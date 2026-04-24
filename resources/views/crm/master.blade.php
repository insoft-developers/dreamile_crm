<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>CRM | Dreamile International </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta content="Admin & Dashboards Template" name="description" />
    <meta content="Pixeleyez" name="author" />

    <!-- layout setup -->
    <script type="module" src="{{ asset('template/crm') }}/assets/js/layout-setup.js"></script>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images') }}/logo_trans.png">
    <link rel="stylesheet" href="{{ asset('template/crm') }}/assets/libs/gridjs/theme/mermaid.min.css">
    <!-- Simplebar Css -->
    <link rel="stylesheet" href="{{ asset('template/crm') }}/assets/libs/simplebar/simplebar.min.css">
    <!-- Swiper Css -->
    <link href="{{ asset('template/crm') }}/assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet">
    <!-- Nouislider Css -->
    <link href="{{ asset('template/crm') }}/assets/libs/nouislider/nouislider.min.css" rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="{{ asset('template/crm') }}/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
        type="text/css">
    <!--icons css-->
    <link href="{{ asset('template/crm') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{ asset('template/crm') }}/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- Begin Header -->
        <header class="app-header" id="appHeader">
            <div class="container-fluid w-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-inline-flex align-items-center gap-2">
                        <a href="index.html" class="align-items-end logo-main d-none me-5">
                            <img height="35" width="34" class="logo-dark" alt="Dark Logo"
                                src="{{ asset('template/crm') }}/assets/images/logo-md.png">
                            <h3 class="text-body-emphasis fw-bolder mb-0 ms-1">Urbix</h3>
                        </a>
                        <button type="button" class="vertical-toggle btn header-btn" id="toggleSidebar"
                            aria-label="Toggle Sidebar">
                            <i class="bi bi-arrow-bar-left header-icon"></i>
                        </button>
                        <button type="button" class="horizontal-toggle btn header-btn d-none" id="toggleHorizontal"
                            aria-label="Toggle Menu">
                            <i class="ri-menu-2-line header-icon"></i>
                        </button>
                        <!-- Search Bar -->

                    </div>
                    <div class="flex-shrink-0 d-flex align-items-center gap-4">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="dropdown pe-dropdown-mega d-none d-md-block">
                                <button class="btn header-btn" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false" aria-label="Notifications">
                                    <i class="bi bi-bell"></i>
                                    <div class="icon-dot"></div>
                                </button>
                                <div
                                    class="dropdown-menu dropdown-mega-md header-dropdown-menu pe-noti-dropdown-menu p-0">
                                    <div class="p-3 border-bottom">
                                        <h6 class="d-flex align-items-center mb-0">Notification <span
                                                class="badge bg-success-subtle text-success ms-auto">4 Unread</span>
                                        </h6>
                                    </div>
                                    <div>
                                        <div class="noti-item">
                                            <div
                                                class="avatar-md d-flex align-items-center justify-content-center bg-success-subtle text-success fs-16">
                                                <i class="bi bi-bag-check-fill"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <a href="#!" class="text-decoration-none stretched-link">
                                                    <h6 class="mb-1 fw-semibold">Item Back in Stock</h6>
                                                </a>
                                                <p class="text-muted mb-2 fs-12 mb-2">Today, 02:45 PM</p>
                                                <div class="p-2 bg-body-tertiary bg-opacity-50 rounded">
                                                    <p class="mb-0 lh-base fs-13">Good news! The item you wanted is back
                                                        in stock. Grab it before it’s gone again!</p>
                                                </div>
                                            </div>
                                            <a href="#!"
                                                class="position-absolute top-0 end-0 mt-2 me-3 fs-18 link link-danger z-1">
                                                <i class="bi bi-x"></i>
                                            </a>
                                        </div>
                                        <div class="noti-item">
                                            <img src="{{ asset('template/crm') }}/assets/images/avatar/avatar-8.jpg"
                                                alt="Avatar Iamge" class="avatar-md">
                                            <div>
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mb-1 text-muted"><strong
                                                            class="fw-semibold text-body">Donald</strong><i
                                                            class="ri-heart-3-fill text-danger ms-1"></i></h6>
                                                </a>
                                                <p class="text-muted mb-0 fs-12 mb-2">Friday, 11:29 PM</p>
                                            </div>
                                            <a href="#!"
                                                class="position-absolute top-10 end-0 fs-18 z-1 link link-danger me-3"><i
                                                    class="bi bi-x"></i></a>
                                        </div>
                                        <div class="noti-item">
                                            <div
                                                class="avatar-md d-flex align-items-center justify-content-center bg-danger-subtle text-danger fs-16">
                                                <i class="bi bi-fire"></i>
                                            </div>
                                            <div>
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mb-2">Birthday Reminder</h6>
                                                </a>
                                                <p class="text-muted mb-2 fs-12 mb-2">Tuesday, 02:45 PM</p>
                                                <div class="p-2 bg-body-tertiary bg-opacity-50 rounded">
                                                    <p class="mb-0 lh-base fs-13">Don’t forget! It’s Emily birthday
                                                        tomorrow. Send them a message!</p>
                                                </div>
                                            </div>
                                            <a href="#!"
                                                class="position-absolute top-10 end-0 fs-18 z-1 link link-danger me-3"><i
                                                    class="bi bi-x"></i></a>
                                        </div>
                                        <div class="noti-item">
                                            <img src="{{ asset('template/crm') }}/assets/images/avatar/avatar-5.jpg"
                                                alt="Avatar Image" class="avatar-md">
                                            <div>
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mb-1 text-muted"><strong
                                                            class="fw-semibold text-body">Richard</strong><i
                                                            class="bi bi-person-plus-fill text-primary fs-16 ms-1"></i>
                                                    </h6>
                                                </a>
                                                <p class="text-muted mb-0 fs-12">Monday, 07:14 AM</p>
                                            </div>
                                            <a href="#!"
                                                class="position-absolute top-10 end-0 fs-18 z-1 link link-danger me-3"><i
                                                    class="bi bi-x"></i></a>
                                        </div>
                                        <div class="noti-item">
                                            <img src="{{ asset('template/crm') }}/assets/images/avatar/avatar-4.jpg"
                                                alt="Avatar Image" class="avatar-md">
                                            <div>
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mb-2">Olivia <strong
                                                            class="fw-normal text-muted fs-13">liked your recent
                                                            post</strong></h6>
                                                </a>
                                                <p class="text-muted mb-0 fs-12">Thursday 3:20 PM</p>
                                            </div>
                                            <a href="#!"
                                                class="position-absolute top-10 end-0 fs-18 z-1 link link-danger me-3"><i
                                                    class="bi bi-x"></i></a>
                                        </div>
                                        <div class="noti-item">
                                            <img src="{{ asset('template/crm') }}/assets/images/avatar/avatar-1.jpg"
                                                alt="Avatar Image" class="avatar-md">
                                            <div>
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mb-2 text-body">Mia <strong
                                                            class="fw-normal text-muted fs-13">shared a file in
                                                            Marketing Campaign</strong></h6>
                                                </a>
                                                <p class="text-muted mb-3 fs-12">Thursday 3:20 PM</p>
                                                <div
                                                    class="d-flex align-items-center gap-2 p-2 position-relative z-1 border rounded">
                                                    <div
                                                        class="avatar-md d-flex align-items-center rounded justify-content-center flex-shrink-0 bg-danger-subtle text-danger">
                                                        <i class="bi bi-file-pdf"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <a href="#!">
                                                            <h6 class="mb-2">Campaign_Strategy.mp4</h6>
                                                        </a>
                                                        <p class="mb-0 text-muted fs-12">MP4 | 14 MB</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#!"
                                                class="position-absolute top-10 end-0 fs-18 z-1 link link-danger me-3"><i
                                                    class="bi bi-x"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="dropdown pe-dropdown-mega d-none d-md-block">
                            <button class="header-profile-btn btn gap-1 text-start" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="d-none d-xl-block pe-2">
                                    <span class="d-block mb-0 fs-12 fw-semibold">{{ Auth::user()->name }}</span>
                                    <span class="d-block mb-0 fs-10 text-muted">{{ Auth::user()->email }}</span>
                                </div>
                                <span class="header-btn btn position-relative">
                                    <img src="{{ asset('template/crm') }}/assets/images/avatar/avatar-3.jpg"
                                        alt="Avatar Image" class="img-fluid rounded-circle">
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-mega-sm header-dropdown-menu p-3">
                                <div class="border-bottom pb-2 mb-2 d-flex align-items-center gap-2">
                                    <img src="{{ asset('template/crm') }}/assets/images/avatar/avatar-3.jpg"
                                        alt="Avatar Image" class="avatar-md">
                                    <div>
                                        <a href="javascript:void(0)">
                                            <h6 class="mb-0 lh-base">{{ Auth::user()->name }}</h6>
                                        </a>
                                        <p class="mb-0 fs-13 text-muted">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                                <ul class="list-unstyled mb-1 border-bottom pb-1">
                                    <li><a class="dropdown-item" href="pages-profile.html"><i
                                                class="bi bi-person me-2"></i> View Profile</a></li>
                                    <li><a class="dropdown-item" href="pages-profile.html"><i
                                                class="bi bi-gear me-2"></i> Settings</a></li>
                        
                                </ul>
                                
                                <ul class="list-unstyled mb-0">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- END Header -->



        @include('crm.sidebar')
        <div class="sidebar-backdrop" id="sidebar-backdrop"></div>

        @yield('content')

        <div class="offcanvas offcanvas-end border-0 data-theme-colors layout-customizer" tabindex="-1"
            id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="flex-wrap align-items-center bg-primary bg-gradient p-5 offcanvas-header">
                <p class="m-0 text-white fw-semibold fs-16" id="offcanvasRightLabel">Theme Customization</p>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-0">
                <div data-simplebar class="h-100">
                    <div class="p-6">
                        <h6 class="mb-5 fw-semibold">Layout:</h6>
                        <div class="row gy-3">
                            <div class="col-6">
                                <div class="border overflow-hidden rounded-2">
                                    <input id="customizer-layout01" name="data-layout" type="radio"
                                        value="vertical" class="form-check-input" checked>
                                    <label class="form-check-label p-0 avatar-3xl w-100 rounded-2"
                                        for="customizer-layout01">
                                        <span class="d-flex h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light-subtle d-flex h-100 flex-column gap-1 p-2">
                                                    <span class="d-block p-1 px-2 bg-light rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light-subtle d-block p-1"></span>
                                                    <span
                                                        class="d-block h-100 bg-primary-subtle m-3 rounded-2 rounded-2"></span>
                                                    <span class="bg-light-subtle d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Vertical</h5>
                            </div>
                            <div class="col-6">
                                <div class="border overflow-hidden rounded-2">
                                    <input id="customizer-layout02" name="data-layout" type="radio"
                                        value="horizontal" class="form-check-input">
                                    <label class="form-check-label p-0 avatar-3xl w-100 rounded-2"
                                        for="customizer-layout02">
                                        <span class="d-flex h-100 flex-column">
                                            <span class="bg-light-subtle d-flex py-1 px-3 gap-1 align-items-center">
                                                <span class="d-block p-1 bg-light rounded me-1"></span>
                                                <span class="d-block p-1 pb-0 px-2 bg-light ms-auto"></span>
                                                <span class="d-block p-1 pb-0 px-2 bg-light"></span>
                                            </span>
                                            <span
                                                class="bg-light-subtle d-flex gap-1 pt-1 pb-4 px-3 border-primary-subtle border-top">
                                                <span class="d-block p-1 pb-0 px-2 bg-light"></span>
                                                <span class="d-block p-1 pb-0 px-2 bg-light"></span>
                                                <span class="d-block p-1 pb-0 px-2 bg-light"></span>
                                            </span>
                                            <span class="d-block h-100 bg-primary-subtle mx-3 mb-2 mt-n3 rounded-2">
                                            </span>
                                            <span class="bg-light-subtle d-block p-1 mt-auto"></span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Horizontal</h5>
                            </div>
                            <div class="col-6">
                                <div class="border overflow-hidden rounded-2">
                                    <input id="customizer-layout03" name="data-layout" type="radio"
                                        value="semibox" class="form-check-input">
                                    <label class="form-check-label p-0 avatar-3xl w-100 rounded-2"
                                        for="customizer-layout03">
                                        <span class="d-flex gap-1 h-100 p-1">
                                            <span class="flex-shrink-0 mb-3">
                                                <span class="d-block p-1 px-1 bg-light rounded mb-1 mx-1"></span>
                                                <span class="bg-light-subtle d-flex h-100 flex-column gap-1 p-2">
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light-subtle d-block p-1"></span>
                                                    <span class="d-block h-100 bg-primary-subtle my-2 mx-1 rounded-2">
                                                    </span>
                                                    <span class="bg-light-subtle d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Semi Box</h5>
                            </div>
                            <!-- end col -->
                        </div>

                        <h6 class="my-5 fw-semibold">Content Width:</h6>

                        <div class="row gy-3">
                            <div class="col-6">
                                <div class="border overflow-hidden rounded-2">
                                    <input id="defaultContent" name="data-content-width" type="radio"
                                        value="default" class="form-check-input" checked>
                                    <label class="form-check-label p-0 avatar-3xl w-100 rounded-2"
                                        for="defaultContent">
                                        <span class="d-flex h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light-subtle d-flex h-100 flex-column gap-1 p-2">
                                                    <span class="d-block p-1 px-2 bg-light rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light-subtle d-block p-1"></span>
                                                    <span class="d-block h-100 bg-primary-subtle m-3 rounded-2">
                                                    </span>
                                                    <span class="bg-light-subtle d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Default</h5>
                            </div>
                            <div class="col-6">
                                <div class="border overflow-hidden rounded-2">
                                    <input id="boxLayout" name="data-content-width" type="radio" value="box"
                                        class="form-check-input">
                                    <label class="form-check-label p-0 avatar-3xl w-100 rounded-2" for="boxLayout">
                                        <span class="d-flex h-100 px-3">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light-subtle d-flex h-100 flex-column gap-1 p-2">
                                                    <span class="d-block p-1 px-2 bg-light rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light-subtle d-block p-1"></span>
                                                    <span class="d-block h-100 bg-primary-subtle m-2 rounded-2">
                                                    </span>
                                                    <span class="bg-light-subtle d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Box</h5>
                            </div>
                            <!-- end col -->
                        </div>

                        <h6 class="my-5 fw-semibold">Layout Direction:</h6>

                        <div class="row gy-3">
                            <div class="col-6">
                                <div class="border overflow-hidden rounded-2">
                                    <input id="ltrMode" name="dir" type="radio" value="ltr"
                                        class="form-check-input" checked>
                                    <label class="form-check-label p-0 avatar-3xl w-100 rounded-2" for="ltrMode">
                                        <span class="d-flex h-100">
                                            <span class="flex-shrink-0 order-1">
                                                <span class="bg-light-subtle d-flex h-100 flex-column gap-1 p-2">
                                                    <span class="d-block p-1 px-2 bg-light rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light-subtle d-block p-1"></span>
                                                    <span class="d-block h-100 bg-primary-subtle m-3 rounded-2">
                                                    </span>
                                                    <span class="bg-light-subtle d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">LTR</h5>
                            </div>
                            <div class="col-6">
                                <div class="border overflow-hidden rounded-2">
                                    <input id="rtlMode" name="dir" type="radio" value="rtl"
                                        class="form-check-input">
                                    <label class="form-check-label p-0 avatar-3xl w-100 rounded-2" for="rtlMode">
                                        <span class="d-flex h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light-subtle d-flex h-100 flex-column gap-1 p-2">
                                                    <span class="d-block p-1 px-2 bg-light rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light-subtle d-block p-1"></span>
                                                    <span class="d-block h-100 bg-primary-subtle m-3 rounded-2">
                                                    </span>
                                                    <span class="bg-light-subtle d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">RTL</h5>
                            </div>
                            <!-- end col -->
                        </div>

                        <h6 class="my-5 fw-semibold">Layout Mode:</h6>

                        <div class="row gy-3">
                            <div class="col-6">
                                <div>
                                    <input id="layout-light" name="data-bs-theme" type="radio" value="light"
                                        class="form-check-input" checked>
                                    <label class="form-check-label p-0 avatar-3xl w-100 rounded-2" for="layout-light">
                                        <span class="d-flex h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light-subtle d-flex h-100 flex-column gap-1 p-2">
                                                    <span class="d-block p-1 px-2 bg-light rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light-subtle d-block p-1"></span>
                                                    <span class="d-block h-100 bg-primary-subtle m-3 rounded-2">
                                                    </span>
                                                    <span class="bg-light-subtle d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Light</h5>
                            </div>
                            <div class="col-6">
                                <div class="border overflow-hidden rounded-2">
                                    <input id="layout-dark" name="data-bs-theme" type="radio" value="dark"
                                        class="form-check-input">
                                    <label class="form-check-label p-0 avatar-3xl w-100 rounded-2 bg-dark"
                                        for="layout-dark">
                                        <span class="d-flex h-100">
                                            <span class="flex-shrink-0">
                                                <span
                                                    class="bg-white bg-opacity-10 d-flex h-100 flex-column gap-1 p-2">
                                                    <span
                                                        class="d-block p-1 px-2 bg-white bg-opacity-10 rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-white bg-opacity-10 d-block p-1"></span>
                                                    <span class="d-block h-100 bg-light bg-opacity-10 m-3 rounded-2">
                                                    </span>
                                                    <span class="bg-white bg-opacity-10 d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Dark</h5>
                            </div>
                            <div class="col-6">
                                <div class="border overflow-hidden rounded-2">
                                    <input id="automode" name="data-bs-theme" type="radio" value="auto"
                                        class="form-check-input">
                                    <label class="form-check-label p-0 avatar-3xl w-100 rounded-2" for="automode">
                                        <span class="d-flex h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light-subtle d-flex h-100 flex-column gap-1 p-2">
                                                    <span class="d-block p-1 px-2 bg-light rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light-subtle d-block p-1"></span>
                                                    <span class="d-block h-100 bg-primary-subtle m-3 rounded-2">
                                                    </span>
                                                    <span class="bg-light-subtle d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">System</h5>
                            </div>
                            <!-- end col -->
                        </div>

                        <h6 class="my-5 fw-semibold">Sidebar Size:</h6>

                        <div class="row gy-3">
                            <div class="col-6">
                                <div class="border overflow-hidden rounded-2">
                                    <input id="sidebar-default" name="data-sidebar" type="radio" value="default"
                                        class="form-check-input" checked>
                                    <label class="form-check-label p-0 avatar-3xl w-100 rounded-2"
                                        for="sidebar-default">
                                        <span class="d-flex h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light-subtle d-flex h-100 flex-column gap-1 p-2">
                                                    <span class="d-block p-1 px-2 bg-light rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light-subtle d-block p-1"></span>
                                                    <span class="d-block h-100 bg-primary-subtle m-3 rounded-2">
                                                    </span>
                                                    <span class="bg-light-subtle d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Default</h5>
                            </div>
                            <div class="col-6">
                                <div class="border overflow-hidden rounded-2">
                                    <input id="sidebar-medium" name="data-sidebar" type="radio" value="medium"
                                        class="form-check-input" checked>
                                    <label class="form-check-label p-0 avatar-3xl w-100 rounded-2"
                                        for="sidebar-medium">
                                        <span class="d-flex h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light-subtle d-flex h-100 flex-column gap-1 p-2">
                                                    <span class="d-block p-1 bg-light rounded mb-2"></span>
                                                    <span class="d-block p-1 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 pb-0 bg-light"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light-subtle d-block p-1"></span>
                                                    <span class="d-block h-100 bg-primary-subtle m-3 rounded-2">
                                                    </span>
                                                    <span class="bg-light-subtle d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Medium</h5>
                            </div>
                            <div class="col-6">
                                <div class="border overflow-hidden rounded-2">
                                    <input id="sidebar-icon" name="data-sidebar" type="radio" value="icon"
                                        class="form-check-input">
                                    <label class="form-check-label p-0 avatar-3xl w-100 rounded-2" for="sidebar-icon">
                                        <span class="d-flex h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light-subtle d-flex h-100 flex-column gap-1 p-1">
                                                    <span class="d-block p-1 bg-light rounded mb-2"></span>
                                                    <span class="d-block p-1 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 pb-0 bg-light"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light-subtle d-block p-1"></span>
                                                    <span class="d-block h-100 bg-primary-subtle m-3 rounded-2">
                                                    </span>
                                                    <span class="bg-light-subtle d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Icon</h5>
                            </div>
                            <div class="col-6">
                                <div class="border overflow-hidden rounded-2">
                                    <input id="sidebar-icon-hover" name="data-sidebar" type="radio"
                                        value="icon-hover" class="form-check-input">
                                    <label class="form-check-label p-0 avatar-3xl w-100 rounded-2"
                                        for="sidebar-icon-hover">
                                        <span class="d-flex h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light-subtle d-flex h-100 flex-column gap-1 p-1">
                                                    <span class="d-block p-1 bg-light rounded mb-2"></span>
                                                    <span class="d-block p-1 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 pb-0 bg-light"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light-subtle d-block p-1"></span>
                                                    <span class="d-block h-100 bg-primary-subtle m-3 rounded-2">
                                                    </span>
                                                    <span class="bg-light-subtle d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Icon hover</h5>
                            </div>
                            <!-- end col -->
                        </div>

                        <h6 class="my-5 fw-semibold">Sidebar Color:</h6>

                        <div class="row gy-3">
                            <div class="col-6">
                                <div class="border overflow-hidden rounded-2">
                                    <input id="sidebar-light" name="data-sidebar-color" type="radio"
                                        value="light" class="form-check-input" checked>
                                    <label class="form-check-label p-0 avatar-3xl w-100 rounded-2"
                                        for="sidebar-light">
                                        <span class="d-flex h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light-subtle d-flex h-100 flex-column gap-1 p-2">
                                                    <span class="d-block p-1 px-2 bg-light rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-light"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light-subtle d-block p-1"></span>
                                                    <span class="d-block h-100 bg-primary-subtle m-3 rounded-2">
                                                    </span>
                                                    <span class="bg-light-subtle d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Light</h5>
                            </div>
                            <div class="col-6">
                                <div class="border overflow-hidden rounded-2">
                                    <input id="sidebar-dark" name="data-sidebar-color" type="radio" value="dark"
                                        class="form-check-input">
                                    <label class="form-check-label p-0 avatar-3xl w-100 rounded-2" for="sidebar-dark">
                                        <span class="d-flex h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-primary d-flex h-100 flex-column gap-1 p-2">
                                                    <span
                                                        class="d-block p-1 px-2 bg-light-subtle opacity-25 rounded mb-2"></span>
                                                    <span
                                                        class="d-block p-1 px-2 pb-0 bg-light-subtle opacity-25"></span>
                                                    <span
                                                        class="d-block p-1 px-2 pb-0 bg-light-subtle opacity-25"></span>
                                                    <span
                                                        class="d-block p-1 px-2 pb-0 bg-light-subtle opacity-25"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light-subtle d-block p-1"></span>
                                                    <span class="d-block h-100 bg-primary-subtle m-3 rounded-2">
                                                    </span>
                                                    <span class="bg-light-subtle d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Dark</h5>
                            </div>
                            <!-- end col -->
                        </div>
                        <div id="sidebar-color" class="my-5">
                            <h6 class="mb-0 fw-semibold">Primary Color</h6>
                            <p class="text-muted">Choose a color of Primary.</p>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-theme-colors"
                                        id="themeColor-01" value="default" checked>
                                    <label class="form-check-label avatar-md rounded" for="themeColor-01"></label>
                                </div>
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-theme-colors"
                                        id="themeColor-02" value="cyan">
                                    <label class="form-check-label avatar-md rounded" for="themeColor-02"></label>
                                </div>
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-theme-colors"
                                        id="themeColor-03" value="blue">
                                    <label class="form-check-label avatar-md rounded" for="themeColor-03"></label>
                                </div>
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-theme-colors"
                                        id="themeColor-04" value="purple">
                                    <label class="form-check-label avatar-md rounded" for="themeColor-04"></label>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-end gap-2 modal-footer pt-6 border-top">
                            <button type="button" class="btn btn-light" id="resetBtn">
                                <i class="ri-reset-right-line"></i> Reset Layouts
                            </button>
                            <button type="button" class="btn btn-danger">
                                <i class="ri-shopping-bag-3-line"></i> Buy Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- Begin scroll top -->
        <div class="progress-wrap d-flex align-items-center justify-content-center cursor-pointer h-40px w-40px position-fixed"
            id="progress-scroll">
            <svg class="progress-circle w-100 h-100 position-absolute" viewBox="0 0 100 100">
                <circle cx="50" cy="50" r="45" class="progress" />
            </svg>
            <i class="ri-arrow-up-line fs-16 z-1 position-relative text-primary"></i>
        </div>
        <!-- END scroll top --> <!-- Begin Footer -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    <script>
                        document.write(new Date().getFullYear())
                    </script> © Dreamile International.
                    <div class="text-sm-end d-none d-sm-block">
                        
                    </div>
                </div>
            </div>
        </footer>
        <!-- END Footer -->
    </div>
    <!-- END page -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('template/crm') }}/assets/libs/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('template/crm') }}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('template/crm') }}/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ asset('template/crm') }}/assets/js/scroll-top.init.js"></script>
    <script src="{{ asset('template/crm') }}/assets/libs/gridjs/gridjs.umd.js" type="text/javascript"></script>

    <script src="{{ asset('template/crm') }}/assets/libs/apexcharts/apexcharts.min.js"></script>
    <!-- File js -->
    <script src="{{ asset('template/crm') }}/assets/js/dashboard/e-commerce.init.js"></script>
    <!-- App js -->
    <script type="module" src="{{ asset('template/crm') }}/assets/js/app.js"></script>

</body>

</html>
