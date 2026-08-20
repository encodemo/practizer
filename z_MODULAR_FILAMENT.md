Untuk menggabungkan (mengintegrasikan) Filament ke dalam arsitektur modul nwidart/laravel-modules, Anda perlu mendaftarkan Filament Panel agar mengenali struktur folder di dalam modul Anda.
Berikut adalah langkah-langkah praktis untuk melakukannya:
## 1. Buat Modul Baru (Jika belum ada)
Jika Anda belum memiliki modul, buatlah terlebih dahulu melalui terminal:

php artisan module:make Karyawan

## 2. Daftarkan Modul di Filament Panel Provider
Buka file Panel Provider Filament Anda (biasanya berada di app/Providers/Filament/AdminPanelProvider.php). Gunakan method discover... milik Filament untuk membaca Resource, Pages, dan Widgets yang ada di dalam modul Anda. [1, 2] 
Ubah file AdminPanelProvider.php menjadi seperti ini: [3] 

```php
use Nwidart\Modules\Facades\Module;

public function panel(Panel $panel): Panel
{
    // Ambil path dasar dari modul Anda (misal: nama modulnya 'Karyawan')
    $moduleName = 'Karyawan';
    $modulePath = base_path('Modules/' . $moduleName);

    return $panel
        ->default()
        ->id('admin')
        ->path('admin')
        // ... konfigurasi bawaan lainnya ...
        
        // Temukan Resource di dalam Modul
        ->discoverResources(
            in: $modulePath . '/Filament/Resources',
            for: 'Modules\\' . $moduleName . '\\Filament\\Resources'
        )
        // Temukan Pages di dalam Modul
        ->discoverPages(
            in: $modulePath . '/Filament/Pages',
            for: 'Modules\\' . $moduleName . '\\Filament\\Pages'
        )
        // Temukan Widgets di dalam Modul
        ->discoverWidgets(
            in: $modulePath . '/Filament/Widgets',
            for: 'Modules\\' . $moduleName . '\\Filament\\Widgets'
        );
}
```
## 3. Buat Folder Struktur di Dalam Modul
Secara default, perintah php artisan make:filament-resource akan membuat file di folder utama app/. Karena kita menggunakan arsitektur modul, buatlah folder secara manual di dalam modul Anda dengan struktur seperti ini:

```php
Modules/
└── Karyawan/
    └── Filament/
        ├── Resources/
        ├── Pages/
        └── Widgets/
```

## 4. Membuat Resource Filament untuk Modul
Saat membuat Resource baru, Anda bisa memanfaatkan flag --model dan --panel jika diperlukan, namun cara paling aman adalah membuat Resource biasa lalu memindahkannya ke folder modul, atau membuatnya secara manual.
Jika memindahkan file dari app/ ke Modules/, pastikan Anda mengubah namespace di dalam file PHP tersebut agar sesuai dengan modul, contohnya:

```php
namespace Modules\Karyawan\Filament\Resources;

// ...
class AnggotaResource extends Resource
{
    // Pastikan Model mengarah ke Model di dalam Modul Anda
    protected static ?string $model = \Modules\Karyawan\Models\Anggota::class;
}
```

------------------------------
## Alternative: Menggunakan Filament Plugin (Cara Lebih Bersih)
Jika Anda memiliki banyak modul dan tidak ingin mengotori AdminPanelProvider.php dengan banyak kode discover, Anda bisa membuat Filament Plugin di setiap ModuleServiceProvider masing-masing modul.
Jika Anda tertarik, saya bisa buatkan contoh implementasi menggunakan Filament Plugin atau cara otomatisasi scan seluruh folder Modules/. Manakah pendekatan yang ingin Anda pelajari lebih lanjut?

[1] [https://github.com](https://github.com/bradyrenting/filament-passwordless)
[2] [https://github.com](https://github.com/liberusoftware/boilerplate-laravel)
[3] [https://filamentphp.com](https://filamentphp.com/plugins/oriondevelops-greeter)


Membuat Filament Plugin untuk setiap modul adalah pendekatan terbaik (paling bersih dan modular). Dengan cara ini, setiap modul bertanggung jawab penuh atas komponen Filament-nya sendiri, sehingga Anda tidak perlu mengubah file AdminPanelProvider.php utama setiap kali menambah modul baru. [1] 
Berikut adalah langkah-langkah membuat Filament Plugin untuk setiap modul nwidart:
## 1. Buat Class Plugin di Dalam Modul
Buat file class PHP baru di dalam folder modul Anda. Misalnya, kita buat untuk modul Karyawan.
Buat file di: Modules/Karyawan/Filament/KaryawanPlugin.php

```php
<?php

namespace Modules\Karyawan\Filament;

use Filament\Contracts\Plugin;
use Filament\Panel;

class KaryawanPlugin implements Plugin
{
    public function getId(): string
    {
        // ID unik untuk plugin ini
        return 'karyawan-module';
    }

    public function register(Panel $panel): void
    {
        $modulePath = base_path('Modules/Karyawan');

        // Daftarkan semua komponen Filament khusus milik modul ini
        $panel
            ->discoverResources(
                in: $modulePath . '/Filament/Resources',
                for: 'Modules\\Karyawan\\Filament\\Resources'
            )
            ->discoverPages(
                in: $modulePath . '/Filament/Pages',
                for: 'Modules\\Karyawan\\Filament\\Pages'
            )
            ->discoverWidgets(
                in: $modulePath . '/Filament/Widgets',
                for: 'Modules\\Karyawan\\Filament\\Widgets'
            );
    }

    public function boot(Panel $panel): void
    {
        // Logika run-time saat plugin di-boot (opsional)
    }

    public static function make(): static
    {
        return app(static::class);
    }
}
```
## 2. Daftarkan Plugin di Panel Utama
Sekarang, Anda hanya perlu mendaftarkan plugin tersebut sekali saja di panel provider utama Anda (biasanya app/Providers/Filament/AdminPanelProvider.php). [2] 

```php
use Modules\Karyawan\Filament\KaryawanPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->default()
        ->id('admin')
        ->path('admin')
        // ... konfigurasi lainnya ...
        ->plugins([
            KaryawanPlugin::make(), // Cukup tambahkan ini
        ]);
}
```

------------------------------
## Tips Pro: Otomatisasi Scan Seluruh Modul (Tanpa Register Manual)
Jika Anda memiliki puluhan modul dan malas mendaftarkannya satu per satu di AdminPanelProvider.php, Anda bisa memanfaatkan Facade Module dari nwidart untuk melakukan scanning otomatis ke semua modul yang aktif.
Ubah bagian plugins() di AdminPanelProvider.php Anda menjadi seperti ini:

```php
use Nwidart\Modules\Facades\Module;

public function panel(Panel $panel): Panel
{
    // Mengumpulkan semua plugin dari modul yang aktif secara otomatis
    $modulePlugins = [];
    
    foreach (Module::allEnabled() as $module) {
        // Asumsikan nama class plugin mengikuti pola: Modules\NamaModul\Filament\NamaModulPlugin
        $pluginClass = "Modules\\" . $module->getName() . "\\Filament\\" . $module->getName() . "Plugin";
        
        if (class_exists($pluginClass)) {
            $modulePlugins[] = $pluginClass::make();
        }
    }

    return $panel
        ->default()
        ->id('admin')
        // ... konfigurasi lainnya ...
        ->plugins($modulePlugins); // Semua plugin modul otomatis ter-register!
}
```
Dengan trik otomatisasi di atas, Anda cukup membuat file KaryawanPlugin.php, ProdukPlugin.php, atau InvoicePlugin.php di masing-masing modul baru, dan Filament akan langsung mengenali Resource mereka tanpa Anda perlu menyentuh file AdminPanelProvider.php lagi.
Apakah Anda ingin saya buatkan contoh perintah Custom Artisan Command agar Anda bisa membuat struktur folder dan file Plugin Filament ini secara otomatis setiap kali membuat modul baru?

[1] [https://github.com](https://github.com/savannabits/filament-modules)
[2] [https://packagist.org](https://packagist.org/packages/juniyasyos/filament-media-manager)


Berikut adalah contoh pembuatan Custom Artisan Command di Laravel untuk mengotomatisasi pembuatan struktur folder Filament beserta file Plugin-nya di dalam modul nwidart.
## 1. Buat Command Baru
Jalankan perintah ini di terminal untuk membuat class command baru:

```php
php artisan make:command MakeModuleFilamentPlugin
```
## 2. Edit File Command
Buka file yang baru saja dibuat di app/Console/Commands/MakeModuleFilamentPlugin.php, lalu ubah kodenya menjadi seperti berikut:

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Nwidart\Modules\Facades\Module;

class MakeModuleFilamentPlugin extends Command
{
    // Nama perintah yang akan dipanggil di terminal
    protected $signature = 'module:make-filament {module : Nama modul yang dituju (contoh: Karyawan)}';

    // Deskripsi perintah
    protected $description = 'Membuat struktur folder Filament dan file Plugin untuk modul tertentu';

    public function handle()
    {
        $moduleName = ucfirst($this->argument('module'));

        // 1. Validasi apakah modul tersebut ada dan aktif
        if (!Module::has($moduleName)) {
            $this->error("Modul '{$moduleName}' tidak ditemukan!");
            return Command::FAILURE;
        }

        $modulePath = base_path('Modules/' . $moduleName);
        $filamentPath = $modulePath . '/Filament';

        // 2. Buat struktur folder yang dibutuhkan
        $folders = [
            $filamentPath,
            $filamentPath . '/Resources',
            $filamentPath . '/Pages',
            $filamentPath . '/Widgets',
        ];

        foreach ($folders as $folder) {
            if (!File::isDirectory($folder)) {
                File::makeDirectory($folder, 0755, true);
            }
        }

        // 3. Buat file Plugin PHP
        $pluginName = "{$moduleName}Plugin";
        $pluginFilePath = $filamentPath . '/' . $pluginName . '.php';

        if (File::exists($pluginFilePath)) {
            $this->warn("Plugin '{$pluginName}.php' sudah ada di dalam modul {$moduleName}.");
            return Command::SUCCESS;
        }

        // Template isi file Plugin
        $stub = <<<PHP
<?php

namespace Modules\\{$moduleName}\\Filament;

use Filament\Contracts\Plugin;
use Filament\Panel;

class {$pluginName} implements Plugin
{
    public function getId(): string
    {
        return '{$style = strtolower($moduleName)}-module';
    }

    public function register(Panel $panel): void
    {
        \$modulePath = base_path('Modules/{$moduleName}');

        \$panel
            ->discoverResources(
                in: \$modulePath . '/Filament/Resources',
                for: 'Modules\\\\{$moduleName}\\\\Filament\\\\Resources'
            )
            ->discoverPages(
                in: \$modulePath . '/Filament/Pages',
                for: 'Modules\\\\{$moduleName}\\\\Filament\\\\Pages'
            )
            ->discoverWidgets(
                in: \$modulePath . '/Filament/Widgets',
                for: 'Modules\\\\{$moduleName}\\\\Filament\\\\Widgets'
            );
    }

    public function boot(Panel $panel): void
    {
        // Logika saat boot
    }

    public static function make(): static
    {
        return app(static::class);
    }
}
PHP;

        File::put($pluginFilePath, $stub);

        $this->info("✅ Struktur Filament berhasil dibuat untuk Modul: {$moduleName}");
        $this->info("📂 File dibuat: Modules/{$moduleName}/Filament/{$pluginName}.php");

        return Command::SUCCESS;
    }
}
```

## 3. Cara Menggunakannya
Setiap kali Anda membuat modul baru dengan nwidart, Anda cukup menjalankan perintah custom ini setelahnya.
Langkah-langkah alur kerja baru Anda:

   1. Buat modul nwidart biasa:
```php
   php artisan module:make Produk
```
   2. Jalankan perintah custom untuk menyuntikkan Filament:
```php
   php artisan module:make-filament Produk
``` 
   
Output di terminal akan seperti ini:

```php
✅ Struktur Filament berhasil dibuat untuk Modul: Produk
📂 File dibuat: Modules/Produk/Filament/ProdukPlugin.php
```
Sekarang folder Resources, Pages, Widgets sudah siap di dalam modul Produk, dan file ProdukPlugin.php otomatis terkonfigurasi dengan namespace yang benar sesuai modulnya. Berkat trik otomatisasi scan di AdminPanelProvider.php pada pembahasan sebelumnya, modul baru ini akan langsung terbaca oleh Filament tanpa perlu mendaftarkannya manual lagi. [1] 
Jika Anda ingin melangkah lebih jauh, saya bisa tunjukkan cara membuat Custom Artisan Command untuk membuat Resource Filament langsung ke dalam folder modul tersebut agar Anda tidak perlu memindahkannya secara manual dari folder app/. Apakah Anda membutuhkannya?

[1] [https://filamentphp.com](https://filamentphp.com/plugins/coolsam-modules)

Ya, Anda tentu saja bisa melewati sistem authentication agar Filament Panel dapat diakses langsung tanpa login. Pendekatan ini sangat umum digunakan ketika panel Filament hanya berfungsi sebagai mockup, purwarupa (prototype), atau presentasi desain UI/UX kepada klien. [1] 
Untuk menonaktifkan login pada Filament Panel, Anda memiliki dua cara utama. Pilih salah satu yang paling sesuai dengan kebutuhan proyek Anda:
## Cara 1: Mengosongkan Middleware auth (Cara Paling Mudah)
Secara default, Filament menggunakan middleware Authenticate untuk mengunci panel. Anda bisa menghapus atau menimpa (override) middleware tersebut agar panel menjadi terbuka untuk publik. [2, 3] 
Buka file Panel Provider utama Anda (misalnya app/Providers/Filament/AdminPanelProvider.php), lalu ubah konfigurasinya menjadi seperti ini: [4] 

```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->default()
        ->id('admin')
        ->path('admin')
        // 1. Hapus atau komentari baris ->login() jika ada
        // ->login() 
        
        // 2. Timpa middleware auth menjadi kosong []
        ->authMiddleware([]) 
        
        // ... konfigurasi plugin & discover module Anda ...
        ->plugins($modulePlugins);
}
```
Efeknya: Siapa pun yang membuka URL /admin akan langsung masuk ke Dashboard tanpa dimintai email dan password. [5] 
------------------------------
## Cara 2: Menggunakan "Auto-Login" Otomatis (Lebih Aman untuk Data)
Jika Resource atau halaman di dalam modul Anda tetap membutuhkan objek User yang sedang login agar tidak terjadi error (misalnya ada kode $user->name atau relasi database), cara terbaik adalah melakukan Auto-Login menggunakan akun dummy. [6] 
Ubah file app/Providers/Filament/AdminPanelProvider.php Anda, lalu manfaatkan middleware kustom pada authMiddleware: [7] 

```php
use Illuminate\Support\Facades\Auth;

public function panel(Panel $panel): Panel
{
    return $panel
        ->default()
        ->id('admin')
        ->path('admin')
        // Tetap matikan halaman login bawaan
        // ->login() 
        
        // Buat middleware kustom untuk otomatis login menggunakan User ID 1
        ->authMiddleware([
            \App\Http\Middleware\Authenticate::class, // Tetap gunakan middleware bawaan laravel/filament
        ])
        ->authGuard('web') // Pastikan menggunakan guard yang sesuai
        
        // Gunakan trik di bawah ini untuk mengotomatisasi login saat aplikasi di-boot
        ->bootUsing(function () {
            if (app()->environment('local')) {
                // Otomatis login sebagai user pertama di database Anda
                $user = \App\Models\User::first();
                if ($user) {
                    Auth::login($user);
                }
            }
        });
}
```
Catatan: Pastikan Anda sudah menjalankan seeder untuk membuat minimal 1 user di dalam database.
------------------------------
## 💡 Tips Tambahan untuk Kebutuhan Demo UI/UX:
Jika Anda hanya ingin menampilkan visual tanpa interaksi database yang rumit:

   1. Gunakan Custom Pages: Daripada membuat Resource (yang memaksa Anda membuat Model & Database), buatlah Custom Page Filament di dalam modul Anda menggunakan perintah php artisan make:filament-page NamaHalaman.
   2. Di dalam file Blade custom page tersebut (.blade.php), Anda bebas memasukkan kode HTML/CSS, komponen Tailwind, atau bahkan menyematkan (embed) link Figma Prototype menggunakan <iframe>.

Apakah Anda ingin dibantu untuk membuat Custom Page khusus di dalam modul yang bisa langsung menampilkan desain UI/UX tanpa bergantung pada database sama sekali?

[1] [https://dev.to](https://dev.to/robertobutti/how-to-build-a-simple-notebook-app-with-laravel-filament-v4-step-by-step-guide-18nl)
[2] [https://stackoverflow.com](https://stackoverflow.com/questions/78482831/in-filamentphp-v3-i-am-adding-custom-colors-to-the-panel-but-they-are-not-show)
[3] [https://sailsjs.com](https://sailsjs.com/documentation/concepts/middleware)
[4] [https://blog.jpat.dev](https://blog.jpat.dev/filament-v3-how-to-fill-login-automatically-local-environment)
[5] [https://fr.wordpress.org](https://fr.wordpress.org/plugins/controlled-admin-access/)
[6] [https://security.stackexchange.com](https://security.stackexchange.com/questions/42246/should-i-know-my-users-passwords-so-i-can-check-they-can-logon)
[7] [https://filamentphp.com](https://filamentphp.com/plugins/mortezaashrafi-shield-captcha)
