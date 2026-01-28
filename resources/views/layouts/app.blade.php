<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal Film') - {{ config('app.name') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #ffc107;
            --primary-hover: #ffca2c;
            --primary-dark: #e0a800;
            --secondary-color: #141414;
            --dark-bg: #141414;
            --card-bg: #1f1f1f;
            --text-light: #ffffff;
            --text-muted: #b0b0b0;
            --text-footer: #d0d0d0;
        }

        body {
            background-color: var(--dark-bg);
            color: var(--text-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .navbar {
            background-color: rgba(20, 20, 20, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand {
            color: var(--primary-color) !important;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .nav-link {
            color: var(--text-light) !important;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #000;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            color: #000;
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #000;
        }

        .movie-card {
            background-color: var(--card-bg);
            border: none;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
        }

        .movie-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(255, 193, 7, 0.2);
        }

        .movie-card .card-img-top {
            height: 300px;
            object-fit: cover;
        }

        .movie-card .card-body {
            padding: 15px;
        }

        .movie-card .card-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: 8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .movie-card .rating {
            color: var(--primary-color);
            font-weight: 600;
        }

        .movie-card .release-date {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .favorite-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.7);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            transition: all 0.3s;
            z-index: 10;
        }

        .favorite-btn:hover {
            background: var(--primary-color);
            color: #000;
            transform: scale(1.1);
        }

        .favorite-btn.favorited {
            background: var(--primary-color);
            color: #000;
        }

        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(20, 20, 20, 1)),
                        url('https://image.tmdb.org/t/p/original/rAiYTfKGqDCRIIqo664sY9XZIvQ.jpg');
            background-size: cover;
            background-position: center;
            padding: 80px 0;
            margin-bottom: 30px;
        }

        .search-box {
            max-width: 600px;
            margin: 0 auto;
        }

        .search-box .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 15px 20px;
            font-size: 1.1rem;
        }

        .search-box .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .search-box .form-control:focus {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: var(--primary-color);
            box-shadow: none;
            color: white;
        }

        .category-nav {
            background-color: var(--card-bg);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .category-nav .nav-link {
            color: var(--text-muted) !important;
            padding: 8px 20px;
            border-radius: 20px;
            margin: 0 5px;
        }

        .category-nav .nav-link.active,
        .category-nav .nav-link:hover {
            background-color: var(--primary-color);
            color: #000 !important;
        }

        .genre-badge {
            background-color: rgba(255, 193, 7, 0.2);
            color: var(--primary-color);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            margin: 3px;
            display: inline-block;
        }

        .pagination .page-link {
            background-color: var(--card-bg);
            border-color: #444;
            color: var(--text-light);
        }

        .pagination .page-link:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #000;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #000;
        }

        .form-control, .form-select {
            background-color: var(--card-bg);
            border-color: #444;
            color: var(--text-light);
        }

        .form-control:focus, .form-select:focus {
            background-color: var(--card-bg);
            border-color: var(--primary-color);
            color: var(--text-light);
            box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .card {
            background-color: var(--card-bg);
            border: none;
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #444;
            color: var(--text-light);
        }

        .card-body {
            color: var(--text-light);
        }

        .card-title {
            color: var(--text-light);
        }

        .form-label {
            color: var(--text-light);
        }

        .form-check-label {
            color: var(--text-light);
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        .small, small {
            color: var(--text-muted);
        }

        strong {
            color: var(--text-light);
        }

        .table {
            color: var(--text-light);
        }

        .table-dark {
            --bs-table-bg: var(--card-bg);
            --bs-table-border-color: #444;
        }

        footer {
            background-color: #0a0a0a;
            padding: 30px 0;
            margin-top: 50px;
            border-top: 1px solid #333;
        }

        footer h5, footer h6 {
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        footer p {
            color: var(--text-footer);
        }

        footer .footer-link {
            color: var(--text-footer);
            text-decoration: none;
            transition: color 0.3s;
        }

        footer .footer-link:hover {
            color: var(--primary-color);
        }

        footer .footer-copyright {
            color: var(--text-muted);
        }

        footer .footer-copyright a {
            color: var(--primary-color);
            text-decoration: none;
        }

        footer .footer-copyright a:hover {
            text-decoration: underline;
        }

        .alert {
            border: none;
        }

        .dropdown-menu {
            background-color: var(--card-bg);
            border: 1px solid #444;
        }

        .dropdown-item {
            color: var(--text-light);
        }

        .dropdown-item:hover {
            background-color: var(--primary-color);
            color: #000;
        }

        .dropdown-divider {
            border-color: #444;
        }

        .no-poster {
            background: linear-gradient(135deg, #2a2a2a, #1a1a1a);
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        .bg-primary {
            background-color: var(--primary-color) !important;
            color: #000 !important;
        }

        .border-primary {
            border-color: var(--primary-color) !important;
        }

        /* Fix for select option text */
        .form-select option {
            background-color: var(--card-bg);
            color: var(--text-light);
        }

        @media (max-width: 768px) {
            .movie-card .card-img-top {
                height: 250px;
            }

            .hero-section {
                padding: 40px 0;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-film"></i> Raisya - Portal Film
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') && !request('category') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-grid"></i> Kategori
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('home', ['category' => 'popular']) }}">Film Populer</a></li>
                            <li><a class="dropdown-item" href="{{ route('home', ['category' => 'now_playing']) }}">Sedang Tayang</a></li>
                            <li><a class="dropdown-item" href="{{ route('home', ['category' => 'top_rated']) }}">Rating Tertinggi</a></li>
                            <li><a class="dropdown-item" href="{{ route('home', ['category' => 'upcoming']) }}">Akan Datang</a></li>
                        </ul>
                    </li>
                    @if(isset($genres) && count($genres) > 0)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-tags"></i> Genre
                        </a>
                        <ul class="dropdown-menu" style="max-height: 400px; overflow-y: auto;">
                            @foreach($genres as $genre)
                            <li><a class="dropdown-item" href="{{ route('genre.filter', $genre['id']) }}">{{ $genre['name'] }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    @endif
                </ul>

                <!-- Search Form -->
                <form class="d-flex me-3" action="{{ route('search') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" placeholder="Cari film..." value="{{ request('q') }}" style="width: 200px;">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('favorites.index') }}">
                                <i class="bi bi-heart-fill" style="color: var(--primary-color);"></i> Favorit
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(auth()->user()->isAdmin())
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard Admin</a></li>
                                <li><hr class="dropdown-divider"></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('favorites.index') }}"><i class="bi bi-heart"></i> Koleksi Saya</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary btn-sm ms-2" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i> Daftar
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="bi bi-film"></i> Raisya - Portal Film</h5>
                    <p>Aplikasi untuk menjelajahi dan menyimpan film favorit Anda. Data film bersumber dari TMDb API.</p>
                </div>
                <div class="col-md-3">
                    <h6>Menu</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="footer-link">Beranda</a></li>
                        <li><a href="{{ route('home', ['category' => 'popular']) }}" class="footer-link">Film Populer</a></li>
                        <li><a href="{{ route('home', ['category' => 'top_rated']) }}" class="footer-link">Rating Tertinggi</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Akun</h6>
                    <ul class="list-unstyled">
                        @auth
                        <li><a href="{{ route('favorites.index') }}" class="footer-link">Koleksi Saya</a></li>
                        @else
                        <li><a href="{{ route('login') }}" class="footer-link">Login</a></li>
                        <li><a href="{{ route('register') }}" class="footer-link">Daftar</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="border-color: #444;">
            <div class="text-center footer-copyright">
                <small>&copy; {{ date('Y') }} Raisya - Portal Film. Data dari <a href="https://www.themoviedb.org/" target="_blank">TMDb</a>.</small>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Setup CSRF token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Function to toggle favorite
        async function toggleFavorite(button, tmdbId) {
            const isFavorited = button.classList.contains('favorited');
            const url = isFavorited ? '{{ route("favorites.quickRemove") }}' : '{{ route("favorites.quickAdd") }}';

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ tmdb_id: tmdbId })
                });

                const data = await response.json();

                if (data.success) {
                    button.classList.toggle('favorited');
                    const icon = button.querySelector('i');
                    if (button.classList.contains('favorited')) {
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill');
                    } else {
                        icon.classList.remove('bi-heart-fill');
                        icon.classList.add('bi-heart');
                    }
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        }
    </script>

    @stack('scripts')
</body>
</html>
