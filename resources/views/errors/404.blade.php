@extends('layouts.app')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <h1 class="display-1 fw-bold text-warning">404</h1>
            <h4 class="mb-3">Halaman Tidak Ditemukan</h4>
            <p class="text-muted mb-4">Maaf, halaman yang Anda cari tidak ditemukan atau telah dipindahkan.</p>
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="bi bi-house"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
