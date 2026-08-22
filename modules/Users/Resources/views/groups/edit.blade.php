<x-admin::layouts.master>
    <div class="space-y-6">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('users.groups.index') ?? '#' }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">
                        Groups
                    </a>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-sm font-medium text-gray-900 dark:text-gray-200">Edit Group</span>
                </div>
                <h1 class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">Edit: {{ $group['name'] ?? 'Group Name' }}</h1>
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <button type="button" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-red-700 bg-red-100 border border-transparent rounded-lg shadow-sm hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50">
                    Delete Group
                </button>
            </div>
        </div>

        <!-- Form Section -->
        <form action="{{ route('users.groups.update', $group['id'] ?? 1) ?? '#' }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Main Form Form -->
                <div class="flex-1 space-y-6">
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
                        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">General Information</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Basic details about this user group.</p>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Group Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Group Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ $group['name'] ?? '' }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ $group['description'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Permissions Mockup -->
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
                        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Module Permissions</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Select which modules and actions this group can access.</p>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Users Module -->
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <h4 class="font-medium text-gray-900 dark:text-white mb-3">Users Management</h4>
                                    <div class="space-y-2">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" checked class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-500">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">View Users</span>
                                        </label><br>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" checked class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-500">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Create Users</span>
                                        </label><br>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" checked class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-500">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Edit Users</span>
                                        </label><br>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-500">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Delete Users</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Settings Module -->
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <h4 class="font-medium text-gray-900 dark:text-white mb-3">System Settings</h4>
                                    <div class="space-y-2">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" checked class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-500">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">View Settings</span>
                                        </label><br>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-500">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Manage Configurations</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Form -->
                <div class="w-full lg:w-80 space-y-6">
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
                        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Status</h3>
                        </div>
                        <div class="p-6">
                            <div x-data="{ isActived: {{ isset($group['status']) && $group['status'] === 'active' ? 'true' : 'false' }} }" class="flex items-center justify-between">
                                <span class="flex-grow flex flex-col">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white" x-text="isActived ? 'Active' : 'Inactive'"></span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Can be assigned to users</span>
                                </span>
                                <!-- Toggle Button -->
                                <button type="button" 
                                    @click="isActived = !isActived" 
                                    :class="isActived ? 'bg-primary-600' : 'bg-gray-200 dark:bg-gray-700'"
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900" 
                                    role="switch" aria-checked="true">
                                    <span aria-hidden="true" 
                                        :class="isActived ? 'translate-x-5' : 'translate-x-0'"
                                        class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                </button>
                                <input type="hidden" name="status" :value="isActived ? 'active' : 'inactive'">
                            </div>
                        </div>
                    </div>

                    <!-- Additional Metadata Mockup -->
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
                        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Additional Information</h3>
                        </div>
                        <div class="p-6 space-y-4 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex justify-between">
                                <span>Members Count:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $group['users_count'] ?? 0 }} Users</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Created At:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ date('M d, Y', strtotime($group['created_at'] ?? now())) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 flex items-center justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('users.groups.index') ?? '#' }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                    Cancel
                </a>
                <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white transition-colors border border-transparent rounded-lg shadow-sm bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                    Save Changes
                </button>
            </div>
        </form>

    </div>
</x-admin::layouts.master>

