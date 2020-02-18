<?php

namespace App\Services;

use App\Dto\Filter;
use App\Models\Flat;

class FlatService
{
    /**
     * @var BuildingService
     */
    private $buildingService;
    /**
     * @var CityService
     */
    private $cityService;
    /**
     * @var DistrictService
     */
    private $districtService;
    /**
     * @var ResidentialBlockService
     */
    private $residentialBlockService;

    public function __construct(
        BuildingService $buildingService,
        CityService $cityService,
        DistrictService $districtService,
        ResidentialBlockService $residentialBlockService
    )
    {
        $this->buildingService = $buildingService;
        $this->cityService = $cityService;
        $this->districtService = $districtService;
        $this->residentialBlockService = $residentialBlockService;
    }

    public function search(Filter $filter, int $page)
    {
        //todo кол-во элементов на странице. Можем передавать в запросе, можем брать из конфига и тд.
        $perPage = 1;

        $result = Flat
            // если задан район
            ::when($filter->district, function ($query) use ($filter) {
                $query->whereHas('district', function ($query) use ($filter) {
                    $query->where('districts.title', 'like', '%' . $filter->district . '%');
                });
            })
            // если не задан район, но задан город. (т.к. район в себе содержит уже город)
            ->when(!$filter->district && $filter->city, function ($query) use ($filter) {
                // так как квартиры у нас связаны с городами через районы, то
                // выбираем сначала все районы принадлежащие квартирам, а потом смотрим их города
                $query->whereHas('district', function ($query) use ($filter) {
                    $query->whereHas('city', function ($query) use ($filter) {
                        $query->where('cities.title', 'like', '%' . $filter->city . '%');
                    });
                });
            })
            //если передан адрес
            ->when($filter->address, function ($query) use ($filter) {
                // todo тут обработать возможные ошибки в названии
                $query->where('address', 'like', '%' . $filter->address . '%');
            })

            // жилой комплекс
            ->when($filter->residentialBlock, function ($query) use ($filter) {
                $query->whereHas('residentialBlock', function ($query) use ($filter) {
                    $query->where('residential_blocks.title', 'like', '%' . $filter->residentialBlock . '%');
                });
            })

            //корпус или максимальное кол-во этажей
            ->when($filter->building || $filter->maxFloors, function ($query) use ($filter) {
                $query->whereHas('building', function ($query) use ($filter) {
                    $query
                        ->where('buildings.title', 'like', '%' . $filter->residentialBlock . '%')
                        ->orWhere('max_floors', '<=', $filter->maxFloors);
                });
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

            // цена
            ->when($filter->price, function ($query) use ($filter) {
                $query->where('price', '<=', $filter->price);
            })

            // подгружаем с городом, районом и ЖК, корпусом
            ->with(['district.city', 'residentialBlock', 'building'])

            // пагинация
            ->skip($page * $perPage)
            ->take($perPage)
            // fixme вообще offset медленно работает при больших сдвигах,
            // поэтому можно заюзать дополнительное условие вместо него
            // например, запоминать последний просмотренный элемент, а потом
            // делать выборку от этого элемента
            // также результат может быть неконсистентый, если добавляются новые элементы

            // получаем результат
            ->get();

        return $result;
    }

    public function add(array $data): Flat
    {
        //добавляем город при условии, что его нет.
        //мы должны оперировать существующими городами, но
        //для демонстарции api сделаем возможность добавления.
        $city = $this->cityService->getOrCreate($data['city']);
        //добавляем район
        $district = $this->districtService->getOrCreate($city, $data['district']);
        //добавлям жилой комплекс
        $block = $this->residentialBlockService->getOrCreate($data['residential_block']);
        //корпус
        $building = $this->buildingService->getOrCreate($block, $data);


        $flat = Flat::create([
            'address' => $data['address'],
            'floor' => $data['floor'],
            'rooms' => $data['rooms'],
            'area' => $data['area'],
            'price' => $data['price'],

            // связи
            'residential_block_id' => $block->id,
            'district_id' => $district->id,
            'building_id' => $building->id
        ]);

        // можно еще так, это это доп запросы.
        //$flat->district()->associate($district);
        //$flat->residentialBlock()->associate($block);

        return $flat;
    }
}
