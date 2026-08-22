## **Create Module**

root/modules/
├── Admin
├── Settings
├── Users
│
└── ...


```bash
https://nwidart.com/laravel-modules/v6/basic-usage/creating-a-module
```

Jalankan perintah di bawah ini untuk membuat module baru.
```bash
php artisan module:make moduleName
```
Bisa juga membuat beberapa module dengan satu command.
```bash
php artisan module:make Admin Users Settings

PS C:\xampp\htdocs\practizer> php artisan module:make Admin Users Settings
PHP Warning:  Module "openssl" is already loaded in Unknown on line 0

   INFO  Creating module: [Admin].  

  Generating file C:\xampp\htdocs\practizer\Modules/Admin/module.json .................................................................. 1.95ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Admin/routes/web.php .............................................................. 12.20ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Admin/routes/api.php ............................................................... 1.13ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Admin/resources/views/index.blade.php .............................................. 1.20ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Admin/resources/views/components/layouts/master.blade.php .......................... 2.22ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Admin/config/config.php ............................................................ 1.25ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Admin/composer.json ................................................................ 1.89ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Admin/resources/assets/js/app.js ................................................... 1.96ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Admin/resources/assets/sass/app.scss ............................................... 1.60ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Admin/vite.config.js ............................................................... 1.60ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Admin/package.json ................................................................. 1.08ms DONE
  Generating file C:/xampp/htdocs/practizer/Modules/Admin/Database/seeders/AdminDatabaseSeeder.php ..................................... 2.30ms DONE
  Generating file C:/xampp/htdocs/practizer/Modules/Admin/Providers/AdminServiceProvider.php ........................................... 0.73ms DONE
  Generating file C:/xampp/htdocs/practizer/Modules/Admin/Providers/EventServiceProvider.php ........................................... 0.66ms DONE
  Generating file C:/xampp/htdocs/practizer/Modules/Admin/Providers/RouteServiceProvider.php ........................................... 0.75ms DONE
  Generating file C:/xampp/htdocs/practizer/Modules/Admin/Http/Controllers/AdminController.php ......................................... 0.81ms DONE

   INFO  Module [Admin] created successfully.  

   INFO  Creating module: [Users].  

  Generating file C:\xampp\htdocs\practizer\Modules/Users/module.json .................................................................. 0.80ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Users/routes/web.php ............................................................... 1.77ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Users/routes/api.php ............................................................... 1.12ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Users/resources/views/index.blade.php .............................................. 0.95ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Users/resources/views/components/layouts/master.blade.php .......................... 2.51ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Users/config/config.php ............................................................ 1.14ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Users/composer.json ................................................................ 1.12ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Users/resources/assets/js/app.js ................................................... 2.86ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Users/resources/assets/sass/app.scss ............................................... 1.18ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Users/vite.config.js ............................................................... 1.93ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Users/package.json ................................................................. 2.05ms DONE
  Generating file C:/xampp/htdocs/practizer/Modules/Users/Database/seeders/UsersDatabaseSeeder.php ..................................... 0.75ms DONE
  Generating file C:/xampp/htdocs/practizer/Modules/Users/Providers/UsersServiceProvider.php ........................................... 0.80ms DONE
  Generating file C:/xampp/htdocs/practizer/Modules/Users/Providers/EventServiceProvider.php ........................................... 0.79ms DONE
  Generating file C:/xampp/htdocs/practizer/Modules/Users/Providers/RouteServiceProvider.php ........................................... 0.82ms DONE
  Generating file C:/xampp/htdocs/practizer/Modules/Users/Http/Controllers/UsersController.php ......................................... 0.82ms DONE

   INFO  Module [Users] created successfully.  

   INFO  Creating module: [Settings].  

  Generating file C:\xampp\htdocs\practizer\Modules/Settings/module.json ............................................................... 0.89ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Settings/routes/web.php ............................................................ 1.44ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Settings/routes/api.php ............................................................ 1.00ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Settings/resources/views/index.blade.php ........................................... 0.98ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Settings/resources/views/components/layouts/master.blade.php ....................... 2.01ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Settings/config/config.php ......................................................... 1.02ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Settings/composer.json ............................................................. 0.99ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Settings/resources/assets/js/app.js ................................................ 2.87ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Settings/resources/assets/sass/app.scss ............................................ 1.37ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Settings/vite.config.js ............................................................ 1.03ms DONE
  Generating file C:\xampp\htdocs\practizer\Modules/Settings/package.json .............................................................. 0.90ms DONE
  Generating file C:/xampp/htdocs/practizer/Modules/Settings/Database/seeders/SettingsDatabaseSeeder.php ............................... 0.77ms DONE
  Generating file C:/xampp/htdocs/practizer/Modules/Settings/Providers/SettingsServiceProvider.php ..................................... 0.83ms DONE
  Generating file C:/xampp/htdocs/practizer/Modules/Settings/Providers/EventServiceProvider.php ........................................ 1.41ms DONE
  Generating file C:/xampp/htdocs/practizer/Modules/Settings/Providers/RouteServiceProvider.php ........................................ 1.51ms DONE
  Generating file C:/xampp/htdocs/practizer/Modules/Settings/Http/Controllers/SettingsController.php ................................... 0.87ms DONE

   INFO  Module [Settings] created successfully.
```
##

List all available modules.
php artisan module:list










