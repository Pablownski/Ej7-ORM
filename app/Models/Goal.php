<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Goal extends Model
{
    protected $fillable = [
        'fixture_id',
        'player_id',
        'assist_player_id',
        'minute',
        'stoppage_minute',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'minute'          => 'integer',
            'stoppage_minute' => 'integer',
        ];
    }

    // Un gol pertenece a un partido
    public function fixture(): BelongsTo
    {
        return $this->belongsTo(Fixture::class);
    }

    // Jugador que marcó el gol
    public function scorer(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_id');
    }

    // Jugador que dio la asistencia (puede ser null)
    public function assistant(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'assist_player_id');
    }
}
