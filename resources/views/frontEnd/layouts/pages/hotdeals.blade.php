@extends('frontEnd.layouts.master') 
@section('title','Hot Deals')
 
@section('content')
 <div class="blankspace"></div>
   <div class="filerSliderItem">
<div class="filterSecName">
    <div class="hero-section"><i class="fa-solid fa-bars-filter"></i> Filter</div>
    <div class="filter-close"><i class="fa-solid fa-xmark"></i></div>
</div>

<div class="hero-2part">
    <form action="{{ route('shop') }}" method="GET" id="filterForm">

        <!-- CATEGORY + SUBCATEGORY + CHILDCATEGORY -->
        <div class="sidebar_item wraper__item">
            <div class="accordion" id="category_sidebar">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseCat" aria-expanded="true" aria-controls="collapseCat">
                        Products Categories
                        </button>
                    </h2>
                    <div id="collapseCat" class="accordion-collapse collapse show"
                         data-bs-parent="#category_sidebar">
                        <div class="accordion-body cust_according_body">
                            <ul class="space-y-2">
                                @foreach($all_categories as $cat)
                                    <li>
                                        <label>
                                            <input type="checkbox" class="category-checkbox" name="category[]" value="{{ $cat->slug }}"
                                                {{ is_array(request()->category) && in_array($cat->slug, request()->category) ? 'checked' : '' }}>
                                            <strong>{{ $cat->name }}</strong>
                                        </label>

                                        <!-- Subcategories -->
                                        @php
                                            $subs = $cat->subcategories()->where('status',1)->get();
                                        @endphp
                                        @if($subs->count())
                                            <ul class="ml-4 space-y-1 subcategory-list" style="display:none;">
                                                @foreach($subs as $subcat)
                                                    <li>
                                                        <label>
                                                            <input type="checkbox" class="subcategory-checkbox" name="subcategory[]" value="{{ $subcat->slug }}"
                                                                {{ is_array(request()->subcategory) && in_array($subcat->slug, request()->subcategory) ? 'checked' : '' }}>
                                                            {{ $subcat->subcategoryName }}
                                                        </label>

                                                        <!-- Childcategories -->
                                                        @php
                                                            $childs = $subcat->childcategories()->where('status',1)->get();
                                                        @endphp
                                                        @if($childs->count())
                                                            <ul class="ml-4 space-y-1 childcategory-list" style="display:none;">
                                                                @foreach($childs as $child)
                                                                    <li>
                                                                        <label>
                                                                            <input type="checkbox" class="childcategory-checkbox" name="childcategory[]" value="{{ $child->slug }}"
                                                                                {{ is_array(request()->childcategory) && in_array($child->slug, request()->childcategory) ? 'checked' : '' }}>
                                                                            {{ $child->childcategoryName }}
                                                                        </label>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif

                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- PRICE FILTER -->
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
       

        <!-- STOCK CHECKBOXES -->
        <div class="sidebar_item wraper__item">
            <div class="accordion" id="stock_sidebar">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseStock" aria-expanded="true" aria-controls="collapseStock">
                            Stock
                        </button>
                    </h2>
                    <div id="collapseStock" class="accordion-collapse collapse show"
                         data-bs-parent="#stock_sidebar">
                        <div class="accordion-body cust_according_body form-checkbox">
                            <label><input type="checkbox" name="stock[]" value="In Stock" {{ in_array('In Stock',(array)request()->stock) ? 'checked' : '' }}> In Stock</label>
                            <br><label><input type="checkbox" name="stock[]" value="Stock Out" {{ in_array('Out of Stock',(array)request()->stock) ? 'checked' : '' }}> Out of Stock</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Onno filters ... -->
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
</div>
 </div>
<section class="product-section">
                    <div class="gradient-bg ">
                        <span>Hot Deals</span>
                    </div>
                
    <div class="container">
     
            <div class="row">
                            <div class="col-sm-6">
                                <div class="showing-data">
                                    <!-- <span>Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of
                                        {{ $products->total() }} Results</span> -->
                                </div>
                            </div>
                           <div class="row"> 
        
                            <div class="category-row">
                               <div class="filerarea">
                        <div class="filterSliderbtn">
                            <a><i class="fa-solid fa-bars-filter"></i> Filter</a>
                        </div>
                        <div class="sortright">
                            <div class="page-sort">
                                  <form id="filterForm2" class="attribute-submit" action="{{ url()->current() }}" method="GET">
                                    <select name="sort" class="form-control form-select sort">
                                                <option value="1" @if(request()->get('sort')==1)selected @endif>Sort by Latest</option>
                                                <option value="2" @if(request()->get('sort')==2)selected @endif>Sort by Oldest</option>
                                                <option value="3" @if(request()->get('sort')==3)selected @endif>Sort by High To Low</option>
                                                <option value="4" @if(request()->get('sort')==4)selected @endif>Sort by Low To High</option>
                                                <option value="5" @if(request()->get('sort')==5)selected @endif>Sort by A-Z</option>
                                                <option value="6" @if(request()->get('sort')==6)selected @endif>Sort by Z-A</option>
                                            </select>
                                            <input type="hidden" name="min_price" value="{{request()->get('min_price')}}" />
                                            <input type="hidden" name="max_price" value="{{request()->get('max_price')}}" />
                                  </form>
                                      
                                            
                                      
                                    </div>
                        </div>
                                   
                                
                    </div>
                            
                            </div>
                          
                    
                </div>
                         
                        </div>
      
        
        <div class="row">
            <div class="col-sm-12">
                 <div class="offer_timer" id="simple_timer"></div>
            </div>
            <div class="col-sm-12">
                <div id="productList" class="category-product main_product_inner">
                    @foreach($products as $key=>$value)
                    <div class="product_item wist_item">
                        <div class="product_item_inner">
                             @if($value->old_price)
                            <div class="sale-badge">
                                <div class="sale-badge-inner">
                                    <div class="sale-badge-box">
                                        <span class="sale-badge-text">
                                            <p>Save : @php $discount=(((($value->old_price)-($value->new_price))*100) / ($value->old_price)) @endphp {{ number_format($discount, 0) }}%</p>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endif
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
                                <a href="{{ route('product', $value->slug) }}">
                <img 
                    src="{{ asset($value->image ? $value->image->image : '') }}" 
                    alt="{{ $value->name }}" 
                    class="main-img"
                />
            </a>

            @if($value->second_image)
            <a href="{{ route('product', $value->slug) }}">
                <img 
                    src="{{ asset($value->second_image) }}" 
                    alt="{{ $value->name }} hover" 
                    class="hover-img"
                />
            </a>
            @endif

                <div class="quick-view" data-bs-toggle="modal"
                   data-bs-target="#quickViewModal-{{ $value->id }}">
                <span>Quick View </span>
              <div class="sizeShowproduct">
                 @if($value->prosizes && $value->prosizes->count() > 0)
                @foreach($value->prosizes as $size)
                    <span>
                        <!-- {{ $size->size?->sizeName ?? '-' }} -->
                      
                    </span>
                @endforeach
                   @endif
              </div>
                </div>
              
                
               

                @if($value->stock < 1)
                <div class="stock-out-overlay">STOCK OUT</div>
                @endif
            </div>
                            <div class="pro_des">
                                <div class="pro_name">
                                    <a href="{{ route('product',$value->slug) }}">{{Str::limit($value->name,80)}}</a>
                                </div>
                                <div class="pro_stockstatus {{ $value->stock >= 1 ? 'text-success' : 'text-danger' }}">
                                        {{ $value->stock >= 1 ? 'In Stock' : 'Stock Out' }}
                                    </div>
                               <div class="pro_price">
                                            <p>@if ($value->old_price)
                                                 <del>{{ $value->old_price }}.00৳</del>
                                                @endif
                                                {{ $value->new_price }}.00৳
                                            </p>
                                        </div>
                            </div>
                        </div>

                         @if(! $value->prosizes->isEmpty() || ! $value->procolors->isEmpty() || ($value->stock < 1))
                        <!-- <div class="pro_btn">
                            
                            <div class="cart_btn order_button">
                                <a href="{{ route('product',$value->slug) }}" class="addcartbutton">Buy Now</a>
                            </div>
                            
                        </div> -->
                        @else

                        <!-- <div class="pro_btn">
                           
                            <form action="{{route('cart.store')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{$value->id}}" />
                                <input type="hidden" name="qty" value="1" />
                                <button type="submit">Buy Now</button>
                            </form>
                        </div> -->
                        @endif
                        
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="custom_paginate">
                    {{$products->links('pagination::bootstrap-4')}}
                   
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
    $(".sort").on('change', function(){
        ajaxFilter();
    });

});
</script>
<script>
    $("#simple_timer").syotimer({
        date: new Date(2015, 0, 1),
        layout: "hms",
        doubleNumbers: false,
        effectType: "opacity",

        periodUnit: "d",
        periodic: true,
        periodInterval: 1,
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