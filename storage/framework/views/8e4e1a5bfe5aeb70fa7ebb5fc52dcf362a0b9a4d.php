<?php $__env->startSection('content'); ?>
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <h1 class="page-title"><i class="fa fa-leaf" style="color:green"></i> Official Production Data for <?php echo e($data->commodity); ?></h1>

            <?php echo Form::open(['url' => route('official_data.index'), 'method' => 'get', 'accept-charset' => 'UTF-8', 'id' => 'selectCommodityForm']); ?>

                <div class="row">
                    <div class="col-12">
                        <label>Commodity</label>
                        <?php echo Form::select('commodity_id', $commodities, $commodity_id, ['id' => 'commodity_id','class' => 'form-control']); ?>

                    </div>
                </div>
            <?php echo Form::close(); ?>


            <div class="commodity-list">
                <table style="margin-bottom:20px">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Province</th>
                            <th class="text-right">Production</th>
                            <th class="text-right">Area Harvested</th>
                            <th class="text-right">Yield</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $data->official_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="commodity-name" style="width:20%"><?php echo e($d->year); ?></td>
                                <td class="commodity-name" style="width:20%"><?php echo e(optional($d->province)->province); ?></td>
                                <td class="crop-type text-right" style="width:20%"><?php echo e(number_format($d->production, 2)); ?></td>
                                <td class="text-right"><?php echo e(number_format($d->area_harvested, 2)); ?></td>
                                <td class="text-right"><?php echo e(number_format($d->yield, 2)); ?></td>
                                <td class="actions">
                                    <form action="<?php echo e(route('official_data.destroy', ['id' => $d->id])); ?>" method="POST" id="delete_record_<?php echo e($d->id); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <a
                                            onclick="confirm('Are you sure you want to delete this item?'); return document.getElementById('delete_record_<?php echo e($d->id); ?>').submit()"
                                            href="javascript:{}"
                                            role="button"
                                            style="white-space:nowrap; color:red">
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </a>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td class="text-center" colspan="6">No data. Click Upload Data in the sidebar to upload data</td>
                            </tr>
                        <?php endif; ?>
                    <tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function () {
            const commodityId = $('#commodity_id')
            commodityId.on('change', function () {
                $('#selectCommodityForm').submit();
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lester/projects/nfcqs/resources/views/official-data.blade.php ENDPATH**/ ?>