<?php

namespace App\Http\Services;

use App\Http\Repository\SupportRequestRepository;
use App\Http\Repository\UserRepository;
use App\Mail\SupportMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SupportRequestService extends BaseService
{
    public $userRepository;
    public function __construct(SupportRequestRepository $supportRequestRepository,UserRepository $userRepository) {
        parent::__construct($supportRequestRepository);
        $this->userRepository = $userRepository;
    }

    public function create($attribute)
    {
        $freeManagers = $this->userRepository->findFreeManager();
        $user = Auth::user();
        $data = [
            "user_id" => $user->id,
            "manager_id" => $freeManagers->id,
            "description" => $attribute['description'] ?? null,
            "booking_id" => $attribute['booking_id']
        ];

        $supportRequest = $this->repository->create($data);
        Mail::to($freeManagers->email)->send(new SupportMail($freeManagers,$supportRequest));
    }

}