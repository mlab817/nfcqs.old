<div class="modal fade" id="popupForm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <?php echo Form::open(['url' => 'geotag', 'metdod' => 'post', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8', 'id' => 'uploadGeotagPhotos']); ?>

                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel"><i class="fas fa-qrcode" style="color:orange"></i>
                        <?php if(@$album->is_shapefile == 0): ?>
                            Geotag Photos
                        <?php else: ?>
                            Contract Shape File
                        <?php endif; ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="background-color:#fafafa; padding:0 0 15px 0">
                    <div class="row" style="padding:10px">
                        <div class="col-3">
                            <?php echo Form::select('modality_id', $modalities, @$album->modality_id, ['class' => 'form-control semi-text']); ?>

                        </div>
                        <div class="col-3">
                            <div class="form-control semi-text">
                                <label style="margin-bottom:0; padding-bottom:0; margin-right:5px"><?php echo Form::radio('kml_class', 1, (@$album->kml_class == 1) ? true : false); ?> Target</label>
                                <label style="margin-bottom:0; padding-bottom:0"><?php echo Form::radio('kml_class', 2, (@$album->kml_class == 2) ? true : false); ?> Actual</label>
                            </div>
                        </div>
                        <div class="col-4">
                            
                            <?php echo Form::select('description', $activities, @$album->description, ['class' => 'form-control semi-text']); ?>

                        </div>
                        <div class="col-2">
                            <?php echo Form::text('report_date', (@$album != '') ? date('Y-m-d', strtotime(@$album->report_date)) : '', ['class' => 'form-control semi-text pick-date', 'placeholder' => 'Report Date']); ?>

                        </div>
                    </div>
                    <div class="geotag-photos" style="padding: 0 25px">
                        <div class="upload-photo thumb-item" title="Create New Album">
                            <i class="far fa-image"></i>
                            <input type="file" name="photos" id="photos" title="Choose geotag photos" multiple="multiple" <?php echo e(($albumId == 0) ? "disabled='disabled'" : ''); ?> />
                        </div>
                        <?php if(sizeof($kml) != 0): ?>
                            <?php $__currentLoopData = $kml; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="view-map-btn thumb-item" data-map="<?php echo e(url('map?kml=' . $key->kml_filename)); ?>"><i class="fas fa-map-signs" style="color:orange"></i></div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php elseif(sizeof($photos) != 0): ?>
                            <div class="view-map-btn thumb-item" data-map="<?php echo e(url('map?albumId=' . $albumId)); ?>"><i class="fas fa-map-signs" style="color:orange"></i></div>
                        <?php endif; ?>
                        <?php if(sizeof($photos) != 0): ?>
                            <?php $__currentLoopData = $photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a class="thumbnail thumb-item no-border-thumb open-geotag-dashboard" href="<?php echo e(url('geotag/open-dashboard?photo=' . $key->geotag_filename . '&album_id=' . $albumId . '&contract_id=' . $contractId)); ?>" style="background:url('<?php echo e(url('uploads/geotag/img/thumbnail/' . $key->geotag_filename)); ?>') no-repeat; background-size: cover" data-lat="<?php echo e($key->geotag_lat); ?>" data-lng="<?php echo e($key->geotag_lng); ?>"></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="modal-footer">
                    <div style="border:2px solid orange; padding:4px 10px 4px; border-radius:5px; position:relative">
                        <div style="display:inline-block; padding-right:10px">
                            <label>Contract shape file?</label>
                        </div>
                        <div style="display:inline-block; padding-right:10px">
                            <label style="margin-bottom:0"><?php echo Form::radio('is_shapefile', 1, (@$album->is_shapefile) ? true : false, ['style'=>'margin-bottom:-1px']); ?> Yes</label>
                        </div>
                        <div style="display:inline-block">
                            <label style="margin-bottom:0"><?php echo Form::radio('is_shapefile', 0, (@$album->is_shapefile) ? false : true, ['style'=>'margin-bottom:-1px']); ?> No</label>
                        </div>
                    </div>
                    <input type="hidden" name="contract_id" value="<?php echo e($contractId); ?>" />
                    <input type="hidden" name="album_id" value="<?php echo e($albumId); ?>" />
                    <button type="button" class="btn btn-primary" id="saveAlbumDetails"><i class="far fa-hdd"></i>Save album details</button>
                    <button type="button" class="btn btn-danger" id="deleteAlbum" data-album="<?php echo e($albumId); ?>"><i class="fas fa-trash-alt"></i>Delete</button>
                </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
