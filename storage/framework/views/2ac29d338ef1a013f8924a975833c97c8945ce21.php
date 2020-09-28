<div class="row">
<div class="col-lg-12"> <?php echo Form::open(['route' => 'indexing.api.savesection', 'id' => 'createSection', 'class' => 'bs-example form-horizontal m-b-none']); ?>

  <section class="panel panel-default">
  <?php 
  $translations = Modules\Settings\Entities\Options::translations();
  $default_country = get_option('company_country');
  $disable = '';
  ?>
  <div class="panel-body card">
    <input type="hidden" class="form-control" placeholder="jobid" name="jobid" id="jobid" value="<?php echo e($jobdata->id); ?>" />
    <input type="hidden" class="form-control" placeholder="pui" name="pui" id="pui" value="<?php echo e($jobdata->pui); ?>" />
    <input type="hidden" class="form-control" placeholder="orderid" name="orderid" id="orderid" value="<?php echo e($jobdata->orderid); ?>" />
    <input type="hidden" class="form-control" placeholder="jobid" id="sectioncount" name="sectioncount" value="<?php echo e($sectioncount); ?>" />
    <input type="hidden" class="form-control" placeholder="pubchoicecount" id="pubchoicecount" name="pubchoicecount" value="<?php echo e($pubchoicecount); ?>" />
    <input type="hidden" class="form-control" placeholder="sectionid" id="sectionid" name="sectionid" value="0" />
    <input type="hidden" class="form-control" placeholder="updateclassification" id="updateclassification" name="updateclassification" value="0" />
    <input type="hidden" name="json" value="false"/>
    <div class="col-md-12">
      <header class="panel-heading" style="padding:10px 0px !important;">
        <header class="btn btn-default btn-sm"> <?php echo e(svg_image('solid/exclamation-circle')); ?> <?php echo trans('app.'.'sectionalertinfo'); ?>  &nbsp;&nbsp;[ PUBL: <span class="badge badge-warning mr-2"><?php echo e($jobdata->publ); ?> </span> | Abstract: <span class="badge badge-warning mr-2"><?php echo e($jobdata->abs); ?> </span> ]</header>
        <div class="btn btn-sm label-success pull-right" >Section Count : <span id="indexersectioncount"><?php echo e($sectioncount); ?></span></div>
      </header>
      <?php if(count($translations) > 0): ?>
      <div class="tab-content tab-content-fix">
        <div class="tab-pane fade in active" id="tab-english"> <?php endif; ?>
          <div id="frmindexsectionshow" class=""> <?php if($jobdata->publ == 'Yes' && $jobdata->abs == 'Yes'): ?>
            <input type="hidden" class="form-control" placeholder="jobdatayestoall" name="jobdatayestoall" value="1" />
            <div class="form-group">
              <div class="col-lg-3">
                <label><?php echo trans('app.'.'section'); ?></label>
                <span class="text-dark label label-danger pull-right"><?php echo e(svg_image('solid/exclamation-circle')); ?> <?php echo trans('app.'.'totalsectionallowed'); ?></span>
                <select class="select2-option form-control" id="indexer_section" name="indexer_section" onChange="getClassification(this.value);" required>
                  <option selected="true" disabled="disabled">Select Section</option>
					<?php $__currentLoopData = embaseindex_section(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sectionval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($sectionval['sectionvalue']); ?>"><?php echo e($sectionval['sectionvalue']); ?></option>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
              <div class="col-lg-3">
                <label><?php echo trans('app.'.'publication'); ?> <span class="text-danger">*</span> </label>
                <select class="select2-option form-control Selpublication" id="Selpublication" name="indexer_publication"  required>
                  <option selected="true" disabled="disabled">Select Publication Choice</option>
                  <option value="?">?</option>
                  <option value="+">+</option>
                </select>
              </div>
              <div class="col-lg-3">
                <label><?php echo trans('app.'.'classification'); ?> <span class="text-danger">*</span> </label>
                <select class="select2-option form-control classification" id="classification" name="indexer_classification[]" required multiple="multiple" data-maximum-selection-length="3">
                </select>
              </div>
              <div class="col-lg-3">
                <div class="form-group"><br />
                  <?php echo renderAjaxcustomButtonSquare('save'); ?> </div>
              </div>
            </div>
            <?php else: ?>
            <input type="hidden" class="form-control" placeholder="jobdatayestoall" name="jobdatayestoall" value="0" />
            <div class="form-group">
              <div class="col-lg-5">
                <label><?php echo trans('app.'.'section'); ?><span class="text-danger">*</span> </label>
                <span class="text-dark label label-danger pull-right"><?php echo e(svg_image('solid/exclamation-circle')); ?> <?php echo trans('app.'.'totalsectionallowed'); ?></span>
                <select class="select2-option form-control indexer_section"  placeholder="jobdatayestoall" id="indexer_section" name="indexer_section[]" multiple="multiple" data-maximum-selection-length="s">
				 <?php $__currentLoopData = embaseindex_section(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sectionval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($sectionval['sectionvalue']); ?>"><?php echo e($sectionval['sectionvalue']); ?></option>
				 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                </select>
              </div>
              <div class="col-lg-3 disabledbutton" >
                <label><?php echo trans('app.'.'publication'); ?></label>
                <select class="form-control" disabled>
                  <option selected="true" disabled="disabled">Select Publication Choice</option>
                </select>
              </div>
              <div class="col-lg-2 disabledbutton">
                <label><?php echo trans('app.'.'classification'); ?></label>
                <select class="form-control" disabled>
                  <option selected="true" disabled="disabled">Classification</option>
                </select>
              </div>
              <div class="col-lg-2">
                <div class="form-group"><br />
                  <?php echo renderAjaxcustomButtonSquare('add'); ?> </div>
              </div>
            </div>
            <?php endif; ?>
            <?php if(count($translations) > 0): ?> </div>
        </div>
        <?php endif; ?> </div>
    </div>
    </section>
    <?php echo Form::close(); ?> </div>
</div>
<div class="sortable">
  <div class="section-list" id="nestable"> <?php if($jobdata->publ == 'Yes' && $jobdata->abs == 'Yes'): ?>
    <?php echo app('arrilot.widget')->run('Indexing\ShowSectionswithclassification', ['indexingsections' => DB::table('datasections')
    ->where('datasections.user_id', \Auth::id())->where('datasections.jobid', $jobdata->id)->where('datasections.orderid', $jobdata->orderid)->where('datasections.pui', $jobdata->pui)
    ->get()]); ?>
    <?php else: ?> 
    <?php echo app('arrilot.widget')->run('Indexing\ShowSections', ['indexingsections' => DB::table('datasections')
    ->where('datasections.user_id', \Auth::id())->where('datasections.jobid', $jobdata->id)->where('datasections.orderid', $jobdata->orderid)->where('datasections.pui', $jobdata->pui)
    ->get()]); ?>
    <?php endif; ?> </div>
</div>
<?php $__env->startPush('pagestyle'); ?>
<link rel=stylesheet href="<?php echo e(getAsset('plugins/nestable/nestable.css')); ?>">
<?php echo $__env->make('stacks.css.form', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('pagescript'); ?>
<?php echo $__env->make('stacks.js.form', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php if($sectioncount == langapp('sectioncnt')): ?>
<script>$('#frmindexsectionshow').find('input, textarea, button, select').attr('disabled','disabled');</script>
<?php else: ?>
<script>$('#frmindexsectionshow').find('input, textarea, button, select').removeAttr('disabled','disabled');</script>
<?php endif; ?>
<script>
$("#preloader").hide();
$("#preloaderloading").hide();
$(document).ready(function () {
	var seccont = <?php echo trans('app.'.'sectioncnt'); ?> - $('#sectioncount').val();
	if(seccont == 1) {
		$("#indexer_section").select2();
	} else {
		$("#indexer_section").select2({
			maximumSelectionLength: seccont
		});
	}
});

function getClassification(val) {
	var selectedValues = $('#indexer_section').val();
	var res = selectedValues.split("|");
	if(selectedValues !='') {
		axios.post('<?php echo e(get_option('site_url')); ?>api/v1/indexing/ajax/classification', {
			id: res[0].trim()
		})
		.then(function (response) {
			$('.classification').html(response.data);
			$("#classification").select2({
       	 		maximumSelectionLength: 3
  		  	});
			var updateclassification = $('#updateclassification').val();
			if(updateclassification !=0) {
				var res = updateclassification.split("|||");
				$("#classification").select2().val(res).trigger("change");
			}
		})
		.catch(function (error) {
			var errors = error.response.data.errors;
			var errorsHtml= '';
			$.each( errors, function( key, value ) {
				errorsHtml += '<li>' + value[0] + '</li>';
			});
			toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
		});
	}
}

$(document).ready(function() {
	$("#sectiondeletebtn").click(function(){
		var sectionindex = [];
		$.each($(".custom-checkbox input[type='checkbox']:checked"), function(){
			sectionindex.push($(this).val());
		});
		if(sectionindex.length > 0) {
			if(!confirm('Do you want to delete all this section?')) {
				return false;
			}
			axios.post('<?php echo e(get_option("site_url")); ?>api/v1/indexing/sectiondeleteall', {
				id       :  sectionindex,
				jobid    : 	$('#jobid').val(),
				orderid  :  $('#orderid').val(),
				pui	     :  $('#pui').val(),
			})
			.then(function (response) {
				var maxselect = <?php echo trans('app.'.'sectioncnt'); ?> - response.data.count;
				$("#indexer_section").select2({
					maximumSelectionLength: maxselect
				});
				$("#sectioncount").val(response.data.count);
				$("#pubchoicecount").val(response.data.pubchoicecount);
				$("#indexersectioncount").html(response.data.count);
				toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
				ajaxdatview();
				open = false;
				toggle(open);
				$.each($(".custom-checkbox input[type='checkbox']:checked"), function(){
					$('#sectiondata-' + $(this).val()).hide(500, function () {
						$(this).remove();
					});
				 });
				$(".innerhtmlclassification").html();	
				$('.innerhtmlclassification').hide(1000, function () {
				$(".innerhtmlclassification").html();	
				});
			})
			.catch(function (error) {
				toastr.error( 'Oops! Something went wrong!' , '<?php echo trans('app.'.'response_status'); ?> ');
			});
		} else {
			alert('Please select section data!!');
			return false;
		}
	});
});
</script>
<?php $__env->stopPush(); ?>