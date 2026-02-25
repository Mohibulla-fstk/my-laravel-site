@extends('frontEnd.layouts.master')
@section('title')
<title>Forgot Password</title>

@section('content')
    <div class="blankspace"></div>
<div class="gradient-bg">
        <Span>Forgot Password</Span>
    </div>
    <section class="auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-5">
                    <div class="form-content">
                        <p class="auth-title">Forgot Password</p>
                        <form action="{{route('customer.forgot.verify')}}" method="POST" data-parsley-validate="">
                            @csrf
                            <div class="form-group mb-3">

                                <input type="number" id="phone" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" value="{{ old('phone') }}" required>
                                <label class="phonelabel" for="phone">Phone number</label>
                                @error('phone')
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