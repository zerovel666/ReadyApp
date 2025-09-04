<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Resource\PromoCodeResource;
use App\Http\Services\PromoCodeService;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public $promoCodeService;
    public function __construct(PromoCodeService $promoCodeService)
    {
        $this->promoCodeService = $promoCodeService;
    }

    public function all(Request $request)
    {
        if ($request->page) {
            $collection = $this->promoCodeService->paginate();
            return Response::response(
                $collection->setCollection(PromoCodeResource::collection($collection->getCollection())->collection)
            );
        } else {
            return Response::response(PromoCodeResource::collection($this->promoCodeService->all()));
        }
    }

    public function find($id)
    {
        return Response::response(new PromoCodeResource($this->promoCodeService->find($id)));
    }
    public function getByColumn($column, $attribute)
    {
        return Response::response($this->promoCodeService->getByColumn($column, $attribute));
    }
    public function updateById($id, Request $request)
    {
        return Response::response(new PromoCodeResource($this->promoCodeService->updateById($id, $request->all())));
    }
    public function deleteById($id)
    {
        return Response::response($this->promoCodeService->deleteById($id));
    }
    public function create(Request $request)
    {
        return Response::response(new PromoCodeResource($this->promoCodeService->create($request->all())));
    }
}
