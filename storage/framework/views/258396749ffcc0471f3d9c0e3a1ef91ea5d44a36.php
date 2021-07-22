<div class="modal fade" id="popupForm" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo Form::open(['url' => 'procured-goods', 'method' => 'post', 'accept-charset' => 'UTF-8', 'id' => 'procuredGoodsForm', 'class' => 'popup-form x-load']); ?>

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><?php echo e(($default != null) ? 'Edit' : 'Add'); ?> Procured Goods</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="response-wrapper"></div>
                    <div class="row">
                        <div class="col-6" style="padding:0 10px 0 0">
                            <label>Item Type</label>
                            <?php echo Form::select('type_id', $types, ($default != null) ? $default->type_id : '', ['class' => 'form-control']); ?>

                        </div>
                        <div class="col-6" style="padding:0 0 0 10px">
                            <label>Unit of Measure</label>
                            <?php echo Form::text('unit_measure', ($default != null) ? $default->unit_measure : '', ['class' => 'form-control']); ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4" style="padding:0 10px 0 0">
                            <label>Quantity</label>
                            <?php echo Form::text('quantity', ($default != null) ? $default->quantity : '', ['class' => 'form-control']); ?>

                        </div>
                        <div class="col-4" style="padding:0 0 0 10px">
                            <label>Unit Cost</label>
                            <?php echo Form::text('unit_cost', ($default != null) ? $default->unit_cost : '', ['class' => 'form-control']); ?>

                        </div>
                        <div class="col-4" style="padding:0 0 0 10px">
                            <label>Total Cost</label>
                            <?php echo Form::text('total_cost', ($default != null) ? $default->quantity * $default->unit_cost : '', ['class' => 'form-control', 'readonly' => 'readonly']); ?>

                        </div>
                    </div>
                    <div class="row">
                        <label>Technical Description</label>
                        <?php echo Form::textarea('description', ($default != null) ? $default->description : '', ['class' => 'form-control', 'rows' => '2']); ?>

                    </div>
                    <div class="row datepicker-wrapper">
                        <div class="col-6" style="padding:0 10px 0 0">
                            <label>Date Delivered</label>
                            <?php echo Form::text('date_delivered', ($default != null) ? $default->date_delivered : '', ['class' => 'form-control pick-date']); ?>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php echo Form::hidden('item_id', ($default != null) ? $default->unit_cost : ''); ?>

                    <?php echo Form::submit('Save', ['class' => 'btn btn-primary']); ?>

                    <?php echo Form::button('Close', ['class' => 'btn btn-danger', 'data-dismiss' => 'modal']); ?>

                </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
