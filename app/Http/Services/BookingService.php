<?php

namespace App\Http\Services;

use App\Http\Helpers\VerifiedHelper;
use App\Http\Repository\BookingRepository;
use App\Http\Repository\CarModelRepository;
use App\Http\Repository\CarRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingService extends BaseService
{
    public $carRepository;
    public $carModelRepository;
    public function __construct(BookingRepository $bookingRepository, CarRepository $carRepository, CarModelRepository $carModelRepository)
    {
        parent::__construct($bookingRepository);
        $this->carRepository = $carRepository;
        $this->carModelRepository = $carModelRepository;
    }

    public function create($attribute)
    {
        $user = Auth::user();

        VerifiedHelper::checkVerifed($user, $attribute);

        $model = DB::transaction(function () use ($attribute, $user) {
            $carModel = $this->carModelRepository->find($attribute['car_model_id']);
            $cars = $carModel->cars;

            if (!$user || !$carModel || empty($cars)) {
                throw new \Exception("User or car not found", 404);
            }
            $result = null;
            foreach ($cars as $car) {
                if (!$this->repository->checkBookingCarsInPeriod($car->id, $attribute["start_date"], $attribute['end_date'])) {
                    $result = $car;
                    break;
                }
            }

            if (!empty($result)) {
                $carBook = $result;
                $data = [
                    "user_id" => $user->id,
                    "car_id" => $carBook->id,
                    "start_date" => $attribute['start_date'],
                    "end_date" => $attribute['end_date'],
                    "status" => "pending"
                ];
                return $this->repository->create($data);
            } else {
                throw new \Exception("There is no available car of this model right now, sorry :)", 400);
            }
        });

        return $model;
    }

    public function allMeByStatus($status)
    {
        $user = Auth::user();
        return $this->repository->getByUserIdAndStatus($user->id,$status);
    }

    public function cancel($id)
    {
        $booking = $this->repository->find($id);
        if ($booking->user_id != Auth::user()->id){
            throw new \Exception("You don't can cancel this booking",403);
        }

        $booking->update(["status" => "canceled"]);
        return [
            "message" => "Success cancel"
        ];
    }
}
