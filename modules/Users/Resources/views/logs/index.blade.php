<x-admin::layouts.master>
    <div x-data="{
            searchQuery: '',
            selectedTab: 'all', // 'all', 'auth', 'changes', 'security', 'system'
            moduleFilter: '',
            severityFilter: '',
            showFilterDropdown: false,
            
            // Auto-refresh simulation
            isRefreshing: false,
            refreshToast: false,
            triggerRefresh() {
                this.isRefreshing = true;
                setTimeout(() => {
                    this.isRefreshing = false;
                    this.refreshToast = true;
                    setTimeout(() => this.refreshToast = false, 3500);
                }, 800);
            },

            // Inspect / JSON Diff Modal State
            inspectModalOpen: false,
            activeLog: null,
            openInspect(log) {
                this.activeLog = log;
                this.inspectModalOpen = true;
            },

            // Export Modal State
            exportModalOpen: false,
            exportFormat: 'xlsx',
            exportScope: 'all',
            isExporting: false,
            exportSuccess: false,
            triggerExport() {
                this.isExporting = true;
                setTimeout(() => {
                    this.isExporting = false;
                    this.exportModalOpen = false;
                    this.exportSuccess = true;
                    setTimeout(() => this.exportSuccess = false, 4500);
                }, 1000);
            },

            // Purge Retention Modal State
            purgeModalOpen: false,
            purgeDays: '90',
            isPurging: false,
            purgeSuccess: false,
            triggerPurge() {
                this.isPurging = true;
                setTimeout(() => {
                    this.isPurging = false;
                    this.purgeModalOpen = false;
                    this.purgeSuccess = true;
                    setTimeout(() => this.purgeSuccess = false, 5000);
                }, 1200);
            },

            // Helper to check row visibility
            matchesFilter(log) {
                // Search query match
                const q = this.searchQuery.toLowerCase();
                const matchSearch = !q || 
                    log.log_code.toLowerCase().includes(q) ||
                    log.description.toLowerCase().includes(q) ||
                    log.action.toLowerCase().includes(q) ||
                    log.causer.name.toLowerCase().includes(q) ||
                    log.causer.email.toLowerCase().includes(q) ||
                    log.ip_address.toLowerCase().includes(q) ||
                    log.module.toLowerCase().includes(q);

                // Quick tab filter
                let matchTab = true;
                if (this.selectedTab === 'auth') matchTab = (log.module === 'Auth');
                else if (this.selectedTab === 'security') matchTab = (log.severity === 'warning' || log.severity === 'danger');
                else if (this.selectedTab === 'changes') matchTab = (log.changes !== null && (log.changes.old || log.changes.new));
                else if (this.selectedTab === 'system') matchTab = (log.module === 'System' || log.module === 'Settings');

                // Faceted dropdown filter
                const matchModule = !this.moduleFilter || log.module === this.moduleFilter;
                const matchSeverity = !this.severityFilter || log.severity === this.severityFilter;

                return matchSearch && matchTab && matchModule && matchSeverity;
            }
         }" 
         class="space-y-6">

        <!-- HEADER TITLE & ACTION BAR -->
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
                    <span class="text-gray-800 font-semibold">Activity Logs</span>
                </nav>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-bold text-gray-900">User Activity Logs</h1>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                        Audit Stream Active
                    </span>
                </div>
                <p class="text-sm text-gray-500 mt-0.5">Immutable audit trail, security events, user modifications, and forensics timeline.</p>
            </div>
            
            <!-- Actions: Refresh, Purge, Export -->
            <div class="flex items-center gap-2.5 shrink-0 flex-wrap">
                <!-- Refresh Button -->
                <button type="button" 
                        @click="triggerRefresh()" 
                        :disabled="isRefreshing"
                        class="inline-flex items-center gap-1.5 px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm focus:ring-2 focus:ring-primary focus:outline-none"
                        title="Reload Activity Stream">
                    <span class="iconify text-base text-gray-500" :class="isRefreshing ? 'animate-spin text-primary' : ''" data-icon="heroicons:arrow-path"></span>
                    <span class="hidden sm:inline">Refresh</span>
                </button>

                <!-- Purge Retention Button (Opens Danger Modal) -->
                <button type="button" 
                        @click="purgeModalOpen = true" 
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white border border-rose-200 rounded-lg text-sm font-medium text-rose-600 hover:bg-rose-50 hover:border-rose-300 transition-all shadow-sm focus:ring-2 focus:ring-rose-400 focus:outline-none">
                    <span class="iconify text-base" data-icon="heroicons:trash"></span>
                    <span>Purge Logs</span>
                </button>

                <!-- Export Logs Button (Opens Export Modal) -->
                <button type="button" 
                        @click="exportModalOpen = true" 
                        class="inline-flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-all shadow-sm font-medium text-sm focus:ring-2 focus:ring-offset-2 focus:ring-primary focus:outline-none">
                    <span class="iconify text-base" data-icon="heroicons:arrow-down-tray"></span>
                    <span>Export Audit Trail</span>
                </button>
            </div>
        </div>

        <!-- FLASH NOTIFICATION: SUCCESS FROM CONTROLLER -->
        @if(session('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-between text-emerald-800 text-sm shadow-sm">
            <div class="flex items-center gap-3">
                <span class="iconify text-xl text-emerald-600 shrink-0" data-icon="heroicons:check-circle"></span>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button type="button" @click="show = false" class="text-emerald-500 hover:text-emerald-700 hover:bg-emerald-100 p-1.5 rounded-lg transition-colors">
                <span class="iconify text-lg" data-icon="heroicons:x-mark"></span>
            </button>
        </div>
        @endif

        <!-- TOAST: REFRESH NOTIFICATION -->
        <div x-show="refreshToast" 
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="p-3.5 rounded-xl bg-slate-900 text-white flex items-center justify-between text-xs shadow-lg">
            <div class="flex items-center gap-2.5">
                <span class="iconify text-lg text-emerald-400 shrink-0" data-icon="heroicons:bolt"></span>
                <span>Audit feed refreshed: Real-time event buffer is up to date.</span>
            </div>
            <button type="button" @click="refreshToast = false" class="text-gray-400 hover:text-white p-1">
                <span class="iconify text-base" data-icon="heroicons:x-mark"></span>
            </button>
        </div>

        <!-- TOAST: EXPORT SIMULATION SUCCESS -->
        <div x-show="exportSuccess" 
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="p-4 rounded-xl bg-blue-50 border border-blue-200 flex items-center justify-between text-blue-800 text-sm shadow-sm">
            <div class="flex items-center gap-3">
                <span class="iconify text-xl text-primary shrink-0" data-icon="heroicons:arrow-down-tray"></span>
                <span>
                    File audit log <strong class="font-semibold" x-text="'audit_logs_' + new Date().toISOString().slice(0,10) + '.' + exportFormat"></strong> berhasil digenerate & diunduh (Simulasi Mockup).
                </span>
            </div>
            <button type="button" @click="exportSuccess = false" class="text-blue-500 hover:text-blue-700 p-1.5 rounded-lg">
                <span class="iconify text-lg" data-icon="heroicons:x-mark"></span>
            </button>
        </div>

        <!-- TOAST: PURGE SIMULATION SUCCESS -->
        <div x-show="purgeSuccess" 
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="p-4 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-between text-amber-800 text-sm shadow-sm">
            <div class="flex items-center gap-3">
                <span class="iconify text-xl text-amber-600 shrink-0" data-icon="heroicons:archive-box"></span>
                <span>
                    Retention Purge Selesai: Log aktivitas yang berumur lebih dari <strong class="font-semibold" x-text="purgeDays + ' hari'"></strong> berhasil diarsipkan dan dibersihkan dari live index.
                </span>
            </div>
            <button type="button" @click="purgeSuccess = false" class="text-amber-500 hover:text-amber-700 p-1.5 rounded-lg">
                <span class="iconify text-lg" data-icon="heroicons:x-mark"></span>
            </button>
        </div>

        <!-- ========================================================================= -->
        <!-- 1. FILAMENT-STYLE KPI METRICS GRID                                        -->
        <!-- ========================================================================= -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- Metric 1: Total Logs -->
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-1">Total Activities</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-bold text-gray-900">{{ $stats->total_logs }}</span>
                        <span class="text-xs font-semibold text-emerald-600 flex items-center">
                            <span class="iconify text-sm" data-icon="heroicons:arrow-trending-up"></span>
                            +12%
                        </span>
                    </div>
                    <span class="text-[11px] text-gray-400 mt-1 block">Indexed records in active buffer</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-primary flex items-center justify-center shrink-0">
                    <span class="iconify text-2xl" data-icon="heroicons:clipboard-document-list"></span>
                </div>
            </div>

            <!-- Metric 2: Security & Warnings -->
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-1">Security & Alerts</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-bold text-gray-900">{{ $stats->security_alerts }}</span>
                        <span class="text-xs font-semibold text-rose-600 bg-rose-50 px-1.5 py-0.5 rounded border border-rose-100">
                            Action Needed
                        </span>
                    </div>
                    <span class="text-[11px] text-gray-400 mt-1 block">Failed auth & policy updates</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                    <span class="iconify text-2xl" data-icon="heroicons:shield-exclamation"></span>
                </div>
            </div>

            <!-- Metric 3: Authentication Events -->
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-1">Auth & Sessions</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-bold text-gray-900">{{ $stats->auth_events }}</span>
                        <span class="text-xs font-medium text-gray-400">Events</span>
                    </div>
                    <span class="text-[11px] text-gray-400 mt-1 block">Logins, resets & impersonations</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                    <span class="iconify text-2xl" data-icon="heroicons:key"></span>
                </div>
            </div>

            <!-- Metric 4: Active Causers -->
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-1">Active Operators</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-bold text-gray-900">{{ $stats->active_causers }}</span>
                        <span class="text-xs font-semibold text-emerald-600 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Online
                        </span>
                    </div>
                    <span class="text-[11px] text-gray-400 mt-1 block">Unique actors logged today</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <span class="iconify text-2xl" data-icon="heroicons:user-group"></span>
                </div>
            </div>

        </div>

        <!-- ========================================================================= -->
        <!-- 2. MAIN LOGS CARD: TABS, TOOLBAR, TABLE & PAGINATION                       -->
        <!-- ========================================================================= -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            
            <!-- QUICK TABS BAR -->
            <div class="border-b border-gray-200 bg-gray-50/50 px-4 pt-2">
                <nav class="flex space-x-2 sm:space-x-4 overflow-x-auto" aria-label="Tabs">
                    <button type="button" 
                            @click="selectedTab = 'all'" 
                            :class="selectedTab === 'all' ? 'border-primary text-primary font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium'"
                            class="whitespace-nowrap py-3 px-2 border-b-2 text-xs sm:text-sm flex items-center gap-2 transition-colors focus:outline-none">
                        <span class="iconify text-base" data-icon="heroicons:list-bullet"></span>
                        <span>All Activities</span>
                        <span class="ml-1 px-1.5 py-0.5 rounded-full text-[10px] bg-gray-200 text-gray-700">{{ count($logs) }}</span>
                    </button>

                    <button type="button" 
                            @click="selectedTab = 'security'" 
                            :class="selectedTab === 'security' ? 'border-rose-600 text-rose-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium'"
                            class="whitespace-nowrap py-3 px-2 border-b-2 text-xs sm:text-sm flex items-center gap-2 transition-colors focus:outline-none">
                        <span class="iconify text-base text-rose-500" data-icon="heroicons:shield-exclamation"></span>
                        <span>Security Alerts</span>
                        <span class="ml-1 px-1.5 py-0.5 rounded-full text-[10px] bg-rose-100 text-rose-700 font-semibold">{{ $stats->security_alerts }}</span>
                    </button>

                    <button type="button" 
                            @click="selectedTab = 'auth'" 
                            :class="selectedTab === 'auth' ? 'border-purple-600 text-purple-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium'"
                            class="whitespace-nowrap py-3 px-2 border-b-2 text-xs sm:text-sm flex items-center gap-2 transition-colors focus:outline-none">
                        <span class="iconify text-base text-purple-500" data-icon="heroicons:key"></span>
                        <span>Auth & Sessions</span>
                        <span class="ml-1 px-1.5 py-0.5 rounded-full text-[10px] bg-purple-100 text-purple-700 font-semibold">{{ $stats->auth_events }}</span>
                    </button>

                    <button type="button" 
                            @click="selectedTab = 'changes'" 
                            :class="selectedTab === 'changes' ? 'border-emerald-600 text-emerald-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium'"
                            class="whitespace-nowrap py-3 px-2 border-b-2 text-xs sm:text-sm flex items-center gap-2 transition-colors focus:outline-none">
                        <span class="iconify text-base text-emerald-500" data-icon="heroicons:document-text"></span>
                        <span>Data Modifications</span>
                    </button>

                    <button type="button" 
                            @click="selectedTab = 'system'" 
                            :class="selectedTab === 'system' ? 'border-primary text-primary font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium'"
                            class="whitespace-nowrap py-3 px-2 border-b-2 text-xs sm:text-sm flex items-center gap-2 transition-colors focus:outline-none">
                        <span class="iconify text-base text-gray-500" data-icon="heroicons:cog-6-tooth"></span>
                        <span>System Maintenance</span>
                    </button>
                </nav>
            </div>

            <!-- TOOLBAR: SEARCH & FILTER CONTROLS -->
            <div class="p-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between gap-3 items-center bg-white">
                
                <!-- Search Input -->
                <div class="relative w-full sm:max-w-md">
                    <span class="iconify absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg" data-icon="heroicons:magnifying-glass"></span>
                    <input type="text" 
                           x-model="searchQuery"
                           placeholder="Search logs by causer, IP, description, action..." 
                           class="w-full pl-10 pr-4 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                </div>

                <!-- Filter Popover Trigger & Reset -->
                <div class="flex items-center gap-2 w-full sm:w-auto justify-end relative">
                    
                    <!-- Reset Button if filtered -->
                    <button type="button" 
                            x-show="searchQuery || moduleFilter || severityFilter || selectedTab !== 'all'"
                            x-cloak
                            @click="searchQuery = ''; moduleFilter = ''; severityFilter = ''; selectedTab = 'all'"
                            class="text-xs text-rose-600 hover:text-rose-700 font-semibold px-2 py-1 rounded hover:bg-rose-50 transition-colors">
                        Clear All Filters
                    </button>

                    <!-- Filter Dropdown Button -->
                    <div class="relative">
                        <button @click="showFilterDropdown = !showFilterDropdown" 
                                type="button"
                                class="flex items-center gap-2 px-3.5 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition-colors font-medium shadow-sm">
                            <span class="iconify text-gray-500 text-base" data-icon="heroicons:funnel"></span>
                            <span>Faceted Filter</span>
                            <span class="iconify text-xs text-gray-400 transform transition-transform" :class="showFilterDropdown ? 'rotate-180' : ''" data-icon="heroicons:chevron-down"></span>
                        </button>

                        <!-- Filter Popover Panel -->
                        <div x-show="showFilterDropdown" 
                             @click.outside="showFilterDropdown = false" 
                             x-cloak 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                             class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-xl border border-gray-200 p-4 z-30 space-y-4">
                            
                            <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                                <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider">Filter Audit Logs</h4>
                                <button type="button" @click="showFilterDropdown = false" class="text-gray-400 hover:text-gray-600">
                                    <span class="iconify text-base" data-icon="heroicons:x-mark"></span>
                                </button>
                            </div>
                            
                            <!-- Module Filter -->
                            <div>
                                <label class="text-xs font-semibold text-gray-700 block mb-1">Target Module</label>
                                <select x-model="moduleFilter" class="w-full text-xs bg-gray-50 border border-gray-300 rounded-lg p-2.5 focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                                    <option value="">All Modules (Semua)</option>
                                    @foreach($modules as $m)
                                    <option value="{{ $m }}">{{ $m }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Severity Filter -->
                            <div>
                                <label class="text-xs font-semibold text-gray-700 block mb-1">Severity Level</label>
                                <select x-model="severityFilter" class="w-full text-xs bg-gray-50 border border-gray-300 rounded-lg p-2.5 focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                                    <option value="">All Severities</option>
                                    <option value="info">Info (Standard events)</option>
                                    <option value="success">Success (Creation / Grants)</option>
                                    <option value="warning">Warning (Modifications / Resets)</option>
                                    <option value="danger">Danger (Deletions / Failed auth)</option>
                                </select>
                            </div>

                            <div class="pt-2 flex items-center justify-between border-t border-gray-100">
                                <button type="button" 
                                        @click="moduleFilter = ''; severityFilter = '';" 
                                        class="text-xs text-rose-600 hover:text-rose-700 font-semibold hover:underline">
                                    Reset
                                </button>
                                <button type="button" 
                                        @click="showFilterDropdown = false" 
                                        class="px-3 py-1.5 bg-primary text-white text-xs font-semibold rounded-lg hover:bg-blue-600 shadow-sm">
                                    Apply Filter
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- TABLE SECTION -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-700 uppercase font-semibold text-xs border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3.5 whitespace-nowrap">Log Reference</th>
                            <th class="px-6 py-3.5 whitespace-nowrap">Actor / Causer</th>
                            <th class="px-6 py-3.5 whitespace-nowrap">Event & Action</th>
                            <th class="px-6 py-3.5 whitespace-nowrap">Module & Target</th>
                            <th class="px-6 py-3.5 whitespace-nowrap">Client & IP</th>
                            <th class="px-6 py-3.5 whitespace-nowrap">Timestamp</th>
                            <th class="px-6 py-3.5 whitespace-nowrap text-right">Inspect</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach(collect($logs)->take(15) as $log)
                        @php
                            $logJson = json_encode($log);
                            
                            $methodBadges = [
                                'GET'    => 'bg-blue-50 text-blue-700 border-blue-200',
                                'POST'   => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'PUT'    => 'bg-amber-50 text-amber-700 border-amber-200',
                                'DELETE' => 'bg-rose-50 text-rose-700 border-rose-200'
                            ];
                            $methodBadge = $methodBadges[$log->request_method] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                        @endphp
                        <tr x-show="matchesFilter({{ $logJson }})" 
                            class="odd:bg-white even:bg-slate-50/40 hover:bg-blue-50/50 transition-colors group cursor-pointer"
                            @click="openInspect({{ $logJson }})">
                            
                            <!-- Col 1: Log Code -->
                            <td class="px-6 py-3.5 whitespace-nowrap">
                                <div class="font-mono text-xs font-bold text-gray-800 flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $log->severity_meta['dot'] }}"></span>
                                    <span>{{ $log->log_code }}</span>
                                </div>
                                <div class="text-[11px] text-gray-400 font-mono mt-0.5">ID #{{ $log->id }}</div>
                            </td>

                            <!-- Col 2: Actor / Causer -->
                            <td class="px-6 py-3.5 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $log->causer->avatar }}" 
                                         alt="{{ $log->causer->name }}" 
                                         class="w-8 h-8 rounded-full border border-gray-200 object-cover shrink-0">
                                    <div>
                                        <div class="font-bold text-gray-900 text-xs">{{ $log->causer->name }}</div>
                                        <div class="text-gray-400 text-[11px]">{{ $log->causer->role }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Col 3: Event & Action (Severity Badge) -->
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-2 mb-0.5">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-semibold border {{ $log->severity_meta['badge'] }}">
                                        <span class="iconify" data-icon="{{ $log->severity_meta['icon'] }}"></span>
                                        {{ $log->action }}
                                    </span>
                                    
                                    @if($log->changes)
                                    <span class="text-[10px] font-mono bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded border border-slate-200 font-medium" title="Contains payload changes">
                                        Δ Diff
                                    </span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500 line-clamp-1 max-w-xs">{{ $log->description }}</div>
                            </td>

                            <!-- Col 4: Module & Endpoint -->
                            <td class="px-6 py-3.5 whitespace-nowrap">
                                <div class="flex items-center gap-1.5">
                                    <span class="font-semibold text-xs text-gray-800">{{ $log->module }}</span>
                                    <span class="text-[10px] font-mono px-1.5 py-0.2 rounded border {{ $methodBadge }} font-bold">
                                        {{ $log->request_method }}
                                    </span>
                                </div>
                                <div class="text-[11px] text-gray-400 font-mono mt-0.5 truncate max-w-[140px]" title="{{ $log->endpoint }}">
                                    {{ $log->endpoint }}
                                </div>
                            </td>

                            <!-- Col 5: Client & IP -->
                            <td class="px-6 py-3.5 whitespace-nowrap">
                                <div class="flex items-center gap-1.5 text-xs text-gray-700 font-mono">
                                    <span class="iconify text-sm text-gray-400" data-icon="{{ $log->device_type === 'Mobile' ? 'heroicons:device-phone-mobile' : 'heroicons:computer-desktop' }}"></span>
                                    <span>{{ $log->ip_address }}</span>
                                </div>
                                <div class="text-[11px] text-gray-400 flex items-center gap-1 mt-0.5">
                                    <span class="iconify text-xs" data-icon="heroicons:map-pin"></span>
                                    <span>{{ $log->location }}</span>
                                </div>
                            </td>

                            <!-- Col 6: Timestamp -->
                            <td class="px-6 py-3.5 whitespace-nowrap">
                                <div class="text-xs font-semibold text-gray-800">{{ $log->time_ago }}</div>
                                <div class="text-[11px] text-gray-400 font-mono mt-0.5">{{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d H:i') }}</div>
                            </td>

                            <!-- Col 7: Actions -->
                            <td class="px-6 py-3.5 whitespace-nowrap text-right text-sm font-medium" @click.stop>
                                <button type="button" 
                                        @click="openInspect({{ $logJson }})" 
                                        class="p-2 text-gray-500 hover:text-primary hover:bg-blue-50 rounded-lg transition-colors inline-flex items-center focus:outline-none" 
                                        title="Inspect Payload & Diff">
                                    <span class="iconify text-lg" data-icon="heroicons:eye"></span>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION MOCKUP -->
            <div class="px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-gray-200 rounded-b-xl bg-gray-50/60">
                <div class="text-xs text-gray-500">
                    Showing <span class="font-semibold text-gray-900">1</span> to <span class="font-semibold text-gray-900">15</span> of <span class="font-semibold text-gray-900">{{ count($logs) }}</span> audit records
                </div>
                
                <div>
                    <nav class="isolate inline-flex -space-x-px rounded-lg shadow-sm" aria-label="Pagination">
                        <button type="button" class="relative inline-flex items-center rounded-l-lg px-2.5 py-2 text-gray-400 bg-white border border-gray-300 hover:bg-gray-50 focus:z-20">
                            <span class="sr-only">Previous</span>
                            <span class="iconify text-base" data-icon="heroicons:chevron-left"></span>
                        </button>
                        <button type="button" aria-current="page" class="relative z-10 inline-flex items-center bg-primary px-3.5 py-2 text-xs font-bold text-white border border-primary focus:z-20">1</button>
                        <button type="button" class="relative inline-flex items-center bg-white px-3.5 py-2 text-xs font-semibold text-gray-700 border border-gray-300 hover:bg-gray-50 focus:z-20">2</button>
                        <button type="button" class="relative inline-flex items-center rounded-r-lg px-2.5 py-2 text-gray-400 bg-white border border-gray-300 hover:bg-gray-50 focus:z-20">
                            <span class="sr-only">Next</span>
                            <span class="iconify text-base" data-icon="heroicons:chevron-right"></span>
                        </button>
                    </nav>
                </div>
            </div>
            
        </div>

        <!-- ========================================================================= -->
        <!-- MODAL 1: AUDIT RECORD & PAYLOAD DIFF INSPECTOR (ALPINE.JS)                -->
        <!-- ========================================================================= -->
        <div x-show="inspectModalOpen" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             role="dialog" 
             aria-modal="true">
            
            <!-- Backdrop -->
            <div x-show="inspectModalOpen" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" 
                 @click="inspectModalOpen = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <!-- Modal Panel -->
                <div x-show="inspectModalOpen" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-gray-200">
                    
                    <!-- Header with Log Meta -->
                    <template x-if="activeLog">
                        <div>
                            <div class="bg-slate-900 text-white px-6 py-4 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-primary">
                                        <span class="iconify text-2xl" data-icon="heroicons:magnifying-glass-circle"></span>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-base font-bold font-mono text-white" x-text="activeLog.log_code"></h3>
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase"
                                                  :class="activeLog.severity === 'danger' ? 'bg-rose-500 text-white' : (activeLog.severity === 'warning' ? 'bg-amber-500 text-white' : 'bg-blue-500 text-white')"
                                                  x-text="activeLog.severity"></span>
                                        </div>
                                        <p class="text-xs text-slate-400 mt-0.5" x-text="'Recorded at ' + activeLog.created_at + ' (' + activeLog.time_ago + ')'"></p>
                                    </div>
                                </div>
                                <button type="button" @click="inspectModalOpen = false" class="text-slate-400 hover:text-white p-1 rounded-lg focus:outline-none">
                                    <span class="iconify text-xl" data-icon="heroicons:x-mark"></span>
                                </button>
                            </div>

                            <!-- Body Section -->
                            <div class="p-6 space-y-5 max-h-[75vh] overflow-y-auto">
                                
                                <!-- Summary Meta Cards -->
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 bg-gray-50 p-3.5 rounded-xl border border-gray-200 text-xs">
                                    <div>
                                        <span class="text-gray-400 font-semibold block text-[10px] uppercase">Actor / Causer</span>
                                        <span class="font-bold text-gray-900 truncate block mt-0.5" x-text="activeLog.causer.name"></span>
                                        <span class="text-gray-500 text-[10px]" x-text="activeLog.causer.role"></span>
                                    </div>

                                    <div>
                                        <span class="text-gray-400 font-semibold block text-[10px] uppercase">Module / Method</span>
                                        <span class="font-bold text-gray-900 block mt-0.5" x-text="activeLog.module"></span>
                                        <span class="font-mono text-[10px] text-primary" x-text="activeLog.request_method + ' ' + activeLog.endpoint"></span>
                                    </div>

                                    <div>
                                        <span class="text-gray-400 font-semibold block text-[10px] uppercase">IP & Location</span>
                                        <span class="font-mono font-bold text-gray-900 block mt-0.5" x-text="activeLog.ip_address"></span>
                                        <span class="text-gray-500 text-[10px]" x-text="activeLog.location"></span>
                                    </div>

                                    <div>
                                        <span class="text-gray-400 font-semibold block text-[10px] uppercase">Client Device</span>
                                        <span class="font-semibold text-gray-900 truncate block mt-0.5" x-text="activeLog.device_type"></span>
                                        <span class="text-gray-500 text-[10px] truncate block" x-text="activeLog.user_agent"></span>
                                    </div>
                                </div>

                                <!-- Action & Description -->
                                <div>
                                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Action Summary</h4>
                                    <div class="p-3 bg-blue-50/50 border border-blue-100 rounded-xl">
                                        <div class="text-sm font-bold text-gray-900" x-text="activeLog.action"></div>
                                        <div class="text-xs text-gray-600 mt-1 leading-relaxed" x-text="activeLog.description"></div>
                                    </div>
                                </div>

                                <!-- Payload Diff / Changes Viewer -->
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider flex items-center gap-1.5">
                                            <span class="iconify text-base text-primary" data-icon="heroicons:code-bracket-square"></span>
                                            <span>Payload Diff & Attribute Changes</span>
                                        </h4>
                                        <span class="text-[11px] text-gray-400">JSON representation</span>
                                    </div>

                                    <!-- If has Before / After Diff -->
                                    <template x-if="activeLog.changes && (activeLog.changes.old !== undefined || activeLog.changes.new !== undefined)">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            <!-- Old State (Red) -->
                                            <div class="rounded-xl border border-rose-200 bg-rose-50/40 p-3.5">
                                                <div class="flex items-center gap-1.5 text-xs font-bold text-rose-700 mb-2 pb-1 border-b border-rose-200">
                                                    <span class="iconify" data-icon="heroicons:minus-circle"></span>
                                                    <span>Before (Old Values)</span>
                                                </div>
                                                <pre class="font-mono text-[11px] text-rose-900 overflow-x-auto whitespace-pre-wrap leading-relaxed" x-text="JSON.stringify(activeLog.changes.old, null, 2)"></pre>
                                            </div>

                                            <!-- New State (Green) -->
                                            <div class="rounded-xl border border-emerald-200 bg-emerald-50/40 p-3.5">
                                                <div class="flex items-center gap-1.5 text-xs font-bold text-emerald-700 mb-2 pb-1 border-b border-emerald-200">
                                                    <span class="iconify" data-icon="heroicons:plus-circle"></span>
                                                    <span>After (New Values)</span>
                                                </div>
                                                <pre class="font-mono text-[11px] text-emerald-900 overflow-x-auto whitespace-pre-wrap leading-relaxed" x-text="JSON.stringify(activeLog.changes.new, null, 2)"></pre>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- If has other metadata properties -->
                                    <template x-if="activeLog.changes && activeLog.changes.old === undefined && activeLog.changes.new === undefined">
                                        <div class="rounded-xl border border-gray-200 bg-gray-900 p-4 text-emerald-400 font-mono text-xs overflow-x-auto">
                                            <pre x-text="JSON.stringify(activeLog.changes, null, 2)"></pre>
                                        </div>
                                    </template>

                                    <!-- If no changes recorded -->
                                    <template x-if="!activeLog.changes">
                                        <div class="p-6 rounded-xl border border-dashed border-gray-200 bg-gray-50 text-center text-xs text-gray-400">
                                            <span class="iconify text-2xl mx-auto mb-1 text-gray-300" data-icon="heroicons:check-circle"></span>
                                            <span>Read/Auth Event: No state entity mutations or database diffs recorded.</span>
                                        </div>
                                    </template>
                                </div>

                                <!-- User Agent string raw -->
                                <div>
                                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">User Agent Header</label>
                                    <div class="p-2.5 bg-gray-100 rounded-lg text-[11px] font-mono text-gray-600 truncate" x-text="activeLog.user_agent"></div>
                                </div>

                            </div>

                            <!-- Footer -->
                            <div class="bg-gray-50 px-6 py-3.5 flex items-center justify-between border-t border-gray-100">
                                <span class="text-xs text-gray-400 font-mono">
                                    Status: <strong class="text-emerald-600">VERIFIED IMMUTABLE</strong>
                                </span>
                                <button type="button" 
                                        @click="inspectModalOpen = false" 
                                        class="px-4 py-2 bg-gray-900 text-white rounded-lg text-xs font-semibold hover:bg-gray-800 transition-colors shadow-sm">
                                    Close Inspector
                                </button>
                            </div>
                        </div>
                    </template>

                </div>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- MODAL 2: EXPORT AUDIT TRAIL DATA (ALPINE.JS)                              -->
        <!-- ========================================================================= -->
        <div x-show="exportModalOpen" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             role="dialog" 
             aria-modal="true">
            
            <div x-show="exportModalOpen" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
                 @click="exportModalOpen = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="exportModalOpen" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-200">
                    
                    <div class="bg-white px-6 pt-6 pb-4 border-b border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-primary flex items-center justify-center">
                                <span class="iconify text-2xl" data-icon="heroicons:arrow-down-tray"></span>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Export Audit Log Trail</h3>
                                <p class="text-xs text-gray-500">Download formatted forensic logs for compliance audit or archive.</p>
                            </div>
                        </div>
                        <button type="button" @click="exportModalOpen = false" class="text-gray-400 hover:text-gray-600">
                            <span class="iconify text-xl" data-icon="heroicons:x-mark"></span>
                        </button>
                    </div>

                    <div class="p-6 space-y-5">
                        <!-- Format Selection -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">1. Select Format</label>
                            <div class="grid grid-cols-4 gap-2.5">
                                <label class="p-3 rounded-xl border cursor-pointer text-center transition-all"
                                       :class="exportFormat === 'xlsx' ? 'border-primary bg-blue-50/50 ring-1 ring-primary' : 'border-gray-200 hover:border-gray-300 bg-white'">
                                    <input type="radio" name="format" value="xlsx" x-model="exportFormat" class="sr-only">
                                    <span class="iconify text-2xl mx-auto mb-1 text-emerald-600" data-icon="heroicons:table-cells"></span>
                                    <span class="text-xs font-bold text-gray-900 block">Excel</span>
                                    <span class="text-[9px] text-gray-400">.xlsx</span>
                                </label>

                                <label class="p-3 rounded-xl border cursor-pointer text-center transition-all"
                                       :class="exportFormat === 'csv' ? 'border-primary bg-blue-50/50 ring-1 ring-primary' : 'border-gray-200 hover:border-gray-300 bg-white'">
                                    <input type="radio" name="format" value="csv" x-model="exportFormat" class="sr-only">
                                    <span class="iconify text-2xl mx-auto mb-1 text-blue-600" data-icon="heroicons:document-text"></span>
                                    <span class="text-xs font-bold text-gray-900 block">CSV</span>
                                    <span class="text-[9px] text-gray-400">Comma</span>
                                </label>

                                <label class="p-3 rounded-xl border cursor-pointer text-center transition-all"
                                       :class="exportFormat === 'pdf' ? 'border-primary bg-blue-50/50 ring-1 ring-primary' : 'border-gray-200 hover:border-gray-300 bg-white'">
                                    <input type="radio" name="format" value="pdf" x-model="exportFormat" class="sr-only">
                                    <span class="iconify text-2xl mx-auto mb-1 text-rose-600" data-icon="heroicons:document-arrow-down"></span>
                                    <span class="text-xs font-bold text-gray-900 block">PDF</span>
                                    <span class="text-[9px] text-gray-400">Report</span>
                                </label>

                                <label class="p-3 rounded-xl border cursor-pointer text-center transition-all"
                                       :class="exportFormat === 'json' ? 'border-primary bg-blue-50/50 ring-1 ring-primary' : 'border-gray-200 hover:border-gray-300 bg-white'">
                                    <input type="radio" name="format" value="json" x-model="exportFormat" class="sr-only">
                                    <span class="iconify text-2xl mx-auto mb-1 text-amber-600" data-icon="heroicons:code-bracket"></span>
                                    <span class="text-xs font-bold text-gray-900 block">JSON</span>
                                    <span class="text-[9px] text-gray-400">Raw Diff</span>
                                </label>
                            </div>
                        </div>

                        <!-- Data Scope -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">2. Scope Range</label>
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 transition-colors">
                                    <input type="radio" name="scope" value="all" x-model="exportScope" class="text-primary focus:ring-primary">
                                    <div>
                                        <span class="text-xs font-bold text-gray-800 block">All Indexed Logs (Semua Log)</span>
                                        <span class="text-[11px] text-gray-500">Export seluruh {{ count($logs) }} log aktivitas yang ada di sistem.</span>
                                    </div>
                                </label>
                                <label class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 transition-colors">
                                    <input type="radio" name="scope" value="filtered" x-model="exportScope" class="text-primary focus:ring-primary">
                                    <div>
                                        <span class="text-xs font-bold text-gray-800 block">Filtered View Only</span>
                                        <span class="text-[11px] text-gray-500">Export hanya log yang sesuai dengan filter dan pencarian saat ini.</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex items-center justify-between gap-3 border-t border-gray-100">
                        <span class="text-xs text-gray-400">Format: <strong class="uppercase text-gray-700" x-text="exportFormat"></strong></span>
                        <div class="flex items-center gap-2">
                            <button type="button" @click="exportModalOpen = false" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50">Cancel</button>
                            <button type="button" @click="triggerExport()" :disabled="isExporting" class="inline-flex items-center gap-2 px-5 py-2 bg-primary text-white rounded-lg text-sm font-semibold hover:bg-blue-600 shadow-sm disabled:opacity-50">
                                <template x-if="isExporting">
                                    <span class="inline-flex items-center gap-2">
                                        <span class="iconify animate-spin text-base" data-icon="heroicons:arrow-path"></span>
                                        Generating...
                                    </span>
                                </template>
                                <template x-if="!isExporting">
                                    <span class="inline-flex items-center gap-1.5">
                                        <span class="iconify text-base" data-icon="heroicons:arrow-down-tray"></span>
                                        Download Log
                                    </span>
                                </template>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- MODAL 3: PURGE OLD LOGS RETENTION POLICY (ALPINE.JS DANGER ZONE)          -->
        <!-- ========================================================================= -->
        <div x-show="purgeModalOpen" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             role="dialog" 
             aria-modal="true">
            
            <div x-show="purgeModalOpen" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" 
                 @click="purgeModalOpen = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="purgeModalOpen" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-rose-200">
                    
                    <div class="bg-white p-6">
                        <div class="sm:flex sm:items-start gap-4">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-rose-100 sm:mx-0 sm:h-10 sm:w-10 text-rose-600">
                                <span class="iconify text-2xl" data-icon="heroicons:exclamation-triangle"></span>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:text-left flex-1">
                                <h3 class="text-base font-bold leading-6 text-gray-900">Purge & Archive Old Audit Logs</h3>
                                <div class="mt-2 text-xs text-gray-500 space-y-2">
                                    <p>
                                        Pembersihan log audit mematuhi kebijakan kepatuhan keamanan (*Security Retention Policy*). Log yang dibersihkan akan dihapus dari active buffer dan diarsipkan ke *cold storage*.
                                    </p>
                                </div>

                                <!-- Retention Age Selector -->
                                <div class="mt-4 bg-rose-50/50 border border-rose-100 rounded-xl p-3.5">
                                    <label class="text-xs font-bold text-rose-900 block mb-1">Pilih Batas Usia Log yang Dihapus:</label>
                                    <select x-model="purgeDays" class="w-full text-xs bg-white border border-rose-300 rounded-lg p-2.5 font-semibold text-gray-800 focus:outline-none focus:ring-1 focus:ring-rose-500">
                                        <option value="30">Lebih dari 30 Hari yang lalu</option>
                                        <option value="90">Lebih dari 90 Hari yang lalu (Rekomendasi)</option>
                                        <option value="180">Lebih dari 180 Hari yang lalu</option>
                                        <option value="365">Lebih dari 1 Tahun yang lalu</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-3.5 sm:flex sm:flex-row-reverse gap-2 border-t border-gray-100">
                        <button type="button" 
                                @click="triggerPurge()" 
                                :disabled="isPurging"
                                class="inline-flex w-full justify-center rounded-lg bg-rose-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 sm:w-auto transition-colors disabled:opacity-50">
                            <template x-if="isPurging">
                                <span class="inline-flex items-center gap-2">
                                    <span class="iconify animate-spin text-base" data-icon="heroicons:arrow-path"></span>
                                    Purging Logs...
                                </span>
                            </template>
                            <template x-if="!isPurging">
                                <span>Confirm Purge Policy</span>
                            </template>
                        </button>
                        <button type="button" 
                                @click="purgeModalOpen = false" 
                                class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            Cancel
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</x-admin::layouts.master>

