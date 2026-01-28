@extends('layouts.app')

@section('title', 'Daftar')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold"><i class="bi bi-film text-primary"></i> Raisya - Portal Film</h2>
                        <p class="text-muted">Buat akun baru</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text" style="background-color: var(--card-bg); border-color: #444; color: var(--text-light);">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}"
                                       placeholder="Nama lengkap Anda" required autofocus>
                            </div>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text" style="background-color: var(--card-bg); border-color: #444; color: var(--text-light);">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}"
                                       placeholder="contoh@email.com" required>
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text" style="background-color: var(--card-bg); border-color: #444; color: var(--text-light);">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password" placeholder="Minimal 8 karakter" required>
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text" style="background-color: var(--card-bg); border-color: #444; color: var(--text-light);">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input type="password" class="form-control"
                                       id="password_confirmation" name="password_confirmation"
                                       placeholder="Ulangi password" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                            <i class="bi bi-person-plus"></i> Daftar
                        </button>

                        <div class="text-center">
                            <p class="text-muted mb-0">
                                Sudah punya akun?
                                <a href="{{ route('login') }}" class="text-primary text-decoration-none">Masuk di sini</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
