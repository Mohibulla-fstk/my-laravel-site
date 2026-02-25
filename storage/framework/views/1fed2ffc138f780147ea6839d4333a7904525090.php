
<?php $__env->startSection('title', 'Combo Manager'); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(asset('/public/backEnd/')); ?>/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css"
        rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('/public/backEnd/')); ?>/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css"
        rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('/public/backEnd/')); ?>/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css"
        rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('/public/backEnd/')); ?>/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css"
        rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <!-- start Combo title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="<?php echo e(route('combos.create')); ?>" class="btn btn-primary rounded-pill">Create</a>
                    </div>
                    <h4 class="page-title">Combo Manage</h4>
                </div>
            </div>
        </div>
        <!-- end Combo title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Action</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Image</th>
                                        <th>Min Products</th>
                                        <th>Max Products</th>
                                        <th>Price</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $__currentLoopData = $combos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $combo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td>
                                                <div class="button-list">
                                                    <?php if($combo->status): ?>
                                                        <form action="<?php echo e(route('combo.inactive')); ?>" method="POST"
                                                            style="display:inline;">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="id" value="<?php echo e($combo->id); ?>">
                                                            <button type="submit"
                                                                class="change-confirm btn btn-xs btn-secondary waves-effect waves-light">
                                                                <i class="fe-thumbs-down"></i></button>
                                                        </form>
                                                    <?php else: ?>
                                                        <form action="<?php echo e(route('combo.active')); ?>" method="POST"
                                                            style="display:inline;">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="id" value="<?php echo e($combo->id); ?>">
                                                            <button type="submit"
                                                                class="change-confirm btn btn-xs btn-success waves-effect waves-light">
                                                                <i class="fe-thumbs-up"></i></button>
                                                        </form>
                                                    <?php endif; ?>


                                                    <a href="<?php echo e(route('combos.edit', $combo->id)); ?>"
                                                        class="btn btn-xs btn-primary waves-effect waves-light">
                                                        <i class="fe-edit-1"></i>
                                                    </a>

                                                    <form method="post" action="<?php echo e(route('combos.destroy', $combo->id)); ?>"
                                                        class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit"
                                                            class="btn btn-xs btn-danger waves-effect waves-light delete-confirm"><i
                                                                class="fe-trash-2"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td><?php echo e($combo->name); ?></td>
                                            <td><?php echo e($combo->category->name ?? '-'); ?></td>
                                            <td>
                                                <?php if($combo->images->isNotEmpty()): ?>
                                                    <img src="<?php echo e(asset($combo->images->first()->image)); ?>" class="backend-image"
                                                        alt="Combo Image" style="border-radius: 0;width:80px;height:100%">
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($combo->min_products); ?></td>
                                            <td><?php echo e($combo->max_products); ?></td>
                                            <td><?php echo e(number_format($combo->price, 2)); ?></td>
                                            <td><?php if($combo->status == 1): ?><span
                                                class="badge bg-soft-success text-success">Active</span>
                                            <?php else: ?>
                                                    <span class="badge bg-soft-danger text-danger">Inactive</span>
                                                <?php endif; ?>
                                            </td>



                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".checkall").on('change', function () {
                $(".checkbox").prop('checked', $(this).is(":checked"));
            });

            $(document).on('click', '.hotdeal_update', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                console.log('url', url);
                var product = $('input.checkbox:checked').map(function () {
                    return $(this).val();
                });
                var product_ids = product.get();
                if (product_ids.length == 0) {
                    toastr.error('Please Select A Product First !');
                    return;
                }
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: { product_ids },
                    success: function (res) {
                        if (res.status == 'success') {
                            toastr.success(res.message);
                            window.location.reload();
                        } else {
                            toastr.error('Failed something wrong');
                        }
                    }
                });
            });
            $(document).on('click', '.update_status', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var product = $('input.checkbox:checked').map(function () {
                    return $(this).val();
                });
                var product_ids = product.get();
                if (product_ids.length == 0) {
                    toastr.error('Please Select A Product First !');
                    return;
                }
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: { product_ids },
                    success: function (res) {
                        if (res.status == 'success') {
                            toastr.success(res.message);
                            window.location.reload();
                        } else {
                            toastr.error('Failed something wrong');
                        }
                    }
                });
            });
            $(document).on('click', '.update_status', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var product = $('input.checkbox:checked').map(function () {
                    return $(this).val();
                });
                var product_ids = product.get();
                if (product_ids.length == 0) {
                    toastr.error('Please Select A Product First !');
                    return;
                }
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: { product_ids },
                    success: function (res) {
                        if (res.status == 'success') {
                            toastr.success(res.message);
                            window.location.reload();
                        } else {
                            toastr.error('Failed something wrong');
                        }
                    }
                });
            });


        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backEnd.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\nmfashion\resources\views/backEnd/combos/index.blade.php ENDPATH**/ ?>