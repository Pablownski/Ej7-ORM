<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transfer extends Model
{
    protected $fillable = [
        'player_id',
        'from_club_id',
        'to_club_id',
        'transfer_fee_millions',
        'transfer_type',
        'transferred_at',
        'loan_end_date',
    ];

    protected function casts(): array
    {
        return [
            'transfer_fee_millions' => 'decimal:2',
            'transferred_at'        => 'date',
            'loan_end_date'         => 'date',
        ];
    }

    // La transferencia involucra a un jugador
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    // Club de origen (puede ser null si el jugador estaba libre)
    public function fromClub(): BelongsTo
    {
        return $this->belongsTo(Club::class, 'from_club_id');
    }

    // Club de destino (puede ser null si el jugador quedó libre)
    public function toClub(): BelongsTo
    {
        return $this->belongsTo(Club::class, 'to_club_id');
    }
}
