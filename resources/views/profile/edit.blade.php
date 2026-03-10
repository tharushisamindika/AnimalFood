<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Profile Settings</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Manage your account profile information.</p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Profile Information -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Profile Information</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Update your account's profile information.</p>
            </div>
            <div class="p-6">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Change Password -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Change Password</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Update your password to keep your account secure.</p>
            </div>
            <div class="p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account (Admin Only) -->
        @if(auth()->user()->role !== 'cashier')
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Delete Account</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Permanently delete your account and all associated data.</p>
            </div>
            <div class="p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
        @endif
    </div>
</x-admin-layout>
