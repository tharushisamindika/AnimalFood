<?php

namespace App\Http\Controllers;

use App\Models\DiscountType;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    /**
     * Display discount types
     */
    public function index(Request $request)
    {
        $query = DiscountType::orderBy('created_at', 'desc');

        // Filtering
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } else {
                $query->where('is_active', false);
            }
        }

        $discounts = $query->paginate(15);

        return view('admin.discounts.index', compact('discounts'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $products = Product::where('status', 'active')->get();
        $categories = Category::all();

        return view('admin.discounts.create', compact('products', 'categories'));
    }

    /**
     * Store discount
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:discount_types,code',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:percentage,fixed_amount',
            'value' => 'required|numeric|min:0',
            'minimum_amount' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after:valid_from',
            'is_active' => 'boolean',
            'is_automatic' => 'boolean',
            'applicable_products' => 'nullable|array',
            'applicable_categories' => 'nullable|array',
            'usage_limit' => 'nullable|integer|min:1',
            'terms_conditions' => 'nullable|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        $data['is_active'] = $request->boolean('is_active');
        $data['is_automatic'] = $request->boolean('is_automatic');

        DiscountType::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Discount created successfully!',
            'redirect' => route('admin.discounts.index')
        ]);
    }

    /**
     * Show discount
     */
    public function show(DiscountType $discount)
    {
        return view('admin.discounts.show', compact('discount'));
    }

    /**
     * Show edit form
     */
    public function edit(DiscountType $discount)
    {
        $products = Product::where('status', 'active')->get();
        $categories = Category::all();

        return view('admin.discounts.edit', compact('discount', 'products', 'categories'));
    }

    /**
     * Update discount
     */
    public function update(Request $request, DiscountType $discount)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:discount_types,code,' . $discount->id,
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:percentage,fixed_amount',
            'value' => 'required|numeric|min:0',
            'minimum_amount' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after:valid_from',
            'is_active' => 'boolean',
            'is_automatic' => 'boolean',
            'applicable_products' => 'nullable|array',
            'applicable_categories' => 'nullable|array',
            'usage_limit' => 'nullable|integer|min:1',
            'terms_conditions' => 'nullable|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        $data['is_active'] = $request->boolean('is_active');
        $data['is_automatic'] = $request->boolean('is_automatic');

        $discount->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Discount updated successfully!',
            'redirect' => route('admin.discounts.index')
        ]);
    }

    /**
     * Delete discount
     */
    public function destroy(DiscountType $discount)
    {
        $discount->delete();

        return response()->json([
            'success' => true,
            'message' => 'Discount deleted successfully!'
        ]);
    }

    /**
     * Validate discount code
     */
    public function validateCode(Request $request)
    {
        $code = $request->get('code');
        $orderAmount = $request->get('order_amount', 0);
        $items = $request->get('items', []);

        $discount = DiscountType::byCode($code)->valid()->first();

        if (!$discount) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid or expired discount code.'
            ]);
        }

        if (!$discount->isValid($orderAmount)) {
            return response()->json([
                'valid' => false,
                'message' => 'Discount not applicable to this order.'
            ]);
        }

        if (!$discount->isApplicableToItems($items)) {
            return response()->json([
                'valid' => false,
                'message' => 'Discount not applicable to selected items.'
            ]);
        }

        $discountAmount = $discount->calculateDiscount($orderAmount, $items);

        return response()->json([
            'valid' => true,
            'discount' => [
                'id' => $discount->id,
                'name' => $discount->name,
                'code' => $discount->code,
                'type' => $discount->type,
                'value' => $discount->value,
                'amount' => $discountAmount,
                'formatted_value' => $discount->formatted_value,
            ]
        ]);
    }

    /**
     * Get automatic discounts
     */
    public function getAutomaticDiscounts(Request $request)
    {
        $orderAmount = $request->get('order_amount', 0);
        $items = $request->get('items', []);

        $discounts = DiscountType::valid()
                                ->automatic()
                                ->get()
                                ->filter(function($discount) use ($orderAmount, $items) {
                                    return $discount->isValid($orderAmount) && 
                                           $discount->isApplicableToItems($items);
                                });

        $applicableDiscounts = [];

        foreach ($discounts as $discount) {
            $discountAmount = $discount->calculateDiscount($orderAmount, $items);
            if ($discountAmount > 0) {
                $applicableDiscounts[] = [
                    'id' => $discount->id,
                    'name' => $discount->name,
                    'code' => $discount->code,
                    'type' => $discount->type,
                    'value' => $discount->value,
                    'amount' => $discountAmount,
                    'formatted_value' => $discount->formatted_value,
                ];
            }
        }

        return response()->json($applicableDiscounts);
    }

    /**
     * Toggle discount status
     */
    public function toggleStatus(DiscountType $discount)
    {
        $discount->update(['is_active' => !$discount->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Discount status updated successfully!',
            'is_active' => $discount->is_active
        ]);
    }
}