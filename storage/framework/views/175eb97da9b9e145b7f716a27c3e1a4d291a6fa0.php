<div class="row m-l-none m-r-none m-sm">
    <div class="col-sm-6 col-md-3 padder-v lt border-l pallete b-b b-r">
        <a class="clear" href="<?php echo e(route('projects.index', ['filter' => 'Active'])); ?>">
            <span class="fa-stack fa-2x pull-left m-r-xs">
                <i class="fas fa-square fa-stack-2x text-dark"></i>
                <i class="fas fa-clock fa-stack-1x text-white"></i>
            </span>
            
            <small class="text-uc" data-rel="tooltip" title="<?php echo trans('app.'.'worked'); ?> <?php echo trans('app.'.'today'); ?> <?php echo e(dateFormatted(today())); ?>"><?php echo trans('app.'.'today'); ?></small>
            <span class="h4 block m-t-xs text-dark"><?php echo e(secToHours(getCalculated('time_today'))); ?></span>
        </a>
    </div>
    <div class="col-sm-6 col-md-3 padder-v lt pallete b-b b-r">
        <a class="clear" href="<?php echo e(route('reports.index', ['m' => 'projects'])); ?>">
            <span class="fa-stack fa-2x pull-left m-r-xs">
                <i class="fas fa-square fa-stack-2x text-success"></i>
                <i class="fas fa-calendar-week fa-stack-1x text-white"></i>
            </span>
            <small class="text-uc" data-rel="tooltip" data-placement="bottom" title="<?php echo e(dateFormatted(now()->startOfWeek())); ?> - <?php echo e(dateFormatted(now()->endOfWeek())); ?>"><?php echo trans('app.'.'this_week'); ?></small>
            <span class="h4 block m-t-xs text-dark"><?php echo e(secToHours(getCalculated('time_this_week'))); ?></span>
        </a>
    </div>
    <div class="col-sm-6 col-md-3 padder-v pallete b-b b-r">
        <a class="clear" href="<?php echo e(route('reports.index', ['m' => 'projects'])); ?>">
            <span class="fa-stack fa-2x pull-left m-r-xs">
                <i class="fas fa-square fa-stack-2x text-info"></i>
                <i class="fas fa-balance-scale fa-stack-1x text-white"></i>
            </span>
            
            <small class="text-uc" data-rel="tooltip" title="Average Billable"><?php echo trans('app.'.'average'); ?></small>
            <span class="h4 block m-t-xs text-dark"><?php echo e(secToHours(round(getCalculated('projects_average_billable')))); ?></span>
        </a>
    </div>
    <div class="col-sm-6 col-md-3 padder-v pallete b-b">
        <a class="clear" href="<?php echo e(route('projects.index')); ?>">
            <span class="fa-stack fa-2x pull-left m-r-xs">
                <i class="fas fa-square fa-stack-2x text-danger"></i>
                <i class="fas fa-percent fa-stack-1x text-white"></i>
            </span>
            
            <small class="text-uc" data-rel="tooltip" data-placement="bottom" title="Average Budget"><?php echo trans('app.'.'budget'); ?></small>
            <span class="h4 block m-t-xs text-dark"><?php echo e(round(getCalculated('projects_average_budget'))); ?>%</span> </a>
        </div>
        
    </div>