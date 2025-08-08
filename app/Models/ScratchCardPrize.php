<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScratchCardPrize extends Model
{
    use HasFactory;

    protected $fillable = [
        'scratch_card_id',
        'name',
        'value',
        'image',
        'quantity'
    ];

    public function scratchCard()
    {
        return $this->belongsTo(ScratchCard::class);
    }
}
