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
                <div
                    style="
                        height:75vh;
                        overflow-y:auto;
                        background:white;
                    ">

                    @foreach ($conversations as $conversation)
                        <div wire:click="selectConversation({{ $conversation->id }})" class="border-bottom"
                            style="
                                cursor:pointer;
                                transition:0.2s;
                                background:
                                {{ optional($selectedConversation)->id == $conversation->id ? '#f0f2f5' : 'white' }};
                            ">
                            @php
                                $customer = $conversation->customer;
                            @endphp
                            <div class="p-3">

                                <div class="d-flex align-items-center">

                                    {{-- AVATAR --}}
                                    <div class="me-3">
                                      
                                        @if (!empty($customer->photo))
                                            <img src="{{ asset('storage/'.$customer->photo) }}"
                                                width="50" height="50" class="rounded-circle">
                                        @else
                                            <img src="https://ui-avatars.com/api/?background=25D366&color=fff&name={{ urlencode($conversation->customer_name) }}"
                                                width="50" height="50" class="rounded-circle">
                                        @endif
                                    </div>

                                    {{-- CONTENT --}}
                                    <div class="flex-grow-1 overflow-hidden">

                                        <div class="d-flex justify-content-between">

                                            <div class="fw-semibold text-truncate">

                                                {{ $customer->fullname ?? $conversation->phone }}

                                            </div>

                                            <small class="text-muted" style="font-size:11px;">

                                                {{ optional($conversation->last_message_at)->format('H:i') }}

                                            </small>

                                        </div>

                                        <div class="
                                                small
                                                text-muted
                                                text-truncate
                                            "
                                            style="
                                                max-width:220px;
                                            ">

                                            {{ optional($conversation->latestMessage)->message }}

                                        </div>

                                    </div>

                                    {{-- UNREAD --}}
                                    @if ($conversation->unread_count > 0)
                                        <div class="ms-2">

                                            <span
                                                class="
                                                    badge
                                                    rounded-pill
                                                "
                                                style="
                                                    background:#25D366;
                                                    font-size:11px;
                                                ">

                                                {{ $conversation->unread_count }}

                                            </span>

                                        </div>
                                    @endif

                                </div>

                            </div>

                        </div>
                    @endforeach

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
                            
                            @if(! empty($selectedConversation->customer && ! empty($selectedConversation->customer->photo)))
                            <img src="{{ asset('storage/'.$selectedConversation->customer->photo) }}"
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

                        <div class="d-flex gap-3 text-muted">

                            <i class="bi bi-search"></i>

                            <i class="bi bi-three-dots-vertical"></i>

                        </div>

                    </div>

                    {{-- MESSAGE BODY --}}
                    <div id="chat-body" class="p-3"
                        style="
                            background:#efeae2;
                            height:68vh;
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

                                            {{ $msg->message }}

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

                                            {{ $msg->message }}

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
                    <div class="p-3 border-top"
                        style="
                            background:#f0f2f5;
                        ">

                        <div class="d-flex align-items-center">

                            <button
                                class="
                                    btn
                                    border-0
                                    text-muted
                                    me-2
                                ">

                                <i class="bi bi-emoji-smile fs-5"></i>

                            </button>

                            <input type="text" class="form-control border-0" placeholder="Type a message"
                                wire:model="message" wire:keydown.enter="sendMessage"
                                style="
                                    background:white;
                                    border-radius:10px;
                                    height:45px;
                                ">

                            <button
                                class="
                                    btn
                                    btn-success
                                    ms-2
                                    rounded-circle
                                "
                                wire:click="sendMessage"
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
                            height:80vh;
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

</div>

<script>
    function scrollChatToBottom() {

        let chatBody =
            document.getElementById('chat-body');

        if (chatBody) {

            chatBody.scrollTop =
                chatBody.scrollHeight;
        }
    }

    document.addEventListener(
        'livewire:initialized',
        () => {

            scrollChatToBottom();

            Livewire.hook('morph.updated', () => {

                scrollChatToBottom();

            });

        }
    );
</script>
