<div class="modal fade" id="popupForm" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['url' => 'map-display', 'method' => 'post', 'accept-charset' => 'UTF-8', 'id' => 'mapControlForm', 'class' => 'popup-form x-load show-map']) !!}
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fas fa-cog" style="color:orange"></i> Map Dashboard Settings</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="error-wrapper" style="display:none"></div>
                    <div class="row">
                        <div class="col-12">
                            <label>Commodity</label>
                            {!! Form::select('map_commodity', $commodities, '', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label>Province</label>
                            <input type="hidden" name="province_error" value="0" />
                            <div class="map-province-input-wrapper form-control">
                                . . .
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>Year</label>
                            {!! Form::select('map_year', ['' => ''], '', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-6">
                            <label>Model</label>
                            {!! Form::select('map_model', ['' => '', '1' => 'Logarithmic Time Trend', '2' => 'Annualized Growth Rate', '3' => 'Autoregressive Integrated Moving Average'], '', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::submit('Show Map', ['class' => 'btn btn-primary']) !!}
                    {!! Form::button('Close', ['class' => 'btn btn-danger', 'data-dismiss' => 'modal']) !!}
                    <input type="hidden" name="province_count" value="0" />
                </div>
            {!! Form::close() !!}
            <script type="text/javascript">
                var mapControlData = {!! json_encode($data) !!};
            </script>
        </div>
    </div>
</div>
    