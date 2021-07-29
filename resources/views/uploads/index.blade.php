<div class="modal fade" id="popupForm" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['url' => 'uploads.store', 'method' => 'post', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8', 'id' => 'commodityForm', 'class' => 'popup-form x-load-file']) !!}
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><i class="fas fa-pencil-alt" style="color:orange"></i> Upload Official Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="response-wrapper"></div>
                <div class="row">
                    <div class="col-12">
                        <label>Commodity</label>
                        {!! Form::select('commodity_id', $commodities, 1, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label class="commodity-name">
                            Commodity Data
                            <a href="#">Template</a>
                        </label>
                        {!! Form::file('commodity_data', ['class' => 'form-control','accept' => '.csv']) !!}
                        <small>The file must have a year, province production and area harvested column for crops
                            and year, province, and production for non-crops. The first row is expected to be the headers.
                        </small>
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