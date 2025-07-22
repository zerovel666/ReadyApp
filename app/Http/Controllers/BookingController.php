<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public $bookingService;
    public function __construct(BookingService $bookingService) {
        $this->bookingService = $bookingService;
    }

    public function create(Request $request)
    {
        return Response::response($this->bookingService->create($request->all()));
    }
}
