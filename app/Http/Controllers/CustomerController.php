<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%")
                  ->orWhere('city', 'LIKE', "%{$search}%")
                  ->orWhere('state', 'LIKE', "%{$search}%")
                  ->orWhere('customer_id', 'LIKE', "%{$search}%")
                  ->orWhere('company_name', 'LIKE', "%{$search}%")
                  ->orWhere('contact_person', 'LIKE', "%{$search}%");
            });
        }
        
        // Status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Customer type filter
        if ($request->has('customer_type') && $request->customer_type !== '') {
            $query->where('customer_type', $request->customer_type);
        }
        
        // Sort functionality
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $customers = $query->paginate(15);
        
        if ($request->ajax()) {
            return response()->json([
                'customers' => $customers,
                'html' => view('admin.customers.partials.customers-table', compact('customers'))->render(),
                'html_tablet' => view('admin.customers.partials.customers-table', compact('customers'))->render()
            ]);
        }
        
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|regex:/^[0-9+\-\s\(\)]+$/|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|regex:/^[0-9A-Za-z\s\-]+$/|max:20',
            'customer_type' => 'required|in:individual,shop,institute,company',
            'company_name' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check for duplicate customer
        $duplicateCheck = Customer::where('email', $request->email)
            ->orWhere('phone', $request->phone)
            ->first();

        if ($duplicateCheck) {
            return response()->json([
                'success' => false,
                'message' => 'Customer with this email or phone already exists!',
                'duplicate' => $duplicateCheck
            ], 422);
        }

        $customer = Customer::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Customer added successfully!',
            'customer' => $customer
        ]);
    }

    public function show(Customer $customer)
    {
        return response()->json($customer);
    }

    public function update(Request $request, Customer $customer)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'required|string|regex:/^[0-9+\-\s\(\)]+$/|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|regex:/^[0-9A-Za-z\s\-]+$/|max:20',
            'customer_type' => 'required|in:individual,shop,institute,company',
            'company_name' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check for duplicate customer (excluding current customer)
        $duplicateCheck = Customer::where('id', '!=', $customer->id)
            ->where(function($query) use ($request) {
                $query->where('email', $request->email)
                      ->orWhere('phone', $request->phone);
            })
            ->first();

        if ($duplicateCheck) {
            return response()->json([
                'success' => false,
                'message' => 'Customer with this email or phone already exists!',
                'duplicate' => $duplicateCheck
            ], 422);
        }

        $customer->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Customer updated successfully!',
            'customer' => $customer
        ]);
    }

    public function destroy(Customer $customer)
    {
        // Check if user is cashier - cashiers cannot delete customers
        if (auth()->user()->role === 'cashier') {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to delete customers. Only administrators can perform this action.'
            ], 403);
        }

        try {
            // Check if customer has orders
            if ($customer->orders()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete customer with existing orders. Please archive instead.'
                ], 422);
            }
            
            $customer->delete();

            return response()->json([
                'success' => true,
                'message' => 'Customer deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting customer: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function bulkDelete(Request $request)
    {
        // Check if user is cashier - cashiers cannot delete customers
        if (auth()->user()->role === 'cashier') {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to delete customers. Only administrators can perform this action.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'customer_ids' => 'required|array',
            'customer_ids.*' => 'exists:customers,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $customers = Customer::whereIn('id', $request->customer_ids)->get();
            $deletedCount = 0;
            
            foreach ($customers as $customer) {
                if ($customer->orders()->count() === 0) {
                    $customer->delete();
                    $deletedCount++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Successfully deleted {$deletedCount} customers!",
                'deleted_count' => $deletedCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting customers: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function validateField(Request $request)
    {
        $field = $request->field;
        $value = $request->value;
        $excludeId = $request->exclude_id;

        $query = Customer::query();
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $exists = $query->where($field, $value)->exists();

        return response()->json([
            'valid' => !$exists,
            'message' => $exists ? ucfirst($field) . ' already exists.' : ucfirst($field) . ' is available.'
        ]);
    }

    public function export(Request $request)
    {
        try {
            // Log the export request
            \Log::info('Customer export requested', [
                'user_id' => auth()->id(),
                'filters' => $request->all()
            ]);
            
            $query = Customer::query();
            
            // Apply search filter
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('phone', 'LIKE', "%{$search}%")
                      ->orWhere('city', 'LIKE', "%{$search}%")
                      ->orWhere('state', 'LIKE', "%{$search}%")
                      ->orWhere('customer_id', 'LIKE', "%{$search}%")
                      ->orWhere('company_name', 'LIKE', "%{$search}%")
                      ->orWhere('contact_person', 'LIKE', "%{$search}%");
                });
            }
            
            // Apply status filter
            if ($request->has('status') && $request->status !== '') {
                $query->where('status', $request->status);
            }

            // Apply customer type filter
            if ($request->has('customer_type') && $request->customer_type !== '') {
                $query->where('customer_type', $request->customer_type);
            }
            
            // Order by creation date
            $query->orderBy('created_at', 'desc');
            
            $customers = $query->get();
            
            // Log the number of customers found
            \Log::info('Customers found for export', ['count' => $customers->count()]);
            
            $filename = 'customers_' . date('Y-m-d_H-i-s') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'no-cache, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ];
            
            $callback = function() use ($customers) {
                $file = fopen('php://output', 'w');
                
                // Add BOM for UTF-8
                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
                
                // Add headers
                fputcsv($file, [
                    'Customer ID',
                    'Name',
                    'Email',
                    'Phone',
                    'Customer Type',
                    'Company Name',
                    'Contact Person',
                    'Address',
                    'City',
                    'State',
                    'Postal Code',
                    'Tax Number',
                    'Status',
                    'Notes',
                    'Created At'
                ]);
                
                // Add data
                foreach ($customers as $customer) {
                    fputcsv($file, [
                        $customer->customer_id ?? 'N/A',
                        $customer->name ?? 'N/A',
                        $customer->email ?? 'N/A',
                        $customer->phone ?? 'N/A',
                        $customer->customer_type ?? 'N/A',
                        $customer->company_name ?? 'N/A',
                        $customer->contact_person ?? 'N/A',
                        $customer->address ?? 'N/A',
                        $customer->city ?? 'N/A',
                        $customer->state ?? 'N/A',
                        $customer->postal_code ?? 'N/A',
                        $customer->tax_number ?? 'N/A',
                        $customer->status ?? 'N/A',
                        $customer->notes ?? 'N/A',
                        $customer->created_at ? $customer->created_at->format('Y-m-d H:i:s') : 'N/A'
                    ]);
                }
                
                fclose($file);
            };
            
            return response()->stream($callback, 200, $headers);
            
        } catch (\Exception $e) {
            \Log::error('Customer export error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error exporting customers: ' . $e->getMessage()
            ], 500);
        }
    }
} 