@extends('frontEnd.layouts.master')
@section('title', $combo->name)
@vite('resources/js/zoom.js')
@section('head')
    <!-- Product JSON-LD for Google Rich Results -->
    <script type="application/ld+json">
                                        {
                                          "@context": "https://schema.org/",
                                          "@type": "Product",
                                          "name": "{{ $combo->name }}",
                                          "image": [
                                            @foreach($combo->images as $img)
                                                  "{{ asset($img->image) }}"@if(!$loop->last),@endif
                                            @endforeach
                                          ],
                                          "description": "{{ $combo->short_description ?? $combo->description ?? 'NM Fashion product' }}",
                                          "sku": "{{ $combo->sku ?? $combo->id }}",
                                          "brand": {
                                            "@type": "Brand",
                                            "name": "{{ $combo->brand ? $combo->brand->name : 'NM Fashion' }}"
                                          },
                                          "offers": {
                                            "@type": "Offer",
                                            "url": "{{ url()->current() }}",
                                            "priceCurrency": "BDT",
                                            "price": "{{ $combo->new_price }}",
                                            "availability": "{{ $combo->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
                                            "itemCondition": "https://schema.org/NewCondition"
                                          }
                                        }
                                        </script>


@endsection
@push('seo')
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="app-url" content="{{ route('product', $combo->slug) }}" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="{{ $combo->meta_description }}" />
    <meta name="keywords" content="{{ $combo->slug }}" />

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product" />
    <meta name="twitter:site" content="{{ $combo->name }}" />
    <meta name="twitter:title" content="{{ $combo->name }}" />
    <meta name="twitter:description" content="{{ $combo->meta_description }}" />
    <meta name="twitter:creator" content="gomobd.com" />
    <meta property="og:url" content="{{ route('combo.show', $combo->slug) }}" />

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $combo->name }}" />
    <meta property="og:type" content="combo" />
    <meta property="og:url" content="{{ route('combo.show', $combo->slug) }}" />
    <meta property="og:description" content="{{ $combo->meta_description }}" />
    <meta property="og:site_name" content="{{ $combo->name }}" />

@endpush




@section('content')
<div class="blankspace"></div>
<div class="gradient-bg">
    <span>Product Combo</span>
</div>
    <div class="max-width">
        <div class="comboalert" style="padding: 10px 15px;text-align:center; width: 100%;">

            <span style="font-weight:500; text-align: center; font-size: 20px">
                Buy any {{ $maxProducts }} pieces at {{ $combo->new_price }} taka
            </span>
        </div>

        <div class="homeproduct main-details-page">
            <div class="col-sm-12">

                <section class="product-section">
                    <div class="container">



                        <div class="row ">

                            <div class="col-sm-6 position-relative maxbtnset">
                                @if($combo->old_price)
                                <div class="maximized">
                                            <i class="fa-sharp fa-light fa-arrows-maximize"></i>
                                        </div>
                                    <div class="product-details-discount-badge">
                                        <div class="sale-badge">
                                            <div class="sale-badge-inner">
                                                <div class="sale-badge-box">
                                                    <span class="sale-badge-text">
                                                        <p>-
                                                            @php $discount = (((($combo->old_price) - ($combo->new_price)) * 100) / ($combo->old_price)) @endphp
                                                            {{ number_format($discount, 0) }}%
                                                        </p>

                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- <style>
                                    /* Default opacity for thumbnails */
                                    .indicator-item img {
                                        opacity: 0.4;
                                        transition: opacity 0.3s;
                                    }

                                    /* Active thumbnail */
                                    .indicator-item.active img {
                                        opacity: 1;
                                    }
                                </style> --}}
                                <div class="scrollinner">
                                    <div class="scrollcontent">
                                        <div class="details_slider_wrapper">
                                    <!-- Left Arrow -->
                                            <button class="owl-prev custom-prev"><i class="fa-sharp fa-light fa-chevron-left"></i></button>

                                            <div class="details_slider owl-carousel">
                                                @foreach ($combo->images as $value)
                                                    <div class="dimage_item">
                                                        <img src="{{ asset($value->image) }}" class="block__pic" loading="lazy" />
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Right Arrow -->
                                            <button class="owl-next custom-next"><i class="fa-sharp fa-light fa-chevron-right"></i></button>
                                        </div>

                                        <div class="swiper indicator_thumb">
                                            <div class="swiper-wrapper">
                                                @foreach ($combo->images as $key => $image)
                                                    <div class="swiper-slide indicator-item" data-id="{{ $key }}">
                                                        <img src="{{ asset($image->image) }}" loading="lazy" />
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="details_slider owl-carousel">
                                    @foreach ($combo->images as $value)
                                        <div class="dimage_item">
                                            <img src="{{ asset($value->image) }}" class="block__pic" loading="lazy" />
                                        </div>
                                    @endforeach
                                </div>


                                <div class="swiper indicator_thumb">
                                    <div class="swiper-wrapper">
                                        @foreach ($combo->images as $key => $image)
                                            <div class="swiper-slide indicator-item" data-id="{{ $key }}">
                                                <img src="{{ asset($image->image) }}" loading="lazy" />
                                            </div>
                                        @endforeach

                                    </div>
                                </div> --}}


                            </div>
                            <div class="col-sm-6">
                                <div class="details_right">


                                    <div class="product">
                                        <div class="product-cart">
                                            <div class="tdt" style="margin: 5px 0;">
                                                <li><a href="{{ url('/') }}" style="font-weight: 600;">Category : </a></li>
                                                @if($combo->category && $combo->category->slug)

                                                    <li><a href="{{ url('/category/' . $combo->category->slug) }}"
                                                            style="color: #f80653;font-weight: 600;">{{ $combo->category->name }}</a>
                                                    </li>
                                                @endif
                                            </div>
                                            @if ($combo->pro_unit)
                                                <div class="pro_unig">
                                                    <label>Unit: {{ $combo->pro_unit }}</label>
                                                    <input type="hidden" name="pro_unit" value="{{ $combo->pro_unit }}" />
                                                </div>
                                            @endif


                                            <p class="name">{{ $combo->name }}</p>

                                            <div class="details-price">
                                                @if ($combo->old_price)

                                                @endif
                                                <p>৳{{ $combo->new_price }}</p>
                                                <div class="cd1">
                                                    <del>৳{{ $combo->old_price }}</del>
                                                </div>
                                                <div class="cd2">
                                                    <span class="main-badge">
                                                        @php $discount = (((($combo->old_price) - ($combo->new_price)) * 100) / ($combo->old_price)) @endphp
                                                        {{ number_format($discount, 0) }}% OFF
                                                    </span>
                                                </div>

                                            </div>

                                            <div class="stockmenu" style="margin:15px 0">
                                                @if ($combo->stock < 1)
                                                    <span class="stockleft" style="border:1px solid #ff0000;color: #ff0000;">
                                                        Stock Out
                                                    </span>
                                                @elseif ($combo->stock < 6)
                                                    <span class="stockleft" style="border:1px solid #ff0000;color: #ff0000;">
                                                        Only {{ $combo->stock }} in stock
                                                    </span>
                                                @else
                                                    <span class="stockleft">
                                                        {{ $combo->stock }} in stock
                                                    </span>
                                                @endif

                                            </div>

                                            <div class="pro_brand">
                                                <p>Brand :
                                                    <span>
                                                        {{ $combo->brand ? $combo->brand->name : 'Non Brand' }}</span>
                                                </p>
                                            </div>


                                            @php
                                                // Controller থেকে আসা ভ্যালু
                                                $modalId = $combo->id;
                                                $basePrice = $combo->new_price;
                                            @endphp

                                            <form action="{{ route('cart.combo') }}" method="POST" id="comboForm">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $combo->id }}">
                                                <input type="hidden" name="qty" value="1">

                                                <div class="combo-products mb-3">
                                                    <div class="section-titleComb">
                                                        <span>Choose Any {{ $maxProducts }} Products</span>
                                                    </div>

                                                    <div class="d-flex flex-wrap gap-3">
                                                        @for ($i = 1; $i <= $maxProducts; $i++)
                                                            <div class="combo-box text-center" data-index="{{ $i }}">
                                                                <div class="product-placeholder">
                                                                    <span class="plus-icon">+</span>
                                                                </div>
                                                                <p class="product-text">Please select a product!</p>
                                                                <input type="hidden" name="combo_products[]"
                                                                    class="selected-product-id">
                                                                <input type="hidden" name="combo_colors[]"
                                                                    class="selected-product-color">
                                                                <input type="hidden" name="combo_sizes[]"
                                                                    class="selected-product-size">
                                                            </div>
                                                        @endfor
                                                    </div>
                                                </div>

                                                <!-- Product selection modal -->
                                                <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Select any {{ $maxProducts }}
                                                                    Product</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row category-product main_product_inner_model">
                                                                    @foreach($products as $product)
                                                                        <div class="col-md-3 mb-3">
                                                                            @php
                                                                                $mainImage = $product->images->count() ? $product->images[0]->image : 'default.jpg';
                                                                            @endphp
                                                                            <div class="product_item wist_item"
                                                                                data-id="{{ $product->id }}"
                                                                                data-name="{{ $product->name }}"
                                                                                data-image="{{ asset($mainImage) }}"
                                                                                data-price="{{ $product->new_price }}">

                                                                                <div class="pro_img">
                                                                                    <img src="{{ asset($mainImage) }}"
                                                                                        class="main-img"
                                                                                        alt="{{ $product->name }}">
                                                                                </div>

                                                                                <div class="pro_des">
                                                                                    <div class="pro_name">
                                                                                        <h5>{{ Str::limit($product->name, 50) }}
                                                                                        </h5>
                                                                                    </div>
                                                                                    <div class="details-price">
                                                                                        @if ($product->old_price)

                                                                                        @endif
                                                                                        <p style="font-size: 17px">
                                                                                            ৳{{ $product->new_price }}</p>
                                                                                        <div class="cd1">
                                                                                            <del
                                                                                                style="font-size: 15px">৳{{ $product->old_price }}</del>
                                                                                        </div>
                                                                                        <div class="cd2">
                                                                                            <span class="main-badge">
                                                                                                @php $discount = (((($product->old_price) - ($product->new_price)) * 100) / ($product->old_price)) @endphp
                                                                                                {{ number_format($discount, 0) }}%
                                                                                                OFF
                                                                                            </span>
                                                                                        </div>

                                                                                    </div>

                                                                                    {{-- Color --}}
                                                                                    @if($product->colors && $product->colors->count() > 0)
                                                                                        <div class="pro-color" style="width:100%;">
                                                                                            <div class="color_inner">
                                                                                                <p>Color - <span
                                                                                                        class="selectedColor">Select
                                                                                                        Any Color</span></p>
                                                                                                <div class="size-container">
                                                                                                    <div class="selector"
                                                                                                        style="display:flex; flex-wrap:wrap; gap:6px; margin-top:8px;">
                                                                                                        @foreach($product->colors as $procolor)
                                                                                                            <div class="selector-item">
                                                                                                                <input type="radio"
                                                                                                                    id="fc-option{{ $procolor->id }}-{{ $product->id }}"
                                                                                                                    value="{{ $procolor->colorName ?? '' }}"
                                                                                                                    name="product_color_{{ $product->id }}"
                                                                                                                    class="selector-item_radio" />
                                                                                                                <label
                                                                                                                    for="fc-option{{ $procolor->id }}-{{ $product->id }}"
                                                                                                                    style="margin-right:5px;background-color: {{ $procolor->color ?? '' }};border:1px solid #ccc;"
                                                                                                                    class="selector-item_label">
                                                                                                                    <span><img
                                                                                                                            src="{{ asset('public/frontEnd/images/check-icon.svg') }}"
                                                                                                                            alt="Checked Icon" /></span>
                                                                                                                </label>
                                                                                                            </div>
                                                                                                        @endforeach
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif

                                                                                    {{-- Size --}}
                                                                                    @if($product->sizes && $product->sizes->count() > 0)
                                                                                        <div class="pro-size" style="width:100%;">
                                                                                            <div class="size_inner">
                                                                                                <p>Size - <span
                                                                                                        class="selectedSize">Select
                                                                                                        Any Size</span></p>
                                                                                                <div class="size-container">
                                                                                                    <div class="selector"
                                                                                                        style="display:flex; flex-wrap:wrap; gap:6px; margin-top:8px;">
                                                                                                        @foreach($product->sizes as $prosize)
                                                                                                            <div class="selector-item">
                                                                                                                <input type="radio"
                                                                                                                    id="f-option{{ $prosize->id }}-{{ $product->id }}"
                                                                                                                    value="{{ $prosize->sizeName ?? '' }}"
                                                                                                                    name="product_size_{{ $product->id }}"
                                                                                                                    class="selector-item_radio"
                                                                                                                    style="display:none;" />
                                                                                                                <label
                                                                                                                    for="f-option{{ $prosize->id }}-{{ $product->id }}"
                                                                                                                    class="selector-item_label"
                                                                                                                    style="cursor:pointer; padding:5px 10px; border:1px solid #ccc; border-radius:4px;">
                                                                                                                    {{ $prosize->sizeName ?? '' }}
                                                                                                                </label>
                                                                                                            </div>
                                                                                                        @endforeach
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif

                                                                                    <button type="button"
                                                                                        class="btn add-to-combo-btn">Add to
                                                                                        Combo</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Add to cart / Buy now --}}
                                                <div class="single_product">
                                                    @php $basePrice = $combo->new_price ?? $combo->price; @endphp
                                                    <button type="submit" class="btn px-4 add_cart_btn" name="add_cart">Add
                                                        to cart – {{ $basePrice }}৳</button>
                                                    <button type="submit" class="btn px-4 order_now_btn order_now_btn_m"
                                                        name="combo_order_now">Buy it Now <span style="margin-left: 5px;"><i
                                                                class="fa-solid fa-arrow-up-right"></i></span></button>

                                                </div>
<div class="shareandcomparesystem d-flex gap-2 mt-2">

                                                        <button type="button" class="btn btn-primary px-3"
                                                            data-bs-toggle="modal" data-bs-target="#shareModal">
                                                            <i class="fa-solid fa-share-nodes"></i> Share
                                                        </button>
                                                    </div>
                                                    <!-- Share Button -->


                                                    <!-- Share Modal -->
                                                    <div class="modal fade" id="shareModal" tabindex="-1"
                                                        aria-labelledby="shareModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="shareModalLabel">Share Product
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- URL Input -->


                                                                    <!-- Share Buttons -->
                                                                    <div class="d-flex justify-content-between">
                                                                        <a href="#" id="facebookShare" target="_blank"
                                                                            class="btn btn-primary w-30">
                                                                            <i class="fab fa-facebook-f"></i> Facebook
                                                                        </a>
                                                                        <a href="#" id="xShare" target="_blank"
                                                                            class="btn btn-info w-30">
                                                                            <i class="fab fa-twitter"></i> X
                                                                        </a>
                                                                        <a href="#" id="whatsappShare" target="_blank"
                                                                            class="btn btn-success w-30">
                                                                            <i class="fab fa-whatsapp"></i> WhatsApp
                                                                        </a>
                                                                    </div>
                                                                    <div class="mt-3">
                                                                        <input type="text" id="productURL" class="form-control"
                                                                            readonly value="{{ url()->current() }}">
                                                                        <button id="copyBtn"
                                                                            class="btn btn-dark mt-2 w-100">Copy URL</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Script -->
                                                    <script>
                                                        document.addEventListener("DOMContentLoaded", function () {
                                                            const copyBtn = document.getElementById("copyBtn");
                                                            const productURL = document.getElementById("productURL");

                                                            copyBtn.addEventListener("click", function () {
                                                                productURL.select();
                                                                productURL.setSelectionRange(0, 99999);
                                                                navigator.clipboard.writeText(productURL.value).then(() => {
                                                                    alert("Copied: " + productURL.value);
                                                                });
                                                            });

                                                            const currentURL = encodeURIComponent(productURL.value);
                                                            document.getElementById("facebookShare").href = `https://www.facebook.com/sharer/sharer.php?u=${currentURL}`;
                                                            document.getElementById("xShare").href = `https://twitter.com/intent/tweet?url=${currentURL}`;
                                                            document.getElementById("whatsappShare").href = `https://api.whatsapp.com/send?text=${currentURL}`;
                                                        });
                                                    </script>

                                                <div class="mt-md-2 mt-2 ">


                                                </div>
                                                <div class="mt-md-2 mt-2">
                                                    <table class="table table-bordered border-1 border-dark">
                                                        <tr>
                                                            <th colspan="2" class="text-center">
                                                                Our Delivery Charge
                                                            </th>
                                                        </tr>
                                                        @foreach ($shippingcharge as $key => $value)
                                                            <tr>
                                                                <td>{{ $value->name }}</td>
                                                                <td class="text-end">৳ {{ $value->amount }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                    {{--<div class="del_charge_area">
                                                        <div class="alert alert-info text-m">
                                                            <div class="flext_area">

                                                                <i class="fa-solid fa-cubes"></i>
                                                                <div>

                                                                    @foreach ($shippingcharge as $key => $value)
                                                                    <h4>{{ $value->name }} </h4>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>--}}
                                                </div>
                                            </form>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </section>
            <script>
                document.addEventListener('DOMContentLoaded', function () {

                    // Update color/size text
                    document.querySelectorAll('.product_item').forEach(function (productDiv) {
                        productDiv.querySelectorAll("input[name^='product_color_']").forEach(function (radio) {
                            radio.addEventListener('change', function () {
                                const selectedColor = productDiv.querySelector('.selectedColor');
                                if (selectedColor) selectedColor.textContent = this.value || 'None';
                            });
                        });
                        productDiv.querySelectorAll("input[name^='product_size_']").forEach(function (radio) {
                            radio.addEventListener('change', function () {
                                const selectedSize = productDiv.querySelector('.selectedSize');
                                if (selectedSize) selectedSize.textContent = this.value || 'None';
                            });
                        });
                    });

                    let maxProducts = {{ $maxProducts }};
                    let currentBox = null;

                    // Combo box selection
                    document.querySelectorAll('.combo-box').forEach(function (box) {
                        box.addEventListener('click', function () {
                            currentBox = box;
                            let modal = new bootstrap.Modal(document.getElementById('productModal'));
                            modal.show();
                        });
                    });

                    // Add to combo
                    document.querySelectorAll('.add-to-combo-btn').forEach(function (button) {
                        button.addEventListener('click', function () {
                            let productDiv = button.closest('.product_item');
                            let id = productDiv.dataset.id;
                            let name = productDiv.dataset.name;
                            let image = productDiv.dataset.image;

                            // Selected color/size
                            const colorContainer = productDiv.querySelector('.pro-color');
                            const sizeContainer = productDiv.querySelector('.pro-size');

                            const selectedColor = productDiv.querySelector(`input[name^="product_color_${id}"]:checked`);
                            const selectedSize = productDiv.querySelector(`input[name^="product_size_${id}"]:checked`);

                            // Validation: যদি color বা size থাকে এবং select না করা হয়
                            if (colorContainer && !selectedColor) {
                                alert('Please select a color before adding this product!');
                                return false;
                            }
                            if (sizeContainer && !selectedSize) {
                                alert('Please select a size before adding this product!');
                                return false;
                            }

                            const colorText = selectedColor?.value || '';
                            const sizeText = selectedSize?.value || '';

                            if (!currentBox) return;

                            currentBox.querySelector('.product-placeholder').innerHTML = `<img src="${image}" alt="${name}">`;
                            currentBox.querySelector('.product-text').textContent = name + (colorText ? ' - ' + colorText : '') + (sizeText ? ' / ' + sizeText : '');
                            currentBox.querySelector('.selected-product-id').value = id;
                            currentBox.querySelector('.selected-product-color').value = colorText;
                            currentBox.querySelector('.selected-product-size').value = sizeText;

                            bootstrap.Modal.getInstance(document.getElementById('productModal')).hide();
                        });
                    });

                    // Combo form submission validation
                    document.getElementById('comboForm').addEventListener('submit', function (e) {
                        e.preventDefault(); // প্রথমেই prevent করে দিচ্ছি

                        const selectedProducts = document.querySelectorAll('.selected-product-id');
                        let filledCount = 0;

                        selectedProducts.forEach(function (input) {
                            if (input.value) filledCount++;
                        });

                        if (filledCount < maxProducts) {
                            alert(`You must select exactly ${maxProducts} products to add to cart!`);
                            return false;
                        }

                        // সব ঠিক থাকলে form submit করো
                        this.submit();
                    });

                });
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    document.querySelectorAll('.btn-add-combo').forEach(btn => {
                        btn.addEventListener('click', function () {
                            let parent = this.closest('.combo-products');
                            let select = this.closest('.combo-select').cloneNode(true);
                            parent.appendChild(select);
                        });
                    });
                });
            </script>
            <section class="pro_details_area">
                <div class="container">
                    <div class="category-row">
                        <div class="row">
                            <div class="card">
                                <div class="card-body des-btn">
                                    <style>
                                        .tab-link {
                                            background: transparent;
                                            color: #000;
                                            border: none;
                                            padding: 8px 16px;
                                            transition: 0.3s;
                                            border-radius: 6px;
                                        }

                                        /* যখন active ক্লাস থাকবে */
                                        .tab-link.active {
                                            background: #1a1a1b;
                                            color: #fff;
                                        }
                                    </style>
                                    <!-- Custom Tabs -->
                                    <ul class="custom-tabs" id="productTab" role="tablist">
                                        <li>
                                            <button class="tab-link active" id="size-tab" data-bs-toggle="tab"
                                                data-bs-target="#size" type="button" role="tab">Size Guide</button>
                                        </li>
                                        <li>
                                            <button class="tab-link" id="description-tab" data-bs-toggle="tab"
                                                data-bs-target="#description" type="button" role="tab">Description</button>
                                        </li>
                                        <li>
                                            <button class="tab-link" id="orderpolicy-tab" data-bs-toggle="tab"
                                                data-bs-target="#orderpolicy" type="button" role="tab">Order Policy</button>
                                        </li>
                                        <li>
                                            <button class="tab-link" id="reviews-tab" data-bs-toggle="tab"
                                                data-bs-target="#reviews" type="button" role="tab">Reviews
                                                ({{ $reviews->count() }})</button>
                                        </li>
                                    </ul>

                                    <!-- Tab Content -->
                                    <div class="tab-content" id="productTabContent">
                                        @if ($productsizes->count() > 0)
                                            <div class="tab-pane fade show active" id="size" role="tabpanel">
                                                <h5 class="fw-semibold">{{ $combo->category->name  }} Size Guide</h5>

                                                <!-- Responsive wrapper -->
                                                <div class="table-responsive mt-3">
                                                    <table class="table table-bordered mt-3">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Size</th>
                                                                <th scope="col">{{ $details->sizeType }}</th>
                                                                <th scope="col">Hip</th>
                                                                <th scope="col">Length</th>
                                                                <th scope="col">Thick</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($productsizes as $prosize)
                                                                <tr>
                                                                    <td>{{ $prosize->size?->sizeName }}</td>
                                                                    <td>{{ $prosize->size?->chestSize }}</td>
                                                                    <td>{{ $prosize->size?->hipSize }}</td>
                                                                    <td>{{ $prosize->size?->length }}</td>
                                                                    <td>{{ $prosize->size?->thickSize }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        @endif
                                        <!-- Description -->
                                        <div class="tab-pane fade" id="description" role="tabpanel">

                                            <h5 class="fw-semibold">Description</h5>
                                            <div class="description tab-content details-action-box" id="description">

                                                <p>{!! $combo->description !!}</p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="orderpolicy" role="tabpanel">
                                            <h5 class="fw-semibold">Order Policy</h5>
                                            <div class="description tab-content details-action-box" id="orderpolicy">

                                                <p>{!! $generalsetting->order_policy !!}</p>
                                            </div>
                                        </div>
                                        <!-- Reviews -->
                                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                                            <h5 class="fw-semibold">Customer Review</h5>
                                            <div class="section-head">
                                                <div class="title">

                                                    <p>Get specific details about this product from customers who own it.
                                                    </p>
                                                </div>

                                            </div>
                                            @if ($reviews->count() > 0)
                                                <div class="customer-review2">
                                                    <div class="row">
                                                        @foreach ($reviews as $key => $review)
                                                            <div class="col-sm-12 col-12">
                                                                <div class="review-card">
                                                                    <p class="review_star">
                                                                        {!! str_repeat('<i class="fa-solid fa-star"></i>', $review->ratting) !!}
                                                                    </p>
                                                                    <p class="review_content">{{ $review->review }}</p> <br>
                                                                    <div class="reviewnamedate">
                                                                        <p class="reviewer_name"><span
                                                                                style="color: #1a1a1b;">By</span>
                                                                            {{ $review->name }}</p><span
                                                                            style="margin: 0 4px">on</span>
                                                                        <p class="review_data">
                                                                            {{ $review->created_at->format('d-m-Y') }}
                                                                        </p>
                                                                    </div>


                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                <div class="empty-content">
                                                    <p class="empty-text1"><i class="fa-light fa-clipboard-list-check"></i></p>
                                                    <p class="empty-text">No Review yet.</p>
                                                </div>
                                            @endif
                                            <div class="action review-btn-mood">
                                                <div>
                                                    <button type="button"
                                                        class="details-action-btn question-btn btn-overlay"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                        Write a review
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="pro_details_area">
                <div class="container">
                    <div class="category-row">
                        <div class="row">
                            <div class="col-sm-8">


                                <div class="tab-content details-action-box" id="writeReview">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="modal fade" id="exampleModal" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog  modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Your
                                                                    review
                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <div class="insert-review">
                                                                    @if (Auth::guard('customer')->check())
                                                                        <form action="{{ route('customer.combo.review') }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <label for="message-text"
                                                                                class="col-form-label">Give us
                                                                                rating
                                                                                :</label>
                                                                            <input type="hidden" name="combo_id"
                                                                                value="{{ $combo->id }}">

                                                                            <div class="fz-12 mb-2">
                                                                                <div class="rating">
                                                                                    <label title="Excellent">
                                                                                        ☆ <input required type="radio"
                                                                                            name="ratting" value="5" />
                                                                                    </label>
                                                                                    <label title="Best">
                                                                                        ☆ <input required type="radio"
                                                                                            name="ratting" value="4" />
                                                                                    </label>
                                                                                    <label title="Better">
                                                                                        ☆ <input required type="radio"
                                                                                            name="ratting" value="3" />
                                                                                    </label>
                                                                                    <label title="Very Good">
                                                                                        ☆ <input required type="radio"
                                                                                            name="ratting" value="2" />
                                                                                    </label>
                                                                                    <label title="Good">
                                                                                        ☆ <input required type="radio"
                                                                                            name="ratting" value="1" />
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="message-text"
                                                                                    class="col-form-label">Message :</label>
                                                                                <textarea required
                                                                                    class="form-control radius-lg" name="review"
                                                                                    id="message-text"></textarea>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <button class="details-review-button"
                                                                                    type="submit">Submit Review</button>
                                                                            </div>
                                                                        </form>
                                                                    @else
                                                                        <button class="revbtn"
                                                                            href="{{ route('customer.login') }}">Login to Post
                                                                            Your Review</bitton>
                                                                    @endif
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="releted-product-section">


                <div class="category-row">
                    <div class="row">
                        <div class="related-title">
                            <div class="gradient-bg">
                                <span>Related Product</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="category-product main_product_inner recently_slider1 swiper" style="padding: 20px">
                                <div class="product-inner swiper-wrapper">
                                    @foreach ($products as $key => $value)
                                        <div class="product_item wist_item swiper-slide" style="margin: 0;">
                                            <div class="product_item_inner">
                                                @if($value->old_price)
                                                    <div class="sale-badge">
                                                        <div class="sale-badge-inner">
                                                            <div class="sale-badge-box">
                                                                <span class="sale-badge-text">
                                                                    <p>-{{ number_format($discount, 0) }}%</p>

                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="pro_img"
                                                    data-second="{{ $value->images->count() > 1 ? asset($value->images[1]->image) : '' }}">
                                                    <a href="{{ route('product', $value->slug) }}">
                                                        <img src="{{ asset($value->image ? $value->image->image : '') }}"
                                                            alt="{{ $value->name }}" class="main-img" />
                                                    </a>

                                                    @if($value->second_image)
                                                        <a href="{{ route('product', $value->slug) }}">
                                                            <img src="{{ asset($value->second_image) }}"
                                                                alt="{{ $value->name }} hover" class="hover-img" />
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
                                                            href="{{ route('product', $value->slug) }}">{{ Str::limit($value->name, 80) }}</a>
                                                    </div>
                                                     <div
                                                        class="pro_stockstatus {{ $value->stock >= 1 ? 'text-success' : 'text-danger' }}">
                                                        {{ $value->stock >= 1 ? 'In Stock' : 'Stock Out' }}
                                                    </div>
                                                    <div class="pro_price">
                                                        <p>

                                                            ৳ {{ $value->new_price }} @if ($value->old_price)
                                                            @endif
                                                            <del>৳ {{ $value->old_price }}</del>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            @if (!$value->prosizes->isEmpty() || !$value->procolors->isEmpty() || !$value->stock)
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
                        </div>
                    </div>
                </div>


            </section>


        </div>
    </div>
<div class="fs-viewer" id="fsViewer">
    <div class="fs-top">
        <button id="zoomIn"><i class="uil uil-search-plus"></i></button>
        <button id="zoomOut"><i class="uil uil-search-minus"></i></button>
        <button id="autoPlay">▶</button>
        <button id="fullScreen">⛶</button>
        <button id="closeFs">✕</button>
    </div>

    <button class="fs-nav left"><i class="uil uil-angle-left-b"></i></button>
    <img id="fsImage">
    <button class="fs-nav right"><i class="uil uil-angle-right-b"></i></button>
</div>
@endsection

@push('script')
    <script src="{{ asset('public/frontEnd/js/owl.carousel.min.js') }}"></script>

    <script src="{{ asset('public/frontEnd/js/zoomsl.min.js') }}"></script>

    <script>
        $('.order_now_btn').on('click', function (e) {
            e.preventDefault();
            // hidden input add
            if (!$(this).closest('form').find('input[name="combo_order_now"]').length) {
                $(this).closest('form').append('<input type="hidden" name="combo_order_now" value="1">');
            }
            $(this).closest('form')[0].submit();
        });

    </script>

    <script>
        const thumbSlider = new Swiper('.indicator_thumb', {
            spaceBetween: 10,
            slidesPerView: 5,
            initialSlide: 0,  // 4 thumbnails visible

            loop: false,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },

            breakpoints: {
                250: { slidesPerView: 4 },
                580: { slidesPerView: 4 },
                640: { slidesPerView: 5 },
                768: { slidesPerView: 5 },

            }
        });
    </script>

<script>
$(document).ready(function () {

    var owl = $(".details_slider");

    /* 🔥 INIT first active */
    owl.on('initialized.owl.carousel', function () {
        setActiveThumb(0);
    });

    owl.owlCarousel({
        margin: 15,
        items: 1,
        loop: true,
        dots: false,
        autoplayTimeout: 6000,
        autoplayHoverPause: true,
    });

    // 🔥 Next / Prev
    $(".custom-next").click(function () {
        owl.trigger("next.owl.carousel");
    });

    $(".custom-prev").click(function () {
        owl.trigger("prev.owl.carousel");
    });

    // 🔥 Slide change (ONLY source of truth)
    owl.on('changed.owl.carousel', function (event) {
        let realIndex = event.relatedTarget.relative(event.item.index);
        setActiveThumb(realIndex);
    });

    // 🔥 Thumbnail click
    $(".indicator-item").on("click", function () {
        let index = $(this).data("id");
        owl.trigger("to.owl.carousel", [index, 300]);
    });

    // 🔥 Helper
    function setActiveThumb(index) {
        $(".indicator-item").removeClass("active-thumb");
        $('.indicator-item[data-id="' + index + '"]').addClass("active-thumb");
    }

});
</script>

    {{-- <script>
        const indicators = document.querySelectorAll('.indicator-item');

        indicators.forEach(item => {
            item.addEventListener('click', function () {
                // Sob gulo active class remove
                indicators.forEach(i => i.classList.remove('active'));
                // Current item active
                this.classList.add('active');

                // Slider e corresponding image show korte chaile
                const id = this.dataset.id;
                const slider = document.querySelector('.details_slider');
                if (slider) {
                    // Owl Carousel er method use korte hobe
                    $(slider).trigger('to.owl.carousel', [id, 300]);
                }
            });
        });

        // Page load e first thumbnail active
        if (indicators.length > 0) {
            indicators[0].classList.add('active');
        }
    </script> --}}
    <script>
        var relatedSlider = new Swiper(".recently_slider1", {
            slidesPerView: 4,
            spaceBetween: 10,
            loop: true,

            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            breakpoints: {
                250: { slidesPerView: 2, spaceBetween: 10 },
                576: { slidesPerView: 3, spaceBetween: 15 },
                768: { slidesPerView: 4, spaceBetween: 20 },
                992: { slidesPerView: 5, spaceBetween: 20 },
                1200: { slidesPerView: 5, spaceBetween: 20 },
            },
        });
    </script>
    <script>
        var recentlySlider = new Swiper(".recently_slider", {
            slidesPerView: 4,
            spaceBetween: 10,
            loop: false,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            // autoplay: {
            //     delay: 3000,
            //     disableOnInteraction: false,
            // },
            breakpoints: {
                250: { slidesPerView: 2, spaceBetween: 10 },
                576: { slidesPerView: 3, spaceBetween: 15 },
                768: { slidesPerView: 4, spaceBetween: 20 },
                992: { slidesPerView: 5, spaceBetween: 20 },
                1200: { slidesPerView: 5, spaceBetween: 20 },
            },
        });
    </script>

    <script>
        $(document).ready(function () {
            $(".details_slider").owlCarousel({
                margin: 15,
                items: 1,
                loop: true,
                dots: false,
                autoplay: true,
                autoplayTimeout: 6000,
                autoplayHoverPause: true,
            });
            $(".indicator-item").on("click", function () {
                var slideIndex = $(this).data("id");
                $(".details_slider").trigger("to.owl.carousel", slideIndex);
            });
        });
    </script>
    <!--Data Layer Start-->


    <script type="text/javascript">
        $(document).ready(function () {
            $('#order_now').click(function () {
                gtag("event", "add_to_cart", {
                    currency: "BDT",
                    value: "1.5",
                    items: [
                        @foreach (Cart::instance('shopping')->content() as $cartInfo)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                {
                            item_id: "{{$combo->id}}",
                            item_name: "{{$combo->name}}",
                            price: "{{$combo->new_price}}",
                            currency: "BDT",
                            quantity: {{ $cartInfo->qty ?? 0 }}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                },
                        @endforeach
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ]
                });
            });
        });
    </script>

    <!-- Data Layer End-->
    <script>
        $(document).ready(function () {
            $(".related_slider").owlCarousel({
                margin: 10,
                items: 6,
                loop: true,
                dots: true,
                nav: true,
                autoplay: true,
                autoplayTimeout: 6000,
                autoplayHoverPause: true,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 2,
                        nav: true,
                    },
                    600: {
                        items: 3,
                        nav: false,
                    },
                    1000: {
                        items: 6,
                        nav: true,
                        loop: true,
                    },
                },
            });
            // $('.owl-nav').remove();
        });
    </script>


    <script>
        function sendSuccess() {
            // size validation
            size = document.forms["formName"]["product_size"].value;
            color = document.forms["formName"]["product_color"].value;
            if (size != "") {
                // access
            } else {
                toastr.warning("Please select any size");
                return false;
            }

            if (color != "") {
                // access
            } else {
                toastr.error("Please select any color");
                return false;
            }
        }
    </script>
    <script>
        $(document).ready(function () {
            $(".rating label").click(function () {
                $(".rating label").removeClass("active");
                $(this).addClass("active");
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $(".thumb_slider").owlCarousel({
                margin: 15,
                items: 4,
                loop: true,
                dots: false,
                nav: true,
                autoplayTimeout: 6000,
                autoplayHoverPause: true,
            });
        });
    </script>

 
    <script>
        const scrollBtn = document.querySelector(".scrolltop");

        window.addEventListener("scroll", () => {
            let scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
            let scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            let scrollPercent = (scrollTop / scrollHeight) * 100;

            // border progress update
            scrollBtn.style.background = `conic-gradient(#000 ${scrollPercent}%, transparent ${scrollPercent}%)`;
        });

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: "smooth" });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const swiper = new Swiper('.menulick', {
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
@endpush