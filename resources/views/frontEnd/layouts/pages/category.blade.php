@extends('frontEnd.layouts.master')
@section('title')
  <title>{{ $category->meta_title }}</title>

@push('seo')
    <meta name="app-url" content="{{ route('category', $category->slug) }}" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="{{ $category->meta_description }}" />
    <meta name="keywords" content="{{ $category->slug }}" />

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product" />
    <meta name="twitter:site" content="{{ $category->name }}" />
    <meta name="twitter:title" content="{{ $category->name }}" />
    <meta name="twitter:description" content="{{ $category->meta_description }}" />
    <meta name="twitter:creator" content="Creative Design" />
    <meta property="og:url" content="{{ route('category', $category->slug) }}" />
    <meta name="twitter:image" content="{{ asset($category->image) }}" />

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $category->name }}" />
    <meta property="og:type" content="product" />
    <meta property="og:url" content="{{ route('category', $category->slug) }}" />
    <meta property="og:image" content="{{ asset($category->image) }}" />
    <meta property="og:description" content="{{ $category->meta_description }}" />
    <meta property="og:site_name" content="{{ $category->name }}" />
@endpush
@section('content')
 <div class="blankspace"></div>
<div class="gradient-bg">
       <span>{{ $category->name }}</span>
 <div>
        Total 
        {{ $products->count() + (isset($combo_products) ? $combo_products->count() : 0) }} 
        Products on {{ $category->name }}
    </div>
    </div>
    <div class="filerSliderItem">

    <div class="filterSecName">
        <div class="hero-section"><i class="fa-solid fa-bars-filter"></i> Filter</div>
                    <div class="filter-close"><i class="fa-solid fa-xmark"></i></div>
                    </div>
                   <div class="hero-2part">
                     <form id="filterForm" class="attribute-submit" action="{{ url()->current() }}" method="GET">
    <!-- Checkbox, price inputs etc -->
                        <div class="sidebar_item wraper__item">
                            <div class="accordion" id="category_sidebar">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseCat" aria-expanded="true" aria-controls="collapseOne">
                                            {{ $category->name }}
                                        </button>
                                    </h2>
                                    <div id="collapseCat" class="accordion-collapse collapse show"
                                        data-bs-parent="#category_sidebar">
                                        <div class="accordion-body cust_according_body">
                                            <ul>
                                                @foreach ($category->subcategories as $key => $subcat)
                                                    <li>
                                                        <a
                                                            href="{{ url('subcategory/' . $subcat->slug) }}">{{ $subcat->subcategoryName }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--sidebar item end-->
                         <div class="sidebar_item wraper__item">
            <div class="accordion" id="price_sidebar">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsePrice" aria-expanded="true" aria-controls="collapsePrice">
                            Price
                        </button>
                    </h2>
                    <div id="collapsePrice" class="accordion-collapse collapse show"
                         data-bs-parent="#price_sidebar">
                        <div class="accordion-body cust_according_body">
                      
                            <div id="price-range" class="slider form-attribute"></div> <br>
                              <div class="filter-price-inputs"> 
                                                                <p class="min-price">MIN<input type="text"
                                                                        name="min_price" id="min_price" />
                                                                </p>
                                                                <p class="max-price">MAX<input type="text"
                                                                        name="max_price" id="max_price" />
                                                                </p>
                                                            </div>
                                                        </div>
                        </div>
                    </div>
                </div>
            </div>
       
                        <!--sidebar item end-->
          <div class="sidebar_item wraper__item">
    <div class="accordion" id="filter_sidebar">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseFilter" aria-expanded="true" aria-controls="collapseOne">
                    Stock
                </button>
            </h2>
            <div id="collapseFilter" class="accordion-collapse collapse show"
                data-bs-parent="#filter_sidebar">
                <div class="accordion-body cust_according_body">
                    <div class="filter-body">
                        <ul class="space-y-3">
                            <li>
                                <label>
                                    <input type="checkbox" name="stock[]" value="In Stock"
                                        class="form-checkbox form-attribute"
                                        @if(is_array(request()->get('stock')) && in_array('In Stock', request()->get('stock'))) checked @endif>
                                    In Stock
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" name="stock[]" value="Stock out"
                                        class="form-checkbox form-attribute"
                                        @if(is_array(request()->get('stock')) && in_array('Out of Stock', request()->get('stock'))) checked @endif>
                                    Out of Stock
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="sidebar_item wraper__item">
            <div class="accordion" id="size_sidebar">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSize" aria-expanded="true" aria-controls="collapseSize">
                            Filter by Size
                        </button>
                    </h2>
                    <div id="collapseSize" class="accordion-collapse collapse show"
                         data-bs-parent="#size_sidebar">
                        <div class="accordion-body cust_according_body form-checkbox">
                            @foreach($all_sizes as $size)
    <label class="size">
        <input type="checkbox" name="size[]" value="{{ $size->sizeName }}"
            {{ is_array(request('size')) && in_array($size->sizeName, request('size'))}}>
        {{ $size->sizeName }}
    </label><br>
@endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </form> 
                   </div>


                        <!--sidebar item end-->
                    
                    
    </div>
    <section class="product-section">
 
        <div class="max-width1">
            <!-- <div class="sorting-section">-->
                <div class="row"> 
                    
                    <!-- <div class="col-sm-6">
                        <div class="category-breadcrumb d-flex align-items-center">
                            <a href="{{ route('home') }}">Home</a>
                            <span><i class="fa-solid fa-angle-right arrowset"></i></span>
                            
                            
                        </div>
                    </div>  -->
                  
                       
                            <div class="category-row">
                                <!-- <div class="showing-data">
                                    <span>Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of
                                        {{ $products->total() }} Results</span>
                                </div> -->
                               <div class="filerarea">
                        <div class="filterSliderbtn">
                            <a><i class="fa-solid fa-bars-filter"></i> Filter</a>
                        </div>
                          <div class="sortright">
                            <div class="page-sort">
                                  <form id="filterForm2" class="attribute-submit" action="{{ url()->current() }}" method="GET">
                                    <select name="sort" class="form-control form-select sort">
                                                  <option value="1" {{ request()->get('sort') == 1 ? 'selected' : '' }}>Latest First</option>
    <option value="2" {{ request()->get('sort') == 2 ? 'selected' : '' }}>Oldest First</option>
    <option value="3" {{ request()->get('sort') == 3 ? 'selected' : '' }}>Price High to Low</option>
    <option value="4" {{ request()->get('sort') == 4 ? 'selected' : '' }}>Price Low to High</option>
    <option value="5" {{ request()->get('sort') == 5 ? 'selected' : '' }}>Name A-Z</option>
    <option value="6" {{ request()->get('sort') == 6 ? 'selected' : '' }}>Name Z-A</option>
                                            </select>
                                            <input type="hidden" name="min_price" value="{{request()->get('min_price')}}" />
                                            <input type="hidden" name="max_price" value="{{request()->get('max_price')}}" />
                                  </form>
                                      
                                            
                                      
                                    </div>
                        </div>
                                   
                                
                    </div>
                            
                            </div>
                          
                    
                </div>
                <!-- </div>
            </div> -->
            <div class="row">

                
                <div class="col-sm-12">
 
                       
                  <!-- <div class="container">
                     <div class="row sorting-product">
                            <div class="col-sm-6">
                                <div class="showing-data">
                                    <span>Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of
                                        {{ $products->total() }} Results</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="filter_sort">
                                    <div class="filter_btn">
                                        <i class="fa fa-list-ul"></i>
                                    </div>
                                    <div class="page-sort">
                                        <form action="" class="sort-form">
                                            <select name="sort" class="form-control form-select sort">
                                                <option value="1" @if(request()->get('sort')==1)selected @endif>Product: Latest</option>
                                                <option value="2" @if(request()->get('sort')==2)selected @endif>Product: Oldest</option>
                                                <option value="3" @if(request()->get('sort')==3)selected @endif>Price: High To Low</option>
                                                <option value="4" @if(request()->get('sort')==4)selected @endif>Price: Low To High</option>
                                                <option value="5" @if(request()->get('sort')==5)selected @endif>Name: A-Z</option>
                                                <option value="6" @if(request()->get('sort')==6)selected @endif>Name: Z-A</option>
                                            </select>
                                            <input type="hidden" name="min_price" value="{{request()->get('min_price')}}" />
                                            <input type="hidden" name="max_price" value="{{request()->get('max_price')}}" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                  </div> -->


                    <div id="productList" class="category-product main_product_inner">
                        
       @php
    $comboProducts = $combo_products ?? collect();
    $normalProducts = $products->getCollection() ?? collect(); // paginator থেকে collection নাও

    // Merge
    $allItems = $comboProducts->merge($normalProducts)->sortBy('created_at'); ;
@endphp


@forelse ($paginatedItems  as $value)
    <div class="product_item wist_item">
        <div class="product_item_inner">

            {{-- Sale Badge --}}
            @if($value->old_price)
                <div class="sale-badge">
                    <div class="sale-badge-inner">
                        <div class="sale-badge-box">
                            <span class="sale-badge-text">
                                @php 
                                    $disprice = $value->old_price - $value->new_price;
                                    $discount = ($disprice * 100) / $value->old_price;
                                @endphp
                                <p>-{{ number_format($discount,0) }}%</p>
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Product Image --}}
            <div class="pro_img" data-second="{{ $value->images->count() > 1 ? asset($value->images[1]->image) : '' }}">
                    @php
                                    $wishlist = json_decode(request()->cookie('wishlist', '[]'), true);
                                    $inWishlist = isset($wishlist[$value->id]);
                                @endphp

                               
                                <div class="wishlist-btn">
                                    <button type="button" class="wishlist-toggle" data-product-id="{{ $value->id }}">
                                        @if($inWishlist)
                                            <!-- In wishlist → show trash SVG -->
                                           <svg class="wishlist-icon" width="24" height="24" aria-hidden="true" role="img" focusable="false" style="color: #f80653;">
                                                <use href="#heart-filled" xlink:href="#heart-filled"></use>
                                            </svg>

                                        @else
                                            <!-- Not in wishlist → show heart SVG -->
                                            <svg width="24" height="24" aria-hidden="true" role="img" focusable="false">
                                                <use href="#heart" xlink:href="#heart"></use>
                                            </svg>
                                        @endif
                                    </button>
                                </div>
                @if($value instanceof \App\Models\Combo)
                    <a href="{{ route('combo.show', $value->slug) }}">
                        <img src="{{ asset($value->images->first()?->image ?? '') }}" alt="{{ $value->name }}" class="main-img" />
                    </a>
                @else
                    <a href="{{ route('product', $value->slug) }}">
                        <img src="{{ asset($value->image ? $value->image->image : '') }}" alt="{{ $value->name }}" class="main-img" />
                    </a>
                @endif

                @if(isset($value->second_image) && $value->second_image)
                    <a href="{{ $value instanceof \App\Models\Combo ? route('combo.show', $value->slug) : route('product', $value->slug) }}">
                        <img src="{{ asset($value->second_image) }}" alt="{{ $value->name }} hover" class="hover-img" />
                    </a>
                @endif

   
       @if(!$value instanceof \App\Models\Combo)
    <div class="quick-view" data-bs-toggle="modal" data-bs-target="#quickViewModal-{{ $value->id }}">
        <span>Quick View</span>
    </div>
    @else
     <a href="{{ route('combo.show', $value->slug) }}">
      <div class="combo-height">
        <h4>Combo</h4>
    </div>
    </a>
  @endif



                @if(isset($value->stock) && $value->stock < 1)
                    <div class="stock-out-overlay">STOCK OUT</div>
                @endif
            </div>

            {{-- Product Details --}}
            <div class="pro_des">
                <div class="pro_name">
                    <a href="{{ $value instanceof \App\Models\Combo ? route('combo.show', $value->slug) : route('product', $value->slug) }}">
                        {{ Str::limit($value->name, 80) }}
                    </a>
                </div>
                <div class="pro_stockstatus {{ $value->stock >= 1 ? 'text-success' : 'text-danger' }}">
                                        {{ $value->stock >= 1 ? 'In Stock' : 'Stock Out' }}
                                    </div>

                @if($soldShow && !($value instanceof \App\Models\Combo))
                    <span style="background-color:#FFBCA5" class="px-3 py-1 rounded-pill">Sold {{ $value->sold ?? 0 }}</span>
                @endif

                <div class="pro_price">
                    <p>
                        @if($value->old_price)
                            <del>{{ $value->old_price }}.00৳</del>
                        @endif
                        {{ $value->new_price }}.00৳
                    </p>
                </div>
            </div>

        </div>
    </div>
@empty
    <div class="no-products">
        <div class="nooroductsectionicontext">
            <div class="iconfornopsystem"><i class="fa-solid fa-clipboard-exclamation"></i></div>
            <div class="textsystemfornop">No Any Product here</div>
            <a href="{{route('shop')}}"><span class="span-class4">Shop Now <i class="fa-solid fa-arrow-right"></i></span></a>
        </div>
    </div>
@endforelse


                    </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="custom_paginate">
                        {{ $products->links('pagination::bootstrap-4') }}

                    </div>
                </div>
            </div>
        </div>
     
    </section>
    <section class="homeproduct">
        <div class="container">
            <div class="category-row">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="meta_des">
                        {!! $category->meta_description !!}
                    </div>
                </div>
               </div>
            </div>
        </div>
    </section>
<section>
    @include('partials.quick-view')
</section>


@endsection

@push('script')

<script>
document.querySelectorAll('.pro_img').forEach(div => {
    const img = div.querySelector('.main-img');
    const secondSrc = div.dataset.second;

    if (secondSrc) {
        const secondImg = new Image();
        secondImg.src = secondSrc;
        secondImg.classList.add('hover-img');
        secondImg.style.position = "absolute";
        secondImg.style.top = "0";
        secondImg.style.left = "0";
        secondImg.style.opacity = "0";
        secondImg.style.transition = "opacity 0.5s ease-in-out";
        secondImg.style.pointerEvents = 'none';

        div.style.position = "relative";
        div.appendChild(secondImg);

        div.addEventListener('mouseover', () => {
            secondImg.style.opacity = "1";
        });
        div.addEventListener('mouseout', () => {
            secondImg.style.opacity = "0";
        });
    }
});
    
    

</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <!-- <script>
    const filterbtnslider = document.querySelector('.filterSliderbtn'),filterClose = document.querySelector(".filter-close"),filterContent = document.querySelector('.filerSliderItem');
    filterbtnslider.addEventListener('click',()=>{
        
        filterContent.classList.add('sliderShow')
    })
    filterClose.addEventListener('click',()=>{
         filterContent.classList.remove('sliderShow')
    })
</script> -->

<script>
     $(".filterSliderbtn").on("click", function () {
            $("#page-overlay").show();
            $(".filerSliderItem").addClass("sliderShow");
        });

        $("#page-overlay").on("click", function () {
            $("#page-overlay").hide();
            $(".filerSliderItem").removeClass("sliderShow");
        });
        $(".filter-close").on("click", function () {
            $("#page-overlay").hide();
            $(".filerSliderItem").removeClass("sliderShow");
        });
        
</script>
   <script>
$(document).ready(function(){

    function ajaxFilter() {
        let form = $("#filterForm");

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            success: function(response){
                // Replace only #productList from the returned HTML
                let newContent = $(response).find("#productList").html();
                $("#productList").html(newContent);
            },
            error: function(xhr){
                console.error(xhr.responseText);
            }
        });
    }

    // Checkbox click → show/hide sub/child categories
    $(".category-checkbox").on('change', function(){
        let subList = $(this).closest('li').find('.subcategory-list').first();
        if(subList.length) subList.toggle(this.checked);
        ajaxFilter();
    });

    $(".subcategory-checkbox").on('change', function(){
        let childList = $(this).closest('li').find('.childcategory-list').first();
        if(childList.length) childList.toggle(this.checked);
        ajaxFilter();
    });

    $(".childcategory-checkbox").on('change', ajaxFilter);
      $(".ajax-filter").on('change', ajaxFilter);

    // Sort / price / stock
    $(".form-attribute, .form-checkbox, #price-range,.size").on('change click', function(){
        ajaxFilter();
    });

    // Page load: show checked sub/child categories
    $(".category-checkbox:checked").each(function(){
        $(this).closest('li').find('.subcategory-list').first().show();
    });
    $(".subcategory-checkbox:checked").each(function(){
        $(this).closest('li').find('.childcategory-list').first().show();
    });

});
</script>

 <script>
$(document).ready(function(){

    function ajaxFilter() {
        let form = $("#filterForm2");

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            success: function(response){
                // Replace only #productList from the returned HTML
                let newContent = $(response).find("#productList").html();
                $("#productList").html(newContent);
            },
            error: function(xhr){
                console.error(xhr.responseText);
            }
        });
    }

    // Trigger on sort dropdown change
    $(".sort").on('change click', function(){
        ajaxFilter();
    });

});
</script>


    <script>
        $(function() {
            $("#price-range").slider({
                step: 1,
                range: true,
                min: {{ $min_price }},
                max: {{ $max_price }},
                values: [
                    {{ request()->get('min_price') ? request()->get('min_price') : $min_price }},
                    {{ request()->get('max_price') ? request()->get('max_price') : $max_price }}
                ],
                slide: function(event, ui) {
                    $("#min_price").val(ui.values[0]);
                    $("#max_price").val(ui.values[1]);
                }
            });
            $("#min_price").val({{ request()->get('min_price') ? request()->get('min_price') : $min_price }});
            $("#max_price").val({{ request()->get('max_price') ? request()->get('max_price') : $max_price }});
            $("#priceRange").val($("#price-range").slider("values", 0) + " - " + $("#price-range").slider("values",
                1));

            $("#mobile-price-range").slider({
                step: 5,
                range: true,
                min: {{ $min_price }},
                max: {{ $max_price }},
                values: [
                    {{ request()->get('min_price') ? request()->get('min_price') : $min_price }},
                    {{ request()->get('max_price') ? request()->get('max_price') : $max_price }}
                ],
                slide: function(event, ui) {
                    $("#min_price").val(ui.values[0]);
                    $("#max_price").val(ui.values[1]);
                }
            });
            $("#min_price").val({{ request()->get('min_price') ? request()->get('min_price') : $min_price }});
            $("#max_price").val({{ request()->get('max_price') ? request()->get('max_price') : $max_price }});
            $("#priceRange").val($("#price-range").slider("values", 0) + " - " + $("#price-range").slider("values",
                1));

        });
    </script>
    
@endpush
