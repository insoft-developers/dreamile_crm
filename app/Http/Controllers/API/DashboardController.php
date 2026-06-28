<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct(
        protected DashboardService $service
    ){}

    public function index(Request $request)
    {

        return ApiResponse::success(

            $this->service->dashboard($request->user())

        );

    }

}