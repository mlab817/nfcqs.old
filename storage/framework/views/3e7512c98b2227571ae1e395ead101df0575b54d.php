<?php $__env->startSection('content'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <h1 class="page-title"><i class="fas fa-info-circle"></i> Contracts Summary by Province</h1>
        <div style="display:block">
            <div class="chart-wrapper" style="display:inline-block; width:700px; padding:5px; border:1px solid #ddd; margin:20px; background-color:#fff; vertical-align:middle; height:100%">
                <canvas id="contracts"></canvas>
            </div>
            <div class="chart-wrapper" style="display:inline-block; width:700px; padding:5px; border:1px solid #ddd; margin:20px; background-color:#fff; vertical-align:middle; height:100%">                    
                <canvas id="area"></canvas>
            </div>
        </div>
        <div style="display:block">
            <table style="width:700px; margin:20px">
                <thead>
                    <tr>
                        <th rowspan="2" style="max-width:200px">Province<br /><span style="color:#888; font-weight:normal; text-transform:none">*click province name for sub-watershed level summary*</span></th>
                        <th colspan="2">Contracts</th>
                        <th rowspan="2">Total Payments<br /><span style="font-weight:normal; text-transform:none">(in Peso)</span></th>
                        <th colspan="2">Area in hectare</th>
                    </tr>
                    <tr>
                        <th>No.</th>
                        <th>Cost <span style="font-weight:normal; text-transform:none">(in Peso)</span></th>
                        <th>Contracted</th>
                        <th>Established</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $no = 0; 
                        $cost = 0;
                        $payments = 0;
                        $contracted = 0; 
                        $planted = 0;
                    ?>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><a href="<?php echo e(url('report/sub-watershed?province=' . $key)); ?>" style="display:inline-block; color:orange;"><?php echo e($key); ?></a></td>
                            <td style="text-align:right"><?php echo e(number_format($val[0], 0)); ?></td>
                            <td style="text-align:right"><?php echo e(number_format($val[1], 2)); ?></td>
                            <td style="text-align:right"><?php echo e(number_format($val[4], 2)); ?></td>
                            <td style="text-align:right"><?php echo e(number_format($val[2], 2)); ?></td>
                            <td style="text-align:right"><?php echo e(number_format($val[3], 2)); ?></td>
                        </tr>
                        <?php 
                            $no += $val[0]; 
                            $cost += $val[1]; 
                            $payments += $val[4]; 
                            $contracted += $val[2]; 
                            $planted += $val[3];
                        ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <th>Total</th>
                        <th style="text-align:right"><?php echo e(number_format($no, 0)); ?></th>
                        <th style="text-align:right"><?php echo e(number_format($cost, 2)); ?></th>
                        <th style="text-align:right"><?php echo e(number_format($payments, 2)); ?></th>
                        <th style="text-align:right"><?php echo e(number_format($contracted, 2)); ?></th>
                        <th style="text-align:right"><?php echo e(number_format($planted, 2)); ?></th>
                    </tr>
                </tbody>
            </table>
            <div class="dashboard-icons">
                <a href="<?php echo e(url('report/region')); ?>">Graph by Region</a>
                <a href="<?php echo e(url('report/province')); ?>">Graph by Province</a>
            </div>
        </div>
        <script type="text/javascript">
            var contracts = {
                labels: [
                    <?php $i = 0; ?>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo '"' . $key . '"'; ?><?php echo e(($i != sizeof($data) - 1) ? ',' : ''); ?>

                        <?php ++$i; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                ],
                datasets: [{
                    label: 'No. of Contracts',
                    backgroundColor: window.chartColors.yellow,
                    borderColor: window.chartColors.yellow,
                    borderWidth: 1,
                    data: [
                        <?php $i = 0; ?>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($val[0]); ?><?php echo e(($i != sizeof($data) - 1) ? ',' : ''); ?>

                            <?php ++$i; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    ]
                }, {
                    label: 'Contract Cost (in Million)',
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue,
                    data: [
                        <?php $i = 0; ?>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e((round($val[1] / 1000000, 2))); ?><?php echo e(($i != sizeof($data) - 1) ? ',' : ''); ?>

                            <?php ++$i; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    ]
                }, {
                    label: 'Total Payments (in Million)',
                    backgroundColor: window.chartColors.grey,
                    borderColor: window.chartColors.grey,
                    data: [
                        <?php $i = 0; ?>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e((round($val[4] / 1000000, 2))); ?><?php echo e(($i != sizeof($data) - 1) ? ',' : ''); ?>

                            <?php ++$i; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    ]
                }]
            },
            area = {
                labels: [
                    <?php $i = 0; ?>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo '"' . $key . '"'; ?><?php echo e(($i != sizeof($data) - 1) ? ',' : ''); ?>

                        <?php ++$i; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                ],
                datasets: [{
                    label: 'Area Contracted',
                    backgroundColor: window.chartColors.red,
                    borderColor: window.chartColors.red,
                    borderWidth: 1,
                    data: [
                        <?php $i = 0; ?>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($val[2]); ?><?php echo e(($i != sizeof($data) - 1) ? ',' : ''); ?>

                            <?php ++$i; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    ]
                }, {
                    label: 'Area Established',
                    backgroundColor: window.chartColors.green,
                    borderColor: window.chartColors.green,
                    data: [
                        <?php $i = 0; ?>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($val[3]); ?><?php echo e(($i != sizeof($data) - 1) ? ',' : ''); ?>

                            <?php ++$i; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    ]
                }]

            };

            window.onload = function() {
                var c = document.getElementById('contracts').getContext('2d'),
                    a = document.getElementById('area').getContext('2d');

                window.myHorizontalBar = new Chart(c, {
                    type: 'horizontalBar',
                    data: contracts,
                    options: {
                        elements: {
                            rectangle: {
                                borderWidth: 2,
                            }
                        },
                        responsive: true,
                        legend: {
                            position: 'bottom',
                        },
                        title: {
                            display: true,
                            text: 'No. of Contracts, Cost & Payments'
                        }
                    }
                });

                window.myHorizontalBar = new Chart(a, {
                    type: 'horizontalBar',
                    data: area,
                    options: {
                        elements: {
                            rectangle: {
                                borderWidth: 2,
                            }
                        },
                        responsive: true,
                        legend: {
                            position: 'bottom',
                        },
                        title: {
                            display: true,
                            text: 'Area Contracted & Established'
                        }
                    }
                });
            };
        </script>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>