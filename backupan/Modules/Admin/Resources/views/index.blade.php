@extends('admin::components.layouts.master')

@section('title', 'Dashboard Utama')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h2 class="h4">Ringkasan Data</h2>
    </div>
    
    <!-- Contoh Card Statistik -->
    <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm p-3 bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase mb-1">Total Pengguna</h6>
                    <h2 class="mb-0">1,250</h2>
                </div>
                <i class="fas fa-users fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
</div>
@endsection
