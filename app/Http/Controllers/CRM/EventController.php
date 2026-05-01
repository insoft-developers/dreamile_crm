<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Event;
use App\Models\Level;
use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function table(Request $request)
    {
        if ($request->ajax()) {
            $data = Event::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    if (!empty($row->image)) {
                        return '<a href="'.asset('/storage/'.$row->image).'" target="_blank"><img class="user-image" src="'.asset('/storage/'.$row->image).'"></a>';
                    } else {
                        return '<center> -</center>';
                    }
                })
                ->addColumn('updated_at', function ($row) {
                    return date('d-m-Y H:i', strtotime($row->updated_at));
                })
                ->addColumn('event_date', function ($row) {
                    return date('d-m-Y', strtotime($row->event_date));
                })
                ->addColumn('event_location', function ($row) {
                    return '<div style="white-space:normal;width:330px;">'.$row->event_location.'</div>';
                })

                ->addColumn('action', function ($row) {
                    $button = '';
                    $button .= '<center>';

                    $button .= '<button style="margin-left:3px;" onclick="editData('.$row->id.')" title="Edit Data" class="me-0 btn btn-insoft btn-warning"><i class="bi bi-pencil-square"></i></button>';
                    $button .= '<button onclick="deleteData('.$row->id.')" style="margin-left:3px;" title="Delete Data" class="btn btn-insoft btn-danger"><i class="bi bi-trash3"></i></button>';

                    $button .= '</center>';
                    return $button;
                })
                ->rawColumns(['action','image','event_location'])
                ->make(true);
        }
    }


    public function index()
    {
        $view = 'event';

        return view('crm.customers.event.index', compact('view'));
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
            'event_name' => 'required|string|max:150',
            'event_date' => 'required',
            'event_location' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ]);

        $path = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 'public');
        }

        $input['image'] = $path;
        Event::create($input);


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
        $data = Event::find($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();
        $event = Event::find($id);
        $validated = $request->validate([
            'event_name' => 'required|string|max:150',
            'event_date' => 'required',
            'event_location' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ]);

        $path = $event->image;

        if ($request->hasFile('image')) {

            // hapus foto lama (kalau ada)
            if ($event->image && Storage::disk('public')->exists($event->image)) {
                Storage::disk('public')->delete($event->image);
            }

            // upload foto baru
            $path = $request->file('image')->store('events', 'public');
        }

        $input['image'] = $path;
        $input['updated_at'] = Carbon::now();
        $event->update($input);

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
        $event = Event::find($id);


        if ($event->image && Storage::disk('public')->exists($event->image)) {
            Storage::disk('public')->delete($event->image);
        }

        // hapus data user
        $event->delete();
    }


}
