<x-admin::layouts.master>
    <div x-data="{
            searchQuery: '',
            roleFilter: '',
            statusFilter: '',
            showFilterDropdown: false,
            
            // Delete Modal State
            showDeleteModal: false,
            deleteUserId: null,
            deleteUserName: '',
            openDeleteModal(id, name) {
                this.deleteUserId = id;
                this.deleteUserName = name;
                this.showDeleteModal = true;
            },

            // Export Modal State
            showExportModal: false,
            exportFormat: 'xlsx',
            exportScope: 'all',
            isExporting: false,
            exportSuccess: false,
            triggerExport() {
                this.isExporting = true;
                setTimeout(() => {
                    this.isExporting = false;
                    this.showExportModal = false;
                    this.exportSuccess = true;
                    setTimeout(() => this.exportSuccess = false, 5000);
                }, 1000);
            }
         }" 
         class="space-y-6">

        <!-- HEADER TITLE & ACTION -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2 text-xs font-medium text-gray-500 mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors flex items-center gap-1">
                        <span class="iconify text-sm" data-icon="heroicons:home"></span>
                        Dashboard
                    </a>
                    <span class="iconify text-xs text-gray-400" data-icon="heroicons:chevron-right"></span>
                    <span class="text-gray-800 font-semibold">Users</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">Users Management</h1>
                <p class="text-sm text-gray-500 mt-0.5">Manage system users, their access levels, roles, and account status.</p>
            </div>
            
            <a href="{{ route('users.create') }}" 
               class="inline-flex items-center gap-2 bg-primary text-white px-4 py-2.5 rounded-lg hover:bg-blue-600 transition-all shadow-sm font-medium text-sm focus:ring-2 focus:ring-offset-2 focus:ring-primary focus:outline-none shrink-0">
                <span class="iconify text-lg" data-icon="heroicons:plus"></span>
                <span>Add New User</span>
            </a>
        </div>

        <!-- FLASH MESSAGE NOTIFICATION (DARI REDIRECT CONTROLLER) -->
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

        <!-- EXPORT SIMULATION SUCCESS TOAST -->
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
                    File export <strong class="font-semibold" x-text="'users_export.' + exportFormat"></strong> berhasil diunduh (Simulasi Mockup).
                </span>
            </div>
            <button type="button" 
                    @click="exportSuccess = false" 
                    class="text-blue-500 hover:text-blue-700 hover:bg-blue-100 p-1.5 rounded-lg transition-colors focus:outline-none">
                <span class="iconify text-lg" data-icon="heroicons:x-mark"></span>
            </button>
        </div>

        <!-- MAIN CARD TABLE WRAPPER -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            
            <!-- TOOLBAR: SEARCH & FILTER -->
            <div class="p-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between gap-4 items-center bg-white">
                
                <!-- Search Input -->
                <div class="relative w-full sm:max-w-xs">
                    <span class="iconify absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg" data-icon="heroicons:magnifying-glass"></span>
                    <input type="text" 
                           x-model="searchQuery"
                           placeholder="Search users by name, email..." 
                           class="w-full pl-10 pr-4 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                </div>

                <!-- Filters & Actions -->
                <div class="flex items-center gap-2 w-full sm:w-auto justify-end relative">
                    
                    <!-- Filter Dropdown Trigger -->
                    <div class="relative">
                        <button @click="showFilterDropdown = !showFilterDropdown" 
                                type="button"
                                class="flex items-center gap-2 px-3.5 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition-colors font-medium shadow-sm">
                            <span class="iconify text-gray-500 text-base" data-icon="heroicons:funnel"></span>
                            <span>Filter</span>
                            <span class="iconify text-xs text-gray-400 transform transition-transform" :class="showFilterDropdown ? 'rotate-180' : ''" data-icon="heroicons:chevron-down"></span>
                        </button>

                        <!-- Filter Popover Panel (Hidden by default with x-cloak & x-show) -->
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
                                <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider">Filter Data</h4>
                                <button type="button" @click="showFilterDropdown = false" class="text-gray-400 hover:text-gray-600">
                                    <span class="iconify text-base" data-icon="heroicons:x-mark"></span>
                                </button>
                            </div>
                            
                            <!-- Role Filter -->
                            <div>
                                <label class="text-xs font-semibold text-gray-700 block mb-1">User Role</label>
                                <select x-model="roleFilter" class="w-full text-xs bg-gray-50 border border-gray-300 rounded-lg p-2.5 focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                                    <option value="">All Roles (Semua)</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Editor">Editor</option>
                                    <option value="Member">Member</option>
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div>
                                <label class="text-xs font-semibold text-gray-700 block mb-1">Account Status</label>
                                <select x-model="statusFilter" class="w-full text-xs bg-gray-50 border border-gray-300 rounded-lg p-2.5 focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                                    <option value="">All Statuses (Semua)</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Nonaktif">Nonaktif</option>
                                </select>
                            </div>

                            <div class="pt-2 flex items-center justify-between border-t border-gray-100">
                                <button type="button" 
                                        @click="roleFilter = ''; statusFilter = ''; searchQuery = '';" 
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

                    <!-- Export Trigger Button (Opens Export Modal) -->
                    <button type="button" 
                            @click="showExportModal = true" 
                            class="flex items-center gap-1.5 px-3.5 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition-colors font-medium shadow-sm" 
                            title="Export Users">
                        <span class="iconify text-base text-gray-500" data-icon="heroicons:arrow-down-tray"></span>
                        <span class="hidden md:inline">Export</span>
                    </button>
                </div>
            </div>

            <!-- TABLE SECTION -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-700 uppercase font-semibold text-xs border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3.5 whitespace-nowrap">User</th>
                            <th class="px-6 py-3.5 whitespace-nowrap">Role</th>
                            <th class="px-6 py-3.5 whitespace-nowrap">Status</th>
                            <th class="px-6 py-3.5 whitespace-nowrap">Joined Date</th>
                            <th class="px-6 py-3.5 whitespace-nowrap text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach(collect($users)->take(10) as $user)
                        <tr class="odd:bg-white even:bg-slate-50/40 hover:bg-blue-50/50 transition-colors group">
                            
                            <!-- Col: User (Avatar + Name + Email) -->
                            <td class="px-6 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <!-- UI-Avatars Mockup -->
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=f1f5f9&color=334155&bold=true" 
                                         alt="{{ $user->name }}" 
                                         class="w-10 h-10 rounded-full border border-gray-200 object-cover shrink-0">
                                    <div>
                                        <a href="{{ route('users.show', $user->id) }}" class="font-bold text-gray-900 hover:text-primary transition-colors block">
                                            {{ $user->name }}
                                        </a>
                                        <div class="text-gray-500 text-xs">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Col: Role -->
                            <td class="px-6 py-3 whitespace-nowrap">
                                @php
                                    $roleColors = [
                                        'Admin' => 'bg-purple-50 text-purple-700 border-purple-200',
                                        'Editor' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'Member' => 'bg-gray-50 text-gray-700 border-gray-200'
                                    ];
                                    $roleClass = $roleColors[$user->role] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold border {{ $roleClass }}">
                                    {{ $user->role }}
                                </span>
                            </td>

                            <!-- Col: Status -->
                            <td class="px-6 py-3 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold border
                                    {{ $user->status === 'Aktif' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $user->status === 'Aktif' ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                    {{ $user->status }}
                                </span>
                            </td>

                            <!-- Col: Joined Date -->
                            <td class="px-6 py-3 whitespace-nowrap text-gray-500 text-xs font-medium">
                                {{ \Carbon\Carbon::parse($user->created_at)->format('Y-m-d H:i:s') }}
                            </td>

                            <!-- Col: Actions (View, Edit, Delete) -->
                            <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-1 opacity-80 group-hover:opacity-100 transition-opacity">
                                    <!-- View Details Link -->
                                    <a href="{{ route('users.show', $user->id) }}" 
                                       class="p-2 text-gray-500 hover:text-primary hover:bg-blue-50 rounded-lg transition-colors inline-flex items-center focus:outline-none" 
                                       title="View Details">
                                        <span class="iconify text-lg" data-icon="heroicons:eye"></span>
                                    </a>

                                    <!-- Edit User Link -->
                                    <a href="{{ route('users.edit', $user->id) }}" 
                                       class="p-2 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors inline-flex items-center focus:outline-none" 
                                       title="Edit User">
                                        <span class="iconify text-lg" data-icon="heroicons:pencil-square"></span>
                                    </a>

                                    <!-- Delete User Button (Opens Alpine Delete Modal) -->
                                    <button type="button" 
                                            @click="openDeleteModal({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                            class="p-2 text-gray-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors inline-flex items-center focus:outline-none" 
                                            title="Delete User">
                                        <span class="iconify text-lg" data-icon="heroicons:trash"></span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION MOCKUP -->
            <div class="px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-gray-200 rounded-b-xl bg-gray-50/60">
                <!-- Showing Info -->
                <div class="text-xs text-gray-500">
                    Showing <span class="font-semibold text-gray-900">1</span> to <span class="font-semibold text-gray-900">10</span> of <span class="font-semibold text-gray-900">{{ count($users) }}</span> users
                </div>
                
                <!-- Page Navigation Buttons -->
                <div>
                    <nav class="isolate inline-flex -space-x-px rounded-lg shadow-sm" aria-label="Pagination">
                        <!-- Prev -->
                        <a href="{{ route('users.index') }}" class="relative inline-flex items-center rounded-l-lg px-2.5 py-2 text-gray-400 bg-white border border-gray-300 hover:bg-gray-50 focus:z-20">
                            <span class="sr-only">Previous</span>
                            <span class="iconify text-base" data-icon="heroicons:chevron-left"></span>
                        </a>
                        <!-- Page 1 -->
                        <a href="{{ route('users.index') }}" aria-current="page" class="relative z-10 inline-flex items-center bg-primary px-3.5 py-2 text-xs font-bold text-white border border-primary focus:z-20">1</a>
                        <!-- Page 2 -->
                        <a href="{{ route('users.index') }}" class="relative inline-flex items-center bg-white px-3.5 py-2 text-xs font-semibold text-gray-700 border border-gray-300 hover:bg-gray-50 focus:z-20">2</a>
                        <!-- Page 3 -->
                        <a href="{{ route('users.index') }}" class="relative inline-flex items-center bg-white px-3.5 py-2 text-xs font-semibold text-gray-700 border border-gray-300 hover:bg-gray-50 focus:z-20">3</a>
                        <!-- Next -->
                        <a href="{{ route('users.index') }}" class="relative inline-flex items-center rounded-r-lg px-2.5 py-2 text-gray-400 bg-white border border-gray-300 hover:bg-gray-50 focus:z-20">
                            <span class="sr-only">Next</span>
                            <span class="iconify text-base" data-icon="heroicons:chevron-right"></span>
                        </a>
                    </nav>
                </div>
            </div>
            
        </div>

        <!-- ========================================================================= -->
        <!-- MODAL: DELETE USER CONFIRMATION (ALPINE.JS)                                -->
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
                                <h3 class="text-base font-bold leading-6 text-gray-900" id="modal-title">Delete User Account</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete user <span class="font-semibold text-gray-900" x-text="deleteUserName"></span> (ID #<span x-text="deleteUserId"></span>)? All associated records and permissions will be permanently removed.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-3.5 sm:flex sm:flex-row-reverse sm:px-6 gap-2 border-t border-gray-100">
                        <form :action="'{{ url('admin/users') }}/' + deleteUserId" method="POST" class="inline">
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
        <!-- MODAL: EXPORT USERS (ALPINE.JS)                                           -->
        <!-- ========================================================================= -->
        <div x-show="showExportModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             role="dialog" 
             aria-modal="true">
            
            <!-- Backdrop -->
            <div x-show="showExportModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
                 @click="showExportModal = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <!-- Modal Panel -->
                <div x-show="showExportModal" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-200">
                    
                    <!-- Modal Header -->
                    <div class="bg-white px-6 pt-6 pb-4 border-b border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-primary flex items-center justify-center">
                                <span class="iconify text-2xl" data-icon="heroicons:arrow-down-tray"></span>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Export Users Data</h3>
                                <p class="text-xs text-gray-500">Download formatted user records for reporting or spreadsheet audit.</p>
                            </div>
                        </div>
                        <button type="button" @click="showExportModal = false" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                            <span class="iconify text-xl" data-icon="heroicons:x-mark"></span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6 space-y-5">
                        
                        <!-- 1. Format Selection -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                1. Export Format
                            </label>
                            <div class="grid grid-cols-3 gap-3">
                                <!-- Excel -->
                                <label class="p-3 rounded-xl border cursor-pointer text-center transition-all"
                                       :class="exportFormat === 'xlsx' ? 'border-primary bg-blue-50/50 ring-1 ring-primary' : 'border-gray-200 hover:border-gray-300 bg-white'">
                                    <input type="radio" name="format" value="xlsx" x-model="exportFormat" class="sr-only">
                                    <span class="iconify text-2xl mx-auto mb-1 text-emerald-600" data-icon="heroicons:table-cells"></span>
                                    <span class="text-xs font-bold text-gray-900 block">Excel</span>
                                    <span class="text-[10px] text-gray-400">.xlsx format</span>
                                </label>

                                <!-- CSV -->
                                <label class="p-3 rounded-xl border cursor-pointer text-center transition-all"
                                       :class="exportFormat === 'csv' ? 'border-primary bg-blue-50/50 ring-1 ring-primary' : 'border-gray-200 hover:border-gray-300 bg-white'">
                                    <input type="radio" name="format" value="csv" x-model="exportFormat" class="sr-only">
                                    <span class="iconify text-2xl mx-auto mb-1 text-blue-600" data-icon="heroicons:document-text"></span>
                                    <span class="text-xs font-bold text-gray-900 block">CSV</span>
                                    <span class="text-[10px] text-gray-400">Comma-separated</span>
                                </label>

                                <!-- PDF -->
                                <label class="p-3 rounded-xl border cursor-pointer text-center transition-all"
                                       :class="exportFormat === 'pdf' ? 'border-primary bg-blue-50/50 ring-1 ring-primary' : 'border-gray-200 hover:border-gray-300 bg-white'">
                                    <input type="radio" name="format" value="pdf" x-model="exportFormat" class="sr-only">
                                    <span class="iconify text-2xl mx-auto mb-1 text-rose-600" data-icon="heroicons:document-arrow-down"></span>
                                    <span class="text-xs font-bold text-gray-900 block">PDF</span>
                                    <span class="text-[10px] text-gray-400">Printable report</span>
                                </label>
                            </div>
                        </div>

                        <!-- 2. Export Scope -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                2. Data Scope
                            </label>
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 transition-colors">
                                    <input type="radio" name="scope" value="all" x-model="exportScope" class="text-primary focus:ring-primary">
                                    <div>
                                        <span class="text-xs font-bold text-gray-800 block">All Records (Semua Data)</span>
                                        <span class="text-[11px] text-gray-500">Export seluruh 23 data user dalam sistem.</span>
                                    </div>
                                </label>
                                <label class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 transition-colors">
                                    <input type="radio" name="scope" value="filtered" x-model="exportScope" class="text-primary focus:ring-primary">
                                    <div>
                                        <span class="text-xs font-bold text-gray-800 block">Current Page Only</span>
                                        <span class="text-[11px] text-gray-500">Export 10 user yang sedang ditampilkan di tabel.</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                    </div>

                    <!-- Modal Footer -->
                    <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-gray-100">
                        <span class="text-xs text-gray-400 text-center sm:text-left">
                            Format: <strong class="uppercase text-gray-700" x-text="exportFormat"></strong>
                        </span>
                        
                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <button type="button" 
                                    @click="showExportModal = false" 
                                    class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors w-full sm:w-auto">
                                Cancel
                            </button>
                            <button type="button" 
                                    @click="triggerExport()" 
                                    :disabled="isExporting"
                                    class="inline-flex items-center justify-center gap-2 px-5 py-2 bg-primary text-white rounded-lg text-sm font-semibold hover:bg-blue-600 transition-all shadow-sm focus:ring-2 focus:ring-offset-1 focus:ring-primary disabled:opacity-50 w-full sm:w-auto">
                                <template x-if="isExporting">
                                    <span class="inline-flex items-center gap-2">
                                        <span class="iconify animate-spin text-base" data-icon="heroicons:arrow-path"></span>
                                        Generating...
                                    </span>
                                </template>
                                <template x-if="!isExporting">
                                    <span class="inline-flex items-center gap-1.5">
                                        <span class="iconify text-base" data-icon="heroicons:arrow-down-tray"></span>
                                        Download File
                                    </span>
                                </template>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</x-admin::layouts.master>
