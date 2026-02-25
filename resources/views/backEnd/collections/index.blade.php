@extends('backEnd.layouts.master')
@section('title','Collection Manage')

@section('css')

<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- start Collection title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">

                    {{-- Create Collection --}}
                    <a href="{{ route('collections.create') }}" class="btn btn-primary rounded-pill me-2">
                        Create Collection
                    </a>

                </div>
                <h4 class="page-title">Collection Manage</h4>
            </div>
        </div>
    </div>
     
    <!-- end Collection title --> 

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Drag</th>
                                <th>SL</th>
                                <th>Collection Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>               
                    
                        <tbody id="sortable-collections">
                        @foreach($collections->sortBy('sort_order') as $collection)
                        <tr data-id="{{ $collection->id }}">
                            {{-- Drag Handle with Icon --}}
                            <td class="drag-handle text-center" style="cursor: move; width: 40px;">
                                <i class="fa-sharp fa-solid fa-grip-dots-vertical text-muted"></i>
                                
                            </td>
                            <td>
                                <div class="small text-muted">
                                    {{ $loop->iteration }}
                                </div>
                            </td>
                            <td>{{ $collection->name }}</td>
                            <td>{{ $collection->slug }}</td>

                            <td>
                                @if($collection->status == 1)
                                    <span class="badge bg-soft-success text-success">Active</span>
                                @else
                                    <span class="badge bg-soft-danger text-danger">Inactive</span>
                                @endif
                            </td>

                            <td>
                                <div class="button-list">

                                    {{-- Status Toggle --}}
                                    @if($collection->status == 1)
                                    <form method="post" action="{{ route('collections.inactive') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="hidden_id" value="{{ $collection->id }}">
                                        <button type="submit"
                                            class="btn btn-xs btn-secondary waves-effect waves-light change-confirm">
                                            <i class="fe-thumbs-down"></i>
                                        </button>
                                    </form>
                                    @else
                                    <form method="post" action="{{ route('collections.active') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="hidden_id" value="{{ $collection->id }}">
                                        <button type="submit"
                                            class="btn btn-xs btn-success waves-effect waves-light change-confirm">
                                            <i class="fe-thumbs-up"></i>
                                        </button>
                                    </form>
                                    @endif

                                    {{-- Manage Items --}}
                                    <a href="{{ route('collections.items', $collection->id) }}"
                                    class="btn btn-xs btn-info waves-effect waves-light">
                                        <i class="fe-list"></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('collections.edit', $collection->id) }}"
                                    class="btn btn-xs btn-primary waves-effect waves-light">
                                        <i class="fe-edit-1"></i>
                                    </a>

                                    {{-- Delete --}}
                                    <form method="post" action="{{ route('collections.destroy') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="hidden_id" value="{{ $collection->id }}">
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
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
$(document).ready(function () {

    $("#sortable-collections").sortable({
        handle: ".drag-handle",
        items: "tr",
        cursor: "move",
        opacity: 0.8,
        axis: "y",
        placeholder: "sortable-placeholder",

        update: function () {

            let order = [];

            $("#sortable-collections tr").each(function (index) {
                order.push({
                    id: $(this).data("id"),
                    position: index + 1
                });
            });

            console.log(order); // 🔴 THIS MUST LOG

            $.ajax({
                url: "{{ route('collections.sort') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    order: order
                },
                success: function (res) {
                    console.log("Saved", res);
                    location.reload()
                },
                error: function (err) {
                    console.error(err);
                }
            });
        }
    });

});
</script>



<!-- third party js -->
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
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
