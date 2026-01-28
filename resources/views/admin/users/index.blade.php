@extends('layouts.admin')

@section('title', 'Kelola User')
@section('page-title', 'Kelola User')

@section('content')
<!-- Search & Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-6">
                <label for="search" class="form-label">Cari User</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="search" name="search"
                           value="{{ $search }}" placeholder="Nama atau email...">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </div>
            @if($search)
            <div class="col-md-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-lg"></i> Reset
                </a>
            </div>
            @endif
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><i class="bi bi-people"></i> Daftar User ({{ $users->total() }})</h6>
    </div>
    <div class="card-body">
        @if($users->count() > 0)
        <div class="table-responsive">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Favorit</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->isAdmin())
                                <span class="badge badge-admin">Admin</span>
                            @else
                                <span class="badge badge-user">User</span>
                            @endif
                        </td>
                        <td>{{ $user->favoriteFilms->count() }}</td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-primary" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if(!$user->isAdmin() && $user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus user ini?')" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $users->appends(['search' => $search])->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-people" style="font-size: 3rem; color: #666;"></i>
            <h5 class="mt-3">Tidak ada user ditemukan</h5>
            @if($search)
            <p class="text-muted">Tidak ada hasil untuk pencarian "{{ $search }}"</p>
            @endif
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .badge-admin {
        background-color: var(--primary-color);
    }

    .badge-user {
        background-color: #6c757d;
    }

    .pagination .page-link {
        background-color: var(--card-bg);
        border-color: #333;
        color: var(--text-light);
    }

    .pagination .page-link:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
</style>
@endpush
@endsection
