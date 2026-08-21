# **Install ```nwidart/laravel-modules```**

Untuk membuat struktur Laravel menjadi modular, dibutuhkan sebuah dependency tambahan yang dapat mengelola module secara otomatis.

Dependency tersebut adalah **```nwidart/laravel-modules``** yang dapat diperoleh melalui:
1. [nwidart.com](https://nwidart.com/laravel-modules)
2. [github.com](https://github.com/nWidart/laravel-modules)

## Cara Instalasi




composer require nwidart/laravel-modules










php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"

Do you trust "wikimedia/composer-merge-plugin" to execute code and wish to enable it now? (writes "allow-plugins" to composer.json) [y,n,d,?]
Answer y to allow the plugin to be executed. Otherwise, you will need to manually enable the following to your composer.json:

"config": {
    "allow-plugins": {
        "wikimedia/composer-merge-plugin": true
    }
},

setelah installasi composer-merge-plugin, tambahkan konfigurasi berikut ke file composer.json:

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

composer dump-autoload
