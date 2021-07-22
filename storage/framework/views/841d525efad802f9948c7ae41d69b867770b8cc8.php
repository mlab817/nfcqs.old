<div class="modal fade" id="popupForm" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" style="width:800px">
            <div class="modal-content">
                <?php echo Form::open(['url' => 'profile/po-docs', 'method' => 'post', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8', 'id' => 'uploadPoMaps', 'class' => 'popup-form x-load-file']); ?>

                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Registration Documents</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <?php if(sizeof($docs) != 0): ?>
                            <div class="row">
                                <table>
                                    <tbody>
                                        <?php $__currentLoopData = $docs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($key->remarks); ?></td>
                                                <td class="column-control-icons" style="text-align:center; vertical-align:middle">
                                                    <a href="<?php echo e(url($key->filename)); ?>" target="_blank" style="color:green; display:inline-block; margin-right:5px"><i class="fa fa-arrow-circle-o-down" aria-hidden="true" style="margin-right:5px"></i>View</a>
                                                    <a href="<?php echo e(url('profile/po-docs-delete?file_id=' . $key->id . '&po_id=' . $poId)); ?>" class="delete-po-uploads" style="color:red; display:inline-block"><i class="fa fa-trash" aria-hidden="true" style="margin-right:5px"></i>Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                        <div class="row">
                            <label>PDF | JPEG File</label>
                            <?php echo Form::file('file', ['style' => 'font-size:12px; width:100%; border-radius:3px']); ?>

                        </div>
                        <div class="row">
                            <label>Remarks</label>
                            <?php echo Form::textarea('remarks', '', ['class' => 'form-control', 'rows' => '3']); ?>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input name="po_id" value="<?php echo e($poId); ?>" type="hidden" />
                        <span style="font-size:12px; color:#888; padding-top:3px; display:inline-block; position:relative; margin-right:auto; width:275px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap"><i class="fa fa-code" aria-hidden="true" style="color:orange"></i> <?php echo @$poCode[0]; ?></span>
                        <?php echo Form::submit('Upload', ['class' => 'btn btn-primary']); ?>

                        <?php echo Form::button('Close', ['class' => 'btn btn-danger', 'data-dismiss' => 'modal']); ?>

                    </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
    