<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $view = 'dashboard';
        return view('crm.dashboard', compact('view'));
    }

    public function hearbeat(Request $request)
    {
        User::where('id',Auth::user()->id)->update([
            "last_seen" => now()
        ]);
    }
}
