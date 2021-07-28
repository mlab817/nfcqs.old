<div class="modal fade" id="popupForm" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo Form::open(['url' => 'commodities/add', 'method' => 'post', 'accept-charset' => 'UTF-8', 'id' => 'commodityForm', 'class' => 'popup-form x-load-file']); ?>

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fas fa-pencil-alt" style="color:orange"></i> Forecast Data Requirements</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="response-wrapper"></div>
                    <div class="row">
                        <div class="col-6">
                            <label>Province</label>
                            <?php echo Form::select('province_id', $provinces, 1, ['class' => 'form-control']); ?>

                        </div>
                        <div class="col-6">
                            <label>Commodity</label>
                            <?php echo Form::select('commodity_id', $commodities, 1, ['class' => 'form-control']); ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label title="Most recent actual population">Population</label>
                            <?php echo Form::text('population', 1000000, ['class' => 'form-control']); ?>

                        </div>
                        <div class="col-4">
                            <label title="Year of actual population data">Population Year</label>
                            <?php echo Form::text('year', 2010, ['class' => 'form-control']); ?>

                        </div>
                        <div class="col-4">
                            <label title="Conversion Rate (in Percent)">Conversion Rate (%)</label>
                            <?php echo Form::text('conversion_rate', 65.4, ['class' => 'form-control']); ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label title="Per Capita Consumption for the Province (in Kilogram)">Per Capita Consumption (in kg/YR)</label>
                            <?php echo Form::text('per_capita', 109.26, ['class' => 'form-control']); ?>

                        </div>
                        <div class="col-6">
                            <label title="Year of actual per capita consumption">Per Capita Consumption Year</label>
                            <?php echo Form::text('per_capita_year', 2009, ['class' => 'form-control']); ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="commodity-name">
                                Commodity Data
                                <a href="#">Template</a>
                            </label>
                            <?php echo Form::file('commodity_data', ['class' => 'form-control','accept' => '.csv,.txt']); ?>

                        </div>
                        <div class="col-6">
                            <label>
                                Population Growth Rate
                                <a href="#">Template</a>
                            </label>
                            <?php echo Form::file('pop_growth_rate', ['class' => 'form-control','accept' => '.csv,.txt']); ?>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php echo Form::submit('Save', ['class' => 'btn btn-primary']); ?>

                    <?php echo Form::button('Close', ['class' => 'btn btn-danger', 'data-dismiss' => 'modal']); ?>

                </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
        <?php /**PATH /Users/marklesterbolotaolo/Desktop/laravel/nfcqs/resources/views/input/add.blade.php ENDPATH**/ ?>