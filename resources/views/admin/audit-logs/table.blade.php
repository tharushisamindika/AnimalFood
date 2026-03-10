<!-- Desktop Table View -->
<div class="hidden md:block overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Date/Time
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Action
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Model
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    User
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Description
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Changes
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($auditLogs as $log)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                    {{ $log->created_at->format('M d, Y g:i A') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                        @if($log->action === 'created') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                        @elseif($log->action === 'updated') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                        @elseif($log->action === 'deleted') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                        @elseif($log->action === 'login') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                        @elseif($log->action === 'logout') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                        @elseif($log->action === 'login_failed') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                        @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                    {{ class_basename($log->model_type) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                    {{ $log->user->name ?? 'System' }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                    {{ Str::limit($log->description, 50) }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                    @if($log->action === 'updated' && $log->changed_fields)
                        <div class="text-xs">
                            @foreach($log->changed_fields as $field)
                                <div class="mb-1">
                                    <span class="font-medium">{{ $field }}:</span>
                                    <span class="text-red-600 dark:text-red-400">{{ $log->old_values[$field] ?? 'null' }}</span>
                                    <span class="mx-1">→</span>
                                    <span class="text-green-600 dark:text-green-400">{{ $log->new_values[$field] ?? 'null' }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <span class="text-gray-500 dark:text-gray-400">{{ $log->formatted_changes }}</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button onclick="viewDetails({{ $log->id }})" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 p-1 rounded hover:bg-blue-50 dark:hover:bg-blue-900/20" title="View Details">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center">
                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No audit logs found</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No audit logs match your current filters.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Mobile Card View -->
<div class="md:hidden space-y-4 p-4">
    @forelse($auditLogs as $log)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-start justify-between">
            <div class="flex items-center space-x-3">
                <div class="h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white truncate">{{ class_basename($log->model_type) }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $log->created_at->format('M d, Y g:i A') }}</p>
                </div>
            </div>
            <div class="flex space-x-2">
                <button onclick="viewDetails({{ $log->id }})" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 p-2 rounded hover:bg-blue-50 dark:hover:bg-blue-900/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
            <div>
                <span class="font-medium text-gray-500 dark:text-gray-400">Action:</span>
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                    @if($log->action === 'created') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                    @elseif($log->action === 'updated') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                    @elseif($log->action === 'deleted') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                    @elseif($log->action === 'login') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                    @elseif($log->action === 'logout') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                    @elseif($log->action === 'login_failed') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                    @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                </span>
            </div>
            <div>
                <span class="font-medium text-gray-500 dark:text-gray-400">User:</span>
                <div class="text-gray-900 dark:text-white">{{ $log->user->name ?? 'System' }}</div>
            </div>
            <div class="col-span-2">
                <span class="font-medium text-gray-500 dark:text-gray-400">Description:</span>
                <div class="text-gray-900 dark:text-white">{{ Str::limit($log->description, 100) }}</div>
            </div>
            @if($log->action === 'updated' && $log->changed_fields)
            <div class="col-span-2">
                <span class="font-medium text-gray-500 dark:text-gray-400">Changes:</span>
                <div class="text-xs mt-1">
                    @foreach($log->changed_fields as $field)
                        <div class="mb-1">
                            <span class="font-medium">{{ $field }}:</span>
                            <span class="text-red-600 dark:text-red-400">{{ $log->old_values[$field] ?? 'null' }}</span>
                            <span class="mx-1">→</span>
                            <span class="text-green-600 dark:text-green-400">{{ $log->new_values[$field] ?? 'null' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="text-center py-12 text-gray-500 dark:text-gray-400">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <p class="mt-2">No audit logs found.</p>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($auditLogs->hasPages())
<div class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
    <div class="flex-1 flex justify-between sm:hidden">
        @if($auditLogs->onFirstPage())
            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 cursor-not-allowed">
                Previous
            </span>
        @else
            <a href="{{ $auditLogs->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                Previous
            </a>
        @endif

        @if($auditLogs->hasMorePages())
            <a href="{{ $auditLogs->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                Next
            </a>
        @else
            <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 cursor-not-allowed">
                Next
            </span>
        @endif
    </div>
    
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-gray-700 dark:text-gray-300">
                Showing <span class="font-medium">{{ $auditLogs->firstItem() ?? 0 }}</span> to <span class="font-medium">{{ $auditLogs->lastItem() ?? 0 }}</span> of <span class="font-medium">{{ $auditLogs->total() }}</span> results
            </p>
        </div>
        <div>
            {{ $auditLogs->links() }}
        </div>
    </div>
</div>
@endif
