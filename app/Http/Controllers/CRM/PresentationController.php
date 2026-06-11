<?php

namespace App\Http\Controllers\CRM;

use App\Exports\PresentationExport;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Event;
use App\Models\Level;
use App\Models\Position;
use App\Models\Presentation;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PresentationController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function table(Request $request)
    {
        if ($request->ajax()) {
            $data = Presentation::query();
            if(! empty(Auth::user()->branch_id)) {
                $data->where('branch_id', Auth::user()->branch_id);
            }

            if ($request->filter_start_date && $request->filter_end_date) {
                $data->whereBetween('date', [$request->filter_start_date, $request->filter_end_date]);
            }

            if ($request->filter_consultant) {
                $data->where('consultant_id', $request->filter_consultant);
            }

            if ($request->filter_branch) {
                $data->where('branch_id', $request->filter_branch);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('deal', function($row){
                    return $row->deals->count();
                })
                ->addColumn('lead', function($row){
                    return $row->leads->count();
                })
                ->addColumn('consultant_id', function($row){
                    return $row->consultant?->name ?? '';
                })
                ->addColumn('branch_id', function($row){
                    return $row->branch?->branch_name ?? '';
                })
                ->addColumn('userid', function($row){
                    return $row->createdBy?->name ?? '';
                })
                ->addColumn('image', function ($row) {
                    if (!empty($row->image)) {
                        return '<a href="'.asset('/storage/'.$row->image).'" target="_blank"><img class="user-image" src="'.asset('/storage/'.$row->image).'"></a>';
                    } else {
                        return '<center> -</center>';
                    }
                })
                ->addColumn('created_at', function ($row) {
                    return date('d-m-Y H:i', strtotime($row->created_at));
                })
                ->addColumn('date', function ($row) {
                    return date('d-m-Y', strtotime($row->date));
                })
                ->addColumn('location', function ($row) {
                    return '<div style="white-space:normal;width:180px;">'.$row->location.'</div>';
                })
                ->addColumn('description', function ($row) {
                    return '<div style="white-space:normal;width:180px;">'.$row->description.'</div>';
                })

                ->addColumn('action', function ($row) {
                    $button = '';
                    $button .= '<center>';

                    $button .= '<button style="margin-left:3px;" onclick="editData('.$row->id.')" title="Edit Data" class="me-0 btn btn-insoft btn-warning"><i class="bi bi-pencil-square"></i></button>';
                    $button .= '<button onclick="deleteData('.$row->id.')" style="margin-left:3px;" title="Delete Data" class="btn btn-insoft btn-danger"><i class="bi bi-trash3"></i></button>';

                    $button .= '</center>';
                    return $button;
                })
                ->rawColumns(['action','image','location', 'description'])
                ->make(true);
        }
    }


    public function index()
    {
        $view = 'presentation';
        $consultantsQuery = User::where('is_active', 1)->where('position', 'consultant');
        if(! empty(Auth::user()->branch_id)) {
            $consultantsQuery->where('branch_id', Auth::user()->branch_id);
        }
        
        $consultants = $consultantsQuery->get();


        $branchesQuery = Branch::query();
        if(! empty(Auth::user()->branch_id)) {
            $branchesQuery->where('id', Auth::user()->branch_id);
        }

        $branches = $branchesQuery->get();
        return view('crm.presentation.index', compact('view', 'consultants', 'branches'));
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
            'title' => 'required|string|max:150',
            'location' => 'required',
            'date' => 'required',
            'consultant_id' => 'required',
            'audience' =>'nullable',
            'tertarik' => 'nullable',
            'sangat_tertarik'=> 'nullable',
            'kurang_tertarik' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ]);

        $path = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('presentations', 'public');
        }

        $input['image'] = $path;
        $input['userid'] = Auth::user()->id;
        Presentation::create($input);


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
        $data = Presentation::find($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();
        $data = Presentation::find($id);
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'location' => 'required',
            'date' => 'required',
            'consultant_id' => 'required',
            'audience' =>'nullable',
            'tertarik' => 'nullable',
            'sangat_tertarik'=> 'nullable',
            'kurang_tertarik' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ]);

        $path = $data->image;

        if ($request->hasFile('image')) {

            // hapus foto lama (kalau ada)
            if ($data->image && Storage::disk('public')->exists($data->image)) {
                Storage::disk('public')->delete($data->image);
            }

            // upload foto baru
            $path = $request->file('image')->store('presentations', 'public');
        }

        $input['image'] = $path;
        $input['userid'] = Auth::user()->id;
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
        $data = Presentation::find($id);


        if ($data->image && Storage::disk('public')->exists($data->image)) {
            Storage::disk('public')->delete($data->image);
        }

        // hapus data user
        $data->delete();
    }


   public function exportExcel(Request $request)
    {
        $company = Company::find(1);
        return Excel::download(new PresentationExport($request, $company), 'presentation_data_report.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $company = Company::first();

        $data = Presentation::query()->with(['consultant', 'branch', 'createdBy']);
            

        if ($request->filter_start_date && $request->filter_end_date) {
            $data->whereBetween('date', [$request->filter_start_date, $request->filter_end_date]);
        }

        if ($request->filter_consultant) {
            $data->where('consultant_id', $request->filter_consultant);
        }

        if ($request->filter_branch) {
            $data->where('branch_id', $request->filter_branch);
        }

        $customers = $data->orderBy('id', 'desc')->get();

        $pdf = Pdf::loadView('crm.presentation.pdf', compact('customers', 'company'));

        // LANDSCAPE
        $pdf->setPaper('legal', 'landscape');

        return $pdf->stream('presentation_report.pdf');
    }


}
