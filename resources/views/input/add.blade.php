<div class="modal fade" id="popupForm" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['url' => 'commodities/add', 'method' => 'post', 'accept-charset' => 'UTF-8', 'id' => 'commodityForm', 'class' => 'popup-form x-load-file']) !!}
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"><i class="fas fa-pencil-alt" style="color:orange"></i> Forecast Data Requirements</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="response-wrapper"></div>
                        <div class="row">
                            <div class="col-6">
                                <label>Province</label>
                                {!! Form::select('province_id', $provinces, '', ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-6">
                                <label>Commodity</label>
                                {!! Form::select('commodity_id', $commodities, '', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label title="Most recent actual population">Population</label>
                                {!! Form::text('population', '', ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-4">
                                <label title="Year of actual population data">Population Year</label>
                                {!! Form::text('year', '', ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-4">
                                <label title="Conversion Rate (in Percent)">Conversion Rate (%)</label>
                                {!! Form::text('conversion_rate', '', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label title="Per Capita Consumption for the Province (in Kilogram)">Per Capita Consumption (in kg/YR)</label>
                                {!! Form::text('per_capita', '', ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-6">
                                <label title="Year of actual per capita consumption">Per Capita Consumption Year</label>
                                {!! Form::text('per_capita_year', '', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="commodity-name">Commodity Data</label>
                                {!! Form::file('commodity_data', ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-6">
                                <label>Population Growth Rate</label>
                                {!! Form::file('pop_growth_rate', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                        {!! Form::button('Close', ['class' => 'btn btn-danger', 'data-dismiss' => 'modal']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
        