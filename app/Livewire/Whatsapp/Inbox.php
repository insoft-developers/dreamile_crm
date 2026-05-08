<?php

namespace App\Livewire\Whatsapp;

use App\Models\Customer;
use App\Models\WhatsappConversation;
use App\Models\WhatsappMessage;
use App\Services\WhatsappService;
use Livewire\Component;
use Livewire\WithFileUploads;

class Inbox extends Component
{
    use WithFileUploads;

    public $search = '';
    public $activeTab = 'chat';
    public $selectedConversation = null;

    public $message = '';
    public $searchMessage = '';
    public $attachment;
    public $showSearch = false;

    /*
    |--------------------------------------------------------------------------
    | SELECT CHAT
    |--------------------------------------------------------------------------
    */

    public function selectConversation($id)
    {
        $this->selectedConversation = WhatsappConversation::with('customer')->find($id);

        $this->searchMessage = ''; // 🔥 WAJIB reset

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

        $response = app(WhatsappService::class)->send($phone, $this->message);

        $messageId = $response['messages'][0]['id'] ?? null;

        WhatsappMessage::create([
            'conversation_id' => $this->selectedConversation->id,
            'phone' => $phone,
            'message' => $this->message,
            'sender' => 'agent',
            'message_id' => $messageId, // 🔥 INI WAJIB
            'status' => 'sent',
        ]);

        $this->selectedConversation->update([
            'last_message_at' => now(),
        ]);

        $this->message = '';
    }

    public function render()
    {
        $conversations = WhatsappConversation::query()

            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('customer_name', 'like', '%' . $this->search . '%')->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })

            ->with(['latestMessage', 'customer'])

            ->orderByDesc('last_message_at')

            ->get();

        $messages = [];

        $contacts = Customer::query()
            ->whereNotNull('phone_number')
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('fullname', 'like', '%' . $this->search . '%')->orWhere('phone_number', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('fullname')
            ->get();

        if ($this->selectedConversation) {
            $messages = WhatsappMessage::where('conversation_id', $this->selectedConversation->id)

                ->when($this->searchMessage, function ($q) {
                    $q->where('message', 'like', '%' . $this->searchMessage . '%');
                })

                ->latest()
                ->take(50)
                ->get()
                ->reverse();
        }

        return view('components.whatsapp.inbox', compact('conversations', 'messages', 'contacts'));
    }

    public function startChatFromContact($customerId)
    {
        $customer = Customer::find($customerId);

        if (!$customer || !$customer->phone_number) {
            return;
        }

        $conversation = WhatsappConversation::firstOrCreate(
            ['phone' => $customer->phone_number],
            [
                'customer_name' => $customer->fullname,
                'last_message_at' => now(),
            ],
        );

        $this->selectConversation($conversation->id);
        $this->activeTab = 'chat';
    }

    public function toggleSearch()
    {
        $this->showSearch = !$this->showSearch;
    }

    public function closeSearch()
    {
        $this->showSearch = false;
        $this->searchMessage = '';
        $this->dispatch('focusMessageInput');
    }


}
