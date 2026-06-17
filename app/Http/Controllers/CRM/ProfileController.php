<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $view = 'view-profile';
        return view('crm.profile.index', compact('view'));
    }

    public function update(Request $request)
    {

        $user = Auth::user();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => [
                'required',
                'unique:users,phone_number,' . $user->id,
                'regex:/^628[0-9]{7,13}$/'
            ],
            'photo_profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|confirmed|min:6'
        ], [
            'email.unique' => 'Email sudah digunakan oleh user lain.',
            'phone_number.required' => 'Nomor HP wajib diisi.',
            'phone_number.unique' => 'Nomor HP sudah digunakan oleh user lain.',
            'phone_number.regex' => 'Nomor HP harus menggunakan format 628xxxxxxxxxx.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        DB::beginTransaction();



        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
            ];



            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            if ($request->hasFile('photo_profile')) {

                $path = public_path('storage/users');

                if (!File::exists($path)) {
                    File::makeDirectory($path, 0755, true);
                }

                if (
                    $user->photo_profile &&
                    File::exists($path . '/' . $user->photo_profile)
                ) {

                    File::delete($path . '/' . $user->photo_profile);
                }

                $filename = time() . '_' . $request
                    ->file('photo_profile')
                    ->getClientOriginalName();

                $request->file('photo_profile')
                    ->move($path, $filename);

                $data['photo_profile'] = 'users/'.$filename;
            }

            $user->update($data);

            DB::commit();

            return back()->with(
                'success',
                'Profil berhasil diperbarui.'
            );
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with(
                'error',
                'Gagal memperbarui profil: ' . $e->getMessage()
            );
        }
    }
}
