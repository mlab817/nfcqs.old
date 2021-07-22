<div class="modal fade" id="popupForm" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width:800px">
        <div class="modal-content">
            <?php echo Form::open(['url' => 'contract/modality', 'method' => 'post', 'accept-charset' => 'UTF-8', 'id' => 'contractModality', 'class' => 'popup-form']); ?>

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Modality & Funding Source</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row" id="modalityEntries" style="display:<?php echo e((sizeof($entries) == 0) ? 'none' : 'block'); ?>">
                        <table>
                            <thead>
                                <tr>
                                    <th>Modality</th>
                                    <th>Area Contracted</th>
                                    <th>Fundsource</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="contract-modalities">
                                <?php if(sizeof($entries) != 0): ?>
                                    <?php $__currentLoopData = $entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($key->modality); ?> <?php echo e(($key->year_contracted != null) ? '(' . $key->year_contracted . ')' : ''); ?></td>
                                            <td style="min-width:75px; text-align:center; vertical-align:middle"><?php echo e(($key->area_contracted != 0) ? $key->area_contracted : ''); ?></td>
                                            <td style="min-width:75px; text-align:center; vertical-align:middle"><?php echo e($key->fundsource); ?></td>
                                            <td style="min-width:75px; text-align:center; vertical-align:middle; font-size:10px; font-weight:bold"><a href="#" class="delete-modality" data-modality="<?php echo e($key->id); ?>" style="color:red"><i class="fas fa-trash-alt" style="margin-right:5px"></i>DELETE</a></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row" style="margin-top:0; padding:0 10px 10px; background-color:#f4f4f4; border-top:1px solid #ddd">
                        <div style="display:table-row">
                            <div style="display:table-cell; width:75%; padding:5px">
                                <label>Modality</label>
                                <?php echo Form::select('modality', $modalities, '', ['class' => 'form-control', 'style' => '']); ?>

                            </div>
                            <div style="display:table-cell; width:25%; padding:5px">
                                <label>Fundsource</label>
                                <?php echo Form::select('fundsource', $fundsource, '', ['class' => 'form-control', 'style' => '']); ?>

                            </div>
                        </div>
                        <div style="display:table-row; margin-top:5px">
                            <div style="display:table-cell; padding:5px">
                                <label>GOP <b>%</b> Share</label>
                                <?php echo Form::text('gop_share', $gop, ['class' => 'form-control']); ?>

                            </div>
                            <div style="display:table-cell; padding:5px">
                                <label>Year Contracted</label>
                                <?php echo Form::text('year_contracted', '', ['class' => 'form-control']); ?>

                            </div>
                            <div style="display:table-cell; padding:5px">
                                <label>Area Contracted</label>
                                <?php echo Form::text('area_contracted', '', ['class' => 'form-control']); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span style="font-size:12px; color:#888; padding-top:3px; display:inline-block; position:relative; margin-right:auto; width:275px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap"><i class="fa fa-code" aria-hidden="true" style="color:orange"></i> <?php echo @$contractCode; ?></span>
                    <?php echo Form::hidden('contract_id', $contractId); ?>

                    <?php echo Form::submit('Save', ['class' => 'btn btn-primary save-contract-modality']); ?>

                    <?php echo Form::button('Close', ['class' => 'btn btn-danger', 'data-dismiss' => 'modal']); ?>

                </div>
                <input name="contract_id" value="<?php echo e($contractId); ?>" type="hidden" />
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
