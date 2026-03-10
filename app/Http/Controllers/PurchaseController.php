<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    /**
     * Display a listing of purchases
     */
    public function index(Request $request)
    {
        $query = Purchase::with(['supplier', 'user'])
                    ->orderBy('created_at', 'desc');

        // Filtering
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('supplier_id')) {
            $query->bySupplier($request->supplier_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('purchase_number', 'like', "%{$search}%")
                  ->orWhere('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('supplier', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $purchases = $query->paginate(15);
        $suppliers = Supplier::where('status', 'active')->orderBy('name')->get();
        $statuses = ['pending', 'partial', 'received', 'completed', 'cancelled'];

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.purchases.table', compact('purchases'))->render(),
                'pagination' => $purchases->links()->render()
            ]);
        }

        return view('admin.purchases.index', compact('purchases', 'suppliers', 'statuses'));
    }

    /**
     * Show the form for creating a new purchase
     */
    public function create()
    {
        $suppliers = Supplier::where('status', 'active')
                           ->where('is_blacklisted', false)
                           ->orderBy('name')
                           ->get();
        
        $products = Product::where('status', 'active')
                          ->with('supplier')
                          ->orderBy('name')
                          ->get();

        return view('admin.purchases.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created purchase
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after:purchase_date',
            'invoice_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::transaction(function () use ($request) {
            // Create purchase
            $purchase = Purchase::create([
                'purchase_number' => Purchase::generatePurchaseNumber(),
                'supplier_id' => $request->supplier_id,
                'user_id' => auth()->id(),
                'purchase_date' => $request->purchase_date,
                'expected_delivery_date' => $request->expected_delivery_date,
                'invoice_number' => $request->invoice_number,
                'notes' => $request->notes,
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            // Create purchase items
            foreach ($request->items as $itemData) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $itemData['product_id'],
                    'unit_cost' => $itemData['unit_cost'],
                    'quantity_ordered' => $itemData['quantity'],
                    'quantity_pending' => $itemData['quantity'],
                    'status' => 'pending',
                ]);
            }

            // Update purchase totals
            $purchase->updateTotals();
        });

        return response()->json([
            'success' => true,
            'message' => 'Purchase order created successfully!',
            'redirect' => route('admin.purchases.index')
        ]);
    }

    /**
     * Display the specified purchase
     */
    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'user', 'receivedBy', 'items.product', 'returns']);
        return view('admin.purchases.show', compact('purchase'));
    }

    /**
     * Show GRN (Goods Received Note) form
     */
    public function grn(Purchase $purchase)
    {
        if (!$purchase->can_be_received) {
            return redirect()->route('admin.purchases.show', $purchase)
                           ->with('error', 'This purchase cannot receive items.');
        }

        $purchase->load(['supplier', 'items.product']);
        return view('admin.purchases.grn', compact('purchase'));
    }

    /**
     * Process GRN (receive items)
     */
    public function receiveItems(Request $request, Purchase $purchase)
    {
        $validator = Validator::make($request->all(), [
            'received_items' => 'required|array|min:1',
            'received_items.*.item_id' => 'required|exists:purchase_items,id',
            'received_items.*.quantity' => 'required|integer|min:1',
            'delivery_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::transaction(function () use ($request, $purchase) {
            // Receive items
            $purchase->receiveItems($request->received_items, auth()->id());

            // Update delivery date
            $purchase->update(['delivery_date' => $request->delivery_date]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Items received successfully!',
            'redirect' => route('admin.purchases.show', $purchase)
        ]);
    }

    /**
     * Cancel purchase
     */
    public function cancel(Purchase $purchase)
    {
        if (!$purchase->can_be_cancelled) {
            return response()->json([
                'success' => false,
                'message' => 'This purchase cannot be cancelled.'
            ], 422);
        }

        $purchase->update(['status' => 'cancelled']);

        return response()->json([
            'success' => true,
            'message' => 'Purchase cancelled successfully!'
        ]);
    }
}
