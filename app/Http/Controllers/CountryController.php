<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Requests\CountryRequest;
use App\Http\Services\CountryService;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public $countryService;
    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function all(Request $request)
    {
        if ($request->page) {
            return Response::response($this->countryService->paginate());
        } else {
            return Response::response($this->countryService->all());
        }
    }

    public function find($id)
    {
        return Response::response($this->countryService->find($id));
    }
    public function getByColumn($column, $attribute)
    {
        return Response::response($this->countryService->getByColumn($column, $attribute));
    }
    public function updateById($id, CountryRequest $request)
    {
        return Response::response($this->countryService->updateById($id, $request->validationData()));
    }
    public function deleteById($id)
    {
        return Response::response($this->countryService->deleteById($id));
    }
    public function create(CountryRequest $request)
    {
        return Response::response($this->countryService->create($request->validationData()));
    }
}
