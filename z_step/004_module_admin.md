## **Create Admin Module**

Buka file  ```root\Modules\Admin\routes\web.php```

```php
<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('admins', AdminController::class)->names('admin');
});

```
Ubah menjadi:
```php
<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

```
##

Buka browser, lakukan pengujian dengan membuka url.
```php
<http://localhost/practizer/public/admin>
```
atau
```php
http://localhost/practizer/public/admin/dashboard
```

Apabila semua pengaturan berhasil, maka browser akan menampilkan halaman `Hello World` dengan keterangan di bawahnya `Module: Admin`

##

ubah Admin/resources/views/components/layouts/master.blade.php

New-Item -Path "C:\xampp\htdocs\practizer\modules\Admin\Resources\views\components\layouts\" -Name "partials" -ItemType Directory

New-Item -Path "C:\xampp\htdocs\practizer\modules\Admin\Resources\views\components\layouts\partials" -Name "footer.blade.php" -ItemType File
New-Item -Path "C:\xampp\htdocs\practizer\modules\Admin\Resources\views\components\layouts\partials" -Name "header.blade.php" -ItemType File
New-Item -Path "C:\xampp\htdocs\practizer\modules\Admin\Resources\views\components\layouts\partials" -Name "sidebar.blade.php" -ItemType File

buat Admin/resources/views/components/layouts/partials/footer.blade.php
buat Admin/resources/views/components/layouts/partials/header.blade.php
buat Admin/resources/views/components/layouts/partials/sidebar.blade.php

##

New-Item -Path "C:\xampp\htdocs\practizer\public\" -Name "modules\admin\css" -ItemType Directory
New-Item -Path "C:\xampp\htdocs\practizer\public\modules\admin\css" -Name "style.css" -ItemType File

New-Item -Path "C:\xampp\htdocs\practizer\public\" -Name "modules\admin\js" -ItemType Directory
New-Item -Path "C:\xampp\htdocs\practizer\public\modules\admin\js" -Name "tailwind-config.js" -ItemType File
New-Item -Path "C:\xampp\htdocs\practizer\public\modules\admin\js" -Name "sidebar.js" -ItemType File





