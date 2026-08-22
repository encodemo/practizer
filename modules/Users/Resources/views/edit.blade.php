<x-admin::layouts.master>
    <div x-data="{
            name: '{{ $user->name }}',
            email: '{{ $user->email }}',
            username: '{{ $user->username }}',
            selectedRole: '{{ $user->role }}',
            isActive: {{ $user->status === 'Aktif' ? 'true' : 'false' }},
            enforce2FA: {{ $user->two_factor_enabled ? 'true' : 'false' }},
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
                    <a href="{{ route('users.show', $user->id) }}" class="hover:text-primary transition-colors">{{ $user->name }}</a>
                    <span class="iconify text-xs text-gray-400" data-icon="heroicons:chevron-right"></span>
                    <span class="text-gray-800 font-semibold">Edit</span>
                </nav>
                
                <h1 class="text-2xl font-bold text-gray-900">Edit User: {{ $user->name }}</h1>
                <p class="text-sm text-gray-500 mt-0.5">Update profile information, access roles, and account security parameters.</p>
            </div>

            <!-- Top Action Buttons -->
            <div class="flex items-center gap-2">
                <a href="{{ route('users.show', $user->id) }}" 
                   class="inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm focus:ring-2 focus:ring-offset-1 focus:ring-gray-300">
                    <span class="iconify text-base" data-icon="heroicons:arrow-left"></span>
                    <span>View Profile</span>
                </a>

                <button type="button" 
                        onclick="document.getElementById('edit-user-form').submit()" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-blue-600 transition-all shadow-sm focus:ring-2 focus:ring-offset-1 focus:ring-primary">
                    <span class="iconify text-base" data-icon="heroicons:check"></span>
                    <span>Update User</span>
                </button>
            </div>
        </div>

        <!-- MAIN FORM -->
        <form id="edit-user-form" action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

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
                                           value="{{ $user->name }}"
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
                                           value="{{ $user->username }}"
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
                                           value="{{ $user->email }}"
                                           required
                                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                                </div>
                            </div>

                            <!-- New Password (Optional) -->
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        New Password <span class="text-gray-400 font-normal lowercase">(optional)</span>
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
                                           placeholder="Leave blank to keep current" 
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
                                    Confirm New Password
                                </label>
                                <div class="relative">
                                    <span class="iconify absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg" data-icon="heroicons:shield-check"></span>
                                    <input :type="showPasswordConfirm ? 'text' : 'password'" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           x-model="passwordConfirmation"
                                           placeholder="Confirm new password" 
                                           class="w-full pl-10 pr-10 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all font-mono">
                                    <button type="button" 
                                            @click="showPasswordConfirm = !showPasswordConfirm" 
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                                        <span class="iconify text-lg" :data-icon="showPasswordConfirm ? 'heroicons:eye-slash' : 'heroicons:eye'"></span>
                                    </button>
                                </div>
                            </div>
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
                                           value="{{ $user->phone }}"
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
                                        <option value="Asia/Jakarta" selected>Asia/Jakarta (WIB) GMT+7</option>
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
                                          class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">{{ $user->address }}</textarea>
                            </div>

                            <!-- Bio / Notes -->
                            <div class="sm:col-span-2">
                                <label for="bio" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Bio / Notes</label>
                                <textarea id="bio" 
                                          name="bio" 
                                          rows="3" 
                                          class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">{{ $user->bio }}</textarea>
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
                                    <img :src="'https://ui-avatars.com/api/?name=' + encodeURIComponent(name) + '&background=1e293b&color=ffffff&size=128&bold=true'" 
                                         alt="{{ $user->name }}" 
                                         class="w-28 h-28 rounded-2xl object-cover border-2 border-gray-200 shadow-sm bg-gray-100">
                                </template>
                                
                                <label for="avatar-upload" class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center cursor-pointer shadow-md hover:bg-blue-600 transition-colors" title="Change Photo">
                                    <span class="iconify text-base" data-icon="heroicons:camera"></span>
                                    <input type="file" id="avatar-upload" name="avatar" accept="image/*" @change="handleAvatar" class="hidden">
                                </label>
                            </div>

                            <p class="text-xs text-gray-500 font-medium">PNG, JPG, or GIF up to 2MB</p>
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
                                    @foreach($departments as $dept)
                                    <option value="{{ $dept }}" {{ $user->department === $dept ? 'selected' : '' }}>{{ $dept }}</option>
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
                                   value="{{ $user->position }}"
                                   class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                        </div>

                        <!-- User Group -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">User Groups</label>
                            <div class="space-y-1.5 max-h-36 overflow-y-auto pr-1">
                                @foreach($groups as $grp)
                                <label class="flex items-center gap-2 p-2 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 transition-colors">
                                    <input type="checkbox" name="groups[]" value="{{ $grp->id }}" class="rounded border-gray-300 text-primary focus:ring-primary" checked>
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
                                <span class="text-[11px] text-gray-500" x-text="isActive ? 'Account is active' : 'Account is suspended'"></span>
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
                                <span class="text-xs font-bold text-gray-900 block">Two-Factor Authentication</span>
                                <span class="text-[11px] text-gray-500">Require MFA for sign in</span>
                            </div>
                            <button type="button" 
                                    @click="enforce2FA = !enforce2FA" 
                                    :class="enforce2FA ? 'bg-primary' : 'bg-gray-200'"
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                <span :class="enforce2FA ? 'translate-x-5' : 'translate-x-0'"
                                      class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                            <input type="hidden" name="two_factor_enabled" :value="enforce2FA ? '1' : '0'">
                        </div>
                    </div>

                </div>

            </div>

            <!-- STICKY BOTTOM FORM ACTIONS BAR -->
            <div class="mt-8 bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs text-gray-500 flex items-center gap-1.5">
                    <span class="iconify text-base text-gray-400" data-icon="heroicons:information-circle"></span>
                    <span>Editing User ID <span class="font-mono font-bold text-gray-800">#{{ $user->id }}</span></span>
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <a href="{{ route('users.show', $user->id) }}" 
                       class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors text-center w-full sm:w-auto">
                        Cancel
                    </a>

                    <button type="submit" 
                            class="inline-flex items-center justify-center gap-2 px-5 py-2 bg-primary text-white rounded-lg text-sm font-semibold hover:bg-blue-600 transition-colors shadow-sm focus:ring-2 focus:ring-offset-2 focus:ring-primary w-full sm:w-auto">
                        <span class="iconify text-base" data-icon="heroicons:check"></span>
                        Save Changes
                    </button>
                </div>
            </div>

        </form>

    </div>
</x-admin::layouts.master>

