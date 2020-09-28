<?php
$arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
shuffle($arrbgdata); 
?>
<li class="list-group-item card" id="sectiondata-<?php echo e($secdata[0]->id); ?>">
  <div class="todo-indicator bg-<?php echo e($arrbgdata[0]); ?>"></div>
  <div class="widget-content p-0">
    <div class="widget-content-wrapper">
      <div class="widget-content-left mr-2">
        <div class="custom-checkbox custom-control">
          <input type="checkbox" class="custom-control-input" id="CustomSectionCheckbox<?php echo e($secdata[0]->id); ?>" value="<?php echo e($secdata[0]->id); ?>">
          <label for="CustomSectionCheckbox<?php echo e($secdata[0]->id); ?>" class="custom-control-label">&nbsp;</label>
        </div>
      </div>
      <div class="widget-content-left flex2 text-dark sectionajax" data-id="<?php echo e($secdata[0]->id); ?>" id="section-<?php echo e($secdata[0]->id); ?>">
        <div class="widget-heading text-dark">Section : <?php echo e($secdata[0]->sectionval); ?></div>
        <div class="widget-subheading text-dark">Publication Choice: <?php echo e($secdata[0]->pubchoice); ?></div>
      </div>
      <div class="widget-content-right widget-content-actions">
        <div class="border-0 btn-transition btn"> <a href="#" class="editSection" data-section-id="<?php echo e($secdata[0]->id); ?>" title="<?php echo trans('app.'.'edit'); ?>"><i class="fa fa-edit text-primary"></i> </a> </div>
        <div class="border-0 btn-transition btn"> <?php if($secdata[0]->user_id === Auth::id()): ?> <a href="#" class="deleteSection" data-section-id="<?php echo e($secdata[0]->id); ?>" title="<?php echo trans('app.'.'delete'); ?>"><i class="fa fa-trash-alt text-danger"></i> </a> <?php endif; ?> </div>
      </div>
    </div>
  </div>
</li>
