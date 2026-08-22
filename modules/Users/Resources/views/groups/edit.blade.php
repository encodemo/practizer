<x-admin::layouts.master>
    <div x-data="{
            name: '{{ addslashes($group['name'] ?? '') }}',
            description: '{{ addslashes($group['description'] ?? '') }}',
            isActived: {{ isset($group['status']) && $group['status'] === 'active' ? 'true' : 'false' }},
            selectAll: false,
            showDeleteModal: false,
            toggleAllPermissions(checked) {
                this.$el.closest('form').querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = checked);
            }
         }" 
         class="space-y-6 max-w-7xl mx-auto">
        
        <!-- BREADCRUMBS & TOP ACTIONS HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2 text-xs font-medium text-gray-500 mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors flex items-center gap-1">
                        <span class="iconify text-sm" data-icon="heroicons:home"></span>
                        Dashboard
                    </a>
                    <span class="iconify text-xs text-gray-400" data-icon="heroicons:chevron-right"></span>
                    <a href="{{ route('users.index') }}" class="hover:text-primary transition-colors">Users</a>
                    <span class="iconify text-xs text-gray-400" data-icon="heroicons:chevron-right"></span>
                    <a href="{{ route('users.groups.index') }}" class="hover:text-primary transition-colors">User Groups</a>
                    <span class="iconify text-xs text-gray-400" data-icon="heroicons:chevron-right"></span>
                    <span class="text-gray-800 font-semibold">{{ $group['name'] ?? 'Edit Group' }}</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">Edit Group: {{ $group['name'] ?? 'Group' }}</h1>
                <p class="text-sm text-gray-500 mt-0.5">Modify group identity, access rules, and active assignment status.</p>
            </div>

            <!-- Top Action Buttons -->
            <div class="flex items-center gap-2">
                <a href="{{ route('users.groups.index') }}" 
                   class="inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm focus:ring-2 focus:ring-offset-1 focus:ring-gray-300">
                    <span class="iconify text-base" data-icon="heroicons:arrow-left"></span>
                    <span>Back</span>
                </a>

                <button type="button" 
                        @click="showDeleteModal = true" 
                        class="inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-rose-200 text-rose-600 rounded-lg text-sm font-medium hover:bg-rose-50 hover:border-rose-300 transition-all shadow-sm focus:ring-2 focus:ring-offset-1 focus:ring-rose-300">
                    <span class="iconify text-base" data-icon="heroicons:trash"></span>
                    <span>Delete Group</span>
                </button>

                <button type="button" 
                        onclick="document.getElementById('edit-group-form').submit()" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-blue-600 transition-all shadow-sm focus:ring-2 focus:ring-offset-1 focus:ring-primary">
                    <span class="iconify text-base" data-icon="heroicons:check"></span>
                    <span>Save Changes</span>
                </button>
            </div>
        </div>

        <!-- MAIN FORM -->
        <form id="edit-group-form" action="{{ route('users.groups.update', $group['id'] ?? 1) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- LEFT COLUMN: PRIMARY DETAILS & PERMISSION MATRIX (8 COLS) -->
                <div class="lg:col-span-8 space-y-6">
                    
                    <!-- CARD 1: GENERAL INFORMATION -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-5">
                            <div>
                                <h3 class="text-base font-bold text-gray-900">General Information</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Basic identity and operational scope for this user group.</p>
                            </div>
                            <span class="iconify text-2xl text-primary" data-icon="heroicons:user-group"></span>
                        </div>

                        <div class="space-y-5">
                            <!-- Group Name -->
                            <div>
                                <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Group Name <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="iconify absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg" data-icon="heroicons:identification"></span>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           x-model="name"
                                           value="{{ $group['name'] ?? '' }}"
                                           placeholder="e.g. Engineering Lead, Marketing Ops, Finance" 
                                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all" 
                                           required>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Description / Purpose
                                </label>
                                <textarea id="description" 
                                          name="description" 
                                          rows="3" 
                                          x-model="description"
                                          class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all resize-y">{{ $group['description'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 2: PERMISSIONS CHECKBOX MATRIX -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/50 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="iconify text-xl text-emerald-600" data-icon="heroicons:shield-check"></span>
                                <div>
                                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Group Permissions Matrix</h3>
                                    <p class="text-[11px] text-gray-500">Assign baseline module rights inherited by group members.</p>
                                </div>
                            </div>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" 
                                       x-model="selectAll" 
                                       @change="toggleAllPermissions(selectAll)"
                                       class="rounded border-gray-300 text-primary focus:ring-primary w-4 h-4">
                                <span class="text-xs font-semibold text-gray-600">Select All</span>
                            </label>
                        </div>
                        
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                            
                            <!-- Module 1: Users -->
                            <div class="border border-gray-200 rounded-xl overflow-hidden">
                                <div class="bg-gray-50 px-4 py-2.5 border-b border-gray-200 font-bold text-gray-800 text-xs uppercase tracking-wider flex items-center gap-2">
                                    <span class="iconify text-base text-gray-500" data-icon="heroicons:users"></span>
                                    Users Management
                                </div>
                                <div class="p-4 space-y-3">
                                    <label class="flex items-start gap-2.5 cursor-pointer group">
                                        <input type="checkbox" name="permissions[]" value="view_users" class="perm-checkbox mt-0.5 rounded border-gray-300 text-primary focus:ring-primary" checked>
                                        <div>
                                            <span class="text-xs font-mono font-bold text-gray-800 group-hover:text-primary transition-colors block">view_users</span>
                                            <span class="text-[11px] text-gray-500">View user directory & profiles</span>
                                        </div>
                                    </label>
                                    <label class="flex items-start gap-2.5 cursor-pointer group">
                                        <input type="checkbox" name="permissions[]" value="create_users" class="perm-checkbox mt-0.5 rounded border-gray-300 text-primary focus:ring-primary" checked>
                                        <div>
                                            <span class="text-xs font-mono font-bold text-gray-800 group-hover:text-primary transition-colors block">create_users</span>
                                            <span class="text-[11px] text-gray-500">Register new user accounts</span>
                                        </div>
                                    </label>
                                    <label class="flex items-start gap-2.5 cursor-pointer group">
                                        <input type="checkbox" name="permissions[]" value="edit_users" class="perm-checkbox mt-0.5 rounded border-gray-300 text-primary focus:ring-primary" checked>
                                        <div>
                                            <span class="text-xs font-mono font-bold text-gray-800 group-hover:text-primary transition-colors block">edit_users</span>
                                            <span class="text-[11px] text-gray-500">Modify member details & roles</span>
                                        </div>
                                    </label>
                                    <label class="flex items-start gap-2.5 cursor-pointer group">
                                        <input type="checkbox" name="permissions[]" value="delete_users" class="perm-checkbox mt-0.5 rounded border-gray-300 text-rose-600 focus:ring-rose-500">
                                        <div>
                                            <span class="text-xs font-mono font-bold text-gray-800 group-hover:text-rose-600 transition-colors block">delete_users</span>
                                            <span class="text-[11px] text-gray-500">Terminate user accounts</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Module 2: System Settings -->
                            <div class="border border-gray-200 rounded-xl overflow-hidden">
                                <div class="bg-gray-50 px-4 py-2.5 border-b border-gray-200 font-bold text-gray-800 text-xs uppercase tracking-wider flex items-center gap-2">
                                    <span class="iconify text-base text-gray-500" data-icon="heroicons:cog-6-tooth"></span>
                                    System Settings
                                </div>
                                <div class="p-4 space-y-3">
                                    <label class="flex items-start gap-2.5 cursor-pointer group">
                                        <input type="checkbox" name="permissions[]" value="view_settings" class="perm-checkbox mt-0.5 rounded border-gray-300 text-primary focus:ring-primary" checked>
                                        <div>
                                            <span class="text-xs font-mono font-bold text-gray-800 group-hover:text-primary transition-colors block">view_settings</span>
                                            <span class="text-[11px] text-gray-500">Read system configurations</span>
                                        </div>
                                    </label>
                                    <label class="flex items-start gap-2.5 cursor-pointer group">
                                        <input type="checkbox" name="permissions[]" value="edit_settings" class="perm-checkbox mt-0.5 rounded border-gray-300 text-primary focus:ring-primary">
                                        <div>
                                            <span class="text-xs font-mono font-bold text-gray-800 group-hover:text-primary transition-colors block">edit_settings</span>
                                            <span class="text-[11px] text-gray-500">Modify global application config</span>
                                        </div>
                                    </label>
                                    <label class="flex items-start gap-2.5 cursor-pointer group">
                                        <input type="checkbox" name="permissions[]" value="view_logs" class="perm-checkbox mt-0.5 rounded border-gray-300 text-primary focus:ring-primary" checked>
                                        <div>
                                            <span class="text-xs font-mono font-bold text-gray-800 group-hover:text-primary transition-colors block">view_logs</span>
                                            <span class="text-[11px] text-gray-500">Access activity & audit stream</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN: STATUS & METADATA (4 COLS) -->
                <div class="lg:col-span-4 space-y-6">

                    <!-- CARD 1: GROUP STATUS TOGGLE -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 space-y-4">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Group Status</h3>

                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-xs font-bold text-gray-900 block" x-text="isActived ? 'Active Group' : 'Inactive Group'"></span>
                                <span class="text-[11px] text-gray-500" x-text="isActived ? 'Can be assigned to users' : 'Hidden from assignment list'"></span>
                            </div>
                            <button type="button" 
                                    @click="isActived = !isActived" 
                                    :class="isActived ? 'bg-primary' : 'bg-gray-200'"
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                <span :class="isActived ? 'translate-x-5' : 'translate-x-0'"
                                      class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                            <input type="hidden" name="status" :value="isActived ? 'active' : 'inactive'">
                        </div>
                    </div>

                    <!-- CARD 2: ADDITIONAL INFORMATION -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 space-y-3">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Group Metadata</h3>

                        <div class="space-y-2.5 text-xs">
                            <div class="flex justify-between items-center text-gray-600">
                                <span>Total Members</span>
                                <span class="font-bold text-gray-900 bg-gray-100 px-2 py-0.5 rounded border border-gray-200">
                                    {{ $group['users_count'] ?? 0 }} Users
                                </span>
                            </div>
                            <div class="flex justify-between items-center text-gray-600">
                                <span>Created At</span>
                                <span class="font-medium text-gray-800">
                                    {{ \Carbon\Carbon::parse($group['created_at'] ?? now())->format('d M Y H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- STICKY BOTTOM FORM ACTIONS BAR -->
            <div class="mt-8 bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs text-gray-500 flex items-center gap-1.5">
                    <span class="iconify text-base text-gray-400" data-icon="heroicons:information-circle"></span>
                    <span>Editing Group ID <span class="font-mono font-bold text-gray-800">#{{ $group['id'] ?? 1 }}</span></span>
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <a href="{{ route('users.groups.index') }}" 
                       class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors text-center w-full sm:w-auto">
                        Cancel
                    </a>

                    <button type="submit" 
                            class="inline-flex items-center justify-center gap-2 px-5 py-2 bg-primary text-white rounded-lg text-sm font-semibold hover:bg-blue-600 transition-colors shadow-sm focus:ring-2 focus:ring-offset-2 focus:ring-primary w-full sm:w-auto">
                        <span class="iconify text-base" data-icon="heroicons:check"></span>
                        Save Changes
                    </button>
                </div>
            </div>

        </form>

        <!-- ========================================================================= -->
        <!-- MODAL: DELETE GROUP CONFIRMATION (ALPINE.JS)                               -->
        <!-- ========================================================================= -->
        <div x-show="showDeleteModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
            
            <!-- Backdrop -->
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
                <!-- Modal Panel -->
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
                                <h3 class="text-base font-bold leading-6 text-gray-900" id="modal-title">Delete User Group</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete the group <span class="font-semibold text-gray-900">{{ $group['name'] ?? '' }}</span> (ID #{{ $group['id'] ?? 1 }})? Members in this group may lose group-specific permissions.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-3.5 sm:flex sm:flex-row-reverse sm:px-6 gap-2 border-t border-gray-100">
                        <form action="{{ route('users.groups.destroy', $group['id'] ?? 1) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex w-full justify-center rounded-lg bg-rose-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 sm:w-auto transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                                Confirm Delete
                            </button>
                        </form>
                        <button type="button" 
                                @click="showDeleteModal = false" 
                                class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                            Cancel
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</x-admin::layouts.master>

