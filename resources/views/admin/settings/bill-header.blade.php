<x-admin-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Bill Header Design</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Configure company information and logo for billing documents.</p>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-md flex items-center">
            <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded-md flex items-center">
            <svg class="w-5 h-5 mr-2 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    @if (!$storageLinkExists)
        <div class="mb-6 bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 text-yellow-700 dark:text-yellow-300 px-4 py-3 rounded-md flex items-center">
            <svg class="w-5 h-5 mr-2 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <span class="font-medium">Storage link not found. Please run <code class="bg-yellow-100 dark:bg-yellow-800 px-1 rounded">php artisan storage:link</code> in your terminal to enable logo uploads.</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Bill Header Settings Form -->
                 <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
             <div class="flex items-center justify-between mb-6">
                 <h2 class="text-lg font-medium text-gray-900 dark:text-white">Company Information</h2>
                 @if($billHeader)
                 <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                     <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                         <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                     </svg>
                     Active
                 </span>
                 @else
                 <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                     <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                         <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                     </svg>
                     Not Configured
                 </span>
                 @endif
             </div>
            
            <form method="POST" action="{{ $billHeader ? route('admin.settings.bill-header.update', $billHeader) : route('admin.settings.bill-header.store') }}" enctype="multipart/form-data" class="space-y-6" id="billHeaderForm">
                @csrf
                @if($billHeader)
                    @method('PUT')
                @endif

                <!-- Company Logo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Company Logo
                    </label>
                    <div class="flex items-center space-x-4">
                        <div id="logo-preview-container" class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center overflow-hidden">
                            @if($billHeader && $billHeader->company_logo)
                                <img id="logo-preview" src="{{ Storage::url($billHeader->company_logo) }}" alt="Company Logo" class="w-full h-full object-cover">
                            @else
                                <svg id="logo-placeholder" class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <input type="file" id="company_logo_input" name="company_logo" accept="image/*" class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100 dark:file:bg-green-900 dark:file:text-green-300">
                                                         <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF up to 2MB. Logo will appear in bill preview and print.</p>
                        </div>
                    </div>
                    @error('company_logo')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Company Name -->
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Company Name *
                    </label>
                                         <input type="text" id="company_name" name="company_name" value="{{ old('company_name', $billHeader?->company_name ?? '') }}" required
                        class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                    @error('company_name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Company Address -->
                <div>
                    <label for="company_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Company Address
                    </label>
                                         <textarea id="company_address" name="company_address" rows="3"
                         class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">{{ old('company_address', $billHeader?->company_address ?? '') }}</textarea>
                    @error('company_address')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="company_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Phone Number
                        </label>
                                                 <input type="text" id="company_phone" name="company_phone" value="{{ old('company_phone', $billHeader?->company_phone ?? '') }}"
                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                        @error('company_phone')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="company_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Email Address
                        </label>
                                                 <input type="email" id="company_email" name="company_email" value="{{ old('company_email', $billHeader?->company_email ?? '') }}"
                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                        @error('company_email')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Website and Tax Number -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="company_website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Website
                        </label>
                                                 <input type="url" id="company_website" name="company_website" value="{{ old('company_website', $billHeader?->company_website ?? '') }}"
                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                        @error('company_website')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tax_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tax Number
                        </label>
                                                 <input type="text" id="tax_number" name="tax_number" value="{{ old('tax_number', $billHeader?->tax_number ?? '') }}"
                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                        @error('tax_number')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Invoice Prefix -->
                <div>
                    <label for="invoice_prefix" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Invoice Prefix
                    </label>
                                         <input type="text" id="invoice_prefix" name="invoice_prefix" value="{{ old('invoice_prefix', $billHeader?->invoice_prefix ?? 'INV') }}"
                        class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Prefix for invoice numbers (e.g., INV, BILL)</p>
                    @error('invoice_prefix')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Footer Text -->
                <div>
                    <label for="footer_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Footer Text
                    </label>
                                         <textarea id="footer_text" name="footer_text" rows="3"
                         class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">{{ old('footer_text', $billHeader?->footer_text ?? '') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Text to appear at the bottom of bills</p>
                    @error('footer_text')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="testBillHeader()" class="inline-flex items-center px-4 py-2 border border-blue-300 dark:border-blue-600 text-sm font-medium rounded-lg text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Test Header
                    </button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ $billHeader ? 'Update Settings' : 'Save Settings' }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Bill Header Preview -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Bill Header Preview</h2>
            
            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-6 bg-gray-50 dark:bg-gray-700">
                <div class="flex items-start space-x-4 mb-6">
                    <!-- Logo on the left -->
                    <div id="preview-logo-container" class="flex-shrink-0">
                        @if($billHeader && $billHeader->company_logo)
                            <img id="preview-logo" src="{{ Storage::url($billHeader->company_logo) }}" alt="Company Logo" class="h-16 w-auto">
                        @else
                            <div id="preview-logo-placeholder" class="h-16 w-16 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Company information on the right -->
                    <div class="flex-1">
                                                 <h3 id="preview-company-name" class="text-xl font-bold text-gray-900 dark:text-white">
                             {{ $billHeader?->company_name ?? 'Your Company Name' }}
                         </h3>
                         
                         <p id="preview-company-address" class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                             {{ $billHeader?->company_address ?? 'Company Address' }}
                         </p>
                         
                         <div class="flex flex-wrap gap-4 mt-1 text-sm text-gray-600 dark:text-gray-400">
                             <span id="preview-company-phone">{{ $billHeader?->company_phone ?? 'Phone Number' }}</span>
                             <span id="preview-company-email">{{ $billHeader?->company_email ?? 'Email Address' }}</span>
                         </div>
                         
                         <p id="preview-company-website" class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                             {{ $billHeader?->company_website ?? 'Website' }}
                         </p>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 dark:border-gray-600 pt-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-white">Invoice #</h4>
                                                         <p class="text-sm text-gray-600 dark:text-gray-400">{{ $billHeader?->invoice_prefix ?? 'INV' }}-001</p>
                        </div>
                        <div class="text-right">
                            <h4 class="font-medium text-gray-900 dark:text-white">Date</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ date('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
                
                                 @if($billHeader?->footer_text)
                    <div class="border-t border-gray-200 dark:border-gray-600 pt-4 mt-4">
                        <p class="text-xs text-gray-500 dark:text-gray-400 text-center">
                                                         {{ $billHeader?->footer_text }}
                        </p>
                    </div>
                @endif
            </div>
            
                         <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900 rounded-lg">
                 <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100 mb-2">How it works:</h4>
                 <ul class="text-sm text-blue-800 dark:text-blue-200 space-y-1">
                     <li>• Configure your company information above</li>
                     <li>• Upload your company logo (PNG, JPG, GIF up to 2MB)</li>
                     <li>• Save the settings with confirmation</li>
                     <li>• This header will be applied to all generated bills</li>
                     <li>• Use the "Test Header" button to verify your settings</li>
                 </ul>
             </div>
             
             @if(!$billHeader)
             <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900 rounded-lg">
                 <h4 class="text-sm font-medium text-yellow-900 dark:text-yellow-100 mb-2">⚠️ No Bill Header Found:</h4>
                 <p class="text-sm text-yellow-800 dark:text-yellow-200">
                     You haven't created a bill header yet. Fill out the form and save your company information. 
                     The "Test Header" button will show "No Active Header" until you save your first bill header settings.
                 </p>
             </div>
             @else
             <div class="mt-4 p-4 bg-green-50 dark:bg-green-900 rounded-lg">
                 <h4 class="text-sm font-medium text-green-900 dark:text-green-100 mb-2">✅ Bill Header Active:</h4>
                 <p class="text-sm text-green-800 dark:text-green-200">
                     Your bill header is configured and active. The "Test Header" button will show your current settings. 
                     You can update the information below and save changes.
                 </p>
             </div>
             @endif
            
            <div class="mt-4 p-4 bg-green-50 dark:bg-green-900 rounded-lg">
                <h4 class="text-sm font-medium text-green-900 dark:text-green-100 mb-2">💡 Tips:</h4>
                <ul class="text-sm text-green-800 dark:text-green-200 space-y-1">
                    <li>• Logo should be high quality and square/rectangular</li>
                    <li>• Company name is required for the header to work</li>
                    <li>• Invoice prefix will be used in all bill numbers</li>
                    <li>• Footer text appears at the bottom of printed bills</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- JavaScript for Live Logo and Text Preview -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoInput = document.getElementById('company_logo_input');
            const logoPreview = document.getElementById('logo-preview');
            const logoPlaceholder = document.getElementById('logo-placeholder');
            const previewLogo = document.getElementById('preview-logo');
            const previewLogoPlaceholder = document.getElementById('preview-logo-placeholder');
            const previewLogoContainer = document.getElementById('preview-logo-container');

            // Text field elements
            const companyNameInput = document.getElementById('company_name');
            const companyAddressInput = document.getElementById('company_address');
            const companyPhoneInput = document.getElementById('company_phone');
            const companyEmailInput = document.getElementById('company_email');
            const companyWebsiteInput = document.getElementById('company_website');

            // Preview elements
            const previewCompanyName = document.getElementById('preview-company-name');
            const previewCompanyAddress = document.getElementById('preview-company-address');
            const previewCompanyPhone = document.getElementById('preview-company-phone');
            const previewCompanyEmail = document.getElementById('preview-company-email');
            const previewCompanyWebsite = document.getElementById('preview-company-website');

            // Logo preview functionality
            logoInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                
                if (file) {
                    // Validate file type
                    if (!file.type.startsWith('image/')) {
                        alert('Please select a valid image file.');
                        return;
                    }
                    
                    // Validate file size (2MB limit)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('File size must be less than 2MB.');
                        return;
                    }

                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const imageUrl = e.target.result;
                        
                        // Update the small preview in the form
                        if (logoPreview) {
                            logoPreview.src = imageUrl;
                            logoPreview.style.display = 'block';
                        } else {
                            // Create new image element if it doesn't exist
                            const newLogoPreview = document.createElement('img');
                            newLogoPreview.id = 'logo-preview';
                            newLogoPreview.src = imageUrl;
                            newLogoPreview.alt = 'Company Logo';
                            newLogoPreview.className = 'w-full h-full object-cover';
                            document.getElementById('logo-preview-container').appendChild(newLogoPreview);
                        }
                        
                        if (logoPlaceholder) {
                            logoPlaceholder.style.display = 'none';
                        }
                        
                        // Update the large preview in the preview section
                        if (previewLogo) {
                            previewLogo.src = imageUrl;
                            previewLogo.style.display = 'block';
                        } else {
                            // Create new image element for preview section
                            const newPreviewLogo = document.createElement('img');
                            newPreviewLogo.id = 'preview-logo';
                            newPreviewLogo.src = imageUrl;
                            newPreviewLogo.alt = 'Company Logo';
                            newPreviewLogo.className = 'h-16 w-auto';
                            previewLogoContainer.innerHTML = '';
                            previewLogoContainer.appendChild(newPreviewLogo);
                        }
                        
                        if (previewLogoPlaceholder) {
                            previewLogoPlaceholder.style.display = 'none';
                        }
                        
                        // Add a subtle animation effect
                        previewLogoContainer.style.transition = 'all 0.3s ease';
                        previewLogoContainer.style.transform = 'scale(1.05)';
                        setTimeout(() => {
                            previewLogoContainer.style.transform = 'scale(1)';
                        }, 300);
                    };
                    
                    reader.readAsDataURL(file);
                } else {
                    // If no file selected, show placeholders
                    if (logoPreview) {
                        logoPreview.style.display = 'none';
                    }
                    if (logoPlaceholder) {
                        logoPlaceholder.style.display = 'block';
                    }
                    if (previewLogo) {
                        previewLogo.style.display = 'none';
                    }
                    if (previewLogoPlaceholder) {
                        previewLogoPlaceholder.style.display = 'block';
                    }
                }
            });

            // Text field live preview functionality
            function updateTextPreview(inputElement, previewElement, placeholderText) {
                if (inputElement && previewElement) {
                    const value = inputElement.value.trim();
                    if (value) {
                        previewElement.textContent = value;
                        previewElement.style.opacity = '1';
                    } else {
                        previewElement.textContent = placeholderText;
                        previewElement.style.opacity = '0.6';
                    }
                }
            }

            // Add event listeners for text fields
            if (companyNameInput && previewCompanyName) {
                companyNameInput.addEventListener('input', function() {
                    updateTextPreview(this, previewCompanyName, 'Your Company Name');
                });
            }

            if (companyAddressInput && previewCompanyAddress) {
                companyAddressInput.addEventListener('input', function() {
                    updateTextPreview(this, previewCompanyAddress, 'Company Address');
                });
            }

            if (companyPhoneInput && previewCompanyPhone) {
                companyPhoneInput.addEventListener('input', function() {
                    updateTextPreview(this, previewCompanyPhone, 'Phone Number');
                });
            }

            if (companyEmailInput && previewCompanyEmail) {
                companyEmailInput.addEventListener('input', function() {
                    updateTextPreview(this, previewCompanyEmail, 'Email Address');
                });
            }

            if (companyWebsiteInput && previewCompanyWebsite) {
                companyWebsiteInput.addEventListener('input', function() {
                    updateTextPreview(this, previewCompanyWebsite, 'Website');
                });
            }

            // Initialize preview with current values
            if (companyNameInput && previewCompanyName) {
                updateTextPreview(companyNameInput, previewCompanyName, 'Your Company Name');
            }
            if (companyAddressInput && previewCompanyAddress) {
                updateTextPreview(companyAddressInput, previewCompanyAddress, 'Company Address');
            }
            if (companyPhoneInput && previewCompanyPhone) {
                updateTextPreview(companyPhoneInput, previewCompanyPhone, 'Phone Number');
            }
            if (companyEmailInput && previewCompanyEmail) {
                updateTextPreview(companyEmailInput, previewCompanyEmail, 'Email Address');
            }
            if (companyWebsiteInput && previewCompanyWebsite) {
                updateTextPreview(companyWebsiteInput, previewCompanyWebsite, 'Website');
            }

            // Add drag and drop functionality
            const logoPreviewContainer = document.getElementById('logo-preview-container');
            
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                logoPreviewContainer.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                logoPreviewContainer.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                logoPreviewContainer.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                logoPreviewContainer.classList.add('border-2', 'border-green-500', 'border-dashed');
            }

            function unhighlight(e) {
                logoPreviewContainer.classList.remove('border-2', 'border-green-500', 'border-dashed');
            }

            logoPreviewContainer.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                if (files.length > 0) {
                    logoInput.files = files;
                    logoInput.dispatchEvent(new Event('change'));
                }
            }

            // Add click to upload functionality
            logoPreviewContainer.addEventListener('click', function() {
                logoInput.click();
            });
            
            logoPreviewContainer.style.cursor = 'pointer';

            // Form submission with confirmation
            const form = document.getElementById('billHeaderForm');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Show confirmation dialog
                Swal.fire({
                    title: 'Save Bill Header Settings?',
                    text: 'This will update your company information and logo for all future bills.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, Save Settings',
                    cancelButtonText: 'Cancel',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        // Show loading state
                        Swal.showLoading();
                        
                        // Submit the form
                        return new Promise((resolve) => {
                            setTimeout(() => {
                                form.submit();
                                resolve();
                            }, 500);
                        });
                    }
                });
            });

            // Show success message if page loads with success parameter
            @if(session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonColor: '#10b981',
                    confirmButtonText: 'Great!'
                });
            @endif

            // Show error message if page loads with error parameter
            @if(session('error'))
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'OK'
                });
            @endif

            // Auto-hide success/error messages after 5 seconds
            setTimeout(() => {
                const successMessage = document.querySelector('.bg-green-50');
                const errorMessage = document.querySelector('.bg-red-50');
                
                if (successMessage) {
                    successMessage.style.transition = 'opacity 0.5s ease';
                    successMessage.style.opacity = '0';
                    setTimeout(() => successMessage.remove(), 500);
                }
                
                if (errorMessage) {
                    errorMessage.style.transition = 'opacity 0.5s ease';
                    errorMessage.style.opacity = '0';
                    setTimeout(() => errorMessage.remove(), 500);
                }
            }, 5000);

            // Test bill header function
            window.testBillHeader = function() {
                fetch('{{ route("admin.test.bill-header") }}')
                    .then(response => response.json())
                    .then(data => {
                        console.log('Bill header test data:', data);
                        Swal.fire({
                            title: 'Bill Header Test Results',
                            html: `
                                <div class="text-left">
                                    <p><strong>Active Header:</strong> ${data.header ? 'Yes' : 'No'}</p>
                                    ${data.header ? `
                                        <p><strong>Company Name:</strong> ${data.header.company_name || 'Not set'}</p>
                                        <p><strong>Company Logo:</strong> ${data.header.company_logo || 'Not set'}</p>
                                        <p><strong>Logo URL:</strong> ${data.logo_url || 'Not set'}</p>
                                        <p><strong>Storage URL:</strong> ${data.storage_url}</p>
                                        <p><strong>Company Address:</strong> ${data.header.company_address || 'Not set'}</p>
                                        <p><strong>Company Phone:</strong> ${data.header.company_phone || 'Not set'}</p>
                                        <p><strong>Company Email:</strong> ${data.header.company_email || 'Not set'}</p>
                                        <p><strong>Invoice Prefix:</strong> ${data.header.invoice_prefix || 'Not set'}</p>
                                    ` : ''}
                                    <p><strong>Total Headers:</strong> ${data.all_headers.length}</p>
                                </div>
                            `,
                            icon: 'info',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3b82f6'
                        });
                    })
                    .catch(error => {
                        console.error('Error testing bill header:', error);
                        Swal.fire('Error!', 'Failed to test bill header data.', 'error');
                    });
            };
        });
    </script>
</x-admin-layout>
