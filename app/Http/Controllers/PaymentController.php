<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use App\Models\Customer;
use App\Models\Order;
use App\Models\CustomerCredit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display payment transactions
     */
    public function index(Request $request)
    {
        $query = PaymentTransaction::with(['customer', 'order', 'user'])
                                  ->orderBy('created_at', 'desc');

        // Filtering
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date_from')) {
            $query->where('payment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('payment_date', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('transaction_number', 'like', "%{$search}%")
                  ->orWhere('reference_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $payments = $query->paginate(15);
        $customers = Customer::orderBy('name')->get();
        
        $paymentMethods = ['cash', 'card', 'bank_transfer', 'credit', 'cheque', 'mobile_payment'];
        $paymentTypes = ['payment', 'refund', 'credit_adjustment', 'late_fee'];

        return view('admin.payments.index', compact('payments', 'customers', 'paymentMethods', 'paymentTypes'));
    }

    /**
     * Show payment form
     */
    public function create(Request $request)
    {
        $customerId = $request->get('customer_id');
        $orderId = $request->get('order_id');

        $customer = $customerId ? Customer::with('credit')->find($customerId) : null;
        $order = $orderId ? Order::find($orderId) : null;

        $customers = Customer::orderBy('name')->get();
        $paymentMethods = ['cash', 'card', 'bank_transfer', 'credit', 'cheque', 'mobile_payment'];

        return view('admin.payments.create', compact('customers', 'customer', 'order', 'paymentMethods'));
    }

    /**
     * Store payment
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'order_id' => 'nullable|exists:orders,id',
            'type' => 'required|in:payment,refund,credit_adjustment,late_fee',
            'payment_method' => 'required|in:cash,card,bank_transfer,credit,cheque,mobile_payment',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'reference_number' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::transaction(function () use ($request) {
            // Create payment transaction
            $payment = PaymentTransaction::create([
                'customer_id' => $request->customer_id,
                'order_id' => $request->order_id,
                'user_id' => auth()->id(),
                'type' => $request->type,
                'payment_method' => $request->payment_method,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'reference_number' => $request->reference_number,
                'description' => $request->description,
                'notes' => $request->notes,
                'status' => 'completed',
            ]);

            // Update order if specified
            if ($request->order_id && $request->type === 'payment') {
                $order = Order::find($request->order_id);
                $order->increment('paid_amount', $request->amount);
                $order->decrement('due_amount', $request->amount);
                
                // Update payment status
                if ($order->due_amount <= 0) {
                    $order->payment_status = 'paid';
                } elseif ($order->paid_amount > 0) {
                    $order->payment_status = 'partial';
                }
                $order->save();
            }

            // Update customer credit
            $customerCredit = CustomerCredit::where('customer_id', $request->customer_id)->first();
            if ($customerCredit && $request->type === 'payment') {
                $customerCredit->updateBalance($request->amount, 'payment');
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Payment recorded successfully!',
            'redirect' => route('admin.payments.index')
        ]);
    }

    /**
     * Show payment details
     */
    public function show(PaymentTransaction $payment)
    {
        $payment->load(['customer', 'order', 'user']);
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Process bulk payment
     */
    public function bulkPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'payment_method' => 'required|in:cash,card,bank_transfer,credit,cheque,mobile_payment',
            'total_amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'reference_number' => 'nullable|string|max:100',
            'orders' => 'required|array|min:1',
            'orders.*.order_id' => 'required|exists:orders,id',
            'orders.*.amount' => 'required|numeric|min:0.01',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::transaction(function () use ($request) {
            $totalPaid = 0;

            foreach ($request->orders as $orderPayment) {
                // Create individual payment transaction
                PaymentTransaction::create([
                    'customer_id' => $request->customer_id,
                    'order_id' => $orderPayment['order_id'],
                    'user_id' => auth()->id(),
                    'type' => 'payment',
                    'payment_method' => $request->payment_method,
                    'amount' => $orderPayment['amount'],
                    'payment_date' => $request->payment_date,
                    'reference_number' => $request->reference_number,
                    'description' => 'Bulk payment',
                    'status' => 'completed',
                ]);

                // Update order
                $order = Order::find($orderPayment['order_id']);
                $order->increment('paid_amount', $orderPayment['amount']);
                $order->decrement('due_amount', $orderPayment['amount']);
                
                if ($order->due_amount <= 0) {
                    $order->payment_status = 'paid';
                } elseif ($order->paid_amount > 0) {
                    $order->payment_status = 'partial';
                }
                $order->save();

                $totalPaid += $orderPayment['amount'];
            }

            // Update customer credit
            $customerCredit = CustomerCredit::where('customer_id', $request->customer_id)->first();
            if ($customerCredit) {
                $customerCredit->updateBalance($totalPaid, 'payment');
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Bulk payment processed successfully!',
            'redirect' => route('admin.payments.index')
        ]);
    }

    /**
     * Get customer outstanding orders
     */
    public function getCustomerOutstanding(Customer $customer)
    {
        $orders = Order::where('customer_id', $customer->id)
                      ->where('due_amount', '>', 0)
                      ->with(['orderItems.product'])
                      ->orderBy('due_date', 'asc')
                      ->get();

        $data = $orders->map(function($order) {
            return [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'invoice_number' => $order->invoice_number,
                'order_date' => $order->created_at->format('Y-m-d'),
                'due_date' => $order->due_date ? $order->due_date->format('Y-m-d') : null,
                'total_amount' => $order->final_amount,
                'paid_amount' => $order->paid_amount,
                'due_amount' => $order->due_amount,
                'is_overdue' => $order->is_overdue,
                'days_overdue' => $order->due_date ? now()->diffInDays($order->due_date, false) : 0,
            ];
        });

        return response()->json($data);
    }

    /**
     * Reverse payment
     */
    public function reverse(PaymentTransaction $payment)
    {
        if ($payment->status !== 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Only completed payments can be reversed.'
            ], 422);
        }

        DB::transaction(function () use ($payment) {
            // Create reversal transaction
            PaymentTransaction::create([
                'customer_id' => $payment->customer_id,
                'order_id' => $payment->order_id,
                'user_id' => auth()->id(),
                'type' => $payment->type === 'payment' ? 'refund' : 'payment',
                'payment_method' => $payment->payment_method,
                'amount' => $payment->amount,
                'payment_date' => now(),
                'description' => 'Reversal of transaction: ' . $payment->transaction_number,
                'status' => 'completed',
            ]);

            // Update order if applicable
            if ($payment->order_id && $payment->type === 'payment') {
                $order = Order::find($payment->order_id);
                $order->decrement('paid_amount', $payment->amount);
                $order->increment('due_amount', $payment->amount);
                
                if ($order->due_amount > 0) {
                    $order->payment_status = $order->paid_amount > 0 ? 'partial' : 'pending';
                }
                $order->save();
            }

            // Update customer credit
            $customerCredit = CustomerCredit::where('customer_id', $payment->customer_id)->first();
            if ($customerCredit && $payment->type === 'payment') {
                $customerCredit->updateBalance($payment->amount, 'purchase');
            }

            // Mark original payment as reversed
            $payment->update(['status' => 'cancelled']);
        });

        return response()->json([
            'success' => true,
            'message' => 'Payment reversed successfully!'
        ]);
    }

    /**
     * Get payments summary for dashboard
     */
    public function getSummary()
    {
        $today = now()->startOfDay();
        
        // Today's payments
        $todayPayments = PaymentTransaction::where('payment_date', '>=', $today)
            ->where('type', 'payment')
            ->where('status', 'completed')
            ->sum('amount');

        // Outstanding dues
        $outstandingDues = Order::where('due_amount', '>', 0)
            ->where('status', 'completed')
            ->sum('due_amount');

        // Overdue amounts (due date passed)
        $overdueAmount = Order::where('due_amount', '>', 0)
            ->where('due_date', '<', now())
            ->where('status', 'completed')
            ->sum('due_amount');

        // Customers with dues
        $customersWithDues = Order::where('due_amount', '>', 0)
            ->where('status', 'completed')
            ->distinct('customer_id')
            ->count('customer_id');

        return response()->json([
            'success' => true,
            'today_payments' => number_format($todayPayments, 2),
            'outstanding_dues' => number_format($outstandingDues, 2),
            'overdue_amount' => number_format($overdueAmount, 2),
            'customers_with_dues' => $customersWithDues
        ]);
    }

    /**
     * Get payments API for AJAX loading
     */
    public function getPaymentsApi(Request $request)
    {
        $query = PaymentTransaction::with(['customer', 'order', 'user'])
                                  ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date_from')) {
            $query->where('payment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('payment_date', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('transaction_number', 'like', "%{$search}%")
                  ->orWhere('reference_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $payments = $query->paginate(15);

        return response()->json([
            'success' => true,
            'payments' => $payments
        ]);
    }

    /**
     * Generate customer dues report
     */
    public function getDuesReport(Request $request)
    {
        $query = Customer::with(['orders' => function($q) {
            $q->where('due_amount', '>', 0)
              ->where('status', 'completed')
              ->orderBy('due_date', 'asc');
        }])->whereHas('orders', function($q) {
            $q->where('due_amount', '>', 0)
              ->where('status', 'completed');
        });

        // Filter by customer if specified
        if ($request->filled('customer_id')) {
            $query->where('id', $request->customer_id);
        }

        $customers = $query->get();

        $report = [
            'summary' => [
                'total_dues' => 0,
                'overdue_amount' => 0,
                'customers_count' => 0
            ],
            'customers' => []
        ];

        foreach ($customers as $customer) {
            $totalDue = $customer->orders->sum('due_amount');
            $overdueAmount = $customer->orders->where('due_date', '<', now())->sum('due_amount');
            $billsCount = $customer->orders->count();
            $oldestBillDate = $customer->orders->min('due_date');

            // Apply status filter
            if ($request->filled('status')) {
                if ($request->status === 'overdue' && $overdueAmount <= 0) {
                    continue;
                }
                if ($request->status === 'current' && $overdueAmount > 0) {
                    continue;
                }
            }

            $customerData = [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'total_due' => number_format($totalDue, 2),
                'overdue_amount' => number_format($overdueAmount, 2),
                'bills_count' => $billsCount,
                'oldest_bill_date' => $oldestBillDate,
                'bills' => $customer->orders->map(function($order) {
                    return [
                        'id' => $order->id,
                        'invoice_number' => $order->invoice_number,
                        'order_date' => $order->created_at->format('Y-m-d'),
                        'due_date' => $order->due_date ? $order->due_date->format('Y-m-d') : null,
                        'total_amount' => number_format($order->final_amount, 2),
                        'paid_amount' => number_format($order->paid_amount, 2),
                        'due_amount' => number_format($order->due_amount, 2),
                        'is_overdue' => $order->due_date && $order->due_date->isPast(),
                        'days_overdue' => $order->due_date ? max(0, now()->diffInDays($order->due_date, false)) : 0,
                    ];
                })
            ];

            $report['customers'][] = $customerData;
            $report['summary']['total_dues'] += $totalDue;
            $report['summary']['overdue_amount'] += $overdueAmount;
        }

        $report['summary']['total_dues'] = number_format($report['summary']['total_dues'], 2);
        $report['summary']['overdue_amount'] = number_format($report['summary']['overdue_amount'], 2);
        $report['summary']['customers_count'] = count($report['customers']);

        // Sort customers by total due amount (descending)
        usort($report['customers'], function($a, $b) {
            return (float)str_replace(',', '', $b['total_due']) <=> (float)str_replace(',', '', $a['total_due']);
        });

        return response()->json([
            'success' => true,
            'report' => $report
        ]);
    }

    /**
     * Get customer bills for detailed view
     */
    public function getCustomerBills(Customer $customer)
    {
        $bills = Order::where('customer_id', $customer->id)
                     ->where('due_amount', '>', 0)
                     ->with(['orderItems.product'])
                     ->orderBy('due_date', 'asc')
                     ->get();

        $data = $bills->map(function($bill) {
            return [
                'id' => $bill->id,
                'invoice_number' => $bill->invoice_number,
                'order_number' => $bill->order_number,
                'order_date' => $bill->created_at->format('Y-m-d'),
                'due_date' => $bill->due_date ? $bill->due_date->format('Y-m-d') : null,
                'total_amount' => $bill->final_amount,
                'paid_amount' => $bill->paid_amount,
                'due_amount' => $bill->due_amount,
                'is_overdue' => $bill->due_date && $bill->due_date->isPast(),
                'days_overdue' => $bill->due_date ? max(0, now()->diffInDays($bill->due_date, false)) : 0,
                'items' => $bill->orderItems->map(function($item) {
                    return [
                        'product_name' => $item->product->name ?? 'N/A',
                        'quantity' => $item->quantity,
                        'unit_price' => $item->unit_price,
                        'total_price' => $item->total_price
                    ];
                })
            ];
        });

        return response()->json([
            'success' => true,
            'customer' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone
            ],
            'bills' => $data,
            'summary' => [
                'total_due' => $bills->sum('due_amount'),
                'overdue_amount' => $bills->where('due_date', '<', now())->sum('due_amount'),
                'bills_count' => $bills->count()
            ]
        ]);
    }
}