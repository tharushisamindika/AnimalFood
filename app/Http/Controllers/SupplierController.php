<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function search(Request $request)
    {
        $search = $request->get('search', '');
        
        if (empty($search)) {
            $suppliers = Supplier::orderBy('created_at', 'desc')->paginate(10);
        } else {
            $suppliers = Supplier::where(function($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('phone', 'LIKE', "%{$search}%")
                      ->orWhere('contact_person', 'LIKE', "%{$search}%")
                      ->orWhere('address', 'LIKE', "%{$search}%")
                      ->orWhere('supplier_id', 'LIKE', "%{$search}%")
                      ->orWhere('tax_number', 'LIKE', "%{$search}%");
            })->orderBy('created_at', 'desc')->paginate(10);
        }

        if ($request->ajax()) {
            $html = view('admin.suppliers.partials.suppliers-table', compact('suppliers'))->render();
            $htmlMobile = view('admin.suppliers.partials.suppliers-mobile', compact('suppliers'))->render();
            
            return response()->json([
                'success' => true,
                'html' => $html,
                'html_mobile' => $htmlMobile,
                'pagination' => $suppliers->links()->toHtml(),
                'total' => $suppliers->total(),
                'current_page' => $suppliers->currentPage(),
                'per_page' => $suppliers->perPage(),
                'showing_from' => $suppliers->firstItem(),
                'showing_to' => $suppliers->lastItem()
            ]);
        }

        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:suppliers,email',
            'phone' => 'required|string|regex:/^[0-9+\-\s\(\)]+$/|max:20',
            'secondary_phone' => 'nullable|string|regex:/^[0-9+\-\s\(\)]+$/|max:20',
            'address' => 'required|string|max:500',
            'contact_person' => 'required|string|max:255',
            'tax_number' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
            'is_blacklisted' => 'nullable|boolean',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        $data['supplier_id'] = Supplier::generateSupplierId();
        $data['is_blacklisted'] = $request->boolean('is_blacklisted');

        $supplier = Supplier::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Supplier added successfully!',
            'supplier' => $supplier
        ]);
    }

    public function show(Supplier $supplier)
    {
        return response()->json($supplier);
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:suppliers,email,' . $supplier->id,
            'phone' => 'required|string|regex:/^[0-9+\-\s\(\)]+$/|max:20',
            'secondary_phone' => 'nullable|string|regex:/^[0-9+\-\s\(\)]+$/|max:20',
            'address' => 'required|string|max:500',
            'contact_person' => 'required|string|max:255',
            'tax_number' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
            'is_blacklisted' => 'nullable|boolean',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        $data['is_blacklisted'] = $request->boolean('is_blacklisted');

        $supplier->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Supplier updated successfully!',
            'supplier' => $supplier
        ]);
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return response()->json([
            'success' => true,
            'message' => 'Supplier deleted successfully!'
        ]);
    }
} 