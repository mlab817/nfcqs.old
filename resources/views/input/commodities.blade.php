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
                            <a style="font-weight:normal; font-size:11px" href="{{ url('province?download=no&model=1&key='. $key) }}" title="Logarithmic Time Trend">LOG</a> <span style="font-weight:normal">|</span> <a style="font-weight:normal; font-size:11px; color:green" href="{{ url('province?download=no&model=2&province=' . $key->province) }}" title="Annualized Growth Rate">AGR</a> <span style="font-weight:normal">|</span> <a style="font-weight:normal; font-size:11px; color:orange" href="{{ url('province?download=no&model=3&province=' . $key->province) }}" title="Autoregressive Integrated Moving Average">ARIMA</a>
                        </div>
                    </div>
                    @foreach ($key->crops->groupBy('src_commodity_id') as $key => $k)
                        <div style="display:block" style="margin-top:20px">
                            {{ \App\Models\SrcCommodity::find($key)->commodity }}
                            <i class="fas fa-long-arrow-alt-right"></i>
                            <a style="font-weight:normal; font-size:11px" href="{{ url('province?download=no&model=1&key='. $key) }}" title="Logarithmic Time Trend">LOG</a> <span style="font-weight:normal">|</span> <a style="font-weight:normal; font-size:11px; color:green" href="{{ url('province?download=no&model=2&province=' . $key) }}" title="Annualized Growth Rate">AGR</a> <span style="font-weight:normal">|</span> <a style="font-weight:normal; font-size:11px; color:orange" href="{{ url('province?download=no&model=3&province=' . $key) }}" title="Autoregressive Integrated Moving Average">ARIMA</a>
                        </div>
                        <table style="margin-bottom:20px">
                            <tbody>
                                @foreach($k as $c)
                                    <tr>
                                        <td class="commodity-name" style="width:20%">{{ $c->commodity->commodity }}</td>
                                        <td class="crop-type" style="width:20%">{{ $c->commodity->crop_type }}</td>
                                        <td style="width:80px">{{ ($c->remarks != null) ? \Illuminate\Support\Str::limit($c->remarks,60) : '' }}</td>
                                        <td class="actions">
                                            <a href="{{ route('download_file', ['filePath' => $c->crop_data_filename]) }}" style="white-space:nowrap" title="Download the file"><i class="fas fa-file-download"></i>Commodity Data</a>
                                            <a href="{{ route('download_file', ['filePath' => $c->pop_data_filename]) }}" style="white-space:nowrap" title="Download the file"><i class="fas fa-file-download"></i>Population Growth Rate</a>
                                            <a href="{{ url('shifter?key=' . $c->id) }}" style="white-space:nowrap" class="open-popup"><i class="far fa-play-circle"></i>Run Forecast Models</a>
                                            @if ($c->remarks != null)
                                                <a href="{{ url('result?key=' . $c->id) }}" style="white-space:nowrap; color:orange"><i class="fas fa-chart-line"></i>View Forecast Result</a>
                                            @endif
                                            <form action="{{ route('delete_crop', ['crop' => $c]) }}" method="POST" id="delete_record_{{$c->id}}">
                                                @csrf
                                                @method('DELETE')
                                                <a
                                                    onclick="confirm('Are you sure you want to delete this item?'); return document.getElementById('delete_record_{{$c->id}}').submit()"
                                                    href="javascript:{}"
                                                    role="button"
                                                    style="white-space:nowrap; color:red">
                                                    <i class="fas fa-trash"></i>
                                                    Delete
                                                </a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            <tbody>
                        </table>
                    @endforeach
                @endforeach
            @endif
        </div>
    </div>
</div>
@stop
