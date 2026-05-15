<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TemplateController extends Controller
{
    
    public function table(Request $request)
    {
        if ($request->ajax()) {
            $data = Template::query();
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('created_at', function ($row) {
                    return date('d-m-Y H:i', strtotime($row->updated_at));
                })

                ->addColumn('status', function($row){
                    return $row->status == 'active' ? '<span class="badge bg-success rounded-pill">Active</span>': '<span class="badge bg-danger rounded-pill">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $button = '';
                    $button .= '<center>';

                    $button .= '<button onclick="editData('.$row->id.')" title="Edit Data" class="me-0 btn btn-insoft btn-warning"><i class="bi bi-pencil-square"></i></button>';
                    $button .= '<button onclick="deleteData('.$row->id.')" style="margin-left:3px;" title="Delete Data" class="btn btn-insoft btn-danger"><i class="bi bi-trash3"></i></button>';

                    $button .= '</center>';
                    return $button;
                })
                ->rawColumns(['action','status'])
                ->make(true);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $view = 'template';
       return view('crm.template.index', compact('view'));
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
            'template_name' => 'required',
            'display_name' => 'required',
            'category' => 'required',
            'language' => 'required',
            'total_variable' => 'required',
            'status' => 'required',

        ]);


        Template::create($input);

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
        $template = Template::find($id);
        return $template;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();

        $validated = $request->validate([
            'template_name' => 'required',
            'display_name' => 'required',
            'category' => 'required',
            'language' => 'required',
            'total_variable' => 'required',
            'status' => 'required',

        ]);


        $data = Template::find($id);
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
        return Template::destroy($id);
    }
}
