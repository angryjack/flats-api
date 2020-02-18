<?php

namespace App\Services;

use App\Dto\Filter;
use App\Models\Building;
use App\Models\City;
use App\Models\District;
use App\Models\Flat;
use App\Models\ResidentialBlock;

class FlatService
{
    public function search(Filter $filter, int $page)
    {
        return Flat
            // если задан район
            ::when($filter->district, function ($query) use ($filter) {
                $query->whereHas('district', function ($query) use ($filter) {
                    $query->where('districts.title', $filter->district);
                });
            })
            // если не задан район, но задан город. (т.к. район в себе содержит уже город)
            ->when(!$filter->district && $filter->city, function ($query) use ($filter) {
                // так как квартиры у нас связаны с городами через районы, то
                // выбираем сначала все районы принадлежащие квартирам, а потом смотрим их города
                $query->whereHas('district', function ($query) use ($filter) {
                    $query->whereHas('city', function ($query) use ($filter) {
                        $query->where('cities.title', $filter->city);
                    });
                });
            })
            //если передан адрес
            ->when($filter->address, function ($query) use ($filter) {
                // todo тут обработать возможные ошибки в названии
                $query->where('address', $filter->address);
            })
            // цена
            ->when($filter->price, function ($query) use ($filter) {
                $query->where('price', '<=', $filter->price);
            })
            // этаж
            ->when($filter->floor, function ($query) use ($filter) {
                $query->where('floor', $filter->floor);
            })
            // кол-во комнат
            ->when($filter->rooms, function ($query) use ($filter) {
                // меньше либо равно
                $query->where('rooms', '<=', $filter->rooms);
            })
            // площадь
            ->when($filter->rooms, function ($query) use ($filter) {
                // больше или равно
                $query->where('area', '>=', $filter->area);
            })
            // подгружаем с городом, районом и ЖК
            ->with(['district.city', 'residentialBlock'])
            ->get();
    }

    public function add(array $data)
    {
        $city = $this->getCity($data['city']);
        $district = $this->getDistrict($city, $data['district']);
        $block = $this->getResidentialBlock($data['residential_block']);

        if ($data['building']) {
            $building = $this->getBuilding($block, $data['building']);
        }

        $flat = Flat::create([
            'address' => $data['address'],
            'floor' => $data['floor'],
            'rooms' => $data['rooms'],
            'area' => $data['area'],
            'price' => $data['price'],

            // связи
            'residential_block_id' => $block->id,
            'district_id' => $district->id
        ]);

        // можно еще так, это это доп запросы.
        //$flat->district()->associate($district);
        //$flat->residentialBlock()->associate($block);
    }

    // получаем город
    // вообще мы не должны создавать город при добавлении квартиры,
    // они должны быть определены до запуска приложения, но
    // так как это тестовое задание, для упрощения работы - сделал.
    //todo завести под каждый метод ниже свой сервис
    public function getCity(string $title): City
    {
        return City::firstOrCreate(['title' => $title]);
    }

    public function getDistrict(City $city, string $title): District
    {
        return District::firstOrCreate([
            'title' => $title,
            'city_id' => $city->id
        ]);
    }

    public function getResidentialBlock(string $title): ResidentialBlock
    {
        return ResidentialBlock::firstOrCreate(['title' => $title]);
    }

    public function getBuilding(ResidentialBlock $block, string $title): Building
    {
        return Building::firstOrCreate([
            'title' => $title,
            'residential_block_id' => $block->id,
            'flats_from' => 0,
            'flats_to' => 99,
        ]);
    }
}
