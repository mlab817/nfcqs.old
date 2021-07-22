@extends('app')
@section('content')
<div id="page-content-wrapper">
    <div class="container-fluid">
        <h1 class="page-title"><i class="fa fa-list" aria-hidden="true"></i> Project Reports</h1>
        <div class="report-list">
            @if (sizeof($data) != 0)
                @foreach ($data as $key)
                    <div class="row">
                        <div class="col-4">{{ $key->remarks }}</div>
                        <div class="col-2">{{ date('F d, Y', strtotime($key->created_at)) }}</div>
                        <div class="col-2"><a href="{{ url($key->filename) }}"><i class="fas fa-file-download"></i>Download</a></div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@stop
