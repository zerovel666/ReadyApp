<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AgentController extends Controller
{
    public function health(Request $request)
    {
        return Response::get($request, config('agent.url'));
    }

    
}
