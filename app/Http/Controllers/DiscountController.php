<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Services\DiscountService;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public $discountService;

    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }

    public function create(Request $request)
    {
        $this->discountService->create($request->all());
        return Response::response(["message" => "Discount success created"]);
    }

    public function all(Request $request)
    {
        return Response::response($this->discountService->getByType($request->type));
    }

    public function updateById($id, Request $request)
    {
        $this->discountService->updateById($id, $request->all());
        return Response::response($this->discountService->find($id));
    }

    public function deleteById($id)
    {
        return Response::response($this->discountService->deleteById($id));
    }
}
