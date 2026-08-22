<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory as Faker;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */public function index()
    {
        // Menggunakan Faker dengan pengaturan bahasa Indonesia
        $faker = Faker::create('id_ID');
        
        $users = [];

        // Looping untuk membuat tepat 23 data dummy
        for ($i = 1; $i <= 23; $i++) {
            // Kita buat sebagai Object (casting ke (object)) agar di Blade 
            // nanti bisa dipanggil dengan panah seperti $user->name
            $users[] = (object) [
                'id'         => $i,
                'name'       => $faker->name(),
                'email'      => $faker->unique()->safeEmail(),
                'role'       => $faker->randomElement(['Admin', 'Member', 'Editor']),
                'status'     => $faker->randomElement(['Aktif', 'Nonaktif']),
                'created_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
                'updated_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
            ];
        }

        // Melempar array $users ke view resources/views/users/index.blade.php
        return view('users::index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Data Mockup untuk Dropdown & Opsi Form (100% database-agnostic)
        $roles = [
            (object) ['id' => 1, 'name' => 'Admin', 'badge' => 'bg-purple-100 text-purple-700 border-purple-200', 'description' => 'Full administrative access across all modules & settings.'],
            (object) ['id' => 2, 'name' => 'Editor', 'badge' => 'bg-blue-100 text-blue-700 border-blue-200', 'description' => 'Can manage content, view reports, and update user records.'],
            (object) ['id' => 3, 'name' => 'Member', 'badge' => 'bg-gray-100 text-gray-700 border-gray-200', 'description' => 'Standard user with basic access to assigned personal modules.'],
        ];

        $groups = [
            (object) ['id' => 1, 'name' => 'Core Tech Staff'],
            (object) ['id' => 2, 'name' => 'Finance & Accounting'],
            (object) ['id' => 3, 'name' => 'Operations & Logistics'],
            (object) ['id' => 4, 'name' => 'Customer Support']
        ];

        $departments = [
            'Technology & IT Architecture',
            'Business Development & Sales',
            'Finance & Audit',
            'Human Resources',
            'Product & Marketing'
        ];

        return view('users::create', compact('roles', 'groups', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) 
    {
        // SIMULASI UX: Pura-puranya data berhasil disimpan, lalu redirect ke index
        $name = $request->input('name', 'New User');
        return redirect()->route('users.index')->with('success', "User '{$name}' successfully created (Simulation)!");
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        // Simulasi data realistis berbasis ID (100% database-agnostic mockup)
        $numericId = is_numeric($id) ? (int) $id : 1;
        $roles = ['Admin', 'Editor', 'Member'];
        $role = $roles[($numericId % count($roles))];
        $status = ($numericId % 2 === 0) ? 'Aktif' : 'Nonaktif';

        $user = (object) [
            'id' => $numericId,
            'name' => 'Alexander Pratama',
            'username' => 'alex.pratama',
            'email' => 'alexander.pratama@practizer.test',
            'phone' => '+62 812-3456-7890',
            'role' => $role,
            'status' => $status,
            'department' => 'Technology & IT Architecture',
            'position' => 'Senior Lead Developer',
            'location' => 'Jakarta, Indonesia',
            'address' => 'Jl. Jenderal Sudirman Kav. 52-53, Jakarta Selatan 12190',
            'bio' => 'Senior full-stack engineer and enterprise system architect. Passionate about modular monoliths, Laravel ecosystem, and reactive UI architecture.',
            'timezone' => 'Asia/Jakarta (WIB) GMT+7',
            'two_factor_enabled' => true,
            'email_verified_at' => '2026-01-15 09:30:00',
            'last_login_at' => '2026-08-22 13:45:12',
            'last_login_ip' => '192.168.1.105',
            'created_at' => '2026-01-10 10:15:00',
            'updated_at' => '2026-08-20 16:20:00',
            'permissions' => [
                'users.view' => 'View Users List & Profiles',
                'users.create' => 'Create New User Accounts',
                'users.edit' => 'Edit Existing User Profiles',
                'users.delete' => 'Delete / Suspend Users',
                'roles.manage' => 'Manage Roles & RBAC Matrix',
                'settings.general' => 'Modify General App Settings',
                'settings.security' => 'Manage Security & 2FA Policies',
                'audit.logs.view' => 'Access System Audit Logs',
                'reports.export' => 'Export Data to Excel / PDF'
            ],
            'recent_activities' => [
                (object) [
                    'action' => 'Logged into Admin Dashboard',
                    'description' => 'Successful authentication from Chrome 128 (Windows 10)',
                    'ip' => '192.168.1.105',
                    'time' => '15 minutes ago',
                    'icon' => 'heroicons:arrow-right-on-rectangle',
                    'color' => 'text-blue-500 bg-blue-50'
                ],
                (object) [
                    'action' => 'Updated User Settings',
                    'description' => 'Changed notification preferences to Daily Digest',
                    'ip' => '192.168.1.105',
                    'time' => '2 hours ago',
                    'icon' => 'heroicons:adjustments-horizontal',
                    'color' => 'text-purple-500 bg-purple-50'
                ],
                (object) [
                    'action' => 'Modified Role Permissions',
                    'description' => 'Granted "reports.export" permission to Editor group',
                    'ip' => '192.168.1.105',
                    'time' => '1 day ago',
                    'icon' => 'heroicons:shield-check',
                    'color' => 'text-amber-500 bg-amber-50'
                ],
                (object) [
                    'action' => 'Security Token Generated',
                    'description' => 'Personal access token "CLI-Deployment" generated',
                    'ip' => '192.168.1.105',
                    'time' => '3 days ago',
                    'icon' => 'heroicons:key',
                    'color' => 'text-emerald-500 bg-emerald-50'
                ]
            ],
            'active_sessions' => [
                (object) [
                    'device' => 'Chrome on Windows 10 (Current Session)',
                    'ip' => '192.168.1.105',
                    'location' => 'Jakarta, ID',
                    'is_current' => true,
                    'last_active' => 'Active now'
                ],
                (object) [
                    'device' => 'Safari on iPhone 15 Pro',
                    'ip' => '182.253.14.88',
                    'location' => 'Jakarta, ID',
                    'is_current' => false,
                    'last_active' => 'Yesterday at 20:14'
                ]
            ]
        ];
        
        return view('users::show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Data Mockup untuk Opsi Form Edit (100% database-agnostic)
        $roles = [
            (object) ['id' => 1, 'name' => 'Admin', 'badge' => 'bg-purple-100 text-purple-700 border-purple-200', 'description' => 'Full administrative access across all modules & settings.'],
            (object) ['id' => 2, 'name' => 'Editor', 'badge' => 'bg-blue-100 text-blue-700 border-blue-200', 'description' => 'Can manage content, view reports, and update user records.'],
            (object) ['id' => 3, 'name' => 'Member', 'badge' => 'bg-gray-100 text-gray-700 border-gray-200', 'description' => 'Standard user with basic access to assigned personal modules.'],
        ];

        $groups = [
            (object) ['id' => 1, 'name' => 'Core Tech Staff'],
            (object) ['id' => 2, 'name' => 'Finance & Accounting'],
            (object) ['id' => 3, 'name' => 'Operations & Logistics'],
            (object) ['id' => 4, 'name' => 'Customer Support']
        ];

        $departments = [
            'Technology & IT Architecture',
            'Business Development & Sales',
            'Finance & Audit',
            'Human Resources',
            'Product & Marketing'
        ];

        // Simulasi data user yang sedang diedit
        $user = (object) [
            'id' => $id,
            'name' => 'Alexander Pratama',
            'username' => 'alex.pratama',
            'email' => 'alexander.pratama@practizer.test',
            'phone' => '+62 812-3456-7890',
            'role' => 'Admin',
            'status' => 'Aktif',
            'department' => 'Technology & IT Architecture',
            'position' => 'Senior Lead Developer',
            'location' => 'Jakarta, Indonesia',
            'address' => 'Jl. Jenderal Sudirman Kav. 52-53, Jakarta Selatan 12190',
            'bio' => 'Senior full-stack engineer and enterprise system architect.',
            'timezone' => 'Asia/Jakarta',
            'two_factor_enabled' => true,
            'email_verified_at' => '2026-01-15 09:30:00',
        ];

        return view('users::edit', compact('user', 'roles', 'groups', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) 
    {
        // SIMULASI UX: Redirect ke show dengan pesan sukses
        $name = $request->input('name', 'User');
        return redirect()->route('users.show', $id)->with('success', "User '{$name}' successfully updated (Simulation)!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) 
    {
        // SIMULASI UX: Redirect ke index dengan pesan sukses
        return redirect()->route('users.index')->with('success', "User #{$id} successfully deleted (Simulation)!");
    }
}
