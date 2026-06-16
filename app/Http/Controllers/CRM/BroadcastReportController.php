<?php

namespace App\Http\Controllers\CRM;

use App\Exports\BroadcastReportExport;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Broadcast;
use App\Models\Company;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class BroadcastReportController extends Controller
{
    public function index()
    {
        $view = 'broadcast-report';
        $branches = Auth::user()->branch_id ? Branch::where('id', Auth::user()->branch_id)->get() : Branch::all();

        $users = Auth::user()->branch_id ? User::where('branch_id', Auth::user()->branch_id)->get() : User::all();
        return view('crm.reports.broadcast.index', compact('view', 'branches', 'users'));
    }


    public function table(Request $request)
    {
        if ($request->ajax()) {
            $data = Broadcast::query();
            if (Auth::user()->branch_id) {
                $data->where('branch_id', Auth::user()->branch_id);
            }
            if ($request->filter_start_date && $request->filter_end_date) {
                $data->whereBetween('created_at', [
                    $request->filter_start_date . ' 00:00:00',
                    $request->filter_end_date . ' 23:59:59'
                ]);
            }

            if ($request->filter_branch) {
                $data->where('branch_id', $request->filter_branch);
            }
            if ($request->filter_status) {
                $data->where('status', $request->filter_status);
            }
            if ($request->filter_created_by) {
                $data->where('userid', $request->filter_created_by);
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return date('d-m-Y', strtotime($row->created_at));
                })
                ->addColumn('branch_id', function ($row) {
                    return $row->branch?->branch_name ?? '';
                })
                ->addColumn('template', function ($row) {
                    return $row->template_name;
                })
                ->addColumn('user_id', function ($row) {
                    return $row->user?->name ?? '';
                })
                ->addColumn('percent_sent', function ($row) {
                    return number_format($row->sent / $row->total * 100) . '%';
                })
                ->addColumn('percent_failed', function ($row) {
                    return number_format($row->failed / $row->total * 100) . '%';
                })
                ->addColumn('action', function ($row) {
                    $button = '';
                    $button .= '<center>';
                    $button .= '<a href="' . url('/broadcast_detail_report/' . $row->id) . '"><button style="margin-left:3px;" title="Detail Data" class="btn btn-insoft btn-info"><i class="bi bi-list"></i></button></a>';

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
        return Excel::download(new BroadcastReportExport($request, $company), 'broadcast_report.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $company = Company::first();

        $data = Broadcast::query();
        if (Auth::user()->branch_id) {
            $data->where('branch_id', Auth::user()->branch_id);
        }
        if ($request->filter_start_date && $request->filter_end_date) {
            $data->whereBetween('created_at', [
                $request->filter_start_date . ' 00:00:00',
                $request->filter_end_date . ' 23:59:59'
            ]);
        }

        if ($request->filter_branch) {
            $data->where('branch_id', $request->filter_branch);
        }
        if ($request->filter_status) {
            $data->where('status', $request->filter_status);
        }
        if ($request->filter_created_by) {
            $data->where('userid', $request->filter_created_by);
        }

        $data = $data->get();        

        $pdf = Pdf::loadView('crm.reports.broadcast.pdf', compact('data', 'company'));

        // LANDSCAPE
        $pdf->setPaper('legal', 'landscape');

        return $pdf->stream('broadcast_report.pdf');
    }
}
