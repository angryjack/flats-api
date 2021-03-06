<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель корпуса.
 */
class Building extends Model
{
    protected $fillable = [
        'title',
        'flats_from',
        'flats_to',
        'max_floors',
        'residential_block_id',
    ];

    public function residentialBlock()
    {
        return $this->belongsTo(ResidentialBlock::class);
    }

    public function flats()
    {
        return $this->hasMany(Flat::class);
    }
}
