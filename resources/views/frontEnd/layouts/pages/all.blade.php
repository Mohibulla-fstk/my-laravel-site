@extends('frontEnd.layouts.master')

@section('title', 'All Categories')


@section('content')
    <div class="blankspace"></div>
    <div class="gradient-bg">
        <span>All Category</span>
        <div>Totall {{ $menucategories->count() }} Categories</div>
    </div>
    <div class="exmcontent" style="background-color: #1a1a1b;">
        <div class="container">

            <!-- <div id="page-header" class="page-header page-header--shop">
                                                                                        <div class="em-container clearfix">
                                                                                            <div class="page-header__content em-flex em-flex-column em-flex-align-center text-center">


                                                                                            </div>
                                                                                        </div>
                                                                                    </div> -->

            <!-- @if($categories->count())

                                                                                                                                                                    @else
                                                                                                                                                                        <p class="text-gray-500 text-center py-6">কোনও category পাওয়া যায়নি।</p>
                                                                                                                                                                    @endif -->


            <div class="col-sm-12">
                <div class="category-product1 main_product_inner1">
                    @foreach ($menucategories as $key => $value)
                        <div class="cat_item1">
                            <div class="cat_img1">
                                <a href="{{ route('category', $value->slug) }}">
                                    <img src="{{ asset($value->image) }}" loading="lazy" alt="" />
                                </a>
                                <div class="cat_name1">
                                    <a href="{{ route('category', $value->slug) }}">
                                        {{ $value->name }}
                                    </a>
                                    <div class="product_count">
                                        {{ $value->products->count() }} Products
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')

@endpush