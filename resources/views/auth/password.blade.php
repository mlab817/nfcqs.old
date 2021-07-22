<div class="modal fade" id="popupForm">
    <div class="modal-dialog">
        <div class="modal-content" style="width:450px; margin:25px auto">
            {!! Form::open(['url' => 'change-password', 'method' => 'post', 'class' => 'x-load', 'data-goto' => url('logout')]) !!}
                <div class="modal-header">
                    <h4 class="modal-title" style="display:inline-block">Update Password</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" style="font-size:16px">
                    <div class="row" style="padding:0 25px">
                        <div class="col-6" style="padding:0 10px 0 0">
                            <label>Password</label>
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-6" style="padding:0 0 0 10px">
                            <label>Re-Type Password</label>
                            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::submit('Update', ['class' => 'btn btn-primary', 'style' => 'margin-right:10px']) !!}
                    {!! Form::button('Close', ['class' => 'btn btn-danger', 'data-dismiss' => 'modal']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
