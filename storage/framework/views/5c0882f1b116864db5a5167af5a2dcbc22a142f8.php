<?php $__env->startSection('content'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <h1 class="page-title"><i class="fas fa-info-circle"></i> List of System Users</h1>
        <table>
            <thead>
                <tr>
                    <th>Office</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th style="text-align:center">Status</th>
                    <th style="text-align:center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(sizeof($users) != 0): ?>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                        <tr>
                            <td><?php echo e($key->office); ?></td>
                            <td><?php echo e($key->full_name); ?></td>
                            <td><?php echo e($key->email); ?></td>
                            <td style="text-align:center"><?php echo ($key->is_active == 0) ? '<span style="color:#fff; background-color:orange; padding:3px 5px; border-radius:3px; font-weight:bold; font-size:10px; text-transform:uppercase">Inactive</span>' : '<span style="color:#fff; background-color:green; padding:3px 5px; border-radius:3px; font-weight:bold; font-size:10px; text-transform:uppercase">Active</span>'; ?></td>
                            <td style="text-align:center; font-weight:bold; font-size:11px; text-transform:uppercase">
                                <a href="<?php echo e(url('user/edit?id=' . $key->id)); ?>" style="color:green; margin-right:4px; padding-right:5px; border-right:1px solid #ddd">Edit</a>
                                
                                <?php if($key->is_active == 0): ?>
                                    <a href="<?php echo e(url('user/access?action=1&id=' . $key->id)); ?>" style="color:orange; margin-right:4px; padding-right:5px; border-right:1px solid #ddd">Activate</a>
                                <?php else: ?>
                                    <a href="<?php echo e(url('user/access?action=0&id=' . $key->id)); ?>" style="color:orange; margin-right:4px; padding-right:5px; border-right:1px solid #ddd">Deactivate</a>
                                <?php endif; ?>

                                <a href="<?php echo e(url('user/delete?id=' . $key->id)); ?>" class="delete-record" style="color:red">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>