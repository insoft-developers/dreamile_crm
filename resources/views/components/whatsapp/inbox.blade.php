<div wire:poll.2s>
    {{-- <div> --}}
    <div class="card border-0 shadow-sm overflow-hidden">

        <div class="row g-0">

            {{-- SIDEBAR --}}
            <div class="col-md-3 border-end bg-white">

                {{-- HEADER --}}
                <div class="p-3 border-bottom d-flex align-items-center justify-content-between"
                    style="background:#f0f2f5;">

                    <div class="d-flex align-items-center">

                        <div class="
                                rounded-circle
                                bg-success
                                text-white
                                d-flex
                                align-items-center
                                justify-content-center
                                me-2
                            "
                            style="
                                width:42px;
                                height:42px;
                                font-weight:600;
                            ">

                            D

                        </div>

                        <div>

                            <div class="fw-bold">
                                Dreamile Chat
                            </div>

                            <small class="text-success">
                                Online
                            </small>

                        </div>

                    </div>

                    <div>

                        <i class="bi bi-three-dots-vertical"></i>

                    </div>

                </div>

                <div class="d-flex border-bottom bg-white">
                    <button
                        class="flex-fill btn btn-sm rounded-0 {{ $activeTab == 'chat' ? 'btn-success text-white' : 'btn-light' }}"
                        wire:click="$set('activeTab','chat')">

                        Chat

                    </button>

                    <button
                        class="flex-fill btn btn-sm rounded-0 {{ $activeTab == 'contact' ? 'btn-success text-white' : 'btn-light' }}"
                        wire:click="$set('activeTab','contact')">

                        Contacts

                    </button>
                </div>

                {{-- SUB TAB CHAT --}}
                @if ($activeTab == 'chat')
                    <div style="margin-top:5px"></div>
                    <div class="d-flex border-bottom bg-light">

                        <button
                            class="flex-fill btn btn-sm 
            {{ $chatFilter == 'all' ? 'btn-danger text-white' : 'btn-light' }}"
                            wire:click="$set('chatFilter','all')">

                            All

                        </button>

                        <button
                            class="flex-fill btn btn-sm
            {{ $chatFilter == 'unassigned' ? 'btn-danger text-white' : 'btn-light' }}"
                            wire:click="$set('chatFilter','unassigned')">

                            Unassigned

                        </button>

                        <button
                            class="flex-fill btn btn-sm
            {{ $chatFilter == 'assigned' ? 'btn-danger text-white' : 'btn-light' }}"
                            wire:click="$set('chatFilter','assigned')">

                            Assigned

                        </button>

                        <button
                            class="flex-fill btn btn-sm
            {{ $chatFilter == 'resolved' ? 'btn-danger text-white' : 'btn-light' }}"
                            wire:click="$set('chatFilter','resolved')">

                            Resolved

                        </button>

                    </div>
                @endif

                {{-- SEARCH --}}
                <div class="p-2 border-bottom bg-white">

                    <div class="position-relative">

                        <i class="bi bi-search position-absolute"
                            style="
                                left:12px;
                                top:10px;
                                color:#667781;
                            "></i>

                        <input type="text" class="form-control border-0" placeholder="Search or start new chat"
                            wire:model.live="search"
                            style="
                                background:#f0f2f5;
                                padding-left:38px;
                                border-radius:8px;
                                height:42px;
                            ">

                    </div>

                </div>

                {{-- CHAT LIST --}}
                <div style="height:75vh; overflow-y:auto; background:white;">

                    {{-- ================= CHAT LIST ================= --}}
                    @if ($activeTab == 'chat')

                        @foreach ($conversations as $conversation)
                            <div wire:click="selectConversation({{ $conversation->id }})" class="border-bottom"
                                style="cursor:pointer;height:78px;
                background: {{ optional($selectedConversation)->id == $conversation->id ? '#f0f2f5' : 'white' }};">

                                <div class="p-3 d-flex align-items-center">

                                    <div class="me-3">
                                        @if (empty($conversation->customer) || empty($conversation->customer->photo))
                                            <img src="https://ui-avatars.com/api/?background=25D366&color=fff&name={{ urlencode($conversation->customer_name) }}"
                                                width="40" height="40" class="rounded-circle">
                                        @else
                                            <img src="{{ asset('storage/' . $conversation->customer->photo) }}"
                                                width="40" height="40" class="rounded-circle">
                                        @endif
                                    </div>

                                    <div class="flex-grow-1 overflow-hidden">
                                        <div class="fw-semibold text-truncate">
                                            {{ $conversation->customer->fullname ?? $conversation->phone }}
                                        </div>

                                        <div class="small text-muted text-truncate">
                                            {{ optional($conversation->latestMessage)->message }}
                                        </div>
                                    </div>

                                    @if ($conversation->unread_count > 0)
                                        <span class="custom-badge-number">{{ $conversation->unread_count }}</span>
                                    @endif

                                    {{-- MENU --}}
                                    <div class="dropdown dropdown-chat" wire:ignore>

                            

                                        <button id="dropdownMenu{{ $conversation->id }}"
                                            class="btn btn-sm border-0 p-0 text-muted" data-bs-toggle="dropdown"
                                            onclick="event.stopPropagation()">

                                            <i class="bi bi-three-dots-vertical"></i>

                                        </button>

                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">

                                            {{-- TAKE CHAT --}}

                                            {{-- ASSIGN --}}
                                            <li>

                                                <button class="dropdown-item"
                                                    wire:click.stop="openAssignModal({{ $conversation->id }})">

                                                    <i class="bi bi-person-plus me-2"></i>

                                                    Assign To

                                                </button>

                                            </li>

                                            <li>

                                                <button class="dropdown-item"
                                                    wire:click.stop="takeChat({{ $conversation->id }})">

                                                    <i class="bi bi-person-check me-2"></i>

                                                    Take This Chat

                                                </button>

                                            </li>


                                            {{-- ADD CONTACT --}}
                                            <li>

                                                <button class="dropdown-item"
                                                    wire:click.stop="addToContact({{ $conversation->id }})">

                                                    <i class="bi bi-person-lines-fill me-2"></i>

                                                    Add To Contact

                                                </button>

                                            </li>

                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>

                                            {{-- RESOLVE --}}
                                            <li>

                                                @if ($conversation->status == 'resolved')
                                                    <button class="dropdown-item text-success"
                                                        wire:click.stop="reopenChat({{ $conversation->id }}, 'dropdownMenu{{ $conversation->id }}')">

                                                        <i class="bi bi-check-circle me-2"></i>

                                                        Reopen Chat

                                                    </button>
                                                @else
                                                    <button class="dropdown-item text-success"
                                                        wire:click.stop="resolveChat({{ $conversation->id }}, 'dropdownMenu{{ $conversation->id }}')">

                                                        <i class="bi bi-check-circle me-2"></i>

                                                        Resolve Chat

                                                    </button>
                                                @endif

                                            </li>

                                        </ul>

                                    </div>


                                </div>
                                @if ($conversation->status == 'open')
                                    @if (empty($conversation->assigned_to))
                                        <span class="badge rounded-pill bg-danger chat-status">Unassigned</span>
                                    @else
                                        <span class="badge rounded-pill bg-warning chat-status">Assigned</span>
                                    @endif
                                @elseif($conversation->status == 'resolved')
                                    <span class="badge rounded-pill bg-success chat-status">Resolved</span>
                                @endif






                            </div>
                        @endforeach

                        {{-- ================= CONTACT LIST ================= --}}
                    @else
                        @foreach ($contacts as $contact)
                            <div wire:click="startChatFromContact({{ $contact->id }})" class="border-bottom"
                                style="cursor:pointer;">

                                <div class="p-3 d-flex align-items-center">

                                    <div class="me-3">
                                        @if (!empty($contact->photo))
                                            <img src="{{ asset('storage/' . $contact->photo) }}" width="50"
                                                height="50" class="rounded-circle">
                                        @else
                                            <img src="https://ui-avatars.com/api/?background=0d6efd&color=fff&name={{ urlencode($contact->fullname) }}"
                                                width="50" height="50" class="rounded-circle">
                                        @endif
                                    </div>

                                    <div class="flex-grow-1">

                                        <div class="fw-semibold">
                                            {{ $contact->fullname }}
                                        </div>

                                        <div class="small text-muted">
                                            {{ $contact->phone }}
                                        </div>

                                    </div>

                                </div>

                            </div>
                        @endforeach

                    @endif

                </div>

            </div>

            {{-- CHAT ROOM --}}
            <div class="col-md-9">

                @if ($selectedConversation)

                    {{-- HEADER --}}
                    <div class="
                            p-3
                            border-bottom
                            d-flex
                            align-items-center
                            justify-content-between
                        "
                        style="
                            background:#f0f2f5;
                        ">

                        <div class="d-flex align-items-center">

                            @if (!empty($selectedConversation->customer && !empty($selectedConversation->customer->photo)))
                                <img src="{{ asset('storage/' . $selectedConversation->customer->photo) }}"
                                    width="42" height="42" class="rounded-circle me-3">
                            @else
                                <img src="https://ui-avatars.com/api/?background=25D366&color=fff&name={{ urlencode($selectedConversation->customer_name) }}"
                                    width="42" height="42" class="rounded-circle me-3">
                            @endif
                            <div>

                                <div class="fw-semibold">

                                    {{ $selectedConversation->customer->fullname ?? $selectedConversation->phone }}

                                </div>

                                <small class="text-muted">

                                    {{ $selectedConversation->phone }}

                                </small>

                            </div>

                        </div>

                        @if ($showSearch)
                            <div class="px-3 py-2 border-bottom bg-white">

                                <div class="d-flex align-items-center gap-2">

                                    {{-- INPUT WRAPPER --}}
                                    <div class="position-relative flex-grow-1">

                                        {{-- ICON SEARCH --}}
                                        <i class="bi bi-search position-absolute"
                                            style="
                        left:12px;
                        top:50%;
                        transform:translateY(-50%);
                        color:#667781;
                        font-size:13px;
                    ">
                                        </i>

                                        {{-- INPUT --}}
                                        <input type="text" class="form-control border-0"
                                            placeholder="Search message..."
                                            wire:model.live.debounce.300ms="searchMessage"
                                            style="
                        background:#f0f2f5;
                        padding-left:35px;
                        border-radius:20px;
                        height:38px;
                        font-size:13px;
                    ">
                                    </div>

                                    {{-- CLOSE BUTTON --}}
                                    <button class="btn btn-light border-0" wire:click="closeSearch"
                                        style="
        border-radius:50%;
        width:38px;
        height:38px;
        display:flex;
        align-items:center;
        justify-content:center;
    ">
                                        <i class="bi bi-x-lg"></i>
                                    </button>

                                </div>

                            </div>
                        @endif

                        <div class="d-flex gap-3 text-muted">

                            <i class="bi bi-search" style="cursor:pointer" wire:click="toggleSearch"></i>

                            <i class="bi bi-three-dots-vertical"></i>

                        </div>





                    </div>

                    {{-- MESSAGE BODY --}}
                    <div id="chat-body" class="p-3"
                        style="
                            background:#efeae2;
                            height:75vh;
                            overflow-y:auto;
                        ">

                        @php
                            $lastDate = null;
                        @endphp

                        @foreach ($messages as $msg)
                            @php

                                $messageDate = \Carbon\Carbon::parse($msg->created_at)->format('d M Y');

                            @endphp

                            {{-- DATE --}}
                            @if ($lastDate != $messageDate)
                                <div class="text-center my-3">

                                    <span
                                        class="
                                            px-3
                                            py-1
                                            rounded-pill
                                            shadow-sm
                                            small
                                        "
                                        style="
                                            background:#ffffffd9;
                                            color:#667781;
                                            font-size:12px;
                                        ">

                                        {{ $messageDate }}

                                    </span>

                                </div>

                                @php
                                    $lastDate = $messageDate;
                                @endphp
                            @endif

                            {{-- AGENT --}}
                            @if ($msg->sender == 'agent')
                                <div class="d-flex justify-content-end mb-2">

                                    <div class="position-relative"
                                        style="
                                            max-width:72%;
                                        ">

                                        <div class="
                                                px-3
                                                py-0
                                                shadow-sm
                                                position-relative
                                            "
                                            style="
                                                background:#d9fdd3;
                                                border-radius:8px;
                                                color:#111b21;
                                                font-size:14px;
                                                min-height:10px;
                                                word-break:break-word;
                                                
                                            ">

                                            @if ($msg->type == 'image')
                                                <img src="{{ asset('storage/' . $msg->attachment) }}"
                                                    class="img-fluid rounded" style="max-width:200px;">
                                            @elseif($msg->type == 'file')
                                                <a href="{{ asset('storage/' . $msg->attachment) }}" target="_blank">
                                                    📎 Download File
                                                </a>
                                            @else
                                                @if ($searchMessage)
                                                    {!! str_ireplace(
                                                        $searchMessage,
                                                        '<mark style="background:#ffe58f;padding:0 2px;">' . $searchMessage . '</mark>',
                                                        e($msg->message),
                                                    ) !!}
                                                @else
                                                    {{ $msg->message }}
                                                @endif
                                            @endif

                                            <div class="text-end"
                                                style="
                                                    font-size:11px;
                                                    color:#667781;
                                                    margin-top:2px;
                                                ">

                                                <div class="
        d-flex
        align-items-center
        justify-content-end
        gap-1
    "
                                                    style="
        font-size:11px;
        color:#667781;
        margin-top:0;
    ">

                                                    <span>

                                                        {{ \Carbon\Carbon::parse($msg->created_at)->format('H:i') }}

                                                    </span>

                                                    @if ($msg->sender == 'agent')
                                                        {{-- SENT --}}
                                                        @if ($msg->status == 'sent')
                                                            <i class="bi bi-check2"
                                                                style="
                    font-size:13px;
                "></i>

                                                            {{-- DELIVERED --}}
                                                        @elseif($msg->status == 'delivered')
                                                            <i class="bi bi-check2-all"
                                                                style="
                    font-size:13px;
                "></i>

                                                            {{-- READ --}}
                                                        @elseif($msg->status == 'read')
                                                            <i class="bi bi-check2-all"
                                                                style="
                    font-size:13px;
                    color:#53bdeb;
                "></i>
                                                        @endif
                                                    @endif

                                                </div>

                                            </div>

                                            {{-- TAIL --}}
                                            <div
                                                style="
                                                    position:absolute;
                                                    right:-6px;
                                                    top:0;
                                                    width:0;
                                                    height:0;
                                                    border-top:10px solid #d9fdd3;
                                                    border-left:10px solid transparent;
                                                ">
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                {{-- CUSTOMER --}}
                            @else
                                <div class="d-flex justify-content-start mb-2">

                                    <div class="position-relative"
                                        style="
                                            max-width:72%;
                                        ">

                                        <div class="
                                                px-3
                                                py-0
                                                shadow-sm
                                                position-relative
                                            "
                                            style="
                                                background:white;
                                                border-radius:8px;
                                                color:#111b21;
                                                font-size:14px;
                                                min-height:10px;
                                                word-break:break-word;
                                                
                                            ">

                                            @if ($msg->type == 'image')
                                                <img src="{{ asset('storage/' . $msg->attachment) }}"
                                                    class="img-fluid rounded" style="max-width:200px;">
                                            @elseif($msg->type == 'file')
                                                <a href="{{ asset('storage/' . $msg->attachment) }}" target="_blank">
                                                    📎 Download File
                                                </a>
                                            @else
                                                @if ($searchMessage)
                                                    {!! str_ireplace(
                                                        $searchMessage,
                                                        '<mark style="background:#ffe58f;padding:0 2px;">' . $searchMessage . '</mark>',
                                                        e($msg->message),
                                                    ) !!}
                                                @else
                                                    {{ $msg->message }}
                                                @endif
                                            @endif

                                            <div class="text-end"
                                                style="
                                                    font-size:11px;
                                                    color:#667781;
                                                    margin-top:2px;
                                                ">

                                                {{ \Carbon\Carbon::parse($msg->created_at)->format('H:i') }}

                                            </div>

                                            {{-- TAIL --}}
                                            <div
                                                style="
                                                    position:absolute;
                                                    left:-6px;
                                                    top:0;
                                                    width:0;
                                                    height:0;
                                                    border-top:10px solid white;
                                                    border-right:10px solid transparent;
                                                ">
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            @endif
                        @endforeach

                    </div>

                    {{-- FOOTER --}}
                    {{-- RESOLVED NOTICE --}}
                    @if ($selectedConversation?->status == 'resolved')
                        <div
                            class="alert alert-success rounded-0 mb-0 d-flex align-items-center justify-content-between">

                            <div>

                                <i class="bi bi-check-circle me-2"></i>

                                This chat has been resolved

                            </div>

                            <button class="btn btn-sm btn-warning"
                                wire:click="reopenChat({{ $selectedConversation->id }})">

                                <i class="bi bi-arrow-counterclockwise me-1"></i>

                                Reopen

                            </button>

                        </div>
                    @endif

                    {{-- FOOTER --}}
                    <div class="p-3 border-top" style="background:#f0f2f5;">

                        <div class="d-flex align-items-center">

                            {{-- EMOJI --}}
                            <button id="emojiBtn" class="btn border-0 text-muted me-2"
                                {{ $selectedConversation?->status == 'resolved' ? 'disabled' : '' }}>

                                <i class="bi bi-emoji-smile fs-5"></i>

                            </button>

                            <emoji-picker id="emojiPicker" wire:ignore
                                style="
                position:absolute;
                bottom:70px;
                right:20px;
                display:none;
                z-index:999;
            ">
                            </emoji-picker>

                            {{-- INPUT --}}
                            <input type="text" id="messageInput" class="form-control border-0"
                                placeholder="{{ $selectedConversation?->status == 'resolved' ? 'Chat resolved' : 'Type a message' }}"
                                wire:model="message" wire:keydown.enter="sendMessage"
                                {{ $selectedConversation?->status == 'resolved' ? 'disabled' : '' }}
                                style="
                background:white;
                border-radius:10px;
                height:45px;
            ">

                            {{-- FILE INFO --}}
                            @if ($attachment)
                                <div class="text-success ms-2">

                                    File:
                                    {{ $attachment->getClientOriginalName() }}

                                </div>
                            @endif

                            {{-- UPLOADING --}}
                            <div wire:loading wire:target="attachment">

                                Uploading...

                            </div>

                            {{-- FILE INPUT --}}
                            <input type="file" wire:model="attachment" id="fileInput" style="display:none"
                                accept="image/*,application/pdf,.doc,.docx,.xls,.xlsx" />

                            {{-- ATTACH BUTTON --}}
                            <button class="btn border-0 text-muted me-2"
                                onclick="document.getElementById('fileInput').click()"
                                {{ $selectedConversation?->status == 'resolved' ? 'disabled' : '' }}>

                                <i class="bi bi-paperclip fs-5"></i>

                            </button>

                            {{-- SEND BUTTON --}}
                            <button class="btn btn-success ms-2 rounded-circle" wire:click="sendMessage"
                                {{ $selectedConversation?->status == 'resolved' ? 'disabled' : '' }}
                                style="
                width:45px;
                height:45px;
            ">

                                <i class="bi bi-send-fill"></i>

                            </button>

                        </div>

                    </div>
                @else
                    <div class="
                            d-flex
                            align-items-center
                            justify-content-center
                            flex-column
                        "
                        style="
                            height:90vh;
                            background:#f0f2f5;
                        ">

                        <i class="
                                bi bi-whatsapp
                                text-success
                            "
                            style="
                                font-size:80px;
                            "></i>

                        <h4 class="mt-3">
                            Dreamile WhatsApp CRM
                        </h4>

                        <p class="text-muted">

                            Select conversation to start chat

                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>

    @if ($showAssignModal)

        <div class="modal fade show d-block" style="background:rgba(0,0,0,0.5);">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content border-0 shadow">

                    <div class="modal-header">

                        <h5 class="modal-title">

                            Assign Chat

                        </h5>

                        <button type="button" class="btn-close" wire:click="$set('showAssignModal', false)">
                        </button>

                    </div>

                    <div class="modal-body">

                        <label class="form-label">

                            Select Agent

                        </label>

                        <select class="form-select" wire:model="assignToUser">

                            <option value="">

                                Choose agent

                            </option>

                            @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}">

                                    {{ $agent->name }}

                                </option>
                            @endforeach

                        </select>

                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-light" wire:click="$set('showAssignModal', false)">

                            Cancel

                        </button>

                        <button class="btn btn-success" wire:click="assignChat">

                            Assign

                        </button>

                    </div>

                </div>

            </div>

        </div>

    @endif

</div>
<script type="module">
    import 'https://cdn.jsdelivr.net/npm/emoji-picker-element/index.js';
</script>
<script>
    function isNearBottom(container, threshold = 100) {
        return container.scrollHeight - container.scrollTop - container.clientHeight < threshold;
    }

    function scrollChatToBottom(force = false) {
        let chatBody = document.getElementById('chat-body');

        if (!chatBody) return;

        // cek posisi user
        let shouldScroll = isNearBottom(chatBody);

        if (shouldScroll || force) {
            chatBody.scrollTop = chatBody.scrollHeight;
        }
    }

    document.addEventListener('livewire:initialized', () => {

        let chatBody = document.getElementById('chat-body');

        if (chatBody) {
            // pertama kali load → paksa scroll
            scrollChatToBottom(true);
        }

        Livewire.hook('morph.updated', () => {
            scrollChatToBottom(false);
        });

    });
</script>
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('closeDropdown', (event) => {

            let button = document.getElementById(event.id);

            if (!button) return;

            let dropdown =
                bootstrap.Dropdown.getOrCreateInstance(button);

            dropdown.hide();

        });



        Livewire.on('focusMessageInput', () => {
            let input = document.getElementById('messageInput');
            if (input) input.focus();
        });

        function initEmoji() {

            let picker = document.getElementById('emojiPicker');
            let button = document.getElementById('emojiBtn');
            let input = document.getElementById('messageInput');

            if (!picker || !button || !input) return;

            // ✅ CEGAH DOUBLE INIT
            if (picker.dataset.init === '1') return;

            picker.dataset.init = '1';

            // TOGGLE
            button.onclick = function(e) {
                e.stopPropagation();

                picker.style.display =
                    picker.style.display === 'none' || picker.style.display === '' ?
                    'block' :
                    'none';
            };

            // EMOJI CLICK (HANYA SEKALI)
            picker.addEventListener('emoji-click', function(event) {

                let emoji = event.detail.unicode || event.detail.emoji;

                // safety anti spam
                if (emoji.length > 2) {
                    emoji = emoji[0];
                }

                input.value += emoji;

                input.dispatchEvent(new Event('input'));
                input.focus();
            });

            // CLOSE CLICK LUAR
            document.addEventListener('click', function(e) {
                if (!picker.contains(e.target) && !button.contains(e.target)) {
                    picker.style.display = 'none';
                }
            });
        }

        // INIT PERTAMA
        setTimeout(initEmoji, 200);

        // 🔥 TETAP PANGGIL, TAPI AMAN
        Livewire.hook('morph.updated', () => {
            setTimeout(initEmoji, 200);
        });

    });
</script>
