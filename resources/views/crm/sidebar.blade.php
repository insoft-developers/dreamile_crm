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
                             <a href="javascript:void(0)">Pages</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="pages-starter.html" class="pe-nav-link">
                                 Starter Page
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="pages-profile.html" class="pe-nav-link">
                                 Profile
                             </a>
                         </li>
                         <li class="pe-slide-item pe-has-sub">
                             <a href="#collapseBlogs" class="pe-nav-link" data-bs-toggle="collapse"
                                 aria-expanded="false" aria-controls="collapseBlogs">
                                 <span class="pe-nav-sub-content">Blogs</span>
                                 <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                             </a>
                             <ul class="pe-slide-menu collapse" id="collapseBlogs">
                                 <li class="slide pe-nav-content1">
                                     <a href="javascript:void(0)">Blog</a>
                                 </li>
                                 <li class="pe-slide-item">
                                     <a href="pages-blog-list.html" class="pe-nav-link">
                                         Blog List
                                     </a>
                                 </li>
                                 <li class="pe-slide-item">
                                     <a href="pages-blog-details.html" class="pe-nav-link">
                                         Blog Details
                                     </a>
                                 </li>
                                 <li class="pe-slide-item">
                                     <a href="pages-blog-create.html" class="pe-nav-link">
                                         Create Blog
                                     </a>
                                 </li>
                             </ul>
                         </li>
                         <li class="pe-slide-item">
                             <a href="pages-pricing.html" class="pe-nav-link">
                                 Pricing
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="pages-privacy-policy.html" class="pe-nav-link">
                                 Privacy Policy
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="pages-terms-conditions.html" class="pe-nav-link">
                                 Terms & Conditions
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="pages-timeline.html" class="pe-nav-link">
                                 Timeline
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="pages-faqs.html" class="pe-nav-link">
                                 FAQs
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="pages-billing-subscription.html" class="pe-nav-link">
                                 Billing & Subscription
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="not-authorize.html" class="pe-nav-link">
                                 Not Authorized
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="coming-soon.html" class="pe-nav-link">
                                 Comming Soon
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="under-maintenance.html" class="pe-nav-link">
                                 Maintenance
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="error.html" class="pe-nav-link">
                                 Error
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
                         <li class="pe-slide-item">
                             <a href="ui-alerts.html" class="pe-nav-link">Alert</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-avatars.html" class="pe-nav-link">Avatar</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-badges.html" class="pe-nav-link">Badge</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-breadcrumbs.html" class="pe-nav-link">Breadcrumb</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-buttons.html" class="pe-nav-link">Buttons</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-button-group.html" class="pe-nav-link">Button Group</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-card.html" class="pe-nav-link">Cards</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-cookie.html" class="pe-nav-link">Cookie</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-carousel.html" class="pe-nav-link">Carousel</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-dropdowns.html" class="pe-nav-link">Dropdown</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-images-figures.html" class="pe-nav-link">Images & Figures</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-links.html" class="pe-nav-link">Links</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-list.html" class="pe-nav-link">List Group</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-tabs.html" class="pe-nav-link">Nav & Tabs</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-pagination.html" class="pe-nav-link">Pagination</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-popover.html" class="pe-nav-link">Popovers</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-progress.html" class="pe-nav-link">Progress</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-spinner.html" class="pe-nav-link">Spinners</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-separator.html" class="pe-nav-link">Separator</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-modal.html" class="pe-nav-link">Modal</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-offcanvas.html" class="pe-nav-link">Offcanvas</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-placeholders.html" class="pe-nav-link">Placeholders</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-toast.html" class="pe-nav-link">Toasts</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-tooltips.html" class="pe-nav-link">Tooltips</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-typography.html" class="pe-nav-link">Typography</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-utilities.html" class="pe-nav-link">Utilities</a>
                         </li>
                     </ul>
                 </li>
                 <li class="pe-slide pe-has-sub">
                     <a href="#collapseAdvancedUI" class="pe-nav-link" data-bs-toggle="collapse"
                         aria-expanded="false" aria-controls="collapseAdvancedUI">
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
                         <li class="pe-slide-item">
                             <a href="ui-countup.html" class="pe-nav-link">Count Up</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-draggable-cards.html" class="pe-nav-link">Draggable Cards</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-media-player.html" class="pe-nav-link">Media Player</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-ratings.html" class="pe-nav-link">Rating</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-ribbons.html" class="pe-nav-link">Ribbons</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-scrollspy.html" class="pe-nav-link">Scroll Spy</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-sortable-js.html" class="pe-nav-link">Sortable JS</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-sweetalert2.html" class="pe-nav-link">Sweet Alert</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-advance-swiper.html" class="pe-nav-link">Swiper JS</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-tour.html" class="pe-nav-link">Tour</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-treeview.html" class="pe-nav-link">Tree View</a>
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
                             <a href="javascript:void(0)">Forms</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-form-elements.html" class="pe-nav-link">
                                 Input
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-form-checkboxs-radios.html" class="pe-nav-link">
                                 Checkbox & Radios
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-form-input-group.html" class="pe-nav-link">
                                 Inout Group
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-form-select.html" class="pe-nav-link">
                                 Form Select
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-form-range.html" class="pe-nav-link">
                                 Range Slider
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-form-input-spin.html" class="pe-nav-link">
                                 Input Spin
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-form-input-masks.html" class="pe-nav-link">
                                 Input Masks
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-form-file-uploads.html" class="pe-nav-link">
                                 File Uploads
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-date-picker.html" class="pe-nav-link">
                                 Date,Time Picker
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-floating-labels.html" class="pe-nav-link">Floating Label</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-form-layout.html" class="pe-nav-link">Form Layout</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-form-editor.html" class="pe-nav-link">Editor</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-form-validation.html" class="pe-nav-link">Form Validation</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-form-wizards.html" class="pe-nav-link">Form Wizards</a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-form-advanced.html" class="pe-nav-link">Form Advanced</a>
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
                         <li class="pe-slide-item">
                             <a href="ui-tables-listjs.html" class="pe-nav-link">
                                 List JS Table
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-tables-gridjs.html" class="pe-nav-link">
                                 Grid JS Table
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="ui-tables-datatables.html" class="pe-nav-link">
                                 Datatables
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
                             <a href="chart-js-chart.html" class="pe-nav-link">
                                 Chartjs Charts
                             </a>
                         </li>
                         <li class="pe-slide-item">
                             <a href="echart-chart.html" class="pe-nav-link">
                                 Echart Charts
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
