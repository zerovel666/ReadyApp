<?php

namespace App\Http\Repository;

use App\Models\SupportRequest;

class SupportRequestRepository extends BaseRepository
{
    public function __construct(SupportRequest $supportRequest) {
        parent::__construct($supportRequest);
    }
}