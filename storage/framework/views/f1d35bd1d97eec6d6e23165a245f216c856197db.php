<div class="modal fade" id="popupForm" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document" style="width:860px">
        <div class="modal-content">
            <?php echo Form::open(['url' => 'contract/remarks', 'method' => 'post', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8', 'id' => 'saveRemarks', 'class' => 'popup-form x-load-file', 'data-goto' => url('contracts')]); ?>

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Contract Remarks</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" style="background-color:#f4f4f4">
                    <?php if(sizeof($remarks) != 0): ?>
                        <div class="row" style="margin-bottom:25px">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Responsible Office</th>
                                        <th>Remarks</th>
                                        <th>Remarks From</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $remarks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td style="width:150px; text-align:center"><?php echo e($key->responsible_office); ?></td>
                                            <td><?php echo e($key->remarks); ?></td>
                                            <td style="width:250px; line-height:11px; text-align:center">
                                                <?php if(sizeof($key->watershed) != 0): ?>
                                                    <b style="font-size:10px; text-transform:uppercase; font-weight:bold">SUSIMO <?php echo e($key->watershed[0]); ?></b>
                                                <?php elseif($key->province != null): ?>
                                                    <b style="font-size:10px; text-transform:uppercase; font-weight:bold">PPMO <?php echo e($key->province); ?></b>
                                                <?php elseif($key->region != null): ?>
                                                    <b style="font-size:10px; text-transform:uppercase; font-weight:bold">RPMO <?php echo e($key->region); ?></b>
                                                <?php else: ?>
                                                    <b style="font-size:10px; text-transform:uppercase; font-weight:bold">CPMO</b>
                                                <?php endif; ?>
                                                <span style="display:block; font-size:11px; padding:4px 5px; border-top:1px solid #ddd; border-bottom:1px solid #ddd; margin:2px 0; background-color:#f4f4f4">Encoded By: <?php echo e($key->user); ?></span>
                                                <span style="color:#777; font-size:10px"><?php echo e(date('F d, Y', strtotime($key->created_at))); ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <label>Responsible Office:</label>
                        <?php echo Form::select('responsible_office', ['' => '', 'CPMO' => 'CPMO', 'RPMO' => 'RPMO', 'PPMO' => 'PPMO', 'CENRO' => 'CENRO', 'SUSIMO' => 'SUSIMO', 'LGU' => 'LGU', 'PO' => 'PO', 'NCIP' => 'NCIP', 'OTHERS' => 'OTHERS'], '', ['class' => 'form-control', 'style' => 'font-size:12px; width:100%']); ?>

                    </div>
                    <div class="row">
                        <label>Remarks:</label>
                        <?php echo Form::textarea('remarks', '', ['class' => 'form-control', 'style' => 'font-size:12px; width:100%', 'rows' => '3']); ?>

                    </div>
                </div>
                <div class="modal-footer">
                    <span style="font-size:12px; color:#888; padding-top:3px; display:inline-block; position:relative; margin-right:auto; width:275px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap"><i class="fa fa-code" aria-hidden="true" style="color:orange"></i> <?php echo @$contractCode[0]; ?></span>
                    <?php echo Form::submit('Save', ['class' => 'btn btn-primary']); ?>

                    <?php echo Form::button('Close', ['class' => 'btn btn-danger', 'data-dismiss' => 'modal']); ?>

                </div>
                <input name="contract_id" value="<?php echo e($contractId); ?>" type="hidden" />
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
