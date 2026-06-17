<?php

namespace App\Http\Controllers\CRM;

use App\Exports\VisitReportExport;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Customer;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class VisitReportController extends Controller
{
    public function index()
    {
        $view = 'visit-report';
        $consultants = Auth::user()->branch_id ? User::where('branch_id', Auth::user()->branch_id)->where('position', 'consultant')->get() : User::where('position', 'consultant')->get();

        $branches = Auth::user()->branch_id ? Branch::where('id', Auth::user()->branch_id)->get() : Branch::all();

        $users = Auth::user()->branch_id ? User::where('branch_id', Auth::user()->branch_id)->get() : User::all();
        return view('crm.reports.visit.index', compact('view', 'consultants', 'branches', 'users'));
    }

    public function table(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::whereNotNull('visit_date')->whereNotNull('visit_location');

            if ($request->filter_start_date && $request->filter_end_date) {
                $data->whereBetween(
                    'visit_date',
                    [
                        $request->filter_start_date . ' 00:00:00',
                        $request->filter_end_date . ' 23:59:59'
                    ]
                );
            }


            if (Auth::user()->branch_id) {
                $data->where('branch_id', Auth::user()->branch_id);
            }

            if ($request->filter_consultant) {
                $data->where('consultant_id', $request->filter_consultant);
            }

            if ($request->filter_branch) {
                $data->where('branch_id', $request->filter_branch);
            }

            if ($request->filter_status) {
                $data->where('visit_status', $request->filter_status);
            }

            if ($request->filter_created_by) {
                $data->where('created_by', $request->filter_created_by);
            }


            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return date('d-m-Y H:i:s', strtotime($row->visit_date));
                })
                ->addColumn('customer', function ($row) {
                    return $row->fullname ?? '';
                })

                ->addColumn('consultant', function ($row) {
                    return $row->consultant?->name ?? '';
                })

                ->addColumn('location', function ($row) {
                    return $row->visit_location ?? '';
                })

                ->addColumn('branch', function ($row) {
                    return $row->branch?->branch_name ?? '';
                })

                ->addColumn('status', function ($row) {
                    return $row->visit_status ?? '';
                })

                ->addColumn('note', function ($row) {
                    return '<div style="white-space:normal;width:180px;">' . $row->visit_note . '</div>';
                })

                ->addColumn('created_by', function ($row) {
                    return $row->createdBy?->name ?? '';
                })

                ->addColumn('images', function ($row) {

                    if ($row->visitImages->isEmpty()) {
                        return '-';
                    }

                    $html = '
                        <div style="
                            display:grid;
                            grid-template-columns:repeat(2, 1fr);
                            gap:5px;
                            max-width:160px;
                        ">';

                    foreach ($row->visitImages as $image) {
                        $html .= '
                            <a href="' . asset('storage/' . $image->image) . '" target="_blank">
                                <img
                                    src="' . asset('storage/' . $image->image) . '"
                                    style="
                                        width:100%;
                                        height:50px;
                                        object-fit:cover;
                                        border:1px solid #ddd;
                                        border-radius:4px;
                                    "
                                >
                            </a>
                        ';
                    }

                    $html .= '</div>';

                    return $html;
                })
                ->rawColumns(['images'])


                ->rawColumns(['note', 'images'])
                ->make(true);
        }
    }

    public function exportExcel(Request $request)
    {
        $company = Company::find(1);
        return Excel::download(new VisitReportExport($request, $company), 'visit_report.xlsx');
    }


    public function exportPdf(Request $request)
    {
        $company = Company::first();

        $data = Customer::with([
            'consultant',
            'branch',
            'createdBy',
            'visitImages'
        ])
            ->whereNotNull('visit_date')
            ->whereNotNull('visit_location');

        if ($request->filter_start_date && $request->filter_end_date) {
            $data->whereBetween('visit_date', [
                $request->filter_start_date . ' 00:00:00',
                $request->filter_end_date . ' 23:59:59'
            ]);
        }

        if (Auth::user()->branch_id) {
            $data->where('branch_id', Auth::user()->branch_id);
        }

        if ($request->filter_consultant) {
            $data->where('consultant_id', $request->filter_consultant);
        }

        if ($request->filter_branch) {
            $data->where('branch_id', $request->filter_branch);
        }

        if ($request->filter_status) {
            $data->where('visit_status', $request->filter_status);
        }

        if ($request->filter_created_by) {
            $data->where('created_by', $request->filter_created_by);
        }

        $customers = $data->get();

        $pdf = Pdf::loadView(
            'crm.reports.visit.pdf',
            compact('customers', 'company')
        );

        $pdf->setPaper('legal', 'landscape');

        return $pdf->stream('visit_report.pdf');
    }
}
