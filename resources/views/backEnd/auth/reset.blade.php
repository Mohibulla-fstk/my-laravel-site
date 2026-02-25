<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password | {{ optional($generalsetting)->name ?? 'Admin Panel' }}</title>
    @if($generalsetting && $generalsetting->favicon)
        <link rel="shortcut icon" href="{{ asset($generalsetting->favicon) }}" />
    @endif
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('public/backEnd/assets_login/css/vendors.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backEnd/assets_login/css/aiz-core.css') }}">

    <style>
        body {
            font-size: 12px;
        }
        .dot-bg {
            background-image: radial-gradient(#a583ea4d 1.5px, #0000 0);
            background-size: 20px 20px;
            position: relative;
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
                                    <h1 class="h3 text-primary mb-0">Reset Password</h1>
                                    <p>Enter your email and new password.</p>
                                </div>

                                @if(session('status'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="form-group">
                                        <input id="email" type="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               name="email" value="{{ old('email') }}" required autofocus
                                               placeholder="Type old Email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input id="password" type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password" required placeholder="New Password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input id="password-confirm" type="password" class="form-control"
                                               name="password_confirmation" required placeholder="Confirm Password">
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                                        Reset Password
                                    </button>
                                </form>

                                <div class="text-center mt-3">
                                    <a href="{{ route('login') }}" class="text-reset fs-14">Back to Login</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="{{ asset('public/backEnd/assets_login/js/vendors.js') }}"></script>
<script src="{{ asset('public/backEnd/assets_login/js/aiz-core.js') }}"></script>
</body>
</html>
