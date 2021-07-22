<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>INREMP - CMIS</title>
    <?php $noCache = rand(); ?>

    <link href="<?php echo e(asset('vendor/bootstrap-4.0.0/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('vendor/datepicker-0.6.3/docs/css/datepicker.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('vendor/font-awesome-5.0.6/web-fonts-with-css/css/fontawesome-all.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('vendor/font-awesome-4.7.0/css/font-awesome.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('vendor/select-2.4.0/dist/css/select2.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/sidebar.css?' . $noCache)); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/geotag.css? ' . $noCache)); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/app.css?' . $noCache)); ?>" rel="stylesheet">

    <script src="<?php echo e(asset('js/utils.js')); ?>"></script>
</head>
<body>
    <div id="wrapper" class="toggled">
        <?php echo $__env->make('sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <!-- Loading ... -->
    <div class="loading">
        <div class="loading-bar"></div>
        <div class="loading-bar"></div>
        <div class="loading-bar"></div>
        <div class="loading-bar"></div>
    </div>

    <!-- Active User -->
    <div class="current-user" style="z-index:999">
        <i class="far fa-user"></i>Hi, <span><?php echo Auth::user()->full_name ?></span>
    </div>

    <!--- Report Icons -->
    <div class="report-icons">
        <a href="<?php echo e(url('report/physical-progress')); ?>">Physical</a>
        <a href="<?php echo e(url('report/financial-progress')); ?>">Financial</a>
    </div>

    <!-- More Menus -->
    <?php echo $__env->make('more-menus', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <script src="<?php echo e(asset('vendor/jquery-3.2.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/popper/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/bootstrap-4.0.0/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/datepicker-0.6.3/docs/js/datepicker.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('vendor/select-2.4.0/dist/js/select2.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('vendor/chart-2.7.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/exif-2.3.0.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/sweetalert/dist/sweetalert.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/geotag.js?' . $noCache)); ?>"></script>
    <script src="<?php echo e(asset('js/editable.js?' . $noCache)); ?>"></script>
    <script src="<?php echo e(asset('js/app.js?' . $noCache)); ?>"></script>
</body>
</html>
