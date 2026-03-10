@section('page-title', 'Stock Levels')

<x-admin-layout>
    <div class="mobile-container">
    <!-- Page Header -->
    <div class="mb-6 lg:mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Stock Levels</h1>
                <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400">Monitor and manage product inventory levels with FIFO/LIFO tracking.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                <a href="{{ route('admin.inventory.dashboard') }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4"></path>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.inventory.scanner') }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-transparent text-xs sm:text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V6a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1zm12 0h2a1 1 0 001-1V6a1 1 0 00-1-1h-2a1 1 0 00-1 1v1a1 1 0 001 1zM5 20h2a1 1 0 001-1v-1a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1z"></path>
                    </svg>
                    Scanner
                </a>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-3 sm:p-4 lg:p-6 mb-6 lg:mb-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-4">
            <!-- Search -->
            <div class="sm:col-span-2 lg:col-span-1">
                <label for="search" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">Search Product</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Name, SKU, or barcode..." class="w-full px-2 sm:px-3 py-1.5 sm:py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">Category</label>
                <select id="category_id" name="category_id" class="w-full px-2 sm:px-3 py-1.5 sm:py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Supplier -->
            <div>
                <label for="supplier_id" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">Supplier</label>
                <select id="supplier_id" name="supplier_id" class="w-full px-2 sm:px-3 py-1.5 sm:py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    <option value="">All Suppliers</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Stock Status -->
            <div>
                <label for="stock_status" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">Stock Status</label>
                <select id="stock_status" name="stock_status" class="w-full px-2 sm:px-3 py-1.5 sm:py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    <option value="">All Status</option>
                    <option value="low_stock" {{ request('stock_status') === 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                    <option value="zero_stock" {{ request('stock_status') === 'zero_stock' ? 'selected' : '' }}>Out of Stock</option>
                    <option value="overstock" {{ request('stock_status') === 'overstock' ? 'selected' : '' }}>Overstock</option>
                    <option value="normal" {{ request('stock_status') === 'normal' ? 'selected' : '' }}>Normal</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row sm:items-end gap-2 sm:space-x-2 sm:col-span-2 lg:col-span-1">
                <button type="button" id="filterBtn" class="w-full sm:w-auto px-3 sm:px-4 py-1.5 sm:py-2 border border-transparent text-xs sm:text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-1 sm:mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"></path>
                    </svg>
                    Filter
                </button>
                <button type="button" id="bulkAdjustBtn" class="w-full sm:w-auto px-3 sm:px-4 py-1.5 sm:py-2 border border-gray-300 dark:border-gray-600 text-xs sm:text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-1 sm:mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="hidden xs:inline">Bulk Adjust</span>
                    <span class="xs:hidden">Bulk</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Stock Levels Table -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
        <div class="table-container overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-1 sm:px-2 md:px-4 lg:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product</th>
                        <th class="px-1 sm:px-2 md:px-4 lg:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Stock</th>
                        <th class="px-1 sm:px-2 md:px-4 lg:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden md:table-cell">Levels</th>
                        <th class="px-1 sm:px-2 md:px-4 lg:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden lg:table-cell">Value</th>
                        <th class="px-1 sm:px-2 md:px-4 lg:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-1 sm:px-2 md:px-4 lg:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-20 sm:w-auto">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($products as $product)
                    @php
                        $stockStatus = 'normal';
                        $stockColor = 'green';
                        
                        if ($product->stock_quantity === 0) {
                            $stockStatus = 'Out of Stock';
                            $stockColor = 'red';
                        } elseif ($product->stock_quantity <= $product->minimum_stock_level) {
                            $stockStatus = 'Critical';
                            $stockColor = 'red';
                        } elseif ($product->stock_quantity <= $product->reorder_level) {
                            $stockStatus = 'Low Stock';
                            $stockColor = 'yellow';
                        } elseif ($product->stock_quantity > $product->max_stock_level) {
                            $stockStatus = 'Overstock';
                            $stockColor = 'blue';
                        }
                        
                        $totalValue = $product->stock_quantity * $product->average_cost;
                        $activeBatches = $product->inventoryBatches->where('is_active', true)->count();
                        $expiringBatches = $product->inventoryBatches->where('is_active', true)->filter(function($batch) {
                            return $batch->expiry_date && $batch->expiry_date->diffInDays(now()) <= 30;
                        })->count();
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-1 sm:px-2 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4">
                            <div class="flex items-center">
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white truncate">{{ $product->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        SKU: {{ $product->sku }}
                                        @if($product->barcode)
                                            <span class="hidden sm:inline">| Barcode: {{ $product->barcode }}</span>
                                        @endif
                                    </div>
                                    @if($product->location)
                                        <div class="text-xs text-gray-500 dark:text-gray-400 hidden sm:block">Location: {{ $product->location }}</div>
                                    @endif
                                    <!-- Mobile-only info -->
                                    <div class="md:hidden mt-1">
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Min: {{ $product->minimum_stock_level }} | Max: {{ $product->max_stock_level }}</div>
                                        <div class="lg:hidden text-xs text-gray-500 dark:text-gray-400">Cost: {{ \App\Helpers\CurrencyHelper::format($product->average_cost) }}</div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-1 sm:px-2 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4">
                            <div class="text-xs sm:text-sm text-gray-900 dark:text-white">
                                <div class="font-medium">{{ $product->stock_quantity }} {{ $product->unit }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 hidden sm:block">Method: {{ $product->stock_method }}</div>
                                @if($product->track_batches && $activeBatches > 0)
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $activeBatches }} batches</div>
                                @endif
                                @if($expiringBatches > 0)
                                    <div class="text-xs text-orange-600 dark:text-orange-400">{{ $expiringBatches }} expiring</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-1 sm:px-2 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 hidden md:table-cell">
                            <div class="text-xs sm:text-sm text-gray-900 dark:text-white">
                                <div>Min: {{ $product->minimum_stock_level }}</div>
                                <div>Reorder: {{ $product->reorder_level }}</div>
                                <div>Max: {{ $product->max_stock_level }}</div>
                            </div>
                        </td>
                        <td class="px-1 sm:px-2 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 hidden lg:table-cell">
                            <div class="text-xs sm:text-sm text-gray-900 dark:text-white">
                                <div>Cost: {{ \App\Helpers\CurrencyHelper::format($product->average_cost) }}</div>
                                <div>Total: {{ \App\Helpers\CurrencyHelper::format($totalValue) }}</div>
                                @if($product->last_stock_update)
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Updated: {{ $product->last_stock_update->diffForHumans() }}</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-1 sm:px-2 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4">
                            <div class="flex flex-col gap-1">
                                <span class="inline-flex items-center px-1 sm:px-1.5 md:px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $stockColor }}-100 text-{{ $stockColor }}-800 dark:bg-{{ $stockColor }}-900 dark:text-{{ $stockColor }}-200">
                                    <span class="hidden sm:inline">{{ $stockStatus }}</span>
                                    <span class="sm:hidden">
                                        @if($stockStatus === 'Out of Stock') OOS
                                        @elseif($stockStatus === 'Low Stock') Low
                                        @elseif($stockStatus === 'Critical') Crit
                                        @elseif($stockStatus === 'Overstock') Over
                                        @else OK
                                        @endif
                                    </span>
                                </span>
                                @if($product->inventoryAlerts->where('status', 'active')->count() > 0)
                                    <span class="inline-flex items-center px-1 sm:px-1.5 md:px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        <span class="hidden sm:inline">{{ $product->inventoryAlerts->where('status', 'active')->count() }} alerts</span>
                                        <span class="sm:hidden">{{ $product->inventoryAlerts->where('status', 'active')->count() }}!</span>
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-1 sm:px-2 md:px-4 lg:px-6 py-2 sm:py-3 md:py-4 text-sm font-medium w-16 sm:w-20 md:w-auto">
                            <div class="flex flex-col sm:flex-row gap-0.5 sm:gap-1 md:gap-2 items-center sm:items-start">
                                <a href="{{ route('admin.products.show', $product) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 p-0.5 sm:p-1 rounded hover:bg-blue-50 dark:hover:bg-blue-900/20" title="View Details">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <button onclick="adjustStock({{ $product->id }}, '{{ $product->name }}')" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 p-0.5 sm:p-1 rounded hover:bg-green-50 dark:hover:bg-green-900/20" title="Adjust Stock">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                                @if(!$product->barcode)
                                    <button onclick="generateBarcode({{ $product->id }})" class="text-purple-600 dark:text-purple-400 hover:text-purple-900 dark:hover:text-purple-300 p-0.5 sm:p-1 rounded hover:bg-purple-50 dark:hover:bg-purple-900/20" title="Generate Barcode">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V6a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1zm12 0h2a1 1 0 001-1V6a1 1 0 00-1-1h-2a1 1 0 00-1 1v1a1 1 0 001 1zM5 20h2a1 1 0 001-1v-1a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1z"></path>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-2 sm:px-4 md:px-6 py-6 sm:py-8 md:py-12 text-center text-gray-500 dark:text-gray-400">
                            <svg class="mx-auto h-6 w-6 sm:h-8 sm:w-8 md:h-12 md:w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <p class="mt-2 text-xs sm:text-sm">No products found matching the criteria.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="mt-4 sm:mt-6">
        {{ $products->links() }}
    </div>
    @endif

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Filter functionality
        document.getElementById('filterBtn').addEventListener('click', function() {
            const search = document.getElementById('search').value;
            const categoryId = document.getElementById('category_id').value;
            const supplierId = document.getElementById('supplier_id').value;
            const stockStatus = document.getElementById('stock_status').value;

            const params = new URLSearchParams();
            if (search) params.append('search', search);
            if (categoryId) params.append('category_id', categoryId);
            if (supplierId) params.append('supplier_id', supplierId);
            if (stockStatus) params.append('stock_status', stockStatus);

            window.location.href = `{{ route('admin.inventory.stock-levels') }}?${params.toString()}`;
        });

        // Enter key support for search
        document.getElementById('search').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('filterBtn').click();
            }
        });

        // Bulk adjustment functionality
        document.getElementById('bulkAdjustBtn').addEventListener('click', function() {
            showBulkAdjustmentDialog();
        });

        // Adjust stock function
        function adjustStock(productId, productName) {
            Swal.fire({
                title: `Adjust Stock`,
                html: `
                    <div class="space-y-4 text-left">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <div>
                                    <div class="font-medium text-blue-900" id="selected-product-name">${productName}</div>
                                    <div class="text-sm text-blue-700" id="selected-product-info">Loading product info...</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700">Adjustment Type</label>
                                <select id="swal-adjustment-type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="increase">Increase Stock</option>
                                    <option value="decrease">Decrease Stock</option>
                                    <option value="set">Set Stock Level</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700">Quantity</label>
                                <input type="number" id="swal-quantity" min="0" step="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter quantity">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-700">Reason</label>
                            <select id="swal-reason" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select a reason...</option>
                                <option value="Stock count adjustment">Stock count adjustment</option>
                                <option value="Damaged goods">Damaged goods</option>
                                <option value="Lost items">Lost items</option>
                                <option value="Found items">Found items</option>
                                <option value="Return to supplier">Return to supplier</option>
                                <option value="Theft/Shrinkage">Theft/Shrinkage</option>
                                <option value="Quality control">Quality control</option>
                                <option value="Expired products">Expired products</option>
                                <option value="Transfer between locations">Transfer between locations</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-700">Notes (Optional)</label>
                            <textarea id="swal-notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Add any additional notes..."></textarea>
                        </div>
                        
                        <div id="adjustment-preview" class="bg-gray-50 border border-gray-200 rounded-lg p-3 hidden">
                            <div class="text-sm font-medium text-gray-700 mb-1">Adjustment Preview:</div>
                            <div id="preview-text" class="text-sm text-gray-600"></div>
                        </div>
                    </div>
                `,
                width: '600px',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-save mr-2"></i>Adjust Stock',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancel',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 mr-3',
                    cancelButton: 'btn btn-secondary px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400'
                },
                didOpen: () => {
                    // Load current product info
                    loadProductInfo(productId);
                    
                    // Add event listeners for live preview
                    const typeSelect = document.getElementById('swal-adjustment-type');
                    const quantityInput = document.getElementById('swal-quantity');
                    
                    [typeSelect, quantityInput].forEach(element => {
                        element.addEventListener('input', updateAdjustmentPreview);
                    });
                },
                preConfirm: () => {
                    const type = document.getElementById('swal-adjustment-type').value;
                    const quantity = document.getElementById('swal-quantity').value;
                    const reason = document.getElementById('swal-reason').value;
                    const notes = document.getElementById('swal-notes').value;
                    
                    if (!quantity || quantity <= 0) {
                        Swal.showValidationMessage('Please enter a valid quantity');
                        return false;
                    }
                    
                    if (!reason) {
                        Swal.showValidationMessage('Please select a reason for the adjustment');
                        return false;
                    }
                    
                    return { type, quantity: parseInt(quantity), reason, notes };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const { type, quantity, reason, notes } = result.value;
                    
                    // Show loading
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Adjusting stock levels...',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    fetch('{{ route("admin.inventory.adjust-stock") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            adjustment_type: type,
                            quantity: quantity,
                            reason: reason,
                            notes: notes
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Stock Adjusted!',
                                html: `
                                    <div class="text-left">
                                        <p class="mb-2"><strong>Product:</strong> ${productName}</p>
                                        <p class="mb-2"><strong>Previous Stock:</strong> ${data.old_quantity}</p>
                                        <p class="mb-2"><strong>New Stock:</strong> ${data.new_quantity}</p>
                                        <p class="mb-2"><strong>Adjustment:</strong> ${data.adjustment > 0 ? '+' : ''}${data.adjustment}</p>
                                        <p><strong>Reason:</strong> ${reason}</p>
                                    </div>
                                `,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'An error occurred while adjusting stock'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while adjusting stock'
                        });
                    });
                }
            });
        }
        
        // Load product information for the adjustment dialog
        function loadProductInfo(productId) {
            fetch(`/admin/products/${productId}/info`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const product = data.product;
                        document.getElementById('selected-product-info').innerHTML = 
                            `SKU: ${product.sku} | Current Stock: ${product.stock_quantity} ${product.unit} | Reorder Level: ${product.reorder_level}`;
                        
                        // Store current stock for preview calculation
                        window.currentStock = product.stock_quantity;
                        window.productUnit = product.unit;
                    }
                })
                .catch(error => {
                    console.error('Error loading product info:', error);
                });
        }
        
        // Update adjustment preview
        function updateAdjustmentPreview() {
            const type = document.getElementById('swal-adjustment-type').value;
            const quantity = parseInt(document.getElementById('swal-quantity').value) || 0;
            const preview = document.getElementById('adjustment-preview');
            const previewText = document.getElementById('preview-text');
            
            if (quantity > 0 && window.currentStock !== undefined) {
                let newStock = window.currentStock;
                let changeText = '';
                
                switch (type) {
                    case 'increase':
                        newStock = window.currentStock + quantity;
                        changeText = `+${quantity}`;
                        break;
                    case 'decrease':
                        newStock = Math.max(0, window.currentStock - quantity);
                        changeText = `-${quantity}`;
                        break;
                    case 'set':
                        newStock = quantity;
                        changeText = quantity > window.currentStock ? `+${quantity - window.currentStock}` : `-${window.currentStock - quantity}`;
                        break;
                }
                
                previewText.innerHTML = `Current: ${window.currentStock} ${window.productUnit} → New: ${newStock} ${window.productUnit} (${changeText})`;
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }
        }

        // Bulk adjustment dialog
        function showBulkAdjustmentDialog() {
            Swal.fire({
                title: 'Bulk Stock Adjustment',
                html: `
                    <div class="space-y-4 text-left">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <div class="text-sm text-yellow-800">
                                    <strong>Note:</strong> Search and select products below to adjust multiple stocks at once.
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-700">Search Products</label>
                            <div class="relative">
                                <input type="text" id="bulk-product-search" class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Search by name, SKU, or barcode...">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div id="bulk-search-results" class="mt-2 max-h-60 overflow-y-auto border border-gray-200 rounded-lg hidden">
                                <!-- Search results will appear here -->
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-700">Selected Products</label>
                            <div id="bulk-selected-products" class="min-h-20 max-h-40 overflow-y-auto border border-gray-200 rounded-lg p-3 bg-gray-50">
                                <div class="text-sm text-gray-500 text-center py-4">No products selected</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700">Adjustment Type</label>
                                <select id="bulk-adjustment-type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="increase">Increase Stock</option>
                                    <option value="decrease">Decrease Stock</option>
                                    <option value="set">Set Stock Level</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700">Quantity</label>
                                <input type="number" id="bulk-quantity" min="0" step="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter quantity">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-700">Reason</label>
                            <select id="bulk-reason" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select a reason...</option>
                                <option value="Bulk stock count adjustment">Bulk stock count adjustment</option>
                                <option value="Bulk damaged goods">Bulk damaged goods</option>
                                <option value="Bulk inventory correction">Bulk inventory correction</option>
                                <option value="Bulk transfer">Bulk transfer</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-700">Notes (Optional)</label>
                            <textarea id="bulk-notes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Add any additional notes..."></textarea>
                        </div>
                    </div>
                `,
                width: '700px',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-save mr-2"></i>Apply Bulk Adjustment',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancel',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 mr-3',
                    cancelButton: 'btn btn-secondary px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400'
                },
                didOpen: () => {
                    setupBulkAdjustmentSearch();
                },
                preConfirm: () => {
                    const selectedProducts = window.bulkSelectedProducts || [];
                    const type = document.getElementById('bulk-adjustment-type').value;
                    const quantity = document.getElementById('bulk-quantity').value;
                    const reason = document.getElementById('bulk-reason').value;
                    const notes = document.getElementById('bulk-notes').value;

                    if (selectedProducts.length === 0) {
                        Swal.showValidationMessage('Please select at least one product');
                        return false;
                    }

                    if (!quantity || quantity <= 0) {
                        Swal.showValidationMessage('Please enter a valid quantity');
                        return false;
                    }

                    if (!reason) {
                        Swal.showValidationMessage('Please select a reason for the adjustment');
                        return false;
                    }

                    return { selectedProducts, type, quantity: parseInt(quantity), reason, notes };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    processBulkAdjustment(result.value);
                }
            });
        }

        // Setup bulk adjustment search functionality
        function setupBulkAdjustmentSearch() {
            window.bulkSelectedProducts = [];
            const searchInput = document.getElementById('bulk-product-search');
            const searchResults = document.getElementById('bulk-search-results');
            let searchTimeout;

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();
                
                if (query.length < 2) {
                    searchResults.classList.add('hidden');
                    return;
                }

                searchTimeout = setTimeout(() => {
                    searchProducts(query);
                }, 300);
            });
        }

        // Search products for bulk adjustment
        function searchProducts(query) {
            const searchResults = document.getElementById('bulk-search-results');
            
            fetch(`{{ route('admin.inventory.search-products') }}?search=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displaySearchResults(data.products);
                    } else {
                        searchResults.innerHTML = '<div class="p-3 text-red-600">Error searching products</div>';
                        searchResults.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Search error:', error);
                    searchResults.innerHTML = '<div class="p-3 text-red-600">Error searching products</div>';
                    searchResults.classList.remove('hidden');
                });
        }

        // Display search results
        function displaySearchResults(products) {
            const searchResults = document.getElementById('bulk-search-results');
            
            if (products.length === 0) {
                searchResults.innerHTML = '<div class="p-3 text-gray-500">No products found</div>';
            } else {
                searchResults.innerHTML = products.map(product => `
                    <div class="p-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-b-0" onclick="addToBulkSelection(${product.id}, '${product.name}', '${product.sku}', ${product.stock_quantity})">
                        <div class="font-medium text-gray-900">${product.name}</div>
                        <div class="text-sm text-gray-500">SKU: ${product.sku} | Stock: ${product.stock_quantity} ${product.unit}</div>
                    </div>
                `).join('');
            }
            
            searchResults.classList.remove('hidden');
        }

        // Add product to bulk selection
        function addToBulkSelection(productId, productName, productSku, currentStock) {
            if (!window.bulkSelectedProducts) {
                window.bulkSelectedProducts = [];
            }

            // Check if already selected
            if (window.bulkSelectedProducts.some(p => p.id == productId)) {
                return;
            }

            window.bulkSelectedProducts.push({
                id: productId,
                name: productName,
                sku: productSku,
                stock: currentStock
            });

            updateBulkSelectedDisplay();
            
            // Hide search results
            document.getElementById('bulk-search-results').classList.add('hidden');
            document.getElementById('bulk-product-search').value = '';
        }

        // Update bulk selected products display
        function updateBulkSelectedDisplay() {
            const container = document.getElementById('bulk-selected-products');
            
            if (window.bulkSelectedProducts.length === 0) {
                container.innerHTML = '<div class="text-sm text-gray-500 text-center py-4">No products selected</div>';
            } else {
                container.innerHTML = window.bulkSelectedProducts.map(product => `
                    <div class="flex items-center justify-between bg-white border border-gray-200 rounded-lg p-2 mb-2">
                        <div class="flex-1">
                            <div class="font-medium text-gray-900 text-sm">${product.name}</div>
                            <div class="text-xs text-gray-500">SKU: ${product.sku} | Current: ${product.stock}</div>
                        </div>
                        <button onclick="removeFromBulkSelection(${product.id})" class="text-red-600 hover:text-red-800 p-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                `).join('');
            }
        }

        // Remove product from bulk selection
        function removeFromBulkSelection(productId) {
            window.bulkSelectedProducts = window.bulkSelectedProducts.filter(p => p.id != productId);
            updateBulkSelectedDisplay();
        }

        // Process bulk adjustment
        function processBulkAdjustment(data) {
            const { selectedProducts, type, quantity, reason, notes } = data;
            
            Swal.fire({
                title: 'Processing Bulk Adjustment...',
                html: `
                    <div class="text-left">
                        <p class="mb-2">Adjusting stock for ${selectedProducts.length} products...</p>
                        <div id="bulk-progress" class="w-full bg-gray-200 rounded-full h-2">
                            <div id="bulk-progress-bar" class="bg-blue-600 h-2 rounded-full" style="width: 0%"></div>
                        </div>
                        <div id="bulk-status" class="mt-2 text-sm text-gray-600">Starting...</div>
                    </div>
                `,
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false
            });

            let completed = 0;
            let errors = [];
            const total = selectedProducts.length;

            // Process products one by one
            const processNext = async (index) => {
                if (index >= selectedProducts.length) {
                    // All done
                    const successCount = completed - errors.length;
                    Swal.fire({
                        icon: successCount > 0 ? 'success' : 'error',
                        title: 'Bulk Adjustment Complete',
                        html: `
                            <div class="text-left">
                                <p class="mb-2"><strong>Successfully adjusted:</strong> ${successCount} products</p>
                                ${errors.length > 0 ? `<p class="mb-2 text-red-600"><strong>Errors:</strong> ${errors.length} products</p>` : ''}
                                <p><strong>Adjustment Type:</strong> ${type}</p>
                                <p><strong>Quantity:</strong> ${quantity}</p>
                                <p><strong>Reason:</strong> ${reason}</p>
                            </div>
                        `,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                    return;
                }

                const product = selectedProducts[index];
                document.getElementById('bulk-status').textContent = `Processing ${product.name}...`;

                try {
                    const response = await fetch('{{ route("admin.inventory.adjust-stock") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: product.id,
                            adjustment_type: type,
                            quantity: quantity,
                            reason: reason,
                            notes: notes
                        })
                    });

                    const result = await response.json();
                    if (!result.success) {
                        errors.push(`${product.name}: ${result.message}`);
                    }
                } catch (error) {
                    errors.push(`${product.name}: Network error`);
                }

                completed++;
                const progress = (completed / total) * 100;
                document.getElementById('bulk-progress-bar').style.width = `${progress}%`;
                
                // Process next product
                setTimeout(() => processNext(index + 1), 500);
            };

            processNext(0);
        }

        // Generate barcode function
        function generateBarcode(productId) {
            fetch(`{{ url('/admin/inventory/generate-barcode') }}/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success', `Barcode generated: ${data.barcode}`, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', data.message || 'An error occurred', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'An error occurred while generating barcode', 'error');
            });
        }
    </script>
    </div>
</x-admin-layout>
