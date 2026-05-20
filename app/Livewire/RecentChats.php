<?php

namespace App\Livewire;

use App\Models\WhatsappConversation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RecentChats extends Component
{
    public function render()
    {
        $query = WhatsappConversation::with('customer')->latest('last_message_at');

        if (!empty(Auth::user()->branch_id)) {
            $query->whereHas('customer', function ($q) {
                $q->where('branch_id', Auth::user()->branch_id);
            });
        }

        $recents = $query->take(10)->get();
        return view('components.recent-chats', compact('recents'));
    }
}
