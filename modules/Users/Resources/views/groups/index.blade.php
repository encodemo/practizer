<x-admin::layouts.master>
    <div x-data="{
            searchQuery: '',
            statusFilter: '',
            
            // Delete Modal State
            showDeleteModal: false,
            deleteGroupId: null,
            deleteGroupName: '',
            openDeleteModal(id, name) {
                this.deleteGroupId = id;
                this.deleteGroupName = name;
                this.showDeleteModal = true;
            },

            // Filter logic helper
            matchesFilter(group) {
                const q = this.searchQuery.toLowerCase();
                const matchSearch = !q || 
                    group.name.toLowerCase().includes(q) || 
                    group.description.toLowerCase().includes(q);
                
                const matchStatus = !this.statusFilter || group.status === this.statusFilter;
                return matchSearch && matchStatus;
            }
        }" 
        class="space-y-6">
        
        <!-- HEADER TITLE & TOP ACTION -->
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
                    <span class="text-gray-800 font-semibold">User Groups</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">User Groups Management</h1>
                <p class="text-sm text-gray-500 mt-0.5">Manage departmental teams, work groups, and group-level permission assignments.</p>
            </div>
            
            <a href="{{ route('users.groups.create') }}" 
               class="inline-flex items-center gap-2 bg-primary text-white px-4 py-2.5 rounded-lg hover:bg-blue-600 transition-all shadow-sm font-medium text-sm focus:ring-2 focus:ring-offset-2 focus:ring-primary focus:outline-none shrink-0">
                <span class="iconify text-lg" data-icon="heroicons:plus"></span>
                <span>Create New Group</span>
            </a>
        </div>

        <!-- FLASH MESSAGE NOTIFICATION (FROM CONTROLLER REDIRECT) -->
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

        <!-- MAIN CARD TABLE WRAPPER -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            
            <!-- TOOLBAR: SEARCH & FILTER -->
            <div class="p-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between gap-4 items-center bg-white">
                <!-- Search Input -->
                <div class="relative w-full sm:max-w-xs">
                    <span class="iconify absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg" data-icon="heroicons:magnifying-glass"></span>
                    <input type="text" 
                           x-model="searchQuery" 
                           placeholder="Search groups by name..." 
                           class="w-full pl-10 pr-4 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                </div>

                <!-- Status Filter -->
                <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                    <div class="relative w-full sm:w-48">
                        <span class="iconify absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-base" data-icon="heroicons:funnel"></span>
                        <select x-model="statusFilter" 
                                class="w-full pl-9 pr-8 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all appearance-none text-gray-700 font-medium">
                            <option value="">All Statuses (Semua)</option>
                            <option value="active">Active Groups</option>
                            <option value="inactive">Inactive Groups</option>
                        </select>
                        <span class="iconify absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 text-base pointer-events-none" data-icon="heroicons:chevron-down"></span>
                    </div>
                </div>
            </div>

            <!-- TABLE SECTION -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-700 uppercase font-semibold text-xs border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3.5 whitespace-nowrap">Group Name & Purpose</th>
                            <th class="px-6 py-3.5 whitespace-nowrap">Members</th>
                            <th class="px-6 py-3.5 whitespace-nowrap">Status</th>
                            <th class="px-6 py-3.5 whitespace-nowrap">Created Date</th>
                            <th class="px-6 py-3.5 whitespace-nowrap text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($groups as $group)
                        @php $groupJson = json_encode($group); @endphp
                        <tr x-show="matchesFilter({{ $groupJson }})" 
                            class="odd:bg-white even:bg-slate-50/40 hover:bg-blue-50/50 transition-colors group">
                            
                            <!-- Col 1: Group Details -->
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-blue-50 text-primary flex items-center justify-center shrink-0 mt-0.5 border border-blue-100">
                                        <span class="iconify text-xl" data-icon="heroicons:user-group"></span>
                                    </div>
                                    <div>
                                        <a href="{{ route('users.groups.edit', $group['id']) }}" class="font-bold text-gray-900 hover:text-primary transition-colors block">
                                            {{ $group['name'] }}
                                        </a>
                                        <div class="text-xs text-gray-500 mt-0.5">{{ $group['description'] }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Col 2: Members Count -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                    <span class="iconify text-sm text-gray-500" data-icon="heroicons:users"></span>
                                    {{ $group['users_count'] }} users
                                </span>
                            </td>

                            <!-- Col 3: Status Badge -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($group['status'] === 'active')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Active
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    Inactive
                                </span>
                                @endif
                            </td>

                            <!-- Col 4: Created Date -->
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 font-medium">
                                {{ \Carbon\Carbon::parse($group['created_at'])->format('d M Y') }}
                            </td>

                            <!-- Col 5: Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-1 opacity-80 group-hover:opacity-100 transition-opacity">
                                    <!-- Edit Link -->
                                    <a href="{{ route('users.groups.edit', $group['id']) }}" 
                                       class="p-2 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors inline-flex items-center focus:outline-none" 
                                       title="Edit Group">
                                        <span class="iconify text-lg" data-icon="heroicons:pencil-square"></span>
                                    </a>

                                    <!-- Delete Button (Triggers Alpine Modal) -->
                                    <button type="button" 
                                            @click="openDeleteModal({{ $group['id'] }}, '{{ addslashes($group['name']) }}')"
                                            class="p-2 text-gray-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors inline-flex items-center focus:outline-none" 
                                            title="Delete Group">
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
                <div class="text-xs text-gray-500">
                    Showing <span class="font-semibold text-gray-900">1</span> to <span class="font-semibold text-gray-900">{{ count($groups) }}</span> of <span class="font-semibold text-gray-900">{{ count($groups) }}</span> groups
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
                                        Are you sure you want to delete the group <span class="font-semibold text-gray-900" x-text="deleteGroupName"></span> (ID #<span x-text="deleteGroupId"></span>)? Members in this group may lose group-specific permissions.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-3.5 sm:flex sm:flex-row-reverse sm:px-6 gap-2 border-t border-gray-100">
                        <form :action="'{{ url('admin/users/groups') }}/' + deleteGroupId" method="POST" class="inline">
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

