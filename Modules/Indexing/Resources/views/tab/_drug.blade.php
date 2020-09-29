<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default"> @php 
      $translations = Modules\Settings\Entities\Options::translations();
      $default_country = get_option('company_country');
      $disable = '';
      @endphp
      <div class="panel-body card">
        <div class="col-md-121">
          <header class="panel-heading" style="padding:10px 0px !important;">
            <header class="btn btn-default btn-sm"> @icon('solid/exclamation-circle') @langapp('drugalertinfo') &nbsp;&nbsp;[ <span class="badge badge-warning mr-2">@langapp('drugindexing') </span> ]</header>
          </header>
          {!! Form::open(['route' => 'indexing.api.savedrug', 'id' => 'createDrug', 'class' => 'bs-example form-horizontal m-b-none']) !!}
          <div class="col-md-121">
            <input type="hidden" class="form-control" placeholder="jobid" name="jobid" id="jobid" value="{{$jobdata->id}}" />
            <input type="hidden" class="form-control" placeholder="pui" name="pui" id="pui" value="{{$jobdata->pui}}" />
            <input type="hidden" class="form-control" placeholder="orderid" name="orderid" id="orderid" value="{{$jobdata->orderid}}" />
            <input type="hidden" name="json" value="false"/>
            <input type="hidden" class="form-control" placeholder="drugid" id="drugid" name="drugid" value="0" />
            <div class="row">
              <div class="col-md-3">
                <div class="badge badge-info mr-2" style="margin-bottom:10px">Drug Term</div>
                <br />
                <div class="form-group">
                  <div class="col-lg-4">
                    <label>
                    <input type="radio" id="txtdrugmajor" name="drugtermindexing" value="1">
                    <span class="label-text text-info">Major</span></label>
                  </div>
                  <div class="col-lg-6">
                    <label>
                    <input type="radio" id="txtdrugminor" name="drugtermindexing" value="2">
                    <span class="label-text text-info">Minor</span></label>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="badge badge-info mr-2" style="margin-bottom:10px">Candidate Term</div>
                <br />
                <div class="form-group">
                  <div class="col-lg-4">
                    <label>
                    <input type="radio" id="txtdrugcandidatemajor" name="drugtermindexing" value="3">
                    <span class="label-text text-info">Major </span></label>
                  </div>
                  <div class="col-lg-6">
                    <label>
                    <input type="radio" id="txtdrugcandidateminor" name="drugtermindexing" value="4">
                    <span class="label-text text-info">Minor</span></label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-8">
                <div class="frmSearch">
                  <input type="hidden" id="txtdrugtermtype" class="form-control"  name="txtdrugtermtype"  autocomplete="off">
                  <input type="text" id="txtdrugterm" class="form-control" placeholder="@langapp('drugterm')" name="txtdrugterm" disabled="disabled" autocomplete="off">
                  <div id="suggesstion-box"></div>
                </div>
              </div>
              <div class="col-lg-4"> {!!  renderAjaxButtonSquare('save')  !!} </div>
            </div>
          </div>
          {!! Form::close() !!} </div>
      </div>
    </section>
    <div class="panel-body card">
      <div class="col-md-121">
        <div class="row">
          <div class="col-md-5">
            <div class="sortable">
              <div class="drug-list" id="nestable"> @widget('Indexing\ShowDrugterms', ['user_id' => \Auth::id(), 'pui' => $jobdata->pui, 'jobid' => $jobdata->id, 'orderid' => $jobdata->orderid]) </div>
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
                      <li role="presentation" class="othermenu"><a href="{{route('indexing.api.frmdrugotherfield')}}" id="tab1" class="tabmenu">Other Fields</a></li>
                      <li role="presentation" class="drugmenu"><a href="{{route('indexing.api.frmdrugtherapy')}}" id="tab2" class="tabmenu">@langapp('drugtherapy')</a></li>
                      <li role="presentation" class="drugmenu" style="display:none;"><a href="{{route('indexing.api.frmdrugdoseinfo')}}" id="tab3" class="tabmenu">@langapp('drugdoseinfo')</a></li>
                      <li role="presentation" class="drugmenu"><a href="{{route('indexing.api.frmrouteofdrug')}}" id="tab4" class="tabmenu">@langapp('routeofdrug')</a></li>
                      <li role="presentation" class="drugmenu"><a href="{{route('indexing.api.frmdosefrequency')}}" id="tab5" class="tabmenu">@langapp('dosefrequency')</a></li>
                      <li role="presentation" class="drugmenu"><a href="{{route('indexing.api.frmdrugcombination')}}" id="tab6" class="tabmenu">@langapp('drugcombination')</a></li>
                      <li role="presentation" class="drugmenu"><a href="{{route('indexing.api.frmadversedrug')}}" id="tab7" class="tabmenu">@langapp('adversedrug')</a></li>
                      <li role="presentation" class="drugmenu"><a href="{{route('indexing.api.frmdrugcomparison')}}" id="tab8" class="tabmenu">@langapp('drugcomparison')</a></li>
                      <li role="presentation" class="drugmenu"><a href="{{route('indexing.api.frmdrugdosage')}}" id="tab9" class="tabmenu">@langapp('drugdosage')</a></li>
                      <li role="presentation" class="drugmenu"><a href="{{route('indexing.api.frmdruginteraction')}}" id="tab10" class="tabmenu">@langapp('druginteraction')</a></li>
                      <li role="presentation" class="drugmenu"><a href="{{route('indexing.api.frmdrugpharma')}}" id="tab11" class="tabmenu">@langapp('drugpharma')</a></li>
                    </ul>
                  </div>
                  <div class="col-md-8">
                    <!-- Tab panes -->
                    {!! Form::open(['route' => 'indexing.api.savedruglinks', 'id' => 'createDrugLinks', 'class' => 'bs-example form-horizontal m-b-none']) !!}
                    <input type="hidden" class="form-control" placeholder="jobid" name="jobid" id="jobid" value="{{$jobdata->id}}" />
                    <input type="hidden" class="form-control" placeholder="pui" name="pui" id="pui" value="{{$jobdata->pui}}" />
                    <input type="hidden" class="form-control" placeholder="orderid" name="orderid" id="orderid" value="{{$jobdata->orderid}}" />
                    <input type="radio" id="txtdrugmajorselected"  value="1" readonly="readonly">
                    <input type="radio" id="txtdrugminorselected"  value="0" readonly="readonly">
                    <input type="hidden" id="drugindexterm" name="drugindexterm"  value="" readonly="readonly">
                    <input type="hidden" id="drugindextermtype" name="drugindextermtype"  value="" readonly="readonly">
                    <input type="hidden" name="selecteddrugid" id="selecteddrugid" value=""/>
                    <div id="preloader"><i class="fas fa-spin fa-spinner"></i> Loading...</div>
                    <div id="tabcontent"> </div>
                    {!! Form::close() !!} </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@push('pagestyle')
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
<link rel=stylesheet href="{{ getAsset('plugins/nestable/nestable.css') }}">
@include('stacks.css.form')
@endpush
@push('pagescript')
@include('stacks.js.form')
<script>

function loadTabContent(tabUrl){
	$("#preloader").show();
	axios.post(tabUrl, {
		drugterm	:	$("#drugindexterm").val(),
		drugtermtype:	$("#drugindextermtype").val(),
		drugid		:	$("#selecteddrugid").val(),
		jobid		:	'{{ $jobdata->id }}',
		orderid		:	'{{ $jobdata->orderid }}',
		pui			:	'{{ $jobdata->pui }}',
		
	})
	.then(function (response) {
		<!--toastr.success(response.data.message, '@langapp('success') ');-->
		jQuery("#tabcontent").empty().append(response.data.htmldrugterm);
		$("#preloader").hide();
	})
	.catch(function (error) {
		var errors = error.response.data.errors;
		var errorsHtml= '';
		$.each( errors, function( key, value ) {
			errorsHtml += '<li>' + value[0] + '</li>';
		});
		toastr.error( errorsHtml , '@langapp('response_status') ');
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
	$("input[name='drugtermindexing']").click(function () {
		if ($("#txtdrugmajor").is(":checked")) {
			$('#txtdrugterm').val('');
			$("#txtdrugterm").removeAttr("disabled");
			$('#txtdrugterm').prop("disabled", false);
			$('#txtdrugterm').attr('placeholder', "@langapp('mmt')");
			$('#suggesstion-box').show();
			
			callautosuggestion('show');				
			$("#txtdrugterm").focus();
		} else if ($("#txtdrugminor").is(":checked")) {			
			$('#txtdrugterm').val('');
			$('#txtdrugterm').attr('placeholder', "@langapp('mmit')");	
			$('#txtdrugterm').prop("disabled", false);
			$("#txtdrugterm").removeAttr("disabled");			
			$('#suggesstion-box').show();
			callautosuggestion('show');		
			$("#txtdrugterm").focus();	
	   } else if ($("#txtdrugcandidatemajor").is(":checked")) {
			$('#txtdrugterm').off('keyup');
			$('#suggesstion-box').hide();
			$('#txtdrugterm').val('');
			$('#txtdrugterm').attr('placeholder', "Major Candidate Term");	
			$('#txtdrugterm').prop("disabled", false);
			$("#txtdrugterm").removeAttr("disabled");
			
			callautosuggestion('hide');
			$('#suggesstion-box').hide();
			$("#txtdrugterm").focus();	
		} else if ($("#txtdrugcandidateminor").is(":checked")) {
			$('#txtdrugterm').off('keyup');
			$('#suggesstion-box').hide();
			$('#txtdrugterm').val('');
			$('#txtdrugterm').attr('placeholder', "Minor Candidate Term");	
			$('#txtdrugterm').prop("disabled", false);
			$("#txtdrugterm").removeAttr("disabled");			
			callautosuggestion('hide');
			$('#suggesstion-box').hide();
			$("#txtdrugterm").focus();	
	   }
	});
});








function selectedTerms(name,term){
	$("#txtdrugterm").val(name);
	$("#txtdrugtermtype").val(term);
	$("#suggesstion-box").hide();
}


function callautosuggestion(data){
	if(data == 'show'){
			$('#txtdrugterm').keyup(function(){  
			   var keyvalue = $(this).val();  
			   if(keyvalue !='') {
					axios.post('{{ get_option('site_url') }}api/v1/indexing/ajax/termdrug', {
						searchterm: keyvalue,
						searchtype: 'drug',
						suggestion: data,
					})
					.then(function (response) {
						$('#suggesstion-box').fadeIn();  
						$('#suggesstion-box').html(response.data); 
						<!--toastr.success(response.data.message, '@langapp('success') ');-->
					})
					.catch(function (error) {
						var errors = error.response.data.errors;
						var errorsHtml= '';
						$.each( errors, function( key, value ) {
							errorsHtml += '<li>' + value[0] + '</li>';
						});
						toastr.error( errorsHtml , '@langapp('response_status') ');
					});
				}
			}); 
	} else {	
		$('#txtdrugterm').keyup(function(){ 
			$('#suggesstion-box').fadeIn();  
			$('#suggesstion-box').html(''); 
		});
	}
}


<?php /*?>
	
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

function selectedotherfield(selectval){
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
	
	$( ".card" ).removeClass( "active" );
	alert($(this).attr("data-id"));
	alert(id);
	$( "#drug-"+id ).parents().addClass( "active" );
	
}



</script>
@endpush