<?php $__env->startSection('content'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <h1 class="page-title"><i class="fas fa-photo-video" style="color:green"></i> Geotag Albums</h1>
        <div class="contract-details">
            <div class="info-wrapper">Contract Code: <b><?php echo e($details->contract_code); ?></b></div>
            <div class="info-wrapper">Contract Type: <?php echo e($details->contract_type); ?></div>
            <div class="info-wrapper">Contractor: <?php echo e($details->contractor_name); ?></div>
            <div class="info-wrapper">Contract Cost: <b><?php echo e(number_format($details->contract_cost, 2)); ?></b></div>
        </div>
        <div class="geotag-albums">
            <div style="display:block; margin-bottom:25px">
                <a href="<?php echo e(url('geotag/album?albumId=0&contractId=' . $contractId)); ?>" class="create-album open-popup" title="Create new album" data-dateformat="yyyy-mm-dd"><i class="far fa-image"></i></a>
                <div style="clear:both"></div>
            </div>
            <div style="display:block; margin-bottom:25px">
                <?php if(sizeof($albums) != 0): ?>
                    <?php $__currentLoopData = $albums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(url('geotag/album?albumId=' . $key->id . '&contractId=' . $contractId)); ?>" class="album no-border-thumb open-popup" title="View album photos" style="background:url('<?php echo e(url('uploads/geotag/img/thumbnail/' . $key->photo)); ?>') no-repeat; background-size: cover" data-dateformat="yyyy-mm-dd">
                            <b><?php echo e(date('M d, Y', strtotime($key->report_date))); ?></b>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                <div style="clear:both"></div>
            </div>
            <div style="display:block">
                <?php if(sizeof($kmls) != 0): ?>
                    <?php $__currentLoopData = $kmls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(url('geotag/album?albumId=' . $key->id . '&contractId=' . $contractId)); ?>" class="album no-border-thumb open-popup" title="View album photos" style="background:url('<?php echo e(asset('img/shapefile.png')); ?>') no-repeat; background-size: cover" data-dateformat="yyyy-mm-dd">
                            <b><?php echo e(date('M d, Y', strtotime($key->report_date))); ?></b>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                <div style="clear:both"></div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>