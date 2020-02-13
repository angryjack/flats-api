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
            'city',
            'district',
            'address',
            'residentialBlock',
            'building',
            'maxFloors',
            'floor',
            'rooms',
            'area',
            'price',
        ];

        foreach ($keys as $key) {
            if (isset($data[$key])) {
                $this->$key = $data[$key];
            }
        }
    }
}
