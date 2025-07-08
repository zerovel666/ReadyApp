<?php

namespace App\Http\Services;

use App\Http\Repository\PartnerRepository;
use Illuminate\Support\Facades\Storage;

class PartnerService extends BaseService
{
    public function __construct(PartnerRepository $partnerRepository)
    {
        parent::__construct($partnerRepository);
    }

    public function upload($request,$id)
    {
        if ($file = $request->file('logo_partner')) {
            $model = $this->repository->find($id);
            if (!$model){
                throw new \Exception("Object with id $id not found",404);
            }
            if ($model->logo_path){
                Storage::disk('public')->delete($model->logo_path);
            }
            $saveFile = Storage::disk('public')->put("readyApp/logoPartner",$file);
            $model->update([
                "logo_path" => $saveFile
            ]);
            return [
                "message" => "Success upload logo",
                "logo_path" => Storage::url($saveFile)
            ];
        }
        return [
            "message" => "noImage",
        ];
    }
}
