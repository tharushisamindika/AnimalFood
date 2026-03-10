<x-admin-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Change Password</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Update your account password to keep it secure.</p>
    </div>

    <div class="max-w-4xl">
        @if (session('status'))
            <div class="mb-6 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-md">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                    Password Information
                </h3>
            </div>
            
            <form method="POST" action="{{ route('password.change') }}" class="p-6 space-y-6" id="changePasswordForm">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Current Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input id="current_password" name="current_password" type="password" required
                                class="block w-full pl-10 pr-12 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 @error('current_password') border-red-500 dark:border-red-400 @enderror"
                                placeholder="Enter your current password">
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password" data-target="current_password">
                                <svg class="h-5 w-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                        <div id="current_password_validation" class="mt-2 text-sm hidden"></div>
                        @error('current_password')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            New Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" required
                                class="block w-full pl-10 pr-12 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 @error('password') border-red-500 dark:border-red-400 @enderror"
                                placeholder="Enter your new password">
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password" data-target="password">
                                <svg class="h-5 w-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="mt-2 flex space-x-2">
                            <button type="button" id="generatePasswordBtn" class="inline-flex items-center px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Generate
                            </button>
                        </div>
                        <div id="password_validation" class="mt-2 text-sm hidden"></div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Confirm New Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="block w-full pl-10 pr-12 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                            placeholder="Confirm your new password">
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password" data-target="password_confirmation">
                            <svg class="h-5 w-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    <div id="password_confirmation_validation" class="mt-2 text-sm hidden"></div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-4">Password Requirements:</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="flex items-center" id="req-length">
                            <svg class="h-4 w-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-sm text-gray-600 dark:text-gray-400">At least 8 characters long</span>
                        </div>
                        <div class="flex items-center" id="req-letter">
                            <svg class="h-4 w-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Contains at least one letter</span>
                        </div>
                        <div class="flex items-center" id="req-number">
                            <svg class="h-4 w-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Contains at least one number</span>
                        </div>
                        <div class="flex items-center" id="req-symbol">
                            <svg class="h-4 w-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Contains at least one symbol</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit" id="submitBtn"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Password toggle functionality
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('svg');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>';
                } else {
                    input.type = 'password';
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
                }
            });
        });

        // Generate password functionality
        document.getElementById('generatePasswordBtn').addEventListener('click', function() {
            fetch('{{ route("password.generate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('password').value = data.password;
                document.getElementById('password_confirmation').value = data.password;
                
                validatePassword();
                validatePasswordConfirmation();
                
                Swal.fire({
                    icon: 'success',
                    title: 'Password Generated',
                    text: 'A secure password has been generated and filled in both fields.',
                    confirmButtonColor: '#10B981'
                });
            })
            .catch(error => {
                console.error('Error generating password:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to generate password. Please try again.',
                    confirmButtonColor: '#10B981'
                });
            });
        });

        // Real-time validation variables
        let currentPasswordValid = false;
        let passwordValid = false;
        let passwordConfirmationValid = false;
        let passwordHistoryValid = true;

        // Current password validation
        let currentPasswordTimeout;
        document.getElementById('current_password').addEventListener('input', function() {
            clearTimeout(currentPasswordTimeout);
            currentPasswordTimeout = setTimeout(() => {
                validateCurrentPassword();
            }, 500);
        });

        function validateCurrentPassword() {
            const currentPassword = document.getElementById('current_password').value;
            const validationDiv = document.getElementById('current_password_validation');
            
            if (currentPassword.length === 0) {
                validationDiv.className = 'mt-2 text-sm hidden';
                currentPasswordValid = false;
                updateSubmitButton();
                return;
            }

            fetch('{{ route("password.validate.current") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    current_password: currentPassword
                })
            })
            .then(response => response.json())
            .then(data => {
                currentPasswordValid = data.valid;
                validationDiv.className = `mt-2 text-sm ${data.valid ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}`;
                validationDiv.textContent = data.message;
                validationDiv.classList.remove('hidden');
                updateSubmitButton();
            })
            .catch(error => {
                console.error('Error validating current password:', error);
            });
        }

        // Password validation
        let passwordTimeout;
        document.getElementById('password').addEventListener('input', function() {
            clearTimeout(passwordTimeout);
            passwordTimeout = setTimeout(() => {
                validatePassword();
                validatePasswordConfirmation();
            }, 500);
        });

        function validatePassword() {
            const password = document.getElementById('password').value;
            const validationDiv = document.getElementById('password_validation');
            
            if (password.length === 0) {
                validationDiv.className = 'mt-2 text-sm hidden';
                passwordValid = false;
                updateSubmitButton();
                return;
            }

            const requirements = {
                length: password.length >= 8,
                letter: /[a-zA-Z]/.test(password),
                number: /\d/.test(password),
                symbol: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)
            };

            updateRequirementIndicator('req-length', requirements.length);
            updateRequirementIndicator('req-letter', requirements.letter);
            updateRequirementIndicator('req-number', requirements.number);
            updateRequirementIndicator('req-symbol', requirements.symbol);

            passwordValid = Object.values(requirements).every(req => req);
            
            if (passwordValid) {
                checkPasswordHistory(password);
            } else {
                validationDiv.className = 'mt-2 text-sm text-red-600 dark:text-red-400';
                validationDiv.textContent = 'Password does not meet all requirements';
                validationDiv.classList.remove('hidden');
                passwordHistoryValid = true;
                updateSubmitButton();
            }
        }

        function updateRequirementIndicator(elementId, met) {
            const element = document.getElementById(elementId);
            const icon = element.querySelector('svg');
            const span = element.querySelector('span');
            
            if (met) {
                icon.className = 'h-4 w-4 text-green-500 mr-3';
                span.className = 'text-sm text-green-600 dark:text-green-400';
            } else {
                icon.className = 'h-4 w-4 text-gray-400 mr-3';
                span.className = 'text-sm text-gray-600 dark:text-gray-400';
            }
        }

        function checkPasswordHistory(password) {
            fetch('{{ route("password.check.history") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    password: password
                })
            })
            .then(response => response.json())
            .then(data => {
                passwordHistoryValid = data.valid;
                const validationDiv = document.getElementById('password_validation');
                
                if (data.valid) {
                    validationDiv.className = 'mt-2 text-sm text-green-600 dark:text-green-400';
                    validationDiv.textContent = 'Password is available for use';
                } else {
                    validationDiv.className = 'mt-2 text-sm text-red-600 dark:text-red-400';
                    validationDiv.textContent = data.message;
                }
                validationDiv.classList.remove('hidden');
                updateSubmitButton();
            })
            .catch(error => {
                console.error('Error checking password history:', error);
            });
        }

        // Password confirmation validation
        let passwordConfirmationTimeout;
        document.getElementById('password_confirmation').addEventListener('input', function() {
            clearTimeout(passwordConfirmationTimeout);
            passwordConfirmationTimeout = setTimeout(() => {
                validatePasswordConfirmation();
            }, 300);
        });

        function validatePasswordConfirmation() {
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            const validationDiv = document.getElementById('password_confirmation_validation');
            
            if (passwordConfirmation.length === 0) {
                validationDiv.className = 'mt-2 text-sm hidden';
                passwordConfirmationValid = false;
                updateSubmitButton();
                return;
            }

            if (password === passwordConfirmation) {
                passwordConfirmationValid = true;
                validationDiv.className = 'mt-2 text-sm text-green-600 dark:text-green-400';
                validationDiv.textContent = 'Passwords match';
            } else {
                passwordConfirmationValid = false;
                validationDiv.className = 'mt-2 text-sm text-red-600 dark:text-red-400';
                validationDiv.textContent = 'Passwords do not match';
            }
            validationDiv.classList.remove('hidden');
            updateSubmitButton();
        }

        function updateSubmitButton() {
            const submitBtn = document.getElementById('submitBtn');
            const allValid = currentPasswordValid && passwordValid && passwordConfirmationValid && passwordHistoryValid;
            submitBtn.disabled = !allValid;
        }

        // Form submission with SweetAlert
        document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
            if (!currentPasswordValid || !passwordValid || !passwordConfirmationValid || !passwordHistoryValid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please fix all validation errors before submitting.',
                    confirmButtonColor: '#10B981'
                });
            }
        });

        // Show SweetAlert for server-side errors
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: `
                    <div class="text-left">
                        @foreach($errors->all() as $error)
                            <p class="mb-2">• {{ $error }}</p>
                        @endforeach
                    </div>
                `,
                confirmButtonColor: '#10B981'
            });
        @endif
    </script>
</x-admin-layout>
