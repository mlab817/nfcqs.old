<div class="modal fade" id="popupForm" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width:800px">
        <div class="modal-content">
            <?php echo Form::open(['url' => 'contract/payments', 'method' => 'post', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8', 'id' => 'uploadPayments', 'class' => 'popup-form x-load-file', 'data-goto' => urldecode($goto)]); ?>

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Upload Schedule of Payments</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <?php echo Form::file('file', ['style' => 'font-size:12px; width:100%; border-radius:3px']); ?>

                    </div>
                </div>
                <div class="modal-footer">
                    <span style="font-size:12px; color:#888; padding-top:3px; display:inline-block; position:relative; margin-right:auto; width:275px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap"><i class="fa fa-code" aria-hidden="true" style="color:orange"></i> <?php echo @$contractCode[0]; ?></span>
                    <a href="<?php echo @$filename[0]; ?>" style="font-size:12px; color:green; padding-top:3px; display:inline-block; position:relative; margin-right:auto; width:275px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; font-weight:normal"><i class="far fa-arrow-alt-circle-down" style="color:green"></i>DOWNLOAD</a>
                    <?php echo Form::submit('Upload', ['class' => 'btn btn-primary']); ?>

                    <?php echo Form::button('Close', ['class' => 'btn btn-danger', 'data-dismiss' => 'modal']); ?>

                </div>
                <input name="contract_id" value="<?php echo e($contractId); ?>" type="hidden" />
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
