<x-admin::layouts.master>
    <div x-data="{
            showTestMailModal: false,
            testEmailRecipient: 'admin@practizer.id',
            showPassword: false
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
                    <span class="text-gray-800 font-semibold">Mail Server</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">Mail & SMTP Server Settings</h1>
                <p class="text-sm text-gray-500 mt-0.5">Configure outbound email transport, SMTP relay credentials, sender identity, and test connectivity.</p>
            </div>

            <!-- Top Actions -->
            <div class="flex items-center gap-2">
                <button type="button" 
                        @click="showTestMailModal = true" 
                        class="inline-flex items-center gap-2 px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm focus:ring-2 focus:ring-offset-1 focus:ring-gray-300">
                    <span class="iconify text-lg text-primary" data-icon="heroicons:paper-airplane"></span>
                    <span>Send Test Email</span>
                </button>

                <button type="button" 
                        onclick="document.getElementById('mail-settings-form').submit()" 
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-blue-600 transition-all shadow-sm focus:ring-2 focus:ring-offset-1 focus:ring-primary shrink-0">
                    <span class="iconify text-lg" data-icon="heroicons:check"></span>
                    <span>Save Mail Settings</span>
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
        <x-settings::settings-nav active="mail" />

        <!-- MAIN FORM WRAPPER -->
        <form id="mail-settings-form" action="{{ route('settings.mail.update') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-6">

                <!-- LEFT COLUMN: SMTP SERVER & SENDER PROFILE (8 COLS) -->
                <div class="lg:col-span-8 space-y-6">

                    <!-- CARD 1: SMTP CONNECTION PARAMS -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-5">
                            <div>
                                <h3 class="text-base font-bold text-gray-900">SMTP Transport Configuration</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Relay server connection details and port authentication.</p>
                            </div>
                            <span class="iconify text-2xl text-primary" data-icon="heroicons:envelope"></span>
                        </div>

                        <div class="space-y-5">
                            <!-- Mail Driver -->
                            <div>
                                <label for="mail_driver" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Mail Transport Driver <span class="text-rose-500">*</span>
                                </label>
                                <select name="mail_driver" id="mail_driver" class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary font-medium text-gray-800">
                                    <option value="smtp" selected>SMTP (Standard Mail Server Relay)</option>
                                    <option value="mailgun">Mailgun API</option>
                                    <option value="ses">Amazon SES</option>
                                    <option value="postmark">Postmark</option>
                                    <option value="log">Local Log File (Testing / Dev)</option>
                                </select>
                            </div>

                            <!-- Host & Port -->
                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                                <div class="sm:col-span-8">
                                    <label for="mail_host" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        SMTP Host Server <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="iconify absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-base" data-icon="heroicons:server"></span>
                                        <input type="text" 
                                               name="mail_host" 
                                               id="mail_host" 
                                               value="{{ $mail['mail_host'] }}" 
                                               placeholder="e.g. smtp.mailtrap.io or smtp.gmail.com" 
                                               class="w-full pl-10 pr-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary font-mono text-xs" 
                                               required>
                                    </div>
                                </div>

                                <div class="sm:col-span-4">
                                    <label for="mail_port" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        Port <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="number" 
                                           name="mail_port" 
                                           id="mail_port" 
                                           value="{{ $mail['mail_port'] }}" 
                                           placeholder="587" 
                                           class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary font-mono text-xs font-bold text-center" 
                                           required>
                                </div>
                            </div>

                            <!-- Username & Password -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="mail_username" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        SMTP Username
                                    </label>
                                    <div class="relative">
                                        <span class="iconify absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-base" data-icon="heroicons:user"></span>
                                        <input type="text" 
                                               name="mail_username" 
                                               id="mail_username" 
                                               value="{{ $mail['mail_username'] }}" 
                                               class="w-full pl-10 pr-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary font-mono text-xs">
                                    </div>
                                </div>

                                <div>
                                    <label for="mail_password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        SMTP Password
                                    </label>
                                    <div class="relative">
                                        <span class="iconify absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-base" data-icon="heroicons:lock-closed"></span>
                                        <input :type="showPassword ? 'text' : 'password'" 
                                               name="mail_password" 
                                               id="mail_password" 
                                               value="{{ $mail['mail_password'] }}" 
                                               class="w-full pl-10 pr-10 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary font-mono text-xs">
                                        <button type="button" 
                                                @click="showPassword = !showPassword" 
                                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                                            <span class="iconify text-base" :data-icon="showPassword ? 'heroicons:eye-slash' : 'heroicons:eye'"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Encryption -->
                            <div>
                                <label for="mail_encryption" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Encryption Protocol
                                </label>
                                <div class="grid grid-cols-3 gap-3">
                                    <label class="flex items-center gap-2 p-3 rounded-lg border border-gray-200 bg-gray-50/60 cursor-pointer">
                                        <input type="radio" name="mail_encryption" value="tls" {{ $mail['mail_encryption'] === 'tls' ? 'checked' : '' }} class="text-primary focus:ring-primary">
                                        <span class="text-xs font-bold text-gray-800">TLS (587)</span>
                                    </label>
                                    <label class="flex items-center gap-2 p-3 rounded-lg border border-gray-200 bg-gray-50/60 cursor-pointer">
                                        <input type="radio" name="mail_encryption" value="ssl" {{ $mail['mail_encryption'] === 'ssl' ? 'checked' : '' }} class="text-primary focus:ring-primary">
                                        <span class="text-xs font-bold text-gray-800">SSL (465)</span>
                                    </label>
                                    <label class="flex items-center gap-2 p-3 rounded-lg border border-gray-200 bg-gray-50/60 cursor-pointer">
                                        <input type="radio" name="mail_encryption" value="null" {{ $mail['mail_encryption'] === 'null' ? 'checked' : '' }} class="text-primary focus:ring-primary">
                                        <span class="text-xs font-bold text-gray-800">None / Plain</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 2: SENDER IDENTITY & QUEUE -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-5">
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Sender Identity (From Address)</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Default envelope metadata shown to email recipients.</p>
                            </div>
                            <span class="iconify text-2xl text-primary" data-icon="heroicons:user-circle"></span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="mail_from_name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Sender Name <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" 
                                       name="mail_from_name" 
                                       id="mail_from_name" 
                                       value="{{ $mail['mail_from_name'] }}" 
                                       class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary font-medium" 
                                       required>
                            </div>

                            <div>
                                <label for="mail_from_address" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Sender Email Address <span class="text-rose-500">*</span>
                                </label>
                                <input type="email" 
                                       name="mail_from_address" 
                                       id="mail_from_address" 
                                       value="{{ $mail['mail_from_address'] }}" 
                                       class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary font-medium" 
                                       required>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN: STATUS & HELP (4 COLS) -->
                <div class="lg:col-span-4 space-y-6">

                    <!-- CARD 1: RELAY STATUS & TEST TRIGGER -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 space-y-4">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Connection Status</h3>

                        <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-200 flex items-center gap-3">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <div>
                                <span class="text-xs font-bold text-emerald-900 block">SMTP Server Connected</span>
                                <span class="text-[11px] text-emerald-700">Ready for transaction emails</span>
                            </div>
                        </div>

                        <button type="button" 
                                @click="showTestMailModal = true" 
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-50 text-primary border border-blue-200 rounded-lg text-xs font-bold hover:bg-blue-100 transition-colors shadow-sm focus:outline-none">
                            <span class="iconify text-base" data-icon="heroicons:paper-airplane"></span>
                            <span>Verify Connection (Send Test)</span>
                        </button>
                    </div>

                    <!-- CARD 2: CONFIG GUIDELINE -->
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 text-slate-700 text-xs space-y-2.5">
                        <div class="flex items-center gap-2 font-bold text-slate-900">
                            <span class="iconify text-lg text-amber-500" data-icon="heroicons:information-circle"></span>
                            <span>Email Delivery Note</span>
                        </div>
                        <p class="leading-relaxed text-[11px] text-slate-600">
                            For production setups, consider utilizing dedicated transactional providers like AWS SES, Mailgun, or SendGrid to avoid deliverability and spam filtering issues.
                        </p>
                    </div>

                </div>

            </div>

            <!-- STICKY BOTTOM ACTIONS BAR -->
            <div class="mt-8 bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs text-gray-500 flex items-center gap-1.5">
                    <span class="iconify text-base text-gray-400" data-icon="heroicons:envelope"></span>
                    <span>Outbound emails (Password reset, activation, reports) use these transport configurations.</span>
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <button type="reset" 
                            class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors text-center w-full sm:w-auto">
                        Cancel
                    </button>

                    <button type="submit" 
                            class="inline-flex items-center justify-center gap-2 px-5 py-2 bg-primary text-white rounded-lg text-sm font-semibold hover:bg-blue-600 transition-colors shadow-sm focus:ring-2 focus:ring-offset-2 focus:ring-primary w-full sm:w-auto">
                        <span class="iconify text-base" data-icon="heroicons:check"></span>
                        Save Mail Settings
                    </button>
                </div>
            </div>

        </form>

        <!-- ========================================================================= -->
        <!-- MODAL: SEND TEST EMAIL (ALPINE.JS)                                        -->
        <!-- ========================================================================= -->
        <div x-show="showTestMailModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
            
            <!-- Backdrop -->
            <div x-show="showTestMailModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
                 @click="showTestMailModal = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <!-- Modal Panel -->
                <div x-show="showTestMailModal" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-200">
                    
                    <form action="{{ route('settings.mail.test') }}" method="POST">
                        @csrf
                        
                        <div class="bg-white px-6 pb-6 pt-6 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10 text-primary">
                                    <span class="iconify text-2xl" data-icon="heroicons:paper-airplane"></span>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left flex-1">
                                    <h3 class="text-base font-bold leading-6 text-gray-900" id="modal-title">Test Outbound Email Transport</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500 mb-4">
                                            Send a sample diagnostic message using current SMTP parameters to verify handshake and TLS authentication.
                                        </p>
                                        
                                        <div>
                                            <label for="test_email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                                Recipient Email Address <span class="text-rose-500">*</span>
                                            </label>
                                            <input type="email" 
                                                   name="test_email" 
                                                   id="test_email" 
                                                   x-model="testEmailRecipient" 
                                                   class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary font-medium" 
                                                   required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-3.5 sm:flex sm:flex-row-reverse sm:px-6 gap-2 border-t border-gray-100">
                            <button type="submit" 
                                    class="inline-flex w-full justify-center rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-600 sm:w-auto transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                Send Test Email
                            </button>
                            <button type="button" 
                                    @click="showTestMailModal = false" 
                                    class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                                Cancel
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</x-admin::layouts.master>

