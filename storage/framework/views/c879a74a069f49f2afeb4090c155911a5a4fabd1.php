<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <title>NFCQS</title>
    <?php $noCache = rand(); ?>

	<link href="<?php echo e(asset('vendor/font-awesome-5.0.6/web-fonts-with-css/css/fontawesome-all.min.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('/css/login.min.css?' . $noCache)); ?>" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="<?php echo e(asset('/img/da-logo.png')); ?>" class="login-logo" />
        </div>
        <div class="system-name">
            <h2>NFCQS</h2>
        </div>
        <div class="login-wrapper">
            <?php if(count($errors) > 0): ?>
                <div class="alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><i class="fas fa-angle-right"></i> <?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php else: ?>
                <div class="alert">
                    <strong><i class="fas fa-lock"></i> Login Form</strong>
                </div>
            <?php endif; ?>
            <form method="POST" action="<?php echo e(url('/login')); ?>">
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
                <input type="text" name="email" value="<?php echo e(old('email')); ?>" placeholder="Email" autocomplete="on" />
                <input type="password" name="password" placeholder="Password" autocomplete="off" />
                <input type="submit" value="Sign in" />
            </form>
        </div>
    </div>
</body>
</html>
<?php /**PATH /Users/marklesterbolotaolo/Desktop/laravel/nfcqs1/resources/views/auth/login.blade.php ENDPATH**/ ?>