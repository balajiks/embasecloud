<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
      <div class="panel-body card">
        <header class="panel-heading" style="padding:10px 0px !important;">
          <header class="btn btn-default btn-sm"> @icon('solid/exclamation-circle') @langapp('mdiinfo')</header>
        </header>
        @php 
        $translations = Modules\Settings\Entities\Options::translations();
        $default_country = get_option('company_country');
        $disable = '';
        @endphp
        
        {!! Form::open(['route' => 'indexing.api.savemedicaldeviceindexing', 'id' => 'createMedicalIndexing', 'class' => 'bs-example form-horizontal m-b-none']) !!}
        <input type="hidden" class="form-control" placeholder="jobid" name="jobid" id="jobid" value="{{$jobdata->id}}" />
        <input type="hidden" class="form-control" placeholder="pui" name="pui" id="pui" value="{{$jobdata->pui}}" />
        <input type="hidden" class="form-control" placeholder="orderid" name="orderid" id="orderid" value="{{$jobdata->orderid}}" />
        <input type="hidden" name="json" value="false"/>
        <div class="col-md-12">
          <div class="form-group">
            <div class="col-lg-1">
              <label>
              <input type="radio" id="txtmedicalmajor" name="medicaltermindexing" value="1">
              <span class="label-text text-info">@langapp('major')</span></label>
            </div>
            <div class="col-lg-2">
              <label>
              <input type="radio" id="txtmedicalminor" name="medicaltermindexing" value="0">
              <span class="label-text text-info">@langapp('minor')</span></label>
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-6">
              <label>@langapp('drt')</label>
              <div class="frmSearch">
                <input type="hidden" id="txtdevicetermtype" class="form-control"  name="txtdevicetermtype"  autocomplete="off">
                <input type="text" id="txtdeviceterm" class="form-control" placeholder="@langapp('drt')" name="txtdeviceterm" disabled="disabled" autocomplete="off">
                <div id="suggesstion-box"></div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-6"  id="devicelink">
              <label>@langapp('devicelink')</label>
              <select class="select2-option form-control devicelink" id="indexer_devicelink" name="indexer_devicelink" disabled="disabled">
                <option selected="true" disabled="disabled">Select @langapp('devicelink')</option>
                <option value="Adverse device effect">Adverse device effect</option>
                <option value="Clinical trial">Clinical trial</option>
                <option value="Device Comparison">Device Comparison</option>
                <option value="Device economics">Device economics</option>
              </select>
            </div>
            <div class="col-lg-6">
              <label>@langapp('sublink')</label>
              <select class="select2-option form-control sublink" id="sublink" name="sublink[]" multiple="multiple" disabled="disabled">
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-4">{!!  renderAjaxButtonSquare('save')  !!}</div>
          </div>
        </div>
        {!! Form::close() !!} </div>
    </section>
	
		<div class="sortable">
		<div class="section-list" id="nestable"> @widget('Indexing\ShowMedicalsdevice', ['user_id' => \Auth::id(), 'jobid' => $jobdata->id, 'orderid' => $jobdata->orderid, 'pui' => $jobdata->pui]) </div>
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
</style>
<link rel=stylesheet href="{{ getAsset('plugins/nestable/nestable.css') }}">
@include('stacks.css.form')
@endpush
@push('pagescript')
@include('stacks.js.form')
<script>
$("#disablepanel").addClass("disabledbutton");
$(function () {
        $("input[name='medicaltermindexing']").click(function () {
            if ($("#txtmedicalmajor").is(":checked")) {
                $("#txtdeviceterm").removeAttr("disabled");
				$('#txtdeviceterm').prop("disabled", false);
                $('#txtdeviceterm').attr('placeholder', "@langapp('drt')");
				$('#indexer_devicelink').prop("disabled", false);
				$('#sublink').prop("disabled", false);
				$("#txtdeviceterm").focus();
				
            } else {
                $('#txtdeviceterm').attr('placeholder', "@langapp('drt')");	
				$('#txtdeviceterm').prop("disabled", false);
				$("#txtdeviceterm").removeAttr("disabled");
				$('#indexer_devicelink').prop("disabled", false);
				$('#sublink').prop("disabled", false);
				$("#txtdeviceterm").focus();	
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
	$('#txtdeviceterm').keyup(function(){  
           var keyvalue = $(this).val();  
		   if(keyvalue !='') {
				axios.post('{{ get_option('site_url') }}api/v1/indexing/ajax/termdevice', {
					searchterm: keyvalue
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
});  
function selectedTerms(name,term){
	$("#txtdeviceterm").val(name);
	$("#txtdevicetermtype").val(term);
	$("#suggesstion-box").hide();
}

$('#indexer_devicelink').on('change', function() {
alert('saddas');
  	var keyvalue = $(this).val(); 
	var jobid	 = $("#jobid").val();  
	var orderid	 = $("#orderid").val();
	var pui	 	 = $("#pui").val();
	if(keyvalue !='') {
		axios.post('{{ get_option('site_url') }}api/v1/indexing/ajax/sublink', {
			searchterm: keyvalue,
			jobid: jobid,
			orderid: orderid,
			pui: pui,
		})
		.then(function (response) {
			$('.sublink').fadeIn();  
			$('.sublink').html(response.data); 
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
</script>
@endpush