<?php $__env->startSection('content'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <h1 class="page-title"><i class="fas fa-info-circle"></i> Register New User</h1>
        <?php if($errors->any()): ?>
            <div class="row">
                <div class="col-8">
                    <div class="alert alert-danger" role="alert">
                        <?php echo implode('', $errors->all('<div>:message</div>')); ?>

                    </div>
                </div>
            </div>
        <?php elseif(isset($msg)): ?>
            <div class="row">
                <div class="col-8">
                    <div class="alert alert-success" role="alert">
                        <?php echo e($msg); ?>

                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php echo Form::open(['url' => 'register', 'method' => 'post']); ?>

            <div class="row">
                <div class="col-8">
                    <label>Office</label>
                    <?php echo Form::text('office', old('office'), ['class' => 'form-control']); ?>

                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <label>Name</label>
                    <?php echo Form::text('full_name', '', ['class' => 'form-control']); ?>

                </div>
                <div class="col-4">
                    <label>Email Address</label>
                    <?php echo Form::email('email', '', ['class' => 'form-control']); ?>

                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <label>Password</label>
                    <?php echo Form::password('password', ['class' => 'form-control']); ?>

                </div>
                <div class="col-4">
                    <label>Confirm Password</label>
                    <?php echo Form::password('password_confirmation', ['class' => 'form-control']); ?>

                </div>
            </div>
            <div class="row" style="margin-top:25px">
                <div class="col-4">
                    <?php echo Form::submit('Register', ['class' => 'btn btn-primary']); ?>

                    <?php echo Form::reset('Clear Form', ['class' => 'btn btn-danger']); ?>

                </div>
            </div>
        <?php echo Form::close(); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>