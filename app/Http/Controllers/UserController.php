<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Resource\UserResource;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
     public $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function all(Request $request)
    {
        if ($request->page) {
            $collection = $this->userService->paginate();
            return Response::response(
                $collection->setCollection(UserResource::collection($collection->getCollection())->collection)
            );
        } else {
            return Response::response($this->userService->all());
        }
    }

    public function find($id)
    {
        return Response::response(new UserResource($this->userService->find($id)));
    }
    public function getByColumn($column, $attribute)
    {
        return Response::response($this->userService->getByColumn($column, $attribute));
    }
    public function updateById($id, Request $request)
    {
        return Response::response($this->userService->updateById($id, $request->all()));
    }
    public function deleteById($id)
    {
        return Response::response($this->userService->deleteById($id));
    }
    public function create(Request $request)
    {
        return Response::response(new UserResource($this->userService->create($request->all())));
    }
    
}
