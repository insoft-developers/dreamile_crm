@extends('crm.master')

@section('content')

<main class="app-wrapper">

<div class="container-fluid">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between mb-4">

                <div>

                    <h4 class="fw-bold mb-1">
                       <button onclick="window.history.back()" title="Back to contact group" class="me-0 btn  btn-light btn-sm"><i
                                    class="bi bi-arrow-left"></i></button> {{ $broadcast->name }}
                    </h4>

                    <p class="text-muted mb-0">
                        Template:
                        {{ $broadcast->template_name }}
                    </p>

                </div>

                <div>

                    <span class="badge bg-primary rounded-pill px-4 py-2">
                        {{ strtoupper($broadcast->status) }}
                    </span>

                </div>

            </div>

            <div class="row mb-4">

                <div class="col-md-4">

                    <div class="card border-0 bg-success-subtle">

                        <div class="card-body">

                            <h3>{{ $broadcast->sent }}</h3>

                            <p class="mb-0">
                                Sent
                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card border-0 bg-danger-subtle">

                        <div class="card-body">

                            <h3>{{ $broadcast->failed }}</h3>

                            <p class="mb-0">
                                Failed
                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card border-0 bg-primary-subtle">

                        <div class="card-body">

                            <h3>{{ $broadcast->total }}</h3>

                            <p class="mb-0">
                                Total
                            </p>

                        </div>

                    </div>

                </div>

            </div>

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Contact Name</th>
                            <th>Phone</th>

                            <th>Status</th>

                            <th>Error</th>

                            <th>Time</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($details as $item)

                        <tr>
                            <td>
                                {{ $item->customer?->fullname ?? '' }}
                            </td>
                            <td>
                                {{ $item->phone }}
                            </td>

                            <td>

                                @if($item->status == 'sent')

                                <span class="badge bg-success">
                                    SENT
                                </span>

                                @elseif($item->status == 'failed')

                                <span class="badge bg-danger">
                                    FAILED
                                </span>

                                @else

                                <span class="badge bg-warning">
                                    PENDING
                                </span>

                                @endif

                            </td>

                            <td style="white-space:normal;width:200px;">
                                <span>{{ $item->error }}</span>
                            </td>

                            <td>
                                {{ $item->updated_at }}
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</main>

@endsection