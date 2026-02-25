<!doctype html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    @if($generalsetting && $generalsetting->favicon)
        <link rel="shortcut icon" href="{{ asset($generalsetting->favicon) }}" />
    @endif

    <title>Forgot Password | {{ optional($generalsetting)->name ?? 'YourSiteName' }}</title>

    <!-- google font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">

    <!-- aiz core css -->
    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/assets_login/css/vendors.css">
    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/assets_login/css/aiz-core.css">

    <style>
        body {
            font-size: 12px;
        }
        .dot-bg {
            background-image: radial-gradient(#a583ea4d 1.5px, #0000 0);
            background-size: 20px 20px;
            position: relative;
        }

    .nav-tabs .nav-link {
        background-color: #f8f9fa; /* light default */
        color: #000;
        transition: background 0.3s;
    }
    /* Active tab background black */
    .nav-tabs .nav-link.active {
        background-color: #1a1a1b;
        color: #fff;
    }

    /* Optional: hover effect */
    .nav-tabs .nav-link:hover {
        background-color: #1a1a1b;
        color: #fff;
    }
    </style>
</head>

<body>

<div class="aiz-main-wrapper d-flex dot-bg">
    <div class="flex-grow-1">
        <div class="h-100 bg-cover bg-center py-5 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-xl-4 mx-auto">
                        <div class="card text-left">
                            <div class="card-body">

                                <div class="mb-5 text-center">
                                    <img src="{{ asset(optional($generalsetting)->dark_logo ?? 'default-logo.png') }}"
                                         class="mw-100 mb-4" height="40">

                                    <h1 class="h3 text-primary mb-0">
                                        {{ optional($generalsetting)->name ?? 'My Website' }}
                                    </h1>
                                    <p>Choose how you want to reset your password</p>
                                </div>

                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <!-- Tabs -->
                                <ul class="nav nav-tabs mb-3" id="resetTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="link-tab" data-bs-toggle="tab" href="#link" role="tab">Reset Link</a>
                                    </li>
                                    <li style="margin: 10px 8px 0 8px">Or</li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="otp-tab" data-bs-toggle="tab" href="#otp" role="tab">Get OTP</a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="resetTabContent">

                                    <!-- Reset Link Form -->
                                    <div class="tab-pane fade show active" id="link" role="tabpanel">
                                        <form method="POST" action="{{ route('password.email') }}">
                                            @csrf
                                            <div class="form-group">
                                                <input type="email"
                                                       name="email"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       value="{{ old('email') }}"
                                                       placeholder="Enter your email"
                                                       required autofocus>

                                                @error('email')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <button type="submit" class="btn btn-primary btn-lg btn-block mt-2">
                                                Send Password Reset Link
                                            </button>
                                        </form>
                                    </div>

                                    <!-- OTP Form -->
                                    <div class="tab-pane fade" id="otp" role="tabpanel">
                                        <form method="POST" action="{{ route('password.otp.send') }}">
                                            @csrf
                                            <div class="form-group">
                                                <input type="email"
                                                       name="email"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       value="{{ old('email') }}"
                                                       placeholder="Enter your email"
                                                       required autofocus>

                                                @error('email')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <button type="submit" class="btn btn-primary btn-lg btn-block mt-2">
                                                Send OTP
                                            </button>
                                        </form>
                                    </div>

                                </div>

                                <div class="text-center mt-3">
                                    <a href="{{ route('login') }}" class="text-reset fs-14">
                                        ← Back to Login
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('public/backEnd/')}}/assets_login/js/vendors.js"></script>
<script src="{{asset('public/backEnd/')}}/assets_login/js/aiz-core.js"></script>

<script>
    var triggerTabList = [].slice.call(document.querySelectorAll('#resetTab a'))
    triggerTabList.forEach(function (triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl)
        triggerEl.addEventListener('click', function (event) {
            event.preventDefault()
            tabTrigger.show()
        })
    })
</script>

</body>
</html>
