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
        $this->validateAddRequest($request);
        $flat = $this->flatService->add($request->all());

        return ['status' => true, 'body' => $flat];
    }

    public function search(Request $request)
    {
        $this->validateSearchRequest($request);
        $filter = new Filter($request->all());
        $page = $request->input('page', 0);
        $result = $this->flatService->search($filter, $page);

        return ['status' => true, 'body' => $result];
    }

    private function validateAddRequest(Request $request)
    {
        $this->validate($request, [
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'address' => 'required|string',
            'residential_block' => 'required|string',
            'building' => 'string',
            'max_floors' => 'required|integer',
            'rooms' => 'required|integer|min:1',
            'area' => 'required|integer|min:1',
            'price' => 'required|integer|min:1',
        ]);
    }

    private function validateSearchRequest(Request $request)
    {
        $this->validate($request, [
            'page' => 'integer|min:1',
            'city' => 'string|max:255',
            'district' => 'string|max:255',
            'address' => 'string',
            'residential_block' => 'string',
            'building' => 'string',
            'max_floors' => 'integer',
            'rooms' => 'integer|min:1',
            'area' => 'integer|min:1',
            'price' => 'integer|min:1',
        ]);
    }
}
