<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\BillHeader;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Dompdf\Dompdf;
use Dompdf\Options;

class BillingController extends Controller
{
    public function index()
    {
        try {
            // No need to load data here since we're fetching via AJAX
            return view('admin.billing.index');
        } catch (\Exception $e) {
            return back()->with('error', 'Error loading billing page: ' . $e->getMessage());
        }
    }

    public function list()
    {
        try {
            return view('admin.billing.list');
        } catch (\Exception $e) {
            return back()->with('error', 'Error loading billing list page: ' . $e->getMessage());
        }
    }

    public function exportBills(Request $request)
    {
        try {
            $query = Order::with(['customer', 'user'])
                         ->whereNotNull('invoice_number')
                         ->orderBy('created_at', 'desc');

            // Apply filters
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('invoice_number', 'like', "%{$search}%")
                      ->orWhere('order_number', 'like', "%{$search}%")
                      ->orWhereHas('customer', function($customerQuery) use ($search) {
                          $customerQuery->where('name', 'like', "%{$search}%")
                                       ->orWhere('email', 'like', "%{$search}%")
                                       ->orWhere('phone', 'like', "%{$search}%");
                      });
                });
            }

            if ($request->has('status') && !empty($request->status)) {
                switch ($request->status) {
                    case 'paid':
                        $query->where('due_amount', '<=', 0);
                        break;
                    case 'pending':
                        $query->where('due_amount', '>', 0)->where('due_date', '>=', now());
                        break;
                    case 'overdue':
                        $query->where('due_amount', '>', 0)->where('due_date', '<', now());
                        break;
                    case 'cancelled':
                        $query->where('status', 'cancelled');
                        break;
                }
            }

            if ($request->has('dateRange') && !empty($request->dateRange)) {
                $now = now();
                switch ($request->dateRange) {
                    case 'today':
                        $query->whereDate('created_at', $now->toDateString());
                        break;
                    case 'week':
                        $query->whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()]);
                        break;
                    case 'month':
                        $query->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year);
                        break;
                    case 'quarter':
                        $query->whereBetween('created_at', [$now->startOfQuarter(), $now->endOfQuarter()]);
                        break;
                    case 'year':
                        $query->whereYear('created_at', $now->year);
                        break;
                }
            }

            $bills = $query->get();
            $billHeader = BillHeader::getActive();

            // Calculate summary statistics
            $summary = [
                'total_bills' => $bills->count(),
                'total_amount' => $bills->sum('final_amount'),
                'total_paid' => $bills->sum('paid_amount'),
                'total_due' => $bills->sum('due_amount'),
                'paid_bills' => $bills->where('due_amount', '<=', 0)->count(),
                'pending_bills' => $bills->where('due_amount', '>', 0)->where('due_date', '>=', now())->count(),
                'overdue_bills' => $bills->where('due_amount', '>', 0)->where('due_date', '<', now())->count(),
                'cancelled_bills' => $bills->where('status', 'cancelled')->count(),
            ];

            // Transform data for PDF
            $billsData = $bills->map(function ($bill) {
                return [
                    'bill_number' => $bill->invoice_number,
                    'order_number' => $bill->order_number,
                    'customer_name' => $bill->customer->name ?? 'N/A',
                    'customer_email' => $bill->customer->email ?? 'N/A',
                    'date' => $bill->invoice_date ? $bill->invoice_date->format('M d, Y') : $bill->created_at->format('M d, Y'),
                    'due_date' => $bill->due_date ? $bill->due_date->format('M d, Y') : 'N/A',
                    'amount' => number_format($bill->final_amount, 2),
                    'paid_amount' => number_format($bill->paid_amount, 2),
                    'due_amount' => number_format($bill->due_amount, 2),
                    'status' => $this->getBillStatus($bill),
                    'created_by' => $bill->user->name ?? 'System',
                ];
            });

            $exportType = $request->get('type', 'pdf');
            $reportTitle = $request->get('title', 'Bills Summary Report');
            $includeSummary = $request->get('include_summary', true);
            $includeDetails = $request->get('include_details', true);

            if ($exportType === 'pdf') {
                return $this->generatePDF($billsData, $summary, $billHeader, $reportTitle, $includeSummary, $includeDetails);
            } else {
                return $this->generatePrintPreview($billsData, $summary, $billHeader, $reportTitle, $includeSummary, $includeDetails);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error generating export: ' . $e->getMessage()
            ], 500);
        }
    }

    private function generatePDF($billsData, $summary, $billHeader, $reportTitle, $includeSummary, $includeDetails)
    {
        $html = view('admin.billing.exports.pdf', compact(
            'billsData', 
            'summary', 
            'billHeader', 
            'reportTitle', 
            'includeSummary', 
            'includeDetails'
        ))->render();

        // Initialize DomPDF
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $filename = 'bills_report_' . date('Y-m-d_H-i-s') . '.pdf';
        
        return response($dompdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    private function generatePrintPreview($billsData, $summary, $billHeader, $reportTitle, $includeSummary, $includeDetails)
    {
        return view('admin.billing.exports.print-preview', compact(
            'billsData', 
            'summary', 
            'billHeader', 
            'reportTitle', 
            'includeSummary', 
            'includeDetails'
        ));
    }

    public function getBills(Request $request): JsonResponse
    {
        try {
            $query = Order::with(['customer', 'user'])
                         ->whereNotNull('invoice_number')
                         ->orderBy('created_at', 'desc');

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('invoice_number', 'like', "%{$search}%")
                      ->orWhere('order_number', 'like', "%{$search}%")
                      ->orWhereHas('customer', function($customerQuery) use ($search) {
                          $customerQuery->where('name', 'like', "%{$search}%")
                                       ->orWhere('email', 'like', "%{$search}%")
                                       ->orWhere('phone', 'like', "%{$search}%");
                      });
                });
            }

            // Status filter
            if ($request->has('status') && !empty($request->status)) {
                switch ($request->status) {
                    case 'paid':
                        $query->where('due_amount', '<=', 0);
                        break;
                    case 'pending':
                        $query->where('due_amount', '>', 0)->where('due_date', '>=', now());
                        break;
                    case 'overdue':
                        $query->where('due_amount', '>', 0)->where('due_date', '<', now());
                        break;
                    case 'cancelled':
                        $query->where('status', 'cancelled');
                        break;
                }
            }

            // Date range filter
            if ($request->has('dateRange') && !empty($request->dateRange)) {
                $now = now();
                switch ($request->dateRange) {
                    case 'today':
                        $query->whereDate('created_at', $now->toDateString());
                        break;
                    case 'week':
                        $query->whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()]);
                        break;
                    case 'month':
                        $query->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year);
                        break;
                    case 'quarter':
                        $query->whereBetween('created_at', [$now->startOfQuarter(), $now->endOfQuarter()]);
                        break;
                    case 'year':
                        $query->whereYear('created_at', $now->year);
                        break;
                }
            }

            // Pagination
            $perPage = $request->get('per_page', 15);
            $bills = $query->paginate($perPage);

            // Calculate summary before transformation
            $summary = [
                'total_bills' => $bills->total(),
                'total_amount' => number_format($bills->getCollection()->sum(function($bill) {
                    return is_numeric($bill->final_amount) ? (float)$bill->final_amount : 0;
                }), 2),
                'total_paid' => number_format($bills->getCollection()->sum(function($bill) {
                    return is_numeric($bill->paid_amount) ? (float)$bill->paid_amount : 0;
                }), 2),
                'total_due' => number_format($bills->getCollection()->sum(function($bill) {
                    return is_numeric($bill->due_amount) ? (float)$bill->due_amount : 0;
                }), 2),
            ];

            // Transform data for frontend
            $bills->getCollection()->transform(function ($bill) {
                return [
                    'id' => $bill->id,
                    'bill_number' => $bill->invoice_number,
                    'order_number' => $bill->order_number,
                    'customer' => [
                        'name' => $bill->customer->name ?? 'N/A',
                        'email' => $bill->customer->email ?? 'N/A',
                        'phone' => $bill->customer->phone ?? 'N/A',
                    ],
                    'date' => $bill->invoice_date ? $bill->invoice_date->format('M d, Y') : $bill->created_at->format('M d, Y'),
                    'due_date' => $bill->due_date ? $bill->due_date->format('M d, Y') : 'N/A',
                    'amount' => number_format(is_numeric($bill->final_amount) ? (float)$bill->final_amount : 0, 2),
                    'paid_amount' => number_format(is_numeric($bill->paid_amount) ? (float)$bill->paid_amount : 0, 2),
                    'due_amount' => number_format(is_numeric($bill->due_amount) ? (float)$bill->due_amount : 0, 2),
                    'status' => $this->getBillStatus($bill),
                    'status_class' => $this->getBillStatusClass($bill),
                    'created_by' => $bill->user->name ?? 'System',
                    'created_at' => $bill->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $bill->updated_at->format('Y-m-d H:i:s'),
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $bills->items(),
                'pagination' => [
                    'current_page' => $bills->currentPage(),
                    'last_page' => $bills->lastPage(),
                    'per_page' => $bills->perPage(),
                    'total' => $bills->total(),
                    'from' => $bills->firstItem(),
                    'to' => $bills->lastItem(),
                ],
                'summary' => $summary
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error fetching bills: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getBillStatus($bill): string
    {
        if ($bill->status === 'cancelled') {
            return 'Cancelled';
        }
        
        if ($bill->due_amount <= 0) {
            return 'Paid';
        }
        
        if ($bill->due_date && $bill->due_date->isPast()) {
            return 'Overdue';
        }
        
        return 'Pending';
    }

    private function getBillStatusClass($bill): string
    {
        if ($bill->status === 'cancelled') {
            return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
        }
        
        if ($bill->due_amount <= 0) {
            return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
        }
        
        if ($bill->due_date && $bill->due_date->isPast()) {
            return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
        }
        
        return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
    }

    public function getCustomers(Request $request): JsonResponse
    {
        try {
            $query = Customer::query();
            
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            }
            
            $customers = $query->where('status', 'active')->get(['id', 'name', 'email', 'phone', 'address']);
            
            // Ensure the default "Customer" entry is always first for billing
            $defaultCustomer = $customers->where('name', 'Customer')->first();
            if ($defaultCustomer) {
                $customers = $customers->reject(function($customer) {
                    return $customer->name === 'Customer';
                });
                $customers = collect([$defaultCustomer])->merge($customers);
            }
            
            return response()->json($customers);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching customers: ' . $e->getMessage()], 500);
        }
    }

    public function getProducts(Request $request): JsonResponse
    {
        try {
            $query = Product::query();
            
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }
            
            $products = $query->where('status', 'active')
                             ->where('stock_quantity', '>', 0)
                             ->get(['id', 'name', 'sku', 'price', 'stock_quantity', 'unit', 'description']);
            
            return response()->json($products);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching products: ' . $e->getMessage()], 500);
        }
    }

    public function getProductDetails($id): JsonResponse
    {
        try {
            $product = Product::findOrFail($id);
            
            return response()->json([
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'price' => $product->price,
                'stock_quantity' => $product->stock_quantity,
                'unit' => $product->unit ?? 'unit',
                'description' => $product->description
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Product not found: ' . $e->getMessage()], 404);
        }
    }

    public function getCustomerDetails($id): JsonResponse
    {
        try {
            $customer = Customer::findOrFail($id);
            
            return response()->json([
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'address' => $customer->address,
                'city' => $customer->city,
                'state' => $customer->state,
                'postal_code' => $customer->postal_code
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Customer not found: ' . $e->getMessage()], 404);
        }
    }

    public function createSampleBills(): JsonResponse
    {
        try {
            // Get some customers and products
            $customers = Customer::where('status', 'active')->take(5)->get();
            $products = Product::where('status', 'active')->where('stock_quantity', '>', 0)->take(10)->get();
            
            if ($customers->isEmpty()) {
                return response()->json(['error' => 'No active customers found. Please create some customers first.'], 400);
            }
            
            if ($products->isEmpty()) {
                return response()->json(['error' => 'No active products found. Please create some products first.'], 400);
            }

            $billHeader = BillHeader::getActive();
            $createdBills = [];

            for ($i = 1; $i <= 10; $i++) {
                $customer = $customers->random();
                
                // Generate unique invoice number
                $lastInvoice = Order::whereNotNull('invoice_number')->orderBy('id', 'desc')->first();
                $lastNumber = $lastInvoice ? (int) substr($lastInvoice->invoice_number, strlen($billHeader->invoice_prefix) + 1) : 0;
                $nextNumber = $lastNumber + $i;
                $invoiceNumber = $billHeader->invoice_prefix . '-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
                
                // Create order with invoice number
                $order = Order::create([
                    'order_number' => 'ORD-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT),
                    'invoice_number' => $invoiceNumber,
                    'customer_id' => $customer->id,
                    'user_id' => auth()->id() ?? 1,
                    'total_amount' => rand(1000, 5000),
                    'tax_amount' => 0,
                    'discount_amount' => 0,
                    'final_amount' => rand(1000, 5000),
                    'paid_amount' => rand(0, 5000),
                    'due_amount' => rand(0, 2000),
                    'due_date' => now()->addDays(rand(1, 30)),
                    'status' => 'completed',
                    'payment_status' => 'partial',
                    'payment_method' => 'cash',
                    'invoice_date' => now()->subDays(rand(1, 30)),
                    'notes' => 'Sample bill for testing purposes'
                ]);

                // Create order items
                $numItems = rand(1, 3);
                for ($j = 0; $j < $numItems; $j++) {
                    $product = $products->random();
                    $quantity = rand(1, 5);
                    $price = $product->price;
                    
                    \App\Models\OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $price,
                        'total_price' => $quantity * $price,
                        'discount_amount' => 0,
                        'tax_amount' => 0,
                        'final_price' => $quantity * $price
                    ]);
                }

                $createdBills[] = [
                    'invoice_number' => $invoiceNumber,
                    'customer_name' => $customer->name,
                    'amount' => $order->final_amount,
                    'status' => $this->getBillStatus($order)
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Successfully created ' . count($createdBills) . ' sample bills',
                'bills' => $createdBills
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error creating sample bills: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createBill(Request $request): JsonResponse
    {
        try {
            \Log::info('Creating bill with data:', $request->all());
            \Log::info('Request headers:', $request->headers->all());
            
            $request->validate([
                'customer_id' => 'required', // we will resolve CASH special-case below
                'items' => 'required|array|min:1',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.quantity' => 'required|integer|min:1',
                'due_date' => 'nullable|date',
                'notes' => 'nullable|string|max:500',
                'payment_method' => 'nullable|string',
                'paid_amount' => 'nullable|numeric|min:0',
                'total_amount' => 'nullable|numeric|min:0',
                'tax_amount' => 'nullable|numeric|min:0',
                'discount_amount' => 'nullable|numeric|min:0',
                'final_amount' => 'nullable|numeric|min:0',
                'due_amount' => 'nullable|numeric|min:0',
                'discount_code' => 'nullable|string',
                'discount_type' => 'nullable|string',
                'discount_percentage' => 'nullable|numeric|min:0'
            ]);

            // Resolve customer: support 'cash' pseudo-customer
            if ($request->customer_id === 'cash' || empty($request->customer_id)) {
                $customer = Customer::firstOrCreate(
                    ['name' => 'Customer'],
                    [
                        'email' => 'customer@example.com',
                        'phone' => 'N/A',
                        'address' => 'Walk-in',
                        'city' => 'N/A',
                        'state' => 'N/A',
                        'postal_code' => 'N/A',
                        'status' => 'active'
                    ]
                );
            } else {
                // Validate actual customer id
                $request->validate(['customer_id' => 'exists:customers,id']);
                $customer = Customer::findOrFail($request->customer_id);
            }

            if (!$customer) {
                throw new \Exception('Customer not found');
            }

            \Log::info('Customer resolved:', ['customer_id' => $customer->id, 'customer_name' => $customer->name]);

            $billHeader = BillHeader::getActive();
            if (!$billHeader) {
                // Create a default bill header if none exists
                try {
                    $billHeader = BillHeader::create([
                        'company_name' => 'Your Company Name',
                        'invoice_prefix' => 'INV',
                        'is_active' => true
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to create default bill header:', ['error' => $e->getMessage()]);
                    // Use default prefix if creation fails
                    $prefix = 'INV';
                }
            }
            $prefix = $billHeader ? ($billHeader->invoice_prefix ?? 'INV') : 'INV';

            // Generate invoice number
            try {
                $lastOrder = Order::whereNotNull('invoice_number')
                                  ->where('invoice_number', 'like', $prefix . '-%')
                                  ->orderBy('id', 'desc')
                                  ->first();
                
                if ($lastOrder) {
                    // Extract number from invoice number like "INV-000123"
                    $lastNumber = (int) preg_replace('/\D/', '', substr($lastOrder->invoice_number, strlen($prefix) + 1));
                } else {
                    $lastNumber = 0;
                }
                
                // Keep trying until we find a unique invoice number
                do {
                    $lastNumber++;
                    $invoiceNumber = $prefix . '-' . str_pad($lastNumber, 6, '0', STR_PAD_LEFT);
                    $exists = Order::where('invoice_number', $invoiceNumber)->exists();
                } while ($exists);
                
            } catch (\Exception $e) {
                \Log::error('Failed to generate invoice number:', ['error' => $e->getMessage()]);
                // Fallback to timestamp-based number
                $invoiceNumber = $prefix . '-' . str_pad(time() % 1000000, 6, '0', STR_PAD_LEFT);
            }

            \Log::info('Generated invoice number:', ['invoice_number' => $invoiceNumber]);

            // Use values from request or calculate from items
            $totalAmount = (float) $request->input('total_amount', 0);
            $taxAmount = (float) $request->input('tax_amount', 0);
            $discountAmount = (float) $request->input('discount_amount', 0);
            $finalAmount = (float) $request->input('final_amount', 0);
            
            // If values not provided, calculate from items
            if ($totalAmount == 0) {
                $totalAmount = 0.0;
                foreach ($request->items as $item) {
                    $product = Product::findOrFail($item['product_id']);
                    $quantity = (int) $item['quantity'];
                    $unitPrice = (float) $product->price;
                    $itemTotal = $quantity * $unitPrice;
                    $totalAmount += $itemTotal;
                }
                $taxAmount = round($totalAmount * 0.10, 2);
                $finalAmount = round($totalAmount - $discountAmount + $taxAmount, 2);
            }

            // Prepare order items
            $orderItems = [];
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                if (!$product) {
                    throw new \Exception("Product with ID {$item['product_id']} not found");
                }
                $quantity = (int) $item['quantity'];
                $unitPrice = (float) $product->price;
                $itemTotal = $quantity * $unitPrice;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $itemTotal,
                ];
            }

            \Log::info('Calculated totals:', ['total_amount' => $totalAmount, 'tax_amount' => $taxAmount, 'discount_amount' => $discountAmount, 'final_amount' => $finalAmount, 'items_count' => count($orderItems)]);

            // Payment fields from request
            $allowedMethods = ['cash', 'card', 'bank_transfer', 'credit', 'cheque', 'mobile_payment', 'mixed'];
            $paymentMethod = in_array($request->input('payment_method'), $allowedMethods, true)
                ? $request->input('payment_method')
                : 'cash';
            $paidAmount = (float) $request->input('paid_amount', 0);
            $dueAmount = (float) $request->input('due_amount', max($finalAmount - $paidAmount, 0));
            $paymentStatus = $dueAmount <= 0 ? 'paid' : ($paidAmount > 0 ? 'partial' : 'pending');

            \Log::info('Payment details:', [
                'payment_method' => $paymentMethod,
                'paid_amount' => $paidAmount,
                'due_amount' => $dueAmount,
                'payment_status' => $paymentStatus
            ]);

            // Generate order number to match invoice number
            $orderNumber = 'ORD-' . str_pad($lastNumber, 6, '0', STR_PAD_LEFT);
            
            // Prepare order data
            $orderData = [
                'order_number' => $orderNumber,
                'invoice_number' => $invoiceNumber,
                'customer_id' => $customer->id,
                'user_id' => auth()->id() ?? 1,
                'total_amount' => $totalAmount,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discountAmount,
                'discount_code' => $request->input('discount_code'),
                'discount_type' => $request->input('discount_type') ?? 'fixed_amount',
                'discount_percentage' => $request->input('discount_percentage') ?? 0,
                'final_amount' => $finalAmount,
                'paid_amount' => $paidAmount,
                'due_amount' => $dueAmount,
                'due_date' => $request->due_date ? \Carbon\Carbon::parse($request->due_date) : now()->addDays(30),
                'status' => 'completed',
                'payment_status' => $paymentStatus,
                'payment_method' => $paymentMethod,
                'invoice_date' => now(),
                'notes' => $request->notes ?? '',
            ];

            \Log::info('Creating order with data:', $orderData);

            // Create order
            try {
                $order = Order::create($orderData);
                if (!$order) {
                    throw new \Exception('Failed to create order');
                }
                \Log::info('Order created successfully:', ['order_id' => $order->id]);
            } catch (\Exception $e) {
                \Log::error('Failed to create order:', ['error' => $e->getMessage(), 'data' => $orderData]);
                throw new \Exception('Failed to create order: ' . $e->getMessage());
            }

            // Create order items
            try {
                foreach ($orderItems as $item) {
                    $orderItem = \App\Models\OrderItem::create(array_merge($item, [
                        'order_id' => $order->id,
                    ]));
                    if (!$orderItem) {
                        throw new \Exception('Failed to create order item');
                    }
                }
                \Log::info('Order items created successfully');
            } catch (\Exception $e) {
                \Log::error('Failed to create order items:', ['error' => $e->getMessage(), 'order_id' => $order->id]);
                // Delete the order if items creation fails
                $order->delete();
                throw new \Exception('Failed to create order items: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Bill created successfully',
                'bill' => [
                    'id' => $order->id,
                    'invoice_number' => $order->invoice_number,
                    'customer_name' => $customer->name,
                    'amount' => $order->final_amount,
                    'due_date' => optional($order->due_date)->format('M d, Y'),
                    'status' => $this->getBillStatus($order),
                ],
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in createBill:', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'error' => 'Validation error: ' . implode(', ', array_flatten($e->errors())),
            ], 422);
        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('Database error in createBill:', ['error' => $e->getMessage(), 'sql' => $e->getSql()]);
            return response()->json([
                'success' => false,
                'error' => 'Database error: ' . $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            \Log::error('Unexpected error in createBill:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'error' => 'Error creating bill: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function deleteBill(Order $bill): JsonResponse
    {
        try {
            // Check if user has permission to delete bills
            if (auth()->user()->role === 'cashier') {
                return response()->json([
                    'success' => false,
                    'error' => 'You do not have permission to delete bills.'
                ], 403);
            }

            // Delete associated order items first
            $bill->orderItems()->delete();
            
            // Delete the bill
            $bill->delete();

            return response()->json([
                'success' => true,
                'message' => 'Bill deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error deleting bill: ' . $e->getMessage()
            ], 500);
        }
    }

    public function viewBill(Order $bill): JsonResponse
    {
        try {
            $bill->load(['customer', 'user', 'orderItems.product']);

            $billData = [
                'id' => $bill->id,
                'bill_number' => $bill->invoice_number,
                'order_number' => $bill->order_number,
                'customer' => [
                    'name' => $bill->customer->name ?? 'N/A',
                    'email' => $bill->customer->email ?? 'N/A',
                    'phone' => $bill->customer->phone ?? 'N/A',
                    'address' => $bill->customer->address ?? 'N/A',
                ],
                'date' => $bill->invoice_date ? $bill->invoice_date->format('M d, Y') : $bill->created_at->format('M d, Y'),
                'due_date' => $bill->due_date ? $bill->due_date->format('M d, Y') : 'N/A',
                'total_amount' => number_format($bill->total_amount, 2),
                'tax_amount' => number_format($bill->tax_amount, 2),
                'discount_amount' => number_format($bill->discount_amount, 2),
                'final_amount' => number_format($bill->final_amount, 2),
                'paid_amount' => number_format($bill->paid_amount, 2),
                'due_amount' => number_format($bill->due_amount, 2),
                'status' => $this->getBillStatus($bill),
                'payment_status' => $bill->payment_status,
                'payment_method' => $bill->payment_method,
                'notes' => $bill->notes,
                'created_by' => $bill->user->name ?? 'System',
                'created_at' => $bill->created_at->format('M d, Y H:i:s'),
                'items' => $bill->orderItems->map(function($item) {
                    return [
                        'product_name' => $item->product->name ?? 'N/A',
                        'sku' => $item->product->sku ?? 'N/A',
                        'quantity' => $item->quantity,
                        'unit_price' => number_format($item->unit_price, 2),
                        'total_price' => number_format($item->total_price, 2),
                        'discount_amount' => number_format($item->discount_amount, 2),
                        'tax_amount' => number_format($item->tax_amount, 2),
                        'final_price' => number_format($item->final_price, 2),
                    ];
                })
            ];

            return response()->json([
                'success' => true,
                'data' => $billData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error fetching bill details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reprintBill(Order $bill): JsonResponse
    {
        try {
            $bill->load(['customer', 'user', 'orderItems.product']);
            $billHeader = BillHeader::getActive();

            // Generate reprint bill data
            $billData = [
                'id' => $bill->id,
                'bill_number' => $bill->invoice_number,
                'order_number' => $bill->order_number,
                'is_reprint' => true, // Flag to identify this as a reprint
                'customer' => [
                    'name' => $bill->customer->name ?? 'N/A',
                    'email' => $bill->customer->email ?? 'N/A',
                    'phone' => $bill->customer->phone ?? 'N/A',
                    'address' => $bill->customer->address ?? 'N/A',
                ],
                'date' => $bill->invoice_date ? $bill->invoice_date->format('M d, Y') : $bill->created_at->format('M d, Y'),
                'due_date' => $bill->due_date ? $bill->due_date->format('M d, Y') : 'N/A',
                'total_amount' => number_format($bill->total_amount, 2),
                'tax_amount' => number_format($bill->tax_amount, 2),
                'discount_amount' => number_format($bill->discount_amount, 2),
                'final_amount' => number_format($bill->final_amount, 2),
                'paid_amount' => number_format($bill->paid_amount, 2),
                'due_amount' => number_format($bill->due_amount, 2),
                'status' => $this->getBillStatus($bill),
                'payment_status' => $bill->payment_status,
                'payment_method' => $bill->payment_method,
                'notes' => $bill->notes,
                'created_by' => $bill->user->name ?? 'System',
                'created_at' => $bill->created_at->format('M d, Y H:i:s'),
                'reprint_date' => now()->format('M d, Y H:i:s'),
                'items' => $bill->orderItems->map(function($item) {
                    return [
                        'product_name' => $item->product->name ?? 'N/A',
                        'sku' => $item->product->sku ?? 'N/A',
                        'quantity' => $item->quantity,
                        'unit_price' => number_format($item->unit_price, 2),
                        'total_price' => number_format($item->total_price, 2),
                        'discount_amount' => number_format($item->discount_amount, 2),
                        'tax_amount' => number_format($item->tax_amount, 2),
                        'final_price' => number_format($item->final_price, 2),
                    ];
                }),
                'bill_header' => $billHeader ? [
                    'company_name' => $billHeader->company_name,
                    'company_logo' => $billHeader->company_logo,
                    'company_address' => $billHeader->company_address,
                    'company_phone' => $billHeader->company_phone,
                    'company_email' => $billHeader->company_email,
                    'company_website' => $billHeader->company_website,
                    'footer_text' => $billHeader->footer_text,
                ] : null
            ];

            return response()->json([
                'success' => true,
                'data' => $billData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error generating reprint: ' . $e->getMessage()
            ], 500);
        }
    }
}
