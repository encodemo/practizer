<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users::roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users::permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) 
    {
        return redirect()->route('users.roles.index')->with('success', 'Permission successfully created (Simulation)!');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('users::permissions.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('users::permissions.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) 
    {
        return redirect()->route('users.roles.index')->with('success', 'Permission successfully updated (Simulation)!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) 
    {
        return redirect()->route('users.roles.index')->with('success', 'Permission successfully deleted (Simulation)!');
    }
}
