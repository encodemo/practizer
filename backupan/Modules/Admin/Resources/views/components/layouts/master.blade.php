<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    
    <style>
        body { overflow-x: hidden; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        #sidebar-wrapper { min-height: 100vh; width: 250px; transition: all 0.25s ease; }
        .wrapper { display: flex; width: 100%; }
        #page-content-wrapper { width: 100%; }
    </style>
</head>
<body>

    <div class="wrapper">
        <!-- PERBAIKAN: Ditambahkan prefix admin:: -->
        @include('admin::components.layouts.sidebar')

        <div id="page-content-wrapper" class="bg-light">
            <!-- PERBAIKAN: Ditambahkan prefix admin:: -->
            @include('admin::components.layouts.navbar')

            <!-- Konten Dinamis -->
            <div class="container-fluid p-4">
                @yield('content')
            </div>
            
            <footer class="text-center py-3 bg-white mt-auto border-top">
                <small class="text-muted">&copy; 2026 Admin Dashboard. All Rights Reserved.</small>
            </footer>
        </div>
    </div>
</body>
</html>
