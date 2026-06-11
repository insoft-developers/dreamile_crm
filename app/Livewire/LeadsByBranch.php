<?php

namespace App\Livewire;

use App\Models\Branch;
use Livewire\Component;

class LeadsByBranch extends Component
{
    public function render()
    {


      
        $branches = Branch::query()
            ->withCount([
                'leads as new_count' => function ($query) {
                    $query->where('status', 'new-lead');
                },
                'leads as visit_count' => function ($query) {
                    $query->where('status', 'visit');
                },
                'leads as confirm_count' => function ($query) {
                    $query->where('status', 'confirm');
                },
                'leads as deal_count' => function ($query) {
                    $query->where('status', 'deal');
                },
                'leads as nok_count' => function ($query) {
                    $query->where('status', 'nok');
                },
                'leads as student_count' => function ($query) {
                    $query->where('is_customer', 1);
                },
            ])
            ->get();

        return view('components.leads-by-branch', compact('branches'));
    }
}
