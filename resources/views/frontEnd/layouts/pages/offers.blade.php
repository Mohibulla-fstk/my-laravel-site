@extends('frontEnd.layouts.master')
@section('title', 'Hot Deals')

@section('content')
    <div class="blankspace"></div>

    <span>
        klk
    </span>
@endsection
@push('script')
    <script>
        $(".sort").change(function () {
            $('#loading').show();
            $(".sort-form").submit();
        })
    </script>
@endpush