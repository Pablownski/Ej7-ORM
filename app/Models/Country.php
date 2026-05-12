<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $fillable = [
        'name',
        'code',
        'continent',
        'population',
        'flag_url',
    ];

    protected function casts(): array
    {
        return [
            'population' => 'integer',
        ];
    }

    // Un país tiene muchas ligas
    public function leagues(): HasMany
    {
        return $this->hasMany(League::class);
    }

    // Un país tiene muchos clubes
    public function clubs(): HasMany
    {
        return $this->hasMany(Club::class);
    }

    // Un país tiene muchos jugadores (nacionalidad)
    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    // Un país tiene muchos entrenadores
    public function managers(): HasMany
    {
        return $this->hasMany(Manager::class);
    }
}
