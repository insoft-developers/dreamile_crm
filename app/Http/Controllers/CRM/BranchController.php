<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function table(Request $request)
    {
        if ($request->ajax()) {
            $data = Branch::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('address', function($row){
                    return '<div style="white-space:normal;width:300px;">'.$row->address.'</div';
                })
                ->addColumn('updated_at', function($row){
                    return date('d-m-Y H:i', strtotime($row->updated_at));
                })
                ->addColumn('action', function ($row) {
                    $button = '';
                    $button .= '<center>';

                    $button .= '<button onclick="editData('.$row->id.')" title="Edit Data" class="me-0 btn btn-insoft btn-warning"><i class="bi bi-pencil-square"></i></button>';
                    $button .= '<button onclick="deleteData('.$row->id.')" style="margin-left:3px;" title="Delete Data" class="btn btn-insoft btn-danger"><i class="bi bi-trash3"></i></button>';

                    $button .= '</center>';
                    return $button;
                })
                ->rawColumns(['action','address'])
                ->make(true);
        }
    }


    public function index()
    {
        $view = 'branch';
        return view('crm.settings.branch.index', compact('view'));
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
            'branch_name' => 'required|string|max:100',
            'address' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|string|max:20',
            'pic' => 'required',
        ]);
        

        Branch::create($input);

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
        $data = Branch::find($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();

        $validated = $request->validate([
            'branch_name' => 'required|string|max:100',
            'address' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|string|max:20',
            'pic' => 'required',
        ]);
        
        $data = Branch::find($id);
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
        return Branch::destroy($id);
    }
}
