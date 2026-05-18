<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Broadcast;
use App\Models\ContactGroup;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class BroadcastController extends Controller
{
    public function table(Request $request)
    {
        if ($request->ajax()) {
            $data = Broadcast::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('recipients', function ($row) {
                    return '';
                })
                ->addColumn('created_at', function ($row) {
                    return date('d-m-Y H:i', strtotime($row->updated_at));
                })
                ->addColumn('action', function ($row) {
                    $button = '';
                    $button .= '<center>';

                    $button .= '<button onclick="editData(' . $row->id . ')" title="Edit Data" class="me-0 btn btn-insoft btn-warning"><i class="bi bi-pencil-square"></i></button>';
                    $button .= '<button onclick="deleteData(' . $row->id . ')" style="margin-left:3px;" title="Delete Data" class="btn btn-insoft btn-danger"><i class="bi bi-trash3"></i></button>';

                    $button .= '</center>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $view = 'broadcast';

        $dataContact = null;
        $dataGroup = null;
        if (empty(Auth::user()->branch_id)) {
            $dataContact = Customer::whereNotNull('phone_number')->get();
        } else {
            $dataContact = Customer::whereNotNull('phone_number')
                ->where('branch_id', Auth::user()->branch_id)
                ->get();
        }

        if (empty(Auth::user()->branch_id)) {
            $dataGroup = ContactGroup::all();
        } else {
            $dataGroup = ContactGroup::where('branch_id', Auth::user()->branch_id)->get();
        }

        return view('crm.broadcast.index', compact('view','dataContact','dataGroup'));
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
        dd($input);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
