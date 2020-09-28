<?php
// Field 4 - Saved Data
	$matchThese 			= ['user_id' => $user_id, 'jobid' => $jobid, 'orderid' => $orderid];
	$drugtermdata 			= DB::table('index_drug')->where($matchThese)->get()->toArray();
	$drugtermtypecount 		= DB::table('index_drug')->select('type', DB::raw('count(*) as total'))->where($matchThese)->groupBy('type')->pluck('total','type')->all();
	

	$drugdata = array();
	foreach($drugtermdata as $termgroup){
	   $drugdata[$termgroup->type][] = $termgroup;
	}
	$data['drugtermtypecount']  = $drugtermtypecount;
	$data['drugdata']   		= $drugdata;
?>
<div class="col-lg-121">
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading"> <?php echo trans('app.'.'drugsublink'); ?> <span class="btn btn-success btn-xs">Total: <span id="drugtotalajax"><?php echo e(@$drugtermtypecount['minor'] + @$drugtermtypecount['major']); ?> </span></span></div>
      <div class="panel-body">
        <div class="slim-scroll1">
          <div class="form-group">
            <div class="panel-group" id="accordion"> <?php if(!empty($drugdata)): ?>
              <?php 
              $cnt =1;
              ?>
              <?php $__currentLoopData = $drugdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$drugterms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="panel panel-default">
                <div class="panel-heading"> <?php if($key == 'major'): ?>
                  <h3 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo e($cnt); ?>"> <?php echo e(ucwords($key)); ?>&nbsp;&nbsp;<span class="btn btn-info btn-xs m-r"><span id="drugmajortotalajax"><?php echo e(@$drugtermtypecount['major']); ?></span> </span></a></h3>
                  <?php else: ?>
                  <h3 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo e($cnt); ?>"><?php echo e(ucwords($key)); ?>&nbsp;&nbsp;<span class="btn btn-info btn-xs m-r"><span id="drugminortotalajax"><?php echo e(@$drugtermtypecount['minor']); ?></span> </span></a></h3>
                  <?php endif; ?> </div>
                <div id="collapseOne<?php echo e($cnt); ?>" class="panel-collapse collapse <?php if($key == 'major'): ?> in <?php endif; ?>">
                  <div class="panel-body">
                    <ul class="todo-list-wrapper section-todo-list list-group list-group-flush slim-scroll" id="<?php echo e($key); ?>-druglistdata" data-height="250" style="height:250px;">
                      <?php $__currentLoopData = $drugterms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $termsdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <li class="list-group-item card" data-id="<?php echo e($termsdata->id); ?>" id="drugtermsdata-<?php echo e($termsdata->id); ?>" onclick="selecteddrugdata('<?php echo e($termsdata->id); ?>','<?php echo e($termsdata->drugterm); ?>','<?php echo e($termsdata->type); ?>')" >
                        <div class="todo-indicator bg-success"></div>
                        <div class="widget-content p-0">
                          <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-2">
                              <div class="custom-checkbox custom-control">
                                <div class="placeholdericon"></div>
                              </div>
                            </div>
                            <div class="widget-content-left flex2 text-dark">
                              <div class="widget-heading text-dark"><?php echo e($termsdata->drugterm); ?></div>
                            </div>
                            <div class="widget-content-right">
                              <div class="badge badge-secondary mr-2"><?php echo e($termsdata->termtype); ?></div>
                            </div>
                            <div class="widget-content-right widget-content-actions">
                              <div class="border-0 btn-transition btn"> <?php if($termsdata->user_id === Auth::id()): ?> <a href="#" class="deletedrugterm" data-section-id="<?php echo e($termsdata->id); ?>" title="<?php echo trans('app.'.'delete'); ?>"><i class="fa fa-trash-alt text-danger"></i> </a> <?php endif; ?> </div>
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
              <?php endif; ?> </div>
            <?php /*?><div class="row"> @if(!empty($drugdata))
                @foreach ($drugdata as $key =>$drugterms )
                <ol class="dd-list" id="{{$key}}-druglistdata">
                  <li class="btn-warning" style="padding-left:20px;">
                    <label>{{$key}}</label>
                  </li>
                  @foreach ($drugterms as $termsdata )
                  <li class="dd-item dd3-item active" data-id="{{ $termsdata->id }}" id="drugtermsdata-{{ $termsdata->id }}" onclick="selecteddrugdata('{{$termsdata->id}}','{{$termsdata->drugterm}}','{{$termsdata->type}}')" > <span class="pull-right m-xs"> @if ($termsdata->user_id === Auth::id()) <a href="#" class="deletedrugterm" data-section-id="{{$termsdata->id}}" title="@langapp('delete')"> @icon('solid/times', 'icon-muted fa-fw m-r-xs') </a> @endif </span>
                   
				    <div class="dd3-content" id="drugtermshighlight-{{ $termsdata->id }}">
                      <label><span class="label-text active"> <span class="{!! $termsdata->status ? 'text-info' : 'text-danger' !!}" id="drug-id-{{ $termsdata->id }}"> {{ $termsdata->drugterm }} </span></span></label>
                      <span class="btn btn-info btn-xs pull-right">{{ $termsdata->termtype }}</span> </div>
                  </li>
                  @endforeach
                </ol>
                @endforeach
				
				
                @else
                <ol class="dd-list" id="major-druglistdata">
                  <li class="btn-warning" style="padding-left:20px;">
                    <label>Major</label>
                  </li>
                  <li id="major-listdata"></li>
                </ol>
                <ol class="dd-list" id="minor-druglistdata">
                  <li class="btn-warning" style="padding-left:20px;">
                    <label>Minor</label>
                  </li>
                  <li id="minor-listdata"></li>
                </ol>
                @endif </div><?php */?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
