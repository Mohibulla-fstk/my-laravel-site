<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: none; border: none;">

            <div class="modal-body">
                <div class="form-content">
                    <p class="auth-title">User Login </p>
                    <form action="<?php echo e(route('customer.signin')); ?>" method="POST" data-parsley-validate="">
                        <?php echo csrf_field(); ?>
                        <div class="form-group mb-3">
                            <input type="number" id="phone" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                name="phone" value="<?php echo e(old('phone')); ?>" required>
                            <label class="phonelabel" for="phone">Phone Number</label>
                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <!-- col-end -->

                        <div class="form-group mb-3">
                            <input type="password" id="password"
                                class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password"
                                value="<?php echo e(old('password')); ?>" required>
                            <label class="passlabel" for="password">Password</label>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <!-- col-end -->

                        <a href="<?php echo e(route('customer.forgot.password')); ?>" class="forget-link">
                            <i class="fa-solid fa-unlock"></i> Forget Password?
                        </a>

                        <div class="form-group mb-3">
                            <button class="submit-btn"> Login </button>
                        </div>
                        <!-- col-end -->
                    </form>

                    <div class="register-now no-account">
                        <p>No any account? </p>
                        <a data-bs-toggle="modal" data-bs-target="#signupModal"><i data-feather="edit-3"></i> Sign
                            Up</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\nmfashion\resources\views/partials/login-modal.blade.php ENDPATH**/ ?>