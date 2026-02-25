
<?php $__env->startSection('title', $combo->name); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/js/zoom.js'); ?>
<?php $__env->startSection('head'); ?>
    <!-- Product JSON-LD for Google Rich Results -->
    <script type="application/ld+json">
                                        {
                                          "@context": "https://schema.org/",
                                          "@type": "Product",
                                          "name": "<?php echo e($combo->name); ?>",
                                          "image": [
                                            <?php $__currentLoopData = $combo->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                  "<?php echo e(asset($img->image)); ?>"<?php if(!$loop->last): ?>,<?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          ],
                                          "description": "<?php echo e($combo->short_description ?? $combo->description ?? 'NM Fashion product'); ?>",
                                          "sku": "<?php echo e($combo->sku ?? $combo->id); ?>",
                                          "brand": {
                                            "@type": "Brand",
                                            "name": "<?php echo e($combo->brand ? $combo->brand->name : 'NM Fashion'); ?>"
                                          },
                                          "offers": {
                                            "@type": "Offer",
                                            "url": "<?php echo e(url()->current()); ?>",
                                            "priceCurrency": "BDT",
                                            "price": "<?php echo e($combo->new_price); ?>",
                                            "availability": "<?php echo e($combo->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock'); ?>",
                                            "itemCondition": "https://schema.org/NewCondition"
                                          }
                                        }
                                        </script>


<?php $__env->stopSection(); ?>
<?php $__env->startPush('seo'); ?>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="app-url" content="<?php echo e(route('product', $combo->slug)); ?>" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="<?php echo e($combo->meta_description); ?>" />
    <meta name="keywords" content="<?php echo e($combo->slug); ?>" />

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product" />
    <meta name="twitter:site" content="<?php echo e($combo->name); ?>" />
    <meta name="twitter:title" content="<?php echo e($combo->name); ?>" />
    <meta name="twitter:description" content="<?php echo e($combo->meta_description); ?>" />
    <meta name="twitter:creator" content="gomobd.com" />
    <meta property="og:url" content="<?php echo e(route('combo.show', $combo->slug)); ?>" />

    <!-- Open Graph data -->
    <meta property="og:title" content="<?php echo e($combo->name); ?>" />
    <meta property="og:type" content="combo" />
    <meta property="og:url" content="<?php echo e(route('combo.show', $combo->slug)); ?>" />
    <meta property="og:description" content="<?php echo e($combo->meta_description); ?>" />
    <meta property="og:site_name" content="<?php echo e($combo->name); ?>" />

<?php $__env->stopPush(); ?>




<?php $__env->startSection('content'); ?>
<div class="blankspace"></div>
<div class="gradient-bg">
    <span>Product Combo</span>
</div>
    <div class="max-width">
        <div class="comboalert" style="padding: 10px 15px;text-align:center; width: 100%;">

            <span style="font-weight:500; text-align: center; font-size: 20px">
                Buy any <?php echo e($maxProducts); ?> pieces at <?php echo e($combo->new_price); ?> taka
            </span>
        </div>

        <div class="homeproduct main-details-page">
            <div class="col-sm-12">

                <section class="product-section">
                    <div class="container">



                        <div class="row ">

                            <div class="col-sm-6 position-relative maxbtnset">
                                <?php if($combo->old_price): ?>
                                <div class="maximized">
                                            <i class="fa-sharp fa-light fa-arrows-maximize"></i>
                                        </div>
                                    <div class="product-details-discount-badge">
                                        <div class="sale-badge">
                                            <div class="sale-badge-inner">
                                                <div class="sale-badge-box">
                                                    <span class="sale-badge-text">
                                                        <p>-
                                                            <?php $discount = (((($combo->old_price) - ($combo->new_price)) * 100) / ($combo->old_price)) ?>
                                                            <?php echo e(number_format($discount, 0)); ?>%
                                                        </p>

                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                
                                <div class="scrollinner">
                                    <div class="scrollcontent">
                                        <div class="details_slider_wrapper">
                                    <!-- Left Arrow -->
                                            <button class="owl-prev custom-prev"><i class="fa-sharp fa-light fa-chevron-left"></i></button>

                                            <div class="details_slider owl-carousel">
                                                <?php $__currentLoopData = $combo->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="dimage_item">
                                                        <img src="<?php echo e(asset($value->image)); ?>" class="block__pic" loading="lazy" />
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>

                                            <!-- Right Arrow -->
                                            <button class="owl-next custom-next"><i class="fa-sharp fa-light fa-chevron-right"></i></button>
                                        </div>

                                        <div class="swiper indicator_thumb">
                                            <div class="swiper-wrapper">
                                                <?php $__currentLoopData = $combo->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="swiper-slide indicator-item" data-id="<?php echo e($key); ?>">
                                                        <img src="<?php echo e(asset($image->image)); ?>" loading="lazy" />
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                


                            </div>
                            <div class="col-sm-6">
                                <div class="details_right">


                                    <div class="product">
                                        <div class="product-cart">
                                            <div class="tdt" style="margin: 5px 0;">
                                                <li><a href="<?php echo e(url('/')); ?>" style="font-weight: 600;">Category : </a></li>
                                                <?php if($combo->category && $combo->category->slug): ?>

                                                    <li><a href="<?php echo e(url('/category/' . $combo->category->slug)); ?>"
                                                            style="color: #f80653;font-weight: 600;"><?php echo e($combo->category->name); ?></a>
                                                    </li>
                                                <?php endif; ?>
                                            </div>
                                            <?php if($combo->pro_unit): ?>
                                                <div class="pro_unig">
                                                    <label>Unit: <?php echo e($combo->pro_unit); ?></label>
                                                    <input type="hidden" name="pro_unit" value="<?php echo e($combo->pro_unit); ?>" />
                                                </div>
                                            <?php endif; ?>


                                            <p class="name"><?php echo e($combo->name); ?></p>

                                            <div class="details-price">
                                                <?php if($combo->old_price): ?>

                                                <?php endif; ?>
                                                <p>৳<?php echo e($combo->new_price); ?></p>
                                                <div class="cd1">
                                                    <del>৳<?php echo e($combo->old_price); ?></del>
                                                </div>
                                                <div class="cd2">
                                                    <span class="main-badge">
                                                        <?php $discount = (((($combo->old_price) - ($combo->new_price)) * 100) / ($combo->old_price)) ?>
                                                        <?php echo e(number_format($discount, 0)); ?>% OFF
                                                    </span>
                                                </div>

                                            </div>

                                            <div class="stockmenu" style="margin:15px 0">
                                                <?php if($combo->stock < 1): ?>
                                                    <span class="stockleft" style="border:1px solid #ff0000;color: #ff0000;">
                                                        Stock Out
                                                    </span>
                                                <?php elseif($combo->stock < 6): ?>
                                                    <span class="stockleft" style="border:1px solid #ff0000;color: #ff0000;">
                                                        Only <?php echo e($combo->stock); ?> in stock
                                                    </span>
                                                <?php else: ?>
                                                    <span class="stockleft">
                                                        <?php echo e($combo->stock); ?> in stock
                                                    </span>
                                                <?php endif; ?>

                                            </div>

                                            <div class="pro_brand">
                                                <p>Brand :
                                                    <span>
                                                        <?php echo e($combo->brand ? $combo->brand->name : 'Non Brand'); ?></span>
                                                </p>
                                            </div>


                                            <?php
                                                // Controller থেকে আসা ভ্যালু
                                                $modalId = $combo->id;
                                                $basePrice = $combo->new_price;
                                            ?>

                                            <form action="<?php echo e(route('cart.combo')); ?>" method="POST" id="comboForm">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="id" value="<?php echo e($combo->id); ?>">
                                                <input type="hidden" name="qty" value="1">

                                                <div class="combo-products mb-3">
                                                    <div class="section-titleComb">
                                                        <span>Choose Any <?php echo e($maxProducts); ?> Products</span>
                                                    </div>

                                                    <div class="d-flex flex-wrap gap-3">
                                                        <?php for($i = 1; $i <= $maxProducts; $i++): ?>
                                                            <div class="combo-box text-center" data-index="<?php echo e($i); ?>">
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
                                                        <?php endfor; ?>
                                                    </div>
                                                </div>

                                                <!-- Product selection modal -->
                                                <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Select any <?php echo e($maxProducts); ?>

                                                                    Product</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row category-product main_product_inner_model">
                                                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <div class="col-md-3 mb-3">
                                                                            <?php
                                                                                $mainImage = $product->images->count() ? $product->images[0]->image : 'default.jpg';
                                                                            ?>
                                                                            <div class="product_item wist_item"
                                                                                data-id="<?php echo e($product->id); ?>"
                                                                                data-name="<?php echo e($product->name); ?>"
                                                                                data-image="<?php echo e(asset($mainImage)); ?>"
                                                                                data-price="<?php echo e($product->new_price); ?>">

                                                                                <div class="pro_img">
                                                                                    <img src="<?php echo e(asset($mainImage)); ?>"
                                                                                        class="main-img"
                                                                                        alt="<?php echo e($product->name); ?>">
                                                                                </div>

                                                                                <div class="pro_des">
                                                                                    <div class="pro_name">
                                                                                        <h5><?php echo e(Str::limit($product->name, 50)); ?>

                                                                                        </h5>
                                                                                    </div>
                                                                                    <div class="details-price">
                                                                                        <?php if($product->old_price): ?>

                                                                                        <?php endif; ?>
                                                                                        <p style="font-size: 17px">
                                                                                            ৳<?php echo e($product->new_price); ?></p>
                                                                                        <div class="cd1">
                                                                                            <del
                                                                                                style="font-size: 15px">৳<?php echo e($product->old_price); ?></del>
                                                                                        </div>
                                                                                        <div class="cd2">
                                                                                            <span class="main-badge">
                                                                                                <?php $discount = (((($product->old_price) - ($product->new_price)) * 100) / ($product->old_price)) ?>
                                                                                                <?php echo e(number_format($discount, 0)); ?>%
                                                                                                OFF
                                                                                            </span>
                                                                                        </div>

                                                                                    </div>

                                                                                    
                                                                                    <?php if($product->colors && $product->colors->count() > 0): ?>
                                                                                        <div class="pro-color" style="width:100%;">
                                                                                            <div class="color_inner">
                                                                                                <p>Color - <span
                                                                                                        class="selectedColor">Select
                                                                                                        Any Color</span></p>
                                                                                                <div class="size-container">
                                                                                                    <div class="selector"
                                                                                                        style="display:flex; flex-wrap:wrap; gap:6px; margin-top:8px;">
                                                                                                        <?php $__currentLoopData = $product->colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $procolor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                                            <div class="selector-item">
                                                                                                                <input type="radio"
                                                                                                                    id="fc-option<?php echo e($procolor->id); ?>-<?php echo e($product->id); ?>"
                                                                                                                    value="<?php echo e($procolor->colorName ?? ''); ?>"
                                                                                                                    name="product_color_<?php echo e($product->id); ?>"
                                                                                                                    class="selector-item_radio" />
                                                                                                                <label
                                                                                                                    for="fc-option<?php echo e($procolor->id); ?>-<?php echo e($product->id); ?>"
                                                                                                                    style="margin-right:5px;background-color: <?php echo e($procolor->color ?? ''); ?>;border:1px solid #ccc;"
                                                                                                                    class="selector-item_label">
                                                                                                                    <span><img
                                                                                                                            src="<?php echo e(asset('public/frontEnd/images/check-icon.svg')); ?>"
                                                                                                                            alt="Checked Icon" /></span>
                                                                                                                </label>
                                                                                                            </div>
                                                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php endif; ?>

                                                                                    
                                                                                    <?php if($product->sizes && $product->sizes->count() > 0): ?>
                                                                                        <div class="pro-size" style="width:100%;">
                                                                                            <div class="size_inner">
                                                                                                <p>Size - <span
                                                                                                        class="selectedSize">Select
                                                                                                        Any Size</span></p>
                                                                                                <div class="size-container">
                                                                                                    <div class="selector"
                                                                                                        style="display:flex; flex-wrap:wrap; gap:6px; margin-top:8px;">
                                                                                                        <?php $__currentLoopData = $product->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prosize): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                                            <div class="selector-item">
                                                                                                                <input type="radio"
                                                                                                                    id="f-option<?php echo e($prosize->id); ?>-<?php echo e($product->id); ?>"
                                                                                                                    value="<?php echo e($prosize->sizeName ?? ''); ?>"
                                                                                                                    name="product_size_<?php echo e($product->id); ?>"
                                                                                                                    class="selector-item_radio"
                                                                                                                    style="display:none;" />
                                                                                                                <label
                                                                                                                    for="f-option<?php echo e($prosize->id); ?>-<?php echo e($product->id); ?>"
                                                                                                                    class="selector-item_label"
                                                                                                                    style="cursor:pointer; padding:5px 10px; border:1px solid #ccc; border-radius:4px;">
                                                                                                                    <?php echo e($prosize->sizeName ?? ''); ?>

                                                                                                                </label>
                                                                                                            </div>
                                                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php endif; ?>

                                                                                    <button type="button"
                                                                                        class="btn add-to-combo-btn">Add to
                                                                                        Combo</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                <div class="single_product">
                                                    <?php $basePrice = $combo->new_price ?? $combo->price; ?>
                                                    <button type="submit" class="btn px-4 add_cart_btn" name="add_cart">Add
                                                        to cart – <?php echo e($basePrice); ?>৳</button>
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
                                                                            readonly value="<?php echo e(url()->current()); ?>">
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
                                                        <?php $__currentLoopData = $shippingcharge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($value->name); ?></td>
                                                                <td class="text-end">৳ <?php echo e($value->amount); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </table>
                                                    
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

                    let maxProducts = <?php echo e($maxProducts); ?>;
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
                                                (<?php echo e($reviews->count()); ?>)</button>
                                        </li>
                                    </ul>

                                    <!-- Tab Content -->
                                    <div class="tab-content" id="productTabContent">
                                        <?php if($productsizes->count() > 0): ?>
                                            <div class="tab-pane fade show active" id="size" role="tabpanel">
                                                <h5 class="fw-semibold"><?php echo e($combo->category->name); ?> Size Guide</h5>

                                                <!-- Responsive wrapper -->
                                                <div class="table-responsive mt-3">
                                                    <table class="table table-bordered mt-3">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Size</th>
                                                                <th scope="col"><?php echo e($details->sizeType); ?></th>
                                                                <th scope="col">Hip</th>
                                                                <th scope="col">Length</th>
                                                                <th scope="col">Thick</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $__currentLoopData = $productsizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prosize): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td><?php echo e($prosize->size?->sizeName); ?></td>
                                                                    <td><?php echo e($prosize->size?->chestSize); ?></td>
                                                                    <td><?php echo e($prosize->size?->hipSize); ?></td>
                                                                    <td><?php echo e($prosize->size?->length); ?></td>
                                                                    <td><?php echo e($prosize->size?->thickSize); ?></td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        <?php endif; ?>
                                        <!-- Description -->
                                        <div class="tab-pane fade" id="description" role="tabpanel">

                                            <h5 class="fw-semibold">Description</h5>
                                            <div class="description tab-content details-action-box" id="description">

                                                <p><?php echo $combo->description; ?></p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="orderpolicy" role="tabpanel">
                                            <h5 class="fw-semibold">Order Policy</h5>
                                            <div class="description tab-content details-action-box" id="orderpolicy">

                                                <p><?php echo $generalsetting->order_policy; ?></p>
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
                                            <?php if($reviews->count() > 0): ?>
                                                <div class="customer-review2">
                                                    <div class="row">
                                                        <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="col-sm-12 col-12">
                                                                <div class="review-card">
                                                                    <p class="review_star">
                                                                        <?php echo str_repeat('<i class="fa-solid fa-star"></i>', $review->ratting); ?>

                                                                    </p>
                                                                    <p class="review_content"><?php echo e($review->review); ?></p> <br>
                                                                    <div class="reviewnamedate">
                                                                        <p class="reviewer_name"><span
                                                                                style="color: #1a1a1b;">By</span>
                                                                            <?php echo e($review->name); ?></p><span
                                                                            style="margin: 0 4px">on</span>
                                                                        <p class="review_data">
                                                                            <?php echo e($review->created_at->format('d-m-Y')); ?>

                                                                        </p>
                                                                    </div>


                                                                </div>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="empty-content">
                                                    <p class="empty-text1"><i class="fa-light fa-clipboard-list-check"></i></p>
                                                    <p class="empty-text">No Review yet.</p>
                                                </div>
                                            <?php endif; ?>
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
                                                                    <?php if(Auth::guard('customer')->check()): ?>
                                                                        <form action="<?php echo e(route('customer.combo.review')); ?>"
                                                                            method="POST">
                                                                            <?php echo csrf_field(); ?>
                                                                            <label for="message-text"
                                                                                class="col-form-label">Give us
                                                                                rating
                                                                                :</label>
                                                                            <input type="hidden" name="combo_id"
                                                                                value="<?php echo e($combo->id); ?>">

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
                                                                    <?php else: ?>
                                                                        <button class="revbtn"
                                                                            href="<?php echo e(route('customer.login')); ?>">Login to Post
                                                                            Your Review</bitton>
                                                                    <?php endif; ?>
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
                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="product_item wist_item swiper-slide" style="margin: 0;">
                                            <div class="product_item_inner">
                                                <?php if($value->old_price): ?>
                                                    <div class="sale-badge">
                                                        <div class="sale-badge-inner">
                                                            <div class="sale-badge-box">
                                                                <span class="sale-badge-text">
                                                                    <p>-<?php echo e(number_format($discount, 0)); ?>%</p>

                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="pro_img"
                                                    data-second="<?php echo e($value->images->count() > 1 ? asset($value->images[1]->image) : ''); ?>">
                                                    <a href="<?php echo e(route('product', $value->slug)); ?>">
                                                        <img src="<?php echo e(asset($value->image ? $value->image->image : '')); ?>"
                                                            alt="<?php echo e($value->name); ?>" class="main-img" />
                                                    </a>

                                                    <?php if($value->second_image): ?>
                                                        <a href="<?php echo e(route('product', $value->slug)); ?>">
                                                            <img src="<?php echo e(asset($value->second_image)); ?>"
                                                                alt="<?php echo e($value->name); ?> hover" class="hover-img" />
                                                        </a>
                                                    <?php endif; ?>
                                                    <div class="quick-view" data-bs-toggle="modal"
                                                        data-bs-target="#quickViewModal-<?php echo e($value->id); ?>">
                                                        <span>Quick View </span>
                                                        <div class="sizeShowproduct">
                                                            <?php if($value->prosizes && $value->prosizes->count() > 0): ?>
                                                                <?php $__currentLoopData = $value->prosizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <span>
                                                                        <!-- <?php echo e($size->size?->sizeName ?? '-'); ?> -->

                                                                    </span>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>





                                                    <?php if($value->stock < 1): ?>
                                                        <div class="stock-out-overlay">STOCK OUT</div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="pro_des">
                                                    <div class="pro_name">
                                                        <a
                                                            href="<?php echo e(route('product', $value->slug)); ?>"><?php echo e(Str::limit($value->name, 80)); ?></a>
                                                    </div>
                                                     <div
                                                        class="pro_stockstatus <?php echo e($value->stock >= 1 ? 'text-success' : 'text-danger'); ?>">
                                                        <?php echo e($value->stock >= 1 ? 'In Stock' : 'Stock Out'); ?>

                                                    </div>
                                                    <div class="pro_price">
                                                        <p>

                                                            ৳ <?php echo e($value->new_price); ?> <?php if($value->old_price): ?>
                                                            <?php endif; ?>
                                                            <del>৳ <?php echo e($value->old_price); ?></del>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php if(!$value->prosizes->isEmpty() || !$value->procolors->isEmpty() || !$value->stock): ?>
                                                <!-- <div class="pro_btn">

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="cart_btn order_button">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <a href="<?php echo e(route('product', $value->slug)); ?>"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            class="addcartbutton">Buy Now</a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div> -->
                                            <?php else: ?>
                                                <!-- <div class="pro_btn">

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <form action="<?php echo e(route('cart.store')); ?>" method="POST">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php echo csrf_field(); ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <input type="hidden" name="id" value="<?php echo e($value->id); ?>" />
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <input type="hidden" name="qty" value="1" />
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <button type="submit">Buy Now</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </form>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div> -->
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('public/frontEnd/js/owl.carousel.min.js')); ?>"></script>

    <script src="<?php echo e(asset('public/frontEnd/js/zoomsl.min.js')); ?>"></script>

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
                        <?php $__currentLoopData = Cart::instance('shopping')->content(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cartInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                {
                            item_id: "<?php echo e($combo->id); ?>",
                            item_name: "<?php echo e($combo->name); ?>",
                            price: "<?php echo e($combo->new_price); ?>",
                            currency: "BDT",
                            quantity: <?php echo e($cartInfo->qty ?? 0); ?>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                },
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('frontEnd.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\nmfashion\resources\views/frontEnd/layouts/pages/combo.blade.php ENDPATH**/ ?>