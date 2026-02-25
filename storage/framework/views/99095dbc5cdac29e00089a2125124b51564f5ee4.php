
<?php
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
    
?>

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

    <div class="checkoutareacart" >
                                

                                                <?php $__currentLoopData = Cart::instance('shopping')->content(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                   <div class="partCot">
                                                     <div class="productcartshowareaforcheckout">
                                  
                                                       <div class="cartimgforcheckout">
    <a href="<?php echo e($value->options->get('is_combo') && $value->options->get('is_combo')
                ? route('combo.show', $value->options->slug) 
                : route('product', $value->options->slug)); ?>">
        
        <?php if(isset($value->options->is_combo) && $value->options->is_combo): ?>
            
            <img style="width: 130px; height:auto;" src="<?php echo e(asset($value->options->combo_image ?? 'public/uploads/default/user.png')); ?>" alt="Combo Image">
        <?php else: ?>
            
            <img style="width: 130px; height:auto;" src="<?php echo e(asset($value->options->image ?? 'public/default.png')); ?>" alt="Product Image">
        <?php endif; ?>
    </a>
</div>

                                                        <div class="cartpriceforcheckout">
                                                            <div class="tyepset">
                                                                <div class="name1sttype">
                                                                  <a href="<?php echo e($value->options->get('is_combo') && $value->options->get('is_combo')
                ? route('combo.show', $value->options->slug) 
                : route('product', $value->options->slug)); ?>">
                                                            <h4 style="font-size: 16px">  <?php echo e(Str::limit($value->name, 200)); ?>   <?php if($value->options->get('is_combo')): ?>
                                <span class="badge bg-warning" style="margin-left:5px;">Combo</span>
                            <?php endif; ?>
                        </h4>
                                                            </a>
                                                            </div>
                                                            <div class="name2ndtype">

                                                              <?php
                        $product = App\Models\Product::find($value->id);
                    ?>

                    <?php if($product && ($product->sizes->isNotEmpty() || $product->colors->isNotEmpty())): ?>
                        <div class="row g-1 mt-2">
                            <!-- Size Selector -->
                            <?php if($product->sizes->isNotEmpty()): ?>
                                <div class="col-6">

                                    <select style="font-size: 13px" id="size-selector-<?php echo e($value->rowId); ?>"
                                        class="form-select form-select-sm cart-size-selector" data-id="<?php echo e($value->rowId); ?>">
                                        <option>Select an option</option>
                                        <?php $__currentLoopData = $product->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($size->sizeName); ?>" <?php echo e($size->sizeName == $value->options->product_size ? 'selected' : ''); ?>>
                                                <?php echo e($size->sizeName); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <label for="size-selector-<?php echo e($value->rowId); ?>" class="form-label text-muted text-start"
                                        style="font-size: 12px;">Size:
                                        <?php if($value->options->product_size): ?>
                                            <?php echo e($value->options->product_size); ?>

                                        <?php endif; ?>
                                    </label>
                                </div>
                            <?php endif; ?>

                            <!-- Color Selector -->
                            <?php if($product->colors->isNotEmpty()): ?>
                                <div class="col-6">
                                    <select style="font-size: 13px" id="color-selector-<?php echo e($value->rowId); ?>"
                                        class="form-select form-select-sm cart-color-selector" data-id="<?php echo e($value->rowId); ?>">
                                        <option>Select an option</option>
                                        <?php $__currentLoopData = $product->colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($color->colorName); ?>" <?php echo e($color->colorName == $value->options->product_color ? 'selected' : ''); ?>>
                                                <?php echo e($color->colorName); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <label for="color-selector-<?php echo e($value->rowId); ?>" class="form-label text-muted text-start"
                                        style="font-size: 12px;">Color:
                                        <?php if($value->options->product_color): ?>
                                            <?php echo e($value->options->product_color); ?>

                                        <?php endif; ?>
                                    </label>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                                                     
                                                            </div>
                                                             <div class="name3rdtype">
                                                      <div class="cartandremovebtnset">
                                                            <div class="customquantity"
                            style="border:1px solid #ff9900; border-radius: 0; background: none;">
                            <button type="button"
                                style="border-right:1px solid #ff9900; border-radius: 0; background: none;"
                                class=" ctrl cart_decrementt"
                                data-id="<?php echo e($value->rowId); ?>" aria-label="decrease">−</button>
                            <div class="value-box">
                                <input type="text" class="qty-input" value="<?php echo e($value->qty); ?>" readonly
                                    aria-label="quantity" />
                            </div>
                            <button style="border-left:1px solid #ff9900; border-radius: 0; background: none;"
                                type="button" class="ctrl cart_incrementt" data-id="<?php echo e($value->rowId); ?>"
                                aria-label="increase">+</button>
                        </div>
                                   <div class="btnforremovecheckout">
                                      <a class="cart_remove" data-id="<?php echo e($value->rowId); ?>"><i class="fa-solid fa-trash-xmark"></i></a>
                                   </div>
                                                      </div>
                                    
                                                      </div>
                                                            </div>
                                                      <div class="nametypeprice" style="text-align: end">
  <strong><?php echo e($value->price); ?> ৳</strong>
                                                        </div>
                                                        </div>
                                                        
                                                    
                                                        

                                                    </div>
                                                      <div class="comboProductcartSection">
         <?php if($value->options->get('is_combo')): ?>
 
       
    <div id="combo-items-<?php echo e($loop->index); ?>" class="combo-inner-products" style=" margin-top:5px;">
        <?php $__currentLoopData = $value->options->get('combo_items') ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="productcartshowarea productcartpart2forcombo" style="display: grid; grid-template-columns:10% 20% 40% 30%; gap: 0px; margin-bottom:5px; padding-bottom:5px;">
                <div class="sideblankspace"></div>
                
                <div class="part-imgpcart">
                 
                    <a class="cart-photo" href="#">
                        
                        <img src="<?php echo e(asset($p['image'])); ?>" alt="<?php echo e($p['name']); ?>" style="width:100%; object-fit:cover;" />
                    </a>
            
                </div>

                
                <div class="part-namepcart">
                    <div class="highsection">
                        <div class="cartmiddlepart">
                            <div class="productnamecartsection">
                                <a class="ppricecart" href="#"><?php echo e(Str::limit($p['name'], 40)); ?></a>
                                <?php if($p['is_combo'] ?? false): ?>
                                    <span class="badge bg-warning" style="margin-left:5px;">Combo</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        
                        <div class="size-part">
                            <p>Size - <?php echo e($p['size'] ?? 'N/A'); ?></p>
                            <p>Color - <?php echo e($p['color'] ?? 'N/A'); ?></p>
                            <p>Quantity - <?php echo e($value->qty); ?></p>
                        </div>
                        
                    </div>
                </div>
                  <div class="secpricecart" style="text-align: right;">
                    <span class="cartprice" data-price="<?php echo e($value->price); ?>">
                        <?php echo e($value->price); ?> ৳
                    </span>
                    </span>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>

   </div>
                                                   </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                        </div>
   <tfoot>
                                            <tr style="border: none">
                                                <th colspan="3" class="text-start px-2" style="border: none; font-weight: 500; font-size:14px;">Subtotal</th>
                                                <td class="text-end px-2" style="border: none; font-weight: 500; font-size:14px;">
                                                    <span id="net_total"><span
                                                            class="alinur"></span><strong><?php echo e(number_format($subtotal, 2)); ?>

                                                            ৳</strong></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" class="text-start px-2" style="border: none; font-weight: 500; font-size:14px;">Delivery Charge</th>
                                                <td class="text-end px-2" style="border: none; font-weight: 500; font-size:14px;">
                                                    <span id="cart_shipping_cost"><span
                                                            class="alinur"></span><strong><?php echo e(number_format($shipping, 2)); ?>

                                                            ৳</strong></span>
                                                </td>
                                            </tr>
                                            <tr id="couponRow" style="<?php echo e($applied ? '' : 'display:none;'); ?>">
                                                <th colspan="3" class="text-start px-2" style="border: none; font-weight: 500; font-size:14px;">Coupon Discount</th>
                                                <td class="text-end px-2" style="border: none; font-weight: 500; font-size:14px;">
                                                    <span id="discount_amount"><span
                                                            class="alinur"></span><strong>-<?php echo e(number_format($discount, 2)); ?>

                                                            ৳</strong></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" class="text-start px-2" style="border: none; font-weight: 500;font-size:14px;">Shipping Discount</th>
                                                <td class="text-end px-2" style="border: none; font-weight: 500;font-size:14px;">
                                                    <span id="ship_discount_amount"><span
                                                            class="alinur"></span><strong><?php echo e(number_format($shipOff, 2)); ?>

                                                            ৳</strong></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" class="text-start px-2" style="border: none; font-size:20px;">Total</th>
                                                <td class="text-end px-2" style="border: none;">
                                                    <span id="grand_total" style="font-size:20px"><span
                                                            class="alinur"></span><strong><?php echo e(number_format($grandTotal, 2)); ?>

                                                            ৳</strong></span>
                                                </td>
                                            </tr>
                                        </tfoot>
</table>
<div class="card-footer text-danger" style="margin-top:10px;border-left: 4px solid red; padding-left:10px">
                                    <?php echo $generalsetting->checkout_note; ?>

                                </div>
                                </div>
                                
<script src="<?php echo e(asset('public/frontEnd/js/jquery-3.6.3.min.js')); ?>"></script>

<script>
     const freeShippingTarget = <?php echo e($generalsetting->free_shipping ?? 0); ?>;


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


$(document).ready(function() {

    let subtotal = parseFloat(`<?php echo e($subtotal); ?>`) || 0;
    let discount = parseFloat(`<?php echo e($discount); ?>`) || 0;
    let shipDiscount = parseFloat(`<?php echo e($shipOff); ?>`) || 0;

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
<!-- cart js start -->
<script>
 

    function cart_count() {
            $.ajax({
                type: "GET",
                url: "<?php echo e(route('cart.count')); ?>",
                success: function (data) {
                    if (data) {
                        $("#cart-qty").html(data);
                    } else {
                        $("#cart-qty").empty();
                    }
                },
            });
        }
    $(document).on("click", ".cart_removee", function() {
                var id = $(this).data("id");
                if (!id) return;

                $.ajax({
                    type: "GET",
                    url: "<?php echo e(route('cart.remove')); ?>",
                    data: { id: id },
                    success: function(data) {
                        if (data) {
                            $(".cartlist").html(data);
                            reloadCartMenu();   // Update main cart HTML
                            cart_count();             // Update cart count
                            mobile_cart();            // Update mobile cart
                            cart_summary();           // Update cart summary
                                // Reload cart menu including combo products

                            // Update free shipping progress
                            let subtotal = parseFloat($("#net_total").text().replace(/[^\d.-]/g,'')) || 0;
                            updateFreeShippingProgress(subtotal);
                        }
                    },
                    error: function(err){
                        console.log("Remove error:", err);
                    }
                });
            });

        $(".cart_incrementt").on("click", function() {
        var id = $(this).data("id");
        if (!id) return;

        $.ajax({
            type: "GET",
            url: "<?php echo e(route('cart.increment')); ?>",
            data: { id: id },
            success: function(data) {
                if (data) {
                    $(".cartlist").html(data); // Update cart HTML
                    cart_count();
                    mobile_cart();
                    reloadCartMenu();
                    // Update free shipping progress
                    let subtotal = parseFloat($("#net_total").text().replace(/[^\d.-]/g,'')) || 0;
                    updateFreeShippingProgress(subtotal);
                }
            },
            error: function(err){
                console.log("Increment error:", err);
            }
        });
        });

        $(".cart_decrementt").on("click", function() {
        var id = $(this).data("id");
        if (!id) return;

        $.ajax({
            type: "GET",
            url: "<?php echo e(route('cart.decrement')); ?>",
            data: { id: id },
            success: function(data) {
                if (data) {
                    $(".cartlist").html(data); // Update cart HTML
                    cart_count();
                    mobile_cart();
                    reloadCartMenu();
                    // Update free shipping progress
                    let subtotal = parseFloat($("#net_total").text().replace(/[^\d.-]/g,'')) || 0;
                    updateFreeShippingProgress(subtotal);
                }
            },
            error: function(err){
                console.log("Decrement error:", err);
            }
        });
        });

</script>

<!-- cart js end -->
<?php /**PATH C:\xampp\htdocs\nmfashion\resources\views/frontEnd/layouts/ajax/cart.blade.php ENDPATH**/ ?>