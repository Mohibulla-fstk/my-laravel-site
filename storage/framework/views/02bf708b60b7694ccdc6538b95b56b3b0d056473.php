 <?php
            $subtotal = Cart::instance('shopping')->subtotal();
            $subtotal = str_replace(',', '', $subtotal);
            $subtotal = str_replace('.00', '', $subtotal);
            $shipping = Session::get('shipping') ? Session::get('shipping') : 0;
        ?>
        <div class="headtext">
            <span>Shopping Cart</span>

            <div class="crossmark"> <i class="fa-solid fa-xmark"></i></div>
        </div>
        <div class="maincontent">


            <ul>
                <?php $__empty_1 = true; $__currentLoopData = Cart::instance('shopping')->content(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="partCot">
                        <div class="productcartshowarea"
                            style="display: grid; grid-template-columns: 20% 60% 20%;gap: 0px;">

                            
                            <div class="part-imgpcart">
                                <a class="cart-photo" href="<?php echo e(route('product', $value->options->get('slug'))); ?>">
                                    <img src="<?php echo e(asset($value->options->get('image'))); ?>" alt="" />
                                </a>
                            </div>

                            
                            <div class="part-namepcart">
                                <div class="highsection">
                                    <div class="cartmiddlepart">
                                        <div class="productnamecartsection">
                                            <span class="ppricecart"><?php echo e(Str::limit($value->name, 40)); ?></span>
                                            <?php if($value->options->get('is_combo')): ?>
                                                <span class="badge bg-warning" style="margin-left:5px;">Combo</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    
                                    <?php if(!$value->options->get('is_combo')): ?>
                                        
                                        <div class="size-part">
                                            <p>Size - <?php echo e($value->options->product_size ?? 'N/A'); ?></p>
                                            <p>Color - <?php echo e($value->options->product_color ?? 'N/A'); ?></p>
                                        </div>
                                    <?php endif; ?>

                                    
                                    <div class="faulsection d-flex align-items-center">
                                        <div class="customquantity"
                                            style="border:1px solid #ff9900; border-radius: 0; background: none;">
                                            <button type="button"
                                                style="border-right:1px solid #ff9900; border-radius: 0; background: none;"
                                                class=" ctrl minus cart_decrementt" data-id="<?php echo e($value->rowId); ?>"
                                                aria-label="decrease">−</button>
                                            <div class="value-box">
                                                <input type="text" class="qty-input" value="<?php echo e($value->qty); ?>"
                                                    readonly aria-label="quantity" />
                                            </div>
                                            <button
                                                style="border-left:1px solid #ff9900; border-radius: 0; background: none;"
                                                type="button" class="ctrl plus cart_incrementt"
                                                data-id="<?php echo e($value->rowId); ?>" aria-label="increase">+</button>
                                        </div>

                                        <div class="removebtnsec">
                                            <button style="margin-left: 5px;" class="remove-cart cart_removee"
                                                data-id="<?php echo e($value->rowId); ?>">
                                                <i class="fa-solid fa-trash-xmark"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            
                            <li>
                                <div class="secpricecart" style="text-align: right;">
                                    <span class="cartprice" data-price="<?php echo e($value->price); ?>">
                                        <?php echo e($value->price * $value->qty); ?> ৳
                                    </span>
                                    <span class="cartqnty">(<?php echo e($value->price); ?>৳ X <span
                                            class="qty-text"><?php echo e($value->qty); ?></span>)
                                    </span>
                                </div>
                            </li>

                        </div>
                        <div class="comboProductcartSection">
                            <?php if($value->options->get('is_combo')): ?>
                                <div id="combo-items-<?php echo e($key); ?>" class="combo-inner-products"
                                    style=" margin-top:5px;">
                                    <?php $__currentLoopData = $value->options->get('combo_items') ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="productcartshowarea productcartpart2forcombo"
                                            style="display: grid; grid-template-columns:10% 20% 40% 30%; gap: 0px; margin-bottom:5px; padding-bottom:5px;">
                                            <div class="sideblankspace"></div>
                                            
                                            <div class="part-imgpcart">
                                                <a class="cart-photo" href="#">
                                                    <img src="<?php echo e(asset($p['image'])); ?>" alt="<?php echo e($p['name']); ?>"
                                                        style="width:100%; object-fit:cover;" />
                                                </a>
                                            </div>

                                            
                                            <div class="part-namepcart">
                                                <div class="highsection">
                                                    <div class="cartmiddlepart">
                                                        <div class="productnamecartsection">
                                                            <a class="ppricecart"
                                                                href="#"><?php echo e(Str::limit($p['name'], 40)); ?></a>
                                                            <?php if($p['is_combo'] ?? false): ?>
                                                                <span class="badge bg-warning"
                                                                    style="margin-left:5px;">Combo</span>
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
                                                <span class="cartprice">
                                                    0 ৳
                                                </span>
                                                </span>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>

                        </div>

                        <?php if($value->options->get('is_combo')): ?>
                            <button type="button" class="btn btn-sm btn-outline-secondary toggle-combo-items"
                                data-target="#combo-items-<?php echo e($key); ?>"
                                style="margin-bottom:5px;  transform: translate(-50%, -15px);">
                                Hide Items
                            </button>
                        <?php endif; ?>
                    </div>  
                 </ul>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="no-cartproduct">
                        <span class="span-class1"><svg width="50" height="50" aria-hidden="true" role="img" focusable="false"> <use href="#shopping-bag" xlink:href="#shopping-bag"></use> </svg></span>
                        <span class="span-class2">Your cart is empty</span>
                        <span class="span-class3">You may check out all the available products and buy some in the
                            shop</span>
                        <br>
                        <a href="<?php echo e(route('shop')); ?>"><span class="span-class4">Shop Now <i
                                    class="fa-solid fa-arrow-right"></i></span></a>
                    </div>
                <?php endif; ?>
        </div>
        
        <div class="btnfixedset">
            <div class="bottomsetforcart" >
                <p class="checkoutpstyle">
                    <a href="<?php echo e(route('customer.checkout')); ?>">
                       <svg width="24" height="24" aria-hidden="true" role="img" focusable="false"> <use href="#shopping-bag" xlink:href="#shopping-bag"></use> </svg>
                        <span>Total (<?php echo e(Cart::instance('shopping')->count()); ?>) Items</span>
                    </a>
                </p>
                <p class="checkoutpstyle"><strong>Total Price : ৳<?php echo e($subtotal); ?></strong></p>
                <a href="<?php echo e(route('customer.checkout')); ?>" class="go_cart"> Checkout
                </a>
            </div>
        </div>
 <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('.toggle-combo-items').forEach(function(button) {
                        button.addEventListener('click', function() {
                            let targetSelector = button.getAttribute('data-target');
                            let target = document.querySelector(targetSelector);

                            if (target) {
                                target.classList.toggle('combo-hidden'); // class toggle

                                // Button text update
                                if (target.classList.contains('combo-hidden')) {
                                    button.textContent = "Show Items";
                                } else {
                                    button.textContent = "Hide Items";
                                }
                            }
                        });
                    });
                });
            </script>
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('.toggle-combo').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const target = document.getElementById(btn.dataset.target);
                            target.classList.toggle('hidden');
                        });
                    });
                });
            </script>
        <script>
               // Remove item from cart
                $(document).on("click", ".cart_removee", function() {
                    var id = $(this).data("id");
                    if (!id) return;

                    $.ajax({
                        type: "GET",
                        url: "<?php echo e(route('cart.remove')); ?>",
                        data: { id: id },
                        success: function(data) {
                            if (data) {
                                $(".cartlist").html(data); // Update main cart HTML
                                cart_count();             // Update cart count
                                mobile_cart();            // Update mobile cart
                                cart_summary();           // Update cart summary
                                reloadCartMenu();         // Reload cart menu including combo products

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
                        $(".cartlist").html(data);
                         // Update cart HTML
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
        </script><?php /**PATH C:\xampp\htdocs\nmfashion\resources\views/frontEnd/layouts/ajax/cartmenu.blade.php ENDPATH**/ ?>