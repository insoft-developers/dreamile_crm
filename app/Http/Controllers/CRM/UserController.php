<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Level;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function table(Request $request)
    {
        if ($request->ajax()) {
            $data = User::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('photo_profile', function ($row) {
                    if (!empty($row->photo_profile)) {
                        return '<img class="user-image" src="'.asset('/storage/'.$row->photo_profile).'">';
                    } else {
                        return '<center> -</center>';
                    }
                })
                ->addColumn('updated_at', function ($row) {
                    return date('d-m-Y H:i', strtotime($row->updated_at));
                })
                ->addColumn('branch_id', function ($row) {
                    return $row->branch_id == null ? 'All Branch' : $row->branch->branch_name ?? '';
                })
                ->addColumn('level', function ($row) {
                    return $row->levels->level_name ?? '';
                })

                ->addColumn('position', function ($row) {
                    return $row->positions->position_name ?? '';
                })
                ->addColumn('action', function ($row) {
                    $button = '';
                    $button .= '<center>';

                    $button .= '<button onclick="editData('.$row->id.')" title="Edit Data" class="me-0 btn btn-insoft btn-warning"><i class="bi bi-pencil-square"></i></button>';
                    $button .= '<button onclick="deleteData('.$row->id.')" style="margin-left:3px;" title="Delete Data" class="btn btn-insoft btn-danger"><i class="bi bi-trash3"></i></button>';

                    $button .= '</center>';
                    return $button;
                })
                ->rawColumns(['action','photo_profile'])
                ->make(true);
        }
    }


    public function index()
    {
        $view = 'user';
        $branches = Branch::all();
        $levels = Level::all();
        $positions = Position::all();
        return view('crm.user.user.index', compact('view', 'branches', 'levels', 'positions'));
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
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email',
            'branch_id' => 'nullable',
            'level' => 'required',
            'position' => 'required',
            'password' => 'required|min:6',
            'photo_profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ]);

        $input['password'] = bcrypt($request->password);


        $path = null;

        if ($request->hasFile('photo_profile')) {
            $path = $request->file('photo_profile')->store('users', 'public');
        }

        $input['photo_profile'] = $path;
        User::create($input);


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
        $data = User::find($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();
        $user = User::find($id);
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|'.Rule::unique('users')->ignore($user->id),
            'branch_id' => 'nullable',
            'level' => 'required',
            'position' => 'required',
            'password' => 'nullable|string|min:6',
            'photo_profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ]);

        $path = $user->photo_profile;

        if ($request->hasFile('photo_profile')) {

            // hapus foto lama (kalau ada)
            if ($user->photo_profile && Storage::disk('public')->exists($user->photo_profile)) {
                Storage::disk('public')->delete($user->photo_profile);
            }

            // upload foto baru
            $path = $request->file('photo_profile')->store('users', 'public');
        }


        if (!empty($request->password)) {
            $input['password'] = bcrypt($request->password);
        } else {
            $input['password'] = $user->password;
        }

        $input['photo_profile'] = $path;
        $user->update($input);

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
        $user = User::find($id);


        if ($user->photo_profile && Storage::disk('public')->exists($user->photo_profile)) {
            Storage::disk('public')->delete($user->photo_profile);
        }

        // hapus data user
        $user->delete();
    }
}
