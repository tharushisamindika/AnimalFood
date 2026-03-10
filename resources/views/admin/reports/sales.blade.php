<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Sales Report</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Comprehensive sales analysis and reporting</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="exportReport()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export Report
                </button>
                <button onclick="printReport()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Report
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Sales</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">Rs. 2,45,750.00</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Orders</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">1,247</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Unique Customers</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">342</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Average Order Value</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">Rs. 1,975.00</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Date Range -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date Range</label>
                <select id="dateRange" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                    <option value="all">All Time</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month" selected>This Month</option>
                    <option value="quarter">This Quarter</option>
                    <option value="year">This Year</option>
                </select>
            </div>
            
            <!-- Product Category -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Category</label>
                <select id="categoryFilter" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                    <option value="">All Categories</option>
                    <option value="dog-food">Dog Food</option>
                    <option value="cat-food">Cat Food</option>
                    <option value="bird-food">Bird Food</option>
                    <option value="fish-food">Fish Food</option>
                </select>
            </div>
            
            <!-- Sales Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sales Status</label>
                <select id="statusFilter" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                    <option value="">All Status</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
                <input type="text" id="searchInput" placeholder="Search by product, customer..." 
                       class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
            </div>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Sales Details</h3>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Showing 1-10 of 1,247 results
                    </span>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">#ORD-001</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">John Smith</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">john@example.com</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">Premium Dog Food</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Dog Food</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            5 kg
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">Rs. 2,500.00</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Dec 15, 2024
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                Completed
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button onclick="viewSale('ORD-001')" class="text-blue-600 hover:text-blue-900 dark:hover:text-blue-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">#ORD-002</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">Sarah Johnson</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">sarah@example.com</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">Cat Food Deluxe</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Cat Food</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            3 kg
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">Rs. 1,800.00</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Dec 16, 2024
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                Pending
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button onclick="viewSale('ORD-002')" class="text-blue-600 hover:text-blue-900 dark:hover:text-blue-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">#ORD-003</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">Mike Wilson</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">mike@example.com</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">Bird Seed Mix</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Bird Food</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            2 kg
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">Rs. 950.00</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Dec 17, 2024
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                Completed
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button onclick="viewSale('ORD-003')" class="text-blue-600 hover:text-blue-900 dark:hover:text-blue-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
            <div class="flex items-center justify-between">
                <div class="flex-1 flex justify-between sm:hidden">
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Previous
                    </a>
                    <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Next
                    </a>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">1,247</span> results
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                Previous
                            </a>
                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">1</a>
                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">2</a>
                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">3</a>
                            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                Next
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Preview Modal -->
    <div id="printPreviewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-5 mx-auto p-5 border w-11/12 max-w-6xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Print Preview - Sales Report</h3>
                    <div class="flex space-x-2">
                        <button onclick="closePrintPreview()" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Close
                        </button>
                        <button onclick="printCurrentReport()" class="px-4 py-2 bg-green-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Print Report
                        </button>
                    </div>
                </div>

                <!-- Print Preview Content -->
                <div id="printPreviewContent" class="bg-white p-8 border border-gray-200 rounded-lg">
                    <!-- Report Header -->
                    <div class="text-center mb-8 border-b border-gray-300 pb-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Animal Food System</h1>
                        <h2 class="text-2xl font-semibold text-gray-700 mb-2">Sales Report</h2>
                        <p class="text-gray-600" id="reportDateRange">Report Period: This Month</p>
                        <p class="text-gray-600" id="reportGeneratedDate">Generated on: {{ date('F d, Y \a\t g:i A') }}</p>
                    </div>

                    <!-- Summary Statistics -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900" id="printTotalSales">Rs. 2,45,750.00</div>
                            <div class="text-sm text-gray-600">Total Sales</div>
                        </div>
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900" id="printTotalOrders">1,247</div>
                            <div class="text-sm text-gray-600">Total Orders</div>
                        </div>
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900" id="printUniqueCustomers">342</div>
                            <div class="text-sm text-gray-600">Unique Customers</div>
                        </div>
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900" id="printAvgOrderValue">Rs. 1,975.00</div>
                            <div class="text-sm text-gray-600">Average Order Value</div>
                        </div>
                    </div>

                    <!-- Applied Filters -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Applied Filters</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-gray-700">Date Range:</span>
                                <span id="printDateRange" class="text-gray-600">This Month</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Category:</span>
                                <span id="printCategoryFilter" class="text-gray-600">All Categories</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Status:</span>
                                <span id="printStatusFilter" class="text-gray-600">All Status</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Search:</span>
                                <span id="printSearchFilter" class="text-gray-600">All</span>
                            </div>
                        </div>
                    </div>

                    <!-- Sales Table -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Sales Details</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-900">Order ID</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-900">Customer</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-900">Product</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-900">Quantity</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-900">Amount</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-900">Date</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-900">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="printTableBody">
                                    <!-- Table rows will be populated dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Report Footer -->
                    <div class="mt-8 pt-6 border-t border-gray-300 text-center text-sm text-gray-600">
                        <p>This report was generated by the Animal Food System</p>
                        <p>For any queries, please contact the system administrator</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Global variables to store current filter values
        let currentFilters = {
            dateRange: 'month',
            category: '',
            status: '',
            search: ''
        };

        // Sample data - in real implementation, this would come from the database
        const sampleSalesData = [
            {
                orderId: 'ORD-001',
                customer: 'John Smith',
                email: 'john@example.com',
                product: 'Premium Dog Food',
                category: 'Dog Food',
                quantity: '5 kg',
                amount: 'Rs. 2,500.00',
                date: 'Dec 15, 2024',
                status: 'Completed'
            },
            {
                orderId: 'ORD-002',
                customer: 'Sarah Johnson',
                email: 'sarah@example.com',
                product: 'Cat Food Deluxe',
                category: 'Cat Food',
                quantity: '3 kg',
                amount: 'Rs. 1,800.00',
                date: 'Dec 16, 2024',
                status: 'Pending'
            },
            {
                orderId: 'ORD-003',
                customer: 'Mike Wilson',
                email: 'mike@example.com',
                product: 'Bird Seed Mix',
                category: 'Bird Food',
                quantity: '2 kg',
                amount: 'Rs. 950.00',
                date: 'Dec 17, 2024',
                status: 'Completed'
            }
        ];

        function viewSale(orderId) {
            Swal.fire({
                title: `Order ${orderId}`,
                text: 'Order details will be displayed here when database is integrated.',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }

        function exportReport() {
            Swal.fire({
                title: 'Export Sales Report',
                text: 'Report export functionality will be implemented when database is integrated.',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }

        function printReport() {
            // Get current filter values
            currentFilters.dateRange = document.getElementById('dateRange').value;
            currentFilters.category = document.getElementById('categoryFilter').value;
            currentFilters.status = document.getElementById('statusFilter').value;
            currentFilters.search = document.getElementById('searchInput').value;

            // Update print preview with current data
            updatePrintPreview();
            
            // Show print preview modal
            document.getElementById('printPreviewModal').classList.remove('hidden');
        }

        function closePrintPreview() {
            document.getElementById('printPreviewModal').classList.add('hidden');
        }

        function printCurrentReport() {
            // Create a new window for printing
            const printWindow = window.open('', '_blank');
            const printContent = document.getElementById('printPreviewContent').innerHTML;
            
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Sales Report - Animal Food System</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        table { border-collapse: collapse; width: 100%; margin: 20px 0; }
                        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                        th { background-color: #f2f2f2; font-weight: bold; }
                        .summary-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin: 20px 0; }
                        .summary-item { text-align: center; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
                        .summary-value { font-size: 24px; font-weight: bold; }
                        .summary-label { font-size: 14px; color: #666; }
                        .filters { background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin: 20px 0; }
                        .filters-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
                        .filter-item { font-size: 14px; }
                        .filter-label { font-weight: bold; }
                        @media print {
                            .no-print { display: none; }
                        }
                    </style>
                </head>
                <body>
                    ${printContent}
                </body>
                </html>
            `);
            
            printWindow.document.close();
            printWindow.focus();
            
            // Wait for content to load, then print
            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 500);
        }

        function updatePrintPreview() {
            // Update report header with current date range
            const dateRangeText = getDateRangeText(currentFilters.dateRange);
            document.getElementById('reportDateRange').textContent = `Report Period: ${dateRangeText}`;
            document.getElementById('reportGeneratedDate').textContent = `Generated on: ${new Date().toLocaleString()}`;

            // Update filter display
            document.getElementById('printDateRange').textContent = dateRangeText;
            document.getElementById('printCategoryFilter').textContent = currentFilters.category || 'All Categories';
            document.getElementById('printStatusFilter').textContent = currentFilters.status || 'All Status';
            document.getElementById('printSearchFilter').textContent = currentFilters.search || 'All';

            // Filter data based on current filters
            let filteredData = filterSalesData(sampleSalesData, currentFilters);

            // Update summary statistics
            updatePrintSummaryStats(filteredData);

            // Update table body
            updatePrintTableBody(filteredData);
        }

        function getDateRangeText(dateRange) {
            const dateRangeMap = {
                'all': 'All Time',
                'today': 'Today',
                'week': 'This Week',
                'month': 'This Month',
                'quarter': 'This Quarter',
                'year': 'This Year'
            };
            return dateRangeMap[dateRange] || 'This Month';
        }

        function filterSalesData(data, filters) {
            return data.filter(item => {
                // Category filter
                if (filters.category && item.category !== filters.category) {
                    return false;
                }
                
                // Status filter
                if (filters.status && item.status !== filters.status) {
                    return false;
                }
                
                // Search filter
                if (filters.search) {
                    const searchTerm = filters.search.toLowerCase();
                    const searchableText = `${item.customer} ${item.email} ${item.product} ${item.category}`.toLowerCase();
                    if (!searchableText.includes(searchTerm)) {
                        return false;
                    }
                }
                
                return true;
            });
        }

        function updatePrintSummaryStats(data) {
            // Calculate summary statistics from filtered data
            const totalSales = data.reduce((sum, item) => {
                const amount = parseFloat(item.amount.replace('Rs. ', '').replace(',', ''));
                return sum + amount;
            }, 0);
            
            const totalOrders = data.length;
            const uniqueCustomers = new Set(data.map(item => item.customer)).size;
            const avgOrderValue = totalOrders > 0 ? totalSales / totalOrders : 0;

            // Update summary display
            document.getElementById('printTotalSales').textContent = `Rs. ${totalSales.toLocaleString('en-IN', {minimumFractionDigits: 2})}`;
            document.getElementById('printTotalOrders').textContent = totalOrders.toLocaleString();
            document.getElementById('printUniqueCustomers').textContent = uniqueCustomers.toLocaleString();
            document.getElementById('printAvgOrderValue').textContent = `Rs. ${avgOrderValue.toLocaleString('en-IN', {minimumFractionDigits: 2})}`;
        }

        function updatePrintTableBody(data) {
            const tableBody = document.getElementById('printTableBody');
            tableBody.innerHTML = '';

            if (data.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="border border-gray-300 px-4 py-4 text-center text-gray-500">
                            No sales data found for the selected filters.
                        </td>
                    </tr>
                `;
                return;
            }

            data.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="border border-gray-300 px-4 py-2 text-sm">${item.orderId}</td>
                    <td class="border border-gray-300 px-4 py-2 text-sm">
                        <div>${item.customer}</div>
                        <div class="text-gray-500 text-xs">${item.email}</div>
                    </td>
                    <td class="border border-gray-300 px-4 py-2 text-sm">
                        <div>${item.product}</div>
                        <div class="text-gray-500 text-xs">${item.category}</div>
                    </td>
                    <td class="border border-gray-300 px-4 py-2 text-sm">${item.quantity}</td>
                    <td class="border border-gray-300 px-4 py-2 text-sm font-medium">${item.amount}</td>
                    <td class="border border-gray-300 px-4 py-2 text-sm">${item.date}</td>
                    <td class="border border-gray-300 px-4 py-2 text-sm">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${
                            item.status === 'Completed' ? 'bg-green-100 text-green-800' :
                            item.status === 'Pending' ? 'bg-yellow-100 text-yellow-800' :
                            'bg-red-100 text-red-800'
                        }">
                            ${item.status}
                        </span>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Filter functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            currentFilters.search = e.target.value;
            console.log('Searching for:', e.target.value);
        });

        document.getElementById('dateRange').addEventListener('change', function(e) {
            currentFilters.dateRange = e.target.value;
            console.log('Date range changed to:', e.target.value);
        });

        document.getElementById('categoryFilter').addEventListener('change', function(e) {
            currentFilters.category = e.target.value;
            console.log('Category filter changed to:', e.target.value);
        });

        document.getElementById('statusFilter').addEventListener('change', function(e) {
            currentFilters.status = e.target.value;
            console.log('Status filter changed to:', e.target.value);
        });

        // Close modal when clicking outside
        document.getElementById('printPreviewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePrintPreview();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePrintPreview();
            }
        });
    </script>
</x-admin-layout> 