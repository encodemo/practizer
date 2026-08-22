# **Install ```nwidart/laravel-modules```**

Untuk membuat struktur Laravel menjadi modular, dibutuhkan sebuah dependency tambahan yang dapat mengelola module secara otomatis.

Dependency tersebut adalah **```nwidart/laravel-modules``** yang dapat diperoleh melalui:
1. [nwidart.com](https://nwidart.com/laravel-modules)
2. [github.com](https://github.com/nWidart/laravel-modules)

## Proses Instalasi
```cpp
composer require nwidart/laravel-modules

PS C:\xampp\htdocs\practizer> composer require nwidart/laravel-modules
PHP Warning:  Module "openssl" is already loaded in Unknown on line 0

Cannot use nwidart/laravel-modules's latest version v13.0.0 as it requires php ^8.3 which is not satisfied by your platform.
./composer.json has been updated
Running composer update nwidart/laravel-modules
Loading composer repositories with package information
Updating dependencies
Lock file operations: 2 installs, 0 updates, 0 removals
  - Locking nwidart/laravel-modules (v12.0.5)
  - Locking wikimedia/composer-merge-plugin (v2.1.0)
Writing lock file
Installing dependencies from lock file (including require-dev)
Package operations: 2 installs, 0 updates, 0 removals
wikimedia/composer-merge-plugin contains a Composer plugin which is currently not in your allow-plugins config. See https://getcomposer.org/allow-plugins

```

Do you trust "wikimedia/composer-merge-plugin" to execute code and wish to enable it now? (writes "allow-plugins" to composer.json) [y,n,d,?]
Answer y to allow the plugin to be executed. Otherwise, you will need to manually enable the following to your composer.json:

```cpp
"config": {
    "allow-plugins": {
        "wikimedia/composer-merge-plugin": true
    }
},
```

```cpp
Do you trust "wikimedia/composer-merge-plugin" to execute code and wish to enable it now? (writes "allow-plugins" to composer.json) [y,n,d,?] y
  - Installing wikimedia/composer-merge-plugin (v2.1.0): Extracting archive
  - Installing nwidart/laravel-modules (v12.0.5): Extracting archive
Generating optimized autoload files
> Illuminate\Foundation\ComposerScripts::postAutoloadDump
> @php artisan package:discover --ansi

PHP Warning:  Module "openssl" is already loaded in Unknown on line 0

   INFO  Discovering packages.  

  laravel/pail ............................................................ DONE
  laravel/sail ............................................................ DONE
  laravel/tinker .......................................................... DONE
  nesbot/carbon ........................................................... DONE
  nunomaduro/collision .................................................... DONE
  nunomaduro/termwind ..................................................... DONE
  nwidart/laravel-modules ................................................. DONE

82 packages you are using are looking for funding.
Use the `composer fund` command to find out more!
> @php artisan vendor:publish --tag=laravel-assets --ansi --force

PHP Warning:  Module "openssl" is already loaded in Unknown on line 0

   INFO  No publishable resources for tag [laravel-assets].  

No security vulnerability advisories found.
Using version ^12.0 for nwidart/laravel-modules
```
##
Setelah proses instalasi selesai lanjutkan dengan:

```cpp
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"

PS C:\xampp\htdocs\practizer> php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
PHP Warning:  Module "openssl" is already loaded in Unknown on line 0

   INFO  Publishing assets.  

  Copying file [C:\xampp\htdocs\practizer\vendor\nwidart\laravel-modules\config\config.php] to [C:\xampp\htdocs\practizer\config\modules.php] . DONE
  Copying directory [C:\xampp\htdocs\practizer\vendor\nwidart\laravel-modules\src\Commands\stubs] to [C:\xampp\htdocs\practizer\stubs\nwidart-stubs]  DONE
  Copying file [C:\xampp\htdocs\practizer\vendor\nwidart\laravel-modules\scripts\vite-module-loader.js] to [C:\xampp\htdocs\practizer\vite-module-loader.js]  DONE
```

setelah proses publish selesai, tambahkan konfigurasi berikut ke file composer.json:
```cpp
{
  "autoload": {
    "psr-4": {
      "App\\": "app/",
      "Modules\\": "Modules/"
    }
  }
},

"extra": {
    "laravel": {
        "dont-discover": []
    },
    "merge-plugin": {
        "include": [
            "Modules/*/composer.json"
        ]
    }
},
```
lakukan:
```cpp
composer dump-autoload

PS C:\xampp\htdocs\practizer> composer dump-autoload
PHP Warning:  Module "openssl" is already loaded in Unknown on line 0

Generating optimized autoload files
> Illuminate\Foundation\ComposerScripts::postAutoloadDump
> @php artisan package:discover --ansi

Warning: Module "openssl" is already loaded in Unknown on line 0
PHP Warning:  Module "openssl" is already loaded in Unknown on line 0

   INFO  Discovering packages.  

  laravel/pail ............................................................ DONE
  laravel/sail ............................................................ DONE
  laravel/tinker .......................................................... DONE
  nesbot/carbon ........................................................... DONE
  nunomaduro/collision .................................................... DONE
  nunomaduro/termwind ..................................................... DONE
  nwidart/laravel-modules ................................................. DONE

Generated optimized autoload files containing 6643 classes
```
##
langkah selanjutnya ubah: ```root\config\modules.php```

ubah mulai baris:
```php


        /*
        |--------------------------------------------------------------------------
        | The app path
        |--------------------------------------------------------------------------
        |
        | app folder name
        | for example can change it to 'src' or 'App'
        */
        'app_folder' => 'app/',

        /*
        |--------------------------------------------------------------------------
        | Generator path
        |--------------------------------------------------------------------------
        | Customise the paths where the folders will be generated.
        | Setting the generate key to false will not generate that folder
        */
        'generator' => [
            // app/
            'actions' => ['path' => 'app/Actions', 'generate' => false],
            'casts' => ['path' => 'app/Casts', 'generate' => false],
            'channels' => ['path' => 'app/Broadcasting', 'generate' => false],
            'class' => ['path' => 'app/Classes', 'generate' => false],
            'command' => ['path' => 'app/Console', 'generate' => false],
            'command_replacements' => ['path' => 'app/Console/Replacements', 'generate' => false],
            'component-class' => ['path' => 'app/View/Components', 'generate' => false],
            'emails' => ['path' => 'app/Emails', 'generate' => false],
            'event' => ['path' => 'app/Events', 'generate' => false],
            'enums' => ['path' => 'app/Enums', 'generate' => false],
            'exceptions' => ['path' => 'app/Exceptions', 'generate' => false],
            'jobs' => ['path' => 'app/Jobs', 'generate' => false],
            'helpers' => ['path' => 'app/Helpers', 'generate' => false],
            'interfaces' => ['path' => 'app/Interfaces', 'generate' => false],
            'listener' => ['path' => 'app/Listeners', 'generate' => false],
            'model' => ['path' => 'app/Models', 'generate' => false],
            'notifications' => ['path' => 'app/Notifications', 'generate' => false],
            'observer' => ['path' => 'app/Observers', 'generate' => false],
            'policies' => ['path' => 'app/Policies', 'generate' => false],
            'provider' => ['path' => 'app/Providers', 'generate' => true],
            'repository' => ['path' => 'app/Repositories', 'generate' => false],
            'resource' => ['path' => 'app/Transformers', 'generate' => false],
            'route-provider' => ['path' => 'app/Providers', 'generate' => true],
            'rules' => ['path' => 'app/Rules', 'generate' => false],
            'services' => ['path' => 'app/Services', 'generate' => false],
            'scopes' => ['path' => 'app/Models/Scopes', 'generate' => false],
            'traits' => ['path' => 'app/Traits', 'generate' => false],

            // app/Http/
            'controller' => ['path' => 'app/Http/Controllers', 'generate' => true],
            'filter' => ['path' => 'app/Http/Middleware', 'generate' => false],
            'request' => ['path' => 'app/Http/Requests', 'generate' => false],

            // config/
            'config' => ['path' => 'config', 'generate' => true],

            // database/
            'factory' => ['path' => 'database/factories', 'generate' => true],
            'migration' => ['path' => 'database/migrations', 'generate' => true],
            'seeder' => ['path' => 'database/seeders', 'generate' => true],

            // lang/
            'lang' => ['path' => 'lang', 'generate' => false],

            // resource/
            'assets' => ['path' => 'resources/assets', 'generate' => true],
            'component-view' => ['path' => 'resources/views/components', 'generate' => false],
            'views' => ['path' => 'resources/views', 'generate' => true],
            'inertia' => ['path' => 'resources/js/Pages', 'generate' => false],
            'inertia-components' => ['path' => 'resources/js/Components', 'generate' => false],

            // routes/
            'routes' => ['path' => 'routes', 'generate' => true],

            // tests/
            'test-feature' => ['path' => 'tests/Feature', 'generate' => true],
            'test-unit' => ['path' => 'tests/Unit', 'generate' => true],
        ],
```
##
menjadi:

```php


        /*
        |--------------------------------------------------------------------------
        | The app path
        |--------------------------------------------------------------------------
        |
        | app folder name
        | for example can change it to 'src' or 'App'
        */
        'app_folder' => '',

        /*
        |--------------------------------------------------------------------------
        | Generator path
        |--------------------------------------------------------------------------
        | Customise the paths where the folders will be generated.
        | Setting the generate key to false will not generate that folder
        */
        'generator' => [
            // 
            'actions' => ['path' => 'Actions', 'generate' => false],
            'casts' => ['path' => 'Casts', 'generate' => false],
            'channels' => ['path' => 'Broadcasting', 'generate' => false],
            'class' => ['path' => 'Classes', 'generate' => false],
            'command' => ['path' => 'Console', 'generate' => false],
            'command_replacements' => ['path' => 'Console/Replacements', 'generate' => false],
            'component-class' => ['path' => 'View/Components', 'generate' => false],
            'emails' => ['path' => 'Emails', 'generate' => false],
            'event' => ['path' => 'Events', 'generate' => false],
            'enums' => ['path' => 'Enums', 'generate' => false],
            'exceptions' => ['path' => 'Exceptions', 'generate' => false],
            'jobs' => ['path' => 'Jobs', 'generate' => false],
            'helpers' => ['path' => 'Helpers', 'generate' => false],
            'interfaces' => ['path' => 'Interfaces', 'generate' => false],
            'listener' => ['path' => 'Listeners', 'generate' => false],
            'model' => ['path' => 'Models', 'generate' => false],
            'notifications' => ['path' => 'Notifications', 'generate' => false],
            'observer' => ['path' => 'Observers', 'generate' => false],
            'policies' => ['path' => 'Policies', 'generate' => false],
            'provider' => ['path' => 'Providers', 'generate' => true],
            'repository' => ['path' => 'Repositories', 'generate' => false],
            'resource' => ['path' => 'Transformers', 'generate' => false],
            'route-provider' => ['path' => 'Providers', 'generate' => true],
            'rules' => ['path' => 'Rules', 'generate' => false],
            'services' => ['path' => 'Services', 'generate' => false],
            'scopes' => ['path' => 'Models/Scopes', 'generate' => false],
            'traits' => ['path' => 'Traits', 'generate' => false],

            // Http/
            'controller' => ['path' => 'Http/Controllers', 'generate' => true],
            'filter' => ['path' => 'Http/Middleware', 'generate' => false],
            'request' => ['path' => 'Http/Requests', 'generate' => false],

            // Config/
            'config' => ['path' => 'Config', 'generate' => true],

            // Database/
            'factory' => ['path' => 'Database/factories', 'generate' => true],
            'migration' => ['path' => 'Database/migrations', 'generate' => true],
            'seeder' => ['path' => 'Database/seeders', 'generate' => true],

            // Lang/
            'lang' => ['path' => 'Lang', 'generate' => false],

            // Resources/
            'assets' => ['path' => 'Resources/assets', 'generate' => true],
            'component-view' => ['path' => 'Resources/views/components', 'generate' => false],
            'views' => ['path' => 'Resources/views', 'generate' => true],
            'inertia' => ['path' => 'Resources/js/Pages', 'generate' => false],
            'inertia-components' => ['path' => 'Resources/js/Components', 'generate' => false],

            // Routes/
            'routes' => ['path' => 'Routes', 'generate' => true],

            // Tests/
            'test-feature' => ['path' => 'Tests/Feature', 'generate' => true],
            'test-unit' => ['path' => 'Tests/Unit', 'generate' => true],
        ],
```

proses instalasi **```nwidart/laravel-modules``** selesai.
