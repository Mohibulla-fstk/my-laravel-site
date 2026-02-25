@extends('frontEnd.layouts.master')
@section('title')
<title>Forgot Password Reset</title>
@section('content')
    <div class="blankspace"></div>
    <div class="gradient-bg">
        <Span>Forgot Password Verify</Span>
    </div>
    <section class="auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-5">
                    <div class="form-content">
                        <p class="auth-title">Forgot Password Verify</p>
                        <form action="{{route('customer.forgot.store')}}" method="POST" data-parsley-validate="">
                            @csrf
                            <div class="form-group mb-3">

                                <input type="number" id="otp" class="form-control @error('otp') is-invalid @enderror"
                                    name="otp" value="{{ old('otp') }}" required>
                                <label class="otplabel" for="otp">OTP</label>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- col-end -->

                            <div class="form-group mb-3">

                                <input type="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    value="{{ old('password') }}" required>
                                <label class="passlabel" for="password">Password</label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- col-end -->
                            <div class="form-group mb-3">
                                <button class="submit-btn">submit</button>
                            </div>
                            <!-- col-end -->
                        </form>
                        <div class="resend_otp">
                            <form action="{{route('customer.forgot.resendotp')}}" method="POST">
                                @csrf
                                <button><i data-feather="rotate-cw"></i> Resend OTP</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script src="{{asset('public/frontEnd/')}}/js/parsley.min.js"></script>
    <script src="{{asset('public/frontEnd/')}}/js/form-validation.init.js"></script>
@endpush