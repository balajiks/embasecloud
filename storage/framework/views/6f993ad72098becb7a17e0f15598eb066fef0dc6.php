<div class="row m-l-none m-r-none m-sm">
    <div class="col-sm-6 col-md-3 padder-v lt border-l pallete b-b b-r">
        <a class="clear" href="<?php echo e(route('projects.index', ['filter' => 'Active'])); ?>">
            <span class="fa-stack fa-2x pull-left m-r-xs">
                <i class="fas fa-square fa-stack-2x text-dracula op7"></i>
                <i class="fas fa-spinner fa-stack-1x text-white"></i>
            </span>
            
            <small class="text-uc"><?php echo trans('app.'.'active'); ?></small>
            <span class="h4 block m-t-xs text-dark"><?php echo e(getCalculated('projects_active')); ?></span>
        </a>
    </div>
    <div class="col-sm-6 col-md-3 padder-v lt pallete b-b b-r">
        <a class="clear" href="<?php echo e(route('reports.index', ['m' => 'projects'])); ?>">
            <span class="fa-stack fa-2x pull-left m-r-xs">
                <i class="fas fa-square fa-stack-2x text-info op7"></i>
                <i class="fas fa-check-double fa-stack-1x text-white"></i>
            </span>
            <small class="text-uc"><?php echo trans('app.'.'done'); ?></small>
            <span class="h4 block m-t-xs text-dark"><?php echo e(getCalculated('projects_done')); ?></span>
        </a>
    </div>
    <div class="col-sm-6 col-md-3 padder-v pallete b-b b-r">
        <a class="clear" href="<?php echo e(route('tasks.index')); ?>">
            <span class="fa-stack fa-2x pull-left m-r-xs">
                <i class="fas fa-square fa-stack-2x text-success"></i>
                <i class="fas fa-exclamation-circle fa-stack-1x text-white"></i>
            </span>
            
            <small class="text-uc"><?php echo trans('app.'.'pending'); ?> <?php echo trans('app.'.'tasks'); ?></small>
            <span class="h4 block m-t-xs text-dark"><?php echo e(getCalculated('tasks_active')); ?></span> </a>
        </div>
        
        
        <div class="col-sm-6 col-md-3 padder-v pallete b-b">
            <a class="clear" href="<?php echo e(route('reports.index', ['m' => 'tasks'])); ?>">
                <span class="fa-stack fa-2x pull-left m-r-xs">
                    <i class="fas fa-square fa-stack-2x text-dark"></i>
                    <i class="fas fa-tasks fa-stack-1x text-white"></i>
                </span>
                
                <small class="text-uc"><?php echo trans('app.'.'done'); ?> <?php echo trans('app.'.'tasks'); ?></small>
                <span class="h4 block m-t-xs text-dark"><?php echo e(getCalculated('tasks_done')); ?></span>
            </a>
        </div>
        
    </div>