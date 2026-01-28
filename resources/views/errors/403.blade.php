@extends('layouts.app')

@section('title', '403 - Akses Ditolak')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <h1 class="display-1 fw-bold text-danger">403</h1>
            <h4 class="mb-3">Akses Ditolak</h4>
            <p class="text-muted mb-4">{{ $exception->getMessage() ?: 'Anda tidak memiliki izin untuk mengakses halaman ini.' }}</p>
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="bi bi-house"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
