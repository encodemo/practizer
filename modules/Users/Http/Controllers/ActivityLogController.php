<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory as Faker;

class ActivityLogController extends Controller
{
    /**
     * Menampilkan daftar riwayat aktivitas sistem (Mockup DB-Agnostic)
     */
    public function index(Request $request)
    {
        $faker = Faker::create('id_ID');

        // Master Modules & Severity Styling Definitions
        $modules = ['Users', 'Roles', 'Permissions', 'Settings', 'Auth', 'System'];
        $severities = [
            'info'    => ['badge' => 'bg-blue-50 text-blue-700 border-blue-200', 'icon' => 'heroicons:information-circle', 'dot' => 'bg-blue-500'],
            'success' => ['badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'icon' => 'heroicons:check-circle', 'dot' => 'bg-emerald-500'],
            'warning' => ['badge' => 'bg-amber-50 text-amber-700 border-amber-200', 'icon' => 'heroicons:exclamation-triangle', 'dot' => 'bg-amber-500'],
            'danger'  => ['badge' => 'bg-rose-50 text-rose-700 border-rose-200', 'icon' => 'heroicons:shield-exclamation', 'dot' => 'bg-rose-500'],
        ];

        // Template variasi aktivitas nyata enterprise untuk simulasi audit trail
        $activityTemplates = [
            [
                'event' => 'user_login',
                'module' => 'Auth',
                'severity' => 'info',
                'action' => 'User Authenticated',
                'description' => 'Successfully logged into Admin Dashboard via web session.',
                'changes' => null,
                'request_method' => 'POST',
                'endpoint' => '/login',
            ],
            [
                'event' => 'failed_login',
                'module' => 'Auth',
                'severity' => 'danger',
                'action' => 'Failed Login Attempt',
                'description' => 'Invalid credentials provided for email administrator@practizer.test.',
                'changes' => [
                    'reason' => 'Invalid password hash',
                    'attempts' => 3,
                    'locked' => false
                ],
                'request_method' => 'POST',
                'endpoint' => '/login',
            ],
            [
                'event' => 'user_created',
                'module' => 'Users',
                'severity' => 'success',
                'action' => 'User Account Created',
                'description' => 'Created new user account with assigned role "Member".',
                'changes' => [
                    'old' => null,
                    'new' => [
                        'name' => 'Budi Santoso',
                        'email' => 'budi.santoso@practizer.test',
                        'role' => 'Member',
                        'status' => 'Aktif',
                        'department' => 'Operations & Logistics'
                    ]
                ],
                'request_method' => 'POST',
                'endpoint' => '/admin/users',
            ],
            [
                'event' => 'role_updated',
                'module' => 'Roles',
                'severity' => 'warning',
                'action' => 'Role Permissions Modified',
                'description' => 'Updated permission matrix for role "Editor". Granted export privileges.',
                'changes' => [
                    'old' => ['permissions' => ['view_users', 'edit_users']],
                    'new' => ['permissions' => ['view_users', 'edit_users', 'export_reports', 'view_audit_logs']]
                ],
                'request_method' => 'PUT',
                'endpoint' => '/admin/users/roles/2',
            ],
            [
                'event' => 'settings_changed',
                'module' => 'Settings',
                'severity' => 'warning',
                'action' => 'Security Settings Updated',
                'description' => 'Modified system session timeout lifetime and forced two-factor authentication policy.',
                'changes' => [
                    'old' => ['session_lifetime' => '60 min', 'force_2fa' => false, 'max_login_attempts' => 5],
                    'new' => ['session_lifetime' => '120 min', 'force_2fa' => true, 'max_login_attempts' => 3]
                ],
                'request_method' => 'POST',
                'endpoint' => '/admin/settings/security',
            ],
            [
                'event' => 'user_deleted',
                'module' => 'Users',
                'severity' => 'danger',
                'action' => 'User Account Terminated',
                'description' => 'Permanently removed user account ID #14 from system.',
                'changes' => [
                    'old' => ['id' => 14, 'name' => 'Doni Kusuma', 'email' => 'doni.kusuma@practizer.test', 'role' => 'Member'],
                    'new' => null
                ],
                'request_method' => 'DELETE',
                'endpoint' => '/admin/users/14',
            ],
            [
                'event' => 'data_exported',
                'module' => 'Users',
                'severity' => 'info',
                'action' => 'Bulk Data Exported',
                'description' => 'Exported formatted user spreadsheet report (users_export.xlsx).',
                'changes' => ['format' => 'xlsx', 'total_records' => 23, 'scope' => 'All Users'],
                'request_method' => 'GET',
                'endpoint' => '/admin/users/export',
            ],
            [
                'event' => 'password_reset',
                'module' => 'Auth',
                'severity' => 'warning',
                'action' => 'Password Reset Requested',
                'description' => 'Admin triggered recovery email link for user account.',
                'changes' => ['notification_channel' => 'SMTP Mail', 'token_valid_hours' => 24],
                'request_method' => 'POST',
                'endpoint' => '/admin/users/1/reset-password',
            ],
            [
                'event' => 'user_impersonated',
                'module' => 'Auth',
                'severity' => 'warning',
                'action' => 'Account Session Impersonated',
                'description' => 'Super Administrator initiated impersonation session for support investigation.',
                'changes' => ['impersonator' => 'Super Admin', 'target_user' => 'Alexander Pratama'],
                'request_method' => 'POST',
                'endpoint' => '/admin/users/1/impersonate',
            ],
            [
                'event' => 'system_cache_cleared',
                'module' => 'System',
                'severity' => 'info',
                'action' => 'Application Cache Flushed',
                'description' => 'Optimized view, config, and route caches via maintenance panel.',
                'changes' => ['cleared' => ['config', 'routes', 'views', 'modules_cache']],
                'request_method' => 'POST',
                'endpoint' => '/admin/settings/cache-clear',
            ]
        ];

        // Generate 30 mock activity log records
        $logs = [];
        for ($i = 1; $i <= 1975; $i++) {
            $tpl = $activityTemplates[($i - 1) % count($activityTemplates)];
            $userName = $faker->name();
            $roles = ['Super Admin', 'Admin', 'Editor', 'Member'];
            $userRole = $roles[$i % count($roles)];
            
            // Randomize causer identity or make some system events
            $isSystemCauser = ($tpl['module'] === 'System' && $i % 3 === 0);
            
            $causer = $isSystemCauser ? (object) [
                'id'     => null,
                'name'   => 'System Automated Job',
                'email'  => 'system@practizer.internal',
                'role'   => 'System Cron',
                'avatar' => 'https://ui-avatars.com/api/?name=System+Job&background=334155&color=ffffff&bold=true'
            ] : (object) [
                'id'     => ($i % 8) + 1,
                'name'   => $userName,
                'email'  => strtolower(str_replace(' ', '.', $userName)) . '@practizer.test',
                'role'   => $userRole,
                'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($userName) . '&background=f1f5f9&color=334155&bold=true'
            ];

            $userAgents = [
                'Chrome 128 (Windows 10 Pro 64-bit)',
                'Safari 17.5 (macOS Sonoma)',
                'Firefox 130 (Ubuntu 24.04 LTS)',
                'Edge 128 (Windows 11 Enterprise)',
                'Mobile Safari (Apple iPhone 15 Pro / iOS 17.6)'
            ];

            $locations = [
                'Jakarta, Indonesia',
                'Surabaya, Indonesia',
                'Bandung, Indonesia',
                'Singapore, SG',
                'Tokyo, JP'
            ];

            $logs[] = (object) [
                'id'             => 1000 + $i,
                'log_code'       => 'LOG-' . date('Ym') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'causer'         => $causer,
                'event'          => $tpl['event'],
                'module'         => $tpl['module'],
                'severity'       => $tpl['severity'],
                'severity_meta'  => $severities[$tpl['severity']],
                'action'         => $tpl['action'],
                'description'    => $tpl['description'],
                'changes'        => $tpl['changes'],
                'request_method' => $tpl['request_method'],
                'endpoint'       => $tpl['endpoint'],
                'ip_address'     => '192.168.1.' . (100 + ($i % 45)),
                'user_agent'     => $userAgents[$i % count($userAgents)],
                'device_type'    => (str_contains($userAgents[$i % count($userAgents)], 'iPhone')) ? 'Mobile' : 'Desktop',
                'location'       => $locations[$i % count($locations)],
                'created_at'     => date('Y-m-d H:i:s', strtotime("-{$i} hours -".($i*3)." minutes")),
                'time_ago'       => ($i === 1) ? '1 hour ago' : "{$i} hours ago",
            ];
        }

        // Summary Metric Mockup (Filament KPI Widgets)
        $stats = (object) [
            'total_logs'       => count($logs),
            'security_alerts'  => count(array_filter($logs, fn($l) => in_array($l->severity, ['warning', 'danger']))),
            'auth_events'      => count(array_filter($logs, fn($l) => $l->module === 'Auth')),
            'active_causers'   => count(array_unique(array_filter(array_map(fn($l) => $l->causer->id, $logs)))),
        ];

        return view('users::logs.index', compact('logs', 'stats', 'modules', 'severities'));
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return redirect()->route('users.logs.index')->with('info', "Inspecting Activity Log Record #{$id} (Mockup)");
    }

    /**
     * Simulasi Purge / Clean Old Logs berdasarkan Retention Policy
     */
    public function purge(Request $request)
    {
        $days = $request->input('days', 90);
        return redirect()->route('users.logs.index')->with('success', "Retention Cleanup executed: Audit logs older than {$days} days archived successfully (Simulation)!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return redirect()->route('users.logs.index')->with('success', "Activity log record #{$id} archived (Simulation)!");
    }
}
