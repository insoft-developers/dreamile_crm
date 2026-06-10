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
                            <li class="breadcrumb-item active" aria-current="page">Presentation</li>
                            <li class="breadcrumb-item active" aria-current="page">Presentation Data</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <!--start::card-->
                        <div class="card-header">
                            <h5 class="card-title mb-0"> Presentation Data </h5>
                            <button onclick="addData()" title="Add Data" class="me-0 btn  btn-success btn-sm"><i
                                    class="bi bi-plus"></i></button>
                        </div>
                        <div class="card-body">
                            <div class="card mb-3">
                                <div class="card-body card-color">
                                    <form id="filterForm">
                                        <div class="row g-2">

                                            <!-- Range Tanggal -->
                                            <div class="col-md-4">
                                                <label>Date</label>
                                                <input type="date" id="filter_date" name="filter_date"
                                                    class="form-control">
                                            </div>

                                            
                                            <!-- Consultant -->
                                            <div class="col-md-4">
                                                <label>Consultant</label>
                                                <select id="filter_consultant" name="filter_consultant"
                                                    class="form-control">
                                                    <option value="">- All -</option>
                                                    @foreach($consultants as $consult)
                                                        <option value="{{ $consult->id }}">{{ $consult->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Branch -->
                                            <div class="col-md-4">
                                                <label>Branch</label>
                                                <select id="filter_branch" name="filter_branch" class="form-control">
                                                    <option value="">- All -</option>
                                                    @foreach($branches as $branch)
                                                        <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
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
                                            <th>Title</th>
                                            <th>Location</th>
                                            <th>Date</th>
                                            <th>Consultant</th>
                                            <th>Audience</th>
                                            <th>Tertarik</th>
                                            <th>Sangat Tertarik</th>
                                            <th>Kurang Tertarik</th>
                                            <th>Leads</th>
                                            <th>Deals</th>
                                            <th>Description</th>
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
    @include('crm.presentation.modal')
@endsection

@push('scripts')
    @include('crm.presentation.js')
@endpush
