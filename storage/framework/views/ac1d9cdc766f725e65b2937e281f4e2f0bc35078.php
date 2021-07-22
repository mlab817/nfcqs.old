<?php $__env->startSection('content'); ?>
<div id="page-content-wrapper" class="map-wrapper">
    <div id="map"></div>
    <?php if(sizeof($kmls) != 0 OR sizeof($albums) != 0): ?>
        <div class="map-layers">
            <div class="map-option-title"><i class="fas fa-layer-group"></i> LAYERS</div>
            <div class="map-option-body">
                <div class="layer-toggle">
                    <?php if(sizeof($kmls) != 0): ?>
                        <?php $__currentLoopData = $kmls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($key->modality != '' AND $key->modality != null): ?>
                                <label class="trigger trigger-checkbox map-layer-trigger">
                                    <div class="select-box">
                                        <input name="kml_map[]" type="checkbox" value="<?php echo e($key->kml_filename); ?>">
                                        <div class="trigger-indicator"></div>
                                    </div>
                                    <div class="select-text">
                                        <?php if($key->kml_class == 1): ?>
                                            Target
                                        <?php elseif($key->kml_class == 2): ?>
                                            Actual
                                        <?php endif; ?>
                                        &#x2192; <?php echo e(($key->modality != '') ? $key->modality : ''); ?>

                                        <div class="layer-type">kml</div>
                                    </div>
                                </label>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    <?php if(sizeof($kmls) != 0 AND sizeof($albums) != 0): ?>
                        <div style="display:block; margin:10px 0; height:1px; background-color:#ddd"></div>
                    <?php endif; ?>
                    <?php if(sizeof($albums) != 0): ?>
                        <?php $__currentLoopData = $albums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="trigger trigger-checkbox map-layer-album">
                                <div class="select-box">
                                    <input name="albums[]" type="checkbox" value="<?php echo e($key->id); ?>" <?php echo e(($albumId == $key->id) ? 'checked="checked"' : ''); ?>>
                                    <div class="trigger-indicator"></div>
                                </div>
                                <div class="select-text">
                                    <?php echo e(($key->modality_code != '') ? $key->modality_code . ' &#x2192; ' : ''); ?>

                                    <?php echo e($key->description); ?>

                                    <div class="layer-type">photo</div>
                                </div>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
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
            geotag.map.photos.addMarkers(photos);

            // viewing polygon | not photo album
            <?php if($kml != '' AND $kml != null): ?>
                geotag.map.addKml('<?php echo e(url("uploads/geotag/kml/" . $kml)); ?>', 'map');
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