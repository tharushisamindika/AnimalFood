<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('images/dog.png') }}">

        <title>Animal Food System</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
        <!-- Global Laravel Variables -->
        <script>
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            };
        </script>
    </head>
    <body class="font-sans antialiased overflow-x-hidden">
        <div class="min-h-screen w-full bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
            <style>
                .card-shadow {
                    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                }
                .card-shadow:hover {
                    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                }
                .dark .card-shadow {
                    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
                }
                .dark .card-shadow:hover {
                    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4), 0 10px 10px -5px rgba(0, 0, 0, 0.3);
                }
                
                /* Mobile Layout Fixes */
                @media (max-width: 768px) {
                    html, body {
                        overflow-x: hidden;
                        width: 100%;
                        position: relative;
                    }
                    
                    .mobile-container {
                        width: 100vw;
                        max-width: 100%;
                        overflow-x: hidden;
                    }
                    
                    /* Prevent horizontal scroll on tables */
                    .table-container {
                        width: 100%;
                        overflow-x: auto;
                        -webkit-overflow-scrolling: touch;
                        margin: 0;
                        padding: 0;
                    }
                    
                    /* Fix mobile sidebar z-index */
                    .mobile-sidebar {
                        position: fixed;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        z-index: 50;
                    }
                    
                    /* Ensure tables fit properly on mobile */
                    .table-container table {
                        min-width: 600px; /* Minimum table width for mobile horizontal scroll */
                    }
                    
                    /* Compact mobile table cells */
                    .table-container td,
                    .table-container th {
                        white-space: nowrap;
                    }
                    
                    /* Allow text wrapping in product names only */
                    .table-container td:first-child {
                        white-space: normal;
                        max-width: 120px;
                    }
                }
                
                /* Extra small mobile devices */
                @media (max-width: 480px) {
                    .mobile-container {
                        padding-left: 0.5rem;
                        padding-right: 0.5rem;
                    }
                    
                    .table-container {
                        margin-left: -0.5rem;
                        margin-right: -0.5rem;
                        width: calc(100vw);
                    }
                }
            </style>
            <!-- Sidebar -->
            <div x-data="{ sidebarOpen: false }" class="flex min-h-screen w-full">
                <!-- Sidebar for desktop -->
                <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
                    <div class="flex-1 flex flex-col min-h-0 bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 shadow-2xl border-r border-gray-700">
                        <!-- Logo -->
                        <div class="flex items-center h-20 flex-shrink-0 px-6 bg-gradient-to-r from-emerald-600 via-green-600 to-emerald-700 shadow-lg">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg">
                                    <img src="{{ asset('images/dog.png') }}" alt="Dog" class="h-8 w-8 rounded-lg">
                                </div>
                                <span class="ml-3 text-white font-bold text-lg tracking-wide">Animal Food System</span>
                            </div>
                        </div>

                        <!-- Navigation -->
                        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                            <!-- Dashboard -->
                            <a href="{{ route('dashboard') }}" class="group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-emerald-500 to-green-500 text-white shadow-lg shadow-emerald-500/25' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:shadow-md' }}">
                                <svg class="mr-3 h-6 w-6 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                                </svg>
                                Dashboard
                            </a>

                            <!-- Products -->
                            <a href="{{ route('admin.products.index') }}" class="group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-gradient-to-r from-blue-500 to-indigo-500 text-white shadow-lg shadow-blue-500/25' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:shadow-md' }}">
                                <svg class="mr-3 h-6 w-6 {{ request()->routeIs('admin.products.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Products
                            </a>

                                        <!-- Inventory Management -->
            <div x-data="{ open: false }">
                <button @click="open = !open" class="group flex items-center w-full px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.inventory*') ? 'bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-lg shadow-amber-500/25' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:shadow-md' }}">
                    <svg class="mr-3 h-6 w-6 {{ request()->routeIs('admin.inventory*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-14 0h14"></path>
                    </svg>
                    Inventory
                    <svg class="ml-auto h-5 w-5 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="ml-8 space-y-2 mt-2">
                    <a href="{{ route('admin.inventory.dashboard') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.inventory.dashboard') ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.inventory.stock-levels') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.inventory.stock-levels') ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                        </svg>
                        Stock Levels
                    </a>
                    <a href="{{ route('admin.inventory.scanner') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.inventory.scanner') ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V6a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1zm12 0h2a1 1 0 001-1V6a1 1 0 00-1-1h-2a1 1 0 00-1 1v1a1 1 0 001 1zM5 20h2a1 1 0 001-1v-1a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1z"></path>
                        </svg>
                        Scanner
                    </a>
                </div>
            </div>

                            <!-- Sales -->
                            <a href="{{ route('admin.sales.index') }}" class="group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.sales.*') ? 'bg-gradient-to-r from-purple-500 to-pink-500 text-white shadow-lg shadow-purple-500/25' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:shadow-md' }}">
                                <svg class="mr-3 h-6 w-6 {{ request()->routeIs('admin.sales.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                Sales
                            </a>

                            <!-- Orders -->
                            <a href="{{ route('admin.orders.index') }}" class="group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.orders.*') ? 'bg-gradient-to-r from-teal-500 to-cyan-500 text-white shadow-lg shadow-teal-500/25' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:shadow-md' }}">
                                <svg class="mr-3 h-6 w-6 {{ request()->routeIs('admin.orders.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Orders
                            </a>

                            <!-- Customers -->
                            <a href="{{ route('admin.customers.index') }}" class="group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.customers.*') ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg shadow-indigo-500/25' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:shadow-md' }}">
                                <svg class="mr-3 h-6 w-6 {{ request()->routeIs('admin.customers') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                Customers
                            </a>

                            <!-- Suppliers (Admin Only) -->
                            @if(auth()->user()->role !== 'cashier')
                            <a href="{{ route('admin.suppliers') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.suppliers') ? 'bg-green-100 text-green-900 dark:bg-green-700 dark:text-green-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                                <svg class="mr-3 h-6 w-6 {{ request()->routeIs('admin.suppliers') ? 'text-green-500' : 'text-gray-400 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Suppliers
                            </a>
                            @endif

                            <!-- Purchases (Admin Only) -->
                            @if(auth()->user()->role !== 'cashier')
                            <div x-data="{ open: false }">
                                <button @click="open = !open" class="group flex items-center w-full px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.purchases.*') || request()->routeIs('admin.purchase-returns.*') ? 'bg-green-100 text-green-900 dark:bg-green-700 dark:text-green-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                                    <svg class="mr-3 h-6 w-6 {{ request()->routeIs('admin.purchases.*') || request()->routeIs('admin.purchase-returns.*') ? 'text-green-500' : 'text-gray-400 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    Purchases
                                    <svg class="ml-auto h-5 w-5 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="ml-8 space-y-1">
                                    <a href="{{ route('admin.purchases.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.purchases.*') ? 'bg-green-100 text-green-900 dark:bg-green-700 dark:text-green-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                                        <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                        Purchase Orders
                                    </a>
                                    <a href="{{ route('admin.purchases.create') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        New Purchase
                                    </a>
                                    <a href="{{ route('admin.purchase-returns.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.purchase-returns.*') ? 'bg-green-100 text-green-900 dark:bg-green-700 dark:text-green-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                                        <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H9m0 0l3 3m-3-3l3-3m5 5v8a2 2 0 01-2 2H6a2 2 0 01-2-2v-8"></path>
                                        </svg>
                                        Returns
                                    </a>
                                </div>
                            </div>
                            @endif

                            <!-- Categories (Admin Only) -->
                            @if(auth()->user()->role !== 'cashier')
                            <a href="{{ route('admin.categories') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.categories') ? 'bg-green-100 text-green-900 dark:bg-green-700 dark:text-green-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                                <svg class="mr-3 h-6 w-6 {{ request()->routeIs('admin.categories') ? 'text-green-500' : 'text-gray-400 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Categories
                            </a>
                            @endif

                            <!-- Reports -->
                            <div x-data="{ open: false }">
                                <button @click="open = !open" class="group flex items-center w-full px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Reports
                                    <svg class="ml-auto h-5 w-5 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="ml-8 space-y-1">
                                    <a href="{{ route('admin.reports.sales') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        Sales Report
                                    </a>
                                    <a href="{{ route('admin.reports.customers') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                        Customer Report
                                    </a>
                                    <a href="{{ route('admin.reports.suppliers') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        Supplier Report
                                    </a>
                                    <a href="{{ route('admin.reports.inventory') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-14 0h14"></path>
                                        </svg>
                                        Inventory Report
                                    </a>
                                </div>
                            </div>

                            <!-- Billing -->
                            <div x-data="{ open: false }">
                                <button @click="open = !open" class="group flex items-center w-full px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Billing
                                    <svg class="ml-auto h-5 w-5 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="ml-8 space-y-1">
                                    <a href="{{ route('admin.billing.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Point of Sale
                                    </a>
                                    <a href="{{ route('admin.billing.list') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Bill List
                                    </a>
                                    <a href="{{ route('admin.payments.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.payments*') ? 'bg-green-100 text-green-900 dark:bg-green-700 dark:text-green-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                                        <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        Payments
                                    </a>
                                </div>
                            </div>

                            <!-- Users (Admin Only) -->
                            @if(auth()->user()->role !== 'cashier')
                            <a href="{{ route('admin.users') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.users') ? 'bg-green-100 text-green-900 dark:bg-green-700 dark:text-green-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                                <svg class="mr-3 h-6 w-6 {{ request()->routeIs('admin.users') ? 'text-green-500' : 'text-gray-400 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                Users
                            </a>
                            @endif

                            <!-- Audit Logs (Admin Only) -->
                            @if(auth()->user()->role !== 'cashier')
                            <a href="{{ route('admin.audit-logs.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.audit-logs.*') ? 'bg-green-100 text-green-900 dark:bg-green-700 dark:text-green-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                                <svg class="mr-3 h-6 w-6 {{ request()->routeIs('admin.audit-logs.*') ? 'text-green-500' : 'text-gray-400 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Audit Logs
                            </a>
                            @endif

                            <!-- Settings (Admin Only) -->
                            @if(auth()->user()->role !== 'cashier')
                            <div x-data="{ open: false }">
                                <button @click="open = !open" class="group flex items-center w-full px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.settings') || request()->routeIs('password.change') ? 'bg-green-100 text-green-900 dark:bg-green-700 dark:text-green-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                                    <svg class="mr-3 h-6 w-6 {{ request()->routeIs('admin.settings') || request()->routeIs('password.change') ? 'text-green-500' : 'text-gray-400 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Settings
                                    <svg class="ml-auto h-5 w-5 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="ml-8 space-y-1">
                                    <a href="{{ route('admin.settings') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.settings') ? 'bg-green-100 text-green-900 dark:bg-green-700 dark:text-green-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                                        <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        General Settings
                                    </a>
                                    <a href="{{ route('password.change') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('password.change') ? 'bg-green-100 text-green-900 dark:bg-green-700 dark:text-green-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                                        <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                        </svg>
                                        Change Password
                                    </a>
                                </div>
                            </div>
                            @endif
                        </nav>
                        
                        <!-- Desktop Logout Button -->
                        <div class="flex-shrink-0 border-t border-gray-700 p-6 bg-gradient-to-r from-gray-900 to-gray-800">
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="group flex items-center w-full px-4 py-3 text-sm font-semibold rounded-xl text-red-400 bg-red-500/10 hover:bg-red-500/20 hover:text-red-300 border border-red-500/20 hover:border-red-500/40 transition-all duration-200">
                                    <svg class="mr-3 h-5 w-5 text-red-400 group-hover:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Mobile sidebar -->
                <div x-show="sidebarOpen" class="mobile-sidebar fixed inset-0 flex z-50 md:hidden" x-cloak>
                    <div x-show="sidebarOpen" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="sidebarOpen = false"></div>
                    
                    <div x-show="sidebarOpen" class="relative flex-1 flex flex-col w-64 max-w-xs bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 shadow-2xl" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
                        <div class="absolute top-0 right-0 -mr-12 pt-2">
                            <button @click="sidebarOpen = false" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-emerald-500 transition-all duration-200">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Mobile navigation content -->
                        <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto flex flex-col">
                            <div class="flex-shrink-0 flex items-center px-6 py-4">
                                <div class="h-10 w-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg">
                                    <img src="{{ asset('images/dog.png') }}" alt="Dog" class="h-8 w-8 rounded-lg">
                                </div>
                                <span class="ml-3 text-white font-bold text-lg tracking-wide">Animal Food System</span>
                            </div>
                            <nav class="mt-5 px-4 space-y-2 flex-1 overflow-y-auto">
                                <!-- Mobile navigation items -->
                                <a href="{{ route('dashboard') }}" class="group flex items-center px-4 py-3 text-base font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-emerald-500 to-green-500 text-white shadow-lg shadow-emerald-500/25' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:shadow-md' }}">
                                    <svg class="mr-4 h-6 w-6 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                                    </svg>
                                    Dashboard
                                </a>

                                <!-- Products -->
                                <a href="{{ route('admin.products.index') }}" class="group flex items-center px-4 py-3 text-base font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-gradient-to-r from-blue-500 to-indigo-500 text-white shadow-lg shadow-blue-500/25' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:shadow-md' }}">
                                    <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.products.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    Products
                                </a>

                                <!-- Inventory Management -->
                                <div x-data="{ open: {{ request()->routeIs('admin.inventory*') ? 'true' : 'false' }} }">
                                    <button @click="open = !open" class="group flex items-center w-full px-4 py-3 text-base font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.inventory*') ? 'bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-lg shadow-amber-500/25' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:shadow-md' }}">
                                        <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.inventory*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-14 0h14"></path>
                                        </svg>
                                        Inventory
                                        <svg class="ml-auto h-5 w-5 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="ml-8 space-y-2 mt-2">
                                        <a href="{{ route('admin.inventory.dashboard') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.inventory.dashboard') ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                                            <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4"></path>
                                            </svg>
                                            Dashboard
                                        </a>
                                        <a href="{{ route('admin.inventory.stock-levels') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.inventory.stock-levels') ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                                            <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                                            </svg>
                                            Stock Levels
                                        </a>
                                        <a href="{{ route('admin.inventory.scanner') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.inventory.scanner') ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                                            <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V6a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1zm12 0h2a1 1 0 001-1V6a1 1 0 00-1-1h-2a1 1 0 00-1 1v1a1 1 0 001 1zM5 20h2a1 1 0 001-1v-1a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1z"></path>
                                            </svg>
                                            Scanner
                                        </a>
                                    </div>
                                </div>

                                <!-- Sales -->
                                <a href="{{ route('admin.sales.index') }}" class="group flex items-center px-4 py-3 text-base font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.sales.*') ? 'bg-gradient-to-r from-purple-500 to-pink-500 text-white shadow-lg shadow-purple-500/25' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:shadow-md' }}">
                                    <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.sales.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                    Sales
                                </a>

                                <!-- Orders -->
                                <a href="{{ route('admin.orders.index') }}" class="group flex items-center px-4 py-3 text-base font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.orders.*') ? 'bg-gradient-to-r from-teal-500 to-cyan-500 text-white shadow-lg shadow-teal-500/25' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:shadow-md' }}">
                                    <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.orders.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    Orders
                                </a>

                                <!-- Customers -->
                                <a href="{{ route('admin.customers.index') }}" class="group flex items-center px-4 py-3 text-base font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.customers.*') ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg shadow-indigo-500/25' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:shadow-md' }}">
                                    <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.customers.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                    Customers
                                </a>
                                <!-- Suppliers (Admin Only) -->
                                @if(auth()->user()->role !== 'cashier')
                                <a href="{{ route('admin.suppliers') }}" class="group flex items-center px-4 py-3 text-base font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.suppliers') ? 'bg-gradient-to-r from-rose-500 to-pink-500 text-white shadow-lg shadow-rose-500/25' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:shadow-md' }}">
                                    <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.suppliers') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    Suppliers
                                </a>
                                @endif

                                <!-- Purchases (Admin Only) -->
                                @if(auth()->user()->role !== 'cashier')
                                <a href="{{ route('admin.purchases.index') }}" class="group flex items-center px-4 py-3 text-base font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.purchases.*') || request()->routeIs('admin.purchase-returns.*') ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg shadow-green-500/25' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:shadow-md' }}">
                                    <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.purchases.*') || request()->routeIs('admin.purchase-returns.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    Purchases
                                </a>
                                @endif

                                <!-- Categories (Admin Only) -->
                                @if(auth()->user()->role !== 'cashier')
                                <a href="{{ route('admin.categories') }}" class="group flex items-center px-4 py-3 text-base font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.categories') ? 'bg-gradient-to-r from-violet-500 to-purple-500 text-white shadow-lg shadow-violet-500/25' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:shadow-md' }}">
                                    <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.categories') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Categories
                                </a>
                                @endif

                                <!-- Billing -->
                                <a href="{{ route('admin.billing.index') }}" class="group flex items-center px-4 py-3 text-base font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.billing.*') ? 'bg-gradient-to-r from-cyan-500 to-blue-500 text-white shadow-lg shadow-cyan-500/25' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:shadow-md' }}">
                                    <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.billing.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Billing
                                </a>

                                <!-- Reports -->
                                <a href="{{ route('admin.reports.index') }}" class="group flex items-center px-4 py-3 text-base font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.reports.*') ? 'bg-gradient-to-r from-slate-500 to-gray-500 text-white shadow-lg shadow-slate-500/25' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:shadow-md' }}">
                                    <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.reports.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Reports
                                </a>

                                <!-- Users (Admin Only) -->
                                @if(auth()->user()->role !== 'cashier')
                                <a href="{{ route('admin.users') }}" class="group flex items-center px-4 py-3 text-base font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users') ? 'bg-gradient-to-r from-orange-500 to-red-500 text-white shadow-lg shadow-orange-500/25' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:shadow-md' }}">
                                    <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.users') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                    Users
                                </a>
                                @endif

                                <!-- Audit Logs (Admin Only) -->
                                @if(auth()->user()->role !== 'cashier')
                                <a href="{{ route('admin.audit-logs.index') }}" class="group flex items-center px-4 py-3 text-base font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.audit-logs.*') ? 'bg-gradient-to-r from-yellow-500 to-orange-500 text-white shadow-lg shadow-yellow-500/25' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:shadow-md' }}">
                                    <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.audit-logs.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Audit Logs
                                </a>
                                @endif

                                <!-- Settings (Admin Only) -->
                                @if(auth()->user()->role !== 'cashier')
                                <a href="{{ route('admin.settings') }}" class="group flex items-center px-4 py-3 text-base font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.settings') ? 'bg-gradient-to-r from-gray-500 to-slate-500 text-white shadow-lg shadow-gray-500/25' : 'text-gray-300 hover:bg-gray-800 hover:text-white hover:shadow-md' }}">
                                    <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.settings') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Settings
                                </a>
                                @endif
                            </nav>
                            
                            <!-- Mobile Logout Button -->
                            <div class="flex-shrink-0 border-t border-gray-700 p-6 bg-gradient-to-r from-gray-900 to-gray-800">
                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <button type="submit" class="group flex items-center w-full px-4 py-3 text-base font-semibold rounded-xl text-red-400 bg-red-500/10 hover:bg-red-500/20 hover:text-red-300 border border-red-500/20 hover:border-red-500/40 transition-all duration-200">
                                        <svg class="mr-4 h-6 w-6 text-red-400 group-hover:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main content -->
                <div class="md:pl-64 flex flex-col flex-1 min-h-screen">
                    <!-- Top navigation bar -->
                    <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 md:h-20 bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 shadow-2xl border-b border-gray-700">
                        <div class="flex-1 px-3 sm:px-4 md:px-6 flex justify-between items-center">
                            <!-- Mobile menu button -->
                            <div class="md:hidden">
                                <button @click="sidebarOpen = true" class="inline-flex items-center justify-center p-2 sm:p-3 rounded-xl text-gray-300 hover:text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-emerald-500 transition-all duration-200">
                                    <span class="sr-only">Open main menu</span>
                                    <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Page Title -->
                            <div class="flex items-center justify-center md:justify-start flex-1 md:flex-none">
                                <h1 class="text-sm sm:text-base md:text-xl font-bold bg-gradient-to-r from-emerald-400 to-green-400 bg-clip-text text-transparent text-center md:text-left">
                                    @yield('page-title', 'Dashboard')
                                </h1>
                            </div>

                            <!-- Right side items - User icon positioned at far right -->
                            <div class="flex items-center ml-auto space-x-2 sm:space-x-3 md:space-x-4">
                                <!-- Notifications -->
                                <button class="p-1.5 sm:p-2 rounded-xl text-gray-300 hover:text-white hover:bg-gray-800 transition-all duration-200 relative">
                                    <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.19 4.19A2 2 0 014 5v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-1.41.59z"></path>
                                    </svg>
                                    <span class="absolute top-0.5 right-0.5 sm:top-1 sm:right-1 h-1.5 w-1.5 sm:h-2 sm:w-2 bg-red-500 rounded-full"></span>
                                </button>

                                <!-- Profile dropdown -->
                                <div class="relative" x-data="{ open: false }">
                                    <div>
                                        <button @click="open = !open" class="max-w-xs bg-gradient-to-r from-gray-800 to-gray-700 rounded-xl flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 p-0.5 sm:p-1 border border-gray-600 hover:border-gray-500 transition-all duration-200" id="user-menu" aria-expanded="false" aria-haspopup="true">
                                            <span class="sr-only">Open user menu</span>
                                            <div class="h-6 w-6 sm:h-8 sm:w-8 rounded-lg overflow-hidden border-2 border-gray-600">
                                                <img id="top-nav-avatar" src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                            </div>
                                            <svg class="ml-1 sm:ml-2 h-3 w-3 sm:h-4 sm:w-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <!-- Dropdown menu -->
                                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 z-10 mt-3 w-56 origin-top-right rounded-xl bg-gradient-to-br from-gray-900 to-gray-800 py-2 shadow-2xl ring-1 ring-gray-700 focus:outline-none border border-gray-700">
                                        <div class="px-4 py-3 text-sm">
                                            <div class="font-semibold text-white">{{ Auth::user()->name }}</div>
                                            <div class="text-gray-400">{{ Auth::user()->email }}</div>
                                            <div class="text-xs text-gray-500 capitalize mt-1">{{ str_replace('_', ' ', Auth::user()->role) }}</div>
                                        </div>
                                        <div class="border-t border-gray-700">
                                            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                                                <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                Profile
                                            </a>
                                            <a href="{{ route('password.change') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                                                <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                                </svg>
                                                Change Password
                                            </a>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors">
                                                    <svg class="mr-3 h-4 w-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                    </svg>
                                                    Sign out
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Page content -->
                    <main class="flex-1 min-h-0">
                        <div class="py-3 sm:py-4 md:py-6 h-full">
                            <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8 h-full">
                                {{ $slot }}
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </body>
</html> 