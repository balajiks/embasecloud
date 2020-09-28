<?php $__currentLoopData = $data['drugtermdata']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $termsdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<li class="list-group-item card" data-id="<?php echo e($termsdata->id); ?>" id="drugtermsdata-<?php echo e($termsdata->id); ?>" onclick="selecteddrugdata('<?php echo e($termsdata->id); ?>','<?php echo e($termsdata->drugterm); ?>','<?php echo e($termsdata->type); ?>')" >
  <div class="todo-indicator bg-success"></div>
  <div class="widget-content p-0">
    <div class="widget-content-wrapper">
      <div class="widget-content-left mr-2">
        <div class="custom-checkbox custom-control">
          <div class="placeholdericon"></div>
        </div>
      </div>
      <div class="widget-content-left flex2 text-dark">
        <div class="widget-heading text-dark"><?php echo e($termsdata->drugterm); ?></div>
      </div>
      <div class="widget-content-right">
        <div class="badge badge-info mr-2"><?php echo e($termsdata->termtype); ?></div>
      </div>
      <div class="widget-content-right widget-content-actions">
        <div class="border-0 btn-transition btn"> <?php if($termsdata->user_id === Auth::id()): ?> <a href="#" class="deletedrugterm" data-section-id="<?php echo e($termsdata->id); ?>" title="<?php echo trans('app.'.'delete'); ?>"><i class="fa fa-trash-alt text-danger"></i> </a> <?php endif; ?> </div>
      </div>
    </div>
  </div>
</li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 