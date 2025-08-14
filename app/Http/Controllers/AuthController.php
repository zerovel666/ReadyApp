<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Services\AuthService;
use App\Http\Services\V2\AuthServiceV2;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public $authService;

    public function __construct(AuthServiceV2 $authService) {
        $this->authService = $authService;
    }

    public function register(Request $request) 
    {
        return Response::response($this->authService->register($request->all()));
    }

    public function login(Request $request) 
    {
        return Response::response($this->authService->login($request->all()));
    }

    public function refreshAuthToken(Request $request)
    {
        return Response::response($this->authService->refreshUserToken($request->refresh_token,$request->user_id));
    }

    // public function confirmTwoFactor(Request $request) 
    // {
    //     return Response::response($this->authService->confirmTwoFactor($request->all())); V1
    // }
}
