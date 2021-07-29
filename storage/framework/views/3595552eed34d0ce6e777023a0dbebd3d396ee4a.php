<?php $__env->startSection('content'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <h1 class="page-title"><i class="fas fa-info-circle"></i> Forecast Results for the <?php echo e(($province != '...Philippines') ? 'Province of ' . $province : 'Philippines'); ?></h1>
        <?php echo $chart->container(); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    <?php echo $chart->script(); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/marklesterbolotaolo/Desktop/laravel/nfcqs/resources/views/dashboard/province.blade.php ENDPATH**/ ?>