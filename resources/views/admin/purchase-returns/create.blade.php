<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create Purchase Return</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Return items from a purchase order.</p>
            </div>
            <a href="{{ route('admin.purchase-returns.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Returns
            </a>
        </div>
    </div>

    <!-- Return Form -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <form id="returnForm" class="p-6">
            @csrf
            
            <!-- Purchase Selection -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div>
                    <label for="purchase_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Purchase Order <span class="text-red-500">*</span>
                    </label>
                    <select id="purchase_id" name="purchase_id" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Select Purchase Order</option>
                        @foreach($purchases as $purchase)
                            <option value="{{ $purchase->id }}" {{ request('purchase_id') == $purchase->id ? 'selected' : '' }}>
                                {{ $purchase->purchase_number }} - {{ $purchase->supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="return_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Return Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="return_date" name="return_date" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                </div>
            </div>

            <!-- Product Selection (will be populated via AJAX) -->
            <div id="productSection" class="mb-8" style="display: none;">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label for="product_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Product <span class="text-red-500">*</span>
                        </label>
                        <select id="product_id" name="product_id" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Select Product</option>
                        </select>
                    </div>

                    <div>
                        <label for="quantity_returned" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Quantity to Return <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="quantity_returned" name="quantity_returned" min="1" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                        <p id="quantityHelp" class="mt-1 text-xs text-gray-500 dark:text-gray-400"></p>
                    </div>
                </div>
            </div>

            <!-- Return Details -->
            <div id="returnDetails" class="mb-8" style="display: none;">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Return Reason <span class="text-red-500">*</span>
                        </label>
                        <select id="reason" name="reason" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Select Reason</option>
                            @foreach($reasons as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="reason_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea id="reason_description" name="reason_description" rows="3" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="Describe the reason for return..."></textarea>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Additional Notes
                    </label>
                    <textarea id="notes" name="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" placeholder="Additional notes..."></textarea>
                </div>
            </div>

            <!-- Form Actions -->
            <div id="formActions" class="flex justify-end space-x-3" style="display: none;">
                <a href="{{ route('admin.purchase-returns.index') }}" class="px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Create Return
                    </span>
                </button>
            </div>
        </form>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('purchase_id').addEventListener('change', function() {
            const purchaseId = this.value;
            const productSection = document.getElementById('productSection');
            const productSelect = document.getElementById('product_id');
            
            if (purchaseId) {
                // Fetch products for this purchase
                fetch(`/admin/purchases/${purchaseId}/items`)
                    .then(response => response.json())
                    .then(data => {
                        productSelect.innerHTML = '<option value="">Select Product</option>';
                        data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = `${item.name} (Received: ${item.quantity_received})`;
                            option.setAttribute('data-quantity', item.quantity_received);
                            option.setAttribute('data-cost', item.unit_cost);
                            productSelect.appendChild(option);
                        });
                        productSection.style.display = 'block';
                    })
                    .catch(error => {
                        console.error('Error fetching products:', error);
                        Swal.fire('Error!', 'Failed to load products for this purchase.', 'error');
                    });
            } else {
                productSection.style.display = 'none';
                document.getElementById('returnDetails').style.display = 'none';
                document.getElementById('formActions').style.display = 'none';
            }
        });

        document.getElementById('product_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const quantityInput = document.getElementById('quantity_returned');
            const quantityHelp = document.getElementById('quantityHelp');
            const returnDetails = document.getElementById('returnDetails');
            const formActions = document.getElementById('formActions');
            
            if (this.value) {
                const maxQuantity = selectedOption.getAttribute('data-quantity');
                quantityInput.max = maxQuantity;
                quantityInput.value = 1;
                quantityHelp.textContent = `Maximum quantity that can be returned: ${maxQuantity}`;
                
                returnDetails.style.display = 'block';
                formActions.style.display = 'flex';
            } else {
                returnDetails.style.display = 'none';
                formActions.style.display = 'none';
            }
        });

        document.getElementById('returnForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route('admin.purchase-returns.store') }}', {
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
        });

        // Auto-load products if purchase_id is provided via URL
        if (document.getElementById('purchase_id').value) {
            document.getElementById('purchase_id').dispatchEvent(new Event('change'));
        }
    </script>
</x-admin-layout>
