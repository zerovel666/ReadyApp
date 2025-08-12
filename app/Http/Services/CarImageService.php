<?php

namespace App\Http\Services;

use App\Http\Repository\CarImageRepository;
use Illuminate\Support\Facades\Storage;

class CarImageService extends BaseService
{
    public function __construct(CarImageRepository $carImageRepository) {
        parent::__construct($carImageRepository);
    }

    public function create($request)
    {
        $data = $request->all();
        $filepath = Storage::disk('public')->put("readyApp/carImage/$request->model_id",$request->file('image'));
        $data['filepath'] = $filepath;
        return $this->repository->create($data);
    }
}