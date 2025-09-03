<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Resource\SupportRequestResource;
use App\Http\Services\SupportRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportRequestController extends Controller
{
    public $supportRequestService;

    public function __construct(SupportRequestService $supportRequestService) {
        $this->supportRequestService = $supportRequestService;
    }

    public function createSupport(Request $request)
    {
        $this->supportRequestService->create($request->all());
        return Response::response(["message" => "Support send for manager, please wait"]);
    }

    public function getMy()
    {
        return Response::response(SupportRequestResource::collection($this->supportRequestService->getByColumn("manager_id",Auth::user()->id)));
    }

    public function update(Request $request,$id)
    {
        return Response::response(new SupportRequestResource($this->supportRequestService->updateById($id,$request->all())));
    }
}
