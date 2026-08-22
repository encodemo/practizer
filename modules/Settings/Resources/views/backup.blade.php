<x-admin::layouts.master>
    <div x-data="{
            showDeleteModal: false,
            deleteFilename: '',
            showRestoreModal: false,
            restoreFilename: '',
            openDeleteModal(filename) {
                this.deleteFilename = filename;
                this.showDeleteModal = true;
            },
            openRestoreModal(filename) {
                this.restoreFilename = filename;
                this.showRestoreModal = true;
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
                    <span class="text-gray-800 font-semibold">Backup & Storage</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">Backup & Storage Maintenance</h1>
                <p class="text-sm text-gray-500 mt-0.5">Manage automated database dumps, storage disk quotas, snapshot downloads, and system cache optimization.</p>
            </div>

            <!-- Top Actions -->
            <div class="flex items-center gap-2">
                <form action="{{ route('settings.backup.optimize') }}" method="POST" class="inline m-0">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm focus:ring-2 focus:ring-offset-1 focus:ring-gray-300">
                        <span class="iconify text-lg text-emerald-600" data-icon="heroicons:sparkles"></span>
                        <span>Optimize Cache</span>
                    </button>
                </form>

                <form action="{{ route('settings.backup.create') }}" method="POST" class="inline m-0">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-blue-600 transition-all shadow-sm focus:ring-2 focus:ring-offset-1 focus:ring-primary shrink-0">
                        <span class="iconify text-lg" data-icon="heroicons:plus"></span>
                        <span>Create Backup Now</span>
                    </button>
                </form>
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
        <x-settings::settings-nav active="backup" />

        <!-- STORAGE & SERVER HEALTH METRICS BAR -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- Metric 1: Backups Total -->
            <div class="p-5 bg-white rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Available Snapshots</span>
                    <span class="text-2xl font-bold text-gray-900 mt-1 block">{{ count($backups) }} Files</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-primary flex items-center justify-center border border-blue-100">
                    <span class="iconify text-2xl" data-icon="heroicons:circle-stack"></span>
                </div>
            </div>

            <!-- Metric 2: Storage Free -->
            <div class="p-5 bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Disk Partition</span>
                    <span class="text-xs font-bold text-gray-800">{{ $serverStats['storage_free'] }} Free</span>
                </div>
                <div class="mt-2 w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                    <div class="bg-primary h-2 rounded-full" style="width: {{ $serverStats['storage_percentage'] }}%"></div>
                </div>
                <span class="text-[11px] text-gray-500 mt-1 block">{{ $serverStats['storage_used'] }} of 200 GB Used ({{ $serverStats['storage_percentage'] }}%)</span>
            </div>

            <!-- Metric 3: Cache Driver -->
            <div class="p-5 bg-white rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Cache Driver</span>
                    <span class="text-lg font-bold text-gray-900 mt-1 block uppercase">{{ $serverStats['cache_driver'] }} (Active)</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
                    <span class="iconify text-2xl" data-icon="heroicons:bolt"></span>
                </div>
            </div>

            <!-- Metric 4: Queue Driver -->
            <div class="p-5 bg-white rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Queue Worker</span>
                    <span class="text-lg font-bold text-gray-900 mt-1 block uppercase">{{ $serverStats['queue_driver'] }}</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-100">
                    <span class="iconify text-2xl" data-icon="heroicons:queue-list"></span>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-6">

            <!-- LEFT COLUMN: BACKUP SNAPSHOTS TABLE (8 COLS) -->
            <div class="lg:col-span-8 space-y-6">

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/50 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="iconify text-xl text-primary" data-icon="heroicons:archive-box"></span>
                            <div>
                                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Backup Archive Repository</h3>
                                <p class="text-[11px] text-gray-500">Historical database dumps and full snapshot files stored on disk.</p>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600">
                            <thead class="bg-gray-50 text-gray-700 uppercase font-semibold text-xs border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3.5 whitespace-nowrap">Backup Archive</th>
                                    <th class="px-6 py-3.5 whitespace-nowrap">Size</th>
                                    <th class="px-6 py-3.5 whitespace-nowrap">Location</th>
                                    <th class="px-6 py-3.5 whitespace-nowrap">Created Date</th>
                                    <th class="px-6 py-3.5 whitespace-nowrap text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($backups as $backup)
                                <tr class="odd:bg-white even:bg-slate-50/40 hover:bg-blue-50/50 transition-colors group">
                                    
                                    <!-- Filename & Type -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-primary flex items-center justify-center shrink-0 mt-0.5 border border-blue-100">
                                                <span class="iconify text-lg" data-icon="heroicons:document-arrow-down"></span>
                                            </div>
                                            <div>
                                                <span class="font-mono font-bold text-xs text-gray-900 block">{{ $backup['filename'] }}</span>
                                                <span class="text-[11px] text-gray-500">{{ $backup['type'] }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Size -->
                                    <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-gray-700">
                                        {{ $backup['size'] }}
                                    </td>

                                    <!-- Location Disk -->
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-600">
                                        <span class="inline-flex items-center gap-1 bg-gray-100 px-2 py-0.5 rounded text-gray-700 border border-gray-200">
                                            <span class="iconify text-xs text-gray-500" data-icon="heroicons:server"></span>
                                            {{ $backup['disk'] }}
                                        </span>
                                    </td>

                                    <!-- Created Date -->
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 font-medium">
                                        {{ \Carbon\Carbon::parse($backup['created_at'])->format('d M Y H:i') }}
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-1 opacity-80 group-hover:opacity-100 transition-opacity">
                                            
                                            <!-- Download Link -->
                                            <a href="{{ route('settings.backup.download', $backup['filename']) }}" 
                                               class="p-2 text-gray-500 hover:text-primary hover:bg-blue-50 rounded-lg transition-colors inline-flex items-center" 
                                               title="Download Snapshot">
                                                <span class="iconify text-lg" data-icon="heroicons:arrow-down-tray"></span>
                                            </a>

                                            <!-- Restore Button (Triggers Alpine Modal) -->
                                            <button type="button" 
                                                    @click="openRestoreModal('{{ $backup['filename'] }}')" 
                                                    class="p-2 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors inline-flex items-center" 
                                                    title="Restore Database">
                                                <span class="iconify text-lg" data-icon="heroicons:arrow-path"></span>
                                            </button>

                                            <!-- Delete Button (Triggers Alpine Modal) -->
                                            <button type="button" 
                                                    @click="openDeleteModal('{{ $backup['filename'] }}')" 
                                                    class="p-2 text-gray-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors inline-flex items-center" 
                                                    title="Delete Backup">
                                                <span class="iconify text-lg" data-icon="heroicons:trash"></span>
                                            </button>

                                        </div>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: SCHEDULE & MAINTENANCE ACTIONS (4 COLS) -->
            <div class="lg:col-span-4 space-y-6">

                <!-- CARD 1: AUTOMATED SCHEDULE SUMMARY -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider">Auto-Backup Schedule</h3>
                        <span class="iconify text-lg text-emerald-600" data-icon="heroicons:clock"></span>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between items-center text-gray-600">
                            <span>Frequency</span>
                            <span class="font-bold text-gray-900 bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded border border-emerald-200">Daily @ 00:00</span>
                        </div>
                        <div class="flex justify-between items-center text-gray-600">
                            <span>Retention Rule</span>
                            <span class="font-medium text-gray-800">Keep last 14 days</span>
                        </div>
                        <div class="flex justify-between items-center text-gray-600">
                            <span>Compression</span>
                            <span class="font-medium text-gray-800">GZIP (.sql.gz)</span>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: SYSTEM OPTIMIZATION UTILITY -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 space-y-3">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider">System Cache Flush</h3>
                        <span class="iconify text-lg text-primary" data-icon="heroicons:command-line"></span>
                    </div>

                    <p class="text-[11px] text-gray-500 leading-relaxed">
                        Recompiles application routes, Blade templates, and clears stale configuration cache.
                    </p>

                    <form action="{{ route('settings.backup.optimize') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-50 hover:bg-gray-100 border border-gray-300 rounded-lg text-xs font-bold text-gray-700 transition-colors shadow-sm focus:outline-none">
                            <span class="iconify text-base text-emerald-600" data-icon="heroicons:sparkles"></span>
                            <span>Run php artisan optimize</span>
                        </button>
                    </form>
                </div>

            </div>

        </div>

        <!-- ========================================================================= -->
        <!-- MODAL: DELETE BACKUP CONFIRMATION (ALPINE.JS)                             -->
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
                                <span class="iconify text-2xl" data-icon="heroicons:trash"></span>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-bold leading-6 text-gray-900" id="modal-title">Delete Backup File</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to permanently delete <span class="font-mono font-semibold text-gray-900" x-text="deleteFilename"></span>? This file will be permanently removed from disk storage.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-3.5 sm:flex sm:flex-row-reverse sm:px-6 gap-2 border-t border-gray-100">
                        <form :action="'{{ url('admin/settings/backup/delete') }}/' + deleteFilename" method="POST" class="inline">
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

        <!-- ========================================================================= -->
        <!-- MODAL: RESTORE DATABASE SNAPSHOT (ALPINE.JS)                              -->
        <!-- ========================================================================= -->
        <div x-show="showRestoreModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
            
            <!-- Backdrop -->
            <div x-show="showRestoreModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
                 @click="showRestoreModal = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="showRestoreModal" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-200">
                    
                    <div class="bg-white px-6 pb-6 pt-6 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-amber-100 sm:mx-0 sm:h-10 sm:w-10 text-amber-600">
                                <span class="iconify text-2xl" data-icon="heroicons:exclamation-triangle"></span>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-bold leading-6 text-gray-900" id="modal-title">Restore Database Snapshot</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Restoring from <span class="font-mono font-semibold text-gray-900" x-text="restoreFilename"></span> will override the current database tables with data from this snapshot point. Ensure you have taken a fresh backup before proceeding.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-3.5 sm:flex sm:flex-row-reverse sm:px-6 gap-2 border-t border-gray-100">
                        <form action="{{ route('settings.backup') }}" method="GET" class="inline">
                            <button type="submit" 
                                    @click="showRestoreModal = false"
                                    class="inline-flex w-full justify-center rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-amber-500 sm:w-auto transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                Confirm Restore
                            </button>
                        </form>
                        <button type="button" 
                                @click="showRestoreModal = false" 
                                class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                            Cancel
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</x-admin::layouts.master>

