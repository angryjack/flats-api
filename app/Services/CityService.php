<?php

namespace App\Services;

use App\Models\City;

class CityService
{
    public function getOrCreate(string $title): City
    {
        //todo тут можно проверить опечатки и не создавать город
        return City::firstOrCreate(['title' => $title]);
    }
}
