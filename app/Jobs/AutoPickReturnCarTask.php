<?php

namespace App\Jobs;

use App\Http\Controllers\TelegramWebhookController;
use App\Http\Repository\BookingRepository;
use App\Http\Repository\DictiRepository;
use App\Http\Repository\TaskRepository;
use App\Http\Services\AgentInfoService;
use App\Mail\SendMailAgentForReturnCar;
use App\Mail\SendMailDeliverCar;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Throwable;

class AutoPickReturnCarTask implements ShouldQueue
{
    use Queueable;

    public $bookingRepository;
    public $taskRepository;
    public $booking_id;
    public $agentInfoSerivce;
    public $dictiRepository;
    public $telegramWebHookController;

    public function __construct($booking_id)
    {
        $this->bookingRepository = app(BookingRepository::class);
        $this->taskRepository = app(TaskRepository::class);
        $this->agentInfoSerivce = app(AgentInfoService::class);
        $this->dictiRepository = app(DictiRepository::class);
        $this->telegramWebHookController = app(TelegramWebhookController::class);
        $this->booking_id = $booking_id;
    }

    public function handle(): void
    {
        try {
            $booking = $this->bookingRepository->find($this->booking_id);
            $now = now();
            $end_date = Carbon::parse($booking->end_date);
            $deadline = $end_date->copy()->subHours(1);
            $dictiCheckList = $this->dictiRepository->firstByColumnWhereActive("constant","AGENT_CHECK_LISTS");
            if ($end_date->between($now, $now->copy()->addHours(24))) {
                $agent = $this->agentInfoSerivce->getFreeAgent();
                $this->taskRepository->create([
                    "user_id" => $booking->user_id,
                    "agent_id" => $agent->id,
                    "car_id" => $booking->car_id,
                    "type_id" => $this->dictiRepository->firstByColumnWhereActive("constant", "RETURN_CAR")->id,
                    "booking_id" => $booking->id,
                    "longitude_a" => $booking->car->location->longitude,
                    "latitude_a" => $booking->car->location->latitude,
                    "longitude_b" => $booking->longitude,
                    "latitude_b" => $booking->latitude,
                    "date_time_complete" => $deadline,
                    "check_list_id" => $this->dictiRepository->getChildrenByParentId($dictiCheckList->id)->where("active","true")->first()->id,
                    "description" => "Deliver the rented car to the customer before the rental period begins",
                ]);
                if ($email = $agent->user->email) {
                    Mail::to($email)->send(new SendMailAgentForReturnCar(
                        $deadline,
                        $booking->car->location->longitude,
                        $booking->car->location->latitude,
                        $booking->longitude,
                        $booking->latitude,
                    ));
                }
                if ($telegram_chat_id = $agent->user->telegram_chat_id) {
                    $this->telegramWebHookController->send([
                        "chat_id" => $telegram_chat_id,
                        "body" => [
                            "text" => "New Task: Deliver the car to the customer\n\n" .
                                "Deadline: {$deadline}\n" .
                                "From: {$booking->car->location->latitude}, {$booking->car->location->longitude}\n" .
                                "To: {$booking->latitude}, {$booking->longitude}\n\n" .
                                "Please ensure the car is delivered on time.",
                            "parse_mode" => "Markdown"
                        ]
                    ]);
                }
                \Log::channel('worker')->info("SUCCESS WORK", ["SUCCESS" => "RETURN CAR"]);
            } else {
                \Log::channel('worker')->info("CREATE NEW WORK", ["NEW" => "RETURN CAR"]);
                AutoPickReturnCarTask::dispatch($booking->id)->delay($end_date->copy()->subDay());
            }
        } catch (Throwable $e) {
            \Log::channel('worker')->info("ERROR WORK AutoPickReturnCarTask JOB", [$e->getMessage(), $e->getTraceAsString()]);
            AutoPickReturnCarTask::dispatch($booking->id)->delay(Carbon::parse($booking->end_date)->subDay());
        }
    }
}
