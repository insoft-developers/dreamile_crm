<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Log In | CRM - Dreamile International </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta content="CRM - Dreamile International" name="description" />
    <meta content="Pixeleyez" name="author" />

    <!-- layout setup -->
    <script type="module" src="{{ asset('template/crm') }}/assets/js/layout-setup.js"></script>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/logo_trans.png') }}"> <!-- Simplebar Css -->
    <link rel="stylesheet" href="{{ asset('template/crm') }}/assets/libs/simplebar/simplebar.min.css">
    <!-- Swiper Css -->
    <link href="{{ asset('template/crm') }}/assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet">
    <!-- Nouislider Css -->
    <link href="{{ asset('template/crm') }}/assets/libs/nouislider/nouislider.min.css" rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="{{ asset('template/crm') }}/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
        type="text/css">
    <!--icons css-->
    <link href="{{ asset('template/crm') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{ asset('template/crm') }}/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">

    <style>
        .dreamile-title {
            position: absolute;
            left: 111px;
        }
    </style>
</head>

<body>
    <!-- START -->
    <div class="position-fixed top-0 bottom-0 end-0 start-0 z-0 bg-pattern"></div>
    <div class="auth-pattern-shapes d-none d-lg-block"></div>
    <div class="auth-pattern-outline d-none d-lg-block"></div>
    <div class="auth-pattern-shape extra d-none d-lg-block"></div>
    <div class="auth-pattern-extra d-none d-lg-block"></div>
    <header
        class="px-3 px-md-8 py-5 position-absolute top-0 d-flex justify-content-between align-items-center w-100 z-1">
        <a href="{{ url('/') }}" class="d-flex align-items-end logo-main">
            <img height="85" class="logo-dark" alt="Dark Logo" src="{{ asset('images/logo_trans.png') }}">

        </a>
        <h3 class="text-body-emphasis fw-bolder mb-0 ms-1 dreamile-title">CRM - Dreamile International</h3>

    </header>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100 pt-20 pb-10">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card mx-xxl-8 shadow-none">
                    <div class="card-body p-8">
                        <h3 class="fw-medium text-center">Login</h3>
                        @if ($errors->any())
                            <div style="color:red;">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-4">
                                <label for="email" class="form-label">Email <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter your email" required>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Password <span
                                        class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter your password" required>
                                    <button type="button"
                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted toggle-password"
                                        id="toggle-password" data-target="password"><i
                                            class="ri-eye-off-line align-middle"></i></button>
                                </div>
                            </div>
                            <div class="my-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">Remember me</label>
                                    </div>
                                    <div class="form-text">
                                        <a href="auth-forgot-password.html" class="link">Forgot password?</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary w-100 mb-4">Login</button>

                            </div>
                        </form>

                    </div>
                </div>
                <p class="position-relative text-center fs-13 mb-0">©
                    <script>
                        document.write(new Date().getFullYear())
                    </script> Dreamile International.
                </p>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('template/crm') }}/assets/libs/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('template/crm') }}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('template/crm') }}/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ asset('template/crm') }}/assets/js/scroll-top.init.js"></script>
    <script src="{{ asset('template/crm') }}/assets/js/auth/auth.init.js"></script>
</body>

</html>
