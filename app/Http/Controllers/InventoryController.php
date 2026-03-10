<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\InventoryBatch;
use App\Models\InventoryAlert;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    /**
     * Display inventory dashboard
     */
    public function index(Request $request)
    {
        // Get statistics
        $stats = [
            'total_products' => Product::count(),
            'low_stock_products' => Product::whereRaw('stock_quantity <= reorder_level')->count(),
            'expired_batches' => InventoryBatch::expired()->count(),
            'expiring_soon' => InventoryBatch::expiringSoon(30)->count(),
            'active_alerts' => InventoryAlert::active()->count(),
            'critical_alerts' => InventoryAlert::active()->where('priority', 'critical')->count(),
            'total_inventory_value' => Product::sum(DB::raw('stock_quantity * average_cost')),
            'zero_stock_products' => Product::where('stock_quantity', 0)->count(),
        ];

        // Get recent alerts
        $recentAlerts = InventoryAlert::with(['product', 'batch'])
            ->active()
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get low stock products
        $lowStockProducts = Product::with(['supplier', 'inventoryBatches'])
            ->whereRaw('stock_quantity <= reorder_level')
            ->orderBy('stock_quantity', 'asc')
            ->limit(10)
            ->get();

        // Get expiring batches
        $expiringBatches = InventoryBatch::with(['product'])
            ->expiringSoon(30)
            ->orderBy('expiry_date', 'asc')
            ->limit(10)
            ->get();

        return view('admin.inventory.dashboard', compact(
            'stats', 'recentAlerts', 'lowStockProducts', 'expiringBatches'
        ));
    }

    /**
     * Stock levels management
     */
    public function stockLevels(Request $request)
    {
        $query = Product::with(['supplier', 'inventoryBatches', 'inventoryAlerts' => function($q) {
            $q->active();
        }]);

        // Filtering
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'low_stock':
                    $query->whereRaw('stock_quantity <= reorder_level');
                    break;
                case 'zero_stock':
                    $query->where('stock_quantity', 0);
                    break;
                case 'overstock':
                    $query->whereRaw('stock_quantity > max_stock_level');
                    break;
                case 'normal':
                    $query->whereRaw('stock_quantity > reorder_level')
                          ->whereRaw('stock_quantity <= max_stock_level');
                    break;
            }
        }

        $products = $query->paginate(15);
        $categories = \App\Models\Category::all();
        $suppliers = \App\Models\Supplier::all();

        return view('admin.inventory.stock-levels', compact(
            'products', 'categories', 'suppliers'
        ));
    }

    /**
     * Barcode scanner
     */
    public function scanner()
    {
        return view('admin.inventory.scanner');
    }

    /**
     * Scan barcode/QR code
     */
    public function scanBarcode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
            'type' => 'required|in:barcode,qr_code',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $code = $request->code;
        $type = $request->type;

        // Search for product by barcode or QR code
        $product = Product::where($type, $code)->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found with this ' . $type
            ], 404);
        }

        // Get product details with inventory information
        $productData = [
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku,
            'barcode' => $product->barcode,
            'current_stock' => $product->stock_quantity,
            'reorder_level' => $product->reorder_level,
            'location' => $product->location,
            'unit' => $product->unit,
            'price' => $product->price,
            'cost_price' => $product->cost_price,
            'stock_status' => $this->getStockStatus($product),
        ];

        return response()->json([
            'success' => true,
            'product' => $productData
        ]);
    }

    /**
     * Stock adjustment
     */
    public function adjustStock(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'adjustment_type' => 'required|in:increase,decrease,set',
            'quantity' => 'required|integer|min:0',
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::find($request->product_id);
        $oldQuantity = $product->stock_quantity;
        $newQuantity = 0;
        $adjustmentQuantity = 0;

        switch ($request->adjustment_type) {
            case 'increase':
                $newQuantity = $oldQuantity + $request->quantity;
                $adjustmentQuantity = $request->quantity;
                break;
            case 'decrease':
                $newQuantity = max(0, $oldQuantity - $request->quantity);
                $adjustmentQuantity = -min($request->quantity, $oldQuantity);
                break;
            case 'set':
                $newQuantity = $request->quantity;
                $adjustmentQuantity = $newQuantity - $oldQuantity;
                break;
        }

        DB::transaction(function () use ($product, $newQuantity, $adjustmentQuantity, $request) {
            // Update product stock
            $product->update([
                'stock_quantity' => $newQuantity,
                'last_stock_update' => now(),
            ]);

            // Create inventory transaction
            InventoryTransaction::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'type' => 'adjustment',
                'quantity' => abs($adjustmentQuantity),
                'reason' => $request->reason,
                'notes' => $request->notes,
                'transaction_date' => now(),
                'metadata' => [
                    'old_quantity' => $product->stock_quantity - $adjustmentQuantity,
                    'new_quantity' => $newQuantity,
                    'adjustment_type' => $request->adjustment_type,
                ],
            ]);

            // Check and create alerts
            $product->checkAndCreateAlerts();
        });

        return response()->json([
            'success' => true,
            'message' => 'Stock adjusted successfully',
            'old_quantity' => $oldQuantity,
            'new_quantity' => $newQuantity,
            'adjustment' => $adjustmentQuantity,
        ]);
    }

    /**
     * Get product information for stock adjustment
     */
    public function getProductInfo(Product $product)
    {
        return response()->json([
            'success' => true,
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'stock_quantity' => $product->stock_quantity,
                'unit' => $product->unit,
                'reorder_level' => $product->reorder_level,
                'max_stock_level' => $product->max_stock_level,
                'minimum_stock_level' => $product->minimum_stock_level,
                'average_cost' => $product->average_cost,
                'last_stock_update' => $product->last_stock_update?->format('Y-m-d H:i:s')
            ]
        ]);
    }

    /**
     * Search products for bulk adjustment
     */
    public function searchProducts(Request $request)
    {
        $query = $request->get('search', '');
        
        if (strlen($query) < 2) {
            return response()->json([
                'success' => true,
                'products' => []
            ]);
        }

        $products = Product::where(function($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('sku', 'like', "%{$query}%")
              ->orWhere('barcode', 'like', "%{$query}%");
        })
        ->select('id', 'name', 'sku', 'stock_quantity', 'unit', 'barcode')
        ->limit(20)
        ->get()
        ->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'stock_quantity' => $product->stock_quantity,
                'unit' => $product->unit,
                'barcode' => $product->barcode
            ];
        });

        return response()->json([
            'success' => true,
            'products' => $products
        ]);
    }

    /**
     * Generate barcode for product
     */
    public function generateBarcode(Product $product)
    {
        $barcode = $product->generateBarcode();

        return response()->json([
            'success' => true,
            'barcode' => $barcode,
            'message' => 'Barcode generated successfully'
        ]);
    }

    /**
     * Helper method to get stock status
     */
    private function getStockStatus(Product $product)
    {
        if ($product->stock_quantity === 0) {
            return 'out_of_stock';
        } elseif ($product->stock_quantity <= $product->minimum_stock_level) {
            return 'critical';
        } elseif ($product->stock_quantity <= $product->reorder_level) {
            return 'low';
        } elseif ($product->stock_quantity > $product->max_stock_level) {
            return 'overstock';
        } else {
            return 'normal';
        }
    }
}