<div class="modal fade" id="popupForm" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo Form::open(['url' => 'procurement/winning-bidder', 'method' => 'post', 'accept-charset' => 'UTF-8', 'id' => 'winningBidderForm', 'class' => 'popup-form x-load']); ?>

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Details of Winning Contractor</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="response-wrapper"></div>
                    <div class="row">
                        <div class="col-8" style="padding:0 10px 0 0">
                            <label>Contractor's Name</label>
                            <?php echo Form::text('contractor_name', ($default != null) ? $default->contractor_name : '', ['class' => 'form-control']); ?>

                        </div>
                        <div class="col-4" style="padding:0 0 0 10px">
                            <label>Financial Capacity</label>
                            <?php echo Form::text('financial_capacity', ($default != null) ? $default->financial_capacity : '', ['class' => 'form-control']); ?>

                        </div>
                    </div>
                    <div class="row">
                        <label>Address</label>
                        <?php echo Form::text('contractor_address', ($default != null) ? $default->contractor_address : '', ['class' => 'form-control']); ?>

                    </div>
                    <div class="row">
                        <div class="col-8" style="padding:0 10px 0 0">
                            <label>Office of Registration</label>
                            <?php echo Form::select('office_registration_id', $regTypes, ($default != null) ? $default->office_registration_id : '', ['class' => 'form-control']); ?>

                        </div>
                        <div class="col-4 datepicker-wrapper" style="padding:0 0 0 10px">
                            <label>Registration Date</label>
                            <?php echo Form::text('registration_date', ($default != null) ? $default->registration_date : '', ['class' => 'form-control pick-date', 'autocomplete' => 'off']); ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6" style="padding:0 10px 0 0">
                            <label>Registration No.</label>
                            <?php echo Form::text('registration_no', ($default != null) ? $default->registration_no : '', ['class' => 'form-control']); ?>

                        </div>
                        <div class="col-6" style="padding:0 0 0 10px">
                            <label>Servicing Bank</label>
                            <?php echo Form::select('servicing_bank_id', $banks, ($default != null) ? $default->servicing_bank_id : '', ['class' => 'form-control']); ?>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php echo Form::hidden('id', ($default != null) ? $default->id : ''); ?>

                    <?php echo Form::hidden('project_id', $projectId); ?>

                    <?php echo Form::submit('Save', ['class' => 'btn btn-primary']); ?>

                    <?php echo Form::button('Close', ['class' => 'btn btn-danger', 'data-dismiss' => 'modal']); ?>

                </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
