<x-admin::layouts.master>
    <div x-data="{ 
            activeTab: 'overview',
            
            // Modal States
            showDeleteModal: false,
            showResetPassModal: false,
            showImpersonateModal: false,
            showForceResetModal: false,
            showRevokeModal: false,
            revokeTarget: 'All other remote sessions',

            // Toast / Feedback State
            actionToast: null,
            copied: false,

            copyToClipboard(text) {
                navigator.clipboard.writeText(text);
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            },

            triggerToast(message) {
                this.actionToast = message;
                setTimeout(() => this.actionToast = null, 4500);
            }
         }" 
         class="space-y-6">

        <!-- BREADCRUMBS & TOP NAVIGATION -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <!-- Breadcrumb -->
                <nav class="flex items-center gap-2 text-xs font-medium text-gray-500 mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors flex items-center gap-1">
                        <span class="iconify text-sm" data-icon="heroicons:home"></span>
                        Dashboard
                    </a>
                    <span class="iconify text-xs text-gray-400" data-icon="heroicons:chevron-right"></span>
                    <a href="{{ route('users.index') }}" class="hover:text-primary transition-colors">Users</a>
                    <span class="iconify text-xs text-gray-400" data-icon="heroicons:chevron-right"></span>
                    <span class="text-gray-800 font-semibold">{{ $user->name }}</span>
                </nav>
                
                <!-- Title & Status Header -->
                <div class="flex items-center flex-wrap gap-3">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                    
                    <!-- Role Badge -->
                    @php
                        $roleColors = [
                            'Admin' => 'bg-purple-50 text-purple-700 border-purple-200',
                            'Editor' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'Member' => 'bg-gray-50 text-gray-700 border-gray-200'
                        ];
                        $roleClass = $roleColors[$user->role] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold border {{ $roleClass }}">
                        <span class="iconify mr-1" data-icon="heroicons:shield-check"></span>
                        {{ $user->role }}
                    </span>

                    <!-- Status Pill -->
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold border
                        {{ $user->status === 'Aktif' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $user->status === 'Aktif' ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                        {{ $user->status }}
                    </span>

                    <!-- 2FA Badge -->
                    @if($user->two_factor_enabled)
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200" title="Two-Factor Authentication Active">
                        <span class="iconify text-emerald-600" data-icon="heroicons:lock-closed"></span>
                        2FA Active
                    </span>
                    @endif
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="flex items-center gap-2">
                <a href="{{ route('users.index') }}" 
                   class="inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm focus:ring-2 focus:ring-offset-1 focus:ring-gray-300">
                    <span class="iconify text-base" data-icon="heroicons:arrow-left"></span>
                    <span>Back to List</span>
                </a>

                <a href="{{ route('users.edit', $user->id) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-blue-600 transition-all shadow-sm focus:ring-2 focus:ring-offset-1 focus:ring-primary">
                    <span class="iconify text-base" data-icon="heroicons:pencil-square"></span>
                    <span>Edit User</span>
                </a>

                <button type="button" 
                        @click="showDeleteModal = true" 
                        class="inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-rose-200 text-rose-600 rounded-lg text-sm font-medium hover:bg-rose-50 hover:border-rose-300 transition-all shadow-sm focus:ring-2 focus:ring-offset-1 focus:ring-rose-300">
                    <span class="iconify text-base" data-icon="heroicons:trash"></span>
                    <span>Delete</span>
                </button>
            </div>
        </div>

        <!-- FLASH MESSAGE NOTIFICATION (DARI CONTROLLER REDIRECT) -->
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

        <!-- ACTION SIMULATION TOAST FEEDBACK (UNTUK MODAL ACTION) -->
        <div x-show="actionToast" 
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="p-4 rounded-xl bg-blue-50 border border-blue-200 flex items-center justify-between text-blue-800 text-sm shadow-sm">
            <div class="flex items-center gap-3">
                <span class="iconify text-xl text-primary shrink-0" data-icon="heroicons:information-circle"></span>
                <span class="font-medium" x-text="actionToast"></span>
            </div>
            <button type="button" 
                    @click="actionToast = null" 
                    class="text-blue-500 hover:text-blue-700 hover:bg-blue-100 p-1.5 rounded-lg transition-colors focus:outline-none">
                <span class="iconify text-lg" data-icon="heroicons:x-mark"></span>
            </button>
        </div>

        <!-- MAIN LAYOUT GRID (LEFT: PROFILE SUMMARY, RIGHT: DETAILS & TABS) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- LEFT COLUMN: USER PROFILE SUMMARY CARD (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Main Profile Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Cover Header -->
                    <div class="h-24 bg-gradient-to-r from-blue-600 via-indigo-600 to-primary relative">
                        <div class="absolute inset-0 bg-black/10"></div>
                    </div>

                    <div class="px-6 pb-6 pt-0 relative">
                        <!-- Avatar with Border -->
                        <div class="flex justify-between items-end -mt-12 mb-4">
                            <div class="relative">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=1e293b&color=ffffff&size=128&bold=true" 
                                     alt="{{ $user->name }}" 
                                     class="w-24 h-24 rounded-xl border-4 border-white shadow-md object-cover bg-white">
                                <span class="absolute bottom-1 right-1 w-4 h-4 rounded-full border-2 border-white {{ $user->status === 'Aktif' ? 'bg-emerald-500' : 'bg-rose-500' }}" 
                                      title="{{ $user->status }}"></span>
                            </div>

                            <span class="text-xs font-mono text-gray-600 bg-gray-100 border border-gray-200 px-2.5 py-1 rounded-md font-semibold">
                                ID #{{ $user->id }}
                            </span>
                        </div>

                        <!-- User Identity -->
                        <div class="mb-4">
                            <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                            <p class="text-sm text-gray-500 font-medium">@<span>{{ $user->username }}</span></p>
                            <p class="text-xs text-primary font-semibold mt-1">{{ $user->position }}</p>
                        </div>

                        <!-- Bio -->
                        <p class="text-xs text-gray-600 leading-relaxed border-t border-b border-gray-100 py-3 mb-4">
                            {{ $user->bio }}
                        </p>

                        <!-- Contact & Details List -->
                        <div class="space-y-3 text-xs text-gray-600">
                            <!-- Email -->
                            <div class="flex items-center justify-between group">
                                <div class="flex items-center gap-2 text-gray-500">
                                    <span class="iconify text-base text-gray-400" data-icon="heroicons:envelope"></span>
                                    <span>Email</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="font-medium text-gray-800">{{ $user->email }}</span>
                                    <button type="button" 
                                            @click="copyToClipboard('{{ $user->email }}')" 
                                            class="text-gray-400 hover:text-primary transition-colors p-0.5 rounded focus:outline-none" 
                                            title="Copy Email">
                                        <span class="iconify text-sm" data-icon="heroicons:clipboard-document"></span>
                                    </button>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-gray-500">
                                    <span class="iconify text-base text-gray-400" data-icon="heroicons:phone"></span>
                                    <span>Phone</span>
                                </div>
                                <span class="font-medium text-gray-800">{{ $user->phone }}</span>
                            </div>

                            <!-- Department -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-gray-500">
                                    <span class="iconify text-base text-gray-400" data-icon="heroicons:building-office"></span>
                                    <span>Department</span>
                                </div>
                                <span class="font-medium text-gray-800">{{ $user->department }}</span>
                            </div>

                            <!-- Location -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-gray-500">
                                    <span class="iconify text-base text-gray-400" data-icon="heroicons:map-pin"></span>
                                    <span>Location</span>
                                </div>
                                <span class="font-medium text-gray-800">{{ $user->location }}</span>
                            </div>

                            <!-- Timezone -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-gray-500">
                                    <span class="iconify text-base text-gray-400" data-icon="heroicons:clock"></span>
                                    <span>Timezone</span>
                                </div>
                                <span class="font-medium text-gray-800">{{ $user->timezone }}</span>
                            </div>

                            <!-- Joined At -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-gray-500">
                                    <span class="iconify text-base text-gray-400" data-icon="heroicons:calendar-days"></span>
                                    <span>Joined Date</span>
                                </div>
                                <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</span>
                            </div>
                        </div>

                        <!-- Copy feedback toast -->
                        <div x-show="copied" 
                             x-cloak
                             x-transition
                             class="mt-3 text-center py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded text-xs font-semibold">
                            ✓ Copied to clipboard!
                        </div>

                        <!-- Quick Actions Grid (Pop-up Modals) -->
                        <div class="mt-6 pt-4 border-t border-gray-100 grid grid-cols-2 gap-2">
                            <button type="button" 
                                    @click="showResetPassModal = true" 
                                    class="flex items-center justify-center gap-1.5 px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg text-xs font-medium transition-colors border border-gray-200 focus:outline-none">
                                <span class="iconify text-sm text-gray-500" data-icon="heroicons:key"></span>
                                Reset Pass
                            </button>
                            <button type="button" 
                                    @click="showImpersonateModal = true" 
                                    class="flex items-center justify-center gap-1.5 px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg text-xs font-medium transition-colors border border-gray-200 focus:outline-none">
                                <span class="iconify text-sm text-gray-500" data-icon="heroicons:arrow-path"></span>
                                Impersonate
                            </button>
                        </div>

                    </div>
                </div>

                <!-- Account Metadata Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 space-y-3">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">System Metadata</h3>
                    
                    <div class="space-y-2.5 text-xs">
                        <div class="flex items-center justify-between text-gray-600">
                            <span>Email Verified</span>
                            <span class="inline-flex items-center gap-1 text-emerald-600 font-semibold">
                                <span class="iconify" data-icon="heroicons:check-badge"></span>
                                {{ \Carbon\Carbon::parse($user->email_verified_at)->format('d M Y') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-gray-600">
                            <span>Last Login</span>
                            <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() }}</span>
                        </div>
                        <div class="flex items-center justify-between text-gray-600">
                            <span>Last Known IP</span>
                            <span class="font-mono text-gray-700 bg-gray-100 px-1.5 py-0.5 rounded text-[11px]">{{ $user->last_login_ip }}</span>
                        </div>
                        <div class="flex items-center justify-between text-gray-600">
                            <span>Last Profile Update</span>
                            <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($user->updated_at)->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: TABBED DETAILED PANELS (8 cols) -->
            <div class="lg:col-span-8 space-y-6">

                <!-- FILAMENT-STYLE TAB NAVIGATION -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-1.5 flex flex-wrap gap-1">
                    <button type="button" 
                            @click="activeTab = 'overview'" 
                            :class="activeTab === 'overview' ? 'bg-primary text-white font-semibold shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100 font-medium'"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm transition-all focus:outline-none">
                        <span class="iconify text-base" data-icon="heroicons:user"></span>
                        <span>Overview</span>
                    </button>

                    <button type="button" 
                            @click="activeTab = 'permissions'" 
                            :class="activeTab === 'permissions' ? 'bg-primary text-white font-semibold shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100 font-medium'"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm transition-all focus:outline-none">
                        <span class="iconify text-base" data-icon="heroicons:shield-check"></span>
                        <span>Roles & Permissions</span>
                    </button>

                    <button type="button" 
                            @click="activeTab = 'security'" 
                            :class="activeTab === 'security' ? 'bg-primary text-white font-semibold shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100 font-medium'"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm transition-all focus:outline-none">
                        <span class="iconify text-base" data-icon="heroicons:lock-closed"></span>
                        <span>Security & Sessions</span>
                    </button>

                    <button type="button" 
                            @click="activeTab = 'activity'" 
                            :class="activeTab === 'activity' ? 'bg-primary text-white font-semibold shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100 font-medium'"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm transition-all focus:outline-none">
                        <span class="iconify text-base" data-icon="heroicons:clock"></span>
                        <span>Activity Audit</span>
                    </button>
                </div>

                <!-- TAB 1: OVERVIEW -->
                <div x-show="activeTab === 'overview'" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-200" 
                     x-transition:enter-start="opacity-0 translate-y-1" 
                     x-transition:enter-end="opacity-100 translate-y-0" 
                     class="space-y-6">
                    
                    <!-- Section: General Account Information -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-5">
                            <div>
                                <h3 class="text-base font-bold text-gray-900">General Information</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Basic identity and personal contact records.</p>
                            </div>
                            <span class="iconify text-xl text-primary" data-icon="heroicons:identification"></span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-5 gap-x-6 text-sm">
                            <div>
                                <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Full Legal Name</label>
                                <p class="text-gray-900 font-medium">{{ $user->name }}</p>
                            </div>

                            <div>
                                <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Username</label>
                                <p class="text-gray-900 font-medium">@<span>{{ $user->username }}</span></p>
                            </div>

                            <div>
                                <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Primary Email</label>
                                <p class="text-gray-900 font-medium">{{ $user->email }}</p>
                            </div>

                            <div>
                                <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Contact Phone</label>
                                <p class="text-gray-900 font-medium">{{ $user->phone }}</p>
                            </div>

                            <div class="md:col-span-2">
                                <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Physical Address</label>
                                <p class="text-gray-900 font-medium">{{ $user->address }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Work & Organization -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-5">
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Organizational Assignment</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Department hierarchy and workplace positioning.</p>
                            </div>
                            <span class="iconify text-xl text-primary" data-icon="heroicons:briefcase"></span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-5 gap-x-6 text-sm">
                            <div>
                                <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Department</label>
                                <p class="text-gray-900 font-medium">{{ $user->department }}</p>
                            </div>

                            <div>
                                <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Job Designation</label>
                                <p class="text-gray-900 font-medium">{{ $user->position }}</p>
                            </div>

                            <div>
                                <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Assigned Group</label>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-blue-50 text-blue-700 text-xs font-medium border border-blue-200">
                                    <span class="iconify" data-icon="heroicons:user-group"></span>
                                    Core Tech Staff
                                </span>
                            </div>

                            <div>
                                <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Account Lifecycle</label>
                                <p class="text-gray-900 font-medium">Permanent Employee (Full-Access)</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- TAB 2: ROLES & PERMISSIONS -->
                <div x-show="activeTab === 'permissions'" 
                     x-cloak 
                     x-transition:enter="transition ease-out duration-200" 
                     x-transition:enter-start="opacity-0 translate-y-1" 
                     x-transition:enter-end="opacity-100 translate-y-0" 
                     class="space-y-6">
                    
                    <!-- Assigned Role Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Current Role Tier</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Primary RBAC authorization level assigned to this account.</p>
                            </div>
                            <a href="{{ route('users.roles.index') }}" class="text-xs text-primary hover:underline font-semibold flex items-center gap-1">
                                Manage Roles <span class="iconify" data-icon="heroicons:arrow-top-right-on-square"></span>
                            </a>
                        </div>

                        <div class="p-4 rounded-xl border border-purple-200 bg-purple-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-lg">
                                    <span class="iconify text-2xl" data-icon="heroicons:shield-check"></span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900">{{ $user->role }} Authority</h4>
                                    <p class="text-xs text-gray-600">Full administrative privileges across all modules with audit logging.</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded bg-purple-100 text-purple-800 text-xs font-bold border border-purple-200">
                                Default Role
                            </span>
                        </div>
                    </div>

                    <!-- Direct Permissions Matrix -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-4">
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Effective Permissions</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Granted actions derived from role and direct assignments.</p>
                            </div>
                            <span class="text-xs font-semibold px-2.5 py-1 bg-gray-100 text-gray-700 rounded-md border border-gray-200">
                                {{ count($user->permissions) }} Grants Active
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($user->permissions as $key => $description)
                            <div class="p-3 rounded-lg border border-gray-200 bg-gray-50/50 flex items-start gap-3 hover:bg-blue-50/40 hover:border-blue-200 transition-colors">
                                <span class="iconify text-emerald-600 text-lg mt-0.5 shrink-0" data-icon="heroicons:check-circle"></span>
                                <div>
                                    <span class="text-xs font-mono font-bold text-gray-900 block">{{ $key }}</span>
                                    <span class="text-xs text-gray-500">{{ $description }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                <!-- TAB 3: SECURITY & SESSIONS -->
                <div x-show="activeTab === 'security'" 
                     x-cloak 
                     x-transition:enter="transition ease-out duration-200" 
                     x-transition:enter-start="opacity-0 translate-y-1" 
                     x-transition:enter-end="opacity-100 translate-y-0" 
                     class="space-y-6">
                    
                    <!-- Security Settings & 2FA -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-base font-bold text-gray-900 mb-1">Security Posture</h3>
                        <p class="text-xs text-gray-500 mb-4">Authentication safeguards and multi-factor verification state.</p>

                        <div class="space-y-4">
                            <div class="p-4 rounded-xl border border-emerald-200 bg-emerald-50/50 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <span class="iconify text-2xl text-emerald-600" data-icon="heroicons:shield-check"></span>
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900">Two-Factor Authentication (2FA)</h4>
                                        <p class="text-xs text-gray-600">Hardware token / Authenticator app enabled and enforced.</p>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded border border-emerald-200">
                                    Enabled
                                </span>
                            </div>

                            <div class="p-4 rounded-xl border border-gray-200 bg-gray-50 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <span class="iconify text-2xl text-gray-600" data-icon="heroicons:key"></span>
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900">Password Policy</h4>
                                        <p class="text-xs text-gray-500">Last changed 45 days ago. Next rotation recommended in 45 days.</p>
                                    </div>
                                </div>
                                <button type="button" 
                                        @click="showForceResetModal = true" 
                                        class="px-3.5 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-xs font-semibold hover:bg-gray-100 transition-colors shadow-sm focus:outline-none">
                                    Force Reset
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Active Login Sessions -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Active Login Sessions</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Devices currently signed into this user account.</p>
                            </div>
                            <button type="button" 
                                    @click="revokeTarget = 'All other remote sessions'; showRevokeModal = true;" 
                                    class="text-xs text-rose-600 hover:text-rose-700 font-semibold hover:underline focus:outline-none">
                                Terminate All Other Sessions
                            </button>
                        </div>

                        <div class="space-y-3">
                            @foreach($user->active_sessions as $session)
                            <div class="p-4 rounded-xl border {{ $session->is_current ? 'border-blue-200 bg-blue-50/40' : 'border-gray-200 bg-gray-50/50' }} flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg {{ $session->is_current ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-700' }} flex items-center justify-center">
                                        <span class="iconify text-xl" data-icon="{{ str_contains($session->device, 'iPhone') ? 'heroicons:device-phone-mobile' : 'heroicons:computer-desktop' }}"></span>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-bold text-gray-900">{{ $session->device }}</span>
                                            @if($session->is_current)
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-primary border border-blue-200 uppercase">
                                                This Device
                                            </span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-500 flex items-center gap-2 mt-0.5">
                                            <span>IP: {{ $session->ip }}</span>
                                            <span>•</span>
                                            <span>{{ $session->location }}</span>
                                            <span>•</span>
                                            <span>{{ $session->last_active }}</span>
                                        </div>
                                    </div>
                                </div>

                                @if(!$session->is_current)
                                <button type="button" 
                                        @click="revokeTarget = '{{ $session->device }} ({{ $session->ip }})'; showRevokeModal = true;" 
                                        class="text-xs text-gray-500 hover:text-rose-600 font-medium px-2.5 py-1 rounded border border-gray-200 hover:border-rose-200 bg-white transition-colors self-end sm:self-center focus:outline-none">
                                    Revoke
                                </button>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                <!-- TAB 4: ACTIVITY AUDIT -->
                <div x-show="activeTab === 'activity'" 
                     x-cloak 
                     x-transition:enter="transition ease-out duration-200" 
                     x-transition:enter-start="opacity-0 translate-y-1" 
                     x-transition:enter-end="opacity-100 translate-y-0" 
                     class="space-y-6">
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-6">
                            <div>
                                <h3 class="text-base font-bold text-gray-900">User Activity Timeline</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Audit log of system events initiated by this user.</p>
                            </div>
                            <a href="{{ route('users.logs.index') }}" class="text-xs text-primary hover:underline font-semibold flex items-center gap-1">
                                Full Audit Log <span class="iconify" data-icon="heroicons:arrow-top-right-on-square"></span>
                            </a>
                        </div>

                        <!-- Timeline Layout -->
                        <div class="relative pl-6 space-y-6 before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-gray-200">
                            @foreach($user->recent_activities as $activity)
                            <div class="relative group">
                                <!-- Timeline Bullet Dot -->
                                <div class="absolute -left-6 top-0 w-6 h-6 rounded-full bg-white border-2 border-primary flex items-center justify-center">
                                    <span class="w-2 h-2 rounded-full bg-primary"></span>
                                </div>

                                <!-- Activity Item Content -->
                                <div class="bg-gray-50/70 border border-gray-200/80 rounded-xl p-4 hover:bg-blue-50/30 hover:border-blue-200 transition-colors">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 mb-1">
                                        <h4 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                                            <span class="iconify text-base text-primary" data-icon="{{ $activity->icon }}"></span>
                                            {{ $activity->action }}
                                        </h4>
                                        <span class="text-xs text-gray-400 font-medium">{{ $activity->time }}</span>
                                    </div>
                                    <p class="text-xs text-gray-600 mb-2">{{ $activity->description }}</p>
                                    <div class="flex items-center gap-2 text-[11px] text-gray-400 font-mono">
                                        <span class="iconify" data-icon="heroicons:globe-alt"></span>
                                        <span>IP: {{ $activity->ip }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- ========================================================================= -->
        <!-- MODAL 1: RESET PASSWORD CONFIRMATION (ALPINE.JS)                          -->
        <!-- ========================================================================= -->
        <div x-show="showResetPassModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             role="dialog" 
             aria-modal="true">
            
            <div x-show="showResetPassModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm" 
                 @click="showResetPassModal = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="showResetPassModal" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-200">
                    
                    <div class="bg-white p-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-blue-100 text-primary flex items-center justify-center shrink-0">
                                <span class="iconify text-2xl" data-icon="heroicons:key"></span>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Send Password Reset Link</h3>
                                <p class="text-sm text-gray-500 mt-1.5">
                                    Generate a secure token and send the password recovery email to <strong class="text-gray-900">{{ $user->email }}</strong>?
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-3.5 flex flex-row-reverse gap-2 border-t border-gray-100">
                        <button type="button" 
                                @click="showResetPassModal = false; triggerToast('Password recovery link dispatched to {{ $user->email }} (Mockup).')" 
                                class="inline-flex justify-center rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-600 transition-colors focus:ring-2 focus:ring-offset-1 focus:ring-primary">
                            Send Reset Email
                        </button>
                        <button type="button" 
                                @click="showResetPassModal = false" 
                                class="inline-flex justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- MODAL 2: IMPERSONATE USER CONFIRMATION (ALPINE.JS)                        -->
        <!-- ========================================================================= -->
        <div x-show="showImpersonateModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             role="dialog" 
             aria-modal="true">
            
            <div x-show="showImpersonateModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm" 
                 @click="showImpersonateModal = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="showImpersonateModal" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-200">
                    
                    <div class="bg-white p-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                                <span class="iconify text-2xl" data-icon="heroicons:arrow-path-rounded-square"></span>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Impersonate Account Session</h3>
                                <p class="text-sm text-gray-500 mt-1.5">
                                    You will temporarily log in as <strong class="text-gray-900">{{ $user->name }}</strong> with their role privileges (<span class="font-semibold text-purple-700">{{ $user->role }}</span>). An audit trail record will be registered.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-3.5 flex flex-row-reverse gap-2 border-t border-gray-100">
                        <button type="button" 
                                @click="showImpersonateModal = false; triggerToast('Now impersonating session for {{ $user->name }} (Mockup).')" 
                                class="inline-flex justify-center rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-amber-500 transition-colors focus:ring-2 focus:ring-offset-1 focus:ring-amber-500">
                            Start Impersonation
                        </button>
                        <button type="button" 
                                @click="showImpersonateModal = false" 
                                class="inline-flex justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- MODAL 3: FORCE PASSWORD RESET CONFIRMATION (ALPINE.JS)                    -->
        <!-- ========================================================================= -->
        <div x-show="showForceResetModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             role="dialog" 
             aria-modal="true">
            
            <div x-show="showForceResetModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm" 
                 @click="showForceResetModal = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="showForceResetModal" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-200">
                    
                    <div class="bg-white p-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-blue-100 text-primary flex items-center justify-center shrink-0">
                                <span class="iconify text-2xl" data-icon="heroicons:shield-exclamation"></span>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Enforce Password Rotation</h3>
                                <p class="text-sm text-gray-500 mt-1.5">
                                    Flag account for mandatory password update. The user will be prompted to set a new password on their very next sign-in.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-3.5 flex flex-row-reverse gap-2 border-t border-gray-100">
                        <button type="button" 
                                @click="showForceResetModal = false; triggerToast('Mandatory password reset flag enabled for {{ $user->name }} (Mockup).')" 
                                class="inline-flex justify-center rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-600 transition-colors focus:ring-2 focus:ring-offset-1 focus:ring-primary">
                            Enforce on Next Login
                        </button>
                        <button type="button" 
                                @click="showForceResetModal = false" 
                                class="inline-flex justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- MODAL 4: REVOKE SESSION CONFIRMATION (ALPINE.JS)                          -->
        <!-- ========================================================================= -->
        <div x-show="showRevokeModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             role="dialog" 
             aria-modal="true">
            
            <div x-show="showRevokeModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm" 
                 @click="showRevokeModal = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="showRevokeModal" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-200">
                    
                    <div class="bg-white p-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                                <span class="iconify text-2xl" data-icon="heroicons:arrow-right-on-rectangle"></span>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Revoke Active Session</h3>
                                <p class="text-sm text-gray-500 mt-1.5">
                                    Terminate active session for <strong class="text-gray-900" x-text="revokeTarget"></strong>? The device will be immediately disconnected.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-3.5 flex flex-row-reverse gap-2 border-t border-gray-100">
                        <button type="button" 
                                @click="showRevokeModal = false; triggerToast('Session successfully terminated for ' + revokeTarget + ' (Mockup).')" 
                                class="inline-flex justify-center rounded-lg bg-rose-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 transition-colors focus:ring-2 focus:ring-offset-1 focus:ring-rose-500">
                            Confirm Revoke
                        </button>
                        <button type="button" 
                                @click="showRevokeModal = false" 
                                class="inline-flex justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- MODAL 5: DELETE USER CONFIRMATION (ALPINE.JS)                             -->
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
                 class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm" 
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
                                        Are you sure you want to delete user <span class="font-semibold text-gray-900">{{ $user->name }}</span> (ID #{{ $user->id }})? All associated records and session data will be permanently removed. This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-3.5 sm:flex sm:flex-row-reverse sm:px-6 gap-2 border-t border-gray-100">
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
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
