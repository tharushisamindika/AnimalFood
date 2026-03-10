<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Product;
use App\Models\SalesTarget;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    /**
     * Display a listing of sales.
     */
    public function index(Request $request)
    {
        $query = Sales::with(['product', 'user'])
            ->orderBy('created_at', 'desc');

        // Filter by type
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by product
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $sales = $query->paginate(15);
        $products = Product::where('status', 'active')->get();
        $todayTarget = SalesTarget::getTodayTarget();

        return view('admin.sales.index', compact('sales', 'products', 'todayTarget'));
    }

    /**
     * Show the form for creating a new sale.
     */
    public function create()
    {
        $products = Product::where('status', 'active')
            ->where('stock_quantity', '>', 0)
            ->get();
        
        $todayTarget = SalesTarget::getTodayTarget();
        
        return view('admin.sales.create', compact('products', 'todayTarget'));
    }

    /**
     * Store a newly created sale.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check stock availability
        if ($product->stock_quantity < $request->quantity) {
            return back()->withErrors(['quantity' => 'Insufficient stock. Available: ' . $product->stock_quantity]);
        }

        DB::transaction(function () use ($request, $product) {
            // Create sale record
            $sale = Sales::create([
                'product_id' => $request->product_id,
                'user_id' => Auth::id(),
                'quantity' => $request->quantity,
                'unit_price' => $request->unit_price,
                'total_amount' => $request->quantity * $request->unit_price,
                'type' => 'sale',
                'status' => 'completed',
                'notes' => $request->notes,
            ]);

            // Update product stock
            $product->decrement('stock_quantity', $request->quantity);

            // Update today's sales target
            $todayTarget = SalesTarget::getOrCreateForDate(today());
            $todayTarget->updateAchievement($sale->total_amount, $sale->quantity);
        });

        return redirect()->route('admin.sales.index')
            ->with('success', 'Sale recorded successfully!');
    }

    /**
     * Display the specified sale.
     */
    public function show(Sales $sale)
    {
        $sale->load(['product', 'user', 'refunds', 'corrections']);
        return view('admin.sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified sale.
     */
    public function edit(Sales $sale)
    {
        if (!$sale->canBeCorrected()) {
            return redirect()->route('admin.sales.show', $sale)
                ->with('error', 'This sale cannot be corrected.');
        }

        $products = Product::where('status', 'active')->get();
        return view('admin.sales.edit', compact('sale', 'products'));
    }

    /**
     * Update the specified sale.
     */
    public function update(Request $request, Sales $sale)
    {
        if (!$sale->canBeCorrected()) {
            return redirect()->route('admin.sales.show', $sale)
                ->with('error', 'This sale cannot be corrected.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'notes' => 'required|string|max:500',
        ]);

        $product = $sale->product;
        $quantityDifference = $request->quantity - $sale->quantity;
        $amountDifference = ($request->quantity * $request->unit_price) - $sale->total_amount;

        // Check if we have enough stock for the correction
        if ($quantityDifference > 0 && $product->stock_quantity < $quantityDifference) {
            return back()->withErrors(['quantity' => 'Insufficient stock for correction. Available: ' . $product->stock_quantity]);
        }

        DB::transaction(function () use ($request, $sale, $product, $quantityDifference, $amountDifference) {
            // Create correction record
            Sales::create([
                'product_id' => $sale->product_id,
                'user_id' => Auth::id(),
                'quantity' => $request->quantity,
                'unit_price' => $request->unit_price,
                'total_amount' => $request->quantity * $request->unit_price,
                'type' => 'correction',
                'status' => 'completed',
                'notes' => $request->notes,
                'original_sale_id' => $sale->id,
            ]);

            // Update product stock
            if ($quantityDifference != 0) {
                $product->increment('stock_quantity', -$quantityDifference);
            }

            // Update today's sales target
            if ($amountDifference != 0) {
                $todayTarget = SalesTarget::getOrCreateForDate(today());
                $todayTarget->updateAchievement($amountDifference, $quantityDifference);
            }
        });

        return redirect()->route('admin.sales.show', $sale)
            ->with('success', 'Sale correction recorded successfully!');
    }

    /**
     * Remove the specified sale.
     */
    public function destroy(Sales $sale)
    {
        // Only allow deletion of pending sales
        if ($sale->status !== 'pending') {
            return redirect()->route('admin.sales.show', $sale)
                ->with('error', 'Only pending sales can be deleted.');
        }

        $sale->delete();

        return redirect()->route('admin.sales.index')
            ->with('success', 'Sale deleted successfully!');
    }

    /**
     * Process a refund for a sale.
     */
    public function refund(Request $request, Sales $sale)
    {
        if (!$sale->canBeRefunded()) {
            return redirect()->route('admin.sales.show', $sale)
                ->with('error', 'This sale cannot be refunded.');
        }

        $request->validate([
            'refund_quantity' => 'required|integer|min:1|max:' . $sale->quantity,
            'refund_reason' => 'required|string|max:500',
        ]);

        $refundQuantity = $request->refund_quantity;
        $refundAmount = ($refundQuantity / $sale->quantity) * $sale->total_amount;

        DB::transaction(function () use ($request, $sale, $refundQuantity, $refundAmount) {
            // Create refund record
            Sales::create([
                'product_id' => $sale->product_id,
                'user_id' => Auth::id(),
                'quantity' => $refundQuantity,
                'unit_price' => $sale->unit_price,
                'total_amount' => $refundAmount,
                'type' => 'refund',
                'status' => 'completed',
                'notes' => $request->refund_reason,
                'original_sale_id' => $sale->id,
            ]);

            // Restore product stock
            $sale->product->increment('stock_quantity', $refundQuantity);

            // Update today's sales target (subtract refund amount)
            $todayTarget = SalesTarget::getOrCreateForDate(today());
            $todayTarget->updateAchievement(-$refundAmount, -$refundQuantity);
        });

        return redirect()->route('admin.sales.show', $sale)
            ->with('success', 'Refund processed successfully!');
    }

    /**
     * Get sales statistics for dashboard.
     */
    public function getStats(): JsonResponse
    {
        $todaySales = Sales::today()->byType('sale')->sum('total_amount');
        $todayRefunds = Sales::today()->byType('refund')->sum('total_amount');
        $todayNet = $todaySales - $todayRefunds;
        
        $todayTarget = SalesTarget::getTodayTarget();
        $targetProgress = $todayTarget ? $todayTarget->getProgressPercentage() : 0;
        $targetAmount = $todayTarget ? $todayTarget->daily_target : 0;

        $recentSales = Sales::with(['product', 'user'])
            ->byType('sale')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'today_sales' => $todaySales,
            'today_refunds' => $todayRefunds,
            'today_net' => $todayNet,
            'target_progress' => $targetProgress,
            'target_amount' => $targetAmount,
            'recent_sales' => $recentSales,
        ]);
    }

    /**
     * Get product details for sale form.
     */
    public function getProductDetails($productId): JsonResponse
    {
        $product = Product::findOrFail($productId);
        
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'stock_quantity' => $product->stock_quantity,
            'unit' => $product->unit,
        ]);
    }

    /**
     * Show sales targets management.
     */
    public function targets()
    {
        $targets = SalesTarget::orderBy('target_date', 'desc')->paginate(15);
        return view('admin.sales.targets', compact('targets'));
    }

    /**
     * Store or update sales target.
     */
    public function storeTarget(Request $request)
    {
        $request->validate([
            'target_date' => 'required|date',
            'daily_target' => 'required|numeric|min:0',
            'target_quantity' => 'nullable|integer|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        SalesTarget::updateOrCreate(
            ['target_date' => $request->target_date],
            [
                'daily_target' => $request->daily_target,
                'target_quantity' => $request->target_quantity,
                'notes' => $request->notes,
                'is_active' => true,
            ]
        );

        return redirect()->route('admin.sales.targets')
            ->with('success', 'Sales target updated successfully!');
    }

    /**
     * Get daily sales chart data for the last 7 days.
     */
    public function getDailyChartData(): JsonResponse
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $sales = Sales::whereDate('created_at', $date)
                ->byType('sale')
                ->sum('total_amount');
            $refunds = Sales::whereDate('created_at', $date)
                ->byType('refund')
                ->sum('total_amount');
            
            $data[] = [
                'date' => $date->format('M d'),
                'sales' => $sales,
                'refunds' => $refunds,
                'net' => $sales - $refunds
            ];
        }

        return response()->json($data);
    }

    /**
     * Get weekly sales chart data for the last 12 weeks.
     */
    public function getWeeklyChartData(): JsonResponse
    {
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $startOfWeek = now()->subWeeks($i)->startOfWeek();
            $endOfWeek = now()->subWeeks($i)->endOfWeek();
            
            $sales = Sales::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->byType('sale')
                ->sum('total_amount');
            $refunds = Sales::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->byType('refund')
                ->sum('total_amount');
            
            $data[] = [
                'week' => 'Week ' . $startOfWeek->format('M d'),
                'sales' => $sales,
                'refunds' => $refunds,
                'net' => $sales - $refunds
            ];
        }

        return response()->json($data);
    }

    /**
     * Get monthly sales chart data for the last 12 months.
     */
    public function getMonthlyChartData(): JsonResponse
    {
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $sales = Sales::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->byType('sale')
                ->sum('total_amount');
            $refunds = Sales::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->byType('refund')
                ->sum('total_amount');
            
            $data[] = [
                'month' => $month->format('M Y'),
                'sales' => $sales,
                'refunds' => $refunds,
                'net' => $sales - $refunds
            ];
        }

        return response()->json($data);
    }

    /**
     * Get top selling products chart data.
     */
    public function getProductChartData(): JsonResponse
    {
        $topProducts = Sales::with('product')
            ->byType('sale')
            ->selectRaw('product_id, SUM(total_amount) as total_sales, SUM(quantity) as total_quantity')
            ->groupBy('product_id')
            ->orderByDesc('total_sales')
            ->limit(10)
            ->get()
            ->map(function ($sale) {
                return [
                    'product' => $sale->product->name ?? 'Unknown Product',
                    'sales' => $sale->total_sales,
                    'quantity' => $sale->total_quantity
                ];
            });

        return response()->json($topProducts);
    }
}
