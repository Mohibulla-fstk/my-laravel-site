@extends('backEnd.layouts.master')
@section('title', 'Banner Edit')
@section('css')
    <link href="{{asset('public/backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
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
                    <h4 class="page-title">Banner Edit</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('banners.update') }}" method="POST" class="row" data-parsley-validate=""
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $edit_data->id }}" name="id">

                            <!-- Category -->
                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="category_id" class="form-label">Banner Category</label>
                                    <select class="form-control select2-multiple @error('category_id') is-invalid @enderror"
                                        name="category_id" id="category_id" data-toggle="select2"
                                        data-placeholder="Choose ..." required>
                                        <option value="">Select..</option>
                                        @foreach($categories as $value)
                                            <option value="{{ $value->id }}" data-text="{{ $value->text_field }}"
                                                @if($edit_data->category_id == $value->id) selected @endif>
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

                            <!-- Banner Text Fields -->
                            <div id="banner_text_fields" style="display:none;">

                                <!-- Text Status -->
                                <div class="col-sm-6 mb-3">
                                    <div class="form-group">
                                        <label for="text_status" class="d-block">Text Status</label>
                                        <label class="switch">
                                            <input type="checkbox" value="1" name="text_status" id="text_status"
                                                @if($edit_data->text_status == 1) checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                        @error('text_status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Title Fields -->
                                <div id="title_fields" style="display:none;">

                                    <!-- Title -->
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="title" class="form-label">Title *</label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                name="title" value="{{ $edit_data->title }}" id="title">
                                            @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Title Color -->
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label for="titlecolor" class="form-label">Title Color *</label>
                                            <input type="color"
                                                class="form-control @error('titlecolor') is-invalid @enderror"
                                                name="titlecolor" value="{{ $edit_data->titlecolor }}" id="titlecolor">
                                            @error('titlecolor')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Subtitle -->
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="subtitle" class="form-label">Subtitle *</label>
                                            <input type="text" class="form-control @error('subtitle') is-invalid @enderror"
                                                name="subtitle" value="{{ $edit_data->subtitle }}" id="subtitle">
                                            @error('subtitle')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Subtitle Color -->
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label for="subtitlecolor" class="form-label">SubTitle Color *</label>
                                            <input type="color"
                                                class="form-control @error('subtitlecolor') is-invalid @enderror"
                                                name="subtitlecolor" value="{{ $edit_data->subtitlecolor }}"
                                                id="subtitlecolor">
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
                                                name="button_text" value="{{ $edit_data->button_text }}" id="button_text">
                                            @error('button_text')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Button Color -->
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label for="buttoncolor" class="form-label">Button Color *</label>
                                            <input type="color"
                                                class="form-control @error('buttoncolor') is-invalid @enderror"
                                                name="buttoncolor" value="{{ $edit_data->buttoncolor }}" id="buttoncolor">
                                            @error('buttoncolor')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Button Text Color -->
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label for="buttontextcolor" class="form-label">Button Text Color *</label>
                                            <input type="color"
                                                class="form-control @error('buttontextcolor') is-invalid @enderror"
                                                name="buttontextcolor" value="{{ $edit_data->buttontextcolor }}"
                                                id="buttontextcolor">
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
                                        value="{{ $edit_data->link }}" id="link" required>
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
                                        name="image" id="image">
                                    @if($edit_data->image)
                                        <img src="{{ asset($edit_data->image) }}" alt="" class="edit-image mt-2"
                                            style="max-width:150px;">
                                    @endif
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="status" class="d-block">Status</label>
                                    <label class="switch">
                                        <input type="checkbox" value="1" name="status" @if($edit_data->status == 1) checked
                                        @endif>
                                        <span class="slider round"></span>
                                    </label>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit -->
                            <div>
                                <input type="submit" class="btn btn-success" value="Update">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('public/backEnd/')}}/assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="{{asset('public/backEnd/')}}/assets/js/pages/form-validation.init.js"></script>
    <script src="{{asset('public/backEnd/')}}/assets/libs/select2/js/select2.min.js"></script>
    <script src="{{asset('public/backEnd/')}}/assets/js/pages/form-advanced.init.js"></script>

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

            $categorySelect.on('change', toggleTextFields);
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

            $checkbox.on('change', toggleTitleFields);
            toggleTitleFields();
        });
    </script>
@endsection