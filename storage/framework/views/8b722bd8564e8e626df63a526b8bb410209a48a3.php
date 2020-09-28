<?php $__env->startSection('content'); ?>
<input type="hidden" class="form-control" placeholder="jobid" id="project_jobid" name="jobid" value="<?php echo e($jobdata->id); ?>" />
<input type="hidden" class="form-control" placeholder="pui" id="project_pui" name="pui" value="<?php echo e($jobdata->pui); ?>" />
<input type="hidden" class="form-control" placeholder="orderid" id="project_orderid" name="orderid" value="<?php echo e($jobdata->orderid); ?>" />
<aside class="b-l bg" id="">
  <div class="panel-group m-b" id="accordion2">
    <ul class="list no-style" id="responses-list">
      <li class="panel panel-default" id="tokenize">
        <div class="panel-heading"><?php echo e(svg_image('solid/cogs')); ?> <?php echo trans('app.'.'sectiondetails'); ?>  <span class="badge badge-secondary mr-2">JobID: <?php echo e($jobdata->id); ?></span> &nbsp;&nbsp; <span class="badge badge-secondary mr-2">PUI: <?php echo e(str_replace('_pui ','',$jobdata->pui)); ?></span>
          <div style="float:right; margin-top:-5px;"> <a href="<?php echo e(route('indexing.ajaxapivalidation', ['id' => $jobdata->id])); ?>" class="btn btn-sm btn-<?php echo e(get_option('theme_color')); ?> pull-right" data-toggle="ajaxModal"> <?php echo e(svg_image('solid/vote-yea')); ?> <?php echo trans('app.'.'ajaxapivalidationapi'); ?> </a> <a href="<?php echo e(route('indexing.showmeta', ['id' => $jobdata->id])); ?>" class="btn btn-sm btn-default pull-right" data-toggle="ajaxModal"> <?php echo e(svg_image('solid/newspaper')); ?> <?php echo trans('app.'.'openindexmanual'); ?> </a> <a href="<?php echo e(route('indexing.showemtree', ['id' => $jobdata->id])); ?>" target="_blank" class="btn btn-sm btn-default pull-right"> <?php echo e(svg_image('solid/vials')); ?> <?php echo trans('app.'.'openemtree'); ?> </a> <a href="<?php echo e(route('indexing.showsource', ['id' => $jobdata->id])); ?>" target="_blank" class="btn btn-sm btn-default pull-right"> <?php echo e(svg_image('solid/plus-square')); ?> <?php echo trans('app.'.'opensource'); ?> </a> <a href="<?php echo e(route('indexing.showmeta', ['id' => $jobdata->id])); ?>" class="btn btn-sm btn-default pull-right" data-toggle="ajaxModal"> <?php echo e(svg_image('solid/file-signature')); ?> <?php echo trans('app.'.'metadata'); ?> </a> </div>
        </div>
      </li>
    </ul>
  </div>
  <ul class="dashmenu text-uc text-muted no-border no-radius nav pro-nav-tabs nav-tabs-dashed">
    <li class="<?php echo e(($tab == 'section') ? 'active' : ''); ?>"> <a href="<?php echo e(route('indexing.addindexing', ['id' => $jobdata->id, 'tabmenu' => 'section', 'tab' => 'section'])); ?>"> <img src="<?php echo e(getAsset('images/section.svg')); ?>" > <?php echo trans('app.'.'section'); ?> </a> </li>
    <li class="<?php echo e(($tab == 'medical') ? 'active' : ''); ?>"> <a href="<?php echo e(route('indexing.addindexing', ['id' => $jobdata->id, 'tab' => 'medical'])); ?>"><img src="<?php echo e(getAsset('images/medical.svg')); ?>" > <?php echo trans('app.'.'medical'); ?> </a> </li>
    <li class="<?php echo e(($tab == 'drug') ? 'active' : ''); ?>"> <a href="<?php echo e(route('indexing.addindexing', ['id' => $jobdata->id, 'tab' => 'drug'])); ?>"><img src="<?php echo e(getAsset('images/drug.svg')); ?>" > <?php echo trans('app.'.'drug'); ?> </a> </li>
    <li class="<?php echo e(($tab == 'drugtradename') ? 'active' : ''); ?>"> <a href="<?php echo e(route('indexing.addindexing', ['id' => $jobdata->id, 'tab' => 'drugtradename'])); ?>"><img src="<?php echo e(getAsset('images/drugtrade.svg')); ?>" > <?php echo trans('app.'.'drugtradename'); ?> </a> </li>
    <li class="<?php echo e(($tab == 'mdt') ? 'active' : ''); ?>"> <a href="<?php echo e(route('indexing.addindexing', ['id' => $jobdata->id, 'tab' => 'mdt'])); ?>"><img src="<?php echo e(getAsset('images/mdt.svg')); ?>" > <?php echo trans('app.'.'mdt'); ?> </a> </li>
    <li class="<?php echo e(($tab == 'ctn') ? 'active' : ''); ?>"> <a href="<?php echo e(route('indexing.addindexing', ['id' => $jobdata->id, 'tab' => 'ctn'])); ?>"><img src="<?php echo e(getAsset('images/ctn.svg')); ?>" > <?php echo trans('app.'.'ctn'); ?> </a> </li>
    <li class="<?php echo e(($tab == 'msn') ? 'active' : ''); ?>"> <a href="<?php echo e(route('indexing.addindexing', ['id' => $jobdata->id, 'tab' => 'msn'])); ?>"><img src="<?php echo e(getAsset('images/msn.svg')); ?>" > <?php echo trans('app.'.'msn'); ?> </a> </li>
    <li class="<?php echo e(($tab == 'mdi') ? 'active' : ''); ?>"> <a href="<?php echo e(route('indexing.addindexing', ['id' => $jobdata->id, 'tab' => 'mdi'])); ?>"><img src="<?php echo e(getAsset('images/mdi.svg')); ?>" > <?php echo trans('app.'.'mdi'); ?> </a> </li>
  </ul>
  <section class="padder"> <?php echo $__env->make('indexing::tab._'.$tab, \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?> </section>
</aside>
<aside class="aside-lg b-l">
  <section class="vbox">
    <section class="scrollable" id="feeds">
      <div class="slim-scroll" data-color="#333333" data-disable-fade-out="true" data-distance="0" data-height="auto" data-size="3px"> <?php echo $__env->make('indexing::_sidebar.'.$tabmenu, \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?> </div>
    </section>
  </section>
</aside>
<?php $__env->startPush('pagescript'); ?>
<?php echo $__env->make('indexing::_ajax.sectionjs', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<script type="text/javascript">
$(document).ready(function () {
var kanbanCol = $('.scrumboard');
draggableInit();
});

function draggableInit() {
	var sourceId;
	$('[draggable=true]').bind('dragstart', function (event) {
	sourceId = $(this).parent().attr('id');
	event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));
	});
	$('.scrumboard').bind('dragover', function (event) {
	event.preventDefault();
	});
	$('.scrumboard').bind('drop', function (event) {
	var children = $(this).children();
	var targetId = children.attr('id');
	if (sourceId != targetId) {
	var elementId = event.originalEvent.dataTransfer.getData("text/plain");
	$('#processing-modal').modal('toggle');
	setTimeout(function () {
	var element = document.getElementById(elementId);
	id = element.getAttribute('id');
	axios.post('/api/v1/indexing/'+id+'/movestage', {
	id: id,
	target: targetId
	})
	.then(function (response) {
	toastr.success(response.data.message, '<?php echo trans('app.'.'success'); ?> ');
	})
	.catch(function (error) {
	var errors = error.response.data.errors;
	var errorsHtml= '';
	$.each( errors, function( key, value ) {
	errorsHtml += '<li>' + value[0] + '</li>';
	});
	toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
	});
	children.prepend(element);
	$('#processing-modal').modal('toggle');
	}, 1000);
	}
	event.preventDefault();
	});
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.indexerapp', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>