<?php echo Form::open(['url' => '', 'method' => 'post', 'id' => 'projectProfile']); ?>

    <table>
        <thead>
            <tr>
                <th class="column-header-action">Actions</th>
                <?php if(sizeof($columns) != 0): ?>
                    <?php for($i = 0; $i < sizeof($columns); $i++): ?>
                        <?php if(strpos(strtoupper($columns[$i]['val']), '-XXX-') !== false): ?>
                            <th style="text-align:center"><?php echo e($columns[$i]['val']); ?></th>
                        <?php else: ?>
                            <th><?php echo e($columns[$i]['val']); ?></th>
                        <?php endif; ?>
                    <?php endfor; ?>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if(sizeof ($details) != 0): ?>
                <?php $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="column-control-icons">
                            <a class="inline" style="padding:0 5px; color:green" href="<?php echo e(url('/profile-project?project_id=' . $key->id)); ?>"><i class="fas fa-pencil-alt" style="margin-right:5px; color:green"></i>Edit</a>
                            <a class="inline delete-project" style="padding:0 5px; color:red" href="<?php echo e(url('/profile/delete-project?project_id=' . $key->id)); ?>"><i class="fas fa-trash" style="margin-right:5px; color:red"></i>Delete</a>
                            <?php if($key->type_id == 2): ?>
                                <a data-dateformat="yyyy-mm-dd" class="inline open-popup" style="padding:0 5px; color:rgb(52, 138, 236)" href="<?php echo e(url('/milestone/pre-procurement?project_id=' . $key->id)); ?>"><i class="fas fa-book" style="margin-right:5px; color:rgb(52, 138, 236)"></i>Pre-Procurement</a>
                                <a data-dateformat="yyyy-mm-dd" class="inline open-popup" style="padding:0 5px; color:orange" href="<?php echo e(url('/milestone/procurement?project_id=' . $key->id)); ?>"><i class="fas fa-cart-arrow-down" style="margin-right:5px; color:orange"></i>Procurement</a>
                            <?php endif; ?>
                        </td>
                        <?php if(sizeof($columns) != 0): ?>
                            <?php for($i = 0; $i < sizeof($columns); $i++): ?>
                                <?php if(is_numeric($key->{$columns[$i]['key']}) OR strpos(strtoupper($columns[$i]['val']), '-XXX-') !== false): ?>
                                    <td style="text-align:center"><?php echo e($key->$columns[$i]['key']); ?></td>
                                <?php else: ?>
                                    <td><?php echo e($key->{$columns[$i]['key']}); ?></td>
                                <?php endif; ?>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </tbody>
    </table>
<?php echo Form::close(); ?>

<div class="project-list-pagination">
    <?php echo $projectList->render(); ?>

</div>