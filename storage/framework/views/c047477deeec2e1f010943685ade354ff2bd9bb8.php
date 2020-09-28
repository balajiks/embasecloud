<?php
$arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
shuffle($arrbgdata); 
?>
<div class="row">
  <div class="col-sm-12 col-lg-12">
    <div class="card-hover-shadow-2x mb-3 card">
      <div class="p-2">
            <ul class="todo-list-wrapper section-todo-list list-group list-group-flush slim-scroll" data-height="250">
			 <?php $__currentLoopData = $indexingsections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			  <li class="list-group-item card" data-id="<?php echo e($section->id); ?>" id="section-<?php echo e($section->id); ?>">
                <div class="todo-indicator bg-<?php echo e($arrbgdata[0]); ?>"></div>
                <div class="widget-content p-0">
                  <div class="widget-content-wrapper">
                    <div class="widget-content-left mr-2">
                      <div class="custom-checkbox custom-control">
                        <div class="placeholdericon"></div>
                      </div>
                    </div>
                    <div class="widget-content-left flex2 text-dark">
                      <div class="widget-heading text-dark">Section : <?php echo e($section->sectionval); ?></div>
                    </div>
                    <div class="widget-content-right">
                      <div class="badge badge-secondary mr-2"><?php echo e(svg_image('solid/calendar-alt')); ?> <?php echo e(!empty($section->created_at) ?  dateElapsed($section->created_at) : ''); ?></div>
                    </div>
                    <div class="widget-content-right widget-content-actions">
                      <div class="border-0 btn-transition btn"> <?php if($section->user_id === Auth::id()): ?> <a href="#" class="deleteSection" data-section-id="<?php echo e($section->id); ?>" title="<?php echo trans('app.'.'delete'); ?>"><i class="fa fa-trash-alt text-danger"></i> </a> <?php endif; ?> </div>
                    </div>
                  </div>
                </div>
              </li>
			  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </div>
    </div>
  </div>
</div>