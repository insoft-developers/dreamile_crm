<?php

namespace App\Http\Controllers\CRM;

use App\Exports\AgentPerformExport;
use App\Exports\FRTDetailExport;
use App\Exports\FRTSummaryExport;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Event;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class FirstResponseTimeController extends Controller
{
    public function index()
    {
        $view = 'frt';

        $consultants = Auth::user()->branch_id ? User::where('branch_id', Auth::user()->branch_id)->get() : User::all();
        $branches = Auth::user()->branch_id ? Branch::where('id', Auth::user()->branch_id)->get() : Branch::all();
        return view('crm.reports.frt.index', compact('view', 'consultants', 'branches'));
    }

    public function table(Request $request)
    {
        if ($request->ajax()) {

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

            if ($request->filter_branch) {
                $frtQuery->where('u.branch_id', $request->filter_branch);
            }

            if ($request->filter_consultant) {
                $frtQuery->where('u.id', $request->filter_consultant);
            }

            if ($request->filter_start_date && $request->filter_end_date) {
                $frtQuery->whereBetween('wc.created_at', [
                    $request->filter_start_date . ' 00:00:00',
                    $request->filter_end_date . ' 23:59:59'
                ]);
            }

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

            return DataTables::of($summary)
                ->addIndexColumn()

                ->addColumn('consultant', function ($row) {
                    return $row->name ?? '';
                })
                ->addColumn('branch_id', function ($row) {

                    return $row->branch_name ?? 'All branch';
                })
                ->addColumn('total_chat', function ($row) {
                    return $row->total_chat ?? 0;
                })
                ->addColumn('avg_frt', function ($row) {
                    return $row->avg_frt ? formatDuration($row->avg_frt) : 0;
                })
                ->addColumn('fastest', function ($row) {
                    return $row->fastest ? formatDuration($row->fastest) : 0;
                })
                ->addColumn('slowest', function ($row) {
                    return $row->slowest ? formatDuration($row->slowest) : 0;
                })
                ->addColumn('action', function ($row) {
                    $button = '';
                    $button .= '<center>';
                    $button .= '<a href="' . url('/first_response_time/' . $row->id) . '"><button style="margin-left:3px;" title="Detail Data" class="btn btn-insoft btn-info"><i class="bi bi-list"></i></button></a>';

                    $button .= '</center>';
                    return $button;
                })



                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function exportExcel(Request $request)
    {
        $company = Company::find(1);
        return Excel::download(new FRTSummaryExport($request, $company), 'first_response_time_report.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $company = Company::first();

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

        if ($request->filter_branch) {
            $frtQuery->where('u.branch_id', $request->filter_branch);
        }

        if ($request->filter_consultant) {
            $frtQuery->where('u.id', $request->filter_consultant);
        }

        if ($request->filter_start_date && $request->filter_end_date) {
            $frtQuery->whereBetween('wc.created_at', [
                $request->filter_start_date . ' 00:00:00',
                $request->filter_end_date . ' 23:59:59'
            ]);
        }

        $data = DB::query()
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

        $pdf = Pdf::loadView('crm.reports.frt.pdf', compact('data', 'company'));

        // LANDSCAPE
        $pdf->setPaper('legal', 'landscape');

        return $pdf->stream('first_response_time_report.pdf');
    }

    public function show(String $id)
    {
        $view = 'frt-detail';
        return view('crm.reports.frt.detail.index', compact('view'));
    }


    public function detailTable(Request $request)
    {
        if ($request->ajax()) {

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

            $query->where('u.id', $request->detailId);

            if ($request->filter_start_date && $request->filter_end_date) {

                $query->whereBetween('wc.created_at', [
                    $request->filter_start_date . ' 00:00:00',
                    $request->filter_end_date . ' 23:59:59'
                ]);
            }



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

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('customer', function ($row) {
                    return $row->fullname ?? '';
                })
                ->addColumn('consultant', function ($row) {
                    return $row->agent_name ?? '';
                })
                ->addColumn('branch_name', function ($row) {
                    return $row->branch_name ?? '';
                })
                ->addColumn('chat_masuk', function ($row) {
                    return  Carbon::parse($row->first_customer_message)->format('d-m-Y H:i:s');
                })
                ->addColumn('dibalas', function ($row) {
                    return  Carbon::parse($row->first_agent_message)->format('d-m-Y H:i:s');
                })
                ->addColumn('frt', function ($row) {
                    return formatDuration($row->frt_seconds);
                })

                ->rawColumns([])
                ->make(true);
        }
    }

    public function exportDetailExcel(Request $request)
    {
        $company = Company::find(1);
        return Excel::download(new FRTDetailExport($request, $company), 'first_response_detail_report.xlsx');
    }

    public function exportDetailPDF(Request $request)
    {
        $company = Company::first();

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

            $query->where('u.id', $request->agent_id);

            if ($request->filter_start_date && $request->filter_end_date) {

                $query->whereBetween('wc.created_at', [
                    $request->filter_start_date . ' 00:00:00',
                    $request->filter_end_date . ' 23:59:59'
                ]);
            }



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

        $pdf = Pdf::loadView('crm.reports.frt.detail.pdf', compact('data', 'company'));

        // LANDSCAPE
        $pdf->setPaper('legal', 'landscape');

        return $pdf->stream('first_response_detail_report.pdf');
    }
}
