<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Jobs\SendWhatsappBroadcastJob;
use App\Models\Broadcast;
use App\Models\BroadcastItem;
use App\Models\ContactGroup;
use App\Models\ContactGroupItem;
use App\Models\Customer;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class BroadcastController extends Controller
{
    public function table(Request $request)
    {
        if ($request->ajax()) {
            $data = Broadcast::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('progress', function ($row) {
                    $percent = 0;

                    if ($row->total > 0) {
                        $percent = round(($row->sent / $row->total) * 100);
                    }

                    return '
                        <div>
                            <div class="d-flex justify-content-between mb-1">
                                <small class="fw-semibold">
                                    ' .
                        $row->sent .
                        ' / ' .
                        $row->total .
                        '
                                </small>
                                <small class="text-muted">
                                    ' .
                        $percent .
                        '%
                                </small>
                            </div>
                            <div class="progress rounded-pill" style="height:8px;">
                                <div
                                    class="progress-bar"
                                    style="width:' .
                        $percent .
                        '%">
                                </div>
                            </div>
                        </div>
                    ';
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 'draft') {
                        return '
                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2">
                        Draft
                    </span>
                ';
                    }

                    if ($row->status == 'processing') {
                        return '
                    <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">
                        Processing
                    </span>
                ';
                    }

                    if ($row->status == 'completed') {
                        return '
                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                        Completed
                    </span>
                ';
                    }

                    return '
                <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                    Failed
                </span>
            ';
                })
                
                ->addColumn('created_at', function ($row) {
                    return date('d-m-Y H:i', strtotime($row->updated_at));
                })
                ->addColumn('action', function ($row) {
                    $button = '';
                    $button .= '<center>';

                    $button .= '<a href="' . url('/broadcast/' . $row->id) . '"><button title="Detail Data" class="me-0 btn btn-insoft btn-primary"><i class="bi bi-eye"></i></button></a>';
                    if ($row->status == 'draft') {
                        $button .= '<button style="margin-left:3px;" onclick="startBroadcast(' . $row->id . ')" title="Start Broadcast" class="me-0 btn btn-insoft btn-success"><i class="bi bi-send-fill"></i></button>';
                    } else {
                        $button .= '<button style="margin-left:3px;" disabled title="Start Broadcast" class="me-0 btn btn-insoft btn-success"><i class="bi bi-send-fill"></i></button>';
                    }
                    if ($row->failed > 0) {
                        $button .= '<button style="margin-left:3px;" onclick="retryBroadcast(' . $row->id . ')" title="Retry Broadcast" class="me-0 btn btn-insoft btn-warning"><i class="bi bi-arrow-repeat"></i></button>';
                    } else {
                        $button .= '<button style="margin-left:3px;" disabled title="Retry Broadcast" class="me-0 btn btn-insoft btn-warning"><i class="bi bi-arrow-repeat"></i></button>';
                    }

                    $button .= '<button onclick="deleteData(' . $row->id . ')" style="margin-left:3px;" title="Delete Data" class="btn btn-insoft btn-danger"><i class="bi bi-trash3"></i></button>';

                    $button .= '</center>';
                    return $button;
                })
                ->rawColumns(['action', 'progress', 'status'])
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

        $templates = Template::where('status','active')->get();

        return view('crm.broadcast.index', compact('view', 'dataContact', 'dataGroup', 'templates'));
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
        DB::beginTransaction();

        try {
            $request->validate([
                'name' => 'required',
                'template_name' => 'required',
                'contact_type' => 'required',
            ]);

            $broadcast = Broadcast::create([
                'name' => $request->name,
                'message' => $request->message,
                'template_name' => $request->template_name,
                'status' => 'draft',
                'total' => 0,
                'sent' => 0,
                'failed' => 0,
                'branch_id' => Auth::user()->branch_id,
                'userid' => Auth::user()->id,
            ]);

            $targets = [];

            if ($request->contact_type == 'contact') {
                $contacts = Customer::whereIn('id', $request->contact_target ?? [])->get();

                foreach ($contacts as $contact) {
                    if (!empty($contact->phone_number)) {
                        $targets[] = [
                            'broadcast_id' => $broadcast->id,
                            'phone' => $contact->phone_number,
                            'status' => 'pending',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
            }

            if ($request->contact_type == 'group') {
                $members = ContactGroupItem::whereIn('contact_group_id', $request->group_target ?? [])->get();

                foreach ($members as $member) {
                    if (!empty($member->customer->phone_number)) {
                        $targets[] = [
                            'broadcast_id' => $broadcast->id,
                            'phone' => $member->customer->phone_number,
                            'status' => 'pending',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
            }

            $targets = collect($targets)->unique('phone')->values()->toArray();

            if (count($targets) > 0) {
                BroadcastItem::insert($targets);
            }

            $broadcast->update([
                'total' => count($targets),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Broadcast created successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,

                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $view = 'broadcast-detail';
        $broadcast = Broadcast::findOrFail($id);

        $details = BroadcastItem::where('broadcast_id', $id)->latest()->get();
        return view('crm.broadcast.detail', compact('view', 'broadcast', 'details'));
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
        BroadcastItem::where('broadcast_id', $id)->delete();
        return Broadcast::destroy($id);
    }

    public function start(string $id)
    {
        $broadcast = Broadcast::findOrFail($id);

        $broadcast->update([
            'status' => 'processing',
        ]);

        SendWhatsappBroadcastJob::dispatch($broadcast->id);

        return response()->json([
            'success' => true,
        ]);
    }

    public function retry(string $id)
    {
        BroadcastItem::where('broadcast_id', $id)
            ->where('status', 'failed')
            ->update([
                'status' => 'pending',

                'error' => null,
            ]);

        $broadcast = Broadcast::find($id);

        $broadcast->update([
            'status' => 'processing',
        ]);

        SendWhatsappBroadcastJob::dispatch($id);

        return response()->json([
            'success' => true,
        ]);
    }
    
}
