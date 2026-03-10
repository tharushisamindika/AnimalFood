<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BillHeaderController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\CustomerReportController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Registration routes (only for administrators and super administrators)
    Route::get('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])->name('register')->middleware('role:administrator,super_administrator');
    Route::post('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])->middleware('role:administrator,super_administrator');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Change Password Routes
    Route::get('/change-password', [ChangePasswordController::class, 'show'])->name('password.change');
    Route::post('/change-password', [ChangePasswordController::class, 'update'])->name('password.change.update');
    
    // AJAX Password Validation Routes
    Route::post('/validate-current-password', [ChangePasswordController::class, 'validateCurrentPassword'])->name('password.validate.current');
    Route::post('/validate-password-confirmation', [ChangePasswordController::class, 'validatePasswordConfirmation'])->name('password.validate.confirmation');
    Route::post('/check-password-history', [ChangePasswordController::class, 'checkPasswordHistory'])->name('password.check.history');
    Route::post('/generate-password', [ChangePasswordController::class, 'generatePassword'])->name('password.generate');
    
    // Admin Routes
    Route::prefix('admin')->group(function () {
        // Products CRUD
        Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('admin.products.show');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy')->middleware('role:administrator,super_administrator');
        
        // Product alerts and stock management
        Route::get('/products/alerts/low-stock', [ProductController::class, 'lowStockAlerts'])->name('admin.products.low-stock');
        Route::get('/products/alerts/expiring', [ProductController::class, 'expiringSoonAlerts'])->name('admin.products.expiring');
        Route::post('/products/{product}/update-stock', [ProductController::class, 'updateStock'])->name('admin.products.update-stock');
        Route::get('/products/count', [ProductController::class, 'getCounts'])->name('admin.products.count');
        
        // Sales Management
        Route::get('/sales', [SalesController::class, 'index'])->name('admin.sales.index');
        Route::get('/sales/create', [SalesController::class, 'create'])->name('admin.sales.create');
        Route::post('/sales', [SalesController::class, 'store'])->name('admin.sales.store');
        Route::get('/sales/{sale}', [SalesController::class, 'show'])->name('admin.sales.show');
        Route::get('/sales/{sale}/edit', [SalesController::class, 'edit'])->name('admin.sales.edit');
        Route::put('/sales/{sale}', [SalesController::class, 'update'])->name('admin.sales.update');
        Route::delete('/sales/{sale}', [SalesController::class, 'destroy'])->name('admin.sales.destroy');
        Route::post('/sales/{sale}/refund', [SalesController::class, 'refund'])->name('admin.sales.refund');
        Route::get('/sales/stats', [SalesController::class, 'getStats'])->name('admin.sales.stats');
        Route::get('/sales/product/{productId}', [SalesController::class, 'getProductDetails'])->name('admin.sales.product-details');
        
        // Chart Data Routes
        Route::get('/sales/charts/daily', [SalesController::class, 'getDailyChartData'])->name('admin.sales.charts.daily');
        Route::get('/sales/charts/weekly', [SalesController::class, 'getWeeklyChartData'])->name('admin.sales.charts.weekly');
        Route::get('/sales/charts/monthly', [SalesController::class, 'getMonthlyChartData'])->name('admin.sales.charts.monthly');
        Route::get('/sales/charts/products', [SalesController::class, 'getProductChartData'])->name('admin.sales.charts.products');
        
        // Sales Targets
        Route::get('/sales/targets', [SalesController::class, 'targets'])->name('admin.sales.targets');
        Route::post('/sales/targets', [SalesController::class, 'storeTarget'])->name('admin.sales.targets.store');
        

        // Orders CRUD
        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/create', [OrderController::class, 'create'])->name('admin.orders.create');
        Route::post('/orders', [OrderController::class, 'store']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);
        Route::put('/orders/{order}', [OrderController::class, 'update']);
        Route::delete('/orders/{order}', [OrderController::class, 'destroy']);
        Route::post('/orders/bulk-delete', [OrderController::class, 'bulkDelete'])->name('admin.orders.bulk-delete');
        Route::get('/orders/export', [OrderController::class, 'export'])->name('admin.orders.export');
        
        // Customers CRUD
        Route::get('/customers', [CustomerController::class, 'index'])->name('admin.customers.index');
        Route::get('/customers/create', [CustomerController::class, 'create'])->name('admin.customers.create');
        Route::post('/customers', [CustomerController::class, 'store']);
        Route::post('/customers/bulk-delete', [CustomerController::class, 'bulkDelete'])->name('admin.customers.bulk-delete');
        Route::get('/customers/export', [CustomerController::class, 'export'])->name('admin.customers.export');
        Route::get('/customers/validate-field', [CustomerController::class, 'validateField'])->name('admin.customers.validate-field');
        Route::get('/customers/{customer}', [CustomerController::class, 'show']);
        Route::put('/customers/{customer}', [CustomerController::class, 'update']);
        Route::delete('/customers/{customer}', [CustomerController::class, 'destroy']);
        
        // Suppliers CRUD (Admin Only)
        Route::get('/suppliers', [SupplierController::class, 'index'])->name('admin.suppliers')->middleware('role:administrator,super_administrator');
        Route::get('/suppliers/search', [SupplierController::class, 'search'])->name('admin.suppliers.search')->middleware('role:administrator,super_administrator');
        Route::post('/suppliers', [SupplierController::class, 'store'])->middleware('role:administrator,super_administrator');
        Route::get('/suppliers/{supplier}', [SupplierController::class, 'show'])->middleware('role:administrator,super_administrator');
        Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->middleware('role:administrator,super_administrator');
        Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->middleware('role:administrator,super_administrator');
        
        // Purchases CRUD (Admin Only)
        Route::get('/purchases', [PurchaseController::class, 'index'])->name('admin.purchases.index')->middleware('role:administrator,super_administrator');
        Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('admin.purchases.create')->middleware('role:administrator,super_administrator');
        Route::post('/purchases', [PurchaseController::class, 'store'])->name('admin.purchases.store')->middleware('role:administrator,super_administrator');
        Route::get('/purchases/{purchase}', [PurchaseController::class, 'show'])->name('admin.purchases.show')->middleware('role:administrator,super_administrator');
        Route::get('/purchases/{purchase}/grn', [PurchaseController::class, 'grn'])->name('admin.purchases.grn')->middleware('role:administrator,super_administrator');
        Route::post('/purchases/{purchase}/receive', [PurchaseController::class, 'receiveItems'])->name('admin.purchases.receive')->middleware('role:administrator,super_administrator');
        Route::patch('/purchases/{purchase}/cancel', [PurchaseController::class, 'cancel'])->name('admin.purchases.cancel')->middleware('role:administrator,super_administrator');
        
        // Purchase Returns CRUD (Admin Only)
        Route::get('/purchase-returns', [PurchaseReturnController::class, 'index'])->name('admin.purchase-returns.index')->middleware('role:administrator,super_administrator');
        Route::get('/purchase-returns/create', [PurchaseReturnController::class, 'create'])->name('admin.purchase-returns.create')->middleware('role:administrator,super_administrator');
        Route::post('/purchase-returns', [PurchaseReturnController::class, 'store'])->name('admin.purchase-returns.store')->middleware('role:administrator,super_administrator');
        Route::get('/purchase-returns/{purchaseReturn}', [PurchaseReturnController::class, 'show'])->name('admin.purchase-returns.show')->middleware('role:administrator,super_administrator');
        Route::patch('/purchase-returns/{purchaseReturn}/approve', [PurchaseReturnController::class, 'approve'])->name('admin.purchase-returns.approve')->middleware('role:administrator,super_administrator');
        Route::patch('/purchase-returns/{purchaseReturn}/reject', [PurchaseReturnController::class, 'reject'])->name('admin.purchase-returns.reject')->middleware('role:administrator,super_administrator');
        Route::patch('/purchase-returns/{purchaseReturn}/process', [PurchaseReturnController::class, 'process'])->name('admin.purchase-returns.process')->middleware('role:administrator,super_administrator');
        Route::patch('/purchase-returns/{purchaseReturn}/complete', [PurchaseReturnController::class, 'complete'])->name('admin.purchase-returns.complete')->middleware('role:administrator,super_administrator');
        Route::get('/purchases/{purchase}/items', [PurchaseReturnController::class, 'getPurchaseItems'])->name('admin.purchases.items')->middleware('role:administrator,super_administrator');
        
        // Categories CRUD (Admin Only)
        Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories')->middleware('role:administrator,super_administrator');
        Route::post('/categories', [CategoryController::class, 'store'])->middleware('role:administrator,super_administrator');
        Route::get('/categories/get/all', [CategoryController::class, 'getCategories'])->name('admin.categories.get')->middleware('role:administrator,super_administrator');
        Route::get('/categories/validate-name', [CategoryController::class, 'validateName'])->name('admin.categories.validate-name')->middleware('role:administrator,super_administrator');
        Route::get('/categories/{id}', [CategoryController::class, 'show'])->where('id', '[0-9]+')->middleware('role:administrator,super_administrator');
        Route::put('/categories/{id}', [CategoryController::class, 'update'])->where('id', '[0-9]+')->middleware('role:administrator,super_administrator');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->where('id', '[0-9]+')->middleware('role:administrator,super_administrator');
        
        // Users CRUD (Admin Only)
        Route::get('/users', [UserController::class, 'index'])->name('admin.users')->middleware('role:administrator,super_administrator');
        Route::post('/users', [UserController::class, 'store'])->middleware('role:administrator,super_administrator');
        Route::get('/users/{user}', [UserController::class, 'show'])->middleware('role:administrator,super_administrator');
        Route::put('/users/{user}', [UserController::class, 'update'])->middleware('role:administrator,super_administrator');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware('role:administrator,super_administrator');
        
        // Audit Logs (Admin Only)
        Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('admin.audit-logs.index')->middleware('role:administrator,super_administrator');
        Route::get('/audit-logs/export', [AuditLogController::class, 'export'])->name('admin.audit-logs.export')->middleware('role:administrator,super_administrator');
        Route::get('/audit-logs/stats', [AuditLogController::class, 'getStats'])->name('admin.audit-logs.stats')->middleware('role:administrator,super_administrator');
        Route::get('/audit-logs/cleanup-estimate', [AuditLogController::class, 'cleanupEstimate'])->name('admin.audit-logs.cleanup-estimate')->middleware('role:administrator,super_administrator');
        Route::post('/audit-logs/cleanup', [AuditLogController::class, 'cleanup'])->name('admin.audit-logs.cleanup')->middleware('role:administrator,super_administrator');
        Route::get('/audit-logs/user/login-history', [AuditLogController::class, 'getUserLoginHistory'])->name('admin.audit-logs.user.login-history')->middleware('role:administrator,super_administrator');
        Route::get('/audit-logs/bill-header/history', [AuditLogController::class, 'getBillHeaderHistory'])->name('admin.audit-logs.bill-header.history')->middleware('role:administrator,super_administrator');
        Route::get('/audit-logs/recent', [AuditLogController::class, 'getRecentLogs'])->name('admin.audit-logs.recent')->middleware('role:administrator,super_administrator');
        Route::get('/audit-logs/{auditLog}', [AuditLogController::class, 'show'])->name('admin.audit-logs.show')->middleware('role:administrator,super_administrator');

        // Customer Reports & Dues
        Route::get('/reports/customer-dues', [CustomerReportController::class, 'index'])->name('admin.reports.customer-dues');
        Route::get('/reports/customer-statement/{customer}', [CustomerReportController::class, 'customerStatement'])->name('admin.reports.customer-statement');
        Route::get('/reports/detailed-report', [CustomerReportController::class, 'detailedReport'])->name('admin.reports.detailed-report');
        Route::get('/reports/aging-report', [CustomerReportController::class, 'agingReport'])->name('admin.reports.aging-report');
        Route::get('/reports/export-dues', [CustomerReportController::class, 'exportDues'])->name('admin.reports.export-dues');

        // Payments
        Route::get('/payments', [PaymentController::class, 'index'])->name('admin.payments.index');
        Route::get('/payments/create', [PaymentController::class, 'create'])->name('admin.payments.create');
        Route::post('/payments', [PaymentController::class, 'store'])->name('admin.payments.store');
        Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('admin.payments.show');
        Route::post('/payments/bulk', [PaymentController::class, 'bulkPayment'])->name('admin.payments.bulk');
        Route::get('/customers/{customer}/outstanding', [PaymentController::class, 'getCustomerOutstanding'])->name('admin.customers.outstanding');
        Route::get('/customers/{customer}/credit', function($customerId) {
            $customer = \App\Models\Customer::find($customerId);
            return response()->json($customer ? $customer->credit : null);
        })->name('admin.customers.credit');
        Route::patch('/payments/{payment}/reverse', [PaymentController::class, 'reverse'])->name('admin.payments.reverse');
        
        // Payment API Routes
        Route::get('/payments/summary', [PaymentController::class, 'getSummary'])->name('admin.payments.summary');
        Route::get('/payments/api', [PaymentController::class, 'getPaymentsApi'])->name('admin.payments.api');
        Route::get('/payments/dues-report', [PaymentController::class, 'getDuesReport'])->name('admin.payments.dues-report');
        Route::get('/customers/{customer}/bills', [PaymentController::class, 'getCustomerBills'])->name('admin.customers.bills');

        // Discounts
        Route::get('/discounts', [DiscountController::class, 'index'])->name('admin.discounts.index');
        Route::get('/discounts/create', [DiscountController::class, 'create'])->name('admin.discounts.create');
        Route::post('/discounts', [DiscountController::class, 'store'])->name('admin.discounts.store');
        Route::get('/discounts/{discount}', [DiscountController::class, 'show'])->name('admin.discounts.show');
        Route::get('/discounts/{discount}/edit', [DiscountController::class, 'edit'])->name('admin.discounts.edit');
        Route::put('/discounts/{discount}', [DiscountController::class, 'update'])->name('admin.discounts.update');
        Route::delete('/discounts/{discount}', [DiscountController::class, 'destroy'])->name('admin.discounts.destroy');
        Route::get('/api/discounts/validate-code', [DiscountController::class, 'validateCode'])->name('admin.discounts.validate-code');
        Route::get('/api/discounts/automatic', [DiscountController::class, 'getAutomaticDiscounts'])->name('admin.discounts.automatic');
        Route::patch('/discounts/{discount}/toggle', [DiscountController::class, 'toggleStatus'])->name('admin.discounts.toggle');

        // Inventory Management
        Route::get('/inventory', [InventoryController::class, 'index'])->name('admin.inventory.dashboard');
        Route::get('/inventory/stock-levels', [InventoryController::class, 'stockLevels'])->name('admin.inventory.stock-levels');
        Route::get('/inventory/scanner', [InventoryController::class, 'scanner'])->name('admin.inventory.scanner');
        Route::post('/inventory/scan-barcode', [InventoryController::class, 'scanBarcode'])->name('admin.inventory.scan-barcode');
        Route::post('/inventory/adjust-stock', [InventoryController::class, 'adjustStock'])->name('admin.inventory.adjust-stock');
        Route::get('/inventory/search-products', [InventoryController::class, 'searchProducts'])->name('admin.inventory.search-products');
        Route::get('/products/{product}/info', [InventoryController::class, 'getProductInfo'])->name('admin.products.info');
        Route::post('/inventory/generate-barcode/{product}', [InventoryController::class, 'generateBarcode'])->name('admin.inventory.generate-barcode');
        
        // Billing
        Route::get('/billing', [BillingController::class, 'index'])->name('admin.billing.index');
        Route::get('/billing/customers', [BillingController::class, 'getCustomers'])->name('admin.billing.customers');
        Route::get('/billing/products', [BillingController::class, 'getProducts'])->name('admin.billing.products');
        Route::get('/billing/products/{id}', [BillingController::class, 'getProductDetails'])->name('admin.billing.products.details');
        Route::get('/billing/customers/{id}', [BillingController::class, 'getCustomerDetails'])->name('admin.billing.customers.details');
        
        Route::get('/billing/list', [BillingController::class, 'list'])->name('admin.billing.list');
                        Route::get('/billing/api/bills', [BillingController::class, 'getBills'])->name('admin.billing.api.bills');
                Route::post('/billing/api/create-sample-bills', [BillingController::class, 'createSampleBills'])->name('admin.billing.api.create-sample-bills');
                Route::post('/billing/api/create-bill', [BillingController::class, 'createBill'])->name('admin.billing.api.create-bill');
                Route::delete('/billing/api/bills/{bill}', [BillingController::class, 'deleteBill'])->name('admin.billing.api.delete-bill');
                Route::get('/billing/api/bills/{bill}/view', [BillingController::class, 'viewBill'])->name('admin.billing.api.view-bill');
                Route::get('/billing/api/bills/{bill}/reprint', [BillingController::class, 'reprintBill'])->name('admin.billing.api.reprint-bill');
                Route::get('/billing/export', [BillingController::class, 'exportBills'])->name('admin.billing.export');
        
        // Reports
        Route::get('/reports', function () {
            return view('admin.reports.index');
        })->name('admin.reports.index');
        
        Route::get('/reports/sales', function () {
            return view('admin.reports.sales');
        })->name('admin.reports.sales');
        
        Route::get('/reports/customers', function () {
            return view('admin.reports.customers');
        })->name('admin.reports.customers');
        
        Route::get('/reports/suppliers', function () {
            return view('admin.reports.suppliers');
        })->name('admin.reports.suppliers');
        
        Route::get('/reports/inventory', function () {
            return view('admin.reports.inventory');
        })->name('admin.reports.inventory');
        
        Route::get('/settings', function () {
            return view('admin.settings.index');
        })->name('admin.settings');
        
        // Dashboard Data
        Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])->name('admin.dashboard.stats');
        Route::get('/dashboard/charts/{period}', [DashboardController::class, 'getChartData'])->name('admin.dashboard.charts');
        Route::get('/dashboard/recent-activity', [DashboardController::class, 'getRecentActivity'])->name('admin.dashboard.recent-activity');
        
        // Bill Header Settings
        Route::get('/settings/bill-header', [BillHeaderController::class, 'index'])->name('admin.settings.bill-header');
        Route::post('/settings/bill-header', [BillHeaderController::class, 'store'])->name('admin.settings.bill-header.store');
        Route::put('/settings/bill-header/{billHeader}', [BillHeaderController::class, 'update'])->name('admin.settings.bill-header.update');
        Route::get('/settings/bill-header/active', [BillHeaderController::class, 'getActiveHeader'])->name('admin.settings.bill-header.active');
        
        // Test route to check bill header data
        Route::get('/test/bill-header', function() {
            $header = \App\Models\BillHeader::getActive();
            $logoExists = false;
            $logoPath = '';
            
            if ($header && $header->company_logo) {
                $logoPath = storage_path('app/public/' . $header->company_logo);
                $logoExists = file_exists($logoPath);
            }
            
            return response()->json([
                'header' => $header,
                'all_headers' => \App\Models\BillHeader::all(),
                'storage_url' => asset('storage'),
                'logo_url' => $header ? asset('storage/' . $header->company_logo) : null,
                'logo_exists' => $logoExists,
                'logo_path' => $logoPath,
                'public_storage_path' => public_path('storage')
            ]);
        })->name('admin.test.bill-header');
    });
});

require __DIR__.'/auth.php';
