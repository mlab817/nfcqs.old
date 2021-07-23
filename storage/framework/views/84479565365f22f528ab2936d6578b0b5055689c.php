<?php $__env->startSection('content'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <h1 class="page-title"><i class="fas fa-info-circle"></i> Edit System User</h1>
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
        <?php echo Form::open(['url' => route('users.update', $user->id), 'method' => 'PUT']); ?>

            <div class="row">
                <div class="col-8">
                    <label>Office</label>
                    <?php echo Form::text('office', $user->office, ['class' => 'form-control']); ?>

                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <label>Name</label>
                    <?php echo Form::text('full_name', $user->full_name, ['class' => 'form-control']); ?>

                </div>
                <div class="col-4">
                    <label>Email Address</label>
                    <?php echo Form::email('email', $user->email, ['class' => 'form-control']); ?>

                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <label>Enter New Password</label>
                    <?php echo Form::password('password', ['class' => 'form-control']); ?>

                </div>
                <div class="col-4">
                    <label>Confirm New Password</label>
                    <?php echo Form::password('password_confirmation', ['class' => 'form-control']); ?>

                </div>
            </div>
            <div class="row" style="margin-top:25px">
                <div class="col-4">
                    <?php echo Form::submit('Save Changes', ['class' => 'btn btn-primary']); ?>

                    <a a href="<?php echo e(route('users.index')); ?>" class="btn btn-danger">Cancel</a>
                </div>
            </div>

            <?php echo Form::hidden('id', $user->id); ?>

        <?php echo Form::close(); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/marklesterbolotaolo/Desktop/laravel/nfcqs1/resources/views/edit-user.blade.php ENDPATH**/ ?>