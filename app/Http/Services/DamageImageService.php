<?php

namespace App\Http\Services;

use App\Http\Repository\DamageImageRepository;
use Illuminate\Support\Facades\Storage;

class DamageImageService extends BaseService
{
    public function __construct(DamageImageRepository $damageImageRepository)
    {
        parent::__construct($damageImageRepository);
    }

    public function create($request)
    {
        $data = $request->all();
        $filepath = Storage::disk('public')->put("readyApp/damageImage/$request->damage_note_id",$request->file('image'));
        $data['filepath'] = $filepath;
        return $this->repository->create($data);
    }
}
