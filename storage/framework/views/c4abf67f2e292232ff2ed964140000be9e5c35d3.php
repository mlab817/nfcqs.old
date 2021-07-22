<?php $__env->startSection('content'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <h1 class="page-title"><i class="fas fa-list" style="margin-right:5px"></i> Peoples Organization</h1>
        <div class="table-settings-icon-wrapper">
            <a href="<?php echo e(url('po-list/columns')); ?>" class="set-po-list-columns btn btn-secondary"><i class="fas fa-pencil-alt" style="margin-right:5px"></i>  Add or Remove Columns</a>
        </div>
        <div class="po-list">
            ...
        </div>
    </div>
</div>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) { 
        getPoContent("<?php echo e(url('po-list/content')); ?>");
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>