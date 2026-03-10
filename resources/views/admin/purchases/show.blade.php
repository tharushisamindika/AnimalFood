<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Purchase Order #{{ $purchase->purchase_number }}</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">View purchase order details and receive items.</p>
            </div>
            <div class="flex space-x-3">
                @if($purchase->can_be_received)
                    <a href="{{ route('admin.purchases.grn', $purchase) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        Receive Items (GRN)
                    </a>
                @endif
                <a href="{{ route('admin.purchases.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Purchases
                </a>
            </div>
        </div>
    </div>

    <!-- Purchase Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Purchase Information -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Purchase Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Purchase Number</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $purchase->purchase_number }}</p>
                    </div>
                    @if($purchase->invoice_number)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Invoice Number</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $purchase->invoice_number }}</p>
                    </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Purchase Date</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $purchase->purchase_date->format('F d, Y') }}</p>
                    </div>
                    @if($purchase->expected_delivery_date)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Expected Delivery</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $purchase->expected_delivery_date->format('F d, Y') }}</p>
                    </div>
                    @endif
                    @if($purchase->delivery_date)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Actual Delivery</label>
                        <p class="mt-1 text-sm text-green-600 dark:text-green-400">{{ $purchase->delivery_date->format('F d, Y') }}</p>
                    </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Created By</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $purchase->user->name }}</p>
                    </div>
                </div>
                @if($purchase->notes)
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Notes</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $purchase->notes }}</p>
                </div>
                @endif
            </div>

            <!-- Supplier Information -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Supplier Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Supplier Name</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white font-medium">{{ $purchase->supplier->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Supplier ID</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $purchase->supplier->supplier_id }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $purchase->supplier->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Phone</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $purchase->supplier->phone }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Address</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $purchase->supplier->address }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status & Summary -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Status</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Order Status</label>
                        <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium
                            @if($purchase->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                            @elseif($purchase->status === 'partial') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                            @elseif($purchase->status === 'received') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                            @elseif($purchase->status === 'completed') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                            @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                            @endif">
                            {{ $purchase->formatted_status }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Payment Status</label>
                        <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium
                            @if($purchase->payment_status === 'pending') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                            @elseif($purchase->payment_status === 'partial') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                            @elseif($purchase->payment_status === 'paid') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                            @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                            @endif">
                            {{ $purchase->formatted_payment_status }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Summary Card -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Order Summary</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                        <span class="font-medium text-gray-900 dark:text-white">Rs. {{ number_format($purchase->subtotal, 2) }}</span>
                    </div>
                    @if($purchase->tax_amount > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Tax:</span>
                        <span class="font-medium text-gray-900 dark:text-white">Rs. {{ number_format($purchase->tax_amount, 2) }}</span>
                    </div>
                    @endif
                    @if($purchase->shipping_cost > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Shipping:</span>
                        <span class="font-medium text-gray-900 dark:text-white">Rs. {{ number_format($purchase->shipping_cost, 2) }}</span>
                    </div>
                    @endif
                    @if($purchase->discount_amount > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Discount:</span>
                        <span class="font-medium text-gray-900 dark:text-white">-Rs. {{ number_format($purchase->discount_amount, 2) }}</span>
                    </div>
                    @endif
                    <div class="border-t border-gray-200 dark:border-gray-600 pt-2">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-900 dark:text-white">Total:</span>
                            <span class="font-bold text-lg text-gray-900 dark:text-white">Rs. {{ number_format($purchase->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quantity Summary -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Quantity Status</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Ordered:</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $purchase->total_quantity_ordered }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Received:</span>
                        <span class="text-sm font-medium text-green-600 dark:text-green-400">{{ $purchase->total_quantity_received }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Pending:</span>
                        <span class="text-sm font-medium text-yellow-600 dark:text-yellow-400">{{ $purchase->total_quantity_pending }}</span>
                    </div>
                    @if($purchase->total_quantity_ordered > 0)
                    <div class="mt-2">
                        <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400 mb-1">
                            <span>Progress</span>
                            <span>{{ round(($purchase->total_quantity_received / $purchase->total_quantity_ordered) * 100, 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ ($purchase->total_quantity_received / $purchase->total_quantity_ordered) * 100 }}%"></div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Purchase Items -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg mb-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Purchase Items</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Unit Cost</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ordered</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Received</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pending</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Cost</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($purchase->items as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $item->product->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $item->product->sku }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            Rs. {{ number_format($item->unit_cost, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{ $item->quantity_ordered }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 dark:text-green-400">
                            {{ $item->quantity_received }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-600 dark:text-yellow-400">
                            {{ $item->quantity_pending }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                            Rs. {{ number_format($item->total_cost, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($item->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @elseif($item->status === 'partial') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                @elseif($item->status === 'received') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @endif">
                                {{ $item->formatted_status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Returns (if any) -->
    @if($purchase->returns->count() > 0)
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Purchase Returns</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Return Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Reason</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($purchase->returns as $return)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900 dark:text-white">
                            {{ $return->return_number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{ $return->product->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{ $return->quantity_returned }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{ $return->formatted_reason }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($return->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @elseif($return->status === 'approved') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                @elseif($return->status === 'processed') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                @elseif($return->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @endif">
                                {{ $return->formatted_status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.purchase-returns.show', $return) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                View Details
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</x-admin-layout>
