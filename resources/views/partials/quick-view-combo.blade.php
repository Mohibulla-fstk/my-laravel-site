@push('css')
    <link rel="stylesheet" href="{{ asset('public/css/responsive.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('public/css/style.css') }}" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

@endpush
@php $modalId = $combo->id; @endphp

<div class="modal fade" id="quickViewModalCombo-{{ $modalId }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 rounded-3 shadow-lg">

            <!-- Close Button -->
            <button type="button" class="btn-close position-absolute top-0 end-0 m-3 z-3"
                data-bs-dismiss="modal"></button>

            <div class="modal-body p-0">
                <div class="row g-0">

                    <!-- Left: Combo Images -->
                    <div class="col-lg-6 d-flex align-items-center justify-content-center bg-light">
                        <div class="swiper product-main-swiper">
                            <div class="swiper-wrapper">
                                {{-- Main combo image --}}
                                <div class="swiper-slide">
                                    <img src="{{ asset($combo->images->first()?->image ?? 'public/default.png') }}"
                                         alt="{{ $combo->name }}" style="object-fit: cover;" class="main-hover-img"
                                         loading="lazy">
                                </div>

                                {{-- Combo items images --}}
                                @foreach($combo->products as $item)
                                    <div class="swiper-slide">
                                        <img src="{{ asset($item->image?->image ?? 'public/default.png') }}" alt="{{ $item->name }}"
                                             style="object-fit: cover;" loading="lazy">
                                    </div>
                                @endforeach
                            </div>

                            <!-- Navigation arrows -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>

                            <!-- Pagination -->
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>

                    <!-- Right: Combo Details -->
                    <div class="col-lg-6 p-4">
                        <p>Category: {{ $combo->category->name ?? 'N/A' }}</p>
                        <h3 class="fw-bold">{{ $combo->name }}</h3>

                        <!-- Price -->
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <span class="fw-bold text-danger fs-4">{{ $combo->new_price }}৳</span>
                            @if($combo->old_price > $combo->new_price)
                                <span class="text-decoration-line-through text-muted">
                                    {{ $combo->old_price }}৳
                                </span>
                            @endif
                        </div>

                        <!-- Included Products -->
                        <h6>Included Products:</h6>
                        <ul>
                            @foreach($combo->products as $p)
                                <li>{{ $p->name ?? '-' }} (Qty: 1)</li>
                            @endforeach
                        </ul>

                        <!-- Quantity + Add to Cart -->
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="combo_id" value="{{ $combo->id }}">
                            <input type="hidden" name="qty" value="1">

                            <div class="pro-qty" style="width:100%; margin-bottom:15px;">
                                <p style="font-weight:600; font-size:18px; margin-bottom:5px;">Quantity:</p>
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
                                <button type="submit" class="btn add_cart_btn1" data-base-price="{{ $combo->new_price }}">
                                    Add to cart – {{ $combo->new_price }}৳
                                </button>
                                <button type="submit" name="order_now" value="1" class="btn mt-2 order_now_btn1">
                                    BUY IT NOW <i class="fa-solid fa-arrow-up-right"></i>
                                </button>
                            </div>

                            <div class="ViewFullDetailsbtn mt-3">
                                <a href="{{ route('combo.show', $combo->slug) }}">View full details →</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<script>
    document.querySelectorAll('.quick-view-form').forEach(form => {
        const modalId = form.dataset.modalId; // form element e data-modal-id attribute থাকতে হবে

        // hidden inputs
        const hiddenColor = form.querySelector('input[name="product_color"]');
        const hiddenSize = form.querySelector('input[name="product_size"]');
        const selectedColor = form.querySelector('#selectedColor-' + modalId);
        const selectedSize = form.querySelector('#selectedSize-' + modalId);

        // radios
        form.querySelectorAll('input[name="product_color_radio_' + modalId + '"]').forEach(radio => {
            radio.addEventListener('change', function () {
                hiddenColor.value = this.value;
                if (selectedColor) selectedColor.textContent = this.value || "None";
            });
        });

        form.querySelectorAll('input[name="product_size_radio_' + modalId + '"]').forEach(radio => {
            radio.addEventListener('change', function () {
                hiddenSize.value = this.value;
                if (selectedSize) selectedSize.textContent = this.value || "None";
            });
        });

        // qty
        // Quantity elements
        const qtyContainer = document.getElementById("pro-qty-" + modalId);
        const qtyInput = qtyContainer.querySelector("input[name='qty']");
        const minusBtn = qtyContainer.querySelector(".minus");
        const plusBtn = qtyContainer.querySelector(".plus");
        const addCartBtn = document.getElementById("addCartBtn-" + modalId);

        let quantity = parseInt(qtyInput.value);
        let basePrice = parseFloat(addCartBtn.dataset.basePrice); // ensures exact number


        function updateQtyDisplay() {
            qtyInput.value = quantity;
        }

        // Event listeners for + / -
        minusBtn.addEventListener("click", function (e) {
            e.preventDefault();
            if (quantity > 1) {
                quantity -= 1;
                addCartBtn.textContent = "Add to cart – " + (basePrice * quantity).toFixed(0) + "৳";

            }
        });

        plusBtn.addEventListener("click", function (e) {
            e.preventDefault();
            quantity += 1;
            addCartBtn.textContent = "Add to cart – " + (basePrice * quantity).toFixed(0) + "৳";

        });

        updateQtyDisplay();

        // validation before submit
        form.addEventListener('submit', e => {
            if (form.querySelectorAll('input[name="product_color_radio_' + modalId + '"]').length && !hiddenColor.value) {
                alert('Please select a color.');
                e.preventDefault();
                return false;
            }
            if (form.querySelectorAll('input[name="product_size_radio_' + modalId + '"]').length && !hiddenSize.value) {
                alert('Please select a size.');
                e.preventDefault();
                return false;
            }
            if (!qtyInput.value || parseInt(qtyInput.value) < 1) {
                alert('Quantity must be at least 1.');
                e.preventDefault();
                return false;
            }
        });
    });
</script>
