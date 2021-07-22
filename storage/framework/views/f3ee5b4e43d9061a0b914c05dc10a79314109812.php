<?php $__env->startSection('content'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <h1 class="page-title"><i class="fa fa-list" aria-hidden="true"></i> Project Reports</h1>
        <div class="report-list">
            <?php if(sizeof($data) != 0): ?>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row">
                        <div class="col-4"><?php echo e($key->remarks); ?></div>
                        <div class="col-2"><?php echo e(date('F d, Y', strtotime($key->created_at))); ?></div>
                        <div class="col-2"><a href="<?php echo e(url($key->filename)); ?>"><i class="fas fa-file-download"></i>Download</a></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>