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
                            <li class="breadcrumb-item" aria-current="page"><a href="{{ url('broadcast_report') }}">Broadcast Report</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <!--start::card-->
                        <div class="card-header">
                            <h5 class="card-title mb-0"> Broadcast Detail Report </h5>
                            
                        </div>
                        <div class="card-body">
                         <div class="card mb-3">
                                <div class="card-body card-color">
                                    <form id="filterForm">
                                        <div class="row g-2">

                                            <!-- Range Tanggal -->
                                            
                                            <div class="col-md-2">
                                                <label>Status</label>
                                                <select id="filter_status" name="filter_status" class="form-control">
                                                    <option value="">- All -</option>
                                                    <option value="sent">Sent</option>
                                                    <option value="failed">Failed</option>
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
                                            <th>Broadcast Name</th>
                                            <th>Contact Name</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Note</th>
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
    
@endsection

@push('scripts')
    @include('crm.reports.broadcast.detail.js')
@endpush
