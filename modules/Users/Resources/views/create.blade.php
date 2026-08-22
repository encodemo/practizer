<x-admin::layouts.master>
    <div x-data="{
            name: '',
            email: '',
            username: '',
            selectedRole: 'Admin',
            isActive: true,
            enforce2FA: false,
            sendEmailInvite: true,
            showPassword: false,
            showPasswordConfirm: false,
            password: '',
            passwordConfirmation: '',
            avatarPreview: null,
            handleAvatar(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => this.avatarPreview = e.target.result;
                    reader.readAsDataURL(file);
                }
            },
            generatePassword() {
                const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+';
                let pass = '';
                for (let i = 0; i < 14; i++) {
                    pass += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                this.password = pass;
                this.passwordConfirmation = pass;
                this.showPassword = true;
            },
            autoUsername() {
                if (!this.username && this.name) {
                    this.username = this.name.toLowerCase().replace(/[^a-z0-9]/g, '.');
                }
            }
         }" 
         class="space-y-6 max-w-7xl mx-auto">

        <!-- BREADCRUMBS & TOP ACTIONS HEADER -->
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
                    <span class="text-gray-800 font-semibold">Create User</span>
                </nav>
                
                <h1 class="text-2xl font-bold text-gray-900">Create New User</h1>
                <p class="text-sm text-gray-500 mt-0.5">Provision a new account with credentials, role assignments, and department data.</p>
            </div>

            <!-- Top Action Buttons -->
            <div class="flex items-center gap-2">
                <a href="{{ route('users.index') }}" 
                   class="inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm focus:ring-2 focus:ring-offset-1 focus:ring-gray-300">
                    <span class="iconify text-base" data-icon="heroicons:x-mark"></span>
                    <span>Cancel</span>
                </a>

                <button type="button" 
                        onclick="document.getElementById('create-user-form').submit()" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-blue-600 transition-all shadow-sm focus:ring-2 focus:ring-offset-1 focus:ring-primary">
                    <span class="iconify text-base" data-icon="heroicons:check"></span>
                    <span>Save User</span>
                </button>
            </div>
        </div>

        <!-- MAIN FORM -->
        <form id="create-user-form" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- LEFT COLUMN: PRIMARY INPUTS (8 COLS) -->
                <div class="lg:col-span-8 space-y-6">

                    <!-- CARD 1: ACCOUNT CREDENTIALS & IDENTITY -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-5">
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Account Credentials</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Basic authentication credentials and unique identifiers.</p>
                            </div>
                            <span class="iconify text-2xl text-primary" data-icon="heroicons:user-circle"></span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <!-- Full Name -->
                            <div class="sm:col-span-2">
                                <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Full Name <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="iconify absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg" data-icon="heroicons:user"></span>
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           x-model="name"
                                           @blur="autoUsername()"
                                           placeholder="e.g. Johnathan Doe" 
                                           required
                                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                                </div>
                            </div>

                            <!-- Username -->
                            <div>
                                <label for="username" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Username <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative flex rounded-lg shadow-sm">
                                    <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-100 text-gray-500 text-sm font-mono">
                                        @
                                    </span>
                                    <input type="text" 
                                           id="username" 
                                           name="username" 
                                           x-model="username"
                                           placeholder="johndoe" 
                                           required
                                           class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-r-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                                </div>
                            </div>

                            <!-- Email Address -->
                            <div>
                                <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Email Address <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="iconify absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg" data-icon="heroicons:envelope"></span>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           x-model="email"
                                           placeholder="john@example.com" 
                                           required
                                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                                </div>
                            </div>

                            <!-- Password -->
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Password <span class="text-rose-500">*</span>
                                    </label>
                                    <button type="button" 
                                            @click="generatePassword()" 
                                            class="text-[11px] text-primary hover:underline font-semibold flex items-center gap-1">
                                        <span class="iconify text-xs" data-icon="heroicons:sparkles"></span>
                                        Generate
                                    </button>
                                </div>
                                <div class="relative">
                                    <span class="iconify absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg" data-icon="heroicons:lock-closed"></span>
                                    <input :type="showPassword ? 'text' : 'password'" 
                                           id="password" 
                                           name="password" 
                                           x-model="password"
                                           placeholder="••••••••••••" 
                                           required
                                           class="w-full pl-10 pr-10 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all font-mono">
                                    <button type="button" 
                                            @click="showPassword = !showPassword" 
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                                        <span class="iconify text-lg" :data-icon="showPassword ? 'heroicons:eye-slash' : 'heroicons:eye'"></span>
                                    </button>
                                </div>
                            </div>

                            <!-- Password Confirmation -->
                            <div>
                                <label for="password_confirmation" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Confirm Password <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="iconify absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg" data-icon="heroicons:shield-check"></span>
                                    <input :type="showPasswordConfirm ? 'text' : 'password'" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           x-model="passwordConfirmation"
                                           placeholder="••••••••••••" 
                                           required
                                           class="w-full pl-10 pr-10 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all font-mono">
                                    <button type="button" 
                                            @click="showPasswordConfirm = !showPasswordConfirm" 
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                                        <span class="iconify text-lg" :data-icon="showPasswordConfirm ? 'heroicons:eye-slash' : 'heroicons:eye'"></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Password Match Hint -->
                        <div x-show="password && passwordConfirmation" x-cloak class="mt-3">
                            <template x-if="password === passwordConfirmation">
                                <span class="inline-flex items-center gap-1.5 text-xs text-emerald-600 font-semibold">
                                    <span class="iconify text-base" data-icon="heroicons:check-circle"></span>
                                    Passwords match!
                                </span>
                            </template>
                            <template x-if="password !== passwordConfirmation">
                                <span class="inline-flex items-center gap-1.5 text-xs text-rose-600 font-semibold">
                                    <span class="iconify text-base" data-icon="heroicons:x-circle"></span>
                                    Passwords do not match
                                </span>
                            </template>
                        </div>
                    </div>

                    <!-- CARD 2: PROFILE & CONTACT DETAILS -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-5">
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Personal & Contact Info</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Telephone, address, and profile background information.</p>
                            </div>
                            <span class="iconify text-2xl text-primary" data-icon="heroicons:phone"></span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Phone Number</label>
                                <div class="relative">
                                    <span class="iconify absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg" data-icon="heroicons:phone"></span>
                                    <input type="text" 
                                           id="phone" 
                                           name="phone" 
                                           placeholder="+62 812-3456-7890" 
                                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                                </div>
                            </div>

                            <!-- Timezone -->
                            <div>
                                <label for="timezone" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Timezone</label>
                                <div class="relative">
                                    <span class="iconify absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg" data-icon="heroicons:clock"></span>
                                    <select id="timezone" 
                                            name="timezone" 
                                            class="w-full pl-10 pr-8 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all appearance-none">
                                        <option value="Asia/Jakarta">Asia/Jakarta (WIB) GMT+7</option>
                                        <option value="Asia/Makassar">Asia/Makassar (WITA) GMT+8</option>
                                        <option value="Asia/Jayapura">Asia/Jayapura (WIT) GMT+9</option>
                                        <option value="UTC">UTC (Coordinated Universal Time)</option>
                                    </select>
                                    <span class="iconify absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none" data-icon="heroicons:chevron-down"></span>
                                </div>
                            </div>

                            <!-- Physical Address -->
                            <div class="sm:col-span-2">
                                <label for="address" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Physical Address</label>
                                <textarea id="address" 
                                          name="address" 
                                          rows="2" 
                                          placeholder="Street name, building, city, postal code..."
                                          class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all"></textarea>
                            </div>

                            <!-- Bio / Notes -->
                            <div class="sm:col-span-2">
                                <label for="bio" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Bio / Notes</label>
                                <textarea id="bio" 
                                          name="bio" 
                                          rows="3" 
                                          placeholder="Short bio or internal administrator notes regarding this user..."
                                          class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 3: DIRECT PERMISSIONS ACCORDION (OPTIONAL OVERRIDES) -->
                    <div x-data="{ openPermissions: false }" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <button type="button" 
                                @click="openPermissions = !openPermissions" 
                                class="w-full p-6 flex items-center justify-between text-left hover:bg-gray-50/70 transition-colors focus:outline-none">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-50 text-primary flex items-center justify-center">
                                    <span class="iconify text-xl" data-icon="heroicons:key"></span>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-gray-900">Direct Permissions (Optional)</h3>
                                    <p class="text-xs text-gray-500 mt-0.5">Customize individual access rights beyond standard role privileges.</p>
                                </div>
                            </div>
                            <span class="iconify text-xl text-gray-400 transform transition-transform duration-200" 
                                  :class="openPermissions ? 'rotate-180' : ''" 
                                  data-icon="heroicons:chevron-down"></span>
                        </button>

                        <div x-show="openPermissions" x-cloak x-collapse class="border-t border-gray-100 p-6 bg-gray-50/50 space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @php
                                    $permissionsList = [
                                        'users.view' => 'View Users List & Profile Info',
                                        'users.create' => 'Create & Register New Users',
                                        'users.edit' => 'Edit User Data & Passwords',
                                        'users.delete' => 'Delete & Suspend Accounts',
                                        'roles.manage' => 'Manage RBAC Matrix & Roles',
                                        'settings.general' => 'Edit App Config & Logos',
                                        'settings.security' => 'Manage Security & 2FA Rules',
                                        'audit.logs.view' => 'Access System Audit Trail Logs'
                                    ];
                                @endphp

                                @foreach($permissionsList as $permKey => $permLabel)
                                <label class="flex items-start gap-3 p-3 bg-white border border-gray-200 rounded-lg cursor-pointer hover:border-primary/50 transition-colors">
                                    <input type="checkbox" name="permissions[]" value="{{ $permKey }}" class="mt-0.5 rounded border-gray-300 text-primary focus:ring-primary">
                                    <div>
                                        <span class="text-xs font-mono font-bold text-gray-800 block">{{ $permKey }}</span>
                                        <span class="text-[11px] text-gray-500 leading-tight">{{ $permLabel }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN: ROLES, AVATAR & METADATA (4 COLS) -->
                <div class="lg:col-span-4 space-y-6">

                    <!-- CARD 1: AVATAR UPLOAD & LIVE PREVIEW -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Profile Photo</h3>
                        
                        <div class="flex flex-col items-center justify-center text-center">
                            <!-- Avatar Preview Container -->
                            <div class="relative mb-4 group">
                                <template x-if="avatarPreview">
                                    <img :src="avatarPreview" alt="Avatar Preview" class="w-28 h-28 rounded-2xl object-cover border-2 border-primary shadow-sm">
                                </template>
                                <template x-if="!avatarPreview">
                                    <img :src="'https://ui-avatars.com/api/?name=' + encodeURIComponent(name || 'New User') + '&background=0284c7&color=ffffff&size=128&bold=true'" 
                                         alt="Avatar Placeholder" 
                                         class="w-28 h-28 rounded-2xl object-cover border-2 border-gray-200 shadow-sm bg-gray-100">
                                </template>
                                
                                <label for="avatar-upload" class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center cursor-pointer shadow-md hover:bg-blue-600 transition-colors" title="Upload Photo">
                                    <span class="iconify text-base" data-icon="heroicons:camera"></span>
                                    <input type="file" id="avatar-upload" name="avatar" accept="image/*" @change="handleAvatar" class="hidden">
                                </label>
                            </div>

                            <p class="text-xs text-gray-500 font-medium">PNG, JPG, or GIF up to 2MB</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">Auto-generates initial avatar if left empty.</p>
                        </div>
                    </div>

                    <!-- CARD 2: ROLE SELECTION (FILAMENT RADIO CARDS) -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Role & Access Tier</h3>
                            <span class="text-rose-500 text-xs">*</span>
                        </div>

                        <div class="space-y-2.5">
                            @foreach($roles as $role)
                            <label class="block p-3.5 rounded-xl border cursor-pointer transition-all relative"
                                   :class="selectedRole === '{{ $role->name }}' ? 'border-primary bg-blue-50/40 ring-1 ring-primary' : 'border-gray-200 hover:border-gray-300 bg-white'">
                                <div class="flex items-center justify-between mb-1">
                                    <div class="flex items-center gap-2">
                                        <input type="radio" 
                                               name="role" 
                                               value="{{ $role->name }}" 
                                               x-model="selectedRole" 
                                               class="text-primary focus:ring-primary">
                                        <span class="text-sm font-bold text-gray-900">{{ $role->name }}</span>
                                    </div>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold border {{ $role->badge }}">
                                        {{ $role->name }}
                                    </span>
                                </div>
                                <p class="text-[11px] text-gray-500 pl-6 leading-normal">
                                    {{ $role->description }}
                                </p>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- CARD 3: ORGANIZATIONAL ASSIGNMENT -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 space-y-4">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Workplace Info</h3>

                        <!-- Department -->
                        <div>
                            <label for="department" class="block text-xs font-semibold text-gray-700 mb-1">Department</label>
                            <div class="relative">
                                <select id="department" 
                                        name="department" 
                                        class="w-full pl-3 pr-8 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all appearance-none">
                                    <option value="">-- Select Department --</option>
                                    @foreach($departments as $dept)
                                    <option value="{{ $dept }}" {{ $loop->first ? 'selected' : '' }}>{{ $dept }}</option>
                                    @endforeach
                                </select>
                                <span class="iconify absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-base pointer-events-none" data-icon="heroicons:chevron-down"></span>
                            </div>
                        </div>

                        <!-- Job Title / Position -->
                        <div>
                            <label for="position" class="block text-xs font-semibold text-gray-700 mb-1">Job Designation / Title</label>
                            <input type="text" 
                                   id="position" 
                                   name="position" 
                                   placeholder="e.g. Lead Engineer" 
                                   class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                        </div>

                        <!-- User Group -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">User Groups</label>
                            <div class="space-y-1.5 max-h-36 overflow-y-auto pr-1">
                                @foreach($groups as $grp)
                                <label class="flex items-center gap-2 p-2 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 transition-colors">
                                    <input type="checkbox" name="groups[]" value="{{ $grp->id }}" class="rounded border-gray-300 text-primary focus:ring-primary" {{ $loop->first ? 'checked' : '' }}>
                                    <span class="text-xs font-medium text-gray-800">{{ $grp->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- CARD 4: STATUS & SECURITY POLICIES -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 space-y-4">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Account Settings</h3>

                        <!-- Account Status Toggle -->
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-xs font-bold text-gray-900 block">Account Status</span>
                                <span class="text-[11px] text-gray-500" x-text="isActive ? 'Account is active & enabled' : 'Account will be disabled'"></span>
                            </div>
                            <button type="button" 
                                    @click="isActive = !isActive" 
                                    :class="isActive ? 'bg-primary' : 'bg-gray-200'"
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                <span :class="isActive ? 'translate-x-5' : 'translate-x-0'"
                                      class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                            <input type="hidden" name="status" :value="isActive ? 'Aktif' : 'Nonaktif'">
                        </div>

                        <hr class="border-gray-100">

                        <!-- Enforce 2FA Toggle -->
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-xs font-bold text-gray-900 block">Enforce 2FA</span>
                                <span class="text-[11px] text-gray-500">Require MFA on first login</span>
                            </div>
                            <button type="button" 
                                    @click="enforce2FA = !enforce2FA" 
                                    :class="enforce2FA ? 'bg-primary' : 'bg-gray-200'"
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                <span :class="enforce2FA ? 'translate-x-5' : 'translate-x-0'"
                                      class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                            <input type="hidden" name="enforce_2fa" :value="enforce2FA ? '1' : '0'">
                        </div>

                        <hr class="border-gray-100">

                        <!-- Send Email Invitation Checkbox -->
                        <label class="flex items-start gap-2.5 cursor-pointer">
                            <input type="checkbox" name="send_invite" x-model="sendEmailInvite" class="mt-0.5 rounded border-gray-300 text-primary focus:ring-primary">
                            <div>
                                <span class="text-xs font-bold text-gray-900 block">Send Email Invitation</span>
                                <span class="text-[11px] text-gray-500">Dispatch welcome email with initial password setup link.</span>
                            </div>
                        </label>
                    </div>

                </div>

            </div>

            <!-- STICKY BOTTOM FORM ACTIONS BAR -->
            <div class="mt-8 bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs text-gray-500 flex items-center gap-1.5">
                    <span class="iconify text-base text-gray-400" data-icon="heroicons:information-circle"></span>
                    <span>Fields marked with <span class="text-rose-500 font-bold">*</span> are required.</span>
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <a href="{{ route('users.index') }}" 
                       class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors text-center w-full sm:w-auto">
                        Cancel
                    </a>

                    <button type="submit" 
                            name="action" 
                            value="save_and_create_another" 
                            class="px-4 py-2 bg-slate-100 border border-slate-300 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-200 transition-colors text-center w-full sm:w-auto">
                        Save & Create Another
                    </button>

                    <button type="submit" 
                            class="inline-flex items-center justify-center gap-2 px-5 py-2 bg-primary text-white rounded-lg text-sm font-semibold hover:bg-blue-600 transition-colors shadow-sm focus:ring-2 focus:ring-offset-2 focus:ring-primary w-full sm:w-auto">
                        <span class="iconify text-base" data-icon="heroicons:check"></span>
                        Save User
                    </button>
                </div>
            </div>

        </form>

    </div>
</x-admin::layouts.master>

