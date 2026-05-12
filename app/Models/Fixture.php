<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fixture extends Model
{
    protected $fillable = [
        'season_id',
        'home_club_id',
        'away_club_id',
        'played_at',
        'home_score',
        'away_score',
        'status',
        'attendance',
    ];

    protected function casts(): array
    {
        return [
            'played_at'  => 'datetime',
            'home_score' => 'integer',
            'away_score' => 'integer',
            'attendance' => 'integer',
        ];
    }

    // Un partido pertenece a una temporada
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    // Club local
    public function homeClub(): BelongsTo
    {
        return $this->belongsTo(Club::class, 'home_club_id');
    }

    // Club visitante
    public function awayClub(): BelongsTo
    {
        return $this->belongsTo(Club::class, 'away_club_id');
    }

    // Goles del partido
    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class)->orderBy('minute');
    }

    // Tarjetas del partido
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class)->orderBy('minute');
    }
}
