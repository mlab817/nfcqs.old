<?php $__env->startSection('content'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <?php echo Form::open(['url' => 'contract', 'method' => 'post', 'class' => 'x-load contract-form', 'data-goto' => url('contracts'), 'style' => 'max-width:500px']); ?>

            <h1 class="form-title"><i class="fas fa-pencil-alt" style="margin-right:5px"></i> <?php echo e(($contractId != '') ? 'Updating Contract' : 'New Contract'); ?></h1>
            <div class="row">
                <label>Contractor Name</label>
                <?php echo Form::text('contractor_name', @$contract['contractor_name'], ['class' => 'form-control']); ?>

            </div>
            <div class="row">
                <div class="col-6" style="padding:0 10px 0 0">
                    <label>Contractor's Servicing Bank</label>
                    <?php echo Form::select('servicing_bank', ['' => '', 'Land Bank of the Philippines' => 'Land Bank of the Philippines', 'First Consolidated Bank' => 'First Consolidated Bank'], @$contract['servicing_bank'], ['class' => 'form-control']); ?>

                </div>
                <div class="col-6" style="padding:0 0 0 10px">
                    <label>Contractor Address</label>
                    <?php echo Form::text('contractor_address', @$contract['contractor_address'], ['class' => 'form-control']); ?>

                </div>
            </div>
            <div class="row">
                <div class="col-6" style="padding:0 10px 0 0">
                    <label>SEC/CDA/DOLE Registered?</label>
                    <div class="field-like">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="sec_registered" value="1" checked="checked" /> Yes
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="sec_registered" value="0" <?php echo e((@$contract['sec_registered'] == '0') ? 'checked="checked"' : ''); ?> /> No
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-6" style="padding:0 0 0 10px">
                    <label title="only if registered">SEC/CDA/DOLE Registration No.<!--(<i style="color:#007BF3">only if registered</i>)--></label>
                    <?php echo Form::text('registration_no', @$contract['registration_no'], ['class' => 'form-control']); ?>

                </div>
            </div>
            <span class="vertical-divider"></span>
            <div class="row">
                <div class="col-6" style="padding:0 10px 0 0">
                    <label>Contract Type</label>
                    <?php echo Form::select('contract_type_id', $contractTypes, @$contract['contract_type_id'], ['class' => 'form-control']); ?>

                </div>
                <div class="col-6" style="padding:0 0 0 10px">
                    <label>Contract Code / Number</label>
                    <?php echo Form::text('contract_code', @$contract['contract_code'], ['class' => 'form-control']); ?>

                </div>
            </div>
            <div class="row">
                <div class="col-6" style="padding:0 10px 0 0">
                    <label>Contract Cost (LP + GOP)</label>
                    <?php echo Form::text('contract_cost', (@$contract['contract_cost'] != '') ? number_format(@$contract['contract_cost'], 2) : '', ['class' => 'form-control']); ?>

                </div>
                <div class="col-6" style="padding:0 0 0 10px">
                    <label>GOP Counterpart (% Share):</label>
                    <?php echo Form::text('gop_share', (@$contract['gop_share'] != '') ? number_format(@$contract['gop_share'], 2) : '', ['class' => 'form-control']); ?>

                </div>
            </div>
            <div class="row">
                <div class="col-6 datepicker-wrapper" style="padding:0 10px 0 0">
                    <label>Start Date</label>
                    <?php echo Form::text('start_date', (@$contract['start_date'] != '') ? date('Y-m-d', strtotime($contract['start_date'])) : '', ['class' => 'form-control pick-date']); ?>

                </div>
                <div class="col-6 datepicker-wrapper" style="padding:0 0 0 10px">
                    <label>End Date</label>
                    <?php echo Form::text('end_date', (@$contract['end_date'] != '') ? date('Y-m-d', strtotime($contract['end_date'])) : '', ['class' => 'form-control pick-date']); ?>

                </div>
            </div>
            <span class="vertical-divider"></span>
            <div class="row">
                <div class="col-6" style="padding:0 10px 0 0">
                    <label>Watershed</label>
                    <?php echo Form::select('watershed_id', $watersheds, @$contract['watershed_id'], ['class' => 'form-control']); ?>

                </div>
                <?php if($user->province_id == 0): ?>
                    <div class="col-6" style="padding:0 0 0 10px">
                        <label>Province</label>
                        <?php echo Form::select('province_id', $provinces, @$contract['province_id'], ['class' => 'form-control', 'data-geturl' => url('get-municipalities')]); ?>

                    </div>
                <?php else: ?>
                    <div class="col-6" style="padding:0 0 0 10px">
                        <label>Municipality</label>
                        <?php echo Form::hidden('province_id', $user->province_id); ?>

                        <?php echo Form::select('municipality', $municipalities, @$contract['municipality'], ['class' => 'form-control', 'data-geturl' => url('get-barangays')]); ?>

                    </div>
                <?php endif; ?>
            </div>
            <div class="row">
                <?php if($user->province_id == 0): ?>
                    <div class="col-6" style="padding:0 10px 0 0">
                        <label>Municipality</label>
                        <?php echo Form::select('municipality', $municipalities, @$contract['municipality'], ['class' => 'form-control', 'data-geturl' => url('get-barangays')]); ?>

                    </div>
                    <div class="col-6" style="padding:0 0 0 10px">
                        <label>Barangay</label>
                        <?php echo Form::select('barangay', $barangays, @$contract['barangay'], ['class' => 'form-control']); ?>

                    </div>
                <?php else: ?>
                    <div class="col-6" style="padding:0 10px 0 0">
                        <label>Barangay</label>
                        <?php echo Form::select('barangay', $barangays, @$contract['barangay'], ['class' => 'form-control']); ?>

                    </div>
                    <div class="col-6 area-covered" style="padding:0 0 0 10px; <?php echo e((@$contract['contract_type_id'] == 2 OR @$contract['contract_type_id'] == 3 OR @$contract['contract_type_id'] == 4) ? 'display:none' : ''); ?>">
                        <label>Contracted Area (in Hectare)</label>
                        <?php echo Form::text('area_covered', (@$contract['area_covered'] != 0 AND @$contract['area_covered'] != '') ? number_format(@$contract['area_covered'], 2) : '', ['class' => 'form-control']); ?>

                    </div>
                <?php endif; ?>
            </div>
            <?php if($user->province_id == 0): ?>
                <div class="row area-covered" style="<?php echo e((@$contract['contract_type_id'] == 2 OR @$contract['contract_type_id'] == 3 OR @$contract['contract_type_id'] == 4) ? 'display:none' : ''); ?>">
                    <div class="col-6" style="padding:0 10px 0 0">
                        <label>Contracted Area (in Hectare)</label>
                        <?php echo Form::text('area_covered', (@$contract['area_covered'] != 0 AND @$contract['area_covered'] != '') ? number_format(@$contract['area_covered'], 2) : '', ['class' => 'form-control']); ?>

                    </div>
                </div>
            <?php endif; ?>
            <span class="vertical-divider infra-target" style="<?php echo e((@$contract['contract_type_id'] != 2) ? 'display:none' : ''); ?>"></span>
            <div class="row infra-target" style="<?php echo e((@$contract['contract_type_id'] != 2) ? 'display:none' : ''); ?>">
                <div class="col-6" style="padding:0 10px 0 0">
                    <label>Unit Measure</label>
                    <?php echo Form::select('unit_measure', $unitMeasures, @$contract['unit_measure'], ['class' => 'form-control']); ?>

                </div>
                <div class="col-6 infra-target" style="padding:0 0 0 10px; <?php echo e((@$contract['contract_type_id'] != 2) ? 'display:none' : ''); ?>">
                    <label>Quantity</label>
                    <?php echo Form::text('quantity', (@$contract['quantity'] != 0 AND @$contract['quantity'] != '') ? number_format(@$contract['quantity'], 2) : '', ['class' => 'form-control']); ?>

                </div>
            </div>
            <div class="row" style="margin-top:25px">
                <?php echo Form::hidden('contract_id', $contractId); ?>

                <?php echo Form::submit('Save Contract', ['class' => 'btn btn-primary', 'style' => 'margin-right:10px']); ?>

                <?php echo Form::reset('Cancel', ['class' => 'btn btn-danger']); ?>

            </div>
        <?php echo Form::close(); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>