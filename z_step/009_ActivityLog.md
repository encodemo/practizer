# Dokumentasi & Tutorial: User Activity Log & Audit Trail (TALL-Stack & FilamentPHP Mockup)

## 📌 Gambaran Umum & Nilai Strategis

Modul **User Activity Log (Audit Trail System)** berfungsi sebagai pusat pencatatan riwayat aktivitas, audit keamanan, dan pemantauan forensik sistem secara *real-time*. 

Dalam arsitektur perangkat lunak enterprise modern dan standar kepatuhan regulasi (**ISO 27001**, **SOC 2 Type II**, **GDPR**, dan **PCI-DSS**), *Activity Log* menjamin prinsip **5W + 1H** (*Who, What, Which, When, Where, How*) serta menjaga prinsip **Immutability (Kekekalan Data)**—di mana catatan log bersifat *append-only* (hanya bertambah, tidak dapat diedit/dimanipulasi).

Pada fase ini, modul diimplementasikan sebagai **Static Mockup (Database-Agnostic)** menggunakan arsitektur visual modern **TALL-Stack (Tailwind CSS, Alpine.js, Laravel Blade)** dengan pola interaksi ala **FilamentPHP**.

---

## 📂 Struktur Direktori & File Terkait

Seluruh fungsionalitas User Activity Log terintegrasi di dalam modul `Users` (menggunakan arsitektur `nwidart/laravel-modules`):

```
Modules/
├── Admin/
│   └── Resources/views/components/layouts/partials/
│       └── sidebar.blade.php             # Navigasi sidebar menu "Activity Logs"
└── Users/
    ├── Http/Controllers/
    │   └── ActivityLogController.php     # Controller simulasi generator data & aksi log
    ├── Routes/
    │   └── web.php                       # Registrasi route audit trail & retention
    └── Resources/views/
        └── logs/
            └── index.blade.php           # Master view UI/UX (KPIs, Table, & Modals)
```

---

## 🛣️ Konfigurasi Routing

Rute didaftarkan secara bersih dan terstruktur pada *route group* `admin/users`:

```php
// File: Modules/Users/Routes/web.php
Route::prefix('admin/users')->name('users.')->group(function () {
    
    // 5. Activity Logs & Audit Trail Routes
    Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index');
    Route::post('/logs/purge', [ActivityLogController::class, 'purge'])->name('logs.purge');
    Route::get('/logs/{id}', [ActivityLogController::class, 'show'])->name('logs.show')->whereNumber('id');
    Route::delete('/logs/{id}', [ActivityLogController::class, 'destroy'])->name('logs.destroy')->whereNumber('id');

});
```

*Named routes* yang tersedia:
- `users.logs.index` $\rightarrow$ `GET /admin/users/logs` (Halaman utama audit log)
- `users.logs.purge` $\rightarrow$ `POST /admin/users/logs/purge` (Simulasi pembersihan log lama)
- `users.logs.show` $\rightarrow$ `GET /admin/users/logs/{id}` (Detail inspeksi log)
- `users.logs.destroy` $\rightarrow$ `DELETE /admin/users/logs/{id}` (Simulasi arsip log)

---

## 🎨 Arsitektur & Fitur UI/UX (TALL-Stack / Filament Style)

### 1. Filament-Style KPI Metric Widgets
Bagian atas halaman dilengkapi 4 kartu ringkasan analitik interaktif:
- **Total Activities:** Menampilkan jumlah total event log dalam buffer aktif (+12% tren aktivitas).
- **Security & Alerts:** Menghitung insiden keamanan, kegagalan otentikasi (*failed login*), dan modifikasi hak akses.
- **Auth & Sessions:** Menghitung event login, logout, reset password, dan impersonasi akun.
- **Active Operators:** Menampilkan jumlah operator/user unik yang aktif melakukan aksi di sistem.

### 2. Quick Filter Tabs & Faceted Search Toolbar
- **Quick Tabs:** Tombol filter instan berbasis Alpine.js untuk beralih antara:
  - `All Activities` (Semua event)
  - `Security Alerts` (Event peringatan & bahaya)
  - `Auth & Sessions` (Event otentikasi)
  - `Data Modifications` (Event yang memiliki perubahan nilai data / diff)
  - `System Maintenance` (Event konfigurasi & cache sistem)
- **Universal Search Bar:** Pencarian real-time untuk nama user, email, IP address, deskripsi, ataupun kode log.
- **Faceted Filter Popover:** Dropdown panel Alpine.js (`x-show`, `x-transition`, `@click.outside`) untuk memfilter berdasarkan *Target Module* (`Users`, `Roles`, `Settings`, `Auth`, `System`) dan *Severity Level* (`Info`, `Success`, `Warning`, `Danger`).

### 3. Interactive Audit Trail Table
- **Actor / Causer:** Menampilkan avatar UI-Avatars, nama lengkap, dan badge peran user.
- **Severity Badging:** Kode warna standar industri:
  - 🔵 **Info (Blue):** Aktivitas standar (login sukses, navigasi, ekspor data).
  - 🟢 **Success (Green):** Pembuatan entitas baru (*user created*, *role added*).
  - 🟡 **Warning (Amber):** Modifikasi data sensitif, reset password, impersonasi.
  - 🔴 **Danger (Rose):** Kegagalan login (*failed auth*), penghapusan akun (*user deleted*).
- **Endpoint & HTTP Method:** Badge metode HTTP (`GET`, `POST`, `PUT`, `DELETE`) beserta path URI.
- **Client & Geolocation:** Menampilkan IP address, deteksi perangkat (*Desktop / Mobile*), dan lokasi geografis.
- **Relative Timestamp:** Waktu relatif (*human diff*) dan timestamp ISO presisi.

### 4. Alpine.js Modal 1: Forensic & JSON Diff Inspector
Ketika baris log atau tombol *Inspect* (ikon mata) diklik:
- Terbuka pop-up modal tanpa memuat ulang halaman (*zero page reload*).
- Menampilkan rincian lengkap operator, request URI, client user-agent, dan geolocation.
- **Visual Payload Diff Box:**
  - 🔴 **Before (Old Values):** Box merah muda yang menampilkan nilai data sebelum diubah.
  - 🟢 **After (New Values):** Box hijau muda yang menampilkan nilai data baru setelah diubah.

### 5. Alpine.js Modal 2: Export Data Audit
- Dialog modal untuk mengunduh log audit ke format:
  - **Excel (`.xlsx`)**
  - **CSV Comma-separated**
  - **PDF Printable Report**
  - **Raw JSON Diff**
- Pilihan lingkup data (*All Indexed Logs* vs *Filtered View Only*).
- Disertai animasi loading spinner dan toast notifikasi sukses.

### 6. Alpine.js Modal 3: Retention Policy Purge (Danger Zone)
- Dialog konfirmasi berlapis untuk mematuhi kebijakan penyimpanan log (*Data Retention Policy*).
- Pilihan batas usia log yang ingin diarsipkan (30 hari, 90 hari, 180 hari, 1 tahun).
- Memberikan peringatan bahwa pembersihan log bersifat permanen.

### 7. Zero Native DOM Alerts/Confirms
- Seluruh konfirmasi aksi dan umpan balik pengguna **100% menggunakan pop-up modal dan toast animasi Alpine.js**, tanpa menggunakan `window.alert()` atau `window.confirm()` bawaan browser.

---

## 📖 Panduan Pengguna (User Guide)

### A. Membaca & Menyaring Log Aktivitas
1. Buka menu navigasi sidebar **Users Management > Activity Logs**.
2. Gunakan **Quick Tabs** di atas tabel untuk melihat kategori tertentu (misal: klik tab **Security Alerts** untuk melihat potensi ancaman atau kegagalan login).
3. Ketikkan kata kunci pada kolom pencarian (misal: `192.168.1.105` atau `Budi`) untuk memfilter data secara instan.
4. Klik tombol **Faceted Filter** untuk menyaring data berdasarkan modul tertentu.

### B. Menginspeksi Perubahan Data (Payload Diff)
1. Pada tabel log aktivitas, klik pada baris log mana saja atau klik ikon **Mata (Inspect)** di kolom paling kanan.
2. Modal **Audit Record Inspector** akan terbuka.
3. Periksa panel **Payload Diff & Attribute Changes**:
   - Kolom kiri **Before (Old Values)** menunjukkan data lama sebelum diedit.
   - Kolom kanan **After (New Values)** menunjukkan data baru hasil perubahan.
4. Klik **Close Inspector** untuk kembali ke tabel.

### C. Mengekspor Log Audit
1. Klik tombol **Export Audit Trail** di sudut kanan atas halaman.
2. Pilih format file yang diinginkan (**Excel**, **CSV**, **PDF**, atau **JSON**).
3. Tentukan cakupan data (*All Logs* atau *Filtered Only*).
4. Klik **Download Log**. Toast notifikasi akan muncul mengonfirmasi bahwa file berhasil digenerate.

### D. Menjalankan Kebijakan Retensi (Purge Logs)
1. Klik tombol **Purge Logs** (tombol merah di samping Export).
2. Pilih batas waktu retensi (misal: *Lebih dari 90 Hari yang lalu*).
3. Klik tombol **Confirm Purge Policy**. Sistem akan memproses pengarsipan log lama dan menampilkan konfirmasi sukses.

---

## 💻 Panduan Developer: Migrasi ke Mode Production

Ketika proyek siap dihubungkan ke basis data MySQL/PostgreSQL dan diimplementasikan secara dinamis, ikuti panduan berikut:

### 1. Integrasi Paket `spatie/laravel-activitylog`
Pasang paket standar industri untuk pencatatan log di Laravel:
```bash
composer require spatie/laravel-activitylog
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"
php artisan migrate
```

### 2. Menambahkan Trait Logging pada Model Eloquent
Cukup tambahkan trait `LogsActivity` pada model yang ingin dipantau (misalnya `User.php`, `Role.php`, `Setting.php`):

```php
namespace Modules\Users\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use LogsActivity;

    protected $fillable = ['name', 'email', 'password', 'role', 'status'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'role', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('Users')
            ->setDescriptionForEvent(fn(string $eventName) => "User account has been {$eventName}");
    }
}
```

### 3. Mengimplementasikan Controller Production
Ubah data simulasi pada `ActivityLogController.php` menjadi kueri Eloquent asli:

```php
namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('causer')->latest();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('log_name', 'like', "%{$search}%")
                  ->orWhereHasMorph('causer', ['App\Models\User', 'Modules\Users\Entities\User'], function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter Modul
        if ($module = $request->input('module')) {
            $query->where('log_name', $module);
        }

        $logs = $query->paginate(15);

        $stats = (object) [
            'total_logs'      => Activity::count(),
            'security_alerts' => Activity::whereIn('event', ['failed_login', 'deleted', 'role_changed'])->count(),
            'auth_events'     => Activity::where('log_name', 'Auth')->count(),
            'active_causers'  => Activity::whereNotNull('causer_id')->distinct('causer_id')->count('causer_id'),
        ];

        $modules = ['Users', 'Roles', 'Permissions', 'Settings', 'Auth', 'System'];

        return view('users::logs.index', compact('logs', 'stats', 'modules'));
    }

    public function purge(Request $request)
    {
        $days = (int) $request->input('days', 90);
        
        // Menghapus log lebih tua dari X hari
        Activity::where('created_at', '<', now()->subDays($days))->delete();

        return redirect()->route('users.logs.index')->with('success', "Audit logs older than {$days} days purged successfully.");
    }
}
```

### 4. Menjadwalkan Otomasi Pembersihan Log (Scheduled Job)
Tambahkan perintah pembersihan otomatis di `routes/console.php` atau scheduler Laravel:

```php
use Illuminate\Support\Facades\Schedule;

// Bersihkan log yang berusia lebih dari 90 hari setiap hari Minggu jam 00:00
Schedule::command('activitylog:clean --days=90')->weeklyOn(0, '00:00');
```

---

*Dokumentasi ini disusun sebagai standar baku arsitektur User Activity Log & Audit Trail pada aplikasi Practizer.*

