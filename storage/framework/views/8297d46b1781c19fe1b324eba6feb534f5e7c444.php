
<?php $__env->startSection('title'); ?>
  <title><?php echo e($category->meta_title); ?></title>

<?php $__env->startPush('seo'); ?>
    <meta name="app-url" content="<?php echo e(route('category', $category->slug)); ?>" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="<?php echo e($category->meta_description); ?>" />
    <meta name="keywords" content="<?php echo e($category->slug); ?>" />

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product" />
    <meta name="twitter:site" content="<?php echo e($category->name); ?>" />
    <meta name="twitter:title" content="<?php echo e($category->name); ?>" />
    <meta name="twitter:description" content="<?php echo e($category->meta_description); ?>" />
    <meta name="twitter:creator" content="Creative Design" />
    <meta property="og:url" content="<?php echo e(route('category', $category->slug)); ?>" />
    <meta name="twitter:image" content="<?php echo e(asset($category->image)); ?>" />

    <!-- Open Graph data -->
    <meta property="og:title" content="<?php echo e($category->name); ?>" />
    <meta property="og:type" content="product" />
    <meta property="og:url" content="<?php echo e(route('category', $category->slug)); ?>" />
    <meta property="og:image" content="<?php echo e(asset($category->image)); ?>" />
    <meta property="og:description" content="<?php echo e($category->meta_description); ?>" />
    <meta property="og:site_name" content="<?php echo e($category->name); ?>" />
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
 <div class="blankspace"></div>
<div class="gradient-bg">
       <span><?php echo e($category->name); ?></span>
 <div>
        Total 
        <?php echo e($products->count() + (isset($combo_products) ? $combo_products->count() : 0)); ?> 
        Products on <?php echo e($category->name); ?>

    </div>
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
                                            <?php echo e($category->name); ?>

                                        </button>
                                    </h2>
                                    <div id="collapseCat" class="accordion-collapse collapse show"
                                        data-bs-parent="#category_sidebar">
                                        <div class="accordion-body cust_according_body">
                                            <ul>
                                                <?php $__currentLoopData = $category->subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li>
                                                        <a
                                                            href="<?php echo e(url('subcategory/' . $subcat->slug)); ?>"><?php echo e($subcat->subcategoryName); ?></a>
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
 
        <div class="max-width1">
            <!-- <div class="sorting-section">-->
                <div class="row"> 
                    
                    <!-- <div class="col-sm-6">
                        <div class="category-breadcrumb d-flex align-items-center">
                            <a href="<?php echo e(route('home')); ?>">Home</a>
                            <span><i class="fa-solid fa-angle-right arrowset"></i></span>
                            
                            
                        </div>
                    </div>  -->
                  
                       
                            <div class="category-row">
                                <!-- <div class="showing-data">
                                    <span>Showing <?php echo e($products->firstItem()); ?>-<?php echo e($products->lastItem()); ?> of
                                        <?php echo e($products->total()); ?> Results</span>
                                </div> -->
                               <div class="filerarea">
                        <div class="filterSliderbtn">
                            <a><i class="fa-solid fa-bars-filter"></i> Filter</a>
                        </div>
                          <div class="sortright">
                            <div class="page-sort">
                                  <form id="filterForm2" class="attribute-submit" action="<?php echo e(url()->current()); ?>" method="GET">
                                    <select name="sort" class="form-control form-select sort">
                                                  <option value="1" <?php echo e(request()->get('sort') == 1 ? 'selected' : ''); ?>>Latest First</option>
    <option value="2" <?php echo e(request()->get('sort') == 2 ? 'selected' : ''); ?>>Oldest First</option>
    <option value="3" <?php echo e(request()->get('sort') == 3 ? 'selected' : ''); ?>>Price High to Low</option>
    <option value="4" <?php echo e(request()->get('sort') == 4 ? 'selected' : ''); ?>>Price Low to High</option>
    <option value="5" <?php echo e(request()->get('sort') == 5 ? 'selected' : ''); ?>>Name A-Z</option>
    <option value="6" <?php echo e(request()->get('sort') == 6 ? 'selected' : ''); ?>>Name Z-A</option>
                                            </select>
                                            <input type="hidden" name="min_price" value="<?php echo e(request()->get('min_price')); ?>" />
                                            <input type="hidden" name="max_price" value="<?php echo e(request()->get('max_price')); ?>" />
                                  </form>
                                      
                                            
                                      
                                    </div>
                        </div>
                                   
                                
                    </div>
                            
                            </div>
                          
                    
                </div>
                <!-- </div>
            </div> -->
            <div class="row">

                
                <div class="col-sm-12">
 
                       
                  <!-- <div class="container">
                     <div class="row sorting-product">
                            <div class="col-sm-6">
                                <div class="showing-data">
                                    <span>Showing <?php echo e($products->firstItem()); ?>-<?php echo e($products->lastItem()); ?> of
                                        <?php echo e($products->total()); ?> Results</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="filter_sort">
                                    <div class="filter_btn">
                                        <i class="fa fa-list-ul"></i>
                                    </div>
                                    <div class="page-sort">
                                        <form action="" class="sort-form">
                                            <select name="sort" class="form-control form-select sort">
                                                <option value="1" <?php if(request()->get('sort')==1): ?>selected <?php endif; ?>>Product: Latest</option>
                                                <option value="2" <?php if(request()->get('sort')==2): ?>selected <?php endif; ?>>Product: Oldest</option>
                                                <option value="3" <?php if(request()->get('sort')==3): ?>selected <?php endif; ?>>Price: High To Low</option>
                                                <option value="4" <?php if(request()->get('sort')==4): ?>selected <?php endif; ?>>Price: Low To High</option>
                                                <option value="5" <?php if(request()->get('sort')==5): ?>selected <?php endif; ?>>Name: A-Z</option>
                                                <option value="6" <?php if(request()->get('sort')==6): ?>selected <?php endif; ?>>Name: Z-A</option>
                                            </select>
                                            <input type="hidden" name="min_price" value="<?php echo e(request()->get('min_price')); ?>" />
                                            <input type="hidden" name="max_price" value="<?php echo e(request()->get('max_price')); ?>" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                  </div> -->


                    <div id="productList" class="category-product main_product_inner">
                        
       <?php
    $comboProducts = $combo_products ?? collect();
    $normalProducts = $products->getCollection() ?? collect(); // paginator থেকে collection নাও

    // Merge
    $allItems = $comboProducts->merge($normalProducts)->sortBy('created_at'); ;
?>


<?php $__empty_1 = true; $__currentLoopData = $paginatedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                <?php if($value instanceof \App\Models\Combo): ?>
                    <a href="<?php echo e(route('combo.show', $value->slug)); ?>">
                        <img src="<?php echo e(asset($value->images->first()?->image ?? '')); ?>" alt="<?php echo e($value->name); ?>" class="main-img" />
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('product', $value->slug)); ?>">
                        <img src="<?php echo e(asset($value->image ? $value->image->image : '')); ?>" alt="<?php echo e($value->name); ?>" class="main-img" />
                    </a>
                <?php endif; ?>

                <?php if(isset($value->second_image) && $value->second_image): ?>
                    <a href="<?php echo e($value instanceof \App\Models\Combo ? route('combo.show', $value->slug) : route('product', $value->slug)); ?>">
                        <img src="<?php echo e(asset($value->second_image)); ?>" alt="<?php echo e($value->name); ?> hover" class="hover-img" />
                    </a>
                <?php endif; ?>

   
       <?php if(!$value instanceof \App\Models\Combo): ?>
    <div class="quick-view" data-bs-toggle="modal" data-bs-target="#quickViewModal-<?php echo e($value->id); ?>">
        <span>Quick View</span>
    </div>
    <?php else: ?>
     <a href="<?php echo e(route('combo.show', $value->slug)); ?>">
      <div class="combo-height">
        <h4>Combo</h4>
    </div>
    </a>
  <?php endif; ?>



                <?php if(isset($value->stock) && $value->stock < 1): ?>
                    <div class="stock-out-overlay">STOCK OUT</div>
                <?php endif; ?>
            </div>

            
            <div class="pro_des">
                <div class="pro_name">
                    <a href="<?php echo e($value instanceof \App\Models\Combo ? route('combo.show', $value->slug) : route('product', $value->slug)); ?>">
                        <?php echo e(Str::limit($value->name, 80)); ?>

                    </a>
                </div>
                <div class="pro_stockstatus <?php echo e($value->stock >= 1 ? 'text-success' : 'text-danger'); ?>">
                                        <?php echo e($value->stock >= 1 ? 'In Stock' : 'Stock Out'); ?>

                                    </div>

                <?php if($soldShow && !($value instanceof \App\Models\Combo)): ?>
                    <span style="background-color:#FFBCA5" class="px-3 py-1 rounded-pill">Sold <?php echo e($value->sold ?? 0); ?></span>
                <?php endif; ?>

                <div class="pro_price">
                    <p>
                        <?php if($value->old_price): ?>
                            <del><?php echo e($value->old_price); ?>.00৳</del>
                        <?php endif; ?>
                        <?php echo e($value->new_price); ?>.00৳
                    </p>
                </div>
            </div>

        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="no-products">
        <div class="nooroductsectionicontext">
            <div class="iconfornopsystem"><i class="fa-solid fa-clipboard-exclamation"></i></div>
            <div class="textsystemfornop">No Any Product here</div>
            <a href="<?php echo e(route('shop')); ?>"><span class="span-class4">Shop Now <i class="fa-solid fa-arrow-right"></i></span></a>
        </div>
    </div>
<?php endif; ?>


                    </div>
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
            <div class="category-row">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="meta_des">
                        <?php echo $category->meta_description; ?>

                    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <!-- <script>
    const filterbtnslider = document.querySelector('.filterSliderbtn'),filterClose = document.querySelector(".filter-close"),filterContent = document.querySelector('.filerSliderItem');
    filterbtnslider.addEventListener('click',()=>{
        
        filterContent.classList.add('sliderShow')
    })
    filterClose.addEventListener('click',()=>{
         filterContent.classList.remove('sliderShow')
    })
</script> -->

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

    // Checkbox click → show/hide sub/child categories
    $(".category-checkbox").on('change', function(){
        let subList = $(this).closest('li').find('.subcategory-list').first();
        if(subList.length) subList.toggle(this.checked);
        ajaxFilter();
    });

    $(".subcategory-checkbox").on('change', function(){
        let childList = $(this).closest('li').find('.childcategory-list').first();
        if(childList.length) childList.toggle(this.checked);
        ajaxFilter();
    });

    $(".childcategory-checkbox").on('change', ajaxFilter);
      $(".ajax-filter").on('change', ajaxFilter);

    // Sort / price / stock
    $(".form-attribute, .form-checkbox, #price-range,.size").on('change click', function(){
        ajaxFilter();
    });

    // Page load: show checked sub/child categories
    $(".category-checkbox:checked").each(function(){
        $(this).closest('li').find('.subcategory-list').first().show();
    });
    $(".subcategory-checkbox:checked").each(function(){
        $(this).closest('li').find('.childcategory-list').first().show();
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
    $(".sort").on('change click', function(){
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
    
<?php $__env->stopPush(); ?>

<?php echo $__env->make('frontEnd.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\nmfashion\resources\views/frontEnd/layouts/pages/category.blade.php ENDPATH**/ ?>