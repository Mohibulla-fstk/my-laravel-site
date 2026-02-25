<div class="cartmenu">
    <div class="headtext">
        <span>Shopping Cart</span>
        <div class="crossmark"> <i class="fa-solid fa-xmark"></i></div>
    </div>

    <div class="maincontent">
        <ul id="cart-section">
            @foreach (Cart::instance('shopping')->content() as $value)
                <li class="productcartshowarea">
                    <!-- Quantity Section -->
                    <div class="customquantity">
                        <button type="button" class="ctrl minus cart_decrement" data-id="{{ $value->rowId }}">−</button>
                        <div class="value-box">
                            <input type="text" class="qty-input" value="{{ $value->qty }}" readonly />
                        </div>
                        <button type="button" class="ctrl plus cart_increment" data-id="{{ $value->rowId }}">+</button>
                    </div>

                    <!-- Product Image -->
                    <a href=""><img src="{{ asset($value->options->image) }}" alt="" /></a>

                    <!-- Product Name & Price -->
                    <div class="highsection">
                        <div class="cartmiddlepart">
                            <div class="productnamecartsection">
                                <a class="ppricecart" href="">{{ Str::limit($value->name, 40) }}</a>
                            </div>
                        </div>
                        <div class="secpricecart cart-containe">
                            <p class="cartprice">৳{{ $value->price * $value->qty }}</p>
                            <p class="cartqnty">({{ $value->price }}৳ X {{ $value->qty }})</p>
                        </div>
                    </div>

                    <!-- Remove Button -->
                    <button class="remove-cart cart_remove" data-id="{{ $value->rowId }}">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </li>
            @endforeach
        </ul>

        <p>Total: <span id="cart_total">{{ Cart::instance('shopping')->subtotal() }}</span></p>

    </div>

    <!-- Checkout Section -->
    <div class="btnfixedset">
        <div class="bottomsetforcart">
            <p class="checkoutpstyle">
                <a href="{{ route('customer.checkout') }}">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span>Total ({{ Cart::instance('shopping')->count() }}) Items</span>
                </a>
            </p>
            <p class="checkoutpstyle"><strong>Total Price : ৳{{ $subtotal }}</strong></p>
            <a href="{{ route('customer.checkout') }}" class="go_cart"> Checkout </a>
        </div>
    </div>
</div>

<script>
    function reloadCart(data) {
        $('#cart-area').html(data.html); // পুরো cartmenu.blade.php replace হবে
        $('#cart_total').text(data.total); // total price update
        $('#cart_count').text(data.count); // যদি header এ cart count থাকে
    }

    $(document).on('click', '.cart_increment', function () {
        let rowId = $(this).data('id');
        $.get('/cart/increment/' + rowId, function (data) {
            reloadCart(data);
        });
    });

    $(document).on('click', '.cart_decrement', function () {
        let rowId = $(this).data('id');
        $.get('/cart/decrement/' + rowId, function (data) {
            reloadCart(data);
        });
    });

    $(document).on('click', '.cart_remove', function () {
        let rowId = $(this).data('id');
        $.get('/cart/remove/' + rowId, function (data) {
            reloadCart(data);
        });
    });


</script>