@extends('backEnd.layouts.master')
@section('title','All Categories')

@section('css')
<link href="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />
<link href="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" />
<link href="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" />
@endsection

@section('content')
 <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">All Categories Manage</h4>
            </div>
        </div>
    </div>
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <table id="datatable" class="table table-bordered table-striped nowrap w-100">
                    <thead>
                        <tr>
                            <th>Drag</th>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Badges</th>
                            <th>Status</th>
                            <th>Front View</th>
                        </tr>
                    </thead>

                   <tbody id="sortable">
                    @foreach($allCategories as $item)
                    <tr data-id="{{ $item->id }}" data-type="{{ $item->type }}">
                        
                        {{-- 🔥 Drag Handle --}}
                        <td class="text-center align-middle handle" style="cursor: move;">
                            <i class="fa-sharp fa-solid fa-grip-dots-vertical text-muted"></i>
                        </td>

                        {{-- 🔢 Serial (UI only, real serial = sort_order) --}}
                        <td class="sort-serial text-center align-middle">
                            {{ $item->sort_order }}
                        </td>

                        {{-- 📛 Name --}}
                        <td class="align-middle">
                            {{ $item->name }}
                        </td>

                        {{-- 🏷 Type --}}
                        <td class="align-middle">
                            @if($item->type == 'category')
                                <span class="badge bg-primary">Category</span>
                            @elseif($item->type == 'subcategory')
                                <span class="badge bg-success">Sub Category</span>
                            @else
                                <span class="badge bg-warning">Child Category</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $badges = ['Hot', 'Winter', 'New', 'On Sale', 'Latest', 'Trending', 'Featured'];
                            @endphp

                            <select class="form-select badge-select"
                                    data-id="{{ $item->id }}"
                                    data-type="{{ $item->type }}">
                                <option value="">No Badge</option>
                                @foreach($badges as $badge)
                                    <option value="{{ $badge }}" 
                                        {{ ($item->badge ?? '') == $badge ? 'selected' : '' }}>
                                        {{ $badge }}
                                    </option>
                                @endforeach
                            </select>
                        </td>


                        {{-- ✅ Status --}}
                        <td class="text-center align-middle">
                            <div class="form-check form-switch d-inline-block">
                                <input class="form-check-input status-toggle"
                                    type="checkbox"
                                    data-id="{{ $item->id }}"
                                    data-type="{{ $item->type }}"
                                    data-field="status"
                                    {{ $item->status == 1 ? 'checked' : '' }}>
                            </div>
                        </td>

                        {{-- 👁 Front View --}}
                        <td class="text-center align-middle">
                            <div class="form-check form-switch d-inline-block">
                                <input class="form-check-input status-toggle"
                                    type="checkbox"
                                    data-id="{{ $item->id }}"
                                    data-type="{{ $item->type }}"
                                    data-field="front_view"
                                    {{ $item->front_view == 1 ? 'checked' : '' }}>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>


                </table>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')

<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<!-- jQuery UI -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
$(document).ready(function () {
    $('.badge-select').on('change', function () {
    let badge = $(this).val();
    let itemId = $(this).data('id');
    let itemType = $(this).data('type');

    $.ajax({
        url: "{{ route('admin.update.badge') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            item_id: itemId,
            item_type: itemType, // ✅ category/subcategory/childcategory
            item_badge: badge
        },
        success: function (res) {
            if (res.status === 'success') {
                toastr.success('Badge updated successfully');
            }
        }
    });
});

});
</script>

<script>
$(document).ready(function() {

    // 🔥 Make table rows sortable
    $("#sortable").sortable({
        handle: ".handle",  // drag only by handle
        update: function(event, ui) {

            let order = [];

            // Loop through each row to get new order
            $("#sortable tr").each(function(index) {
                order.push({
                    id: $(this).data('id'),
                    type: $(this).data('type'),
                    sort_order: index + 1  // new serial
                });
            });

            // 🔥 AJAX call to update sort_order in DB
            $.ajax({
                url: "{{ route('allCategories.sort') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    order: order
                },
                success: function(response) {
                    toastr.success('Sorting updated successfully!');
                    
                    // Optionally: Update serial column UI
                    $("#sortable tr").each(function(index) {
                        $(this).find(".sort-serial").text(index + 1);
                    });
                    location.reload();
                },
                error: function() {
                    toastr.error('Something went wrong!');
                }
            });
        }
    });

    // Optional: make cursor 'move' when hover handle
    $(".handle").css("cursor", "move");
});
</script>

<script>
$(document).ready(function () {

    $('#datatable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[0, 'asc']]
    });

    // 🔥 Status & Front View Toggle
    $(document).on('change', '.status-toggle', function () {

        let el = $(this);

        $.ajax({
            url: "{{ route('all.categories.status') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: el.data('id'),
                type: el.data('type'),
                field: el.data('field'),
                value: el.is(':checked') ? 1 : 0
            },
            success: function () {
                toastr.success('Updated Successfully');
            },
            error: function () {
                toastr.error('Something went wrong');
                el.prop('checked', !el.is(':checked'));
            }
        });
    });

});
</script>

@endsection

