<?php

namespace App\Http\Services;

use App\Http\Helpers\VerifiedHelper;
use App\Http\Repository\AgentInfoRepository;
use App\Http\Repository\BookingRepository;
use App\Http\Repository\CarModelRepository;
use App\Http\Repository\CarRepository;
use App\Http\Repository\DictiRepository;
use App\Http\Repository\TaskRepository;
use App\Http\Resource\BookingResource;
use App\Jobs\AutoPickDeliveryCarTask;
use App\Jobs\AutoPickReturnCarTask;
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
    public function __construct(BookingRepository $bookingRepository, CarRepository $carRepository, CarModelRepository $carModelRepository, AgentInfoRepository $agentInfoRepository, DictiRepository $dictiRepository, TaskRepository $taskRepository)
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
            $statusFree = $this->dictiRepository->firstByColumn("constant", "FREE");
            foreach ($cars as $car) {
                if ($car->status_id === $statusFree->id && !$this->repository->checkBookingCarsInPeriod($car->id, $attribute["start_date"], $attribute['end_date'])) {
                    $car->location;
                    $result = $car;
                    break;
                }
            }
            if (!empty($result)) {
                $carBook = $result;
                $bookData = [
                    "user_id" => $user->id,
                    "car_id" => $carBook->id,
                    "start_date" => $attribute['start_date'],
                    "end_date" => $attribute['end_date'],
                    "status" => "pending",
                    "latitude" => $attribute['latitude'],
                    "longitude" => $attribute['longitude'],
                ];

                $book = $this->repository->create($bookData);

                return [
                    "message" => "Please paid this transaction",
                    "book" => new BookingResource($book),
                    "transaction" => [
                        "id" => $book->id,
                        "status" => $book->status,
                        "amount" => round($car->model->amount * (Carbon::parse($book->start_date)->diffInDays(Carbon::parse($book->end_date)) + 1))
                    ]
                ];
            } else {
                throw new \Exception("There is no available car of this model right now, sorry :)", 400);
            }
        });

        return $model;
    }

    public function allMeByStatus($status)
    {
        $user = Auth::user();
        return $this->repository->getByUserIdAndStatus($user->id, $status);
    }

    public function cancel($id)
    {
        $booking = $this->repository->find($id);
        if ($booking->user_id != Auth::user()->id) {
            throw new \Exception("You don't can cancel this booking", 403);
        }

        $booking->update(["status" => "canceled"]);
        $this->taskRepository->updateByColumn("booking_id", $booking->id, [
            "status_id" => $this->dictiRepository->getChildrenByConstant("STATUS_TASK")->where("constant", "CANCEL")->first()->id
        ]);
        return [
            "message" => "Success cancel"
        ];
    }

    public function paidTransacation($book_id, $amount)
    {
        $book = $this->repository->find($book_id);
        $car = $book->car;
        if (round($car->model->amount * (Carbon::parse($book->start_date)->diffInDays(Carbon::parse($book->end_date)) + 1)) > $amount) {
            throw new \Exception("insufficient funds", 400);
        }

        $book->update(["status" => "approved"]);
        if (Carbon::parse($book->start_date)->lessThanOrEqualTo(now()->addHours(24))) {
            (new AutoPickDeliveryCarTask($book->id))->handle();
        } else {
            AutoPickDeliveryCarTask::dispatch($book->id)->delay(Carbon::parse($book->start_date)->subDay());
        }

        if (Carbon::parse($book->end_date)->lessThanOrEqualTo(now()->addHours(24))) {
            (new AutoPickReturnCarTask($book->id))->handle();
        } else {
            AutoPickReturnCarTask::dispatch($book->id)->delay(Carbon::parse($book->end_date)->subDay());
        }
    }
}
