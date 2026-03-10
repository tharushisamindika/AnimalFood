@section('page-title', 'Barcode Scanner')

<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Barcode/QR Scanner</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Scan product barcodes or QR codes to quickly view inventory information.</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.inventory.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4"></path>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.inventory.stock-levels') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Stock Levels
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Camera Scanner -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Camera Scanner</h3>
            </div>
            <div class="p-6">
                <div class="text-center">
                    <div id="camera-container" class="relative">
                        <video id="video" width="100%" height="300" class="border rounded-lg bg-gray-100 dark:bg-gray-700"></video>
                        <div id="scan-region" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-16 border-2 border-green-500 rounded-lg pointer-events-none hidden">
                            <div class="absolute top-0 left-0 w-4 h-4 border-t-2 border-l-2 border-green-500"></div>
                            <div class="absolute top-0 right-0 w-4 h-4 border-t-2 border-r-2 border-green-500"></div>
                            <div class="absolute bottom-0 left-0 w-4 h-4 border-b-2 border-l-2 border-green-500"></div>
                            <div class="absolute bottom-0 right-0 w-4 h-4 border-b-2 border-r-2 border-green-500"></div>
                        </div>
                    </div>
                    
                    <div class="mt-4 space-y-3">
                        <button id="start-camera" onclick="startCamera()" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            Start Camera
                        </button>
                        
                        <button id="stop-camera" onclick="stopCamera()" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hidden">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path>
                            </svg>
                            Stop Camera
                        </button>
                    </div>
                    
                    <div id="camera-status" class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                        Click "Start Camera" to begin scanning
                    </div>
                </div>
            </div>
        </div>

        <!-- Manual Input & Results -->
        <div class="space-y-6">
            <!-- Manual Input -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Manual Input</h3>
                </div>
                <div class="p-6">
                    <form id="manual-scan-form" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Code Type</label>
                            <select id="code-type" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                <option value="barcode">Barcode</option>
                                <option value="qr_code">QR Code</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Enter Code</label>
                            <input type="text" id="manual-code" placeholder="Enter barcode or QR code..." class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Search Product
                        </button>
                    </form>
                </div>
            </div>

            <!-- Product Results -->
            <div id="product-results" class="bg-white dark:bg-gray-800 shadow rounded-lg hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Product Information</h3>
                </div>
                <div id="product-details" class="p-6">
                    <!-- Product details will be loaded here -->
                </div>
            </div>

            <!-- Scan History -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Scans</h3>
                </div>
                <div class="p-6">
                    <div id="scan-history" class="space-y-3">
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="mt-2">No recent scans</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include QuaggaJS for barcode scanning -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let cameraActive = false;
        let scanHistory = JSON.parse(localStorage.getItem('scanHistory') || '[]');

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            displayScanHistory();
            setupManualForm();
        });

        function startCamera() {
            const video = document.getElementById('video');
            const startBtn = document.getElementById('start-camera');
            const stopBtn = document.getElementById('stop-camera');
            const status = document.getElementById('camera-status');
            const scanRegion = document.getElementById('scan-region');

            navigator.mediaDevices.getUserMedia({ 
                video: { 
                    facingMode: 'environment',
                    width: { ideal: 640 },
                    height: { ideal: 480 }
                } 
            })
            .then(function(stream) {
                video.srcObject = stream;
                video.play();
                
                cameraActive = true;
                startBtn.classList.add('hidden');
                stopBtn.classList.remove('hidden');
                scanRegion.classList.remove('hidden');
                status.textContent = 'Camera active - Position barcode in the scan area';
                
                // Initialize Quagga for barcode detection
                Quagga.init({
                    inputStream: {
                        name: "Live",
                        type: "LiveStream",
                        target: video,
                        constraints: {
                            width: 640,
                            height: 480,
                            facingMode: "environment"
                        }
                    },
                    decoder: {
                        readers: [
                            "code_128_reader",
                            "ean_reader",
                            "ean_8_reader",
                            "code_39_reader",
                            "code_39_vin_reader",
                            "codabar_reader",
                            "upc_reader",
                            "upc_e_reader"
                        ]
                    },
                    locate: true,
                    locator: {
                        halfSample: true,
                        patchSize: "medium"
                    }
                }, function(err) {
                    if (err) {
                        console.error('Quagga initialization failed:', err);
                        status.textContent = 'Error initializing barcode scanner';
                        return;
                    }
                    Quagga.start();
                });

                Quagga.onDetected(function(result) {
                    const code = result.codeResult.code;
                    if (code && code.length > 3) {
                        searchProduct(code, 'barcode');
                        // Brief pause before allowing next scan
                        Quagga.pause();
                        setTimeout(() => {
                            if (cameraActive) {
                                Quagga.start();
                            }
                        }, 2000);
                    }
                });
            })
            .catch(function(err) {
                console.error('Camera access denied or error:', err);
                status.textContent = 'Camera access denied or not available';
                Swal.fire('Camera Error', 'Unable to access camera. Please check permissions.', 'error');
            });
        }

        function stopCamera() {
            const video = document.getElementById('video');
            const startBtn = document.getElementById('start-camera');
            const stopBtn = document.getElementById('stop-camera');
            const status = document.getElementById('camera-status');
            const scanRegion = document.getElementById('scan-region');

            if (video.srcObject) {
                const tracks = video.srcObject.getTracks();
                tracks.forEach(track => track.stop());
                video.srcObject = null;
            }

            if (typeof Quagga !== 'undefined') {
                Quagga.stop();
            }

            cameraActive = false;
            startBtn.classList.remove('hidden');
            stopBtn.classList.add('hidden');
            scanRegion.classList.add('hidden');
            status.textContent = 'Camera stopped';
        }

        function setupManualForm() {
            document.getElementById('manual-scan-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const code = document.getElementById('manual-code').value.trim();
                const type = document.getElementById('code-type').value;
                
                if (code) {
                    searchProduct(code, type);
                }
            });
        }

        function searchProduct(code, type) {
            // Show loading
            const resultsDiv = document.getElementById('product-results');
            const detailsDiv = document.getElementById('product-details');
            
            resultsDiv.classList.remove('hidden');
            detailsDiv.innerHTML = `
                <div class="text-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-600 mx-auto"></div>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Searching for product...</p>
                </div>
            `;

            fetch('{{ route("admin.inventory.scan-barcode") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    code: code,
                    type: type
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayProductDetails(data.product);
                    addToScanHistory(code, type, data.product);
                } else {
                    detailsDiv.innerHTML = `
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">${data.message}</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                detailsDiv.innerHTML = `
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">Error searching for product</p>
                    </div>
                `;
            });
        }

        function displayProductDetails(product) {
            const detailsDiv = document.getElementById('product-details');
            
            const stockStatusColor = {
                'out_of_stock': 'red',
                'critical': 'red',
                'low': 'yellow',
                'normal': 'green',
                'overstock': 'blue'
            }[product.stock_status] || 'gray';

            detailsDiv.innerHTML = `
                <div class="space-y-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white">${product.name}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">SKU: ${product.sku}</p>
                            ${product.barcode ? `<p class="text-sm text-gray-500 dark:text-gray-400">Barcode: ${product.barcode}</p>` : ''}
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-${stockStatusColor}-100 text-${stockStatusColor}-800 dark:bg-${stockStatusColor}-900 dark:text-${stockStatusColor}-200">
                            ${product.stock_status.replace('_', ' ').toUpperCase()}
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Current Stock</div>
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">${product.current_stock} ${product.unit}</div>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Reorder Level</div>
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">${product.reorder_level} ${product.unit}</div>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Selling Price</div>
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">Rs. ${parseFloat(product.price).toFixed(2)}</div>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Cost Price</div>
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">Rs. ${parseFloat(product.cost_price).toFixed(2)}</div>
                        </div>
                    </div>
                    
                    ${product.location ? `
                    <div>
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Location</div>
                        <div class="text-sm text-gray-900 dark:text-white">${product.location}</div>
                    </div>
                    ` : ''}
                    
                    <div class="flex space-x-3 pt-4">
                        <a href="/admin/products/${product.id}" class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            View Details
                        </a>
                        <button onclick="adjustStockForProduct(${product.id}, '${product.name}')" class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700">
                            Adjust Stock
                        </button>
                    </div>
                </div>
            `;
        }

        function addToScanHistory(code, type, product) {
            const historyItem = {
                code: code,
                type: type,
                product: product,
                timestamp: new Date().toISOString()
            };
            
            scanHistory.unshift(historyItem);
            scanHistory = scanHistory.slice(0, 10); // Keep only last 10 scans
            localStorage.setItem('scanHistory', JSON.stringify(scanHistory));
            displayScanHistory();
        }

        function displayScanHistory() {
            const historyDiv = document.getElementById('scan-history');
            
            if (scanHistory.length === 0) {
                historyDiv.innerHTML = `
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="mt-2">No recent scans</p>
                    </div>
                `;
                return;
            }

            historyDiv.innerHTML = scanHistory.map(item => `
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="flex-1">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">${item.product.name}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">${item.code} (${item.type})</div>
                        <div class="text-xs text-gray-400 dark:text-gray-500">${new Date(item.timestamp).toLocaleString()}</div>
                    </div>
                    <button onclick="searchProduct('${item.code}', '${item.type}')" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </button>
                </div>
            `).join('');
        }

        function adjustStockForProduct(productId, productName) {
            Swal.fire({
                title: `Adjust Stock: ${productName}`,
                html: `
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Adjustment Type</label>
                            <select id="swal-adjustment-type" class="w-full px-3 py-2 border rounded-lg">
                                <option value="increase">Increase Stock</option>
                                <option value="decrease">Decrease Stock</option>
                                <option value="set">Set Stock Level</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Quantity</label>
                            <input type="number" id="swal-quantity" min="0" class="w-full px-3 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Reason</label>
                            <select id="swal-reason" class="w-full px-3 py-2 border rounded-lg">
                                <option value="Stock count adjustment">Stock count adjustment</option>
                                <option value="Damaged goods">Damaged goods</option>
                                <option value="Lost items">Lost items</option>
                                <option value="Found items">Found items</option>
                                <option value="Return to supplier">Return to supplier</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Adjust Stock',
                preConfirm: () => {
                    const type = document.getElementById('swal-adjustment-type').value;
                    const quantity = document.getElementById('swal-quantity').value;
                    const reason = document.getElementById('swal-reason').value;
                    
                    if (!quantity || !reason) {
                        Swal.showValidationMessage('Please fill in all fields');
                        return false;
                    }
                    
                    return { type, quantity: parseInt(quantity), reason };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const { type, quantity, reason } = result.value;
                    
                    fetch('{{ route("admin.inventory.adjust-stock") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            adjustment_type: type,
                            quantity: quantity,
                            reason: reason
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Success', data.message, 'success');
                        } else {
                            Swal.fire('Error', data.message || 'An error occurred', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'An error occurred while adjusting stock', 'error');
                    });
                }
            });
        }

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            stopCamera();
        });
    </script>
</x-admin-layout>
