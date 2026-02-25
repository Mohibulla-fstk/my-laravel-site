@extends('backEnd.layouts.master')
@section('title', 'Coupon Mannager')

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

        <!-- start Coupon title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ route('coupon.create') }}" class="btn btn-primary rounded-pill">Create</a>
                    </div>
                    <h4 class="page-title">Coupon Manage</h4>
                </div>
            </div>
        </div>
        <!-- end Coupon title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Code</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                    <th>Max Discount</th>
                                    <th>Min Order Total</th>
                                    <th>Max Uses</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($coupons as $key => $coupon)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $coupon->code }}</td>
                                        <td>{{ ucfirst($coupon->type) }}</td>
                                        <td>{{ number_format($coupon->value, 2) }}</td>
                                        <td>{{ $coupon->max_discount ? number_format($coupon->max_discount, 2) : '-' }}</td>
                                        <td>{{ number_format($coupon->min_order_total, 2) }}</td>
                                        <td>{{ $coupon->max_uses ?? '-' }}</td>
                                        <td>
                                            @if($coupon->is_active)
                                                <span class="badge bg-soft-success text-success">Active</span>
                                            @else
                                                <span class="badge bg-soft-danger text-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="button-list">
                                                @if($coupon->is_active)
                                                    <form method="post" action="{{ route('coupon.inactive') }}" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" value="{{ $coupon->id }}" name="hidden_id">
                                                        <button type="submit"
                                                            class="btn btn-xs btn-secondary waves-effect waves-light change-confirm">
                                                            <i class="fe-thumbs-down"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form method="post" action="{{ route('coupon.active') }}" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" value="{{ $coupon->id }}" name="hidden_id">
                                                        <button type="submit"
                                                            class="btn btn-xs btn-success waves-effect waves-light change-confirm">
                                                            <i class="fe-thumbs-up"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                <a href="{{ route('coupon.edit', $coupon->id) }}"
                                                    class="btn btn-xs btn-primary waves-effect waves-light">
                                                    <i class="fe-edit-1"></i>
                                                </a>

                                                <form method="post" action="{{ route('coupon.destroy', $coupon->id) }}"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-xs btn-danger waves-effect waves-light delete-confirm">
                                                        <i class="mdi mdi-close"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
    </div>

@endsection


@section('script')
    <!-- third party js -->
    <script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script
        src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script
        src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script
        src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
    <script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
    <script src="{{asset('/public/backEnd/')}}/assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="{{asset('/public/backEnd/')}}/assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="{{asset('/public/backEnd/')}}/assets/js/pages/datatables.init.js"></script>
    <!-- third party js ends -->
@endsection