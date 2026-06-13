<?php

namespace App\Http\Controllers\CRM;

use App\Exports\AgentPerformExport;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Event;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class AgentPerformReportController extends Controller
{
    public function index()
    {
        $view = 'agent-perform-report';
        $consultants = Auth::user()->branch_id ? User::where('branch_id', Auth::user()->branch_id)->get() : User::all();


        $branches = Auth::user()->branch_id ? Branch::where('id', Auth::user()->branch_id)->get() : Branch::all();

        return view('crm.reports.agent_perform.index', compact('view', 'consultants', 'branches'));
    }


    public function table(Request $request)
    {
        if ($request->ajax()) {
            // $data = User::query();
            $query = DB::table('users as u')
                ->leftJoin('whatsapp_conversations as wc', 'wc.assigned_to', '=', 'u.id')
                ->leftJoin('whatsapp_messages as wm', 'wm.conversation_id', '=', 'wc.id')
                ->leftJoin('branches as br', 'u.branch_id', '=', 'br.id');

            if ($request->filter_start_date && $request->filter_end_date) {
                $query->whereBetween('wc.created_at', [
                    $request->filter_start_date . ' 00:00:00',
                    $request->filter_end_date . ' 23:59:59'
                ]);
            }

            if ($request->filter_consultant) {
                $query->where('u.id', $request->filter_consultant);
            }
            if ($request->filter_branch) {
                $query->where('u.branch_id', $request->filter_branch);
            }

            $data = $query
                ->select(
                    'u.id',
                    'u.name',
                    'u.branch_id',
                    'br.branch_name',
                    DB::raw('COUNT(DISTINCT wc.id) as assigned_chat'),
                    DB::raw("COUNT(DISTINCT CASE WHEN wc.status='open' THEN wc.id END) as open_chat"),
                    DB::raw("COUNT(DISTINCT CASE WHEN wc.status='resolve' THEN wc.id END) as closed_chat"),
                    DB::raw("COUNT(CASE WHEN wm.sender='customer' THEN wm.id END) as incoming_message"),
                    DB::raw("COUNT(CASE WHEN wm.sender='agent' THEN wm.id END) as outgoing_message")
                )
                ->groupBy('u.id', 'u.name', 'u.branch_id', 'br.branch_name')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('consultant', function ($row) {
                    return $row->name ?? '';
                })
                ->addColumn('branch_id', function ($row) {

                    return $row->branch_id ? $row->branch_name : 'All branch';
                })
                ->addColumn('assigned_chat', function ($row) {
                    return $row->assigned_chat;
                })
                ->addColumn('open', function ($row) {
                    return $row->open_chat;
                })
                ->addColumn('closed', function ($row) {
                    return $row->closed_chat;
                })
                ->addColumn('incoming', function ($row) {
                    return $row->incoming_message;
                })
                ->addColumn('outgoing', function ($row) {
                    return $row->outgoing_message;
                })

                ->rawColumns([''])
                ->make(true);
        }
    }


    public function exportExcel(Request $request)
    {
        $company = Company::find(1);
        return Excel::download(new AgentPerformExport($request, $company), 'agent_performance_report.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $company = Company::first();

        $query = DB::table('users as u')
            ->leftJoin('whatsapp_conversations as wc', 'wc.assigned_to', '=', 'u.id')
            ->leftJoin('whatsapp_messages as wm', 'wm.conversation_id', '=', 'wc.id')
            ->leftJoin('branches as br', 'u.branch_id', '=', 'br.id');

        if ($request->filter_start_date && $request->filter_end_date) {
            $query->whereBetween('wc.created_at', [
                $request->filter_start_date . ' 00:00:00',
                $request->filter_end_date . ' 23:59:59'
            ]);
        }

        if ($request->filter_consultant) {
            $query->where('u.id', $request->filter_consultant);
        }
        if ($request->filter_branch) {
            $query->where('u.branch_id', $request->filter_branch);
        }

        $data = $query
            ->select(
                'u.id',
                'u.name',
                'u.branch_id',
                'br.branch_name',
                DB::raw('COUNT(DISTINCT wc.id) as assigned_chat'),
                DB::raw("COUNT(DISTINCT CASE WHEN wc.status='open' THEN wc.id END) as open_chat"),
                DB::raw("COUNT(DISTINCT CASE WHEN wc.status='resolve' THEN wc.id END) as closed_chat"),
                DB::raw("COUNT(CASE WHEN wm.sender='customer' THEN wm.id END) as incoming_message"),
                DB::raw("COUNT(CASE WHEN wm.sender='agent' THEN wm.id END) as outgoing_message")
            )
            ->groupBy('u.id', 'u.name', 'u.branch_id', 'br.branch_name')
            ->get();

        $pdf = Pdf::loadView('crm.reports.agent_perform.pdf', compact('data', 'company'));

        // LANDSCAPE
        $pdf->setPaper('legal', 'landscape');

        return $pdf->stream('event_report.pdf');
    }
}
