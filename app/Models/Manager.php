<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Manager extends Model
{
    protected $fillable = [
        'club_id',
        'country_id',
        'first_name',
        'last_name',
        'birth_date',
        'tactic',
        'hired_at',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'hired_at'   => 'date',
        ];
    }

    // Un entrenador pertenece a un club (puede ser null si está sin equipo)
    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    // Un entrenador tiene una nacionalidad
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
