@extends('backEnd.layouts.master')
@section('title', 'Order Create')
@section('css')
    <style>
        .increment_btn,
        .remove_btn {
            margin-top: -17px;
            margin-bottom: 10px;
        }
    </style>
    <link href="{{asset('public/backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/backEnd')}}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet"
        type="text/css" />
@endsection
@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <form method="get" action="{{ route('admin.order.cart_clear', $order->id ?? 0) }}"
                            class="d-inline delete-cart-form">
                            <button type="submit" class="btn btn-danger rounded-pill delete-confirm" title="Delete">
                                <i class="fas fa-trash-alt"></i> Cart Clear
                            </button>
                        </form>



                    </div>
                    <h4 class="page-title">Order Create</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.order.update')}}" method="POST" class="row pos_form"
                            data-parsley-validate="" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{$order->id}}" name="order_id">
                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="product_id" class="form-label">Products *</label>
                                    <select id="cart_add"
                                        class="form-control select2 @error('product_id') is-invalid @enderror"
                                        value="{{ old('product_id') }}">
                                        <option value="">Select..</option>
                                        @foreach($products as $value)
                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->
                            <div class="col-sm-12">
                                {{-- ================= Normal Products Table ================= --}}
                                {{-- ================= Normal Products Table ================= --}}
                               @php 
                                    $product_discount = 0; 
                                    $normalProducts = collect($cartinfo)->filter(function($item) {
                                        return $item->options->product_type == 'normal';
                                    });
                                @endphp

                                @if($normalProducts->isNotEmpty())
                                <h3 style="font-family: 'Poppins';">Regular Products</h3>
                                <table class="table table-bordered table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th style="width:10%">Image</th>
                                            <th style="width:25%">Name</th>
                                            <th style="width:15%">Quantity</th>
                                            <th style="width:12%">Sell Price</th>
                                            <th style="width:12%">Coupon</th>
                                            <th style="width:15%">Coupon Discount</th>
                                            <th style="width:15%">Extra Discount</th>
                                            <th style="width:15%">Sub Total</th>
                                            <th style="width:15%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach($cartinfo as $value)
                                            @if($value->options->product_type == 'normal')
                                                <tr>
                                                    <td>
                                                        <img style="width:50px;"
                                                            src="{{ asset($value->options->image ?? 'public/default.png') }}"
                                                            alt="Product Image">
                                                    </td>
                                                    <td>
                                                        {{ $value->name }}
                                                        @php $product = App\Models\Product::find($value->id); @endphp
                                                        @if($product && ($product->sizes->isNotEmpty() || $product->colors->isNotEmpty()))
                                                            <div class="row g-1">
                                                                @if($product->sizes->isNotEmpty())
                                                                    <div class="col-md-6">
                                                                        <select class="form-select form-select-sm cart-size-selector"
                                                                            data-id="{{ $value->rowId }}">
                                                                            @foreach($product->sizes as $size)
                                                                                <option value="{{ $size->sizeName }}" {{ $size->sizeName == $value->options->product_size ? 'selected' : '' }}>
                                                                                    {{ $size->sizeName }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <label class="form-label text-muted"
                                                                            style="font-size:0.875rem;">Size:
                                                                            {{ $value->options->product_size ?? '' }}</label>
                                                                    </div>
                                                                @endif
                                                                @if($product->colors->isNotEmpty())
                                                                    <div class="col-md-6">
                                                                        <select class="form-select form-select-sm cart-color-selector"
                                                                            data-id="{{ $value->rowId }}">
                                                                            @foreach($product->colors as $color)
                                                                                <option value="{{ $color->colorName }}" {{ $color->colorName == $value->options->product_color ? 'selected' : '' }}>
                                                                                    {{ $color->colorName }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <label class="form-label text-muted"
                                                                            style="font-size:0.875rem;">Color:
                                                                            {{ $value->options->product_color ?? '' }}</label>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="qty-cart vcart-qty">
                                                            <div class="quantity">
                                                                <button class="minus cart_decrement" value="{{$value->qty}}"
                                                                    data-id="{{$value->rowId}}">-</button>
                                                                <input type="text" value="{{$value->qty}}" readonly />
                                                                <button class="plus cart_increment" value="{{$value->qty}}"
                                                                    data-id="{{$value->rowId}}">+</button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $value->price }}</td>
                                                    <td>
                                                        @if($order->coupon)
                                                            @if($value->options->product_type == 'normal')
                                                                <p>Coupon Applied Code: 
                                                                    <span style="background-color: red; color: #fff; padding:2px 6px; border-radius:5px;">
                                                                    {{ $orderdetails->where('product_type', 'normal')->first()->coupon_name ?? 'None' }}
                                                                    </span>
                                                                </p>
                                                                <p>Coupon Type: {{ $order->coupon->type }}</p>
                                                                <p>Coupon Discount Amount: {{ $orderdetails->where('product_type', 'normal')->sum('coupon_discount_amount') ?? 0 }} ৳</p>
                                                            @else
                                                                -
                                                            @endif
                                                        @else
                                                            <p>Coupon Applied: None</p>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if($order->coupon)
                                                            @if($value->options->product_type == 'normal')
                                                                {{ $orderdetails->where('product_type', 'normal')->sum('coupon_discount_amount') ?? 0 }} ৳ Discount
                                                            @else
                                                                -
                                                            @endif
                                                        @else
                                                            None
                                                        @endif
                                                    </td>


                                                    <td><input type="number" class="product_discount"
                                                            value="{{$value->options->product_discount ?? 0}}"
                                                            data-id="{{$value->rowId}}"></td>
                                                    <td>{{ ($value->price - ($value->options->product_discount ?? 0)) * $value->qty }}
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs cart_remove"
                                                            data-id="{{$value->rowId}}">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @php $product_discount += ($value->options->product_discount ?? 0) * $value->qty; @endphp
                                            @endif
                                        @endforeach
                                        @php Session::put('product_discount', $product_discount); @endphp
                                    </tbody>
                                </table>
                                @endif
                                @php 
                                    $product_discount = 0; 
                                    $comboProducts = collect($cartinfo)->filter(function($item) {
                                        return $item->options->product_type == 'combo';
                                    });
                                @endphp

                                @if($comboProducts->isNotEmpty())
                                {{-- ================= Combo Products Table ================= --}}
                                <h3 style="font-family: 'Poppins';">Combo Products</h3>
                                <table class="table table-bordered table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th style="width:10%">Image</th>
                                            <th style="width:25%">Combo + Products</th>
                                            <th style="width:15%">Quantity</th>
                                            <th style="width:12%">Sell Price</th>
                                            <th style="width:12%">Coupon</th>
                                            <th style="width:15%">Coupon Discount</th>
                                            <th style="width:15%">Extra Discount</th>
                                            <th style="width:15%">Sub Total</th>
                                            <th style="width:15%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $combo_discount = 0; @endphp
                                        @foreach($cartinfo as $value)
                                            @if(in_array($value->options->product_type, ['combo', 'combo_item']))
                                                <tr>
                                                    <td>
                                                        <img style="width:50px;"
                                                            src="{{ asset($value->options->image ?? 'public/default.png') }}"
                                                            alt="Combo Image">
                                                    </td>
                                                    <td>
                                                        {{ $value->name }}
                                                        @php $product = App\Models\Product::find($value->id); @endphp
                                                        @if($product && ($product->sizes->isNotEmpty() || $product->colors->isNotEmpty()))
                                                            <div class="row g-1">
                                                                @if($product->sizes->isNotEmpty())
                                                                    <div class="col-md-6">
                                                                        <select class="form-select form-select-sm cart-size-selector"
                                                                            data-id="{{ $value->rowId }}">
                                                                            @foreach($product->sizes as $size)
                                                                                <option value="{{ $size->sizeName }}" {{ $size->sizeName == $value->options->product_size ? 'selected' : '' }}>
                                                                                    {{ $size->sizeName }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <label class="form-label text-muted"
                                                                            style="font-size:0.875rem;">Size:
                                                                            {{ $value->options->product_size ?? '' }}</label>
                                                                    </div>
                                                                @endif
                                                                @if($product->colors->isNotEmpty())
                                                                    <div class="col-md-6">
                                                                        <select class="form-select form-select-sm cart-color-selector"
                                                                            data-id="{{ $value->rowId }}">
                                                                            @foreach($product->colors as $color)
                                                                                <option value="{{ $color->colorName }}" {{ $color->colorName == $value->options->product_color ? 'selected' : '' }}>
                                                                                    {{ $color->colorName }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <label class="form-label text-muted"
                                                                            style="font-size:0.875rem;">Color:
                                                                            {{ $value->options->product_color ?? '' }}</label>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="qty-cart vcart-qty">
                                                            <div class="quantity">
                                                                <button class="minus cart_decrement" value="{{$value->qty}}"
                                                                    data-id="{{$value->rowId}}">-</button>
                                                                <input type="text" value="{{$value->qty}}" readonly />
                                                                <button class="plus cart_increment" value="{{$value->qty}}"
                                                                    data-id="{{$value->rowId}}">+</button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $value->price }}</td>
                                                    <td>
                                                        @if($order->coupon)
                                                            @if($value->options->product_type == 'combo')
                                                                <p>Coupon Applied Code: 
                                                                    <span style="background-color: red; color: #fff; padding:2px 6px; border-radius:5px;">
                                                                    {{ $orderdetails->where('product_type', 'combo')->first()->coupon_name ?? 'None' }}
                                                                    </span>
                                                                </p>
                                                                <p>Coupon Type: {{ $order->coupon->type }}</p>
                                                                <p>Coupon Discount Amount: {{ $orderdetails->where('product_type', 'combo')->sum('coupon_discount_amount') ?? 0 }} ৳</p>
                                                            @else
                                                                -
                                                            @endif
                                                        @else
                                                            <p>Coupon Applied: None</p>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if($order->coupon)
                                                            @if($value->options->product_type == 'combo')
                                                                {{ $orderdetails->where('product_type', 'combo')->sum('coupon_discount_amount') ?? 0 }} ৳ Discount
                                                            @else
                                                                -
                                                            @endif
                                                        @else
                                                            None
                                                        @endif
                                                    </td>

                                                    <td><input type="number" class="product_discount"
                                                            value="{{$value->options->product_discount ?? 0}}"
                                                            data-id="{{$value->rowId}}"></td>
                                                    <td>{{ ($value->price - ($value->options->product_discount ?? 0)) * $value->qty }}
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs cart_remove"
                                                            data-id="{{$value->rowId}}">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @php $combo_discount += ($value->options->product_discount ?? 0) * $value->qty; @endphp
                                            @endif
                                        @endforeach
                                        @php Session::put('product_discount', $product_discount + $combo_discount); @endphp
                                    </tbody>
                                </table>
                                @endif


                            </div>
                            <!-- custome address -->
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group mb-2">
                                            <input type="text" id="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Customer Name" name="name" value="{{$shippinginfo->name}}"
                                                required>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- col-end -->
                                    <div class="col-sm-12">
                                        <div class="form-group mb-2">
                                            <input type="number" id="phone"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                placeholder="Customer Number" name="phone" value="{{$shippinginfo->phone}}"
                                                required>
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
                                            <input type="address" placeholder="Address" id="address"
                                                class="form-control @error('address') is-invalid @enderror" name="address"
                                                value="{{$shippinginfo->address}}" required>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                       <div class="form-group mb-3">
                                            <textarea placeholder="note" id="note"
                                                class="form-control @error('note') is-invalid @enderror"
                                                name="note"
                                                required
                                                rows="4">{{$shippinginfo->note}}</textarea>
                                            @error('note')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <select type="area" id="area"
                                                class="form-control @error('area') is-invalid @enderror" name="area"
                                                required>
                                                <option value="">Delivery Area</option>
                                                @foreach($shippingcharge as $key => $value)
                                                    <option value="{{$value->id}}" @if($shippinginfo->area == $value->name)
                                                    selected @endif>{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- col-end -->
                                </div>
                            </div>
                            <!-- cart total -->
                            <div class="col-sm-6">
                                <table class="table table-bordered">
                                    <tbody id="cart_details">
                                                                               @php
    // Cart subtotal
    $subtotal = Cart::instance('pos_shopping')->subtotal();
    $subtotal = str_replace(',', '', $subtotal);
    $subtotal = str_replace('.00', '', $subtotal);
    $subtotal = floatval($subtotal);

    // Shipping fee
    $shipping = Session::get('pos_shipping', 0);
    $shipping = floatval($shipping);

    // Main discount from order_details (sum of product-specific discounts)
    $mainDiscount = $orderdetails->sum('discount_amount') ?? 0;
    $mainDiscount = floatval($mainDiscount);

    // Coupon discount calculation from order_details (saved coupon info)
    $couponDiscount = $orderdetails->first()->coupon_discount_amount ?? 0;
    $couponDiscount = floatval($couponDiscount);

    // Determine what to show in main discount (for UI display logic)
    if ($couponDiscount > 0 && $mainDiscount == 0) {
        $displayMainDiscount = 0;
    } elseif ($couponDiscount == 0 && $mainDiscount > 0) {
        $displayMainDiscount = $mainDiscount;
    } elseif ($couponDiscount > 0 && $mainDiscount > 0) {
        $displayMainDiscount = $mainDiscount; // show main discount along with coupon
    } else {
        $displayMainDiscount = 0;
    }

    // Total discount calculation
    $total_discount = $mainDiscount + $couponDiscount;

    // Total amount to pay
    $total = ($subtotal + $shipping) - $total_discount;
@endphp
                                        <tr>
                                            <td>Sub Total</td>
                                            <td>{{ $subtotal }}</td>
                                        </tr>
                                        <tr>
                                            <td>Shipping Fee</td>
                                            <td>{{ $shipping }}</td>
                                        </tr>

                                        {{-- Coupon Discount Row (show only if coupon applied) --}}
                                        @if($couponDiscount > 0)
                                            <tr>
                                                <td>Coupon Discount</td>
                                                <td>{{ $couponDiscount }}</td>
                                            </tr>
                                        @endif

                                        {{-- Always show Discount row (session or coupon applied) --}}
                                        <tr>
                                            <td>Discount</td>
                                            <td>{{ $displayMainDiscount }}</td>
                                        </tr>

                                        <tr>
                                            <td>Total</td>
                                            <td>{{ $total }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <input type="submit" class="btn btn-success" value="Update Order" />
                            </div>
                        </form>
                    </div>
                    <!-- end card-body-->
                </div>
                <!-- end card-->
            </div>
            <!-- end col-->
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('public/backEnd/')}}/assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="{{asset('public/backEnd/')}}/assets/js/pages/form-validation.init.js"></script>
    <script src="{{asset('public/backEnd/')}}/assets/libs/select2/js/select2.min.js"></script>
    <script src="{{asset('public/backEnd/')}}/assets/js/pages/form-advanced.init.js"></script>
    <!-- Plugins js -->
    <script src="{{asset('public/backEnd/')}}/assets/libs//summernote/summernote-lite.min.js"></script>
    <script>
        $(".summernote").summernote({
            placeholder: "Enter Your Text Here",
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>

    <script>
        // jQuery
        $(document).ready(function () {
            $(".delete-cart-form").on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    type: "GET",
                    url: $(this).attr('action'),
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            cart_content(); // refresh cart table
                            cart_details(); // refresh cart details
                            alert(response.message);
                        }
                    },
                    error: function (err) {
                        console.log(err);
                        alert('Cart clear failed!');
                    }
                });
            });

            $(".cart_remove").click(function (e) {
                e.preventDefault();
                var id = $(this).data("id");

                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.order.cart_remove') }}",
                    data: { id: id },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            cart_content();    // cart table refresh
                            cart_details();    // cart summary refresh
                        }
                    },
                    error: function (err) {
                        console.log(err);
                        alert('Failed to remove product!');
                    }
                });
            });


        });



    </script>
    <script>
        // Product discount input change
        $(document).on("change", ".product_discount", function () {
            var rowId = $(this).data("id");
            var discount = parseFloat($(this).val()) || 0;

            $.ajax({
                url: "{{ route('admin.order.product_discount') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: rowId,
                    discount: discount
                },
                dataType: "json",
                success: function (res) {
                    // Update cart display without page reload
                    cart_content();
                    cart_details();
                },
                error: function (err) {
                    console.log(err);
                    alert('Failed to update discount!');
                }
            });
        });

    </script>
@endsection