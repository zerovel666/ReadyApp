<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Resource\CarImageResource;
use App\Http\Services\CarImageService;
use App\Models\CarImage;
use Illuminate\Http\Request;

class CarImageController extends Controller
{
    public $carImageService;
    public function __construct(CarImageService $carImageService)
    {
        $this->carImageService = $carImageService;
    }

    public function all(Request $request)
    {
        if ($request->page) {
            $collection = $this->carImageService->paginate();
            return Response::response(
                $collection->setCollection(CarImageResource::collection($collection->getCollection())->collection)
            );
        } else {
            return Response::response(CarImageResource::collection($this->carImageService->all()));
        }
    }

    public function find($id)
    {
        return Response::response(new CarImageResource($this->carImageService->find($id)));
    }
    public function getByColumn($column, $attribute)
    {
        return Response::response($this->carImageService->getByColumn($column, $attribute));
    }
    public function updateById($id, Request $request)
    {
        return Response::response(new CarImageResource($this->carImageService->updateById($id, $request->all())));
    }
    public function deleteById($id)
    {
        return Response::response($this->carImageService->deleteById($id));
    }
    public function create(Request $request)
    {
        return Response::response(new CarImageResource($this->carImageService->create($request)));
    }
    public function getByCarModelId($car_model_id)
    {
        return Response::response(CarImageResource::collection($this->carImageService->getByColumn("car_equipment_id",$car_model_id)));
    }
}
