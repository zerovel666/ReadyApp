<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Resource\DamageNoteResource;
use App\Http\Services\DamageNoteService;
use Illuminate\Http\Request;

class DamageNoteController extends Controller
{
    public $damageNoteService;
    public function __construct(DamageNoteService $damageNoteService)
    {
        $this->damageNoteService = $damageNoteService;
    }

    public function all(Request $request)
    {
        return Response::response(DamageNoteResource::collection($this->damageNoteService->all()));
    }

    public function find($id)
    {
        return Response::response(new DamageNoteResource($this->damageNoteService->find($id)));
    }
    public function getByColumn($column, $attribute)
    {
        return Response::response($this->damageNoteService->getByColumn($column, $attribute));
    }
    public function updateById($id, Request $request)
    {
        return Response::response(new DamageNoteResource($this->damageNoteService->updateById($id, $request->all())));
    }
    public function deleteById($id)
    {
        return Response::response($this->damageNoteService->deleteById($id));
    }
    public function create(Request $request)
    {
        return Response::response(new DamageNoteResource($this->damageNoteService->create($request->all())));
    }

    public function getActive()
    {
        return Response::response(DamageNoteResource::collection($this->damageNoteService->getByColumn("is_resolved",false)));
    }
}
