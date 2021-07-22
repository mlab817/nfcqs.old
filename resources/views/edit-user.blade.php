@extends('app')
@section('content')
<div id="page-content-wrapper">
    <div class="container-fluid">
        <h1 class="page-title"><i class="fas fa-info-circle"></i> Edit System User</h1>
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
        {!! Form::open(['url' => 'user/update', 'method' => 'post']) !!}
            <div class="row">
                <div class="col-8">
                    <label>Office</label>
                    {!! Form::text('office', $user->office, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <label>Name</label>
                    {!! Form::text('full_name', $user->full_name, ['class' => 'form-control']) !!}
                </div>
                <div class="col-4">
                    <label>Email Address</label>
                    {!! Form::email('email', $user->email, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <label>Enter New Password</label>
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>
                <div class="col-4">
                    <label>Confirm New Password</label>
                    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row" style="margin-top:25px">
                <div class="col-4">
                    {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
                    <a a href="{{ url('users') }}" class="btn btn-danger">Cancel</a>
                </div>
            </div>

            {!! Form::hidden('id', $id) !!}
        {!! Form::close() !!}
    </div>
</div>
@stop
