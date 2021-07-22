<?php $__env->startSection('content'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <h1 class="page-title"><i class="fas fa-list" style="margin-right:5px"></i> List of Projects</h1>
        <div class="table-settings-icon-wrapper">
            <a href="<?php echo e(url('project-list/columns')); ?>" class="set-project-list-columns btn btn-secondary"><i class="fas fa-pencil-alt" style="margin-right:5px"></i>  Add or Remove Columns</a>
        </div>
        <div class="project-list">
            ...
        </div>
    </div>
</div>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) { 
        getProjectContent("<?php echo e(url('project-list/content')); ?>");
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>