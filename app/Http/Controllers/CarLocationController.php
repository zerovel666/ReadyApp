<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Resource\CarLocationResource;
use App\Http\Services\CarLocationService;
use Illuminate\Http\Request;

class CarLocationController extends Controller
{
    public $carLocationService;
    public function __construct(CarLocationService $carLocationService)
    {
        $this->carLocationService = $carLocationService;
    }

    public function all(Request $request)
    {
        if ($request->page) {
            $collection = $this->carLocationService->paginate();
            return Response::response(
                $collection->setCollection(CarLocationResource::collection($collection->getCollection())->collection)
            );
        } else {
            return Response::response(CarLocationResource::collection($this->carLocationService->all()));
        }
    }

    public function find($id)
    {
        return Response::response(new CarLocationResource($this->carLocationService->find($id)));
    }
    public function getByColumn($column, $attribute)
    {
        return Response::response($this->carLocationService->getByColumn($column, $attribute));
    }
    public function updateById($id, Request $request)
    {
        return Response::response(new CarLocationResource($this->carLocationService->updateById($id, $request->all())));
    }
    public function deleteById($id)
    {
        return Response::response($this->carLocationService->deleteById($id));
    }
    public function create(Request $request)
    {
        return Response::response(new CarLocationResource($this->carLocationService->create($request->all())));
    }
    public function getByCarId($car_id)
    {
        return Response::response($this->carLocationService->getByColumn("car_id", $car_id));
    }
}
