@extends('frontEnd.layouts.master')
@section('title', 'Customer Checkout') 

  

 @section('content')
    <div class="blankspace"></div>
    <div class="gradient-bg">
        <Span>checkout</Span>
    </div>
    <div class="max-width">
        <section class="chheckout-section">
            @php
                $applied = session('coupon');

                // Cart subtotal
                $subtotal = Cart::instance('shopping')->subtotal();
                $subtotal = str_replace(',', '', $subtotal);
                $subtotal = str_replace('.00', '', $subtotal);

                // Shipping
                $shipping = Session::get('shipping') ?? 0;

                // Discount & shipping discount (product-specific)
                $discount = $applied['discount'] ?? 0;
                $shipOff = $applied['shipping_discount'] ?? 0;

                // If product-specific coupon, use session subtotal for that product
                if ($applied && isset($applied['product_id'])) {
                    $productId = $applied['product_id'];
                    $productPrice = 0;
                    foreach (Cart::instance('shopping')->content() as $cartItem) {
                        if ($cartItem->id == $productId) {
                            $productPrice = $cartItem->price * $cartItem->qty;
                        }
                    }
                    $subtotal = $productPrice;
                }

                $grandTotal = max(0, ($subtotal - $discount) + max(0, $shipping - $shipOff));
            @endphp

        
            <div class="container">
                <div class="coupon-system" style="font-size: 14px">
    <input type="checkbox" name="showcoupon" id="showcoupon">
    <span>Have any Coupon? <label for="showcoupon"><a style="text-decoration: underline;">Enter your Code</a></label></span>
    <div class="coupon-totals" id="couponTotals">
        <div id="couponArea" class="{{ session('coupon') ? 'active' : '' }}">
            @if(session('coupon'))
                <div class="btnforcouponapplied">
                    <span>You have Applied: {{ session('coupon.code') }}</span>
                    <button type="button" id="removeCouponBtn">Remove Coupon</button>
                </div>
            @else
                <div class="btnforcoupon">
                    <input type="text" id="couponCodeInput" placeholder="Enter coupon code" style="text-transform: none;">
                    <button type="button" id="applyCouponBtn">Apply Coupon</button>
                </div>
            @endif
        </div>
    </div>
</div>

          
                <div class="row">

                    <div class="col-sm-5 cus-order-2">
                        
                        <div class="checkout-shipping">
                            <form action="{{ route('customer.ordersave') }}" method="POST" data-parsley-validate="">
                                @csrf
                                <div class="card-main">
                                    <div class="card-header1" style="padding: 10px 0px;">
                                        
                                        <!-- <h6>আপনার অর্ডারটি কনফার্ম করতে তথ্যগুলো পূরণ করে <span style="color:#fe5200;">"অর্ডার
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                করুন"</span> বাটন এ ক্লিক করুন অথবা ফোনে অর্ডার করতে এই নাম্বার <a
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                href="tel:{{ $contact->hotline }}">{{ $contact->hotline }}</a> এর উপরে ক্লিক
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            করুন। </h6> -->
                                        <h3>Billing Details</h3>
                                    </div>
                                    <div class="card-body" style="padding: 20px; border: 1px solid #e2e2e2;">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group mb-3">
                                                    <label for="name">Your Name <span>*</span></label>
                                                    <input type="text" id="name"
                                                        class="form-control @error('name') is-invalid @enderror extraborder" name="name"
                                                        value="{{ old('name') }}" required style="font-size:15px;padding:10px 15px; border-radius: 20px;resize: none;border: 1px solid #EBEBEB;"/>
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- col-end -->
                                            <div class="col-sm-12">
                                                <div class="form-group mb-3">
                                                    <label for="phone">Your Mobile Number <span
                                                            >*</span></label>
                                                    <input type="text" minlength="11" id="number" maxlength="11"
                                                        pattern="0[0-9]+"
                                                        title="please enter number only and 0 must first character"
                                                        title="Please enter an 11-digit number." id="phone"
                                                        class="border-rd form-control @error('phone') is-invalid @enderror extraborder"
                                                        name="phone" value="{{ old('phone') }}" required style="font-size:15px;padding:10px 15px; border-radius: 20px;resize: none;border: 1px solid #EBEBEB;"/>
                                                    @error('phone')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- col-end -->
                                            <div class="col-sm-12">
                                                <div class="form-group mb-3">
                                                    <label for="address">Your Address <span
                                                            >*</span></label>
                                                    <input type="address" id="address"
                                                        class="border-rd form-control @error('address') is-invalid @enderror"
                                                        name="address" value="{{ old('address') }}" required style="font-size:15px;padding:10px 15px; border-radius: 20px;resize: none;border: 1px solid #EBEBEB;"/>
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group mb-3">
                                                    <label for="note">Your note (Optional)</label>
                                                    <textarea type="note" id="note"
                                                        class="border-rd form-control @error('note') is-invalid @enderror"
                                                        name="note" value="{{ old('note') }}" placeholder="Notes about your order, e.g. special notes for delivery." required rows="4" style="font-size:15px;padding:10px 15px; border-radius: 20px;resize: none;border: 1px solid #EBEBEB;"></textarea>
                                                    @error('note')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group mb-3">
                                                    <label for="area">Delivery Area <span
                                                            >*</span></label>
                                                    <div class="select-wrapper">
                                                        <select type="area" id="area"
                                                            class="form-control @error('area') is-invalid @enderror extraborder"
                                                            name="area"
                                                            required
                                                            style="cursor:pointer;border-radius: 20px;resize: none;border:1px solid #e2e2e2;background:#f7f7f7">
                                                            
                                                            <option value="0" data-charge="0" selected>Select</option>
                                                            @foreach ($shippingcharge as $value)
                                                                <option value="{{ $value->id }}" data-charge="{{ $value->amount }}">
                                                                    {{ $value->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        <!-- 👇 Arrow icon -->
                                                        <i class="fa-solid fa-angle-down select-arrow"></i>
                                                    </div>

                                                    @error('area')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- col-end -->

                                            <!-------------------->
                                            <!-- col-end -->
                                            <div class="col-sm-12">

                                                <div class="radio_payment">
                                                    <label id="payment_method">Payment Method</label>
                                                    <div class="payment_option">

                                                    </div>
                                                </div>
                                                <div class="payment-methods">

                                                    <div class="form-check p_cash">
                                                        <input class="form-check-input" type="radio" name="payment_method"
                                                            id="inlineRadio1" value="Cash On Delivery" checked required />
                                                        <label class="form-check-label" for="inlineRadio1">
                                                            Cash On Delivery
                                                        </label>
                                                    </div>
                                                    @if($bkash_gateway)
                                                        <div class="form-check p_bkash">
                                                            <input class="form-check-input" type="radio" name="payment_method"
                                                                id="inlineRadio2" value="bkash" required />
                                                            <label class="form-check-label" for="inlineRadio2">
                                                                Bkash
                                                            </label>
                                                        </div>
                                                    @endif

                                                    @if($shurjopay_gateway)
                                                        <div class="form-check p_shurjo">
                                                            <input class="form-check-input" type="radio" name="payment_method"
                                                                id="inlineRadio3" value="shurjopay" required />
                                                            <label class="form-check-label" for="inlineRadio3">
                                                                Shurjopay
                                                            </label>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-------------------->
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <button class="order_place" type="submit">Place Order</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- card end -->




                            </form>
                        </div>
                    </div>
                    <!-- col end -->

                    <div class="col-sm-7 cust-order-1">
                       
                        <div class="cart_details table-responsive-sm">
                            <div class="card-main cartlist">
                                <div class="card-header1" style="padding: 8px 0px;">
                                    <h3>Your order</h3>
                                </div>
                                <div class="order-wrapper" id="orderWrapper">
                                    <div class="shipping-progress">
                                        <div class="progress-filled"></div>
                                        <div class="truck-icon"><i class="fa-sharp fa-light fa-truck"></i></div>
                                    </div>
                                    <p id="shippingText" style="font-size: 14px">
                                        Buy <strong><span id="remainingAmount">0.00</span>৳</strong> more to enjoy <strong>FREE SHIPPING</strong>
                                    </p>
                                </div>
                                <div class="card-body " style="padding: 20px;margin-top:20px; border:1px solid #e2e2e2;background:#fbfbfc">
                                    <p style="font-weight: bold; font-size: 15px">Product</p>
                                    <table class="cart_table table table-bordered table-striped text-center mb-0">
                                        <!-- <thead>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <th style="width: 20%;">Delete</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <th style="width: 40%;">Product</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <th style="width: 20%;">Quantity</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <th style="width: 20%;">Price</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </thead> -->
                                        <div class="checkoutareacart" >
                                

                                                @foreach (Cart::instance('shopping')->content() as $value)

                                                   <div class="partCot">
                                                     <div class="productcartshowareaforcheckout">
                                  
                                                       <div class="cartimgforcheckout">
                                                        <a href="{{$value->options->get('is_combo') && $value->options->get('is_combo')
                                                                    ? route('combo.show', $value->options->slug) 
                                                                    : route('product', $value->options->slug) }}">
                                                            
                                                            @if(isset($value->options->is_combo) && $value->options->is_combo)
                                                                {{-- Combo Image --}}
                                                                <img style="width: 130px; height:auto;" src="{{ asset($value->options->combo_image ?? 'public/uploads/default/user.png') }}" alt="Combo Image">
                                                            @else
                                                                {{-- Product Image --}}
                                                                <img style="width: 130px; height:auto;" src="{{ asset($value->options->image ?? 'public/default.png') }}" alt="Product Image">
                                                            @endif
                                                        </a>
                                                    </div>

                                                        <div class="cartpriceforcheckout">
                                                            <div class="tyepset">
                                                                <div class="name1sttype">
                                                                  <a href="{{$value->options->get('is_combo') && $value->options->get('is_combo')
                                                                    ? route('combo.show', $value->options->slug) 
                                                                    : route('product', $value->options->slug) }}">
                                                                        <h4 style="font-size: 16px">  {{ Str::limit($value->name, 200) }}   @if($value->options->get('is_combo'))
                                                                                    <span class="badge bg-warning" style="margin-left:5px;">Combo</span>
                                                                                @endif
                                                                        </h4>
                                                            </a>
                                                            </div>
                                                            <div class="name2ndtype">

                                                              @php
                        $product = App\Models\Product::find($value->id);
                    @endphp

                    @if($product && ($product->sizes->isNotEmpty() || $product->colors->isNotEmpty()))
                        <div class="row g-1 mt-2">
                            <!-- Size Selector -->
                            @if($product->sizes->isNotEmpty())
                                <div class="col-6">

                                    <select style="font-size: 13px" id="size-selector-{{ $value->rowId }}"
                                        class="form-select form-select-sm cart-size-selector" data-id="{{ $value->rowId }}">
                                        <option>Select an option</option>
                                        @foreach($product->sizes as $size)
                                            <option value="{{ $size->sizeName }}" {{ $size->sizeName == $value->options->product_size ? 'selected' : '' }}>
                                                {{ $size->sizeName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="size-selector-{{ $value->rowId }}" class="form-label text-muted text-start"
                                        style="font-size: 12px;">Size:
                                        @if($value->options->product_size)
                                            {{$value->options->product_size}}
                                        @endif
                                    </label>
                                </div>
                            @endif

                            <!-- Color Selector -->
                            @if($product->colors->isNotEmpty())
                                <div class="col-6">
                                    <select style="font-size: 13px" id="color-selector-{{ $value->rowId }}"
                                        class="form-select form-select-sm cart-color-selector" data-id="{{ $value->rowId }}">
                                        <option>Select an option</option>
                                        @foreach($product->colors as $color)
                                            <option value="{{ $color->colorName }}" {{ $color->colorName == $value->options->product_color ? 'selected' : '' }}>
                                                {{ $color->colorName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="color-selector-{{ $value->rowId }}" class="form-label text-muted text-start"
                                        style="font-size: 12px;">Color:
                                        @if($value->options->product_color)
                                            {{ $value->options->product_color }}
                                        @endif
                                    </label>
                                </div>
                            @endif
                        </div>
                    @endif
                                                     
                                                            </div>
                                                                    <div class="name3rdtype">
                                                            <div class="cartandremovebtnset">
                                                                    <div class="customquantity"
                                    style="border:1px solid #ff9900; border-radius: 0; background: none;">
                                    <button type="button"
                                        style="border-right:1px solid #ff9900; border-radius: 0; background: none;"
                                        class="ctrl minus cart_decrementt"
                                        data-id="{{ $value->rowId }}" aria-label="decrease">−</button>
                                    <div class="value-box">
                                        <input type="text" class="qty-input" value="{{ $value->qty }}" readonly
                                            aria-label="quantity" />
                                    </div>
                                    <button style="border-left:1px solid #ff9900; border-radius: 0; background: none;"
                                        type="button" class="ctrl plus cart_incrementt" data-id="{{ $value->rowId }}"
                                        aria-label="increase">+</button>
                                </div>
                                        <div class="btnforremovecheckout">
                                            <a class="cart_removee" data-id="{{ $value->rowId }}"><i class="fa-solid fa-trash-xmark cart_removee"></i></a>
                                        </div>
                                                            </div>
                                                            
                                                            </div>
                                                                    </div>
                                                            <div class="nametypeprice" style="text-align: end">
                                                                <strong>{{ $value->price }} ৳</strong>
                                                                </div>
                                                                </div>
                                                        
                                                    
                                                        

                                                    </div>
                                                      <div class="comboProductcartSection">
                                                    @if($value->options->get('is_combo'))
                                            
                                                
                                                <div id="combo-items-{{ $loop->index }}" class="combo-inner-products" style=" margin-top:5px;">
                                                    @foreach($value->options->get('combo_items') ?? [] as $p)
                                                        <div class="productcartshowarea productcartpart2forcombo" style="display: grid; grid-template-columns:10% 20% 40% 30%; gap: 0px; margin-bottom:5px; padding-bottom:5px;">
                                                            <div class="sideblankspace"></div>
                                                            {{-- ✅ Image --}}
                                                            <div class="part-imgpcart">
                                                            
                                                                <a class="cart-photo" href="{{ route('product', $p['slug']) }}">
                                                                    
                                                                    <img src="{{ asset($p['image']) }}" alt="{{ $p['name'] }}" style="width:100%; object-fit:cover;" />
                                                                </a>
                                                        
                                                            </div>

                                                            {{-- ✅ Name + Details --}}
                                                            <div class="part-namepcart">
                                                                <div class="highsection">
                                                                    <div class="cartmiddlepart">
                                                                        <div class="productnamecartsection">
                                                                            <a class="ppricecart" href="#">{{ Str::limit($p['name'], 40) }}</a>
                                                                            @if($p['is_combo'] ?? false)
                                                                                <span class="badge bg-warning" style="margin-left:5px;">Combo</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    {{-- ✅ Color & Size --}}
                                                                    <div class="size-part">
                                                                        <p>Size - {{ $p['size'] ?? 'N/A' }}</p>
                                                                        <p>Color - {{ $p['color'] ?? 'N/A' }}</p>
                                                                        <p>Quantity - {{ $value->qty }}</p>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="secpricecart" style="text-align: right;">
                                                                <span class="cartprice">
                                                                    0 ৳
                                                                </span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            </div>
                                                   </div>
                                                @endforeach
                                        
                                        </div>


                                        <tfoot>
                                            <tr style="border: none">
                                                <th colspan="3" class="text-start px-2" style="border: none; font-weight: 500; font-size:14px;">Subtotal</th>
                                                <td class="text-end px-2" style="border: none; font-weight: 500; font-size:14px;">
                                                    <span id="net_total"><span
                                                            class="alinur"></span><strong>{{ number_format($subtotal, 2) }}
                                                            ৳</strong></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" class="text-start px-2" style="border: none; font-weight: 500; font-size:14px;">Delivery Charge</th>
                                                <td class="text-end px-2" style="border: none; font-weight: 500; font-size:14px;">
                                                    <span id="cart_shipping_cost"><span
                                                            class="alinur"></span><strong>{{ number_format($shipping, 2) }}
                                                            ৳</strong></span>
                                                </td>
                                            </tr>
                                            <tr id="couponRow" style="{{ $applied ? '' : 'display:none;' }}">
                                                <th colspan="3" class="text-start px-2" style="border: none; font-weight: 500; font-size:14px;">Coupon Discount</th>
                                                <td class="text-end px-2" style="border: none; font-weight: 500; font-size:14px;">
                                                    <span id="discount_amount"><span
                                                            class="alinur"></span><strong>-{{ number_format($discount, 2) }}
                                                            ৳</strong></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" class="text-start px-2" style="border: none; font-weight: 500;font-size:14px;">Shipping Discount</th>
                                                <td class="text-end px-2" style="border: none; font-weight: 500;font-size:14px;">
                                                    <span id="ship_discount_amount"><span
                                                            class="alinur"></span><strong>{{ number_format($shipOff, 2) }}
                                                            ৳</strong></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" class="text-start px-2" style="border: none; font-size:20px;">Total</th>
                                                <td class="text-end px-2" style="border: none;">
                                                    <span id="grand_total" style="font-size:20px"><span
                                                            class="alinur"></span><strong>{{ number_format($grandTotal, 2) }}
                                                            ৳</strong></span>
                                                </td>
                                            </tr>
                                        </tfoot>



                                    </table>
                                    <div class="card-footer text-danger" style="margin-top:10px;border-left: 4px solid red; padding-left:10px">
                                    {!! $generalsetting->checkout_note !!}
                                </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <!-- col end -->
                </div>
            </div>
        </section>
    </div>
@endsection 
@push('script')
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" 
        integrity="sha256-3gJwYpMe3Q0n4H9o0v+6b0omB6+H8vT9g5cF4/2k9HE=" 
        crossorigin="anonymous"></script>


<script>
 const freeShippingTarget = {{ $generalsetting->free_shipping ?? 0 }};


// Function to update progress bar & colors
function updateFreeShippingProgress(cartTotal) {
    setTimeout(() => {
    const progress = Math.min(100, (cartTotal / freeShippingTarget) * 100);
    const remaining = Math.max(0, freeShippingTarget - cartTotal);

    const progressBar = document.querySelector('.progress-filled');
    const truck = document.querySelector('.truck-icon');

    progressBar.style.width = progress + '%';
    truck.style.left = progress + '%';

    if(progress >= 100){
        progressBar.classList.add('success');
        progressBar.classList.remove('warning','danger');
        truck.classList.add('success');
        $('#shippingText').html('<span class="success-text">Congratulations! You have got FREE SHIPPING!</span>');
    } else if(progress >= 60){
        progressBar.classList.add('warning');
        progressBar.classList.remove('success','danger');
        truck.classList.add('warning');
        truck.classList.remove('success','danger');
        $('#remainingAmount').text(remaining.toFixed(2));
    } else {
        progressBar.classList.add('danger');
        progressBar.classList.remove('success','warning');
        truck.classList.add('danger');
        truck.classList.remove('success','warning');
        
        $('#remainingAmount').text(remaining.toFixed(2));
    }
     }, 300);
}

// Initial load
updateFreeShippingProgress(parseFloat($('#net_total').text().replace(/[^\d.-]/g,'')) || 0);

// AJAX function for cart updates
function updateCart(rowId, action){
    $.ajax({
        url: '/cart/update', // replace with your route
        method: 'POST',
        data: { rowId: rowId, action: action },
        success: function(response){
            if(response.subtotal !== undefined){
                $('#net_total').text(response.subtotal.toFixed(2));
                updateFreeShippingProgress(response.subtotal);
            }
            if(response.cart_html){
                $('#cart-items-container').html(response.cart_html);
            }
        },
        error: function(err){
            console.error('Cart update failed:', err);
        }
    });
}

// Increment quantity
$(document).on('click', '.cart_incrementt', function(e){
    e.preventDefault();
    const rowId = $(this).data('id');
    updateCart(rowId, 'increment');
});

// Decrement quantity
$(document).on('click', '.cart_decrementt', function(e){
    e.preventDefault();
    const rowId = $(this).data('id');
    updateCart(rowId, 'decrement');
});

// Remove item
$(document).on('click', '.cart_removee', function(e){
    e.preventDefault();
    const rowId = $(this).data('id');
    updateCart(rowId, 'remove');
});
</script>

    <script src="{{ asset('public/frontEnd/') }}/js/parsley.min.js"></script>
    <script src="{{ asset('public/frontEnd/') }}/js/form-validation.init.js"></script>
    <script src="{{ asset('public/frontEnd/') }}/js/select2.min.js"></script>
    
<script>
$(document).ready(function() {

    let subtotal = parseFloat(`{{ $subtotal }}`) || 0;
    let discount = parseFloat(`{{ $discount }}`) || 0;
    let shipDiscount = parseFloat(`{{ $shipOff }}`) || 0;

    // 🔴 IMPORTANT: initial shipping = 0
    let shippingCharge = 0;

    // 🔹 Page load এ forcefully 0 দেখাও
    $('#area').val(0);
    $('#cart_shipping_cost strong').text('0.00 ৳');

    let initialGrandTotal = subtotal - discount - shipDiscount;
    $('#grand_total strong').text(initialGrandTotal.toFixed(2) + ' ৳');

    // 🔹 Area change
    $('#area').on('change', function () {

        let areaId = $(this).val();

        if (areaId == 0) {
            shippingCharge = 0;
        } else {
            shippingCharge = parseFloat($(this).find(':selected').data('charge')) || 0;
        }

        let newGrandTotal = subtotal + shippingCharge - discount - shipDiscount;

        $('#cart_shipping_cost strong').text(shippingCharge.toFixed(2) + ' ৳');
        $('#grand_total strong').text(newGrandTotal.toFixed(2) + ' ৳');
    });

});
</script>


    <script>
        $(document).on('click', '.order_place', function (e) {
            e.preventDefault(); // form submit temporarily stop
            let areaVal = $('#area').val();

            if (areaVal == 0 || areaVal === null) {
                alert('অনুগ্রহ করে আপনার Delivery Area নির্বাচন করুন');
                $('#area').focus();
                return false;
            }
            // summary fetch
            let subtotal = parseFloat($('#net_total strong').text().replace(/,/g, '')) || 0;
            let shipping = parseFloat($('#cart_shipping_cost strong').text().replace(/,/g, '')) || 0;
            let discount = parseFloat($('#discount_amount strong').text().replace(/,/g, '')) || 0;
            let shipDiscount = parseFloat($('#ship_discount_amount strong').text().replace(/,/g, '')) || 0;
            let grandTotal = parseFloat($('#grand_total strong').text().replace(/,/g, '')) || 0;

            // Optional: confirmation popup
            if (!confirm(`Are you sure? \nGrand Total: ৳${grandTotal.toFixed(2)} \nDiscount: ৳${discount.toFixed(2)}`)) {
                return false;
            }

            // Form submit
            $(this).closest('form').submit();
        });

    </script>
<script>
$(document).ready(function() {

    function updateCartSummary(data) {
        // Totals
        $('#net_total strong').text(parseFloat(data.subtotal).toFixed(2) + " ৳");
        $('#cart_shipping_cost strong').text(parseFloat(data.shipping).toFixed(2) + " ৳");
        $('#discount_amount strong').text('-' + parseFloat(data.discount).toFixed(2) + " ৳");
        $('#ship_discount_amount strong').text(parseFloat(data.shipping_discount).toFixed(2) + " ৳");
        $('#grand_total strong').text(parseFloat(data.grandTotal).toFixed(2) + " ৳");

        // Coupon area
        if (data.code) {
            $('#couponArea').addClass('active').html(`
                <div class="btnforcouponapplied">
                    <span>You have Applied: ${data.code}</span>
                    <button type="button" id="removeCouponBtn">Remove Coupon</button>
                </div>
            `);
            $('#couponRow').show();
            
        } else {
            $('#couponArea').html(`
                <div class="btnforcoupon">
                    <input type="text" id="couponCodeInput" placeholder="Enter coupon code" style="text-transform: none;">
                    <button type="button" id="applyCouponBtn">Apply Coupon</button>
                </div>
            `);
            $('#couponRow').hide();
        }
    }

    // Apply coupon
    $(document).on('click', '#applyCouponBtn', function() {
        let code = $('#couponCodeInput').val().trim();
        if(!code) return alert('Enter coupon code');

        let subtotal = parseFloat($('#net_total strong').text().replace(/,/g,'').replace(/[^\d\.]/g,'')) || 0;
        let shipping = parseFloat($('#cart_shipping_cost strong').text().replace(/,/g,'').replace(/[^\d\.]/g,'')) || 0;

        $.ajax({
            url: "{{ route('coupon.apply') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                code: code,
                subtotal: subtotal,
                shipping: shipping,
                product_id: null // full cart
            },
            success: function(res) {
                if(res.error) return alert(res.error);
                if(res.success) {
                    updateCartSummary(res);
                    
                    
                }
            },
            error: function(xhr) {
                alert('Something went wrong. Please try again.');
            }
        });
    });

    // Remove coupon
    $(document).on('click', '#removeCouponBtn', function() {
        $.ajax({
            url: "{{ route('coupon.remove') }}",
            method: "POST",
            data: { _token: "{{ csrf_token() }}" },
            success: function(res) {
                if(res.success) {
                    updateCartSummary(res);
                 
                }
            },
            error: function() {
                alert('Something went wrong while removing coupon.');
            }
        });
    });

});
</script>








    <script>
        $(document).ready(function () {
            $(".select2").select2();
        });
    </script>


   
    <script type="text/javascript">
        dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
        dataLayer.push({
            event: "view_cart",
            ecommerce: {
                items: [@foreach (Cart::instance('shopping')->content() as $cartInfo){
                    item_name: "{{$cartInfo->name}}",
                    item_id: "{{$cartInfo->id}}",
                    price: "{{$cartInfo->price}}",
                    item_brand: "{{$cartInfo->options->brand}}",
                    item_category: "{{$cartInfo->options->category}}",
                    item_size: "{{$cartInfo->options->size}}",
                    item_color: "{{$cartInfo->options->color}}",
                    currency: "BDT",
                    quantity: {{$cartInfo->qty ?? 0}}
                }, @endforeach]
            }
        });
    </script>
    <script type="text/javascript">
        // Clear the previous ecommerce object.
        dataLayer.push({ ecommerce: null });

        // Push the begin_checkout event to dataLayer.
        dataLayer.push({
            event: "begin_checkout",
            ecommerce: {
                items: [@foreach (Cart::instance('shopping')->content() as $cartInfo)
                                {
                    item_name: "{{$cartInfo->name}}",
                    item_id: "{{$cartInfo->id}}",
                    price: "{{$cartInfo->price}}",
                    item_brand: "{{$cartInfo->options->brands}}",
                    item_category: "{{$cartInfo->options->category}}",
                    item_size: "{{$cartInfo->options->size}}",
                    item_color: "{{$cartInfo->options->color}}",
                    currency: "BDT",
                    quantity: {{$cartInfo->qty ?? 0}}
                                },
                @endforeach]
            }
        });
    </script>
    <script src="{{asset('public/frontEnd/js/jquery-3.6.3.min.js')}}"></script>
    <!-- cart js start -->
         {{-- <script>
        document.addEventListener('click', function (e) {
            // যদি click হওয়া element এ 'cart_remove' class থাকে
            if (e.target && e.target.classList.contains('cart_removee')) {
                // closest parent div with class 'productcartshowarea'
                let productArea = e.target.closest('.partCot');
                if (productArea) {
                    productArea.remove(); // শুধু ওই div remove হবে
                
                }
            }
        });
    </script> --}}
    <script>
        $('.cart_store').on('click', function () {
            var id = $(this).data('id');
            var qty = $(this).parent().find('input').val();
            if (id) {
                $.ajax({
                    type: "GET",
                    data: { 'id': id, 'qty': qty ? qty : 1 },
                    url: "{{route('cart.store')}}",
                    success: function (data) {
                        if (data) {
                            return cart_count();
                        }
                    }
                });
            }
        });



       
        // Event listener for size selector change
        $('.cart-size-selector').on('change', function () {
            var rowId = $(this).data('id'); // Get the row ID
            var selectedSize = $(this).val(); // Get the selected size

            if (rowId) {
                $.ajax({
                    type: "GET", // Change to GET if your route accepts GET requests
                    data: {
                        'id': rowId,
                        'product_size': selectedSize // New size to update
                    },
                    url: "{{ route('cart.update') }}", // Use the same route for updating size
                    success: function (data) {
                        if (data) {
                            $(".cartlist").html(data); // Update the cart list UI with new data
                            return cart_count(); // Update the cart count
                        }
                    },
                    error: function () {
                        alert('An error occurred while updating the size. Please try again.');
                    }
                });
            }
        });


        // Event listener for color selector change
        $('.cart-color-selector').on('change', function () {
            var rowId = $(this).data('id'); // Get the row ID
            var selectedColor = $(this).val(); // Get the selected color

            if (rowId) {
                $.ajax({
                    type: "GET", // Change to GET if your route accepts GET requests
                    data: {
                        'id': rowId,
                        'product_color': selectedColor // New size to update
                    },
                    url: "{{ route('cart.update') }}", // Use the same route for updating size
                    success: function (data) {
                        if (data) {
                            $(".cartlist").html(data); // Update the cart list UI with new data
                            return cart_count(); // Update the cart count
                        }
                    },
                    error: function () {
                        alert('An error occurred while updating the size. Please try again.');
                    }
                });
            }
        });


        function cart_count() {
            $.ajax({
                type: "GET",
                url: "{{route('cart.count')}}",
                success: function (data) {
                    if (data) {
                        $("#cart-qty").html(data);
                    } else {
                        $("#cart-qty").empty();
                    }
                }
            });
        };

    </script>
    
@endpush