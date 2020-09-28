<?php
// Field 3 - Saved Data
		$matchThese 			= ['user_id' => $user_id, 'jobid' => $jobid, 'orderid' => $orderid];
		$checktagdata 			= DB::table('index_medical_checktag')->where($matchThese)->get()->toArray();
		$medicaltermdata 		= DB::table('index_medical_term')->where($matchThese)->get()->toArray();
		$medicaltermtypecount 	= DB::table('index_medical_term')->select('type', DB::raw('count(*) as total'))->where($matchThese)->groupBy('type')->pluck('total','type')->all();
		$diseasescount 			= DB::table('index_medical_term')->select(DB::raw("(CHAR_LENGTH(diseaseslink) - CHAR_LENGTH(REPLACE(diseaseslink, ',', '')) + 1) as TotalValue"))->where($matchThese)->where('diseaseslink', '<>', 'Null')->get()->toArray();
		
		$totaldiseasescnt = 0;
		foreach($diseasescount as $cntval){
		   $totaldiseasescnt = $totaldiseasescnt + $cntval->TotalValue;
		}

		$medicaldata = array();
		foreach($medicaltermdata as $termgroup){
		   $medicaldata[$termgroup->type][] = $termgroup;
		}
		$data['checktagdata']   		= $checktagdata;
		$data['medicaltermtypecount']   = $medicaltermtypecount;
		$data['medicaldata']   			= $medicaldata;
?>
<?php
$arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
shuffle($arrbgdata); 
?>


<div class="col-lg-12">
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading"><?php echo trans('app.'.'medicalinfo'); ?> <span class="btn btn-success btn-xs">Total: <span id="medtotalajax"><?php echo e(@$medicaltermtypecount['minor'] + @$medicaltermtypecount['major'] + count(@$checktagdata)); ?> </span></span></div>
      <div class="panel-body">
        <div class="slim-scroll1">
          <div class="form-group">
            <div class="col-md-6">
              <div class="panel-group" id="accordion"> <?php if(!empty($medicaldata)): ?>
                <?php 
                $cnt =1;
                ?>
                <?php $__currentLoopData = $medicaldata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$medicalterms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				
                <div class="panel panel-default">
                  <div class="panel-heading"> <?php if($key == 'major'): ?>
                    <h3 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo e($cnt); ?>"> <?php echo e(ucwords($key)); ?>&nbsp;&nbsp;<span class="btn btn-info btn-xs m-r"><span id="medmajortotalajax"><?php echo e(@$medicaltermtypecount['major']); ?></span> </span></a></h3>
                    <?php else: ?>
                    <h3 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo e($cnt); ?>"><?php echo e(ucwords($key)); ?>&nbsp;&nbsp;<span class="btn btn-info btn-xs m-r"><span id="medminortotalajax"><?php echo e(@$medicaltermtypecount['minor']); ?></span> </span></a></h3>
                    <?php endif; ?> </div>
                  <div id="collapseOne<?php echo e($cnt); ?>" class="panel-collapse collapse <?php if($key == 'major'): ?> in <?php endif; ?>">
                    <div class="panel-body">
                      <ul class="todo-list-wrapper section-todo-list list-group list-group-flush slim-scroll" id="<?php echo e($key); ?>-mediallistdata" data-height="147" style="height:147px;">
                        
						<?php $__currentLoopData = $medicalterms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $termsdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php
						$rand = rand(0,4);
						?>
						
						<li class="list-group-item card" id="medicaldata-<?php echo e($termsdata->id); ?>">
						<div class="todo-indicator bg-<?php echo $arrbgdata[0];?>"></div>
						<div class="widget-content p-0">
						  <div class="widget-content-wrapper">
							<div class="widget-content-left mr-2">
							  <div class="custom-checkbox custom-control">
								<input type="checkbox" class="custom-control-input" id="CustomSectionCheckbox<?php echo e($termsdata->id); ?>" value="<?php echo e($termsdata->id); ?>">
								<label for="CustomSectionCheckbox<?php echo e($termsdata->id); ?>" class="custom-control-label">&nbsp;</label>
							  </div>
							</div>
							<div class="widget-content-left flex2 text-dark medicalajax" data-id="<?php echo e($termsdata->id); ?>" id="medical-<?php echo e($termsdata->id); ?>">
							  <div class="widget-heading text-dark"><?php echo e($termsdata->medicalterm); ?></div>
							  
							</div>
							<div class="widget-content-right"> <?php if($termsdata->termtype =='MED'): ?>
                                <div class="badge badge-secondary mr-2"><?php echo e($termsdata->termtype); ?></div>
                                <?php elseif($termsdata->termtype =='DIS'): ?>
                                <div class="badge badge-danger mr-2"><?php echo e($termsdata->termtype); ?></div>
								<?php else: ?>
								<div class="badge badge-info mr-2"><?php echo e($termsdata->termtype); ?></div>
                                <?php endif; ?> </div>
								
								
							<div class="widget-content-right widget-content-actions">
							  <div class="border-0 btn-transition btn"> <a href="#" class="editMedical" data-medical-id="<?php echo e($termsdata->id); ?>" title="<?php echo trans('app.'.'edit'); ?>"><i class="fa fa-edit text-primary"></i> </a> </div>
							  <div class="border-0 btn-transition btn"> <?php if($termsdata->user_id === Auth::id()): ?> <a href="#" class="deletemedicalterm" data-medical-id="<?php echo e($termsdata->id); ?>" title="<?php echo trans('app.'.'delete'); ?>"><i class="fa fa-trash-alt text-danger"></i> </a> <?php endif; ?> </div>
							</div>
						  </div>
						</div>
					  </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <li id="<?php echo e($key); ?>-listdata"></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <?php 
                $cnt++;
                ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne1"> Major&nbsp;&nbsp;<span class="btn btn-info btn-xs m-r"><span id="medmajortotalajax">0</span> </span></a></h3>
                  </div>
                  <div id="collapseOne1" class="panel-collapse collapse in ">
                    <div class="panel-body">
                      <ul class="todo-list-wrapper section-todo-list list-group list-group-flush slim-scroll" id="major-mediallistdata" data-height="147" style="height:147px;">
                        <li id="major-listdata"></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne2"> Minor&nbsp;&nbsp;<span class="btn btn-info btn-xs m-r"><span id="medminortotalajax">0</span> </span></a></h3>
                  </div>
                  <div id="collapseOne2" class="panel-collapse collapse">
                    <div class="panel-body">
                      <ul class="todo-list-wrapper section-todo-list list-group list-group-flush slim-scroll" id="minor-mediallistdata" data-height="147" style="height:147px;">
                        <li id="minor-listdata"></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <?php endif; ?>
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOnechecktags">Minor Term (_ib) CheckTags &nbsp;<span class="btn btn-info btn-xs m-r"><span id="medchecktagtotalajax"><?php echo e(count(@$checktagdata)); ?></span> </span></a></h3>
                  </div>
                  <div id="collapseOnechecktags" class="panel-collapse collapse">
                    <div class="panel-body">
                      <ul class="todo-list-wrapper medical-todo-list list-group list-group-flush slim-scroll" data-height="147" style="height:147px;">
					  
                        <?php $__currentLoopData = $checktagdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $checktag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php
						$rand = rand(0,4);
						?>
						
						
						<li class="list-group-item card" id="medicalchecktagdata-<?php echo e($checktag->id); ?>">
						<div class="todo-indicator bg-<?php echo $arrbgdata[0];?>"></div>
						<div class="widget-content p-0">
						  <div class="widget-content-wrapper">
							<div class="widget-content-left mr-2">
							  <div class="custom-checkbox custom-control">
								<input type="checkbox" class="custom-control-input" id="CustomSectionCheckbox<?php echo e($checktag->id); ?>" value="<?php echo e($checktag->id); ?>">
								<label for="CustomSectionCheckbox<?php echo e($checktag->id); ?>" class="custom-control-label">&nbsp;</label>
							  </div>
							</div>
							<div class="widget-content-left flex2 text-dark medicalchecktagajax" data-id="<?php echo e($checktag->id); ?>" id="checktag-<?php echo e($checktag->id); ?>">
							  <div class="widget-heading text-dark"><?php echo e($checktag->checktag); ?></div>
							</div>
							<div class="widget-content-right widget-content-actions">
							 
							  <div class="border-0 btn-transition btn"> <?php if($checktag->user_id === Auth::id()): ?> <a href="#" class="deletechecktag" data-checktag-id="<?php echo e($checktag->id); ?>" title="<?php echo trans('app.'.'delete'); ?>"><i class="fa fa-trash-alt text-danger"></i> </a> <?php endif; ?> </div>
							</div>
						  </div>
						</div>
					  </li>
						
						
						
                        
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<li id="checktags-listdata"></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6" >
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapsediseases">Diseases links</a></h4>
                </div>
                <div id="collapsediseases" class="panel-collapse collapse in">
                  <div class="panel-body">
                    <ul class="todo-list-wrapper section-todo-list list-group list-group-flush slim-scroll" id="diseaseterm" data-height="250" style="height:250px;">
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>