<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Resource\BookingResource;
use App\Http\Services\BookingService;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public $bookingService;
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function create(Request $request)
    {
        if (Carbon::parse($request->start_date) < now() || Carbon::parse($request->start_date) > Carbon::parse($request->end_date)) {
            throw new ValidationException("ERROR DATE", 400);
        }
        return Response::response($this->bookingService->create($request->all()));
    }

    public function allMeByStatus(Request $request)
    {
        return Response::response(BookingResource::collection($this->bookingService->allMeByStatus($request->status)));
    }

    public function cancel($id)
    {
        return Response::response($this->bookingService->cancel($id));
    }

    public function paidTransacation(Request $request,$id)
    {
        $this->bookingService->paidTransacation($id,$request->amount ?? 0);
        return Response::response(["message" => "Success paid"]);
    }

    public function getUnavailableDatesByCarEquipmentId($id)
    {
        return $this->bookingService->getUnavailableDatesByCarEquipmentId($id);
    }
}
