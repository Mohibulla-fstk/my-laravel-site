 
<?php $__env->startSection('title'); ?>
  <title><?php echo e($subcategory->meta_title); ?></title> 

<?php $__env->startPush('seo'); ?>
<meta name="app-url" content="<?php echo e(route('subcategory',$subcategory->slug)); ?>" />
<meta name="robots" content="index, follow" />
<meta name="description" content="<?php echo e($subcategory->meta_description); ?>" />
<meta name="keywords" content="<?php echo e($subcategory->slug); ?>" />

<!-- Twitter Card data -->
<meta name="twitter:card" content="product" />
<meta name="twitter:site" content="<?php echo e($subcategory->subcategoryName); ?>" />
<meta name="twitter:title" content="<?php echo e($subcategory->subcategoryName); ?>" />
<meta name="twitter:description" content="<?php echo e($subcategory->meta_description); ?>" />
<meta name="twitter:creator" content="gomobd.com" />
<meta property="og:url" content="<?php echo e(route('subcategory',$subcategory->slug)); ?>" />
<meta name="twitter:image" content="<?php echo e(asset($subcategory->image)); ?>" />

<!-- Open Graph data -->
<meta property="og:title" content="<?php echo e($subcategory->subcategoryName); ?>" />
<meta property="og:type" content="product" />
<meta property="og:url" content="<?php echo e(route('subcategory',$subcategory->slug)); ?>" />
<meta property="og:image" content="<?php echo e(asset($subcategory->image)); ?>" />
<meta property="og:description" content="<?php echo e($subcategory->meta_description); ?>" />
<meta property="og:site_name" content="<?php echo e($subcategory->subcategoryName); ?>" />
<?php $__env->stopPush(); ?> 
<?php $__env->startSection('content'); ?>
 <div class="blankspace"></div>
<div class="gradient-bg">
       <span><?php echo e($subcategory->subcategoryName); ?></span>
       <div>Totall <?php echo e($products->count()); ?> Products on <?php echo e($subcategory->subcategoryName); ?></div>
    </div>
     <div class="filerSliderItem">

    <div class="filterSecName">
        <div class="hero-section"><i class="fa-solid fa-bars-filter"></i> Filter</div>
                    <div class="filter-close"><i class="fa-solid fa-xmark"></i></div>
                    </div>
                   <div class="hero-2part">
                     <form id="filterForm" class="attribute-submit" action="<?php echo e(url()->current()); ?>" method="GET">
    <!-- Checkbox, price inputs etc -->
                        <div class="sidebar_item wraper__item">
                            <div class="accordion" id="category_sidebar">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseCat" aria-expanded="true" aria-controls="collapseOne">
                                            <?php echo e($subcategory->name); ?>

                                        </button>
                                    </h2>
                                    <div id="collapseCat" class="accordion-collapse collapse show"
                                        data-bs-parent="#category_sidebar">
                                        <div class="accordion-body cust_according_body">
                                            <ul>
                                                <?php $__currentLoopData = $subcategory->childcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $childcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li>
                                                        <a
                                                            href="<?php echo e(url('products/' . $childcat->slug)); ?>"><?php echo e($childcat->childcategoryName); ?></a>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--sidebar item end-->
                         <div class="sidebar_item wraper__item">
            <div class="accordion" id="price_sidebar">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsePrice" aria-expanded="true" aria-controls="collapsePrice">
                            Price
                        </button>
                    </h2>
                    <div id="collapsePrice" class="accordion-collapse collapse show"
                         data-bs-parent="#price_sidebar">
                        <div class="accordion-body cust_according_body">
                      
                            <div id="price-range" class="slider form-attribute"></div> <br>
                              <div class="filter-price-inputs"> 
                                                                <p class="min-price">MIN<input type="text"
                                                                        name="min_price" id="min_price" />
                                                                </p>
                                                                <p class="max-price">MAX<input type="text"
                                                                        name="max_price" id="max_price" />
                                                                </p>
                                                            </div>
                                                        </div>
                        </div>
                    </div>
                </div>
            </div>
       
                        <!--sidebar item end-->
          <div class="sidebar_item wraper__item">
    <div class="accordion" id="filter_sidebar">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseFilter" aria-expanded="true" aria-controls="collapseOne">
                    Stock
                </button>
            </h2>
            <div id="collapseFilter" class="accordion-collapse collapse show"
                data-bs-parent="#filter_sidebar">
                <div class="accordion-body cust_according_body">
                    <div class="filter-body">
                        <ul class="space-y-3">
                            <li>
                                <label>
                                    <input type="checkbox" name="stock[]" value="In Stock"
                                        class="form-checkbox form-attribute"
                                        <?php if(is_array(request()->get('stock')) && in_array('In Stock', request()->get('stock'))): ?> checked <?php endif; ?>>
                                    In Stock
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" name="stock[]" value="Stock out"
                                        class="form-checkbox form-attribute"
                                        <?php if(is_array(request()->get('stock')) && in_array('Out of Stock', request()->get('stock'))): ?> checked <?php endif; ?>>
                                    Out of Stock
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="sidebar_item wraper__item">
            <div class="accordion" id="size_sidebar">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSize" aria-expanded="true" aria-controls="collapseSize">
                            Filter by Size
                        </button>
                    </h2>
                    <div id="collapseSize" class="accordion-collapse collapse show"
                         data-bs-parent="#size_sidebar">
                        <div class="accordion-body cust_according_body form-checkbox">
                            <?php $__currentLoopData = $all_sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <label class="size">
        <input type="checkbox" name="size[]" value="<?php echo e($size->sizeName); ?>"
            <?php echo e(is_array(request('size')) && in_array($size->sizeName, request('size'))); ?>>
        <?php echo e($size->sizeName); ?>

    </label><br>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </form> 
                   </div>


                        <!--sidebar item end-->
                    
                    
    </div>
<section class="product-section">
    <div class="container"  style="margin-top: 15px;">
        
        
        <div class="row">
           
            <div class="col-sm-12">
                <div class="row">
                            <div class="col-sm-6">
                                <div class="showing-data">
                                    <!-- <span>Showing <?php echo e($products->firstItem()); ?>-<?php echo e($products->lastItem()); ?> of
                                        <?php echo e($products->total()); ?> Results</span> -->
                                </div>
                            </div>
                           <div class="row"> 
        
                            <div class="category-row">
                               <div class="filerarea">
                        <div class="filterSliderbtn">
                            <a><i class="fa-solid fa-bars-filter"></i> Filter</a>
                        </div>
                        <div class="sortright">
                            <div class="page-sort">
                                  <form id="filterForm2" class="attribute-submit" action="<?php echo e(url()->current()); ?>" method="GET">
                                    <select name="sort" class="form-control form-select sort">
                                                <option value="1" <?php if(request()->get('sort')==1): ?>selected <?php endif; ?>>Sort by Latest</option>
                                                <option value="2" <?php if(request()->get('sort')==2): ?>selected <?php endif; ?>>Sort by Oldest</option>
                                                <option value="3" <?php if(request()->get('sort')==3): ?>selected <?php endif; ?>>Sort by High To Low</option>
                                                <option value="4" <?php if(request()->get('sort')==4): ?>selected <?php endif; ?>>Sort by Low To High</option>
                                                <option value="5" <?php if(request()->get('sort')==5): ?>selected <?php endif; ?>>Sort by A-Z</option>
                                                <option value="6" <?php if(request()->get('sort')==6): ?>selected <?php endif; ?>>Sort by Z-A</option>
                                            </select>
                                            <input type="hidden" name="min_price" value="<?php echo e(request()->get('min_price')); ?>" />
                                            <input type="hidden" name="max_price" value="<?php echo e(request()->get('max_price')); ?>" />
                                  </form>
                                      
                                            
                                      
                                    </div>
                        </div>
                                   
                                
                    </div>
                            
                            </div>
                          
                    
                </div>
                         
                        </div>
                <div id="productList" class="category-product main_product_inner">
                             
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="product_item wist_item">
                        <div class="product_item_inner">
                            <?php if($value->old_price): ?>
                            <div class="sale-badge">
                                <div class="sale-badge-inner">
                                    <div class="sale-badge-box">
                                        <span class="sale-badge-text">
                                            <?php 
                                $disprice = $value->old_price - $value->new_price;
                                $discount = ($disprice * 100) / $value->old_price;
                            ?>
                                          <p>-<?php echo e(number_format($discount,0)); ?>%</p>
                                            
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <!--<?php if($soldShow && $value->sold): ?>-->
                            <!--    <div class="sale-badge" style="left:4px;">-->
                            <!--        <div class="sale-badge-inner">-->
                            <!--            <div class="sale-badge-box">-->
                            <!--                <span class="sale-badge-text">-->
                            <!--                    <p class="text-center"> <?php echo e($value->sold); ?></p>-->
                            <!--                    SOLD-->
                            <!--                </span>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--<?php endif; ?>-->
                            <div class="pro_img" data-second="<?php echo e($value->images->count() > 1 ? asset($value->images[1]->image) : ''); ?>">
                                <?php
                                    $wishlist = json_decode(request()->cookie('wishlist', '[]'), true);
                                    $inWishlist = isset($wishlist[$value->id]);
                                ?>

                               
                                <div class="wishlist-btn">
                                    <button type="button" class="wishlist-toggle" data-product-id="<?php echo e($value->id); ?>">
                                        <?php if($inWishlist): ?>
                                            <!-- In wishlist → show trash SVG -->
                                           <svg class="wishlist-icon" width="24" height="24" aria-hidden="true" role="img" focusable="false" style="color: #f80653;">
                                                <use href="#heart-filled" xlink:href="#heart-filled"></use>
                                            </svg>

                                        <?php else: ?>
                                            <!-- Not in wishlist → show heart SVG -->
                                            <svg width="24" height="24" aria-hidden="true" role="img" focusable="false">
                                                <use href="#heart" xlink:href="#heart"></use>
                                            </svg>
                                        <?php endif; ?>
                                    </button>
                                </div>
                                <a href="<?php echo e(route('product', $value->slug)); ?>">
                <img 
                    src="<?php echo e(asset($value->image ? $value->image->image : '')); ?>" 
                    alt="<?php echo e($value->name); ?>" 
                    class="main-img"
                />
            </a>

            <?php if($value->second_image): ?>
            <a href="<?php echo e(route('product', $value->slug)); ?>">
                <img 
                    src="<?php echo e(asset($value->second_image)); ?>" 
                    alt="<?php echo e($value->name); ?> hover" 
                    class="hover-img"
                />
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
                                    <a href="<?php echo e(route('product',$value->slug)); ?>"><?php echo e(Str::limit($value->name,80)); ?></a>
                                </div>
                                 <div class="pro_stockstatus <?php echo e($value->stock >= 1 ? 'text-success' : 'text-danger'); ?>">
                                        <?php echo e($value->stock >= 1 ? 'In Stock' : 'Stock Out'); ?>

                                    </div>
                                <?php if($soldShow): ?>
                                <span style="background-color:#FFBCA5" class="px-3 py-1 rounded-pill">Sold <?php echo e($value->sold??0); ?></span>
                                <?php endif; ?>
                                <div class="pro_price">
                                            <p><?php if($value->old_price): ?>
                                                 <del><?php echo e($value->old_price); ?>.00৳</del>
                                                <?php endif; ?>
                                                <?php echo e($value->new_price); ?>.00৳
                                            </p>
                                        </div>
                            </div>
                        </div>

                         <?php if(! $value->prosizes->isEmpty() || ! $value->procolors->isEmpty() || ($value->stock <1)): ?>
                        <!-- <div class="pro_btn">
                           
                            <div class="cart_btn order_button">
                                <a href="<?php echo e(route('product',$value->slug)); ?>" class="addcartbutton">Order Now</a>
                            </div>
                            
                        </div> -->
                        <?php else: ?>

                        <!-- <div class="pro_btn">
                            
                            <form action="<?php echo e(route('cart.store')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" value="<?php echo e($value->id); ?>" />
                                <input type="hidden" name="qty" value="1" />
                                <button type="submit">Order Now</button>
                            </form>
                        </div> -->
                        <?php endif; ?>
                        
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="custom_paginate">
                    <?php echo e($products->links('pagination::bootstrap-4')); ?>

                   
                </div>
            </div>
        </div>
    </div>
</section>

<section class="homeproduct">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="meta_des">
                    <?php echo $subcategory->meta_description; ?>

                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <?php echo $__env->make('partials.quick-view', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</section>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script>
     $(".filterSliderbtn").on("click", function () {
            $("#page-overlay").show();
            $(".filerSliderItem").addClass("sliderShow");
        });

        $("#page-overlay").on("click", function () {
            $("#page-overlay").hide();
            $(".filerSliderItem").removeClass("sliderShow");
        });
        $(".filter-close").on("click", function () {
            $("#page-overlay").hide();
            $(".filerSliderItem").removeClass("sliderShow");
        });
        
</script>
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
 <script>
        $(document).ready(function () {
            $(".minus").click(function () {
                var $input = $(this).parent().find("input");
                var count = parseInt($input.val()) - 1;
                count = count < 1 ? 1 : count;
                $input.val(count);
                $input.change();
                return false;
            });
            $(".plus").click(function () {
                var $input = $(this).parent().find("input");
                $input.val(parseInt($input.val()) + 1);
                $input.change();
                return false;
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
        <script>
$(document).ready(function(){

    function ajaxFilter() {
        let form = $("#filterForm");

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            success: function(response){
                // Replace only #productList from the returned HTML
                let newContent = $(response).find("#productList").html();
                $("#productList").html(newContent);
            },
            error: function(xhr){
                console.error(xhr.responseText);
            }
        });
    }

    // Trigger on checkbox / filter input change
    $(".form-attribute, .form-checkbox").on('change click', function(){
        ajaxFilter();
    });

    // Trigger on price slider change
    $("#price-range, .size .color").on('change', function(){
        ajaxFilter();
    });

 

});
</script>
 <script>
$(document).ready(function(){

    function ajaxFilter() {
        let form = $("#filterForm2");

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            success: function(response){
                // Replace only #productList from the returned HTML
                let newContent = $(response).find("#productList").html();
                $("#productList").html(newContent);
            },
            error: function(xhr){
                console.error(xhr.responseText);
            }
        });
    }

    // Trigger on sort dropdown change
    $(".sort").on('change', function(){
        ajaxFilter();
    });

});
</script>

     <script>
        $(function() {
            $("#price-range").slider({
                step: 1,
                range: true,
                min: <?php echo e($min_price); ?>,
                max: <?php echo e($max_price); ?>,
                values: [
                    <?php echo e(request()->get('min_price') ? request()->get('min_price') : $min_price); ?>,
                    <?php echo e(request()->get('max_price') ? request()->get('max_price') : $max_price); ?>

                ],
                slide: function(event, ui) {
                    $("#min_price").val(ui.values[0]);
                    $("#max_price").val(ui.values[1]);
                }
            });
            $("#min_price").val(<?php echo e(request()->get('min_price') ? request()->get('min_price') : $min_price); ?>);
            $("#max_price").val(<?php echo e(request()->get('max_price') ? request()->get('max_price') : $max_price); ?>);
            $("#priceRange").val($("#price-range").slider("values", 0) + " - " + $("#price-range").slider("values",
                1));

            $("#mobile-price-range").slider({
                step: 5,
                range: true,
                min: <?php echo e($min_price); ?>,
                max: <?php echo e($max_price); ?>,
                values: [
                    <?php echo e(request()->get('min_price') ? request()->get('min_price') : $min_price); ?>,
                    <?php echo e(request()->get('max_price') ? request()->get('max_price') : $max_price); ?>

                ],
                slide: function(event, ui) {
                    $("#min_price").val(ui.values[0]);
                    $("#max_price").val(ui.values[1]);
                }
            });
            $("#min_price").val(<?php echo e(request()->get('min_price') ? request()->get('min_price') : $min_price); ?>);
            $("#max_price").val(<?php echo e(request()->get('max_price') ? request()->get('max_price') : $max_price); ?>);
            $("#priceRange").val($("#price-range").slider("values", 0) + " - " + $("#price-range").slider("values",
                1));

        });
    </script>

<script>
    // $(".sort").change(function(){
    //   $('#loading').show();
    //   $(".sort-form").submit();
    // })
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('frontEnd.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\nmfashion\resources\views/frontEnd/layouts/pages/subcategory.blade.php ENDPATH**/ ?>