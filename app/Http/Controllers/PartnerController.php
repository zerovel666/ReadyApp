<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Resource\PartnerResource;
use App\Http\Services\PartnerService;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public $partnerService;
    public function __construct(PartnerService $partnerService)
    {
        $this->partnerService = $partnerService;
    }

    public function all(Request $request)
    {
        return Response::response(PartnerResource::collection($this->partnerService->all()));
    }

    public function find($id)
    {
        return Response::response(new PartnerResource($this->partnerService->find($id)));
    }
    public function getByColumn($column, $attribute)
    {
        return Response::response($this->partnerService->getByColumn($column, $attribute));
    }
    public function updateById($id, Request $request)
    {
        return Response::response($this->partnerService->updateById($id, $request->all()));
    }
    public function deleteById($id)
    {
        return Response::response($this->partnerService->deleteById($id));
    }
    public function create(Request $request)
    {
        return Response::response(new PartnerResource($this->partnerService->create($request->all())));
    }
    public function upload(Request $request, $id)
    {
        return Response::response(new PartnerResource($this->partnerService->upload($request, $id)));
    }
}
