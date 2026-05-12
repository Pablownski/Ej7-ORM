<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Season extends Model
{
    protected $fillable = [
        'league_id',
        'champion_club_id',
        'name',
        'start_date',
        'end_date',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date'   => 'date',
        ];
    }

    // Una temporada pertenece a una liga
    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    // Club campeón de la temporada (puede ser null si aún no terminó)
    public function champion(): BelongsTo
    {
        return $this->belongsTo(Club::class, 'champion_club_id');
    }

    // Una temporada tiene muchos partidos
    public function fixtures(): HasMany
    {
        return $this->hasMany(Fixture::class);
    }
}
