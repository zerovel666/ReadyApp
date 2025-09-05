<?php

namespace App\Http\Services;

use App\Http\Helpers\VerifiedHelper;
use App\Http\Repository\AgentInfoRepository;
use App\Http\Repository\BookingRepository;
use App\Http\Repository\CarEquipmentRepository;
use App\Http\Repository\CarModelRepository;
use App\Http\Repository\CarRepository;
use App\Http\Repository\DictiRepository;
use App\Http\Repository\PromoCodeRepository;
use App\Http\Repository\TaskRepository;
use App\Http\Resource\BookingResource;
use App\Jobs\AutoPickDeliveryCarTask;
use App\Jobs\AutoPickReturnCarTask;
use App\Models\Booking;
use App\Models\CarEquipment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingService extends BaseService
{
    public $carRepository;
    public $carModelRepository;
    public $agentInfoRepository;
    public $dictiRepository;
    public $taskRepository;
    public $carEquipmentRepository;
    public $promoCodeRepository;
    public function __construct(BookingRepository $bookingRepository, CarRepository $carRepository, CarModelRepository $carModelRepository, AgentInfoRepository $agentInfoRepository, DictiRepository $dictiRepository, TaskRepository $taskRepository, CarEquipmentRepository $carEquipmentRepository,PromoCodeRepository $promoCodeRepository)
    {
        parent::__construct($bookingRepository);
        $this->carRepository = $carRepository;
        $this->carModelRepository = $carModelRepository;
        $this->agentInfoRepository = $agentInfoRepository;
        $this->dictiRepository = $dictiRepository;
        $this->taskRepository = $taskRepository;
        $this->carEquipmentRepository = $carEquipmentRepository;
        $this->promoCodeRepository = $promoCodeRepository;
    }

    public function create($attribute)
    {
        $user = Auth::user();
        VerifiedHelper::checkVerifed($user, $attribute);

        $model = DB::transaction(function () use ($attribute, $user) {
            $carEquipment = $this->carEquipmentRepository->find($attribute['car_equipment_id']);
            $cars = $carEquipment->cars;
            if (!$user || !$carEquipment || empty($cars)) {
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

                $amount = round($carEquipment->amount * (Carbon::parse($book->start_date)->diffInDays(Carbon::parse($book->end_date)) + 1));

                if ($attribute['promo_code']){
                    if ($promo = $this->promoCodeRepository->firstByColumn('code', $attribute['promo_code'])){
                        if (!$promo->is_global){
                            if ($promo->user_id == $user->id){
                                $amount = $amount / $promo->percent;
                                $promo->update(["count_use" => $promo->count_use + 1]);
                            } else {
                                throw new \Exception("This promo does not belong to you",400);
                            }
                        }else{
                            $amount = $amount / $promo->percent;
                            $promo->update(["count_use" => $promo->count_use + 1]);
                        }
                    }else{
                        throw new \Exception('Promo not found',404);
                    }
                }

                return [
                    "message" => "Please paid this transaction",
                    "book" => new BookingResource($book),
                    "transaction" => [
                        "id" => $book->id,
                        "status" => $book->status,
                        "amount" => $amount
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
        if (round($car->carEquipment->amount * (Carbon::parse($book->start_date)->diffInDays(Carbon::parse($book->end_date)) + 1)) > $amount) {
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

    public function getUnavailableDatesByCarEquipmentId(int $id): array
    {
        $equipment = CarEquipment::with('cars')->findOrFail($id);
        $cars = $equipment->cars;

        $carIds = $cars->pluck('id');
        $carCount = $cars->count();

        // только актуальные брони (сегодня и в будущем)
        $bookings = Booking::query()
            ->whereIn('car_id', $carIds)
            ->where('end_date', '>=', now())
            ->whereIn('status', ['approved', 'pending']) // только реальные брони
            ->get(['car_id', 'start_date', 'end_date']);

        $dates = [];

        foreach ($bookings as $booking) {
            $period = new \DatePeriod(
                new \DateTime($booking->start_date),
                new \DateInterval('P1D'),
                (new \DateTime($booking->end_date))->modify('+1 day')
            );

            foreach ($period as $day) {
                $d = $day->format('Y-m-d');
                $dates[$d] = ($dates[$d] ?? 0) + 1;
            }
        }

        // выбираем только те дни, когда заняты все машины комплектации
        $unavailableDays = array_keys(array_filter($dates, fn($count) => $count >= $carCount));

        // группируем подряд идущие дни в диапазоны
        $result = [];
        if (!empty($unavailableDays)) {
            sort($unavailableDays);
            $start = $prev = $unavailableDays[0];

            foreach (array_slice($unavailableDays, 1) as $day) {
                if ((new \DateTime($day))->modify('-1 day')->format('Y-m-d') !== $prev) {
                    $result[] = ['from' => $start, 'to' => $prev];
                    $start = $day;
                }
                $prev = $day;
            }
            $result[] = ['from' => $start, 'to' => $prev];
        }

        return $result;
    }

    public function getHistoryBookingByCarId($id)
    {
        return $this->repository->getHistoryBookingByCarId($id);
    }
}
