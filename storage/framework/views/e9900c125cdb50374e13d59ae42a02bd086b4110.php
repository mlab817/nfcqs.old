<div class="modal fade" id="popupForm" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width:800px">
        <div class="modal-content">
            <?php echo Form::open(['url' => 'profile/po-set-list-columns', 'method' => 'post', 'accept-charset' => 'UTF-8', 'id' => 'poSetListColumnsForm', 'class' => 'popup-form x-load']); ?>

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Set Table Columns</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <?php for($i = 0; $i < sizeof($columns); $i++): ?>
                        <div style="display:inline-block; min-width:45%">
                            <label style="font-weight:normal; font-size:12px"><?php echo Form::checkbox('columns', $columns[$i]['key'], $columns[$i]['selected']); ?><span style="margin-left:10px; display:inline-block; position:relative"><?php echo e($columns[$i]['val']); ?></span></label>
                        </div>
                    <?php endfor; ?>
                </div>
                <div class="modal-footer">
                    <span class="check-all-po-table-columns" style="font-size:10px; font-weight:bold; color:orange; cursor:pointer; padding-top:3px; display:inline-block; position:relative; margin-right:auto; width:275px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap"><i class="fa fa-long-arrow-right" aria-hidden="true" style="color:orange"></i> SELECT ALL</span>
                    <a href="" class="btn btn-secondary">Reset Display</a>
                    <?php echo Form::button('Close', ['class' => 'btn btn-danger', 'data-dismiss' => 'modal']); ?>

                </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
