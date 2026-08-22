<aside class="w-64 bg-white border-r border-gray-200 flex flex-col transition-transform duration-300">
    <!-- Logo -->
    <div class="h-16 flex items-center justify-center border-b border-gray-200">
        <span class="text-2xl font-bold text-primary flex items-center gap-2">
            <span class="iconify" data-icon="heroicons:bolt-solid"></span>
            Practizer
        </span>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-4">
        
        <!-- STANDALONE MENU -->
        <div class="space-y-1 mb-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 bg-blue-50 text-primary rounded-lg transition-colors">
                <span class="iconify text-xl" data-icon="heroicons:home"></span>
                <span class="font-medium">Dashboard</span>
            </a>
        </div>

        <!-- USERS GROUP (Terbuka secara default) -->
        <div>
            <button onclick="toggleNavGroup('users-menu', this)" class="w-full flex items-center justify-between px-3 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider hover:text-gray-700 transition-colors focus:outline-none">
                <span>Users Management</span>
                <!-- Ikon Chevron -->
                <span class="iconify transform transition-transform duration-300 rotate-180" data-icon="heroicons:chevron-down"></span>
            </button>
            
            <!-- Wrapper Animasi Smooth (Default: Terbuka / 1fr) -->
            <div id="users-menu" class="grid transition-all duration-300 ease-in-out grid-rows-[1fr] opacity-100">
                <div class="overflow-hidden">
                    <div class="space-y-1 mt-1">
                        <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-lg transition-colors">
                            <span class="iconify text-xl" data-icon="heroicons:users"></span>
                            <span class="font-medium text-sm">All Users</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-lg transition-colors">
                            <span class="iconify text-xl" data-icon="heroicons:user-group"></span>
                            <span class="font-medium text-sm">User Groups</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-lg transition-colors">
                            <span class="iconify text-xl" data-icon="heroicons:shield-check"></span>
                            <span class="font-medium text-sm">Roles & Permissions</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-lg transition-colors">
                            <span class="iconify text-xl" data-icon="heroicons:clipboard-document-list"></span>
                            <span class="font-medium text-sm">Activity Logs</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- SETTINGS GROUP (Tertutup secara default) -->
        <div>
            <button onclick="toggleNavGroup('settings-menu', this)" class="w-full flex items-center justify-between px-3 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider hover:text-gray-700 transition-colors focus:outline-none">
                <span>Settings</span>
                <!-- Ikon Chevron -->
                <span class="iconify transform transition-transform duration-300" data-icon="heroicons:chevron-down"></span>
            </button>
            
            <!-- Wrapper Animasi Smooth (Default: Tertutup / 0fr) -->
            <div id="settings-menu" class="grid transition-all duration-300 ease-in-out grid-rows-[0fr] opacity-0">
                <div class="overflow-hidden">
                    <div class="space-y-1 mt-1">
                        <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-lg transition-colors">
                            <span class="iconify text-xl" data-icon="heroicons:adjustments-horizontal"></span>
                            <span class="font-medium text-sm">General</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-lg transition-colors">
                            <span class="iconify text-xl" data-icon="heroicons:lock-closed"></span>
                            <span class="font-medium text-sm">Security</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </nav>

    <!-- LOGOUT -->
    <div class="p-4 border-t border-gray-200">
        <button class="flex items-center gap-3 px-3 py-2 w-full text-left text-red-600 hover:bg-red-50 rounded-lg transition-colors">
            <span class="iconify text-xl" data-icon="heroicons:arrow-right-on-rectangle"></span>
            <span class="font-medium">Logout</span>
        </button>
    </div>
</aside>
