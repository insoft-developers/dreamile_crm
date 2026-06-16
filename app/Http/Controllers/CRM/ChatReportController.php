<?php

namespace App\Http\Controllers\CRM;

use App\Exports\ChatHistoryExport;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Customer;
use App\Models\User;
use App\Models\WhatsappConversation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ChatReportController extends Controller
{
    public function index()
    {
        $view = 'chatting-report';
        $customers = Customer::all();
        $users = User::all();
        $branches = Branch::all();
        return view('crm.reports.chat.index', compact('view', 'customers', 'users', 'branches'));
    }

    public function table(Request $request)
    {
        if ($request->ajax()) {
            

            $data = WhatsappConversation::with('agent');
            if ($request->filter_start_date && $request->filter_end_date) {
                $data->whereBetween('created_at', [
                    $request->filter_start_date . ' 00:00:00',
                    $request->filter_end_date . ' 23:59:59'
                ]);
            }

            if ($request->filter_customer) {
                $data->where('phone', $request->filter_customer);
            }

            if ($request->filter_branch) {
                $branchId = $request->filter_branch;
                $data->whereHas('agent', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                });
            }

            if ($request->filter_consultant) {
                $data->where('assigned_to', $request->filter_consultant);
            }

            if ($request->filter_status) {
                $data->where('status', $request->filter_status);
            }


            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('created_at', function ($row) {
                    return date('d-m-Y H:i', strtotime($row->created_at));
                })
                ->addColumn('customer', function ($row) {
                    return optional($row->customer)->fullname ?? '';
                })
                ->addColumn('phone', function ($row) {
                    return $row->phone;
                })
                ->addColumn('consultant', function ($row) {
                    return optional($row->agent)->name ?? '';
                })
                ->addColumn('branch', function ($row) {
                    return optional($row->agent)->branch?->branch_name ?? '';
                })
                ->addColumn('status', function ($row) {
                    return $row->status == 'open' ? '<span class="badge bg-success">Open</span>' : '<span class="badge bg-danger">Resolved</span>';
                })
                ->addColumn('last_message_at', function ($row) {
                    return $row->last_message_at ? date('d-m-Y H:i:s', strtotime($row->last_message_at)) : '';
                })
                ->addColumn('assign_at', function ($row) {
                    return $row->assign_at ? date('d-m-Y H:i:s', strtotime($row->last_message_at)) : '';
                })
                ->addColumn('action', function ($row) {
                    $button = '';
                    $button .= '<center>';
                    $button .= '<a href="' . url('/chat_detail_report/' . $row->id) . '"><button style="margin-left:3px;" title="Detail Data" class="btn btn-insoft btn-info"><i class="bi bi-list"></i></button></a>';

                    $button .= '</center>';
                    return $button;
                })

                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    }

    public function exportExcel(Request $request)
    {

        $company = Company::find(1);
        return Excel::download(new ChatHistoryExport($request, $company), 'chat_history_report.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $company = Company::first();

        $data = WhatsappConversation::with('agent');
        if ($request->filter_start_date && $request->filter_end_date) {
            $data->whereBetween('created_at', [
                $request->filter_start_date . ' 00:00:00',
                $request->filter_end_date . ' 23:59:59'
            ]);
        }

        if ($request->filter_customer) {
            $data->where('phone', $request->filter_customer);
        }

        if ($request->filter_branch) {
            $branchId = $request->filter_branch;
            $data->whereHas('agent', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }

        if ($request->filter_consultant) {
            $data->where('assigned_to', $request->filter_consultant);
        }

        if ($request->filter_status) {
            $data->where('status', $request->filter_status);
        }

        $data = $data->get();

        $pdf = Pdf::loadView('crm.reports.chat.pdf', compact('data', 'company'));

        // LANDSCAPE
        $pdf->setPaper('legal', 'landscape');

        return $pdf->stream('chat_history_report.pdf');
    }
}
