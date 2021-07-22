@extends('app')
@section('content')
<div id="page-content-wrapper">
    <div class="container-fluid">
        <h1 class="page-title"><i class="fas fa-info-circle"></i> Forecast Results for the {{ ($province != '...Philippines') ? 'Province of ' . $province : 'Philippines'}}</h1>
        <span style="font-size:12px; text-transform:uppercase"><a href="{{ url('province?model=' . $model . '&province=' . $province) }}"> <i class="fas fa-long-arrow-alt-right"></i>Download</a></span>
        @if (sizeof($chart) != 0)
            <script type="text/javascript">
                google.charts.load('current', {'packages':['corechart']});
                
                colors = [
                    ['#2e279d', '#dff6f0'], 
                    ['#004445', '#ffd800'],
                    ['#fa697c', '#fcc169'],
                    ['#272343', '#bae8e8'],
                    ['#222831', '#a3f7bf'],
                    ['#1d4d4f', '#e5dfdf'],
                    ['#621055', '#ffa372'],
                    ['#ef4339', '#51eaea'],
                    ['#36b5b0', '#fcf5b0'],
                    ['#9d0b0b', '#f6da63'],
                    ['#9656a1', '#f4efd3'],
                    ['#594a4e', '#6fc1a5'],
                    ['#594a4e', '#6fc1a5'],
                    ['#ff8ba7', '#c3f0ca'],
                    ['#10316b', '#ececeb'],
                    ['#a35638', '#9dab86'],
                    ['#ffac8e', '#55ae95'],
                    ['#1b2a49', '#c9d1d3'],
                    ['#3fc5f0', '#eef5b2'],
                    ['#003f5c', '#fb5b5a'],
                    ['#9B64E1', '#61d3d4'],
                    ['#9B64E1', '#ffa500']
                ];

                function getRandColors() {
                    return colors[Math.floor(Math.random() * colors.length)];
                }
            </script>
            <?php $rows = round(sizeof($chart) / 2); ?>
            <?php $g = -1; ?>
            @for ($i = 0; $i < $rows; $i++)
                <div class="row">
                    <?php $g = ($g < 0) ? $i : $g; ?>
                    <div class="{{ (sizeof($chart) < 2) ? 'col-12' : 'col-6' }}">
                        <div style="border:1px solid #ddd; background-color:#fff; width:100%; padding:10px">
                            <div id="graph-{{ $g }}" style="display:100%; height:350px"></div>
                        </div>
                        <script type="text/javascript">
                            var d__{{ $g }} = {!! json_encode($chart[$g][1], JSON_NUMERIC_CHECK) !!};
                            
                            function draw__{{ $g }}() {
                                var data__{{ $g }} = google.visualization.arrayToDataTable(d__{{ $g }});

                                var options__{{ $g }} = {
                                    title : '{{ $chart[$g][0] }}',
                                    vAxis: {title: 'Metric Tons'},
                                    hAxis: {title: 'Year'},
                                    seriesType: 'bars',
                                    series: {0: {type: 'line'}},
                                    legend: {position: 'bottom'},
                                    pointSize: 5,
                                    pointShape: 'circle',
                                    colors: getRandColors(),
                                };

                                var chart__{{ $g }} = new google.visualization.ComboChart(document.getElementById('graph-{{ $g }}'));
                                chart__{{ $g }}.draw(data__{{ $g }}, options__{{ $g }});
                            }

                            google.charts.setOnLoadCallback(draw__{{ $g }});
                        </script>
                    </div>
                    <?php $g++; ?>
                    @if (isset($chart[$g]))
                        <div class="col-6">
                            <div style="border:1px solid #ddd; background-color:#fff; padding:10px">
                                <div id="graph-{{ $g }}" style="display:100%; height:350px"></div>
                            </div>
                            <script type="text/javascript">
                                var d__{{ $g }} = {!! json_encode($chart[$g][1], JSON_NUMERIC_CHECK) !!};
                                
                                function draw__{{ $g }}() {
                                    var data__{{ $g }} = google.visualization.arrayToDataTable(d__{{ $g }});
    
                                    var options__{{ $g }} = {
                                        title : '{{ $chart[$g][0] }}',
                                        vAxis: {title: 'Metric Tons'},
                                        hAxis: {title: 'Year'},
                                        seriesType: 'bars',
                                        series: {0: {type: 'line'}},
                                        legend: {position: 'bottom'},
                                        pointSize: 5,
                                        pointShape: 'circle',
                                        colors: getRandColors(),
                                    };
    
                                    var chart__{{ $g }} = new google.visualization.ComboChart(document.getElementById('graph-{{ $g }}'));
                                    chart__{{ $g }}.draw(data__{{ $g }}, options__{{ $g }});
                                }
    
                                google.charts.setOnLoadCallback(draw__{{ $g }});
                            </script>
                        </div>
                    @endif
                    <?php $g++; ?>
                </div>
            @endfor
        @endif
    </div>
</div>
@stop