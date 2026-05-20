<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserOnline extends Component
{
    public function render()
    {
        $users = null;
        if(empty(Auth::user()->branch_id))
            {
                $users = User::where('is_active', 1)->get();
            } else {
                $users = User::where('is_active', 1)->where('branch_id', Auth::user()->branch_id)->get();
            }

        return view('components.user-online', compact('users'));
    }
}
