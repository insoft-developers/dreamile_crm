<?php

namespace App\Http\Controllers\CRM;

use App\Exports\AgentPerformExport;
use App\Exports\FRTSummaryExport;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Company;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
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
                    $button .= '<button style="margin-left:3px;" title="Detail Data" class="btn btn-insoft btn-info"><i class="bi bi-list"></i></button>';

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

    // function formatDuration($seconds)
    // {
    //     $minutes = floor($seconds / 60);
    //     $seconds = $seconds % 60;

    //     if ($minutes > 0) {
    //         return $minutes . ' Menit ' . $seconds . ' Detik';
    //     }

    //     return $seconds . ' Detik';
    // }
}
