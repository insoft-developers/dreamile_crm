<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
        }

        .title {
            text-align: center;
            margin-bottom: 10px;
        }

        .company {
            font-size: 18px;
            font-weight: bold;
        }

        .address {
            font-size: 11px;
        }

        .report-title {
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #198754;
            color: white;
            font-size: 10px;
            padding: 6px;
            border: 1px solid #000;
            text-align: center;
        }

        table td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: top;
            word-wrap: break-word;
        }

        .text-center {
            text-align: center;
        }

        .note {
            width: 180px;
            word-break: break-word;
        }
    </style>

</head>

<body>

    <!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">


<style>

    body{
        font-family: DejaVu Sans, sans-serif;
        font-size:12px;
    }

    .header{
        text-align:center;
        margin-bottom:20px;
    }

    .company{
        font-size:20px;
        font-weight:bold;
    }

    .address{
        font-size:12px;
    }

    .title{
        font-size:16px;
        font-weight:bold;
        margin-top:10px;
    }

    .chat{
        margin-bottom:15px;
        clear:both;
    }

    .customer{
        text-align:left;
    }

    .agent{
        text-align:right;
    }

    .bubble-customer{
        display:inline-block;
        max-width:70%;
        background:#f1f1f1;
        padding:10px;
        border-radius:10px;
        text-align:left;
    }

    .bubble-agent{
        display:inline-block;
        max-width:70%;
        background:#DCF8C6;
        padding:10px;
        border-radius:10px;
        text-align:left;
    }

    .sender{
        font-weight:bold;
        margin-bottom:5px;
    }

    .time{
        font-size:10px;
        color:#666;
        margin-top:5px;
    }

    img{
        max-width:250px;
        max-height:250px;
        margin-bottom:5px;
    }

    hr{
        border:none;
        border-top:1px solid #ddd;
        margin:15px 0;
    }

</style>


</head>

<body>

<div class="header">


<div class="company">
    {{ $company->company_name }}
</div>

<div class="address">
    {{ $company->address }}
</div>

<div class="title">
    CHAT HISTORY DETAIL REPORT
</div>


</div>

@foreach($data as $chat)


@php

    $isAgent = $chat->sender != 'customer';

    $sender = $isAgent
        ? ($chat->user?->name ?? 'Agent')
        : ($chat->customer?->fullname ?? 'Customer');

@endphp

<div class="chat {{ $isAgent ? 'agent' : 'customer' }}">

    <div class="{{ $isAgent ? 'bubble-agent' : 'bubble-customer' }}">

        <div class="sender">
            {{ $sender }}
        </div>

        @if($chat->type == 'image' && $chat->attachment)

            @php
                $path = public_path('storage/'.$chat->attachment);
            @endphp

            @if(file_exists($path))
                <img src="{{ $path }}">
            @else
                <div>[IMAGE]</div>
            @endif

        @elseif($chat->type == 'file')

            <div>
                📎 {{ $chat->file_name ?? 'Attachment' }}
            </div>

        @endif

        <div>
            {!! nl2br(e($chat->message)) !!}
        </div>

        <div class="time">
            {{ date('d-m-Y H:i', strtotime($chat->created_at)) }}
        </div>

    </div>

</div>


@endforeach

</body>

</html>


</body>

</html>