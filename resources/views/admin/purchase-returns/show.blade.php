<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Purchase Return #{{ $purchaseReturn->return_number }}</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">View purchase return details and manage approval.</p>
            </div>
            <a href="{{ route('admin.purchase-returns.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Returns
            </a>
        </div>
    </div>

    <!-- Return Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Return Information -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Return Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Return Number</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $purchaseReturn->return_number }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Return Date</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $purchaseReturn->return_date->format('F d, Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Purchase Order</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">
                            <a href="{{ route('admin.purchases.show', $purchaseReturn->purchase) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                {{ $purchaseReturn->purchase->purchase_number }}
                            </a>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Supplier</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $purchaseReturn->purchase->supplier->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Created By</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $purchaseReturn->user->name }}</p>
                    </div>
                    @if($purchaseReturn->approved_by)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Approved By</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $purchaseReturn->approvedBy->name }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Product Information -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Product Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Product Name</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white font-medium">{{ $purchaseReturn->product->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">SKU</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $purchaseReturn->product->sku }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Quantity Returned</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $purchaseReturn->quantity_returned }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Unit Cost</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ \App\Helpers\CurrencyHelper::format($purchaseReturn->unit_cost) }}</p>
                    </div>
                </div>
            </div>

            <!-- Return Reason -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Return Reason</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Reason</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $purchaseReturn->formatted_reason }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Description</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $purchaseReturn->reason_description }}</p>
                    </div>
                    @if($purchaseReturn->notes)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Notes</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $purchaseReturn->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status & Actions -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Status</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Current Status</label>
                        <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium
                            @if($purchaseReturn->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                            @elseif($purchaseReturn->status === 'approved') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                            @elseif($purchaseReturn->status === 'processed') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                            @elseif($purchaseReturn->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                            @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                            @endif">
                            {{ $purchaseReturn->formatted_status }}
                        </span>
                    </div>
                    @if($purchaseReturn->approved_at)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Approved At</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $purchaseReturn->approved_at->format('F d, Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Amount Details -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Amount Details</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Return Amount:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ \App\Helpers\CurrencyHelper::format($purchaseReturn->total_amount) }}</span>
                    </div>
                    @if($purchaseReturn->refund_amount)
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Refund Amount:</span>
                        <span class="font-medium text-green-600 dark:text-green-400">{{ \App\Helpers\CurrencyHelper::format($purchaseReturn->refund_amount) }}</span>
                    </div>
                    @endif
                    @if($purchaseReturn->refund_method)
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Refund Method:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $purchaseReturn->formatted_refund_method }}</span>
                    </div>
                    @endif
                    @if($purchaseReturn->refund_date)
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Refund Date:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $purchaseReturn->refund_date->format('M d, Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Actions</h3>
                <div class="space-y-3">
                    @if($purchaseReturn->can_be_approved)
                        <button onclick="approveReturn()" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Approve Return
                        </button>
                        <button onclick="rejectReturn()" class="w-full inline-flex justify-center items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-lg text-red-700 bg-white hover:bg-red-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Reject Return
                        </button>
                    @endif

                    @if($purchaseReturn->can_be_processed)
                        <button onclick="processReturn()" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-purple-600 hover:bg-purple-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Process Return
                        </button>
                    @endif

                    @if($purchaseReturn->status === 'processed')
                        <button onclick="completeReturn()" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            Complete & Refund
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function approveReturn() {
            Swal.fire({
                title: 'Approve Return?',
                text: "This return will be approved and can then be processed.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10B981',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    performAction('approve', 'PATCH');
                }
            });
        }

        function rejectReturn() {
            Swal.fire({
                title: 'Reject Return?',
                input: 'textarea',
                inputLabel: 'Rejection Reason',
                inputPlaceholder: 'Please provide a reason for rejection...',
                inputValidator: (value) => {
                    if (!value) {
                        return 'You need to provide a reason for rejection!'
                    }
                },
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, reject it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    performAction('reject', 'PATCH', { rejection_reason: result.value });
                }
            });
        }

        function processReturn() {
            Swal.fire({
                title: 'Process Return?',
                text: "This will reduce the inventory and cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#8B5CF6',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, process it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    performAction('process', 'PATCH');
                }
            });
        }

        function completeReturn() {
            Swal.fire({
                title: 'Complete Return',
                html: `
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Refund Method</label>
                            <select id="refund_method" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                <option value="credit_note">Credit Note</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="cash">Cash</option>
                                <option value="replacement">Replacement</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Refund Amount</label>
                            <input type="number" id="refund_amount" step="0.01" value="{{ $purchaseReturn->total_amount }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Refund Date</label>
                            <input type="date" id="refund_date" value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonColor: '#3B82F6',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Complete Return',
                preConfirm: () => {
                    const refundMethod = document.getElementById('refund_method').value;
                    const refundAmount = document.getElementById('refund_amount').value;
                    const refundDate = document.getElementById('refund_date').value;
                    
                    if (!refundMethod || !refundAmount || !refundDate) {
                        Swal.showValidationMessage('Please fill all fields');
                        return false;
                    }
                    
                    return {
                        refund_method: refundMethod,
                        refund_amount: refundAmount,
                        refund_date: refundDate
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    performAction('complete', 'PATCH', result.value);
                }
            });
        }

        function performAction(action, method, data = {}) {
            fetch(`{{ route('admin.purchase-returns.show', $purchaseReturn) }}`.replace('show', action), {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success!', data.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Something went wrong!', 'error');
            });
        }
    </script>
</x-admin-layout>
