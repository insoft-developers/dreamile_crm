<?php

namespace App\Http\Controllers\CRM;

use App\Exports\BroadcastDetailExport;
use App\Http\Controllers\Controller;
use App\Models\BroadcastItem;
use App\Models\Company;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class BroadcastDetailController extends Controller
{
    public function index($id)
    {
        $view = 'broadcast-detail-report';
        return view('crm.reports.broadcast.detail.index', compact('view'));
    }

    public function table(Request $request)
    {

        if ($request->ajax()) {
            $data = BroadcastItem::with('customer');
            $data->where('broadcast_id', $request->filter_id);

            if ($request->filter_status) {
                $data->where('status', $request->filter_status);
            }

            $search = $request->search['value'];

            $data->where(function ($q) use ($search) {
                $q->where('phone', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('error', 'like', "%{$search}%");
            });

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('broadcast_name', function ($row) {
                    return $row->broadcasts?->name ?? '';
                })
                ->addColumn('contact_name', function ($row) {
                    return $row->customer?->fullname;
                })
                ->addColumn('phone', function ($row) {
                    return $row->phone;
                })
                ->addColumn('status', function ($row) {
                    return $row->status;
                })
                ->addColumn('note', function ($row) {
                    return '<div style="white-space:normal;width:180px;">' . $row->error . '</div>';
                })
                ->addColumn('created_at', function ($row) {
                    return date('d-m-Y', strtotime($row->created_at));
                })
                ->filter(function ($query) use ($request) {

                    if (!empty($request->search['value'])) {

                        $search = $request->search['value'];

                        $query->where(function ($q) use ($search) {
                            $q->where('phone', 'like', "%{$search}%")
                                ->orWhere('status', 'like', "%{$search}%")
                                ->orWhere('error', 'like', "%{$search}%");
                        });
                    }
                })


                ->rawColumns(['note'])
                ->make(true);
        }
    }

    public function exportExcel(Request $request)
    {
        $company = Company::find(1);
        return Excel::download(new BroadcastDetailExport($request, $company), 'broadcast_detail_report.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $company = Company::first();

        $data = BroadcastItem::with('customer');
        $data->where('broadcast_id', $request->filter_id);

        if ($request->filter_status) {
            $data->where('status', $request->filter_status);
        }

        $data = $data->get();

        $pdf = Pdf::loadView('crm.reports.broadcast.detail.pdf', compact('data', 'company'));

        // LANDSCAPE
        $pdf->setPaper('legal', 'landscape');

        return $pdf->stream('broadcast_detail_report.pdf');
    }
}
