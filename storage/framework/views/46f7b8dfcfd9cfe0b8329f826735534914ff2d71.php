<?php $__env->startSection('content'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <?php echo Form::open(['url' => 'profile-project', 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'x-load profile-form', 'id' => 'projectProfile', 'data-goto' => url('project-list'), 'style' => 'max-width:500px']); ?>

            <h1 class="form-title"><i class="fas fa-pencil-alt" style="margin-right:5px"></i> Project Profile</h1>
            <div class="form-group-wrapper">
                <div class="row form-subtitle-wrapper">
                    <div class="form-subtitle"><i class="fas fa-map" style="margin-right:5px"></i> Location</div>
                </div>
                <div class="row">
                    <div class="col-6" style="padding:0 10px 0 0">
                        <label>River Basin</label>
                        <?php echo Form::select('riverbasin', $riverBasins, @$profile['riverbasin'], ['class' => 'form-control']); ?>

                    </div>
                    <div class="col-6" style="padding:0 0 0 10px">
                        <label>Watershed</label>
                        <?php echo Form::select('watershed', $watersheds, @$profile['watershed'], ['class' => 'form-control']); ?>

                    </div>
                </div>
                <div class="row">
                    <div class="col-6" style="padding:0 10px 0 0">
                        <label>PPMO</label>
                        <?php echo Form::select('ppmo', $ppmos, @$profile['ppmo'], ['class' => 'form-control']); ?>

                    </div>
                    <div class="col-6" style="padding:0 0 0 10px">
                        <label>CENRO</label>
                        <?php echo Form::select('cenro', $cenros, @$profile['cenro'], ['class' => 'form-control']); ?>

                    </div>
                </div>
                <div class="row">
                    <div class="col-6" style="padding:0 10px 0 0">
                        <label>WMPCO</label>
                        <?php echo Form::select('wmpco', $wmpcos, @$profile['wmpco'], ['class' => 'form-control']); ?>

                    </div>
                </div>
                <hr style="margin-top:25px" />

                

                <div class="row">
                    <div class="col-6" style="padding:0 10px 0 0">
                        <label>Municipality</label>
                        <?php echo Form::select('municipality', $municipalities, @$profile['municipality'], ['class' => 'form-control trigger-generate-id', 'data-geturl' => url('get-barangays')]); ?>

                    </div>
                    <div class="col-6" style="padding:0 0 0 10px">
                        <label>Barangay</label>
                        <?php echo Form::select('barangay', $barangays, @$profile['barangay'], ['class' => 'form-control']); ?>

                    </div>
                </div>
            </div>
            <div class="form-group-wrapper">
                <div class="row form-subtitle-wrapper">
                    <div class="form-subtitle"><i class="fas fa-info-circle" style="margin-right:5px"></i> Project Type</div>
                </div>
                <div class="row">
                    <label>Project Type</label>
                    <?php echo Form::select('project_type_id', $projectTypes, @$profile['project_type_id'], ['class' => 'form-control']); ?>

                </div>
                <div class="row" style="display:<?php echo e((@$profile['project_type_id'] == 2) ? 'block' : 'none'); ?>">
                    <label>Project Name | Title</label>
                    <?php echo Form::text('project_title', @$profile['project_title'], ['class' => 'form-control']); ?>

                </div>
                <div class="row" style="display:<?php echo e((@$profile['project_type_id'] == 2) ? 'none' : 'block'); ?>">
                    <label>People's Organization</label>
                    <?php echo Form::select('po_name', $pos, @$profile['po_id'], ['class' => 'form-control']); ?>

                </div>
                <div class="row proponent-lgu" style="display:<?php echo e((@$profile['project_type_id'] == 2) ? 'block' : 'none'); ?>">
                    <div class="col-6" style="padding:0 10px 0 0">
                        <label>Proponent</label>
                        <div style="display:block; margin:0; padding:0">
                            <label style="font-size:13px; margin-right:10px"><?php echo Form::radio('proponent_lgu', 'Province', ((@$profile['proponent'] == 'Province') ? true : false)); ?> Province</label>
                            <label style="font-size:13px; "><?php echo Form::radio('proponent_lgu', 'Municipality', ((@$profile['proponent'] == 'Municipality') ? true : false)); ?> Municipality</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group-wrapper infra-beneficiaries" style="display:<?php echo e((@$profile['project_type_id'] == 2) ? 'block' : 'none'); ?>">
                <div class="row form-subtitle-wrapper">
                    <div class="form-subtitle"><i class="fa fa-user-circle" style="margin-right:5px"></i> Beneficiaries</div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label>Male</label>
                        <?php echo Form::text('infra_male', @$profile['infra_male'], ['class' => 'form-control addend']); ?>

                    </div>
                    <div class="col-4">
                        <label>Female</label>
                        <?php echo Form::text('infra_female', @$profile['infra_female'], ['class' => 'form-control addend']); ?>

                    </div>
                    <div class="col-4">
                        <label>Total</label>
                        <?php echo Form::text('total', @$profile['total_male_female'], ['class' => 'form-control', 'readonly' => true]); ?>

                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label>Male (IP)</label>
                        <?php echo Form::text('infra_male_ip', @$profile['infra_male_ip'], ['class' => 'form-control addend']); ?>

                    </div>
                    <div class="col-4">
                        <label>Female (IP)</label>
                        <?php echo Form::text('infra_female_ip', @$profile['infra_female_ip'], ['class' => 'form-control addend']); ?>

                    </div>
                    <div class="col-4">
                        <label>Total (IP)</label>
                        <?php echo Form::text('total', @$profile['total_male_female_ip'], ['class' => 'form-control', 'readonly' => true]); ?>

                    </div>
                </div>
            </div>
            <div class="form-group-wrapper other-beneficiaries" style="display:<?php echo e((@$profile['project_type_id'] == 2) ? 'none' : 'block'); ?>">
                <div class="row form-subtitle-wrapper">
                    <div class="form-subtitle"><i class="fa fa-user-circle" style="margin-right:5px"></i> Household (HH) Beneficiaries</div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label>Direct IP</label>
                        <?php echo Form::text('hh_ip_direct', @$profile['hh_ip_direct'], ['class' => 'form-control addend']); ?>

                    </div>
                    <div class="col-4">
                        <label>Indirect IP</label>
                        <?php echo Form::text('hh_ip_indirect', @$profile['hh_ip_indirect'], ['class' => 'form-control addend']); ?>

                    </div>
                    <div class="col-4">
                        <label>Total (IP)</label>
                        <?php echo Form::text('total', @$profile['hh_ip_total'], ['class' => 'form-control', 'readonly' => true]); ?>

                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label>Direct Non-IP</label>
                        <?php echo Form::text('hh_nonip_direct', @$profile['hh_nonip_direct'], ['class' => 'form-control addend']); ?>

                    </div>
                    <div class="col-4">
                        <label>Indirect Non-IP</label>
                        <?php echo Form::text('hh_nonip_indirect', @$profile['hh_nonip_indirect'], ['class' => 'form-control addend']); ?>

                    </div>
                    <div class="col-4">
                        <label>Total (Non-IP)</label>
                        <?php echo Form::text('total', @$profile['hh_nonip_total'], ['class' => 'form-control', 'readonly' => true]); ?>

                    </div>
                </div>
            </div>
            <div class="form-group-wrapper other-beneficiaries" style="display:<?php echo e((@$profile['project_type_id'] == 2) ? 'none' : 'block'); ?>">
                <div class="row form-subtitle-wrapper">
                    <div class="form-subtitle"><i class="fa fa-user-circle" style="margin-right:5px"></i> Individual Beneficiaries</div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label>Direct IP</label>
                        <?php echo Form::text('ind_ip_direct', @$profile['ind_ip_direct'], ['class' => 'form-control addend']); ?>

                    </div>
                    <div class="col-4">
                        <label>Indirect IP</label>
                        <?php echo Form::text('ind_ip_indirect', @$profile['ind_ip_indirect'], ['class' => 'form-control addend']); ?>

                    </div>
                    <div class="col-4">
                        <label>Total (IP)</label>
                        <?php echo Form::text('total', @$profile['ind_ip_total'], ['class' => 'form-control', 'readonly' => true]); ?>

                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label>Direct Non-IP</label>
                        <?php echo Form::text('ind_nonip_direct', @$profile['ind_nonip_direct'], ['class' => 'form-control addend']); ?>

                    </div>
                    <div class="col-4">
                        <label>Indirect Non-IP</label>
                        <?php echo Form::text('ind_nonip_indirect', @$profile['ind_nonip_indirect'], ['class' => 'form-control addend']); ?>

                    </div>
                    <div class="col-4">
                        <label>Total (Non-IP)</label>
                        <?php echo Form::text('total', @$profile['ind_nonip_total'], ['class' => 'form-control', 'readonly' => true]); ?>

                    </div>
                </div>
            </div>
            <div class="form-group-wrapper">
                <div class="row form-subtitle-wrapper">
                    <div class="form-subtitle"><i class="fas fa-code" style="margin-right:5px"></i> SYSTEM GENERATED ID</div>
                </div>
                <div class="row">
                    <div class="col-6" style="padding:0 10px 0 0">
                        <label>Project ID</label>
                        <?php echo Form::text('project_code', @$profile['project_code'], ['class' => 'form-control', 'readonly' => 'readonly', 'style' => 'font-weight:bold']); ?>

                    </div>
                </div>
            </div>
            <div class="row" style="margin-top:25px">
                <?php echo Form::hidden('province'); ?>

                <?php echo Form::hidden('province_id', @$profile['province_id']); ?>

                <?php echo Form::hidden('project_id', @$profile['project_id']); ?>

                <?php echo Form::submit('SAVE PROJECT PROFILE', ['class' => 'btn btn-primary', 'style' => 'margin-right:10px']); ?>

                <?php echo Form::reset('CANCEL', ['class' => 'btn btn-danger']); ?>

            </div>
        <?php echo Form::close(); ?>

    </div>
</div>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) { 
        
        /* Get List of Auto Complete POs */
        getPoSearch(url + '/profile/get-po-search?type=po-profile');
        
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>