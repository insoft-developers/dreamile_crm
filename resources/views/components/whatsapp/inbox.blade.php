<div wire:poll.2s="checkNewMessage">
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
                                {{ Auth::user()->name }}
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
                {{-- SUB TAB CHAT --}}
                @if ($activeTab == 'chat')

                    <div style="margin-top:5px"></div>


                    <div class="d-flex border-bottom bg-light">

                        {{-- AGENT --}}
                        @if (auth()->user()->position == 'agent')
                            {{-- MY CHAT --}}
                            <button
                                class="flex-fill btn btn-sm
                {{ $chatFilter == 'mychat' ? 'btn-danger text-white' : 'btn-light' }}"
                                wire:click="$set('chatFilter','mychat')">

                                My Chat

                            </button>
                        @else
                            {{-- ADMIN / SUPERVISOR --}}
                            <button
                                class="flex-fill btn btn-sm
                {{ $chatFilter == 'all' ? 'btn-danger text-white' : 'btn-light' }}"
                                wire:click="$set('chatFilter','all')">

                                All

                            </button>
                        @endif

                        {{-- UNASSIGNED --}}
                        <button
                            class="flex-fill btn btn-sm
            {{ $chatFilter == 'unassigned' ? 'btn-danger text-white' : 'btn-light' }}"
                            wire:click="$set('chatFilter','unassigned')">

                            Unassigned

                        </button>

                        {{-- ASSIGNED --}}
                        @if (auth()->user()->position != 'agent')
                            <button
                                class="flex-fill btn btn-sm
                {{ $chatFilter == 'assigned' ? 'btn-danger text-white' : 'btn-light' }}"
                                wire:click="$set('chatFilter','assigned')">

                                Assigned

                            </button>
                        @endif

                        {{-- RESOLVED --}}
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
                    @if (session()->has('warning'))
                        <div class="alert alert-warning mb-2">

                            {{ session('warning') }}

                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger mb-2">

                            {{ session('error') }}

                        </div>
                    @endif

                    @if (session()->has('success'))
                        <div class="alert alert-success mb-2">

                            {{ session('success') }}

                        </div>
                    @endif

                </div>

                {{-- CHAT LIST --}}
                <div style="height:75vh; overflow-y:auto; background:white;">

                    {{-- ================= CHAT LIST ================= --}}
                    @if ($activeTab == 'chat')

                        @forelse ($conversations as $conversation)
                            <div wire:key="conversation-{{ $conversation->id }}"
                                wire:click="selectConversation({{ $conversation->id }})" class="border-bottom"
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



                                            {{-- ASSIGN --}}
                                            @if (Auth::user()->position == 'agent')
                                            @else
                                                <li>

                                                    <button class="dropdown-item"
                                                        wire:click.stop="openAssignModal({{ $conversation->id }})">

                                                        <i class="bi bi-person-plus me-2"></i>

                                                        Assign To

                                                    </button>

                                                </li>
                                            @endif


                                            {{-- ADD CONTACT --}}
                                            <li>

                                                <button class="dropdown-item"
                                                    wire:click.stop="openContactModal({{ $conversation->id }})">

                                                    <i class="bi bi-person-lines-fill me-2"></i>

                                                    Add To Contact

                                                </button>

                                            </li>

                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>



                                        </ul>

                                    </div>


                                </div>
                                @if ($conversation->status == 'open')
                                    @if (empty($conversation->assigned_to))
                                        <span class="badge rounded-pill bg-danger chat-status">Unassigned</span>
                                    @else
                                        <span
                                            class="badge rounded-pill bg-warning chat-status">{{ \Illuminate\Support\Str::limit($conversation->agent?->name, 15) }}</span>
                                    @endif
                                @elseif($conversation->status == 'resolved')
                                    <span class="badge rounded-pill bg-success chat-status">Resolved</span>
                                @endif

                            </div>
                        @empty

                            <div class="d-flex flex-column align-items-center justify-content-center text-muted"
                                style="height:200px;">

                                <i class="bi bi-chat-square-text fs-1 mb-2"></i>

                                <div>No Data</div>

                            </div>
                        @endforelse

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



                        </div>
                        @if ($selectedConversation->status == 'open' && $selectedConversation->assigned_to == $ownerid)
                            <button style="position:relative;float:right;margin-left:-450px;"
                                class="btn btn-sm btn-info"
                                wire:click="resolveChat({{ $selectedConversation->id }})">

                                <i class="bi bi-arrow-counterclockwise me-1"></i>
                                Resolve

                            </button>
                        @endif




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

                                    <div id="msg-{{ $msg->message_id }}" class="position-relative msg-wrapper"
                                        style="
                                            max-width:72%;
                                        ">
                                        <div class="msg-actions dropdown" wire:ignore>

                                            <button class="msg-menu-btn" data-bs-toggle="dropdown">
                                                <i class="bi bi-chevron-down"></i>
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-chat">

                                                <li>
                                                    <a class="dropdown-item" href="#"
                                                        wire:click.prevent="replyMessage({{ $msg->id }})">

                                                        <i class="bi bi-reply me-2"></i>
                                                        Reply

                                                    </a>
                                                </li>


                                            </ul>

                                        </div>
                                        <div class="
                                                px-3
                                                py-0
                                                shadow-sm
                                                position-relative
                                                chat-buble
                                            "
                                            style="
                                                background:#d9fdd3;
                                                border-radius:8px;
                                                color:#111b21;
                                                font-size:14px;
                                                min-height:10px;
                                                word-break:break-word;
                                                
                                            ">

                                            @if ($searchMessage)
                                                {!! str_ireplace(
                                                    $searchMessage,
                                                    '<mark style="background:#ffe58f;padding:0 2px;">' . $searchMessage . '</mark>',
                                                    e($msg->message),
                                                ) !!}
                                            @else
                                                @if ($msg->replyTo)
                                                    <div class="reply-box d-flex align-items-start gap-2"
                                                        onclick="scrollToMessage('{{ $msg->reply_message_id }}')"
                                                        style="
            cursor:pointer;
            background:rgba(0,0,0,0.05);
            border-left:4px solid #53bdeb;
            padding:6px 8px;
            border-radius:7px;
            margin-bottom:4px;
         ">

                                                        {{-- IMAGE THUMB --}}
                                                        @if ($msg->replyTo->type == 'image')
                                                            <img src="{{ asset('storage/' . $msg->replyTo->attachment) }}"
                                                                style="
                    width:45px;
                    height:45px;
                    object-fit:cover;
                    border-radius:5px;
                    flex-shrink:0;
                 ">

                                                            {{-- FILE ICON --}}
                                                        @elseif($msg->replyTo->type == 'file')
                                                            <div
                                                                style="
                    width:45px;
                    height:45px;
                    background:#e9edef;
                    border-radius:5px;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    flex-shrink:0;
                 ">

                                                                <i class="bi bi-file-earmark"
                                                                    style="font-size:20px;"></i>

                                                            </div>
                                                        @endif

                                                        {{-- CONTENT --}}
                                                        <div style="overflow:hidden;">

                                                            <div class="reply-name"
                                                                style="
                    font-size:13px;
                    font-weight:600;
                    color:#53bdeb;
                 ">

                                                                {{ $msg->replyTo->sender == 'agent' ? 'You' : 'Customer' }}

                                                            </div>

                                                            <div
                                                                style="
                    font-size:12px;
                    color:#667781;
                    white-space:nowrap;
                    overflow:hidden;
                    text-overflow:ellipsis;
                    max-width:220px;
                 ">

                                                                @if ($msg->replyTo->type == 'image')
                                                                    📷 Photo
                                                                @elseif($msg->replyTo->type == 'file')
                                                                    📎 {{ $msg->replyTo->file_name ?? 'File' }}
                                                                @else
                                                                    {{ Str::limit($msg->replyTo->message, 80) }}
                                                                @endif

                                                            </div>

                                                        </div>

                                                    </div>
                                                @endif

                                                {{-- AGENT NAME --}}
                                                @if ($msg->sender == 'agent')
                                                    <small>
                                                        <strong>
                                                            {{ $msg->user?->name ?? '' }}
                                                            ({{ $msg->user?->position ?? '' }})
                                                        </strong>
                                                    </small>
                                                    <br>
                                                @endif

                                                {{-- CONTENT --}}
                                                @if ($msg->type == 'image')
                                                    <img src="{{ asset('storage/' . $msg->attachment) }}"
                                                        class="img-fluid rounded" style="max-width:200px;">

                                                    @if ($msg->message)
                                                        <div class="mt-1">
                                                            {!! makeLinksClickable($msg->message) !!}
                                                        </div>
                                                    @endif
                                                @elseif($msg->type == 'file')
                                                    <a href="{{ asset('storage/' . $msg->attachment) }}"
                                                        target="_blank" class="text-decoration-none">

                                                        📎 {{ $msg->file_name ?? 'Download File' }}

                                                    </a>

                                                    @if ($msg->message)
                                                        <div class="mt-1">
                                                            {!! makeLinksClickable($msg->message) !!}
                                                        </div>
                                                    @endif
                                                @else
                                                    {!! makeLinksClickable($msg->message) !!}
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

                                            {{-- REACTION BUTTON --}}
                                            <div class="reaction-trigger reaction-left">

                                                😊

                                                <div class="reaction-picker picker-left">

                                                    <span wire:click="react({{ $msg->id }}, '👍')">👍</span>

                                                    <span wire:click="react({{ $msg->id }}, '❤️')">❤️</span>

                                                    <span wire:click="react({{ $msg->id }}, '😂')">😂</span>

                                                    <span wire:click="react({{ $msg->id }}, '😮')">😮</span>

                                                    <span wire:click="react({{ $msg->id }}, '🙏')">🙏</span>

                                                </div>

                                            </div>
                                            {{-- REACTIONS --}}
                                            @if ($msg->reactions->count())
                                                <div class="reaction-container">

                                                    @foreach ($msg->reactions->groupBy('emoji') as $emoji => $group)
                                                        <span class="reaction-badge">

                                                            {{ $emoji }} {{ $group->count() }}

                                                        </span>
                                                    @endforeach

                                                </div>
                                            @endif

                                        </div>

                                    </div>

                                </div>

                                {{-- CUSTOMER --}}
                            @else
                                <div class="d-flex justify-content-start mb-2">
                                    @if (empty($msg->message) && !$msg->attachment)
                                    @else
                                        <div id="msg-{{ $msg->message_id }}" class="position-relative msg-wrapper"
                                            style="
                                            max-width:72%;
                                        ">
                                            <div class="msg-actions dropdown" wire:ignore>

                                                <button class="msg-menu-btn" data-bs-toggle="dropdown">
                                                    <i class="bi bi-chevron-down icon-reply"></i>
                                                </button>

                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-chat">

                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            wire:click.prevent="replyMessage({{ $msg->id }})">

                                                            <i class="bi bi-reply me-2"></i>
                                                            Reply

                                                        </a>
                                                    </li>
                                                </ul>

                                            </div>
                                            <div class="
                                                px-3
                                                py-0
                                                shadow-sm
                                                position-relative
                                                chat-bubble
                                            "
                                                style="
                                                background:white;
                                                border-radius:8px;
                                                color:#111b21;
                                                font-size:14px;
                                                min-height:10px;
                                                word-break:break-word;
                                                
                                            ">

                                                @if ($searchMessage)
                                                    {!! str_ireplace(
                                                        $searchMessage,
                                                        '<mark style="background:#ffe58f;padding:0 2px;">' . $searchMessage . '</mark>',
                                                        e($msg->message),
                                                    ) !!}
                                                @else
                                                    {{-- REPLY --}}
                                                    @if ($msg->replyTo)
                                                        <div class="reply-box d-flex align-items-start gap-2"
                                                            onclick="scrollToMessage('{{ $msg->reply_message_id }}')"
                                                            style="
                cursor:pointer;
                background:rgba(0,0,0,0.05);
                border-left:4px solid #53bdeb;
                padding:6px 8px;
                border-radius:7px;
                margin-bottom:4px;
             ">

                                                            {{-- IMAGE THUMB --}}
                                                            @if ($msg->replyTo->type == 'image')
                                                                <img src="{{ asset('storage/' . $msg->replyTo->attachment) }}"
                                                                    style="
                        width:45px;
                        height:45px;
                        object-fit:cover;
                        border-radius:5px;
                        flex-shrink:0;
                     ">

                                                                {{-- FILE ICON --}}
                                                            @elseif($msg->replyTo->type == 'file')
                                                                <div
                                                                    style="
                        width:45px;
                        height:45px;
                        background:#e9edef;
                        border-radius:5px;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        flex-shrink:0;
                     ">

                                                                    <i class="bi bi-file-earmark"
                                                                        style="font-size:20px;"></i>

                                                                </div>
                                                            @endif

                                                            {{-- CONTENT --}}
                                                            <div style="overflow:hidden;">

                                                                <div class="reply-name"
                                                                    style="
                        font-size:13px;
                        font-weight:600;
                        color:#53bdeb;
                     ">

                                                                    {{ $msg->replyTo->sender == 'agent' ? 'You' : 'Customer' }}

                                                                </div>

                                                                <div
                                                                    style="
                        font-size:12px;
                        color:#667781;
                        white-space:nowrap;
                        overflow:hidden;
                        text-overflow:ellipsis;
                        max-width:220px;
                     ">

                                                                    @if ($msg->replyTo->type == 'image')
                                                                        📷 Photo
                                                                    @elseif($msg->replyTo->type == 'file')
                                                                        📎 {{ $msg->replyTo->file_name ?? 'File' }}
                                                                    @else
                                                                        {{ Str::limit($msg->replyTo->message, 80) }}
                                                                    @endif

                                                                </div>

                                                            </div>

                                                        </div>
                                                    @endif

                                                    {{-- CONTENT --}}
                                                    @if ($msg->type == 'image')
                                                        <img src="{{ asset('storage/' . $msg->attachment) }}"
                                                            class="img-fluid rounded" style="max-width:200px;">

                                                        @if ($msg->message)
                                                            <div class="mt-1">
                                                                {!! makeLinksClickable($msg->message) !!}
                                                            </div>
                                                        @endif
                                                    @elseif($msg->type == 'file')
                                                        <a href="{{ asset('storage/' . $msg->attachment) }}"
                                                            target="_blank" class="text-decoration-none">

                                                            📎 {{ $msg->file_name ?? 'Download File' }}

                                                        </a>

                                                        @if ($msg->message)
                                                            <div class="mt-1">
                                                                {!! makeLinksClickable($msg->message) !!}
                                                            </div>
                                                        @endif
                                                    @else
                                                        {!! makeLinksClickable($msg->message) !!}
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

                                                {{-- REACTION BUTTON --}}
                                                <div class="reaction-trigger">

                                                    😊

                                                    <div class="reaction-picker picker-right">

                                                        <span wire:click="react({{ $msg->id }}, '👍')">👍</span>

                                                        <span wire:click="react({{ $msg->id }}, '❤️')">❤️</span>

                                                        <span wire:click="react({{ $msg->id }}, '😂')">😂</span>

                                                        <span wire:click="react({{ $msg->id }}, '😮')">😮</span>

                                                        <span wire:click="react({{ $msg->id }}, '🙏')">🙏</span>

                                                    </div>

                                                </div>
                                            </div>
                                            {{-- REACTIONS --}}
                                            @if ($msg->reactions->count())
                                                <div class="reaction-container">

                                                    @foreach ($msg->reactions->groupBy('emoji') as $emoji => $group)
                                                        <span class="reaction-badge">

                                                            {{ $emoji }} {{ $group->count() }}

                                                        </span>
                                                    @endforeach

                                                </div>
                                            @endif

                                        </div>
                                    @endif
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

                            <button
                                {{ $selectedConversation->assigned_to !== $ownerid && $ownerposition !== 'supervisor' ? 'disabled' : '' }}
                                class="btn btn-sm btn-warning"
                                wire:click="reopenChat({{ $selectedConversation->id }})">

                                <i class="bi bi-arrow-counterclockwise me-1"></i>

                                Reopen

                            </button>

                        </div>
                    @elseif($ownerid !== $selectedConversation->assigned_to && $ownerposition !== 'supervisor')
                        <div
                            class="alert alert-danger rounded-0 mb-0 d-flex align-items-center justify-content-between">

                            <div>

                                <i class="bi bi-check-circle me-2"></i>

                                This chat hasn't been assigned to you

                            </div>

                            @if (empty($selectedConversation->assigned_to))
                                <button class="btn btn-sm btn-danger"
                                    wire:click="takeThisChat({{ $selectedConversation->id }})">

                                    <i class="bi bi-person-check me-2 me-1"></i>

                                    Take this chat

                                </button>
                            @endif

                        </div>




                    @endif

                    {{-- FOOTER --}}
                    <div class="p-3 border-top" style="background:#f0f2f5;">
                        @if ($replyPreview)

                            <div
                                class="
            bg-light
            border-top
            border-bottom
            p-2
            d-flex
            justify-content-between
            align-items-start
        ">

                                <div class="d-flex align-items-start gap-2 w-100">

                                    {{-- IMAGE THUMB --}}
                                    @if ($replyPreview->type == 'image')
                                        <img src="{{ asset('storage/' . $replyPreview->attachment) }}"
                                            style="
                        width:50px;
                        height:50px;
                        object-fit:cover;
                        border-radius:6px;
                        flex-shrink:0;
                     ">

                                        {{-- FILE ICON --}}
                                    @elseif($replyPreview->type == 'file')
                                        <div
                                            style="
                        width:50px;
                        height:50px;
                        background:#e9edef;
                        border-radius:6px;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        flex-shrink:0;
                     ">

                                            <i class="bi bi-file-earmark" style="font-size:22px;"></i>

                                        </div>
                                    @endif

                                    {{-- CONTENT --}}
                                    <div class="flex-grow-1"
                                        style="
                    border-left:4px solid #25d366;
                    padding-left:10px;
                    overflow:hidden;
                 ">

                                        <div class="fw-semibold text-success small">

                                            {{ $replyPreview->sender == 'agent' ? 'Replying to yourself' : 'Replying to customer' }}

                                        </div>

                                        <div
                                            style="
                        font-size:13px;
                        color:#667781;
                        white-space:nowrap;
                        overflow:hidden;
                        text-overflow:ellipsis;
                     ">

                                            @if ($replyPreview->type == 'image')

                                                📷 Photo

                                                @if ($replyPreview->message)
                                                    — {{ Str::limit($replyPreview->message, 50) }}
                                                @endif
                                            @elseif($replyPreview->type == 'file')
                                                📎 {{ $replyPreview->file_name ?? 'File' }}

                                                @if ($replyPreview->message)
                                                    — {{ Str::limit($replyPreview->message, 50) }}
                                                @endif
                                            @else
                                                {{ Str::limit($replyPreview->message, 100) }}

                                            @endif

                                        </div>

                                    </div>

                                </div>

                                {{-- CLOSE --}}
                                <button class="btn btn-sm" wire:click="closeReplyPreview">

                                    <i class="bi bi-x-lg"></i>

                                </button>

                            </div>

                        @endif

                        <div class="d-flex align-items-center">



                            {{-- EMOJI --}}
                            <button id="emojiBtn" class="btn border-0 text-muted me-2"
                                {{ $selectedConversation?->status == 'resolved' || ($ownerid !== $selectedConversation->assigned_to && $ownerposition !== 'supervisor') ? 'disabled' : '' }}>

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
                                {{ $selectedConversation?->status == 'resolved' || ($ownerid !== $selectedConversation?->assigned_to && $ownerposition !== 'supervisor') ? 'disabled' : '' }}
                                style="
                background:white;
                border-radius:10px;
                height:45px;
            ">

                            {{-- FILE INFO --}}
                            {{-- MULTIPLE ATTACHMENT PREVIEW --}}
                            @if (!empty($attachments))

                                <div class="d-flex flex-column gap-2 mt-2 px-2">

                                    @foreach ($attachments as $index => $attachment)
                                        <div class="
                    border
                    rounded-3
                    bg-light
                    p-2
                    d-flex
                    align-items-center
                    justify-content-between
                 "
                                            style="
                    max-width:320px;
                 ">

                                            <div
                                                class="
                        d-flex
                        align-items-center
                        gap-2
                        overflow-hidden
                     ">

                                                {{-- IMAGE --}}
                                                @if (str_starts_with($attachment->getMimeType(), 'image/'))
                                                    <img src="{{ $attachment->temporaryUrl() }}"
                                                        style="
                                width:48px;
                                height:48px;
                                object-fit:cover;
                                border-radius:8px;
                                flex-shrink:0;
                             ">
                                                @else
                                                    {{-- FILE ICON --}}
                                                    <div
                                                        style="
                                width:48px;
                                height:48px;
                                background:#e9edef;
                                border-radius:8px;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                flex-shrink:0;
                             ">

                                                        @if (str_contains($attachment->getMimeType(), 'pdf'))
                                                            <i class="bi bi-file-earmark-pdf"
                                                                style="
                                        font-size:22px;
                                        color:#e53935;
                                   "></i>
                                                        @elseif (str_contains($attachment->getMimeType(), 'word') || str_contains($attachment->getMimeType(), 'document'))
                                                            <i class="bi bi-file-earmark-word"
                                                                style="
                                        font-size:22px;
                                        color:#1976d2;
                                   "></i>
                                                        @else
                                                            <i class="bi bi-paperclip"
                                                                style="
                                        font-size:20px;
                                        color:#667781;
                                   "></i>
                                                        @endif

                                                    </div>
                                                @endif

                                                {{-- FILE INFO --}}
                                                <div class="overflow-hidden">

                                                    <div
                                                        style="
                                font-size:13px;
                                font-weight:600;
                                color:#111b21;
                                white-space:nowrap;
                                overflow:hidden;
                                text-overflow:ellipsis;
                             ">

                                                        {{ $attachment->getClientOriginalName() }}

                                                    </div>

                                                    <div
                                                        style="
                                font-size:11px;
                                color:#667781;
                             ">

                                                        {{ number_format($attachment->getSize() / 1024, 1) }}
                                                        KB

                                                    </div>

                                                </div>

                                            </div>

                                            {{-- REMOVE --}}
                                            <button type="button" class="btn btn-sm btn-light border"
                                                wire:click="removeAttachment({{ $index }})">

                                                <i class="bi bi-x-lg"></i>

                                            </button>

                                        </div>
                                    @endforeach

                                </div>

                            @endif

                            <div wire:loading.delay wire:target="attachments"
                                class="
                                    d-none
                                    mt-2
                                    ms-2
                                    px-3
                                    py-2
                                    rounded-pill
                                    bg-light
                                    d-flex
                                    align-items-center
                                    gap-2
                                "
                                wire:loading.class.remove="d-none">

                                <div class="spinner-border spinner-border-sm" role="status"
                                    style="
                                        width:14px;
                                        height:14px;
                                    ">
                                </div>

                                Uploading files...

                            </div>

                            {{-- FILE INPUT --}}
                            <input type="file" multiple wire:model="attachments" id="chatAttachment" hidden>

                            {{-- ATTACH BUTTON --}}
                            <button class="btn border-0 text-muted me-2"
                                onclick="document.getElementById('chatAttachment').click()"
                                {{ $selectedConversation?->status == 'resolved' || ($ownerid !== $selectedConversation->assigned_to && $ownerposition !== 'supervisor') ? 'disabled' : '' }}>
                                <i class="bi bi-paperclip fs-5"></i>
                            </button>
                            {{-- SEND BUTTON --}}
                            <button class="btn btn-success ms-2 rounded-circle" wire:click="sendMessage"
                                {{ $selectedConversation?->status == 'resolved' || ($ownerid !== $selectedConversation?->assigned_to && $ownerposition !== 'supervisor') ? 'disabled' : '' }}
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
                        <h5 class="modal-title">Assign Chat</h5>
                        <button type="button" class="btn-close" wire:click="$set('showAssignModal', false)">
                        </button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Select Agent</label>
                        <select class="form-select" wire:model="assignToUser">
                            <option value="">Choose agent</option>
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
                        <button class="btn btn-success" wire:click="assignChat">Assign</button>
                    </div>
                </div>
            </div>
        </div>
    @endif


    @if ($showContactModal)
        <div class="modal fade show d-block" style="background:rgba(0,0,0,0.5);">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content border-0 shadow">

                    <div class="modal-header">

                        <h5 class="modal-title">

                            Add to Contact

                        </h5>

                        <button type="button" class="btn-close" wire:click="$set('showContactModal', false)">
                        </button>

                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label class="form-label">
                                        Contact Name
                                    </label>
                                    <input type="text" class="form-control" wire:model="contactName"
                                        placeholder="Input contact name">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        Phone Number
                                    </label>
                                    <input readonly type="text" class="form-control" wire:model="contactPhone"
                                        placeholder="Input contact phone">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        Address
                                    </label>
                                    <textarea class="form-control" wire:model="contactAddress" placeholder="Input contact address"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        School From
                                    </label>
                                    <input type="text" class="form-control" wire:model="contactSchool"
                                        placeholder="Input school name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Class
                                    </label>
                                    <input type="text" class="form-control" wire:model="contactClass"
                                        placeholder="Input Class">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        Major
                                    </label>
                                    <input type="text" class="form-control" wire:model="contactMajor"
                                        placeholder="Input Major">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        Gender
                                    </label>
                                    <select class="form-select" wire:model="contactGender">
                                        <option value="">- Select -</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        Branch
                                    </label>
                                    <select class="form-select" wire:model="contactBranch">
                                        <option value="">- Select -</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light" wire:click="$set('showContactModal', false)">
                            Cancel
                        </button>
                        <button class="btn btn-success" wire:click="updateContact">
                            Update Contact
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

    let shouldAutoScroll = true;

    function scrollToBottom(force = false) {

        const chatBody = document.getElementById('chat-body');

        if (!chatBody) return;

        if (shouldAutoScroll || force) {

            requestAnimationFrame(() => {

                chatBody.scrollTop = chatBody.scrollHeight;

            });
        }
    }

    document.addEventListener('livewire:initialized', () => {

        // pertama kali load halaman
        setTimeout(() => {

            scrollToBottom(true);

        }, 300);

        // detect user scroll
        document.addEventListener('scroll', () => {

            const chatBody = document.getElementById('chat-body');

            if (!chatBody) return;

            const threshold = 100;

            const isBottom =
                chatBody.scrollHeight -
                chatBody.scrollTop -
                chatBody.clientHeight <
                threshold;

            shouldAutoScroll = isBottom;

        }, true);

        // setelah livewire update
        Livewire.hook('morph.updated', () => {

            setTimeout(() => {

                scrollToBottom(false);

            }, 50);

        });

        // paksa scroll saat buka conversation
        Livewire.on('force-scroll-bottom', () => {

            shouldAutoScroll = true;

            setTimeout(() => {

                scrollToBottom(true);

            }, 100);

        });

    });

</script>
    
<script>
    document.addEventListener('livewire:initialized', () => {

        Livewire.on('new-message', () => {

            let audio = document.getElementById('notifSound');

            if (audio) {

                audio.currentTime = 0;

                audio.play().catch(error => {

                    console.log(error);
                });
            }

        });


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

            const picker = document.getElementById('emojiPicker');
            const button = document.getElementById('emojiBtn');
            const input = document.getElementById('messageInput');

            if (!picker || !button || !input) return;

            // toggle
            button.onclick = (e) => {
                e.stopPropagation();
                picker.style.display = picker.style.display === 'block' ? 'none' : 'block';
            };

            // prevent duplicate listener
            if (!picker.dataset.bound) {
                picker.addEventListener('emoji-click', (event) => {
                    const emoji = event.detail.unicode;

                    const start = input.selectionStart;
                    const end = input.selectionEnd;

                    input.setRangeText(emoji, start, end, 'end');

                    input.dispatchEvent(new Event('input'));
                    input.focus();
                });

                picker.dataset.bound = '1';
            }

            // close outside
            document.addEventListener('click', (e) => {
                if (!picker.contains(e.target) && !button.contains(e.target)) {
                    picker.style.display = 'none';
                }
            });
        }

        setTimeout(initEmoji, 200);

        Livewire.hook('morph.updated', () => {
            setTimeout(initEmoji, 200);
        });

    });
</script>
<script>
    function scrollToMessage(messageId) {

        const el = document.getElementById('msg-' + messageId);

        if (el) {

            el.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            // highlight sementara
            el.style.transition = '0.3s';
            el.style.background = '#fff3cd';

            setTimeout(() => {
                el.style.background = '';
            }, 2000);
        }
    }
</script>
