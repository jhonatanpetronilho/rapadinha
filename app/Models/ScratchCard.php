<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScratchCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'banner',
        'image',
        'price',
        'max_prize',
        'rtp',
        'active',
    ];

    public function prizes()
    {
        return $this->hasMany(\App\Models\ScratchCardPrize::class);
    }
}
