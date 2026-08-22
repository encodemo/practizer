# Dokumentasi & Tutorial Global: Modul Users (Master Architecture & Implementation)

## 📌 1. Gambaran Umum & Nilai Strategis

Modul **Users** merupakan modul inti (*core module*) dalam sistem **Practizer** yang mengelola seluruh siklus hidup identitas pengguna (*identity & access management*). Modul ini dibangun menggunakan arsitektur modular **`nwidart/laravel-modules`** pada **Laravel 12.12.2 (PHP 8.2.12)**.

Modul ini mencakup 4 pilar fungsional utama:
1. **User Identity & Lifecycle Management:** Pengelolaan profil, kredensial, departemen, dan status akun pengguna.
2. **User Groups Management:** Pengelompokan pengguna berdasarkan departemen, divisi kerja, dan struktur organisasi.
3. **Role-Based Access Control (RBAC):** Manajemen peran (*roles*) dan matriks penugasan izin akses granular (*permissions*).
4. **Activity Log & Audit Trail:** Pencatatan riwayat aktivitas, forensik keamanan, inspeksi payload diff (*before vs after*), dan kepatuhan retensi log.

Seluruh antarmuka dirancang dengan standar visual modern **TALL-Stack (Tailwind CSS, Alpine.js, Laravel Blade)** serta pola interaksi ala **FilamentPHP** dalam status **Database-Agnostic Mockup** yang siap dimigrasikan ke mode production.

---

## 📂 2. Blueprint Arsitektur Direktori Modul Users

Struktur direktori modul `Users` diorganisir secara modular, bersih, dan mematuhi prinsip *Separation of Concerns*:

```
Modules/Users/
├── Config/
│   └── config.php                        # Konfigurasi nama modul & metadata
├── Http/Controllers/
│   ├── UsersController.php               # Pilar 1: Master CRUD & Profil Detail User
│   ├── UserGroupController.php           # Pilar 2: Pengelolaan Grup & Departemen
│   ├── RoleController.php                # Pilar 3A: Pengelolaan Role & Matriks Izin
│   ├── PermissionController.php          # Pilar 3B: Pengelolaan Master Kunci Permission
│   └── ActivityLogController.php         # Pilar 4: Audit Trail, Inspector, & Retention
├── Providers/
│   ├── UsersServiceProvider.php          # Service provider registrasi modul
│   └── RouteServiceProvider.php          # Pemetaan route web & api modul
├── Resources/views/
│   ├── index.blade.php                   # View: Tabel All Users + Export & Delete Modal
│   ├── show.blade.php                    # View: Profil Lengkap + 4 Tab + Action Modals
│   ├── create.blade.php                  # View: Form Tambah User Baru
│   ├── edit.blade.php                    # View: Form Edit Data User
│   ├── groups/
│   │   ├── index.blade.php               # View: Daftar User Groups
│   │   ├── create.blade.php              # View: Form Tambah Group
│   │   └── edit.blade.php                # View: Form Edit Group
│   ├── roles/
│   │   ├── index.blade.php               # View: Tabbed Roles & Permissions Overview
│   │   ├── create.blade.php              # View: Form Tambah Role + Permission Matrix
│   │   └── edit.blade.php                # View: Form Edit Role + Permission Matrix
│   ├── permissions/
│   │   ├── create.blade.php              # View: Form Tambah Master Permission
│   │   └── edit.blade.php                # View: Form Edit Master Permission (Read-Only Key)
│   └── logs/
│       └── index.blade.php               # View: Audit Trail + Diff Inspector + Export/Purge
└── Routes/
    ├── web.php                           # Seluruh pendaftaran route admin/users
    └── api.php                           # Endpoint API modul users
```

---

## 🛣️ 3. Master Routing Matrix

Seluruh rute modul `Users` dikelompokkan secara rapi di bawah *prefix* `admin/users` dengan *route name prefix* `users.`:

```php
// File: Modules/Users/Routes/web.php
use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\UsersController;
use Modules\Users\Http\Controllers\UserGroupController;
use Modules\Users\Http\Controllers\RoleController;
use Modules\Users\Http\Controllers\PermissionController;
use Modules\Users\Http\Controllers\ActivityLogController;

Route::prefix('admin/users')->name('users.')->group(function () {
    
    // =========================================================================
    // 1. ALL USERS MANAGEMENT
    // =========================================================================
    Route::get('/', [UsersController::class, 'index'])->name('index');
    Route::get('/create', [UsersController::class, 'create'])->name('create');
    Route::post('/', [UsersController::class, 'store'])->name('store');
    Route::get('/{id}', [UsersController::class, 'show'])->name('show')->whereNumber('id');
    Route::get('/{id}/edit', [UsersController::class, 'edit'])->name('edit')->whereNumber('id');
    Route::put('/{id}', [UsersController::class, 'update'])->name('update')->whereNumber('id');
    Route::delete('/{id}', [UsersController::class, 'destroy'])->name('destroy')->whereNumber('id');

    // =========================================================================
    // 2. USER GROUPS (Resource)
    // =========================================================================
    Route::resource('groups', UserGroupController::class);

    // =========================================================================
    // 3. ROLES & PERMISSIONS (RBAC Resource)
    // =========================================================================
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    // =========================================================================
    // 4. ACTIVITY LOGS & AUDIT TRAIL
    // =========================================================================
    Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index');
    Route::post('/logs/purge', [ActivityLogController::class, 'purge'])->name('logs.purge');
    Route::get('/logs/{id}', [ActivityLogController::class, 'show'])->name('logs.show')->whereNumber('id');
    Route::delete('/logs/{id}', [ActivityLogController::class, 'destroy'])->name('logs.destroy')->whereNumber('id');

});
```

### Tabel Rute Lengkap:

| HTTP Method | URI Endpoint | Named Route | Controller Action | Deskripsi Fungsi |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/admin/users` | `users.index` | `UsersController@index` | Daftar tabel seluruh user, pencarian, & filter |
| `GET` | `/admin/users/create` | `users.create` | `UsersController@create` | Form pendaftaran user baru |
| `POST` | `/admin/users` | `users.store` | `UsersController@store` | Simpan data user baru |
| `GET` | `/admin/users/{id}` | `users.show` | `UsersController@show` | Detail profil, keamanan, sesi, & riwayat user |
| `GET` | `/admin/users/{id}/edit` | `users.edit` | `UsersController@edit` | Form edit data user |
| `PUT` | `/admin/users/{id}` | `users.update` | `UsersController@update` | Update data user |
| `DELETE` | `/admin/users/{id}` | `users.destroy` | `UsersController@destroy` | Hapus akun user |
| `GET` | `/admin/users/groups` | `users.groups.index` | `UserGroupController@index` | Daftar kelompok kerja / departemen |
| `GET` | `/admin/users/roles` | `users.roles.index` | `RoleController@index` | Tabbed view System Roles & Permissions |
| `GET` | `/admin/users/roles/create`| `users.roles.create` | `RoleController@create` | Form Role baru + Matriks Izin |
| `GET` | `/admin/users/logs` | `users.logs.index` | `ActivityLogController@index`| Live audit trail, KPI cards, & payload diff |
| `POST` | `/admin/users/logs/purge`| `users.logs.purge` | `ActivityLogController@purge`| Kebijakan retensi pembersihan log lama |

---

## 🎨 4. Penjelasan 4 Pilar Fungsional Modul Users

```
                               ┌──────────────────────────────────────────────┐
                               │             MODUL USERS (PRACTIZER)          │
                               └──────────────────────────────────────────────┘
                                                       │
         ┌─────────────────────────┬───────────────────┴─────────────────────┬────────────────────────┐
         ▼                         ▼                                         ▼                        ▼
┌──────────────────┐     ┌───────────────────┐                     ┌──────────────────┐     ┌──────────────────┐
│     PILAR 1      │     │      PILAR 2      │                     │     PILAR 3      │     │     PILAR 4      │
│  USER DIRECTORY  │     │    USER GROUPS    │                     │  ROLES & RBAC    │     │  ACTIVITY LOGS   │
│ (Profil, Sesi,   │     │ (Departemen, Tim, │                     │(Matriks Izin,    │     │(Audit Trail,     │
│ & Tindakan Akun) │     │ & Divisi Kerja)   │                     │ Guard Proteksi)  │     │ Payload Diff)    │
└──────────────────┘     └───────────────────┘                     └──────────────────┘     └──────────────────┘
```

### Pilar 1: User Management (`UsersController.php`)
- **Daftar User (`index.blade.php`):** Menampilkan direktori 23 user mockup lengkap dengan avatar dinamis `ui-avatars.com`, role badge warna, status pill aktif/nonaktif, tanggal registrasi, serta modal ekspor data (Excel, CSV, PDF).
- **Halaman Detail Akun (`show.blade.php`):** Desain Filament 2-kolom:
  - *Kolom Kiri:* Kartu profil lengkap, badge 2FA, kontak, metadata login terakhir, serta tombol aksi cepat (*Quick Modals*).
  - *Kolom Kanan (4 Tab):*
    1. **Overview Tab:** Data identitas legal, departemen, dan penempatan posisi.
    2. **Roles & Permissions Tab:** Daftar izin efektif yang dimiliki akun.
    3. **Security & Sessions Tab:** Pengaturan 2FA, kebijakan password, serta daftar sesi login aktif (dengan tombol revoke sesi).
    4. **Activity Audit Tab:** Linimasa riwayat aksi spesifik yang pernah dilakukan user tersebut.
- **Modal Aksi Kustom:** Reset Password Modal, Impersonate User Modal, Force Reset Modal, dan Revoke Sessions Modal.

### Pilar 2: User Groups (`UserGroupController.php`)
- Mengorganisir user ke dalam divisi kerja (contoh: *Core Tech Staff*, *Finance & Accounting*, *Operations & Logistics*, *Customer Support*).
- Menampilkan jumlah anggota per grup dan status operasional.

### Pilar 3: Roles & Permissions Matrix (`RoleController.php` & `PermissionController.php`)
- **Skenario Hybrid:** Menggabungkan tab navigasi di halaman utama dengan *Dedicated Form Pages* untuk form pembuatan role.
- **Permission Matrix Grid:** Matriks izin yang dikelompokkan per modul aplikasi dengan fitur cerdas **Select All Permissions** per modul.
- **Super User Guard (Simulasi Proteksi):** Toggle interaktif untuk mendemonstrasikan bahwa aksi penghapusan role/permission hanya diizinkan untuk akun *Super Administrator*.
- **Read-Only Permission Key:** Perlindungan string *identifier* permission saat proses edit agar tidak merusak logika pengecekan otorisasi di level kode.

### Pilar 4: Activity Logs & Audit Trail (`ActivityLogController.php`)
- **4 Filament-Style KPI Metric Cards:** Total Activities (+12% tren), Security Alerts, Auth Events, dan Active Operators.
- **Quick Filter Tabs & Faceted Popover:** Filter instan berdasarkan kategori aksi, modul target, dan tingkat *severity* (`info`, `success`, `warning`, `danger`).
- **Forensic Payload Diff Inspector (Modal):** Pop-up inspeksi perbandingan data *Before (Old Values)* vs *After (New Values)*.
- **Compliance Retention Purge Modal:** Pembersihan log berkala sesuai kebijakan kepatuhan data.

---

## 🛡️ 5. Standar Konsistensi UI/UX (Prinsip Non-DOM Pop-up)

Untuk menjaga pengalaman pengguna tetap profesional dan modern:
1. **Tidak Menggunakan DOM Dialog Browser:** Seluruh konfirmasi aksi (hapus user, reset password, impersonate, purge log, delete role) **TIDAK PERNAH** menggunakan `window.alert()` atau `window.confirm()`.
2. **Alpine.js Modal Pop-up:** Menggunakan modal kustom dengan *backdrop blur* (`bg-gray-900/50 backdrop-blur-sm`), animasi masuk/keluar `x-transition`, dan kontrol aksesibilitas `x-cloak`.
3. **Toast Feedback:** Notifikasi aksi instan yang muncul di sudut atas halaman dan menghilang secara otomatis setelah beberapa detik.

---

## 📖 6. Panduan Pengguna (Administrator User Guide)

### A. Alur Menambah & Mengelola User
1. Buka menu **Users Management > All Users**.
2. Klik tombol **Add New User** untuk mendaftarkan akun baru.
3. Isi informasi profil, pilih Role (*Admin, Editor, Member*), tetapkan User Group, lalu klik **Create User Account**.
4. Untuk melihat detail profil atau memutus sesi mencurigakan, klik ikon **Mata (View)** pada tabel user, lalu buka tab **Security & Sessions**.

### B. Alur Mengatur Peran & Matriks Hak Akses
1. Buka menu **Users Management > Roles & Permissions**.
2. Klik **Create Role** untuk membuat hierarki jabatan baru.
3. Centang modul-modul izin yang ingin diberikan (misal: hanya mencentang `view_users` dan `export_reports`).
4. Klik **Save Role & Permissions**.

### C. Alur Memantau Keamanan & Audit Trail
1. Buka menu **Users Management > Activity Logs**.
2. Periksa kartu metrik **Security & Alerts** untuk memantau upaya login gagal atau perubahan izin mendadak.
3. Klik tombol **Inspect (Mata)** pada salah satu baris log untuk memeriksa payload data sebelum dan sesudah perubahan.
4. Klik **Export Audit Trail** untuk mengunduh laporan aktivitas dalam format Excel atau PDF.

---

## 💻 7. Panduan Developer: Roadmap Migrasi ke Mode Production

Ketika sistem siap dihubungkan ke database relasional (MySQL / PostgreSQL), ikuti langkah-langkah implementasi teknis berikut:

### 1. Perintah Artisan Pembentukan Controller (Histori Pembuatan)
Untuk meregenerasi atau menambah controller baru di modul Users:
```bash
php artisan module:make-controller UsersController Users
php artisan module:make-controller UserGroupController Users
php artisan module:make-controller RoleController Users
php artisan module:make-controller PermissionController Users
php artisan module:make-controller ActivityLogController Users
```

### 2. Instalasi Paket Ekosistem Standar Industri
```bash
# 1. Paket Role & Permission (RBAC)
composer require spatie/laravel-permission

# 2. Paket Audit Trail & Activity Logging
composer require spatie/laravel-activitylog

# 3. Publish Migration & Konfigurasi
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"
php artisan migrate
```

### 3. Skema Relasi Model Eloquent (`Modules/Users/Entities/User.php`)
```php
namespace Modules\Users\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasRoles, LogsActivity;

    protected $fillable = [
        'user_group_id', 'name', 'username', 'email', 'password',
        'phone', 'status', 'department', 'position', 'bio', 'location'
    ];

    protected $hidden = ['password', 'remember_token'];

    // Relasi ke User Group
    public function group(): BelongsTo
    {
        return $this->belongsTo(UserGroup::class, 'user_group_id');
    }

    // Konfigurasi Otomatis Spatie Activity Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'status', 'user_group_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('Users');
    }
}
```

### 4. Proteksi Autorisasi di Level Controller & Blade
Gunakan Gate / Policy Laravel untuk mengamankan aksi:
```php
// Pada Controller:
$this->authorize('delete_users');

// Pada Blade View:
@can('delete_users')
    <button type="button" @click="openDeleteModal(...)">Delete</button>
@endcan
```

---

## 📌 8. Daftar Seri Dokumentasi Modul Terkait

| File Panduan | Topik Pembahasan |
| :--- | :--- |
| [`000_Terminal_Commands.md`](file:///c:/xampp/htdocs/practizer/z_step/000_Terminal_Commands.md) | Panduan perintah terminal & CLI Laravel Modules |
| [`005_module_users.md`](file:///c:/xampp/htdocs/practizer/z_step/005_module_users.md) | **Dokumentasi Global & Master Blueprint Modul Users (Dokumen Ini)** |
| [`006_UserController.md`](file:///c:/xampp/htdocs/practizer/z_step/006_UserController.md) | Panduan teknis UsersController & profil multi-tab |
| [`007_UserGroupController.md`](file:///c:/xampp/htdocs/practizer/z_step/007_UserGroupController.md) | Panduan teknis UserGroupController |
| [`008_RolePermission.md`](file:///c:/xampp/htdocs/practizer/z_step/008_RolePermission.md) | Panduan teknis RoleController, PermissionController & RBAC Matrix |
| [`009_ActivityLog.md`](file:///c:/xampp/htdocs/practizer/z_step/009_ActivityLog.md) | Panduan teknis ActivityLogController & Audit Trail |

---

*Dokumentasi ini disusun sebagai standar baku arsitektur Modul Users pada aplikasi Practizer.*

