@extends('backEnd.layouts.master')
@section('title', 'Combo Manager')

@section('css')
    <link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css"
        rel="stylesheet" type="text/css" />
    <link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css"
        rel="stylesheet" type="text/css" />
    <link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css"
        rel="stylesheet" type="text/css" />
    <link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css"
        rel="stylesheet" type="text/css" />
@endsection


@section('content')
    <div class="container-fluid">

        <!-- start Combo title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ route('combos.create') }}" class="btn btn-primary rounded-pill">Create</a>
                    </div>
                    <h4 class="page-title">Combo Manage</h4>
                </div>
            </div>
        </div>
        <!-- end Combo title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Action</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Image</th>
                                        <th>Min Products</th>
                                        <th>Max Products</th>
                                        <th>Price</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($combos as $combo)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="button-list">
                                                    @if($combo->status)
                                                        <form action="{{ route('combo.inactive') }}" method="POST"
                                                            style="display:inline;">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $combo->id }}">
                                                            <button type="submit"
                                                                class="change-confirm btn btn-xs btn-secondary waves-effect waves-light">
                                                                <i class="fe-thumbs-down"></i></button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('combo.active') }}" method="POST"
                                                            style="display:inline;">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $combo->id }}">
                                                            <button type="submit"
                                                                class="change-confirm btn btn-xs btn-success waves-effect waves-light">
                                                                <i class="fe-thumbs-up"></i></button>
                                                        </form>
                                                    @endif


                                                    <a href="{{ route('combos.edit', $combo->id) }}"
                                                        class="btn btn-xs btn-primary waves-effect waves-light">
                                                        <i class="fe-edit-1"></i>
                                                    </a>

                                                    <form method="post" action="{{ route('combos.destroy', $combo->id) }}"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-xs btn-danger waves-effect waves-light delete-confirm"><i
                                                                class="fe-trash-2"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td>{{ $combo->name }}</td>
                                            <td>{{ $combo->category->name ?? '-' }}</td>
                                            <td>
                                                @if($combo->images->isNotEmpty())
                                                    <img src="{{ asset($combo->images->first()->image) }}" class="backend-image"
                                                        alt="Combo Image" style="border-radius: 0;width:80px;height:100%">
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $combo->min_products }}</td>
                                            <td>{{ $combo->max_products }}</td>
                                            <td>{{ number_format($combo->price, 2) }}</td>
                                            <td>@if($combo->status == 1)<span
                                                class="badge bg-soft-success text-success">Active</span>
                                            @else
                                                    <span class="badge bg-soft-danger text-danger">Inactive</span>
                                                @endif
                                            </td>



                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
    </div>
@endsection

@section('script')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".checkall").on('change', function () {
                $(".checkbox").prop('checked', $(this).is(":checked"));
            });

            $(document).on('click', '.hotdeal_update', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                console.log('url', url);
                var product = $('input.checkbox:checked').map(function () {
                    return $(this).val();
                });
                var product_ids = product.get();
                if (product_ids.length == 0) {
                    toastr.error('Please Select A Product First !');
                    return;
                }
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: { product_ids },
                    success: function (res) {
                        if (res.status == 'success') {
                            toastr.success(res.message);
                            window.location.reload();
                        } else {
                            toastr.error('Failed something wrong');
                        }
                    }
                });
            });
            $(document).on('click', '.update_status', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var product = $('input.checkbox:checked').map(function () {
                    return $(this).val();
                });
                var product_ids = product.get();
                if (product_ids.length == 0) {
                    toastr.error('Please Select A Product First !');
                    return;
                }
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: { product_ids },
                    success: function (res) {
                        if (res.status == 'success') {
                            toastr.success(res.message);
                            window.location.reload();
                        } else {
                            toastr.error('Failed something wrong');
                        }
                    }
                });
            });
            $(document).on('click', '.update_status', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var product = $('input.checkbox:checked').map(function () {
                    return $(this).val();
                });
                var product_ids = product.get();
                if (product_ids.length == 0) {
                    toastr.error('Please Select A Product First !');
                    return;
                }
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: { product_ids },
                    success: function (res) {
                        if (res.status == 'success') {
                            toastr.success(res.message);
                            window.location.reload();
                        } else {
                            toastr.error('Failed something wrong');
                        }
                    }
                });
            });


        })
    </script>
@endsection