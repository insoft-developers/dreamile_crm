 @extends('crm.master')
 @section('content')
     <main class="app-wrapper">
         <div class="container-fluid">


             <div class="main-breadcrumb d-flex align-items-center my-3 position-relative">
                 <h2 class="breadcrumb-title mb-0 flex-grow-1 fs-14">Leads Detail Data</h2>
                 
                 <div class="flex-shrink-0">
                     <nav aria-label="breadcrumb">
                         <ol class="breadcrumb justify-content-end mb-0">
                             <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                             <li class="breadcrumb-item" aria-current="page">Customers</li>
                             <li class="breadcrumb-item" aria-current="page"><a href="{{ url('lead') }}">Leads Data</a></li>
                             <li class="breadcrumb-item active" aria-current="page">Leads Detail Data</li>
                         </ol>
                     </nav>
                 </div>
             </div>



             <div class="card position-relative z-1">
                 <div class="card-body p-5">
                    <button onclick="window.history.back()" class="btn btn-sm btn-primary mb-2"><i class="bi bi-arrow-left"></i> Back to Lead Data</button>
                     <div class="d-flex justify-content-between flex-wrap align-items-center gap-6">
                         <div class="flex-shrink-0">
                             <div class="position-relative d-inline-block">
                                
                                 @if (!empty($data->photo))
                                     <img src="{{ asset('storage/' . $data->photo) }}" alt="Avatar Image"
                                         class="h-100px w-100px rounded-pill">
                                 @else
                                     {
                                     <img src="{{ asset('template/crm/assets/images/avatar/dummy.jpg') }}"
                                         alt="Avatar Image" class="h-100px w-100px rounded-pill">
                                 @endif

                                 <div
                                     class="h-30px w-30px rounded-pill bg-primary d-flex justify-content-center align-items-center text-white border border-3 border-light-subtle position-absolute fs-12 bottom-0 end-0">

                                 </div>
                                 <span class="position-absolute profile-dot bg-success rounded-circle">
                                     <span class="visually-hidden">unread messages</span>
                                 </span>
                             </div>
                         </div>
                         <div class="flex-grow-1">
                             <h4 class="mb-1">{{ $data->fullname }} <i
                                     class="bi bi-patch-check-fill fs-16 ms-1 text-success"></i>
                             </h4>
                             <p style="white-space: normal;width:300px;" class="text-muted mb-1">{{ $data->full_address }}
                             </p>

                         </div>
                         <div class="d-flex flex-wrap gap-3">
                             <div
                                 class="d-flex flex-column justify-content-center gap-1 w-256px text-center py-4 border rounded-2">
                                 <h4 class="mb-2 lh-1">School</h4>
                                 <span class="text-muted lh-sm fs-12">{{ $data->school_from }}</span>
                             </div>
                             <div
                                 class="d-flex flex-column justify-content-center gap-1 w-128px text-center py-4 border rounded-2">
                                 <h4 class="mb-2 lh-1">Class</h4>
                                 <span class="text-muted lh-sm fs-12">{{ $data->class }}</span>
                             </div>
                             <div
                                 class="d-flex flex-column justify-content-center gap-1 w-128px text-center py-4 border rounded-2">
                                 <h4 class="mb-2 lh-1">Major</h4>
                                 <span class="text-muted lh-sm fs-12">{{ $data->major }}</span>
                             </div>

                         </div>
                         <div class="d-flex float-end gap-2 flex-shrink-0">


                         </div>
                     </div>
                 </div>
             </div>
             <div class="row">
                 <div class="col-xl-3">
                     <div class="card">
                         <div class="card-header">
                             <h5 class="card-title mb-0">Personal Details</h5>

                         </div>
                         <div class="card-body d-flex flex-column gap-4 text-truncate">
                             <div class="d-flex align-items-center gap-3">
                                 <i class="ri-map-pin-line fs-16 text-muted"></i>
                                 <p class="mb-0">
                                     {{ $data->village_name }}<br>{{ $data->district_name }}<br>{{ $data->regency_name }}<br>{{ $data->province_name }}
                                 </p>
                             </div>
                             <div class="d-flex align-items-center gap-3">
                                 <i class="ri-mail-line fs-16 text-muted"></i>
                                 <p class="mb-0">{{ $data->email }}</p>
                             </div>
                             <div class="d-flex align-items-center gap-3">
                                 <i class="ri-phone-line fs-16 text-muted"></i>
                                 <p class="mb-0">{{ $data->phone_number }}</p>
                             </div>

                             <div class="d-flex align-items-center gap-3">
                                 <i class="ri-user-2-line fs-16 text-muted"></i>
                                 <p class="mb-0">{{ $data->gender }}</p>
                             </div>

                             <div class="d-flex align-items-center gap-3">
                                 <i class="ri-time-line fs-16 text-muted"></i>
                                 <p class="mb-0">Join on {{ date('d F Y', strtotime($data->created_at)) }}</p>
                             </div>
                         </div>
                     </div>

                     <div class="card text-center">
                         <div class="card-header">
                             <h5 class="card-title">Leads Source</h5>
                         </div>
                         <div class="card-body p-4 card-color">
                             @if ($data->lead_source_id == 'event')
                                 <h5>Event</h5>
                                 <table class="table table-bordered table-stripped">
                                     <tr>
                                         <td><strong>{{ $data->events->event_name ?? '' }}</strong></td>
                                     </tr>
                                     @if (!empty($data->events->image))
                                         <tr>
                                             <td>
                                                 <a href="{{ asset('storage/' . $data->events->image) }}" target="_blank"><img class="img-fluid"
                                                     src="{{ asset('storage/' . $data->events->image) }}"></a>
                                             </td>
                                         </tr>
                                     @endif
                                     <tr>
                                         <td>{{ $data->events->event_location ?? '' }}</td>
                                     </tr>
                                     <tr>
                                         <td><strong>{{ date('d F Y', strtotime($data->events->event_date)) ?? '' }}</strong>
                                         </td>
                                     </tr>
                                 </table>
                             @elseif($data->lead_source_id == 'presentation')
                                 <h5>Presentation</h5>
                             @else
                                 <h5>{{ $data->leadsource->source_name ?? '' }}</h5>
                             @endif
                         </div>
                     </div>

                     <div class="card">
                         <div class="card-header">
                             <h5 class="card-title">Note</h5>
                         </div>
                         <div class="card-body p-6">
                             <p>{{ $data->note }}</p>
                         </div>
                     </div>
                 </div>
                 <div class="col-xl-6 order-last order-xl-2">
                     <div class="tab-content">
                         <div class="tab-pane active show" id="pages-profile-tab" role="tabpanel">
                             <div class="card">
                                 <div class="card-header">
                                     <h5 class="card-title">Visit</h5>
                                     @if ($data->visit_status == 'scheduled')
                                         <span class="badge bg-warning-subtle text-warning">Scheduled</span>
                                     @elseif($data->visit_status == 'done')
                                         <span class="badge bg-success-subtle text-success">Done</span>
                                     @else
                                     @endif

                                 </div>
                                 <div class="card-body">

                                     <label><strong>Photo on Visit:</strong></label>
                                     <div class="mb-3">
                                         @if (!empty($data->visitImages))
                                             @foreach ($data->visitImages as $photo)
                                                 <a href="{{ asset('storage/' . $photo->image) }}" target="_blank"><img src="{{ asset('storage/' . $photo->image) }}" alt="photo"
                                                     style="width:120px; height:120px; object-fit:cover; margin-right:10px; margin-bottom:10px; border-radius:8px;border:2px solid green;padding:3px;"></a>
                                             @endforeach
                                         @else
                                             <p>No photos available</p>
                                         @endif
                                     </div>
                                     <label><strong>Date:</strong></label>
                                     <p class="mb-3">{{ $data->visit_date == null ? '' : date('d F Y H:i', strtotime($data->visit_date)) }}</p>
                                     <label><strong>Location:</strong></label>
                                     <p class="mb-3">{{ $data->visit_location ?? '' }}</p>
                                     <label><strong>Visit Note:</strong></label>
                                     <p class="mb-3">{{ $data->visit_note }}</p>

                                 </div>
                             </div>
                             <div class="card">
                                 <div class="card-header">
                                     <h5 class="card-title">Followups</h5>
                                 </div>
                                 <div class="card-body">
                                     <div class="timeline2 icon-timeline">
                                         <ul>
                                          
                                            @if($data->followup)
                                            @foreach($data->followup as $fw)
                                             <li class="box">
                                                 <span class="bg-primary">
                                                     <i class="ri-image-line"></i>
                                                 </span>
                                                 <div class="text-muted float-end fs-13">{{ $fw->date == null ? '' : date('d F Y H:s', strtotime($fw->date)) }}</div>
                                                 <div class="title">Followup {{ $fw->step }}</div>
                                                 <div class="info">{{ $fw->note }}</div>
                                                 <div class="info text-muted">Uploaded <b
                                                         class="text-body">“Image”</b></div>
                                                 <div class="mt-3 d-flex gap-2">
                                                    @if(!empty($fw->image))
                                                     <a href="{{ asset('storage/'.$fw->image) }}" target="_blank"><img src="{{ asset('storage/'.$fw->image) }}"
                                                         class="rounded h-56px" alt="Uploaded Image"></a>
                                                     @endif
                                                 </div>
                                             </li>
                                             @endforeach
                                             @endif
                                         </ul>
                                     </div>
                                 </div>
                             </div>
                         </div>

                     </div>
                 </div>
                 <div class="col-xl-3 order-2 order-xl-last">
                     <div class="d-flex flex-column">
                         <div class="card order-1 order-xl-2">
                             <div class="card-header">
                                 <h5 class="card-title mb-0">Status</h5>
                             </div>
                             <div class="card-body d-flex flex-column gap-6">
                                 <div class="d-flex align-items-center gap-3">

                                     <div class="text-truncate">
                                         @if ($data->status == 'new-lead')
                                             <span class="badge bg-success rounded-pill">{{ strtoupper($data->status) }}</span>
                                         @elseif($data->status == 'visit')
                                             <span class="badge bg-warning rounded-pill">{{ strtoupper($data->status) }}</span>
                                         @elseif($data->status == 'deal')
                                             <span class="badge bg-info rounded-pill">{{ strtoupper($data->status) }}</span>
                                         @elseif($data->status == 'nok')
                                             <span class="badge bg-danger rounded-pill">{{ strtoupper($data->status) }}</span>
                                         @elseif($data->status == 'confirm')
                                             <span class="badge bg-primary rounded-pill">{{ strtoupper($data->status) }}</span>
                                         @endif
                                     </div>

                                 </div>

                             </div>
                         </div>

                         <div class="card order-1 order-xl-2">
                             <div class="card-header">
                                 <h5 class="card-title mb-0">Education Consultant</h5>
                             </div>
                             <div class="card-body d-flex flex-column gap-6">
                                 <div class="d-flex align-items-center gap-3">
                                     @if ($data->consultant && $data->consultant->photo_profile)
                                         <img src="{{ asset('storage/' . $data->consultant->photo_profile) }}"
                                             class="rounded-circle avatar-md" alt="User">
                                     @endif
                                     <div class="text-truncate">
                                         <h6 class="mb-0">{{ $data->consultant?->name ?? '' }}</i></h6>
                                         <small
                                             class="text-muted">{{ $data->consultant?->levels?->level_name ?? '' }}</small>
                                     </div>

                                 </div>

                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         </div><!--End container-fluid-->
     </main><!--End app-wrapper-->
 @endsection
