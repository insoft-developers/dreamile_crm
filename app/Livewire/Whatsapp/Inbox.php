<?php

namespace App\Livewire\Whatsapp;

use App\Models\WhatsappConversation;
use App\Models\WhatsappMessage;
use App\Services\WhatsappService;
use Livewire\Component;

class Inbox extends Component
{
    public $search = '';

    public $selectedConversation = null;

    public $message = '';

    /*
    |--------------------------------------------------------------------------
    | SELECT CHAT
    |--------------------------------------------------------------------------
    */

    public function selectConversation($id)
    {
        $this->selectedConversation = WhatsappConversation::with('customer')->find($id);

        if ($this->selectedConversation) {
            $this->selectedConversation->update([
                'unread_count' => 0,
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SEND MESSAGE
    |--------------------------------------------------------------------------
    */

    public function sendMessage()
    {
        if (!$this->message || !$this->selectedConversation) {
            return;
        }

        $phone = $this->selectedConversation->phone;

        /*
    |-------------------------
    | SEND MESSAGE
    |-------------------------
    */
        $response = app(WhatsappService::class)->send($phone, $this->message);

        $messageId = $response['messages'][0]['id'] ?? null;

        /*
    |-------------------------
    | SAVE MESSAGE
    |-------------------------
    */
        WhatsappMessage::create([
            'conversation_id' => $this->selectedConversation->id,
            'phone' => $phone,
            'message' => $this->message,
            'sender' => 'agent',
            'message_id' => $messageId, // 🔥 INI WAJIB
            'status' => 'sent',
        ]);

        /*
    |-------------------------
    | UPDATE CONVERSATION
    |-------------------------
    */
        $this->selectedConversation->update([
            'last_message_at' => now(),
        ]);

        $this->message = '';
    }

    /*
    |--------------------------------------------------------------------------
    | RENDER
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $conversations = WhatsappConversation::query()

            ->when($this->search, function ($q) {
                $q->where('customer_name', 'like', '%' . $this->search . '%')->orWhere('phone', 'like', '%' . $this->search . '%');
            })

            ->with(['latestMessage','customer'])

            ->orderByDesc('last_message_at')

            ->get();

        $messages = [];

        if ($this->selectedConversation) {
            $messages = WhatsappMessage::where('conversation_id', $this->selectedConversation->id)->latest()->take(50)->get()->reverse();
        }

        return view('components.whatsapp.inbox', compact('conversations', 'messages'));
    }
}
