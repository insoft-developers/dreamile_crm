@extends('crm.master')

@section('content')
    <main class="app-wrapper">

        <div class="container-fluid">
            <div class="main-breadcrumb d-flex align-items-center my-3 position-relative">
                <h2 class="breadcrumb-title mb-0 flex-grow-1 fs-14"></h2>
                <div class="flex-shrink-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-end mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Reports</li>
                            <li class="breadcrumb-item active" aria-current="page">Lead Report</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between mb-4">

                        <div>

                            <h4 class="fw-bold mb-1">
                                Lead Report
                            </h4>

                            <p class="text-muted mb-0">
                                All about lead statistic data
                            </p>

                        </div>

                        <div>

                        </div>

                    </div>
                    <div class="card shadow-sm border-0 rounded-4 mb-4">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center mb-4">

                                <div>
                                    <h5 class="fw-bold mb-1">
                                        Leads Report
                                    </h5>

                                    <small class="text-muted">
                                        Filter laporan leads
                                    </small>
                                </div>

                                <div class="d-flex gap-2">

                                    <button class="btn btn-light quick-filter" data-range="today">
                                        Today
                                    </button>

                                    <button class="btn btn-light quick-filter" data-range="7days">
                                        7 Days
                                    </button>

                                    <button class="btn btn-light quick-filter" data-range="30days">
                                        30 Days
                                    </button>

                                    <button class="btn btn-primary quick-filter" data-range="month">
                                        This Month
                                    </button>

                                </div>

                            </div>

                            <div class="row g-3">

                                <div class="col-md-3">

                                    <label class="form-label">
                                        Search
                                    </label>

                                    <input type="text" id="search" class="form-control" placeholder="Nama / nomor">

                                </div>

                                <div class="col-md-2">

                                    <label class="form-label">
                                        Start Date
                                    </label>

                                    <input type="date" id="startDate" class="form-control">

                                </div>

                                <div class="col-md-2">

                                    <label class="form-label">
                                        End Date
                                    </label>

                                    <input type="date" id="endDate" class="form-control">

                                </div>

                                <div class="col-md-2">

                                    <label class="form-label">
                                        Status
                                    </label>

                                    <select id="status" class="form-select">

                                        <option value="">
                                            All Status
                                        </option>

                                        <option value="new-lead">
                                            New
                                        </option>

                                        <option value="visit">
                                            Visit
                                        </option>

                                        <option value="confirm">
                                            Confirm
                                        </option>

                                    </select>

                                </div>

                                <div class="col-md-2">

                                    <label class="form-label">
                                        Branch
                                    </label>

                                    <select id="branchId" class="form-select">

                                        <option value="">
                                            All Branch
                                        </option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                        @endforeach

                                    </select>

                                </div>

                                <div class="col-md-1 d-flex align-items-end">

                                    <button id="filterBtn" class="btn btn-primary w-100">

                                        <i class="bi bi-funnel"></i>

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row mb-4">


                        <div class="row g-3">

                            <!-- Total Leads -->
                            <div class="col-md-3">
                                <div class="card shadow-sm border-0 rounded-4">
                                    <div class="card-body d-flex justify-content-between align-items-center">

                                        <div>
                                            <p class="text-muted mb-1">Total Leads</p>
                                            <h3 class="fw-bold mb-0">
                                                <span id="card-total">-</span>
                                            </h3>
                                        </div>

                                        <div class="icon-box bg-primary-subtle text-primary">
                                            <i class="bi bi-people fs-3"></i>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- New Leads -->
                            <div class="col-md-3">
                                <div class="card shadow-sm border-0 rounded-4">
                                    <div class="card-body d-flex justify-content-between align-items-center">

                                        <div>
                                            <p class="text-muted mb-1">New Leads</p>
                                            <h3 class="fw-bold mb-0">
                                                <span id="card-new">-</span>
                                            </h3>
                                        </div>

                                        <div class="icon-box bg-info-subtle text-info">
                                            <i class="bi bi-person-plus fs-3"></i>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Visit -->
                            <div class="col-md-3">
                                <div class="card shadow-sm border-0 rounded-4">
                                    <div class="card-body d-flex justify-content-between align-items-center">

                                        <div>
                                            <p class="text-muted mb-1">Visit</p>
                                            <h3 class="fw-bold mb-0">
                                                <span id="card-visit">-</span>
                                            </h3>
                                        </div>

                                        <div class="icon-box bg-warning-subtle text-warning">
                                            <i class="bi bi-calendar-check fs-3"></i>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Confirm -->
                            <div class="col-md-3">
                                <div class="card shadow-sm border-0 rounded-4">
                                    <div class="card-body d-flex justify-content-between align-items-center">

                                        <div>
                                            <p class="text-muted mb-1">Confirm</p>
                                            <h3 class="fw-bold mb-0">
                                                <span id="card-confirm">-</span>
                                            </h3>
                                        </div>

                                        <div class="icon-box bg-success-subtle text-success">
                                            <i class="bi bi-check-circle fs-3"></i>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="card shadow-sm border-0 rounded-4 mb-4">

                                <div class="card-body">

                                    <div class="d-flex justify-content-between align-items-center mb-4">

                                        <div>

                                            <h5 class="fw-bold mb-1">
                                                Leads Trend
                                            </h5>

                                            <small class="text-muted">
                                                Leads harian
                                            </small>

                                        </div>

                                    </div>

                                    <div id="leadsChart"></div>

                                </div>

                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card shadow-sm border-0 rounded-4 h-100">

                                <div class="card-body">

                                    <h5 class="fw-bold mb-4">
                                        Leads by Status
                                    </h5>

                                    <div id="statusChart"></div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card shadow-sm border-0 rounded-4 h-100">

                        <div class="card-body">

                            <h5 class="fw-bold mb-4">
                                Top Lead Sources
                            </h5>

                            <div id="sourceChart"></div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>
    <style>
        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection
@push('scripts')
    @include('crm.reports.lead.js')
@endpush
