<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function register(Request $request) 
    {
        Response::response($this->authService->register($request->all()));
    }

    public function login(Request $request) 
    {
        Response::response($this->authService->login($request->all()));
    }
    public function confirmTwoFactor(Request $request) 
    {
        Response::response($this->authService->confirmTwoFactor($request->all()));
    }
}
