<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
        $query = DB::table('whatsapp_conversations as wc')
                ->join('users as u', 'u.id', '=', 'wc.assigned_to')
                ->leftJoin('branches as br', 'br.id', '=', 'u.branch_id')
                ->leftJoin('customers as cust', 'cust.phone_number', '=', 'wc.phone')

                ->select(
                    'wc.id',
                    'cust.fullname',
                    'wc.phone',

                    'u.name as agent_name',
                    'br.branch_name',

                    DB::raw("
            (
                SELECT MIN(created_at)
                FROM whatsapp_messages
                WHERE conversation_id = wc.id
                AND sender = 'customer'
            ) as first_customer_message
        "),

                    DB::raw("
            (
                SELECT MIN(created_at)
                FROM whatsapp_messages
                WHERE conversation_id = wc.id
                AND sender = 'agent'
            ) as first_agent_message
        "),

                    DB::raw("
            TIMESTAMPDIFF(
                SECOND,

                (
                    SELECT MIN(created_at)
                    FROM whatsapp_messages
                    WHERE conversation_id = wc.id
                    AND sender = 'customer'
                ),

                (
                    SELECT MIN(created_at)
                    FROM whatsapp_messages
                    WHERE conversation_id = wc.id
                    AND sender = 'agent'
                )
            ) as frt_seconds
        ")
                );

            $query->where('u.id', 2);

            $query->whereExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('whatsapp_messages')
                    ->whereColumn(
                        'whatsapp_messages.conversation_id',
                        'wc.id'
                    )
                    ->where('sender', 'agent');
            });

            $data = $query
                
                ->get();

        dd($data);
    }
}
