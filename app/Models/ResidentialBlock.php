<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель Жилого комплекса.
 */
class ResidentialBlock extends Model
{
    protected $fillable = [
        'title'
    ];

    public function flats()
    {
        return $this->hasMany(Flat::class);
    }

    public function buildings()
    {
        return $this->hasMany(Building::class);
    }
}
