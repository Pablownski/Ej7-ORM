<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    protected $fillable = [
        'club_id',
        'country_id',
        'first_name',
        'last_name',
        'birth_date',
        'position',
        'jersey_number',
        'market_value_millions',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'birth_date'            => 'date',
            'jersey_number'         => 'integer',
            'market_value_millions' => 'decimal:2',
            'active'                => 'boolean',
        ];
    }

    // Un jugador pertenece a un club actualmente (puede ser null - libre)
    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    // Un jugador tiene una nacionalidad
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    // Goles marcados por el jugador
    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class, 'player_id');
    }

    // Asistencias del jugador
    public function assists(): HasMany
    {
        return $this->hasMany(Goal::class, 'assist_player_id');
    }

    // Historial de transferencias del jugador
    public function transfers(): HasMany
    {
        return $this->hasMany(Transfer::class);
    }

    // Tarjetas recibidas
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
