<!doctype html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta name="csrf-token" content="igEtQwGfz0hpKoVDnpDYhEg17PsP86VmBfjfpIDl">

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <?php if($generalsetting && $generalsetting->favicon): ?>
        <link rel="shortcut icon" href="<?php echo e(asset($generalsetting->favicon)); ?>" />
    <?php endif; ?>

    <title>Admin Login | <?php echo e(optional($generalsetting)->name ?? 'YourSiteName'); ?></title>


    <!-- google font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.0/css/all.css">
    <!-- aiz core css -->
    <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/assets_login/css/vendors.css">
    <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/assets_login/css/aiz-core.css">

    <style>
        
        body {
            font-size: 12px;
            font-family: 'Poppins';
        }
        .dot-bg {
            background-image: radial-gradient(#a583ea4d 1.5px, #0000 0);
            background-size: 20px 20px;
            position: relative;
        }
        .password-toggle {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            font-size: 16px;
        }

        .password-toggle:hover {
            color: #000;
        }
        .text-reset:hover{
            text-decoration: underline
        }

    </style>

</head>

<body class="">

    <div class="aiz-main-wrapper d-flex dot-bg">
        <div class="flex-grow-1">

            <div class="h-100 bg-cover bg-center py-5 d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-xl-4 mx-auto">
                            <div class="card text-left">
                                <div class="card-body">
                                    <div class="mb-5 text-center">
                                        <img src="<?php echo e(asset(optional($generalsetting)->dark_logo ?? 'default-logo.png')); ?>"
                                            class="mw-100 mb-4" height="40">

                                        <h1 class="h3 text-primary mb-0">Welcome to
                                            <?php echo e(optional($generalsetting)->name ?? 'My Website'); ?>

                                        </h1>

                                        <p>Login to your account.</p>
                                    </div>
                                    <?php if(session('status')): ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <?php echo e(session('status')); ?>

                                        
                                        </div>
                                    <?php endif; ?>

                                    <form method="POST" action="<?php echo e(route('login')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <div class="form-group">
                                            <input id="email" type="email"
                                                class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email"
                                                value="<?php echo e(old('email')); ?>" required autofocus placeholder="Email">
                                            <?php $__errorArgs = ['email'];
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
                                        <div class="form-group position-relative">
                                            <input id="password" type="password"
                                                class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="password" value="<?php echo e(old('password')); ?>" required spellcheck="false"
                                                placeholder="Password" oninput="handlePasswordInput()" >

                                            <span class="password-toggle" id="passwordToggle"
                                                onclick="togglePassword()" style="display:none;">
                                                <i id="toggleIcon" class="fa fa-eye"></i>
                                            </span>


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

                                        <div class="row mb-2">
                                            <div class="col-sm-6">
                                                <div class="text-left">
                                                    <label class="aiz-checkbox">
                                                        <input type="checkbox" name="remember" id="checkbox-signin"
                                                            value="1">
                                                        <span>Remember Me</span>
                                                        <span class="aiz-square-check"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="text-right">
    <a href="<?php echo e(route('password.request')); ?>" class="text-reset fs-14">Forgot password ?</a>
</div>

                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            Login
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .aiz-main-wrapper -->



    <script src="<?php echo e(asset('public/backEnd/')); ?>/assets_login/js/vendors.js"></script>
    <script src="<?php echo e(asset('public/backEnd/')); ?>/assets_login/js/aiz-core.js"></script>
<script>
function handlePasswordInput() {
    const input = document.getElementById('password');
    const toggle = document.getElementById('passwordToggle');
    const icon = document.getElementById('toggleIcon');

    if (input.value.length > 0) {
        toggle.style.display = 'block';
    } else {
        toggle.style.display = 'none';
        input.type = 'password';
        icon.className = 'fa fa-eye';
    }
}

function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');

    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fa fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fa fa-eye';
    }
}
</script>



    

</body>

</html><?php /**PATH C:\xampp\htdocs\nmfashion\resources\views/backEnd/auth/login.blade.php ENDPATH**/ ?>