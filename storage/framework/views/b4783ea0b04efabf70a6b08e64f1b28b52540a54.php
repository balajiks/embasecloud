 <?php $__currentLoopData = $data['medicaltermdata']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diseaseslink): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			  <?php if($diseaseslink->diseaseslink != 'Null'): ?>
			  	
			  	<?php if(strpos($diseaseslink->diseaseslink, ',') !== false): ?>
					 <?php $__currentLoopData = explode(',', $diseaseslink->diseaseslink); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $selected): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <li class="dd-item dd3-item active" data-id="<?php echo e($diseaseslink->id); ?>" id="termsdiseasesdata-<?php echo e($diseaseslink->id); ?>" > <span class="pull-right m-xs">  <?php if($diseaseslink->user_id === Auth::id()): ?> <a href="#" class="deletemedicalterm" data-section-id="<?php echo e($diseaseslink->id); ?>" title="<?php echo trans('app.'.'delete'); ?>"> <?php echo e(svg_image('solid/times', 'icon-muted fa-fw m-r-xs')); ?> </a> <?php endif; ?> </span>
  <div class="dd3-content">
                         <label><span class="label-text"> <span class="<?php echo $diseaseslink->status ? 'text-info' : 'text-danger'; ?>" id="section-id-<?php echo e($diseaseslink->id); ?>"> <?php echo e($selected); ?> </span></span></label>
                       </div>
</li>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php else: ?>
                     <li class="dd-item dd3-item active" data-id="<?php echo e($diseaseslink->id); ?>" id="termsdiseasesdata-<?php echo e($diseaseslink->id); ?>" > <span class="pull-right m-xs"> O <?php if($diseaseslink->user_id === Auth::id()): ?> <a href="#" class="deletemedicalterm" data-section-id="<?php echo e($diseaseslink->id); ?>" title="<?php echo trans('app.'.'delete'); ?>"> <?php echo e(svg_image('solid/times', 'icon-muted fa-fw m-r-xs')); ?> </a> <?php endif; ?> </span>
  <div class="dd3-content">
                         <label><span class="label-text"> <span class="<?php echo $diseaseslink->status ? 'text-info' : 'text-danger'; ?>" id="section-id-<?php echo e($diseaseslink->id); ?>"> <?php echo e($diseaseslink->diseaseslink); ?> </span></span></label>
                       </div>
</li>
                    <?php endif; ?>
			  
		 <?php endif; ?>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 