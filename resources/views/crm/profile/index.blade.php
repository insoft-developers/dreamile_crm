@extends('crm.master')

@section('content')
    <main class="app-wrapper">
        <div class="container-fluid">

            <div class="main-breadcrumb d-flex align-items-center my-3 position-relative">
                <h2 class="breadcrumb-title mb-0 flex-grow-1 fs-14">Profile</h2>
            </div>


            <div class="row">

                <div class="col-md-12">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="bi bi-exclamation-triangle"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">

                            @if (auth()->user()->photo_profile)
                                <img src="{{ asset('storage/' . auth()->user()->photo_profile) }}"
                                    class="rounded-circle mb-3" width="180" height="180" style="object-fit:cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}"
                                    class="rounded-circle mb-3" width="180" height="180">
                            @endif

                            <h5>{{ auth()->user()->name }}</h5>
                            <p class="text-muted">{{ auth()->user()->email }}</p>
                            <p class="text-muted">{{ auth()->user()->position }}</p>

                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title mb-0">Edit Profile</h5>
                        </div>

                        <div class="card-body">

                            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">

                                @csrf

                                <div class="mb-3">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ auth()->user()->name }}" required>
                                </div>

                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email"
                                        value="{{ auth()->user()->email }}" required>
                                </div>

                                <div class="mb-3">
                                    <label>Nomor HP</label>
                                    <input type="text" class="form-control" name="phone_number"
                                        value="{{ auth()->user()->phone_number }}">
                                </div>

                                <div class="mb-3">
                                    <label>Foto Profil</label>
                                    <input type="file" class="form-control" name="photo_profile" accept="image/*">
                                </div>

                                <hr>

                                <h6>Ganti Password</h6>

                                <div class="mb-3">
                                    <label>Password Baru</label>
                                    <input type="password" class="form-control" name="password">
                                </div>

                                <div class="mb-3">
                                    <label>Konfirmasi Password</label>
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    Simpan Perubahan
                                </button>

                            </form>

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </main>
@endsection
