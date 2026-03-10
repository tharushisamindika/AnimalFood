<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PurchaseReturnController extends Controller
{
    /**
     * Display a listing of purchase returns
     */
    public function index(Request $request)
    {
        $query = PurchaseReturn::with(['purchase', 'product', 'supplier', 'user'])
                              ->orderBy('created_at', 'desc');

        // Filtering
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('supplier_id')) {
            $query->bySupplier($request->supplier_id);
        }

        if ($request->filled('reason')) {
            $query->where('reason', $request->reason);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('return_number', 'like', "%{$search}%")
                  ->orWhereHas('purchase', function($q) use ($search) {
                      $q->where('purchase_number', 'like', "%{$search}%");
                  })
                  ->orWhereHas('product', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $returns = $query->paginate(15);
        $suppliers = Supplier::orderBy('name')->get();
        $statuses = ['pending', 'approved', 'rejected', 'processed', 'completed'];
        $reasons = ['defective', 'expired', 'wrong_item', 'overage', 'damaged', 'quality_issue', 'other'];

        return view('admin.purchase-returns.index', compact('returns', 'suppliers', 'statuses', 'reasons'));
    }

    /**
     * Show the form for creating a new return
     */
    public function create(Request $request)
    {
        $purchaseId = $request->get('purchase_id');
        $purchase = $purchaseId ? Purchase::with(['supplier', 'items.product'])->find($purchaseId) : null;
        
        $purchases = Purchase::with('supplier')
                           ->whereIn('status', ['received', 'completed'])
                           ->orderBy('purchase_date', 'desc')
                           ->get();

        $reasons = [
            'defective' => 'Defective Item',
            'expired' => 'Expired Product', 
            'wrong_item' => 'Wrong Item Delivered',
            'overage' => 'Overage/Extra Quantity',
            'damaged' => 'Damaged During Transit',
            'quality_issue' => 'Quality Issue',
            'other' => 'Other Reason'
        ];

        return view('admin.purchase-returns.create', compact('purchase', 'purchases', 'reasons'));
    }

    /**
     * Store a newly created return
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required|exists:purchases,id',
            'product_id' => 'required|exists:products,id',
            'quantity_returned' => 'required|integer|min:1',
            'reason' => 'required|in:defective,expired,wrong_item,overage,damaged,quality_issue,other',
            'reason_description' => 'required|string|max:1000',
            'return_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $purchase = Purchase::find($request->purchase_id);
        $purchaseItem = $purchase->items()->where('product_id', $request->product_id)->first();

        if (!$purchaseItem) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in this purchase.'
            ], 422);
        }

        if ($request->quantity_returned > $purchaseItem->quantity_received) {
            return response()->json([
                'success' => false,
                'message' => 'Return quantity cannot exceed received quantity.'
            ], 422);
        }

        $return = PurchaseReturn::create([
            'return_number' => PurchaseReturn::generateReturnNumber(),
            'purchase_id' => $request->purchase_id,
            'purchase_item_id' => $purchaseItem->id,
            'product_id' => $request->product_id,
            'supplier_id' => $purchase->supplier_id,
            'user_id' => auth()->id(),
            'return_date' => $request->return_date,
            'quantity_returned' => $request->quantity_returned,
            'unit_cost' => $purchaseItem->unit_cost,
            'reason' => $request->reason,
            'reason_description' => $request->reason_description,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Purchase return created successfully!',
            'redirect' => route('admin.purchase-returns.show', $return)
        ]);
    }

    /**
     * Display the specified return
     */
    public function show(PurchaseReturn $purchaseReturn)
    {
        $purchaseReturn->load(['purchase.supplier', 'product', 'user', 'approvedBy']);
        return view('admin.purchase-returns.show', compact('purchaseReturn'));
    }

    /**
     * Approve the return
     */
    public function approve(PurchaseReturn $purchaseReturn)
    {
        if (!$purchaseReturn->can_be_approved) {
            return response()->json([
                'success' => false,
                'message' => 'This return cannot be approved.'
            ], 422);
        }

        $purchaseReturn->approve();

        return response()->json([
            'success' => true,
            'message' => 'Return approved successfully!'
        ]);
    }

    /**
     * Reject the return
     */
    public function reject(Request $request, PurchaseReturn $purchaseReturn)
    {
        if (!$purchaseReturn->can_be_approved) {
            return response()->json([
                'success' => false,
                'message' => 'This return cannot be rejected.'
            ], 422);
        }

        $purchaseReturn->update([
            'status' => 'rejected',
            'notes' => $request->rejection_reason ? $purchaseReturn->notes . "\nRejected: " . $request->rejection_reason : $purchaseReturn->notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Return rejected successfully!'
        ]);
    }

    /**
     * Process the return (reduce inventory)
     */
    public function process(PurchaseReturn $purchaseReturn)
    {
        if (!$purchaseReturn->can_be_processed) {
            return response()->json([
                'success' => false,
                'message' => 'This return cannot be processed.'
            ], 422);
        }

        $purchaseReturn->process();

        return response()->json([
            'success' => true,
            'message' => 'Return processed successfully! Inventory has been updated.'
        ]);
    }

    /**
     * Complete the return with refund details
     */
    public function complete(Request $request, PurchaseReturn $purchaseReturn)
    {
        $validator = Validator::make($request->all(), [
            'refund_method' => 'required|in:credit_note,bank_transfer,cash,replacement',
            'refund_amount' => 'required|numeric|min:0',
            'refund_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $purchaseReturn->complete(
            $request->refund_method,
            $request->refund_amount,
            $request->refund_date
        );

        return response()->json([
            'success' => true,
            'message' => 'Return completed successfully!'
        ]);
    }

    /**
     * Get purchase items for AJAX
     */
    public function getPurchaseItems(Purchase $purchase)
    {
        $items = $purchase->items()
                         ->with('product')
                         ->where('quantity_received', '>', 0)
                         ->get()
                         ->map(function($item) {
                             return [
                                 'id' => $item->product_id,
                                 'name' => $item->product->name,
                                 'quantity_received' => $item->quantity_received,
                                 'unit_cost' => $item->unit_cost,
                             ];
                         });

        return response()->json($items);
    }
}
