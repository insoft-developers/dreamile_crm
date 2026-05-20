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
                            <li class="breadcrumb-item active" aria-current="page">Customers</li>
                            <li class="breadcrumb-item active" aria-current="page">Customer Data</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <!--start::card-->
                        <div class="card-header">
                            <h5 class="card-title mb-0"> Customer Data </h5>
                            <button onclick="addData()" title="Add Data" class="me-0 btn  btn-success btn-sm"><i
                                    class="bi bi-plus"></i></button>
                        </div>
                        <div class="card-body">
                            <div class="card mb-3">
                                <div class="card-body card-color">
                                    <form id="filterForm">
                                        <div class="row g-2">

                                            <!-- Range Tanggal -->
                                            <div class="col-md-2">
                                                <label>Dari Tanggal</label>
                                                <input type="date" id="start_date" name="start_date"
                                                    class="form-control">
                                            </div>

                                            <div class="col-md-2">
                                                <label>Sampai Tanggal</label>
                                                <input type="date" id="end_date" name="end_date" class="form-control">
                                            </div>

                                            <!-- Status -->
                                            <div class="col-md-2">
                                                <label>Status</label>
                                                <select id="filter_status" name="filter_status" class="form-control">
                                                    <option value="">- All -</option>
                                                    <option value="new-lead">New Lead</option>
                                                    <option value="visit">Visit</option>
                                                    <option value="deal">Deal</option>
                                                    <option value="nok">NOK</option>
                                                    <option value="confirm">Confirmation</option>
                                                </select>
                                            </div>

                                            <!-- Lead Source -->
                                            <div class="col-md-2">
                                                <label>Lead Source</label>
                                                <select id="filter_lead_source" name="filter_lead_source"
                                                    class="form-control">
                                                    <option value="">- All -</option>
                                                    @foreach ($sources as $source)
                                                        <option value="{{ $source->slug }}">{{ $source->source_name }}
                                                        </option>
                                                    @endforeach
                                                    <option value="presentation">Presentation</option>
                                                    <option value="event">Event</option>
                                                </select>
                                            </div>

                                            <!-- Consultant -->
                                            <div class="col-md-2">
                                                <label>Consultant</label>
                                                <select id="filter_consultant" name="filter_consultant"
                                                    class="form-control">
                                                    <option value="">- All -</option>
                                                    {{-- loop dari database --}}
                                                    @foreach ($consultants as $consult)
                                                    <option value="{{ $consult->id }}">{{ $consult->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Branch -->
                                            <div class="col-md-2">
                                                <label>Branch</label>
                                                <select id="filter_branch" name="filter_branch" class="form-control">
                                                    <option value="">- All -</option>
                                                    @foreach ($branches ?? [] as $b)
                                                        <option value="{{ $b->id }}">{{ $b->branch_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Tombol -->
                                            <div class="col-md-12 mt-3 d-flex justify-content-between">
                                                <div>
                                                    <button type="button" onclick="filterData()"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="bi bi-search"></i> Filter
                                                    </button>

                                                    <button type="button" onclick="resetFilter()" class="btn btn-secondary btn-sm">
                                                        <i class="bi bi-arrow-clockwise"></i> Reset
                                                    </button>
                                                </div>

                                                <div>
                                                    <button type="button" onclick="exportExcel()"
                                                        class="btn btn-success btn-sm">
                                                        <i class="bi bi-file-earmark-excel"></i> Excel
                                                    </button>

                                                    <button type="button" onclick="exportPDF()"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="bi bi-file-earmark-pdf"></i> PDF
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table width="100%" id="list-table"
                                    class="table table-nowrap table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th class="text-center" width="5%">No</th>
                                            <th class="text-center">Aksi</th>
                                            <th>Photo</th>
                                            <th>Full Name</th>
                                            <th>School</th>
                                            <th>Class/Major</th>
                                            <th>Phone Number</th>
                                            <th>Status</th>
                                            <th>Consultant</th>
                                            <th>Lead Source</th>
                                            <th>Branch</th>
                                            <th>Created By</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <!-- end:: Basic Datatable -->
                        </div>
                    </div>


                </div>

            </div><!--End row-->
        </div><!--End container-fluid-->
    </main><!--End app-wrapper-->
    @include('crm.customers.customer.modal')
  
@endsection

@push('scripts')
    @include('crm.customers.customer.js')
@endpush
