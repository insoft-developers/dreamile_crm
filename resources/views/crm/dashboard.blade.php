@extends('crm.master')
@section('content')
    <main class="app-wrapper">
        <div class="container-fluid">

            <div class="main-breadcrumb d-flex align-items-center my-3 position-relative">
                <h2 class="breadcrumb-title mb-0 flex-grow-1 fs-14">Dreamile International CRM Dashboard</h2>

            </div>
            <div class="row">
                <div class="col-xxl-8">
                    <div class="row h-100">
                        <div class="col-xl-3 col-sm-6">
                            <div class="card card-h-100">
                                <div class="card-body d-flex align-items-center justify-content-around">
                                    <div
                                        class="h-48px w-50px position-relative d-flex justify-content-center align-items-center text-primary fs-4 rounded-3 shadow-lg border">
                                        <i class="bi bi-folder2-open"></i>
                                    </div>
                                    <div>
                                        <h3>{{ number_format($totalLeads) }} </h3>
                                        <span class="fs-5">Total Leads</span>
                                        <p class="fs-12 mb-0">+{{ $newLeadsToday }} today</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <div class="card card-h-100">
                                <div class="card-body d-flex align-items-center justify-content-around">
                                    <div
                                        class="h-48px w-50px position-relative d-flex justify-content-center align-items-center text-primary fs-4 rounded-3 shadow-lg border">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div>
                                        <h3>{{ number_format($activeCustomers) }} </h3>
                                        <span class="fs-5">Active Customers</span>
                                        <p class="fs-12 mb-0"><span
                                                class="text-success">+{{ $newCustomersThisMonth }}</span> Customer This
                                            Month</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6">
                            <div class="card card-h-100">
                                <div class="card-body d-flex align-items-center justify-content-around">
                                    <div
                                        class="h-48px w-50px position-relative d-flex justify-content-center align-items-center text-primary fs-4 rounded-3 shadow-lg border">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div>
                                        <h3>{{ $conversionRate }}% </h3>
                                        <span class="fs-5">Conversion Rate</span>
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
                                        <i class="bi bi-chat-dots text-primary"></i>
                                    </div>
                                    <div>
                                        <h3>{{ $todayChats }}</h3>
                                        <span class="fs-5">Chat Today</span>
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Recent Chats</h4>
                            
                        </div>
                        <div class="card-body">
                            <livewire:RecentChats/>
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


                {{-- <div class="col-xxl-4">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h4>Product Statistics</h4>
                                <p class="mb-0 text-muted">Track your product sales</p>
                            </div>
                            <a href="javascript:void(0)" class="link">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="position-relative">
                                <div id="product-statistics"></div>
                                <div class="product-chart text-center">
                                    <h3>9,829</h3>
                                    <p class="mb-0">Product Sales</p>
                                    <span class="badge bg-success py-1 rounded-pill">+5.34%</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <i class="ri-ram-line fs-5 me-3"></i>
                                    Electronic
                                </div>
                                <div>
                                    <span class="text-muted me-3">2,482</span>
                                    <span class="badge bg-primary-subtle text-primary px-2 rounded-3">+5.34%</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <i class="bi bi-controller fs-5 me-3"></i>
                                    Games
                                </div>
                                <div>
                                    <span class="text-muted me-3">1,828</span>
                                    <span class="badge bg-warning-subtle text-warning px-2 rounded-3">+5.34%</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="bi bi-lamp fs-5 me-3"></i>
                                    Furniture
                                </div>
                                <div>
                                    <span class="text-muted me-3">1,463</span>
                                    <span class="badge bg-danger-subtle text-danger px-2 rounded-3">+5.34%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
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
                                <div class="card-body product-body bg-body m-4 mt-0">
                                    <livewire:UserOnline/>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header pb-4 mb-2">
                                    <h4>Lead Status</h4>
                                    
                                </div>
                                <div class="card-body product-body bg-body m-4 mt-0">
                                    <livewire:LeadStatus/>
                                    
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
                
            </div>

        </div>

        <!-- Submit Section -->
    </main>
@endsection
