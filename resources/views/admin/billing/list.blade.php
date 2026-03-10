<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Bills & Invoices</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">View and manage all customer bills and invoices.</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="createSampleBills()" class="inline-flex items-center px-4 py-2 border border-blue-300 dark:border-blue-600 rounded-lg shadow-sm text-sm font-medium text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create Sample Bills
                </button>
                <button onclick="showCreateBillModal()" class="inline-flex items-center px-4 py-2 border border-purple-300 dark:border-purple-600 rounded-lg shadow-sm text-sm font-medium text-purple-700 dark:text-purple-300 bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/40 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create Manual Bill
                </button>
                <button onclick="showPrintPreview()" class="inline-flex items-center px-4 py-2 border border-orange-300 dark:border-orange-600 rounded-lg shadow-sm text-sm font-medium text-orange-700 dark:text-orange-300 bg-orange-50 dark:bg-orange-900/20 hover:bg-orange-100 dark:hover:bg-orange-900/40 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Preview
                </button>
                <button onclick="exportBills()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export
                </button>
                <a href="{{ route('admin.billing.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Advanced Billing
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search Bills</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" id="searchInput" placeholder="Search by customer name, bill number..." 
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                </div>
            </div>
            
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                <select id="statusFilter" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                    <option value="">All Status</option>
                    <option value="paid">Paid</option>
                    <option value="pending">Pending</option>
                    <option value="overdue">Overdue</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            
            <!-- Date Range -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date Range</label>
                <select id="dateRange" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                    <option value="">All Time</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                    <option value="quarter">This Quarter</option>
                    <option value="year">This Year</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6" id="summaryCards">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Bills</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white" id="totalBills">0</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Amount</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white" id="totalAmount">Rs. 0.00</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Paid</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white" id="totalPaid">Rs. 0.00</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Due</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white" id="totalDue">Rs. 0.00</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bills Table -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Bills List</h3>
                <div class="flex items-center space-x-2">
                    <button onclick="refreshBills()" class="inline-flex items-center px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Refresh
                    </button>
                    <span class="text-sm text-gray-500 dark:text-gray-400" id="lastUpdated">
                        Last updated: <span id="lastUpdatedTime">Never</span>
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Loading State -->
        <div id="loadingState" class="hidden p-8 text-center">
            <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-gray-600 dark:text-gray-400">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Loading bills...
            </div>
        </div>

        <!-- Error State -->
        <div id="errorState" class="hidden p-8 text-center">
            <div class="text-red-600 dark:text-red-400">
                <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-lg font-medium mb-2">Error loading bills</p>
                <p class="text-sm" id="errorMessage">An error occurred while fetching the bills.</p>
                <button onclick="refreshBills()" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Try Again
                </button>
            </div>
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="hidden p-8 text-center">
            <div class="text-gray-500 dark:text-gray-400">
                <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-lg font-medium mb-2">No bills found</p>
                <p class="text-sm">No bills match your current search criteria.</p>
            </div>
        </div>
        
        <div class="overflow-x-auto" id="tableContainer">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Bill #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Due Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="billsTableBody">
                    <!-- Data will be loaded here dynamically -->
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6" id="paginationContainer">
            <div class="flex items-center justify-between">
                <div class="flex-1 flex justify-between sm:hidden">
                    <button onclick="changePage('prev')" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                        Previous
                    </button>
                    <button onclick="changePage('next')" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                        Next
                    </button>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700 dark:text-gray-300" id="paginationInfo">
                            Showing <span class="font-medium">0</span> to <span class="font-medium">0</span> of <span class="font-medium">0</span> results
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" id="paginationNav">
                            <!-- Pagination links will be generated here -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Bill Modal -->
    <div id="createBillModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Create New Bill</h3>
                    <button onclick="closeCreateBillModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <form id="createBillForm" class="space-y-4">
                    <!-- Customer Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Customer</label>
                        <select id="customerSelect" required class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Select Customer</option>
                        </select>
                    </div>

                    <!-- Due Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Due Date</label>
                        <input type="date" id="dueDate" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                    </div>

                    <!-- Items Section -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Items</label>
                        <div id="billItems" class="space-y-3">
                            <div class="bill-item flex space-x-3">
                                <div class="flex-1">
                                    <select class="product-select block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" required>
                                        <option value="">Select Product</option>
                                    </select>
                                </div>
                                <div class="w-24">
                                    <input type="number" class="quantity-input block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="Qty" min="1" required>
                                </div>
                                <div class="w-32">
                                    <input type="text" class="price-display block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-gray-50 dark:bg-gray-600 dark:text-white" placeholder="Price" readonly>
                                </div>
                                <div class="w-32">
                                    <input type="text" class="total-display block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-gray-50 dark:bg-gray-600 dark:text-white" placeholder="Total" readonly>
                                </div>
                                <button type="button" onclick="removeBillItem(this)" class="text-red-600 hover:text-red-800 dark:hover:text-red-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button type="button" onclick="addBillItem()" class="mt-2 inline-flex items-center px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Item
                        </button>
                    </div>

                    <!-- Total -->
                    <div class="border-t pt-4">
                        <div class="flex justify-between text-lg font-medium text-gray-900 dark:text-white">
                            <span>Total:</span>
                            <span id="billTotal">Rs. 0.00</span>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notes</label>
                        <textarea id="billNotes" rows="3" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="Optional notes..."></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeCreateBillModal()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                            Create Bill
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        let currentPage = 1;
        let lastPage = 1;
        let searchTerm = '';
        let statusFilter = '';
        let dateRange = '';
        let refreshInterval;

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            loadBills();
            setupEventListeners();
            startAutoRefresh();
        });

        function setupEventListeners() {
            // Search input with debouncing
            let searchTimeout;
            document.getElementById('searchInput').addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    searchTerm = this.value;
                    currentPage = 1;
                    loadBills();
                }, 500);
            });

            // Status filter
            document.getElementById('statusFilter').addEventListener('change', function() {
                statusFilter = this.value;
                currentPage = 1;
                loadBills();
            });

            // Date range filter
            document.getElementById('dateRange').addEventListener('change', function() {
                dateRange = this.value;
                currentPage = 1;
                loadBills();
            });
        }

        function startAutoRefresh() {
            // Refresh every 30 seconds
            refreshInterval = setInterval(() => {
                loadBills(false); // Don't show loading state for auto-refresh
            }, 30000);
        }

        function stopAutoRefresh() {
            if (refreshInterval) {
                clearInterval(refreshInterval);
            }
        }

        function loadBills(showLoading = true) {
            if (showLoading) {
                showLoadingState();
            }

            const params = new URLSearchParams({
                page: currentPage,
                search: searchTerm,
                status: statusFilter,
                dateRange: dateRange
            });

            fetch(`{{ route('admin.billing.api.bills') }}?${params}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayBills(data);
                        updateSummary(data.summary);
                        updatePagination(data.pagination);
                        updateLastUpdated();
                        hideLoadingState();
                    } else {
                        showError(data.error || 'Failed to load bills');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Network error occurred while loading bills');
                });
        }

        function displayBills(data) {
            const tbody = document.getElementById('billsTableBody');
            
            if (data.data.length === 0) {
                showEmptyState();
                return;
            }

            hideEmptyState();
            
            tbody.innerHTML = data.data.map(bill => `
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700" data-bill-id="${bill.id}" data-bill-number="${bill.bill_number}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">${bill.bill_number}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">${bill.order_number}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 dark:text-white">${bill.customer.name}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">${bill.customer.email}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        ${bill.date}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        ${bill.due_date}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">Rs. ${bill.amount}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Due: Rs. ${bill.due_amount}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${bill.status_class}">
                            ${bill.status}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            <button onclick="viewBill('${bill.bill_number}')" class="text-blue-600 hover:text-blue-900 dark:hover:text-blue-400 p-1 rounded hover:bg-blue-50 dark:hover:bg-blue-900/20" title="View Details">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                            <button onclick="printBill('${bill.bill_number}')" class="text-green-600 hover:text-green-900 dark:hover:text-green-400 p-1 rounded hover:bg-green-50 dark:hover:bg-green-900/20" title="Re-print">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                            </button>
                            <button onclick="deleteBill('${bill.bill_number}')" class="text-red-600 hover:text-red-900 dark:hover:text-red-400 p-1 rounded hover:bg-red-50 dark:hover:bg-red-900/20" title="Delete">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function updateSummary(summary) {
            document.getElementById('totalBills').textContent = summary.total_bills;
            document.getElementById('totalAmount').textContent = `Rs. ${summary.total_amount}`;
            document.getElementById('totalPaid').textContent = `Rs. ${summary.total_paid}`;
            document.getElementById('totalDue').textContent = `Rs. ${summary.total_due}`;
        }

        function updatePagination(pagination) {
            currentPage = pagination.current_page;
            lastPage = pagination.last_page;
            
            document.getElementById('paginationInfo').innerHTML = `
                Showing <span class="font-medium">${pagination.from || 0}</span> to <span class="font-medium">${pagination.to || 0}</span> of <span class="font-medium">${pagination.total}</span> results
            `;

            const nav = document.getElementById('paginationNav');
            nav.innerHTML = '';

            // Previous button
            if (pagination.current_page > 1) {
                nav.innerHTML += `
                    <button onclick="changePage(${pagination.current_page - 1})" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                `;
            }

            // Page numbers
            const start = Math.max(1, pagination.current_page - 2);
            const end = Math.min(pagination.last_page, pagination.current_page + 2);

            for (let i = start; i <= end; i++) {
                nav.innerHTML += `
                    <button onclick="changePage(${i})" class="relative inline-flex items-center px-4 py-2 border text-sm font-medium ${i === pagination.current_page ? 'z-10 bg-green-50 border-green-500 text-green-600 dark:bg-green-900 dark:border-green-400 dark:text-green-300' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700'}">
                        ${i}
                    </button>
                `;
            }

            // Next button
            if (pagination.current_page < pagination.last_page) {
                nav.innerHTML += `
                    <button onclick="changePage(${pagination.current_page + 1})" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                `;
            }
        }

        function changePage(page) {
            currentPage = page;
            loadBills();
        }

        function updateLastUpdated() {
            const now = new Date();
            document.getElementById('lastUpdatedTime').textContent = now.toLocaleTimeString();
        }

        function showLoadingState() {
            document.getElementById('loadingState').classList.remove('hidden');
            document.getElementById('tableContainer').classList.add('hidden');
            document.getElementById('errorState').classList.add('hidden');
            document.getElementById('emptyState').classList.add('hidden');
        }

        function hideLoadingState() {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('tableContainer').classList.remove('hidden');
        }

        function showError(message) {
            document.getElementById('errorMessage').textContent = message;
            document.getElementById('errorState').classList.remove('hidden');
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('tableContainer').classList.add('hidden');
            document.getElementById('emptyState').classList.add('hidden');
        }

        function showEmptyState() {
            document.getElementById('emptyState').classList.remove('hidden');
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('tableContainer').classList.add('hidden');
            document.getElementById('errorState').classList.add('hidden');
        }

        function hideEmptyState() {
            document.getElementById('emptyState').classList.add('hidden');
        }

        function refreshBills() {
            loadBills();
        }

        function getStatusClass(status) {
            switch(status.toLowerCase()) {
                case 'paid':
                    return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                case 'pending':
                    return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
                case 'overdue':
                    return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                case 'cancelled':
                    return 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
                default:
                    return 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
            }
        }

        function viewBill(billNumber) {
            // Find the bill ID from the table
            const billRow = document.querySelector(`tr[data-bill-number="${billNumber}"]`);
            const billId = billRow ? billRow.getAttribute('data-bill-id') : null;
            
            if (!billId) {
                Swal.fire('Error!', 'Bill not found.', 'error');
                return;
            }

            // Show loading state
            Swal.fire({
                title: 'Loading Bill Details...',
                text: 'Please wait while we fetch the bill information.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Fetch bill details
            fetch(`{{ route('admin.billing.api.view-bill', ['bill' => ':billId']) }}`.replace(':billId', billId), {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayBillDetails(data.data);
                } else {
                    throw new Error(data.error || 'Failed to load bill details');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Failed to load bill details. Please try again.', 'error');
            });
        }

        function displayBillDetails(bill) {
            const itemsHtml = bill.items.map(item => `
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <td class="py-2 px-4">${item.product_name}</td>
                    <td class="py-2 px-4 text-center">${item.quantity}</td>
                    <td class="py-2 px-4 text-right">Rs. ${item.unit_price}</td>
                    <td class="py-2 px-4 text-right">Rs. ${item.total_price}</td>
                </tr>
            `).join('');

            Swal.fire({
                title: `Bill ${bill.bill_number}`,
                html: `
                    <div class="text-left max-h-96 overflow-y-auto">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Customer Information</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Name:</strong> ${bill.customer.name}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Email:</strong> ${bill.customer.email}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Phone:</strong> ${bill.customer.phone}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Address:</strong> ${bill.customer.address}</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Bill Information</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Date:</strong> ${bill.date}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Due Date:</strong> ${bill.due_date}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Status:</strong> <span class="px-2 py-1 text-xs font-semibold rounded-full ${getStatusClass(bill.status)}">${bill.status}</span></p>
                                <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Payment Method:</strong> ${bill.payment_method || 'N/A'}</p>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Items</h4>
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="py-2 px-4 text-left">Product</th>
                                        <th class="py-2 px-4 text-center">Qty</th>
                                        <th class="py-2 px-4 text-right">Unit Price</th>
                                        <th class="py-2 px-4 text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${itemsHtml}
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="border-t pt-4">
                            <div class="flex justify-between text-sm mb-1">
                                <span>Subtotal:</span>
                                <span>Rs. ${bill.total_amount}</span>
                            </div>
                            <div class="flex justify-between text-sm mb-1">
                                <span>Tax:</span>
                                <span>Rs. ${bill.tax_amount}</span>
                            </div>
                            <div class="flex justify-between text-sm mb-1">
                                <span>Discount:</span>
                                <span>Rs. ${bill.discount_amount}</span>
                            </div>
                            <div class="flex justify-between text-sm mb-1">
                                <span>Paid Amount:</span>
                                <span>Rs. ${bill.paid_amount}</span>
                            </div>
                            <div class="flex justify-between text-sm mb-1">
                                <span>Due Amount:</span>
                                <span>Rs. ${bill.due_amount}</span>
                            </div>
                            <div class="flex justify-between font-semibold text-lg border-t pt-2">
                                <span>Final Amount:</span>
                                <span>Rs. ${bill.final_amount}</span>
                            </div>
                        </div>
                        
                        ${bill.notes ? `
                        <div class="mt-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Notes</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">${bill.notes}</p>
                        </div>
                        ` : ''}
                        
                        <div class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                            <p><strong>Created by:</strong> ${bill.created_by}</p>
                            <p><strong>Created at:</strong> ${bill.created_at}</p>
                        </div>
                    </div>
                `,
                width: '800px',
                confirmButtonText: 'Close',
                confirmButtonColor: '#10b981'
            });
        }

        function printBill(billNumber) {
            // Find the bill ID from the table
            const billRow = document.querySelector(`tr[data-bill-number="${billNumber}"]`);
            const billId = billRow ? billRow.getAttribute('data-bill-id') : null;
            
            if (!billId) {
                Swal.fire('Error!', 'Bill not found.', 'error');
                return;
            }

            // Show loading state
            Swal.fire({
                title: 'Generating Reprint...',
                text: 'Please wait while we prepare the bill for printing.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Fetch reprint data
            fetch(`{{ route('admin.billing.api.reprint-bill', ['bill' => ':billId']) }}`.replace(':billId', billId), {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    generateReprintBill(data.data);
                } else {
                    throw new Error(data.error || 'Failed to generate reprint');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Failed to generate reprint. Please try again.', 'error');
            });
        }

        function generateReprintBill(billData) {
            // Create a new window for printing
            const printWindow = window.open('', '_blank', 'width=800,height=600');
            
            const itemsHtml = billData.items.map(item => `
                <tr class="border-b border-gray-300">
                    <td class="py-2 px-4">${item.product_name}</td>
                    <td class="py-2 px-4 text-center">${item.quantity}</td>
                    <td class="py-2 px-4 text-right">Rs. ${item.unit_price}</td>
                    <td class="py-2 px-4 text-right">Rs. ${item.total_price}</td>
                </tr>
            `).join('');

            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Bill ${billData.bill_number} - Reprint</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
                        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
                        .reprint-label { background: #ff6b6b; color: white; padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: bold; margin-bottom: 10px; display: inline-block; }
                        .bill-info { display: flex; justify-content: space-between; margin-bottom: 30px; }
                        .customer-info, .bill-details { flex: 1; }
                        .customer-info { margin-right: 20px; }
                        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
                        th { background-color: #f8f9fa; font-weight: bold; }
                        .totals { border-top: 2px solid #333; padding-top: 20px; }
                        .total-row { display: flex; justify-content: space-between; margin-bottom: 5px; }
                        .final-total { font-size: 18px; font-weight: bold; border-top: 1px solid #333; padding-top: 10px; }
                        .footer { margin-top: 30px; text-align: center; font-size: 12px; color: #666; }
                        @media print {
                            body { margin: 0; }
                            .no-print { display: none; }
                        }
                    </style>
                </head>
                <body>
                    <div class="header">
                        ${billData.bill_header ? `
                            <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                                ${billData.bill_header.company_logo ? 
                                    `<img src="/storage/${billData.bill_header.company_logo}" alt="Company Logo" style="height: 60px; width: auto; margin-right: 20px;" onerror="this.style.display='none';">` 
                                    : ''
                                }
                                <div style="text-align: center;">
                                    <h1>${billData.bill_header.company_name}</h1>
                                    <p>${billData.bill_header.company_address}</p>
                                    <p>Phone: ${billData.bill_header.company_phone} | Email: ${billData.bill_header.company_email}</p>
                                </div>
                            </div>
                        ` : '<h1>Company Name</h1>'}
                        <div class="reprint-label">RE-PRINT</div>
                        <h2>Bill ${billData.bill_number}</h2>
                    </div>
                    
                    <div class="bill-info">
                        <div class="customer-info">
                            <h3>Customer Information</h3>
                            <p><strong>Name:</strong> ${billData.customer.name}</p>
                            <p><strong>Email:</strong> ${billData.customer.email}</p>
                            <p><strong>Phone:</strong> ${billData.customer.phone}</p>
                            <p><strong>Address:</strong> ${billData.customer.address}</p>
                        </div>
                        <div class="bill-details">
                            <h3>Bill Information</h3>
                            <p><strong>Date:</strong> ${billData.date}</p>
                            <p><strong>Due Date:</strong> ${billData.due_date}</p>
                            <p><strong>Status:</strong> ${billData.status}</p>
                            <p><strong>Payment Method:</strong> ${billData.payment_method || 'N/A'}</p>
                            <p><strong>Reprint Date:</strong> ${billData.reprint_date}</p>
                        </div>
                    </div>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${itemsHtml}
                        </tbody>
                    </table>
                    
                    <div class="totals">
                        <div class="total-row">
                            <span>Subtotal:</span>
                            <span>Rs. ${billData.total_amount}</span>
                        </div>
                        <div class="total-row">
                            <span>Tax:</span>
                            <span>Rs. ${billData.tax_amount}</span>
                        </div>
                        <div class="total-row">
                            <span>Discount:</span>
                            <span>Rs. ${billData.discount_amount}</span>
                        </div>
                        <div class="total-row">
                            <span>Paid Amount:</span>
                            <span>Rs. ${billData.paid_amount}</span>
                        </div>
                        <div class="total-row">
                            <span>Due Amount:</span>
                            <span>Rs. ${billData.due_amount}</span>
                        </div>
                        <div class="total-row final-total">
                            <span>Final Amount:</span>
                            <span>Rs. ${billData.final_amount}</span>
                        </div>
                    </div>
                    
                    ${billData.notes ? `
                    <div style="margin-top: 20px;">
                        <h3>Notes</h3>
                        <p>${billData.notes}</p>
                    </div>
                    ` : ''}
                    
                    <div class="footer">
                        <p>Created by: ${billData.created_by} | Created: ${billData.created_at}</p>
                        <p>Reprint generated on: ${billData.reprint_date}</p>
                        ${billData.bill_header && billData.bill_header.footer_text ? `<p>${billData.bill_header.footer_text}</p>` : ''}
                    </div>
                    
                    <div class="no-print" style="margin-top: 20px; text-align: center;">
                        <button onclick="window.print()" style="padding: 10px 20px; background: #10b981; color: white; border: none; border-radius: 5px; cursor: pointer;">Print</button>
                        <button onclick="window.close()" style="padding: 10px 20px; background: #6b7280; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">Close</button>
                    </div>
                </body>
                </html>
            `);
            
            printWindow.document.close();
            
            // Close the loading dialog
            Swal.close();
        }

        function deleteBill(billNumber) {
            // Find the bill ID from the table
            const billRow = document.querySelector(`tr[data-bill-number="${billNumber}"]`);
            const billId = billRow ? billRow.getAttribute('data-bill-id') : null;
            
            if (!billId) {
                Swal.fire('Error!', 'Bill not found.', 'error');
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: `You want to delete bill ${billNumber}? This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Deleting Bill...',
                        text: 'Please wait while we delete the bill.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Send delete request
                    fetch(`{{ route('admin.billing.api.delete-bill', ['bill' => ':billId']) }}`.replace(':billId', billId), {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', 'Bill has been deleted successfully.', 'success');
                            // Refresh the bills list
                            loadBills();
                        } else {
                            throw new Error(data.error || 'Failed to delete bill');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'Failed to delete bill. Please try again.', 'error');
                    });
                }
            });
        }

        function showPrintPreview() {
            // Get current filters
            const currentFilters = {
                search: searchTerm,
                status: statusFilter,
                dateRange: dateRange
            };

            // Build print preview URL with current filters
            const params = new URLSearchParams({
                ...currentFilters,
                title: 'Bills Report',
                include_summary: '1',
                include_details: '1',
                type: 'preview'
            });
            
            const printPreviewUrl = `{{ route('admin.billing.export') }}?${params}`;
            
            // Open print preview in new tab
            window.open(printPreviewUrl, '_blank');
        }

        function exportBills() {
            // Get current filters
            const currentFilters = {
                search: searchTerm,
                status: statusFilter,
                dateRange: dateRange
            };

            // Show export options modal
            Swal.fire({
                title: 'Export Bills Report',
                html: `
                    <div class="text-left space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Report Title</label>
                            <input type="text" id="reportTitle" value="Bills Summary Report" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Export Options</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" id="includeSummary" checked class="mr-2">
                                    <span class="text-sm">Include Executive Summary</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" id="includeDetails" checked class="mr-2">
                                    <span class="text-sm">Include Detailed Bills List</span>
                                </label>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Export Format</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="exportType" value="preview" checked class="mr-2">
                                    <span class="text-sm">Print Preview (New Tab)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="exportType" value="pdf" class="mr-2">
                                    <span class="text-sm">Download PDF</span>
                                </label>
                            </div>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Export',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                width: '500px',
                preConfirm: () => {
                    const reportTitle = document.getElementById('reportTitle').value;
                    const includeSummary = document.getElementById('includeSummary').checked;
                    const includeDetails = document.getElementById('includeDetails').checked;
                    const exportType = document.querySelector('input[name="exportType"]:checked').value;
                    
                    if (!reportTitle.trim()) {
                        Swal.showValidationMessage('Report title is required');
                        return false;
                    }
                    
                    if (!includeSummary && !includeDetails) {
                        Swal.showValidationMessage('Please select at least one section to include');
                        return false;
                    }
                    
                    return {
                        reportTitle,
                        includeSummary,
                        includeDetails,
                        exportType
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const { reportTitle, includeSummary, includeDetails, exportType } = result.value;
                    
                    // Build export URL with parameters
                    const params = new URLSearchParams({
                        ...currentFilters,
                        title: reportTitle,
                        include_summary: includeSummary,
                        include_details: includeDetails,
                        type: exportType
                    });
                    
                    const exportUrl = `{{ route('admin.billing.export') }}?${params}`;
                    
                    if (exportType === 'preview') {
                        // Open print preview in new tab
                        window.open(exportUrl, '_blank');
                        Swal.fire({
                            title: 'Print Preview Opened',
                            text: 'The print preview has been opened in a new tab.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        // Download PDF
                        Swal.fire({
                            title: 'Generating PDF',
                            text: 'Please wait while we generate your PDF report...',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        // Create a temporary link to trigger download
                        const link = document.createElement('a');
                        link.href = exportUrl;
                        link.download = `bills_report_${new Date().toISOString().slice(0, 10)}.pdf`;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        
                        setTimeout(() => {
                            Swal.fire({
                                title: 'PDF Generated',
                                text: 'Your PDF report has been downloaded successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        }, 2000);
                    }
                }
            });
        }

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            stopAutoRefresh();
        });

        // Create Sample Bills Function
        function createSampleBills() {
            Swal.fire({
                title: 'Create Sample Bills?',
                text: 'This will create 10 sample bills with random data for testing purposes and show a print preview.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, create them!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Creating Sample Bills',
                        text: 'Please wait while we create the sample bills...',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch('{{ route("admin.billing.api.create-sample-bills") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: data.message + ' Opening print preview...',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                loadBills(); // Refresh the bills list
                                
                                // Open print preview in new tab
                                const printPreviewUrl = '{{ route("admin.billing.export") }}?title=Sample Bills Report&include_summary=1&include_details=1&type=preview&dateRange=all';
                                window.open(printPreviewUrl, '_blank');
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.error,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to create sample bills. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
                }
            });
        }

        // Create Bill Modal Functions
        function showCreateBillModal() {
            document.getElementById('createBillModal').classList.remove('hidden');
            loadCustomers();
            loadProducts();
            setDefaultDueDate();
        }

        function closeCreateBillModal() {
            document.getElementById('createBillModal').classList.add('hidden');
            document.getElementById('createBillForm').reset();
            document.getElementById('billItems').innerHTML = `
                <div class="bill-item flex space-x-3">
                    <div class="flex-1">
                        <select class="product-select block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" required>
                            <option value="">Select Product</option>
                        </select>
                    </div>
                    <div class="w-24">
                        <input type="number" class="quantity-input block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="Qty" min="1" required>
                    </div>
                    <div class="w-32">
                        <input type="text" class="price-display block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-gray-50 dark:bg-gray-600 dark:text-white" placeholder="Price" readonly>
                    </div>
                    <div class="w-32">
                        <input type="text" class="total-display block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-gray-50 dark:bg-gray-600 dark:text-white" placeholder="Total" readonly>
                    </div>
                    <button type="button" onclick="removeBillItem(this)" class="text-red-600 hover:text-red-800 dark:hover:text-red-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            `;
            document.getElementById('billTotal').textContent = 'Rs. 0.00';
        }

        function loadCustomers() {
            fetch('{{ route("admin.billing.customers") }}')
                .then(response => response.json())
                .then(customers => {
                    const select = document.getElementById('customerSelect');
                    select.innerHTML = '<option value="">Select Customer</option>';
                    customers.forEach(customer => {
                        select.innerHTML += `<option value="${customer.id}">${customer.name} (${customer.email})</option>`;
                    });
                })
                .catch(error => console.error('Error loading customers:', error));
        }

        function loadProducts() {
            fetch('{{ route("admin.billing.products") }}')
                .then(response => response.json())
                .then(products => {
                    const selects = document.querySelectorAll('.product-select');
                    selects.forEach(select => {
                        select.innerHTML = '<option value="">Select Product</option>';
                        products.forEach(product => {
                            select.innerHTML += `<option value="${product.id}" data-price="${product.price}">${product.name} - Rs. ${product.price}</option>`;
                        });
                    });
                })
                .catch(error => console.error('Error loading products:', error));
        }

        function setDefaultDueDate() {
            const today = new Date();
            const dueDate = new Date(today.getTime() + (30 * 24 * 60 * 60 * 1000)); // 30 days from now
            document.getElementById('dueDate').value = dueDate.toISOString().split('T')[0];
        }

        function addBillItem() {
            const itemsContainer = document.getElementById('billItems');
            const newItem = document.createElement('div');
            newItem.className = 'bill-item flex space-x-3';
            newItem.innerHTML = `
                <div class="flex-1">
                    <select class="product-select block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" required>
                        <option value="">Select Product</option>
                    </select>
                </div>
                <div class="w-24">
                    <input type="number" class="quantity-input block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="Qty" min="1" required>
                </div>
                <div class="w-32">
                    <input type="text" class="price-display block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-gray-50 dark:bg-gray-600 dark:text-white" placeholder="Price" readonly>
                </div>
                <div class="w-32">
                    <input type="text" class="total-display block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-gray-50 dark:bg-gray-600 dark:text-white" placeholder="Total" readonly>
                </div>
                <button type="button" onclick="removeBillItem(this)" class="text-red-600 hover:text-red-800 dark:hover:text-red-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            `;
            itemsContainer.appendChild(newItem);
            loadProducts(); // Reload products for the new select
        }

        function removeBillItem(button) {
            const items = document.querySelectorAll('.bill-item');
            if (items.length > 1) {
                button.closest('.bill-item').remove();
                calculateBillTotal();
            }
        }

        // Event listeners for bill creation
        document.addEventListener('DOMContentLoaded', function() {
            // Product selection change
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('product-select')) {
                    const item = e.target.closest('.bill-item');
                    const option = e.target.options[e.target.selectedIndex];
                    const price = option.dataset.price || 0;
                    item.querySelector('.price-display').value = `Rs. ${price}`;
                    calculateItemTotal(item);
                }
            });

            // Quantity change
            document.addEventListener('input', function(e) {
                if (e.target.classList.contains('quantity-input')) {
                    calculateItemTotal(e.target.closest('.bill-item'));
                }
            });

            // Form submission
            document.getElementById('createBillForm').addEventListener('submit', function(e) {
                e.preventDefault();
                submitBill();
            });
        });

        function calculateItemTotal(item) {
            const quantity = item.querySelector('.quantity-input').value || 0;
            const priceText = item.querySelector('.price-display').value;
            const price = parseFloat(priceText.replace('Rs. ', '')) || 0;
            const total = quantity * price;
            item.querySelector('.total-display').value = `Rs. ${total.toFixed(2)}`;
            calculateBillTotal();
        }

        function calculateBillTotal() {
            const totals = document.querySelectorAll('.total-display');
            let grandTotal = 0;
            totals.forEach(total => {
                const value = parseFloat(total.value.replace('Rs. ', '')) || 0;
                grandTotal += value;
            });
            document.getElementById('billTotal').textContent = `Rs. ${grandTotal.toFixed(2)}`;
        }

        function submitBill() {
            const formData = {
                customer_id: document.getElementById('customerSelect').value,
                due_date: document.getElementById('dueDate').value,
                notes: document.getElementById('billNotes').value,
                items: []
            };

            // Collect items
            const items = document.querySelectorAll('.bill-item');
            items.forEach(item => {
                const productId = item.querySelector('.product-select').value;
                const quantity = item.querySelector('.quantity-input').value;
                if (productId && quantity) {
                    formData.items.push({
                        product_id: productId,
                        quantity: parseInt(quantity)
                    });
                }
            });

            if (formData.items.length === 0) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please add at least one item to the bill.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            Swal.fire({
                title: 'Creating Bill',
                text: 'Please wait while we create your bill...',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('{{ route("admin.billing.api.create-bill") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        closeCreateBillModal();
                        loadBills(); // Refresh the bills list
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.error,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to create bill. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        }
    </script>
</x-admin-layout>
