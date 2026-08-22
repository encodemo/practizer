<x-admin::layouts.master>
    <div x-data="{
            searchQuery: '',
            levelFilter: '',
            showTraceModal: false,
            activeLog: null,
            showClearModal: false,
            copied: false,
            
            openTraceModal(log) {
                this.activeLog = log;
                this.copied = false;
                this.showTraceModal = true;
            },

            copyTrace() {
                if (this.activeLog && this.activeLog.trace) {
                    navigator.clipboard.writeText(this.activeLog.trace);
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2000);
                }
            },

            matchesLog(log) {
                const q = this.searchQuery.toLowerCase();
                const matchQuery = !q || 
                    log.message.toLowerCase().includes(q) || 
                    log.trace.toLowerCase().includes(q) ||
                    log.timestamp.toLowerCase().includes(q);
                
                const matchLevel = !this.levelFilter || log.level === this.levelFilter;
                return matchQuery && matchLevel;
            }
         }" 
         class="space-y-6 max-w-7xl mx-auto">
        
        <!-- HEADER TITLE & BREADCRUMBS -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2 text-xs font-medium text-gray-500 mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors flex items-center gap-1">
                        <span class="iconify text-sm" data-icon="heroicons:home"></span>
                        Dashboard
                    </a>
                    <span class="iconify text-xs text-gray-400" data-icon="heroicons:chevron-right"></span>
                    <span class="text-gray-500">Settings</span>
                    <span class="iconify text-xs text-gray-400" data-icon="heroicons:chevron-right"></span>
                    <span class="text-gray-800 font-semibold">System Logs & Health</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">System Logs & Diagnostics</h1>
                <p class="text-sm text-gray-500 mt-0.5">Real-time Laravel application exception logs, server environment metrics, and stack trace debugger.</p>
            </div>

            <!-- Top Actions -->
            <div class="flex items-center gap-2">
                <a href="{{ route('settings.logs.download') }}" 
                   class="inline-flex items-center gap-2 px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm focus:ring-2 focus:ring-offset-1 focus:ring-gray-300">
                    <span class="iconify text-lg text-primary" data-icon="heroicons:arrow-down-tray"></span>
                    <span>Download Log</span>
                </a>

                <button type="button" 
                        @click="showClearModal = true" 
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-rose-200 text-rose-600 rounded-lg text-sm font-medium hover:bg-rose-50 hover:border-rose-300 transition-all shadow-sm focus:ring-2 focus:ring-offset-1 focus:ring-rose-300 shrink-0">
                    <span class="iconify text-lg" data-icon="heroicons:trash"></span>
                    <span>Clear Log File</span>
                </button>
            </div>
        </div>

        <!-- FLASH NOTIFICATION -->
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
            <button type="button" 
                    @click="show = false" 
                    class="text-emerald-500 hover:text-emerald-700 hover:bg-emerald-100 p-1.5 rounded-lg transition-colors focus:outline-none" 
                    title="Dismiss">
                <span class="iconify text-lg" data-icon="heroicons:x-mark"></span>
            </button>
        </div>
        @endif

        <!-- SETTINGS SUB-NAVIGATION TABS -->
        <x-settings::settings-nav active="logs" />

        <!-- SERVER HEALTH KPI CARDS -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            
            <!-- PHP Version -->
            <div class="p-4 bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="flex items-center gap-1.5 text-gray-500 text-xs font-semibold mb-1">
                    <span class="iconify text-sm text-indigo-500" data-icon="heroicons:cpu-chip"></span>
                    <span>PHP Runtime</span>
                </div>
                <div class="text-sm font-bold text-gray-900 font-mono">{{ $serverHealth['php_version'] }}</div>
            </div>

            <!-- Laravel Framework -->
            <div class="p-4 bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="flex items-center gap-1.5 text-gray-500 text-xs font-semibold mb-1">
                    <span class="iconify text-sm text-rose-500" data-icon="heroicons:cube"></span>
                    <span>Framework</span>
                </div>
                <div class="text-sm font-bold text-gray-900 font-mono">v{{ $serverHealth['laravel_version'] }}</div>
            </div>

            <!-- OS Info -->
            <div class="p-4 bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="flex items-center gap-1.5 text-gray-500 text-xs font-semibold mb-1">
                    <span class="iconify text-sm text-blue-500" data-icon="heroicons:computer-desktop"></span>
                    <span>Environment</span>
                </div>
                <div class="text-xs font-bold text-gray-900 truncate">{{ $serverHealth['os'] }}</div>
            </div>

            <!-- Memory Consumption -->
            <div class="p-4 bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="flex items-center gap-1.5 text-gray-500 text-xs font-semibold mb-1">
                    <span class="iconify text-sm text-amber-500" data-icon="heroicons:chart-bar"></span>
                    <span>Memory Usage</span>
                </div>
                <div class="text-sm font-bold text-gray-900">{{ $serverHealth['memory_usage'] }}</div>
            </div>

            <!-- Uptime -->
            <div class="p-4 bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="flex items-center gap-1.5 text-gray-500 text-xs font-semibold mb-1">
                    <span class="iconify text-sm text-emerald-500" data-icon="heroicons:check-badge"></span>
                    <span>Server Uptime</span>
                </div>
                <div class="text-sm font-bold text-emerald-600">{{ $serverHealth['uptime'] }}</div>
            </div>

            <!-- Log Size -->
            <div class="p-4 bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="flex items-center gap-1.5 text-gray-500 text-xs font-semibold mb-1">
                    <span class="iconify text-sm text-purple-500" data-icon="heroicons:document-text"></span>
                    <span>Log File Size</span>
                </div>
                <div class="text-sm font-bold text-gray-900 font-mono">{{ $serverHealth['log_size'] }}</div>
            </div>

        </div>

        <!-- MAIN CARD TABLE WRAPPER -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            
            <!-- TOOLBAR: SEARCH & FILTER -->
            <div class="p-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between gap-4 items-center bg-white">
                <!-- Search Input -->
                <div class="relative w-full sm:max-w-md">
                    <span class="iconify absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg" data-icon="heroicons:magnifying-glass"></span>
                    <input type="text" 
                           x-model="searchQuery" 
                           placeholder="Filter errors by keyword, class, or message..." 
                           class="w-full pl-10 pr-4 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                </div>

                <!-- Severity Level Filter -->
                <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                    <div class="relative w-full sm:w-52">
                        <span class="iconify absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-base" data-icon="heroicons:funnel"></span>
                        <select x-model="levelFilter" 
                                class="w-full pl-9 pr-8 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all appearance-none text-gray-700 font-medium">
                            <option value="">All Severities (Semua)</option>
                            <option value="CRITICAL">CRITICAL / EMERGENCY</option>
                            <option value="ERROR">ERROR</option>
                            <option value="WARNING">WARNING</option>
                            <option value="INFO">INFO</option>
                            <option value="DEBUG">DEBUG</option>
                        </select>
                        <span class="iconify absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 text-base pointer-events-none" data-icon="heroicons:chevron-down"></span>
                    </div>
                </div>
            </div>

            <!-- LOG TABLE -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-700 uppercase font-semibold text-xs border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3.5 whitespace-nowrap">Severity</th>
                            <th class="px-6 py-3.5 whitespace-nowrap">Timestamp</th>
                            <th class="px-6 py-3.5 whitespace-nowrap">Environment</th>
                            <th class="px-6 py-3.5">Error Message / Exception Context</th>
                            <th class="px-6 py-3.5 whitespace-nowrap text-right">Inspect</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($logs as $log)
                        @php $logJson = json_encode($log); @endphp
                        <tr x-show="matchesLog({{ $logJson }})" 
                            class="odd:bg-white even:bg-slate-50/40 hover:bg-blue-50/50 transition-colors group">
                            
                            <!-- Col 1: Severity Badge -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(in_array($log['level'], ['EMERGENCY', 'CRITICAL', 'ALERT']))
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold bg-rose-100 text-rose-800 border border-rose-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-600 animate-ping"></span>
                                    {{ $log['level'] }}
                                </span>
                                @elseif($log['level'] === 'ERROR')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    ERROR
                                </span>
                                @elseif($log['level'] === 'WARNING')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    WARNING
                                </span>
                                @elseif($log['level'] === 'INFO')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    INFO
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold bg-gray-100 text-gray-700 border border-gray-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                    {{ $log['level'] }}
                                </span>
                                @endif
                            </td>

                            <!-- Col 2: Timestamp -->
                            <td class="px-6 py-4 whitespace-nowrap text-xs font-mono text-gray-500 font-medium">
                                {{ $log['timestamp'] }}
                            </td>

                            <!-- Col 3: Environment -->
                            <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-gray-600 uppercase">
                                <span class="bg-gray-100 px-2 py-0.5 rounded border border-gray-200">{{ $log['environment'] }}</span>
                            </td>

                            <!-- Col 4: Message -->
                            <td class="px-6 py-4">
                                <div class="font-mono text-xs font-bold text-gray-900 group-hover:text-primary transition-colors line-clamp-1">
                                    {{ $log['message'] }}
                                </div>
                            </td>

                            <!-- Col 5: Trace Button -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button type="button" 
                                        @click="openTraceModal({{ $logJson }})"
                                        class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-semibold text-primary hover:bg-blue-50 rounded-lg transition-colors border border-blue-100">
                                    <span class="iconify text-base" data-icon="heroicons:code-bracket"></span>
                                    <span>Stack Trace</span>
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
                    Showing recent <span class="font-semibold text-gray-900">{{ count($logs) }}</span> event entries from <span class="font-mono">laravel.log</span>
                </div>
                <div>
                    <nav class="isolate inline-flex -space-x-px rounded-lg shadow-sm" aria-label="Pagination">
                        <button type="button" class="relative inline-flex items-center rounded-l-lg px-2.5 py-2 text-gray-400 bg-white border border-gray-300 hover:bg-gray-50 focus:z-20" disabled>
                            <span class="sr-only">Previous</span>
                            <span class="iconify text-base" data-icon="heroicons:chevron-left"></span>
                        </button>
                        <button type="button" aria-current="page" class="relative z-10 inline-flex items-center bg-primary px-3.5 py-2 text-xs font-bold text-white border border-primary focus:z-20">1</button>
                        <button type="button" class="relative inline-flex items-center rounded-r-lg px-2.5 py-2 text-gray-400 bg-white border border-gray-300 hover:bg-gray-50 focus:z-20" disabled>
                            <span class="sr-only">Next</span>
                            <span class="iconify text-base" data-icon="heroicons:chevron-right"></span>
                        </button>
                    </nav>
                </div>
            </div>

        </div>

        <!-- ========================================================================= -->
        <!-- MODAL: STACK TRACE INSPECTOR (ALPINE.JS)                                  -->
        <!-- ========================================================================= -->
        <div x-show="showTraceModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
            
            <!-- Backdrop -->
            <div x-show="showTraceModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
                 @click="showTraceModal = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="showTraceModal" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl border border-gray-200">
                    
                    <div class="bg-slate-900 px-6 py-4 text-white flex items-center justify-between border-b border-slate-800">
                        <div class="flex items-center gap-2">
                            <span class="iconify text-xl text-rose-400" data-icon="heroicons:exclamation-triangle"></span>
                            <h3 class="text-sm font-bold font-mono tracking-wide" x-text="activeLog ? activeLog.level + ' Exception Trace' : 'Stack Trace'"></h3>
                        </div>
                        <button type="button" @click="showTraceModal = false" class="text-slate-400 hover:text-white focus:outline-none">
                            <span class="iconify text-xl" data-icon="heroicons:x-mark"></span>
                        </button>
                    </div>

                    <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                        
                        <!-- Metadata summary -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 p-3 bg-gray-50 border border-gray-200 rounded-xl text-xs">
                            <div>
                                <span class="text-gray-400 block font-semibold">Timestamp</span>
                                <span class="font-mono font-bold text-gray-800" x-text="activeLog?.timestamp"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block font-semibold">Environment</span>
                                <span class="font-bold text-gray-800 uppercase" x-text="activeLog?.environment"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block font-semibold">Severity</span>
                                <span class="font-bold text-rose-600" x-text="activeLog?.level"></span>
                            </div>
                        </div>

                        <!-- Error Message Header -->
                        <div>
                            <span class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-1">Exception Message</span>
                            <div class="p-3 bg-rose-50 border border-rose-200 rounded-lg text-xs font-mono text-rose-900 font-semibold" x-text="activeLog?.message"></div>
                        </div>

                        <!-- Stack Trace Block -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Stack Trace Dump</span>
                                <button type="button" 
                                        @click="copyTrace()" 
                                        class="inline-flex items-center gap-1 text-xs text-primary hover:underline focus:outline-none">
                                    <span class="iconify text-sm" :data-icon="copied ? 'heroicons:check' : 'heroicons:clipboard-document'"></span>
                                    <span x-text="copied ? 'Copied!' : 'Copy Trace'"></span>
                                </button>
                            </div>
                            <pre class="p-4 bg-slate-900 text-slate-200 rounded-xl text-xs font-mono overflow-x-auto leading-relaxed whitespace-pre-wrap border border-slate-800" x-text="activeLog?.trace"></pre>
                        </div>

                    </div>

                    <div class="bg-gray-50 px-6 py-3.5 sm:flex sm:flex-row-reverse sm:px-6 gap-2 border-t border-gray-100">
                        <button type="button" 
                                @click="showTraceModal = false" 
                                class="inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:w-auto transition-colors">
                            Close
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- MODAL: CLEAR LOG FILE CONFIRMATION (ALPINE.JS)                            -->
        <!-- ========================================================================= -->
        <div x-show="showClearModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
            
            <!-- Backdrop -->
            <div x-show="showClearModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
                 @click="showClearModal = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="showClearModal" 
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
                                <span class="iconify text-2xl" data-icon="heroicons:trash"></span>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-bold leading-6 text-gray-900" id="modal-title">Purge System Log File</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to clear the entire content of <span class="font-mono font-semibold text-gray-900">storage/logs/laravel.log</span>? Existing error histories and diagnostic records will be erased.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-3.5 sm:flex sm:flex-row-reverse sm:px-6 gap-2 border-t border-gray-100">
                        <form action="{{ route('settings.logs.clear') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex w-full justify-center rounded-lg bg-rose-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 sm:w-auto transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                                Confirm Purge
                            </button>
                        </form>
                        <button type="button" 
                                @click="showClearModal = false" 
                                class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                            Cancel
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</x-admin::layouts.master>

