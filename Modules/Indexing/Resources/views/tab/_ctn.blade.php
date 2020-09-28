<div class="row">
  <div class="col-lg-12"> {!! Form::open(['route' => 'indexing.api.savectn', 'id' => 'createCtn', 'class' => 'bs-example form-horizontal m-b-none']) !!}
    <section class="panel panel-default"> @php 
      $translations = Modules\Settings\Entities\Options::translations();
      $default_country = get_option('company_country');
      $disable = '';
      @endphp
      <input type="hidden" class="form-control" placeholder="jobid" name="jobid" id="jobid" value="{{$jobdata->id}}" />
      <input type="hidden" class="form-control" placeholder="pui" name="pui" id="pui" value="{{$jobdata->pui}}" />
      <input type="hidden" class="form-control" placeholder="orderid" name="orderid" id="orderid" value="{{$jobdata->orderid}}" />
      <input type="hidden" name="json" value="false"/>
      <div class="panel-body card">
        <header class="panel-heading" style="padding:10px 0px !important;">
          <header class="btn btn-default btn-sm"> @icon('solid/exclamation-circle') @langapp('ctnalertinfo')</header>
        </header>
        <div class="col-md-121">
          <div class="form-group">
            <div class="col-lg-4">
              <label>@langapp('registername')</label>
              <select class="select2-option form-control" id="registryname" name="registryname">
                <option selected="true" disabled="disabled">Select @langapp('registername')</option>
                 @foreach($registries as $register)
                <option value="{{ $register->name }}">{{ $register->name }}</option>
                 @endforeach
              </select>
            </div>
            <div class="col-lg-4">
              <label>@langapp('labelctn')</label>
              <input type="text" id="clinicaltrailnumber" class="form-control" placeholder="@langapp('labelctn')" name="clinicaltrailnumber"  autocomplete="off"/>
            </div>
            <div class="col-lg-4"><br />
              {!!  renderAjaxcustomButtonSquare('save')  !!} </div>
          </div>
        </div>
      </div>
    </section>
    {!! Form::close() !!}
    <div class="sortable">
          <div class="ctn-list" id="nestable"> @widget('Indexing\ShowCtn', ['indexingctn' => DB::table('ctn')->where('user_id', \Auth::id())->where('jobid', $jobdata->id)->where('orderid', $jobdata->orderid)->where('pui', $jobdata->pui)->get()]) </div>
        </div>
  </div>
</div>
@push('pagestyle')
@include('stacks.css.form')
@endpush
@push('pagescript')
@include('stacks.js.form')
<script>
$(".Selpublication").select2({
    placeholder: "Select a state",
    allowClear: true
});

function getClassification(val) {
	var selectedValues = $('#indexer_section').val();
	axios.post('{{ get_option('site_url') }}api/v1/indexing/ajax/classification', {
	id: selectedValues
	})
	.then(function (response) {
		$('.classification').html(response.data);
	toastr.success(response.data.message, '@langapp('success') ');
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
</script>
@endpush