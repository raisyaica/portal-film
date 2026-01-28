<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #ffc107;
            --primary-hover: #ffca2c;
            --secondary-color: #141414;
            --dark-bg: #141414;
            --card-bg: #1f1f1f;
            --sidebar-bg: #0a0a0a;
            --text-light: #ffffff;
            --text-muted: #b0b0b0;
        }

        body {
            background-color: var(--dark-bg);
            color: var(--text-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: var(--sidebar-bg);
            padding-top: 20px;
            z-index: 1000;
        }

        .sidebar .brand {
            color: var(--primary-color);
            font-weight: bold;
            font-size: 1.2rem;
            padding: 0 20px 20px;
            border-bottom: 1px solid #333;
        }

        .sidebar .nav-link {
            color: var(--text-muted);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #000;
            background-color: var(--primary-color);
            border-left: 3px solid var(--primary-hover);
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px 30px;
        }

        .top-bar {
            background-color: var(--card-bg);
            padding: 15px 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-bar h4 {
            color: var(--text-light);
        }

        .stat-card {
            background-color: var(--card-bg);
            border-radius: 10px;
            padding: 25px;
            text-align: center;
        }

        .stat-card .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .stat-card .stat-icon.text-primary {
            color: var(--primary-color) !important;
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: var(--text-light);
        }

        .stat-card .stat-label {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .card {
            background-color: var(--card-bg);
            border: none;
            border-radius: 10px;
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #444;
            padding: 15px 20px;
            color: var(--text-light);
        }

        .card-header h6 {
            color: var(--text-light);
        }

        .card-body {
            color: var(--text-light);
        }

        .card-body h4, .card-body h5, .card-body h6 {
            color: var(--text-light);
        }

        .card-body p {
            color: var(--text-light);
        }

        hr {
            border-color: #444;
        }

        .table {
            color: var(--text-light);
        }

        .table-dark {
            --bs-table-bg: transparent;
            --bs-table-border-color: #444;
            color: var(--text-light);
        }

        .table-dark th {
            color: var(--text-light);
        }

        .table-dark td {
            color: var(--text-muted);
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

        .form-control, .form-select {
            background-color: #2a2a2a;
            border-color: #444;
            color: var(--text-light);
        }

        .form-control:focus, .form-select:focus {
            background-color: #2a2a2a;
            border-color: var(--primary-color);
            color: var(--text-light);
            box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .form-label {
            color: var(--text-light);
        }

        .form-check-label {
            color: var(--text-light);
        }

        strong {
            color: var(--text-light);
        }

        .small, small {
            color: var(--text-muted);
        }

        .badge-admin {
            background-color: var(--primary-color);
            color: #000;
        }

        .badge-user {
            background-color: #6c757d;
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

        .list-group-item {
            background-color: transparent;
            border-color: #444;
            color: var(--text-light);
        }

        .list-group-item h6 {
            color: var(--text-light);
        }

        .list-group-item small {
            color: var(--text-muted);
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        .text-muted {
            color: var(--text-muted) !important;
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

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand">
            <i class="bi bi-film"></i> Raisya - Portal Film Admin
        </div>
        <nav class="nav flex-column mt-3">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                <i class="bi bi-people"></i> Kelola User
            </a>
            <hr class="my-3" style="border-color: #444;">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="bi bi-house"></i> Ke Website
            </a>
            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </nav>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div>
                <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
            </div>
            <div class="d-flex align-items-center">
                <span class="me-3" style="color: var(--text-light);"><i class="bi bi-person-circle"></i> {{ auth()->user()->name }}</span>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
