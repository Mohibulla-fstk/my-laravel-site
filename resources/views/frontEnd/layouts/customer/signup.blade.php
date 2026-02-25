@extends('frontEnd.layouts.master')
@section('title', 'Customer Register')

@section('content')
    <div class="blankspace"></div>
    <div class="gradient-bg">
        <Span>Sign Up</Span>
    </div>
    <section class="auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-5">
                    <div class="form-content">
                        <p class="auth-title"> Sign up</p>
                        <form action="{{route('customer.store')}}" method="POST" data-parsley-validate="">
                            @csrf
                            <div class="form-group mb-3">

                                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required>
                                <label class="namelabel" for="name">Your Name</label>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- col-end -->
                            <div class="form-group mb-3">

                                <input type="number" id="phone" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" value="{{ old('phone') }}" required>
                                <label class="phonelabel" for="phone"> Phone Number</label>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- col-end -->
                            <!--<div class="form-group mb-3">-->
                            <!--    <label for="email"> ইমেইল </label>-->
                            <!--    <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="ইমেইল">-->
                            <!--    @error('email')-->
                            <!--        <span class="invalid-feedback" role="alert">-->
                            <!--            <strong>{{ $message }}</strong>-->
                            <!--        </span>-->
                            <!--    @enderror-->
                            <!--</div>-->
                            <!-- col-end -->
                            <div class="form-group mb-3">

                                <input type="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    value="{{ old('password') }}" required>
                                <label class="passlabel" for="password"> Password </label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- col-end -->
                            <button class="submit-btn">Sign up</button>
                            <div class="register-now no-account">
                                <p><i class="fa-solid fa-user"></i> If registered?</p>
                                <a href="{{route('customer.login')}}"><i data-feather="edit-3"></i> Log in </a>
                            </div>
                        </form>
                    </div>
                    <!-- col-end -->



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