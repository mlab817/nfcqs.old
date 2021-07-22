<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>iPMIS</title>
    <?php $noCache = rand(); ?>

    <link href="<?php echo e(asset('vendor/bootstrap-4.0.0/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('vendor/datepicker-0.6.3/docs/css/datepicker.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('vendor/font-awesome-5.0.6/web-fonts-with-css/css/fontawesome-all.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('vendor/select-2.4.0/dist/css/select2.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/sidebar.css?' . $noCache)); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/geotag.css?' . $noCache)); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/app.css?' . $noCache)); ?>" rel="stylesheet">
</head>
<body>
    <div id="wrapper" class="toggled">
        <?php echo $__env->make('../sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <?php echo Form::open(['url' => 'register', 'method' => 'post', 'class' => 'x-load', 'data-goto' => url('register'), 'style' => 'max-width:500px']); ?>

                    <h1 class="form-title"><i class="fas fa-pencil-alt" style="margin-right:5px"></i> Register User</h1>
                    <div class="row">
                        <div class="col-6" style="padding:0 10px 0 0">
                            <label>Full Name <span style="color:orange">- required</span></label>
                            <?php echo Form::text('full_name', @$user['full_name'], ['class' => 'form-control', 'placeholder' => '']); ?>

                        </div>
                        <div class="col-6" style="padding:0 0 0 10px">
                            <label>Email Address <span style="color:orange">- required</span></label>
                            <?php echo Form::email('email', @$user['email'], ['class' => 'form-control', 'placeholder' => '']); ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6" style="padding:0 10px 0 0">
                            <label>Password <span style="color:orange">- required</span></label>
                            <?php echo Form::password('password', ['class' => 'form-control']); ?>

                        </div>
                        <div class="col-6" style="padding:0 0 0 10px">
                            <label>Re-Type Password <span style="color:orange">- required</span></label>
                            <?php echo Form::password('password_confirmation', ['class' => 'form-control']); ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6" style="padding:0 10px 0 0">
                            <label>Region <span style="color:orange">- all users except NPCO</span></label>
                            <?php echo Form::select('region_id', $regions, '', ['class' => 'form-control', 'data-geturl' => url('get-provinces')]); ?>

                        </div>
                        <div class="col-6" style="padding:0 0 0 10px">
                            <label>Province <span style="color:orange">- all users except NPCO & RPCO</span></label>
                            <?php echo Form::select('province_id', $provinces, '', ['class' => 'form-control']); ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" style="padding:0">
                            <label>Watershed <span style="color:orange">- only users from CENRO, SUSIMO & WMPCO</span></label>
                            <?php echo Form::select('watershed_ids[]', $watersheds, '', ['class' => 'form-control select', 'multiple' => 'multiple']); ?>

                            <div style="padding:10px; border:1px solid #ddd; margin-top:20px; border-radius:5px 5px 5px 5px">
                                <span style="font-size:12px; line-height:normal; display:block; color:#777; font-weight:bold"><i class="fas fa-info-circle" style="margin-right:5px"></i>NOTE:</span>
                                <span style="font-size:12px; line-height:normal; display:block; color:#777; padding-left:25px"><i class="fas fa-long-arrow-alt-right"></i>For CENRO please select all required watersheds.</span>
                                <span style="font-size:12px; line-height:normal; display:block; color:#777; padding-left:25px"><i class="fas fa-long-arrow-alt-right"></i>For SUSIMO / WMPCO please select specific watershed only.</span>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:25px">
                        <?php echo Form::submit('Register', ['class' => 'btn btn-primary', 'style' => 'margin-right:10px']); ?>

                        <?php echo Form::reset('Reset', ['class' => 'btn btn-danger']); ?>

                    </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>

    <script src="<?php echo e(asset('vendor/jquery-3.2.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/popper/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/bootstrap-4.0.0/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/datepicker-0.6.3/docs/js/datepicker.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('vendor/select-2.4.0/dist/js/select2.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('vendor/chart-2.7.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/exif-2.3.0.js')); ?>"></script>
    <script src="<?php echo e(asset('js/geotag.js?' . $noCache)); ?>"></script>
    <script src="<?php echo e(asset('js/app.min.js?' . $noCache)); ?>"></script>
</body>
</html>
