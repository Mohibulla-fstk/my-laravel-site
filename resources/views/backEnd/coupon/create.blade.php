@extends('backEnd.layouts.master')
@section('title', 'Coupon Create')
@section('css')
    <link href="{{asset('public/backEnd')}}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet"
        type="text/css" />
@endsection
@section('content')
    <div class="container-fluid">

        <!-- start Coupon title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ route('coupon.index') }}" class="btn btn-primary">Manage</a>

                    </div>
                    <h4 class="page-title">Coupon Create</h4>
                </div>
            </div>
        </div>
        <!-- end Coupon title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('coupon.store') }}" method="POST" class="row" data-parsley-validate="">
                            @csrf

                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" name="code"
                                        value="{{ old('code') }}" id="code" required placeholder="Coupon Code *">
                                    @error('code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                                        <option value="">Select Type *</option>
                                        <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Percent
                                        </option>
                                        <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                        <option value="free_shipping" {{ old('type') == 'free_shipping' ? 'selected' : '' }}>
                                            Free Shipping</option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <input type="number" step="0.01"
                                        class="form-control @error('value') is-invalid @enderror" name="value"
                                        value="{{ old('value') }}" placeholder="Value">
                                    @error('value')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <input type="number" step="0.01"
                                        class="form-control @error('max_discount') is-invalid @enderror" name="max_discount"
                                        value="{{ old('max_discount') }}" placeholder="Max Discount">
                                    @error('max_discount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <input type="number" step="0.01"
                                        class="form-control @error('min_order_total') is-invalid @enderror"
                                        name="min_order_total" value="{{ old('min_order_total') }}"
                                        placeholder="Min Order Total">
                                    @error('min_order_total')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div> <!-- col-sm-6 -->

                            <div class="col-sm-6 mb-3">
                                <div class="form-group mb-3">
                                    <input type="number" class="form-control @error('max_uses') is-invalid @enderror"
                                        name="max_uses" value="{{ old('max_uses') }}" placeholder="Max Uses">
                                    @error('max_uses')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="is_active" class="d-block">Status</label>
                                    <label class="switch">
                                        <input type="checkbox" value="1" name="is_active" checked>
                                        <span class="slider round"></span>
                                    </label>
                                    @error('is_active')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label>Starts At</label>
                                    <input type="datetime-local" name="starts_at" class="form-control"
                                        value="{{ old('starts_at') }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label>Expires At</label>
                                    <input type="datetime-local" name="expires_at" class="form-control"
                                        value="{{ old('expires_at') }}">
                                </div>
                            </div> <!-- col-sm-6 -->

                            <div class="col-12">
                                <input type="submit" class="btn btn-success" value="Submit">
                            </div>

                        </form>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
    </div>

@endsection



@section('script')
    <script src="{{asset('public/backEnd/')}}/assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="{{asset('public/backEnd/')}}/assets/js/pages/form-validation.init.js"></script>
    <script src="{{asset('public/backEnd/')}}/assets/js/pages/form-advanced.init.js"></script>
    <!-- Plugins js -->
    <script src="{{asset('public/backEnd/')}}/assets/libs//summernote/summernote-lite.min.js"></script>
    <script>
        $(".summernote").summernote({
            placeholder: "Enter Your Text Here",

        });
    </script>
@endsection