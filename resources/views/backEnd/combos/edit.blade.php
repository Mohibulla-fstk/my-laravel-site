@extends('backEnd.layouts.master')
@section('title', 'Combo Edit')

@section('css')
    <link href="{{ asset('public/backEnd/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd/assets/libs/summernote/summernote-lite.min.css') }}" rel="stylesheet"
        type="text/css" />
    <style>
        .increment_btn,
        .remove_btn {
            margin-top: -17px;
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">

        <!-- start Combo title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ route('combos.index') }}" class="btn btn-primary rounded-pill">Manage Combos</a>
                    </div>
                    <h4 class="page-title">Edit Combo</h4>
                </div>
            </div>
        </div>
        <!-- end Combo title -->

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('combos.update', $combo->id) }}" method="POST" enctype="multipart/form-data"
                            class="row" data-parsley-validate="">
                            @csrf
                            @method('PUT')


                            <!-- Combo Name -->
                            <div class="form-group mb-3 col-sm-6">
                                <label for="name" class="form-label">Combo Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name', $combo->name) }}" id="name" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="form-group mb-3 col-sm-6">
                                <label for="category_id" class="form-label">Category *</label>
                                <select name="category_id" id="category_id"
                                    class="form-control select2 @error('category_id') is-invalid @enderror" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ (old('category_id', $combo->category_id) == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
<div class="col-sm-6">
    <div class="form-group mb-3">
        <label for="brand_id" class="form-label">Select Brand</label>
        <select name="brand_id" id="brand_id" class="form-control" required>
            <option value="">-- Select Brand --</option>
            @foreach(\App\Models\Brand::all() as $brand)
                <option value="{{ $brand->id }}" 
                    {{ (isset($combo) && $combo->brand_id == $brand->id) ? 'selected' : '' }}>
                    {{ $brand->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

                            <!-- Min Products -->
                            <div class="form-group mb-3 col-sm-6">
                                <label for="min_products" class="form-label">Min Products *</label>
                                <input type="number" name="min_products" id="min_products"
                                    class="form-control @error('min_products') is-invalid @enderror"
                                    value="{{ old('min_products', $combo->min_products) }}" required>
                                @error('min_products')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <!-- Max Products -->
                            <div class="form-group mb-3 col-sm-6">
                                <label for="max_products" class="form-label">Max Products *</label>
                                <input type="number" name="max_products" id="max_products"
                                    class="form-control @error('max_products') is-invalid @enderror"
                                    value="{{ old('max_products', $combo->max_products) }}" required>
                                @error('max_products')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <!-- Price -->
                            <div class="form-group mb-3 col-sm-6">
                                <label for="price" class="form-label">Combo Price *</label>
                                <input type="number" step="0.01" name="price" id="price"
                                    class="form-control @error('price') is-invalid @enderror"
                                    value="{{ old('price', $combo->price) }}" required>
                                @error('price')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <!-- Old Price -->
                            <div class="form-group mb-3 col-sm-6">
                                <label for="old_price" class="form-label">Old Price</label>
                                <input type="number" step="0.01" name="old_price" id="old_price"
                                    class="form-control @error('old_price') is-invalid @enderror"
                                    value="{{ old('old_price', $combo->old_price) }}">
                                @error('old_price')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <!-- New Price -->
                            <div class="form-group mb-3 col-sm-6">
                                <label for="new_price" class="form-label">New Price *</label>
                                <input type="number" step="0.01" name="new_price" id="new_price"
                                    class="form-control @error('new_price') is-invalid @enderror"
                                    value="{{ old('new_price', $combo->new_price) }}" required>
                                @error('new_price')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group mb-3 col-sm-6">
                                <label for="stock" class="form-label">Stock *</label>
                                <input type="number" step="0.01" name="stock" id="stock"
                                    class="form-control @error('stock') is-invalid @enderror"
                                    value="{{ old('stock', $combo->stock) }}" required>
                                @error('stock')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                                  <div class="col-sm-6">
    <div class="form-group mb-3">
        <label for="stockstatus" class="form-label">Stock Status *</label><br>
        <select class="form-control select2" name="stockstatus">
            <option value="">Select</option>
            <option value="IN STOCK" {{ (old('stockstatus', $combo->stockstatus) == 'IN STOCK') ? 'selected' : '' }}>IN STOCK</option>
            <option value="STOCK OUT" {{ (old('stockstatus', $combo->stockstatus) == 'STOCK OUT') ? 'selected' : '' }}>STOCK OUT</option>
        </select>
        @error('stockstatus')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

                            <!-- Image -->
                            <div class="col-sm-6 mb-3">
                                <label for="images">Image *</label>
                                <div class="input-group control-group increment">
                                    <input type="file" name="images[]"
                                        class="form-control @error('images') is-invalid @enderror" />
                                    <div class="input-group-btn">
                                        <button class="btn btn-success add-btn" type="button"><i
                                                class="fa fa-plus"></i></button>
                                    </div>
                                    @error('images')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="clone hide" style="display: none;">
                                    <div class="control-group input-group">
                                        <input type="file" name="images[]" class="form-control" />
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger remove-btn" type="button"><i
                                                    class="fa fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="product_img">
                                    @foreach($combo->images as $image)
                                        <img src="{{asset($image->image)}}" class="edit-image border" alt="" />
                                        <a href="{{ route('combo.image.destroy', $image->id) }}"
                                            class="btn btn-xs btn-danger waves-effect waves-light">
                                            <i class="mdi mdi-close"></i>
                                        </a>

                                    @endforeach
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="form-group mb-3">
                                <label for="description" class="form-label">Description *</label>
                                <textarea name="description" id="description"
                                    class="summernote form-control @error('description') is-invalid @enderror" rows="6"
                                    required>{{ old('description', $combo->description) }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <!-- Note -->
                            <div class="form-group mb-3">
                                <label for="note" class="form-label">Note</label>
                                <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror"
                                    rows="4">{{ old('note', $combo->note) }}</textarea>
                                @error('note')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-sm-3 mb-3">
                                <div class="form-group">
                                    <label for="status" class="d-block">Status</label><br>
                                    <label class="switch">
                                        <input type="checkbox" value="1" name="status" @if($combo->status==1)checked @endif/>
                                        <span class="slider round"></span>
                                    </label>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-sm-6 -->

                            <div class="col-12">
                                <input type="submit" class="btn btn-success" value="Update Combo">
                            </div>

                        </form>
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>

    </div>
@endsection

@section('script')
    <script src="{{ asset('public/backEnd/assets/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('public/backEnd/assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ asset('public/backEnd/assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('public/backEnd/assets/libs/summernote/summernote-lite.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $(".select2").select2();
            $(".summernote").summernote({
                placeholder: "Enter Your Text Here",
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addBtn = document.querySelector('.add-btn');
            addBtn.addEventListener('click', function () {
                const clone = document.querySelector('.clone').cloneNode(true);
                clone.style.display = 'flex';
                clone.classList.remove('clone');
                this.closest('.col-sm-6').appendChild(clone);

                // Add remove functionality to new button
                clone.querySelector('.remove-btn').addEventListener('click', function () {
                    this.closest('.input-group').remove();
                });
            });

            // Initial remove button functionality
            document.querySelectorAll('.remove-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    this.closest('.input-group').remove();
                });
            });
        });
    </script>
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function () {
                // add image input
                $(".btn-increment").click(function () {
                    var html = $(".clone").html();
                    $(".increment").after(html);
                });

                // remove image input
                $("body").on("click", ".btn-danger", function () {
                    $(this).parents(".control-group").remove();
                });
            });
        </script>

    @endpush

@endsection