<a href="<?php echo e(route('reports.view', ['type' => 'reports', 'm' => 'projects'])); ?>" class="btn btn-<?php echo e(get_option('theme_color')); ?> btn-sm">
        <?php echo e(svg_image('solid/chart-line')); ?> <?php echo trans('app.'.'reports'); ?>
</a>

<div class="btn-group">

        <button class="btn btn-<?php echo e(get_option('theme_color')); ?> btn-sm dropdown-toggle" data-toggle="dropdown">
            Type
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">          
            <li><a href="<?php echo e(route('reports.view', ['type' => 'feedback', 'm' => 'projects'])); ?>"><?php echo trans('app.'.'feedback'); ?></a></li>
        </ul>
    </div>