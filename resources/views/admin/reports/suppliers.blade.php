<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Supplier Report</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Supplier performance and inventory analysis</p>
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
                        <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Suppliers</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">45</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

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
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Purchases</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">Rs. 12,45,670.00</dd>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Products Supplied</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">156</dd>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Active Suppliers</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white">38</dd>
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
            
            <!-- Supplier Category -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Supplier Category</label>
                <select id="categoryFilter" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                    <option value="">All Categories</option>
                    <option value="dog-food">Dog Food Suppliers</option>
                    <option value="cat-food">Cat Food Suppliers</option>
                    <option value="bird-food">Bird Food Suppliers</option>
                    <option value="fish-food">Fish Food Suppliers</option>
                </select>
            </div>
            
            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                <select id="statusFilter" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
            
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
                <input type="text" id="searchInput" placeholder="Search by name, company..." 
                       class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
            </div>
        </div>
    </div>

    <!-- Suppliers Table -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Supplier Details</h3>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Showing 1-10 of 45 suppliers
                    </span>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Supplier</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Products</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Purchases</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Last Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-green-500 flex items-center justify-center">
                                        <span class="text-sm font-medium text-white">PF</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Premium Foods Ltd</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Premium Supplier</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">premium@foods.com</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">+91 98765 43210</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">Dog Food</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            25 products
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">Rs. 2,45,750.00</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Dec 15, 2024
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                Active
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button onclick="viewSupplier('SUP-001')" class="text-blue-600 hover:text-blue-900 dark:hover:text-blue-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                        <span class="text-sm font-medium text-white">CF</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Cat Food Express</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Standard Supplier</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">info@catfood.com</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">+91 87654 32109</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">Cat Food</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            18 products
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">Rs. 1,23,400.00</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Dec 16, 2024
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                Active
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button onclick="viewSupplier('SUP-002')" class="text-blue-600 hover:text-blue-900 dark:hover:text-blue-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-purple-500 flex items-center justify-center">
                                        <span class="text-sm font-medium text-white">BF</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Bird Feed Co</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Specialty Supplier</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">contact@birdfeed.com</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">+91 76543 21098</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">Bird Food</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            12 products
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">Rs. 67,890.00</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Dec 17, 2024
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                Pending
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button onclick="viewSupplier('SUP-003')" class="text-blue-600 hover:text-blue-900 dark:hover:text-blue-400">
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
                            Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">45</span> suppliers
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
                    <h3 class="text-xl font-bold text-gray-900">Print Preview - Supplier Report</h3>
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
                        <h2 class="text-2xl font-semibold text-gray-700 mb-2">Supplier Report</h2>
                        <p class="text-gray-600" id="reportDateRange">Report Period: This Month</p>
                        <p class="text-gray-600" id="reportGeneratedDate">Generated on: {{ date('F d, Y \a\t g:i A') }}</p>
                    </div>

                    <!-- Summary Statistics -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900" id="printTotalSuppliers">45</div>
                            <div class="text-sm text-gray-600">Total Suppliers</div>
                        </div>
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900" id="printTotalPurchases">Rs. 12,45,670.00</div>
                            <div class="text-sm text-gray-600">Total Purchases</div>
                        </div>
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900" id="printProductsSupplied">156</div>
                            <div class="text-sm text-gray-600">Products Supplied</div>
                        </div>
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900" id="printActiveSuppliers">38</div>
                            <div class="text-sm text-gray-600">Active Suppliers</div>
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

                    <!-- Suppliers Table -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Supplier Details</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-900">Supplier</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-900">Contact</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-900">Category</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-900">Products</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-900">Total Purchases</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-900">Last Order</th>
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
        const sampleSupplierData = [
            {
                supplier: 'Premium Foods Ltd',
                type: 'Premium Supplier',
                email: 'premium@foods.com',
                phone: '+91 98765 43210',
                category: 'Dog Food',
                products: '25 products',
                totalPurchases: 'Rs. 2,45,750.00',
                lastOrder: 'Dec 15, 2024',
                status: 'Active'
            },
            {
                supplier: 'Cat Food Express',
                type: 'Standard Supplier',
                email: 'info@catfood.com',
                phone: '+91 87654 32109',
                category: 'Cat Food',
                products: '18 products',
                totalPurchases: 'Rs. 1,23,400.00',
                lastOrder: 'Dec 16, 2024',
                status: 'Active'
            },
            {
                supplier: 'Bird Feed Co',
                type: 'Specialty Supplier',
                email: 'contact@birdfeed.com',
                phone: '+91 76543 21098',
                category: 'Bird Food',
                products: '12 products',
                totalPurchases: 'Rs. 67,890.00',
                lastOrder: 'Dec 17, 2024',
                status: 'Pending'
            }
        ];

        function viewSupplier(supplierId) {
            Swal.fire({
                title: `Supplier ${supplierId}`,
                text: 'Supplier details will be displayed here when database is integrated.',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }

        function exportReport() {
            Swal.fire({
                title: 'Export Supplier Report',
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
                    <title>Supplier Report - Animal Food System</title>
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
            let filteredData = filterSupplierData(sampleSupplierData, currentFilters);

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

        function filterSupplierData(data, filters) {
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
                    const searchableText = `${item.supplier} ${item.email} ${item.phone} ${item.category}`.toLowerCase();
                    if (!searchableText.includes(searchTerm)) {
                        return false;
                    }
                }
                
                return true;
            });
        }

        function updatePrintSummaryStats(data) {
            // Calculate summary statistics from filtered data
            const totalSuppliers = data.length;
            const totalPurchases = data.reduce((sum, item) => {
                const amount = parseFloat(item.totalPurchases.replace('Rs. ', '').replace(',', ''));
                return sum + amount;
            }, 0);
            
            const totalProducts = data.reduce((sum, item) => {
                const products = parseInt(item.products.split(' ')[0]);
                return sum + products;
            }, 0);
            
            const activeSuppliers = data.filter(item => item.status === 'Active').length;

            // Update summary display
            document.getElementById('printTotalSuppliers').textContent = totalSuppliers.toLocaleString();
            document.getElementById('printTotalPurchases').textContent = `Rs. ${totalPurchases.toLocaleString('en-IN', {minimumFractionDigits: 2})}`;
            document.getElementById('printProductsSupplied').textContent = totalProducts.toLocaleString();
            document.getElementById('printActiveSuppliers').textContent = activeSuppliers.toLocaleString();
        }

        function updatePrintTableBody(data) {
            const tableBody = document.getElementById('printTableBody');
            tableBody.innerHTML = '';

            if (data.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="border border-gray-300 px-4 py-4 text-center text-gray-500">
                            No supplier data found for the selected filters.
                        </td>
                    </tr>
                `;
                return;
            }

            data.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="border border-gray-300 px-4 py-2 text-sm">
                        <div>${item.supplier}</div>
                        <div class="text-gray-500 text-xs">${item.type}</div>
                    </td>
                    <td class="border border-gray-300 px-4 py-2 text-sm">
                        <div>${item.email}</div>
                        <div class="text-gray-500 text-xs">${item.phone}</div>
                    </td>
                    <td class="border border-gray-300 px-4 py-2 text-sm">${item.category}</td>
                    <td class="border border-gray-300 px-4 py-2 text-sm">${item.products}</td>
                    <td class="border border-gray-300 px-4 py-2 text-sm font-medium">${item.totalPurchases}</td>
                    <td class="border border-gray-300 px-4 py-2 text-sm">${item.lastOrder}</td>
                    <td class="border border-gray-300 px-4 py-2 text-sm">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${
                            item.status === 'Active' ? 'bg-green-100 text-green-800' :
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
