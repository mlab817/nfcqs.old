<?php $__env->startSection('content'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <h1 class="page-title"><i class="fa fa-leaf" style="color:green"></i> Commodities by Province</h1>
        <div class="commodity-list">
            <?php if(sizeof($data) != 0): ?>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div style="display:block">
                        <div class="province-name" title="Download in Excel">
                            <?php echo e($key->province); ?>

                            <i class="fas fa-long-arrow-alt-right"></i>
                            <a style="font-weight:normal; font-size:11px" href="<?php echo e(url('province?download=no&model=1&province=' . $key->province)); ?>" title="Logarithmic Time Trend">LOG</a> <span style="font-weight:normal">|</span> <a style="font-weight:normal; font-size:11px; color:green" href="<?php echo e(url('province?download=no&model=2&province=' . $key->province)); ?>" title="Annualized Growth Rate">AGR</a> <span style="font-weight:normal">|</span> <a style="font-weight:normal; font-size:11px; color:orange" href="<?php echo e(url('province?download=no&model=3&province=' . $key->province)); ?>" title="Autoregressive Integrated Moving Average">ARIMA</a>
                        </div>
                    </div>
                    <table style="margin-bottom:50px">
                        <tbody>
                            <?php $__currentLoopData = $key->crops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="commodity-name" style="width:20%"><?php echo e($k->commodity->commodity); ?></td>
                                    <td class="crop-type" style="width:20%"><?php echo e($k->commodity->crop_type); ?></td>
                                    <td style="width:80px"><?php echo e(($k->remarks != null) ? \Illuminate\Support\Str::limit($k->remarks,60) : ''); ?></td>
                                    <td class="actions">
                                        <a href="<?php echo e(route('download_file', ['filePath' => $k->crop_data_filename])); ?>" style="white-space:nowrap" title="Download the file"><i class="fas fa-file-download"></i>Commodity Data</a>
                                        <a href="<?php echo e(route('download_file', ['filePath' => $k->pop_data_filename])); ?>" style="white-space:nowrap" title="Download the file"><i class="fas fa-file-download"></i>Population Growth Rate</a>
                                        <a href="<?php echo e(url('shifter?key=' . $k->id)); ?>" style="white-space:nowrap" class="open-popup"><i class="far fa-play-circle"></i>Run Forecast Models</a>
                                        <?php if($k->remarks != null): ?>
                                            <a href="<?php echo e(url('result?key=' . $k->id)); ?>" style="white-space:nowrap; color:orange"><i class="fas fa-chart-line"></i>View Forecast Result</a>
                                        <?php endif; ?>
                                        <a href="<?php echo e(url('crop/delete?key=' . $k->id)); ?>" class="delete-record" style="white-space:nowrap; color:red"><i class="fas fa-trash"></i>Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tbody>
                    </table>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/nfcqs/resources/views/input/commodities.blade.php ENDPATH**/ ?>