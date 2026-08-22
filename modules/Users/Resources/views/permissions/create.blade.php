<x-admin::layouts.master>
    <div class="max-w-3xl mx-auto space-y-6">
        
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
                    <span class="text-gray-800 font-semibold">Create Master Permission</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">Create New Permission</h1>
                <p class="text-sm text-gray-500 mt-0.5">Register a new master permission key in the system.</p>
            </div>
            
            <a href="{{ route('users.roles.index') }}" class="inline-flex items-center gap-2 bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-all shadow-sm font-medium text-sm focus:outline-none">
                <span class="iconify text-lg" data-icon="heroicons:arrow-left"></span>
                <span>Back</span>
            </a>
        </div>

        <form action="{{ route('users.permissions.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- PERMISSION DETAILS CARD -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/50 flex items-center gap-2">
                    <span class="iconify text-xl text-emerald-600" data-icon="heroicons:key"></span>
                    <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Permission Properties</h2>
                </div>
                
                <div class="p-6 space-y-5">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Permission Key -->
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Permission Key (Slug/Name) <span class="text-rose-500">*</span></label>
                            <input type="text" id="name" name="name" placeholder="e.g. export_reports" required
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary font-mono text-sm transition-all">
                            <p class="text-[11px] text-gray-500 mt-1">Use lowercase with underscores (e.g., <code class="bg-gray-100 px-1 rounded text-pink-600">publish_articles</code>).</p>
                        </div>

                        <!-- Module Group -->
                        <div>
                            <label for="module" class="block text-sm font-semibold text-gray-700 mb-1">Module Group</label>
                            <select id="module" name="module" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-sm transition-all">
                                <option value="Users">Users</option>
                                <option value="Settings">Settings</option>
                                <option value="Roles">Roles</option>
                                <option value="General" selected>General</option>
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
                            <textarea id="description" name="description" rows="3" placeholder="Briefly describe what this permission allows..."
                                      class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-sm transition-all resize-y"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FORM ACTIONS -->
            <div class="flex items-center justify-end gap-3 pt-2 pb-10">
                <a href="{{ route('users.roles.index') }}" class="px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors shadow-sm focus:outline-none">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 transition-all shadow-sm focus:ring-2 focus:ring-offset-1 focus:ring-emerald-600">
                    <span class="iconify text-lg" data-icon="heroicons:check-circle"></span>
                    Save Permission
                </button>
            </div>

        </form>
    </div>
</x-admin::layouts.master>

