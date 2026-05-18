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
                            <li class="breadcrumb-item active" aria-current="page">Broadcast</li>
                            <li class="breadcrumb-item active" aria-current="page">Contact Group</li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Contact Group</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">

                <div class="col-9">
                    <div class="card">
                        <!--start::card-->
                        <div class="card-header">
                            <h5 class="card-title mb-0"> <button onclick="window.history.back()" title="Back to contact group" class="me-0 btn  btn-light btn-sm"><i
                                    class="bi bi-arrow-left"></i></button> Manage Contact Group Data </h5>
                            <button onclick="addData()" title="Add Data" class="me-0 btn  btn-success btn-sm"><i
                                    class="bi bi-plus"></i></button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table width="100%" id="list-table"
                                    class="table table-nowrap table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th class="text-center" width="5%">No</th>
                                            <th class="text-center">Aksi</th>
                                            
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Group</th>
                                          
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
    @include('crm.group.manage.modal')
@endsection

@push('scripts')
    @include('crm.group.manage.js')
@endpush
