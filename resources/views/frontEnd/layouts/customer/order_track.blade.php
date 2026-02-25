@extends('frontEnd.layouts.master')
@section('title')
<title>Order Track</title>
@section('content')
    <div class="blankspace"></div>
    <div class="gradient-bg">
        <Span>Order Track</Span>
    </div>

    <section class="auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-5">
                    <div class="form-content">
                        <p class="auth-title">Order Track </p>
                        <form action="{{route('customer.order_track_result')}}" data-parsley-validate="">
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

                                <input type="number" id="invoice_id"
                                    class="form-control @error('invoice_id') is-invalid @enderror" name="invoice_id"
                                    value="{{ old('invoice_id') }}" required>
                                <label class="invoicelabel" for="invoice_id">Enter Your Invoice ID</label>
                                @error('invoice_id')
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