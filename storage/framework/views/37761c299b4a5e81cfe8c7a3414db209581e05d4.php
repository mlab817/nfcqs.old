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
                            <a style="font-weight:normal; font-size:11px" href="<?php echo e(url('province?download=no&model=1&key='. $key)); ?>" title="Logarithmic Time Trend">LOG</a> <span style="font-weight:normal">|</span> <a style="font-weight:normal; font-size:11px; color:green" href="<?php echo e(url('province?download=no&model=2&province=' . $key->province)); ?>" title="Annualized Growth Rate">AGR</a> <span style="font-weight:normal">|</span> <a style="font-weight:normal; font-size:11px; color:orange" href="<?php echo e(url('province?download=no&model=3&province=' . $key->province)); ?>" title="Autoregressive Integrated Moving Average">ARIMA</a>
                        </div>
                    </div>
                    <?php $__currentLoopData = $key->crops->groupBy('src_commodity_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div style="display:block" style="margin-top:20px">
                            <?php echo e(\App\Models\SrcCommodity::find($key)->commodity); ?>

                            <i class="fas fa-long-arrow-alt-right"></i>
                            <a style="font-weight:normal; font-size:11px" href="<?php echo e(url('province?download=no&model=1&key='. $key)); ?>" title="Logarithmic Time Trend">LOG</a> <span style="font-weight:normal">|</span> <a style="font-weight:normal; font-size:11px; color:green" href="<?php echo e(url('province?download=no&model=2&province=' . $key)); ?>" title="Annualized Growth Rate">AGR</a> <span style="font-weight:normal">|</span> <a style="font-weight:normal; font-size:11px; color:orange" href="<?php echo e(url('province?download=no&model=3&province=' . $key)); ?>" title="Autoregressive Integrated Moving Average">ARIMA</a>
                        </div>
                        <table style="margin-bottom:20px">
                            <tbody>
                                <?php $__currentLoopData = $k; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="commodity-name" style="width:20%"><?php echo e($c->commodity->commodity); ?></td>
                                        <td class="crop-type" style="width:20%"><?php echo e($c->commodity->crop_type); ?></td>
                                        <td style="width:80px"><?php echo e(($c->remarks != null) ? \Illuminate\Support\Str::limit($c->remarks,60) : ''); ?></td>
                                        <td class="actions">
                                            <a href="<?php echo e(route('download_file', ['filePath' => $c->crop_data_filename])); ?>" style="white-space:nowrap" title="Download the file"><i class="fas fa-file-download"></i>Commodity Data</a>
                                            <a href="<?php echo e(route('download_file', ['filePath' => $c->pop_data_filename])); ?>" style="white-space:nowrap" title="Download the file"><i class="fas fa-file-download"></i>Population Growth Rate</a>
                                            <a href="<?php echo e(url('shifter?key=' . $c->id)); ?>" style="white-space:nowrap" class="open-popup"><i class="far fa-play-circle"></i>Run Forecast Models</a>
                                            <?php if($c->remarks != null): ?>
                                                <a href="<?php echo e(url('result?key=' . $c->id)); ?>" style="white-space:nowrap; color:orange"><i class="fas fa-chart-line"></i>View Forecast Result</a>
                                            <?php endif; ?>
                                            <form action="<?php echo e(route('delete_crop', ['crop' => $c])); ?>" method="POST" id="delete_record_<?php echo e($c->id); ?>">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <a
                                                    onclick="confirm('Are you sure you want to delete this item?'); return document.getElementById('delete_record_<?php echo e($c->id); ?>').submit()"
                                                    href="javascript:{}"
                                                    role="button"
                                                    style="white-space:nowrap; color:red">
                                                    <i class="fas fa-trash"></i>
                                                    Delete
                                                </a>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tbody>
                        </table>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/marklesterbolotaolo/Desktop/laravel/nfcqs/resources/views/input/commodities.blade.php ENDPATH**/ ?>