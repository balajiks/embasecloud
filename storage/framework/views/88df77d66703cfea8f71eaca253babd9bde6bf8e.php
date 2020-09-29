<div class="row">
  <div class="col-lg-12"> <?php echo Form::open(['route' => 'indexing.api.savemedical', 'id' => 'createMedical', 'class' => 'bs-example form-horizontal m-b-none']); ?>

    <section class="panel panel-default"> <?php 
      $translations = Modules\Settings\Entities\Options::translations();
      $default_country = get_option('company_country');
      $disable = '';
      ?>
      <div class="panel-body card">
        <input type="hidden" class="form-control" placeholder="jobid" name="jobid" id="jobid" value="<?php echo e($jobdata->id); ?>" />
        <input type="hidden" class="form-control" placeholder="pui" name="pui" id="pui" value="<?php echo e($jobdata->pui); ?>" />
        <input type="hidden" class="form-control" placeholder="orderid" name="orderid" id="orderid" value="<?php echo e($jobdata->orderid); ?>" />
        <input type="hidden" name="json" value="false"/>
		<input type="hidden" class="form-control" placeholder="medicalid" id="medicalid" name="medicalid" value="0" />
		<input type="hidden" class="form-control" placeholder="updatediseases" id="updatediseases" name="updatediseases" value="0" />
        <div class="row">
          <div class="col-md-12">
            <header class="panel-heading" style="padding:10px 0px !important;">
              <header class="btn btn-default btn-sm"> <?php echo e(svg_image('solid/exclamation-circle')); ?> <?php echo trans('app.'.'medicalalertinfo'); ?>  &nbsp;&nbsp;[ <span class="badge badge-warning mr-2"><?php echo trans('app.'.'medicalinfo'); ?> </span> ]</header>
            </header>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
		  <div class="badge badge-info mr-2" style="margin-bottom:10px">Medical Term</div><br />
            <div class="form-group">
              <div class="col-lg-4">
                <label>
                <input type="radio" id="txtmedicalmajor" name="medicaltermindexing" value="1">
                <span class="label-text text-info">Major</span></label>
              </div>
              <div class="col-lg-6">
                <label>
                <input type="radio" id="txtmedicalminor" name="medicaltermindexing" value="2">
                <span class="label-text text-info">Minor</span></label>
              </div>
            </div>
          </div>
		  <div class="col-md-3">
		  <div class="badge badge-info mr-2" style="margin-bottom:10px">Candidate Term</div><br />
            <div class="form-group">
              <div class="col-lg-4">
                <label>
                <input type="radio" id="txtmedicalcandidatemajor" name="medicaltermindexing" value="3">
                <span class="label-text text-info">Major </span></label>
              </div>
              <div class="col-lg-6">
                <label>
                <input type="radio" id="txtmedicalcandidateminor" name="medicaltermindexing" value="4">
                <span class="label-text text-info">Minor</span></label>
              </div>
            </div>
          </div>
		  <div class="col-md-3">
		  <div class="badge badge-info mr-2" style="margin-bottom:10px">Disease Term</div><br />
            <div class="form-group">
              <div class="col-lg-4">
                <label>
                <input type="radio" id="txtmedicalcandidatemajordisease" name="medicaltermindexing" value="5">
                <span class="label-text text-info">Major</span></label>
              </div>
              <div class="col-lg-4">
                <label>
                <input type="radio" id="txtmedicalcandidateminordisease" name="medicaltermindexing" value="6">
                <span class="label-text text-info">Minor</span></label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm">
            <div class="frmSearch">
              <input type="hidden" id="txtmedicaltermtype" class="form-control"  name="txtmedicaltermtype"  autocomplete="off">
              <input type="text" id="txtmedicalterm" class="form-control"  name="txtmedicalterm" disabled="disabled" autocomplete="off">
              <div id="suggesstion-box"></div>
            </div>
          </div>
          <div class="col-sm">
            <div class="col-lg-12 disabledbutton"  id="dieseasesenablelink">
              <select class="select2-option form-control diseaseslink"  id="indexer_diseaseslink" name="indexer_diseaseslink[]" multiple>
				<?php $__currentLoopData = $diseaseslink; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diseases): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($diseases->name); ?>"><?php echo e($diseases->name); ?></option>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
          </div>
          <div class="col-sm"><?php echo renderAjaxButtonSquare('save'); ?>  </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="col-lg-5 control-label"><?php echo trans('app.'.'mmtct'); ?> </label>
            <div class="col-lg-2">
              <label class="switch">
              <input type="hidden" value="FALSE" name="hide_mmtct"/>
              <input type="checkbox" id="hide_mmtct" name="hide_mmtct" value="TRUE" />
              <span></span> </label>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="col-lg-6 panel panel-warning disabledbutton"  id="disablepanel">
              <div class="slim-scroll" data-height="300" style="height:300px;">
                <?php
					foreach ($mmt_ct_list as $key => $values){
						 echo '<div class="checkbox"><label><span class="label-text btn btn-info btn-xs">'.$key.'</span></label></div>';
						 foreach ($values as $value) 
						 {
							 echo '<div class="checkbox" onclick="showchecktagdesc(\'checktags'.$value->id.'\')"><input type="hidden" value="'.$value->description.'" id="checktags'.$value->id.'"/> <label class="pad40"><input type="hidden" value="'.$value->name.'" /><input type="checkbox" class="mmtctselectdata" name="medicalchecktags[]" value="'.$value->name.'"><span class="label-text">'.$value->name.'</span></label></div>';
						 }
					 }
				?>
              </div>
            </div>
            <div class="col-lg-6" id="chktagdesc"></div>
          </div>
        </div>
        
      </div>
    </section>
    <section class="panel panel-default">
    <div class="row">
      <div class="col-lg-12">
        <div class="panel-body card">
		<div class="form-group">
          <div class="sortable">
            <div class="medical-list" id="nestable"> <?php echo app('arrilot.widget')->run('Indexing\ShowMedicals', ['user_id' => \Auth::id(), 'pui' => $jobdata->pui, 'jobid' => $jobdata->id, 'orderid' => $jobdata->orderid]); ?> </div>
          </div>
        </div>
      </div>
    </div>
	</div>
</section>

    <?php echo Form::close(); ?> </div>
  <?php if(count($translations) > 0): ?> </div>
<?php endif; ?>
</div>
</div>
</div>
<?php $__env->startPush('pagestyle'); ?>
<style>
.frmSearch {border: 1px solid #a8d4b1;margin: 2px 0px;border-radius:4px;}
#termList{float:left;list-style:none;width:94%;padding:0; position: absolute; z-index:1;}
#termList li{padding: 5px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}
#termList li:hover{background:#ece3d2;cursor: pointer;}
#search-box{padding: 5px;border: #a8d4b1 1px solid;border-radius:4px;}
</style>
<link rel=stylesheet href="<?php echo e(getAsset('plugins/nestable/nestable.css')); ?>">
<?php echo $__env->make('stacks.css.form', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('pagescript'); ?>
<?php echo $__env->make('stacks.js.form', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<script>
$("#disablepanel").addClass("disabledbutton");
$(function () {
        $("input[name='medicaltermindexing']").click(function () {
            if ($("#txtmedicalmajor").is(":checked")) {
				$('#txtmedicalterm').val('');
                $("#txtmedicalterm").removeAttr("disabled");
				$('#txtmedicalterm').prop("disabled", false);
                $('#txtmedicalterm').attr('placeholder', "<?php echo trans('app.'.'mmt'); ?>");
				$('#suggesstion-box').show();
				$('#dieseasesenablelink').addClass("disabledbutton");
				callautosuggestion('show');				
				$("#txtmedicalterm").focus();
            } else if ($("#txtmedicalminor").is(":checked")) {
				
				$('#txtmedicalterm').val('');
                $('#txtmedicalterm').attr('placeholder', "<?php echo trans('app.'.'mmit'); ?>");	
				$('#txtmedicalterm').prop("disabled", false);
				$("#txtmedicalterm").removeAttr("disabled");
				$('#dieseasesenablelink').addClass("disabledbutton");
				$('#suggesstion-box').show();
				callautosuggestion('show');		
				$("#txtmedicalterm").focus();	
           } else if ($("#txtmedicalcandidatemajor").is(":checked")) {
		   		$('#txtmedicalterm').off('keyup');
		   		$('#suggesstion-box').hide();
		   		$('#txtmedicalterm').val('');
                $('#txtmedicalterm').attr('placeholder', "Major Candidate Term");	
				$('#txtmedicalterm').prop("disabled", false);
				$("#txtmedicalterm").removeAttr("disabled");
				$('#dieseasesenablelink').addClass("disabledbutton");
				callautosuggestion('hide');
				$('#suggesstion-box').hide();
				$("#txtmedicalterm").focus();	
            } else if ($("#txtmedicalcandidateminor").is(":checked")) {
				$('#txtmedicalterm').off('keyup');
				$('#suggesstion-box').hide();
				$('#txtmedicalterm').val('');
                $('#txtmedicalterm').attr('placeholder', "Minor Candidate Term");	
				$('#txtmedicalterm').prop("disabled", false);
				$("#txtmedicalterm").removeAttr("disabled");
				
				callautosuggestion('hide');
				$('#suggesstion-box').hide();
				$("#txtmedicalterm").focus();	
           } else if ($("#txtmedicalcandidatemajordisease").is(":checked")) {
		   		$('#txtmedicalterm').off('keyup');
				$("#dieseasesenablelink").removeClass("disabledbutton");
		   		$('#suggesstion-box').hide();		  
		   		$('#txtmedicalterm').val('');
                $('#txtmedicalterm').attr('placeholder', "Major Candidate Term");	
				$('#txtmedicalterm').prop("disabled", false);
				$("#txtmedicalterm").removeAttr("disabled");
				callautosuggestion('hide');
				$('#suggesstion-box').hide();
				$("#txtmedicalterm").focus();	
            } else if ($("#txtmedicalcandidateminordisease").is(":checked")) {
				$('#txtmedicalterm').off('keyup');
				$("#dieseasesenablelink").removeClass("disabledbutton");
				$('#suggesstion-box').hide();
				$('#txtmedicalterm').val('');
                $('#txtmedicalterm').attr('placeholder', "Minor Candidate Term");	
				$('#txtmedicalterm').prop("disabled", false);
				$("#txtmedicalterm").removeAttr("disabled");
				callautosuggestion('hide');
				$("#txtmedicalterm").focus();	
            }
        });
    });
	
	$('#hide_mmtct').click(function(){
		if($(this).prop("checked") == true){
			$("#disablepanel").removeClass("disabledbutton");
			
		} else if($(this).prop("checked") == false){
			$("#disablepanel").addClass("disabledbutton");
		}
	});
	
	function showchecktagdesc(selectedcheckboxval){
		var innerdata = '<div data-collapsed="0" class="panel panel-primary"><div class="panel-heading"> <div class="panel-title">Reference Information!!</div> </div> <div class="panel-body"> <p>'+document.getElementById(selectedcheckboxval).value+'</p> </div> </div> </div>';
		$('#chktagdesc').html(innerdata);
	}
	
	
$(document).ready(function(){  
var maxselect = 8; 
$("#indexer_diseaseslink").select2({
        placeholder: "Diseases Links",
		maximumSelectionLength: maxselect
    });
});  
function selectedTerms(name,term){
	$("#txtmedicalterm").val(name);
	$("#txtmedicaltermtype").val(term);
	$("#suggesstion-box").hide();
	if(term != 'DIS'){
		$('#dieseasesenablelink').addClass("disabledbutton");
	} else {
	 	$("#dieseasesenablelink").removeClass("disabledbutton");
	} 
}

function callautosuggestion(data){
if(data == 'show'){
	$('#txtmedicalterm').keyup(function(){  
	   var keyvalue = $(this).val();  
	   if(keyvalue !='') {
			axios.post('<?php echo e(get_option('site_url')); ?>api/v1/indexing/ajax/terms', {
				searchterm: keyvalue,
				searchtype: 'medical',
				suggestion: data,
			})
			.then(function (response) {
				$('#suggesstion-box').fadeIn();  
				$('#suggesstion-box').html(response.data); 
				<!--toastr.success(response.data.message, '<?php echo trans('app.'.'success'); ?> ');-->
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
	}); 
} else {
	$('#txtmedicalterm').keyup(function(){ 
		$('#suggesstion-box').fadeIn();  
		$('#suggesstion-box').html(''); 
	});
}

}

</script>
<?php $__env->stopPush(); ?>