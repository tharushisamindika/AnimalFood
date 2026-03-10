<x-admin-layout>
    <style>
        /* Enhanced glowing effects for validation */
        .border-red-500 {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
        }
        
        .border-green-500 {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
        }
        
        .focus\:ring-red-500:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2) !important;
        }
        
        .focus\:ring-green-500:focus {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2) !important;
        }
        
        /* Smooth transitions for all form elements */
        input, select {
            transition: all 0.2s ease-in-out;
        }
        
        /* Disable field progression */
        input:invalid {
            pointer-events: auto;
        }
    </style>

    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Register New User</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Create a new user account for the Animal Food System</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.users') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Users
                </a>
            </div>
        </div>
    </div>

    <!-- Registration Form -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">User Registration Form</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Fill in the details below to create a new user account.</p>
        </div>
        
        <div class="p-6">
                <form method="POST" action="{{ route('register') }}" class="space-y-6" enctype="multipart/form-data" id="registrationForm" onsubmit="return validateForm()">
                    @csrf

                    <!-- Avatar Upload Section -->
                    <div class="flex flex-col items-center space-y-4">
                        <div class="relative">
                            <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700 border-4 border-gray-200 dark:border-gray-600">
                                <img id="avatar-preview" src="{{ asset('images/user.png') }}" alt="Avatar Preview" class="w-full h-full object-cover">
                            </div>
                            <label for="avatar" class="absolute bottom-0 right-0 bg-green-500 hover:bg-green-600 text-white rounded-full p-2 cursor-pointer shadow-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </label>
                        </div>
                        <div class="text-center">
                            <label for="avatar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Profile Picture
                            </label>
                            <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden" onchange="previewImage(this)">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Click the camera icon to upload an image (JPG, PNG, GIF up to 2MB)</p>
                        </div>
                        @error('avatar')
                            <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Personal Information Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" id="name-label" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Full Name <span class="text-red-500">*</span>
                                <span id="name-error" class="text-red-500 text-xs ml-2 hidden"></span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg id="name-icon" class="h-5 w-5 text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name"
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 transition-all duration-200 @error('name') border-red-500 dark:border-red-400 @enderror"
                                    placeholder="Enter full name"
                                    oninput="validateName(this)"
                                    onkeypress="return allowOnlyLettersAndSpaces(event)"
                                    onpaste="return false">
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email" id="email-label" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Email Address <span class="text-red-500">*</span>
                                <span id="email-error" class="text-red-500 text-xs ml-2 hidden"></span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg id="email-icon" class="h-5 w-5 text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                </div>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username"
                                    class="block w-full pl-10 pr-10 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 transition-all duration-200 @error('email') border-red-500 dark:border-red-400 @enderror"
                                    placeholder="Enter email address"
                                    oninput="validateEmail(this)">
                                <!-- Email validation indicator -->
                                <div id="email-validation" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none hidden">
                                    <svg id="email-valid-icon" class="h-5 w-5 text-green-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <svg id="email-invalid-icon" class="h-5 w-5 text-red-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                            </div>
                            <div id="email-feedback" class="mt-2 text-sm hidden"></div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div>
                        <label for="role" id="role-label" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Role <span class="text-red-500">*</span>
                            <span id="role-error" class="text-red-500 text-xs ml-2 hidden"></span>
                        </label>
                        <div class="relative max-w-md">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg id="role-icon" class="h-5 w-5 text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <select id="role" name="role" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 @error('role') border-red-500 dark:border-red-400 @enderror"
                                onchange="validateRole(this)">
                                <option value="">Select user role</option>
                                <option value="cashier" {{ old('role') == 'cashier' ? 'selected' : '' }}>Cashier</option>
                                <option value="administrator" {{ old('role') == 'administrator' ? 'selected' : '' }}>Administrator</option>
                                <option value="super_administrator" {{ old('role') == 'super_administrator' ? 'selected' : '' }}>Super Administrator</option>
                            </select>
                        </div>
                        @error('role')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div>
                            <label for="password" id="password-label" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Password <span class="text-red-500">*</span>
                                <span id="password-error" class="text-red-500 text-xs ml-2 hidden"></span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg id="password-icon" class="h-5 w-5 text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input id="password" name="password" type="password" required autocomplete="new-password"
                                    class="block w-full pl-10 pr-40 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 transition-all duration-200 @error('password') border-red-500 dark:border-red-400 @enderror"
                                    placeholder="Create a password"
                                    oninput="validatePassword(this)">
                                <button type="button" id="togglePasswordBtn" class="absolute inset-y-0 right-20 px-3 flex items-center text-sm text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition-colors duration-200">
                                    <svg id="password-eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <button type="button" id="generatePasswordBtn" class="absolute inset-y-0 right-0 px-3 flex items-center text-sm text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Generate
                                </button>
                            </div>
                            <!-- Password Requirements -->
                            <div id="password-requirements" class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                <div id="req-length" class="flex items-center">
                                    <svg class="w-3 h-3 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    At least 8 characters
                                </div>
                                <div id="req-uppercase" class="flex items-center">
                                    <svg class="w-3 h-3 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    One uppercase letter
                                </div>
                                <div id="req-lowercase" class="flex items-center">
                                    <svg class="w-3 h-3 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    One lowercase letter
                                </div>
                                <div id="req-number" class="flex items-center">
                                    <svg class="w-3 h-3 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    One number
                                </div>
                                <div id="req-symbol" class="flex items-center">
                                    <svg class="w-3 h-3 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    One special character
                                </div>
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" id="confirm-password-label" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Confirm Password <span class="text-red-500">*</span>
                                <span id="confirm-password-error" class="text-red-500 text-xs ml-2 hidden"></span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg id="confirm-password-icon" class="h-5 w-5 text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                                    class="block w-full pl-10 pr-12 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 transition-all duration-200"
                                    placeholder="Confirm password"
                                    oninput="validatePasswordConfirmation(this)">
                                <button type="button" id="toggleConfirmPasswordBtn" class="absolute inset-y-0 right-0 px-3 flex items-center text-sm text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition-colors duration-200">
                                    <svg id="confirm-password-eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.users') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                            Cancel
                        </a>
                        <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Create User Account
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Role Information -->
        <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Role Permissions</h3>
                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-white dark:bg-blue-800/50 rounded-lg p-3">
                                <h4 class="font-medium text-blue-900 dark:text-blue-100 mb-2">Cashier</h4>
                                <ul class="text-xs text-blue-700 dark:text-blue-300 space-y-1">
                                    <li>• Process sales transactions</li>
                                    <li>• View inventory levels</li>
                                    <li>• Manage customer information</li>
                                    <li>• Generate basic reports</li>
                                </ul>
                            </div>
                            <div class="bg-white dark:bg-blue-800/50 rounded-lg p-3">
                                <h4 class="font-medium text-blue-900 dark:text-blue-100 mb-2">Administrator</h4>
                                <ul class="text-xs text-blue-700 dark:text-blue-300 space-y-1">
                                    <li>• Full access to all modules</li>
                                    <li>• Manage products & categories</li>
                                    <li>• Manage suppliers & customers</li>
                                    <li>• Generate detailed reports</li>
                                    <li>• System configuration</li>
                                </ul>
                            </div>
                            <div class="bg-white dark:bg-blue-800/50 rounded-lg p-3">
                                <h4 class="font-medium text-blue-900 dark:text-blue-100 mb-2">Super Administrator</h4>
                                <ul class="text-xs text-blue-700 dark:text-blue-300 space-y-1">
                                    <li>• Complete system access</li>
                                    <li>• User management & roles</li>
                                    <li>• System administration</li>
                                    <li>• Database management</li>
                                    <li>• All administrator features</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global validation states
        let validationStates = {
            name: false,
            email: false,
            role: false,
            password: false,
            passwordConfirmation: false
        };

        // Utility function to set field state
        function setFieldState(fieldName, isValid, errorMessage = '') {
            const field = document.getElementById(fieldName);
            const icon = document.getElementById(fieldName + '-icon');
            const error = document.getElementById(fieldName + '-error');
            
            // Update validation state
            validationStates[fieldName === 'password_confirmation' ? 'passwordConfirmation' : fieldName] = isValid;
            
            // Remove all previous classes
            field.classList.remove('border-red-500', 'border-green-500', 'ring-red-500', 'ring-green-500', 'focus:border-red-500', 'focus:border-green-500', 'focus:ring-red-500', 'focus:ring-green-500');
            icon.classList.remove('text-red-500', 'text-green-500');
            
            if (isValid) {
                // Valid state - green
                field.classList.add('border-green-500', 'focus:border-green-500', 'focus:ring-green-500');
                icon.classList.add('text-green-500');
                error.textContent = '';
                error.classList.add('hidden');
            } else if (field.value.length > 0) {
                // Invalid state - red
                field.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
                icon.classList.add('text-red-500');
                error.textContent = errorMessage;
                error.classList.remove('hidden');
            } else {
                // Empty state - default
                field.classList.add('border-gray-300', 'focus:border-blue-500', 'focus:ring-blue-500');
                icon.classList.add('text-gray-400');
                error.textContent = '';
                error.classList.add('hidden');
            }
        }

        // Name validation - only letters and spaces
        function allowOnlyLettersAndSpaces(event) {
            const char = String.fromCharCode(event.which);
            if (!/[a-zA-Z\s]/.test(char)) {
                event.preventDefault();
                return false;
            }
            return true;
        }

        function validateName(input) {
            const value = input.value.trim();
            
            if (value.length === 0) {
                setFieldState('name', false, 'Full name is required');
                return false;
            }
            
            if (value.length < 2) {
                setFieldState('name', false, 'Name must be at least 2 characters');
                return false;
            }
            
            if (!/^[a-zA-Z\s]+$/.test(value)) {
                setFieldState('name', false, 'Only letters and spaces allowed');
                return false;
            }
            
            if (value.split(' ').filter(part => part.length > 0).length < 2) {
                setFieldState('name', false, 'Please enter your full name');
                return false;
            }
            
            setFieldState('name', true);
            return true;
        }

        // Email validation with regex and real-time availability check
        let emailValidationTimeout;
        
        function validateEmail(input) {
            const value = input.value.trim();
            const emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
            
            // Clear previous timeout
            clearTimeout(emailValidationTimeout);
            
            // Hide validation elements
            const emailValidation = document.getElementById('email-validation');
            const emailValidIcon = document.getElementById('email-valid-icon');
            const emailInvalidIcon = document.getElementById('email-invalid-icon');
            const emailFeedback = document.getElementById('email-feedback');
            
            if (emailValidation) {
                emailValidation.classList.add('hidden');
                emailValidIcon.classList.add('hidden');
                emailInvalidIcon.classList.add('hidden');
                emailFeedback.classList.add('hidden');
            }
            
            // Reset border color
            input.classList.remove('border-green-500', 'border-red-500');
            input.classList.add('border-gray-300');
            
            if (value.length === 0) {
                setFieldState('email', false, 'Email address is required');
                return false;
            }
            
            if (!emailRegex.test(value)) {
                setFieldState('email', false, 'Please enter a valid email address');
                return false;
            }
            
            // Debounce the availability check
            emailValidationTimeout = setTimeout(() => {
                checkEmailAvailability(value);
            }, 500);
            
            setFieldState('email', true);
            return true;
        }

        function checkEmailAvailability(email) {
            const emailValidation = document.getElementById('email-validation');
            const emailValidIcon = document.getElementById('email-valid-icon');
            const emailInvalidIcon = document.getElementById('email-invalid-icon');
            const emailFeedback = document.getElementById('email-feedback');
            const emailInput = document.getElementById('email');
            
            if (!emailValidation || !emailValidIcon || !emailInvalidIcon || !emailFeedback || !emailInput) {
                return;
            }
            
            // Show loading state
            emailValidation.classList.remove('hidden');
            emailValidIcon.classList.add('hidden');
            emailInvalidIcon.classList.add('hidden');
            emailFeedback.classList.add('hidden');
            
            fetch('/api/validate-email', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                emailValidation.classList.remove('hidden');
                emailFeedback.classList.remove('hidden');
                
                if (data.valid) {
                    // Email is available
                    emailValidIcon.classList.remove('hidden');
                    emailInvalidIcon.classList.add('hidden');
                    emailInput.classList.remove('border-red-500');
                    emailInput.classList.add('border-green-500');
                    emailFeedback.textContent = data.message;
                    emailFeedback.className = 'mt-2 text-sm text-green-600 dark:text-green-400';
                    setFieldState('email', true);
                } else {
                    // Email is already taken
                    emailValidIcon.classList.add('hidden');
                    emailInvalidIcon.classList.remove('hidden');
                    emailInput.classList.remove('border-green-500');
                    emailInput.classList.add('border-red-500');
                    emailFeedback.textContent = data.message;
                    emailFeedback.className = 'mt-2 text-sm text-red-600 dark:text-red-400';
                    setFieldState('email', false, data.message);
                }
            })
            .catch(error => {
                console.error('Error validating email:', error);
                emailValidation.classList.add('hidden');
                emailFeedback.classList.add('hidden');
            });
        }

        // Role validation
        function validateRole(input) {
            const value = input.value;
            
            if (!value || value === '') {
                setFieldState('role', false, 'Please select a user role');
                return false;
            }
            
            setFieldState('role', true);
            return true;
        }

        // Password validation
        function validatePassword(input) {
            const value = input.value;
            
            // Update password requirements indicators
            const requirements = {
                length: value.length >= 8,
                uppercase: /[A-Z]/.test(value),
                lowercase: /[a-z]/.test(value),
                number: /\d/.test(value),
                symbol: /[!@#$%^&*()_+\-=\[\]{}|;:,.<>?]/.test(value)
            };
            
            // Update visual indicators
            Object.keys(requirements).forEach(req => {
                const element = document.getElementById('req-' + req);
                if (element) {
                    const svg = element.querySelector('svg');
                    
                    if (requirements[req]) {
                        svg.classList.remove('text-gray-400');
                        svg.classList.add('text-green-500');
                        element.classList.remove('text-gray-500');
                        element.classList.add('text-green-600');
                    } else {
                        svg.classList.remove('text-green-500');
                        svg.classList.add('text-gray-400');
                        element.classList.remove('text-green-600');
                        element.classList.add('text-gray-500');
                    }
                }
            });
            
            const isValid = Object.values(requirements).every(req => req);
            
            if (value.length === 0) {
                setFieldState('password', false, 'Password is required');
                return false;
            }
            
            if (!isValid) {
                setFieldState('password', false, 'Password does not meet requirements');
                return false;
            }
            
            setFieldState('password', true);
            
            // Re-validate password confirmation if it has a value
            const confirmField = document.getElementById('password_confirmation');
            if (confirmField.value.length > 0) {
                validatePasswordConfirmation(confirmField);
            }
            
            return true;
        }

        // Password confirmation validation
        function validatePasswordConfirmation(input) {
            const value = input.value;
            const passwordValue = document.getElementById('password').value;
            
            if (value.length === 0) {
                setFieldState('password_confirmation', false, 'Please confirm your password');
                return false;
            }
            
            if (value !== passwordValue) {
                setFieldState('password_confirmation', false, 'Passwords do not match');
                return false;
            }
            
            setFieldState('password_confirmation', true);
            return true;
        }

        // Form validation
        function validateForm() {
            // Validate all fields
            const nameValid = validateName(document.getElementById('name'));
            const emailValid = validateEmail(document.getElementById('email'));
            const roleValid = validateRole(document.getElementById('role'));
            const passwordValid = validatePassword(document.getElementById('password'));
            const confirmValid = validatePasswordConfirmation(document.getElementById('password_confirmation'));
            
            // Check if all validations pass
            const allValid = Object.values(validationStates).every(state => state);
            
            if (!allValid) {
                // Show general error message
                alert('Please fix all validation errors before submitting the form.');
                return false;
            }
            
            return true;
        }

        // Avatar preview function
        function previewImage(input) {
            const preview = document.getElementById('avatar-preview');
            
            if (input.files && input.files[0]) {
                // Validate file size (2MB max)
                const fileSize = input.files[0].size / 1024 / 1024; // Convert to MB
                if (fileSize > 2) {
                    alert('File size must be less than 2MB');
                    input.value = '';
                    preview.src = '{{ asset('images/user.png') }}';
                    return;
                }
                
                // Validate file type
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!validTypes.includes(input.files[0].type)) {
                    alert('Please select a valid image file (JPG, PNG, GIF)');
                    input.value = '';
                    preview.src = '{{ asset('images/user.png') }}';
                    return;
                }
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '{{ asset('images/user.png') }}';
            }
        }

        // Password generation functionality
        document.addEventListener('DOMContentLoaded', function() {
            const generatePasswordBtn = document.getElementById('generatePasswordBtn');
            if (generatePasswordBtn) {
                generatePasswordBtn.addEventListener('click', function() {
                    const password = generateSecurePassword();
                    document.getElementById('password').value = password;
                    document.getElementById('password_confirmation').value = password;
                    
                    // Trigger input events to update validation
                    document.getElementById('password').dispatchEvent(new Event('input'));
                    document.getElementById('password_confirmation').dispatchEvent(new Event('input'));
                });
            }

            // Password reveal/hide functionality
            const togglePasswordBtn = document.getElementById('togglePasswordBtn');
            if (togglePasswordBtn) {
                togglePasswordBtn.addEventListener('click', function() {
                    togglePasswordVisibility('password', 'password-eye-icon');
                });
            }

            const toggleConfirmPasswordBtn = document.getElementById('toggleConfirmPasswordBtn');
            if (toggleConfirmPasswordBtn) {
                toggleConfirmPasswordBtn.addEventListener('click', function() {
                    togglePasswordVisibility('password_confirmation', 'confirm-password-eye-icon');
                });
            }
            
            // Add event listeners for real-time validation
            document.getElementById('name').addEventListener('blur', function() {
                validateName(this);
            });
            
            document.getElementById('email').addEventListener('blur', function() {
                validateEmail(this);
            });
            
            document.getElementById('password').addEventListener('blur', function() {
                validatePassword(this);
            });
            
            document.getElementById('password_confirmation').addEventListener('blur', function() {
                validatePasswordConfirmation(this);
            });
        });

        function generateSecurePassword() {
            const length = 12;
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=[]{}|;:,.<>?";
            let password = "";
            
            // Ensure at least one character from each required category
            password += "ABCDEFGHIJKLMNOPQRSTUVWXYZ"[Math.floor(Math.random() * 26)]; // Uppercase
            password += "abcdefghijklmnopqrstuvwxyz"[Math.floor(Math.random() * 26)]; // Lowercase
            password += "0123456789"[Math.floor(Math.random() * 10)]; // Number
            password += "!@#$%^&*()_+-=[]{}|;:,.<>?"[Math.floor(Math.random() * 32)]; // Symbol
            
            // Fill the rest with random characters
            for (let i = password.length; i < length; i++) {
                password += charset[Math.floor(Math.random() * charset.length)];
            }
            
            // Shuffle the password
            return password.split('').sort(() => Math.random() - 0.5).join('');
        }

        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        }
    </script>
</x-admin-layout>
