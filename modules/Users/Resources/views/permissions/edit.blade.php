<x-admin::layouts.master>
    <div class="max-w-3xl mx-auto space-y-6" 
         x-data="{ 
            isSuperUser: false,
            showDeleteModal: false,
            showAccessDeniedModal: false,
            
            triggerDelete() {
                if (!this.isSuperUser) {
                    this.showAccessDeniedModal = true;
                    return;
                }
                this.showDeleteModal = true;
            }
         }">
        
        <!-- HEADER TITLE & ACTION -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2 text-xs font-medium text-gray-500 mb-2">
                    <a href="{{ route('admin.dashboard') ?? '#' }}" class="hover:text-primary transition-colors flex items-center gap-1">
                        <span class="iconify text-sm" data-icon="heroicons:home"></span>
                    </a>
                    <span class="iconify text-xs text-gray-400" data-icon="heroicons:chevron-right"></span>
                    <a href="{{ route('users.roles.index') }}" class="hover:text-primary transition-colors">Roles & Permissions</a>
                    <span class="iconify text-xs text-gray-400" data-icon="heroicons:chevron-right"></span>
                    <span class="text-gray-800 font-semibold">Edit Master Permission</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">Edit Permission</h1>
                <p class="text-sm text-gray-500 mt-0.5">Modify master permission details. Core system keys are protected.</p>
            </div>
            
            <a href="{{ route('users.roles.index') }}" class="inline-flex items-center gap-2 bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-all shadow-sm font-medium text-sm focus:outline-none">
                <span class="iconify text-lg" data-icon="heroicons:arrow-left"></span>
                <span>Back</span>
            </a>
        </div>

        <form action="{{ route('users.permissions.update', 1) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- PERMISSION DETAILS CARD -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/50 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="iconify text-xl text-emerald-600" data-icon="heroicons:key"></span>
                        <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Permission Properties</h2>
                    </div>
                    
                    <!-- Toggle Simulation (Mockup only) -->
                    <label class="flex items-center gap-2 cursor-pointer" title="Simulate Super User">
                        <span class="text-[10px] font-semibold text-gray-400 uppercase">Simulate Super User</span>
                        <div class="relative">
                            <input type="checkbox" x-model="isSuperUser" class="sr-only">
                            <div class="block bg-gray-200 w-8 h-4 rounded-full transition-colors duration-300" :class="{'bg-emerald-500': isSuperUser}"></div>
                            <div class="dot absolute left-0.5 top-0.5 bg-white w-3 h-3 rounded-full transition-transform duration-300" :class="{'transform translate-x-4': isSuperUser}"></div>
                        </div>
                    </label>
                </div>
                
                <div class="p-6 space-y-5">
                    
                    <!-- ALERT / WARNING -->
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 flex gap-3 text-amber-800 text-sm shadow-sm">
                        <span class="iconify text-xl shrink-0" data-icon="heroicons:exclamation-triangle"></span>
                        <div>
                            <strong class="font-bold block mb-0.5">Core System Permission</strong>
                            <p>Modifying the <code class="bg-amber-100 px-1 rounded">Permission Key</code> can cause application errors if it's referenced in the source code. It is currently <strong class="underline">Read-Only</strong> for safety.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Permission Key (Read Only) -->
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Permission Key (Name) <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="iconify absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg" data-icon="heroicons:lock-closed"></span>
                                <input type="text" id="name" name="name" value="delete_users" readonly
                                       class="w-full pl-10 pr-4 py-2.5 bg-gray-100 border border-gray-200 text-gray-500 font-mono rounded-lg cursor-not-allowed focus:outline-none text-sm">
                            </div>
                            <p class="text-[11px] text-gray-500 mt-1">This key is used programmatically (e.g., <code class="bg-gray-100 px-1 rounded text-pink-600">@@can('delete_users')</code>).</p>
                        </div>

                        <!-- Module Group -->
                        <div>
                            <label for="module" class="block text-sm font-semibold text-gray-700 mb-1">Module Group</label>
                            <select id="module" name="module" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-sm transition-all">
                                <option value="Users" selected>Users</option>
                                <option value="Settings">Settings</option>
                                <option value="Roles">Roles</option>
                                <option value="General">General</option>
                            </select>
                            <p class="text-[11px] text-gray-400 mt-1">Used to group permissions in the Matrix.</p>
                        </div>

                        <!-- Guard Name -->
                        <div>
                            <label for="guard_name" class="block text-sm font-semibold text-gray-700 mb-1">Guard Name</label>
                            <input type="text" id="guard_name" name="guard_name" value="web" readonly
                                   class="w-full px-4 py-2.5 bg-gray-100 border border-gray-200 text-gray-500 rounded-lg cursor-not-allowed text-sm">
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                            <textarea id="description" name="description" rows="3"
                                      class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-sm transition-all resize-y">Allows permanently deleting user accounts.</textarea>
                            <p class="text-[11px] text-gray-400 mt-1">A human-readable description for administrators.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FORM ACTIONS -->
            <div class="flex items-center justify-between pt-2 pb-10">
                <!-- Delete Action (Triggers Pop-up Modal) -->
                <div class="relative group inline-block">
                    <button type="button" 
                            @click="triggerDelete()"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-rose-600 bg-rose-50 border border-rose-200 hover:bg-rose-100 rounded-lg transition-colors focus:outline-none">
                        <span class="iconify text-lg" data-icon="heroicons:trash"></span>
                        Delete Permission
                    </button>
                </div>
                
                <div class="flex gap-3">
                    <a href="{{ route('users.roles.index') }}" class="px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors shadow-sm focus:outline-none">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 transition-all shadow-sm focus:ring-2 focus:ring-offset-1 focus:ring-emerald-600">
                        <span class="iconify text-lg" data-icon="heroicons:check-circle"></span>
                        Update Data
                    </button>
                </div>
            </div>

        </form>

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
                                    Delete Permission
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete permission <strong class="text-gray-900">delete_users</strong>? 
                                        This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-3.5 sm:flex sm:flex-row-reverse sm:px-6 gap-2 border-t border-gray-100">
                        <form action="{{ route('users.permissions.destroy', 1) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-rose-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 sm:w-auto transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                                Confirm Delete
                            </button>
                        </form>
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
                                        Deleting system permissions is restricted to <strong>Super Administrator</strong> accounts only.
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
