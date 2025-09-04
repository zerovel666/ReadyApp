<?php

namespace App\Http\Services;

use App\Http\Repository\CarEquipmentRepository;
use App\Http\Repository\CarModelRepository;
use App\Http\Repository\DiscountRepository;

class DiscountService extends BaseService
{
    public $carEquipmentRepository;
    public $carModelRepository;
    public function __construct(DiscountRepository $discountRepository, CarEquipmentRepository $carEquipmentRepository, CarModelRepository $carModelRepository)
    {
        parent::__construct($discountRepository);
        $this->carModelRepository = $carModelRepository;
        $this->carEquipmentRepository = $carEquipmentRepository;
    }

    public function create($data)
    {
        if ($data['type'] == "carModel") {
            $object = $this->carModelRepository->find($data['item_id']);
        } elseif ($data['type'] == "carEquipment") {
            $object = $this->carEquipmentRepository->find($data['item_id']);
        } else {
            throw new \Exception("Send valid type", 400);
        }

        return $object->discounts()->create([
            'percent' => $data['percent'],
        ]);
    }

    public function getByType($type)
    {
        if ($type == "carModel"){
            return $this->carModelRepository->getWithDiscount();
        } elseif ($type == "carEquipment"){
            return $this->carEquipmentRepository->getWithDiscount();
        } else {
            throw new \Exception("Send valid type", 400);
        }
    }
}
