<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index() {
        $data = DB::table('users as u')
                ->leftJoin('whatsapp_conversations as wc', 'wc.assigned_to', '=', 'u.id')
                ->leftJoin('whatsapp_messages as wm', 'wm.conversation_id', '=', 'wc.id')
                ->select(
                    'u.id',
                    'u.name',
                    DB::raw('COUNT(DISTINCT wc.id) as assigned_chat'),
                    DB::raw("COUNT(DISTINCT CASE WHEN wc.status='open' THEN wc.id END) as open_chat"),
                    DB::raw("COUNT(DISTINCT CASE WHEN wc.status='resolve' THEN wc.id END) as closed_chat"),
                    DB::raw("COUNT(CASE WHEN wm.sender='customer' THEN wm.id END) as incoming_message"),
                    DB::raw("COUNT(CASE WHEN wm.sender='agent' THEN wm.id END) as outgoing_message")
                )
                ->groupBy('u.id', 'u.name')
                ->get();

        dd($data);
    }
}
