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
                            <li class="breadcrumb-item active" aria-current="page">Settings</li>
                            <li class="breadcrumb-item active" aria-current="page">Company</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <!--start::card-->
                        <div class="card-header">
                            <h5 class="card-title mb-0"> Company Data </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table width="100%" id="list-table" class="table table-nowrap table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th class="text-center" width="5%">No</th>
                                            <th class="text-center">Aksi</th>
                                            <th>Company Name</th>
                                            <th>Address</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>PIC</th>
                                            <th>Updated At</th>
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
    @include('crm.settings.company.modal')
@endsection

@push('scripts')
    @include('crm.settings.company.js')
@endpush
