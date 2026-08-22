# Dokumentasi & Tutorial: Module Settings & System Diagnostics (TALL-Stack & FilamentPHP Mockup)

## 📌 Gambaran Umum & Nilai Strategis

Modul **Settings & System Diagnostics** berfungsi sebagai pusat kendali konfigurasi global, tata kelola keamanan, infrastruktur komunikasi email, manajemen cadangan data (*backup*), serta pemantauan kesehatan server dan log error teknis secara *real-time*.

Dalam arsitektur aplikasi enterprise modern, modul **Settings** menerapkan prinsip:
1. **Centralized Configuration**: Seluruh parameter aplikasi (nama sistem, timezone, SMTP, kebijakan password) dikelola secara dinamis tanpa perlu mengubah file konfigurasi fisik di server secara manual.
2. **Separation of Concerns (SoC)**:
   - **User Activity Log** (pada modul `Users`): Mencatat audit trail bisnis (*Who did What*).
   - **System Logs** (pada modul `Settings`): Mencatat kesehatan infrastruktur, exception error PHP/Laravel (`laravel.log`), status memory, dan beban partisi storage.
3. **Safety & High Availability**: Menjamin ketersediaan fitur *Maintenance Mode*, *Automated Database Snapshot*, serta proteksi *Brute-Force Rate Limiting*.

Pada fase pengembangan ini, modul diimplementasikan sebagai **Static Mockup (Database-Agnostic)** menggunakan arsitektur visual modern **TALL-Stack (Tailwind CSS, Alpine.js, Laravel Blade)** dengan pola interaksi ala **FilamentPHP**.

---

## 📂 Struktur Direktori & File Terkait

Seluruh fungsionalitas ini ditempatkan di dalam modul `Settings` (menggunakan arsitektur `nwidart/laravel-modules`):

```
Modules/Settings/
├── Http/
│   └── Controllers/
│       └── SettingsController.php           # Controller pengelola 5 sub-halaman & action simulator
├── Routes/
│   └── web.php                              # Registrasi 16 rute navigasi & action endpoints
└── Resources/
    └── views/
        ├── components/
        │   └── settings-nav.blade.php       # Shared Top Tab Navigation component
        ├── general.blade.php                # Submenu 1: Profil aplikasi, regional & maintenance mode
        ├── security.blade.php               # Submenu 2: Kebijakan password, brute force & 2FA
        ├── mail.blade.php                   # Submenu 3: SMTP Mailer relay & Pop-up Modal Test Mail
        ├── backup.blade.php                 # Submenu 4: Manajemen snapshot, disk quota & cache optimize
        ├── logs.blade.php                   # Submenu 5: Real-time laravel.log viewer & stack trace modal
        └── index.blade.php                  # Alias default include ke general settings
```

Serta terhubung langsung dengan navigasi master:
- `Modules/Admin/Resources/views/components/layouts/partials/sidebar.blade.php`: Navigasi *collapsible accordion* dengan *dynamic active state highlighting*.

---

## 🛣️ Konfigurasi Routing

Rute modul didaftarkan menggunakan *route group* ber-prefix `admin/settings` dengan *name prefix* `settings.`:

```php
// File: Modules/Settings/Routes/web.php
Route::prefix('admin/settings')->name('settings.')->group(function () {
    
    // 1. General Settings
    Route::get('/', [SettingsController::class, 'general'])->name('index');
    Route::get('/general', [SettingsController::class, 'general'])->name('general');
    Route::post('/general', [SettingsController::class, 'updateGeneral'])->name('general.update');

    // 2. Security & Access Policies
    Route::get('/security', [SettingsController::class, 'security'])->name('security');
    Route::post('/security', [SettingsController::class, 'updateSecurity'])->name('security.update');

    // 3. Mail Server (SMTP)
    Route::get('/mail', [SettingsController::class, 'mail'])->name('mail');
    Route::post('/mail', [SettingsController::class, 'updateMail'])->name('mail.update');
    Route::post('/mail/test', [SettingsController::class, 'sendTestMail'])->name('mail.test');

    // 4. Backup & Storage Maintenance
    Route::get('/backup', [SettingsController::class, 'backup'])->name('backup');
    Route::post('/backup/create', [SettingsController::class, 'createBackup'])->name('backup.create');
    Route::get('/backup/download/{filename}', [SettingsController::class, 'downloadBackup'])->name('backup.download');
    Route::delete('/backup/delete/{filename}', [SettingsController::class, 'deleteBackup'])->name('backup.destroy');
    Route::post('/backup/optimize', [SettingsController::class, 'optimize'])->name('backup.optimize');

    // 5. System Logs & Server Diagnostics
    Route::get('/logs', [SettingsController::class, 'logs'])->name('logs');
    Route::get('/logs/download', [SettingsController::class, 'downloadLogs'])->name('logs.download');
    Route::post('/logs/clear', [SettingsController::class, 'clearLogs'])->name('logs.clear');

});
```

---

## 🎨 Arsitektur & Fitur UI/UX (5 Submenu Inti)

### 1. General Settings (`settings/general.blade.php`)
* **Identitas Aplikasi**: Input Nama Aplikasi, Tagline/Slogan, URL Endpoint, Email Kontak Admin, dan Deskripsi SEO.
* **Regional & Localization**: Dropdown zona waktu sistem (*Asia/Jakarta WIB, WITA, WIT, UTC*), bahasa default (*Bahasa Indonesia / English*), format tanggal (*d M Y*), dan simbol mata uang (*IDR Rp*).
* **Asset Branding**: Area preview upload Logo Aplikasi dan Favicon browser.
* **Maintenance Mode Switch**: Toggle switch interaktif Alpine.js untuk mengaktifkan status *Maintenance* disertai input kustomisasi pesan pengumuman publik kepada pengunjung.

### 2. Security & Access Policies (`settings/security.blade.php`)
* **Password Complexity Matrix**: Pengaturan panjang minimal karakter password, masa rotasi/kadaluarsa password (hari), serta checkbox penegakan karakter kapital (*Uppercase*), angka (*Numeric*), dan simbol khusus (*Special Characters*).
* **Brute-Force & Session Protection**: Konfigurasi batas waktu inaktivitas sesi (*Session Timeout*), batas percobaan login gagal (*Max Login Attempts*), dan durasi penguncian akun sementara (*Lockout Duration*).
* **Two-Factor Authentication (2FA)**: Toggle aktivasi 2FA berbasis aplikasi (*Google Authenticator / Authy*) dan opsi penegakan wajib untuk seluruh level Administrator.
* **Admin IP Whitelist**: Area konfigurasi daftar alamat IP atau blok subnet CIDR yang diberi hak istimewa mengakses panel admin.

### 3. Mail Server - SMTP (`settings/mail.blade.php`)
* **Relay Parameters**: Pilihan transport driver (*SMTP, Mailgun, Amazon SES, Postmark, Log*), Host Server, Port (*587 / 465*), Username, Password (dengan tombol *Show/Hide Password*), dan Protokol Enkripsi (*TLS / SSL*).
* **Sender Profile**: Nama pengirim (*From Name*) dan alamat email pengirim (*From Email Address*).
* **Interactive Pop-up Modal ("Send Test Email")**: Dialog pop-up bertenaga Alpine.js untuk mengirimkan pesan uji coba diagnostik secara instan ke email penerima guna memvalidasi *handshake* dan sertifikat TLS.

### 4. Backup & Storage Maintenance (`settings/backup.blade.php`)
* **KPI Metrics Storage**: Kartu statistik jumlah snapshot, *Storage Used vs Free Bar* (2.4 GB / 200 GB), status *Cache Driver* (`file`/`redis`), dan *Queue Worker*.
* **Tabel Riwayat Backup**: Daftar file snapshot arsip database (`.sql.gz`) dan full zip beserta ukuran file, lokasi disk storage, dan tanggal pembuatan.
* **Interactive Actions & Pop-up Modals**:
  * Tombol **"Create Backup Now"**: Memicu pembuatan cadangan baru secara asinkron.
  * Tombol **"Optimize Cache"**: Menjalankan optimasi kompilasi cache routes, config, dan views.
  * Tombol **"Download Snapshot"**: Mengunduh file backup arsip ke komputer lokal.
  * **Pop-up Modal Restore**: Dialog konfirmasi peringatan keamanan sebelum memulihkan database.
  * **Pop-up Modal Delete**: Dialog konfirmasi penghapusan permanen file backup dari storage.

### 5. System Logs & Diagnostics (`settings/logs.blade.php`)
* **Server Health Cards**: 6 indikator real-time: Runtime PHP (`8.2.12`), Framework (`v12.12.2`), OS Server (`Windows 10 x64`), Konsumsi Memory RAM, Server Uptime (`99.98%`), dan Ukuran File Log.
* **Real-time Log Stream**: Membaca file `storage/logs/laravel.log` asli dan menyediakan fallback data mockup realistis jika log kosong.
* **Faceted Search & Level Filter**: Pencarian teks error cepat dan filter tingkat keparahan (*Severity*: `CRITICAL/EMERGENCY`, `ERROR`, `WARNING`, `INFO`, `DEBUG`).
* **Interactive Pop-up Modals**:
  * **Stack Trace Inspector Modal**: Menampilkan trace dump exception dalam format code block bertema gelap (*dark terminal style*), lengkap dengan tombol **"Copy Trace"** (dengan animasi feedback tersalin).
  * **Purge Log File Modal**: Dialog konfirmasi untuk mengosongkan isi file log sistem.

---

## 🧩 Komponen Navigasi Terpadu (`settings-nav.blade.php`)

Untuk memastikan transisi antar-halaman di modul Settings berlangsung mulus, digunakan komponen Blade terpadu:

```html
<!-- Contoh pemanggilan pada view -->
<x-settings::settings-nav active="general" />
```

Komponen ini merender 5 tab navigasi horizontal di bagian atas halaman dengan indikator aktif (*blue underline* dan teks tebal primer), selaras dengan gaya navigasi modern FilamentPHP.

---

## 👥 Panduan Pengguna (User / Administrator Manual)

### 1. Mengubah Identitas & Timezone Sistem
1. Masuk ke menu **Settings $\rightarrow$ General**.
2. Ubah *Application Name*, *Tagline*, atau *Admin Email*.
3. Pada kartu **Regional & Localization**, pilih zona waktu lokal Anda (misal: `Asia/Jakarta`).
4. Klik tombol **"Save General Settings"** pada pojok kanan atas atau bagian bawah halaman.

### 2. Mengaktifkan Mode Pemeliharaan (Maintenance Mode)
1. Buka halaman **General Settings**.
2. Pada panel samping kanan, cari kartu **Maintenance Mode**.
3. Klik tombol switch hingga berubah menjadi warna oranye (*Mode: ACTIVE*).
4. Masukkan pesan pemberitahuan yang ingin ditampilkan kepada publik pada textarea yang muncul.
5. Klik **"Save General Settings"**.

### 3. Menguji Koneksi Email SMTP
1. Buka menu **Settings $\rightarrow$ Mail Server**.
2. Masukkan Host, Port, Username, Password, dan Enkripsi SMTP Anda.
3. Klik tombol **"Send Test Email"** di bagian *header* atau kartu *Connection Status*.
4. Masukkan alamat email tujuan pada Pop-up Modal, lalu klik **"Send Test Email"**.
5. Sistem akan menampilkan notifikasi toast sukses apabila pesan uji coba berhasil dikirim.

### 4. Melakukan Backup Database & Optimasi Sistem
1. Buka menu **Settings $\rightarrow$ Backup & DB**.
2. Klik tombol **"Create Backup Now"** untuk membuat snapshot baru. File cadangan baru akan muncul pada tabel riwayat.
3. Klik tombol **"Optimize Cache"** untuk membersihkan file cache sementara dan mempercepat respon aplikasi.
4. Gunakan ikon unduh pada tabel untuk menyimpan file backup ke media eksternal.

### 5. Memeriksa Log Error & Menginspeksi Stack Trace
1. Buka menu **Settings $\rightarrow$ System Logs**.
2. Pantau metrik kesehatan server pada kartu KPI di baris atas.
3. Gunakan kolom pencarian atau filter tingkat keparahan (*Severity*) untuk menemukan error spesifik.
4. Klik tombol **"Stack Trace"** pada baris error yang ingin diselidiki.
5. Pop-up Modal akan terbuka menampilkan baris kode dan exception detail. Klik **"Copy Trace"** untuk menyalin teks log ke clipboard jika ingin dikirimkan ke tim developer.

---

## 💻 Panduan Pengembang (Developer Reference & Production Transition)

Saat beralih dari mode Mockup ke Database & Production, integrasikan pustaka (*packages*) standar Laravel berikut:

### 1. Rekomendasi Package Ekosistem Laravel

| Fungsi | Package Rekomendasi | Cara Kerja di Mode Production |
| :--- | :--- | :--- |
| **Settings Storage** | `spatie/laravel-settings` | Menyimpan pasangan key-value konfigurasi di tabel `settings` database dengan tipe data ter-cast kuat (*strongly-typed*). |
| **Backup System** | `spatie/laravel-backup` | Menjalankan snapshot database MySQL/PostgreSQL dan kompresi media ke Cloud Storage (AWS S3 / Google Cloud Storage). |
| **2FA Authentication** | `pragmarx/google2fa-laravel` atau Laravel Fortify | Mengelola QR-code TOTP handshake dan verifikasi 6 digit OTP. |
| **Log Management** | `rap2hpoutre/laravel-log-viewer` atau Monolog Handler | Melakukan rotasi file log harian (*daily channel*) dan parsing multi-file logs. |

### 2. Skema Tabel Database `settings` (Production Migration)

```sql
CREATE TABLE `settings` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `group` VARCHAR(100) NOT NULL INDEX,  -- general, security, mail, backup
    `name` VARCHAR(100) NOT NULL,
    `locked` BOOLEAN NOT NULL DEFAULT 0,
    `payload` JSON NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    UNIQUE KEY `settings_group_name_unique` (`group`, `name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 3. Implementasi Service Class Simpan Pengaturan

```php
namespace App\Services;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $app_name;
    public string $app_tagline;
    public string $timezone;
    public bool $maintenance_mode;

    public static function group(): string
    {
        return 'general';
    }
}
```

### 4. Perintah Verifikasi & Testing CLI

Untuk memvalidasi sintaks dan integritas rute modul Settings:

```powershell
# 1. Linting validasi sintaks PHP
php -l modules/Settings/Http/Controllers/SettingsController.php
php -l modules/Settings/Resources/views/general.blade.php
php -l modules/Settings/Resources/views/security.blade.php
php -l modules/Settings/Resources/views/mail.blade.php
php -l modules/Settings/Resources/views/backup.blade.php
php -l modules/Settings/Resources/views/logs.blade.php

# 2. Periksa seluruh daftar 16 rute modul Settings
php artisan route:list --path=admin/settings

# 3. Bersihkan seluruh cache aplikasi jika ada perubahan config
php artisan optimize:clear
```

---

## 🛡️ Checklist Kepatuhan UI/UX & Standar Proyek

* [x] **Zero DOM Windows Alert/Confirm**: 100% dialog konfirmasi dan interaksi menggunakan Pop-up Modal Alpine.js dengan efek `backdrop-blur-sm`.
* [x] **Iconify Standardization**: 100% ikon menggunakan Iconify Heroicons (`heroicons:adjustments-horizontal`, `heroicons:lock-closed`, `heroicons:envelope`, `heroicons:circle-stack`, `heroicons:server-stack`, dll).
* [x] **Responsive Grid Layout**: Tampilan adaptif pada layar Desktop, Tablet, dan Mobile.
* [x] **Active State Highlighting**: Sidebar dan tab navigasi atas otomatis menandai rute aktif.
* [x] **Flash Feedback Notification**: Setiap aksi form dilengkapi banner notifikasi yang merespons session flash message.

