<?php

namespace App\Livewire;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LeadStatus extends Component
{
    public function render()
    {
        $query = Customer::whereNull('is_customer');
        if (Auth::user()->branch_id) {
            $query->where('branch_id', Auth::user()->branch_id);
        }
        
        $data = $query->selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');
        return view('components.lead-status', compact('data'));
    }
}

