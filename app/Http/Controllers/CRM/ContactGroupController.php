<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\ContactGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ContactGroupController extends Controller
{
    

    public function table(Request $request)
    {
        if ($request->ajax()) {
            $data = ContactGroup::query();
            if(! empty(Auth::user()->branch_id)) {
                $data->where('branch_id', Auth::user()->branch_id);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('group_name', function($row){
                    return $row->group_name.'<br>('.$row->items->count().' contacts)';
                })
                ->addColumn('created_at', function ($row) {
                    return date('d-m-Y H:i', strtotime($row->updated_at));
                })

                ->addColumn('branch_id', function($row){
                    return $row->branch?->branch_name ?? '';
                })
                ->addColumn('description', function($row){
                    return '<div style="white-space:normal;width:300px;">'.$row->description.'</div>';
                })
                ->addColumn('action', function ($row) {
                    $button = '';
                    $button .= '<center>';

                    $button .= '<a href="'.url('/group_manage/'.$row->id).'"><button title="Manage Data" class="me-0 btn btn-insoft btn-primary"><i class="bi bi-gear"></i></button></a>';
                    $button .= '<button style="margin-left:3px;" onclick="broadcastData('.$row->id.')" title="Broadcast" class="me-0 btn btn-insoft btn-success"><i class="ri-whatsapp-line"></i></button>';
                    $button .= '<button onclick="editData('.$row->id.')" style="margin-left:3px;" title="Edit Data" class="btn btn-insoft btn-warning"><i class="bi bi-pencil-square"></i></button>';

                    $button .= '</center>';
                    return $button;
                })
                ->rawColumns(['action','description','group_name'])
                ->make(true);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $view = 'group';
        $user = User::find(Auth::user()->id);
        $branches = empty($user->branch_id) ? Branch::all() : Branch::where('id', $user->branch_id)->get();
        return view('crm.group.index', compact('view', 'branches'));
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
            'group_name' => 'required|string|max:100',
            'description' => 'nullable',
            'branch_id' => 'required'
        ]);


        ContactGroup::create($input);

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
        $data = ContactGroup::find($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();

        $validated = $request->validate([
            'group_name' => 'required|string|max:100',
            'description' => 'nullable',
            'branch_id' => 'required'
        ]);


        $data = ContactGroup::find($id);
        $data->update($input);

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
        //
    }
}
