# Dokumentasi & Tutorial: User Group Management (Mockup)

## 📌 Gambaran Umum
Modul **User Group Management** berfungsi sebagai antarmuka untuk mengelola grup pengguna (seperti *Super Administrator, Manager, Staff*) beserta hak akses (permissions) yang dimiliki oleh masing-masing grup. 

Saat ini, modul diimplementasikan dalam fase **Static Mockup (Tanpa Database)**. Tujuan utama fase ini adalah menyajikan rancangan UI/UX yang matang, interaktif, dan konsisten menggunakan standar TALL-stack (Tailwind CSS, Alpine.js) serta pendekatan visual ala FilamentPHP, sebelum fungsionalitas *backend* dan *database* diterapkan sepenuhnya.

---

## 📂 Struktur Direktori & File Terkait

Seluruh fungsionalitas ini merupakan bagian dari modul `Users` (menggunakan arsitektur `nwidart/laravel-modules`). Berikut adalah file-file kunci yang digunakan:

1. **Controller:** 
   `modules/Users/Http/Controllers/UserGroupController.php`
2. **Routes:** 
   `modules/Users/routes/web.php`
3. **Views:** 
   Berada di direktori terpisah untuk menghindari konflik dengan modul user utama:
   - `modules/Users/resources/views/groups/index.blade.php`
   - `modules/Users/resources/views/groups/create.blade.php`
   - `modules/Users/resources/views/groups/edit.blade.php`

---

## 🛣️ Konfigurasi Routing
Rute dikonfigurasi menggunakan standar RESTful API Laravel (`Route::resource`), yang ditempatkan di dalam *route group* modul Users.

```php
// File: modules/Users/routes/web.php
Route::prefix('admin/users')->name('users.')->group(function () {
    // ... rute lain ...
    
    // Rute resource untuk User Groups
    Route::resource('groups', UserGroupController::class);
});
```
Dengan konfigurasi ini, Laravel otomatis menyediakan rute bernama seperti `users.groups.index`, `users.groups.create`, `users.groups.store`, dll.

---

## 💻 Panduan Developer: Mekanisme Controller & Mockup Data
Karena belum menggunakan database, controller `UserGroupController` menggunakan variabel *array* private bernama `$dummyGroups` untuk menyimulasikan data dari *database* atau *Model Eloquent*.

**Contoh Implementasi Controller:**
```php
class UserGroupController extends Controller
{
    private $dummyGroups = [
        [
            'id' => 1,
            'name' => 'Super Administrator',
            'description' => 'Memiliki akses penuh ke seluruh sistem.',
            'users_count' => 2,
            'status' => 'active',
            'created_at' => '2026-08-20 10:00:00'
        ],
        // ... data lainnya ...
    ];

    public function index()
    {
        return view('users::groups.index', ['groups' => $this->dummyGroups]);
    }

    // Simulasi penyimpanan (Store)
    public function store(Request $request) 
    {
        return redirect()->route('users.groups.index')
                         ->with('success', 'User Group berhasil ditambahkan.');
    }
}
```
Setiap aksi manipulasi data (`store`, `update`, `destroy`) dirancang untuk langsung melakukan *redirect* kembali ke halaman `index` dengan membawa *Flash Session* (`success`) untuk mendemonstrasikan munculnya notifikasi *alert*.

---

## 🎨 Arsitektur UI/UX (Frontend)
Desain antarmuka dibuat agar sangat konsisten dengan rancangan utama. Berikut adalah komponen utama penyusun UI:

### 1. Sistem Layout & CSS
- **Blade Component (`<x-admin::layouts.master>`)**: Digunakan di semua view sebagai kerangka *wrapper* utama (Sidebar, Header, Footer).
- **Tailwind CSS**: Memberikan gaya panel/card yang modern, dukungan mode *dark*, dan penyesuaian tata letak grid/flex.
- **Warna Utama**: Menggunakan utility class `bg-primary`, `text-primary`, dan `focus:ring-primary` agar warna identitas seragam dengan halaman aplikasi lainnya.

### 2. Standar Ikon & Breadcrumbs
- **Iconify**: Semua SVG statis telah diganti menggunakan sintaks *Iconify* (`<span class="iconify" data-icon="..."></span>`).
- **Breadcrumbs**: Navigasi hierarki selalu ditambahkan di atas setiap judul halaman untuk memandu orientasi *user* (cth: `Dashboard > Users > User Groups > Create New Group`).

### 3. Interaktivitas via Alpine.js (`x-data`)
UI tidak bergantung pada jQuery, melainkan memanfaatkan **Alpine.js** secara *native* pada HTML:
- **Modal Delete (di `index.blade.php`)**: Membuka modal pop-up konfirmasi dan secara dinamis mengubah URL tujuan penghapusan.
- **Toggle Switch (di `create`/`edit.blade.php`)**: Mengubah elemen *checkbox* atau *select* tradisional menjadi *UI toggle* interaktif yang bereaksi seketika terhadap klik pengguna.
- **Flash Alerts**: Notifikasi `session('success')` bisa tertutup (dismiss) secara perlahan berkat bantuan atribut `x-show` dan `x-transition`.

---

## 🚀 Panduan Migrasi ke Mode Production (Langkah Selanjutnya)
Apabila struktur *mockup* ini sudah disetujui untuk diubah menjadi fitur nyata, berikut adalah *checklist* langkah yang perlu developer lakukan di masa mendatang:

1. **Database & Model:**
   - Buat Migration table `user_groups`.
   - Buat Model `UserGroup` (di `Modules\Users\Models\UserGroup`).
   - Buat tabel pivot `user_group_permissions` atau integrasikan paket seperti `spatie/laravel-permission`.
2. **Controller Logic:**
   - Hapus variabel `$dummyGroups`.
   - Pada method `index()`, ubah menjadi `$groups = UserGroup::paginate(10);`
   - Implementasikan Laravel *Form Request Validation* pada method `store()` dan `update()`.
   - Ubah logika *store*, *update*, dan *destroy* dengan kueri Eloquent untuk berinteraksi dengan tabel sesungguhnya.
3. **Penyempurnaan View:**
   - Sambungkan pagination Laravel sungguhan (via `$groups->links()`) untuk menggantikan pagination *dummy* di `index.blade.php`.

---
*Dokumentasi ini ditulis sebagai referensi berkelanjutan dalam proses pengembangan framework TALL-stack pada proyek Practizer.*

