<?php

namespace App\Http\Controllers\CRM;

use App\Exports\LeadExport;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Event;
use App\Models\LeadSource;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function table(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::query();
            $data->where('is_customer', 1);
            // 🔥 FILTER TANGGAL
            if ($request->start_date && $request->end_date) {
                $data->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
            }

            // 🔥 FILTER STATUS
            if ($request->filter_status) {
                $data->where('status', $request->filter_status);
            }

            // 🔥 FILTER LEAD SOURCE
            if ($request->filter_lead_source) {
                $data->where('lead_source_id', $request->filter_lead_source);
            }

            // 🔥 FILTER CONSULTANT
            if ($request->filter_consultant) {
                $data->where('consultant_id', $request->filter_consultant);
            }

            // 🔥 FILTER BRANCH
            if ($request->filter_branch) {
                $data->where('branch_id', $request->filter_branch);
            }

            if (!empty(Auth::user()->branch_id)) {
                $data->where('branch_id', Auth::user()->branch_id);
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('lead_source_id', function ($row) {
                    if ($row->lead_source_id == 'facebook') {
                        return '<span style="color:blue;font-weight:bold;">Facebook</span>';
                    } elseif ($row->lead_source_id == 'tik-tok') {
                        return '<span style="color:red;font-weight:bold;">TikTok</span>';
                    } elseif ($row->lead_source_id == 'instagram') {
                        return '<span style="color:black;font-weight:bold;">Instagram</span>';
                    } elseif ($row->lead_source_id == 'google') {
                        return '<span style="color:orange;font-weight:bold;">Google</span>';
                    } elseif ($row->lead_source_id == 'event') {
                        return '<span style="color:green;font-weight:bold;">Event</span>';
                    } elseif ($row->lead_source_id == 'presentation') {
                        return '<span style="color:purple;font-weight:bold;">Presentation</span>';
                    } else {
                        return '<span style="color:green;font-weight:bold;">' . $row->lead_source_id . '</span>';
                    }
                })
                ->addColumn('photo', function ($row) {
                    if (!empty($row->photo)) {
                        return '<img class="lead-image" src="' . asset('/storage/' . $row->photo) . '">';
                    } else {
                        return '<center> -</center>';
                    }
                })
                ->addColumn('created_at', function ($row) {
                    return date('d-m-Y H:i', strtotime($row->created_at));
                })
                ->addColumn('school_from', function ($row) {
                    return '<div style="white-space:normal;width:120px;">' . $row->school_from . '</div>';
                })
                ->addColumn('status', function ($row) {
                    $status = null;
                    if ($row->status === 'new-lead') {
                        $status = '<span class="badge rounded-pill bg-success">New</span>';
                    } elseif ($row->status === 'visit') {
                        if ($row->visit_status === 'scheduled') {
                            $status = '<span title="Visit Scheduled" class="badge rounded-pill bg-warning">Visit <i class="ri-calendar-line
"></i></span>';
                        } elseif ($row->visit_status === 'done') {
                            $status = '<span title="visit done" class="badge rounded-pill bg-warning">Visit <i class="ri-check-line
"></i></span>';
                        } else {
                            $status = '<span title="visit not settled" class="badge rounded-pill bg-warning">Visit</span>';
                        }
                    } elseif ($row->status === 'deal') {
                        $status = '<span class="badge rounded-pill bg-info">Deal <i class="ri-check-line
"></i><i class="ri-check-line
"></i></span>';
                    } elseif ($row->status === 'nok') {
                        $status = '<span class="badge rounded-pill bg-danger">NOK</span>';
                    } elseif ($row->status === 'confirm') {
                        $followup = $row->followup->count();

                        $status = '<span class="badge rounded-pill bg-primary">Confirm (' . $followup . ')</span>';
                    }
                    return $status;
                })
                ->addColumn('consultant_id', function ($row) {
                    return $row->consultant?->name ?? '';
                })
                ->addColumn('branch_id', function ($row) {
                    return $row->branch?->branch_name ?? '';
                })
                ->addColumn('class', function ($row) {
                    return $row->class . '/' . $row->major;
                })
                ->addColumn('created_by', function ($row) {
                    return $row->createdBy?->name ?? '';
                })
                ->addColumn('action', function ($row) {
                    $button = '';
                    $button .= '<center>';
                    $button .= '<a href="' . url('/chat/' . $row->id) . '"><button title="Open Chat" class="me-0 btn btn-insoft btn-success"><i class="bi bi-whatsapp"></i></button></a>';

                    $button .= '<button onclick="convert(' . $row->id . ')" style="margin-left:3px;" title="Downgrade to Lead" class="me-0 btn btn-insoft btn-light"><i class="bi bi-arrow-repeat"></i></button>';

                    $button .= '<a href="' . url('/customer/' . $row->id) . '"><button style="margin-left:3px;" title="Detail Data" class="me-0 btn btn-insoft btn-info"><i class="bi bi-file-earmark-post"></i></button></a>';

                    $button .= '<button style="margin-left:3px;" onclick="editData(' . $row->id . ')" title="Edit Data" class="me-0 btn btn-insoft btn-warning"><i class="bi bi-pencil-square"></i></button>';
                    if (Auth::user()->position == 'supervisor') {
                        $button .= '<button onclick="deleteData(' . $row->id . ')" style="margin-left:3px;" title="Delete Data" class="btn btn-insoft btn-danger"><i class="bi bi-trash3"></i></button>';
                    } else {
                        $button .= '<button disabled style="margin-left:3px;" title="Delete Data" class="btn btn-insoft btn-danger"><i class="bi bi-trash3"></i></button>';
                    }

                    $button .= '</center>';
                    return $button;
                })
                ->rawColumns(['action', 'photo', 'school_from', 'status', 'lead_source_id'])
                ->make(true);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $view = 'customer';
        $sources = LeadSource::all();
        $consultants = User::where('position', 'consultant')->get();
        $user = User::find(Auth::user()->id);
        $branches = null;
        if ($user->branch_id === null) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }
        return view('crm.customers.customer.index', compact('view', 'sources', 'consultants', 'branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validated = $request->validate([
            'fullname' => 'required|string|max:150',
            'full_address' => 'required',
            'school_from' => 'required',
            'class' => 'required',
            'major' => 'required',
            'phone_number' => 'required|regex:/^62[0-9]{9,11}$/|unique:customers,phone_number',
            'gender' => 'required',
            'email' => 'nullable|unique:customers,email',
            'lead_source_id' => 'required',
            'status' => 'required',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'event_id' => 'required_if:lead_source,event',
            'branch_id' => 'required',
        ]);

        $path = null;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('leads', 'public');
        }

        $input['province_name'] = $request->province_code == null ? '' : $request->province_name;
        $input['regency_name'] = $request->regency_code == null ? '' : $request->regency_name;
        $input['district_name'] = $request->district_code == null ? '' : $request->district_name;
        $input['village_name'] = $request->village_code == null ? '' : $request->village_name;

        $input['created_by'] = Auth::user()->id;
        $input['photo'] = $path;
        $input['is_customer'] = 1;
        Customer::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan.',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $view = 'customer-detail';
        $data = Customer::find($id);
        return view('crm.customers.customer.detail', compact('view', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Customer::find($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();
        $customer = Customer::find($id);
        $validated = $request->validate([
            'fullname' => 'required|string|max:150',
            'full_address' => 'required',
            'school_from' => 'required',
            'class' => 'required',
            'major' => 'required',
            'phone_number' => 'required|regex:/^62[0-9]{9,11}$/|' . Rule::unique('customers')->ignore($customer->id),
            'gender' => 'required',
            'email' => 'nullable|' . Rule::unique('customers')->ignore($customer->id),
            'lead_source_id' => 'required',
            'status' => 'required',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'event_id' => 'required_if:lead_source_id,event',
            'branch_id' => 'required',
        ]);

        $path = $customer->photo;

        if ($request->hasFile('photo')) {
            // hapus foto lama (kalau ada)
            if ($customer->photo && Storage::disk('public')->exists($customer->photo)) {
                Storage::disk('public')->delete($customer->photo);
            }

            // upload foto baru
            $path = $request->file('photo')->store('leads', 'public');
        }

        $input['photo'] = $path;
        $input['created_by'] = Auth::user()->id;

        $input['district_code'] = $customer->district_code;
        $input['village_code'] = $customer->village_code;
        $input['district_name'] = $customer->district_name;
        $input['village_name'] = $customer->village_name;

        if (!empty($request->district_code)) {
            $input['district_code'] = $request->district_code;
        }
        if (!empty($request->village_code)) {
            $input['village_code'] = $request->village_code;
        }

        if (!empty($request->district_name)) {
            $input['district_name'] = $request->district_name;
        }

        if (!empty($request->village_name)) {
            $input['village_name'] = $request->village_name;
        }

        $customer->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::find($id);

        if ($customer->photo && Storage::disk('public')->exists($customer->photo)) {
            Storage::disk('public')->delete($customer->photo);
        }

        // hapus data user
        $customer->delete();
    }

    public function event()
    {
        $events = Event::all();
        return response()->json($events);
    }

    public function exportExcel(Request $request)
    {
        $company = Company::find(1);
        return Excel::download(new LeadExport($request, $company, 'customer'), 'Customer_data_report.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $company = Company::first();

        $data = Customer::query()
            ->with(['leadsource', 'consultant', 'branch', 'createdBy'])
            ->where('is_customer', 1);

        // FILTER TANGGAL
        if ($request->start_date && $request->end_date) {
            $data->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        // FILTER STATUS
        if ($request->filter_status) {
            $data->where('status', $request->filter_status);
        }

        // FILTER LEAD SOURCE
        if ($request->filter_lead_source) {
            $data->where('lead_source_id', $request->filter_lead_source);
        }

        // FILTER CONSULTANT
        if ($request->filter_consultant) {
            $data->where('consultant_id', $request->filter_consultant);
        }

        // FILTER BRANCH
        if ($request->filter_branch) {
            $data->where('branch_id', $request->filter_branch);
        }

        $customers = $data->orderBy('id', 'desc')->get();

        $pdf = Pdf::loadView('crm.customers.customer.pdf', compact('customers', 'company'));

        // LANDSCAPE
        $pdf->setPaper('legal', 'landscape');

        return $pdf->stream('Customer_Report.pdf');
    }

    public function downgrade(Request $request)
    {
        $input = $request->all();

        $data = Customer::find($input['id']);
        $data->is_customer = null;
        $data->updated_at = Carbon::now();
        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Success',
        ]);
    }
}
