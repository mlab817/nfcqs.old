@extends('../app')
@section('content')
<div id="page-content-wrapper">
    <div class="container-fluid">
        <h1 class="page-title"><i class="fas fa-info-circle"></i> Register New User</h1>
        @if ($errors->any())
            <div class="row">
                <div class="col-8">
                    <div class="alert alert-danger" role="alert">
                        {!! implode('', $errors->all('<div>:message</div>')) !!}
                    </div>
                </div>
            </div>
        @elseif (isset($msg))
            <div class="row">
                <div class="col-8">
                    <div class="alert alert-success" role="alert">
                        {{ $msg }}
                    </div>
                </div>
            </div>
        @endif
        {!! Form::open(['url' => 'register', 'method' => 'post']) !!}
            <div class="row">
                <div class="col-8">
                    <label>Office</label>
                    {!! Form::text('office', old('office'), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <label>Name</label>
                    {!! Form::text('full_name', '', ['class' => 'form-control']) !!}
                </div>
                <div class="col-4">
                    <label>Email Address</label>
                    {!! Form::email('email', '', ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <label>Password</label>
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>
                <div class="col-4">
                    <label>Confirm Password</label>
                    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row" style="margin-top:25px">
                <div class="col-4">
                    {!! Form::submit('Register', ['class' => 'btn btn-primary']) !!}
                    {!! Form::reset('Clear Form', ['class' => 'btn btn-danger']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
