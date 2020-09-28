<section class="panel panel-default">
  
  <header class="panel-heading font-bold">
    <?php echo e($year); ?> - <?php echo trans('app.'.'yearly_overview'); ?>
    <div class="m-b-sm pull-right">
      <div class="btn-group">
        <button class="btn btn-dark btn-xs dropdown-toggle" data-toggle="dropdown"><?php echo trans('app.'.'year'); ?> <span
        class="caret"></span></button>
        <ul class="dropdown-menu">
          <?php $min = date('Y') - 3; ?>
          <?php $__currentLoopData = range($min, date('Y')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><a href="?setyear=<?php echo e($y); ?>"><?php echo e($y); ?></a></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    </div>
  </header>
  
  <div class="panel-body">
    <div id="task-project-chart"></div>
  </div>
</section>
<?php $__env->startPush('pagescript'); ?>
<?php echo $__env->make('stacks.js.chart', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<script>
let chart = new frappe.Chart( "#task-project-chart", {
data: {
labels: ["<?php echo e(langdate('cal_jan')); ?>", "<?php echo e(langdate('cal_feb')); ?>", "<?php echo e(langdate('cal_mar')); ?>", "<?php echo e(langdate('cal_apr')); ?>", "<?php echo e(langdate('cal_may')); ?>", "<?php echo e(langdate('cal_jun')); ?>",
"<?php echo e(langdate('cal_jul')); ?>", "<?php echo e(langdate('cal_aug')); ?>", "<?php echo e(langdate('cal_sep')); ?>", "<?php echo e(langdate('cal_oct')); ?>", "<?php echo e(langdate('cal_nov')); ?>", "<?php echo e(langdate('cal_dec')); ?>"],
datasets: [
{
  name: "<?php echo e(langapp('projects')); ?>", chartType: 'bar',
  values: [<?php echo e($projects['jan']); ?>, <?php echo e($projects['feb']); ?>, <?php echo e($projects['mar']); ?>, <?php echo e($projects['apr']); ?>, <?php echo e($projects['may']); ?>, <?php echo e($projects['jun']); ?>, <?php echo e($projects['jul']); ?>,
  <?php echo e($projects['aug']); ?>, <?php echo e($projects['sep']); ?>, <?php echo e($projects['oct']); ?>, <?php echo e($projects['nov']); ?>, <?php echo e($projects['dec']); ?>]
},
{
  name: "<?php echo e(langapp('tasks')); ?>", chartType: 'bar',
  values: [<?php echo e($tasks['jan']); ?>, <?php echo e($tasks['feb']); ?>, <?php echo e($tasks['mar']); ?>, <?php echo e($tasks['apr']); ?>, <?php echo e($tasks['may']); ?>, <?php echo e($tasks['jun']); ?>, <?php echo e($tasks['jul']); ?>,
  <?php echo e($tasks['aug']); ?>, <?php echo e($tasks['sep']); ?>, <?php echo e($tasks['oct']); ?>, <?php echo e($tasks['nov']); ?>, <?php echo e($tasks['dec']); ?>]
},

],
},
title: "<?php echo e(langapp('projects_analysis')); ?>",
type: 'axis-mixed',
height: 300,
colors: ['#4a90e2', '#83ebed'],
tooltipOptions: {
  formatTooltipX: d => (d + '').toUpperCase(),
  formatTooltipY: d => d + '',
}
});
</script>
<?php $__env->stopPush(); ?>