@extends('app')

@section('content')
<div id="page-content-wrapper">
    <div class="container-fluid">
        <h1 class="page-title"><i class="fa fa-leaf" style="color:green"></i> Commodities by Province</h1>
        <div class="commodity-list">
            @if (sizeof($data) != 0)
                @foreach ($data as $key)
                    <div style="display:block">
                        <div class="province-name" title="Download in Excel">
                            {{ $key->province }}
                            <i class="fas fa-long-arrow-alt-right"></i>
                            <a style="font-weight:normal; font-size:11px" href="{{ url('province?download=no&model=1&province=' . $key->province) }}" title="Logarithmic Time Trend">LOG</a> <span style="font-weight:normal">|</span> <a style="font-weight:normal; font-size:11px; color:green" href="{{ url('province?download=no&model=2&province=' . $key->province) }}" title="Annualized Growth Rate">AGR</a> <span style="font-weight:normal">|</span> <a style="font-weight:normal; font-size:11px; color:orange" href="{{ url('province?download=no&model=3&province=' . $key->province) }}" title="Autoregressive Integrated Moving Average">ARIMA</a>
                        </div>
                    </div>
                    <table style="margin-bottom:50px">
                        <tbody>
                            @foreach ($key->crops as $k)
                                <tr>
                                    <td class="commodity-name" style="width:20%">{{ $k->commodity->commodity }}</td>
                                    <td class="crop-type" style="width:20%">{{ $k->commodity->crop_type }}</td>
                                    <td style="width:80px">{{ ($k->remarks != null) ? \Illuminate\Support\Str::limit($k->remarks,60) : '' }}</td>
                                    <td class="actions">
                                        <a href="{{ route('download_file', ['filePath' => $k->crop_data_filename]) }}" style="white-space:nowrap" title="Download the file"><i class="fas fa-file-download"></i>Commodity Data</a>
                                        <a href="{{ route('download_file', ['filePath' => $k->pop_data_filename]) }}" style="white-space:nowrap" title="Download the file"><i class="fas fa-file-download"></i>Population Growth Rate</a>
                                        <a href="{{ url('shifter?key=' . $k->id) }}" style="white-space:nowrap" class="open-popup"><i class="far fa-play-circle"></i>Run Forecast Models</a>
                                        @if ($k->remarks != null)
                                            <a href="{{ url('result?key=' . $k->id) }}" style="white-space:nowrap; color:orange"><i class="fas fa-chart-line"></i>View Forecast Result</a>
                                        @endif
                                        <a href="{{ url('crop/delete?key=' . $k->id) }}" class="delete-record" style="white-space:nowrap; color:red"><i class="fas fa-trash"></i>Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        <tbody>
                    </table>
                @endforeach
            @endif
        </div>
    </div>
</div>
@stop
