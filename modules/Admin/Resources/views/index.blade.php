<x-admin::layouts.master>
    
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Overview</h1>
        <p class="text-gray-500 text-sm mt-1">Welcome back, Administrator! Here is what's happening today.</p>
    </div>

    <!-- Stats Grid (Tetap dipertahankan karena bagus untuk dashboard) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Stat 1 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Users</p>
                <h3 class="text-2xl font-bold text-gray-800">1,245</h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 text-primary rounded-lg flex items-center justify-center">
                <span class="iconify text-2xl" data-icon="heroicons:users"></span>
            </div>
        </div>
        <!-- Stat 2 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Revenue</p>
                <h3 class="text-2xl font-bold text-gray-800">$34,500</h3>
            </div>
            <div class="w-12 h-12 bg-green-50 text-green-500 rounded-lg flex items-center justify-center">
                <span class="iconify text-2xl" data-icon="heroicons:currency-dollar"></span>
            </div>
        </div>
        <!-- Stat 3 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Active Sessions</p>
                <h3 class="text-2xl font-bold text-gray-800">432</h3>
            </div>
            <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-lg flex items-center justify-center">
                <span class="iconify text-2xl" data-icon="heroicons:computer-desktop"></span>
            </div>
        </div>
        <!-- Stat 4 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">New Orders</p>
                <h3 class="text-2xl font-bold text-gray-800">89</h3>
            </div>
            <div class="w-12 h-12 bg-purple-50 text-purple-500 rounded-lg flex items-center justify-center">
                <span class="iconify text-2xl" data-icon="heroicons:shopping-cart"></span>
            </div>
        </div>
    </div>

    <!-- Charts Section1 -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Bar Chart (Lebih Lebar) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 lg:col-span-2">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Revenue Overview</h2>
            <div class="relative h-72 w-full">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Doughnut Chart (Lebih Sempit) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 lg:col-span-1">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Traffic Sources</h2>
            <div class="relative h-72 w-full flex items-center justify-center">
                <canvas id="trafficChart"></canvas>
            </div>
        </div>

    </div>

    <!-- Charts Grid (6 Jenis Chart) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- 1. Bar Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Bar Chart (Monthly Sales)</h2>
            <div class="relative h-72 w-full">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <!-- 2. Line Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Line Chart (User Growth)</h2>
            <div class="relative h-72 w-full">
                <canvas id="lineChart"></canvas>
            </div>
        </div>

        <!-- 3. Area Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Area Chart (Revenue Trend)</h2>
            <div class="relative h-72 w-full">
                <canvas id="areaChart"></canvas>
            </div>
        </div>

        <!-- 4. Custom Chart (Mixed) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Custom Chart (Sales vs Profit)</h2>
            <div class="relative h-72 w-full">
                <canvas id="customChart"></canvas>
            </div>
        </div>

        <!-- 5. Doughnut Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Doughnut Chart (Traffic Source)</h2>
            <div class="relative h-64 w-full flex justify-center">
                <canvas id="doughnutChart"></canvas>
            </div>
        </div>

        <!-- 6. Pie Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Pie Chart (Device Usage)</h2>
            <div class="relative h-64 w-full flex justify-center">
                <canvas id="pieChart"></canvas>
            </div>
        </div>

    </div>

    <!-- Script Inisialisasi Chart.js -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            
            // Konfigurasi Global Chart.js
            Chart.defaults.font.family = "'Inter', 'sans-serif'";
            Chart.defaults.color = '#6b7280';
            const gridOptions = { color: '#f3f4f6', borderDash: [5, 5] }; // Warna garis bantu grafik// 1. REVENUE CHART (Bar Chart)
            const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
            // Copy & paste langsung ke konfigurasi datasets Chart.js Anda
            const vibrantPalette = {
                backgroundColor: [
                    '#ef4444', '#f97316', '#f59e0b', '#eab308', '#84cc16', '#10b981',
                    '#14b8a6', '#06b6d4', '#0ea5e9', '#3b82f6', '#6366f1', '#8b5cf6'
                ],
                borderColor: [
                    '#dc2626', '#ea580c', '#d97706', '#ca8a04', '#65a30d', '#059669',
                    '#0d9488', '#0891b2', '#0284c7', '#2563eb', '#4f46e5', '#7c3aed'
                ],
                borderWidth: 1
            };

            new Chart(ctxRevenue, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Revenue ($)',
                        data: [12000, 19000, 15000, 22000, 18000, 28000, 25000, 30000, 27000, 32000, 35000, 40000],
                        backgroundColor: vibrantPalette.backgroundColor, // primary (blue-500)
                        borderRadius: 4, // sudut melengkung pada bar
                        barPercentage: 0.75
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false } // Sembunyikan legenda agar lebih bersih
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [4, 4],
                                color: '#e5e7eb' // gray-200
                            }
                        },
                        x: {
                            grid: { display: false } // Hilangkan garis vertikal
                        }
                    }
                }
            });

            // 2. TRAFFIC SOURCES CHART (Doughnut Chart)
            const ctxTraffic = document.getElementById('trafficChart').getContext('2d');
            new Chart(ctxTraffic, {
                type: 'doughnut',
                data: {
                    labels: ['Direct', 'Social', 'Referral'],
                    datasets: [{
                        data: [55, 30, 15],
                        backgroundColor: [
                            '#3b82f6', // blue-500
                            '#10b981', // green-500
                            '#f59e0b'  // amber-500
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '50%', // Ketebalan donat
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    }
                }
            });

            // 1. BAR CHART (Grouped dengan 3 Warna)
            new Chart(document.getElementById('barChart'), {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [
                        {
                            label: 'Product A',
                            data: [12, 19, 15, 25, 22, 30],
                            backgroundColor: '#3b82f6', // Tailwind blue-500
                            borderRadius: 4
                        },
                        {
                            label: 'Product B',
                            data: [8, 12, 18, 15, 20, 25],
                            backgroundColor: '#10b981', // Tailwind green-500
                            borderRadius: 4
                        },
                        {
                            label: 'Product C',
                            data: [5, 10, 8, 12, 15, 18],
                            backgroundColor: '#f59e0b', // Tailwind amber-500
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true, 
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            display: true,
                            position: 'bottom' // Menampilkan legenda di bawah agar informatif
                        }
                    },
                    scales: { 
                        y: { beginAtZero: true, grid: gridOptions }, 
                        x: { grid: { display: false } } 
                    }
                }
            });

            // 2. LINE CHART
            new Chart(document.getElementById('lineChart'), {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Active Users',
                        data: [65, 59, 80, 81, 56, 55, 90],
                        borderColor: '#10b981', // Tailwind green-500
                        borderWidth: 3,
                        tension: 0.4, // Membuat garis menjadi kurva melengkung (smooth)
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#10b981'
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true, grid: gridOptions }, x: { grid: { display: false } } }
                }
            });

            // 3. AREA CHART (Line chart dengan Fill)
            new Chart(document.getElementById('areaChart'), {
                type: 'line',
                data: {
                    labels: ['Q1', 'Q2', 'Q3', 'Q4'],
                    datasets: [{
                        label: 'Revenue',
                        data: [3000, 5000, 4500, 7000],
                        borderColor: '#8b5cf6', // Tailwind violet-500
                        backgroundColor: 'rgba(139, 92, 246, 0.2)', // Violet transparent
                        fill: true, // INI YANG MEMBUATNYA MENJADI AREA CHART
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true, grid: gridOptions }, x: { grid: { display: false } } }
                }
            });

            // 4. CUSTOM CHART (Mixed: Bar + Line)
            new Chart(document.getElementById('customChart'), {
                type: 'bar', // Tipe dasar
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                    datasets: [
                        {
                            label: 'Profit Trend (Line)',
                            type: 'line', // Override tipe dataset
                            data: [5, 10, 8, 15, 12],
                            borderColor: '#f59e0b', // Amber-500
                            borderWidth: 3,
                            fill: false
                        },
                        {
                            label: 'Gross Sales (Bar)',
                            type: 'bar',
                            data: [15, 25, 20, 30, 28],
                            backgroundColor: '#e5e7eb', // Gray-200
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true, grid: gridOptions }, x: { grid: { display: false } } }
                }
            });

            // 5. DOUGHNUT CHART
            new Chart(document.getElementById('doughnutChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Direct', 'Social', 'Referral'],
                    datasets: [{
                        data: [300, 150, 100],
                        backgroundColor: ['#3b82f6', '#10b981', '#f59e0b'],
                        borderWidth: 0,
                        hoverOffset: 5
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    cutout: '40%',
                    plugins: { legend: { position: 'bottom' } }
                }
            });

            // 6. PIE CHART
            new Chart(document.getElementById('pieChart'), {
                type: 'pie',
                data: {
                    labels: ['Mobile', 'Desktop', 'Tablet'],
                    datasets: [{
                        data: [55, 35, 10],
                        backgroundColor: ['#6366f1', '#ec4899', '#14b8a6'], // Indigo, Pink, Teal
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 5
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }
                }
            });

        });
    </script>

</x-admin::layouts.master>
