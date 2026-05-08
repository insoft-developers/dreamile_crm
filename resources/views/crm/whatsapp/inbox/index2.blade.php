@extends('crm.master')

@section('content')

<main class="app-wrapper">

    <div class="container-fluid">

        {{-- BREADCRUMB --}}
        <div class="main-breadcrumb d-flex align-items-center my-3 position-relative">

            <h2 class="breadcrumb-title mb-0 flex-grow-1 fs-16 fw-semibold">
            </h2>

            <div class="flex-shrink-0">

               

            </div>

        </div>

        {{-- LIVEWIRE COMPONENT --}}
        <livewire:whatsapp.inbox />

    </div>

</main>

@endsection