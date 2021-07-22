<?php $__env->startSection('content'); ?>
<?php

    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $goto = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <h1 class="page-title" style="margin-bottom:0"><i class="fas fa-info-circle"></i> List of Contracts</h1>
        <div class="search-form" style="text-align:right; margin-bottom:25px">
            <form method="GET" action="<?php echo e(url('contracts')); ?>" role="form">
                <label style="display:inline-block; margin-top:12px">SEARCH:</label>
                <div class="form-group" style="width:50%; float:right; margin-bottom:0">
                    <div class="input-group">
                        <?php echo Form::select('type', $types, $type, ['class' => 'form-control', 'style' => 'margin-right:5px']); ?>

                        <input value="<?php echo e($search); ?>" autocomplete="off" class="form-control" style="border-radius:5px 0 0 5px" placeholder="Contractor, Contract No. or Location ..." style="border-top-right-radius:0 !important; border-bottom-right-radius:0 !important; font-size:12px !important" name="search" type="text">
                        <div class="input-group-addon trigger-search" style="cursor:pointer"><i class="fa fa-search"></i></div>
                    </div>
                </div>
                <input type="hidden" name="action" value="">
                <button type="submit" style="opacity:0"></button>
                <div style="clear:both"></div>
            </form>
        </div>
        <table>
            <tbody>
                <?php if(sizeof($contracts) != 0): ?>
                    <?php $highlightRow = false; ?>
                    <?php $__currentLoopData = $contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="<?php echo e(($highlightRow == true) ? 'highlight-row' : ''); ?>">
                            <td style="width:50%; vertical-align:middle">
                                <table style="border:0" class="child-table two-cols">
                                    <tr>
                                        <td style="vertical-align:middle"><i class="fa fa-code" aria-hidden="true"></i></td>
                                        <td>
                                            <a href="<?php echo e(url('contracts?search=' . $key->contract_code)); ?>" class="jump-search" style="margin:2px 0; display:inline-block; background-color:orange; border:1px solid orange"><?php echo e($key->contract_code); ?></a>
                                            <a href="<?php echo e(url('contracts?search=' . $key->watershed)); ?>" class="jump-search" style="margin:2px 0; display:inline-block; background-color:rgb(101, 172, 42); border:1px solid rgb(101, 172, 42)"><?php echo e($key->watershed); ?></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:middle">Region:</td>
                                        <td><?php echo e($key->region); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:middle">Province:</td>
                                        <td><?php echo e($key->province); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:middle">Contractor:</td>
                                        <td><?php echo e($key->contractor_name); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:middle">Type:</td>
                                        <td><?php echo e($key->type); ?></td>
                                    </tr>
                                    <?php if($key->type == 'Site Development'): ?>
                                        <tr>
                                            <td style="vertical-align:middle">Area:</td>
                                            <td><?php echo e(number_format($key->area_covered, 2)); ?> <span style="font-weight:normal; color:#888">Hectares</span></td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td style="vertical-align:middle">Duration:</td>
                                        <td>
                                            <div>
                                                <?php echo e(date('F d, Y', strtotime($key->start_date))); ?> <i style="color:#888">to</i> <?php echo e(date('F d, Y', strtotime($key->end_date))); ?>

                                            </div>
                                            <!--
                                            <div style="font-size:12px; background-color:#ddd; margin:5px 0 0 0; padding:2px 5px; display:inline-block; border-right:2px solid green">
                                                Time Elapsed (in Months): 
                                                <?php
                                                    if ($key->elapsed_months != 0 AND $key->contracted_months != 0) {
                                                        $timeElapsed = number_format($key->elapsed_months / $key->contracted_months * 100, 2);
                                                        $timeElapsed = ($timeElapsed > 100) ? 100 : $timeElapsed;
                                                    } else {
                                                        $timeElapsed = 0.00;
                                                    }
                                                ?>
                                                <b><?php echo e(number_format($timeElapsed, 2)); ?>%</b>
                                            </div>
                                            -->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:middle">Contract Cost:</td>
                                        <td style="font-weight:bold"><?php echo e(number_format($key->contract_cost, 2)); ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width:50%; vertical-align:middle">
                                <table>
                                    <thead>
                                        <tr>
                                            <th rowspan="2" colspan="2">Modality</th>
                                            <th rowspan="2">Cost</th>
                                            <th colspan="3">Weighted Physical Progress</th>

                                            <?php if($key->type != 'Infrastructure' AND $key->type != 'Livelihood Enhancement Support (LES)'): ?>
                                                <th colspan="2">Area (Ha)</th>
                                            <?php else: ?>
                                                <?php if($key->type == 'Livelihood Enhancement Support (LES)'): ?>
                                                    <th rowspan="2">Units</th>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <th rowspan="2">Time Elapsed</th>
                                            <th rowspan="2">Period</th>
                                        </tr>
                                        <tr>
                                            <th>Target</th>
                                            <th>Actual</th>
                                            <th>Variance</th>

                                            <?php if($key->type != 'Infrastructure' AND $key->type != 'Livelihood Enhancement Support (LES)'): ?>
                                                <th>Contracted</th>
                                                <th>Planted</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(sizeof($key->modality) != 0): ?>
                                            <?php for($i = 0; $i < sizeof($key->modality); $i++): ?>
                                                <?php 

                                                    // compute variance
                                                    $variance = $key->modality[$i][2] - $key->modality[$i][1];
                                                    $variance = ($variance != 0) ? $variance * 100 : 0;
                                                    $variance = round($variance, 2);

                                                    // reporting period
                                                    $period = (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $key->modality[$i][0])) ? date('M Y', strtotime($key->modality[$i][0])) : $key->modality[$i][0];

                                                    // variance color
                                                    if ($variance < 0) {
                                                        $color = 'red';
                                                    } elseif ($variance > 0) {
                                                        $color = 'green';
                                                    } else {
                                                        $color = '#555';
                                                    }

                                                ?>
                                                <tr>
                                                    <td style="text-align:left; vertical-align:middle" class="menus-column">
                                                        <a href="<?php echo e(url('contract/scurve?boqId=' . $key->modality[$i][5] . '&sheetIndex=' . $key->modality[$i][6])); ?>" target="_blank"><i class="fas fa-cog" title="View SCURVE" style="color:green; margin:0"></i></a>
                                                        <a href="<?php echo e(url('contract/swa?boqId=' . $key->modality[$i][5] . '&period=' . urlencode($period) . '&modality=' . urlencode($key->modality[$i][3]))); ?>" target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true" style="color:orange; margin:0" title="Download Statement of Work Accomplishment (SWA)"></i></a>
                                                    </td>
                                                    <td style="text-align:left; vertical-align:middle"><?php echo e($key->modality[$i][3]); ?></td>
                                                    <td style="text-align:right; vertical-align:middle; font-weight:normal; color:#555"><?php echo e(number_format($key->modality[$i][4], 0)); ?></td>
                                                    <td style="text-align:center; vertical-align:middle; font-weight:normal; color:orange"><?php echo e(($key->modality[$i][1] > 0) ? (($key->modality[$i][1] * 100 > 100) ? 100 : number_format($key->modality[$i][1] * 100, 2)) : 0); ?>%</td>
                                                    <td style="text-align:center; vertical-align:middle; font-weight:normal; color:#337ab7"><?php echo e(($key->modality[$i][2] > 0) ? (($key->modality[$i][2] * 100 > 100) ? 100 : number_format($key->modality[$i][2] * 100, 2)) : 0); ?>%</td>
                                                    <td style="text-align:center; vertical-align:middle; font-weight:normal; color:<?php echo e($color); ?>"><?php echo e(($variance != 0) ? number_format($variance, 2) : 0); ?>%</td>
                                                    
                                                    <?php if($key->type != 'Infrastructure' AND $key->type != 'Livelihood Enhancement Support (LES)'): ?>
                                                        <td style="text-align:center; vertical-align:middle; font-weight:normal"><?php echo e(number_format(@$key->modality[$i][10], 0)); ?></td>
                                                        <td style="text-align:center; vertical-align:middle; font-weight:normal"><?php echo e(number_format(@$key->modality[$i][11], 0)); ?></td>
                                                    <?php else: ?>
                                                        <?php if($key->type == 'Livelihood Enhancement Support (LES)'): ?>
                                                            <td style="text-align:center; vertical-align:middle; font-weight:normal">1</td>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    
                                                    <td style="text-align:center; vertical-align:middle" title="<?php echo e(number_format(@$key->modality[$i][8], 0)); ?> months / <?php echo e(number_format(@$key->modality[$i][9], 0)); ?> months * 100"><?php echo e(number_format(@$key->modality[$i][7], 2)); ?>%</td>
                                                    <td style="text-align:center; vertical-align:middle; width:65px"><?php echo e((preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $key->modality[$i][0])) ? date('M Y', strtotime($key->modality[$i][0])) : $key->modality[$i][0]); ?></td>
                                                </tr>
                                            <?php endfor; ?>
                                        <?php endif; ?>
                                        <tr>
                                            <td colspan="<?php echo e((($key->type != 'Infrastructure') ? (($key->type == 'Livelihood Enhancement Support (LES)') ? 9 : 10) : 8)); ?>" style="text-align:center; border-top:2px solid orange" class="wfp-controls">
                                                <a style="padding:0 5px" href="<?php echo e(url('geotag/albums?contractId=' . $key->id)); ?>" target="_blank"><i class="fas fa-map-marker-alt" style="margin-right:5px; color:orange"></i>Geotag Photos<i title="<?php echo e($key->geotag_count); ?>" class="geotag-photo-count"><?php echo e(($key->geotag_count > 99) ? '99+' : $key->geotag_count); ?></i></a>
                                                <a style="padding:0 5px" href="<?php echo e(($key->filename != '') ? url($key->filename) : url('uploads/boq/Contract (Physical Progress).xlsx')); ?>"><i class="fas fa-download" style="margin-right:5px; color:rgb(101, 172, 42)"></i>Download BOQ</a>
                                                <a style="padding:0 5px" class="open-popup" href="<?php echo e(url('contract/upload-boq?contractId=' . base64_encode($key->id) . '&goto=' . $goto)); ?>"><i class="fas fa-upload" style="margin-right:5px; color:#999"></i>Upload BOQ</a>

                                                <?php if($key->type != 'Infrastructure' AND $key->type != 'Livelihood Enhancement Support (LES)'): ?>
                                                    <a style="padding:0 5px" class="open-popup" href="<?php echo e(url('contract/planted-species?contractId=' . base64_encode($key->id))); ?>" title="Planted Species"><i class="fa fa-leaf" style="margin-right:5px; color:green"></i>Species</a>
                                                <?php endif; ?>

                                                <a style="padding:0 5px" href="<?php echo e(url('contract?contractId=' . $key->id)); ?>"><i class="fas fa-pencil-alt" style="margin-right:5px; color:rgb(97, 65, 183)"></i>Edit</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="ear-remarks" id="contract-<?php echo e($key->id); ?>">
                                    <?php echo Form::open(['url' => 'contracts', 'metdod' => 'post', 'accept-charset' => 'UTF-8']); ?>

                                        <a class="open-popup" href="<?php echo e(url('contract/remarks?contractId=' . base64_encode($key->id))); ?>" style="color:#555"><i class="far fa-comment" style="margin-right:5px"></i>REMARKS</a> |
                                        <a class="open-popup" href="<?php echo e(url('contract/modality?contractId=' . base64_encode($key->id))); ?>" style="color:#555"><i class="fas fa-dollar-sign" style="margin-right:3px"></i>FUNDSOURCE</a> |
                                        <a class="open-popup" href="<?php echo e(url('contract/payments?contractId=' . base64_encode($key->id))); ?>" style="color:#555"><i class="fas fa-shopping-cart" style="margin-right:5px"></i>PAYMENTS</a> |
                                        <a class="delete-contract" href="#" data-contract="<?php echo e(base64_encode($key->id)); ?>" style="color:red"><i class="fas fa-trash-alt" style="margin-right:5px"></i>DELETE CONTRACT</a>
                                    <?php echo Form::close(); ?>

                                </div>
                            </td>
                        </tr>
                        <?php $highlightRow = ($highlightRow == true) ? false : true; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </tbody>
        </table>
        <?php echo $conPaginate->render(); ?>

    </div>
</div>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) { 
        $(document).on('click', '.trigger-search', function() {
            $(this).closest('form').submit();
        })
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>