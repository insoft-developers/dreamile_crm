<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Event;
use App\Models\LeadSource;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function table(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('photo', function ($row) {
                    if (!empty($row->photo)) {
                        return '<img class="lead-image" src="'.asset('/storage/'.$row->photo).'">';
                    } else {
                        return '<center> -</center>';
                    }
                })
                ->addColumn('created_at', function ($row) {
                    return date('d-m-Y H:i', strtotime($row->created_at));
                })
                ->addColumn('school_from', function($row){
                    return '<div style="white-space:normal;width:120px;">'.$row->school_from.'</div>';
                })
                ->addColumn('status', function($row){
                    $status = null;
                    if($row->status === 'new-lead') {
                        $status = '<span class="badge rounded-pill bg-success">New</span>';
                    }
                    else if($row->status === 'visit') {
                        $status = '<span class="badge rounded-pill bg-warning">Visit</span>';
                    }
                    else if($row->status === 'deal') {
                        $status = '<span class="badge rounded-pill bg-info">Deal</span>';
                    }
                    else if($row->status === 'nok') {
                        $status = '<span class="badge rounded-pill bg-danger">NOK</span>';
                    }
                    else if($row->status === 'confirm') {
                        $status = '<span class="badge rounded-pill bg-primary">Confirm</span>';
                    }
                    return $status;
                })
                ->addColumn('consultant_id', function($row){
                    return $row->consultant?->name ?? '';
                })
                 ->addColumn('branch_id', function($row){
                    return $row->branch?->branch_name ?? '';
                })
                ->addColumn('class', function($row){
                    return $row->class.'/'.$row->major;
                })
                ->addColumn('created_by', function($row){
                    return $row->createdBy?->name ?? '';
                })
                ->addColumn('action', function ($row) {
                    $button = '';
                    $button .= '<center>';
                   
                    $button .= '<button style="margin-left:3px;" onclick="editData('.$row->id.')" title="Edit Data" class="me-0 btn btn-insoft btn-warning"><i class="bi bi-pencil-square"></i></button>';
                    $button .= '<button onclick="deleteData('.$row->id.')" style="margin-left:3px;" title="Delete Data" class="btn btn-insoft btn-danger"><i class="bi bi-trash3"></i></button>';

                    $button .= '</center>';
                    return $button;
                })
                ->rawColumns(['action','photo','school_from','status'])
                ->make(true);
        }
    }


    public function index()
    {
        $view = 'lead';
        $sources = LeadSource::all();
        $consultants = User::where('position', 'consultant')->get();
        $user = User::find(Auth::user()->id);
        $branches = null;
        if($user->branch_id === null) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }
        return view('crm.customers.lead.index', compact('view','sources','consultants','branches'));
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
            'branch_id' => 'required'


        ]);

        $path = null;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('leads', 'public');
        }

        $input['created_by'] = Auth::user()->id;
        $input['photo'] = $path;
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
        //
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
        $user = User::find($id);
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|'.Rule::unique('users')->ignore($user->id),
            'branch_id' => 'nullable',
            'level' => 'required',
            'position' => 'required',
            'password' => 'nullable|string|min:6',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ]);

        $path = $user->photo;

        if ($request->hasFile('photo')) {

            // hapus foto lama (kalau ada)
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            // upload foto baru
            $path = $request->file('photo')->store('users', 'public');
        }


        if (!empty($request->password)) {
            $input['password'] = bcrypt($request->password);
        } else {
            $input['password'] = $user->password;
        }

        $input['photo'] = $path;
        $user->update($input);

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
        $user = User::find($id);


        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        // hapus data user
        $user->delete();
    }

    public function event() {
        $events = Event::all();
        return response()->json($events);
    }
}
