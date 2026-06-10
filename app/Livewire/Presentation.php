<?php

namespace App\Livewire;

use App\Models\Presentation as ModelsPresentation;
use Livewire\Component;

class Presentation extends Component
{
    public function render()
    {
        $data = ModelsPresentation::orderBy('id','desc')->limit(10)->get();
        return view('components.presentation', compact('data'));
    }
}
