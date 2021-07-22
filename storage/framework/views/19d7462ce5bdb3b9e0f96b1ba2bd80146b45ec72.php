<?php $__env->startSection('content'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <h1 class="page-title"><i class="fas fa-list" style="margin-right:5px"></i> Procured Goods</h1>
        <div class="table-settings-icon-wrapper">
            <a data-dateformat="yyyy-mm-dd" href="<?php echo e(url('procured-goods')); ?>" class="open-popup btn btn-success"><i class="fas fa-pencil-alt" style="margin-right:5px"></i> ADD GOODS</a>
        </div>
        <div class="procured-goods">
            <?php echo Form::open(['url' => '', 'method' => 'post', 'id' => 'ListProcuredGoods']); ?>

                <table>
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Office</th>
                            <th>Description</th>
                            <th style="text-align:center">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(sizeof($data) != 0): ?>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="column-control-icons">
                                        <a style="padding:0 5px; color:green" class="inline open-popup" data-dateformat="yyyy-mm-dd" href="<?php echo e(url('/procured-goods?item_id=' . $key->id)); ?>"><i class="fas fa-pencil-alt" style="margin-right:5px; color:green"></i>Edit</a>
                                        <a style="padding:0 5px; color:red" class="inline delete-procured-goods" href="<?php echo e(url('/procured-goods/delete?item_id=' . $key->id)); ?>"><i class="fas fa-trash" style="margin-right:5px; color:red"></i>Delete</a>
                                    </td>
                                    <td>
                                        <?php if($key->region_id == 0 AND $key->province_id == 0): ?>
                                            NPCO
                                        <?php else: ?>
                                            <?php echo e($key->office); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span style="font-weight:bold; font-size:11px; text-transform:uppercase; color:orange"><?php echo e($key->type); ?> (<?php echo e($key->unit_measure); ?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> <?php echo e(number_format($key->quantity, 0)); ?>) • </span>
                                        <span><?php echo e($key->description); ?></span>
                                    </td>
                                    <td style="text-align:center"><?php echo e(number_format($key->quantity * $key->unit_cost, 2)); ?> </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) { 
        getPoContent("<?php echo e(url('po-list/content')); ?>");
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>