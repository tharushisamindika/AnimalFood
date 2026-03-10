@foreach($customers as $customer)
<tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
    @if(auth()->user()->role !== 'cashier')
    <td class="px-6 py-4 whitespace-nowrap">
        <input type="checkbox" class="customer-checkbox rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50" value="{{ $customer->id }}">
    </td>
    @endif
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center">
            <div class="flex-shrink-0 h-10 w-10">
                <div class="h-10 w-10 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                    <span class="text-sm font-medium text-green-800 dark:text-green-200">
                        {{ strtoupper(substr($customer->name, 0, 2)) }}
                    </span>
                </div>
            </div>
            <div class="ml-4">
                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $customer->name }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">ID: {{ $customer->customer_id }}</div>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-900 dark:text-white">{{ $customer->email }}</div>
        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $customer->phone }}</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
            @if($customer->customer_type === 'individual') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
            @elseif($customer->customer_type === 'shop') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
            @elseif($customer->customer_type === 'institute') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
            @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
            {{ ucfirst($customer->customer_type ?? 'individual') }}
        </span>
        @if($customer->company_name)
            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $customer->company_name }}</div>
        @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-900 dark:text-white">{{ $customer->city }}, {{ $customer->state }}</div>
        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $customer->postal_code }}</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
            @if($customer->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
            @elseif($customer->status === 'inactive') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
            @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
            {{ ucfirst($customer->status ?? 'active') }}
        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
        {{ $customer->orders->count() }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
        {{ $customer->created_at->format('M d, Y') }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <div class="flex justify-end space-x-1 action-buttons">
            <button onclick="viewCustomer({{ $customer->id }})" class="text-blue-600 hover:text-blue-900 dark:hover:text-blue-400 p-1 rounded hover:bg-blue-50 dark:hover:bg-blue-900/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </button>
            <button onclick="editCustomer({{ $customer->id }})" class="text-green-600 hover:text-green-900 dark:hover:text-green-400 p-1 rounded hover:bg-green-50 dark:hover:bg-green-900/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </button>
            @if(auth()->user()->role !== 'cashier')
            <button onclick="deleteCustomer({{ $customer->id }})" class="text-red-600 hover:text-red-900 dark:hover:text-red-400 p-1 rounded hover:bg-red-50 dark:hover:bg-red-900/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
            @endif
        </div>
    </td>
</tr>
@endforeach
