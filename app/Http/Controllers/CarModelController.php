<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Requests\CarModelRequest;
use App\Http\Resource\CarModelResource;
use App\Http\Services\CarModelService;
use Illuminate\Http\Request;

class CarModelController extends Controller
{
    public $carModelService;
    public function __construct(CarModelService $carModelService)
    {
        $this->carModelService = $carModelService;
    }

    public function all(Request $request)
    {
        if ($request->page) {
            $collection = $this->carModelService->paginate();
            return Response::response(
                $collection->setCollection(CarModelResource::collection($collection->getCollection())->collection)
            );
        } else {
            return Response::response(CarModelResource::collection($this->carModelService->all()));
        }
    }

    public function find($id)
    {
        return Response::response(new CarModelResource($this->carModelService->find($id)));
    }
    public function getByColumn($column, $attribute)
    {
        return Response::response($this->carModelService->getByColumn($column, $attribute));
    }
    public function updateById($id, CarModelRequest $request)
    {
        return Response::response(new CarModelResource($this->carModelService->updateById($id, $request->validationData())));
    }
    public function deleteById($id)
    {
        return Response::response($this->carModelService->deleteById($id));
    }
    public function create(CarModelRequest $request)
    {
        return Response::response(new CarModelResource($this->carModelService->create($request->validationData())));
    }

}
