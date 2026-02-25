 
<?php $__env->startSection('title', 'Home'); ?> 
<?php $__env->startPush('seo'); ?>
 
<?php if($generalsetting && $generalsetting->meta_description): ?>
  <meta name="description" content="<?php echo $generalsetting->meta_description; ?>" />
<?php endif; ?>

<?php if($generalsetting && $generalsetting->meta_keyword): ?>
  <meta name="keywords" content="<?php echo e($generalsetting->meta_keyword); ?>" />
<?php endif; ?>


		<!-- Open Graph data -->
<?php if($generalsetting): ?>
    <?php if(!empty($generalsetting->name)): ?>
        <meta property="og:title" content="<?php echo e($generalsetting->name); ?>" />
    <?php endif; ?>

    <meta property="og:type" content="website" />

    <meta property="og:url" content="<?php echo e(url('/')); ?>" />

    <?php if(!empty($generalsetting->og_baner)): ?>
        <meta property="og:image" content="<?php echo e(asset($generalsetting->og_baner)); ?>" />
    <?php endif; ?>

    <?php if(!empty($generalsetting->meta_description)): ?>
        <meta property="og:description" content="<?php echo e($generalsetting->meta_description); ?>" />
    <?php endif; ?>
<?php endif; ?>

<?php $__env->stopPush(); ?> <?php $__env->startPush('css'); ?>


<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css" rel="stylesheet" />
<?php $__env->stopPush(); ?> <?php $__env->startSection('content'); ?>
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<div class="blankspace"></div>
<section class="slider-section">
    
     
  
            
            <!-- <div class="col-sm-3 hidetosm">
                <div class="sidebar-menu">
                    <ul class="hideshow">
                        <?php $__currentLoopData = $menucategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo e(route('category', $category->slug)); ?>">
                                    <img src="<?php echo e(asset($category->image)); ?>" alt="" />
                                    <?php echo e($category->name); ?>

                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="sidebar-submenu">
                                    <?php $__currentLoopData = $category->subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <a href="<?php echo e(route('subcategory', $subcategory->slug)); ?>">
                                                <?php echo e($subcategory->subcategoryName); ?> <i
                                                    class="fa-solid fa-chevron-right"></i> </a>
                                            <ul class="sidebar-childmenu">
                                                <?php $__currentLoopData = $subcategory->childcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $childcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li>
                                                        <a href="<?php echo e(route('products', $childcat->slug)); ?>">
                                                            <?php echo e($childcat->childcategoryName); ?>

                                                        </a>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
            -->
             <div class="content2">
                

<div class="col-sm-12" style="position: relative;">

   <div class="col-sm-12" style="position: relative;">

    <div class="main-home-slide swiper">
        <div class="swiper-wrapper">
            <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="swiper-slide" style="width: 100%">
                    <?php if($value->text_status == 1): ?>
                        <div class="sub-area">
                      
                       <div class="max-width4">
                       
                             <div class="col-sm-7">
                            <div class="text-field">
                           <div class="first-text-for-banner">
                             <span class="text-field-first-text" style="background:transparent;color:<?php echo e($value->subtitlecolor ?? '#1a1a1b'); ?>"><?php echo e($value->title); ?></span><br>
                           </div>
                           <div class="second-text-for-banner">
                             <span class="text-field-second-text" style="color:<?php echo e($value->subtitlecolor ?? '#1a1a1b'); ?>"><?php echo e($value->subtitle); ?></span><br>
                           </div>
                            <a class="text-field-third-text" href="<?php echo e($value->link); ?>" style="background:<?php echo e($value->buttoncolor ?? '#1a1a1b'); ?>; color:<?php echo e($value->buttontextcolor ?? '#ffffff'); ?>; border: 1px solid <?php echo e($value->buttoncolor ?? '#ffffff'); ?>">
                                <?php echo e($value->button_text); ?> <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                        </div>
                         <div class="col-sm-7">
                           <div class="fakearea-box"></div>
                             </div>
                     
                         </div>
                  
                    </div>
                    <?php endif; ?>
                    
                   <a href="<?php echo e($value->link); ?>">
                        <img src="<?php echo e(asset($value->image)); ?>" alt="" />
                    </a>
                   
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="antiget">
            <div class="swiper-pagination"></div>
        </div>
    </div>

</div>

<script>
    var swiper = new Swiper(".main-home-slide", {
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        autoplay: {
            delay: 7000,
            disableOnInteraction: false,
        },
        speed: 1000,  
    });
</script>



    </div>
            
       
         
    
   
    
</section>
 <div class="top_header">
            <div class="d-flex align-items-center flex-grow-1">
               <?php
    $marqueeCount = $generalsetting->marque_count ?? 0; // database থেকে value
    $headline = $generalsetting->top_headline ?? 'Default headline here';
?>

<?php if($marqueeCount > 0): ?>
    <marquee direction="left" scrollamount="12">
        <?php for($i = 0; $i < $marqueeCount; $i++): ?>
            <i class="fa-solid fa-bolt"></i> <?php echo e($headline); ?>

            <?php if($i < $marqueeCount - 1): ?>
                &nbsp;&nbsp;|&nbsp;&nbsp; 
            <?php endif; ?>
        <?php endfor; ?>
    </marquee>
<?php endif; ?>

                
                
            </div>
          </div>
          
<script>
    const swiper = new Swiper('.swiper', {
  // Optional parameters
  direction: 'horizontal',
  loop: true,
  autoplay:true,

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
       clickable: true, 
  },

  // Navigation arrows
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

  // And if we need scrollbar
  scrollbar: {
    el: '.swiper-scrollbar',
  },
});
</script>
<!-- slider end -->

  <?php if($generalsetting && $generalsetting->show_category_wise_products): ?>
    <?php $__currentLoopData = $homeproducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <section class="homeproduct">
            <div class="max-width1">
                <div class="gradient-bg1 mb-2">
                    <div class="blanksidelayer"></div>
                    <span class="section-title-name"><?php echo e($item->section_name); ?></span> 
            </div>
                </div>

                <div class="swiper myswiper categorySwiper-<?php echo e($item->id); ?>">
                    <div class="swiper-wrapper">
                        <?php
                            // Merge combo_products + products safely
                            $allItems = ($item->combo_products ?? collect())->merge($item->products ?? collect());
                            $shuffledItems = $allItems->shuffle();
                        ?>

                        <?php $__currentLoopData = $shuffledItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($product->status == 1): ?>
                                <div class="swiper-slide product_item_inner">
                                    <div class="category-productforcategorywise main_product_innerforcategorywise">
                                        <div class="pro_img" style="border-radius:10px" 
                                             data-second="<?php echo e($product->images->count() > 1 ? asset($product->images[1]->image) : ''); ?>">
                                            
                                            <?php
                                                $wishlist = json_decode(request()->cookie('wishlist', '[]'), true);
                                                $inWishlist = isset($wishlist[$product->id]);
                                            ?>

                                            <div class="wishlist-btn">
                                                <button type="button" class="wishlist-toggle" data-product-id="<?php echo e($product->id); ?>">
                                                    <?php if($inWishlist): ?>
                                                        <svg class="wishlist-icon" width="24" height="24" style="color: #f80653;">
                                                            <use href="#heart-filled" xlink:href="#heart-filled"></use>
                                                        </svg>
                                                    <?php else: ?>
                                                        <svg width="24" height="24">
                                                            <use href="#heart" xlink:href="#heart"></use>
                                                        </svg>
                                                    <?php endif; ?>
                                                </button>
                                            </div>

                                            <?php if($product instanceof \App\Models\Combo): ?>
                                                <a href="<?php echo e(route('combo.show', $product->slug)); ?>">
                                                    <img src="<?php echo e(asset($product->images->first()?->image ?? '')); ?>" alt="<?php echo e($product->name); ?>" class="main-img" />
                                                </a>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('product', $product->slug)); ?>">
                                                    <img src="<?php echo e(asset($product->image?->image ?? '')); ?>" alt="<?php echo e($product->name); ?>" class="main-img" />
                                                </a>
                                            <?php endif; ?>

                                            <?php if(isset($product->second_image) && $product->second_image): ?>
                                                <a href="<?php echo e(route($product instanceof \App\Models\Combo ? 'combo.show' : 'product', $product->slug)); ?>">
                                                    <img src="<?php echo e(asset($product->second_image)); ?>" alt="<?php echo e($product->name); ?> hover" class="hover-img" />
                                                </a>
                                            <?php endif; ?>

                                            <?php if(!$product instanceof \App\Models\Combo): ?>
                                                <div class="quick-view" data-bs-toggle="modal" data-bs-target="#quickViewModal-<?php echo e($product->id); ?>">
                                                    <span>Quick View</span>
                                                </div>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('combo.show', $product->slug)); ?>">
                                                    <div class="combo-height">
                                                        <h4>Combo</h4>
                                                    </div>
                                                </a>
                                            <?php endif; ?>

                                            <?php if(isset($product->stock) && $product->stock < 1): ?>
                                                <div class="stock-out-overlay">STOCK OUT</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div> <!-- swiper-wrapper -->
                </div> <!-- swiper -->
            </div> <!-- max-width1 -->
        </section>
        
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>





<section class="homeproduct ">
 
    <div class="col-sm-12">
                <div class="category-row set-background-color ">
                <div class="sec_title">
                    <h3 class="section-title-header">
                        <div class="timer_inner">
                            <div class="">
                                <span class="section-title-name dark-category">SHOP BY CATEGORY </span>
                            </div>
                        </div>
                    </h3>
                   <!-- <div class="cetegorybutton">
                    <?php $__currentLoopData = $menucategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                        <a href="<?php echo e(route('category', $value->slug)); ?>">
                            <div class="category-sub-button" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <?php echo e($value->name); ?>

                            </div>    
                        </a>  
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   </div> -->
                </div>
               
              <div class="max-width1">

        
                <div class="col-sm-12">
                    <div class="category-product1 main_product_inner1">
                    <?php $__currentLoopData = $menucategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="cat_item1">
                            <div class="cat_img1">
                                
                                <a href="<?php echo e(route('category', $value->slug)); ?>">
                                    <img src="<?php echo e(asset($value->image)); ?>" loading="lazy" alt="" />
                                </a>
                                <div class="cat_name1">
                                <a href="<?php echo e(route('category', $value->slug)); ?>">
                                    <?php echo e($value->name); ?>

                                </a>
                        <div class="product_count">
                    <?php
                        $mainCount = $value->products->count();
                        $comboCount = $value->combos->sum(function($combo) {
                            return $combo->products->count();
                        });
                        $total = $mainCount + $comboCount;
                    ?>
                    <?php echo e($total); ?> Products
                </div>
                            </div>
                            </div>
                            
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                </div>
         
             </div>
            <!-- <div class="col-sm-12">
                <div class="category-sliger owl-carousel">
                    <?php $__currentLoopData = $menucategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="product-scroll-cetegoryy">
                            <div class="text-center photosection-category">
                                <a href="<?php echo e(route('category', $value->slug)); ?>">
                                    <img class="" src="<?php echo e(asset($value->image)); ?>" alt="" style="width: 100%; height: 100%;" />
                                </a>
                                <div class="text-bottom-name">Hi</div>
                            </div>
                            <div class="text-center">
                                <a href="<?php echo e(route('category', $value->slug)); ?>">
                                    <div style="margin-top:5px;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <?php echo e($value->name); ?>

                                    </div>
                                
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>-->
            </div> 
            </div>
  
</section>






<?php
    $hotDealEndDate = $generalsetting?->hot_deal_end_date 
        ? $generalsetting->hot_deal_end_date . 'T23:59:59' 
        : null;

    $flashSaleEndDate = $generalsetting?->flash_sale_end_date 
        ? $generalsetting->flash_sale_end_date . 'T23:59:59' 
        : null;

    $isHotDealActive = $hotDealEndDate 
        ? \Carbon\Carbon::parse($hotDealEndDate)->isFuture() 
        : false;

    $isFlashSaleActive = $flashSaleEndDate 
        ? \Carbon\Carbon::parse($flashSaleEndDate)->isFuture() 
        : false;
?>

<!--//Flash sales-->
<?php if($isFlashSaleActive): ?>
<section class="homeproduct">
    <div class="max-width">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="sec_title">
                   
                        <div class="timer_inner">
                            <div class="headtext-for-name-category">
                                 <h3 class="section-title-header">
                                    <span class="section-title-name" >Flash Sales </span>
                                  </h3>
                                
                            </div>

                            <div class="count">
                               <div class="offer_timer" id="flash_sale_timer"></div>
                            </div>
                        </div>
                  
                    
                </div>
            </div>
            
            <div class="col-sm-12">
                <div class="category-product main_product_inner owl-carousel">
                    <?php $__currentLoopData = $flas_sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="product_item wist_item">
                            <div class="product_item_inner">
                                <?php if($value->old_price): ?>
                                <div class="sale-badge">
                                    <div class="sale-badge-inner">
                                        <div class="sale-badge-box">
                                            <span class="sale-badge-text">
                                             <?php 
                                                    $disprice = $value->old_price - $value->new_price;
                                                    $discount = $value->old_price > 0 ? ($disprice * 100) / $value->old_price : 0;
                                                ?>
                                                <!-- <p>Save: <?php echo e(number_format($disprice,0)); ?>৳ (<?php echo e(number_format($discount,0)); ?>%)</p> -->
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
                                        <a href="<?php echo e(route('product', $value->slug)); ?>"><?php echo e(Str::limit($value->name, 50)); ?></a>
                                    </div>
                                    
                                    <span style="background-color:#FFBCA5" class="px-3 py-1 rounded-pill">Sold <?php echo e($value->sold??0); ?></span>
                                     <div class="pro_stockstatus <?php echo e($value->stock >= 1 ? 'text-success' : 'text-danger'); ?>">
                                        <?php echo e($value->stock >= 1 ? 'In Stock' : 'Stock Out'); ?>

                                    </div>
                                    <div class="pro_price">
                                            <p><?php if($value->old_price): ?>
                                                 <del><?php echo e($value->old_price); ?>.00৳</del>
                                                <?php endif; ?>
                                                <?php echo e($value->new_price); ?>.00৳
                                            </p>
                                        </div>
                                    
                                </div>
                            </div>

                            <?php if(!$value->prosizes->isEmpty() || !$value->procolors->isEmpty() || ($value->stock < 1)): ?>
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
            <div class="col-sm-12 cntrbtn">
               <div>
                <a href="<?php echo e(route('flashsales')); ?>" class="view_more_btn" style="float:left">View More</a> 
               </div>
            </div>
        </div>
    </div>
    </div>
</section>
<?php endif; ?>
<!--//hot deals-->
<?php if($isHotDealActive): ?>
<section class="homeproduct">
    <div class="max-width">
    <div class="container">
        <div class="row  category-row">
            <div class="col-sm-12">
                <div class="sec_title">
                    
                        <div class="timer_inner">
                            <div class="headtext-for-name-category">
                                <h3 class="section-title-header">
                                <span class="section-title-name">Hot Deal </span>
                                  </h3>
                            </div>

                            <div class="count">
                                <div class="offer_timer" id="simple_timer"></div>
                            </div>
                        </div>
                  
                </div>
            </div>
            <div class="col-sm-12">
                <div class="category-product main_product_inner owl-carousel">
                    <?php $__currentLoopData = $hotdeal_top; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="product_item wist_item">
                            <div class="product_item_inner">
                                <?php if($value->old_price): ?>
                                <div class="sale-badge">
                                    <div class="sale-badge-inner">
                                        <div class="sale-badge-box">
                                            <span class="sale-badge-text">
                                               <?php 
                                                    $disprice = $value->old_price - $value->new_price;
                                                    $discount = $value->old_price > 0 ? ($disprice * 100) / $value->old_price : 0;
                                                ?>
                                                <!-- <p>Save: <?php echo e(number_format($disprice,0)); ?>৳ (<?php echo e(number_format($discount,0)); ?>%)</p> -->
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
                                        <a
                                            href="<?php echo e(route('product', $value->slug)); ?>"><?php echo e(Str::limit($value->name, 50)); ?></a>
                                    </div>
                                        <div class="pro_stockstatus <?php echo e($value->stock >= 1 ? 'text-success' : 'text-danger'); ?>">
                                        <?php echo e($value->stock >= 1 ? 'In Stock' : 'Stock Out'); ?>

                                    </div>
                                    <div class="pro_price">
                                            <p><?php if($value->old_price): ?>
                                                 <del><?php echo e($value->old_price); ?>.00৳</del>
                                                <?php endif; ?>
                                                <?php echo e($value->new_price); ?>.00৳
                                            </p>
                                        </div>
                                </div>
                            </div>

                            <?php if(!$value->prosizes->isEmpty() || !$value->procolors->isEmpty() || ($value->stock < 1)): ?>
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
            <div class="col-sm-12 cntrbtn">
               <div>
                <a href="<?php echo e(route('hotdeals')); ?>" class="view_more_btn" style="float:left">View More</a> 
               </div>
            </div>
        </div>
    </div>
    </div>
</section>
<?php endif; ?>




<?php if($generalsetting && $generalsetting->show_all_products): ?>

<section class="homeproduct">
    <div class="max-width1">

        <div class="col-sm-12">
            <div class="category-row5">
                <!-- <div class="sec_title">
                    <h3 class="section-title-header">
                        <div class="timer_inner">
                            <div class="headtext-for-name-category">
                                <span class="section-title-name">Featured Product</span>
                            </div>
                        </div>
                    </h3>
                </div> -->

                <div class="gradient-bg1 mb-3">
                    <div class="blanksidelayer"></div>
                    <span class="section-title-name">Featured Product</span>
                    
                </div>

                <div class="col-sm-12">
                    <div class="category-product main_product_inner">
                        <?php $__currentLoopData = $all_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="product_item wist_item">
                            <div class="product_item_inner">

                                <?php if($value->old_price): ?>
                                <div class="sale-badge">
                                    <div class="sale-badge-inner">
                                        <div class="sale-badge-box">
                                            <span class="sale-badge-text">
                                                <?php 
                                                    $disprice = $value->old_price - $value->new_price;
                                                    $discount = $value->old_price > 0 ? ($disprice * 100) / $value->old_price : 0;
                                                ?>
                                                <!-- <p>Save: <?php echo e(number_format($disprice,0)); ?>৳ (<?php echo e(number_format($discount,0)); ?>%)</p> -->
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

                                    <div class="quick-view" data-bs-toggle="modal" data-bs-target="#quickViewModal-<?php echo e($value->id); ?>">
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
                                </div> <!-- .pro_img -->

                                <div class="pro_des">

                                    <div class="pro_name">
                                        <a href="<?php echo e(route('product',$value->slug)); ?>"><?php echo e(Str::limit($value->name,50)); ?></a>
                                    </div>

                                    <div class="pro_stockstatus <?php echo e($value->stock >= 1 ? 'text-success' : 'text-danger'); ?>">
                                        <?php echo e($value->stock >= 1 ? 'In Stock' : 'Stock Out'); ?>

                                    </div>


                                    <?php if($value->stock < 1): ?>
                                    <div class="pro_price">
                                        <p>
                                            <del>0.00৳</del>
                                            0.00৳
                                        </p>
                                    </div>
                                    <?php else: ?>
                                    <div class="pro_price">
                                        <p>
                                            <?php if($value->old_price): ?>
                                                <del><?php echo e($value->old_price); ?>.00৳</del>
                                            <?php endif; ?>
                                            <?php echo e($value->new_price); ?>.00৳
                                        </p>
                                    </div>
                                    <?php endif; ?>

                                </div> <!-- .pro_des -->

                            </div> <!-- .product_item_inner -->
                        </div> <!-- .product_item -->
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div> <!-- .category-product -->
                </div> <!-- .col-sm-12 -->

            </div> <!-- .category-row5 -->
        </div> <!-- .col-sm-12 -->

    </div> <!-- .max-width1 -->
</section>

<?php endif; ?>
 
<?php if($sliderbottomads): ?>
<section class="mt-2">
    <div class="max-width">
    <div class="container">
        <div class="row ">
            <?php $__currentLoopData = $sliderbottomads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bottomAds): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-12">
                <a href="<?php echo e($bottomAds->link); ?>?sold=show">
                    <img class="img-fluid" src="<?php echo e($bottomAds->image); ?>"/>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    </div>
</section>
<?php endif; ?>






<?php if($campaognads): ?>
<section>
    <div class="max-width1">
    <div class="container" style="margin-bottom: 10px;">
        <div class="row">
            <?php $__currentLoopData = $campaognads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaignAds): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-12">
                <a href="<?php echo e($campaignAds->link); ?>?sold=show">
                    <img class="img-fluid" src="<?php echo e($campaignAds->image); ?>"/>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    </div>
</section>
<?php endif; ?>
<section>
    
       <div class="sec_title">
                    <div class="gradient-bg">
                        <span>About Shop</span>
                        <div>Inspire and let yourself be inspired, from one unique fashion to another.</div>
                    </div>
                    
                </div>
    <div class="max-width1">

            <div class="row">
               
                <div class="photosec">
    <div class="swiper all-products-swiper">
        <div class="swiper-wrapper">
            <?php $__currentLoopData = $all_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="swiper-slide">
                    <a href="<?php echo e(route('product',$value->slug)); ?>">
                        <img 
                            src="<?php echo e(asset($value->image ? $value->image->image : '')); ?>" 
                            alt="<?php echo e($value->name); ?>" 
                            class="main-hover-img" 
                            loading="lazy"
                        />
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pagination -->
       <div class="antiget">
         <div class="swiper-pagination"></div>
       </div>
    </div>
</div>

                <div class="buttondetails">
                    
                    <div class="card-type">
                        <i class="fa-regular fa-cube"></i>
                  <span class="span-1st">Free Delivery</span>
                  <span class="span-2nd">you Will love at great low prices</span>
                    </div>
                    <div class="card-type">
                       <i class="fa-solid fa-shirt-jersey"></i>
                  <span class="span-1st">Premium Products</span>
                  <span class="span-2nd">Good quality & Premium products </span>
                    </div>
                    <div class="card-type">
                       <i class="fa-solid fa-credit-card-front"></i>
                  <span class="span-1st">Flexible Payment</span>
                  <span class="span-2nd">Payment with Bkash and Credit/Debit Cards</span>
                    </div>
                    <div class="card-type">
                       <i class="fa-solid fa-badge-dollar"></i>
                  <span class="span-1st">Budget Friendly</span>
                  <span class="span-2nd">Budget Friendly & user friendly price</span>
                    </div>
                    <div class="card-type">
                      <i class="fa-solid fa-arrow-u-turn-down-left"></i>
                  <span class="span-1st">3 Days Return</span>
                  <span class="span-2nd">Within 3 days for an exchange</span>
                    </div>
                    <div class="card-type">
                     <i class="fa-solid fa-user-headset"></i>
                  <span class="span-1st">Premium Support</span>
                  <span class="span-2nd">Outstanding premium support</span>
                    </div>
                </div>
            </div>
      
    </div>
</section>

<?php if($reviews->count()>0): ?>
<section class="homeproduct">
    <div class="max-width1">
 
        <div class="row">
            <div class="col-sm-12">
                <div class="category-row5">
                <div class="sec_title">
                    <div class="gradient-bg">
                        <span>Customer Review</span>
                        <div>Hear what they say about us</div>
                    </div>
                    
                </div>
           
            <div class="col-sm-12">
                
                 <div class="swiper all-products-swiper1">
                    <div class="swiper-wrapper customer-review">
                    <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border rounded swiper-slide">
                        <img class="img-fluid w-100" src="<?php echo e(asset($review->image)); ?>" />
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                </div>
            </div>
            </div>
             </div>
        </div>
 
    </div>
</section>
<?php endif; ?>
<section>
    <div class="max-width">
    <div class="container" style="margin-bottom: 10px;">
        <div class="row">
            <?php $__currentLoopData = $footertopads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $footerAds): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-12">
                <a href="<?php echo e($footerAds->link); ?>?sold=show">
                    <img class="img-fluid w-100" src="<?php echo e($footerAds->image); ?>"/>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    </div>
</section>




<?php $__env->stopSection(); ?> <?php $__env->startPush('script'); ?>
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
<script src="<?php echo e(asset('frontEnd/js/owl.carousel.min.js')); ?>"></script>
<!-- jQuery (only ONE time) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="public/frontEnd/js/jquery.syotimer.min.js"></script>







<?php
    $hotDealDate = $generalsetting?->hot_deal_end_date ? $generalsetting->hot_deal_end_date . 'T23:59:59' : null;
    $flashSaleDate = $generalsetting?->flash_sale_end_date ? $generalsetting->flash_sale_end_date . 'T23:59:59' : null;
?>



<script>
$(document).ready(function() {
    // Blade variables safely passed to JS
    let hotDealDate = <?php echo json_encode($hotDealDate, 15, 512) ?>;
    let flashSaleDate = <?php echo json_encode($flashSaleDate, 15, 512) ?>;

    if (hotDealDate) {
        $("#simple_timer").syotimer({
            date: new Date(hotDealDate),
            layout: "hms",
            doubleNumbers: false,
            effectType: "opacity",
            periodUnit: "d",
            periodic: false
        });
    }

    if (flashSaleDate) {
        $("#flash_sale_timer").syotimer({
            date: new Date(flashSaleDate),
            layout: "hms",
            doubleNumbers: false,
            effectType: "opacity",
            periodUnit: "d",
            periodic: false
        });
        
    }

});

</script>





<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".myswiper").forEach(function (el) {
        new Swiper(el, {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 10,
            navigation: {
                nextEl: el.querySelector(".swiper-button-next"),
                prevEl: el.querySelector(".swiper-button-prev"),
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
             breakpoints: {
                200: { slidesPerView: 2 },
                320: { slidesPerView: 2 },
                550: { slidesPerView: 3 },
                768: { slidesPerView: 3 },
                1024: { slidesPerView: 4 },
            },
        });
    });
});

</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const swiper = new Swiper('.all-products-swiper', {
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
            992: { slidesPerView: 4, spaceBetween: 20 },
            1200: { slidesPerView: 5, spaceBetween: 20 },
        },
        autoplay: {
            delay: 2500,       // slide প্রতি 2.5 সেকেন্ডে change হবে
            disableOnInteraction: false, // user swipe করলে autoplay stop হবে না
        }
        
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const swiper = new Swiper('.all-products-swiper1', {
        slidesPerView: 1,
        spaceBetween: 10,
        loop: true,  // scroll speed (time in ms)
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        freeMode: true,
        freeModeMomentum: false, // থামবে না

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
<script>
    $(document).ready(function() {
        $(".main_slider").owlCarousel({
            items: 1,
            loop: true,
            dots: false,
            autoplay: true,
            nav: true,
            autoplayHoverPause: true,
            margin: 0,
            mouseDrag: true,
            smartSpeed: 8000,
            autoplayTimeout: 3000,
            animateOut: "fadeOutRight",
            animateIn: "slideInLeft",

            navText: ["<i class='fa-solid fa-angle-left'></i>",
                "<i class='fa-solid fa-angle-right'></i>"
            ],
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(".hotdeals-slider").owlCarousel({
            margin: 15,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 3,
                    nav: true,
                },
                600: {
                    items: 3,
                    nav: false,
                },
                1000: {
                    items: 6,
                    nav: true,
                    loop: false,
                },
            },
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(".category-slider").owlCarousel({
            margin: 15,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 5,
                    nav: true,
                },
                600: {
                    items: 3,
                    nav: false,
                },
                1000: {
                    items: 8,
                    nav: true,
                    loop: false,
                },
            },
        });

        $(".product_slider").owlCarousel({
            margin: 15,
            items: 6,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2,
                    nav: false,
                },
                600: {
                    items: 5,
                    nav: false,
                },
                1000: {
                    items: 6,
                    nav: false,
                },
            },
        });
        
        $(".flash_sale_slider").owlCarousel({
            margin: 8,
            items: 6,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 3,
                    nav: false,
                },
                600: {
                    items: 6,
                    nav: false,
                },
                1000: {
                    items: 7,
                    nav: false,
                },
            },
        });
        
        $(".category-sliger").owlCarousel({
            margin: 8,
            items: 6,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 3,
                    nav: false,
                },
                600: {
                    items: 6,
                    nav: false,
                },
                1000: {
                    items: 7,
                    nav: false,
                },
            },
        });
        $(".customer-review").owlCarousel({
            margin: 8,
            items: 6,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2,
                    nav: false,
                },
                600: {
                    items: 3,
                    nav: false,
                },
                1000: {
                    items: 5,
                    nav: false,
                },
            },
        });
    });
</script>


   

    <!-- Data Layer End-->
  
    <script>
        function sendSuccess() {
            // size validation
            size = document.forms["formName"]["product_size"].value;
            if (size != "") {
                // access
            } else {
                toastr.warning("Please select any size");
                return false;
            }
            color = document.forms["formName"]["product_color"].value;
            if (color != "") {
                // access
            } else {
                toastr.error("Please select any color");
                return false;
            }
        }
    </script>
    
<?php $__env->stopPush(); ?>

<?php echo $__env->make('frontEnd.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\nmfashion\resources\views/frontEnd/layouts/pages/index.blade.php ENDPATH**/ ?>