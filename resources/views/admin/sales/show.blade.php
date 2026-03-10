<x-admin-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Sale Details</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Sale #{{ $sale->id }} - {{ $sale->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.sales.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Sales
                    </a>
                    @if($sale->canBeRefunded())
                    <button onclick="openRefundModal()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                        </svg>
                        Process Refund
                    </button>
                    @endif
                    @if($sale->canBeCorrected())
                    <a href="{{ route('admin.sales.edit', $sale) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Correct Sale
                    </a>
                    @endif
                </div>
            </div>

            <!-- Sale Information -->
            <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Sale Details -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Sale Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Product Details</h4>
                                    <div class="mt-2">
                                        <p class="text-lg font-medium text-gray-900 dark:text-white">{{ $sale->product->name }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $sale->product->description }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Category: {{ $sale->product->category }}</p>
                                        @if($sale->product->brand)
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Brand: {{ $sale->product->brand }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Transaction Details</h4>
                                    <div class="mt-2 space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">Quantity:</span>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $sale->quantity }} {{ $sale->product->unit }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">Unit Price:</span>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">Rs. {{ number_format($sale->unit_price, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between border-t border-gray-200 dark:border-gray-700 pt-2">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">Total Amount:</span>
                                            <span class="text-lg font-bold text-green-600">Rs. {{ number_format($sale->total_amount, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Sale Type</h4>
                                    <div class="mt-2">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            @if($sale->type === 'sale') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-200
                                            @elseif($sale->type === 'refund') bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-200
                                            @else bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-200
                                            @endif">
                                            {{ ucfirst($sale->type) }}
                                        </span>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Status</h4>
                                    <div class="mt-2">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            @if($sale->status === 'completed') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-200
                                            @elseif($sale->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-200
                                            @else bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-200
                                            @endif">
                                            {{ ucfirst($sale->status) }}
                                        </span>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Staff Member</h4>
                                    <div class="mt-2">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $sale->user->name }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $sale->user->email }}</p>
                                    </div>
                                </div>
                            </div>

                            @if($sale->notes)
                            <div class="mt-6">
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Notes</h4>
                                <div class="mt-2 p-3 bg-gray-50 dark:bg-gray-700 rounded-md">
                                    <p class="text-sm text-gray-900 dark:text-white">{{ $sale->notes }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Timestamps -->
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Timestamps</h3>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Created</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $sale->created_at->format('M d, Y H:i:s') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Last Updated</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $sale->updated_at->format('M d, Y H:i:s') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Records -->
                    @if($sale->refunds->count() > 0 || $sale->corrections->count() > 0)
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Related Records</h3>
                            
                            @if($sale->refunds->count() > 0)
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Refunds</h4>
                                <div class="space-y-2">
                                    @foreach($sale->refunds as $refund)
                                    <div class="p-3 bg-red-50 dark:bg-red-900/20 rounded-md">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="text-sm font-medium text-red-800 dark:text-red-200">Rs. {{ number_format($refund->total_amount, 2) }}</p>
                                                <p class="text-xs text-red-600 dark:text-red-300">{{ $refund->created_at->format('M d, Y H:i') }}</p>
                                            </div>
                                            <span class="text-xs text-red-600 dark:text-red-300">{{ $refund->quantity }} {{ $refund->product->unit }}</span>
                                        </div>
                                        @if($refund->notes)
                                        <p class="text-xs text-red-600 dark:text-red-300 mt-1">{{ $refund->notes }}</p>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if($sale->corrections->count() > 0)
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Corrections</h4>
                                <div class="space-y-2">
                                    @foreach($sale->corrections as $correction)
                                    <div class="p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-md">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Rs. {{ number_format($correction->total_amount, 2) }}</p>
                                                <p class="text-xs text-yellow-600 dark:text-yellow-300">{{ $correction->created_at->format('M d, Y H:i') }}</p>
                                            </div>
                                            <span class="text-xs text-yellow-600 dark:text-yellow-300">{{ $correction->quantity }} {{ $correction->product->unit }}</span>
                                        </div>
                                        @if($correction->notes)
                                        <p class="text-xs text-yellow-600 dark:text-yellow-300 mt-1">{{ $correction->notes }}</p>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Refund Modal -->
    @if($sale->canBeRefunded())
    <div id="refundModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Process Refund</h3>
                <form method="POST" action="{{ route('admin.sales.refund', $sale) }}" id="refundForm">
                    @csrf
                    <div class="mb-4">
                        <label for="refund_quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Refund Quantity</label>
                        <input type="number" id="refund_quantity" name="refund_quantity" min="1" max="{{ $sale->quantity }}" value="{{ $sale->quantity }}" required class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Maximum: {{ $sale->quantity }} {{ $sale->product->unit }}</p>
                    </div>
                    <div class="mb-4">
                        <label for="refund_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Refund Reason *</label>
                        <textarea id="refund_reason" name="refund_reason" rows="3" required class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" placeholder="Please provide a reason for the refund..."></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeRefundModal()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Cancel
                        </button>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Process Refund
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <script>
        function openRefundModal() {
            document.getElementById('refundModal').classList.remove('hidden');
        }

        function closeRefundModal() {
            document.getElementById('refundModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('refundModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeRefundModal();
            }
        });
    </script>
</x-admin-layout>
