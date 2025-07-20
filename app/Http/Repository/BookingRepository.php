<?php

namespace App\Http\Repository;

use App\Models\Booking;

class BookingRepository extends BaseRepository
{
    public function __construct(Booking $booking) {
        parent::__construct($booking);
    }
}