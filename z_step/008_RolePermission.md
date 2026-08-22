# Dokumentasi & Tutorial: Role & Permission Management (Skenario Hybrid Mockup)

## 📌 Gambaran Umum

Modul **Role & Permission Management** berfungsi sebagai pusat kendali otorisasi (*Role-Based Access Control / RBAC*) untuk mengatur hierarki peran pengguna (*roles*) dan penugasan izin akses granular (*permissions*) pada setiap modul sistem.

Pada fase ini, modul diimplementasikan sebagai **Static Mockup (Database-Agnostic)** menggunakan arsitektur **Skenario Hybrid**. Pendekatan ini menggabungkan kemudahan navigasi *Tabbed Interface* dengan kekuatan antarmuka *Dedicated Page* bervolume luas untuk memuat **Permission Matrix** berstandar visual TALL-stack (Tailwind CSS, Alpine.js) serta pola interaksi ala **FilamentPHP**.

---

## 📂 Struktur Direktori & File Terkait

Seluruh fungsionalitas ini ditempatkan dalam modul `Users` (menggunakan arsitektur `nwidart/laravel-modules`):

```
Modules/Users/
├── Http/Controllers/
│   ├── RoleController.php           # Mengelola alur CRUD Role & penugasan Matrix
│   └── PermissionController.php     # Mengelola alur CRUD Master Data Permission
├── Routes/
│   └── web.php                      # Registrasi RESTful Resource Routes
└── Resources/views/
    ├── roles/
    │   ├── index.blade.php          # Tabbed View (Roles & Master Permissions)
    │   ├── create.blade.php         # Dedicated Page Form Create Role + Matrix
    │   └── edit.blade.php           # Dedicated Page Form Edit Role + Matrix
    └── permissions/
        ├── create.blade.php         # Dedicated Page Form Create Master Permission
        └── edit.blade.php           # Dedicated Page Form Edit Master Permission
```

---

## 🛣️ Konfigurasi Routing

Rute didaftarkan menggunakan standar RESTful Resource Controller di dalam *route group* `admin/users`:

```php
// File: Modules/Users/Routes/web.php
Route::prefix('admin/users')->name('users.')->group(function () {
    // 1. System Roles Resource
    Route::resource('roles', RoleController::class);

    // 2. Master Permissions Resource
    Route::resource('permissions', PermissionController::class);
});
```

*Named routes* yang otomatis tersedia meliputi:
- `users.roles.index`, `users.roles.create`, `users.roles.edit`, `users.roles.update`, `users.roles.destroy`
- `users.permissions.create`, `users.permissions.edit`, `users.permissions.update`, `users.permissions.destroy`

---

## 🎨 Arsitektur & Fitur UI/UX (Skenario Hybrid)

### 1. Tabbed Interface pada Halaman Utama (`roles/index.blade.php`)
- Menggabungkan data **System Roles** dan **Master Permissions** dalam satu entri navigasi *sidebar* (`Roles & Permissions`).
- Menggunakan state Alpine.js (`activeTab: 'roles' | 'permissions'`) untuk transisi tab instan tanpa *page reload*.
- Tombol aksi di *header* ("Create Role" atau "Create Permission") berganti otomatis sesuai tab yang sedang aktif.

### 2. Permission Matrix pada Halaman Penuh (`roles/create.blade.php` & `roles/edit.blade.php`)
- Form Create/Edit menggunakan **Dedicated Page** untuk memberikan ruang yang optimal bagi matriks izin.
- Izin dikelompokkan secara visual ke dalam kartu-kartu modul (**Users Module**, **Settings Module**, **Roles Module**).
- Dilengkapi fitur interaktif **Select All Permissions** yang secara reaktif mencentang seluruh *checkbox* modul melalui Alpine.js.

### 3. Proteksi Kunci Izin (*Read-Only Permission Key*)
- Pada form edit permission (`permissions/edit.blade.php`), input `Permission Key` (seperti `delete_users`) diatur menjadi **Read-Only**.
- Mencegah perubahan sembarangan pada *string identifier* yang dapat merusak pengecekan izin programatik di *source code* (seperti `Gate::allows()` atau `@can`).

### 4. Proteksi Aksi Hapus & Modal Pop-Up UI (Tanpa DOM Alert)
- Semua konfirmasi aksi dan penolakan izin **100% menggunakan Modal Pop-Up UI (Alpine.js)** dengan *backdrop blur* dan animasi transisi `x-transition`.
- **Simulasi Super User:** Terdapat tombol *toggle* interaktif di *header* untuk beralih antara *Normal Admin Mode* dan *Super User Mode*.
- Jika user non-super admin mencoba menghapus:
  - Muncul pop-up modal peringatan **"Super User Access Required"**.
  - Aksi *delete* diblokir secara visual.
- Jika dalam mode *Super User*:
  - Muncul pop-up modal **"Confirm Delete"** dengan opsi *Confirm* atau *Cancel*.

---

## 📖 Panduan Pengguna (User Guide)

### A. Mengelola Role & Menetapkan Hak Akses
1. Buka menu **Users Management > Roles & Permissions**.
2. Pada tab **System Roles**, klik tombol **"Create Role"** untuk menambah role baru atau icon pensil untuk mengedit role yang ada.
3. Masukkan **Role Name** (misalnya: *Marketing Staff*).
4. Pada panel **Permission Matrix**, centang izin yang ingin diberikan ke role tersebut, atau gunakan opsi **Select All Permissions**.
5. Klik **"Save Role & Permissions"** untuk menyimpan.

### B. Mengelola Master Data Permission
1. Buka menu **Users Management > Roles & Permissions** lalu klik tab **Master Permissions**.
2. Klik tombol **"Create Permission"** untuk mendaftarkan kunci izin baru.
3. Masukkan nama kunci (contoh: `publish_articles`), pilih kelompok modul, dan berikan deskripsi ringkas.
4. Klik **"Save Permission"**.

### C. Menguji Simulasi Proteksi Penghapusan (Super User Guard)
1. Perhatikan *toggle switch* di sudut kanan atas tabel.
2. Saat posisi **Normal Admin Mode**, klik ikon tempat sampah pada salah satu baris Role/Permission. Sistem akan memunculkan pop-up **"Super User Access Required"**.
3. Klik *toggle* hingga berubah ke **Super User Mode**.
4. Klik kembali ikon tempat sampah, maka pop-up **"Confirm Delete"** akan terbuka dan siap dieksekusi.

---

## 💻 Panduan Developer: Migrasi ke Production

Ketika sistem siap dihubungkan ke basis data, ikuti panduan teknis berikut:

### 1. Integrasi Spatie Laravel Permission (Rekomendasi Utama)
Pasang paket otorisasi standar industri:
```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

### 2. Implementasi Controller
Ubah controller dari data simulasi menjadi kueri Eloquent:

```php
// RoleController.php
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

public function index()
{
    $roles = Role::withCount('users')->with('permissions')->get();
    $permissions = Permission::all();
    return view('users::roles.index', compact('roles', 'permissions'));
}

public function update(Request $request, $id)
{
    $role = Role::findOrFail($id);
    $role->update(['name' => $request->name]);
    
    // Sinkronkan seluruh checkbox dari Permission Matrix
    $role->syncPermissions($request->input('permissions', []));
    
    return redirect()->route('users.roles.index')->with('success', 'Role & Permissions berhasil diperbarui.');
}
```

### 3. Tips Penulisan Template Blade
Jika ingin mencetak string contoh direktif `@can` sebagai teks biasa di file `.blade.php`, pastikan selalu menuliskan tanda ganda `@@can`:
```blade
<!-- Benar (Dicetak sebagai teks murni di HTML) -->
<code>@@can('delete_users')</code>

<!-- Salah (Akan memicu ParseError syntax error) -->
<code>@can('delete_users')</code>
```

---

*Dokumentasi ini disusun sebagai standar baku arsitektur RBAC modul Users pada aplikasi Practizer.*

