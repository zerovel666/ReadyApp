<?php

namespace App\Http\Repository;

use App\Models\Dicti;

class DictiRepository extends BaseRepository
{
    public function __construct(Dicti $dicti) {
        parent::__construct($dicti);
    }

    public function getWithChildren($dictis = null)
    {
        if (is_null($dictis)){
            $dictis = $this->model->whereNull("parent_id")->get();
        }
        return $dictis->map(function($dicti){
            $children = $this->getWithChildren($dicti->children);
            $dicti->setRelation("children",$children);
            return $dicti;
        });
    }

    public function checkTypeAuth($type_auth_constant)
    {
        return $this->model->where("constant",$type_auth_constant)->first();
    }

    public function firstByColumnWhereActive($column,$value,$active)
    {
        return $this->model->where($column,$value)->where("active",$active)->first();
    }
}