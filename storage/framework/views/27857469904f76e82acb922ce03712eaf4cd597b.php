<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default"> <?php 
      $translations = Modules\Settings\Entities\Options::translations();
      $default_country = get_option('company_country');
      $disable = '';
      ?>
      <div class="panel-body card">
        <div class="col-md-121">
          <header class="panel-heading" style="padding:10px 0px !important;">
            <header class="btn btn-default btn-sm"> <?php echo e(svg_image('solid/exclamation-circle')); ?> <?php echo trans('app.'.'drugalertinfo'); ?> &nbsp;&nbsp;[ <span class="badge badge-warning mr-2"><?php echo trans('app.'.'drugindexing'); ?> </span> ]</header>
          </header>
          <?php echo Form::open(['route' => 'indexing.api.savedrug', 'id' => 'createDrug', 'class' => 'bs-example form-horizontal m-b-none']); ?>

          <div class="col-md-121">
            <input type="hidden" class="form-control" placeholder="jobid" name="jobid" id="jobid" value="<?php echo e($jobdata->id); ?>" />
            <input type="hidden" class="form-control" placeholder="pui" name="pui" id="pui" value="<?php echo e($jobdata->pui); ?>" />
            <input type="hidden" class="form-control" placeholder="orderid" name="orderid" id="orderid" value="<?php echo e($jobdata->orderid); ?>" />
            <input type="hidden" name="json" value="false"/>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <div class="col-lg-6">
                    <label>
                    <input type="radio" id="txtdrugmajor" name="fcttermindexing" value="1">
                    <span class="label-text text-info"><?php echo trans('app.'.'dsa'); ?></span></label>
                  </div>
                  <div class="col-lg-6">
                    <label>
                    <input type="radio" id="txtdrugminor" name="fcttermindexing" value="0">
                    <span class="label-text text-info"><?php echo trans('app.'.'dsb'); ?></span></label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-8">
                <div class="frmSearch">
                  <input type="hidden" id="txtdrugtermtype" class="form-control"  name="txtdrugtermtype"  autocomplete="off">
                  <input type="text" id="txtdrugmedicalterm" class="form-control" placeholder="<?php echo trans('app.'.'drugterm'); ?>" name="txtdrugmedicalterm" disabled="disabled" autocomplete="off">
                  <div id="suggesstion-box"></div>
                </div>
              </div>
              <div class="col-lg-4"> <?php echo renderAjaxButtonSquare('save'); ?> </div>
            </div>
          </div>
          <?php echo Form::close(); ?> </div>
      </div>
    </section>
    <div class="panel-body card">
      <div class="col-md-121">
        <div class="row">
          <div class="col-md-5">
            <div class="sortable">
              <div class="drug-list" id="nestable"> <?php echo app('arrilot.widget')->run('Indexing\ShowDrugterms', ['user_id' => \Auth::id(), 'jobid' => $jobdata->id, 'orderid' => $jobdata->orderid]); ?> </div>
            </div>
          </div>
          <div class="col-md-7">
            <div  id="selecteddrunmsg"> </div>
            <section class="scrollable slim-scroll" data-height="415" style="height:415px;">
             <div class="row">
                   
                      <div class="vertical-tab disabledbutton" role="tabpanel" id="vertical-tab-menu">
					   <div class="col-md-4">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                          <li role="presentation" class="othermenu"><a href="<?php echo e(route('indexing.api.frmdrugotherfield')); ?>" id="tab1" class="tabmenu">Other Fields</a></li>
                          <li role="presentation" class="drugmenu"><a href="<?php echo e(route('indexing.api.frmdrugtherapy')); ?>" id="tab2" class="tabmenu"><?php echo trans('app.'.'drugtherapy'); ?></a></li>
                          <li role="presentation" class="drugmenu" style="display:none;"><a href="<?php echo e(route('indexing.api.frmdrugdoseinfo')); ?>" id="tab3" class="tabmenu"><?php echo trans('app.'.'drugdoseinfo'); ?></a></li>
                          <li role="presentation" class="drugmenu"><a href="<?php echo e(route('indexing.api.frmrouteofdrug')); ?>" id="tab4" class="tabmenu"><?php echo trans('app.'.'routeofdrug'); ?></a></li>
                          <li role="presentation" class="drugmenu"><a href="<?php echo e(route('indexing.api.frmdosefrequency')); ?>" id="tab5" class="tabmenu"><?php echo trans('app.'.'dosefrequency'); ?></a></li>
                          <li role="presentation" class="drugmenu"><a href="<?php echo e(route('indexing.api.frmdrugcombination')); ?>" id="tab6" class="tabmenu"><?php echo trans('app.'.'drugcombination'); ?></a></li>
                          <li role="presentation" class="drugmenu"><a href="<?php echo e(route('indexing.api.frmadversedrug')); ?>" id="tab7" class="tabmenu"><?php echo trans('app.'.'adversedrug'); ?></a></li>
                          <li role="presentation" class="drugmenu"><a href="<?php echo e(route('indexing.api.frmdrugcomparison')); ?>" id="tab8" class="tabmenu"><?php echo trans('app.'.'drugcomparison'); ?></a></li>
                          <li role="presentation" class="drugmenu"><a href="<?php echo e(route('indexing.api.frmdrugdosage')); ?>" id="tab9" class="tabmenu"><?php echo trans('app.'.'drugdosage'); ?></a></li>
                          <li role="presentation" class="drugmenu"><a href="<?php echo e(route('indexing.api.frmdruginteraction')); ?>" id="tab10" class="tabmenu"><?php echo trans('app.'.'druginteraction'); ?></a></li>
                          <li role="presentation" class="drugmenu"><a href="<?php echo e(route('indexing.api.frmdrugpharma')); ?>" id="tab11" class="tabmenu"><?php echo trans('app.'.'drugpharma'); ?></a></li>
                          
                        </ul>
						</div>
						 <div class="col-md-8">
                        <!-- Tab panes -->
                        <?php echo Form::open(['route' => 'indexing.api.savedruglinks', 'id' => 'createDrugLinks', 'class' => 'bs-example form-horizontal m-b-none']); ?>

                        <input type="hidden" class="form-control" placeholder="jobid" name="jobid" id="jobid" value="<?php echo e($jobdata->id); ?>" />
                        <input type="hidden" class="form-control" placeholder="pui" name="pui" id="pui" value="<?php echo e($jobdata->pui); ?>" />
                        <input type="hidden" class="form-control" placeholder="orderid" name="orderid" id="orderid" value="<?php echo e($jobdata->orderid); ?>" />
                        <input type="radio" id="txtdrugmajorselected"  value="1" readonly="readonly">
                        <input type="radio" id="txtdrugminorselected"  value="0" readonly="readonly">
                        <input type="hidden" id="drugindexterm" name="drugindexterm"  value="" readonly="readonly">
                        <input type="hidden" id="drugindextermtype" name="drugindextermtype"  value="" readonly="readonly">
                        <input type="hidden" name="selecteddrugid" id="selecteddrugid" value=""/>
                        <div id="preloader"><i class="fas fa-spin fa-spinner"></i> Loading...</div>
                        <div id="tabcontent"> </div>
                        <?php echo Form::close(); ?> 
						</div>
                    </div>
                  </div>
            </section>
          </div>
        </div>
      </div>
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
.activeli {  background:#c9cba3 !important;}
.active,.dd3-content { cursor:pointer;}
.color-box{margin:15px 0;padding-left:20px}
.space{margin-bottom:25px!important}
.shadow{background:#F7F8F9;padding:3px;margin:10px 0}
.info-tab{float:left;margin-left:-23px}

.info-tab{width:40px;height:40px;display:inline-block;position:relative;top:8px}
.info-tab::before,.info-tab::after{display:inline-block;color:#fff;line-height:normal;font-family:"icomoon";position:absolute}
.info-tab i::before,.info-tab i::after{content:"";display:inline-block;position:absolute;left:0;bottom:-15px;transform:rotateX(60deg)}
.info-tab i::before{width:20px;height:20px;box-shadow:inset 12px 0 13px rgba(0,0,0,0.5)}
.info-tab i::after{width:0;height:0;border:12px solid transparent;border-bottom-color:#fff;border-left-color:#fff;bottom:-18px}


.tip-icon{background:#92CD59}
.tip-box{color:#2e5014;background:#d5efc2}
.tip-box a{color:#439800}

.nav-tabs > li {
    margin-bottom: -6px !important;
}
.alert {
  border-radius: 0;
  -webkit-border-radius: 0;
  box-shadow: 0 1px 2px rgba(0,0,0,0.11);
  display: table;
  width: 100%;
  padding-left:60px !important;
}

.alert-white {
  background-image: linear-gradient(to bottom, #fff, #f9f9f9);
  border-top-color: #d8d8d8;
  border-bottom-color: #bdbdbd;
  border-left-color: #cacaca;
  border-right-color: #cacaca;
  color: #404040;
  padding-left: 61px;
  position: relative;
}

.alert-white.rounded {
  border-radius: 3px;
  -webkit-border-radius: 3px;
}

.alert-white.rounded .icon {
  border-radius: 3px 0 0 3px;
  -webkit-border-radius: 3px 0 0 3px;
}

.alert-white .icon {
  text-align: center;
  width: 45px;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  border: 1px solid #bdbdbd;
  padding-top: 15px;
}


.alert-white .icon:after {
  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -o-transform: rotate(45deg);
  transform: rotate(45deg);
  display: block;
  content: '';
  width: 10px;
  height: 10px;
  border: 1px solid #bdbdbd;
  position: absolute;
  border-left: 0;
  border-bottom: 0;
  top: 50%;
  right: -6px;
  margin-top: -3px;
  background: #fff;
}

.alert-white .icon i {
  font-size: 20px;
  color: #fff;
  left: 12px;
  margin-top: -10px;
  position: absolute;
  top: 50%;
}
/*============ colors ========*/
.alert-success {
  color: #3c763d;
  background-color: #dff0d8;
  border-color: #d6e9c6;
}

.alert-white.alert-success .icon, 
.alert-white.alert-success .icon:after {
  border-color: #54a754;
  background: #60c060;
}

.alert-info {
  background-color: #d9edf7;
  border-color: #98cce6;
  color: #3a87ad;
}

.alert-white.alert-info .icon, 
.alert-white.alert-info .icon:after {
  border-color: #3a8ace;
  background: #4d90fd;
}


.alert-white.alert-warning .icon, 
.alert-white.alert-warning .icon:after {
  border-color: #d68000;
  background: #fc9700;
}

.alert-warning {
  background-color: #fcf8e3;
  border-color: #f1daab;
  color: #c09853;
}

.alert-danger {
  background-color: #f2dede;
  border-color: #e0b1b8;
  color: #b94a48;
}

.alert-white.alert-danger .icon, 
.alert-white.alert-danger .icon:after {
  border-color: #ca452e;
  background: #da4932;
}



#preloader
{
	position: absolute;
	top: 5px;
	left: 25px;
	z-index: 100;
	padding: 5px;
	text-align: center;
	 background-color: #3869d4 !important;
    border-color: #3869d4 !important;
    color: #fff;
}
</style>
<link rel=stylesheet href="<?php echo e(getAsset('plugins/nestable/nestable.css')); ?>">
<?php echo $__env->make('stacks.css.form', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('pagescript'); ?>
<?php echo $__env->make('stacks.js.form', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<script>

function loadTabContent(tabUrl){
	$("#preloader").show();
	axios.post(tabUrl, {
		drugterm	:	$("#drugindexterm").val(),
		drugtermtype:	$("#drugindextermtype").val(),
		drugid		:	$("#selecteddrugid").val(),
		jobid		:	'<?php echo e($jobdata->id); ?>',
		orderid		:	'<?php echo e($jobdata->orderid); ?>',
		pui			:	'<?php echo e($jobdata->pui); ?>',
		
	})
	.then(function (response) {
		<!--toastr.success(response.data.message, '<?php echo trans('app.'.'success'); ?> ');-->
		jQuery("#tabcontent").empty().append(response.data.htmldrugterm);
		$("#preloader").hide();
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
			
jQuery(document).ready(function(){	
	$("#preloader").hide();			
	jQuery(".tabmenu").click(function(){	
		tabId = $(this).attr("id");										
		tabUrl = jQuery("#"+tabId).attr("href");
		jQuery("[id^=tab]").parent().removeClass("active");
		jQuery("#"+tabId).parent().addClass("active");
		loadTabContent(tabUrl);
		return false;
	});
});
			
			
			
			
$("#disablepanel").addClass("disabledbutton");
$(function () {
	$("input[name='fcttermindexing']").click(function () {
		if ($("#txtdrugmajor").is(":checked")) {
			$("#txtdrugmedicalterm").removeAttr("disabled");
			$("#txtdrugmedicalterm").focus();
		} else {
			$("#txtdrugmedicalterm").removeAttr("disabled");
			$("#txtdrugmedicalterm").focus();
		}
	});
});
function selectedTerms(name,term){
	$("#txtdrugmedicalterm").val(name);
	$("#txtdrugtermtype").val(term);
	$("#suggesstion-box").hide();
}



$(document).ready(function(){  
	$('#txtdrugmedicalterm').keyup(function(){  
           var keyvalue = $(this).val();  
		   if(keyvalue !='') {
				axios.post('<?php echo e(get_option('site_url')); ?>api/v1/indexing/ajax/termdrug', {
					searchterm: keyvalue
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
	
	$("input[name='freetextoption']").click(function () {
		if($(this).prop("checked") == true){
			$("#txtfreetextoption").removeAttr("disabled");
			$("#txtfreetextoption").focus();
		} else {
			$("#txtfreetextoption").attr("disabled", "disabled");
		}
	});

<?php /*?>function selectedotherfield(selectval){
alert(selectval);

	if(selectval == 'endogenouscompound'){
	alert('asdad');
		$('.otherfieldcls').removeAttr('checked');
		$(".otherfieldcls").addClass("disabledbutton");
	} else {
		$('.otherfieldcls').removeAttr('checked');
		$(".otherfieldcls").removeClass("disabledbutton");
	}
}<?php */?>

function selecteddrugdata(id,name,type){
	
	if(type == 'major'){
		$('#txtdrugmajorselected').prop('checked',true);
		$('#drugindexterm').val(name);
		$('#drugindextermtype').val(type);
		$('#selecteddrugid').val(id);
		$('#selecteddrunmsg').html('<div class="alert alert-info alert-white rounded" style="margin-bottom:5px;"><div class="icon"><i class="fa fa-info-circle"></i></div><strong>Selected Drug Index Term:-  '+name+' [ Major (_dsa)] </strong></div>');
	} else {
		$('#txtdrugminorselected').prop('checked',true);
		$('#drugindexterm').val(name);
		$('#drugindextermtype').val(type);
		$('#selecteddrugid').val(id);
		$('#selecteddrunmsg').html('<div class="alert alert-info alert-white rounded" style="margin-bottom:5px;"><div class="icon"><i class="fa fa-info-circle"></i></div><strong>Selected Drug Index Term:-  '+name+' [ Minor (_dsb) ] </strong></div>');
	}
	
	
	$("[id^=drugtermshighlight]").removeClass("activeli");
	$("#drugtermshighlight-"+id).addClass("activeli");
	$("#vertical-tab-menu").removeClass("disabledbutton");
	$("#tabcontent").empty().append();
	$("[id^=tab]").parent().removeClass("active");
	$(".checkbox").removeClass("disabledbutton");
	$(".drugmenu").removeClass("disabledbutton");
	
}



</script>
<?php $__env->stopPush(); ?>