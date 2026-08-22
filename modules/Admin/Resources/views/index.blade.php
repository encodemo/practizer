<x-admin::layouts.master>
    <div x-data="{
            timeRange: '30d',
            selectedSection: 'all',
            liveTrafficInterval: null,
            liveTrafficValue: 1420
         }" 
         class="space-y-8 max-w-[1600px] mx-auto pb-12">
        
        <!-- ========================================================================= -->
        <!-- 0. PAGE HEADER & TIME-RANGE FILTER CONTROLS                               -->
        <!-- ========================================================================= -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <div>
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2 text-xs font-medium text-gray-500 mb-2">
                    <span class="flex items-center gap-1 text-primary font-semibold">
                        <span class="iconify text-sm" data-icon="heroicons:home"></span>
                        Admin Workspace
                    </span>
                    <span class="iconify text-xs text-gray-400" data-icon="heroicons:chevron-right"></span>
                    <span class="text-gray-800 font-bold">Executive Dashboard</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight flex items-center gap-3">
                    <span>Performance Analytics</span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-primary border border-blue-200">
                        <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                        Live Stream
                    </span>
                </h1>
                <p class="text-sm text-gray-500 mt-1">Multi-dimensional telemetry, financial metrics, and comprehensive column grid templates.</p>
            </div>

            <!-- Header Action Controls -->
            <div class="flex items-center gap-2.5 flex-wrap">
                <!-- Timeframe Pill Buttons -->
                <div class="inline-flex p-1 bg-gray-100 rounded-xl border border-gray-200 text-xs font-semibold">
                    <button type="button" 
                            @click="timeRange = 'today'" 
                            :class="timeRange === 'today' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-900'" 
                            class="px-3 py-1.5 rounded-lg transition-all">
                        Today
                    </button>
                    <button type="button" 
                            @click="timeRange = '7d'" 
                            :class="timeRange === '7d' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-900'" 
                            class="px-3 py-1.5 rounded-lg transition-all">
                        7 Days
                    </button>
                    <button type="button" 
                            @click="timeRange = '30d'" 
                            :class="timeRange === '30d' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-900'" 
                            class="px-3 py-1.5 rounded-lg transition-all">
                        30 Days
                    </button>
                    <button type="button" 
                            @click="timeRange = '1y'" 
                            :class="timeRange === '1y' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-900'" 
                            class="px-3 py-1.5 rounded-lg transition-all">
                        Year 2026
                    </button>
                </div>

                <!-- Export Report Action Button -->
                <a href="{{ route('users.logs.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl text-sm font-semibold hover:bg-blue-600 transition-all shadow-sm focus:ring-2 focus:ring-primary focus:outline-none">
                    <span class="iconify text-base" data-icon="heroicons:arrow-down-tray"></span>
                    <span>Download KPI</span>
                </a>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- 1. SECTION: 4 EQUAL COLUMNS (1 : 1 : 1 : 1) - TOP KEY PERFORMANCE CARDS   -->
        <!-- ========================================================================= -->
        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    <span>Layout Variant 1: 4 Equal Columns (1 : 1 : 1 : 1 Grid)</span>
                </h3>
                <span class="text-[11px] text-gray-400 font-mono">grid-cols-1 sm:grid-cols-2 lg:grid-cols-4</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                
                <!-- Card 1: Gross Revenue -->
                <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Gross Revenue</span>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-primary flex items-center justify-center border border-blue-100 group-hover:scale-110 transition-transform">
                            <span class="iconify text-2xl" data-icon="heroicons:currency-dollar"></span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between">
                        <div>
                            <h4 class="text-2xl sm:text-3xl font-extrabold text-gray-900">$128,450</h4>
                            <div class="flex items-center gap-1.5 mt-1.5">
                                <span class="inline-flex items-center gap-0.5 text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">
                                    <span class="iconify" data-icon="heroicons:arrow-trending-up"></span>
                                    +18.2%
                                </span>
                                <span class="text-[11px] text-gray-400">vs previous month</span>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
                </div>

                <!-- Card 2: Active User Base -->
                <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Active Users</span>
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 group-hover:scale-110 transition-transform">
                            <span class="iconify text-2xl" data-icon="heroicons:users"></span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between">
                        <div>
                            <h4 class="text-2xl sm:text-3xl font-extrabold text-gray-900">24,890</h4>
                            <div class="flex items-center gap-1.5 mt-1.5">
                                <span class="inline-flex items-center gap-0.5 text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">
                                    <span class="iconify" data-icon="heroicons:arrow-trending-up"></span>
                                    +8.4%
                                </span>
                                <span class="text-[11px] text-gray-400">2,140 online now</span>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-500"></div>
                </div>

                <!-- Card 3: Conversion Rate -->
                <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Conversion Rate</span>
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100 group-hover:scale-110 transition-transform">
                            <span class="iconify text-2xl" data-icon="heroicons:shopping-cart"></span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between">
                        <div>
                            <h4 class="text-2xl sm:text-3xl font-extrabold text-gray-900">4.85%</h4>
                            <div class="flex items-center gap-1.5 mt-1.5">
                                <span class="inline-flex items-center gap-0.5 text-xs font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">
                                    <span class="iconify" data-icon="heroicons:bolt"></span>
                                    +1.2%
                                </span>
                                <span class="text-[11px] text-gray-400">checkout ratio</span>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-500 to-orange-500"></div>
                </div>

                <!-- Card 4: Server Throughput -->
                <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">API Throughput</span>
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-100 group-hover:scale-110 transition-transform">
                            <span class="iconify text-2xl" data-icon="heroicons:server-stack"></span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between">
                        <div>
                            <h4 class="text-2xl sm:text-3xl font-extrabold text-gray-900">99.98%</h4>
                            <div class="flex items-center gap-1.5 mt-1.5">
                                <span class="inline-flex items-center gap-0.5 text-xs font-bold text-purple-600 bg-purple-50 px-2 py-0.5 rounded-md border border-purple-200">
                                    <span class="iconify" data-icon="heroicons:check-badge"></span>
                                    Healthy
                                </span>
                                <span class="text-[11px] text-gray-400">18ms avg latency</span>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-purple-500 to-pink-500"></div>
                </div>

            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- 2. SECTION: FULL-WIDTH COLUMN (1 COL) - MASTER PERFORMANCE GRADIENT AREA  -->
        <!-- ========================================================================= -->
        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    <span>Layout Variant 2: Full-Width Column (1 Col Master Span)</span>
                </h3>
                <span class="text-[11px] text-gray-400 font-mono">col-span-full w-full</span>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm space-y-6">
                <!-- Master Chart Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 pb-4">
                    <div>
                        <div class="flex items-center gap-2.5">
                            <div class="w-3 h-3 rounded-full bg-primary animate-ping"></div>
                            <h3 class="text-lg font-bold text-gray-900">Master Telemetry & Revenue Trajectory</h3>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Real-time cumulative gross volume vs compute transaction volume across all quarters.</p>
                    </div>
                    
                    <div class="flex items-center gap-4 text-xs font-semibold">
                        <div class="flex items-center gap-2 text-gray-700">
                            <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                            <span>Direct Revenue ($)</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-700">
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            <span>Platform Traffic (k)</span>
                        </div>
                    </div>
                </div>

                <!-- Canvas Wrapper -->
                <div class="relative h-80 sm:h-96 w-full">
                    <canvas id="canvasMasterArea"></canvas>
                </div>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- 3. SECTION: 3 EQUAL COLUMNS (1 : 1 : 1) - POLAR + DOUGHNUT + RADAR         -->
        <!-- ========================================================================= -->
        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                    <span>Layout Variant 3: 3 Equal Columns (1 : 1 : 1 Symmetrical Grid)</span>
                </h3>
                <span class="text-[11px] text-gray-400 font-mono">grid-cols-1 md:grid-cols-3</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Col 1: Polar Area Chart (Category Share) -->
                <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex flex-col justify-between">
                    <div class="border-b border-gray-100 pb-3 mb-4">
                        <h3 class="text-base font-bold text-gray-900">Resource Allocation</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Polar area distribution across 5 core modules.</p>
                    </div>

                    <div class="relative h-64 w-full flex items-center justify-center">
                        <canvas id="canvasPolar"></canvas>
                    </div>
                </div>

                <!-- Col 2: Multi-Segment Doughnut Chart (Traffic Channels) -->
                <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex flex-col justify-between">
                    <div class="border-b border-gray-100 pb-3 mb-4">
                        <h3 class="text-base font-bold text-gray-900">Inbound Acquisition</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Multi-channel traffic segmentation.</p>
                    </div>

                    <div class="relative h-64 w-full flex items-center justify-center">
                        <canvas id="canvasDoughnut"></canvas>
                    </div>
                </div>

                <!-- Col 3: Radar Chart (Platform Maturity Matrix) -->
                <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex flex-col justify-between">
                    <div class="border-b border-gray-100 pb-3 mb-4">
                        <h3 class="text-base font-bold text-gray-900">System Health Radar</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Security, Latency, Cache & Reliability index.</p>
                    </div>

                    <div class="relative h-64 w-full flex items-center justify-center">
                        <canvas id="canvasRadar"></canvas>
                    </div>
                </div>

            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- 4. SECTION: 4-COLUMN WIDTH (1 : 1 : 2) - UPTIME + CACHE + STACKED BARS     -->
        <!-- ========================================================================= -->
        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                    <span>Layout Variant 4: 4-Column Width (1 : 1 : 2 Right-Weighted Span)</span>
                </h3>
                <span class="text-[11px] text-gray-400 font-mono">lg:col-span-1, lg:col-span-1, lg:col-span-2</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                
                <!-- Col 1: Server Uptime Card -->
                <div class="lg:col-span-1 bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">System Uptime</span>
                            <span class="iconify text-xl text-emerald-600" data-icon="heroicons:server"></span>
                        </div>
                        <h4 class="text-2xl font-extrabold text-gray-900">99.99%</h4>
                        <p class="text-xs text-gray-500 mt-1">Continuous runtime without incident over 120 days.</p>
                    </div>

                    <div class="pt-4 border-t border-gray-100 text-xs flex justify-between font-mono">
                        <span class="text-gray-400">Last Reboot</span>
                        <span class="text-gray-800 font-bold">120d 14h ago</span>
                    </div>
                </div>

                <!-- Col 2: Cache Hit-Ratio Card -->
                <div class="lg:col-span-1 bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Redis Cache Hit</span>
                            <span class="iconify text-xl text-indigo-600" data-icon="heroicons:bolt"></span>
                        </div>
                        <h4 class="text-2xl font-extrabold text-gray-900">94.6%</h4>
                        <p class="text-xs text-gray-500 mt-1">High cache resolution efficiency reducing DB load.</p>
                    </div>

                    <div class="pt-4 border-t border-gray-100 text-xs flex justify-between font-mono">
                        <span class="text-gray-400">Cached Keys</span>
                        <span class="text-gray-800 font-bold">14,280 items</span>
                    </div>
                </div>

                <!-- Col 3 (Right 2): Stacked Grouped Bar Chart -->
                <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Quarterly Expense Breakdown (Stacked)</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Stacked breakdown across Infrastructure, Operations & Support.</p>
                        </div>
                        <span class="px-2 py-0.5 bg-blue-50 text-primary border border-blue-200 rounded text-xs font-bold">Stacked View</span>
                    </div>

                    <div class="relative h-56 w-full">
                        <canvas id="canvasStackedBars"></canvas>
                    </div>
                </div>

            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- 4. SECTION: 3-COLUMN WIDTH (2 : 1) - COMBO BAR-LINE + SYSTEM GAUGES       -->
        <!-- ========================================================================= -->
        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                    <span>Layout Variant 4: 3-Column Width (2 : 1 Asymmetric Layout)</span>
                </h3>
                <span class="text-[11px] text-gray-400 font-mono">lg:col-span-2 & lg:col-span-1</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Col-Span 2 (Left): Mixed Bar + Line Custom Chart -->
                <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Sales Volume vs Net Margin (Combo)</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Dual-axis composite combining discrete sales bars with profit trend line.</p>
                        </div>
                        <div class="flex items-center gap-3 text-xs font-semibold">
                            <span class="flex items-center gap-1 text-gray-600"><span class="w-3 h-3 rounded bg-slate-300"></span> Sales</span>
                            <span class="flex items-center gap-1 text-amber-600"><span class="w-3 h-3 rounded-full bg-amber-500"></span> Margin %</span>
                        </div>
                    </div>

                    <div class="relative h-72 w-full">
                        <canvas id="canvasMixedCombo"></canvas>
                    </div>
                </div>

                <!-- Col-Span 1 (Right): System Health & Quota Progress Gauges -->
                <div class="lg:col-span-1 bg-white rounded-2xl p-6 border border-gray-200 shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <h3 class="text-base font-bold text-gray-900">Infrastructure Quota</h3>
                        <span class="iconify text-xl text-primary" data-icon="heroicons:cpu-chip"></span>
                    </div>

                    <!-- CPU Meter -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between text-xs font-semibold">
                            <span class="text-gray-600">CPU Allocation (8 Cores)</span>
                            <span class="text-gray-900 font-mono">32.4%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-blue-500 h-2.5 rounded-full" style="width: 32.4%"></div>
                        </div>
                    </div>

                    <!-- Memory Meter -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between text-xs font-semibold">
                            <span class="text-gray-600">RAM Usage (32 GB)</span>
                            <span class="text-gray-900 font-mono">58.8%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-emerald-500 h-2.5 rounded-full" style="width: 58.8%"></div>
                        </div>
                    </div>

                    <!-- SSD Storage Meter -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between text-xs font-semibold">
                            <span class="text-gray-600">NVMe Disk Partition</span>
                            <span class="text-gray-900 font-mono">74.2%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-amber-500 h-2.5 rounded-full" style="width: 74.2%"></div>
                        </div>
                    </div>

                    <!-- Quick Status Box -->
                    <div class="p-3 bg-blue-50/60 rounded-xl border border-blue-100 flex items-center justify-between text-xs text-blue-900 mt-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="font-bold">PHP 8.2 Engine</span>
                        </div>
                        <span class="font-mono font-semibold text-primary">OPcache Active</span>
                    </div>
                </div>

            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- 3. SECTION: 2 EQUAL COLUMNS (1 : 1) - MULTI-COLOR BARS VS DUAL LINES      -->
        <!-- ========================================================================= -->
        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Layout Variant 3: 2 Equal Columns (1 : 1 Grid)</span>
                </h3>
                <span class="text-[11px] text-gray-400 font-mono">grid-cols-1 lg:grid-cols-2</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Col 1: 12-Month Multi-Color Bar Chart (Distinct Bar Colors) -->
                <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Monthly Performance Spectrum</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Individual color-mapped bars across 12 calendar months.</p>
                        </div>
                        <span class="px-2 py-1 rounded-md text-xs font-mono font-bold bg-blue-50 text-primary border border-blue-200">
                            12 Distinct Colors
                        </span>
                    </div>

                    <div class="relative h-72 w-full">
                        <canvas id="canvasVibrantBars"></canvas>
                    </div>
                </div>

                <!-- Col 2: Smooth Dual-Line Comparative Growth -->
                <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Annual Growth Comparison</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Smooth bezier trajectory: FY 2025 (Actual) vs FY 2026 (Target).</p>
                        </div>
                        <span class="px-2 py-1 rounded-md text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            +24.8% YoY
                        </span>
                    </div>

                    <div class="relative h-72 w-full">
                        <canvas id="canvasDualLines"></canvas>
                    </div>
                </div>

            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- 5. SECTION: 3-COLUMN WIDTH (1 : 2) - ACTIVITY FEED + MINI DATA TABLE      -->
        <!-- ========================================================================= -->
        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span>Layout Variant 5: 3-Column Width (1 : 2 Inverted Layout)</span>
                </h3>
                <span class="text-[11px] text-gray-400 font-mono">lg:col-span-1 & lg:col-span-2</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Col-Span 1 (Left): Live Audit Feed Timeline -->
                <div class="lg:col-span-1 bg-white rounded-2xl p-6 border border-gray-200 shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="iconify text-lg text-primary" data-icon="heroicons:clock"></span>
                            <h3 class="text-base font-bold text-gray-900">Live Activity Feed</h3>
                        </div>
                        <a href="{{ route('users.logs.index') }}" class="text-xs text-primary hover:underline font-semibold">View All</a>
                    </div>

                    <div class="space-y-3.5 text-xs">
                        <!-- Feed Item 1 -->
                        <div class="flex items-start gap-3 p-2.5 rounded-xl bg-gray-50/70 border border-gray-100">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 mt-1.5 shrink-0"></span>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-gray-800 truncate">Database Backup Verified</p>
                                <p class="text-gray-500 text-[11px]">System snapshot completed in 1.4s</p>
                                <span class="text-[10px] text-gray-400">2 mins ago</span>
                            </div>
                        </div>

                        <!-- Feed Item 2 -->
                        <div class="flex items-start gap-3 p-2.5 rounded-xl bg-gray-50/70 border border-gray-100">
                            <span class="w-2 h-2 rounded-full bg-blue-500 mt-1.5 shrink-0"></span>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-gray-800 truncate">Administrator Password Reset</p>
                                <p class="text-gray-500 text-[11px]">Security policy updated for user #1</p>
                                <span class="text-[10px] text-gray-400">18 mins ago</span>
                            </div>
                        </div>

                        <!-- Feed Item 3 -->
                        <div class="flex items-start gap-3 p-2.5 rounded-xl bg-gray-50/70 border border-gray-100">
                            <span class="w-2 h-2 rounded-full bg-purple-500 mt-1.5 shrink-0"></span>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-gray-800 truncate">Role Permission Synchronized</p>
                                <p class="text-gray-500 text-[11px]">8 matrix rights assigned to Manager</p>
                                <span class="text-[10px] text-gray-400">1 hour ago</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Col-Span 2 (Right): Interactive Recent Users / Transactions Table -->
                <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex flex-col justify-between">
                    <div>
                        <div class="p-5 border-b border-gray-200 flex items-center justify-between bg-white">
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Recent User Onboarding & Status</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Quick telemetry overview of newly activated team members.</p>
                            </div>
                            <a href="{{ route('users.index') }}" 
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 text-gray-700 rounded-lg text-xs font-semibold hover:bg-gray-100 border border-gray-200 transition-colors">
                                <span>Manage All</span>
                                <span class="iconify" data-icon="heroicons:chevron-right"></span>
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-600">
                                <thead class="bg-gray-50 text-gray-700 uppercase font-semibold text-xs border-b border-gray-200">
                                    <tr>
                                        <th class="px-5 py-3 whitespace-nowrap">Member</th>
                                        <th class="px-5 py-3 whitespace-nowrap">Role</th>
                                        <th class="px-5 py-3 whitespace-nowrap">Status</th>
                                        <th class="px-5 py-3 whitespace-nowrap text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <tr class="hover:bg-blue-50/40 transition-colors">
                                        <td class="px-5 py-3 whitespace-nowrap">
                                            <div class="flex items-center gap-2.5">
                                                <img src="https://ui-avatars.com/api/?name=Alexander+Wright&background=0284c7&color=fff&bold=true" class="w-8 h-8 rounded-full">
                                                <div>
                                                    <span class="font-bold text-gray-900 block text-xs">Alexander Wright</span>
                                                    <span class="text-[11px] text-gray-400">alex@practizer.id</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3 whitespace-nowrap text-xs">
                                            <span class="px-2 py-0.5 rounded bg-purple-50 text-purple-700 font-bold border border-purple-200 text-[10px]">Admin</span>
                                        </td>
                                        <td class="px-5 py-3 whitespace-nowrap text-xs">
                                            <span class="inline-flex items-center gap-1 text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded font-semibold text-[10px] border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                            </span>
                                        </td>
                                        <td class="px-5 py-3 whitespace-nowrap text-right text-xs">
                                            <a href="{{ route('users.show', 1) }}" class="text-primary hover:underline font-bold">Inspect</a>
                                        </td>
                                    </tr>

                                    <tr class="hover:bg-blue-50/40 transition-colors">
                                        <td class="px-5 py-3 whitespace-nowrap">
                                            <div class="flex items-center gap-2.5">
                                                <img src="https://ui-avatars.com/api/?name=Elena+Rostova&background=10b981&color=fff&bold=true" class="w-8 h-8 rounded-full">
                                                <div>
                                                    <span class="font-bold text-gray-900 block text-xs">Elena Rostova</span>
                                                    <span class="text-[11px] text-gray-400">elena@practizer.id</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3 whitespace-nowrap text-xs">
                                            <span class="px-2 py-0.5 rounded bg-blue-50 text-blue-700 font-bold border border-blue-200 text-[10px]">Editor</span>
                                        </td>
                                        <td class="px-5 py-3 whitespace-nowrap text-xs">
                                            <span class="inline-flex items-center gap-1 text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded font-semibold text-[10px] border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                            </span>
                                        </td>
                                        <td class="px-5 py-3 whitespace-nowrap text-right text-xs">
                                            <a href="{{ route('users.index') }}" class="text-primary hover:underline font-bold">Inspect</a>
                                        </td>
                                    </tr>

                                    <tr class="hover:bg-blue-50/40 transition-colors">
                                        <td class="px-5 py-3 whitespace-nowrap">
                                            <div class="flex items-center gap-2.5">
                                                <img src="https://ui-avatars.com/api/?name=David+Kim&background=f59e0b&color=fff&bold=true" class="w-8 h-8 rounded-full">
                                                <div>
                                                    <span class="font-bold text-gray-900 block text-xs">David Kim</span>
                                                    <span class="text-[11px] text-gray-400">david@practizer.id</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3 whitespace-nowrap text-xs">
                                            <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-700 font-bold border border-gray-200 text-[10px]">Member</span>
                                        </td>
                                        <td class="px-5 py-3 whitespace-nowrap text-xs">
                                            <span class="inline-flex items-center gap-1 text-rose-700 bg-rose-50 px-2 py-0.5 rounded font-semibold text-[10px] border border-rose-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Pending
                                            </span>
                                        </td>
                                        <td class="px-5 py-3 whitespace-nowrap text-right text-xs">
                                            <a href="{{ route('users.index') }}" class="text-primary hover:underline font-bold">Inspect</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="p-3 bg-gray-50 border-t border-gray-200 text-center text-xs text-gray-500">
                        Total 23 indexed users across 4 departments.
                    </div>
                </div>

            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- 7. SECTION: 4-COLUMN WIDTH (1 : 2 : 1) - QUICK TOOLS + BARS + TARGET RING -->
        <!-- ========================================================================= -->
        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                    <span>Layout Variant 7: 4-Column Width (1 : 2 : 1 Symmetric Center)</span>
                </h3>
                <span class="text-[11px] text-gray-400 font-mono">lg:col-span-1, lg:col-span-2, lg:col-span-1</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                
                <!-- Col 1 (Left 1): Quick Action Command Center -->
                <div class="lg:col-span-1 bg-white rounded-2xl p-6 border border-gray-200 shadow-sm space-y-3">
                    <div class="border-b border-gray-100 pb-3">
                        <h3 class="text-base font-bold text-gray-900">Command Center</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Quick administrative shortcuts.</p>
                    </div>

                    <div class="space-y-2">
                        <a href="{{ route('users.create') }}" 
                           class="w-full flex items-center gap-2.5 p-2.5 rounded-xl bg-gray-50 hover:bg-blue-50 text-gray-700 hover:text-primary font-bold text-xs border border-gray-200 transition-colors">
                            <span class="iconify text-base text-primary" data-icon="heroicons:user-plus"></span>
                            <span>Add New User</span>
                        </a>

                        <a href="{{ route('settings.backup') }}" 
                           class="w-full flex items-center gap-2.5 p-2.5 rounded-xl bg-gray-50 hover:bg-emerald-50 text-gray-700 hover:text-emerald-700 font-bold text-xs border border-gray-200 transition-colors">
                            <span class="iconify text-base text-emerald-600" data-icon="heroicons:circle-stack"></span>
                            <span>Create DB Backup</span>
                        </a>

                        <a href="{{ route('settings.mail') }}" 
                           class="w-full flex items-center gap-2.5 p-2.5 rounded-xl bg-gray-50 hover:bg-purple-50 text-gray-700 hover:text-purple-700 font-bold text-xs border border-gray-200 transition-colors">
                            <span class="iconify text-base text-purple-600" data-icon="heroicons:envelope"></span>
                            <span>SMTP Mail Server</span>
                        </a>

                        <a href="{{ route('settings.logs') }}" 
                           class="w-full flex items-center gap-2.5 p-2.5 rounded-xl bg-gray-50 hover:bg-amber-50 text-gray-700 hover:text-amber-700 font-bold text-xs border border-gray-200 transition-colors">
                            <span class="iconify text-base text-amber-600" data-icon="heroicons:command-line"></span>
                            <span>System Diagnostics</span>
                        </a>
                    </div>
                </div>

                <!-- Col 2 (Middle 2): Horizontal Multi-Color Bar Chart -->
                <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Module & Feature Engagement</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Horizontal colored bar ranking feature usage index.</p>
                        </div>
                        <span class="px-2 py-0.5 bg-gray-100 text-gray-700 rounded text-xs font-bold font-mono">Ranked</span>
                    </div>

                    <div class="relative h-64 w-full">
                        <canvas id="canvasHorizontalBars"></canvas>
                    </div>
                </div>

                <!-- Col 3 (Right 1): Monthly Milestone Progress Ring -->
                <div class="lg:col-span-1 bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex flex-col items-center justify-center text-center">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-3">
                        <span class="iconify text-2xl" data-icon="heroicons:trophy"></span>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900">Quarterly Target</h3>
                    <p class="text-xs text-gray-500 mb-4">Q3 Revenue & Growth Milestones</p>

                    <div class="relative w-32 h-32 flex items-center justify-center">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                            <path class="text-gray-100" stroke-width="3.8" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="text-primary" stroke-dasharray="78, 100" stroke-width="3.8" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <div class="absolute flex flex-col items-center">
                            <span class="text-2xl font-extrabold text-gray-900">78%</span>
                            <span class="text-[9px] font-bold text-gray-400 uppercase">Achieved</span>
                        </div>
                    </div>
                    
                    <span class="text-xs text-emerald-600 font-bold mt-3">$98k of $125k Goal</span>
                </div>

            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- 9. SECTION: 4-COLUMN WIDTH (2 : 1 : 1) - STEPPED AREA + COMPLIANCE + TEAM  -->
        <!-- ========================================================================= -->
        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-violet-500"></span>
                    <span>Layout Variant 9: 4-Column Width (2 : 1 : 1 Left-Weighted Span)</span>
                </h3>
                <span class="text-[11px] text-gray-400 font-mono">lg:col-span-2, lg:col-span-1, lg:col-span-1</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                
                <!-- Col 1 (Left 2): Stepped Area Traffic Burst Chart -->
                <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                        <div>
                            <h3 class="text-base font-bold text-gray-900">24-Hour Request Rate (Stepped Line)</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Discrete stepped visualization tracking API bursts per hour.</p>
                        </div>
                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded text-xs font-bold font-mono">1.4k req/sec</span>
                    </div>

                    <div class="relative h-56 w-full">
                        <canvas id="canvasSteppedArea"></canvas>
                    </div>
                </div>

                <!-- Col 2 (Middle 1): Security Compliance Scorecard -->
                <div class="lg:col-span-1 bg-white rounded-2xl p-6 border border-gray-200 shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <h3 class="text-sm font-bold text-gray-900">Compliance Audit</h3>
                        <span class="iconify text-lg text-emerald-600" data-icon="heroicons:shield-check"></span>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="text-3xl font-extrabold text-emerald-600">96<span class="text-sm text-gray-400">/100</span></div>
                        <div class="text-xs text-gray-500">Tier 1 Security Certified</div>
                    </div>

                    <div class="space-y-2 text-xs">
                        <div class="flex items-center gap-2 text-emerald-700">
                            <span class="iconify" data-icon="heroicons:check-circle"></span>
                            <span>2FA Enforced for Admins</span>
                        </div>
                        <div class="flex items-center gap-2 text-emerald-700">
                            <span class="iconify" data-icon="heroicons:check-circle"></span>
                            <span>Daily Encrypted Snapshots</span>
                        </div>
                        <div class="flex items-center gap-2 text-emerald-700">
                            <span class="iconify" data-icon="heroicons:check-circle"></span>
                            <span>Brute-Force Lockout Active</span>
                        </div>
                    </div>
                </div>

                <!-- Col 3 (Right 1): Active Operators / Team Roster -->
                <div class="lg:col-span-1 bg-white rounded-2xl p-6 border border-gray-200 shadow-sm space-y-3">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <h3 class="text-sm font-bold text-gray-900">Online Staff</h3>
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    </div>

                    <div class="space-y-2.5">
                        <div class="flex items-center gap-2.5">
                            <img src="https://ui-avatars.com/api/?name=Administrator&background=0284c7&color=fff&bold=true" class="w-7 h-7 rounded-full">
                            <div class="min-w-0 flex-1 text-xs">
                                <span class="font-bold text-gray-900 block truncate">Administrator</span>
                                <span class="text-[10px] text-gray-400">Super Admin</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2.5">
                            <img src="https://ui-avatars.com/api/?name=Sarah+Jenkins&background=10b981&color=fff&bold=true" class="w-7 h-7 rounded-full">
                            <div class="min-w-0 flex-1 text-xs">
                                <span class="font-bold text-gray-900 block truncate">Sarah Jenkins</span>
                                <span class="text-[10px] text-gray-400">DevOps Engineer</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2.5">
                            <img src="https://ui-avatars.com/api/?name=Michael+Chen&background=f59e0b&color=fff&bold=true" class="w-7 h-7 rounded-full">
                            <div class="min-w-0 flex-1 text-xs">
                                <span class="font-bold text-gray-900 block truncate">Michael Chen</span>
                                <span class="text-[10px] text-gray-400">Support Lead</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- ========================================================================= -->
    <!-- CHART.JS ADVANCED INITIALIZATION SCRIPT                                   -->
    <!-- ========================================================================= -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            
            // Global Chart Defaults
            Chart.defaults.font.family = "'Inter', system-ui, -apple-system, sans-serif";
            Chart.defaults.color = '#64748b'; // slate-500
            const softGrid = { color: '#f1f5f9', borderDash: [4, 4] }; // slate-100

            // Vibrant 12-Color Palette (Distinct per monthly bar)
            const vibrant12 = [
                '#ef4444', // 1. Red (Jan)
                '#f97316', // 2. Orange (Feb)
                '#f59e0b', // 3. Amber (Mar)
                '#84cc16', // 4. Lime (Apr)
                '#10b981', // 5. Emerald (May)
                '#14b8a6', // 6. Teal (Jun)
                '#06b6d4', // 7. Cyan (Jul)
                '#0284c7', // 8. Sky/Blue (Aug)
                '#3b82f6', // 9. Blue (Sep)
                '#6366f1', // 10. Indigo (Oct)
                '#8b5cf6', // 11. Violet (Nov)
                '#d946ef'  // 12. Fuchsia (Dec)
            ];

            // -------------------------------------------------------------
            // 1. MASTER FULL-WIDTH AREA GRADIENT CHART (canvasMasterArea)
            // -------------------------------------------------------------
            const ctxMaster = document.getElementById('canvasMasterArea');
            if (ctxMaster) {
                const masterGradient1 = ctxMaster.getContext('2d').createLinearGradient(0, 0, 0, 360);
                masterGradient1.addColorStop(0, 'rgba(59, 130, 246, 0.35)');
                masterGradient1.addColorStop(1, 'rgba(59, 130, 246, 0.00)');

                const masterGradient2 = ctxMaster.getContext('2d').createLinearGradient(0, 0, 0, 360);
                masterGradient2.addColorStop(0, 'rgba(16, 185, 129, 0.25)');
                masterGradient2.addColorStop(1, 'rgba(16, 185, 129, 0.00)');

                new Chart(ctxMaster, {
                    type: 'line',
                    data: {
                        labels: ['W1', 'W2', 'W3', 'W4', 'W5', 'W6', 'W7', 'W8', 'W9', 'W10', 'W11', 'W12', 'W13', 'W14', 'W15', 'W16'],
                        datasets: [
                            {
                                label: 'Revenue ($k)',
                                data: [35, 42, 38, 55, 62, 58, 72, 85, 78, 92, 105, 98, 115, 128, 120, 145],
                                borderColor: '#3b82f6',
                                borderWidth: 3,
                                backgroundColor: masterGradient1,
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#3b82f6',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6
                            },
                            {
                                label: 'Platform Traffic (k)',
                                data: [20, 28, 25, 38, 45, 40, 52, 60, 55, 68, 75, 70, 82, 90, 85, 102],
                                borderColor: '#10b981',
                                borderWidth: 2,
                                borderDash: [4, 4],
                                backgroundColor: masterGradient2,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 0
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#1e293b',
                                padding: 12,
                                titleFont: { size: 13, weight: 'bold' },
                                bodyFont: { size: 12 }
                            }
                        },
                        scales: {
                            y: { beginAtZero: true, grid: softGrid },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            // -------------------------------------------------------------
            // 2. VIBRANT 12-COLOR DISTINCT BARS (canvasVibrantBars)
            // -------------------------------------------------------------
            const ctxVibrant = document.getElementById('canvasVibrantBars');
            if (ctxVibrant) {
                new Chart(ctxVibrant, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                            label: 'Monthly Net ($k)',
                            data: [28, 35, 32, 45, 42, 58, 65, 72, 68, 82, 88, 95],
                            backgroundColor: vibrant12,
                            borderRadius: 6,
                            borderWidth: 0,
                            barPercentage: 0.7
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: { beginAtZero: true, grid: softGrid },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            // -------------------------------------------------------------
            // 3. DUAL-LINE ANNUAL COMPARISON (canvasDualLines)
            // -------------------------------------------------------------
            const ctxDualLines = document.getElementById('canvasDualLines');
            if (ctxDualLines) {
                new Chart(ctxDualLines, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [
                            {
                                label: 'FY 2026 Target',
                                data: [30, 40, 48, 55, 68, 75, 82, 90, 95, 105, 115, 125],
                                borderColor: '#10b981',
                                borderWidth: 3,
                                tension: 0.4,
                                pointBackgroundColor: '#10b981'
                            },
                            {
                                label: 'FY 2025 Actual',
                                data: [22, 28, 35, 42, 50, 56, 62, 68, 74, 80, 85, 92],
                                borderColor: '#94a3b8',
                                borderWidth: 2,
                                borderDash: [5, 5],
                                tension: 0.4,
                                pointRadius: 0
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { usePointStyle: true, boxWidth: 6, padding: 15 }
                            }
                        },
                        scales: {
                            y: { beginAtZero: true, grid: softGrid },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            // -------------------------------------------------------------
            // 4. MIXED COMBO BAR + LINE (canvasMixedCombo)
            // -------------------------------------------------------------
            const ctxMixed = document.getElementById('canvasMixedCombo');
            if (ctxMixed) {
                new Chart(ctxMixed, {
                    data: {
                        labels: ['Q1 Jan', 'Q1 Feb', 'Q1 Mar', 'Q2 Apr', 'Q2 May', 'Q2 Jun', 'Q3 Jul', 'Q3 Aug'],
                        datasets: [
                            {
                                type: 'line',
                                label: 'Profit Margin (%)',
                                data: [18, 22, 20, 26, 28, 25, 31, 34],
                                borderColor: '#f59e0b',
                                borderWidth: 3,
                                tension: 0.3,
                                yAxisID: 'y1',
                                pointBackgroundColor: '#fff',
                                pointBorderColor: '#f59e0b',
                                pointBorderWidth: 2
                            },
                            {
                                type: 'bar',
                                label: 'Gross Volume ($k)',
                                data: [45, 58, 52, 68, 74, 70, 85, 94],
                                backgroundColor: '#93c5fd', // blue-300
                                borderRadius: 5,
                                yAxisID: 'y'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom', labels: { usePointStyle: true } }
                        },
                        scales: {
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                grid: softGrid
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                grid: { drawOnChartArea: false },
                                ticks: { callback: v => v + '%' }
                            },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            // -------------------------------------------------------------
            // 5. POLAR AREA CHART (canvasPolar)
            // -------------------------------------------------------------
            const ctxPolar = document.getElementById('canvasPolar');
            if (ctxPolar) {
                new Chart(ctxPolar, {
                    type: 'polarArea',
                    data: {
                        labels: ['Admin', 'Users', 'Settings', 'Storage', 'Security'],
                        datasets: [{
                            data: [35, 45, 25, 30, 40],
                            backgroundColor: [
                                'rgba(59, 130, 246, 0.75)',  // Blue
                                'rgba(16, 185, 129, 0.75)',  // Emerald
                                'rgba(245, 158, 11, 0.75)',  // Amber
                                'rgba(139, 92, 246, 0.75)',  // Violet
                                'rgba(239, 68, 68, 0.75)'    // Rose
                            ],
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom', labels: { usePointStyle: true, padding: 12 } }
                        },
                        scales: {
                            r: { grid: { color: '#f1f5f9' }, ticks: { display: false } }
                        }
                    }
                });
            }

            // -------------------------------------------------------------
            // 6. DOUGHNUT CHART (canvasDoughnut)
            // -------------------------------------------------------------
            const ctxDoughnut = document.getElementById('canvasDoughnut');
            if (ctxDoughnut) {
                new Chart(ctxDoughnut, {
                    type: 'doughnut',
                    data: {
                        labels: ['Direct Web', 'API Client', 'Mobile App', 'Partner SSO'],
                        datasets: [{
                            data: [42, 28, 18, 12],
                            backgroundColor: ['#0284c7', '#10b981', '#f59e0b', '#8b5cf6'],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '68%',
                        plugins: {
                            legend: { position: 'bottom', labels: { usePointStyle: true, padding: 12 } }
                        }
                    }
                });
            }

            // -------------------------------------------------------------
            // 7. RADAR CHART (canvasRadar)
            // -------------------------------------------------------------
            const ctxRadar = document.getElementById('canvasRadar');
            if (ctxRadar) {
                new Chart(ctxRadar, {
                    type: 'radar',
                    data: {
                        labels: ['Security', 'Latency', 'Reliability', 'Cache Hit', 'Throughput', 'Uptime'],
                        datasets: [{
                            label: 'System Score',
                            data: [96, 88, 98, 94, 90, 100],
                            backgroundColor: 'rgba(99, 102, 241, 0.25)', // Indigo transparent
                            borderColor: '#6366f1',
                            borderWidth: 2,
                            pointBackgroundColor: '#6366f1'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            r: {
                                beginAtZero: true,
                                max: 100,
                                ticks: { stepSize: 20, display: false },
                                grid: { color: '#e2e8f0' }
                            }
                        }
                    }
                });
            }

            // -------------------------------------------------------------
            // 8. HORIZONTAL MULTI-COLOR BARS (canvasHorizontalBars)
            // -------------------------------------------------------------
            const ctxHorizontal = document.getElementById('canvasHorizontalBars');
            if (ctxHorizontal) {
                new Chart(ctxHorizontal, {
                    type: 'bar',
                    data: {
                        labels: ['Users Mgmt', 'Audit Trail', 'General Config', 'DB Backups', 'Mail Relay', 'Security 2FA'],
                        datasets: [{
                            label: 'Interaction Count (k)',
                            data: [84, 72, 61, 54, 48, 39],
                            backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4'],
                            borderRadius: 6,
                            barPercentage: 0.65
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            x: { beginAtZero: true, grid: softGrid },
                            y: { grid: { display: false } }
                        }
                    }
                });
            }

            // -------------------------------------------------------------
            // 9. STACKED BARS (canvasStackedBars)
            // -------------------------------------------------------------
            const ctxStacked = document.getElementById('canvasStackedBars');
            if (ctxStacked) {
                new Chart(ctxStacked, {
                    type: 'bar',
                    data: {
                        labels: ['Q1', 'Q2', 'Q3', 'Q4'],
                        datasets: [
                            {
                                label: 'Cloud Compute',
                                data: [14, 18, 16, 22],
                                backgroundColor: '#3b82f6'
                            },
                            {
                                label: 'Storage & DB',
                                data: [10, 12, 14, 15],
                                backgroundColor: '#10b981'
                            },
                            {
                                label: 'Support & CDN',
                                data: [6, 8, 7, 9],
                                backgroundColor: '#f59e0b'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom', labels: { usePointStyle: true, padding: 10 } }
                        },
                        scales: {
                            x: { stacked: true, grid: { display: false } },
                            y: { stacked: true, grid: softGrid }
                        }
                    }
                });
            }

            // -------------------------------------------------------------
            // 10. STEPPED LINE AREA CHART (canvasSteppedArea)
            // -------------------------------------------------------------
            const ctxStepped = document.getElementById('canvasSteppedArea');
            if (ctxStepped) {
                new Chart(ctxStepped, {
                    type: 'line',
                    data: {
                        labels: ['00:00', '03:00', '06:00', '09:00', '12:00', '15:00', '18:00', '21:00', '24:00'],
                        datasets: [{
                            label: 'Req/Sec',
                            data: [420, 380, 520, 1240, 1450, 1380, 1290, 890, 610],
                            borderColor: '#8b5cf6', // violet-500
                            backgroundColor: 'rgba(139, 92, 246, 0.15)',
                            fill: true,
                            stepped: true,
                            borderWidth: 2,
                            pointRadius: 3,
                            pointBackgroundColor: '#8b5cf6'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: { beginAtZero: true, grid: softGrid },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

        });
    </script>

</x-admin::layouts.master>

