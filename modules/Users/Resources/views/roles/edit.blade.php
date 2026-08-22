<x-admin::layouts.master>
    <div class="max-w-6xl mx-auto space-y-6">
        
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
                    <span class="text-gray-800 font-semibold">Edit Role</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">Edit Role: Manager</h1>
                <p class="text-sm text-gray-500 mt-0.5">Configure role name and assign granular permissions.</p>
            </div>
            
            <a href="{{ route('users.roles.index') }}" class="inline-flex items-center gap-2 bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-all shadow-sm font-medium text-sm focus:outline-none">
                <span class="iconify text-lg" data-icon="heroicons:arrow-left"></span>
                <span>Back to List</span>
            </a>
        </div>

        <form action="{{ route('users.roles.update', 2) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- 1. ROLE DETAILS CARD -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/50 flex items-center gap-2">
                    <span class="iconify text-xl text-primary" data-icon="heroicons:identification"></span>
                    <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Role Details</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Role Name <span class="text-rose-500">*</span></label>
                            <input type="text" id="name" name="name" value="Manager" 
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm">
                        </div>
                        <div>
                            <label for="guard_name" class="block text-sm font-semibold text-gray-700 mb-1">Guard Name</label>
                            <input type="text" id="guard_name" name="guard_name" value="web" readonly
                                   class="w-full px-4 py-2.5 bg-gray-100 border border-gray-200 text-gray-500 rounded-lg cursor-not-allowed text-sm">
                            <p class="text-[11px] text-gray-400 mt-1">Guard defines the authentication area (usually 'web' or 'api').</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. PERMISSION MATRIX CARD -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" x-data="{ selectAll: false }">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/50 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="iconify text-xl text-emerald-600" data-icon="heroicons:shield-check"></span>
                        <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Permission Matrix</h2>
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" x-model="selectAll" @change="$event.target.checked ? $el.closest('div.bg-white').querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = true) : $el.closest('div.bg-white').querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = false)" class="rounded border-gray-300 text-primary focus:ring-primary w-4 h-4">
                        <span class="text-xs font-semibold text-gray-600">Select All Permissions</span>
                    </label>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        
                        <!-- MODULE: USERS -->
                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <div class="bg-gray-50 px-4 py-2.5 border-b border-gray-200 font-bold text-gray-800 text-sm flex items-center gap-2">
                                <span class="iconify text-gray-500" data-icon="heroicons:users"></span>
                                Users Module
                            </div>
                            <div class="p-4 flex flex-col gap-3">
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="checkbox" name="permissions[]" value="view_users" class="perm-checkbox mt-0.5 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4" checked>
                                    <div>
                                        <span class="block text-sm font-semibold text-gray-700 group-hover:text-primary transition-colors">view_users</span>
                                        <span class="block text-xs text-gray-500">View user list and details</span>
                                    </div>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="checkbox" name="permissions[]" value="create_users" class="perm-checkbox mt-0.5 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4">
                                    <div>
                                        <span class="block text-sm font-semibold text-gray-700 group-hover:text-primary transition-colors">create_users</span>
                                        <span class="block text-xs text-gray-500">Create new user accounts</span>
                                    </div>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="checkbox" name="permissions[]" value="edit_users" class="perm-checkbox mt-0.5 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4" checked>
                                    <div>
                                        <span class="block text-sm font-semibold text-gray-700 group-hover:text-primary transition-colors">edit_users</span>
                                        <span class="block text-xs text-gray-500">Modify existing users</span>
                                    </div>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="checkbox" name="permissions[]" value="delete_users" class="perm-checkbox mt-0.5 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4">
                                    <div>
                                        <span class="block text-sm font-semibold text-gray-700 group-hover:text-primary transition-colors">delete_users</span>
                                        <span class="block text-xs text-gray-500">Delete user accounts</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- MODULE: SETTINGS -->
                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <div class="bg-gray-50 px-4 py-2.5 border-b border-gray-200 font-bold text-gray-800 text-sm flex items-center gap-2">
                                <span class="iconify text-gray-500" data-icon="heroicons:cog-6-tooth"></span>
                                Settings Module
                            </div>
                            <div class="p-4 flex flex-col gap-3">
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="checkbox" name="permissions[]" value="view_settings" class="perm-checkbox mt-0.5 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4" checked>
                                    <div>
                                        <span class="block text-sm font-semibold text-gray-700 group-hover:text-primary transition-colors">view_settings</span>
                                        <span class="block text-xs text-gray-500">Access system settings</span>
                                    </div>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="checkbox" name="permissions[]" value="edit_settings" class="perm-checkbox mt-0.5 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4">
                                    <div>
                                        <span class="block text-sm font-semibold text-gray-700 group-hover:text-primary transition-colors">edit_settings</span>
                                        <span class="block text-xs text-gray-500">Change system configuration</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- MODULE: ROLES (Restricted) -->
                        <div class="border border-gray-200 rounded-xl overflow-hidden bg-gray-50/30">
                            <div class="bg-gray-50 px-4 py-2.5 border-b border-gray-200 font-bold text-gray-800 text-sm flex items-center gap-2">
                                <span class="iconify text-gray-500" data-icon="heroicons:shield-exclamation"></span>
                                Roles Module
                            </div>
                            <div class="p-4 flex flex-col gap-3">
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="checkbox" name="permissions[]" value="manage_roles" class="perm-checkbox mt-0.5 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4">
                                    <div>
                                        <span class="block text-sm font-semibold text-gray-700 group-hover:text-primary transition-colors">manage_roles</span>
                                        <span class="block text-xs text-gray-500">Create, edit, and assign roles</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- FORM ACTIONS -->
            <div class="flex items-center justify-end gap-3 pt-2 pb-10">
                <a href="{{ route('users.roles.index') }}" class="px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors shadow-sm focus:outline-none">
                    Cancel Changes
                </a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-primary text-white rounded-lg text-sm font-semibold hover:bg-blue-600 transition-all shadow-sm focus:ring-2 focus:ring-offset-1 focus:ring-primary">
                    <span class="iconify text-lg" data-icon="heroicons:check-circle"></span>
                    Save Role & Permissions
                </button>
            </div>

        </form>
    </div>
</x-admin::layouts.master>
