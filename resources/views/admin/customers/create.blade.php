<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Add New Customer</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Create a new customer with all necessary details.</p>
            </div>
            <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Customers
            </a>
        </div>
    </div>

    <!-- Customer Form -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <form method="POST" action="{{ route('admin.customers.store') }}" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Customer Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Customer Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                           placeholder="Enter customer name">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Customer Type -->
                <div>
                    <label for="customer_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Customer Type <span class="text-red-500">*</span>
                    </label>
                    <select id="customer_type" name="customer_type" required
                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Select Customer Type</option>
                        <option value="individual" {{ old('customer_type') == 'individual' ? 'selected' : '' }}>Individual</option>
                        <option value="shop" {{ old('customer_type') == 'shop' ? 'selected' : '' }}>Shop</option>
                        <option value="institute" {{ old('customer_type') == 'institute' ? 'selected' : '' }}>Institute</option>
                        <option value="company" {{ old('customer_type') == 'company' ? 'selected' : '' }}>Company</option>
                    </select>
                    @error('customer_type')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                           placeholder="Enter email address">
                    <div id="emailValidation" class="text-sm mt-1"></div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Phone <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                           class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                           placeholder="Enter phone number">
                    <div id="phoneValidation" class="text-sm mt-1"></div>
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Company Name (for business customers) -->
                <div id="companyFields" class="hidden">
                    <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Company Name
                    </label>
                    <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}"
                           class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                           placeholder="Enter company name">
                    @error('company_name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Person (for business customers) -->
                <div id="contactPersonField" class="hidden">
                    <label for="contact_person" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Contact Person
                    </label>
                    <input type="text" id="contact_person" name="contact_person" value="{{ old('contact_person') }}"
                           class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                           placeholder="Enter contact person name">
                    @error('contact_person')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Address <span class="text-red-500">*</span>
                    </label>
                    <textarea id="address" name="address" rows="3" required
                              class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                              placeholder="Enter complete address">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- City -->
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        City <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="city" name="city" value="{{ old('city') }}" required
                           class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                           placeholder="Enter city">
                    @error('city')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- State -->
                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        State <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="state" name="state" value="{{ old('state') }}" required
                           class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                           placeholder="Enter state">
                    @error('state')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Postal Code -->
                <div>
                    <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Postal Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" required
                           class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                           placeholder="Enter postal code">
                    @error('postal_code')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tax Number -->
                <div>
                    <label for="tax_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Tax Number
                    </label>
                    <input type="text" id="tax_number" name="tax_number" value="{{ old('tax_number') }}"
                           class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                           placeholder="Enter tax number">
                    @error('tax_number')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select id="status" name="status" required
                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Notes
                    </label>
                    <textarea id="notes" name="notes" rows="3"
                              class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                              placeholder="Enter any additional notes">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Create Customer
                </button>
            </div>
        </form>
    </div>

    <script>
        // Dynamic field visibility based on customer type
        document.getElementById('customer_type').addEventListener('change', function() {
            const customerType = this.value;
            const companyFields = document.getElementById('companyFields');
            const contactPersonField = document.getElementById('contactPersonField');
            
            if (customerType === 'shop' || customerType === 'institute' || customerType === 'company') {
                companyFields.style.display = 'block';
                contactPersonField.style.display = 'block';
            } else {
                companyFields.style.display = 'none';
                contactPersonField.style.display = 'none';
            }
        });

        // Real-time validation for email
        let emailTimeout;
        document.getElementById('email').addEventListener('input', function() {
            clearTimeout(emailTimeout);
            const email = this.value;
            const validationDiv = document.getElementById('emailValidation');
            
            if (email.length > 0) {
                emailTimeout = setTimeout(() => {
                    validateField('email', email);
                }, 500);
            } else {
                validationDiv.innerHTML = '';
            }
        });

        // Real-time validation for phone
        let phoneTimeout;
        document.getElementById('phone').addEventListener('input', function() {
            clearTimeout(phoneTimeout);
            const phone = this.value;
            const validationDiv = document.getElementById('phoneValidation');
            
            if (phone.length > 0) {
                phoneTimeout = setTimeout(() => {
                    validateField('phone', phone);
                }, 500);
            } else {
                validationDiv.innerHTML = '';
            }
        });

        function validateField(field, value) {
            const validationDiv = document.getElementById(field + 'Validation');
            
            fetch(`{{ route('admin.customers.validate-field') }}?field=${field}&value=${encodeURIComponent(value)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        validationDiv.innerHTML = `<span class="text-red-600 dark:text-red-400">This ${field} is already registered.</span>`;
                    } else {
                        validationDiv.innerHTML = `<span class="text-green-600 dark:text-green-400">✓ ${field.charAt(0).toUpperCase() + field.slice(1)} is available.</span>`;
                    }
                })
                .catch(error => {
                    console.error('Validation error:', error);
                });
        }
    </script>
</x-admin-layout>
