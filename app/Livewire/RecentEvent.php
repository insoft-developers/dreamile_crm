<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;

class RecentEvent extends Component
{
    public function render()
    {
        $data = Event::orderBy('id','desc')->limit(10)->get();
        return view('components.recent-event', compact('data'));
    }
}
