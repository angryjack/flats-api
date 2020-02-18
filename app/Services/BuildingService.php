<?php

namespace App\Services;

use App\Models\Building;
use App\Models\ResidentialBlock;

class BuildingService
{
    public function getOrCreate(ResidentialBlock $block, array $data): Building
    {
        ['residential_block' => $title, 'max_floors' => $maxFloors] = $data;

        return Building::firstOrCreate([
            'title' => $title,
            'residential_block_id' => $block->id,
            'max_floors' => $maxFloors,

            //todo в рамках задачи мы не трогаем данные значения
            'flats_from' => 1,
            'flats_to' => 999,
        ]);
    }
}
