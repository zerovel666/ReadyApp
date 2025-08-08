<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Resource\TaskResource;
use App\Http\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public $taskService;
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function all(Request $request)
    {
        if ($request->page) {
            $collection = $this->taskService->paginate();
            return Response::response(
                $collection->setCollection(TaskResource::collection($collection->getCollection())->collection)
            );
        } else {
            return Response::response(TaskResource::collection($this->taskService->all()));
        }
    }

    public function find($id)
    {
        return Response::response(new TaskResource($this->taskService->find($id)));
    }
    public function getByColumn($column, $attribute)
    {
        return Response::response($this->taskService->getByColumn($column, $attribute));
    }
    public function updateById($id, Request $request)
    {
        return Response::response(new TaskResource($this->taskService->updateById($id, $request->all())));
    }
    public function deleteById($id)
    {
        return Response::response($this->taskService->deleteById($id));
    }
    public function create(Request $request)
    {
        return Response::response(new TaskResource($this->taskService->create($request->all())));
    }
}
