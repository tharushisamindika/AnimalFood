<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Goods Received Note (GRN)</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Record items received for Purchase Order #{{ $purchase->purchase_number }}</p>
            </div>
            <a href="{{ route('admin.purchases.show', $purchase) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Purchase
            </a>
        </div>
    </div>

    <!-- Purchase Summary -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Purchase Number</label>
                <p class="mt-1 text-sm font-mono text-gray-900 dark:text-white">{{ $purchase->purchase_number }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Supplier</label>
                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $purchase->supplier->name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Purchase Date</label>
                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $purchase->purchase_date->format('F d, Y') }}</p>
            </div>
        </div>
    </div>

    <!-- GRN Form -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Receive Items</h3>
        </div>
        
        <form id="grnForm" class="p-6">
            @csrf
            
            <!-- Delivery Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label for="delivery_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Delivery Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="delivery_date" name="delivery_date" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Delivery Notes
                    </label>
                    <textarea id="notes" name="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="Notes about the delivery..."></textarea>
                </div>
            </div>

            <!-- Items to Receive -->
            <div class="mb-8">
                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Items to Receive</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ordered</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Already Received</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pending</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Receive Now</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($purchase->items as $item)
                            @if($item->quantity_pending > 0)
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
                                    {{ $item->quantity_ordered }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 dark:text-green-400">
                                    {{ $item->quantity_received }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-600 dark:text-yellow-400">
                                    {{ $item->quantity_pending }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <input type="number" 
                                               name="received_items[{{ $loop->index }}][item_id]" 
                                               value="{{ $item->id }}" 
                                               hidden>
                                        <input type="number" 
                                               name="received_items[{{ $loop->index }}][quantity]" 
                                               min="0" 
                                               max="{{ $item->quantity_pending }}" 
                                               value="{{ $item->quantity_pending }}"
                                               class="receive-quantity w-20 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                                        <button type="button" onclick="setMaxQuantity(this)" class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                            All
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($purchase->items->where('quantity_pending', '>', 0)->count() == 0)
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="mt-2">All items have been received for this purchase order.</p>
                </div>
                @endif
            </div>

            <!-- Form Actions -->
            @if($purchase->items->where('quantity_pending', '>', 0)->count() > 0)
            <div class="flex justify-between items-center pt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                    <label for="selectAll" class="text-sm text-gray-700 dark:text-gray-300">Receive all pending items</label>
                </div>
                
                <div class="flex space-x-3">
                    <a href="{{ route('admin.purchases.show', $purchase) }}" class="px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Receive Items
                        </span>
                    </button>
                </div>
            </div>
            @endif
        </form>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Select All functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            const quantityInputs = document.querySelectorAll('.receive-quantity');
            quantityInputs.forEach(input => {
                if (this.checked) {
                    input.value = input.getAttribute('max');
                } else {
                    input.value = '0';
                }
            });
        });

        // Set max quantity for individual items
        function setMaxQuantity(button) {
            const input = button.parentElement.querySelector('.receive-quantity');
            input.value = input.getAttribute('max');
        }

        // Form submission
        document.getElementById('grnForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Check if any items are being received
            const quantityInputs = document.querySelectorAll('.receive-quantity');
            let totalReceiving = 0;
            
            quantityInputs.forEach(input => {
                totalReceiving += parseInt(input.value) || 0;
            });
            
            if (totalReceiving === 0) {
                Swal.fire({
                    title: 'No Items Selected',
                    text: 'Please specify quantities to receive for at least one item.',
                    icon: 'warning',
                    confirmButtonColor: '#3B82F6'
                });
                return;
            }
            
            // Confirm the action
            Swal.fire({
                title: 'Confirm Receipt',
                text: `You are about to receive ${totalReceiving} items. This will update your inventory. Continue?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10B981',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, receive items'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData(this);
                    
                    fetch('{{ route('admin.purchases.receive', $purchase) }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Success!', data.message, 'success').then(() => {
                                if (data.redirect) {
                                    window.location.href = data.redirect;
                                }
                            });
                        } else {
                            Swal.fire('Error!', data.message || 'Something went wrong!', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'Something went wrong!', 'error');
                    });
                }
            });
        });
    </script>
</x-admin-layout>
