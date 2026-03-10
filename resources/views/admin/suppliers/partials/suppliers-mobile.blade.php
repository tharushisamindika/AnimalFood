@foreach($suppliers as $supplier)
<div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 p-4">
    <div class="flex items-start justify-between">
        <div class="flex items-center space-x-3">
            <div class="h-12 w-12 rounded-lg bg-blue-100 dark:bg-blue-900 flex items-center justify-center flex-shrink-0">
                <svg class="h-7 w-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white truncate">{{ $supplier->name }}</h3>
                <p class="text-xs text-blue-600 dark:text-blue-400 font-mono">{{ $supplier->supplier_id ?? 'N/A' }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $supplier->contact_person }}</p>
            </div>
        </div>
        <div class="flex space-x-2">
            <button onclick="viewSupplier({{ $supplier->id }})" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 p-2 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20" title="View Details">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </button>
            <button onclick="editSupplier({{ $supplier->id }})" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 p-2 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20" title="Edit Supplier">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </button>
            <button onclick="deleteSupplier({{ $supplier->id }})" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20" title="Delete Supplier">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>
    </div>
    
    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
        <div class="space-y-3">
            <div>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Contact:</span>
                <div class="text-sm text-gray-900 dark:text-white">{{ $supplier->email }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $supplier->phone }}</div>
                @if($supplier->secondary_phone)
                    <div class="text-xs text-gray-400 dark:text-gray-500">{{ $supplier->secondary_phone }}</div>
                @endif
            </div>
            <div>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Address:</span>
                <div class="text-sm text-gray-900 dark:text-white">{{ Str::limit($supplier->address, 60) }}</div>
            </div>
        </div>
    </div>
    
    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap gap-2">
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $supplier->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                {{ ucfirst($supplier->status) }}
            </span>
            @if($supplier->is_blacklisted)
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-black text-white dark:bg-gray-800 dark:text-gray-100">
                    Blacklisted
                </span>
            @endif
        </div>
    </div>
</div>
@endforeach
