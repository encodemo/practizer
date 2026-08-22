<x-admin::layouts.master>
    <div class="space-y-6 max-w-7xl mx-auto">
        
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
                    <span class="text-gray-800 font-semibold">Security & Access</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">Security & Authentication Settings</h1>
                <p class="text-sm text-gray-500 mt-0.5">Enforce organizational password complexity, brute-force mitigation, session timeouts, and 2FA policies.</p>
            </div>

            <!-- Top Save Button -->
            <button type="button" 
                    onclick="document.getElementById('security-settings-form').submit()" 
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-blue-600 transition-all shadow-sm focus:ring-2 focus:ring-offset-1 focus:ring-primary shrink-0">
                <span class="iconify text-lg" data-icon="heroicons:check"></span>
                <span>Save Security Policies</span>
            </button>
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
        <x-settings::settings-nav active="security" />

        <!-- MAIN FORM WRAPPER -->
        <form id="security-settings-form" action="{{ route('settings.security.update') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-6">

                <!-- LEFT COLUMN: PASSWORD POLICIES & RATE LIMITING (8 COLS) -->
                <div class="lg:col-span-8 space-y-6">

                    <!-- CARD 1: PASSWORD COMPLEXITY POLICY -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-5">
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Password Complexity & Expiration</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Rules applied when users create or reset credentials.</p>
                            </div>
                            <span class="iconify text-2xl text-primary" data-icon="heroicons:key"></span>
                        </div>

                        <div class="space-y-5">
                            <!-- Min Length & Expiry -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="password_min_length" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        Minimum Password Length
                                    </label>
                                    <div class="flex items-center gap-3">
                                        <input type="number" 
                                               name="password_min_length" 
                                               id="password_min_length" 
                                               min="6" 
                                               max="32" 
                                               value="{{ $security['password_min_length'] }}" 
                                               class="w-24 px-3 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary font-bold text-center">
                                        <span class="text-xs text-gray-500">Characters (Min. 8 recommended)</span>
                                    </div>
                                </div>

                                <div>
                                    <label for="password_expiry_days" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        Password Rotation Period
                                    </label>
                                    <div class="flex items-center gap-3">
                                        <input type="number" 
                                               name="password_expiry_days" 
                                               id="password_expiry_days" 
                                               min="0" 
                                               step="30" 
                                               value="{{ $security['password_expiry_days'] }}" 
                                               class="w-24 px-3 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary font-bold text-center">
                                        <span class="text-xs text-gray-500">Days (0 to disable expiry)</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Character Rules Checkboxes -->
                            <div class="pt-3 border-t border-gray-100">
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">
                                    Enforced Complexity Requirements
                                </label>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <label class="flex items-start gap-2.5 p-3 rounded-lg border border-gray-200 bg-gray-50/60 hover:bg-blue-50/40 transition-colors cursor-pointer">
                                        <input type="checkbox" name="require_uppercase" value="1" {{ $security['require_uppercase'] ? 'checked' : '' }} class="mt-0.5 rounded border-gray-300 text-primary focus:ring-primary">
                                        <div>
                                            <span class="text-xs font-bold text-gray-900 block">Uppercase (A-Z)</span>
                                            <span class="text-[11px] text-gray-500">At least one uppercase</span>
                                        </div>
                                    </label>

                                    <label class="flex items-start gap-2.5 p-3 rounded-lg border border-gray-200 bg-gray-50/60 hover:bg-blue-50/40 transition-colors cursor-pointer">
                                        <input type="checkbox" name="require_numeric" value="1" {{ $security['require_numeric'] ? 'checked' : '' }} class="mt-0.5 rounded border-gray-300 text-primary focus:ring-primary">
                                        <div>
                                            <span class="text-xs font-bold text-gray-900 block">Numbers (0-9)</span>
                                            <span class="text-[11px] text-gray-500">At least one digit</span>
                                        </div>
                                    </label>

                                    <label class="flex items-start gap-2.5 p-3 rounded-lg border border-gray-200 bg-gray-50/60 hover:bg-blue-50/40 transition-colors cursor-pointer">
                                        <input type="checkbox" name="require_special_char" value="1" {{ $security['require_special_char'] ? 'checked' : '' }} class="mt-0.5 rounded border-gray-300 text-primary focus:ring-primary">
                                        <div>
                                            <span class="text-xs font-bold text-gray-900 block">Symbols (!@#$)</span>
                                            <span class="text-[11px] text-gray-500">At least one special char</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 2: SESSION & BRUTE FORCE LOCKOUT -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-5">
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Session & Brute-Force Protection</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Control inactivity timeouts and mitigate automated password attacks.</p>
                            </div>
                            <span class="iconify text-2xl text-primary" data-icon="heroicons:shield-exclamation"></span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <!-- Session Timeout -->
                            <div>
                                <label for="session_lifetime" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Inactivity Timeout
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           name="session_lifetime" 
                                           id="session_lifetime" 
                                           value="{{ $security['session_lifetime'] }}" 
                                           class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary font-bold">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">Minutes</span>
                                </div>
                            </div>

                            <!-- Max Failed Attempts -->
                            <div>
                                <label for="max_login_attempts" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Max Failed Attempts
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           name="max_login_attempts" 
                                           id="max_login_attempts" 
                                           value="{{ $security['max_login_attempts'] }}" 
                                           class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary font-bold">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">Tries</span>
                                </div>
                            </div>

                            <!-- Lockout Duration -->
                            <div>
                                <label for="lockout_duration" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Lockout Duration
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           name="lockout_duration" 
                                           id="lockout_duration" 
                                           value="{{ $security['lockout_duration'] }}" 
                                           class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary font-bold">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">Minutes</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN: 2FA & IP RESTRICTION (4 COLS) -->
                <div class="lg:col-span-4 space-y-6">

                    <!-- CARD 1: TWO-FACTOR AUTHENTICATION (2FA) -->
                    <div x-data="{ enable2fa: {{ $security['enable_2fa'] ? 'true' : 'false' }}, enforceAdmin: {{ $security['enforce_admin_2fa'] ? 'true' : 'false' }} }" 
                         class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 space-y-4">
                        
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                            <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider">Two-Factor Auth (2FA)</h3>
                            <span class="iconify text-lg text-emerald-600" data-icon="heroicons:qr-code"></span>
                        </div>

                        <!-- 2FA Global Toggle -->
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-xs font-bold text-gray-900 block" x-text="enable2fa ? '2FA Enabled' : '2FA Disabled'"></span>
                                <span class="text-[11px] text-gray-500">TOTP (Google Auth, Authy)</span>
                            </div>
                            <button type="button" 
                                    @click="enable2fa = !enable2fa" 
                                    :class="enable2fa ? 'bg-primary' : 'bg-gray-200'"
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                <span :class="enable2fa ? 'translate-x-5' : 'translate-x-0'"
                                      class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                            <input type="hidden" name="enable_2fa" :value="enable2fa ? '1' : '0'">
                        </div>

                        <!-- Enforce for Super Admin -->
                        <div x-show="enable2fa" class="pt-3 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-bold text-gray-800 block">Enforce for Admins</span>
                                <span class="text-[11px] text-gray-500">Mandatory on admin login</span>
                            </div>
                            <button type="button" 
                                    @click="enforceAdmin = !enforceAdmin" 
                                    :class="enforceAdmin ? 'bg-emerald-600' : 'bg-gray-200'"
                                    class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                <span :class="enforceAdmin ? 'translate-x-4' : 'translate-x-0'"
                                      class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                            <input type="hidden" name="enforce_admin_2fa" :value="enforceAdmin ? '1' : '0'">
                        </div>
                    </div>

                    <!-- CARD 2: IP WHITELIST / RESTRICTION -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 space-y-3">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                            <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider">Admin IP Whitelist</h3>
                            <span class="iconify text-lg text-primary" data-icon="heroicons:lock-closed"></span>
                        </div>

                        <p class="text-[11px] text-gray-500 leading-relaxed">
                            Specify authorized IPv4/IPv6 addresses or CIDR subnets allowed to reach the admin dashboard. Leave empty to allow all IP addresses.
                        </p>

                        <textarea name="ip_whitelist" 
                                  id="ip_whitelist" 
                                  rows="4" 
                                  placeholder="127.0.0.1&#10;192.168.1.0/24"
                                  class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary font-mono text-gray-800">{{ $security['ip_whitelist'] }}</textarea>
                    </div>

                </div>

            </div>

            <!-- STICKY BOTTOM ACTIONS BAR -->
            <div class="mt-8 bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs text-gray-500 flex items-center gap-1.5">
                    <span class="iconify text-base text-gray-400" data-icon="heroicons:shield-check"></span>
                    <span>Security changes will take effect immediately on next authentication token verification.</span>
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <button type="reset" 
                            class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors text-center w-full sm:w-auto">
                        Reset Defaults
                    </button>

                    <button type="submit" 
                            class="inline-flex items-center justify-center gap-2 px-5 py-2 bg-primary text-white rounded-lg text-sm font-semibold hover:bg-blue-600 transition-colors shadow-sm focus:ring-2 focus:ring-offset-2 focus:ring-primary w-full sm:w-auto">
                        <span class="iconify text-base" data-icon="heroicons:check"></span>
                        Save Security Policies
                    </button>
                </div>
            </div>

        </form>

    </div>
</x-admin::layouts.master>

