<?php

namespace App\Http\Controllers\CRM;

use App\Exports\FollowupReportExport;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Followup;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class FollowupReportController extends Controller
{
    public function index()
    {
        $view = 'followup-report';
        $branches = Auth::user()->branch_id ? Branch::where('id', Auth::user()->branch_id)->get() : Branch::all();

        $consultants = Auth::user()->branch_id ? User::where('branch_id', Auth::user()->branch_id)->where('position', 'consultant')->get() : User::where('position', 'consultant')->get();

        $users = Auth::user()->branch_id ? User::where('branch_id', Auth::user()->branch_id)->get() : User::all();

        return view('crm.reports.followup.index', compact('view', 'branches', 'consultants', 'users'));
    }


    public function table(Request $request)
    {
        if ($request->ajax()) {
            $data = Followup::query();

            if ($request->filter_start_date && $request->filter_end_date) {
                $data->whereBetween(
                    'date',
                    [
                        $request->filter_start_date . ' 00:00:00',
                        $request->filter_end_date . ' 23:59:59'
                    ]
                );
            }

            if ($request->filter_consultant) {
                $data->whereHas('customer', function ($query) use ($request) {
                    $query->where('consultant_id', $request->filter_consultant);
                });
            }

            if ($request->filter_branch) {
                $data->whereHas('customer', function ($query) use ($request) {
                    $query->where('branch_id', $request->filter_branch);
                });
            }

            if ($request->filter_created_by) {
                $data->whereHas('customer', function ($query) use ($request) {
                    $query->where('created_by', $request->filter_created_by);
                });
            }


            $data->orderBy('date', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('created_at', function ($row) {
                    return date('d-m-Y H:i', strtotime($row->date));
                })

                ->addColumn('customer', function ($row) {
                    return $row->customer?->fullname ?? $row->customer?->phone_number;
                })
                ->addColumn('consultant', function ($row) {
                    return $row->customer?->consultant?->name ?? '';
                })

                ->addColumn('step', function ($row) {
                    return 'followup ke -' . $row->step;
                })

                ->addColumn('branch', function ($row) {
                    return $row->customer?->branch?->branch_name ?? '';
                })

                ->addColumn('note', function ($row) {
                    return '<div style="white-space:normal;width:180px;">' . $row->note . '</div>';
                })

                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        return '<a href="' . asset('storage/' . $row->image) . '" target="_blank"><img class="chat-image" src="' . asset('/storage/' . $row->image) . '"></a>';
                    }
                    return;
                })

                ->addColumn('created_by', function ($row) {
                    return $row->customer?->createdBy?->name ?? '';
                })

                ->filter(function ($query) use ($request) {

                    if (!empty($request->search['value'])) {

                        $search = $request->search['value'];

                        $query->where(function ($q) use ($search) {
                            $q->whereHas('customer', function ($c) use ($search) {
                                $c->where('fullname', 'like', "%{$search}%");
                                $c->orWhereHas('consultant', function ($b) use ($search) {
                                    $b->where('name', 'like', "%{$search}%");
                                });
                            })
                                ->orWhere('note', 'like', "%{$search}%")
                            ;


                            // $q->whereHas('customer', 'like', "%{$search}%")
                            // ->orWhere('status', 'like', "%{$search}%")
                            // ->orWhere('error', 'like', "%{$search}%");
                        });
                    }
                })


                ->rawColumns(['note', 'image'])
                ->make(true);
        }
    }

    public function exportExcel(Request $request)
    {
        $company = Company::find(1);
        return Excel::download(new FollowupReportExport($request, $company), 'followup_report.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $company = Company::first();

        $data = Followup::with(['customer.consultant',
        'customer.branch',
        'customer.createdBy']);

        if ($request->filter_start_date && $request->filter_end_date) {
            $data->whereBetween(
                'date',
                [
                    $request->filter_start_date . ' 00:00:00',
                    $request->filter_end_date . ' 23:59:59'
                ]
            );
        }

        if ($request->filter_consultant) {
            $data->whereHas('customer', function ($query) use ($request) {
                $query->where('consultant_id', $request->filter_consultant);
            });
        }

        if ($request->filter_branch) {
            $data->whereHas('customer', function ($query) use ($request) {
                $query->where('branch_id', $request->filter_branch);
            });
        }

        if ($request->filter_created_by) {
            $data->whereHas('customer', function ($query) use ($request) {
                $query->where('created_by', $request->filter_created_by);
            });
        }


        $data->orderBy('date', 'desc');
        $data = $data->get();

        $pdf = Pdf::loadView('crm.reports.followup.pdf', compact('data', 'company'));

        // LANDSCAPE
        $pdf->setPaper('legal', 'landscape');

        return $pdf->stream('followup_report.pdf');
    }
}
