@extends('crm.master')
@section('content')
    <main class="app-wrapper">
        <div class="container-fluid">

            <div class="main-breadcrumb my-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-2">
                            Dreamile CRM Dashboard
                        </h2>

                        <p class="mb-0 text-light opacity-75">
                            Monitor leads, chats, presentations, events and broadcast performance in real time.
                        </p>
                    </div>

                    <div class="text-end">
                        <div class="badge bg-success fs-6 px-3 py-2">
                            {{ now()->format('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-xxl-8">
                    <div class="row h-100">


                        <div class="col-xl-3 col-sm-6">
                            <div class="card card-h-100">
                                <div class="card-body d-flex align-items-center justify-content-around">
                                    <div
                                        class="h-48px w-50px position-relative d-flex justify-content-center align-items-center text-primary fs-4 rounded-3 shadow-lg border">
                                        <i class="bi bi-broadcast"></i>
                                    </div>
                                    <div>
                                        <h3>{{ $broadcastToday }} </h3>
                                        <span class="fs-5">Broadcast Sent</span>
                                        <p class="fs-12 mb-0"><span class="text-success"></span> </p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-3 col-sm-6">
                            <div class="card card-h-100">
                                <div class="card-body d-flex align-items-center justify-content-around">
                                    <div
                                        class="h-48px w-50px position-relative d-flex justify-content-center align-items-center text-primary fs-4 rounded-3 shadow-lg border">
                                        <i class="bi bi-arrow-down-circle text-success"></i>
                                    </div>
                                    <div>
                                        <h3>{{ $incomingChats }} </h3>
                                        <span class="fs-5">Incoming Chat</span>
                                        <p class="fs-12 mb-0"><span class="text-success"></span> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <div class="card card-h-100">
                                <div class="card-body d-flex align-items-center justify-content-around">
                                    <div
                                        class="h-48px w-50px position-relative d-flex justify-content-center align-items-center text-primary fs-4 rounded-3 shadow-lg border">
                                        <i class="bi bi-arrow-up-circle text-info"></i>
                                    </div>
                                    <div>
                                        <h3>{{ $outgoingChats }}</h3>
                                        <span class="fs-5">Outgoing Chat</span>
                                        <p class="fs-12 mb-0"><span class="text-success"></span> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <div class="card card-h-100">
                                <div class="card-body d-flex align-items-center justify-content-around">
                                    <div
                                        class="h-48px w-50px position-relative d-flex justify-content-center align-items-center text-primary fs-4 rounded-3 shadow-lg border">
                                        <i class="bi bi-chat-left-dots-fill text-danger"></i>
                                    </div>
                                    <div>
                                        <h3>{{ $unreadChats }} </h3>
                                        <span class="fs-5">Unread Chat</span>
                                        <p class="fs-12 mb-0"><span class="text-success"></span> </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row text-center">

                                <div class="col-md-3">
                                    <h4 class="fw-bold text-primary">
                                        {{ number_format($totalLeads) }}
                                    </h4>
                                    <small class="text-muted">
                                        Total Leads
                                    </small>
                                </div>

                                <div class="col-md-3">
                                    <h4 class="fw-bold text-success">
                                        {{ number_format($activeCustomers) }}
                                    </h4>
                                    <small class="text-muted">
                                        Active Customers
                                    </small>
                                </div>

                                <div class="col-md-3">
                                    <h4 class="fw-bold text-info">
                                        {{ number_format($todayChats) }}
                                    </h4>
                                    <small class="text-muted">
                                        Chats Today
                                    </small>
                                </div>

                                <div class="col-md-3">
                                    <h4 class="fw-bold text-warning">
                                        {{ $conversionRate }}%
                                    </h4>
                                    <small class="text-muted">
                                        Conversion Rate
                                    </small>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Recent Chats</h4>

                        </div>
                        <div class="card-body">
                            <livewire:RecentChats />
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Leads By Branch</h4>

                            <a href="{{ url('lead') }}" class="btn btn-sm btn-light">
                                View All
                            </a>

                        </div>
                        <div class="card-body">
                            <livewire:LeadsByBranch />
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Recent Presentation</h4>

                            <a href="{{ url('presentation') }}" class="btn btn-sm btn-light">
                                View All
                            </a>

                        </div>
                        <div class="card-body">
                            <livewire:Presentation />
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Recent Events</h4>
                            {{-- <p style="float: right;"><a href="{{ url('event') }}">See Detail..</a></p> --}}
                            <a href="{{ url('event') }}" class="btn btn-sm btn-light">
                                View All
                            </a>

                        </div>
                        <div class="card-body">
                            <livewire:RecentEvent />
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Chat Activity</h4>
                            <div class="d-flex align-items-center">

                            </div>
                        </div>
                        <div class="card-body">

                            <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="pills-home-tab"
                                tabindex="0" id="average-line" class="apexcharts-container"></div>

                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Lead Conversion</h4>
                            <div class="d-flex align-items-center">

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-pane fade show active" id="average-bar" role="tabpanel"
                                aria-labelledby="average-bar-tab" tabindex="0"></div>
                        </div>
                    </div>
                </div>


                <div class="col-xxl-4 col-lg-6">
                    <div class="card h-100">

                        <div class="card-header">
                            <div>
                                <h4>Broadcast Performance</h4>
                                <p class="mb-0 text-muted">
                                    Track Broadcast Delivery Status
                                </p>
                            </div>
                        </div>

                        <div class="card-body">

                            {{-- Bubble Stats --}}
                            <div class="bubble-container">

                                <div class="bubble bubble1">
                                    {{ number_format($broadcastSent) }}
                                    <small>Sent</small>
                                </div>

                                <div class="bubble bubble2">
                                    {{ number_format($broadcastDelivered) }}
                                    <small>Delivered</small>
                                </div>

                                <div class="bubble bubble3">
                                    {{ number_format($broadcastRead) }}
                                    <small>Read</small>
                                </div>

                                <div class="bubble bubble4">
                                    {{ number_format($broadcastFailed) }}
                                    <small>Failed</small>
                                </div>

                            </div>

                            {{-- Sent --}}
                            <div class="d-flex align-items-center gap-3 mb-4">

                                <div class="icon-box bg-primary-subtle text-primary rounded-circle">
                                    <i class="bi bi-send"></i>
                                </div>

                                <div class="w-100">

                                    <div class="d-flex justify-content-between align-items-center fs-13">
                                        <p class="text-muted mb-1">
                                            Sent
                                        </p>

                                        <span>
                                            {{ $sentPercent }}%
                                        </span>
                                    </div>

                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary" style="width: {{ $sentPercent }}%">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- Delivered --}}
                            <div class="d-flex align-items-center gap-3 mb-4">

                                <div class="icon-box bg-success-subtle text-success rounded-circle">
                                    <i class="bi bi-check2-circle"></i>
                                </div>

                                <div class="w-100">

                                    <div class="d-flex justify-content-between align-items-center fs-13">
                                        <p class="text-muted mb-1">
                                            Delivered
                                        </p>

                                        <span>
                                            {{ $deliveredPercent }}%
                                        </span>
                                    </div>

                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" style="width: {{ $deliveredPercent }}%">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- Read --}}
                            <div class="d-flex align-items-center gap-3 mb-4">

                                <div class="icon-box bg-info-subtle text-info rounded-circle">
                                    <i class="bi bi-eye"></i>
                                </div>

                                <div class="w-100">

                                    <div class="d-flex justify-content-between align-items-center fs-13">
                                        <p class="text-muted mb-1">
                                            Read
                                        </p>

                                        <span>
                                            {{ $readPercent }}%
                                        </span>
                                    </div>

                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-info" style="width: {{ $readPercent }}%">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- Failed --}}
                            <div class="d-flex align-items-center gap-3">

                                <div class="icon-box bg-danger-subtle text-danger rounded-circle">
                                    <i class="bi bi-x-circle"></i>
                                </div>

                                <div class="w-100">

                                    <div class="d-flex justify-content-between align-items-center fs-13">
                                        <p class="text-muted mb-1">
                                            Failed
                                        </p>

                                        <span>
                                            {{ $failedPercent }}%
                                        </span>
                                    </div>

                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" style="width: {{ $failedPercent }}%">
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-lg-6">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header pb-4 mb-2">
                                    <h4>User Online</h4>

                                </div>
                                <div class="card-body bg-body m-4 mt-0">
                                    <livewire:UserOnline />

                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header pb-4 mb-2">
                                    <h4>Lead Status</h4>

                                </div>
                                <div class="card-body product-body bg-body m-4 mt-0">
                                    <livewire:LeadStatus />

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

        <!-- Submit Section -->
    </main>
    <style>
        :root {
            --primary: #2563eb;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
        }

        body {
            background: #f5f7fb;
        }

        .main-breadcrumb {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            border-radius: 20px;
            padding: 25px 30px;
            color: #fff;
            margin-bottom: 25px !important;
        }

        .main-breadcrumb h2 {
            color: #fff;
            font-size: 26px;
            font-weight: 700;
        }

        .card {
            border: none !important;
            border-radius: 18px !important;
            box-shadow: 0 5px 20px rgba(15, 23, 42, .06) !important;
            overflow: hidden;
            transition: .3s;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        .card-header {
            background: #fff !important;
            border-bottom: 1px solid #eef2f7 !important;
            padding: 18px 22px !important;
        }

        .card-header h4 {
            margin: 0;
            font-weight: 600;
            color: #1e293b;
        }

        .card-body {
            padding: 20px !important;
        }

        /* KPI CARD */
        .card-h-100 {
            height: 100%;
        }

        .card-h-100 .card-body {
            padding: 22px !important;
        }

        .card-h-100 h3 {
            font-size: 30px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 3px;
        }

        .card-h-100 span.fs-5 {
            font-size: 13px !important;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #64748b;
            font-weight: 600;
        }

        .card-h-100 p {
            margin-top: 5px;
            color: #94a3b8;
        }

        /* ICON */
        .card-h-100 .h-48px {
            width: 58px !important;
            height: 58px !important;
            border: none !important;
            border-radius: 16px !important;
            background: #eff6ff;
            box-shadow: none !important;
        }

        .card-h-100 .bi {
            font-size: 24px !important;
        }

        /* warna icon per card */
        .row .col-xl-3:nth-child(1) .h-48px {
            background: #dbeafe;
            color: #2563eb !important;
        }

        .row .col-xl-3:nth-child(2) .h-48px {
            background: #dcfce7;
            color: #16a34a !important;
        }

        .row .col-xl-3:nth-child(3) .h-48px {
            background: #fef3c7;
            color: #d97706 !important;
        }

        .row .col-xl-3:nth-child(4) .h-48px {
            background: #cffafe;
            color: #0891b2 !important;
        }

        .row .col-xl-3:nth-child(5) .h-48px {
            background: #ede9fe;
            color: #7c3aed !important;
        }

        .row .col-xl-3:nth-child(6) .h-48px {
            background: #dcfce7;
            color: #16a34a !important;
        }

        .row .col-xl-3:nth-child(7) .h-48px {
            background: #dbeafe;
            color: #2563eb !important;
        }

        .row .col-xl-3:nth-child(8) .h-48px {
            background: #fee2e2;
            color: #dc2626 !important;
        }

        /* View Detail */
        .card-header a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .card-header a:hover {
            color: #1d4ed8;
        }

        /* Broadcast */
        .bubble-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .bubble {
            width: 95px;
            height: 95px;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-weight: 700;
            color: #fff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
        }

        .bubble small {
            font-size: 11px;
        }

        .bubble1 {
            background: #2563eb;
        }

        .bubble2 {
            background: #10b981;
        }

        .bubble3 {
            background: #06b6d4;
        }

        .bubble4 {
            background: #ef4444;
        }

        .progress {
            height: 10px !important;
            border-radius: 20px !important;
        }

        .icon-box {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Livewire section */
        .bg-body {
            background: #fff !important;
            border-radius: 12px;
        }

        /* responsive */
        @media(max-width:768px) {

            .main-breadcrumb {
                padding: 20px;
            }

            .main-breadcrumb h2 {
                font-size: 20px;
            }

            .card-h-100 h3 {
                font-size: 24px;
            }
        }
    </style>
@endsection
