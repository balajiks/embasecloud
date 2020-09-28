<?php $__currentLoopData = $data['medicaltermdata']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $termsdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
$arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
shuffle($arrbgdata); 
?>
<li class="list-group-item card" id="medicaldata-<?php echo e($termsdata->id); ?>">
  <div class="todo-indicator bg-<?php echo $arrbgdata[0];?>"></div>
  <div class="widget-content p-0">
    <div class="widget-content-wrapper">
      <div class="widget-content-left mr-2">
        <div class="custom-checkbox custom-control">
          <input type="checkbox" class="custom-control-input" id="CustomSectionCheckbox<?php echo e($termsdata->id); ?>" value="<?php echo e($termsdata->id); ?>">
          <label for="CustomSectionCheckbox<?php echo e($termsdata->id); ?>" class="custom-control-label">&nbsp;</label>
        </div>
      </div>
      <div class="widget-content-left flex2 text-dark medicalajax" data-id="<?php echo e($termsdata->id); ?>" id="medical-<?php echo e($termsdata->id); ?>">
        <div class="widget-heading text-dark"><?php echo e($termsdata->medicalterm); ?></div>
      </div>
      <div class="widget-content-right"> <?php if($termsdata->termtype =='MED'): ?>
        <div class="badge badge-secondary mr-2"><?php echo e($termsdata->termtype); ?></div>
        <?php elseif($termsdata->termtype =='DIS'): ?>
        <div class="badge badge-danger mr-2"><?php echo e($termsdata->termtype); ?></div>
        <?php else: ?>
        <div class="badge badge-info mr-2"><?php echo e($termsdata->termtype); ?></div>
        <?php endif; ?> </div>
      <div class="widget-content-right widget-content-actions">
        <div class="border-0 btn-transition btn"> <a href="#" class="editMedical" data-medical-id="<?php echo e($termsdata->id); ?>" title="<?php echo trans('app.'.'edit'); ?>"><i class="fa fa-edit text-primary"></i> </a> </div>
        <div class="border-0 btn-transition btn"> <?php if($termsdata->user_id === Auth::id()): ?> <a href="#" class="deletemedicalterm" data-medical-id="<?php echo e($termsdata->id); ?>" title="<?php echo trans('app.'.'delete'); ?>"><i class="fa fa-trash-alt text-danger"></i> </a> <?php endif; ?> </div>
      </div>
    </div>
  </div>
</li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 