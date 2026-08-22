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
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-primary font-bold shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 font-medium' }}">
                <span class="iconify text-xl" data-icon="heroicons:home"></span>
                <span class="font-medium text-sm">Dashboard</span>
            </a>
        </div>

        @php
            $isUsersActive = request()->routeIs('users.*');
            $isSettingsActive = request()->routeIs('settings.*');
        @endphp

        <!-- USERS GROUP -->
        <div>
            <button onclick="toggleNavGroup('users-menu', this)" class="w-full flex items-center justify-between px-3 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider hover:text-gray-700 transition-colors focus:outline-none">
                <span class="{{ $isUsersActive ? 'text-primary' : '' }}">Users Management</span>
                <!-- Ikon Chevron -->
                <span class="iconify transform transition-transform duration-300 {{ $isUsersActive ? 'rotate-180 text-primary' : '' }}" data-icon="heroicons:chevron-down"></span>
            </button>
            
            <!-- Wrapper Animasi Smooth -->
            <div id="users-menu" class="grid transition-all duration-300 ease-in-out {{ $isUsersActive ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0' }}">
                <div class="overflow-hidden">
                    <div class="space-y-1 mt-1">
                        <!-- All Users -->
                        <a href="{{ route('users.index') }}" 
                           class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('users.index', 'users.create', 'users.edit', 'users.show') ? 'bg-blue-50 text-primary font-bold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 font-medium' }}">
                            <span class="iconify text-xl" data-icon="heroicons:users"></span>
                            <span class="font-medium text-sm">All Users</span>
                        </a>
                        
                        <!-- User Groups -->
                        <a href="{{ route('users.groups.index') }}" 
                           class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('users.groups.*') ? 'bg-blue-50 text-primary font-bold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 font-medium' }}">
                            <span class="iconify text-xl" data-icon="heroicons:user-group"></span>
                            <span class="font-medium text-sm">User Groups</span>
                        </a>
                        
                        <!-- Roles & Permissions -->
                        <a href="{{ route('users.roles.index') }}" 
                           class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('users.roles.*', 'users.permissions.*') ? 'bg-blue-50 text-primary font-bold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 font-medium' }}">
                            <span class="iconify text-xl" data-icon="heroicons:shield-check"></span>
                            <span class="font-medium text-sm">Roles & Permissions</span>
                        </a>
                        
                        <!-- Activity Logs -->
                        <a href="{{ route('users.logs.index') }}" 
                           class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('users.logs.*') ? 'bg-blue-50 text-primary font-bold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 font-medium' }}">
                            <span class="iconify text-xl" data-icon="heroicons:clipboard-document-list"></span>
                            <span class="font-medium text-sm">Activity Logs</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- SETTINGS GROUP -->
        <div>
            <button onclick="toggleNavGroup('settings-menu', this)" class="w-full flex items-center justify-between px-3 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider hover:text-gray-700 transition-colors focus:outline-none">
                <span class="{{ $isSettingsActive ? 'text-primary' : '' }}">Settings</span>
                <!-- Ikon Chevron -->
                <span class="iconify transform transition-transform duration-300 {{ $isSettingsActive ? 'rotate-180 text-primary' : '' }}" data-icon="heroicons:chevron-down"></span>
            </button>
            
            <!-- Wrapper Animasi Smooth -->
            <div id="settings-menu" class="grid transition-all duration-300 ease-in-out {{ $isSettingsActive ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0' }}">
                <div class="overflow-hidden">
                    <div class="space-y-1 mt-1">
                        <!-- 1. General Settings -->
                        <a href="{{ route('settings.general') }}" 
                           class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('settings.general', 'settings.index') ? 'bg-blue-50 text-primary font-bold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 font-medium' }}">
                            <span class="iconify text-xl" data-icon="heroicons:adjustments-horizontal"></span>
                            <span class="font-medium text-sm">General</span>
                        </a>

                        <!-- 2. Security & Access -->
                        <a href="{{ route('settings.security') }}" 
                           class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('settings.security') ? 'bg-blue-50 text-primary font-bold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 font-medium' }}">
                            <span class="iconify text-xl" data-icon="heroicons:lock-closed"></span>
                            <span class="font-medium text-sm">Security</span>
                        </a>

                        <!-- 3. Mail & SMTP -->
                        <a href="{{ route('settings.mail') }}" 
                           class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('settings.mail') ? 'bg-blue-50 text-primary font-bold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 font-medium' }}">
                            <span class="iconify text-xl" data-icon="heroicons:envelope"></span>
                            <span class="font-medium text-sm">Mail Server</span>
                        </a>

                        <!-- 4. Backup & Maintenance -->
                        <a href="{{ route('settings.backup') }}" 
                           class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('settings.backup') ? 'bg-blue-50 text-primary font-bold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 font-medium' }}">
                            <span class="iconify text-xl" data-icon="heroicons:circle-stack"></span>
                            <span class="font-medium text-sm">Backup & DB</span>
                        </a>

                        <!-- 5. System Logs & Diagnostics -->
                        <a href="{{ route('settings.logs') }}" 
                           class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('settings.logs') ? 'bg-blue-50 text-primary font-bold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 font-medium' }}">
                            <span class="iconify text-xl" data-icon="heroicons:server-stack"></span>
                            <span class="font-medium text-sm">System Logs</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </nav>

    <!-- LOGOUT -->
    <div class="p-4 border-t border-gray-200">
        <button class="flex items-center gap-3 px-3 py-2 w-full text-left text-red-600 hover:bg-red-50 rounded-lg transition-colors font-medium text-sm focus:outline-none">
            <span class="iconify text-xl" data-icon="heroicons:arrow-right-on-rectangle"></span>
            <span class="font-medium">Logout</span>
        </button>
    </div>
</aside>
