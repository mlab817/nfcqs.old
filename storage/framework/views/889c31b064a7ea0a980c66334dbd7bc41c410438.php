<div class="modal fade" id="popupForm" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width:800px">
        <div class="modal-content">
            <?php echo Form::open(['url' => 'contract/upload-boq', 'method' => 'post', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8', 'id' => 'uploadBoq', 'class' => 'popup-form x-load-file', 'data-goto' => urldecode($goto)]); ?>

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Upload Bill of Quantities (BOQ)</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <?php if(sizeof($modalities) == 0): ?>
                            <span style="padding:10px; color:#555; background-color:#f4f4f4; border-radius:5px; font-size:12px; border:1px solid #ddd">
                                ERROR! Uploading of contract BOQ is not available this time. Please set up contract modality and fund source.
                            </span>
                        <?php else: ?>
                            <?php echo Form::file('file', ['style' => 'font-size:12px; width:100%; border-radius:3px']); ?>

                        <?php endif; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <span style="font-size:12px; color:#888; padding-top:3px; display:inline-block; position:relative; margin-right:auto; width:275px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap"><i class="fa fa-code" aria-hidden="true" style="color:orange"></i> <?php echo @$contractCode[0]; ?></span>

                    <?php if(sizeof($modalities) != 0): ?>
                        <?php echo Form::submit('Upload', ['class' => 'btn btn-primary']); ?>

                    <?php endif; ?>

                    <?php echo Form::button('Close', ['class' => 'btn btn-danger', 'data-dismiss' => 'modal']); ?>

                </div>
                <input name="contract_id" value="<?php echo e($contractId); ?>" type="hidden" />
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
