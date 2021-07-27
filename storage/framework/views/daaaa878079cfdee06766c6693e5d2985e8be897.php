<div class="modal fade" id="popupForm" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo Form::open(['url' => 'reports/upload', 'method' => 'post', 'accept-charset' => 'UTF-8', 'id' => 'reportForm', 'class' => 'popup-form x-load-file']); ?>

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fas fa-file-upload" style="color:orange"></i> Upload Reports</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="response-wrapper"></div>
                    <div class="row">
                        <div class="col-12">
                            <label>File:</label>
                            <?php echo Form::file('file', ['class' => 'form-control']); ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label>Remarks:</label>
                            <?php echo Form::textarea('remarks', '', ['class' => 'form-control', 'rows' => '2']); ?>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php echo Form::submit('Upload', ['class' => 'btn btn-primary']); ?>

                    <?php echo Form::button('Close', ['class' => 'btn btn-danger', 'data-dismiss' => 'modal']); ?>

                </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
    <?php /**PATH /Users/marklesterbolotaolo/Desktop/laravel/nfcqs1/resources/views/reports/upload.blade.php ENDPATH**/ ?>