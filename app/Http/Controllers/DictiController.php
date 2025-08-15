<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Resource\DictiResource;
use App\Http\Resource\ResourceNoRelationCall\DictiNRCResource;
use App\Http\Services\DictiService;
use Illuminate\Http\Request;

class DictiController extends Controller
{
    public $dictiService;
    public function __construct(DictiService $dictiService)
    {
        $this->dictiService = $dictiService;
    }

    public function all(Request $request)
    {
        if ($request->page) {
            $collection = $this->dictiService->paginate();
            return Response::response(
                $collection->setCollection(DictiResource::collection($collection->getCollection())->collection)
            );
        } else {
            return Response::response(DictiResource::collection($this->dictiService->all()));
        }
    }

    public function find($id)
    {
        return Response::response(new DictiResource($this->dictiService->find($id)));
    }
    public function getByColumn($column, $attribute)
    {
        return Response::response($this->dictiService->getByColumn($column, $attribute));
    }
    public function updateById($id, Request $request)
    {
        return Response::response($this->dictiService->updateById($id, $request->all()));
    }
    public function deleteById($id)
    {
        return Response::response($this->dictiService->deleteById($id));
    }
    public function create(Request $request)
    {
        return Response::response(new DictiResource($this->dictiService->create($request->all())));
    }

    public function list()
    {
        return Response::response(DictiResource::collection($this->dictiService->list())->sortBy('id')->values());
    }

    public function getBrands()
    {
        return Response::response($this->dictiService->getBrands());
    }
}
