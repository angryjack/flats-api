<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель квартиры.
 */
class Flat extends Model
{
    protected $fillable = [
        'address',
        'floor',
        'rooms',
        'area',
        'price',
        'district_id',
        'residential_block_id',
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function residentialBlock()
    {
        return $this->belongsTo(ResidentialBlock::class);
    }
}
