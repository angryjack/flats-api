<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель Района.
 */
class District extends Model
{
    protected $fillable = [
        'title',
        'city_id'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function flats()
    {
        return $this->hasMany(Flat::class);
    }
}
