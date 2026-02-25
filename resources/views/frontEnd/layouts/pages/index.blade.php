@extends('frontEnd.layouts.master') 
@section('title', 'Home') 
@push('seo')
 
@if($generalsetting && $generalsetting->meta_description)
  <meta name="description" content="{!! $generalsetting->meta_description !!}" />
@endif

@if($generalsetting && $generalsetting->meta_keyword)
  <meta name="keywords" content="{{ $generalsetting->meta_keyword }}" />
@endif


		<!-- Open Graph data -->
@if($generalsetting)
    @if(!empty($generalsetting->name))
        <meta property="og:title" content="{{ $generalsetting->name }}" />
    @endif

    <meta property="og:type" content="website" />

    <meta property="og:url" content="{{ url('/') }}" />

    @if(!empty($generalsetting->og_baner))
        <meta property="og:image" content="{{ asset($generalsetting->og_baner) }}" />
    @endif

    @if(!empty($generalsetting->meta_description))
        <meta property="og:description" content="{{ $generalsetting->meta_description }}" />
    @endif
@endif

@endpush @push('css')


<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css" rel="stylesheet" />
@endpush @section('content')
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<div class="blankspace"></div>
<section class="slider-section">
    
     
  
            
            <!-- <div class="col-sm-3 hidetosm">
                <div class="sidebar-menu">
                    <ul class="hideshow">
                        @foreach ($menucategories as $key => $category)
                            <li>
                                <a href="{{ route('category', $category->slug) }}">
                                    <img src="{{ asset($category->image) }}" alt="" />
                                    {{ $category->name }}
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="sidebar-submenu">
                                    @foreach ($category->subcategories as $key => $subcategory)
                                        <li>
                                            <a href="{{ route('subcategory', $subcategory->slug) }}">
                                                {{ $subcategory->subcategoryName }} <i
                                                    class="fa-solid fa-chevron-right"></i> </a>
                                            <ul class="sidebar-childmenu">
                                                @foreach ($subcategory->childcategories as $key => $childcat)
                                                    <li>
                                                        <a href="{{ route('products', $childcat->slug) }}">
                                                            {{ $childcat->childcategoryName }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            -->
             <div class="content2">
                

<div class="col-sm-12" style="position: relative;">

   <div class="col-sm-12" style="position: relative;">

    <div class="main-home-slide swiper">
        <div class="swiper-wrapper">
            @foreach ($sliders as $key => $value)
                <div class="swiper-slide" style="width: 100%">
                    @if($value->text_status == 1)
                        <div class="sub-area">
                      
                       <div class="max-width4">
                       
                             <div class="col-sm-7">
                            <div class="text-field">
                           <div class="first-text-for-banner">
                             <span class="text-field-first-text" style="background:transparent;color:{{ $value->subtitlecolor ?? '#1a1a1b' }}">{{ $value->title }}</span><br>
                           </div>
                           <div class="second-text-for-banner">
                             <span class="text-field-second-text" style="color:{{ $value->subtitlecolor ?? '#1a1a1b' }}">{{ $value->subtitle }}</span><br>
                           </div>
                            <a class="text-field-third-text" href="{{ $value->link }}" style="background:{{ $value->buttoncolor ?? '#1a1a1b' }}; color:{{ $value->buttontextcolor ?? '#ffffff' }}; border: 1px solid {{ $value->buttoncolor ?? '#ffffff' }}">
                                {{ $value->button_text }} <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                        </div>
                         <div class="col-sm-7">
                           <div class="fakearea-box"></div>
                             </div>
                     
                         </div>
                  
                    </div>
                    @endif
                    
                   <a href="{{ $value->link }}">
                        <img src="{{ asset($value->image) }}" alt="" />
                    </a>
                   
                </div>
            @endforeach
        </div>
        <div class="antiget">
            <div class="swiper-pagination"></div>
        </div>
    </div>

</div>

<script>
    var swiper = new Swiper(".main-home-slide", {
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        autoplay: {
            delay: 7000,
            disableOnInteraction: false,
        },
        speed: 1000,  
    });
</script>



    </div>
            
       
         
    
   
    
</section>
 <div class="top_header">
            <div class="d-flex align-items-center flex-grow-1">
               @php
    $marqueeCount = $generalsetting->marque_count ?? 0; // database থেকে value
    $headline = $generalsetting->top_headline ?? 'Default headline here';
@endphp

@if($marqueeCount > 0)
    <marquee direction="left" scrollamount="12">
        @for ($i = 0; $i < $marqueeCount; $i++)
            <i class="fa-solid fa-bolt"></i> {{ $headline }}
            @if($i < $marqueeCount - 1)
                &nbsp;&nbsp;|&nbsp;&nbsp; 
            @endif
        @endfor
    </marquee>
@endif

                
                
            </div>
          </div>
          
<script>
    const swiper = new Swiper('.swiper', {
  // Optional parameters
  direction: 'horizontal',
  loop: true,
  autoplay:true,

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
       clickable: true, 
  },

  // Navigation arrows
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

  // And if we need scrollbar
  scrollbar: {
    el: '.swiper-scrollbar',
  },
});
</script>
<!-- slider end -->

  @if($generalsetting && $generalsetting->show_category_wise_products)
    @foreach ($homeproducts as $item)
        <section class="homeproduct">
            <div class="max-width1">
                <div class="gradient-bg1 mb-2">
                    <div class="blanksidelayer"></div>
                    <span class="section-title-name">{{ $item->section_name }}</span> {{-- ✅ Now correct --}}
            </div>
                </div>

                <div class="swiper myswiper categorySwiper-{{ $item->id }}">
                    <div class="swiper-wrapper">
                        @php
                            // Merge combo_products + products safely
                            $allItems = ($item->combo_products ?? collect())->merge($item->products ?? collect());
                            $shuffledItems = $allItems->shuffle();
                        @endphp

                        @foreach ($shuffledItems as $product)
                            @if ($product->status == 1)
                                <div class="swiper-slide product_item_inner">
                                    <div class="category-productforcategorywise main_product_innerforcategorywise">
                                        <div class="pro_img" style="border-radius:10px" 
                                             data-second="{{ $product->images->count() > 1 ? asset($product->images[1]->image) : '' }}">
                                            
                                            @php
                                                $wishlist = json_decode(request()->cookie('wishlist', '[]'), true);
                                                $inWishlist = isset($wishlist[$product->id]);
                                            @endphp

                                            <div class="wishlist-btn">
                                                <button type="button" class="wishlist-toggle" data-product-id="{{ $product->id }}">
                                                    @if($inWishlist)
                                                        <svg class="wishlist-icon" width="24" height="24" style="color: #f80653;">
                                                            <use href="#heart-filled" xlink:href="#heart-filled"></use>
                                                        </svg>
                                                    @else
                                                        <svg width="24" height="24">
                                                            <use href="#heart" xlink:href="#heart"></use>
                                                        </svg>
                                                    @endif
                                                </button>
                                            </div>

                                            @if($product instanceof \App\Models\Combo)
                                                <a href="{{ route('combo.show', $product->slug) }}">
                                                    <img src="{{ asset($product->images->first()?->image ?? '') }}" alt="{{ $product->name }}" class="main-img" />
                                                </a>
                                            @else
                                                <a href="{{ route('product', $product->slug) }}">
                                                    <img src="{{ asset($product->image?->image ?? '') }}" alt="{{ $product->name }}" class="main-img" />
                                                </a>
                                            @endif

                                            @if(isset($product->second_image) && $product->second_image)
                                                <a href="{{ route($product instanceof \App\Models\Combo ? 'combo.show' : 'product', $product->slug) }}">
                                                    <img src="{{ asset($product->second_image) }}" alt="{{ $product->name }} hover" class="hover-img" />
                                                </a>
                                            @endif

                                            @if(!$product instanceof \App\Models\Combo)
                                                <div class="quick-view" data-bs-toggle="modal" data-bs-target="#quickViewModal-{{ $product->id }}">
                                                    <span>Quick View</span>
                                                </div>
                                            @else
                                                <a href="{{ route('combo.show', $product->slug) }}">
                                                    <div class="combo-height">
                                                        <h4>Combo</h4>
                                                    </div>
                                                </a>
                                            @endif

                                            @if(isset($product->stock) && $product->stock < 1)
                                                <div class="stock-out-overlay">STOCK OUT</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    </div> <!-- swiper-wrapper -->
                </div> <!-- swiper -->
            </div> <!-- max-width1 -->
        </section>
        
    @endforeach
@endif





<section class="homeproduct ">
 
    <div class="col-sm-12">
                <div class="category-row set-background-color ">
                <div class="sec_title">
                    <h3 class="section-title-header">
                        <div class="timer_inner">
                            <div class="">
                                <span class="section-title-name dark-category">SHOP BY CATEGORY </span>
                            </div>
                        </div>
                    </h3>
                   <!-- <div class="cetegorybutton">
                    @foreach ($menucategories as $key => $value)
                        
                        <a href="{{ route('category', $value->slug) }}">
                            <div class="category-sub-button" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $value->name }}
                            </div>    
                        </a>  
                    @endforeach
                   </div> -->
                </div>
               
              <div class="max-width1">

        
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
                    @php
                        $mainCount = $value->products->count();
                        $comboCount = $value->combos->sum(function($combo) {
                            return $combo->products->count();
                        });
                        $total = $mainCount + $comboCount;
                    @endphp
                    {{ $total }} Products
                </div>
                            </div>
                            </div>
                            
                        </div>
                    @endforeach
                </div>
                </div>
         
             </div>
            <!-- <div class="col-sm-12">
                <div class="category-sliger owl-carousel">
                    @foreach ($menucategories as $key => $value)
                        <div class="product-scroll-cetegoryy">
                            <div class="text-center photosection-category">
                                <a href="{{ route('category', $value->slug) }}">
                                    <img class="" src="{{ asset($value->image) }}" alt="" style="width: 100%; height: 100%;" />
                                </a>
                                <div class="text-bottom-name">Hi</div>
                            </div>
                            <div class="text-center">
                                <a href="{{ route('category', $value->slug) }}">
                                    <div style="margin-top:5px;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $value->name }}
                                    </div>
                                
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>-->
            </div> 
            </div>
  
</section>






@php
    $hotDealEndDate = $generalsetting?->hot_deal_end_date 
        ? $generalsetting->hot_deal_end_date . 'T23:59:59' 
        : null;

    $flashSaleEndDate = $generalsetting?->flash_sale_end_date 
        ? $generalsetting->flash_sale_end_date . 'T23:59:59' 
        : null;

    $isHotDealActive = $hotDealEndDate 
        ? \Carbon\Carbon::parse($hotDealEndDate)->isFuture() 
        : false;

    $isFlashSaleActive = $flashSaleEndDate 
        ? \Carbon\Carbon::parse($flashSaleEndDate)->isFuture() 
        : false;
@endphp

<!--//Flash sales-->
@if($isFlashSaleActive)
<section class="homeproduct">
    <div class="max-width">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="sec_title">
                   
                        <div class="timer_inner">
                            <div class="headtext-for-name-category">
                                 <h3 class="section-title-header">
                                    <span class="section-title-name" >Flash Sales </span>
                                  </h3>
                                
                            </div>

                            <div class="count">
                               <div class="offer_timer" id="flash_sale_timer"></div>
                            </div>
                        </div>
                  
                    
                </div>
            </div>
            
            <div class="col-sm-12">
                <div class="category-product main_product_inner owl-carousel">
                    @foreach ($flas_sales as $key => $value)
                        <div class="product_item wist_item">
                            <div class="product_item_inner">
                                @if($value->old_price)
                                <div class="sale-badge">
                                    <div class="sale-badge-inner">
                                        <div class="sale-badge-box">
                                            <span class="sale-badge-text">
                                             @php 
                                                    $disprice = $value->old_price - $value->new_price;
                                                    $discount = $value->old_price > 0 ? ($disprice * 100) / $value->old_price : 0;
                                                @endphp
                                                <!-- <p>Save: {{ number_format($disprice,0) }}৳ ({{ number_format($discount,0) }}%)</p> -->
                                                <p>-{{ number_format($discount,0) }}%</p>
                                                
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
                                        <a href="{{ route('product', $value->slug) }}">{{ Str::limit($value->name, 50) }}</a>
                                    </div>
                                    
                                    <span style="background-color:#FFBCA5" class="px-3 py-1 rounded-pill">Sold {{$value->sold??0}}</span>
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

                            @if (!$value->prosizes->isEmpty() || !$value->procolors->isEmpty() || ($value->stock < 1))
                                <!-- <div class="pro_btn">
                                   
                                    <div class="cart_btn order_button">
                                        <a href="{{ route('product', $value->slug) }}"
                                            class="addcartbutton">Buy Now</a>
                                    </div>
                                </div> -->
                            @else
                                <!-- <div class="pro_btn">
                                    
                                    <form action="{{ route('cart.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $value->id }}" />
                                        <input type="hidden" name="qty" value="1" />
                                        <button type="submit">Buy Now</button>
                                    </form>
                                </div> -->
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-sm-12 cntrbtn">
               <div>
                <a href="{{ route('flashsales') }}" class="view_more_btn" style="float:left">View More</a> 
               </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endif
<!--//hot deals-->
@if($isHotDealActive)
<section class="homeproduct">
    <div class="max-width">
    <div class="container">
        <div class="row  category-row">
            <div class="col-sm-12">
                <div class="sec_title">
                    
                        <div class="timer_inner">
                            <div class="headtext-for-name-category">
                                <h3 class="section-title-header">
                                <span class="section-title-name">Hot Deal </span>
                                  </h3>
                            </div>

                            <div class="count">
                                <div class="offer_timer" id="simple_timer"></div>
                            </div>
                        </div>
                  
                </div>
            </div>
            <div class="col-sm-12">
                <div class="category-product main_product_inner owl-carousel">
                    @foreach ($hotdeal_top as $key => $value)
                        <div class="product_item wist_item">
                            <div class="product_item_inner">
                                @if($value->old_price)
                                <div class="sale-badge">
                                    <div class="sale-badge-inner">
                                        <div class="sale-badge-box">
                                            <span class="sale-badge-text">
                                               @php 
                                                    $disprice = $value->old_price - $value->new_price;
                                                    $discount = $value->old_price > 0 ? ($disprice * 100) / $value->old_price : 0;
                                                @endphp
                                                <!-- <p>Save: {{ number_format($disprice,0) }}৳ ({{ number_format($discount,0) }}%)</p> -->
                                                <p>-{{ number_format($discount,0) }}%</p>
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
                                        <a
                                            href="{{ route('product', $value->slug) }}">{{ Str::limit($value->name, 50) }}</a>
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

                            @if (!$value->prosizes->isEmpty() || !$value->procolors->isEmpty() || ($value->stock < 1))
                                <!-- <div class="pro_btn">
                                   
                                    <div class="cart_btn order_button">
                                        <a href="{{ route('product', $value->slug) }}"
                                            class="addcartbutton">Buy Now</a>
                                    </div>
                                </div> -->
                            @else
                                <!-- <div class="pro_btn">
                                    
                                    <form action="{{ route('cart.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $value->id }}" />
                                        <input type="hidden" name="qty" value="1" />
                                        <button type="submit">Buy Now</button>
                                    </form>
                                </div> -->
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-sm-12 cntrbtn">
               <div>
                <a href="{{ route('hotdeals') }}" class="view_more_btn" style="float:left">View More</a> 
               </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endif




@if($generalsetting && $generalsetting->show_all_products)

<section class="homeproduct">
    <div class="max-width1">

        <div class="col-sm-12">
            <div class="category-row5">
                <!-- <div class="sec_title">
                    <h3 class="section-title-header">
                        <div class="timer_inner">
                            <div class="headtext-for-name-category">
                                <span class="section-title-name">Featured Product</span>
                            </div>
                        </div>
                    </h3>
                </div> -->

                <div class="gradient-bg1 mb-3">
                    <div class="blanksidelayer"></div>
                    <span class="section-title-name">Featured Product</span>
                    {{-- <!-- <div>Total {{ $all_products->count() }} Products</div> --> --}}
                </div>

                <div class="col-sm-12">
                    <div class="category-product main_product_inner">
                        @foreach($all_products as $key => $value)
                        <div class="product_item wist_item">
                            <div class="product_item_inner">

                                @if($value->old_price)
                                <div class="sale-badge">
                                    <div class="sale-badge-inner">
                                        <div class="sale-badge-box">
                                            <span class="sale-badge-text">
                                                @php 
                                                    $disprice = $value->old_price - $value->new_price;
                                                    $discount = $value->old_price > 0 ? ($disprice * 100) / $value->old_price : 0;
                                                @endphp
                                                <!-- <p>Save: {{ number_format($disprice,0) }}৳ ({{ number_format($discount,0) }}%)</p> -->
                                                <p>-{{ number_format($discount,0) }}%</p>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="pro_img" data-second="{{ $value->images->count() > 1 ? asset($value->images[1]->image) : '' }}">
                                    {{-- Wishlist Button --}}
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

                                    <div class="quick-view" data-bs-toggle="modal" data-bs-target="#quickViewModal-{{ $value->id }}">
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
                                </div> <!-- .pro_img -->

                                <div class="pro_des">

                                    <div class="pro_name">
                                        <a href="{{ route('product',$value->slug) }}">{{ Str::limit($value->name,50) }}</a>
                                    </div>

                                    <div class="pro_stockstatus {{ $value->stock >= 1 ? 'text-success' : 'text-danger' }}">
                                        {{ $value->stock >= 1 ? 'In Stock' : 'Stock Out' }}
                                    </div>


                                    @if ($value->stock < 1)
                                    <div class="pro_price">
                                        <p>
                                            <del>0.00৳</del>
                                            0.00৳
                                        </p>
                                    </div>
                                    @else
                                    <div class="pro_price">
                                        <p>
                                            @if ($value->old_price)
                                                <del>{{ $value->old_price }}.00৳</del>
                                            @endif
                                            {{ $value->new_price }}.00৳
                                        </p>
                                    </div>
                                    @endif

                                </div> <!-- .pro_des -->

                            </div> <!-- .product_item_inner -->
                        </div> <!-- .product_item -->
                        @endforeach
                    </div> <!-- .category-product -->
                </div> <!-- .col-sm-12 -->

            </div> <!-- .category-row5 -->
        </div> <!-- .col-sm-12 -->

    </div> <!-- .max-width1 -->
</section>

@endif
 
@if($sliderbottomads)
<section class="mt-2">
    <div class="max-width">
    <div class="container">
        <div class="row ">
            @foreach($sliderbottomads as $bottomAds)
            <div class="col-md-12">
                <a href="{{$bottomAds->link}}?sold=show">
                    <img class="img-fluid" src="{{$bottomAds->image}}"/>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    </div>
</section>
@endif




{{-- <!-- @if($generalsetting && $generalsetting->show_category_wise_products)

    @foreach ($homeproducts as $homecat)
        <section class="homeproduct">
            <div class="max-width">
            
                    <div class="col-sm-12">
                        <div class="category-row">
                        <div class="sec_title">
                            <h3 class="section-title-header">
                                
                                
                            </h3>
                        </div>
                        <div class="gradient-bg">
                            <span class="section-title-name">{{ $homecat->name }}</span>
                            <div>Total {{ $homecat->products->count() }} Products</div>
                        </div>
                   
                    <div class="col-sm-12">
                        <div class="category-product main_product_inner">
                           
                            @forelse  ($homecat->products as $key => $value)
                           
                               <div class="product_item wist_item">
                                <div class="product_item_inner">
                                    @if($value->old_price)
                                    <div class="sale-badge">
                                        <div class="sale-badge-inner">
                                            <div class="sale-badge-box">
                                                <span class="sale-badge-text">
                                                  @php 
                                                    $disprice = $value->old_price - $value->new_price;
                                                    $discount = $value->old_price > 0 ? ($disprice * 100) / $value->old_price : 0;
                                                @endphp
                                                  <p>-{{ number_format($discount,0) }}%</p>
                                                    
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="pro_img">
                                        <a href="{{ route('product', $value->slug) }}">
                                            <img src="{{ asset($value->image ? $value->image->image : '') }}"
                                                alt="{{ $value->name }}" loading="lazy" />
                                        </a>
                                        @if($value->stock < 1)
                                        <div class="stock-out-overlay">STOCK OUT</div>
                                        @endif
                                         <div class="quick-view" data-bs-toggle="modal"
                   data-bs-target="#quickViewModal-{{ $value->id }}">
                <span>Quick View </span>
              <div class="sizeShowproduct">
                 @if($value->prosizes && $value->prosizes->count() > 0)
                @foreach($value->prosizes as $size)
                    <span>
                        {{ $size->size?->sizeName ?? '-' }}
                      
                    </span>
                @endforeach
                   @endif
              </div>
                </div>
                                    </div>
                                  
                                    <div class="pro_des">
                                        <div class="pro_name">
                                            <a
                                                href="{{ route('product', $value->slug) }}">{{ Str::limit($value->name, 50) }}</a>
                                        </div>
                                           <div class="pro_stockstatus {{ strtolower($value->stockstatus) == 'stock out' ? 'text-danger' : 'text-success' }}">
                                           {{ $value->stockstatus }}
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
    
                                @if (!$value->prosizes->isEmpty() || !$value->procolors->isEmpty() || ($value->stock < 1))
                                    <div class="pro_btn">
                                       
                                        <div class="cart_btn order_button">
                                            <a href="{{ route('product', $value->slug) }}"
                                                class="addcartbutton">Buy Now</a>
                                        </div>
                                    </div>
                                @else
                                    <div class="pro_btn">
                                        
                                        <form action="{{ route('cart.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $value->id }}" />
                                            <input type="hidden" name="qty" value="1" />
                                            <button type="submit">Buy Now</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                                @empty
            <div class="no-products">
                <div class="areatextbit">
                    <p><i class="fa-regular fa-files"></i></p>
                <p>No product available Here</p>
                </div>
            </div>
        @endforelse

                          
                        </div>
                        </div>
                   
                    <div class="col-sm-12">
                        <div class="show_more_btn">
                            <a href="{{ route('category', $homecat->slug) }}" class="view_more_btn">View More</a>
                        </div>
                    </div>
                     </div>
                </div>
            
        </section>
           
                        
    @endforeach
       
                        
@endif --> --}}

@if($campaognads)
<section>
    <div class="max-width1">
    <div class="container" style="margin-bottom: 10px;">
        <div class="row">
            @foreach($campaognads as $campaignAds)
            <div class="col-12">
                <a href="{{$campaignAds->link}}?sold=show">
                    <img class="img-fluid" src="{{$campaignAds->image}}"/>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    </div>
</section>
@endif
<section>
    
       <div class="sec_title">
                    <div class="gradient-bg">
                        <span>About Shop</span>
                        <div>Inspire and let yourself be inspired, from one unique fashion to another.</div>
                    </div>
                    
                </div>
    <div class="max-width1">

            <div class="row">
               
                <div class="photosec">
    <div class="swiper all-products-swiper">
        <div class="swiper-wrapper">
            @foreach($all_products as $value)
                <div class="swiper-slide">
                    <a href="{{ route('product',$value->slug) }}">
                        <img 
                            src="{{ asset($value->image ? $value->image->image : '') }}" 
                            alt="{{ $value->name }}" 
                            class="main-hover-img" 
                            loading="lazy"
                        />
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
       <div class="antiget">
         <div class="swiper-pagination"></div>
       </div>
    </div>
</div>

                <div class="buttondetails">
                    
                    <div class="card-type">
                        <i class="fa-regular fa-cube"></i>
                  <span class="span-1st">Free Delivery</span>
                  <span class="span-2nd">you Will love at great low prices</span>
                    </div>
                    <div class="card-type">
                       <i class="fa-solid fa-shirt-jersey"></i>
                  <span class="span-1st">Premium Products</span>
                  <span class="span-2nd">Good quality & Premium products </span>
                    </div>
                    <div class="card-type">
                       <i class="fa-solid fa-credit-card-front"></i>
                  <span class="span-1st">Flexible Payment</span>
                  <span class="span-2nd">Payment with Bkash and Credit/Debit Cards</span>
                    </div>
                    <div class="card-type">
                       <i class="fa-solid fa-badge-dollar"></i>
                  <span class="span-1st">Budget Friendly</span>
                  <span class="span-2nd">Budget Friendly & user friendly price</span>
                    </div>
                    <div class="card-type">
                      <i class="fa-solid fa-arrow-u-turn-down-left"></i>
                  <span class="span-1st">3 Days Return</span>
                  <span class="span-2nd">Within 3 days for an exchange</span>
                    </div>
                    <div class="card-type">
                     <i class="fa-solid fa-user-headset"></i>
                  <span class="span-1st">Premium Support</span>
                  <span class="span-2nd">Outstanding premium support</span>
                    </div>
                </div>
            </div>
      
    </div>
</section>

@if($reviews->count()>0)
<section class="homeproduct">
    <div class="max-width1">
 
        <div class="row">
            <div class="col-sm-12">
                <div class="category-row5">
                <div class="sec_title">
                    <div class="gradient-bg">
                        <span>Customer Review</span>
                        <div>Hear what they say about us</div>
                    </div>
                    
                </div>
           
            <div class="col-sm-12">
                
                 <div class="swiper all-products-swiper1">
                    <div class="swiper-wrapper customer-review">
                    @foreach ($reviews as $review)
                    <div class="border rounded swiper-slide">
                        <img class="img-fluid w-100" src="{{ asset($review->image) }}" />
                    </div>
                    @endforeach
                </div>
                </div>
            </div>
            </div>
             </div>
        </div>
 
    </div>
</section>
@endif
<section>
    <div class="max-width">
    <div class="container" style="margin-bottom: 10px;">
        <div class="row">
            @foreach($footertopads as $footerAds)
            <div class="col-md-12">
                <a href="{{$footerAds->link}}?sold=show">
                    <img class="img-fluid w-100" src="{{$footerAds->image}}"/>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    </div>
</section>




@endsection @push('script')
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
<script src="{{ asset('frontEnd/js/owl.carousel.min.js') }}"></script>
<!-- jQuery (only ONE time) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="public/frontEnd/js/jquery.syotimer.min.js"></script>







@php
    $hotDealDate = $generalsetting?->hot_deal_end_date ? $generalsetting->hot_deal_end_date . 'T23:59:59' : null;
    $flashSaleDate = $generalsetting?->flash_sale_end_date ? $generalsetting->flash_sale_end_date . 'T23:59:59' : null;
@endphp



<script>
$(document).ready(function() {
    // Blade variables safely passed to JS
    let hotDealDate = @json($hotDealDate);
    let flashSaleDate = @json($flashSaleDate);

    if (hotDealDate) {
        $("#simple_timer").syotimer({
            date: new Date(hotDealDate),
            layout: "hms",
            doubleNumbers: false,
            effectType: "opacity",
            periodUnit: "d",
            periodic: false
        });
    }

    if (flashSaleDate) {
        $("#flash_sale_timer").syotimer({
            date: new Date(flashSaleDate),
            layout: "hms",
            doubleNumbers: false,
            effectType: "opacity",
            periodUnit: "d",
            periodic: false
        });
        
    }

});

</script>





<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".myswiper").forEach(function (el) {
        new Swiper(el, {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 10,
            navigation: {
                nextEl: el.querySelector(".swiper-button-next"),
                prevEl: el.querySelector(".swiper-button-prev"),
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
             breakpoints: {
                200: { slidesPerView: 2 },
                320: { slidesPerView: 2 },
                550: { slidesPerView: 3 },
                768: { slidesPerView: 3 },
                1024: { slidesPerView: 4 },
            },
        });
    });
});

</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const swiper = new Swiper('.all-products-swiper', {
        slidesPerView: 1,
        spaceBetween: 10,
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
             250: { slidesPerView: 2, spaceBetween: 8 },
            576: { slidesPerView: 2, spaceBetween: 10 },
            768: { slidesPerView: 3, spaceBetween: 15 },
            992: { slidesPerView: 4, spaceBetween: 20 },
            1200: { slidesPerView: 5, spaceBetween: 20 },
        },
        autoplay: {
            delay: 2500,       // slide প্রতি 2.5 সেকেন্ডে change হবে
            disableOnInteraction: false, // user swipe করলে autoplay stop হবে না
        }
        
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const swiper = new Swiper('.all-products-swiper1', {
        slidesPerView: 1,
        spaceBetween: 10,
        loop: true,  // scroll speed (time in ms)
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        freeMode: true,
        freeModeMomentum: false, // থামবে না

        breakpoints: {
             250: { slidesPerView: 2, spaceBetween: 8 },
            576: { slidesPerView: 2, spaceBetween: 10 },
            768: { slidesPerView: 3, spaceBetween: 15 },
            992: { slidesPerView: 3, spaceBetween: 10 },
            1200: { slidesPerView: 3, spaceBetween: 10 },
        },
        autoplay: {
            delay: 2500,       // slide প্রতি 2.5 সেকেন্ডে change হবে
            disableOnInteraction: false, // user swipe করলে autoplay stop হবে না
        }
        
    });
});
</script>
<script>
    $(document).ready(function() {
        $(".main_slider").owlCarousel({
            items: 1,
            loop: true,
            dots: false,
            autoplay: true,
            nav: true,
            autoplayHoverPause: true,
            margin: 0,
            mouseDrag: true,
            smartSpeed: 8000,
            autoplayTimeout: 3000,
            animateOut: "fadeOutRight",
            animateIn: "slideInLeft",

            navText: ["<i class='fa-solid fa-angle-left'></i>",
                "<i class='fa-solid fa-angle-right'></i>"
            ],
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(".hotdeals-slider").owlCarousel({
            margin: 15,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 3,
                    nav: true,
                },
                600: {
                    items: 3,
                    nav: false,
                },
                1000: {
                    items: 6,
                    nav: true,
                    loop: false,
                },
            },
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(".category-slider").owlCarousel({
            margin: 15,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 5,
                    nav: true,
                },
                600: {
                    items: 3,
                    nav: false,
                },
                1000: {
                    items: 8,
                    nav: true,
                    loop: false,
                },
            },
        });

        $(".product_slider").owlCarousel({
            margin: 15,
            items: 6,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2,
                    nav: false,
                },
                600: {
                    items: 5,
                    nav: false,
                },
                1000: {
                    items: 6,
                    nav: false,
                },
            },
        });
        
        $(".flash_sale_slider").owlCarousel({
            margin: 8,
            items: 6,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 3,
                    nav: false,
                },
                600: {
                    items: 6,
                    nav: false,
                },
                1000: {
                    items: 7,
                    nav: false,
                },
            },
        });
        
        $(".category-sliger").owlCarousel({
            margin: 8,
            items: 6,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 3,
                    nav: false,
                },
                600: {
                    items: 6,
                    nav: false,
                },
                1000: {
                    items: 7,
                    nav: false,
                },
            },
        });
        $(".customer-review").owlCarousel({
            margin: 8,
            items: 6,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2,
                    nav: false,
                },
                600: {
                    items: 3,
                    nav: false,
                },
                1000: {
                    items: 5,
                    nav: false,
                },
            },
        });
    });
</script>


   

    <!-- Data Layer End-->
  
    <script>
        function sendSuccess() {
            // size validation
            size = document.forms["formName"]["product_size"].value;
            if (size != "") {
                // access
            } else {
                toastr.warning("Please select any size");
                return false;
            }
            color = document.forms["formName"]["product_color"].value;
            if (color != "") {
                // access
            } else {
                toastr.error("Please select any color");
                return false;
            }
        }
    </script>
    
@endpush
