<div class="modal fade" id="popupForm" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <?php echo Form::open(['url' => 'forecast?key=' . $key, 'method' => 'post', 'accept-charset' => 'UTF-8', 'id' => 'shifterForm', 'class' => 'popup-form x-load']); ?>

                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"><i class="fas fa-cog"></i> Growth Rate Shifters</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="response-wrapper"></div>
                        <div class="row">
                            <?php if($commodity->crop_type == 'Crop'): ?>
                                <div class="col-4">
                                    <label>Area (%)</label>
                                    <?php echo Form::text('area', ($shifter != null) ? $shifter->area * 100 : '', ['class' => 'form-control', 'placeholder' => '0.00', 'style=""']); ?>

                                </div>
                                <div class="col-4">
                                    <label>Yield (%)</label>
                                    <?php echo Form::text('yield', ($shifter != null) ? $shifter->yield * 100 : '', ['class' => 'form-control', 'placeholder' => '0.00', 'style=""']); ?>

                                </div>
                                <div class="col-4">
                                    <label>Consumption (%)</label>
                                    <?php echo Form::text('consumption', ($shifter != null) ? $shifter->consumption * 100 : '', ['class' => 'form-control', 'placeholder' => '0.00', 'style=""']); ?>

                                </div>
                            <?php else: ?>
                                <div class="col-6">
                                    <label>Production (%)</label>
                                    <?php echo Form::text('production', ($shifter != null) ? $shifter->production * 100 : '', ['class' => 'form-control', 'placeholder' => '0.00', 'style=""']); ?>

                                </div>
                                <div class="col-6">
                                    <label>Consumption (%)</label>
                                    <?php echo Form::text('consumption', ($shifter != null) ? $shifter->consumption * 100 : '', ['class' => 'form-control', 'placeholder' => '0.00', 'style=""']); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label>Remarks</label>
                                <?php echo Form::textarea('remarks', '', ['class' => 'form-control', 'placeholder' => 'Enter Remarks ...', 'rows' => '2']); ?>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        
                        <?php echo Form::submit('Generate Forecast', ['class' => 'btn btn-primary']); ?>

                        <?php echo Form::button('Close', ['class' => 'btn btn-danger', 'data-dismiss' => 'modal']); ?>

                    </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
        