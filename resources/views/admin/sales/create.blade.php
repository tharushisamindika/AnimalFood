<x-admin-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Record New Sale</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Enter sale details and process the transaction</p>
                </div>
                <a href="{{ route('admin.sales.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Sales
                </a>
            </div>

            <!-- Sales Target Card -->
            @if($todayTarget)
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Today's Target Progress</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Current: Rs. {{ number_format($todayTarget->achieved_amount, 2) }} / Target: Rs. {{ number_format($todayTarget->daily_target, 2) }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-green-600">{{ number_format($todayTarget->getProgressPercentage(), 1) }}%</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Complete</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ min(100, $todayTarget->getProgressPercentage()) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Sales Form -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <form method="POST" action="{{ route('admin.sales.store') }}" id="saleForm">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Product Selection -->
                            <div>
                                <label for="product_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product *</label>
                                <select id="product_id" name="product_id" required class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                                    <option value="">Select a product</option>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                        data-price="{{ $product->price }}"
                                        data-stock="{{ $product->stock_quantity }}"
                                        data-unit="{{ $product->unit }}">
                                        {{ $product->name }} - Rs. {{ number_format($product->price, 2) }} ({{ $product->stock_quantity }} {{ $product->unit }} in stock)
                                    </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity *</label>
                                <input type="number" id="quantity" name="quantity" min="1" step="1" required class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400" id="stock-info"></p>
                                @error('quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Unit Price -->
                            <div>
                                <label for="unit_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Unit Price *</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400 sm:text-sm">Rs.</span>
                                    </div>
                                    <input type="number" id="unit_price" name="unit_price" min="0" step="0.01" required class="pl-7 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                                </div>
                                @error('unit_price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Total Amount (Read-only) -->
                            <div>
                                <label for="total_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Amount</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400 sm:text-sm">Rs.</span>
                                    </div>
                                    <input type="text" id="total_amount" readonly class="pl-7 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm bg-gray-50 dark:bg-gray-600">
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mt-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes (Optional)</label>
                            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" placeholder="Any additional notes about this sale..."></textarea>
                            @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('admin.sales.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Record Sale
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productSelect = document.getElementById('product_id');
            const quantityInput = document.getElementById('quantity');
            const unitPriceInput = document.getElementById('unit_price');
            const totalAmountInput = document.getElementById('total_amount');
            const stockInfo = document.getElementById('stock-info');

            function updateTotal() {
                const quantity = parseFloat(quantityInput.value) || 0;
                const unitPrice = parseFloat(unitPriceInput.value) || 0;
                const total = quantity * unitPrice;
                totalAmountInput.value = total.toFixed(2);
            }

            function updateStockInfo() {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    const stock = parseInt(selectedOption.dataset.stock);
                    const unit = selectedOption.dataset.unit;
                    stockInfo.textContent = `${stock} ${unit} available in stock`;
                    
                    // Set max quantity
                    quantityInput.max = stock;
                    
                    // Auto-fill unit price
                    unitPriceInput.value = selectedOption.dataset.price;
                    updateTotal();
                } else {
                    stockInfo.textContent = '';
                    quantityInput.max = '';
                    unitPriceInput.value = '';
                    totalAmountInput.value = '';
                }
            }

            function validateQuantity() {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    const stock = parseInt(selectedOption.dataset.stock);
                    const quantity = parseInt(quantityInput.value);
                    
                    if (quantity > stock) {
                        quantityInput.setCustomValidity(`Only ${stock} units available in stock`);
                        quantityInput.classList.add('border-red-500');
                    } else {
                        quantityInput.setCustomValidity('');
                        quantityInput.classList.remove('border-red-500');
                    }
                }
            }

            // Event listeners
            productSelect.addEventListener('change', updateStockInfo);
            quantityInput.addEventListener('input', function() {
                updateTotal();
                validateQuantity();
            });
            unitPriceInput.addEventListener('input', updateTotal);

            // Initialize
            updateStockInfo();
        });
    </script>
</x-admin-layout>
