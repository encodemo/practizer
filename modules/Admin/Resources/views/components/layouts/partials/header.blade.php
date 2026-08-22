<header x-data="{
            userMenuOpen: false,
            notifOpen: false,
            showLogoutModal: false,
            isDarkMode: false,
            notifTab: 'all',
            unreadCount: 3,
            notifications: [
                {
                    id: 1,
                    title: 'Security Alert: Failed Root Login',
                    message: 'Multiple failed authentication attempts detected from IP 192.168.1.105.',
                    time: '2 mins ago',
                    type: 'security',
                    unread: true,
                    icon: 'heroicons:shield-exclamation',
                    color: 'text-rose-600 bg-rose-50 border-rose-200'
                },
                {
                    id: 2,
                    title: 'Database Snapshot Completed',
                    message: 'Automated daily backup created successfully (42.5 MB compressed).',
                    time: '15 mins ago',
                    type: 'system',
                    unread: true,
                    icon: 'heroicons:circle-stack',
                    color: 'text-emerald-600 bg-emerald-50 border-emerald-200'
                },
                {
                    id: 3,
                    title: 'New User Account Provisioned',
                    message: 'Sarah Jenkins registered under Engineering group by Administrator.',
                    time: '1 hour ago',
                    type: 'user',
                    unread: true,
                    icon: 'heroicons:user-plus',
                    color: 'text-blue-600 bg-blue-50 border-blue-200'
                },
                {
                    id: 4,
                    title: 'Server Load Normalized',
                    message: 'CPU consumption returned to optimal baseline 14.2%.',
                    time: '2 hours ago',
                    type: 'system',
                    unread: false,
                    icon: 'heroicons:bolt',
                    color: 'text-indigo-600 bg-indigo-50 border-indigo-200'
                },
                {
                    id: 5,
                    title: 'System Optimization Routine',
                    message: 'Route cache and Blade views compiled successfully.',
                    time: '5 hours ago',
                    type: 'system',
                    unread: false,
                    icon: 'heroicons:sparkles',
                    color: 'text-amber-600 bg-amber-50 border-amber-200'
                }
            ],
            markAllAsRead() {
                this.notifications.forEach(n => n.unread = false);
                this.unreadCount = 0;
            },
            filteredNotifs() {
                if (this.notifTab === 'unread') return this.notifications.filter(n => n.unread);
                if (this.notifTab === 'security') return this.notifications.filter(n => n.type === 'security');
                return this.notifications;
            }
        }" 
        class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-20 relative">
    
    <!-- Left Side Header (Mobile Toggle & Search / Breadcrumb Quick info) -->
    <div class="flex items-center gap-4">
        <!-- Mobile Sidebar Toggle -->
        <button onclick="if(window.toggleMobileSidebar) window.toggleMobileSidebar()" class="text-gray-500 hover:text-gray-700 focus:outline-none lg:hidden p-1.5 rounded-lg hover:bg-gray-100 transition-colors" title="Toggle Navigation">
            <span class="iconify text-2xl" data-icon="heroicons:bars-3"></span>
        </button>

        <!-- System Environment Badge -->
        <div class="hidden sm:flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>System Production Ready</span>
            </span>
            <span class="text-xs text-gray-400 font-mono hidden md:inline">Laravel v12.12 • PHP 8.2</span>
        </div>
    </div>

    <!-- Right Side Header (Notification Hub & User Profile Dropdown) -->
    <div class="flex items-center gap-3">
        
        <!-- 1. NOTIFICATION HUB POPOVER (BELL ICON) -->
        <div class="relative">
            <!-- Bell Trigger Button -->
            <button type="button" 
                    @click="notifOpen = !notifOpen; userMenuOpen = false" 
                    class="relative p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-all focus:outline-none" 
                    title="Notifications Hub">
                <span class="iconify text-2xl" data-icon="heroicons:bell"></span>
                
                <!-- Unread Badge with Pulse Ring -->
                <template x-if="unreadCount > 0">
                    <span class="absolute top-1 right-1 flex h-4 w-4">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-4 w-4 bg-rose-600 text-[10px] font-bold text-white items-center justify-center" x-text="unreadCount"></span>
                    </span>
                </template>
            </button>

            <!-- Notifications Flyout Panel (Alpine.js) -->
            <div x-show="notifOpen" 
                 @click.outside="notifOpen = false" 
                 x-cloak 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                 class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden z-50">
                
                <!-- Notif Header -->
                <div class="p-4 bg-gray-50/80 border-b border-gray-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-sm text-gray-900">Notifications Center</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-primary/10 text-primary border border-primary/20" x-text="unreadCount + ' new'"></span>
                    </div>
                    <button type="button" 
                            @click="markAllAsRead()" 
                            class="text-xs text-primary hover:text-blue-700 font-semibold hover:underline focus:outline-none">
                        Mark all as read
                    </button>
                </div>

                <!-- Tabs Filter -->
                <div class="flex border-b border-gray-100 bg-white px-3 pt-2 text-xs">
                    <button type="button" 
                            @click="notifTab = 'all'" 
                            :class="notifTab === 'all' ? 'border-primary text-primary font-bold' : 'border-transparent text-gray-500 hover:text-gray-800 font-medium'" 
                            class="py-2 px-3 border-b-2 transition-colors">
                        All (<span x-text="notifications.length"></span>)
                    </button>
                    <button type="button" 
                            @click="notifTab = 'unread'" 
                            :class="notifTab === 'unread' ? 'border-primary text-primary font-bold' : 'border-transparent text-gray-500 hover:text-gray-800 font-medium'" 
                            class="py-2 px-3 border-b-2 transition-colors">
                        Unread (<span x-text="unreadCount"></span>)
                    </button>
                    <button type="button" 
                            @click="notifTab = 'security'" 
                            :class="notifTab === 'security' ? 'border-rose-600 text-rose-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-800 font-medium'" 
                            class="py-2 px-3 border-b-2 transition-colors">
                        Security Alerts
                    </button>
                </div>

                <!-- Notif Items List -->
                <div class="max-h-80 overflow-y-auto divide-y divide-gray-100">
                    <template x-for="item in filteredNotifs()" :key="item.id">
                        <div class="p-3.5 hover:bg-gray-50 transition-colors flex items-start gap-3 cursor-pointer"
                             :class="item.unread ? 'bg-blue-50/30' : 'bg-white'"
                             @click="item.unread = false; if(unreadCount > 0) unreadCount--">
                            
                            <!-- Icon -->
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 border"
                                 :class="item.color">
                                <span class="iconify text-lg" :data-icon="item.icon"></span>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-1 mb-0.5">
                                    <h4 class="text-xs font-bold text-gray-900 truncate" x-text="item.title"></h4>
                                    <span class="text-[10px] text-gray-400 shrink-0 font-medium" x-text="item.time"></span>
                                </div>
                                <p class="text-xs text-gray-600 leading-snug line-clamp-2" x-text="item.message"></p>
                            </div>

                            <!-- Unread Indicator Dot -->
                            <template x-if="item.unread">
                                <span class="w-2 h-2 rounded-full bg-primary mt-1.5 shrink-0"></span>
                            </template>
                        </div>
                    </template>

                    <template x-if="filteredNotifs().length === 0">
                        <div class="p-6 text-center text-gray-400 text-xs">
                            <span class="iconify text-3xl mx-auto mb-2 text-gray-300" data-icon="heroicons:bell-slash"></span>
                            <span>No notifications found in this category.</span>
                        </div>
                    </template>
                </div>

                <!-- Notif Footer -->
                <div class="p-3 bg-gray-50 border-t border-gray-200 text-center">
                    <a href="{{ route('users.logs.index') }}" 
                       class="text-xs font-semibold text-primary hover:text-blue-700 transition-colors flex items-center justify-center gap-1.5">
                        <span>View System Audit Stream</span>
                        <span class="iconify text-sm" data-icon="heroicons:arrow-right"></span>
                    </a>
                </div>

            </div>
        </div>

        <!-- DIVIDER -->
        <div class="h-6 w-px bg-gray-200"></div>

        <!-- 2. USER PROFILE DROPDOWN MENU -->
        <div class="relative">
            
            <!-- User Trigger Button -->
            <button type="button" 
                    @click="userMenuOpen = !userMenuOpen; notifOpen = false" 
                    class="flex items-center gap-3 p-1.5 pl-2 pr-3 rounded-xl hover:bg-gray-100 transition-all focus:outline-none group border border-transparent hover:border-gray-200">
                <div class="relative">
                    <img src="https://ui-avatars.com/api/?name=Administrator&background=0284c7&color=fff&bold=true" 
                         alt="Avatar" 
                         class="w-8 h-8 rounded-full border border-gray-200 object-cover shadow-sm">
                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 rounded-full bg-emerald-500 border-2 border-white" title="Online"></span>
                </div>
                
                <div class="text-left hidden md:block leading-tight">
                    <span class="text-xs font-bold text-gray-800 block group-hover:text-primary transition-colors">Administrator</span>
                    <span class="text-[10px] text-gray-400 font-medium">Super Admin</span>
                </div>

                <span class="iconify text-gray-400 text-base transform transition-transform duration-200" 
                      :class="userMenuOpen ? 'rotate-180 text-primary' : ''" 
                      data-icon="heroicons:chevron-down"></span>
            </button>

            <!-- User Menu Popover Panel (Alpine.js) -->
            <div x-show="userMenuOpen" 
                 @click.outside="userMenuOpen = false" 
                 x-cloak 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                 class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden z-50">
                
                <!-- User Profile Header Summary -->
                <div class="p-4 bg-gradient-to-br from-blue-50 to-indigo-50/50 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Administrator&background=0284c7&color=fff&bold=true" 
                             alt="Avatar" 
                             class="w-10 h-10 rounded-full border-2 border-white shadow-sm object-cover">
                        <div class="min-w-0 flex-1">
                            <h4 class="text-sm font-bold text-gray-900 truncate">Administrator</h4>
                            <p class="text-xs text-gray-500 truncate">admin@practizer.id</p>
                            <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded text-[10px] font-bold bg-purple-100 text-purple-800 border border-purple-200">
                                <span class="iconify" data-icon="heroicons:shield-check"></span>
                                Super Administrator
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="p-2 space-y-1 text-xs">
                    
                    <!-- My Profile Link -->
                    <a href="{{ route('users.show', 1) }}" 
                       class="flex items-center gap-2.5 px-3 py-2 text-gray-700 hover:text-primary hover:bg-blue-50/60 rounded-xl transition-colors font-medium">
                        <span class="iconify text-base text-gray-400 group-hover:text-primary" data-icon="heroicons:user-circle"></span>
                        <span>My Profile</span>
                    </a>

                    <!-- Account General Settings -->
                    <a href="{{ route('settings.general') }}" 
                       class="flex items-center gap-2.5 px-3 py-2 text-gray-700 hover:text-primary hover:bg-blue-50/60 rounded-xl transition-colors font-medium">
                        <span class="iconify text-base text-gray-400" data-icon="heroicons:adjustments-horizontal"></span>
                        <span>Application Settings</span>
                    </a>

                    <!-- Security & 2FA -->
                    <a href="{{ route('settings.security') }}" 
                       class="flex items-center gap-2.5 px-3 py-2 text-gray-700 hover:text-primary hover:bg-blue-50/60 rounded-xl transition-colors font-medium">
                        <span class="iconify text-base text-gray-400" data-icon="heroicons:lock-closed"></span>
                        <span>Security & Access Control</span>
                    </a>

                    <!-- Audit Trail -->
                    <a href="{{ route('users.logs.index') }}" 
                       class="flex items-center gap-2.5 px-3 py-2 text-gray-700 hover:text-primary hover:bg-blue-50/60 rounded-xl transition-colors font-medium">
                        <span class="iconify text-base text-gray-400" data-icon="heroicons:clipboard-document-list"></span>
                        <span>Audit Stream</span>
                    </a>

                </div>

                <!-- Theme / Mode Simulator -->
                <div class="px-4 py-2.5 bg-gray-50 border-t border-b border-gray-100 flex items-center justify-between text-xs">
                    <span class="text-gray-600 font-medium flex items-center gap-1.5">
                        <span class="iconify text-base text-amber-500" data-icon="heroicons:sun"></span>
                        <span>Theme Mode</span>
                    </span>
                    <button type="button" 
                            @click="isDarkMode = !isDarkMode" 
                            class="px-2.5 py-1 bg-white border border-gray-200 text-gray-700 rounded-lg text-[11px] font-semibold hover:bg-gray-100 shadow-sm transition-all focus:outline-none">
                        <span x-text="isDarkMode ? '🌙 Dark' : '☀️ Light'"></span>
                    </button>
                </div>

                <!-- Logout Trigger Button (Opens Pop-up Modal) -->
                <div class="p-2">
                    <button type="button" 
                            @click="userMenuOpen = false; showLogoutModal = true" 
                            class="w-full flex items-center gap-2.5 px-3 py-2 text-rose-600 hover:bg-rose-50 rounded-xl transition-colors font-medium text-xs text-left focus:outline-none">
                        <span class="iconify text-base text-rose-500" data-icon="heroicons:arrow-right-on-rectangle"></span>
                        <span>Sign Out / Logout</span>
                    </button>
                </div>

            </div>
        </div>

    </div>

    <!-- ========================================================================= -->
    <!-- MODAL: LOGOUT CONFIRMATION (ALPINE.JS - ZERO WINDOW DOM CONFIRM)          -->
    <!-- ========================================================================= -->
    <div x-show="showLogoutModal" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        
        <!-- Backdrop Blur -->
        <div x-show="showLogoutModal" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
             @click="showLogoutModal = false"></div>

        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <!-- Modal Box Panel -->
            <div x-show="showLogoutModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-200">
                
                <div class="bg-white px-6 pb-6 pt-6 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-rose-100 sm:mx-0 sm:h-10 sm:w-10 text-rose-600">
                            <span class="iconify text-2xl" data-icon="heroicons:arrow-right-on-rectangle"></span>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-base font-bold leading-6 text-gray-900" id="modal-title">Sign Out from Practizer Admin</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to end your current administrative session? You will need to sign in again to access the control panel.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-3.5 sm:flex sm:flex-row-reverse sm:px-6 gap-2 border-t border-gray-100">
                    <a href="{{ route('admin.dashboard') }}" 
                       @click="showLogoutModal = false"
                       class="inline-flex w-full justify-center rounded-lg bg-rose-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 sm:w-auto transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 text-center">
                        Confirm Logout
                    </a>
                    <button type="button" 
                            @click="showLogoutModal = false" 
                            class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                        Cancel
                    </button>
                </div>

            </div>
        </div>
    </div>

</header>
