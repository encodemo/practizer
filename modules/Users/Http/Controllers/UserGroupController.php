<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    // Dummy data untuk mockup UI
    private $dummyGroups = [
        [
            'id' => 1,
            'name' => 'Super Administrator',
            'description' => 'Memiliki akses penuh ke seluruh sistem.',
            'users_count' => 2,
            'status' => 'active',
            'created_at' => '2026-08-20 10:00:00'
        ],
        [
            'id' => 2,
            'name' => 'Manager',
            'description' => 'Akses manajerial pada modul spesifik.',
            'users_count' => 5,
            'status' => 'active',
            'created_at' => '2026-08-21 11:30:00'
        ],
        [
            'id' => 3,
            'name' => 'Staff',
            'description' => 'Akses terbatas untuk operasional harian.',
            'users_count' => 24,
            'status' => 'inactive',
            'created_at' => '2026-08-22 09:15:00'
        ]
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users::groups.index', [
            'groups' => $this->dummyGroups
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users::groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) 
    {
        return redirect()->route('users.groups.index')->with('success', 'User Group berhasil ditambahkan.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $group = collect($this->dummyGroups)->firstWhere('id', $id) ?? $this->dummyGroups[0];
        return view('users::groups.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $group = collect($this->dummyGroups)->firstWhere('id', $id) ?? $this->dummyGroups[0];
        return view('users::groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) 
    {
        return redirect()->route('users.groups.index')->with('success', 'User Group berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) 
    {
        return redirect()->route('users.groups.index')->with('success', 'User Group berhasil dihapus.');
    }
}
