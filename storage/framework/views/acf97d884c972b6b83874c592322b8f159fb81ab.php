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
                <div class="modal-body" style="background-color:#fafafa">
                    <div class="row">
                        <div class="col-9" style="padding-left:0">
                            <?php echo Form::text('description', @$album->description, ['class' => 'form-control semi-text', 'placeholder' => 'Album Description']); ?>

                        </div>
                        <div class="col-3" style="padding-right:0">
                            <?php echo Form::text('report_date', (@$album != '') ? date('m/d/Y', strtotime(@$album->report_date)) : '', ['class' => 'form-control semi-text pick-date', 'placeholder' => 'Report Date']); ?>

                        </div>
                    </div>
                    <div class="geotag-photos">
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
                                <!-- <div class="thumbnail no-border-thumb" data-sort="<?php echo e(strtotime($key->geotag_datetime)); ?>" data-filename="<?php echo e($key->geotag_filename); ?>" data-latlng="<?php echo e($key->geotag_lat.','.$key->geotag_lng); ?>" data-url="<?php echo e(url('uploads/geotag/img/' . $key->geotag_filename)); ?>" style="background:url('<?php echo e(url('uploads/geotag/img/thumbnail/' . $key->geotag_filename)); ?>') no-repeat; background-size: cover"></div> -->
                                <a class="thumbnail thumb-item no-border-thumb open-popup" href="<?php echo e(url('geotag/photo?photo=' . $key->geotag_filename)); ?>" style="background:url('<?php echo e(url('uploads/geotag/img/thumbnail/' . $key->geotag_filename)); ?>') no-repeat; background-size: cover"></a>
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
