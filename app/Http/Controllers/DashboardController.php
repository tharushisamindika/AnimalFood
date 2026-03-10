<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sales;
use App\Models\Order;
use App\Models\InventoryAlert;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getStats()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        
        // Today's sales (from Orders table - actual billing data)
        $todaySales = Order::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->whereNotNull('invoice_number')
            ->sum('final_amount');
        $yesterdaySales = Order::whereDate('created_at', $yesterday)
            ->where('status', 'completed')
            ->whereNotNull('invoice_number')
            ->sum('final_amount');
        
        // Today's refunds (from Orders with negative amounts or refund status)
        $todayRefunds = Order::whereDate('created_at', $today)
            ->where(function($query) {
                $query->where('status', 'refunded')
                      ->orWhere('final_amount', '<', 0);
            })
            ->sum(DB::raw('ABS(final_amount)'));
        
        // Net sales
        $todayNet = $todaySales - $todayRefunds;
        
        // Sales target progress (assuming daily target of 10000)
        $dailyTarget = 10000;
        $targetProgress = $dailyTarget > 0 ? ($todayNet / $dailyTarget) * 100 : 0;
        
        // Products in stock
        $productsInStock = Product::where('stock_quantity', '>', 0)->count();
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', 'active')->count();
        
        // Low stock items
        $lowStockItems = Product::where('stock_quantity', '<=', DB::raw('reorder_level'))
            ->count();
        
        // Expiring soon items (within 30 days)
        $expiringSoon = Product::where('expiry_date', '<=', Carbon::now()->addDays(30))
            ->where('expiry_date', '>', Carbon::now())
            ->where('stock_quantity', '>', 0)
            ->count();
        
        // Recent orders with proper formatting
        $recentOrders = Order::with(['customer', 'orderItems.product'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'customer' => [
                        'name' => $order->customer ? $order->customer->name : 'Unknown Customer'
                    ],
                    'items' => $order->orderItems->map(function ($item) {
                        return [
                            'product' => [
                                'name' => $item->product ? $item->product->name : 'Unknown Product'
                            ]
                        ];
                    }),
                    'status' => $order->status,
                    'total_amount' => $order->total_amount,
                    'created_at' => $order->created_at->format('Y-m-d H:i:s')
                ];
            });
        
        // Popular products with proper formatting
        $popularProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->take(4)
            ->get()
            ->map(function ($product) {
                return [
                    'name' => $product->name,
                    'total_sold' => $product->total_sold
                ];
            });
        
        // Customer statistics
        $totalCustomers = Customer::count();
        $activeCustomers = Customer::where('status', 'active')->count();
        
        // Order statistics
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        
        // Monthly revenue (from Orders table)
        $currentMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        
        $monthlyRevenue = Order::where('created_at', '>=', $currentMonth)
            ->where('status', 'completed')
            ->whereNotNull('invoice_number')
            ->sum('final_amount');
            
        $lastMonthRevenue = Order::where('created_at', '>=', $lastMonth)
            ->where('created_at', '<', $currentMonth)
            ->where('status', 'completed')
            ->whereNotNull('invoice_number')
            ->sum('final_amount');
            
        $revenueGrowth = $lastMonthRevenue > 0 ? (($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 : 0;
        
        return response()->json([
            'today_sales' => $todaySales,
            'today_refunds' => $todayRefunds,
            'today_net' => $todayNet,
            'target_progress' => $targetProgress,
            'products_in_stock' => $productsInStock,
            'total_products' => $totalProducts,
            'active_products' => $activeProducts,
            'low_stock_count' => $lowStockItems,
            'expiring_count' => $expiringSoon,
            'total_customers' => $totalCustomers,
            'active_customers' => $activeCustomers,
            'total_orders' => $totalOrders,
            'pending_orders' => $pendingOrders,
            'monthly_revenue' => $monthlyRevenue,
            'revenue_growth' => $revenueGrowth,
            'recent_orders' => $recentOrders,
            'popular_products' => $popularProducts,
            'last_updated' => now()->format('Y-m-d H:i:s')
        ]);
    }
    
    public function getRecentActivity()
    {
        $recentActivities = AuditLog::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'action' => $activity->action,
                    'description' => $activity->description,
                    'model_type' => $activity->model_type,
                    'model_id' => $activity->model_id,
                    'user_name' => $activity->user ? $activity->user->name : 'System',
                    'created_at' => $activity->created_at,
                    'time_ago' => $activity->created_at->diffForHumans(),
                    'icon' => $this->getActivityIcon($activity->action),
                    'color' => $this->getActivityColor($activity->action)
                ];
            });
        
        return response()->json($recentActivities);
    }
    
    private function getActivityIcon($action)
    {
        switch ($action) {
            case 'created':
                return 'M12 6v6m0 0v6m0-6h6m-6 0H6';
            case 'updated':
                return 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z';
            case 'deleted':
                return 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16';
            case 'login':
                return 'M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1';
            case 'logout':
                return 'M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1';
            case 'login_failed':
                return 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z';
            default:
                return 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z';
        }
    }
    
    private function getActivityColor($action)
    {
        switch ($action) {
            case 'created':
                return 'green';
            case 'updated':
                return 'blue';
            case 'deleted':
                return 'red';
            case 'login':
                return 'green';
            case 'logout':
                return 'blue';
            case 'login_failed':
                return 'red';
            default:
                return 'gray';
        }
    }
    
    public function getChartData($period = 'daily')
    {
        $data = [];
        $labels = [];
        
        switch ($period) {
            case 'daily':
                $data = $this->getDailyChartData();
                break;
            case 'weekly':
                $data = $this->getWeeklyChartData();
                break;
            case 'monthly':
                $data = $this->getMonthlyChartData();
                break;
        }
        
        return response()->json($data);
    }
    
    private function getDailyChartData()
    {
        $days = 7;
        $data = [];
        
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $sales = Order::whereDate('created_at', $date)
                ->where('status', 'completed')
                ->whereNotNull('invoice_number')
                ->sum('final_amount');
            $refunds = Order::whereDate('created_at', $date)
                ->where('status', 'refunded')
                ->sum(DB::raw('ABS(final_amount)'));
            
            $data[] = [
                'date' => $date->format('M d'),
                'sales' => $sales,
                'refunds' => $refunds,
                'net' => $sales - $refunds
            ];
        }
        
        return $data;
    }
    
    private function getWeeklyChartData()
    {
        $weeks = 8;
        $data = [];
        
        for ($i = $weeks - 1; $i >= 0; $i--) {
            $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
            $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();
            
            $sales = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->where('status', 'completed')
                ->whereNotNull('invoice_number')
                ->sum('final_amount');
            $refunds = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->where('status', 'refunded')
                ->sum(DB::raw('ABS(final_amount)'));
            
            $data[] = [
                'week' => 'Week ' . $startOfWeek->format('M d'),
                'sales' => $sales,
                'refunds' => $refunds,
                'net' => $sales - $refunds
            ];
        }
        
        return $data;
    }
    
    private function getMonthlyChartData()
    {
        $months = 6;
        $data = [];
        
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $sales = Order::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', 'completed')
                ->whereNotNull('invoice_number')
                ->sum('final_amount');
            $refunds = Order::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', 'refunded')
                ->sum(DB::raw('ABS(final_amount)'));
            
            $data[] = [
                'month' => $date->format('M Y'),
                'sales' => $sales,
                'refunds' => $refunds,
                'net' => $sales - $refunds
            ];
        }
        
        return $data;
    }
}
