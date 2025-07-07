<?php

namespace App\Http\Controllers;

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

    public function all()
    {
        return $this->countryService->all();
    }

    public function find($id)
    {
        return $this->countryService->find($id);
    }
    public function getByColumn($column, $attribute)
    {
        return $this->countryService->getByColumn($column, $attribute);
    }
    public function updateById($id, Request $request)
    {
        return $this->countryService->updateById($id, $request->all());
    }
    public function deleteById($id)
    {
        return $this->countryService->deleteById($id);
    }
    public function create(Request $request)
    {
        return $this->countryService->create($request->all());
    }
}
