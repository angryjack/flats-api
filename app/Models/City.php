<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель Города.
 */
class City extends Model
{
    protected $fillable = [
        'title'
    ];

    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
