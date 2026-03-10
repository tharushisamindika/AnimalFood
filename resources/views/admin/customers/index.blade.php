<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Customers Management</h1>
                <p class="mt-1 sm:mt-2 text-sm text-gray-600 dark:text-gray-400">Manage customer information and relationships.</p>
            </div>
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                <button onclick="exportCustomers()" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export
                </button>
                <button onclick="openAddModal()" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Customer
                </button>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 sm:p-6 mb-4 sm:mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <!-- Search -->
            <div class="sm:col-span-2 lg:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">Search Customers</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" id="searchInput" placeholder="Search by name, email, phone, city..." 
                           class="block w-full pl-8 sm:pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                </div>
            </div>
            
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">Status</label>
                <select id="statusFilter" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="pending">Pending</option>
                </select>
            </div>

            <!-- Customer Type Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">Customer Type</label>
                <select id="customerTypeFilter" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                    <option value="">All Types</option>
                    <option value="individual">Individual</option>
                    <option value="shop">Shop</option>
                    <option value="institute">Institute</option>
                    <option value="company">Company</option>
                </select>
            </div>
            
                            <!-- Sort -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">Sort By</label>
                    <select id="sortBy" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                        <option value="created_at">Date Created</option>
                        <option value="name">Name</option>
                        <option value="email">Email</option>
                        <option value="city">City</option>
                    </select>
                </div>
                
                <!-- Clear Filters Button -->
                <div class="flex items-end">
                    <button onclick="clearFilters()" class="w-full px-3 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium transition-colors duration-200">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear Filters
                    </button>
                </div>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0">
                <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-white">Customers List</h3>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400" id="customerCount">
                        {{ $customers->total() }} customers
                    </span>
                    @if(auth()->user()->role !== 'cashier')
                    <button onclick="bulkDelete()" id="bulkDeleteBtn" class="hidden inline-flex items-center px-2 sm:px-3 py-1 border border-red-300 text-red-700 text-sm rounded-md hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <span class="hidden sm:inline">Delete Selected</span>
                        <span class="sm:hidden">Delete</span>
                    </button>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Desktop Table View -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        @if(auth()->user()->role !== 'cashier')
                        <th class="w-8 px-2 py-3 text-left">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        </th>
                        @endif
                        <th class="w-48 px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                        <th class="w-40 px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Contact</th>
                        <th class="w-32 px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                        <th class="w-36 px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Location</th>
                        <th class="w-20 px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="w-16 px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Orders</th>
                        <th class="w-28 px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created</th>
                        <th class="w-24 px-3 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="customersTableBody">
                    @foreach($customers as $customer)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        @if(auth()->user()->role !== 'cashier')
                        <td class="w-8 px-2 py-3">
                            <input type="checkbox" class="customer-checkbox rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50" value="{{ $customer->id }}">
                        </td>
                        @endif
                        <td class="w-48 px-3 py-3">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <div class="h-8 w-8 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                                        <span class="text-xs font-medium text-green-800 dark:text-green-200">
                                            {{ strtoupper(substr($customer->name, 0, 2)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-3 min-w-0 flex-1">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $customer->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 truncate">ID: {{ $customer->customer_id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="w-40 px-3 py-3">
                            <div class="text-sm text-gray-900 dark:text-white truncate">{{ $customer->email }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $customer->phone }}</div>
                        </td>
                        <td class="w-32 px-3 py-3">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                @if($customer->customer_type === 'individual') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                @elseif($customer->customer_type === 'shop') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($customer->customer_type === 'institute') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                {{ ucfirst($customer->customer_type ?? 'individual') }}
                            </span>
                            @if($customer->company_name)
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate">{{ $customer->company_name }}</div>
                            @endif
                        </td>
                        <td class="w-36 px-3 py-3">
                            <div class="text-sm text-gray-900 dark:text-white truncate">{{ $customer->city }}, {{ $customer->state }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $customer->postal_code }}</div>
                        </td>
                        <td class="w-20 px-3 py-3">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                @if($customer->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($customer->status === 'inactive') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                {{ ucfirst($customer->status ?? 'active') }}
                            </span>
                        </td>
                        <td class="w-16 px-3 py-3 text-sm text-gray-900 dark:text-white">
                            {{ $customer->orders->count() }}
                        </td>
                        <td class="w-28 px-3 py-3 text-xs text-gray-500 dark:text-gray-400">
                            {{ $customer->created_at->format('M d, Y') }}
                        </td>
                        <td class="w-24 px-3 py-3 text-right text-sm font-medium">
                            <div class="flex justify-end space-x-1 action-buttons">
                                <button onclick="viewCustomer({{ $customer->id }})" class="text-blue-600 hover:text-blue-900 dark:hover:text-blue-400 p-1 rounded hover:bg-blue-50 dark:hover:bg-blue-900/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <button onclick="editCustomer({{ $customer->id }})" class="text-green-600 hover:text-green-900 dark:hover:text-green-400 p-1 rounded hover:bg-green-50 dark:hover:bg-green-900/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                @if(auth()->user()->role !== 'cashier')
                                <button onclick="deleteCustomer({{ $customer->id }})" class="text-red-600 hover:text-red-900 dark:hover:text-red-400 p-1 rounded hover:bg-red-50 dark:hover:bg-red-900/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Tablet Table View (Medium screens) -->
        <div class="hidden md:block lg:hidden overflow-x-auto">
            <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        @if(auth()->user()->role !== 'cashier')
                        <th class="w-8 px-2 py-3 text-left">
                            <input type="checkbox" id="selectAllTablet" class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        </th>
                        @endif
                        <th class="w-40 px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                        <th class="w-32 px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Contact</th>
                        <th class="w-24 px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                        <th class="w-20 px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="w-16 px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Orders</th>
                        <th class="w-24 px-3 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="customersTableBodyTablet">
                    @foreach($customers as $customer)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        @if(auth()->user()->role !== 'cashier')
                        <td class="w-8 px-2 py-3">
                            <input type="checkbox" class="customer-checkbox-tablet rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50" value="{{ $customer->id }}">
                        </td>
                        @endif
                        <td class="w-40 px-3 py-3">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <div class="h-8 w-8 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                                        <span class="text-xs font-medium text-green-800 dark:text-green-200">
                                            {{ strtoupper(substr($customer->name, 0, 2)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-3 min-w-0 flex-1">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $customer->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $customer->city }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="w-32 px-3 py-3">
                            <div class="text-sm text-gray-900 dark:text-white truncate">{{ $customer->email }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $customer->phone }}</div>
                        </td>
                        <td class="w-24 px-3 py-3">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                @if($customer->customer_type === 'individual') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                @elseif($customer->customer_type === 'shop') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($customer->customer_type === 'institute') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                {{ ucfirst($customer->customer_type ?? 'individual') }}
                            </span>
                        </td>
                        <td class="w-20 px-3 py-3">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                @if($customer->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($customer->status === 'inactive') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                {{ ucfirst($customer->status ?? 'active') }}
                            </span>
                        </td>
                        <td class="w-16 px-3 py-3 text-sm text-gray-900 dark:text-white">
                            {{ $customer->orders->count() }}
                        </td>
                        <td class="w-24 px-3 py-3 text-right text-sm font-medium">
                            <div class="flex justify-end space-x-1 action-buttons">
                                <button onclick="viewCustomer({{ $customer->id }})" class="text-blue-600 hover:text-blue-900 dark:hover:text-blue-400 p-1 rounded hover:bg-blue-50 dark:hover:bg-blue-900/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <button onclick="editCustomer({{ $customer->id }})" class="text-green-600 hover:text-green-900 dark:hover:text-green-400 p-1 rounded hover:bg-green-50 dark:hover:bg-green-900/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                @if(auth()->user()->role !== 'cashier')
                                <button onclick="deleteCustomer({{ $customer->id }})" class="text-red-600 hover:text-red-900 dark:hover:text-red-400 p-1 rounded hover:bg-red-50 dark:hover:bg-red-900/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden space-y-3 p-3 sm:p-4">
            @foreach($customers as $customer)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 p-3 sm:p-4">
                <!-- Header with checkbox and actions -->
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center space-x-2 sm:space-x-3 flex-1 min-w-0">
                        @if(auth()->user()->role !== 'cashier')
                        <input type="checkbox" class="customer-checkbox rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 flex-shrink-0" value="{{ $customer->id }}">
                        @endif
                        <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center flex-shrink-0">
                            <span class="text-xs sm:text-sm font-medium text-green-800 dark:text-green-200">
                                {{ strtoupper(substr($customer->name, 0, 2)) }}
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-white truncate">{{ $customer->name }}</h3>
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">ID: {{ $customer->customer_id }}</p>
                        </div>
                    </div>
                    <div class="flex space-x-1 sm:space-x-2 flex-shrink-0">
                        <button onclick="viewCustomer({{ $customer->id }})" class="text-blue-600 hover:text-blue-900 dark:hover:text-blue-400 p-1.5 sm:p-2 rounded hover:bg-blue-50 dark:hover:bg-blue-900/20">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                        <button onclick="editCustomer({{ $customer->id }})" class="text-green-600 hover:text-green-900 dark:hover:text-green-400 p-1.5 sm:p-2 rounded hover:bg-green-50 dark:hover:bg-green-900/20">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </button>
                        @if(auth()->user()->role !== 'cashier')
                        <button onclick="deleteCustomer({{ $customer->id }})" class="text-red-600 hover:text-red-900 dark:hover:text-red-400 p-1.5 sm:p-2 rounded hover:bg-red-50 dark:hover:bg-red-900/20">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                        @endif
                    </div>
                </div>
                
                <!-- Customer details in a more compact layout -->
                <div class="space-y-2 sm:space-y-3">
                    <!-- Contact and Type row -->
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start space-y-2 sm:space-y-0">
                        <div class="flex-1">
                            <div class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">Contact</div>
                            <div class="text-sm sm:text-base font-medium text-gray-900 dark:text-white truncate">{{ $customer->email }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $customer->phone }}</div>
                        </div>
                        <div class="flex-1 sm:text-right">
                            <div class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">Type</div>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                @if($customer->customer_type === 'individual') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                @elseif($customer->customer_type === 'shop') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($customer->customer_type === 'institute') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                {{ ucfirst($customer->customer_type ?? 'individual') }}
                            </span>
                            @if($customer->company_name)
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate">{{ $customer->company_name }}</div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Location and Status row -->
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">
                        <div>
                            <div class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Location</div>
                            <div class="text-sm sm:text-base text-gray-900 dark:text-white">{{ $customer->city }}, {{ $customer->state }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $customer->postal_code }}</div>
                        </div>
                        <div>
                            <div class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Status</div>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                @if($customer->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($customer->status === 'inactive') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                {{ ucfirst($customer->status ?? 'active') }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Orders and Date -->
                <div class="mt-3 pt-2 border-t border-gray-100 dark:border-gray-700">
                    <div class="flex justify-between items-center text-xs text-gray-500 dark:text-gray-400">
                        <span>Orders: {{ $customer->orders->count() }}</span>
                        <span>Created: {{ $customer->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="bg-white dark:bg-gray-800 px-3 sm:px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
            {{ $customers->links() }}
        </div>
    </div>

    <!-- Add/Edit Customer Modal -->
    <div id="customerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-4 sm:top-10 mx-auto p-3 sm:p-5 border w-11/12 max-w-2xl shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white" id="modalTitle">Add New Customer</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <form id="customerForm" class="space-y-3 sm:space-y-4">
                    <input type="hidden" id="customerId">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name *</label>
                            <input type="text" id="name" name="name" required class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
                            <input type="email" id="email" name="email" required class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                            <div id="emailValidation" class="text-sm mt-1"></div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone *</label>
                            <input type="tel" id="phone" name="phone" required class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                            <div id="phoneValidation" class="text-sm mt-1"></div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Customer Type *</label>
                            <select id="customer_type" name="customer_type" required class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                                <option value="individual">Individual</option>
                                <option value="shop">Shop</option>
                                <option value="institute">Institute</option>
                                <option value="company">Company</option>
                            </select>
                        </div>

                        <div id="companyFields" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Company Name</label>
                            <input type="text" id="company_name" name="company_name" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                        </div>

                        <div id="contactPersonField" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contact Person</label>
                            <input type="text" id="contact_person" name="contact_person" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                            <select id="status" name="status" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Address *</label>
                        <textarea id="address" name="address" rows="2" required class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"></textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">City *</label>
                            <input type="text" id="city" name="city" required class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">State *</label>
                            <input type="text" id="state" name="state" required class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Postal Code *</label>
                            <input type="text" id="postal_code" name="postal_code" required class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tax Number</label>
                            <input type="text" id="tax_number" name="tax_number" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notes</label>
                        <textarea id="notes" name="notes" rows="3" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Save Customer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Customer Modal -->
    <div id="viewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-4 sm:top-10 mx-auto p-3 sm:p-5 border w-11/12 max-w-2xl shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Customer Details</h3>
                    <button onclick="closeViewModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div id="customerDetails" class="space-y-4">
                    <!-- Customer details will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        /* Ensure table responsiveness */
        .overflow-x-auto {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }
        
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f7fafc;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
        
        /* Ensure table fits within container */
        table {
            table-layout: fixed;
        }
        
        /* Prevent text wrapping in table cells */
        .whitespace-nowrap {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        /* Ensure action buttons don't wrap */
        .action-buttons {
            white-space: nowrap;
            min-width: 80px;
        }
        
        /* Responsive text sizing */
        @media (max-width: 1024px) {
            .text-xs {
                font-size: 0.75rem;
                line-height: 1rem;
            }
        }
    </style>
    
    <script>
        let currentCustomerId = null;
        let searchTimeout;

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                searchCustomers();
            }, 500);
        });

        // Filter functionality
        document.getElementById('statusFilter').addEventListener('change', searchCustomers);
        document.getElementById('customerTypeFilter').addEventListener('change', searchCustomers);
        document.getElementById('sortBy').addEventListener('change', searchCustomers);

        // Customer type change handler
        document.getElementById('customer_type').addEventListener('change', function() {
            const customerType = this.value;
            const companyFields = document.getElementById('companyFields');
            const contactPersonField = document.getElementById('contactPersonField');
            
            if (customerType === 'individual') {
                companyFields.classList.add('hidden');
                contactPersonField.classList.add('hidden');
            } else {
                companyFields.classList.remove('hidden');
                contactPersonField.classList.remove('hidden');
            }
        });

        // Real-time validation
        let emailValidationTimeout;
        let phoneValidationTimeout;

        document.getElementById('email').addEventListener('input', function() {
            clearTimeout(emailValidationTimeout);
            const email = this.value;
            const validationDiv = document.getElementById('emailValidation');
            
            if (email.length > 0) {
                emailValidationTimeout = setTimeout(() => {
                    validateField('email', email);
                }, 500);
            } else {
                validationDiv.innerHTML = '';
            }
        });

        document.getElementById('phone').addEventListener('input', function() {
            clearTimeout(phoneValidationTimeout);
            const phone = this.value;
            const validationDiv = document.getElementById('phoneValidation');
            
            if (phone.length > 0) {
                phoneValidationTimeout = setTimeout(() => {
                    validateField('phone', phone);
                }, 500);
            } else {
                validationDiv.innerHTML = '';
            }
        });

        // Select all functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.customer-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkDeleteButton();
        });

        // Tablet select all functionality
        if (document.getElementById('selectAllTablet')) {
            document.getElementById('selectAllTablet').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.customer-checkbox-tablet');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkDeleteButton();
            });
        }

        // Individual checkbox functionality
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('customer-checkbox') || e.target.classList.contains('customer-checkbox-tablet')) {
                updateBulkDeleteButton();
                updateSelectAll();
            }
        });

        function setupCheckboxListeners() {
            // Reattach event listeners to checkboxes
            const checkboxes = document.querySelectorAll('.customer-checkbox, .customer-checkbox-tablet');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateBulkDeleteButton();
                    updateSelectAll();
                });
            });
        }

        function updateBulkDeleteButton() {
            const checkedBoxes = document.querySelectorAll('.customer-checkbox:checked, .customer-checkbox-tablet:checked');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            
            if (checkedBoxes.length > 0) {
                bulkDeleteBtn.classList.remove('hidden');
            } else {
                bulkDeleteBtn.classList.add('hidden');
            }
        }

        function updateSelectAll() {
            const checkboxes = document.querySelectorAll('.customer-checkbox, .customer-checkbox-tablet');
            const selectAll = document.getElementById('selectAll');
            const selectAllTablet = document.getElementById('selectAllTablet');
            const checkedBoxes = document.querySelectorAll('.customer-checkbox:checked, .customer-checkbox-tablet:checked');
            
            if (checkedBoxes.length === checkboxes.length) {
                if (selectAll) selectAll.checked = true;
                if (selectAllTablet) selectAllTablet.checked = true;
            } else {
                if (selectAll) selectAll.checked = false;
                if (selectAllTablet) selectAllTablet.checked = false;
            }
        }

        function searchCustomers() {
            const search = document.getElementById('searchInput').value;
            const status = document.getElementById('statusFilter').value;
            const customerType = document.getElementById('customerTypeFilter').value;
            const sortBy = document.getElementById('sortBy').value;
            
            const params = new URLSearchParams();
            if (search) params.append('search', search);
            if (status) params.append('status', status);
            if (customerType) params.append('customer_type', customerType);
            params.append('sort_by', sortBy);
            params.append('sort_order', 'desc');
            
            fetch(`{{ route('admin.customers.index') }}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Update desktop table
                const desktopTableBody = document.getElementById('customersTableBody');
                if (desktopTableBody) {
                    desktopTableBody.innerHTML = data.html;
                }
                
                // Update tablet table
                const tabletTableBody = document.getElementById('customersTableBodyTablet');
                if (tabletTableBody) {
                    tabletTableBody.innerHTML = data.html_tablet || data.html;
                }
                
                // Update mobile view - reload the entire page for mobile view
                if (window.innerWidth < 768) {
                    window.location.href = `{{ route('admin.customers.index') }}?${params.toString()}`;
                    return;
                }
                
                document.getElementById('customerCount').textContent = `${data.customers.total} customers`;
                
                // Reattach checkbox listeners
                setupCheckboxListeners();
                
                // Reset select all checkboxes
                const selectAll = document.getElementById('selectAll');
                const selectAllTablet = document.getElementById('selectAllTablet');
                if (selectAll) selectAll.checked = false;
                if (selectAllTablet) selectAllTablet.checked = false;
                
                // Update bulk delete button
                updateBulkDeleteButton();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function validateField(field, value) {
            const currentCustomerId = document.getElementById('customerId').value;
            const params = new URLSearchParams({
                field: field,
                value: value
            });
            
            if (currentCustomerId) {
                params.append('exclude_id', currentCustomerId);
            }
            
            fetch(`{{ route('admin.customers.validate-field') }}?${params.toString()}`)
                .then(response => response.json())
                .then(data => {
                    const validationDiv = document.getElementById(field + 'Validation');
                    if (data.valid) {
                        validationDiv.innerHTML = `<span class="text-green-600">✓ ${data.message}</span>`;
                    } else {
                        validationDiv.innerHTML = `<span class="text-red-600">✗ ${data.message}</span>`;
                    }
                })
                .catch(error => {
                    console.error('Validation error:', error);
                });
        }

        function openAddModal() {
            currentCustomerId = null;
            document.getElementById('modalTitle').textContent = 'Add New Customer';
            document.getElementById('customerForm').reset();
            document.getElementById('customerModal').classList.remove('hidden');
        }

        function editCustomer(id) {
            currentCustomerId = id;
            document.getElementById('modalTitle').textContent = 'Edit Customer';
            
            fetch(`/admin/customers/${id}`)
                .then(response => response.json())
                .then(customer => {
                    document.getElementById('customerId').value = customer.id;
                    document.getElementById('name').value = customer.name;
                    document.getElementById('email').value = customer.email;
                    document.getElementById('phone').value = customer.phone;
                    document.getElementById('customer_type').value = customer.customer_type || 'individual';
                    document.getElementById('company_name').value = customer.company_name || '';
                    document.getElementById('contact_person').value = customer.contact_person || '';
                    document.getElementById('tax_number').value = customer.tax_number || '';
                    document.getElementById('notes').value = customer.notes || '';
                    document.getElementById('address').value = customer.address;
                    document.getElementById('city').value = customer.city;
                    document.getElementById('state').value = customer.state;
                    document.getElementById('postal_code').value = customer.postal_code;
                    document.getElementById('status').value = customer.status || 'active';

                    // Show/hide fields based on customer type
                    const customerType = customer.customer_type || 'individual';
                    const companyFields = document.getElementById('companyFields');
                    const contactPersonField = document.getElementById('contactPersonField');
                    
                    if (customerType === 'individual') {
                        companyFields.classList.add('hidden');
                        contactPersonField.classList.add('hidden');
                    } else {
                        companyFields.classList.remove('hidden');
                        contactPersonField.classList.remove('hidden');
                    }
                    
                    document.getElementById('customerModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error!', 'Failed to load customer data.', 'error');
                });
        }

        function viewCustomer(id) {
            fetch(`/admin/customers/${id}`)
                .then(response => response.json())
                .then(customer => {
                    const detailsHtml = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Personal Information</h4>
                                <div class="space-y-2">
                                    <div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Name:</span>
                                        <p class="text-sm text-gray-900 dark:text-white">${customer.name}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Email:</span>
                                        <p class="text-sm text-gray-900 dark:text-white">${customer.email}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Phone:</span>
                                        <p class="text-sm text-gray-900 dark:text-white">${customer.phone}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Status:</span>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            ${customer.status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                              customer.status === 'inactive' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 
                                              'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'}">
                                            ${customer.status ? customer.status.charAt(0).toUpperCase() + customer.status.slice(1) : 'Active'}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Address Information</h4>
                                <div class="space-y-2">
                                    <div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Address:</span>
                                        <p class="text-sm text-gray-900 dark:text-white">${customer.address}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">City:</span>
                                        <p class="text-sm text-gray-900 dark:text-white">${customer.city}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">State:</span>
                                        <p class="text-sm text-gray-900 dark:text-white">${customer.state}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Postal Code:</span>
                                        <p class="text-sm text-gray-900 dark:text-white">${customer.postal_code}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-2">Additional Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Customer ID:</span>
                                    <p class="text-sm text-gray-900 dark:text-white">${customer.id}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Created:</span>
                                    <p class="text-sm text-gray-900 dark:text-white">${new Date(customer.created_at).toLocaleDateString()}</p>
                                </div>
                            </div>
    </div>
                    `;
                    
                    document.getElementById('customerDetails').innerHTML = detailsHtml;
                    document.getElementById('viewModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error!', 'Failed to load customer data.', 'error');
                });
        }

        function deleteCustomer(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/customers/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', data.message, 'success');
                            searchCustomers();
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'Failed to delete customer.', 'error');
                    });
                }
            });
        }

        function bulkDelete() {
            const checkedBoxes = document.querySelectorAll('.customer-checkbox:checked, .customer-checkbox-tablet:checked');
            const customerIds = Array.from(checkedBoxes).map(cb => cb.value);
            
            if (customerIds.length === 0) {
                Swal.fire('Warning!', 'Please select customers to delete.', 'warning');
                return;
            }
            
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete ${customerIds.length} customer(s). This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/admin/customers/bulk-delete', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            customer_ids: customerIds
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', data.message, 'success');
                            searchCustomers();
                            document.getElementById('selectAll').checked = false;
                            updateBulkDeleteButton();
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'Failed to delete customers.', 'error');
                    });
                }
            });
        }

        function exportCustomers() {
            const search = document.getElementById('searchInput').value;
            const status = document.getElementById('statusFilter').value;
            const customerType = document.getElementById('customerTypeFilter').value;
            
            let url = '{{ route("admin.customers.export") }}?';
            if (search) url += `search=${encodeURIComponent(search)}&`;
            if (status) url += `status=${encodeURIComponent(status)}&`;
            if (customerType) url += `customer_type=${encodeURIComponent(customerType)}&`;
            
            window.location.href = url;
        }

        function clearFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('customerTypeFilter').value = '';
            document.getElementById('sortBy').value = 'created_at';
            searchCustomers();
        }

        // Form submission
        document.getElementById('customerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            const url = currentCustomerId ? `/admin/customers/${currentCustomerId}` : '/admin/customers';
            const method = currentCustomerId ? 'PUT' : 'POST';
            
            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success!', data.message, 'success');
                    closeModal();
                    searchCustomers();
                } else {
                    Swal.fire('Error!', 'Please check the form and try again.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Failed to save customer.', 'error');
            });
        });

        function closeModal() {
            document.getElementById('customerModal').classList.add('hidden');
        }

        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
        }
    </script>
</x-admin-layout> 