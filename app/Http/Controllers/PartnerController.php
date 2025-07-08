<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Requests\PartnerRequest;
use App\Http\Services\PartnerService;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public $partnerService;
    public function __construct(PartnerService $partnerService)
    {
        $this->partnerService = $partnerService;
    }

    public function all()
    {
        return Response::response($this->partnerService->all());
    }

    public function find($id)
    {
        return Response::response($this->partnerService->find($id));
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
    public function create(PartnerRequest $request)
    {
        return Response::response($this->partnerService->create($request->validationData()));
    }
    public function upload(Request $request,$id)
    {
        return Response::response($this->partnerService->upload($request,$id));
    }
}
