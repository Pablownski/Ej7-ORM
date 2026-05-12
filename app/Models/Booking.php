<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'fixture_id',
        'player_id',
        'minute',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'minute' => 'integer',
        ];
    }

    // Una tarjeta pertenece a un partido
    public function fixture(): BelongsTo
    {
        return $this->belongsTo(Fixture::class);
    }

    // Una tarjeta se le muestra a un jugador
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}
