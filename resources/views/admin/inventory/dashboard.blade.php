@section('page-title', 'Inventory Dashboard')

<x-admin-layout>
    <div class="mobile-container">
    <!-- Page Header -->
    <div class="mb-6 lg:mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Inventory Management</h1>
                <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400">Monitor stock levels, track batches, manage alerts, and scan barcodes.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                <a href="{{ route('admin.inventory.scanner') }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-transparent text-xs sm:text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V6a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1zm12 0h2a1 1 0 001-1V6a1 1 0 00-1-1h-2a1 1 0 00-1 1v1a1 1 0 001 1zM5 20h2a1 1 0 001-1v-1a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1z"></path>
                    </svg>
                    <span class="hidden xs:inline">Barcode Scanner</span>
                    <span class="xs:hidden">Scanner</span>
                </a>
                <a href="{{ route('admin.inventory.stock-levels') }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4"></path>
                    </svg>
                    <span class="hidden xs:inline">Stock Levels</span>
                    <span class="xs:hidden">Levels</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-6 lg:mb-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-3 sm:p-4 lg:p-6">
            <div class="flex items-center h-16 sm:h-20 lg:h-24">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 sm:h-6 sm:w-6 lg:h-8 lg:w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div class="ml-2 sm:ml-3 lg:ml-4 min-w-0 flex-1 flex flex-col justify-end h-full">
                    <div class="text-xs sm:text-xs lg:text-sm font-medium text-gray-500 dark:text-gray-400 truncate mb-1">Total Products</div>
                    <div class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_products']) }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-3 sm:p-4 lg:p-6">
            <div class="flex items-center h-16 sm:h-20 lg:h-24">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 sm:h-6 sm:w-6 lg:h-8 lg:w-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-2 sm:ml-3 lg:ml-4 min-w-0 flex-1 flex flex-col justify-end h-full">
                    <div class="text-xs sm:text-xs lg:text-sm font-medium text-gray-500 dark:text-gray-400 truncate mb-1">Low Stock Products</div>
                    <div class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['low_stock_products']) }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-3 sm:p-4 lg:p-6">
            <div class="flex items-center h-16 sm:h-20 lg:h-24">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 sm:h-6 sm:w-6 lg:h-8 lg:w-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-2 sm:ml-3 lg:ml-4 min-w-0 flex-1 flex flex-col justify-end h-full">
                    <div class="text-xs sm:text-xs lg:text-sm font-medium text-gray-500 dark:text-gray-400 truncate mb-1">Critical Alerts</div>
                    <div class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['critical_alerts']) }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-3 sm:p-4 lg:p-6">
            <div class="flex items-center h-16 sm:h-20 lg:h-24">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 sm:h-6 sm:w-6 lg:h-8 lg:w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="ml-2 sm:ml-3 lg:ml-4 min-w-0 flex-1 flex flex-col justify-end h-full">
                    <div class="text-xs sm:text-xs lg:text-sm font-medium text-gray-500 dark:text-gray-400 truncate mb-1">Inventory Value</div>
                    <div class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Helpers\CurrencyHelper::format($stats['total_inventory_value']) }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
        <!-- Recent Alerts -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-sm sm:text-base lg:text-lg font-medium text-gray-900 dark:text-white">Recent Alerts</h3>
            </div>
            <div class="p-3 sm:p-4 lg:p-6">
                @if($recentAlerts->count() > 0)
                    <div class="space-y-3 lg:space-y-4">
                        @foreach($recentAlerts as $alert)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center px-2 py-1 lg:px-2.5 lg:py-0.5 rounded-full text-xs font-medium
                                    @if($alert->priority === 'critical') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @elseif($alert->priority === 'high') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                                    @elseif($alert->priority === 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @else bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                    @endif">
                                    {{ $alert->formatted_priority }}
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white break-words">{{ $alert->title }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 break-words">{{ $alert->message }}</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $alert->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 lg:py-8">
                        <svg class="mx-auto h-10 w-10 lg:h-12 lg:w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No active alerts</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Low Stock Products -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-sm sm:text-base lg:text-lg font-medium text-gray-900 dark:text-white">Low Stock Products</h3>
            </div>
            <div class="p-3 sm:p-4 lg:p-6">
                @if($lowStockProducts->count() > 0)
                    <div class="space-y-3 lg:space-y-4">
                        @foreach($lowStockProducts as $product)
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0 pr-4">
                                <div class="flex items-center">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $product->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">SKU: {{ $product->sku }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $product->stock_quantity }} {{ $product->unit }}</p>
                                <p class="text-xs text-red-600 dark:text-red-400">Reorder: {{ $product->reorder_level }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 lg:py-8">
                        <svg class="mx-auto h-10 w-10 lg:h-12 lg:w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">All products are adequately stocked</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Expiring Batches -->
    @if($expiringBatches->count() > 0)
    <div class="mt-4 sm:mt-6 lg:mt-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-sm sm:text-base lg:text-lg font-medium text-gray-900 dark:text-white">Expiring Batches (Next 30 Days)</h3>
            </div>
            <div class="table-container overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-2 sm:px-3 lg:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product</th>
                            <th class="px-2 sm:px-3 lg:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden sm:table-cell">Batch</th>
                            <th class="px-2 sm:px-3 lg:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quantity</th>
                            <th class="px-2 sm:px-3 lg:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Expiry</th>
                            <th class="px-2 sm:px-3 lg:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Days Left</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($expiringBatches as $batch)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-2 sm:px-3 lg:px-6 py-2 sm:py-3 lg:py-4">
                                <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white truncate">{{ $batch->product->name }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $batch->product->sku }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 sm:hidden">Batch: {{ $batch->batch_number }}</div>
                            </td>
                            <td class="px-2 sm:px-3 lg:px-6 py-2 sm:py-3 lg:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 dark:text-white hidden sm:table-cell">{{ $batch->batch_number }}</td>
                            <td class="px-2 sm:px-3 lg:px-6 py-2 sm:py-3 lg:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 dark:text-white">{{ $batch->quantity_remaining }}</td>
                            <td class="px-2 sm:px-3 lg:px-6 py-2 sm:py-3 lg:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 dark:text-white">
                                <span class="hidden sm:inline">{{ $batch->expiry_date->format('M d, Y') }}</span>
                                <span class="sm:hidden">{{ $batch->expiry_date->format('m/d') }}</span>
                            </td>
                            <td class="px-2 sm:px-3 lg:px-6 py-2 sm:py-3 lg:py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-1.5 sm:px-2 py-0.5 lg:px-2.5 lg:py-0.5 rounded-full text-xs font-medium
                                    @if($batch->days_until_expiry <= 7) bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @elseif($batch->days_until_expiry <= 14) bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                                    @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @endif">
                                    <span class="hidden xs:inline">{{ $batch->days_until_expiry }} days</span>
                                    <span class="xs:hidden">{{ $batch->days_until_expiry }}d</span>
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Quick Actions -->
    <div class="mt-4 sm:mt-6 lg:mt-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-3 sm:p-4 lg:p-6">
            <h3 class="text-sm sm:text-base lg:text-lg font-medium text-gray-900 dark:text-white mb-3 sm:mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 sm:gap-3 lg:gap-4">
                <button onclick="openStockAdjustmentModal()" class="flex items-center justify-center px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <svg class="w-4 h-4 sm:w-4 sm:h-4 lg:w-5 lg:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="hidden xs:inline">Adjust Stock</span>
                    <span class="xs:hidden">Adjust</span>
                </button>
                <a href="{{ route('admin.inventory.scanner') }}" class="flex items-center justify-center px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <svg class="w-4 h-4 sm:w-4 sm:h-4 lg:w-5 lg:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V6a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1zm12 0h2a1 1 0 001-1V6a1 1 0 00-1-1h-2a1 1 0 00-1 1v1a1 1 0 001 1zM5 20h2a1 1 0 001-1v-1a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1z"></path>
                    </svg>
                    <span class="hidden xs:inline">Scan Barcode</span>
                    <span class="xs:hidden">Scan</span>
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center justify-center px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors sm:col-span-2 lg:col-span-1">
                    <svg class="w-4 h-4 sm:w-4 sm:h-4 lg:w-5 lg:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span class="hidden xs:inline">Manage Products</span>
                    <span class="xs:hidden">Products</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Stock Adjustment Modal -->
    <div id="stockAdjustmentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-2 sm:top-4 lg:top-20 mx-auto p-3 sm:p-4 lg:p-5 border w-full max-w-sm sm:max-w-md lg:max-w-lg shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-2 sm:mt-3">
                <h3 class="text-sm sm:text-base lg:text-lg font-medium text-gray-900 dark:text-white mb-3 sm:mb-4">Stock Adjustment</h3>
                <form id="stockAdjustmentForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product</label>
                        <select id="adjustmentProductId" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select product...</option>
                            @foreach($lowStockProducts as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->sku }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Adjustment Type</label>
                        <select id="adjustmentType" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="increase">Increase Stock</option>
                            <option value="decrease">Decrease Stock</option>
                            <option value="set">Set Stock Level</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Quantity</label>
                        <input type="number" id="adjustmentQuantity" min="0" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reason</label>
                        <select id="adjustmentReason" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="Stock count adjustment">Stock count adjustment</option>
                            <option value="Damaged goods">Damaged goods</option>
                            <option value="Lost items">Lost items</option>
                            <option value="Found items">Found items</option>
                            <option value="Return to supplier">Return to supplier</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notes (Optional)</label>
                        <textarea id="adjustmentNotes" rows="3" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </form>
                <div class="flex flex-col sm:flex-row justify-end gap-2 sm:gap-3 mt-4 sm:mt-6">
                    <button onclick="closeStockAdjustmentModal()" class="w-full sm:w-auto px-3 sm:px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Cancel
                    </button>
                    <button onclick="submitStockAdjustment()" class="w-full sm:w-auto px-3 sm:px-4 py-2 border border-transparent rounded-lg text-xs sm:text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                        Adjust Stock
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function openStockAdjustmentModal() {
            document.getElementById('stockAdjustmentModal').classList.remove('hidden');
        }

        function closeStockAdjustmentModal() {
            document.getElementById('stockAdjustmentModal').classList.add('hidden');
            document.getElementById('stockAdjustmentForm').reset();
        }

        function submitStockAdjustment() {
            const productId = document.getElementById('adjustmentProductId').value;
            const type = document.getElementById('adjustmentType').value;
            const quantity = document.getElementById('adjustmentQuantity').value;
            const reason = document.getElementById('adjustmentReason').value;
            const notes = document.getElementById('adjustmentNotes').value;

            if (!productId || !quantity || !reason) {
                Swal.fire('Error', 'Please fill in all required fields', 'error');
                return;
            }

            fetch('{{ route("admin.inventory.adjust-stock") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    adjustment_type: type,
                    quantity: parseInt(quantity),
                    reason: reason,
                    notes: notes
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success', data.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', data.message || 'An error occurred', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'An error occurred while adjusting stock', 'error');
            });
        }

        // Close modal when clicking outside
        document.getElementById('stockAdjustmentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeStockAdjustmentModal();
            }
        });
    </script>
    </div>
</x-admin-layout>
