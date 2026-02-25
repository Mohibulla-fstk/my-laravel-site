@extends('backEnd.layouts.master')
@section('title','Manage Collection Items')

@section('content')
<div class="container-fluid">

    <!-- title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{ route('collections.index') }}" class="btn btn-secondary rounded-pill">
                        Back
                    </a>
                </div>
                <h4 class="page-title">
                    Manage Items: <span class="text-primary">{{ $collection->name }}</span>
                </h4>
            </div>
        </div>
    </div>
@php
    $badges = ['Hot', 'Winter', 'New', 'On Sale', 'Latest', 'Trending', 'Featured'];
@endphp

    <div class="row">

        {{-- CATEGORY --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">Categories</div>
                <div class="card-body">
                    @foreach($categories as $cat)
                        @php
                            $exists = $addedItems->where('item_id',$cat->id)
                                ->where('item_type','category')->first();
                        @endphp

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>{{ $cat->name }}</span>

                            @if($exists)
                            <div class="d-flex gap-1 align-items-center">
                                <select class="form-select form-select-sm badge-select" 
                                        data-id="{{ $cat->id }}" 
                                        data-type="category"
                                        data-collection="{{ $collection->id }}">
                                    <option value="">No Badge</option>
                                    @foreach($badges as $badge)
                                        <option value="{{ $badge }}" {{ $exists->item_badge == $badge ? 'selected' : '' }}>
                                            {{ $badge }}
                                        </option>
                                    @endforeach
                                </select>

                                <button class="btn btn-xs btn-danger remove-item"
                                    data-id="{{ $cat->id }}"
                                    data-type="category">
                                    <i class="mdi mdi-close"></i>
                                </button>
                            </div>
                            @else
                            <div class="d-flex gap-1 align-items-center">
                                <select class="form-select form-select-sm badge-select" 
                                        data-id="{{ $cat->id }}" 
                                        data-type="category"
                                        data-collection="{{ $collection->id }}">
                                    <option value="">No Badge</option>
                                    @foreach($badges as $badge)
                                        <option value="{{ $badge }}">{{ $badge }}</option>
                                    @endforeach
                                </select>

                                <button class="btn btn-xs btn-success add-item"
                                    data-id="{{ $cat->id }}"
                                    data-type="category">
                                    <i class="mdi mdi-plus"></i>
                                </button>
                            </div>
                            @endif


                        </div>

                    @endforeach
                </div>
            </div>
        </div>

        {{-- SUB CATEGORY --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">Sub Categories</div>
                <div class="card-body">
                    @foreach($subcategories as $sub)
                        @php
                            $exists = $addedItems->where('item_id',$sub->id)
                                ->where('item_type','subcategory')->first();
                        @endphp

                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $sub->subcategoryName }}</span>

                           @if($exists)
                            <div class="d-flex gap-1 align-items-center">
                                <select class="form-select form-select-sm badge-select" 
                                        data-id="{{ $sub->id }}" 
                                        data-type="subcategory"
                                        data-collection="{{ $collection->id }}">
                                    <option value="">No Badge</option>
                                    @foreach($badges as $badge)
                                        <option value="{{ $badge }}" {{ $exists->item_badge == $badge ? 'selected' : '' }}>
                                            {{ $badge }}
                                        </option>
                                    @endforeach
                                </select>

                                <button class="btn btn-xs btn-danger remove-item"
                                    data-id="{{ $sub->id }}"
                                    data-type="subcategory">
                                    <i class="mdi mdi-close"></i>
                                </button>
                            </div>
                            @else
                            <div class="d-flex gap-1 align-items-center">
                                <select class="form-select form-select-sm badge-select" 
                                        data-id="{{ $sub->id }}" 
                                        data-type="subcategory"
                                        data-collection="{{ $collection->id }}">
                                    <option value="">No Badge</option>
                                    @foreach($badges as $badge)
                                        <option value="{{ $badge }}">{{ $badge }}</option>
                                    @endforeach
                                </select>

                                <button class="btn btn-xs btn-success add-item"
                                    data-id="{{ $sub->id }}"
                                    data-type="subcategory">
                                    <i class="mdi mdi-plus"></i>
                                </button>
                            </div>
                            @endif

                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- CHILD CATEGORY --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">Child Categories</div>
                <div class="card-body">
                    @foreach($childcategories as $child)
                        @php
                            $exists = $addedItems->where('item_id',$child->id)
                                ->where('item_type','childcategory')->first();
                        @endphp

                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $child->childcategoryName }}</span>

                            @if($exists)
                                <div class="d-flex gap-1 align-items-center">
                                    <select class="form-select form-select-sm badge-select" data-id="{{ $child->id }}" data-type="childcategory">
                                        <option value="">No Badge</option>
                                        @foreach($badges as $badge)
                                            <option value="{{ $badge }}"
                                                {{ $exists->item_badge == $badge ? 'selected' : '' }}>
                                                {{ $badge }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <button class="btn btn-xs btn-danger remove-item"
                                        data-id="{{ $child->id }}"
                                        data-type="childcategory">
                                        <i class="mdi mdi-close"></i>
                                    </button>
                                </div>
                            @else
                                <div class="d-flex gap-1 align-items-center">
                                    <select class="form-select form-select-sm badge-select" data-id="{{ $child->id }}" data-type="childcategory">
                                        <option value="">No Badge</option>
                                        @foreach($badges as $badge)
                                            <option value="{{ $badge }}">{{ $badge }}</option>
                                        @endforeach
                                    </select>

                                    <button class="btn btn-xs btn-success add-item"
                                        data-id="{{ $child->id }}"
                                        data-type="childcategory">
                                        <i class="mdi mdi-plus"></i>
                                    </button>
                                </div>
                            @endif


                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@section('script')
<script>
// Add Item
$('.add-item').click(function () {
    let btn = $(this);
    let badge = btn.closest('div').find('.badge-select').val();

    $.post("{{ route('collections.addItem') }}", {
        _token: "{{ csrf_token() }}",
        collection_id: "{{ $collection->id }}",
        item_id: btn.data('id'),
        item_type: btn.data('type'),
        item_badge: badge
    }, function () {
    location.reload();
        btn.prop('disabled', true); // Add button disable after adding
    });
});

// Remove Item
$('.remove-item').click(function(){
    let btn = $(this);

    $.post("{{ route('collections.removeItem') }}", {
        _token: "{{ csrf_token() }}",
        collection_id: "{{ $collection->id }}",
        item_id: btn.data('id'),
        item_type: btn.data('type')
    }, function(){
    location.reload();
        btn.closest('div').find('.add-item').prop('disabled', false); // Enable Add button again
        btn.closest('div').find('.badge-select').val(''); // Reset badge
    });
});

// Live update badge
$('.badge-select').change(function(){
    let select = $(this);
    let badge = select.val();
    let id = select.data('id');
    let type = select.data('type');

    $.post("{{ route('collections.updateBadge') }}", {
        _token: "{{ csrf_token() }}",
        collection_id: "{{ $collection->id }}",
        item_id: id,
        item_type: type,
        item_badge: badge
    }, function(res){
        // Optionally show toast or success message
        console.log('Badge updated:', badge);
    });
});

</script>
@endsection
