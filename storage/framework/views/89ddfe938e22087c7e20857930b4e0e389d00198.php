<?php $__env->startSection('content'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <?php echo Form::open(['url' => 'profile-po', 'method' => 'post', 'class' => 'x-load profile-form po-profile-form', 'id' => 'poProfile', 'data-goto' => url('po-list'), 'style' => 'max-width:500px']); ?>

            <h1 class="form-title"><i class="fas fa-pencil-alt" style="margin-right:5px"></i> People's  Organization (PO) Profile</h1>
            <div class="form-group-wrapper">
                <div class="row form-subtitle-wrapper">
                    <div class="form-subtitle"><i class="fa fa-area-chart" aria-hidden="true" style="margin-right:5px"></i> PO Area</div>
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
            </div>
            <div class="form-group-wrapper">
                <div class="row form-subtitle-wrapper">
                    <div class="form-subtitle"><i class="fas fa-info-circle" style="margin-right:5px"></i> Basic Info</div>
                </div>
                <div class="row">
                    <label>PO Name</label>
                    <?php echo Form::text('po_name', @$profile['po_name'], ['class' => 'form-control auto-complete-po-name', 'autocomplete' => 'off']); ?>

                    <div class="auto-complete-suggestions"></div>
                </div>
                <div class="row">
                    <label>Original PO Name</label>
                    <?php echo Form::text('orig_po_name', @$profile['orig_po_name'], ['class' => 'form-control', 'autocomplete' => 'off']); ?>

                </div>
                <div class="row">
                    <div class="col-6" style="padding:0 10px 0 0">
                        <label>PO Acronym</label>
                        <?php echo Form::text('po_acronym', @$profile['po_acronym'], ['class' => 'form-control']); ?>

                    </div>
                    <div class="col-6" style="padding:0 0 0 10px">
                        <label>PO Code</label>
                        <?php echo Form::text('po_code', @$profile['po_code'], ['class' => 'form-control']); ?>

                    </div>
                </div>
                <div class="row">
                    <div class="col-6" style="padding:0 10px 0 0">
                        <label>Office of Registration</label>
                        <?php echo Form::select('registration_type_id', $regTypes, @$profile['registration_type_id'], ['class' => 'form-control']); ?>

                    </div>
                    <div class="col-6 datepicker-wrapper" style="padding:0 0 0 10px">
                        <label>Registration Date</label>
                        <?php echo Form::text('registration_date', @$profile['registration_date'], ['class' => 'form-control pick-date']); ?>

                    </div>
                </div>
                <div class="row">
                    <div class="col-6" style="padding:0 10px 0 0">
                        <label>Registration No.</label>
                        <?php echo Form::text('registration_no', @$profile['registration_no'], ['class' => 'form-control']); ?>

                    </div>
                </div>
            </div>
            <div class="form-group-wrapper">
                <div class="row form-subtitle-wrapper">
                    <div class="form-subtitle"><i class="fas fa-address-card" style="margin-right:5px"></i> PO Address</div>
                </div>
                <div class="row">
                    <div class="col-6" style="padding:0 10px 0 0">
                        <label>Region</label>
                        <?php echo Form::select('region_id', $regions, @$profile['region_id'], ['class' => 'form-control', 'data-geturl' => url('get-provinces')]); ?>

                    </div>
                    <div class="col-6 datepicker-wrapper" style="padding:0 0 0 10px">
                        <label>Province</label>
                        <?php echo Form::select('province_id', $provinces, @$profile['province_id'], ['class' => 'form-control', 'data-geturl' => url('get-municipalities')]); ?>

                    </div>
                </div>
                <div class="row">
                    <div class="col-6" style="padding:0 10px 0 0">
                        <label>Municipality</label>
                        <?php echo Form::select('municipality', $municipalities, @$profile['municipality'], ['class' => 'form-control', 'data-geturl' => url('get-barangays')]); ?>

                    </div>
                    <div class="col-6 datepicker-wrapper" style="padding:0 0 0 10px">
                        <label>Barangay</label>
                        <?php echo Form::select('barangay', $barangays, @$profile['barangay'], ['class' => 'form-control']); ?>

                    </div>
                </div>
                <div class="row">
                    <div class="col-6" style="padding:0 10px 0 0">
                        <label>Address Remarks</label>
                        <?php echo Form::text('other_address_details', @$profile['other_address_details'], ['class' => 'form-control']); ?>

                    </div>
                </div>
            </div>
            <div class="form-group-wrapper">
                <div class="row form-subtitle-wrapper">
                    <div class="form-subtitle"><i class="fas fa-calendar-alt" style="margin-right:5px"></i> Tenurial Instrument</div>
                </div>
                <div class="row">
                    <div class="col-6" style="padding:0 10px 0 0">
                        <label>Tenurial Instrument</label>
                        <?php echo Form::select('tenurial_instrument_id', $tenurialInstruments, @$profile['tenurial_instrument_id'], ['class' => 'form-control']); ?>

                    </div>
                    <div class="col-6 datepicker-wrapper" style="padding:0 0 0 10px">
                        <label>Date Awarded</label>
                        <?php echo Form::text('date_awarded', @$profile['date_awarded'], ['class' => 'form-control pick-date']); ?>

                    </div>
                </div>
                <div class="col-6" style="padding:0 10px 0 0">
                    <label>Tenured Area (in Hectare)</label>
                    <?php echo Form::text('tenured_area', @$profile['tenured_area'], ['class' => 'form-control']); ?>

                </div>
            </div>
            <div class="form-group-wrapper">
                <div class="row form-subtitle-wrapper">
                    <div class="form-subtitle"><i class="fas fa-dollar-sign" style="margin-right:5px"></i> Servicing Bank</div>
                </div>
                <div class="row">
                    <div class="col-6" style="padding:0 10px 0 0">
                         <label>Bank Name</label>
                        <?php echo Form::select('servicing_bank_id', $banks, @$profile['servicing_bank_id'], ['class' => 'form-control']); ?>

                    </div>
                </div>
            </div>
            <div class="form-group-wrapper">
                <div class="row form-subtitle-wrapper">
                    <div class="form-subtitle"><i class="fas fa-users" style="margin-right:5px"></i> Household Size</div>
                </div>
                <div class="row">
                    <div class="col-6" style="padding:0 10px 0 0">
                        <label>Total Household</label>
                        <?php echo Form::text('household', @$profile['household'], ['class' => 'form-control']); ?>

                    </div>
                    <div class="col-6" style="padding:0 0 0 10px">
                        <label>Total Household (IP)</label>
                        <?php echo Form::text('household_ip', @$profile['household_ip'], ['class' => 'form-control']); ?>

                    </div>
                </div>
                <div class="row">
                    <div class="col-6" style="padding:0 10px 0 0">
                        <label>Total Household - Female Headed</label>
                        <?php echo Form::text('household_female_headed', @$profile['household_female_headed'], ['class' => 'form-control']); ?>

                    </div>
                    <div class="col-6" style="padding:0 0 0 10px">
                        <label>Total Household (IP) - Female Headed</label>
                        <?php echo Form::text('household_ip_female_headed', @$profile['household_ip_female_headed'], ['class' => 'form-control']); ?>

                    </div>
                </div>
            </div>
            
            <div class="row" style="margin-top:25px">
                <?php echo Form::submit('SAVE PO PROFILE', ['class' => 'btn btn-primary', 'style' => 'margin-right:10px']); ?>

                <?php echo Form::reset('CANCEL', ['class' => 'btn btn-danger']); ?>


                <?php if($poId != 0 AND $poId != null): ?>
                    <?php echo Form::hidden('po_id', $poId); ?>

                <?php endif; ?>
            </div>
        <?php echo Form::close(); ?>

    </div>
</div>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) { 
        
        /* Get List of Auto Complete POs */
        getPoSearch(url + '/profile/get-po-search');
        
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>