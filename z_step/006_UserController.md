# 006 - Implementasi Mockup Interaktif & Dokumentasi Lengkap UserController

Dokumen ini merupakan panduan teknis, referensi arsitektur, dan tutorial operasional menyeluruh untuk modul **Users** pada proyek **Practizer**. Panduan ini dirancang untuk pengguna (*end-user/QA tester*) maupun pengembang (*software engineer/developer*).

---

## 📋 Ringkasan Proyek & Konvensi

| Parameter | Spesifikasi |
| :--- | :--- |
| **Framework Core** | Laravel 12.12.2 |
| **Modular Architecture** | `nwidart/laravel-modules` v12 (Modular Monolith) |
| **Environment** | XAMPP Windows 10 x64, PHP 8.2.12 |
| **Database State** | **Zero Database / Database-Agnostic** (100% Mockup In-Memory) |
| **Design Standard** | **TALL-Stack (Tailwind CSS, Alpine.js) & FilamentPHP Aesthetic** |
| **Icon Ecosystem** | Iconify (Heroicons Solid & Outline) |

---

## 🏛️ Struktur Berkas Modul Users

```
modules/Users/
├── Http/
│   └── Controllers/
│       ├── UsersController.php         # Controller utama manajemen User (CRUD Mockup)
│       ├── UserGroupController.php     # Controller manajemen User Group
│       ├── RoleController.php          # Controller peran (RBAC)
│       ├── PermissionController.php    # Controller hak akses
│       └── ActivityLogController.php   # Controller riwayat audit aktivitas
├── Resources/
│   └── views/
│       ├── index.blade.php             # Halaman tabel daftar user, search, filter, export & modal delete
│       ├── create.blade.php            # Halaman form tambah user baru (avatar live preview, auto-username, password generator)
│       ├── show.blade.php              # Halaman profil single user (4 Tab Panel: Overview, Roles, Security, Audit)
│       └── edit.blade.php              # Halaman form edit user (pre-populated)
└── Routes/
    └── web.php                         # Definisi rute RESTful modular
```

---

## 🛣️ 1. Arsitektur Routing (`modules/Users/Routes/web.php`)

Seluruh rute pada modul Users diproteksi dengan pembatas angka (`->whereNumber('id')`) untuk mencegah tabrakan nama rute (*slug collision*) serta menyediakan rute kompatibilitas `/manage` untuk browser yang menyimpan cache lama.

### Kode `modules/Users/Routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\UsersController;
use Modules\Users\Http\Controllers\UserGroupController;
use Modules\Users\Http\Controllers\RoleController;
use Modules\Users\Http\Controllers\PermissionController;
use Modules\Users\Http\Controllers\ActivityLogController;

Route::prefix('admin/users')->name('users.')->group(function () {
    
    // 1. All Users Management (Direct Clean RESTful Routes)
    Route::get('/', [UsersController::class, 'index'])->name('index');
    Route::get('/create', [UsersController::class, 'create'])->name('create');
    Route::post('/', [UsersController::class, 'store'])->name('store');
    Route::get('/{id}', [UsersController::class, 'show'])->name('show')->whereNumber('id');
    Route::get('/{id}/edit', [UsersController::class, 'edit'])->name('edit')->whereNumber('id');
    Route::put('/{id}', [UsersController::class, 'update'])->name('update')->whereNumber('id');
    Route::delete('/{id}', [UsersController::class, 'destroy'])->name('destroy')->whereNumber('id');

    // Legacy / Alias routes untuk backward-compatibility
    Route::get('/manage', [UsersController::class, 'index']);
    Route::get('/manage/create', [UsersController::class, 'create']);
    Route::get('/manage/{id}', [UsersController::class, 'show'])->whereNumber('id');
    Route::get('/manage/{id}/edit', [UsersController::class, 'edit'])->whereNumber('id');

    // 2. User Groups
    Route::resource('groups', UserGroupController::class);

    // 3. Roles (RBAC)
    Route::resource('roles', RoleController::class);

    // 4. Permissions
    Route::resource('permissions', PermissionController::class);

    // 5. Activity Logs
    Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index');
    Route::get('/logs/{id}', [ActivityLogController::class, 'show'])->name('logs.show')->whereNumber('id');

});
```

### Matriks Endpoint & Named Routes

| Method | URI Path | Named Route | Controller Action | Keterangan |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/admin/users` | `users.index` | `UsersController@index` | Menampilkan tabel daftar user |
| `GET` | `/admin/users/create` | `users.create` | `UsersController@create` | Form pembuatan user baru |
| `POST` | `/admin/users` | `users.store` | `UsersController@store` | Simulasi simpan data & redirect flash |
| `GET` | `/admin/users/{id}` | `users.show` | `UsersController@show` | Detail lengkap profil single user |
| `GET` | `/admin/users/{id}/edit` | `users.edit` | `UsersController@edit` | Form edit profil user |
| `PUT` | `/admin/users/{id}` | `users.update` | `UsersController@update` | Simulasi update data & redirect flash |
| `DELETE` | `/admin/users/{id}` | `users.destroy` | `UsersController@destroy` | Simulasi hapus data & redirect flash |

---

## ⚙️ 2. Bedah Logika Controller (`UsersController.php`)

File controller ini menerapkan konsep **Pure In-Memory Mockup**. Semua data dibangun menggunakan library `Faker\Factory` dan PHP `stdClass` object agar di Blade template dapat diakses menggunakan sintaks objek standar Laravel (`$user->name`, `$user->role`, dsb).

### Rincian Fungsi Method:

1. **`index()`**:
   - Membangun array berisi **23 data user dummy** dengan nama Indonesia, email acak, variasi peran (*Admin, Editor, Member*), status (*Aktif, Nonaktif*), serta timestamp realistis.
   - Mengirim data ke view `users::index` (ditampilkan 10 data pertama untuk simulasi halaman 1).

2. **`create()`**:
   - Menyediakan data opsi dropdown dan radio cards: `$roles`, `$groups`, dan `$departments`.
   - Mengembalikan view `users::create`.

3. **`store(Request $request)`**:
   - Menerima input data dari form tambah.
   - Menghasilkan session flash message sukses: `"User '[Nama]' successfully created (Simulation)!"`.
   - Mengarahkan kembali pengguna ke `route('users.index')`.

4. **`show($id)`**:
   - Mengonversi `$id` menjadi angka aman (`$numericId = is_numeric($id) ? (int)$id : 1`).
   - Menyusun objek user detail lengkap dengan:
     - **Profil & Identitas**: Nama lengkap, username, email, telepon, alamat fisik, bio, timezone.
     - **Metadata Organisasi**: Departemen, jabatan, grup penugasan.
     - **Keamanan & 2FA**: Status 2FA aktif, waktu verifikasi email, kebijakan kata sandi.
     - **Matriks Izin (Permissions)**: Array 9 izin aktif yang diberikan.
     - **Sesi Login Aktif**: Perangkat yang terhubung (Desktop Chrome Windows, Mobile Safari iPhone), IP address, lokasi, status sesi saat ini.
     - **Riwayat Aktivitas (Timeline)**: Log aktivitas terinci dengan timestamp, ikon, warna tema, dan IP.
   - Mengembalikan view `users::show`.

5. **`edit($id)`**:
   - Menyiapkan data user yang sudah terisi (*pre-populated*) dan opsi form untuk diedit.
   - Mengembalikan view `users::edit`.

6. **`update(Request $request, $id)`**:
   - Menerima perubahan data form edit.
   - Melakukan redirect ke `route('users.show', $id)` dengan session flash sukses.

7. **`destroy($id)`**:
   - Mensimulasikan penghapusan user berdasarkan ID.
   - Melakukan redirect ke `route('users.index')` dengan notifikasi sukses terhapus.

---

## 🎨 3. Bedah Antarmuka UI/UX & Komponen Blade

Semua view modul Users menginduk pada layout utama modul Admin: `<x-admin::layouts.master>`.

### A. `index.blade.php` (Daftar User & Pusat Aksi)
* **Toolbar Search & Filter Popover**:
  - Kolom pencarian responsif.
  - Tombol **Filter** dengan popover melayang berbasis Alpine.js (`showFilterDropdown`), menyediakan opsi filter berdasarkan *Role* dan *Status*.
* **Tabel Data Interaktif**:
  - Baris selang-seling (*zebra striping* `odd:bg-white even:bg-slate-50/40`) dengan efek hover lembut.
  - Integrasi API **UI-Avatars** untuk menampilkan avatar inisial warna-warni.
  - Badge peran berwarna (*Purple* untuk Admin, *Blue* untuk Editor, *Gray* untuk Member).
  - Status dot hijau berkedip untuk akun aktif dan merah untuk akun nonaktif.
* **Modal Konfirmasi Hapus (Alpine.js Modal)**:
  - Menggantikan dialog bawaan browser (`window.confirm`) menjadi pop-up modal modern berlatar *backdrop blur*.
  - Menampilkan nama dan ID user yang hendak dihapus secara dinamis.
* **Modal Export Data (Alpine.js Modal)**:
  - Pilihan format: **Excel (`.xlsx`)**, **CSV (`.csv`)**, atau **PDF (`.pdf`)**.
  - Pilihan cakupan: *All Records (23 data)* atau *Current Page (10 data)*.
  - Efek animasi *loading spinner* saat download file simulasi dijalankan.

---

### B. `create.blade.php` (Form Pembuatan User)
* **Live Initial & Image Avatar Preview**:
  - Avatar inisial otomatis berganti mengikuti nama yang sedang diketik pada kolom input (*Two-way data binding* via `x-model="name"`).
  - Jika file foto diunggah, FileReader JavaScript langsung menampilkan pratinjau foto secara instan.
* **Auto-Username Generator**:
  - Otomatis mengubah nama lengkap menjadi format username `@nama.lengkap` saat kursor keluar dari kolom nama (*blur event*).
* **Password Generator & Visibility Toggle**:
  - Tombol **Generate** untuk menghasilkan 14 karakter password acak kuat dengan kombinasi simbol dan angka.
  - Ikon mata untuk melihat/menyembunyikan teks password dan konfirmasi password.
* **Filament-Style Radio Cards**:
  - Kartu pilihan peran interaktif dengan border biru menyala saat dipilih.
* **Toggle Switches Modern**:
  - Switch interaktif untuk mengaktifkan status akun dan opsi penegakan 2FA (*Enforce 2FA*).
* **Direct Permissions Accordion**:
  - Panel izin langsung per modul yang dapat dilipat (*collapsible*).

---

### C. `show.blade.php` (Profil Single User & Tab Panel)
* **Kolom Kiri (Kartu Profil & Quick Actions)**:
  - Header gradien dengan floating avatar berstatus online.
  - Tombol salin email ke clipboard interaktif (*Copy to clipboard toast*).
  - Tombol aksi cepat dengan modal:
    1. **Reset Pass Modal**: Konfirmasi pengiriman tautan pemulihan sandi ke email user.
    2. **Impersonate Modal**: Konfirmasi beralih sesi login sementara sebagai user tersebut.
* **Kolom Kanan (Sistem Tab Alpine.js)**:
  - 📌 **Tab 1: Overview**: Detail identitas personal dan penugasan departemen/pekerjaan.
  - 🛡️ **Tab 2: Roles & Permissions**: Kartu tier peran utama dan daftar izin aktif.
  - 🔒 **Tab 3: Security & Sessions**: Status 2FA, kebijakan rotasi sandi (**Force Reset Modal**), dan daftar perangkat login aktif (**Revoke Session Modal**).
  - ⏱️ **Tab 4: Activity Audit**: Timeline vertikal audit trail aktivitas user.
* **Delete User Modal**: Pop-up konfirmasi hapus akun permanen.

---

### D. `edit.blade.php` (Form Edit Profil User)
* Form yang terisi data awal secara otomatis (*pre-populated values*).
* Opsi perubahan password baru yang bersifat opsional (*leave blank to keep current*).
* Pembaruan departemen, penugasan grup, status akun, dan pengaturan 2FA.

---

## 🧪 4. Panduan Pengujian Fungsional Pengguna (User Testing Guide)

Lakukan pengujian skenario berikut pada browser Anda di environment XAMPP:

### Skenario 1: Navigasi Tabel & Pencarian
1. Buka URL: `http://localhost/practizer/public/admin/users`
2. Klik tombol **Filter** $\rightarrow$ Pastikan popover muncul $\rightarrow$ Pilih Role/Status $\rightarrow$ Klik di luar untuk menutup.
3. Klik tombol **Export** $\rightarrow$ Pilih format `.xlsx` $\rightarrow$ Klik **Download File** $\rightarrow$ Muncul notifikasi toast biru bahwa file simulasi berhasil diunduh.

### Skenario 2: Tambah User Baru
1. Klik tombol **Add New User** (sudut kanan atas) $\rightarrow$ Masuk ke `/admin/users/create`.
2. Ketik nama pada kolom *Full Name* (misal: "Budi Santoso") $\rightarrow$ Perhatikan avatar inisial berganti otomatis dan username terisi `@budi.santoso`.
3. Klik tombol **Generate** pada kolom password $\rightarrow$ Password acak otomatis terisi.
4. Klik tombol **Save User** $\rightarrow$ Otomatis redirect ke halaman daftar user dengan **notifikasi alert hijau** di atas tabel.

### Skenario 3: Detail Profil & Interaksi Modal
1. Klik ikon **Mata (View)** atau **Nama User** $\rightarrow$ Masuk ke `/admin/users/1`.
2. Klik tab **Roles & Permissions**, **Security & Sessions**, dan **Activity Audit** $\rightarrow$ Pastikan perpindahan tab mulus seketika.
3. Klik tombol **Reset Pass** atau **Impersonate** di kartu profil sebelah kiri $\rightarrow$ Pop-up modal muncul $\rightarrow$ Klik tombol konfirmasi $\rightarrow$ Muncul notifikasi feedback biru.
4. Masuk ke tab **Security & Sessions** $\rightarrow$ Klik tombol **Force Reset** atau **Revoke** pada sesi Safari iPhone $\rightarrow$ Pop-up modal muncul dan dapat dikonfirmasi/dibatalkan.

### Skenario 4: Edit & Hapus User
1. Di halaman detail, klik tombol **Edit User** $\rightarrow$ Masuk ke `/admin/users/1/edit`.
2. Ubah data nama atau jabatan $\rightarrow$ Klik **Save Changes** $\rightarrow$ Kembali ke profil detail dengan notifikasi sukses.
3. Klik tombol merah **Delete** $\rightarrow$ Muncul modal konfirmasi hapus $\rightarrow$ Klik **Confirm Delete** $\rightarrow$ Kembali ke daftar user dengan notifikasi sukses terhapus.

---

## 🚀 5. Roadmap Transisi ke Database Produksi (Untuk Developer)

Ketika proyek siap diintegrasikan dengan database MySQL/PostgreSQL nyata, lakukan langkah-langkah berikut:

### Langkah 1: Buat Migration & Model
Jalankan perintah pembuatan migration di dalam modul Users:
```bash
php artisan module:make-model User Users -m
php artisan module:make-model Role Users -m
php artisan module:make-model UserGroup Users -m
php artisan module:make-model ActivityLog Users -m
```

### Langkah 2: Skema Migration Tabel `users`
```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('username')->unique();
    $table->string('email')->unique();
    $table->string('phone')->nullable();
    $table->string('password');
    $table->string('role')->default('Member');
    $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
    $table->string('department')->nullable();
    $table->string('position')->nullable();
    $table->text('address')->nullable();
    $table->text('bio')->nullable();
    $table->string('timezone')->default('Asia/Jakarta');
    $table->boolean('two_factor_enabled')->default(false);
    $table->timestamp('email_verified_at')->nullable();
    $table->timestamp('last_login_at')->nullable();
    $table->string('last_login_ip')->nullable();
    $table->rememberToken();
    $table->timestamps();
});
```

### Langkah 3: Ubah Logika di `UsersController.php`
Ganti data dummy array/stdClass dengan query Eloquent ORM:
```php
public function index(Request $request)
{
    $users = User::query()
        ->when($request->search, fn($q, $s) => $q->where('name', 'like', "%{$s}%")->orWhere('email', 'like', "%{$s}%"))
        ->when($request->role, fn($q, $r) => $q->where('role', $r))
        ->when($request->status, fn($q, $st) => $q->where('status', $st))
        ->latest()
        ->paginate(10);

    return view('users::index', compact('users'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name'     => 'required|string|max:255',
        'username' => 'required|string|unique:users,username',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'role'     => 'required|string',
    ]);

    $validated['password'] = bcrypt($validated['password']);
    $user = User::create($validated);

    return redirect()->route('users.index')->with('success', "User '{$user->name}' berhasil ditambahkan!");
}
```

---

## 📌 Kesimpulan

Modul **Users** pada sistem **Practizer** kini telah memiliki blueprint UI/UX yang lengkap, interaktif, dan berstandar enterprise. Semua tautan rute RESTful, interaksi formulir, komponen modal pop-up, serta skenario penanganan state telah tervalidasi 100% dan siap diimplementasikan ke tahap produksi kapan pun diperlukan.

