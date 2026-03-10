<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\PaymentTransaction;
use App\Models\CustomerCredit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class CustomerReportController extends Controller
{
    /**
     * Display customer dues report
     */
    public function index(Request $request)
    {
        $query = Customer::with(['credit', 'orders' => function($q) {
            $q->where('due_amount', '>', 0)->orderBy('due_date', 'asc');
        }]);

        // Filtering
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('credit_status')) {
            $query->whereHas('credit', function($q) use ($request) {
                $q->where('credit_status', $request->credit_status);
            });
        }

        if ($request->filled('has_dues')) {
            if ($request->has_dues === 'yes') {
                $query->whereHas('orders', function($q) {
                    $q->where('due_amount', '>', 0);
                });
            } else {
                $query->whereDoesntHave('orders', function($q) {
                    $q->where('due_amount', '>', 0);
                });
            }
        }

        if ($request->filled('overdue_only') && $request->overdue_only === 'yes') {
            $query->whereHas('orders', function($q) {
                $q->where('due_amount', '>', 0)
                  ->where('due_date', '<', now());
            });
        }

        $customers = $query->paginate(15);

        // Statistics
        $stats = $this->getCustomerStats();

        return view('admin.reports.customer-dues', compact('customers', 'stats'));
    }

    /**
     * Generate customer statement
     */
    public function customerStatement(Request $request, Customer $customer)
    {
        $startDate = $request->get('start_date', now()->subMonths(3)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $orders = Order::where('customer_id', $customer->id)
                      ->whereBetween('created_at', [$startDate, $endDate])
                      ->with(['orderItems.product'])
                      ->orderBy('created_at', 'desc')
                      ->get();

        $payments = PaymentTransaction::where('customer_id', $customer->id)
                                     ->whereBetween('payment_date', [$startDate, $endDate])
                                     ->orderBy('payment_date', 'desc')
                                     ->get();

        $customer->load('credit');

        $data = [
            'customer' => $customer,
            'orders' => $orders,
            'payments' => $payments,
            'start_date' => Carbon::parse($startDate),
            'end_date' => Carbon::parse($endDate),
            'total_orders' => $orders->sum('final_amount'),
            'total_payments' => $payments->where('type', 'payment')->sum('amount'),
            'total_due' => $orders->sum('due_amount'),
        ];

        if ($request->get('format') === 'pdf') {
            return $this->generateStatementPDF($data);
        }

        return view('admin.reports.customer-statement', $data);
    }

    /**
     * Generate detailed customer report
     */
    public function detailedReport(Request $request)
    {
        $startDate = $request->get('start_date', now()->subMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        $customerId = $request->get('customer_id');

        $query = Order::with(['customer', 'orderItems.product', 'paymentTransactions'])
                     ->whereBetween('created_at', [$startDate, $endDate]);

        if ($customerId) {
            $query->where('customer_id', $customerId);
        }

        $orders = $query->get();

        $summary = [
            'total_orders' => $orders->count(),
            'total_amount' => $orders->sum('final_amount'),
            'total_paid' => $orders->sum('paid_amount'),
            'total_due' => $orders->sum('due_amount'),
            'total_credit_sales' => $orders->where('is_credit_sale', true)->count(),
            'payment_methods' => $orders->groupBy('payment_method')->map->count(),
        ];

        $customers = Customer::orderBy('name')->get();

        $data = [
            'orders' => $orders,
            'summary' => $summary,
            'customers' => $customers,
            'start_date' => Carbon::parse($startDate),
            'end_date' => Carbon::parse($endDate),
            'selected_customer' => $customerId ? Customer::find($customerId) : null,
        ];

        if ($request->get('format') === 'pdf') {
            return $this->generateDetailedReportPDF($data);
        }

        return view('admin.reports.detailed-report', $data);
    }

    /**
     * Generate aging report
     */
    public function agingReport(Request $request)
    {
        $customerId = $request->get('customer_id');
        
        $query = Order::with('customer')
                     ->where('due_amount', '>', 0);

        if ($customerId) {
            $query->where('customer_id', $customerId);
        }

        $orders = $query->get();

        $agingData = $orders->groupBy('customer_id')->map(function($customerOrders) {
            $customer = $customerOrders->first()->customer;
            $totalDue = $customerOrders->sum('due_amount');
            
            $aging = [
                'current' => 0,      // 0-30 days
                'days_31_60' => 0,   // 31-60 days
                'days_61_90' => 0,   // 61-90 days
                'over_90' => 0,      // Over 90 days
            ];

            foreach ($customerOrders as $order) {
                if (!$order->due_date) continue;
                
                $daysOverdue = now()->diffInDays($order->due_date, false);
                
                if ($daysOverdue <= 30) {
                    $aging['current'] += $order->due_amount;
                } elseif ($daysOverdue <= 60) {
                    $aging['days_31_60'] += $order->due_amount;
                } elseif ($daysOverdue <= 90) {
                    $aging['days_61_90'] += $order->due_amount;
                } else {
                    $aging['over_90'] += $order->due_amount;
                }
            }

            return [
                'customer' => $customer,
                'total_due' => $totalDue,
                'aging' => $aging,
                'orders_count' => $customerOrders->count(),
            ];
        });

        $customers = Customer::orderBy('name')->get();

        $data = [
            'aging_data' => $agingData,
            'customers' => $customers,
            'selected_customer' => $customerId ? Customer::find($customerId) : null,
        ];

        if ($request->get('format') === 'pdf') {
            return $this->generateAgingReportPDF($data);
        }

        return view('admin.reports.aging-report', $data);
    }

    /**
     * Export customer dues as CSV
     */
    public function exportDues(Request $request)
    {
        $customers = Customer::with(['credit', 'orders' => function($q) {
            $q->where('due_amount', '>', 0);
        }])->get();

        $filename = 'customer_dues_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($customers) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, [
                'Customer Name',
                'Email',
                'Phone',
                'Credit Limit',
                'Current Balance',
                'Available Credit',
                'Total Due Amount',
                'Overdue Orders',
                'Credit Status'
            ]);

            foreach ($customers as $customer) {
                $totalDue = $customer->orders->sum('due_amount');
                $overdueOrders = $customer->orders->filter(function($order) {
                    return $order->due_date && $order->due_date->isPast();
                })->count();

                fputcsv($file, [
                    $customer->name,
                    $customer->email,
                    $customer->phone,
                    $customer->credit ? $customer->credit->credit_limit : 0,
                    $customer->credit ? $customer->credit->current_balance : 0,
                    $customer->credit ? $customer->credit->available_credit : 0,
                    $totalDue,
                    $overdueOrders,
                    $customer->credit ? $customer->credit->formatted_credit_status : 'No Credit'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get customer statistics
     */
    private function getCustomerStats()
    {
        return [
            'total_customers' => Customer::count(),
            'customers_with_credit' => Customer::whereHas('credit')->count(),
            'customers_with_dues' => Customer::whereHas('orders', function($q) {
                $q->where('due_amount', '>', 0);
            })->count(),
            'overdue_customers' => Customer::whereHas('orders', function($q) {
                $q->where('due_amount', '>', 0)->where('due_date', '<', now());
            })->count(),
            'total_outstanding' => Order::where('due_amount', '>', 0)->sum('due_amount'),
            'overdue_amount' => Order::where('due_amount', '>', 0)
                                   ->where('due_date', '<', now())->sum('due_amount'),
        ];
    }

    /**
     * Generate customer statement PDF
     */
    private function generateStatementPDF($data)
    {
        $pdf = Pdf::loadView('admin.reports.pdf.customer-statement', $data)
                  ->setPaper('a4', 'portrait');

        $filename = 'customer_statement_' . $data['customer']->name . '_' . now()->format('Y_m_d') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Generate detailed report PDF
     */
    private function generateDetailedReportPDF($data)
    {
        $pdf = Pdf::loadView('admin.reports.pdf.detailed-report', $data)
                  ->setPaper('a4', 'landscape');

        $filename = 'detailed_report_' . $data['start_date']->format('Y_m_d') . '_to_' . $data['end_date']->format('Y_m_d') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Generate aging report PDF
     */
    private function generateAgingReportPDF($data)
    {
        $pdf = Pdf::loadView('admin.reports.pdf.aging-report', $data)
                  ->setPaper('a4', 'landscape');

        $filename = 'aging_report_' . now()->format('Y_m_d') . '.pdf';
        
        return $pdf->download($filename);
    }
}