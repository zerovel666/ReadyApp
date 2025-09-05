<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Resource\CarResource;
use App\Http\Services\CarService;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public $carService;
    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    public function all()
    {
        return Response::response(CarResource::collection($this->carService->all()));

    }

    public function find($id)
    {
        return Response::response(new CarResource($this->carService->find($id)));
    }
    public function getByColumn($column, $attribute)
    {
        return Response::response($this->carService->getByColumn($column, $attribute));
    }
    public function updateById($id, Request $request)
    {
        return Response::response(new CarResource($this->carService->updateById($id, $request->all())));
    }
    public function deleteById($id)
    {
        return Response::response($this->carService->deleteById($id));
    }
    public function create(Request $request)
    {
        return Response::response(new CarResource($this->carService->create($request->all())));
    }
    public function getByFilter(Request $request)
    {
        return Response::response(CarResource::collection($this->carService->getByFilter($request->all())));
    }
}
