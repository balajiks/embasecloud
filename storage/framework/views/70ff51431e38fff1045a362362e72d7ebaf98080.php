<?php
$arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
shuffle($arrbgdata); 
$diseasedata = explode(',',$diseases[0]->diseaseslink);
?>
 <?php $__currentLoopData = $diseasedata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dataclass): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<li class="list-group-item" data-id="<?php echo e($diseases[0]->id); ?>" id="medical-<?php echo e($diseases[0]->id); ?>">
  <div class="todo-indicator bg-<?php echo e($arrbgdata[0]); ?>"></div>
  <div class="widget-content p-0">
    <div class="widget-content-wrapper">
      <div class="widget-content-left flex2 text-dark">
	  
	  	<?php if($dataclass === 'Null' || empty($dataclass)): ?>
        <div class="widget-heading text-dark">No Data</div>
		<?php else: ?>
		<div class="widget-heading text-dark"><?php echo e($dataclass); ?></div>
		<?php endif; ?>
		
      </div>
	  <?php if($dataclass != 'Null'): ?>
      <div class="widget-content-right widget-content-actions">
        <div class="border-0 btn-transition btn"> <?php if($diseases[0]->user_id === Auth::id()): ?> <a href="#" class="deleteDiseases" data-section-id="<?php echo e($dataclass); ?>" title="<?php echo trans('app.'.'delete'); ?>"  onclick="deleteDiseases('<?php echo e(@$dataclass); ?>','<?php echo e(@$diseases[0]->id); ?>')"><i class="fa fa-trash-alt text-danger"></i> </a> <?php endif; ?> </div>
      </div>
	  <?php endif; ?>
    </div>
  </div>
</li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 