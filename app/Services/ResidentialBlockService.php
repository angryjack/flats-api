<?php

namespace App\Services;

use App\Models\City;

class CityService
{
    public function getByTitle(string $title)
    {
        return City::firstOrCreate(['title' => $title]);
    }
}
