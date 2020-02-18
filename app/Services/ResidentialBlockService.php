<?php

namespace App\Services;

use App\Models\ResidentialBlock;

class ResidentialBlockService
{
    public function getOrCreate(string $title): ResidentialBlock
    {
        return ResidentialBlock::firstOrCreate(['title' => $title]);
    }
}
