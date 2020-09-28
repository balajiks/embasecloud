<?php if(!empty($data['checktagdata'])): ?>
<?php $__currentLoopData = $data['checktagdata']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $checktag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
$arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
shuffle($arrbgdata); 
?>
<li class="list-group-item card" id="medicalchecktagdata-<?php echo e($checktag->id); ?>">
  <div class="todo-indicator bg-<?php echo $arrbgdata[0];?>"></div>
  <div class="widget-content p-0">
    <div class="widget-content-wrapper">
      <div class="widget-content-left mr-2">
        <div class="custom-checkbox custom-control">
          <input type="checkbox" class="custom-control-input" id="CustomSectionCheckbox<?php echo e($checktag->id); ?>" value="<?php echo e($checktag->id); ?>">
          <label for="CustomSectionCheckbox<?php echo e($checktag->id); ?>" class="custom-control-label">&nbsp;</label>
        </div>
      </div>
      <div class="widget-content-left flex2 text-dark" data-id="<?php echo e($checktag->id); ?>" id="checktag-<?php echo e($checktag->id); ?>">
        <div class="widget-heading text-dark"><?php echo e($checktag->checktag); ?> </div>
      </div>
      
      <div class="widget-content-right widget-content-actions">       
        <div class="border-0 btn-transition btn"> <?php if($checktag->user_id === Auth::id()): ?> <a href="#" class="deletechecktag" data-checktag-id="<?php echo e($checktag->id); ?>" title="<?php echo trans('app.'.'delete'); ?>"><i class="fa fa-trash-alt text-danger"></i> </a> <?php endif; ?> </div>
      </div>
    </div>
  </div>
</li>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>   
<?php endif; ?>