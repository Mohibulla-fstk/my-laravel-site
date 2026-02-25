@extends('backEnd.layouts.master')
@section('title', 'Banner Create')
@section('css')
    <link href="{{asset('public/backEnd')}}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{asset('public/backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/backEnd')}}/assets/css/switchery.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{route('banners.index')}}" class="btn btn-primary rounded-pill">Manage</a>
                    </div>
                    <h4 class="page-title">Banner Create</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('banners.store') }}" method="POST" class="row" data-parsley-validate=""
                            enctype="multipart/form-data">
                            @csrf
                            <!-- Category -->
                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="category_id" class="form-label">Banner Category</label><br>
                                    <select class="form-control select2-multiple @error('category_id') is-invalid @enderror"
                                        name="category_id" id="category_id" data-toggle="select2"
                                        data-placeholder="Choose ..." required="">
                                        <option value="">Select..</option>
                                        @foreach($categories as $value)
                                            <option value="{{ $value->id }}" data-text="{{ $value->text_field }}">
                                                {{ $value->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div id="banner_text_fields" style="display:none;">
                                <!-- Banner Title -->


                                <div class="col-sm-6 mb-3">
                                    <div class="form-group">
                                        <label for="text_status" class="d-block">Text Status</label>
                                        <label class="switch">
                                            <input type="checkbox" value="1" name="text_status" id="text_status">
                                            <span class="slider round"></span>
                                        </label>
                                        @error('text_status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div id="title_fields" style="display:none;">
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="title" class="form-label">Title *</label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                name="title" value="{{ old('title') }}" id="title">
                                            @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label for="titlecolor" class="form-label">Title Color *</label>
                                            <input type="color"
                                                class="form-control @error('titlecolor') is-invalid @enderror"
                                                name="titlecolor" value="{{ old('titlecolor') }}" id="titlecolor"
                                                required="">
                                            @error('titlecolor')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Banner Subtitle -->
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="subtitle" class="form-label">Subtitle *</label>
                                            <input type="text" class="form-control @error('subtitle') is-invalid @enderror"
                                                name="subtitle" value="{{ old('subtitle') }}" id="subtitle">
                                            @error('subtitle')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label for="titlecolor" class="form-label">SubTitle Color *</label>
                                            <input type="color"
                                                class="form-control @error('subtitlecolor') is-invalid @enderror"
                                                name="subtitlecolor" value="{{ old('subtitlecolor') }}" id="subtitlecolor"
                                                required="">
                                            @error('subtitlecolor')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Button Text -->
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="button_text" class="form-label">Button Text *</label>
                                            <input type="text"
                                                class="form-control @error('button_text') is-invalid @enderror"
                                                name="button_text" value="{{ old('button_text') }}" id="button_text">
                                            @error('button_text')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label for="titlecolor" class="form-label">Button Color *</label>
                                            <input type="color"
                                                class="form-control @error('buttoncolor') is-invalid @enderror"
                                                name="buttoncolor" value="{{ old('buttoncolor') }}" id="buttoncolor"
                                                required="">
                                            @error('buttoncolor')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label for="titlecolor" class="form-label">Button text Color *</label>
                                            <input type="color"
                                                class="form-control @error('buttontextcolor') is-invalid @enderror"
                                                name="buttontextcolor" value="{{ old('buttontextcolor') }}"
                                                id="buttontextcolor" required="">
                                            @error('buttontextcolor')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Link -->
                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="link" class="form-label">Redirect Link *</label>
                                    <input type="text" class="form-control @error('link') is-invalid @enderror" name="link"
                                        value="{{ old('link') }}" id="link" placeholder="By Default set #" required="">
                                    @error('link')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>

                            <!-- Image -->
                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="image" class="form-label">Image *</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        name="image" id="image" required="">
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-sm-6 mb-3">
                                <div class="form-group">
                                    <label for="status" class="d-block">Status</label>
                                    <label class="switch">
                                        <input type="checkbox" value="1" name="status" checked>
                                        <span class="slider round"></span>
                                    </label>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div>
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
    <script src="{{asset('public/backEnd/')}}/assets/libs/select2/js/select2.min.js"></script>
    <script src="{{asset('public/backEnd/')}}/assets/js/pages/form-advanced.init.js"></script>
    <script src="{{asset('public/backEnd/')}}/assets/js/switchery.min.js"></script>

    <script src="{{asset('public/backEnd/')}}/assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="{{asset('public/backEnd/')}}/assets/js/pages/form-validation.init.js"></script>
    <script src="{{asset('public/backEnd/')}}/assets/js/pages/form-advanced.init.js"></script>
    <!-- Plugins js -->
    <script src="{{asset('public/backEnd/')}}/assets/libs//summernote/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function () {
            const $categorySelect = $('#category_id');
            const $textFieldsDiv = $('#banner_text_fields');

            function toggleTextFields() {
                const textField = $categorySelect.find(':selected').data('text');
                if (textField == 1) {
                    $textFieldsDiv.show();
                } else {
                    $textFieldsDiv.hide();
                }
            }

            // on select change
            $categorySelect.on('change', toggleTextFields);

            // trigger on page load
            toggleTextFields();
        });
    </script>
    <script>
        $(document).ready(function () {
            const $checkbox = $('#text_status');
            const $titleFields = $('#title_fields');

            function toggleTitleFields() {
                if ($checkbox.is(':checked')) {
                    $titleFields.show();
                } else {
                    $titleFields.hide();
                }
            }

            // on change
            $checkbox.on('change', toggleTitleFields);

            // page load check
            toggleTitleFields();
        });
    </script>



    <script>
        $(".summernote").summernote({
            placeholder: "Enter Your Text Here",

        });
    </script>
    <script>
        $(document).ready(function () {
            var elem = document.querySelector('.js-switch');
            var init = new Switchery(elem);
        });
    </script>
@endsection