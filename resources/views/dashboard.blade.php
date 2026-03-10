<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent dark:from-green-400 dark:to-emerald-400">Dashboard</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Welcome back! Here's what's happening with your animal food business today.</p>
            </div>
            <div id="dashboard-status" class="flex items-center space-x-3 bg-white dark:bg-gray-800 px-4 py-2 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div id="status-indicator" class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                <span id="status-text" class="text-sm font-medium text-gray-700 dark:text-gray-200">Live</span>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <!-- Today's Sales -->
        <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden card-shadow rounded-xl border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-600 dark:text-gray-300 truncate">Today's Sales</dt>
                            <dd class="text-xl font-bold text-gray-900 dark:text-white" id="today-sales">Rs. 0.00</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 px-6 py-4">
                <div class="text-sm">
                    <span class="text-green-700 dark:text-green-300 font-semibold" id="sales-target-progress">0%</span>
                    <span class="text-gray-600 dark:text-gray-400">of daily target</span>
                </div>
            </div>
        </div>

        <!-- Today's Refunds -->
        <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden card-shadow rounded-xl border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-600 dark:text-gray-300 truncate">Today's Refunds</dt>
                            <dd class="text-xl font-bold text-gray-900 dark:text-white" id="today-refunds">Rs. 0.00</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 px-6 py-4">
                <div class="text-sm">
                    <span class="text-red-700 dark:text-red-300 font-semibold" id="net-sales">Rs. 0.00</span>
                    <span class="text-gray-600 dark:text-gray-400">net sales</span>
                </div>
            </div>
        </div>

        <!-- Products in Stock -->
        <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden card-shadow rounded-xl border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-600 dark:text-gray-300 truncate">Products in Stock</dt>
                            <dd class="text-xl font-bold text-gray-900 dark:text-white" id="productsInStock">0</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 px-6 py-4">
                <div class="text-sm">
                    <span class="text-amber-700 dark:text-amber-300 font-semibold" id="productsInStockChange">0</span>
                    <span class="text-gray-600 dark:text-gray-400">products in stock</span>
                </div>
            </div>
        </div>

        <!-- Low Stock Items -->
        <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden card-shadow rounded-xl border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-br from-rose-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-600 dark:text-gray-300 truncate">Low Stock Items</dt>
                            <dd class="text-xl font-bold text-gray-900 dark:text-white" id="lowStockCount">0</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-rose-50 to-red-50 dark:from-rose-900/20 dark:to-red-900/20 px-6 py-4">
                <div class="text-sm">
                    <span class="text-rose-700 dark:text-rose-300 font-semibold" id="lowStockChange">0</span>
                    <span class="text-gray-600 dark:text-gray-400">items need attention</span>
                </div>
            </div>
        </div>

        <!-- Monthly Revenue -->
        <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-600 dark:text-gray-300 truncate">Monthly Revenue</dt>
                            <dd class="text-xl font-bold text-gray-900 dark:text-white" id="monthlyRevenue">Rs. 0.00</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-teal-50 to-cyan-50 dark:from-teal-900/20 dark:to-cyan-900/20 px-6 py-4">
                <div class="text-sm">
                    <span class="text-teal-700 dark:text-teal-300 font-semibold" id="revenueGrowth">+0%</span>
                    <span class="text-gray-600 dark:text-gray-400">from last month</span>
                </div>
            </div>
        </div>
    </div>



    <!-- Sales Charts Section -->
    <div class="mb-8">
        <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent dark:from-green-400 dark:to-emerald-400">Sales Analytics</h3>
                    <div class="flex space-x-3">
                        <button id="daily-btn" class="px-4 py-2 text-sm font-semibold text-green-700 bg-green-100 rounded-lg hover:bg-green-200 dark:bg-green-900/30 dark:text-green-300 dark:hover:bg-green-900/50 transition-all duration-200 shadow-sm">Daily</button>
                        <button id="weekly-btn" class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 transition-all duration-200 shadow-sm">Weekly</button>
                        <button id="monthly-btn" class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 transition-all duration-200 shadow-sm">Monthly</button>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Line Chart -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                            </svg>
                            Sales Trend
                        </h4>
                        <div class="relative" style="height: 280px;">
                            <canvas id="salesTrendChart"></canvas>
                        </div>
                    </div>
                    
                    <!-- Bar Chart -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Top Products
                        </h4>
                        <div class="relative" style="height: 280px;">
                            <canvas id="topProductsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Orders -->
        <div class="lg:col-span-2">
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 rounded-t-2xl">
                    <h3 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent dark:from-blue-400 dark:to-indigo-400 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Recent Orders
                    </h3>
                </div>
                <div class="overflow-hidden">
                    <div class="flow-root">
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            <li class="px-4 py-3">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">Premium Dog Food - 25kg</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Order #12345 - John Smith</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Delivered
                                        </span>
                                    </div>
                                    <div class="flex-shrink-0 text-sm text-gray-500 dark:text-gray-400">
                                        Rs. 89.99
                                    </div>
                                </div>
                            </li>
                            <li class="px-4 py-3">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">Cat Food Mix - 15kg</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Order #12346 - Sarah Johnson</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            Processing
                                        </span>
                                    </div>
                                    <div class="flex-shrink-0 text-sm text-gray-500 dark:text-gray-400">
                                        Rs. 67.50
                                    </div>
                                </div>
                            </li>
                            <li class="px-4 py-3">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">Bird Seed Mix - 5kg</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Order #12347 - Mike Wilson</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            Pending
                                        </span>
                                    </div>
                                    <div class="flex-shrink-0 text-sm text-gray-500 dark:text-gray-400">
                                        Rs. 34.99
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-green-600 dark:text-green-400 hover:text-green-500">View all orders</a>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Recent Activity -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 rounded-t-2xl">
                    <h3 class="text-xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent dark:from-purple-400 dark:to-pink-400 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Quick Actions
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <a href="{{ route('admin.products.create') }}" class="flex items-center p-4 text-sm font-semibold text-gray-700 dark:text-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl hover:from-green-100 hover:to-emerald-100 dark:hover:from-green-900/30 dark:hover:to-emerald-900/30 transition-all duration-200 border border-green-200 dark:border-green-800 hover:border-green-300 dark:hover:border-green-700 shadow-sm hover:shadow-md">
                        <svg class="w-6 h-6 mr-3 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add New Product
                    </a>
                    <a href="{{ route('admin.orders.create') }}" class="flex items-center p-4 text-sm font-semibold text-gray-700 dark:text-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl hover:from-blue-100 hover:to-indigo-100 dark:hover:from-blue-900/30 dark:hover:to-indigo-900/30 transition-all duration-200 border border-blue-200 dark:border-blue-800 hover:border-blue-300 dark:hover:border-blue-700 shadow-sm hover:shadow-md">
                        <svg class="w-6 h-6 mr-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Create Order
                    </a>
                    <a href="{{ route('admin.billing.index') }}" class="flex items-center p-4 text-sm font-semibold text-gray-700 dark:text-gray-200 bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20 rounded-xl hover:from-orange-100 hover:to-amber-100 dark:hover:from-orange-900/30 dark:hover:to-amber-900/30 transition-all duration-200 border border-orange-200 dark:border-orange-800 hover:border-orange-300 dark:hover:border-orange-700 shadow-sm hover:shadow-md">
                        <svg class="w-6 h-6 mr-3 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Create Bill
                    </a>
                    <a href="{{ route('admin.customers.create') }}" class="flex items-center p-4 text-sm font-semibold text-gray-700 dark:text-gray-200 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl hover:from-purple-100 hover:to-pink-100 dark:hover:from-purple-900/30 dark:hover:to-pink-900/30 transition-all duration-200 border border-purple-200 dark:border-purple-800 hover:border-purple-300 dark:hover:border-purple-700 shadow-sm hover:shadow-md">
                        <svg class="w-6 h-6 mr-3 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        Add New Customer
                    </a>
                    <a href="{{ route('admin.inventory.dashboard') }}" class="flex items-center p-4 text-sm font-semibold text-gray-700 dark:text-gray-200 bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-amber-900/20 dark:to-yellow-900/20 rounded-xl hover:from-amber-100 hover:to-yellow-100 dark:hover:from-amber-900/30 dark:hover:to-yellow-900/30 transition-all duration-200 border border-amber-200 dark:border-amber-800 hover:border-amber-300 dark:hover:border-amber-700 shadow-sm hover:shadow-md">
                        <svg class="w-6 h-6 mr-3 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Inventory Management
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="flex items-center p-4 text-sm font-semibold text-gray-700 dark:text-gray-200 bg-gradient-to-r from-indigo-50 to-cyan-50 dark:from-indigo-900/20 dark:to-cyan-900/20 rounded-xl hover:from-indigo-100 hover:to-cyan-100 dark:hover:from-indigo-900/30 dark:hover:to-cyan-900/30 transition-all duration-200 border border-indigo-200 dark:border-indigo-800 hover:border-indigo-300 dark:hover:border-indigo-700 shadow-sm hover:shadow-md">
                        <svg class="w-6 h-6 mr-3 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        View Reports
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 rounded-t-2xl">
                    <h3 class="text-xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent dark:from-teal-400 dark:to-cyan-400 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Recent Activity
                    </h3>
                </div>
                <div class="p-6">
                    <div class="flow-root">
                        <ul class="-mb-8" id="recent-activity-list">
                            <!-- Loading state -->
                            <li class="text-center py-4">
                                <div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Loading recent activity...</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.audit-logs.index') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500">View all activities</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section - Popular Products -->
    <div class="mt-8">
        <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 rounded-t-2xl">
                <h3 class="text-xl font-bold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent dark:from-rose-400 dark:to-pink-400 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    Popular Products
                </h3>
            </div>
            <div class="overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-6">
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl p-4 border border-green-200 dark:border-green-800 hover:shadow-lg transition-all duration-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Premium Dog Food</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-300">25kg bags</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-900 dark:text-white">156 sold</p>
                                <p class="text-sm text-green-600 dark:text-green-400 font-semibold">+12%</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-4 border border-blue-200 dark:border-blue-800 hover:shadow-lg transition-all duration-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Cat Food Mix</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-300">15kg bags</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-900 dark:text-white">89 sold</p>
                                <p class="text-sm text-blue-600 dark:text-blue-400 font-semibold">+8%</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl p-4 border border-purple-200 dark:border-purple-800 hover:shadow-lg transition-all duration-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Bird Seed Mix</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-300">5kg bags</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-900 dark:text-white">67 sold</p>
                                <p class="text-sm text-purple-600 dark:text-purple-400 font-semibold">+15%</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-xl p-4 border border-amber-200 dark:border-amber-800 hover:shadow-lg transition-all duration-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Fish Food</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-300">500g containers</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-900 dark:text-white">45 sold</p>
                                <p class="text-sm text-amber-600 dark:text-amber-400 font-semibold">+5%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Chart instances
        let salesTrendChart = null;
        let topProductsChart = null;
        let currentTimeframe = 'daily';
        let refreshInterval = null;

        // Fetch dashboard data on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadDashboardData();
            loadRecentActivity();
            initializeCharts();
            setupChartButtons();
            
            // Start real-time updates
            startRealTimeUpdates();
        });

        function startRealTimeUpdates() {
            // Clear any existing interval
            if (refreshInterval) {
                clearInterval(refreshInterval);
            }
            
            // Refresh data every 30 seconds for real-time updates
            refreshInterval = setInterval(function() {
                loadDashboardData();
                loadRecentActivity();
            }, 30000); // 30 seconds
        }

        function loadDashboardData() {
            console.log('Loading dashboard data...');
            
            // Show loading state
            showLoadingState();
            
            // Fetch all dashboard data from single endpoint
            fetch('{{ route("admin.dashboard.stats") }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                cache: 'no-cache'
            })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Dashboard data received:', data);
                    console.log('Total Products value:', data.total_products);
                    console.log('Active Products value:', data.active_products);
                    
                    // Update sales statistics
                    updateElement('today-sales', 'Rs. ' + parseFloat(data.today_sales || 0).toFixed(2));
                    updateElement('today-refunds', 'Rs. ' + parseFloat(data.today_refunds || 0).toFixed(2));
                    updateElement('net-sales', 'Rs. ' + parseFloat(data.today_net || 0).toFixed(2));
                    updateElement('sales-target-progress', parseFloat(data.target_progress || 0).toFixed(1) + '%');
                    
                    // Update product statistics
                    updateElement('totalProducts', data.total_products || 0);
                    updateElement('activeProducts', data.active_products || 0);
                    updateElement('lowStockCount', data.low_stock_count || 0);
                    updateElement('lowStockChange', data.low_stock_count || 0);
                    updateElement('expiringCount', data.expiring_count || 0);
                    updateElement('expiringChange', data.expiring_count || 0);
                    
                    // Update products in stock
                    updateElement('productsInStock', data.products_in_stock || 0);
                    updateElement('productsInStockChange', data.products_in_stock || 0);
                    
                    // Update customer statistics
                    updateElement('totalCustomers', data.total_customers || 0);
                    updateElement('activeCustomers', data.active_customers || 0);
                    
                    // Update order statistics
                    updateElement('totalOrders', data.total_orders || 0);
                    updateElement('pendingOrders', data.pending_orders || 0);
                    
                    // Update revenue statistics
                    updateElement('monthlyRevenue', 'Rs. ' + parseFloat(data.monthly_revenue || 0).toFixed(2));
                    const growthSign = data.revenue_growth >= 0 ? '+' : '';
                    updateElement('revenueGrowth', growthSign + parseFloat(data.revenue_growth || 0).toFixed(1) + '%');
                    
                    // Update recent orders
                    updateRecentOrders(data.recent_orders || []);
                    
                    // Update popular products
                    updatePopularProducts(data.popular_products || []);
                    
                    // Hide loading state
                    hideLoadingState();
                    
                    // Update last refresh time
                    updateLastRefreshTime();
                })
                .catch(error => {
                    console.error('Error loading dashboard data:', error);
                    console.error('Error details:', error.message);
                    hideLoadingState();
                    updateStatusIndicator('error');
                    showErrorMessage('Failed to load dashboard data. Please refresh the page.');
                });
        }

        function updateElement(elementId, value) {
            const element = document.getElementById(elementId);
            if (element) {
                // Add a subtle animation for value changes
                element.style.transition = 'all 0.3s ease';
                element.style.transform = 'scale(1.05)';
                element.textContent = value;
                
                setTimeout(() => {
                    element.style.transform = 'scale(1)';
                }, 300);
            }
        }

        function showLoadingState() {
            // Add loading indicator to dashboard cards
            const cards = document.querySelectorAll('.bg-white.dark\\:bg-gray-800');
            cards.forEach(card => {
                card.style.opacity = '0.7';
            });
            
            // Update status indicator
            updateStatusIndicator('loading');
        }

        function hideLoadingState() {
            // Remove loading indicator
            const cards = document.querySelectorAll('.bg-white.dark\\:bg-gray-800');
            cards.forEach(card => {
                card.style.opacity = '1';
            });
            
            // Update status indicator
            updateStatusIndicator('live');
        }

        function updateStatusIndicator(status) {
            const indicator = document.getElementById('status-indicator');
            const statusText = document.getElementById('status-text');
            
            if (indicator && statusText) {
                switch (status) {
                    case 'loading':
                        indicator.className = 'w-3 h-3 bg-amber-500 rounded-full animate-pulse';
                        statusText.textContent = 'Updating...';
                        statusText.className = 'text-sm font-medium text-amber-600 dark:text-amber-400';
                        break;
                    case 'error':
                        indicator.className = 'w-3 h-3 bg-rose-500 rounded-full';
                        statusText.textContent = 'Error';
                        statusText.className = 'text-sm font-medium text-rose-600 dark:text-rose-400';
                        break;
                    case 'live':
                    default:
                        indicator.className = 'w-3 h-3 bg-emerald-500 rounded-full animate-pulse';
                        statusText.textContent = 'Live';
                        statusText.className = 'text-sm font-medium text-emerald-600 dark:text-emerald-400';
                        break;
                }
            }
        }

        function showErrorMessage(message) {
            // Create or update error message
            let errorDiv = document.getElementById('dashboard-error');
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.id = 'dashboard-error';
                errorDiv.className = 'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50';
                document.body.appendChild(errorDiv);
            }
            errorDiv.textContent = message;
            
            // Auto-hide after 5 seconds
            setTimeout(() => {
                if (errorDiv.parentNode) {
                    errorDiv.parentNode.removeChild(errorDiv);
                }
            }, 5000);
        }

        function updateLastRefreshTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString();
            
            // Update or create last refresh indicator
            let refreshIndicator = document.getElementById('last-refresh');
            if (!refreshIndicator) {
                refreshIndicator = document.createElement('div');
                refreshIndicator.id = 'last-refresh';
                refreshIndicator.className = 'fixed bottom-4 right-4 bg-gray-800 text-white px-3 py-1 rounded text-xs z-40';
                document.body.appendChild(refreshIndicator);
            }
            refreshIndicator.textContent = `Last updated: ${timeString}`;
        }

        function updateRecentOrders(orders) {
            const ordersContainer = document.querySelector('.flow-root ul');
            if (!ordersContainer) return;
            
            let ordersHtml = '';
            orders.forEach(order => {
                const statusClass = order.status === 'completed' ? 'bg-green-100 text-green-800' : 
                                  order.status === 'processing' ? 'bg-blue-100 text-blue-800' : 
                                  'bg-yellow-100 text-yellow-800';
                
                ordersHtml += `
                    <li class="px-4 py-3">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">${order.items?.[0]?.product?.name || 'Product'}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Order #${order.id} - ${order.customer?.name || 'Customer'}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusClass}">
                                    ${order.status}
                                </span>
                            </div>
                            <div class="flex-shrink-0 text-sm text-gray-500 dark:text-gray-400">
                                Rs. ${parseFloat(order.total_amount || 0).toFixed(2)}
                            </div>
                        </div>
                    </li>
                `;
            });
            
            ordersContainer.innerHTML = ordersHtml;
        }

        function updatePopularProducts(products) {
            const productsContainer = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-4');
            if (!productsContainer) return;
            
            let productsHtml = '';
            products.forEach(product => {
                productsHtml += `
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">${product.name}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">${product.total_sold} sold</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">${product.total_sold}</p>
                                <p class="text-sm text-green-600 dark:text-green-400">+12%</p>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            productsContainer.innerHTML = productsHtml;
        }

        function loadRecentActivity() {
            console.log('Loading recent activity...');
            fetch('{{ route("admin.dashboard.recent-activity") }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                cache: 'no-cache'
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Recent activity data received:', data);
                    updateRecentActivity(data);
                })
                .catch(error => {
                    console.error('Error loading recent activity:', error);
                    const activityList = document.getElementById('recent-activity-list');
                    if (activityList) {
                        activityList.innerHTML = `
                            <li class="text-center py-4 text-red-600">
                                <svg class="mx-auto h-8 w-8 text-red-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <p class="text-sm">Failed to load recent activity</p>
                                <p class="text-xs text-gray-500 mt-1">${error.message}</p>
                            </li>
                        `;
                    }
                });
        }

        function updateRecentActivity(activities) {
            const activityList = document.getElementById('recent-activity-list');
            if (!activityList) return;
            
            if (activities.length === 0) {
                activityList.innerHTML = `
                    <li class="text-center py-4 text-gray-500 dark:text-gray-400">
                        <p class="text-sm">No recent activity</p>
                    </li>
                `;
                return;
            }
            
            let activitiesHtml = '';
            activities.forEach((activity, index) => {
                const isLast = index === activities.length - 1;
                const colorClass = `bg-${activity.color}-500`;
                
                activitiesHtml += `
                    <li>
                        <div class="relative ${isLast ? '' : 'pb-8'}">
                            ${!isLast ? '<span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>' : ''}
                            <div class="relative flex space-x-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full ${colorClass} flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${activity.icon}"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">${activity.description}</p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500">by ${activity.user_name}</p>
                                    </div>
                                    <div class="text-right text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                        <time>${activity.time_ago}</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                `;
            });
            
            activityList.innerHTML = activitiesHtml;
        }

        function setupChartButtons() {
            document.getElementById('daily-btn').addEventListener('click', () => switchTimeframe('daily'));
            document.getElementById('weekly-btn').addEventListener('click', () => switchTimeframe('weekly'));
            document.getElementById('monthly-btn').addEventListener('click', () => switchTimeframe('monthly'));
        }

        function switchTimeframe(timeframe) {
            currentTimeframe = timeframe;
            
            // Update button styles
            document.querySelectorAll('#daily-btn, #weekly-btn, #monthly-btn').forEach(btn => {
                btn.classList.remove('text-green-700', 'bg-green-100', 'dark:bg-green-900/30', 'dark:text-green-300');
                btn.classList.add('text-gray-600', 'bg-gray-100', 'dark:bg-gray-700', 'dark:text-gray-300');
            });
            
            document.getElementById(timeframe + '-btn').classList.remove('text-gray-600', 'bg-gray-100', 'dark:bg-gray-700', 'dark:text-gray-300');
            document.getElementById(timeframe + '-btn').classList.add('text-green-700', 'bg-green-100', 'dark:bg-green-900/30', 'dark:text-green-300');
            
            // Update charts
            updateSalesTrendChart();
        }

        function initializeCharts() {
            // Initialize sales trend chart
            const salesTrendCtx = document.getElementById('salesTrendChart').getContext('2d');
            salesTrendChart = new Chart(salesTrendCtx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Sales',
                        data: [],
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Refunds',
                        data: [],
                        borderColor: 'rgb(239, 68, 68)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Net Sales',
                        data: [],
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: document.documentElement.classList.contains('dark') ? '#f3f4f6' : '#374151'
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: document.documentElement.classList.contains('dark') ? '#f3f4f6' : '#374151'
                            },
                            grid: {
                                color: document.documentElement.classList.contains('dark') ? '#374151' : '#e5e7eb'
                            }
                        },
                        y: {
                            ticks: {
                                color: document.documentElement.classList.contains('dark') ? '#f3f4f6' : '#374151',
                                callback: function(value) {
                                    return 'Rs. ' + value.toLocaleString();
                                }
                            },
                            grid: {
                                color: document.documentElement.classList.contains('dark') ? '#374151' : '#e5e7eb'
                            }
                        }
                    }
                }
            });

            // Initialize top products chart
            const topProductsCtx = document.getElementById('topProductsChart').getContext('2d');
            topProductsChart = new Chart(topProductsCtx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Sales Amount',
                        data: [],
                        backgroundColor: [
                            'rgba(34, 197, 94, 0.8)',
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(168, 85, 247, 0.8)',
                            'rgba(245, 158, 11, 0.8)',
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(249, 115, 22, 0.8)',
                            'rgba(139, 92, 246, 0.8)',
                            'rgba(236, 72, 153, 0.8)',
                            'rgba(6, 182, 212, 0.8)'
                        ],
                        borderColor: [
                            'rgb(34, 197, 94)',
                            'rgb(59, 130, 246)',
                            'rgb(168, 85, 247)',
                            'rgb(245, 158, 11)',
                            'rgb(239, 68, 68)',
                            'rgb(16, 185, 129)',
                            'rgb(249, 115, 22)',
                            'rgb(139, 92, 246)',
                            'rgb(236, 72, 153)',
                            'rgb(6, 182, 212)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: document.documentElement.classList.contains('dark') ? '#f3f4f6' : '#374151',
                                maxRotation: 45,
                                minRotation: 45
                            },
                            grid: {
                                color: document.documentElement.classList.contains('dark') ? '#374151' : '#e5e7eb'
                            }
                        },
                        y: {
                            ticks: {
                                color: document.documentElement.classList.contains('dark') ? '#f3f4f6' : '#374151',
                                callback: function(value) {
                                    return 'Rs. ' + value.toLocaleString();
                                }
                            },
                            grid: {
                                color: document.documentElement.classList.contains('dark') ? '#374151' : '#e5e7eb'
                            }
                        }
                    }
                }
            });

            // Load initial chart data
            updateSalesTrendChart();
            updateTopProductsChart();
        }

        function updateSalesTrendChart() {
            fetch(`{{ route("admin.dashboard.charts", "daily") }}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                cache: 'no-cache'
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    const labels = data.map(item => currentTimeframe === 'daily' ? item.date : (currentTimeframe === 'weekly' ? item.week : item.month));
                    const salesData = data.map(item => item.sales);
                    const refundsData = data.map(item => item.refunds);
                    const netData = data.map(item => item.net);

                    salesTrendChart.data.labels = labels;
                    salesTrendChart.data.datasets[0].data = salesData;
                    salesTrendChart.data.datasets[1].data = refundsData;
                    salesTrendChart.data.datasets[2].data = netData;
                    salesTrendChart.update('none'); // Use 'none' for better performance
                })
                .catch(error => {
                    console.error('Error loading chart data:', error);
                    // Show error in chart area
                    const chartContainer = document.getElementById('salesTrendChart').parentElement;
                    if (chartContainer) {
                        chartContainer.innerHTML = `
                            <div class="flex items-center justify-center h-full text-red-600">
                                <div class="text-center">
                                    <svg class="mx-auto h-8 w-8 text-red-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <p class="text-sm">Failed to load chart data</p>
                                </div>
                            </div>
                        `;
                    }
                });
        }

        function updateTopProductsChart() {
            fetch('{{ route("admin.sales.charts.products") }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                cache: 'no-cache'
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    const labels = data.map(item => item.product);
                    const salesData = data.map(item => item.sales);

                    topProductsChart.data.labels = labels;
                    topProductsChart.data.datasets[0].data = salesData;
                    topProductsChart.update('none'); // Use 'none' for better performance
                })
                .catch(error => {
                    console.error('Error loading products chart data:', error);
                    // Show error in chart area
                    const chartContainer = document.getElementById('topProductsChart').parentElement;
                    if (chartContainer) {
                        chartContainer.innerHTML = `
                            <div class="flex items-center justify-center h-full text-red-600">
                                <div class="text-center">
                                    <svg class="mx-auto h-8 w-8 text-red-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <p class="text-sm">Failed to load chart data</p>
                                </div>
                            </div>
                        `;
                    }
                });
        }

        // Add manual refresh button functionality
        function addManualRefreshButton() {
            const header = document.querySelector('.mb-4');
            if (header && !document.getElementById('manual-refresh-btn')) {
                const refreshButton = document.createElement('button');
                refreshButton.id = 'manual-refresh-btn';
                refreshButton.className = 'ml-4 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center';
                refreshButton.innerHTML = `
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Refresh Data
                `;
                
                refreshButton.addEventListener('click', function() {
                    this.disabled = true;
                    this.innerHTML = `
                        <svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Refreshing...
                    `;
                    
                    // Refresh all data
                    Promise.all([
                        loadDashboardData(),
                        loadRecentActivity(),
                        updateSalesTrendChart(),
                        updateTopProductsChart()
                    ]).finally(() => {
                        setTimeout(() => {
                            this.disabled = false;
                            this.innerHTML = `
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Refresh Data
                            `;
                        }, 1000);
                    });
                });
                
                header.appendChild(refreshButton);
            }
        }

        // Initialize manual refresh button
        addManualRefreshButton();
        
        // Cleanup function for when page is unloaded
        window.addEventListener('beforeunload', function() {
            if (refreshInterval) {
                clearInterval(refreshInterval);
            }
        });
    </script>
</x-admin-layout>
