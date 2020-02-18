<?php

namespace App\Dto;

class Filter
{
    public $city;
    public $district;
    public $address;
    public $residentialBlock;
    public $building;
    public $maxFloors;
    public $floor;
    public $rooms;
    public $area;
    public $price;

    public function __construct(array $data)
    {
        $keys = [
            'city' => 'city',
            'district' => 'district',
            'address' => 'address',
            'residential_block' => 'residentialBlock',
            'building' => 'building',
            'max_floors' => 'maxFloors',
            'floor' => 'floor',
            'rooms' => 'rooms',
            'area' => 'area',
            'price' => 'price',
        ];

        foreach ($keys as $key => $prop) {
            if (isset($data[$key])) {
                $this->$prop = $data[$key];
            }
        }
    }
}
