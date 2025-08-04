<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Resource\BookingResource;
use App\Http\Services\BookingService;
use App\Models\Booking;
use Carbon\Carbon;
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
        return Response::response(new BookingResource($this->bookingService->create($request->all())));
    }

    public function allMeByStatus(Request $request)
    {
        return Response::response(BookingResource::collection($this->bookingService->allMeByStatus($request->status)));
    }

    public function cancel($id)
    {
        return Response::response($this->bookingService->cancel($id));
    }
}
