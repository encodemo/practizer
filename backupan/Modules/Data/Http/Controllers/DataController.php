<?php

namespace Modules\Data\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Dummy data untuk UI/UX
        $data = collect([
            (object)[
                'id' => 1,
                'name' => 'Sample Data 1',
                'description' => 'Description for sample data 1',
                'status' => 'active',
                'created_at' => now()->subDays(5),
            ],
            (object)[
                'id' => 2,
                'name' => 'Sample Data 2',
                'description' => 'Description for sample data 2',
                'status' => 'inactive',
                'created_at' => now()->subDays(3),
            ],
            (object)[
                'id' => 3,
                'name' => 'Sample Data 3',
                'description' => 'Description for sample data 3',
                'status' => 'pending',
                'created_at' => now()->subDay(),
            ],
        ]);
        
        return view('data::index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('data::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('data::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('data::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}

    /**
     * Show import form (UI only)
     */
    public function showImportForm(): View
    {
        return view('data::import');
    }

    /**
     * Show export options (UI only)
     */
    public function showExportOptions(): View
    {
        return view('data::export');
    }
}
