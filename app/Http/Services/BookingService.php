<?php

namespace App\Http\Services;

use App\Http\Repository\BookingRepository;

class BookingService extends BaseService
{
    public function __construct(BookingRepository $bookingRepository) {
        parent::__construct($bookingRepository);
    }
}