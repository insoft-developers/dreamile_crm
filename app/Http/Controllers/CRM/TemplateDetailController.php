<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\TemplateDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TemplateDetailController extends Controller
{
    
    public function table(Request $request)
    {
        if ($request->ajax()) {
            $data = TemplateDetail::query();
            if ($request->template_id) {
                $data->where('template_id', $request->template_id);
            }
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('created_at', function ($row) {
                    return date('d-m-Y H:i', strtotime($row->updated_at));
                })
                ->addColumn('template_id', function($row){
                    return $row->template?->display_name ?? '';
                })
                ->addColumn('field_value', function($row){
                    return '<div style="white-space:normal;width:200px;">'.$row->field_value.'</div>';
                })        
                ->addColumn('action', function ($row) {
                    $button = '';
                    $button .= '<center>';

                    $button .= '<button style="margin-left:3px;" onclick="editData('.$row->id.')" title="Edit Data" class="me-0 btn btn-insoft btn-warning"><i class="bi bi-pencil-square"></i></button>';
                    $button .= '<button onclick="deleteData('.$row->id.')" style="margin-left:3px;" title="Delete Data" class="btn btn-insoft btn-danger"><i class="bi bi-trash3"></i></button>';

                    $button .= '</center>';
                    return $button;
                })
                ->rawColumns(['action','field_value'])
                ->make(true);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'content_type' => 'required',
            'field_type' => 'required',
            'field_value' => 'required',
        ]);

        $chek = TemplateDetail::where('template_id', $input['template_id'])->where('content_type', 'header')->count();

        if($chek > 0 && $input['content_type'] == 'header') {
            return response()->json([
                "success" => false,
                "message" => "There's only one variable allowed in header!" 
            ]);
        }

        if($input['content_type'] == 'body' && $input['field_type'] == 'image') {
            return response()->json([
                "success" => false,
                "message" => "Image can only be used in header!" 
            ]);
        }
 
        TemplateDetail::create($input);

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
        $data = TemplateDetail::find($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();

        $validated = $request->validate([
            'content_type' => 'required',
            'field_type' => 'required',
            'field_value' => 'required',
        ]);

         if($input['content_type'] == 'body' && $input['field_type'] == 'image') {
            return response()->json([
                "success" => false,
                "message" => "Image can only be used in header!" 
            ]);
        }

        $data = TemplateDetail::find($id);
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
        return TemplateDetail::destroy($id);
    }
}
