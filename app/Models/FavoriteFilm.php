<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteFilm extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tmdb_id',
        'title',
        'original_title',
        'overview',
        'poster_path',
        'backdrop_path',
        'release_date',
        'vote_average',
        'vote_count',
        'popularity',
        'genre_ids',
        'personal_note',
        'watch_status',
        'rating',
    ];

    protected $casts = [
        'genre_ids' => 'array',
        'vote_average' => 'float',
        'popularity' => 'float',
        'rating' => 'integer',
        'release_date' => 'date',
    ];

    const STATUS_WANT_TO_WATCH = 'want_to_watch';
    const STATUS_WATCHING = 'watching';
    const STATUS_WATCHED = 'watched';

    public static function getWatchStatuses()
    {
        return [
            self::STATUS_WANT_TO_WATCH => 'Ingin Ditonton',
            self::STATUS_WATCHING => 'Sedang Ditonton',
            self::STATUS_WATCHED => 'Sudah Ditonton',
        ];
    }

    /**
     * Get user that owns this favorite film
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to filter by user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to filter by watch status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('watch_status', $status);
    }
}
