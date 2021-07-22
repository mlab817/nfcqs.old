<div class="popup-dashboard">
        <span class="close-dashboard">×</span>
        <div class="popup-left" style="width: 75%;">
            <div class="current-photo">
                <?php 
                    $urlCallback = ''; 
                    $latCallback = 0;
                    $lngCallback = 0;
                    
                    $dispPrev = false;
                    $dispNext = false;
                    
                    if ($prev != null) {
                        $urlCallback = url('geotag/update-dashboard?photo=' . $prev->geotag_filename . '&album_id=' . $albumId . '&contract_id=' . $contractId); 
                        $latCallback = $prev->geotag_lat;
                        $lngCallback = $prev->geotag_lng;
                        $dispPrev = true;
                    }
                    
                    if ($next != null) {
                        $urlCallback = ($urlCallback == '') ? url('geotag/update-dashboard?photo=' . $next->geotag_filename . '&album_id=' . $albumId . '&contract_id=' . $contractId) : $urlCallback; 
                        $latCallback = ($latCallback == 0) ? $next->geotag_lat : $latCallback;
                        $lngCallback = ($lngCallback == 0) ? $next->geotag_lat : $lngCallback;
                        $dispNext = true;
                    }
                ?>
                <div class="prev" style="<?php echo e((!$dispPrev) ? 'display:none' : ''); ?>">
                    <a class="geotag-photo-navigation" href="<?php echo e(url('geotag/update-dashboard?photo=' . @$prev->geotag_filename . '&album_id=' . $albumId . '&contract_id=' . $contractId)); ?>" data-lat="<?php echo e(@$prev->geotag_lat); ?>" data-lng="<?php echo e(@$prev->geotag_lng); ?>"></a>
                </div>
                <div class="next" style="<?php echo e((!$dispNext) ? 'display:none' : ''); ?>">
                    <a class="geotag-photo-navigation" href="<?php echo e(url('geotag/update-dashboard?photo=' . @$next->geotag_filename . '&album_id=' . $albumId . '&contract_id=' . $contractId)); ?>" data-lat="<?php echo e(@$next->geotag_lat); ?>" data-lng="<?php echo e(@$next->geotag_lng); ?>"></a>
                </div>
                <img src="<?php echo e(url('uploads/geotag/img/' . $photo)); ?>">
                <div class="photo-action delete-photo" id="deletePhoto" data-photo="<?php echo e($photo); ?>" data-callback="<?php echo e($urlCallback); ?>" data-link="<?php echo e(url('geotag/album?albumId=' . $albumId . '&contractId=' . $contractId)); ?>" data-lat="<?php echo e($latCallback); ?>" data-lng="<?php echo e($lngCallback); ?>">
                    <?php echo Form::open(['url' => 'geotag/delete-photo', 'metdod' => 'post', 'accept-charset' => 'UTF-8', 'id' => 'deleteGeotagPhoto']); ?>

                        <span><i class="fas fa-trash-alt"></i>Delete This Photo</span>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
        <div class="popup-right">
            <div class="contract-info">
                <b><i class="fa fa-code" aria-hidden="true" style="color:orange"></i> <?php echo e($contract->contract_code); ?></b>
                <span>Activity: <?php echo e($album->description); ?></span>
    
                
    
                <span>Date: <?php echo e(date("M d, Y", strtotime($album->report_date))); ?></span>
                <span class="gps-lat">Latitude: <?php echo e(number_format($gps->geotag_lat, 5)); ?></span>
                <span class="gps-lng">Longitude: <?php echo e(number_format($gps->geotag_lng, 5)); ?></span>
            </div>
            <div id="dashboard-map"></div>
            <div class="compare-control" style="<?php echo e((!sizeof($nearbyPhotos)) ? 'display:none' : ''); ?>">
                <span><i class="fa fa-street-view" aria-hidden="true" style="color:green; margin-right:5px"></i>Nearby Photos (*max 15 meters distance*)</span>
                <div class="compare-options">
                    <?php if(sizeof($nearbyPhotos) != 0): ?>
                        <?php for($i = 0; $i < sizeof($nearbyPhotos); $i++): ?>
                            <div 
                                class="compare-thumb" 
                                style="background:url('<?php echo e(url('uploads/geotag/img/thumbnail/' .$nearbyPhotos[$i]['photo'])); ?>') no-repeat; background-size: cover"
                                data-lat="<?php echo e($nearbyPhotos[$i]['latitude']); ?>"
                                data-lng="<?php echo e($nearbyPhotos[$i]['longitude']); ?>"
                                data-date="<?php echo e($nearbyPhotos[$i]['date']); ?>"
                                data-time="<?php echo e($nearbyPhotos[$i]['time']); ?>"
                                data-desc="<?php echo e($nearbyPhotos[$i]['description']); ?>"
                                data-photo=<?php echo e($nearbyPhotos[$i]['photo']); ?>

                                data-path=<?php echo e(url('uploads/geotag/img/' . $nearbyPhotos[$i]['photo'])); ?>

                                data-url="<?php echo e(url('geotag/compare-photo')); ?>">
                                <div class="info"><?php echo e($nearbyPhotos[$i]['distance']); ?> M</div>
                            </div>
                        <?php endfor; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php if(sizeof($kmls) != 0): ?>
                <div class="kml-control">
                    <span><i class="fa fa-map-signs" aria-hidden="true" style="color:green; margin-right:5px"></i>Contract Polygons & Polylines</span>
                    <div class="layer-toggle" style="margin:0 5px 10px">
                        <?php $__currentLoopData = $kmls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($key->modality != '' AND $key->modality != null): ?>
                                <label class="trigger trigger-checkbox">
                                    <div class="select-box">
                                        <input name="kml_mini[]" type="checkbox" value="<?php echo e($key->kml_filename); ?>" data-url="<?php echo e(url('uploads/geotag/kml')); ?>">
                                        <div class="trigger-indicator"></div>
                                    </div>
                                    <div class="select-text">
                                        <?php if($key->kml_class == 1): ?>
                                            Target
                                        <?php elseif($key->kml_class == 2): ?>
                                            Actual
                                        <?php endif; ?>
                                        &#x2192; <?php echo e(($key->modality != '') ? $key->modality : ''); ?>

                                    </div>
                                </label>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    