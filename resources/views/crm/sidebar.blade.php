 <aside class="pe-app-sidebar" id="sidebar">
     <div class="pe-app-sidebar-logo px-6 d-flex align-items-center position-relative">
         <!--begin::Brand Image-->
         <a href="index.html" class="d-flex align-items-end logo-main">
             <img height="45" width="45" class="logo-dark" alt="Dark Logo" src="{{ asset('images/logo_trans.png') }}">
             <img height="45" width="45" class="logo-light" alt="Light Logo"
                 src="{{ asset('images/logo_trans.png') }}">

         </a>
         <h3 class="text-body-emphasis fw-bolder mb-0 ms-1">CRM</h3>
         <button type="button" id="sidebarDefaultArrow"
             class="btn btn-sm p-0 fs-16 text-body-emphasis ms-auto float-end d-none icon-hover-btn d-none"><i
                 class="ri-arrow-right-line fs-5"></i></button>
         <!--end::Brand Image-->
     </div>
     <nav class="pe-app-sidebar-menu nav nav-pills" data-simplebar id="sidebar-simplebar">
         <div class="d-flex align-items-start flex-column w-100">
             <ul class="pe-main-menu list-unstyled">
                 <!-- Main Menu -->
                 <li class="pe-menu-title">Dashboard</li>
                 <li class="pe-slide">
                     <a href="{{ url('/') }}" class="pe-nav-link">
                         <i class="ri-dashboard-line pe-nav-icon"></i>
                         <span class="slide pe-nav-content1">Dashboards</span>

                     </a>

                 </li>

                 <!-- Pages -->
                 <li class="pe-menu-title">Main Menu</li>
                 <li class="pe-slide pe-has-sub">
                     <a href="#collapseAuth" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false"
                         aria-controls="collapseAuth">
                         <i class="ri-whatsapp-line pe-nav-icon"></i>
                         <span class="pe-nav-content">Whatsapp</span>
                         <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                     </a>
                     <ul class="pe-slide-menu collapse" id="collapseAuth">
                         <li class="slide pe-nav-content1">
                             <a href="javascript:void(0)">whatsapp</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="auth-signin.html" class="pe-nav-link">
                                 Inbox
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="auth-signup.html" class="pe-nav-link">
                                 Register
                             </a>
                         </li>

                     </ul>
                 </li>
                 <li class="pe-slide pe-has-sub">
                     <a href="#collapsePages" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false"
                         aria-controls="collapsePages">
                         <i class="ri-customer-service-2-line pe-nav-icon"></i>
                         <span class="pe-nav-content">Customers</span>
                         <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                     </a>
                     <ul class="pe-slide-menu collapse" id="collapsePages">
                         <li class="slide pe-nav-content1">
                             <a href="javascript:void(0)">Customers</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="pages-starter.html" class="pe-nav-link">
                                 Leads Data
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="pages-starter.html" class="pe-nav-link">
                                 Customer Data
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="pages-starter.html" class="pe-nav-link">
                                 Lead Source
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="pages-starter.html" class="pe-nav-link">
                                 Event Data
                             </a>
                         </li>


                     </ul>
                 </li>

                 <li class="pe-slide pe-has-sub">
                     <a href="#collapseBaseUI" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false"
                         aria-controls="collapseBaseUI">
                         <i class="ri-file-chart-line pe-nav-icon"></i>
                         <span class="pe-nav-content">Reports</span>
                         <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                     </a>
                     <ul class="pe-slide-menu collapse" id="collapseBaseUI">
                         <li class="slide pe-nav-content1">
                             <a href="javascript:void(0)">Base UI</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-accordions.html" class="pe-nav-link">Accordions</a>
                         </li>

                     </ul>
                 </li>
                 <li class="pe-slide pe-has-sub">
                     <a href="#collapseAdvancedUI" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false"
                         aria-controls="collapseAdvancedUI">
                         <i class="ri-broadcast-line pe-nav-icon"></i>
                         <span class="pe-nav-content">Broadcast</span>
                         <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                     </a>
                     <ul class="pe-slide-menu collapse" id="collapseAdvancedUI">
                         <li class="slide pe-nav-content1">
                             <a href="javascript:void(0)">Advanced UI</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-block.html" class="pe-nav-link">Block</a>
                         </li>

                     </ul>
                 </li>
                 <li class="pe-slide pe-has-sub">
                     <a href="#collapseFroms" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false"
                         aria-controls="collapseFroms">
                         <i class="ri-user-line pe-nav-icon"></i>
                         <span class="pe-nav-content">Users</span>
                         <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                     </a>
                     <ul class="pe-slide-menu collapse" id="collapseFroms">
                         <li class="slide pe-nav-content1">
                             <a href="javascript:void(0)">Users</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="{{ url('user') }}" class="pe-nav-link">
                                 Users Data
                             </a>
                         </li>


                     </ul>
                 </li>
                 <li class="pe-slide pe-has-sub">
                     <a href="#collapseTables" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false"
                         aria-controls="collapseTables">
                         <i class="ri-coupon-line pe-nav-icon"></i>
                         <span class="pe-nav-content">Ticketing</span>
                         <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                     </a>
                     <ul class="pe-slide-menu collapse" id="collapseTables">
                         <li class="slide pe-nav-content1">
                             <a href="javascript:void(0)">Tables</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-tables-basic.html" class="pe-nav-link">
                                 Basic Tables
                             </a>
                         </li>

                     </ul>
                 </li>
                 <li class="pe-slide pe-has-sub">
                     <a href="#collapseCharts" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false"
                         aria-controls="collapseCharts">
                         <i class="ri-settings-line pe-nav-icon"></i>
                         <span class="pe-nav-content">Settings</span>
                         <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                     </a>
                     <ul class="pe-slide-menu collapse" id="collapseCharts">
                         <li class="slide pe-nav-content1">
                             <a href="#">Settings</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="{{ url('company') }}" class="pe-nav-link">
                                 Company
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="{{ url('branch') }}" class="pe-nav-link">
                                 Branch
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="{{ url('position') }}" class="pe-nav-link">
                                 Positions
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="{{ url('level') }}" class="pe-nav-link">
                                 Levels
                             </a>
                         </li>

                     </ul>
                 </li>
                 <!-- Icons & Maps -->
                 <li class="pe-menu-title">Sign Out</li>

                 <li class="pe-slide pe-has-sub">
                     <a href="{{ route('logout') }}" class="pe-nav-link"
                         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                         <i class="ri-logout-circle-r-line pe-nav-icon"></i>
                         <span class="pe-nav-content">Sign out</span>
                     </a>

                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                         @csrf
                     </form>
                 </li>


             </ul>
             <!-- Widgets -->
             <div style="margin-bottom: 50px;"></div>

         </div>
     </nav>
 </aside>
