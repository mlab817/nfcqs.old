<?php $__env->startSection('content'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <?php echo Form::open(['url' => 'contract', 'method' => 'post', 'class' => 'x-load contract-form', 'data-goto' => url('contracts'), 'style' => 'max-width:500px']); ?>

            <h1 class="form-title"><i class="fas fa-pencil-alt" style="margin-right:5px"></i> <?php echo e(($contractId != '') ? 'Updating Contract Details' : 'Register New Contract'); ?></h1>
            <div class="form-group-wrapper">
                <div class="row form-subtitle-wrapper">
                    <div class="form-subtitle"><i class="fa fa-location-arrow" aria-hidden="true" style="margin-right:5px"></i> Location</div>
                </div>
                <div class="row">
                    <div class="col-6" style="padding:0 10px 0 0">
                        <label>River Basin</label>
                        <?php echo Form::select('riverbasin', $riverbasins, ($riverbasin != '') ? $riverbasin : @$contract['riverbasin'], ['class' => 'form-control']); ?>

                    </div>
                    <div class="col-6" style="padding:0 0 0 10px">
                        <label>Watershed</label>
                        <?php echo Form::select('watershed', $watersheds, @$contract['watershed']->watershed, ['class' => 'form-control', 'data-geturl' => url('get-barangays')]); ?>

                    </div>
                </div>
                <div class="row">
                    <div class="col-6" style="padding:0 10px 0 0">
                        <?php if($user->province_id == 0): ?>
                            <label>Province</label>
                            <?php echo Form::select('province_id', $provinces, @$contract['province_id'], ['class' => 'form-control', 'data-geturl' => url('get-municipalities')]); ?>

                        <?php else: ?>
                            <label>Province</label>
                            <?php echo Form::select('province_id', ['' => '', $provinceId => $province], @$contract['province_id'], ['class' => 'form-control', 'data-geturl' => url('get-municipalities')]); ?>

                        <?php endif; ?>
                    </div>
                    <div class="col-6" style="padding:0 0 0 10px">
                        <label>Municipality</label>
                        <?php echo Form::select('municipality', $municipalities, @$contract['municipality'], ['class' => 'form-control', 'data-geturl' => url('get-barangays')]); ?>

                    </div>
                </div>
                <div class="row">
                    <div class="col-6" style="padding:0 10px 0 0">
                        <label>Barangay</label>
                        <?php echo Form::select('barangay', $barangays, @$contract['barangay'], ['class' => 'form-control']); ?>

                    </div>
                </div>
            </div>
            <div class="form-group-wrapper">
                <div class="row form-subtitle-wrapper">
                    <div class="form-subtitle"><i class="fa fa-handshake-o" aria-hidden="true" style="margin-right:5px"></i> Project Type</div>
                </div>
                <div class="row">
                    <label>Contract Type</label>
                    <?php echo Form::select('contract_type_id', $contractTypes, @$contract['contract_type_id'], ['class' => 'form-control trigger-projects']); ?>

                </div>
                <div class="row">
                    <label>
                        <span class="temp-disp">Link to Project</span>
                        <span class="infra-project-label" style="display:none">Project Title</span>
                        <span class="non-infra-project-label" style="display:none">People's Organization Name</span>
                    </label>
                    <?php echo Form::select('project_id', $projects, @$contract['project_id'], ['class' => 'form-control']); ?>

                </div>
                <div class="row infra-contractor" style="display:<?php echo e((@$contract['contract_type_id'] == 2) ? 'block' : 'none'); ?>">
                    <label>Contractor Name</label>
                    <?php echo Form::text('contractor_name', @$contract['contractor_name'], ['class' => 'form-control', 'readonly' => 'readonly']); ?>

                </div>
            </div>
            <div class="form-group-wrapper">
                <div class="row form-subtitle-wrapper">
                    <div class="form-subtitle"><i class="fa fa-calendar" aria-hidden="true" style="margin-right:5px"></i> Contract Cost & Duration</div>
                </div>
                <div class="row">
                    <label>Contract Code / Number</label>
                    <?php echo Form::text('contract_code', @$contract['contract_code'], ['class' => 'form-control']); ?>

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
                <div class="row area-covered" style="<?php echo e((@$contract['contract_type_id'] == 2 OR @$contract['contract_type_id'] == 4) ? 'display:none' : ''); ?>">
                    <div class="col-6" style="padding:0 10px 0 0">
                        <?php unset($contractTypes[""]); ?>
                        <label>Contracted Area (in Hectare) <i class="fa fa-question-circle" aria-hidden="true" style="color:orange" title="<?php echo e(json_encode($contractTypes)); ?>"></i></label>
                        <?php echo Form::text('area_covered', (@$contract['area_covered'] != 0 AND @$contract['area_covered'] != '') ? number_format(@$contract['area_covered'], 2) : '', ['class' => 'form-control']); ?>

                    </div>
                </div>
                <div class="row infra-target" style="<?php echo e((@$contract['contract_type_id'] != 2) ? 'display:none' : ''); ?>">
                    <div class="col-6" style="padding:0 10px 0 0">
                        <label>Unit Measure <i class="fa fa-question-circle" aria-hidden="true" style="color:orange" title="<?php echo e(json_encode($contractTypes)); ?>"></i></label>
                        <?php echo Form::select('unit_measure', $unitMeasures, @$contract['unit_measure'], ['class' => 'form-control']); ?>

                    </div>
                    <div class="col-6 infra-target" style="padding:0 0 0 10px; <?php echo e((@$contract['contract_type_id'] != 2) ? 'display:none' : ''); ?>">
                        <label>Quantity <i class="fa fa-question-circle" aria-hidden="true" style="color:orange" title="<?php echo e(json_encode($contractTypes)); ?>"></i></label>
                        <?php echo Form::text('quantity', (@$contract['quantity'] != 0 AND @$contract['quantity'] != '') ? number_format(@$contract['quantity'], 2) : '', ['class' => 'form-control']); ?>

                    </div>
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
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {

        $(document).on('change', 'select[name="riverbasin"], select[name="watershed"],  select[name="province_id"], select[name="municipality"], select[name="barangay"]', function () {
            $('select[name="project_id"]').html('<option value=""></option>');
        });

    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>