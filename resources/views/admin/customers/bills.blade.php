<x-admin-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Customer Bills</h1>
            <div id="customer-info" class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Loading customer information...
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Due</dt>
                                <dd id="total-due" class="text-lg font-medium text-gray-900 dark:text-white">Rs. 0.00</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Overdue Amount</dt>
                                <dd id="overdue-amount" class="text-lg font-medium text-gray-900 dark:text-white">Rs. 0.00</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Bills</dt>
                                <dd id="bills-count" class="text-lg font-medium text-gray-900 dark:text-white">0</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bills Table -->
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Outstanding Bills</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Detailed list of all outstanding bills</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Invoice #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Due Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Paid Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Due Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="bills-tbody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <!-- Bills will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bill Details Modal -->
    <div id="billDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Bill Details</h3>
                    <button onclick="closeBillDetailsModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div id="billDetailsContent">
                    <!-- Bill details will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        let customerId;

        document.addEventListener('DOMContentLoaded', function() {
            // Get customer ID from URL
            const urlParts = window.location.pathname.split('/');
            customerId = urlParts[urlParts.indexOf('customers') + 1];
            
            if (customerId) {
                loadCustomerBills();
            } else {
                document.getElementById('customer-info').textContent = 'Invalid customer ID';
            }
        });

        function loadCustomerBills() {
            fetch(`/admin/customers/${customerId}/bills`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayCustomerInfo(data.customer);
                        displaySummary(data.summary);
                        displayBills(data.bills);
                    } else {
                        document.getElementById('customer-info').textContent = 'Error loading customer data';
                    }
                })
                .catch(error => {
                    console.error('Error loading customer bills:', error);
                    document.getElementById('customer-info').textContent = 'Error loading customer data';
                });
        }

        function displayCustomerInfo(customer) {
            document.getElementById('customer-info').innerHTML = `
                <div class="flex items-center space-x-4">
                    <div>
                        <span class="font-semibold">${customer.name}</span>
                        <span class="text-gray-500">•</span>
                        <span>${customer.email}</span>
                        <span class="text-gray-500">•</span>
                        <span>${customer.phone}</span>
                    </div>
                </div>
            `;
        }

        function displaySummary(summary) {
            document.getElementById('total-due').textContent = `Rs. ${parseFloat(summary.total_due).toFixed(2)}`;
            document.getElementById('overdue-amount').textContent = `Rs. ${parseFloat(summary.overdue_amount).toFixed(2)}`;
            document.getElementById('bills-count').textContent = summary.bills_count;
        }

        function displayBills(bills) {
            const tbody = document.getElementById('bills-tbody');
            
            if (bills.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" class="text-center py-8 text-gray-500">No outstanding bills found</td></tr>';
                return;
            }

            tbody.innerHTML = bills.map(bill => `
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600 hover:text-blue-900">
                        <button onclick="viewBillDetails(${bill.id})" class="hover:underline">
                            ${bill.invoice_number}
                        </button>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                        ${new Date(bill.order_date).toLocaleDateString()}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                        ${bill.due_date ? new Date(bill.due_date).toLocaleDateString() : 'N/A'}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                        Rs. ${parseFloat(bill.total_amount).toFixed(2)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                        Rs. ${parseFloat(bill.paid_amount).toFixed(2)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600">
                        Rs. ${parseFloat(bill.due_amount).toFixed(2)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        ${bill.is_overdue ? 
                            `<span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                Overdue (${bill.days_overdue} days)
                            </span>` :
                            `<span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Due
                            </span>`
                        }
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="viewBillDetails(${bill.id})" class="text-blue-600 hover:text-blue-900 mr-2">View</button>
                        <button onclick="makePayment(${bill.id})" class="text-green-600 hover:text-green-900">Pay</button>
                    </td>
                </tr>
            `).join('');
        }

        function viewBillDetails(billId) {
            // Find the bill in the current data
            fetch(`/admin/customers/${customerId}/bills`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const bill = data.bills.find(b => b.id === billId);
                        if (bill) {
                            displayBillDetailsModal(bill);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading bill details:', error);
                });
        }

        function displayBillDetailsModal(bill) {
            const content = document.getElementById('billDetailsContent');
            
            let itemsHtml = '';
            if (bill.items && bill.items.length > 0) {
                itemsHtml = `
                    <div class="mt-6">
                        <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Items</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Product</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Qty</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Price</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    ${bill.items.map(item => `
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-300">${item.product_name}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-300">${item.quantity}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-300">Rs. ${parseFloat(item.unit_price).toFixed(2)}</td>
                                            <td class="px-4 py-2 text-sm font-medium text-gray-900 dark:text-white">Rs. ${parseFloat(item.total_price).toFixed(2)}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    </div>
                `;
            }

            content.innerHTML = `
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Invoice Number</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">${bill.invoice_number}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order Number</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">${bill.order_number}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order Date</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">${new Date(bill.order_date).toLocaleDateString()}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Due Date</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">${bill.due_date ? new Date(bill.due_date).toLocaleDateString() : 'N/A'}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Amount</label>
                        <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">Rs. ${parseFloat(bill.total_amount).toFixed(2)}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Paid Amount</label>
                        <p class="mt-1 text-sm font-medium text-green-600">Rs. ${parseFloat(bill.paid_amount).toFixed(2)}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Due Amount</label>
                        <p class="mt-1 text-sm font-medium text-red-600">Rs. ${parseFloat(bill.due_amount).toFixed(2)}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <p class="mt-1">
                            ${bill.is_overdue ? 
                                `<span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    Overdue (${bill.days_overdue} days)
                                </span>` :
                                `<span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Due
                                </span>`
                            }
                        </p>
                    </div>
                </div>
                ${itemsHtml}
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button onclick="makePayment(${bill.id})" class="px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                        Make Payment
                    </button>
                    <button onclick="closeBillDetailsModal()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                        Close
                    </button>
                </div>
            `;

            document.getElementById('billDetailsModal').classList.remove('hidden');
        }

        function closeBillDetailsModal() {
            document.getElementById('billDetailsModal').classList.add('hidden');
        }

        function makePayment(billId) {
            // Redirect to payment page with pre-filled order ID
            window.location.href = `/admin/payments/create?order_id=${billId}`;
        }
    </script>
</x-admin-layout>
