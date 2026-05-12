<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Club extends Model
{
    protected $fillable = [
        'league_id',
        'country_id',
        'name',
        'short_name',
        'city',
        'founded_year',
        'stadium_name',
        'stadium_capacity',
        'budget_millions',
        'crest_url',
    ];

    protected function casts(): array
    {
        return [
            'founded_year'     => 'integer',
            'stadium_capacity' => 'integer',
            'budget_millions'  => 'decimal:2',
        ];
    }

    // Un club pertenece a una liga
    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    // Un club pertenece a un país
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    // Un club tiene un entrenador actual
    public function manager(): HasOne
    {
        return $this->hasOne(Manager::class);
    }

    // Un club tiene muchos jugadores en su plantilla actual
    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    // Partidos como local
    public function homeFixtures(): HasMany
    {
        return $this->hasMany(Fixture::class, 'home_club_id');
    }

    // Partidos como visitante
    public function awayFixtures(): HasMany
    {
        return $this->hasMany(Fixture::class, 'away_club_id');
    }

    // Transferencias de llegada al club
    public function incomingTransfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'to_club_id');
    }

    // Transferencias de salida del club
    public function outgoingTransfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'from_club_id');
    }

    // Temporadas en que fue campeón
    public function titlesWon(): HasMany
    {
        return $this->hasMany(Season::class, 'champion_club_id');
    }
}
