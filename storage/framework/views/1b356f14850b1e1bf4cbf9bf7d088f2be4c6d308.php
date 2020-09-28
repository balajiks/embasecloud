<?php
$arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
shuffle($arrbgdata); 
$classdata = explode('|||',$classification[0]->classificationval);
?>
<?php $__currentLoopData = $classdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dataclass): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<li class="list-group-item card" data-id="<?php echo e($classification[0]->id); ?>" id="section-<?php echo e($classification[0]->id); ?>">
  <div class="todo-indicator bg-<?php echo e($arrbgdata[0]); ?>"></div>
  <div class="widget-content p-0">
    <div class="widget-content-wrapper">
      <div class="widget-content-left flex2 text-dark">
        <div class="widget-heading text-dark"><?php echo e($dataclass); ?></div>
      </div>
      <div class="widget-content-right widget-content-actions">
        <div class="border-0 btn-transition btn">
        <?php if($classification[0]->user_id === Auth::id()): ?> <a href="#" class="deleteClassification" data-section-id="<?php echo e($dataclass); ?>" title="<?php echo trans('app.'.'delete'); ?>"  onclick="deleteClassification('<?php echo e(@$dataclass); ?>','<?php echo e(@$classification[0]->id); ?>')"><i class="fa fa-trash-alt text-danger"></i> </a> <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>