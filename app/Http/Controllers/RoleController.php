<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Requests\RoleRequest;
use App\Http\Resource\RoleResource;
use App\Http\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public $roleService;
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function all(Request $request)
    {
        if ($request->page) {
            $collection = $this->roleService->paginate();
            return Response::response(
                $collection->setCollection(RoleResource::collection($collection->getCollection())->collection)
            );
        } else {
            return Response::response(RoleResource::collection($this->roleService->all()));
        }
    }

    public function find($id)
    {
        return Response::response(new RoleResource($this->roleService->find($id)));
    }
    public function getByColumn($column, $attribute)
    {
        return Response::response($this->roleService->getByColumn($column, $attribute));
    }
    public function updateById($id, RoleRequest $request)
    {
        return Response::response(new RoleResource($this->roleService->updateById($id, $request->validationData())));
    }
    public function deleteById($id)
    {
        return Response::response($this->roleService->deleteById($id));
    }
    public function create(RoleRequest $request)
    {
        return Response::response(new RoleResource($this->roleService->create($request->validationData())));
    }

}
