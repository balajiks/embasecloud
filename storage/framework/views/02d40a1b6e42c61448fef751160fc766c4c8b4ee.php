
<div class="row">
  <div class="col-sm-12 col-lg-6">
    <div class="card-hover-shadow-2x mb-3 card">
      <div class="card-header-tab" style="border-bottom:1px solid rgba(26,54,126,0.125);">
        <div class="card-header" style="float:left;">
          <div class="card-header-title font-size-xlg text-capitalize font-weight-bold"> <i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i>Section </div>&nbsp;&nbsp;&nbsp;<input id="selectAll" type="checkbox">
          <label for='selectAll' class="badge badge-primary mr-2" style="font-size:100% !important; margin-top:7px; cursor:pointer;">Select All</label>
          &nbsp;&nbsp;&nbsp;
          <label class="badge badge-danger mr-2" style="font-size:100%; margin-top:7px;" id="sectiondeletebtn">Delete</label>
        </div>
        <span id="preloader" class="btn btn-sm btn-warning pull-right" style="display:block !important;"><i class="fas fa-spin fa-spinner"></i> Loading...</span> </div>
      <div class="p-2">
        <ul class="todo-list-wrapper section-todo-list list-group list-group-flush slim-scroll" data-height="250">
          <?php $__currentLoopData = @$indexingsections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
          $arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
          shuffle($arrbgdata); 
          ?>
		  
		  
          <li class="list-group-item card" id="sectiondata-<?php echo e($section->id); ?>">
            <div class="todo-indicator bg-<?php echo e($arrbgdata[0]); ?>"></div>
            <div class="widget-content p-0">
              <div class="widget-content-wrapper">
                <div class="widget-content-left mr-2">
                  <div class="custom-checkbox custom-control">
                    <input type="checkbox" class="custom-control-input" id="CustomSectionCheckbox<?php echo e($section->id); ?>" value="<?php echo e($section->id); ?>">
                    <label for="CustomSectionCheckbox<?php echo e($section->id); ?>" class="custom-control-label">&nbsp;</label>
                  </div>
                </div>
                <div class="widget-content-left flex2 text-dark sectionajax" data-id="<?php echo e($section->id); ?>" id="section-<?php echo e($section->id); ?>">
                  <div class="widget-heading text-dark">Section : <?php echo e($section->sectionval); ?></div>
                  <div class="widget-subheading text-dark">Publication Choice: <?php echo e($section->pubchoice); ?></div>
                </div>
                <div class="widget-content-right widget-content-actions">
                  <div class="border-0 btn-transition btn"> <a href="#" class="editSection" data-section-id="<?php echo e($section->id); ?>" title="<?php echo trans('app.'.'edit'); ?>"><i class="fa fa-edit text-primary"></i> </a> </div>
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
  <?php
  $arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
  shuffle($arrbgdata); 
  ?>
  <div class="col-sm-12 col-lg-6">
    <div class="card-hover-shadow-2x mb-3 card">
      <div class="card-header-tab" style="border-bottom:1px solid rgba(26,54,126,0.125);">
        <div class="card-header" style="float:left;">
          <div class="card-header-title font-size-xlg text-capitalize font-weight-bold"> <i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i>Classification </div>
        </div>
        <span id="preloaderloading" class="btn btn-sm btn-warning pull-right"><i class="fas fa-spin fa-spinner"></i> Loading...</span> </div>
      <div class="p-2">
        <ul class="todo-list-wrapper list-group list-group-flush slim-scroll innerhtmlclassification" data-height="250">
          <?php if(@$indexingsections[0]->classificationval !=''): ?>
          <?php
          $classdata = explode('|||',@$indexingsections[0]->classificationval);
          ?>
          
          
          
          <?php $__currentLoopData = $classdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dataclass): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li class="list-group-item card" data-id="<?php echo e(@$indexingsections[0]->id); ?>" id="section-<?php echo e(@$indexingsections[0]->id); ?>" >
            <div class="todo-indicator bg-<?php echo e($arrbgdata[0]); ?>"></div>
            <div class="widget-content p-0">
              <div class="widget-content-wrapper">
                <div class="widget-content-left flex2 text-dark">
                  <div class="widget-heading text-dark"><?php echo e($dataclass); ?></div>
                </div>
                <div class="widget-content-right widget-content-actions">
                  <div class="border-0 btn-transition btn"> <?php if(@$indexingsections[0]->user_id === Auth::id()): ?> <a href="#" class="deleteClassification" data-section-id="<?php echo e(@$dataclass); ?>" title="<?php echo trans('app.'.'delete'); ?>" onclick="deleteClassification('<?php echo e(@$dataclass); ?>','<?php echo e(@$indexingsections[0]->id); ?>')"><i class="fa fa-trash-alt text-danger"></i> </a> <?php endif; ?> </div>
                </div>
              </div>
            </div>
          </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <?php endif; ?> </div>
    </div>
  </div>
</div>
