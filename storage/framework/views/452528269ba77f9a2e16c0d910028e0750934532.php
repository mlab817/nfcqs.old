<?php $__env->startSection('content'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <h1 class="page-title"><i class="fas fa-info-circle"></i> Contract Timeline</h1>
        <div style="width:75%;">
            <canvas id="canvas"></canvas>
        </div>
        <script type="text/javascript">
            var config = {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($timeline); ?>,
                    datasets: [{
                        label: "Actual",
                        fill: false,
                        backgroundColor: '#348AEC',
                        borderColor: '#348AEC',
                        data: <?php echo json_encode($actual); ?>,
                    }, {
                        label: "Target",
                        fill: false,
                        backgroundColor: '#D85334',
                        borderColor: '#D85334',
                        data: <?php echo json_encode($target); ?>,
                    }]
                },
                options: {
                    responsive: true,
                    title:{
                        display: true,
                        text: "<?php echo e((@$details->type != null) ? @$details->type . ' | Contractor: ' . @$details->contractor_name : 'No Record Found'); ?>"
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Timeline'
                            }
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: '% Physical Progress'
                            }
                        }]
                    }
                }
            };

            window.onload = function() {
                var ctx = document.getElementById("canvas").getContext("2d");
                window.myLine = new Chart(ctx, config);
            };
        </script>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>