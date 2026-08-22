<x-admin::layouts.master>
    <!-- State Management with Alpine.js -->
    <!-- activeTab: 'roles' or 'permissions' -->
    <!-- isSuperUser: mockup flag to demonstrate delete restriction -->
    <div x-data="{
            activeTab: 'roles',
            searchQuery: '',
            isSuperUser: false, // Ubah ke true untuk simulasi super user
            
            // Modal States
            showDeleteModal: false,
            showAccessDeniedModal: false,
            deleteType: '', // 'role' or 'permission'
            deleteId: null,
            deleteName: '',
            
            triggerDelete(type, id, name) {
                if (!this.isSuperUser) {
                    this.showAccessDeniedModal = true;
                    return;
                }
                this.deleteType = type;
                this.deleteId = id;
                this.deleteName = name;
                this.showDeleteModal = true;
            }
         }" 
         class="space-y-6">

        <!-- HEADER TITLE & ACTION -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2 text-xs font-medium text-gray-500 mb-2">
                    <a href="{{ route('admin.dashboard') ?? '#' }}" class="hover:text-primary transition-colors flex items-center gap-1">
                        <span class="iconify text-sm" data-icon="heroicons:home"></span>
                        Dashboard
                    </a>
                    <span class="iconify text-xs text-gray-400" data-icon="heroicons:chevron-right"></span>
                    <span class="text-gray-800 font-semibold">Roles & Permissions</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">Access Management</h1>
                <p class="text-sm text-gray-500 mt-0.5">Manage system roles, assign permissions, and control master access definitions.</p>
            </div>
            
            <!-- Dynamic Action Buttons based on Active Tab -->
            <div class="flex items-center gap-3">
                <!-- Toggle Super User Simulation (Mockup Only) -->
                <label class="flex items-center gap-2 cursor-pointer mr-4" title="Simulate Super User">
                    <div class="relative">
                        <input type="checkbox" x-model="isSuperUser" class="sr-only">
                        <div class="block bg-gray-200 w-10 h-6 rounded-full transition-colors duration-300" :class="{'bg-emerald-500': isSuperUser}"></div>
                        <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform duration-300" :class="{'transform translate-x-4': isSuperUser}"></div>
                    </div>
                    <span class="text-xs font-semibold text-gray-600" x-text="isSuperUser ? 'Super User Mode' : 'Normal Admin Mode'"></span>
                </label>

                <a x-show="activeTab === 'roles'" href="{{ route('users.roles.create') }}" 
                   class="inline-flex items-center gap-2 bg-primary text-white px-4 py-2.5 rounded-lg hover:bg-blue-600 transition-all shadow-sm font-medium text-sm focus:ring-2 focus:ring-offset-2 focus:ring-primary focus:outline-none shrink-0"
                   x-transition>
                    <span class="iconify text-lg" data-icon="heroicons:plus"></span>
                    <span>Create Role</span>
                </a>

                <a x-show="activeTab === 'permissions'" href="{{ route('users.permissions.create') }}" 
                   class="inline-flex items-center gap-2 bg-emerald-600 text-white px-4 py-2.5 rounded-lg hover:bg-emerald-700 transition-all shadow-sm font-medium text-sm focus:ring-2 focus:ring-offset-2 focus:ring-emerald-600 focus:outline-none shrink-0"
                   x-transition x-cloak>
                    <span class="iconify text-lg" data-icon="heroicons:plus"></span>
                    <span>Create Permission</span>
                </a>
            </div>
        </div>

        <!-- FLASH MESSAGE NOTIFICATION -->
        @if(session('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-cloak
             class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-between text-emerald-800 text-sm shadow-sm">
            <div class="flex items-center gap-3">
                <span class="iconify text-xl text-emerald-600 shrink-0" data-icon="heroicons:check-circle"></span>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button type="button" @click="show = false" class="text-emerald-500 hover:text-emerald-700 p-1 rounded-lg">
                <span class="iconify text-lg" data-icon="heroicons:x-mark"></span>
            </button>
        </div>
        @endif

        <!-- MAIN CARD & TABS -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            
            <!-- TABS NAVIGATION -->
            <div class="border-b border-gray-200 bg-gray-50/50">
                <nav class="flex -mb-px px-4 gap-6" aria-label="Tabs">
                    <button @click="activeTab = 'roles'"
                            :class="activeTab === 'roles' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-semibold text-sm flex items-center gap-2 transition-colors focus:outline-none">
                        <span class="iconify text-lg" data-icon="heroicons:shield-check"></span>
                        System Roles
                    </button>

                    <button @click="activeTab = 'permissions'"
                            :class="activeTab === 'permissions' ? 'border-emerald-600 text-emerald-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-semibold text-sm flex items-center gap-2 transition-colors focus:outline-none">
                        <span class="iconify text-lg" data-icon="heroicons:key"></span>
                        Master Permissions
                    </button>
                </nav>
            </div>

            <!-- TOOLBAR: SEARCH -->
            <div class="p-4 border-b border-gray-200 bg-white">
                <div class="relative w-full sm:max-w-md">
                    <span class="iconify absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg" data-icon="heroicons:magnifying-glass"></span>
                    <input type="text" 
                           x-model="searchQuery"
                           :placeholder="activeTab === 'roles' ? 'Search roles...' : 'Search permissions...'" 
                           class="w-full pl-10 pr-4 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                </div>
            </div>

            <!-- TAB CONTENT: ROLES -->
            <div x-show="activeTab === 'roles'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-700 uppercase font-semibold text-xs border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3.5 whitespace-nowrap">Role Name</th>
                            <th class="px-6 py-3.5 whitespace-nowrap">Users Count</th>
                            <th class="px-6 py-3.5 whitespace-nowrap">Permissions</th>
                            <th class="px-6 py-3.5 whitespace-nowrap text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <!-- Mockup Role: Super Admin -->
                        <tr class="hover:bg-blue-50/50 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold text-gray-900">Super Administrator</div>
                                <div class="text-xs text-gray-500 mt-0.5">Full access to all system features.</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700">1</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                    All Permissions (Bypass)
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-1 opacity-80 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('users.roles.edit', 1) }}" class="p-2 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors focus:outline-none" title="Edit Role">
                                        <span class="iconify text-lg" data-icon="heroicons:pencil-square"></span>
                                    </a>
                                    <!-- Delete Button -->
                                    <button type="button" 
                                            @click="triggerDelete('role', 1, 'Super Administrator')"
                                            class="p-2 rounded-lg transition-colors focus:outline-none inline-flex items-center group relative text-gray-500 hover:text-rose-600 hover:bg-rose-50 cursor-pointer" 
                                            title="Delete Role">
                                        <span class="iconify text-lg" data-icon="heroicons:trash"></span>
                                        <div x-show="!isSuperUser" class="absolute bottom-full mb-2 hidden group-hover:block w-max bg-gray-800 text-white text-[10px] px-2 py-1 rounded whitespace-nowrap right-0">
                                            Super User Only
                                        </div>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Mockup Role: Manager -->
                        <tr class="hover:bg-blue-50/50 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold text-gray-900">Manager</div>
                                <div class="text-xs text-gray-500 mt-0.5">Can manage users and content.</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700">5</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-gray-100 text-gray-600 border border-gray-200">view_users</span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-gray-100 text-gray-600 border border-gray-200">edit_users</span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-gray-100 text-gray-600 border border-gray-200">view_settings</span>
                                    <span class="text-xs text-gray-400 font-medium pl-1">+12 more</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-1 opacity-80 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('users.roles.edit', 2) }}" class="p-2 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors focus:outline-none" title="Edit Role">
                                        <span class="iconify text-lg" data-icon="heroicons:pencil-square"></span>
                                    </a>
                                    <!-- Delete Button -->
                                    <button type="button" 
                                            @click="triggerDelete('role', 2, 'Manager')"
                                            class="p-2 rounded-lg transition-colors focus:outline-none inline-flex items-center group relative text-gray-500 hover:text-rose-600 hover:bg-rose-50 cursor-pointer" 
                                            title="Delete Role">
                                        <span class="iconify text-lg" data-icon="heroicons:trash"></span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- TAB CONTENT: PERMISSIONS -->
            <div x-show="activeTab === 'permissions'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-700 uppercase font-semibold text-xs border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3.5 whitespace-nowrap">Permission Key</th>
                            <th class="px-6 py-3.5 whitespace-nowrap">Module Group</th>
                            <th class="px-6 py-3.5">Description</th>
                            <th class="px-6 py-3.5 whitespace-nowrap text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        
                        <!-- Mockup Permission 1 -->
                        <tr class="hover:bg-emerald-50/50 transition-colors group">
                            <td class="px-6 py-3 whitespace-nowrap">
                                <code class="text-xs font-bold text-pink-600 bg-pink-50 px-2 py-1 rounded">view_users</code>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <span class="text-xs font-semibold text-gray-700">Users</span>
                            </td>
                            <td class="px-6 py-3 text-xs text-gray-500">
                                Allows viewing the list of users and user details.
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-1 opacity-80 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('users.permissions.edit', 1) }}" class="p-2 text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors focus:outline-none" title="Edit Permission">
                                        <span class="iconify text-lg" data-icon="heroicons:pencil-square"></span>
                                    </a>
                                    <!-- Delete Button -->
                                    <button type="button" 
                                            @click="triggerDelete('permission', 1, 'view_users')"
                                            class="p-2 rounded-lg transition-colors focus:outline-none inline-flex items-center group relative text-gray-500 hover:text-rose-600 hover:bg-rose-50 cursor-pointer" 
                                            title="Delete Permission">
                                        <span class="iconify text-lg" data-icon="heroicons:trash"></span>
                                        <div x-show="!isSuperUser" class="absolute bottom-full mb-2 hidden group-hover:block w-max bg-gray-800 text-white text-[10px] px-2 py-1 rounded whitespace-nowrap right-0">
                                            Super User Only
                                        </div>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Mockup Permission 2 -->
                        <tr class="hover:bg-emerald-50/50 transition-colors group">
                            <td class="px-6 py-3 whitespace-nowrap">
                                <code class="text-xs font-bold text-pink-600 bg-pink-50 px-2 py-1 rounded">delete_users</code>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <span class="text-xs font-semibold text-gray-700">Users</span>
                            </td>
                            <td class="px-6 py-3 text-xs text-gray-500">
                                Allows permanently deleting user accounts.
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-1 opacity-80 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('users.permissions.edit', 2) }}" class="p-2 text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors focus:outline-none" title="Edit Permission">
                                        <span class="iconify text-lg" data-icon="heroicons:pencil-square"></span>
                                    </a>
                                    <!-- Delete Button -->
                                    <button type="button" 
                                            @click="triggerDelete('permission', 2, 'delete_users')"
                                            class="p-2 rounded-lg transition-colors focus:outline-none inline-flex items-center group relative text-gray-500 hover:text-rose-600 hover:bg-rose-50 cursor-pointer" 
                                            title="Delete Permission">
                                        <span class="iconify text-lg" data-icon="heroicons:trash"></span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION MOCKUP -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50/60 text-center">
                <span class="text-xs text-gray-500">Showing 1 to 2 entries (Mockup)</span>
            </div>
            
        </div>

        <!-- ========================================================================= -->
        <!-- MODAL: DELETE CONFIRMATION (ALPINE.JS)                                    -->
        <!-- ========================================================================= -->
        <div x-show="showDeleteModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
            
            <div x-show="showDeleteModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
                 @click="showDeleteModal = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="showDeleteModal" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-200">
                    
                    <div class="bg-white px-6 pb-6 pt-6 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-rose-100 sm:mx-0 sm:h-10 sm:w-10 text-rose-600">
                                <span class="iconify text-2xl" data-icon="heroicons:exclamation-triangle"></span>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-bold leading-6 text-gray-900" id="modal-title">
                                    Delete <span class="capitalize" x-text="deleteType"></span>
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete this <span x-text="deleteType"></span>: <strong class="text-gray-900" x-text="deleteName"></strong>? 
                                        This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-3.5 sm:flex sm:flex-row-reverse sm:px-6 gap-2 border-t border-gray-100">
                        <button type="button" @click="showDeleteModal = false" class="inline-flex w-full justify-center rounded-lg bg-rose-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 sm:w-auto transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                            Confirm Delete
                        </button>
                        <button type="button" @click="showDeleteModal = false" class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- MODAL: ACCESS DENIED / SUPER USER ONLY (ALPINE.JS)                        -->
        <!-- ========================================================================= -->
        <div x-show="showAccessDeniedModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="access-denied-title" 
             role="dialog" 
             aria-modal="true">
            
            <div x-show="showAccessDeniedModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
                 @click="showAccessDeniedModal = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="showAccessDeniedModal" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-200">
                    
                    <div class="bg-white px-6 pb-6 pt-6 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-amber-100 sm:mx-0 sm:h-10 sm:w-10 text-amber-600">
                                <span class="iconify text-2xl" data-icon="heroicons:shield-exclamation"></span>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-bold leading-6 text-gray-900" id="access-denied-title">
                                    Super User Access Required
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Deleting system roles or permissions is restricted to <strong>Super Administrator</strong> accounts only.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-3.5 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-100">
                        <button type="button" @click="showAccessDeniedModal = false" class="inline-flex w-full justify-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-800 sm:w-auto transition-colors focus:outline-none">
                            Understood
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-admin::layouts.master>
