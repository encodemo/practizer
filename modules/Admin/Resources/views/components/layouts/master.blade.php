<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Practizer</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('modules/admin/css/style.css') }}">

    <!-- External Tailwind Config -->
    <script src="{{ asset('modules/admin/js/tailwind-config.js') }}"></script>
    
    <!-- Alpine.js CDN (TALL-Stack Core for Modals, Dropdowns & Reactive UI) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Iconify CDN (untuk Heroicons) -->
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    <!-- Global CSS Helper for Alpine Cloak -->
    <style>
        [x-cloak] { 
            display: none !important; 
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans flex h-screen overflow-hidden">

    <!-- INCLUDE SIDEBAR -->
    @include('admin::components.layouts.partials.sidebar')

    <!-- MAIN CONTENT WRAPPER -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <!-- INCLUDE HEADER -->
        @include('admin::components.layouts.partials.header')

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
            {{ $slot }}
        </main>

        <!-- INCLUDE FOOTER -->
        <!-- @include('admin::components.layouts.partials.footer') -->
        
    </div>

    <!-- Custom JS -->
    <script src="{{ asset('modules/admin/js/sidebar.js') }}"></script>

</body>
</html>
