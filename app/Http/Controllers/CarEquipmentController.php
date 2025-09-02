<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Resource\CarEquipmentResource;
use App\Http\Services\carEquipmentService;
use App\Models\CarEquipment;
use Illuminate\Http\Request;

class CarEquipmentController extends Controller
{
    public $carEquipmentService;
    public function __construct(CarEquipmentService $carEquipmentService)
    {
        $this->carEquipmentService = $carEquipmentService;
    }

    public function all(Request $request)
    {
        if ($request->page) {
            $collection = $this->carEquipmentService->paginate();
            return Response::response(
                $collection->setCollection(CarEquipmentResource::collection($collection->getCollection())->collection)
            );
        } else {
            return Response::response(CarEquipmentResource::collection($this->carEquipmentService->all()));
        }
    }

    public function find($id)
    {
        return Response::response(new CarEquipmentResource($this->carEquipmentService->find($id)));
    }
    public function getByColumn($column, $attribute)
    {
        return Response::response($this->carEquipmentService->getByColumn($column, $attribute));
    }
    public function updateById($id, Request $request)
    {
        return Response::response(new CarEquipmentResource($this->carEquipmentService->updateById($id, $request->all())));
    }
    public function deleteById($id)
    {
        return Response::response($this->carEquipmentService->deleteById($id));
    }
    public function create(Request $request)
    {
        return Response::response(new CarEquipmentResource($this->carEquipmentService->create($request->all())));
    }
    public function getByFilter(Request $request)
    {
        return Response::response(CarEquipmentResource::collection($this->carEquipmentService->getByFilter($request->all())));
    }

    public function getEquipmentByModelId($model_id)
    {
        return Response::response(CarEquipmentResource::collection($this->carEquipmentService->getByColumn("car_model_id",$model_id)));
    }

    public function dashboard()
    {
        return Response::response($this->carEquipmentService->dashboard());
    }
}
