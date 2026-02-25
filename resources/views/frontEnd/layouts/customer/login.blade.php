@extends('frontEnd.layouts.master')
@section('title', 'Login')
@section('content')
    <div class="blankspace"></div>
    <div class="gradient-bg">
        <Span>Login</Span>
    </div>
    <section class="auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-5">
                    <div class="form-content">
                        <p class="auth-title">User Login </p>
                        <form action="{{route('customer.signin')}}" method="POST" data-parsley-validate="">
                            @csrf
                            <div class="form-group mb-3">

                                <input type="number" id="phone" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" value="{{ old('phone') }}" required>
                                <label class="phonelabel" for="phone">Phone Number</label>
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
                            <a href="{{route('customer.forgot.password')}}" class="forget-link"><i
                                    class="fa-solid fa-unlock"></i> Forget Password?</a>
                            <div class="form-group mb-3">
                                <button class="submit-btn"> Login </button>
                            </div>
                            <!-- col-end -->
                        </form>
                        <div class="register-now no-account">
                            <p> No any account? </p>
                            <a href="{{route('customer.signup')}}"><i data-feather="edit-3"></i> Sign Up</a>
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