<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('supplier');

        // Filtering
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('brand')) {
            $query->byBrand($request->brand);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%')
                  ->orWhere('brand', 'like', '%' . $request->search . '%');
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $products = $query->paginate(15);

        // Get categories and brands for filters
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $brands = Product::distinct()->pluck('brand')->filter();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $units = ['kg', 'bags', 'pieces', 'liters', 'grams'];
        
        return view('admin.products.create', compact('suppliers', 'categories', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'expiry_date' => 'nullable|date|after:today',
            'unit' => 'required|string|max:50',
            'supplier_id' => 'required|exists:suppliers,id',
            'status' => 'required|in:active,inactive'
        ]);

        // Generate SKU
        $sku = 'SKU-' . strtoupper(Str::random(8));

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'brand' => $request->brand,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'expiry_date' => $request->expiry_date,
            'unit' => $request->unit,
            'sku' => $sku,
            'supplier_id' => $request->supplier_id,
            'status' => $request->status
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('supplier', 'inventoryTransactions');
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $suppliers = Supplier::all();
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $units = ['kg', 'bags', 'pieces', 'liters', 'grams'];
        
        return view('admin.products.edit', compact('product', 'suppliers', 'categories', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
            'unit' => 'required|string|max:50',
            'supplier_id' => 'required|exists:suppliers,id',
            'status' => 'required|in:active,inactive'
        ]);

        $product->update($request->all());

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Check if user is cashier - cashiers cannot delete products
        if (auth()->user()->role === 'cashier') {
            return redirect()->route('admin.products.index')
                ->with('error', 'You do not have permission to delete products. Only administrators can perform this action.');
        }

        try {
            // Check if product has associated orders or sales
            if ($product->orderItems()->count() > 0 || $product->inventoryTransactions()->count() > 0) {
                return redirect()->route('admin.products.index')
                    ->with('error', 'Cannot delete product with existing orders or inventory transactions. Please archive instead.');
            }
            
            $product->delete();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Error deleting product: ' . $e->getMessage());
        }
    }

    /**
     * Get low stock alerts
     */
    public function lowStockAlerts()
    {
        $lowStockProducts = Product::lowStock()->with('supplier')->get();
        return response()->json($lowStockProducts);
    }

    /**
     * Get expiring soon alerts
     */
    public function expiringSoonAlerts()
    {
        $expiringProducts = Product::expiringSoon()->with('supplier')->get();
        return response()->json($expiringProducts);
    }

    /**
     * Update stock quantity (for sales)
     */
    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock_quantity
        ]);

        $product->decrement('stock_quantity', $request->quantity);

        return response()->json([
            'success' => true,
            'new_stock' => $product->fresh()->stock_quantity
        ]);
    }

    /**
     * Get product counts for dashboard
     */
    public function getCounts()
    {
        $total = Product::count();
        $active = Product::where('status', 'active')->count();

        return response()->json([
            'total' => $total,
            'active' => $active
        ]);
    }
}
