@extends('backEnd.layouts.master')
@section('title','Size Edit')
@section('css')
<link href="{{asset('public/backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('public/backEnd')}}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    
    <!-- start Size title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{route('sizes.index')}}" class="btn btn-primary rounded-pill">Manage</a>
                </div>
                <h4 class="page-title">Size Edit</h4>
            </div>
        </div>
    </div>       
    <!-- end Size title --> 
   <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('sizes.update')}}" method="POST" class=row data-parsley-validate=""  enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$edit_data->id}}" name="id">
                    <div class="col-sm-6">
                        <div class="text-titlesetsection" style="margin-bottom: 10px;">
                                    <span class="form-label" style="font-size: 20px; font-weight: 600">For
                                        Shirt/T-shirt/Pants :</span>
                                </div>
                        <!-- <div class="form-group mb-3">
    <select class="form-control @error('sizetype') is-invalid @enderror" name="sizetype"
        id="sizetype" required>
        <option value="">Select SizeType *</option>
        <option value="Hove Chest" {{ (old('sizetype', $edit_data->sizetype) == 'Hove Chest') ? 'selected' : '' }}>
            Hove Chest
        </option>
        <option value="Waist" {{ (old('sizetype', $edit_data->sizetype) == 'Waist') ? 'selected' : '' }}>
            Waist
        </option>
    </select>
    @error('sizetype')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div> -->

                        <div class="form-group mb-3">
                        
                            <input type="text" placeholder="Size Name *" class="form-control @error('sizeName') is-invalid @enderror" name="sizeName" value="{{ $edit_data->sizeName}}"  id="sizeName" required="">
                            @error('sizeName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                        
                            <input type="text" placeholder="Chest Size *" class="form-control @error('chestSize') is-invalid @enderror" name="chestSize" value="{{ $edit_data->chestSize}}"  id="chestSize" required="">
                            @error('chestSize')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                        
                            <input type="text" placeholder="Hip Size *" class="form-control @error('hipSize') is-invalid @enderror" name="hipSize" value="{{ $edit_data->hipSize}}"  id="hipSize" required="">
                            @error('hipSize')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                        
                            <input type="text" placeholder="Length Name *" class="form-control @error('length') is-invalid @enderror" name="length" value="{{ $edit_data->length}}"  id="length" required="">
                            @error('length')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->                    
                    <div class="col-sm-6 mb-3">
                        <div class="form-group">
                            <label for="status" class="d-block">Status</label>
                            <label class="switch">
                              <input type="checkbox" value="1" name="status" @if($edit_data->status==1)checked @endif>
                              <span class="slider round"></span>
                            </label>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col end -->
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
<script src="{{asset('public/backEnd/')}}/assets/js/pages/form-advanced.init.js"></script>
<!-- Plugins js -->
<script src="{{asset('public/backEnd/')}}/assets/libs//summernote/summernote-lite.min.js"></script>
<script>
  $(".summernote").summernote({
    placeholder: "Enter Your Text Here",
    
  });
</script>
@endsection