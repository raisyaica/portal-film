@extends('layouts.app')

@section('title', 'Edit Film Favorit')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-pencil"></i> Edit Film Favorit</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <!-- Poster -->
                        <div class="col-md-3">
                            @if($favorite->poster_path)
                                <img src="https://image.tmdb.org/t/p/w300{{ $favorite->poster_path }}"
                                     alt="{{ $favorite->title }}" class="img-fluid rounded">
                            @else
                                <div class="no-poster rounded" style="height: 200px;">
                                    <i class="bi bi-film" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="col-md-9">
                            <h4>{{ $favorite->title }}</h4>
                            @if($favorite->original_title !== $favorite->title)
                                <p class="text-muted">{{ $favorite->original_title }}</p>
                            @endif
                            <p class="small">
                                <span class="text-warning">
                                    <i class="bi bi-star-fill"></i> {{ number_format($favorite->vote_average, 1) }}
                                </span>
                                <span class="text-muted ms-2">
                                    <i class="bi bi-calendar"></i>
                                    {{ $favorite->release_date ? $favorite->release_date->format('d M Y') : 'N/A' }}
                                </span>
                            </p>
                            <p class="text-muted small">{{ Str::limit($favorite->overview, 200) }}</p>
                        </div>
                    </div>

                    <hr>

                    <form action="{{ route('favorites.update', $favorite->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="watch_status" class="form-label">Status Menonton</label>
                            <select class="form-select @error('watch_status') is-invalid @enderror"
                                    id="watch_status" name="watch_status" required>
                                @foreach($statuses as $key => $label)
                                    <option value="{{ $key }}" {{ $favorite->watch_status == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('watch_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="rating" class="form-label">Rating Anda (1-10)</label>
                            <select class="form-select @error('rating') is-invalid @enderror"
                                    id="rating" name="rating">
                                <option value="">Belum memberi rating</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ $favorite->rating == $i ? 'selected' : '' }}>
                                        {{ $i }} - {{ ['Sangat Buruk', 'Buruk', 'Sangat Jelek', 'Jelek', 'Cukup', 'Lumayan', 'Bagus', 'Sangat Bagus', 'Luar Biasa', 'Masterpiece'][$i-1] }}
                                    </option>
                                @endfor
                            </select>
                            @error('rating')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="personal_note" class="form-label">Catatan Pribadi</label>
                            <textarea class="form-control @error('personal_note') is-invalid @enderror"
                                      id="personal_note" name="personal_note" rows="4"
                                      placeholder="Tulis catatan atau review Anda tentang film ini...">{{ old('personal_note', $favorite->personal_note) }}</textarea>
                            @error('personal_note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted">Maksimal 1000 karakter</div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('favorites.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <a href="{{ route('film.show', $favorite->tmdb_id) }}" class="btn btn-outline-primary">
                                <i class="bi bi-eye"></i> Lihat Detail Film
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
