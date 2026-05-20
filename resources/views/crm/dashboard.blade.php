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
                                        <p class="fs-12 mb-0"><span class="text-success">+{{ $newCustomersThisMonth }}</span> Customer This Month</p>
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
                {{-- <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Latest Order</h4>
                            <div class="d-flex gap-3 align-items-center">
                                <div class="form-icon">
                                    <input type="text" class="form-control form-control-icon" id="firstNameLayout4"
                                        placeholder="Search Here ..." required>
                                    <i class="ri-search-2-line text-muted"></i>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Weekly
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-start">
                                        <a class="dropdown-item" href="javascript:void(0)">Weekly</a>
                                        <a class="dropdown-item" href="javascript:void(0)">In Transit</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Delivered</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Pending</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Delayed</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Canceled</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-box table-responsive">
                                <table class="table table-hover text-nowrap">
                                    <thead class="table-light border-0">
                                        <tr>
                                            <th>Customer ID</th>
                                            <th>Email</th>
                                            <th>Product</th>
                                            <th>Status</th>
                                            <th>Tracking</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="flexCheckDefault"
                                                        id="flexCheckDefault">
                                                    <img src="{{ asset('template/crm') }}/assets/images/avatar/avatar-1.jpg"
                                                        class="avatar-sm rounded-2 mx-2" alt="Avatar Image">
                                                    #0051134
                                                </div>
                                            </td>
                                            <td>ela@septi.gmail.com</td>
                                            <td>MacBook Air</td>
                                            <td><span
                                                    class="badge bg-warning-subtle text-warning py-1 rounded-3 border border-warning">On
                                                    Way</span></td>
                                            <td>PQ1132G</td>
                                            <td>
                                                <div class="dropdown dropdown-menu-end">
                                                    <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="javascript:void(0)">Edit</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="javascript:void(0)">View</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="javascript:void(0)">Track</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="flexCheckDefault1" id="flexCheckDefault1" checked>
                                                    <img src="{{ asset('template/crm') }}/assets/images/avatar/avatar-2.jpg"
                                                        class="avatar-sm rounded-2 mx-2" alt="Avatar Image">
                                                    #0021598
                                                </div>
                                            </td>
                                            <td>te@shroff.gmail.com</td>
                                            <td>Magical Pen</td>
                                            <td><span
                                                    class="badge bg-primary-subtle text-primary py-1 rounded-3 border border-primary">Waiting</span>
                                            </td>
                                            <td>CF0568B</td>
                                            <td>
                                                <div class="dropdown dropdown-menu-end">
                                                    <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="javascript:void(0)">Edit</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="javascript:void(0)">View</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="javascript:void(0)">Track</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="flexCheckDefault2" id="flexCheckDefault2">
                                                    <img src="{{ asset('template/crm') }}/assets/images/avatar/avatar-3.jpg"
                                                        class="avatar-sm rounded-2 mx-2" alt="Avatar Image">
                                                    #0045976
                                                </div>
                                            </td>
                                            <td>te@shroff.gmail.com</td>
                                            <td>Secret Diary</td>
                                            <td><span
                                                    class="badge bg-danger-subtle text-danger py-1 rounded-3 border border-danger">Pending</span>
                                            </td>
                                            <td>RY4578K</td>
                                            <td>
                                                <div class="dropdown dropdown-menu-end">
                                                    <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="javascript:void(0)">Edit</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="javascript:void(0)">View</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="javascript:void(0)">Track</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="flexCheckDefault3" id="flexCheckDefault3">
                                                    <img src="{{ asset('template/crm') }}/assets/images/avatar/avatar-4.jpg"
                                                        class="avatar-sm rounded-2 mx-2" alt="Avatar Image">
                                                    #0074564
                                                </div>
                                            </td>
                                            <td>te@shroff.gmail.com</td>
                                            <td>IdeaPad Azure</td>
                                            <td><span
                                                    class="badge bg-success-subtle text-success py-1 rounded-3 border border-success">Delivered</span>
                                            </td>
                                            <td>ST9856H</td>
                                            <td>
                                                <div class="dropdown dropdown-menu-end">
                                                    <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="javascript:void(0)">Edit</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="javascript:void(0)">View</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="javascript:void(0)">Track</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="flexCheckDefault4" id="flexCheckDefault4">
                                                    <img src="{{ asset('template/crm') }}/assets/images/avatar/avatar-5.jpg"
                                                        class="avatar-sm rounded-2 mx-2" alt="Avatar Image">
                                                    #0098546
                                                </div>
                                            </td>
                                            <td>te@shroff.gmail.com</td>
                                            <td>Laxmi Electric Stove</td>
                                            <td><span
                                                    class="badge bg-success-subtle text-success py-1 rounded-3 border border-success">Delivered</span>
                                            </td>
                                            <td>KI1256G</td>
                                            <td>
                                                <div class="dropdown dropdown-menu-end">
                                                    <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="javascript:void(0)">Edit</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="javascript:void(0)">View</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="javascript:void(0)">Track</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Average Order Value</h4>
                            <div class="d-flex align-items-center">
                                <ul class="nav nav-pills me-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="average-line-tab" data-bs-toggle="pill"
                                            data-bs-target="#average-line" type="button" role="tab"
                                            aria-controls="average-line" aria-selected="true">Line</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="average-bar-tab" data-bs-toggle="pill"
                                            data-bs-target="#average-bar" type="button" role="tab"
                                            aria-controls="average-bar" aria-selected="false">Bar</button>
                                    </li>
                                </ul>
                                <div class="dropdown">
                                    <a href="javascript:void(0)" data-bs-toggle="dropdown" class="text-muted">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-start">
                                        <li><a class="dropdown-item" href="javascript:void(0)">This Week</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)">This Month</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)">This Year</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="pills-home-tab"
                                    tabindex="0" id="average-line" class="apexcharts-container"></div>
                                <div class="tab-pane fade" id="average-bar" role="tabpanel"
                                    aria-labelledby="average-bar-tab" tabindex="0"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card card-h-100">
                        <div class="card-header">
                            <h4>Recent Sales</h4>
                            <a href="javascript:void(0)" class="link">View All</a>
                        </div>
                        <div class="card-body">
                            <div id="gridjs_sort-table"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4">
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
                </div>
                <div class="col-xxl-4 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h4>Customer Growth</h4>
                                <p class="mb-0 text-muted">Track Customer per location</p>
                            </div>
                            <a href="javascript:void(0)" class="link">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="bubble-container">
                                <div class="bubble bubble1">2,489</div>
                                <div class="bubble bubble2">1,756</div>
                                <div class="bubble bubble3">285</div>
                                <div class="bubble bubble4">812</div>
                            </div>
                            <div class="d-flex align-items-center gap-4 mb-5">
                                <img src="{{ asset('template/crm') }}/assets/images/flag/us.svg" height="30"
                                    width="30" class="object-fit-cover rounded-circle">
                                <div class="w-100">
                                    <div class="d-flex justify-content-between align-items-center fs-13">
                                        <p class="text-muted mb-1">United States</p>
                                    </div>
                                    <div class="progress progress-sm"
                                        style="stroke-dasharray: 282.6, 282.6; stroke-dashoffset: 282.6;">
                                        <div class="progress-bar bg-primary" style="width: 90%"></div>
                                    </div>
                                </div>
                                <img src="{{ asset('template/crm') }}/assets/images/flag/de.svg" height="30"
                                    width="30" class="object-fit-cover rounded-circle">
                                <div class="w-100">
                                    <div class="d-flex justify-content-between align-items-center fs-13">
                                        <p class="text-muted mb-1">Andorra</p>
                                    </div>
                                    <div class="progress progress-sm"
                                        style="stroke-dasharray: 282.6, 282.6; stroke-dashoffset: 282.6;">
                                        <div class="progress-bar bg-primary" style="width: 70%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-4 mb-5">
                                <img src="{{ asset('template/crm') }}/assets/images/flag/ru.svg" height="30"
                                    width="30" class="object-fit-cover rounded-circle">
                                <div class="w-100">
                                    <div class="d-flex justify-content-between align-items-center fs-13">
                                        <p class="text-muted mb-1">French</p>
                                    </div>
                                    <div class="progress progress-sm"
                                        style="stroke-dasharray: 282.6, 282.6; stroke-dashoffset: 282.6;">
                                        <div class="progress-bar bg-primary" style="width: 70%"></div>
                                    </div>
                                </div>
                                <img src="{{ asset('template/crm') }}/assets/images/flag/cn.svg" height="30"
                                    width="30" class="object-fit-cover rounded-circle">
                                <div class="w-100">
                                    <div class="d-flex justify-content-between align-items-center fs-13">
                                        <p class="text-muted mb-1">Chinese</p>
                                    </div>
                                    <div class="progress progress-sm"
                                        style="stroke-dasharray: 282.6, 282.6; stroke-dashoffset: 282.6;">
                                        <div class="progress-bar bg-primary" style="width: 25%"></div>
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
                                    <h4>Latest Product</h4>
                                    <div class="dropdown">
                                        <a href="javascript:void(0)" data-bs-toggle="dropdown" class="text-muted"
                                            aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="javascript:void(0)">This Week</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)">This Month</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)">This Year</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body product-body bg-body m-4 mt-0">
                                    <img src="{{ asset('template/crm') }}/assets/images/dashboard/shoeses.png"
                                        class="img-fluid mx-auto d-block product-img1" alt="Product Image">
                                    <div class="m-4 mt-0 py-2 px-4 product-gradient">
                                        <div>
                                            <span class="fs-12">Shoe</span>
                                            <p class="fs-5 mb-0">Nike</p>
                                        </div>
                                        <div>
                                            <i class="bi bi-arrow-right-circle-fill fs-3"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <img src="{{ asset('template/crm') }}/assets/images/dashboard/enhanced_image.png"
                                            class="img-fluid" alt="Enhanced Image">
                                    </div>
                                    <div class="d-flex gap-3 pt-4">
                                        <a href="#!" class="btn btn-outline-primary w-50">Login / Sign Up</a>
                                        <a href="#!" class="btn btn-primary w-50">Get Started</a>
                                    </div>
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
