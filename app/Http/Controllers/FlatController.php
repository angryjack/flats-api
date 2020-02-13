<?php

namespace App\Http\Controllers;

use App\Dto\Filter;
use App\Services\FlatService;
use Illuminate\Http\Request;

class FlatController extends Controller
{
    /**
     * @var FlatService
     */
    private $flatService;

    public function __construct(FlatService $flatService)
    {
        $this->flatService = $flatService;
    }

    public function add(Request $request)
    {
        //todo валидация
        $this->flatService->add($request->all());

        return ['status' => true];
    }

    public function search(Request $request)
    {
        //todo валидация
        //todo пагинация
        $filter = new Filter($request->all());
        $page = 1;
        return $this->flatService->search($filter, $page);
    }
}
