<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class League extends Model
{
    protected $fillable = [
        'country_id',
        'name',
        'short_name',
        'level',
        'founded_year',
        'logo_url',
    ];

    protected function casts(): array
    {
        return [
            'level'        => 'integer',
            'founded_year' => 'integer',
        ];
    }

    // Una liga pertenece a un país
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    // Una liga tiene muchos clubes
    public function clubs(): HasMany
    {
        return $this->hasMany(Club::class);
    }

    // Una liga tiene muchas temporadas
    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class);
    }
}
