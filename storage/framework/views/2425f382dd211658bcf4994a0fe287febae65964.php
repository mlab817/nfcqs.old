<?php echo Form::open(['url' => '', 'method' => 'post', 'id' => 'poProfile']); ?>

    <table>
        <thead>
            <tr>
                <th class="column-header-action">Actions</th>
                <?php if(sizeof($columns) != 0): ?>
                    <?php for($i = 0; $i < sizeof($columns); $i++): ?>
                        <?php if(strpos(strtoupper($columns[$i]['val']), 'AREA') !== false OR strpos(strtoupper($columns[$i]['val']), 'DATE') !== false OR strpos(strtoupper($columns[$i]['val']), 'HOUSEHOLD') !== false OR strpos(strtoupper($columns[$i]['val']), 'NO.') !== false): ?>
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
                            <a style="padding:0 5px; color:green" href="<?php echo e(url('/profile-po?po_id=' . $key->id)); ?>"><i class="fas fa-pencil-alt" style="margin-right:5px; color:green"></i>Edit</a>
                            <a style="padding:0 5px; color:red" class="delete-po" href="<?php echo e(url('/profile/delete-po?po_id=' . $key->id)); ?>"><i class="fas fa-trash" style="margin-right:5px; color:red"></i>Delete</a>
                            <a style="padding:0 5px; color:grey" class="open-popup" href="<?php echo e(url('/profile/po-docs?po_id=' . $key->id)); ?>"><i class="fas fa-file-alt" style="margin-right:5px; color:#777"></i>Registration</a>
                            <a style="padding:0 5px; color:orange" class="open-popup" href="<?php echo e(url('/profile/po-members?po_id=' . $key->id)); ?>"><i class="fas fa-book" style="margin-right:5px; color:orange"></i>Members</a>
                            <a style="padding:0 5px; color:rgb(52, 138, 236)" class="open-popup" href="<?php echo e(url('/profile/po-maps?po_id=' . $key->id)); ?>"><i class="fas fa-map-marker" style="margin-right:5px; color:rgb(52, 138, 236)"></i>Maps</a>
                        </td>
                        <?php if(sizeof($columns) != 0): ?>
                            <?php for($i = 0; $i < sizeof($columns); $i++): ?>
                                <?php if(is_numeric($key->{$columns[$i]['key']}) OR strpos(strtoupper($columns[$i]['val']), 'AREA') !== false OR strpos(strtoupper($columns[$i]['val']), 'DATE') !== false OR strpos(strtoupper($columns[$i]['val']), 'HOUSEHOLD') !== false OR strpos(strtoupper($columns[$i]['val']), 'NO.') !== false): ?>
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

<div class="po-list-pagination">
    <?php echo $poList->render(); ?>

</div>