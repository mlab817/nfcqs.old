<div class="modal fade" id="popupForm" tabindex="-1" role="dialog">
        <div class="modal-dialog <?php echo e(($targetDate != null) ? 'modal-lg' : ''); ?>" role="document">
            <div class="modal-content">
                <?php echo Form::open(['url' => 'milestone/procurement', 'method' => 'post', 'accept-charset' => 'UTF-8', 'id' => 'procurementForm', 'class' => 'popup-form x-load']); ?>

                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"><?php echo e(($targetDate != null) ? 'Procurement Milestone' : 'Can\'t open the form'); ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="response-wrapper">
                            <?php if($targetDate == null): ?>
                                <div class="alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Pre-Procurement must be completed first.</div>
                            <?php endif; ?>
                        </div>
                        <?php if($targetDate != null): ?>
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
                                                    <td class="datepicker-wrapper" style="text-align:center; vertical-align:middle; width:80px; max-width:80px; background-color:#f4f4f4">
                                                        <?php echo Form::text('target_date_' . $key->id, (($key->default != null) ? $key->default->target_date : $targetDate), ['class' => 'tabular-field', 'style' => 'text-align:center', 'readonly' => true]); ?>

                                                    </td>
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
                        <?php endif; ?>
                    </div>
                    <?php if($targetDate != null): ?>
                        <div class="modal-footer">
                            <a data-dateformat="yyyy-mm-dd" class="winning-bidder open-popup" href="<?php echo e(url('/procurement/winning-bidder?project_id=' . $projectId)); ?>" data-dismiss="modal" style="font-size:12px; color:orange; padding-top:3px; display:inline-block; position:relative; margin-right:auto; width:275px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; font-weight:bold; text-transform:uppercase"><i class="fa fa-cog" aria-hidden="true" style="color:green; margin-right:5px"></i>Winning Bidder</a>
                            <?php echo Form::hidden('project_id', $projectId); ?>

                            <?php echo Form::submit('Save', ['class' => 'btn btn-primary']); ?>

                            <?php echo Form::button('Close', ['class' => 'btn btn-danger', 'data-dismiss' => 'modal']); ?>

                        </div>
                    <?php endif; ?>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
    