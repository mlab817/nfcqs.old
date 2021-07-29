@extends('app')

@section('content')
<div id="page-content-wrapper">
    <div class="container-fluid">
        <h1 class="page-title"><i class="fas fa-info-circle"></i> Forecast Results for the {{ ($province != '...Philippines') ? 'Province of ' . $province : 'Philippines'}}</h1>
        {!! $chart->container() !!}
    </div>
</div>
@stop

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    {!! $chart->script() !!}
@endpush
