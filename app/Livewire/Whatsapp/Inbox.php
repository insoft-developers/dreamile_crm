<?php

namespace App\Livewire\Whatsapp;

use App\Models\Customer;
use App\Models\User;
use App\Models\WhatsappConversation;
use App\Models\WhatsappMessage;
use App\Services\WhatsappService;
use Illuminate\Support\Facades\Auth;
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

    public $chatFilter = 'all';

    public $showAssignModal = false;

    public $selectedConversationId;

    public $assignToUser;

    public $agents = [];

    public function mount()
    {
        $this->agents = User::where('position', 'agent')->get();
        if (Auth::user()->position === 'agent') {
            $this->chatFilter = 'mychat';
        }
    }

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
            'userid' => Auth::user()->id,
        ]);

        $this->selectedConversation->update([
            'last_message_at' => now(),
        ]);

        $this->message = '';
    }

    public function render()
    {
        $ownerid = Auth::user()->id;
        $ownerposition = Auth::user()->position;
        $conversations = WhatsappConversation::query()

            // SEARCH
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('customer_name', 'like', '%' . $this->search . '%')->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })

            // FILTER TAB
            ->when($this->chatFilter == 'unassigned', function ($q) {
                $q->whereNull('assigned_to');
            })

            ->when($this->chatFilter == 'assigned', function ($q) {
                $q->whereNotNull('assigned_to')->where('status', 'open');
            })

            ->when($this->chatFilter == 'resolved', function ($q) {
                $q->where('status', 'resolved');
            })

            // MY CHAT (AGENT)
            ->when($this->chatFilter == 'mychat', function ($q) {
                $q->where('assigned_to', auth()->id());
            })

            // RELATION
            ->with(['latestMessage', 'customer'])

            // SORT
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

        return view('components.whatsapp.inbox', compact('conversations', 'messages', 'contacts', 'ownerid', 'ownerposition'));
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

    public function takeChat($conversationId)
    {
        WhatsappConversation::find($conversationId)->update([
            'assigned_to' => auth()->id(),
            'status' => 'open',
        ]);
    }

    public function resolveChat($conversationId, $dropdownId)
    {
        // dd($conversationId);
        WhatsappConversation::where('id', $conversationId)->update([
            'status' => 'resolved',
        ]);

        $this->dispatch('closeDropdown', id: $dropdownId);
    }

    public function addToContact($conversationId)
    {
        $conversation = WhatsappConversation::find($conversationId);

        // create customer/contact
    }

    public function openAssignModal($conversationId)
    {
        $conversation = WhatsappConversation::find($conversationId);

        if ($conversation->assigned_to) {
            session()->flash('warning', 'Chat already assigned to ' . ($conversation->agent?->name ?? 'Agent'));

            return;
        }
        $this->selectedConversationId = $conversationId;

        $this->assignToUser = null;

        $this->showAssignModal = true;
    }

    public function assignChat()
    {
        // dd($this->selectedConversationId);
        WhatsappConversation::where('id', $this->selectedConversationId)->update([
            'assigned_to' => $this->assignToUser,
            'status' => 'open',
        ]);

        $this->showAssignModal = false;
        $this->dispatch('closeDropdown');
        session()->flash('success', 'Chat assigned');
    }

    public function reopenChat($conversationId, $dropdownId = null)
    {
        WhatsappConversation::where('id', $conversationId)->update([
            'status' => 'open',
        ]);

        $this->selectedConversation = WhatsappConversation::find($conversationId);
        if ($dropdownId) {
            $this->dispatch('closeDropdown', id: $dropdownId);
        }

        session()->flash('success', 'Chat reopened');
    }

    public function takeThisChat($conversationId, $dropdownId = null)
    {
        WhatsappConversation::where('id', $conversationId)->update([
            'assigned_to' => Auth::user()->id,
            'status' => 'open',
        ]);
        if ($dropdownId) {
            $this->dispatch('closeDropdown', id: $dropdownId);
        }
    }
}
