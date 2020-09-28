<div class="row">
  <div class="col-sm-4">
    <section class="panel panel-info">
      <div class="panel-body">
        <div class="clear"> <span class="text-dark"><?php echo trans('app.'.'active'); ?> </span> <small class="block text-danger pull-right m-l text-bold"> <?php echo e(getCalculated('projects_active')); ?> </small> </div>
      </div>
    </section>
    <section class="panel panel-info">
      <div class="panel-body">
        <div class="clear"> <span class="text-dark"><?php echo trans('app.'.'done'); ?> </span> <small class="block text-success pull-right m-l text-bold"> <?php echo e(getCalculated('projects_done')); ?> </small> </div>
      </div>
    </section>
    <section class="panel panel-info">
      <div class="panel-body">
        <div class="clear"> <span class="text-dark">Avg. <?php echo trans('app.'.'used_budget'); ?> </span> <small class="block text-primary pull-right m-l text-bold"> <?php echo e(percent(getCalculated('projects_average_budget'))); ?>% </small> </div>
      </div>
    </section>
    
    
  </div>
  <div class="col-md-8 b-top"> <?php echo app('arrilot.widget')->run('Projects\TaskProjectChart'); ?> </div>
</div>
<div class="row b-t">
  <div class="col-md-3 col-sm-6">
    <div class="widget">
      <header class="widget-header">
        <h4 class="widget-title">1st <?php echo trans('app.'.'quarter'); ?> , <?php echo e($year); ?></h4>
      </header>
      <hr class="widget-separator">
      <div class="widget-body p-t-lg"> <?php 
        $janProjects = getCalculated('projects_done_1_'.$year); 
        $febProjects = getCalculated('projects_done_2_'.$year); 
        $marProjects = getCalculated('projects_done_3_'.$year);
        $semOne = array($janProjects, $febProjects, $marProjects); 
        ?>
        <div class="clearfix m-b-md small"><?php echo e(langdate('cal_january')); ?>

          <div class="pull-right text-bold"> <?php echo e($janProjects); ?></div>
        </div>
        <div class="clearfix m-b-md small"><?php echo e(langdate('cal_february')); ?>

          <div class="pull-right text-bold"> <?php echo e($febProjects); ?> </div>
        </div>
        <div class="clearfix m-b-md small"><?php echo e(langdate('cal_march')); ?>

          <div class="pull-right text-bold"> <?php echo e($marProjects); ?> </div>
        </div>
        <div class="clearfix m-b-md small">
          <div class="pull-right text-dark"> <strong> <?php echo e(array_sum($semOne)); ?> <?php echo trans('app.'.'projects'); ?> </strong> </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6">
    <div class="widget">
      <header class="widget-header">
        <h4 class="widget-title">2nd <?php echo trans('app.'.'quarter'); ?> , <?php echo e($year); ?></h4>
      </header>
      <hr class="widget-separator">
      <div class="widget-body p-t-lg"> <?php 
        $aprProjects = getCalculated('projects_done_4_'.$year); 
        $mayProjects = getCalculated('projects_done_5_'.$year); 
        $junProjects = getCalculated('projects_done_6_'.$year);
        $semTwo = array($aprProjects, $mayProjects, $junProjects); 
        ?>
        <div class="clearfix m-b-md small"><?php echo e(langdate('cal_april')); ?>

          <div class="pull-right text-bold"> <?php echo e($aprProjects); ?></div>
        </div>
        <div class="clearfix m-b-md small"><?php echo e(langdate('cal_may')); ?>

          <div class="pull-right text-bold"> <?php echo e($mayProjects); ?> </div>
        </div>
        <div class="clearfix m-b-md small"><?php echo e(langdate('cal_june')); ?>

          <div class="pull-right text-bold"> <?php echo e($junProjects); ?> </div>
        </div>
        <div class="clearfix m-b-md small">
          <div class="pull-right text-dark"> <strong> <?php echo e(array_sum($semTwo)); ?> <?php echo trans('app.'.'projects'); ?> </strong> </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6">
    <div class="widget">
      <header class="widget-header">
        <h4 class="widget-title">3rd <?php echo trans('app.'.'quarter'); ?> , <?php echo e($year); ?></h4>
      </header>
      <hr class="widget-separator">
      <div class="widget-body p-t-lg"> <?php 
        $julProjects = getCalculated('projects_done_7_'.$year); 
        $augProjects = getCalculated('projects_done_8_'.$year); 
        $sepProjects = getCalculated('projects_done_9_'.$year);
        $semThree = array($julProjects, $augProjects, $sepProjects); 
        ?>
        <div class="clearfix m-b-md small"><?php echo e(langdate('cal_july')); ?>

          <div class="pull-right text-bold"> <?php echo e($julProjects); ?></div>
        </div>
        <div class="clearfix m-b-md small"><?php echo e(langdate('cal_august')); ?>

          <div class="pull-right text-bold"> <?php echo e($augProjects); ?> </div>
        </div>
        <div class="clearfix m-b-md small"><?php echo e(langdate('cal_september')); ?>

          <div class="pull-right text-bold"> <?php echo e($sepProjects); ?> </div>
        </div>
        <div class="clearfix m-b-md small">
          <div class="pull-right text-dark"> <strong> <?php echo e(array_sum($semThree)); ?> <?php echo trans('app.'.'projects'); ?> </strong> </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6">
    <div class="widget">
      <header class="widget-header">
        <h4 class="widget-title">4th <?php echo trans('app.'.'quarter'); ?> , <?php echo e($year); ?></h4>
      </header>
      <hr class="widget-separator">
      <div class="widget-body p-t-lg"> <?php 
        $octProjects = getCalculated('projects_done_10_'.$year); 
        $novProjects = getCalculated('projects_done_11_'.$year); 
        $decProjects = getCalculated('projects_done_12_'.$year);
        $semFour = array($octProjects, $novProjects, $decProjects); 
        ?>
        <div class="clearfix m-b-md small"><?php echo e(langdate('cal_october')); ?>

          <div class="pull-right text-bold"> <?php echo e($octProjects); ?></div>
        </div>
        <div class="clearfix m-b-md small"><?php echo e(langdate('cal_november')); ?>

          <div class="pull-right text-bold"> <?php echo e($novProjects); ?> </div>
        </div>
        <div class="clearfix m-b-md small"><?php echo e(langdate('cal_december')); ?>

          <div class="pull-right text-bold"> <?php echo e($decProjects); ?> </div>
        </div>
        <div class="clearfix m-b-md small">
          <div class="pull-right text-dark"> <strong> <?php echo e(array_sum($semFour)); ?> <?php echo trans('app.'.'projects'); ?> </strong> </div>
        </div>
      </div>
    </div>
  </div>
</div>
