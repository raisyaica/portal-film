@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold"><i class="bi bi-film text-primary"></i> Raisya - Portal Film</h2>
                        <p class="text-muted">Masuk ke akun Anda</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text" style="background-color: var(--card-bg); border-color: #444; color: var(--text-light);">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}"
                                       placeholder="contoh@email.com" required autofocus>
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
                                       id="password" name="password" placeholder="Masukkan password" required>
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                            <i class="bi bi-box-arrow-in-right"></i> Masuk
                        </button>

                        <div class="text-center">
                            <p class="text-muted mb-0">
                                Belum punya akun?
                                <a href="{{ route('register') }}" class="text-primary text-decoration-none">Daftar sekarang</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Demo Accounts Info -->
            <div class="card mt-4">
                <div class="card-body">
                    <h6 class="card-title"><i class="bi bi-info-circle"></i> Akun Demo</h6>
                    <div class="small">
                        <p class="mb-1"><strong>Admin:</strong> admin@portalfilm.com / password123</p>
                        <p class="mb-0"><strong>User:</strong> user@portalfilm.com / password123</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
