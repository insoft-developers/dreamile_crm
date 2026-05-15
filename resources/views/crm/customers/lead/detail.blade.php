<style>
    .bg-gradient-light {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    }

    .modern-card {
        border: 0;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(15, 23, 42, 0.05);
        transition: all .2s ease;
        background: #fff;
    }

    .modern-card:hover {
        transform: translateY(-2px);
    }

    .modern-header {
        padding: 1.5rem 1.5rem 0;
        border: 0;
        background: #fff;
    }

    .modern-body {
        padding: 1.5rem;
    }

    .profile-avatar {
        width: 110px;
        height: 110px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }

    .info-box {
        background: #f8fafc;
        border-radius: 20px;
        padding: 24px;
        text-align: center;
        min-width: 140px;
    }

    .info-box h4 {
        font-size: 15px;
        margin-bottom: 10px;
        font-weight: 700;
    }

    .info-box span {
        font-size: 13px;
        color: #64748b;
    }

    .icon-box {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6366f1;
        font-size: 18px;
        flex-shrink: 0;
    }

    .timeline-card {
        background: #fff;
        border-radius: 18px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    }

    .visit-image {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 18px;
        padding: 4px;
        border: 2px solid #22c55e;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .followup-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    }

    .badge-modern {
        padding: 10px 18px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }

    .consultant-photo {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
</style>

@extends('crm.master')

@section('content')

<main class="app-wrapper">

    <div class="container-fluid">

        <!-- Breadcrumb -->
        <div class="main-breadcrumb d-flex align-items-center my-3 position-relative">

            <h2 class="breadcrumb-title mb-0 flex-grow-1 fs-14">
                Leads Detail Data
            </h2>

            <div class="flex-shrink-0">

                <nav aria-label="breadcrumb">

                    <ol class="breadcrumb justify-content-end mb-0">

                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">Dashboard</a>
                        </li>

                        <li class="breadcrumb-item">
                            Customers
                        </li>

                        <li class="breadcrumb-item">
                            <a href="{{ url('lead') }}">Leads Data</a>
                        </li>

                        <li class="breadcrumb-item active">
                            Leads Detail Data
                        </li>

                    </ol>

                </nav>

            </div>

        </div>

        <!-- PROFILE HERO -->
        <div class="modern-card mb-4">

            <div class="card-body p-4 p-xl-5 bg-gradient-light">

                <button onclick="window.history.back()"
                    class="btn btn-light border rounded-pill px-4 shadow-sm mb-4">

                    <i class="bi bi-arrow-left"></i>
                    Back to Lead Data

                </button>

                <div class="d-flex justify-content-between flex-wrap align-items-center gap-4">

                    <!-- Left -->
                    <div class="d-flex align-items-center gap-4">

                        <div class="position-relative">

                            @if (!empty($data->photo))

                                <img src="{{ asset('storage/' . $data->photo) }}"
                                    class="profile-avatar">

                            @else

                                <img src="{{ asset('template/crm/assets/images/avatar/dummy.jpg') }}"
                                    class="profile-avatar">

                            @endif

                            <span class="position-absolute bottom-0 end-0 p-2 bg-success border border-3 border-white rounded-circle"></span>

                        </div>

                        <div>

                            <h3 class="fw-bold mb-2 d-flex align-items-center gap-2">

                                {{ $data->fullname }}

                                <i class="bi bi-patch-check-fill text-success"></i>

                            </h3>

                            <p class="text-muted mb-2" style="max-width:450px;">
                                {{ $data->full_address }}
                            </p>

                            <div class="d-flex align-items-center gap-2 text-muted small">

                                <i class="ri-time-line"></i>

                                Joined
                                {{ date('d F Y', strtotime($data->created_at)) }}

                            </div>

                        </div>

                    </div>

                    <!-- Right -->
                    <div class="d-flex flex-wrap gap-3">

                        <div class="info-box">

                            <h4>School</h4>

                            <span>{{ $data->school_from }}</span>

                        </div>

                        <div class="info-box">

                            <h4>Class</h4>

                            <span>{{ $data->class }}</span>

                        </div>

                        <div class="info-box">

                            <h4>Major</h4>

                            <span>{{ $data->major }}</span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="row g-4">

            <!-- LEFT -->
            <div class="col-xl-3">

                <!-- PERSONAL -->
                <div class="modern-card mb-4">

                    <div class="modern-header">

                        <h5 class="fw-bold mb-0">
                            Personal Details
                        </h5>

                    </div>

                    <div class="modern-body d-flex flex-column gap-4">

                        <div class="d-flex gap-3">

                            <div class="icon-box">
                                <i class="ri-map-pin-line"></i>
                            </div>

                            <div>

                                {{ $data->village_name }}<br>
                                {{ $data->district_name }}<br>
                                {{ $data->regency_name }}<br>
                                {{ $data->province_name }}

                            </div>

                        </div>

                        <div class="d-flex gap-3">

                            <div class="icon-box">
                                <i class="ri-mail-line"></i>
                            </div>

                            <div>{{ $data->email }}</div>

                        </div>

                        <div class="d-flex gap-3">

                            <div class="icon-box">
                                <i class="ri-phone-line"></i>
                            </div>

                            <div>{{ $data->phone_number }}</div>

                        </div>

                        <div class="d-flex gap-3">

                            <div class="icon-box">
                                <i class="ri-user-2-line"></i>
                            </div>

                            <div>{{ $data->gender }}</div>

                        </div>

                    </div>

                </div>

                <!-- LEAD SOURCE -->
                <div class="modern-card mb-4">

                    <div class="modern-header">

                        <h5 class="fw-bold mb-0">
                            Leads Source
                        </h5>

                    </div>

                    <div class="modern-body text-center">

                        @if ($data->lead_source_id == 'event')

                            <h5 class="fw-bold mb-4">
                                Event
                            </h5>

                            <table class="table table-bordered">

                                <tr>
                                    <td>
                                        <strong>{{ $data->events->event_name ?? '' }}</strong>
                                    </td>
                                </tr>

                                @if (!empty($data->events->image))

                                    <tr>

                                        <td>

                                            <a href="{{ asset('storage/' . $data->events->image) }}"
                                                target="_blank">

                                                <img class="img-fluid rounded-4"
                                                    src="{{ asset('storage/' . $data->events->image) }}">

                                            </a>

                                        </td>

                                    </tr>

                                @endif

                                <tr>
                                    <td>{{ $data->events->event_location ?? '' }}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <strong>
                                            {{ date('d F Y', strtotime($data->events->event_date)) ?? '' }}
                                        </strong>
                                    </td>
                                </tr>

                            </table>

                        @elseif($data->lead_source_id == 'presentation')

                            <h5 class="fw-bold">
                                Presentation
                            </h5>

                        @else

                            <h5 class="fw-bold">
                                {{ $data->leadsource->source_name ?? '' }}
                            </h5>

                        @endif

                    </div>

                </div>

                <!-- NOTE -->
                <div class="modern-card">

                    <div class="modern-header">

                        <h5 class="fw-bold mb-0">
                            Note
                        </h5>

                    </div>

                    <div class="modern-body">

                        <p class="mb-0">
                            {{ $data->note }}
                        </p>

                    </div>

                </div>

            </div>

            <!-- CENTER -->
            <div class="col-xl-6">

                <!-- VISIT -->
                <div class="modern-card mb-4">

                    <div class="modern-header d-flex justify-content-between align-items-center">

                        <h5 class="fw-bold mb-0">
                            Visit
                        </h5>

                        @if ($data->visit_status == 'scheduled')

                            <span class="badge bg-warning-subtle text-warning badge-modern">
                                Scheduled
                            </span>

                        @elseif($data->visit_status == 'done')

                            <span class="badge bg-success-subtle text-success badge-modern">
                                Done
                            </span>

                        @endif

                    </div>

                    <div class="modern-body">

                        <label class="fw-bold mb-3">
                            Photo on Visit
                        </label>

                        <div class="mb-4">

                            @if (!empty($data->visitImages))

                                @foreach ($data->visitImages as $photo)

                                    <a href="{{ asset('storage/' . $photo->image) }}"
                                        target="_blank">

                                        <img src="{{ asset('storage/' . $photo->image) }}"
                                            class="visit-image">

                                    </a>

                                @endforeach

                            @else

                                <p>No photos available</p>

                            @endif

                        </div>

                        <div class="mb-3">

                            <label class="fw-bold">
                                Date
                            </label>

                            <p>
                                {{ $data->visit_date == null ? '' : date('d F Y H:i', strtotime($data->visit_date)) }}
                            </p>

                        </div>

                        <div class="mb-3">

                            <label class="fw-bold">
                                Location
                            </label>

                            <p>{{ $data->visit_location ?? '' }}</p>

                        </div>

                        <div>

                            <label class="fw-bold">
                                Visit Note
                            </label>

                            <p>{{ $data->visit_note }}</p>

                        </div>

                    </div>

                </div>

                <!-- FOLLOWUPS -->
                <div class="modern-card">

                    <div class="modern-header">

                        <h5 class="fw-bold mb-0">
                            Followups
                        </h5>

                    </div>

                    <div class="modern-body">

                        @if($data->followup)

                            @foreach($data->followup as $fw)

                                <div class="timeline-card">

                                    <div class="d-flex justify-content-between mb-2">

                                        <h6 class="fw-bold mb-0">
                                            Followup {{ $fw->step }}
                                        </h6>

                                        <small class="text-muted">

                                            {{ $fw->date == null ? '' : date('d F Y H:i', strtotime($fw->date)) }}

                                        </small>

                                    </div>

                                    <p class="mb-3">
                                        {{ $fw->note }}
                                    </p>

                                    @if(!empty($fw->image))

                                        <a href="{{ asset('storage/'.$fw->image) }}"
                                            target="_blank">

                                            <img src="{{ asset('storage/'.$fw->image) }}"
                                                class="followup-image">

                                        </a>

                                    @endif

                                </div>

                            @endforeach

                        @endif

                    </div>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="col-xl-3">

                <!-- STATUS -->
                <div class="modern-card mb-4">

                    <div class="modern-header">

                        <h5 class="fw-bold mb-0">
                            Status
                        </h5>

                    </div>

                    <div class="modern-body">

                        @if ($data->status == 'new-lead')

                            <span class="badge bg-success badge-modern">
                                NEW LEAD
                            </span>

                        @elseif($data->status == 'visit')

                            <span class="badge bg-warning badge-modern">
                                VISIT
                            </span>

                        @elseif($data->status == 'deal')

                            <span class="badge bg-info badge-modern">
                                DEAL
                            </span>

                        @elseif($data->status == 'nok')

                            <span class="badge bg-danger badge-modern">
                                NOK
                            </span>

                        @elseif($data->status == 'confirm')

                            <span class="badge bg-primary badge-modern">
                                CONFIRM
                            </span>

                        @endif

                    </div>

                </div>

                <!-- CONSULTANT -->
                <div class="modern-card">

                    <div class="modern-header">

                        <h5 class="fw-bold mb-0">
                            Education Consultant
                        </h5>

                    </div>

                    <div class="modern-body">

                        <div class="d-flex align-items-center gap-3">

                            @if ($data->consultant && $data->consultant->photo_profile)

                                <img src="{{ asset('storage/' . $data->consultant->photo_profile) }}"
                                    class="consultant-photo">

                            @endif

                            <div>

                                <h6 class="fw-bold mb-1">
                                    {{ $data->consultant?->name ?? '' }}
                                </h6>

                                <small class="text-muted">

                                    {{ $data->consultant?->levels?->level_name ?? '' }}

                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</main>

@endsection