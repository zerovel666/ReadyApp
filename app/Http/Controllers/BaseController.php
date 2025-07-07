<?php

namespace App\Http\Controllers;

use App\Http\Services\BaseService;

class BaseController extends Controller
{
    public $service;

    public function __construct(BaseService $service) {
        $this->service = $service;
    }

    public function all()
    {
        return $this->service->all();
    }

    public function find($id)
    {
        return $this->service->find($id);
    }
    public function getByColumn($column,$attribute)
    {
        return $this->service->getByColumn($column,$attribute);
    }
    public function updateByColumn($column,$value,$attributes)
    {
        return $this->service->updateByColumn($column,$value,$attributes);
    }
    public function deleteById($id)
    {
        return $this->service->deleteById($id);
    }
}