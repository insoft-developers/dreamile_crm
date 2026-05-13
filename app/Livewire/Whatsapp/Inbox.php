<?php

namespace App\Livewire\Whatsapp;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\MessageReaction;
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
    public $showContactModal = false;

    public $selectedConversationId;

    public $assignToUser;

    public $agents = [];
    public $branches = [];
    public $contactPhone = '';
    public $contactName = '';
    public $contactAddress = '';
    public $contactSchool = '';
    public $contactClass = '';
    public $contactMajor = '';
    public $contactGender = '';
    public $contactBranch = '';

    public $replyMessageId = null;
    public $replyPreview = null;

    public function mount()
    {
        $this->agents = User::where('position', 'agent')->get();
        if (Auth::user()->position === 'agent') {
            $this->chatFilter = 'mychat';
        }

        $this->branches = Branch::all();
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

        $response = app(WhatsappService::class)->send($phone, $this->message, $this->replyMessageId);

        $messageId = $response['messages'][0]['id'] ?? null;

        WhatsappMessage::create([
            'conversation_id' => $this->selectedConversation->id,
            'phone' => $phone,
            'message' => $this->message,
            'sender' => 'agent',
            'message_id' => $messageId, // 🔥 INI WAJIB
            'status' => 'sent',
            'userid' => Auth::user()->id,
            'reply_message_id' => $this->replyMessageId,
        ]);

        $this->selectedConversation->update([
            'last_message_at' => now(),
        ]);

        $this->message = '';
        if ($this->replyMessageId) {
            $this->replyMessageId = null;
            $this->replyPreview = null;
        }
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
            $messages = WhatsappMessage::with(['replyTo','reactions'])
                ->where('conversation_id', $this->selectedConversation->id)

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

    public function resolveChat($conversationId)
    {
        // dd($conversationId);
        WhatsappConversation::where('id', $conversationId)->update([
            'status' => 'resolved',
        ]);
    }

    public function openAssignModal($conversationId)
    {
        $conversation = WhatsappConversation::find($conversationId);

        if ($conversation->assigned_to && $conversation->status == 'open') {
            session()->flash('error', 'Chat already assigned to ' . ($conversation->agent?->name ?? 'Agent'));

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

    public function openContactModal($conversationId)
    {
        $conversation = WhatsappConversation::find($conversationId);
        $this->selectedConversationId = $conversationId;

        $this->contactName = $conversation->customer?->fullname;
        $this->contactPhone = $conversation->phone;
        $this->contactAddress = $conversation->customer?->full_address;
        $this->contactSchool = $conversation->customer?->school_from;
        $this->contactClass = $conversation->customer?->class;
        $this->contactMajor = $conversation->customer?->major;
        $this->contactGender = $conversation->customer?->gender;
        $this->contactBranch = $conversation->customer?->branch_id;

        $this->showContactModal = true;
    }

    public function updateContact()
    {
        try {
            $customer = Customer::firstOrNew([
                'phone_number' => $this->contactPhone,
            ]);

            $customer->fullname = $this->contactName;
            $customer->full_address = $this->contactAddress;

            $customer->school_from = $this->contactSchool;
            $customer->class = $this->contactClass;
            $customer->major = $this->contactMajor;
            $customer->branch_id = $this->contactBranch;
            $customer->gender = $this->contactGender;

            // hanya saat data baru
            if (!$customer->exists) {
                $customer->lead_source_id = '';
                $customer->created_by = Auth::id();
                $customer->phone_number = $this->contactPhone;
            }

            $customer->save();

            $this->showContactModal = false;
            $this->dispatch('closeDropdown');
            session()->flash('success', 'Contact updated');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            $this->showContactModal = false;
            $this->dispatch('closeDropdown');
        }
    }

    public function replyMessage($id)
    {
        $message = WhatsappMessage::find($id);

        $this->replyMessageId = $message->message_id; // wamid
        $this->replyPreview = $message;

        $this->dispatch('focusMessageInput');
    }

    public function closeReplyPreview()
    {
        $this->replyMessageId = null;
        $this->replyPreview = null;
    }

    public function react($messageId, $emoji)
    {
        
        try {

        
        $msg = WhatsappMessage::find($messageId);

    
        $reaction = MessageReaction::where('message_id', $messageId)
            ->where('user_id', auth()->id())
            ->first();

        // toggle remove
        if ($reaction && $reaction->emoji === $emoji) {
            $reaction->delete();
            return;
        }

        // update existing
        if ($reaction) {
            $reaction->update([
                'emoji' => $emoji,
            ]);
        } else {
            // create
            MessageReaction::create([
                'message_id' => $messageId,
                'user_id' => auth()->id(),
                'emoji' => $emoji,
                
            ]);
        }
        // kirim reaction ke WhatsApp
        app(WhatsappService::class)->react($msg->phone,$msg->message_id,$emoji);
        }
        catch(\Exception $e) {
            dd($e->getMessage());
        }
    }
}
