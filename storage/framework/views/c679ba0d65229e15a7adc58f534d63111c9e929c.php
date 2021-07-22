<?php $__env->startSection('content'); ?>
<div id="page-content-wrapper" class="map-wrapper">
    <div id="map"></div>
    <?php if(sizeof($kmls) != 0): ?>
        <div class="map-options">
            <div class="map-option-title">Layers</div>
            <div class="map-option-body">
                <?php $__currentLoopData = $kmls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="entry">
                        <div class="icon">
                            <i class="far fa-square map-layer-trigger" data-kml="<?php echo $key->kml_filename; ?>" data-checked=""></i>
                        </div>
                        <span><?php echo $key->description; ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBOl3WLnIMBvrastVYuEPbVGuBjKHBatUM"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            photos = <?php echo json_encode($photos); ?>;
            path = "<?php echo e($path); ?>";
            kml = "<?php echo e($kml); ?>";

            geotag.map.size();
            geotag.map.init();
            geotag.map.photos.marker(photos);
            geotag.map.kml('<?php echo e(url("uploads/geotag/kml/" . $kml)); ?>');

        }, false);
    </script>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>