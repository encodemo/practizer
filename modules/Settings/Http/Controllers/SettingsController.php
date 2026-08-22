<?php

namespace Modules\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{
    /**
     * 1. GENERAL SETTINGS
     */
    public function general()
    {
        $settings = [
            'app_name' => 'Practizer Platform',
            'app_tagline' => 'Enterprise Modular Web Application',
            'app_description' => 'A robust Laravel modular system powered by TALL-stack and Filament UI standards.',
            'app_url' => url('/'),
            'admin_email' => 'admin@practizer.id',
            'timezone' => 'Asia/Jakarta',
            'date_format' => 'd M Y',
            'time_format' => '24',
            'currency' => 'IDR',
            'default_language' => 'id',
            'maintenance_mode' => false,
            'maintenance_message' => 'Sistem sedang dalam pemeliharaan rutin. Kami akan segera kembali.',
            'copyright_text' => '© ' . date('Y') . ' Practizer Inc. All rights reserved.'
        ];

        return view('settings::general', compact('settings'));
    }

    public function updateGeneral(Request $request)
    {
        return redirect()->route('settings.general')->with('success', 'Pengaturan General berhasil diperbarui.');
    }

    /**
     * 2. SECURITY & ACCESS SETTINGS
     */
    public function security()
    {
        $security = [
            'password_min_length' => 8,
            'require_uppercase' => true,
            'require_numeric' => true,
            'require_special_char' => true,
            'password_expiry_days' => 90,
            'session_lifetime' => 120, // minutes
            'max_login_attempts' => 5,
            'lockout_duration' => 15, // minutes
            'enable_2fa' => true,
            'enforce_admin_2fa' => true,
            'enable_recaptcha' => false,
            'ip_whitelist' => "127.0.0.1\n192.168.1.1/24\n10.0.0.0/8"
        ];

        return view('settings::security', compact('security'));
    }

    public function updateSecurity(Request $request)
    {
        return redirect()->route('settings.security')->with('success', 'Kebijakan Keamanan & Akses berhasil diperbarui.');
    }

    /**
     * 3. MAIL & SMTP SETTINGS
     */
    public function mail()
    {
        $mail = [
            'mail_driver' => 'smtp',
            'mail_host' => 'smtp.mailtrap.io',
            'mail_port' => '587',
            'mail_username' => 'practizer_smtp_user',
            'mail_password' => 'secret_password_123',
            'mail_encryption' => 'tls',
            'mail_from_name' => 'Practizer System Notification',
            'mail_from_address' => 'noreply@practizer.id',
            'queue_mail' => true
        ];

        return view('settings::mail', compact('mail'));
    }

    public function updateMail(Request $request)
    {
        return redirect()->route('settings.mail')->with('success', 'Konfigurasi Mail & SMTP berhasil disimpan.');
    }

    public function sendTestMail(Request $request)
    {
        $recipient = $request->input('test_email', 'admin@practizer.id');
        return redirect()->route('settings.mail')->with('success', "Test email berhasil dikirimkan ke {$recipient}.");
    }

    /**
     * 4. BACKUP & MAINTENANCE
     */
    public function backup()
    {
        $backups = [
            [
                'filename' => 'practizer_db_backup_2026-08-22_120000.sql.gz',
                'disk' => 'Local / Storage',
                'size' => '14.8 MB',
                'type' => 'Database Snapshot',
                'status' => 'completed',
                'created_at' => '2026-08-22 12:00:00'
            ],
            [
                'filename' => 'practizer_db_backup_2026-08-21_000000.sql.gz',
                'disk' => 'Local / Storage',
                'size' => '14.5 MB',
                'type' => 'Database Snapshot',
                'status' => 'completed',
                'created_at' => '2026-08-21 00:00:00'
            ],
            [
                'filename' => 'practizer_full_backup_2026-08-20_000000.zip',
                'disk' => 'Cloud S3 Backup',
                'size' => '182.4 MB',
                'type' => 'Full App & Storage',
                'status' => 'completed',
                'created_at' => '2026-08-20 00:00:00'
            ]
        ];

        $serverStats = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'storage_used' => '2.4 GB',
            'storage_free' => '184.6 GB',
            'storage_percentage' => 15,
            'cache_driver' => config('cache.default', 'file'),
            'queue_driver' => config('queue.default', 'sync')
        ];

        return view('settings::backup', compact('backups', 'serverStats'));
    }

    public function createBackup(Request $request)
    {
        return redirect()->route('settings.backup')->with('success', 'Backup database baru berhasil digenerate.');
    }

    public function downloadBackup($filename)
    {
        return redirect()->route('settings.backup')->with('success', "Memulai unduhan file backup: {$filename}");
    }

    public function deleteBackup($filename)
    {
        return redirect()->route('settings.backup')->with('success', "File backup {$filename} berhasil dihapus.");
    }

    public function optimize(Request $request)
    {
        return redirect()->route('settings.backup')->with('success', 'Sistem Cache, Routes, dan Views berhasil di-optimize.');
    }

    /**
     * 5. SYSTEM LOGS & DIAGNOSTICS
     */
    public function logs(Request $request)
    {
        $logFile = storage_path('logs/laravel.log');
        $logs = [];

        // Parsing laravel.log jika ada
        if (File::exists($logFile)) {
            $content = File::get($logFile);
            $pattern = '/\[(\d{4}-\d{2}-\d{2}[T\s]\d{2}:\d{2}:\d{2}[\.\d\+\:]*?)\]\s([a-zA-Z0-9_\-]+)\.([A-Z]+)\:\s(.*?)(?=\n\[\d{4}-\d{2}-\d{2}|$)/s';
            preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

            if (!empty($matches)) {
                $idCounter = 1;
                foreach (array_reverse(array_slice($matches, -50)) as $match) {
                    $logs[] = [
                        'id' => $idCounter++,
                        'timestamp' => $match[1],
                        'environment' => $match[2],
                        'level' => strtoupper($match[3]),
                        'message' => trim(strtok($match[4], "\n")),
                        'trace' => trim($match[4])
                    ];
                }
            }
        }

        // Fallback dummy logs berkualitas tinggi jika log asli kosong untuk visual mockup
        if (empty($logs)) {
            $logs = [
                [
                    'id' => 1,
                    'timestamp' => '2026-08-22 18:30:15',
                    'environment' => 'production',
                    'level' => 'ERROR',
                    'message' => 'Connection to Redis cluster timed out after 3000ms',
                    'trace' => "Predis\\Connection\\ConnectionException: Connection timed out in Predis/Client.php:452\n#0 Predis\\Connection\\AbstractConnection->connect()\n#1 Illuminate\\Redis\\Connections\\Connection->command()\n#2 Illuminate\\Cache\\RedisStore->get()"
                ],
                [
                    'id' => 2,
                    'timestamp' => '2026-08-22 17:45:02',
                    'environment' => 'production',
                    'level' => 'WARNING',
                    'message' => 'Disk usage on /storage partition reached 82% threshold',
                    'trace' => "App\\Services\\HealthChecker::checkStorage(): Storage threshold exceeded.\nPartition: C:\\xampp\\htdocs\\practizer\\storage\nTotal: 200GB, Used: 164GB"
                ],
                [
                    'id' => 3,
                    'timestamp' => '2026-08-22 16:12:44',
                    'environment' => 'production',
                    'level' => 'CRITICAL',
                    'message' => 'Mailgun API webhook payload signature verification failed',
                    'trace' => "App\\Http\\Controllers\\WebhookController::handleMailgun(): Invalid timestamp token in HMAC-SHA256 signature verification.\nSource IP: 198.51.100.42"
                ],
                [
                    'id' => 4,
                    'timestamp' => '2026-08-22 14:05:10',
                    'environment' => 'production',
                    'level' => 'INFO',
                    'message' => 'Scheduled Artisan command queue:restart completed successfully',
                    'trace' => "Command: php artisan queue:restart\nStatus: OK\nTriggered by: System Cron"
                ],
                [
                    'id' => 5,
                    'timestamp' => '2026-08-22 11:20:00',
                    'environment' => 'production',
                    'level' => 'DEBUG',
                    'message' => 'HTTP request dispatched to Payment Gateway API v2 (/orders/checkout)',
                    'trace' => "GuzzleHttp\\Client::request('POST', 'https://api.payment.example.com/v2/orders/checkout')\nLatency: 142ms, Response: 200 OK"
                ]
            ];
        }

        $serverHealth = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'os' => PHP_OS_FAMILY . ' ' . php_uname('m'),
            'memory_limit' => ini_get('memory_limit') ?: '512M',
            'memory_usage' => round(memory_get_usage(true) / 1024 / 1024, 2) . ' MB',
            'uptime' => '99.98% (34 Days)',
            'db_driver' => 'MySQL 8.0 (Mockup Mode)',
            'log_size' => File::exists($logFile) ? round(File::size($logFile) / 1024, 2) . ' KB' : '124.5 KB'
        ];

        return view('settings::logs', compact('logs', 'serverHealth'));
    }

    public function downloadLogs()
    {
        return redirect()->route('settings.logs')->with('success', 'File laravel.log berhasil disiapkan untuk unduhan.');
    }

    public function clearLogs()
    {
        $logFile = storage_path('logs/laravel.log');
        if (File::exists($logFile)) {
            File::put($logFile, '');
        }

        return redirect()->route('settings.logs')->with('success', 'File log sistem berhasil dibersihkan (Purged).');
    }
}

