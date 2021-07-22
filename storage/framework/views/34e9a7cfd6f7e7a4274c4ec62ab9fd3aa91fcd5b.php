<?php $__env->startSection('content'); ?>
<div id="page-content-wrapper" class="map-wrapper">
    <div id="map"></div>
    <?php if(sizeof($kmls) != 0): ?>
        <div class="map-options">
            <div class="map-option-title"><i class="fas fa-layer-group"></i> KML FILES</div>
            <div class="map-option-body">

                

                <div class="kml-toggle">
                    <?php $__currentLoopData = $kmls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($key->modality != '' AND $key->modality != null): ?>
                            <label class="trigger trigger-checkbox map-layer-trigger">
                                <div class="select-box">
                                    <input name="kml_map[]" type="checkbox" value="<?php echo e($key->kml_filename); ?>">
                                    <div class="trigger-indicator"></div>
                                </div>
                                <div class="select-text">
                                    <?php echo e(isset($key->modality_code) ? $key->modality_code : $key->modality); ?> / 
                                    <?php if($key->kml_class == 1): ?>
                                        Contracted
                                    <?php elseif($key->kml_class == 2): ?>
                                        Accomplished
                                    <?php endif; ?>
                                </div>
                            </label>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBOl3WLnIMBvrastVYuEPbVGuBjKHBatUM"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            photos = <?php echo json_encode($photos); ?>;
            path = "<?php echo e($path); ?>";
            kml = "<?php echo e($kml); ?>";

            // map container
            // the same height as sidebar menu
            geotag.map.size();

            // initialize the map
            geotag.map.init('map');

            // display photo markers on map
            geotag.map.photos.marker(photos);

            // viewing polygon | not photo album
            <?php if($kml != '' AND $kml != null): ?>
                geotag.map.kml('<?php echo e(url("uploads/geotag/kml/" . $kml)); ?>');
            <?php endif; ?>

            // hide elements
            $('.current-user, .report-icons').hide();

            // update size of map container when window is resized
            $(window).resize(function() {
                geotag.map.size();
            });

        }, false);
    </script>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>