<div class="modal fade" id="popupForm" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?php echo Form::open(['url' => 'milestone/pre-procurement', 'method' => 'post', 'accept-charset' => 'UTF-8', 'id' => 'preProcurementForm', 'class' => 'popup-form x-load']); ?>

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Pre-Procurement Milestone</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="response-wrapper"></div>
                    <table>
                        <thead>
                            <tr>
                                <th rowspan="2" colspan="2">Milestone</th>
                                <th colspan="2">Date <span style="font-weight:normal; color:orange"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> Year-Month-Day</span></th>
                                <th rowspan="2">Remarks</th>
                            </tr>
                            <tr>
                                <th>Target</th>
                                <th>Actual</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(sizeof($milestones) != 0): ?>
                                <?php $i = 1; ?>
                                <?php $__currentLoopData = $milestones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td style="text-align:right; width:20px; vertical-align:middle"><?php echo e($i); ?></td>
                                        <td style="width:35%; vertical-align:middle">
                                            <?php echo e($key->milestone); ?>

                                            <?php echo Form::hidden('remarks_' . $key->id, (($key->default != null) ? $key->default->remarks : '')); ?>

                                            <?php echo Form::hidden('no_days_' . $key->id, $key->no_days); ?>

                                        </td>
                                        <?php if($i != 1): ?>
                                            <td style="text-align:center; vertical-align:middle; width:80px; max-width:80px">
                                                <?php echo Form::text('target_date_' . $key->id, (($key->default != null) ? $key->default->target_date : ''), ['class' => 'tabular-field', 'style' => 'text-align:center', 'readonly' => true]); ?>

                                            </td>
                                        <?php else: ?>
                                            <td class="datepicker-wrapper" style="text-align:center; vertical-align:middle; width:80px; max-width:80px; background-color:#f4f4f4"></td>
                                        <?php endif; ?>
                                        <td class="datepicker-wrapper" style="text-align:center; vertical-align:middle; width:80px; max-width:80px">
                                            <?php echo Form::text('actual_date_' . $key->id, (($key->default != null) ? $key->default->actual_date : ''), ['class' => 'tabular-field pick-date ' . (($i == 1) ? 'trigger-milestone' : ''), 'style' => 'text-align:center', 'autocomplete' => 'off']); ?>

                                        </td>
                                        <td id="remarks_<?php echo e($key->id); ?>" contenteditable="true" class="col-editable " style="width:35%; vertical-align:middle">
                                            <?php echo (($key->default != null) ? $key->default->remarks : ''); ?>

                                        </td>
                                    </tr>
                                    <?php ++$i; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <?php echo Form::hidden('project_id', $projectId); ?>

                    <?php echo Form::submit('Save', ['class' => 'btn btn-primary']); ?>

                    <?php echo Form::button('Close', ['class' => 'btn btn-danger', 'data-dismiss' => 'modal']); ?>

                </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
