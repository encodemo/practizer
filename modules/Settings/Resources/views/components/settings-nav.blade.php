@props(['active' => 'general'])

<div class="border-b border-gray-200 bg-white rounded-t-xl px-4 pt-2 -mb-px">
    <nav class="flex space-x-2 sm:space-x-4 overflow-x-auto" aria-label="Settings Tabs">
        
        <!-- Tab 1: General -->
        <a href="{{ route('settings.general') }}" 
           class="inline-flex items-center gap-2 py-3 px-3 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap transition-colors {{ $active === 'general' ? 'border-primary text-primary font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <span class="iconify text-lg" data-icon="heroicons:adjustments-horizontal"></span>
            <span>General</span>
        </a>

        <!-- Tab 2: Security -->
        <a href="{{ route('settings.security') }}" 
           class="inline-flex items-center gap-2 py-3 px-3 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap transition-colors {{ $active === 'security' ? 'border-primary text-primary font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <span class="iconify text-lg" data-icon="heroicons:lock-closed"></span>
            <span>Security & Access</span>
        </a>

        <!-- Tab 3: Mail Server -->
        <a href="{{ route('settings.mail') }}" 
           class="inline-flex items-center gap-2 py-3 px-3 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap transition-colors {{ $active === 'mail' ? 'border-primary text-primary font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <span class="iconify text-lg" data-icon="heroicons:envelope"></span>
            <span>Mail Server (SMTP)</span>
        </a>

        <!-- Tab 4: Backup & DB -->
        <a href="{{ route('settings.backup') }}" 
           class="inline-flex items-center gap-2 py-3 px-3 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap transition-colors {{ $active === 'backup' ? 'border-primary text-primary font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <span class="iconify text-lg" data-icon="heroicons:circle-stack"></span>
            <span>Backup & Storage</span>
        </a>

        <!-- Tab 5: System Logs -->
        <a href="{{ route('settings.logs') }}" 
           class="inline-flex items-center gap-2 py-3 px-3 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap transition-colors {{ $active === 'logs' ? 'border-primary text-primary font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <span class="iconify text-lg" data-icon="heroicons:server-stack"></span>
            <span>System Logs & Health</span>
        </a>

    </nav>
</div>

