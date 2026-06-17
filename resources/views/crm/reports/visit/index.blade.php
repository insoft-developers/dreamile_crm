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
                            <li class="breadcrumb-item active" aria-current="page">Visit Report</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <!--start::card-->
                        <div class="card-header">
                            <h5 class="card-title mb-0"> Visit Report </h5>
                            
                        </div>
                        <div class="card-body">
                         <div class="card mb-3">
                                <div class="card-body card-color">
                                    <form id="filterForm">
                                        <div class="row g-2">

                                            <!-- Range Tanggal -->
                                            <div class="col-md-2">
                                                <label>Start Date</label>
                                                <input type="date" id="filter_start_date" name="filter_start_date"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-2">
                                                <label>End Date</label>
                                                <input type="date" id="filter_end_date" name="filter_end_date"
                                                    class="form-control">
                                            </div>

                                            <div class="col-md-2">
                                                <label>Consultant</label>
                                                <select id="filter_consultant" name="filter_consultant" class="form-control">
                                                    <option value="">- All -</option>
                                                    @foreach($consultants as $key)
                                                    <option value="{{ $key->id }}">{{ $key->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <label>Branch</label>
                                                <select id="filter_branch" name="filter_branch" class="form-control">
                                                    <option value="">- All -</option>
                                                    @foreach($branches as $key)
                                                    <option value="{{ $key->id }}">{{ $key->branch_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- Branch -->
                                            <div class="col-md-2">
                                                <label>Status</label>
                                                <select id="filter_status" name="filter_status" class="form-control">
                                                    <option value="">- All -</option>
                                                    <option value="done">Done</option>
                                                    <option value="scheduled">Scheduled</option>
                                                    
                                                </select>
                                            </div>
                                            <!-- Branch -->
                                            <div class="col-md-2">
                                                <label>Created By</label>
                                                <select id="filter_created_by" name="filter_created_by" class="form-control">
                                                    <option value="">- All -</option>
                                                    @foreach($users as $key)
                                                    <option value="{{ $key->id }}">{{ $key->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Tombol -->
                                            <div class="col-md-12 mt-3 d-flex">
                                                
                                                    <button type="button" onclick="filterData()"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="bi bi-search"></i> Filter
                                                    </button>

                                                    <button style="margin-left: 2px;" type="button" onclick="resetFilter()" class="btn btn-secondary btn-sm">
                                                        <i class="bi bi-arrow-clockwise"></i> Reset
                                                    </button>
                                               

                                               
                                                    <button style="margin-left: 2px;" type="button" onclick="exportExcel()"
                                                        class="btn btn-success btn-sm">
                                                        <i class="bi bi-file-earmark-excel"></i> Excel
                                                    </button>

                                                    <button style="margin-left: 2px;" type="button" onclick="exportPDF()"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="bi bi-file-earmark-pdf"></i> PDF
                                                    </button>
                                                
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
                                            <th>Date</th>
                                            <th>Customer</th>
                                            <th>Consultant</th>
                                            <th>Location</th>
                                            <th>Branch</th>
                                            <th>Status</th>
                                            <th>Visit Images</th>
                                            <th>Note</th>
                                            <th>Created By</th>
                                            


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
    
@endsection

@push('scripts')
    @include('crm.reports.visit.js')
@endpush
