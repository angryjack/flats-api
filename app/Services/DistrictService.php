<?php

namespace App\Services;

use App\Models\City;

class CityService
{
    public function getByTitle(string $title): City
    {
        return City::firstOrCreate(['title' => $title]);
    }
}
