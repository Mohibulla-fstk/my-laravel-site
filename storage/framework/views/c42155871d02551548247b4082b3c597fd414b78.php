

<?php $__env->startSection('title','Wishlist'); ?>

<?php $__env->startSection('content'); ?>
<div class="blankspace"></div>

<div class="gradient-bg">
    <span>My Wishlist</span>
</div>

<div class="container py-4">
<h3>My Wishlist</h3> 
    <?php if(count($wishlist) > 0): ?>
        <div class="row">
            <?php $__currentLoopData = $wishlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-3 wishlist-item" data-id="<?php echo e($item['id']); ?>">
                    <div class="product_item wist_item">
                        <div class="product_item_inner">

                            <div class="pro_img">
                                
                                <a href="<?php echo e(route('product', $item['slug'])); ?>">
                                    <img 
                                        src="<?php echo e(asset($item['image'])); ?>" 
                                        alt="<?php echo e($item['name']); ?>" 
                                        class="main-img"
                                    >
                                </a>

                                
                                <?php if(!empty($item['second_image'])): ?>
                                <a href="<?php echo e(route('product', $item['slug'])); ?>">
                                    <img 
                                        src="<?php echo e(asset($item['second_image'])); ?>" 
                                        alt="<?php echo e($item['name']); ?> hover" 
                                        class="hover-img"
                                    >
                                </a>
                                <?php endif; ?>

                                
                                <div class="quick-view" data-bs-toggle="modal" data-bs-target="#quickViewModal-<?php echo e($item['id']); ?>">
                                    <span>Quick View</span>
                                    
                                    <div class="sizeShowproduct">
                                        <?php if(!empty($item['prosizes']) && count($item['prosizes']) > 0): ?>
                                            <?php $__currentLoopData = $item['prosizes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span><?php echo e($size['sizeName'] ?? '-'); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>


                            <div class="pro_des text-left">
                                <div class="pro_name">
                                    <a href="<?php echo e(route('product', $item['slug'])); ?>">
                                        <?php echo e(Str::limit($item['name'], 40)); ?>

                                    </a>
                                </div>
                                    <div class="pro_stockstatus <?php echo e(($item['stock'] ?? 0) >= 1 ? 'text-success' : 'text-danger'); ?>">
                                    <?php echo e(($item['stock'] ?? 0) >= 1 ? 'In Stock' : 'Stock Out'); ?>

                                    
                                </div>

                               
                                 <?php if($item['stock'] < 1): ?>
                                    <div class="pro_price">
                                        <p>
                                            <del>0.00৳</del>
                                            0.00৳
                                        </p>
                                    </div>
                                    <?php else: ?>
                                    <div class="pro_price">
                                        <p>
                                            <?php if($item['old_price']): ?>
                                                <del><?php echo e($item['old_price']); ?>.00৳</del>
                                            <?php endif; ?>
                                            <?php echo e($item['new_price']); ?>.00৳
                                        </p>
                                    </div>
                                    <?php endif; ?>

                                <button 
                                    class="wishlist-toggle-remove btn btn-sm btn-danger mt-2"
                                    data-product-id="<?php echo e($item['id']); ?>"
                                >
                                    Remove 
                                </button>
                                
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            
            <div style="display: flex;flex-direction:column">
                <span style="font-size: 30px;font-weight:500">Wishlist is empty !</span>
            <span>You don't have any products in the wishlist yet. You will find a lot of interesting products on our "Shop" page.</span>
            <div style="margin-top: 20px">
                <a href="<?php echo e(route('home')); ?>">
                <span class="span-class4">Return to shop <i
                                    class="fa-solid fa-arrow-right"></i></span></a>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).on('click', '.wishlist-toggle-remove', function(e){
    e.preventDefault();

    let btn = $(this);
    let productId = btn.data('product-id');

    $.ajax({
        url: "<?php echo e(route('wishlist.toggle')); ?>",
        type: "POST",
        data: {
            _token: "<?php echo e(csrf_token()); ?>",
            product_id: productId
        },
        success: function(res){

            if(res.status === 'removed'){
                // Instant remove from DOM using data-id
                $('.wishlist-item[data-id="'+productId+'"]').fadeOut(300, function(){
                    $(this).remove();

                    // Empty wishlist message
                    if($('.wishlist-item').length === 0){
                        $('.container.py-4').html(`<div class="text-center py-5">
            
            <div style="display: flex;flex-direction:column">
                <span style="font-size: 30px;font-weight:500">Wishlist is empty !</span>
            <span>You don't have any products in the wishlist yet. You will find a lot of interesting products on our "Shop" page.</span>
            <div style="margin-top: 20px">
                <a href="<?php echo e(route('home')); ?>">
                <span class="span-class4">Return to shop <i
                                    class="fa-solid fa-arrow-right"></i></span></a>
                </div>
            </div>
        </div>`);
                    }
                });
            }

            // Update header wishlist count live
            if($('.wishlist-count-top').length){
                $('.wishlist-count-top').text(res.count);
            }

        },
        error: function(err){
            console.log(err);
            alert('Failed to remove product from wishlist!');
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontEnd.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\nmfashion\resources\views/frontEnd/layouts/pages/wishlist.blade.php ENDPATH**/ ?>