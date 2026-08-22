# **Install Laravel 12.12.2**

```bash
composer create-project --prefer-dist laravel/laravel:12.12.2 practizer

Creating a "laravel/laravel:12.12.2" project at "./base-12122"
Installing laravel/laravel (v12.12.2)
  - Installing laravel/laravel (v12.12.2): Extracting archive
Created project in E:\xampp\htdocs\base-12122
> @php -r "file_exists('.env') || copy('.env.example', '.env');"
Loading composer repositories with package information
Updating dependencies
Lock file operations: 111 installs, 0 updates, 0 removals
  - Locking brick/math (0.14.8)
  - Locking carbonphp/carbon-doctrine-types (3.2.0)
  - Locking dflydev/dot-access-data (v3.0.3)       
  - Locking doctrine/inflector (2.1.0)
  - Locking doctrine/lexer (3.0.1)
  - Locking dragonmantank/cron-expression (v3.6.0)
  - Locking egulias/email-validator (4.0.4)
  - Locking fakerphp/faker (v1.24.1)
  - Locking filp/whoops (2.18.4)
  - Locking fruitcake/php-cors (v1.4.0)
  - Locking graham-campbell/result-type (v1.1.4)
  - Locking guzzlehttp/guzzle (7.15.3)
  - Locking guzzlehttp/promises (2.5.2)
  - Locking guzzlehttp/psr7 (2.13.0)
  - Locking guzzlehttp/uri-template (v1.0.10)
  - Locking hamcrest/hamcrest-php (v3.0.0)
  - Locking laravel/framework (v12.67.0)
  - Locking laravel/pail (v1.2.7)
  - Locking laravel/pint (v1.30.4)
  - Locking laravel/prompts (v0.3.23)
  - Locking laravel/sail (v1.67.0)
  - Locking laravel/serializable-closure (v2.0.15)
  - Locking laravel/tinker (v2.11.1)
  - Locking league/commonmark (2.10.0)
  - Locking league/config (v1.2.0)
  - Locking league/flysystem (3.35.2)
  - Locking league/flysystem-local (3.31.0)
  - Locking league/mime-type-detection (1.17.0)
  - Locking league/uri (7.8.1)
  - Locking league/uri-interfaces (7.8.1)
  - Locking mockery/mockery (1.6.15)
  - Locking monolog/monolog (3.10.0)
  - Locking myclabs/deep-copy (1.14.0)
  - Locking nesbot/carbon (3.13.2)
  - Locking nette/schema (v1.3.6)
  - Locking nette/utils (v4.1.5)
  - Locking nikic/php-parser (v5.8.0)
  - Locking nunomaduro/collision (v8.9.5)
  - Locking nunomaduro/termwind (v2.4.0)
  - Locking phar-io/manifest (2.0.4)
  - Locking phar-io/version (3.2.1)
  - Locking phpoption/phpoption (1.9.5)
  - Locking phpunit/php-code-coverage (11.0.12)
  - Locking phpunit/php-file-iterator (5.1.1)
  - Locking phpunit/php-invoker (5.0.1)
  - Locking phpunit/php-text-template (4.0.1)
  - Locking phpunit/php-timer (7.0.1)
  - Locking phpunit/phpunit (11.5.56)
  - Locking psr/clock (1.0.0)
  - Locking psr/container (2.0.2)
  - Locking psr/event-dispatcher (1.0.0)
  - Locking psr/http-client (1.0.3)
  - Locking psr/http-factory (1.1.0)
  - Locking psr/http-message (2.0)
  - Locking psr/log (3.0.2)
  - Locking psr/simple-cache (3.0.0)
  - Locking psy/psysh (v0.12.24)
  - Locking ralouphie/getallheaders (3.0.3)
  - Locking ramsey/collection (2.1.1)
  - Locking ramsey/uuid (4.9.3)
  - Locking sebastian/cli-parser (3.0.2)
  - Locking sebastian/code-unit (3.0.3)
  - Locking sebastian/code-unit-reverse-lookup (4.0.1)
  - Locking sebastian/comparator (6.3.3)
  - Locking sebastian/complexity (4.0.1)
  - Locking sebastian/diff (6.0.2)
  - Locking sebastian/environment (7.2.1)
  - Locking sebastian/exporter (6.3.2)
  - Locking sebastian/global-state (7.0.2)
  - Locking sebastian/lines-of-code (3.0.1)
  - Locking sebastian/object-enumerator (6.0.1)
  - Locking sebastian/object-reflector (4.0.1)
  - Locking sebastian/recursion-context (6.0.3)
  - Locking sebastian/type (5.1.3)
  - Locking sebastian/version (5.0.2)
  - Locking staabm/side-effects-detector (1.0.5)
  - Locking symfony/clock (v7.4.8)
  - Locking symfony/console (v7.4.16)
  - Locking symfony/css-selector (v7.4.9)
  - Locking symfony/deprecation-contracts (v3.7.1)
  - Locking symfony/error-handler (v7.4.15)
  - Locking symfony/event-dispatcher (v7.4.15)
  - Locking symfony/event-dispatcher-contracts (v3.7.1)
  - Locking symfony/finder (v7.4.14)
  - Locking symfony/http-foundation (v7.4.16)
  - Locking symfony/http-kernel (v7.4.16)
  - Locking symfony/mailer (v7.4.15)
  - Locking symfony/mime (v7.4.16)
  - Locking symfony/polyfill-ctype (v1.37.0)
  - Locking symfony/polyfill-intl-grapheme (v1.41.0)
  - Locking symfony/polyfill-intl-idn (v1.38.1)
  - Locking symfony/polyfill-intl-normalizer (v1.38.0)
  - Locking symfony/polyfill-mbstring (v1.38.2)
  - Locking symfony/polyfill-php80 (v1.37.0)
  - Locking symfony/polyfill-php83 (v1.41.0)
  - Locking symfony/polyfill-php84 (v1.38.1)
  - Locking symfony/polyfill-php85 (v1.41.0)
  - Locking symfony/polyfill-uuid (v1.37.0)
  - Locking symfony/process (v7.4.13)
  - Locking symfony/routing (v7.4.15)
  - Locking symfony/service-contracts (v3.7.1)
  - Locking symfony/string (v7.4.15)
  - Locking symfony/translation (v7.4.16)
  - Locking symfony/translation-contracts (v3.7.1)
  - Locking symfony/uid (v7.4.9)
  - Locking symfony/var-dumper (v7.4.15)
  - Locking symfony/yaml (v7.4.15)
  - Locking theseer/tokenizer (1.3.1)
  - Locking tijsverkoyen/css-to-inline-styles (v2.4.0)
  - Locking vlucas/phpdotenv (v5.6.4)
  - Locking voku/portable-ascii (2.1.1)
Writing lock file
Installing dependencies from lock file (including require-dev)
Package operations: 111 installs, 0 updates, 0 removals
  - Installing doctrine/inflector (2.1.0): Extracting archive
  - Installing doctrine/lexer (3.0.1): Extracting archive
  - Installing dragonmantank/cron-expression (v3.6.0): Extracting archive
  - Installing symfony/deprecation-contracts (v3.7.1): Extracting archive
  - Installing psr/container (2.0.2): Extracting archive
  - Installing fakerphp/faker (v1.24.1): Extracting archive
  - Installing symfony/polyfill-mbstring (v1.38.2): Extracting archive
  - Installing symfony/http-foundation (v7.4.16): Extracting archive
  - Installing fruitcake/php-cors (v1.4.0): Extracting archive
  - Installing symfony/polyfill-php80 (v1.37.0): Extracting archive
  - Installing psr/http-message (2.0): Extracting archive
  - Installing psr/http-client (1.0.3): Extracting archive
  - Installing ralouphie/getallheaders (3.0.3): Extracting archive
  - Installing psr/http-factory (1.1.0): Extracting archive
  - Installing guzzlehttp/psr7 (2.13.0): Extracting archive
  - Installing guzzlehttp/promises (2.5.2): Extracting archive
  - Installing guzzlehttp/guzzle (7.15.3): Extracting archive
  - Installing guzzlehttp/uri-template (v1.0.10): Extracting archive
  - Installing symfony/polyfill-intl-normalizer (v1.38.0): Extracting archive
  - Installing symfony/polyfill-intl-grapheme (v1.41.0): Extracting archive
  - Installing symfony/polyfill-ctype (v1.37.0): Extracting archive
  - Installing symfony/string (v7.4.15): Extracting archive
  - Installing symfony/service-contracts (v3.7.1): Extracting archive
  - Installing symfony/console (v7.4.16): Extracting archive
  - Installing nunomaduro/termwind (v2.4.0): Extracting archive
  - Installing voku/portable-ascii (2.1.1): Extracting archive
  - Installing phpoption/phpoption (1.9.5): Extracting archive
  - Installing graham-campbell/result-type (v1.1.4): Extracting archive
  - Installing vlucas/phpdotenv (v5.6.4): Extracting archive
  - Installing symfony/css-selector (v7.4.9): Extracting archive
  - Installing tijsverkoyen/css-to-inline-styles (v2.4.0): Extracting archive
  - Installing symfony/var-dumper (v7.4.15): Extracting archive
  - Installing symfony/polyfill-uuid (v1.37.0): Extracting archive
  - Installing symfony/uid (v7.4.9): Extracting archive
  - Installing symfony/routing (v7.4.15): Extracting archive
  - Installing symfony/process (v7.4.13): Extracting archive
  - Installing symfony/polyfill-php85 (v1.41.0): Extracting archive
  - Installing symfony/polyfill-php84 (v1.38.1): Extracting archive
  - Installing symfony/polyfill-php83 (v1.41.0): Extracting archive
  - Installing symfony/polyfill-intl-idn (v1.38.1): Extracting archive
  - Installing symfony/mime (v7.4.16): Extracting archive
  - Installing psr/event-dispatcher (1.0.0): Extracting archive
  - Installing symfony/event-dispatcher-contracts (v3.7.1): Extracting archive
  - Installing symfony/event-dispatcher (v7.4.15): Extracting archive
  - Installing psr/log (3.0.2): Extracting archive
  - Installing egulias/email-validator (4.0.4): Extracting archive
  - Installing symfony/mailer (v7.4.15): Extracting archive
  - Installing symfony/error-handler (v7.4.15): Extracting archive
  - Installing symfony/http-kernel (v7.4.16): Extracting archive
  - Installing symfony/finder (v7.4.14): Extracting archive
  - Installing ramsey/collection (2.1.1): Extracting archive
  - Installing brick/math (0.14.8): Extracting archive
  - Installing ramsey/uuid (4.9.3): Extracting archive
  - Installing psr/simple-cache (3.0.0): Extracting archive
  - Installing symfony/translation-contracts (v3.7.1): Extracting archive
  - Installing symfony/translation (v7.4.16): Extracting archive
  - Installing psr/clock (1.0.0): Extracting archive
  - Installing symfony/clock (v7.4.8): Extracting archive
  - Installing carbonphp/carbon-doctrine-types (3.2.0): Extracting archive
  - Installing nesbot/carbon (3.13.2): Extracting archive
  - Installing monolog/monolog (3.10.0): Extracting archive
  - Installing league/uri-interfaces (7.8.1): Extracting archive
  - Installing league/uri (7.8.1): Extracting archive
  - Installing league/mime-type-detection (1.17.0): Extracting archive
  - Installing league/flysystem-local (3.31.0): Extracting archive
  - Installing league/flysystem (3.35.2): Extracting archive
  - Installing nette/utils (v4.1.5): Extracting archive
  - Installing nette/schema (v1.3.6): Extracting archive
  - Installing dflydev/dot-access-data (v3.0.3): Extracting archive
  - Installing league/config (v1.2.0): Extracting archive
  - Installing league/commonmark (2.10.0): Extracting archive
  - Installing laravel/serializable-closure (v2.0.15): Extracting archive
  - Installing laravel/prompts (v0.3.23): Extracting archive
  - Installing laravel/framework (v12.67.0): Extracting archive
  - Installing laravel/pail (v1.2.7): Extracting archive
  - Installing laravel/pint (v1.30.4): Extracting archive
  - Installing symfony/yaml (v7.4.15): Extracting archive
  - Installing laravel/sail (v1.67.0): Extracting archive
  - Installing nikic/php-parser (v5.8.0): Extracting archive
  - Installing psy/psysh (v0.12.24): Extracting archive
  - Installing laravel/tinker (v2.11.1): Extracting archive
  - Installing hamcrest/hamcrest-php (v3.0.0): Extracting archive
  - Installing mockery/mockery (1.6.15): Extracting archive
  - Installing filp/whoops (2.18.4): Extracting archive
  - Installing nunomaduro/collision (v8.9.5): Extracting archive
  - Installing staabm/side-effects-detector (1.0.5): Extracting archive
  - Installing sebastian/version (5.0.2): Extracting archive
  - Installing sebastian/type (5.1.3): Extracting archive
  - Installing sebastian/recursion-context (6.0.3): Extracting archive
  - Installing sebastian/object-reflector (4.0.1): Extracting archive
  - Installing sebastian/object-enumerator (6.0.1): Extracting archive
  - Installing sebastian/global-state (7.0.2): Extracting archive
  - Installing sebastian/exporter (6.3.2): Extracting archive
  - Installing sebastian/environment (7.2.1): Extracting archive
  - Installing sebastian/diff (6.0.2): Extracting archive
  - Installing sebastian/comparator (6.3.3): Extracting archive
  - Installing sebastian/code-unit (3.0.3): Extracting archive
  - Installing sebastian/cli-parser (3.0.2): Extracting archive
  - Installing phpunit/php-timer (7.0.1): Extracting archive
  - Installing phpunit/php-text-template (4.0.1): Extracting archive
  - Installing phpunit/php-invoker (5.0.1): Extracting archive
  - Installing phpunit/php-file-iterator (5.1.1): Extracting archive
  - Installing theseer/tokenizer (1.3.1): Extracting archive
  - Installing sebastian/lines-of-code (3.0.1): Extracting archive
  - Installing sebastian/complexity (4.0.1): Extracting archive
  - Installing sebastian/code-unit-reverse-lookup (4.0.1): Extracting archive
  - Installing phpunit/php-code-coverage (11.0.12): Extracting archive
  - Installing phar-io/version (3.2.1): Extracting archive
  - Installing phar-io/manifest (2.0.4): Extracting archive
  - Installing myclabs/deep-copy (1.14.0): Extracting archive
  - Installing phpunit/phpunit (11.5.56): Extracting archive
55 package suggestions were added by new dependencies, use `composer suggest` to see details.
Generating optimized autoload files
> Illuminate\Foundation\ComposerScripts::postAutoloadDump
> @php artisan package:discover --ansi

   INFO  Discovering packages.

  laravel/pail ............................................................ DONE
  laravel/sail ............................................................ DONE
  laravel/tinker .......................................................... DONE
  nesbot/carbon ........................................................... DONE
  nunomaduro/collision .................................................... DONE
  nunomaduro/termwind ..................................................... DONE

81 packages you are using are looking for funding.
Use the `composer fund` command to find out more!
> @php artisan vendor:publish --tag=laravel-assets --ansi --force

   INFO  No publishable resources for tag [laravel-assets].

No security vulnerability advisories found.
> @php artisan key:generate --ansi

   INFO  Application key set successfully.

> @php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
> @php artisan migrate --graceful --ansi

   INFO  Preparing database.

  Creating migration table ........................................ 77.80ms DONE

   INFO  Running migrations.  

  0001_01_01_000000_create_users_table ........................... 515.34ms DONE
  0001_01_01_000001_create_cache_table ........................... 433.43ms DONE
  0001_01_01_000002_create_jobs_table ............................ 560.01ms DONE

```
---

## Edit File ```.env```

```php
APP_NAME=Practizer
APP_ENV=local
APP_KEY=base64:Vc40iiKwgUkWTEM5uwGI8V1E/aozWQ9lvJZl9y2oUlA=
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US
APP_TIMEZONE=Asia/Jakarta

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

# DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=300
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database
DB_QUEUE_RETRY_AFTER=3600

CACHE_STORE=database
# CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
```

