<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>NFCQS</title>
    <?php $noCache = rand(); ?>

    <link href="<?php echo e(asset('/vendor/leaflet-1.3.4/leaflet.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('vendor/bootstrap-4.0.0/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('vendor/font-awesome-5.0.6/web-fonts-with-css/css/fontawesome-all.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('vendor/font-awesome-4.7.0/css/font-awesome.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('vendor/font-awesome-5.11.2/css/all.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('vendor/select-2.4.0/dist/css/select2.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/sidebar.min.css?' . $noCache)); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/app.min.css?' . $noCache)); ?>" rel="stylesheet">
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="<?php echo e(asset('js/utils.min.js')); ?>"></script>
</head>
<body>
    <div id="wrapper" class="toggled">
        <?php echo $__env->make('sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <div class="map-legend">
        <h1>Map Legend</h1>
        <div class="legend-colors">...</div>
    </div>
    <div class="change-map-data">...</div>
    <div class="loading">
        <div class="loading-bar"></div>
        <div class="loading-bar"></div>
        <div class="loading-bar"></div>
        <div class="loading-bar"></div>
    </div>
    <div class="current-user" style="z-index:999">
        <i class="far fa-user"></i>Hi, 
        <span><?php echo e((isset(Auth::user()->full_name)) ? Auth::user()->full_name : 'Guest'); ?></span>
    </div>

    <script src="<?php echo e(asset('/vendor/leaflet-1.3.4/leaflet.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('/vendor/leaflet-1.3.4/plugins/canvas-icon/leaflet-canvasicon.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('/vendor/leaflet-omnivore.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('vendor/jquery-3.2.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/popper/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/bootstrap-4.0.0/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/select-2.4.0/dist/js/select2.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('vendor/sweetalert/dist/sweetalert.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/editable.min.js?' . $noCache)); ?>"></script>
    <script src="<?php echo e(asset('js/app.min.js?' . $noCache)); ?>"></script>

</body>
</html>
<?php /**PATH /Users/marklesterbolotaolo/Desktop/laravel/nfcqs1/resources/views////app.blade.php ENDPATH**/ ?>