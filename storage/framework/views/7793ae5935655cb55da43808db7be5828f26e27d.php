<?php $__env->startSection('content'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <h1 class="page-title"><i class="fas fa-map-marker-alt" style="color:orange"></i> Geotag Albums</h1>
        <div class="contract-details">
            <table>
                <thead>
                    <tr>
                        <th>Contract Code</th>
                        <th>Contract Type</th>
                        <th>Contractor</th>
                        <th>Contract Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="color"><span style="letter-spacing:1px; padding:3px 5px; background-color:orange; color:#fff; font-size:10px; font-weight:bold; border-radius:3px 3px 3px 3px"><?php echo e($details->contract_code); ?></span></td>
                        <td><?php echo e($details->contract_type); ?></td>
                        <td><?php echo e($details->contractor_name); ?></td>
                        <td><?php echo e(number_format($details->contract_cost, 2)); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="geotag-albums">
            <a href="<?php echo e(url('geotag/album?albumId=0&contractId=' . $contractId)); ?>" class="create-album open-popup" title="Create new album"><i class="far fa-image"></i></a>
            <?php if(sizeof($albums) != 0): ?>
                <?php $__currentLoopData = $albums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($key->photo != null): ?>
                        <a href="<?php echo e(url('geotag/album?albumId=' . $key->id . '&contractId=' . $contractId)); ?>" class="album no-border-thumb open-popup" title="View album photos" style="background:url('<?php echo e(url('uploads/geotag/img/thumbnail/' . $key->photo)); ?>') no-repeat; background-size: cover">
                            <b><?php echo e(date('M d, Y', strtotime($key->report_date))); ?></b>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(url('geotag/album?albumId=' . $key->id . '&contractId=' . $contractId)); ?>" class="album no-border-thumb open-popup" title="View album photos" style="background:url('<?php echo e(asset('img/shapefile.png')); ?>') no-repeat; background-size: cover">
                                <b><?php echo e(date('M d, Y', strtotime($key->report_date))); ?></b>
                            </a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
        <div style="clear:both"></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>