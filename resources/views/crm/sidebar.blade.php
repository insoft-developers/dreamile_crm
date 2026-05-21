@php

    $whatsappMenu = request()->is('chat');

    $customerMenu =
        request()->is('lead') || request()->is('customer') || request()->is('lead_source') || request()->is('event');

    $broadcastMenu =
        request()->is('broadcast') || request()->is('contact_group') || request()->is('broadcast_template');

    $settingMenu = request()->is('company') || request()->is('branch') || request()->is('level');

    $userMenu = request()->is('user');

    $reportMenu =
        request()->is('lead_report') ||
        request()->is('chat_report') ||
        request()->is('broadcast_report') ||
        request()->is('followup_report') ||
        request()->is('conversion_report') ||
        request()->is('admin_performance_report');

@endphp

<aside class="pe-app-sidebar" id="sidebar">

    <div class="pe-app-sidebar-logo px-6 d-flex align-items-center position-relative">

        <a href="{{ url('/') }}" class="d-flex align-items-end logo-main">
            <img height="45" width="45" class="logo-dark" alt="Dark Logo" src="{{ asset('images/logo_trans.png') }}">

            <img height="45" width="45" class="logo-light" alt="Light Logo"
                src="{{ asset('images/logo_trans.png') }}">
        </a>

        <h3 class="text-body-emphasis fw-bolder mb-0 ms-1">
            {{ $view == 'inbox' ? '' : 'CRM' }}
        </h3>

    </div>

    <nav class="pe-app-sidebar-menu nav nav-pills" data-simplebar id="sidebar-simplebar">

        <div class="d-flex align-items-start flex-column w-100">

            <ul class="pe-main-menu list-unstyled">

                <!-- Dashboard -->
                <li class="pe-menu-title">Dashboard</li>

                <li class="pe-slide pe-has-sub">
                    <a href="{{ url('/') }}" class="pe-nav-link {{ request()->is('/') ? 'active' : '' }}">

                        <i class="ri-dashboard-line pe-nav-icon"></i>

                        <span class="pe-nav-content">
                            Dashboards
                        </span>
                    </a>
                </li>

                <!-- Main Menu -->
                <li class="pe-menu-title">Main Menu</li>

                <!-- Whatsapp -->
                <li class="pe-slide pe-has-sub">

                    <a href="#collapseAuth" class="pe-nav-link {{ $whatsappMenu ? 'active' : '' }}"
                        data-bs-toggle="collapse">

                        <i class="ri-whatsapp-line pe-nav-icon"></i>

                        <span class="pe-nav-content">
                            Whatsapp
                        </span>

                        <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                    </a>

                    <ul class="pe-slide-menu collapse {{ $whatsappMenu ? 'show' : '' }}" id="collapseAuth">

                        <li class="slide pe-nav-content1">
                            <a href="javascript:void(0)">
                                Whatsapp
                            </a>
                        </li>

                        <li class="pe-slide-item">
                            <a href="{{ url('chat') }}"
                                class="pe-nav-link {{ request()->is('chat') ? 'active' : '' }}">

                                Inbox
                            </a>
                        </li>

                    </ul>

                </li>

                <!-- Customers -->
                <li class="pe-slide pe-has-sub">

                    <a href="#collapsePages" class="pe-nav-link {{ $customerMenu ? 'active' : '' }}"
                        data-bs-toggle="collapse">

                        <i class="ri-customer-service-2-line pe-nav-icon"></i>

                        <span class="pe-nav-content">
                            Customers
                        </span>

                        <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                    </a>

                    <ul class="pe-slide-menu collapse {{ $customerMenu ? 'show' : '' }}" id="collapsePages">

                        <li class="slide pe-nav-content1">
                            <a href="javascript:void(0)">
                                Customers
                            </a>
                        </li>

                        <li class="pe-slide-item">
                            <a href="{{ url('lead') }}"
                                class="pe-nav-link {{ request()->is('lead') ? 'active' : '' }}">

                                Leads Data
                            </a>
                        </li>

                        <li class="pe-slide-item">
                            <a href="{{ url('customer') }}"
                                class="pe-nav-link {{ request()->is('customer') ? 'active' : '' }}">

                                Customer Data
                            </a>
                        </li>

                        <li class="pe-slide-item">
                            <a href="{{ url('lead_source') }}"
                                class="pe-nav-link {{ request()->is('lead_source') ? 'active' : '' }}">

                                Lead Source
                            </a>
                        </li>

                        <li class="pe-slide-item">
                            <a href="{{ url('event') }}"
                                class="pe-nav-link {{ request()->is('event') ? 'active' : '' }}">

                                Event Data
                            </a>
                        </li>

                    </ul>

                </li>

                

                <!-- Broadcast -->
                <li class="pe-slide pe-has-sub">

                    <a href="#collapseAdvancedUI" class="pe-nav-link {{ $broadcastMenu ? 'active' : '' }}"
                        data-bs-toggle="collapse">

                        <i class="ri-broadcast-line pe-nav-icon"></i>

                        <span class="pe-nav-content">
                            Broadcast
                        </span>

                        <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                    </a>

                    <ul class="pe-slide-menu collapse {{ $broadcastMenu ? 'show' : '' }}" id="collapseAdvancedUI">

                        <li class="slide pe-nav-content1">
                            <a href="javascript:void(0)">
                                Broadcast
                            </a>
                        </li>

                        <li class="pe-slide-item">
                            <a href="{{ url('broadcast') }}"
                                class="pe-nav-link {{ request()->is('broadcast') ? 'active' : '' }}">

                                Broadcast
                            </a>
                        </li>

                        <li class="pe-slide-item">
                            <a href="{{ url('contact_group') }}"
                                class="pe-nav-link {{ request()->is('contact_group') ? 'active' : '' }}">

                                Contact Group
                            </a>
                        </li>

                        <li class="pe-slide-item">
                            <a href="{{ url('broadcast_template') }}"
                                class="pe-nav-link {{ request()->is('broadcast_template') ? 'active' : '' }}">

                                Template
                            </a>
                        </li>

                    </ul>

                </li>

                <!-- Reports -->
                <li class="pe-slide pe-has-sub">

                    <a href="#collapseBaseUI" class="pe-nav-link" data-bs-toggle="collapse">

                        <i class="ri-file-chart-line pe-nav-icon"></i>

                        <span class="pe-nav-content">
                            Reports
                        </span>

                        <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                    </a>

                    <ul class="pe-slide-menu collapse {{ $reportMenu ? 'show' : '' }}" id="collapseBaseUI">

                        <li class="slide pe-nav-content1">
                            <a href="javascript:void(0)">
                                Reports
                            </a>
                        </li>
                        <li class="pe-slide-item">
                            <a href="{{ url('lead_report') }}"
                                class="pe-nav-link {{ request()->is('lead_report') ? 'active' : '' }}">
                                Lead Report
                            </a>
                        </li>
                        <li class="pe-slide-item">
                            <a href="{{ url('chat_report') }}"
                                class="pe-nav-link {{ request()->is('chat_report') ? 'active' : '' }}">
                                Chat Report
                            </a>
                        </li>
                        <li class="pe-slide-item">
                            <a href="{{ url('broadcast_report') }}"
                                class="pe-nav-link {{ request()->is('broadcast_report') ? 'active' : '' }}">
                                Broadcast Report
                            </a>
                        </li>
                        <li class="pe-slide-item">
                            <a href="{{ url('followup_report') }}"
                                class="pe-nav-link {{ request()->is('followup_report') ? 'active' : '' }}">
                                Followup Report
                            </a>
                        </li>
                        <li class="pe-slide-item">
                            <a href="{{ url('conversion_report') }}"
                                class="pe-nav-link {{ request()->is('conversion_report') ? 'active' : '' }}">
                                Conversion Report
                            </a>
                        </li>
                        <li class="pe-slide-item">
                            <a href="{{ url('admin_performance_report') }}"
                                class="pe-nav-link {{ request()->is('admin_performance_report') ? 'active' : '' }}">
                                Admin Performance Report
                            </a>
                        </li>

                    </ul>

                </li>

                <!-- Users -->
                <li class="pe-slide pe-has-sub">

                    <a href="#collapseFroms" class="pe-nav-link {{ $userMenu ? 'active' : '' }}"
                        data-bs-toggle="collapse">

                        <i class="ri-user-line pe-nav-icon"></i>

                        <span class="pe-nav-content">
                            Users
                        </span>

                        <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                    </a>

                    <ul class="pe-slide-menu collapse {{ $userMenu ? 'show' : '' }}" id="collapseFroms">

                        <li class="slide pe-nav-content1">
                            <a href="javascript:void(0)">
                                Users
                            </a>
                        </li>

                        <li class="pe-slide-item">
                            <a href="{{ url('user') }}"
                                class="pe-nav-link {{ request()->is('user') ? 'active' : '' }}">

                                Users Data
                            </a>
                        </li>

                    </ul>

                </li>

                <!-- Settings -->
                <li class="pe-slide pe-has-sub">

                    <a href="#collapseCharts" class="pe-nav-link {{ $settingMenu ? 'active' : '' }}"
                        data-bs-toggle="collapse">

                        <i class="ri-settings-line pe-nav-icon"></i>

                        <span class="pe-nav-content">
                            Settings
                        </span>

                        <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                    </a>

                    <ul class="pe-slide-menu collapse {{ $settingMenu ? 'show' : '' }}" id="collapseCharts">

                        <li class="slide pe-nav-content1">
                            <a href="#">
                                Settings
                            </a>
                        </li>

                        <li class="pe-slide-item">
                            <a href="{{ url('company') }}"
                                class="pe-nav-link {{ request()->is('company') ? 'active' : '' }}">

                                Company
                            </a>
                        </li>

                        <li class="pe-slide-item">
                            <a href="{{ url('branch') }}"
                                class="pe-nav-link {{ request()->is('branch') ? 'active' : '' }}">

                                Branch
                            </a>
                        </li>

                        <li class="pe-slide-item">
                            <a href="{{ url('level') }}"
                                class="pe-nav-link {{ request()->is('level') ? 'active' : '' }}">

                                Levels
                            </a>
                        </li>

                    </ul>

                </li>

                <!-- Logout -->
                <li class="pe-menu-title">
                    Sign Out
                </li>

                <li class="pe-slide pe-has-sub">

                    <a href="{{ route('logout') }}" class="pe-nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                        <i class="ri-logout-circle-r-line pe-nav-icon"></i>

                        <span class="pe-nav-content">
                            Sign out
                        </span>

                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">

                        @csrf
                    </form>

                </li>

            </ul>

            <div style="margin-bottom:50px;"></div>

        </div>

    </nav>

</aside>
