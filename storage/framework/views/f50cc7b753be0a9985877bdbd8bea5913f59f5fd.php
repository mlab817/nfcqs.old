<div class="modal fade" id="popupForm" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width:800px">
        <div class="modal-content">
            <?php echo Form::open(['url' => 'profile/po-members', 'method' => 'post', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8', 'id' => 'uploadPoMembers', 'class' => 'popup-form x-load-file']); ?>

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Members</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <?php echo Form::file('file', ['style' => 'font-size:12px; width:100%; border-radius:3px']); ?>

                    </div>
                </div>
                <div class="modal-footer">
                    <input name="po_id" value="<?php echo e($poId); ?>" type="hidden" />
                    <span style="font-size:12px; color:#888; padding-top:3px; display:inline-block; position:relative; margin-right:auto; width:275px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap"><i class="fa fa-code" aria-hidden="true" style="color:orange"></i> <?php echo @$poCode[0]; ?></span>
                    <a href="<?php echo e(url($filename)); ?>" target="_blank" style="font-size:12px; color:orange; padding-top:3px; display:inline-block; position:relative; margin-right:auto; width:275px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap"><i class="fa fa-angle-right" aria-hidden="true" style="color:green; margin-right:5px"></i>DOWNLOAD</a>
                    <?php echo Form::submit('Upload', ['class' => 'btn btn-primary']); ?>

                    <?php echo Form::button('Close', ['class' => 'btn btn-danger', 'data-dismiss' => 'modal']); ?>

                </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
