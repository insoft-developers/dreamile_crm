<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
        $frtQuery = DB::table('whatsapp_conversations as wc')
            ->join('users as u', 'u.id', '=', 'wc.assigned_to')
            ->join('branches as br', 'br.id', '=', 'u.branch_id')
            ->select(
                'u.id',
                'u.name',
                'br.branch_name',

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

        $summary = DB::query()
            ->fromSub($frtQuery, 'frt')
            ->select(
                'id',
                'name',
                'branch_name',

                DB::raw('COUNT(*) as total_chat'),

                DB::raw('ROUND(AVG(frt_seconds)) as avg_frt'),

                DB::raw('MIN(frt_seconds) as fastest'),

                DB::raw('MAX(frt_seconds) as slowest')
            )
            ->groupBy(
                'id',
                'name',
                'branch_name'
            )
            ->get();

        dd($summary);
    }
}
