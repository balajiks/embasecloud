<div class="row">
<div class="col-lg-12"> {!! Form::open(['route' => 'indexing.api.savesection', 'id' => 'createSection', 'class' => 'bs-example form-horizontal m-b-none']) !!}
  <section class="panel panel-default">
  @php 
  $translations = Modules\Settings\Entities\Options::translations();
  $default_country = get_option('company_country');
  $disable = '';
  @endphp
  <div class="panel-body card">
    <input type="hidden" class="form-control" placeholder="jobid" name="jobid" id="jobid" value="{{$jobdata->id}}" />
    <input type="hidden" class="form-control" placeholder="pui" name="pui" id="pui" value="{{$jobdata->pui}}" />
    <input type="hidden" class="form-control" placeholder="orderid" name="orderid" id="orderid" value="{{$jobdata->orderid}}" />
    <input type="hidden" class="form-control" placeholder="jobid" id="sectioncount" name="sectioncount" value="{{$sectioncount}}" />
    <input type="hidden" class="form-control" placeholder="pubchoicecount" id="pubchoicecount" name="pubchoicecount" value="{{$pubchoicecount}}" />
    <input type="hidden" class="form-control" placeholder="sectionid" id="sectionid" name="sectionid" value="0" />
    <input type="hidden" class="form-control" placeholder="updateclassification" id="updateclassification" name="updateclassification" value="0" />
    <input type="hidden" name="json" value="false"/>
    <div class="col-md-12">
      <header class="panel-heading" style="padding:10px 0px !important;">
        <header class="btn btn-default btn-sm"> @icon('solid/exclamation-circle') @langapp('sectionalertinfo')  &nbsp;&nbsp;[ PUBL: <span class="badge badge-warning mr-2">{{$jobdata->publ}} </span> | Abstract: <span class="badge badge-warning mr-2">{{$jobdata->abs}} </span> ]</header>
        <div class="btn btn-sm label-success pull-right" >Section Count : <span id="indexersectioncount">{{$sectioncount}}</span></div>
      </header>
      @if (count($translations) > 0)
      <div class="tab-content tab-content-fix">
        <div class="tab-pane fade in active" id="tab-english"> @endif
          <div id="frmindexsectionshow" class=""> @if ($jobdata->publ == 'Yes' && $jobdata->abs == 'Yes')
            <input type="hidden" class="form-control" placeholder="jobdatayestoall" name="jobdatayestoall" value="1" />
            <div class="form-group">
              <div class="col-lg-3">
                <label>@langapp('section')</label>
                <span class="text-dark label label-danger pull-right">@icon('solid/exclamation-circle') @langapp('totalsectionallowed')</span>
                <select class="select2-option form-control" id="indexer_section" name="indexer_section" onChange="getClassification(this.value);" required>
                  <option selected="true" disabled="disabled">Select Section</option>
					@foreach(embaseindex_section() as $sectionval)
                  <option value="{{ $sectionval['sectionvalue'] }}">{{ $sectionval['sectionvalue'] }}</option>
					@endforeach
                </select>
              </div>
              <div class="col-lg-3">
                <label>@langapp('publication') @required </label>
                <select class="select2-option form-control Selpublication" id="Selpublication" name="indexer_publication"  required>
                  <option selected="true" disabled="disabled">Select Publication Choice</option>
                  <option value="?">?</option>
                  <option value="+">+</option>
                </select>
              </div>
              <div class="col-lg-3">
                <label>@langapp('classification') @required </label>
                <select class="select2-option form-control classification" id="classification" name="indexer_classification[]" required multiple="multiple" data-maximum-selection-length="3">
                </select>
              </div>
              <div class="col-lg-3">
                <div class="form-group"><br />
                  {!!  renderAjaxcustomButtonSquare('save')  !!} </div>
              </div>
            </div>
            @else
            <input type="hidden" class="form-control" placeholder="jobdatayestoall" name="jobdatayestoall" value="0" />
            <div class="form-group">
              <div class="col-lg-5">
                <label>@langapp('section')@required </label>
                <span class="text-dark label label-danger pull-right">@icon('solid/exclamation-circle') @langapp('totalsectionallowed')</span>
                <select class="select2-option form-control indexer_section"  placeholder="jobdatayestoall" id="indexer_section" name="indexer_section[]" multiple="multiple" data-maximum-selection-length="s">
				 @foreach(embaseindex_section() as $sectionval)
                  <option value="{{ $sectionval['sectionvalue'] }}">{{ $sectionval['sectionvalue'] }}</option>
				 @endforeach 
                </select>
              </div>
              <div class="col-lg-3 disabledbutton" >
                <label>@langapp('publication')</label>
                <select class="form-control" disabled>
                  <option selected="true" disabled="disabled">Select Publication Choice</option>
                </select>
              </div>
              <div class="col-lg-2 disabledbutton">
                <label>@langapp('classification')</label>
                <select class="form-control" disabled>
                  <option selected="true" disabled="disabled">Classification</option>
                </select>
              </div>
              <div class="col-lg-2">
                <div class="form-group"><br />
                  {!!  renderAjaxcustomButtonSquare('add')  !!} </div>
              </div>
            </div>
            @endif
            @if (count($translations) > 0) </div>
        </div>
        @endif </div>
    </div>
    </section>
    {!! Form::close() !!} </div>
</div>
<div class="sortable">
  <div class="section-list" id="nestable"> @if ($jobdata->publ == 'Yes' && $jobdata->abs == 'Yes')
    @widget('Indexing\ShowSectionswithclassification', ['indexingsections' => DB::table('datasections')
    ->where('datasections.user_id', \Auth::id())->where('datasections.jobid', $jobdata->id)->where('datasections.orderid', $jobdata->orderid)->where('datasections.pui', $jobdata->pui)
    ->get()])
    @else 
    @widget('Indexing\ShowSections', ['indexingsections' => DB::table('datasections')
    ->where('datasections.user_id', \Auth::id())->where('datasections.jobid', $jobdata->id)->where('datasections.orderid', $jobdata->orderid)->where('datasections.pui', $jobdata->pui)
    ->get()])
    @endif </div>
</div>
@push('pagestyle')
<link rel=stylesheet href="{{ getAsset('plugins/nestable/nestable.css') }}">
@include('stacks.css.form')
@endpush
@push('pagescript')
@include('stacks.js.form')
@if ($sectioncount == langapp('sectioncnt'))
<script>$('#frmindexsectionshow').find('input, textarea, button, select').attr('disabled','disabled');</script>
@else
<script>$('#frmindexsectionshow').find('input, textarea, button, select').removeAttr('disabled','disabled');</script>
@endif
<script>
$("#preloader").hide();
$("#preloaderloading").hide();
$(document).ready(function () {
	var seccont = @langapp('sectioncnt') - $('#sectioncount').val();
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
		axios.post('{{ get_option('site_url') }}api/v1/indexing/ajax/classification', {
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
			toastr.error( errorsHtml , '@langapp('response_status') ');
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
			axios.post('{{ get_option("site_url") }}api/v1/indexing/sectiondeleteall', {
				id       :  sectionindex,
				jobid    : 	$('#jobid').val(),
				orderid  :  $('#orderid').val(),
				pui	     :  $('#pui').val(),
			})
			.then(function (response) {
				var maxselect = @langapp('sectioncnt') - response.data.count;
				$("#indexer_section").select2({
					maximumSelectionLength: maxselect
				});
				$("#sectioncount").val(response.data.count);
				$("#pubchoicecount").val(response.data.pubchoicecount);
				$("#indexersectioncount").html(response.data.count);
				toastr.success( response.data.message , '@langapp('response_status') ');
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
				toastr.error( 'Oops! Something went wrong!' , '@langapp('response_status') ');
			});
		} else {
			alert('Please select section data!!');
			return false;
		}
	});
});
</script>
@endpush