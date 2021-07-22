<div class="modal fade" id="popupForm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <?php echo Form::open(['url' => 'geotag/delete-photo', 'metdod' => 'post', 'accept-charset' => 'UTF-8', 'id' => 'deleteGeotagPhoto']); ?>

                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel"><i class="fas fa-qrcode" style="color:orange"></i> Geotag Photo</h4>
                    <a href="<?php echo e(url('geotag/album?albumId=' . $albumId . '&contractId=' . $contractId)); ?>" class="open-popup close" style="text-decoration:none; color:#222" data-dismiss="modal" aria-label="Close">×</a>
                </div>
                <div class="modal-body" style="background-color:#fafafa">
                    <div class="geotag-photos" style="margin-top:0">
                        <div class="row" style="padding:0 15px">
                            <div class="col-9" style="padding-left:0">
                                <?php echo Form::text('description', @$album->description, ['class' => 'form-control semi-text', 'placeholder' => 'Album Description', 'readonly' => 'readonly']); ?>

                            </div>
                            <div class="col-3" style="padding-right:0">
                                <?php echo Form::text('report_date', (@$album != '') ? date('Y-m-d', strtotime(@$album->report_date)) : '', ['class' => 'form-control semi-text', 'placeholder' => 'Report Date', 'readonly' => 'readonly']); ?>

                            </div>
                        </div>
                        <div class="single-photo">
                            <img src="<?php echo e(url('uploads/geotag/img/' . $photo)); ?>" />
                        </div>
                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo e(url('geotag/album?albumId=' . $albumId . '&contractId=' . $contractId)); ?>" class="open-popup btn btn-secondary" data-dismiss="modal" aria-label="Close"><i class="fa fa-level-up" aria-hidden="true"></i> Go Back</a>
                    <button type="button" class="btn btn-danger" id="deletePhoto" data-photo="<?php echo e($photo); ?>" data-link="<?php echo e(url('geotag/album?albumId=' . $albumId . '&contractId=' . $contractId)); ?>"><i class="fas fa-trash-alt"></i>Delete This Photo</button>
                </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
