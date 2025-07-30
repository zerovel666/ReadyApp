<?php

namespace App\Http\Services;

use App\Http\Helpers\VerifiedHelper;
use App\Http\Repository\AgentInfoRepository;
use App\Http\Repository\BookingRepository;
use App\Http\Repository\CarModelRepository;
use App\Http\Repository\CarRepository;
use App\Http\Repository\DictiRepository;
use App\Http\Repository\TaskRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingService extends BaseService
{
    public $carRepository;
    public $carModelRepository;
    public $agentInfoRepository;
    public $dictiRepository;
    public $taskRepository;
    public function __construct(BookingRepository $bookingRepository, CarRepository $carRepository, CarModelRepository $carModelRepository,AgentInfoRepository $agentInfoRepository,DictiRepository $dictiRepository,TaskRepository $taskRepository)
    {
        parent::__construct($bookingRepository);
        $this->carRepository = $carRepository;
        $this->carModelRepository = $carModelRepository;
        $this->agentInfoRepository = $agentInfoRepository;
        $this->dictiRepository = $dictiRepository;
        $this->taskRepository = $taskRepository;
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
                if (!$this->repository->checkBookingCarsInPeriod($car->id, $attribute["start_date"], $attribute['end_date']) && $car->status === 43) {
                    $car->location;
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

                $book = $this->repository->create($data);
                $agent = $this->getFreeAgent();
                $this->taskRepository->create([
                    "user_id" => $user->id,
                    "agent_id" => $agent->id,
                    "address_a" => $carBook->location->latitude." | ".$carBook->location->longitude,
                    "address_b" => $attribute['latitude']." | ".$attribute['longitude'],
                    "date_time_complete" => Carbon::parse($attribute['start_date'] . ' ' . $attribute['time']),
                    "check_list_id" => $this->dictiRepository->firstByColumnWhereActive("parent_id",57,true)->id,
                ]);

                return $book;
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

    public function getFreeAgent()
    {
        $status = $this->dictiRepository->firstByColumn("full_name","Active");
        return $this->agentInfoRepository->getByColumn("status_id",$status->id)->random();
    }
}
