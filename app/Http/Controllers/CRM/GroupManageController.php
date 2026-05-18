<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\ContactGroup;
use App\Models\ContactGroupItem;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class GroupManageController extends Controller
{
    public function table(Request $request)
    {
        if ($request->ajax()) {
            $data = ContactGroupItem::query();
            if ($request->contact_group_id) {
                $data->where('contact_group_id', $request->contact_group_id);
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('contact_group_id', function ($row) {
                    return $row->group?->group_name ?? '';
                })
                ->addColumn('customer_id', function ($row) {
                    return $row->customer?->fullname ?? '';
                })
                ->addColumn('phone_number', function ($row) {
                    return $row->customer?->phone_number ?? '';
                })
                ->addColumn('action', function ($row) {
                    $button = '';
                    $button .= '<center>';

                   
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
            'contact_group_id' => 'required',
            'customer_id.*' => 'required',
        ]);

        if (count($input['customer_id']) > 0) {
            foreach ($input['customer_id'] as $c) {
                $cek = ContactGroupItem::where('customer_id', $c)->where('contact_group_id', $input['contact_group_id'])->count();

                if ($cek == 0) {
                    ContactGroupItem::create([
                        'contact_group_id' => $input['contact_group_id'],
                        'customer_id' => $c,
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada contact untuk ditambahkan',
            ]);
        }

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
        $view = 'group-manage';
        $contact_group_id = $id;
        $contacts = Customer::whereNotNull('phone_number');
        if (!empty(Auth::user()->branch_id)) {
            $contacts = $contacts->where('branch_id', Auth::user()->branch_id)->get();
        } else {
            $contacts = $contacts->get();
        }
        return view('crm.group.manage.index', compact('view', 'contact_group_id', 'contacts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       
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
        return ContactGroupItem::destroy($id);
    }
}
