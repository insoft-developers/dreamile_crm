@extends('crm.master')

@section('content')

<main class="app-wrapper">

    <div class="container-fluid">

        <div class="main-breadcrumb d-flex align-items-center my-3 position-relative">

            <h2 class="breadcrumb-title mb-0 flex-grow-1 fs-14"></h2>

            <div class="flex-shrink-0">
                <nav aria-label="breadcrumb">

                    <ol class="breadcrumb justify-content-end mb-0">

                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">Dashboard</a>
                        </li>

                        <li class="breadcrumb-item active" aria-current="page">
                            Partnership
                        </li>

                        <li class="breadcrumb-item active" aria-current="page">
                            Partner List
                        </li>

                    </ol>

                </nav>
            </div>

        </div>


        <div class="row">

            <div class="col-12">

                <div class="card">

                    <!-- Card Header -->
                    <div class="card-header">

                        <h5 class="card-title mb-0">
                            Partner List
                        </h5>

                        <button
                            onclick="addData()"
                            title="Add Data"
                            class="me-0 btn btn-success btn-sm">

                            <i class="bi bi-plus"></i>

                        </button>

                    </div>


                    <!-- Card Body -->
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


                                        <!-- Consultant -->
                                        <div class="col-md-2">
                                            <label>Jenis Partner</label>
                                            <select style="width: 100%;" id="filter_jenis_partner" name="filter_jenis_partner"
                                                class="form-control select2">
                                                <option value="">- Semua -</option>
                                                @foreach ($type??[] as $t)
                                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Branch -->
                                        <div class="col-md-2">
                                            <label>PIC Dreamile</label>
                                            <select style="width:100%;" id="filter_pic_dreamile" name="filter_pic_dreamile" class="form-control select2">
                                                <option value="">- Semua -</option>
                                                @foreach ($users??[] as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                         <div class="col-md-2">
                                            <label>Provinsi</label>
                                            <select style="width:100%;" id="filter_provinsi" name="filter_provinsi" class="form-control select2">
                                                <option value="">- Semua -</option>
                                               
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label>Kabupaten/Kota</label>
                                            <select style="width:100%;" id="filter_kota" name="filter_kota" class="form-control select2">
                                                <option value="">- Semua -</option>
                                                @foreach ($users??[] as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <!-- Tombol -->
                                        <div class="col-md-12 mt-3 d-flex">

                                            <button type="button" onclick="filterData()"
                                                class="btn btn-primary btn-sm">
                                                <i class="bi bi-search"></i> Filter
                                            </button>

                                            <button style="margin-left: 2px;" type="button" onclick="resetFilter()"
                                                class="btn btn-secondary btn-sm">
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

                            <table
                                width="100%"
                                id="list-table"
                                class="table table-nowrap table-striped table-bordered">

                                <thead>

                                    <tr>

                                        <th>ID</th>

                                        <th
                                            class="text-center"
                                            width="5%">
                                            No
                                        </th>

                                        <th
                                            class="text-center"
                                            width="8%">
                                            Aksi
                                        </th>
                                        <th>File</th>
                                        <th>Tanggal</th>
                                        <th>
                                            Nama Instansi
                                        </th>

                                        <th>
                                            Jenis Partner
                                        </th>

                                        <th>
                                            Provinsi
                                        </th>

                                        <th>
                                            Kab/Kota
                                        </th>

                                        <th>
                                            PIC
                                        </th>

                                        <th>
                                            Jabatan
                                        </th>

                                        <th>
                                            WhatsApp
                                        </th>

                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            PIC Dreamile
                                        </th>
                                        <th>
                                            Jenis Kerjasama
                                        </th>

                                        <th>
                                            Mou Expired Date
                                        </th>

                                    </tr>

                                </thead>

                                <tbody></tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</main>

@include('crm.partnership.list.modal')

@endsection


@push('scripts')

@include('crm.partnership.list.js')

@endpush