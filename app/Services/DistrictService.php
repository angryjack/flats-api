<?php

namespace App\Services;

use App\Models\City;
use App\Models\District;

class DistrictService
{
    public function getOrCreate(City $city, string $title): District
    {
        return District::firstOrCreate([
            'title' => $title,
            'city_id' => $city->id
        ]);
    }
}
