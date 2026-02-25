@push('css')
    <link rel="stylesheet" href="{{ asset('public/css/responsive.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('public/css/style.css') }}" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

@endpush
@foreach($all_products as $product)
    <!-- Quick View Modal -->
    <div class="modal fade" id="quickViewModal-{{ $product->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 rounded-3 shadow-lg">

                <!-- Close Button -->
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3 z-3"
                    data-bs-dismiss="modal"></button>

                <div class="modal-body p-0">
                    <div class="row g-0">

                        <!-- Left: Product Image -->
                        <div class="col-lg-6 d-flex align-items-center justify-content-center bg-light">
                            <!-- Swiper main container -->
                            <div class="swiper product-main-swiper" style="position: relative;">
                                <div class="swiper-wrapper">
                                    <!-- Main product image -->
                                    <!-- <div class="swiper-slide">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <img src="{{ asset($product->image ? $product->image->image : '') }}"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        alt="{{ $product->name }}" class="main-hover-img" loading="lazy" />
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div> -->

                                    <!-- Other product images -->
                                    @foreach($product->images as $img)
                                        <div class="swiper-slide">
                                            <img style="object-fit: cover; height: 100%;width: 100%" src="{{ asset($img->image) }}"
                                                alt="{{ $product->name }}" loading="lazy" />
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Navigation arrows -->
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>

                                <!-- Pagination (optional) -->
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>


                        <!-- Right: Product Details -->
                        <div class="col-lg-6 p-4">
                            <p>Category: {{ $product->category ? $product->category->name : 'N/A' }}</p>

                            <h3 class="fw-bold">{{ $product->name }}</h3>

                            <!-- Price with discount -->
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="fw-bold text-danger fs-4">{{ $product->new_price }}৳</span>
                                @if($product->old_price > $product->new_price)
                                    <span class="text-decoration-line-through text-muted">{{ $product->old_price }}৳</span>
                                    <span
                                        class="badge bg-danger">-{{ round((($product->old_price - $product->new_price) / $product->old_price) * 100) }}%
                                        OFF</span>
                                @endif
                            </div>

                            <!-- Stock -->
                           <div class="stockmenu" style="margin:15px 0">
                                                @if ($product->stock < 1)
                                                    <span class="stockleft" style="border:1px solid #ff0000;color: #ff0000;">
                                                        Stock Out
                                                    </span>
                                                @elseif ($product->stock < 6)
                                                    <span class="stockleft" style="border:1px solid #ff0000;color: #ff0000;">
                                                        Only {{ $product->stock }} in stock
                                                    </span>
                                                @else
                                                    <span class="stockleft">
                                                        {{ $product->stock }} in stock
                                                    </span>
                                                @endif
                                            </div>
                            @php $modalId = $product->id; @endphp

                            <form action="{{ route('cart.store') }}" method="POST" id="quickViewForm-{{ $modalId }}"
                                class="quick-view-form" data-modal-id="{{ $modalId }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="product_color" value="">
                                <input type="hidden" name="product_size" value="">

                                <!-- Colors -->
                                @if($product->procolors->count() > 0)
                                    <div class="pro-color" style="width: 100%;">
                                        <div class="color_inner">
                                            <p>
                                                Color - <span id="selectedColor-{{ $modalId }}">Select Any Color</span>
                                            </p>

                                            <div class="size-container">
                                                <div class="selector"
                                                    style="display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px;">
                                                    @foreach($product->procolors as $procolor)
                                                        <div class="selector-item">
                                                            <input type="radio" id="fc-option{{ $procolor->id }}-{{ $modalId }}"
                                                                value="{{ $procolor->color ? $procolor->color->colorName : '' }}"
                                                                name="product_color_radio_{{ $modalId }}"
                                                                class="selector-item_radio emptyalert" required />

                                                            <label for="fc-option{{ $procolor->id }}-{{ $modalId }}"
                                                                style="margin-right:5px;background-color: {{ $procolor->color ? $procolor->color->color : '' }};border:1px solid #ccc;"
                                                                class="selector-item_label">
                                                                <span>
                                                                    <img src="{{ asset('public/frontEnd/images/check-icon.svg') }}"
                                                                        alt="Checked Icon" />
                                                                </span>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
document.addEventListener("DOMContentLoaded", function () {
    // সব product modal loop করে
    document.querySelectorAll("[id^='selectedColor-']").forEach(selectedColorEl => {
        const modalId = selectedColorEl.id.replace("selectedColor-", ""); // modalId বের করলাম
        const colorRadios = document.querySelectorAll(`input[name='product_color_radio_${modalId}']`);
        let lastSelected = null;

        colorRadios.forEach(radio => {
            radio.addEventListener("click", function () {
                const selectedTextEl = document.getElementById(`selectedColor-${modalId}`);
                if (lastSelected === this) {
                    // আবার একই radio ক্লিক করলে deselect হবে
                    this.checked = false;
                    selectedTextEl.textContent = "Select Any Color";
                    lastSelected = null;
                } else {
                    // নতুন color সিলেক্ট করলে সেট দেখাবে
                    lastSelected = this;
                    selectedTextEl.textContent = this.value || "None";
                }
            });
        });
    });
});
</script>

                                @endif

                                <!-- Sizes -->
                                @if ($product->prosizes->count() > 0)
                                    <div class="pro-size" style="width: 100%;">
                                        <div class="size_inner">
                                            <p>
                                                Size - <span id="selectedSize-{{ $modalId }}">Select Any Size</span>
                                            </p>

                                            <div class="size-container">
                                                <div class="selector"
                                                    style="display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px;">
                                                    @foreach ($product->prosizes as $prosize)
                                                        <div class="selector-item">
                                                            <input type="radio" id="f-option{{ $prosize->id }}-{{ $modalId }}"
                                                                value="{{ $prosize->size ? $prosize->size->sizeName : '' }}"
                                                                name="product_size_radio_{{ $modalId }}"
                                                                class="selector-item_radio emptyalert" required
                                                                style="display: none;" />

                                                            <label for="f-option{{ $prosize->id }}-{{ $modalId }}"
                                                                class="selector-item_label"
                                                                style="cursor:pointer; padding:5px 10px; border:1px solid #ccc; border-radius:4px; display:inline-block;">
                                                                {{ $prosize->size ? $prosize->size->sizeName : '' }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
document.addEventListener("DOMContentLoaded", function () {
    // সব product modal loop করে
    document.querySelectorAll("[id^='selectedSize-']").forEach(selectedSizeEl => {
        const modalId = selectedSizeEl.id.replace("selectedSize-", ""); // modalId বের করলাম
        const sizeRadios = document.querySelectorAll(`input[name='product_size_radio_${modalId}']`);
        let lastSelected = null;

        sizeRadios.forEach(radio => {
            radio.addEventListener("click", function () {
                const selectedTextEl = document.getElementById(`selectedSize-${modalId}`);
                if (lastSelected === this) {
                    // আবার একই radio ক্লিক করলে deselect হবে
                    this.checked = false;
                    selectedTextEl.textContent = "Select Any Size";
                    lastSelected = null;
                } else {
                    // নতুন size সিলেক্ট করলে সেট দেখাবে
                    lastSelected = this;
                    selectedTextEl.textContent = this.value || "None";
                }
            });
        });
    });
});
</script>

                                @endif
                                @if($product->stock < 1)
                                <p class="text-danger text-center border border-danger p-2">STOCK OUT</p>
                                 @else
                                <!-- Quantity + Add to Cart -->
                                <div class="pro-qty" id="pro-qty-{{ $modalId }}" style="width:100%; margin-bottom:15px;">
                                    <p style="font-weight:600; font-size:18px; margin-bottom:5px;">
                                        Quantity : <span id="selectedQty-{{ $modalId }}"></span>
                                    </p>

                                    <div class="qty-container" style="display:flex; align-items:center; gap:5px;">
                                        <button type="button" class="qty-btn minus"
                                            style="cursor:pointer; padding:5px 10px; border-radius:4px;">-</button>
                                        <input type="text" class="qty-input" name="qty" value="1" readonly
                                            style="width:40px; text-align:center; border-radius:4px; padding:4px;" />
                                        <button type="button" class="qty-btn plus"
                                            style="cursor:pointer; padding:5px 10px; border-radius:4px;">+</button>
                                    </div>
                                </div>

                                <div class="btnset2partforquickview">
                                    
                                    <div class="setflex d-flex gap-2">
                                                            <button type="submit" class="btn add_cart_btn1" id="addCartBtn-{{ $modalId }}"
                                        data-base-price="{{ $product->new_price }}">
                                        Add to cart
                                    </button>
                                                             @php
                                                            $wishlist = json_decode(request()->cookie('wishlist', '[]'), true);
                                                            $inWishlist = isset($wishlist[$product->id]);
                                                        @endphp

                                                        <button type="button" class="wishlist-toggle add_wishlist_btn" data-product-id="{{ $product->id }}">
                                                            @if($inWishlist)
                                                                <!-- In wishlist → show trash SVG -->
                                                            <svg class="wishlist-icon" width="24" height="24" aria-hidden="true" role="img" focusable="false" style="color: #1a1a1b;">
                                                                    <use href="#trash" xlink:href="#trash"></use>
                                                                </svg>

                                                            @else
                                                                <!-- Not in wishlist → show heart SVG -->
                                                                <svg width="24" height="24" aria-hidden="true" role="img" focusable="false">
                                                                    <use href="#heart" xlink:href="#heart"></use>
                                                                </svg>
                                                            @endif
                                                        </button>
                                                        </div>


                                    <button type="submit" name="order_now" value="1" class="btn mt-2 order_now_btn1">
                                        BUY IT NOW <i class="fa-solid fa-arrow-up-right"></i>
                                    </button>
                                </div>
                                @endif
                                <div class="ViewFullDetailsbtn">
                                    <a href="{{ route('product', $product->slug) }}">
                                        View full details →
                                    </a>
                                </div>
                            </form>
                            <div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endforeach
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<!-- Script -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    // সব modal detect করা
    document.querySelectorAll('.modal').forEach(modal => {

        modal.addEventListener('show.bs.modal', function () {
            const form = modal.querySelector('.quick-view-form');
            if (!form) return; // যদি form না থাকে, skip

            const modalId = form.dataset.modalId;
            const hiddenColor = form.querySelector('input[name="product_color"]');
            const hiddenSize = form.querySelector('input[name="product_size"]');
            const selectedColor = form.querySelector('#selectedColor-' + modalId);
            const selectedSize = form.querySelector('#selectedSize-' + modalId);
            const addCartBtn = form.querySelector("#addCartBtn-" + modalId);
            const buyItBtn = form.querySelector(".order_now_btn1");
            const qtyContainer = form.querySelector("#pro-qty-" + modalId);
            const qtyInput = qtyContainer ? qtyContainer.querySelector("input[name='qty']") : null;
            const minusBtn = qtyContainer ? qtyContainer.querySelector(".minus") : null;
            const plusBtn = qtyContainer ? qtyContainer.querySelector(".plus") : null;

            let quantity = qtyInput ? parseInt(qtyInput.value) || 1 : 1;
            const basePrice = addCartBtn ? parseFloat(addCartBtn.dataset.basePrice) || 0 : 0;
            const hasSize = form.querySelectorAll('input[name="product_size_radio_' + modalId + '"]').length > 0;
            const hasColor = form.querySelectorAll('input[name="product_color_radio_' + modalId + '"]').length > 0;
            let lastSelectedColor = null;
            let lastSelectedSize = null;

            function updateAddCartPrice() {
                quantity = qtyInput ? parseInt(qtyInput.value) || 1 : 1;
                if (!addCartBtn) return;

                const sizeOk = hasSize ? hiddenSize.value : true;
                const colorOk = hasColor ? hiddenColor.value : true;

                if ((!hasSize && !hasColor) || (sizeOk && colorOk)) {
                    addCartBtn.textContent = "Add to cart – " + (basePrice * quantity).toFixed(2) + "৳";
                    addCartBtn.style.opacity = 1;
                    addCartBtn.style.pointerEvents = "auto";
                    if (buyItBtn) buyItBtn.style.opacity = 1;
                    if (buyItBtn) buyItBtn.style.pointerEvents = "auto";
                } else {
                    addCartBtn.textContent = "Add to cart";
                    addCartBtn.style.opacity = 0.4;
                    addCartBtn.style.pointerEvents = "none";
                    if (buyItBtn) buyItBtn.style.opacity = 0.4;
                    if (buyItBtn) buyItBtn.style.pointerEvents = "none";
                }
            }

            // Color selection
            form.querySelectorAll('input[name="product_color_radio_' + modalId + '"]').forEach(radio => {
                radio.addEventListener('click', function () {
                    if (lastSelectedColor === this) {
                        this.checked = false;
                        hiddenColor.value = "";
                        selectedColor.textContent = "Select Any Color";
                        lastSelectedColor = null;
                    } else {
                        lastSelectedColor = this;
                        hiddenColor.value = this.value;
                        selectedColor.textContent = this.value || "None";
                    }
                    updateAddCartPrice();
                });
            });

            // Size selection
            form.querySelectorAll('input[name="product_size_radio_' + modalId + '"]').forEach(radio => {
                radio.addEventListener('click', function () {
                    if (lastSelectedSize === this) {
                        this.checked = false;
                        hiddenSize.value = "";
                        selectedSize.textContent = "Select Any Size";
                        lastSelectedSize = null;
                    } else {
                        lastSelectedSize = this;
                        hiddenSize.value = this.value;
                        selectedSize.textContent = this.value || "None";
                    }
                    updateAddCartPrice();
                });
            });

            // Quantity buttons
            if (qtyInput && minusBtn && plusBtn) {
                minusBtn.addEventListener("click", e => {
                    e.preventDefault();
                    if (quantity > 1) quantity -= 1;
                    qtyInput.value = quantity;
                    updateAddCartPrice();
                });
                plusBtn.addEventListener("click", e => {
                    e.preventDefault();
                    quantity += 1;
                    qtyInput.value = quantity;
                    updateAddCartPrice();
                });
            }

            // Form validation
            form.addEventListener('submit', e => {
                if (hasSize && !hiddenSize.value) {
                    alert('Please select a size.');
                    e.preventDefault();
                }
                if (hasColor && !hiddenColor.value) {
                    alert('Please select a color.');
                    e.preventDefault();
                }
                if (qtyInput && (!qtyInput.value || parseInt(qtyInput.value) < 1)) {
                    alert('Quantity must be at least 1.');
                    e.preventDefault();
                }
            });

            updateAddCartPrice();
        });

    });

});
</script>






<script>
    var swiper = new Swiper('.product-main-swiper', {
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        // autoplay: {
        //     delay: 000,
        //     disableOnInteraction: false,
        // },
        slidesPerView: 1,
        spaceBetween: 10,
    });
</script>