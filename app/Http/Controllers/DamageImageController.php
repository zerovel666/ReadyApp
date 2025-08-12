<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Resource\DamageImageResource;
use App\Http\Services\DamageImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DamageImageController extends Controller
{
    public $damageImageService;
     
    public function __construct(DamageImageService $damageImageService) {
        $this->damageImageService = $damageImageService;
    }

    public function allByDamageNoteId($id)
    {
        return Response::response(DamageImageResource::collection($this->damageImageService->getByColumn("damage_note_id",$id)));
    }

    public function create(Request $request)
    {
        return Response::response(new DamageImageResource($this->damageImageService->create($request)));
    }

    public function deleteById($id)
    {
        return Response::response($this->damageImageService->deleteById($id));
    }
}
