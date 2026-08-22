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
                    <span class="text-gray-800 font-semibold">General</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">General Settings</h1>
                <p class="text-sm text-gray-500 mt-0.5">Manage application profile, branding assets, regional timezone, and maintenance mode.</p>
            </div>

            <!-- Top Save Button -->
            <button type="button" 
                    onclick="document.getElementById('general-settings-form').submit()" 
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-blue-600 transition-all shadow-sm focus:ring-2 focus:ring-offset-1 focus:ring-primary shrink-0">
                <span class="iconify text-lg" data-icon="heroicons:check"></span>
                <span>Save General Settings</span>
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
        <x-settings::settings-nav active="general" />

        <!-- MAIN FORM WRAPPER -->
        <form id="general-settings-form" action="{{ route('settings.general.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-6">

                <!-- LEFT COLUMN: APP IDENTITY & LOCALIZATION (8 COLS) -->
                <div class="lg:col-span-8 space-y-6">

                    <!-- CARD 1: APPLICATION IDENTITY -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-5">
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Application Identity</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Basic profile and meta details displayed across the platform.</p>
                            </div>
                            <span class="iconify text-2xl text-primary" data-icon="heroicons:identification"></span>
                        </div>

                        <div class="space-y-5">
                            <!-- App Name & Tagline -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="app_name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        Application Name <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="app_name" 
                                           id="app_name" 
                                           value="{{ $settings['app_name'] }}" 
                                           class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all font-medium" 
                                           required>
                                </div>
                                <div>
                                    <label for="app_tagline" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        Tagline / Slogan
                                    </label>
                                    <input type="text" 
                                           name="app_tagline" 
                                           id="app_tagline" 
                                           value="{{ $settings['app_tagline'] }}" 
                                           class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                                </div>
                            </div>

                            <!-- App URL & Admin Email -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="app_url" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        App URL Endpoint
                                    </label>
                                    <div class="relative">
                                        <span class="iconify absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-base" data-icon="heroicons:globe-alt"></span>
                                        <input type="url" 
                                               name="app_url" 
                                               id="app_url" 
                                               value="{{ $settings['app_url'] }}" 
                                               class="w-full pl-10 pr-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all font-mono text-xs">
                                    </div>
                                </div>
                                <div>
                                    <label for="admin_email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        System Contact Email <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="iconify absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-base" data-icon="heroicons:envelope"></span>
                                        <input type="email" 
                                               name="admin_email" 
                                               id="admin_email" 
                                               value="{{ $settings['admin_email'] }}" 
                                               class="w-full pl-10 pr-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all font-medium" 
                                               required>
                                    </div>
                                </div>
                            </div>

                            <!-- App Description -->
                            <div>
                                <label for="app_description" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Meta Description (SEO & Header)
                                </label>
                                <textarea name="app_description" 
                                          id="app_description" 
                                          rows="3" 
                                          class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">{{ $settings['app_description'] }}</textarea>
                            </div>

                            <!-- Copyright Text -->
                            <div>
                                <label for="copyright_text" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Footer Copyright Text
                                </label>
                                <input type="text" 
                                       name="copyright_text" 
                                       id="copyright_text" 
                                       value="{{ $settings['copyright_text'] }}" 
                                       class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                            </div>
                        </div>
                    </div>

                    <!-- CARD 2: REGIONAL & LOCALIZATION -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-5">
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Regional & Localization</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Date formatting, system timezone, currency symbols, and default language.</p>
                            </div>
                            <span class="iconify text-2xl text-primary" data-icon="heroicons:language"></span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            
                            <!-- Timezone -->
                            <div>
                                <label for="timezone" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    System Timezone
                                </label>
                                <div class="relative">
                                    <span class="iconify absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-base" data-icon="heroicons:clock"></span>
                                    <select name="timezone" id="timezone" class="w-full pl-10 pr-8 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all appearance-none font-medium text-gray-800">
                                        <option value="Asia/Jakarta" selected>Asia/Jakarta (WIB - UTC+7)</option>
                                        <option value="Asia/Makassar">Asia/Makassar (WITA - UTC+8)</option>
                                        <option value="Asia/Jayapura">Asia/Jayapura (WIT - UTC+9)</option>
                                        <option value="Asia/Singapore">Asia/Singapore (SGT - UTC+8)</option>
                                        <option value="UTC">UTC (Coordinated Universal Time)</option>
                                    </select>
                                    <span class="iconify absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-base pointer-events-none" data-icon="heroicons:chevron-down"></span>
                                </div>
                            </div>

                            <!-- Default Language -->
                            <div>
                                <label for="default_language" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Default Locale / Language
                                </label>
                                <div class="relative">
                                    <span class="iconify absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-base" data-icon="heroicons:globe-americas"></span>
                                    <select name="default_language" id="default_language" class="w-full pl-10 pr-8 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all appearance-none font-medium text-gray-800">
                                        <option value="id" selected>Bahasa Indonesia (ID)</option>
                                        <option value="en">English (US)</option>
                                    </select>
                                    <span class="iconify absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-base pointer-events-none" data-icon="heroicons:chevron-down"></span>
                                </div>
                            </div>

                            <!-- Date Format -->
                            <div>
                                <label for="date_format" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Date Format
                                </label>
                                <select name="date_format" id="date_format" class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all font-medium text-gray-800">
                                    <option value="d M Y" selected>22 Aug 2026 (d M Y)</option>
                                    <option value="Y-m-d">2026-08-22 (Y-m-d ISO)</option>
                                    <option value="d/m/Y">22/08/2026 (d/m/Y)</option>
                                    <option value="m/d/Y">08/22/2026 (m/d/Y)</option>
                                </select>
                            </div>

                            <!-- Default Currency -->
                            <div>
                                <label for="currency" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Currency Symbol
                                </label>
                                <select name="currency" id="currency" class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all font-medium text-gray-800">
                                    <option value="IDR" selected>IDR - Indonesian Rupiah (Rp)</option>
                                    <option value="USD">USD - US Dollar ($)</option>
                                    <option value="EUR">EUR - Euro (€)</option>
                                    <option value="SGD">SGD - Singapore Dollar (S$)</option>
                                </select>
                            </div>

                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN: BRANDING & MAINTENANCE (4 COLS) -->
                <div class="lg:col-span-4 space-y-6">

                    <!-- CARD 1: BRANDING & LOGO ASSETS -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 space-y-4">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                            <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider">Logo & Assets</h3>
                            <span class="iconify text-lg text-primary" data-icon="heroicons:photo"></span>
                        </div>

                        <!-- Brand Logo -->
                        <div class="space-y-2">
                            <label class="block text-xs font-semibold text-gray-600">Application Logo</label>
                            <div class="flex items-center gap-4 p-3 bg-gray-50 border border-dashed border-gray-300 rounded-xl hover:border-primary transition-colors cursor-pointer text-center">
                                <div class="w-12 h-12 bg-white rounded-lg shadow-sm border border-gray-200 flex items-center justify-center text-primary shrink-0">
                                    <span class="iconify text-2xl" data-icon="heroicons:bolt-solid"></span>
                                </div>
                                <div class="text-left text-xs">
                                    <span class="font-bold text-gray-800 block">logo_brand.svg</span>
                                    <span class="text-gray-400">PNG, SVG, JPG up to 2MB</span>
                                </div>
                            </div>
                        </div>

                        <!-- Favicon -->
                        <div class="space-y-2 pt-2 border-t border-gray-100">
                            <label class="block text-xs font-semibold text-gray-600">Browser Favicon</label>
                            <div class="flex items-center gap-3 p-2.5 bg-gray-50 border border-gray-200 rounded-lg">
                                <div class="w-8 h-8 bg-white rounded flex items-center justify-center border border-gray-200 text-primary">
                                    <span class="iconify text-lg" data-icon="heroicons:bolt-solid"></span>
                                </div>
                                <div class="text-xs">
                                    <span class="font-medium text-gray-700 block">favicon.ico (32x32)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 2: MAINTENANCE MODE TOGGLE -->
                    <div x-data="{ isMaintenance: {{ $settings['maintenance_mode'] ? 'true' : 'false' }} }" 
                         class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 space-y-4">
                        
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                            <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider">Maintenance Mode</h3>
                            <span class="iconify text-lg text-amber-500" data-icon="heroicons:wrench-screwdriver"></span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-xs font-bold text-gray-900 block" x-text="isMaintenance ? 'Mode: ACTIVE' : 'Mode: OFF'"></span>
                                <span class="text-[11px] text-gray-500">Block public access for updates</span>
                            </div>
                            <button type="button" 
                                    @click="isMaintenance = !isMaintenance" 
                                    :class="isMaintenance ? 'bg-amber-500' : 'bg-gray-200'"
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                <span :class="isMaintenance ? 'translate-x-5' : 'translate-x-0'"
                                      class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                            <input type="hidden" name="maintenance_mode" :value="isMaintenance ? '1' : '0'">
                        </div>

                        <!-- Maintenance Notice Text -->
                        <div x-show="isMaintenance" x-cloak class="pt-2">
                            <label for="maintenance_message" class="block text-xs font-bold text-amber-800 uppercase tracking-wider mb-1">
                                Public Maintenance Notice
                            </label>
                            <textarea name="maintenance_message" 
                                      id="maintenance_message" 
                                      rows="2" 
                                      class="w-full px-3 py-2 text-xs bg-amber-50 border border-amber-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-amber-500 text-amber-900">{{ $settings['maintenance_message'] }}</textarea>
                        </div>
                    </div>

                </div>

            </div>

            <!-- STICKY BOTTOM ACTIONS BAR -->
            <div class="mt-8 bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs text-gray-500 flex items-center gap-1.5">
                    <span class="iconify text-base text-gray-400" data-icon="heroicons:information-circle"></span>
                    <span>Modifications to general configuration will apply globally to all users.</span>
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <button type="reset" 
                            class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors text-center w-full sm:w-auto">
                        Reset Changes
                    </button>

                    <button type="submit" 
                            class="inline-flex items-center justify-center gap-2 px-5 py-2 bg-primary text-white rounded-lg text-sm font-semibold hover:bg-blue-600 transition-colors shadow-sm focus:ring-2 focus:ring-offset-2 focus:ring-primary w-full sm:w-auto">
                        <span class="iconify text-base" data-icon="heroicons:check"></span>
                        Save General Settings
                    </button>
                </div>
            </div>

        </form>

    </div>
</x-admin::layouts.master>

