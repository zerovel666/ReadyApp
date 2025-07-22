<?php

namespace App\Http\Repository;

use App\Models\Booking;

class BookingRepository extends BaseRepository
{
    public function __construct(Booking $booking)
    {
        parent::__construct($booking);
    }

    public function checkBookingCarsInPeriod($car_id, $start, $end)
    {
        return $this->model
            ->where("car_id", $car_id)
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween("start_date", [$start, $end])
                    ->orWhereBetween("end_date", [$start, $end])
                    ->orWhere(function ($q) use ($start, $end) {
                        $q->where("start_date", "<=", $start)
                            ->where("end_date", ">=", $end);
                    });
            })
            ->exists();
    }
}
