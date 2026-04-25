<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function table(Request $request)
    {
        if ($request->ajax()) {
            $data = Company::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('address', function($row){
                    return '<div style="white-space:normal;width:350px;">'.$row->address.'</div';
                })
                ->addColumn('updated_at', function($row){
                    return date('d-m-Y H:i', strtotime($row->updated_at));
                })
                ->addColumn('action', function ($row) {
                    $button = '';
                    $button .= '<center>';

                    $button .= '<button onclick="editData('.$row->id.')" title="Edit Data" class="me-0 btn btn-insoft btn-warning"><i class="bi bi-pencil-square"></i></button>';
                    // $button .= '<button title="Hapus Data" class="btn btn-insoft btn-danger"><i class="bi bi-trash3"></i></button>';

                    $button .= '</center>';
                    return $button;
                })
                ->rawColumns(['action','address'])
                ->make(true);
        }
    }

    public function index()
    {
        $view = 'company';
        return view('crm.settings.company.index', compact('view'));
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
        $company = Company::find($id);
        return $company;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();
        $validated = $request->validate([
            'company_name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
            'pic' => 'required',
        ]);

        $data = Company::find($id);
        $input['updated_at'] = Carbon::now();
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
