<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $view = 'dashboard';
        return view('crm.dashboard', compact('view'));
    }
}
