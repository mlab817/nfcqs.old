@extends('app')
@section('content')
<style>
    table tr th {background-color:#f4f4f4; border:1px solid #ddd}
    table tr td {text-align:center}
</style>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <h1 class="page-title"><i class="fas fa-info-circle"></i> Forecast Results for {{ $crop->commodity }} - {{ ($crop->province == '...Philippines') ? 'Philippines' : $crop->province }}</h1>
        <div style="width:100%">
            <div class="row">
                <div class="col-12">
                    <div id="line-graph-production" style="width:100%; height:350px; border:1px solid #ddd; margin:0"></div>
                </div>
                <div class="col-12" style="display:{{ ($displayTable != 'yes') ? 'none' : 'block'}}">
                    <table style="border:1px solid #ddd">
                        <thead>
                            <tr>
                                <th rowspan="2">Year</th>
                                @if ($withBaseline != 0)
                                    <th colspan="4">Production Forecast by Model</th>
                                @else
                                    <th colspan="3">Production Forecast by Model</th>
                                @endif
                            </tr>
                            <tr>
                                @if ($withBaseline != 0)
                                    <th>Baseline</th>
                                @endif
                                <th>Autoregressive Integrated Moving Average</th>
                                <th>Annualized Growth Rate</th>
                                <th>Logarithmic Time Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 1; $i < sizeof($chart[0]); $i++)
                                <tr>
                                    @if ($withBaseline != 0)
                                        <td>{{ $chart[0][$i][0] }}</td>
                                        <td>{{ number_format($chart[0][$i][1], 2) }}</td>
                                        <td>{{ number_format($chart[0][$i][2], 2) }}</td>
                                        <td>{{ number_format($chart[0][$i][3], 2) }}</td>
                                        <td>{{ number_format($chart[0][$i][4], 2) }}</td>
                                    @else
                                        <td>{{ $chart[0][$i][0] }}</td>
                                        <td>{{ number_format($chart[0][$i][1], 2) }}</td>
                                        <td>{{ number_format($chart[0][$i][2], 2) }}</td>
                                        <td>{{ number_format($chart[0][$i][3], 2) }}</td>
                                    @endif
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div id="line-graph-consumption" style="width:100%; height:350px; border:1px solid #ddd; margin:0"></div>
                </div>
                <div class="col-12" style="display:{{ ($displayTable != 'yes') ? 'none' : 'block'}}">
                    <table style="border:1px solid #ddd">
                        <thead>
                            <tr>
                                <th rowspan="2">Year</th>
                                @if ($withBaseline != 0)
                                    <th colspan="4">Consumption Forecast by Model</th>
                                @else
                                    <th colspan="3">Consumption Forecast by Model</th>
                                @endif
                            </tr>
                            <tr>
                                @if ($withBaseline != 0)
                                    <th>Baseline</th>
                                @endif
                                <th>Annualized Growth Rate</th>
                                <th>Logarithmic Time Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 1; $i < sizeof($chart[0]); $i++)
                                <tr>
                                    @if ($withBaseline != 0)
                                        <td>{{ $chart[1][$i][0] }}</td>
                                        <td>{{ number_format($chart[1][$i][1], 2) }}</td>
                                        <td>{{ number_format($chart[1][$i][2], 2) }}</td>
                                        <td>{{ number_format($chart[1][$i][3], 2) }}</td>
                                    @else
                                        <td>{{ $chart[1][$i][0] }}</td>
                                        <td>{{ number_format($chart[1][$i][1], 2) }}</td>
                                        <td>{{ number_format($chart[1][$i][2], 2) }}</td>
                                    @endif
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div style="border:1px solid #ddd; padding:25px; background-color:#fff">
                        <div id="graph-log" style="display:100%; height:350px"></div>
                    </div>
                </div>
                <div class="col-12" style="display:{{ ($displayTable != 'yes') ? 'none' : 'block'}}">
                    <table style="border:1px solid #ddd">
                        <thead>
                            <tr>
                                <th rowspan="2">Year</th>
                                <th colspan="2">Logarithmic Time Trend</th>
                            </tr>
                            <tr>
                                <th>Production</th>
                                <th>Consumption</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 1; $i < sizeof($chart[3]); $i++)
                                <tr>
                                    <td>{{ $chart[3][$i][0] }}</td>
                                    <td>{{ number_format($chart[3][$i][1], 2) }}</td>
                                    <td>{{ number_format($chart[3][$i][2], 2) }}</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div style="border:1px solid #ddd; padding:25px; background-color:#fff">
                        <div id="graph-agr" style="display:100%; height:350px"></div>
                    </div>
                </div>
                <div class="col-12" style="display:{{ ($displayTable != 'yes') ? 'none' : 'block'}}">
                    <table style="border:1px solid #ddd">
                        <thead>
                            <tr>
                                <th rowspan="2">Year</th>
                                <th colspan="2">Annualized Growth Rate</th>
                            </tr>
                            <tr>
                                <th>Production</th>
                                <th>Consumption</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 1; $i < sizeof($chart[4]); $i++)
                                <tr>
                                    <td>{{ $chart[4][$i][0] }}</td>
                                    <td>{{ number_format($chart[4][$i][1], 2) }}</td>
                                    <td>{{ number_format($chart[4][$i][2], 2) }}</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            <script type="text/javascript">

                var production = {!! json_encode($chart[0], JSON_NUMERIC_CHECK) !!};
                var consumption = {!! json_encode($chart[1], JSON_NUMERIC_CHECK) !!};
                var log = {!! json_encode($chart[3], JSON_NUMERIC_CHECK) !!};
                var agr = {!! json_encode($chart[4], JSON_NUMERIC_CHECK) !!};
                
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawLineGraphProduction);
                google.charts.setOnLoadCallback(drawLineGraphConsumption);
                google.charts.setOnLoadCallback(drawGraphLog);
                google.charts.setOnLoadCallback(drawGraphAgr);
                
                function drawLineGraphProduction() {
                    var data = google.visualization.arrayToDataTable(production);

                    var options = {
                        title: "Production Forecast all Methods (raw form in metric tons)",
                        curveType: 'function',
                        legend: { position: 'bottom' },
                        pointSize: 10,
                        pointShape: ['circle'],
                        colors: ['#9B64E1', '#348AEC', '#61d3d4', '#ffa500'],
                        series: {
                            0: { pointShape: 'circle' },
                            1: { pointShape: 'square' },
                            2: { pointShape: 'triangle' },
                            3: { pointShape: { type: 'star', sides: 5, dent: 0.5 } },
                            4: { pointShape: 'diamond' },
                            5: { pointShape: 'polygon' }
                        }
                    };

                    var chart = new google.visualization.LineChart(document.getElementById('line-graph-production'));
                    chart.draw(data, options);
                }

                function drawLineGraphConsumption() {
                    var data = google.visualization.arrayToDataTable(consumption);

                    var options = {
                        title: "Consumption Forecast all Methods (in Metric Tons)",
                        curveType: 'function',
                        legend: { position: 'bottom' },
                        pointSize: 10,
                        pointShape: 'circle',
                        colors: ['#348AEC', '#61d3d4', '#ffa500'],
                        series: {
                            0: { pointShape: 'square' },
                            1: { pointShape: 'triangle' },
                            2: { pointShape: { type: 'star', sides: 5, dent: 0.5 } },
                            3: { pointShape: 'diamond' },
                            4: { pointShape: 'polygon' }
                        }
                    };

                    var chart = new google.visualization.LineChart(document.getElementById('line-graph-consumption'));
                    chart.draw(data, options);
                }

                function drawGraphLog() {
                    var data = google.visualization.arrayToDataTable(log);

                    var options = {
                        title : 'Forecast using Logarithmic Time Trend Method',
                        vAxis: {title: 'Metric Tons'},
                        hAxis: {title: 'Year'},
                        seriesType: 'bars',
                        series: {0: {type: 'line'}},
                        legend: {position: 'bottom'},
                        pointSize: 7,
                        pointShape: 'circle',
                        colors: ['#9B64E1', '#ffa500'],
                    };

                    var chart = new google.visualization.ComboChart(document.getElementById('graph-log'));
                    chart.draw(data, options);
                }

                function drawGraphAgr() {
                    var data = google.visualization.arrayToDataTable(agr);

                    var options = {
                        title : 'Forecast using Annualized Growth Rate Method',
                        vAxis: {title: 'Metric Tons'},
                        hAxis: {title: 'Year'},
                        seriesType: 'bars',
                        series: {0: {type: 'line'}},
                        legend: {position: 'bottom'},
                        pointSize: 7,
                        pointShape: 'circle',
                        colors: ['#9B64E1', '#61d3d4'],
                    };

                    var chart = new google.visualization.ComboChart(document.getElementById('graph-agr'));
                    chart.draw(data, options);
                }

            </script>
    </div>
</div>
@stop
