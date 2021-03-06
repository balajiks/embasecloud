<div class="col-lg-12">
	<section class="panel panel-default">
		<form id="frm-indexing" action="{{ route('indexing.bulk.email') }}" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="module" value="indexing">
			<div class="table-responsive">
				<table class="table table-striped" id="indexing-table">
					<thead>
						<tr>
							<th class="hide"></th>
							<th class="no-sort">
								<label>
									<input name="select_all" value="1" id="select-all" type="checkbox" />
									<span class="label-text"></span>
								</label>
							</th>
							<th class="">@langapp('name') </th>
							<th class="">@langapp('company_name') </th>
							<th class="">@langapp('stage')</th>
							<th class="col-currency">@langapp('indexing_value')</th>
							<th class="">@langapp('sales_rep')</th>
							<th class="">@langapp('email') </th>
						</tr>
					</thead>
				</table>
			</div>
			@can('indexing_create')
			<button type="submit" id="button" class="btn btn-sm btn-{{ get_option('theme_color') }} m-xs" value="bulk-email">
			<span class="">@icon('solid/mail-bulk') @langapp('send_email')</span>
			</button>
			@endcan
			@can('indexing_update')
			<button type="submit" id="button" class="btn btn-sm btn-{{ get_option('theme_color') }} m-xs" value="bulk-archive">
			<span class="">@icon('solid/archive') @langapp('archive')</span>
			</button>
			@endcan

			@can('indexing_delete')
			<button type="submit" id="button" class="btn btn-sm btn-{{ get_option('theme_color') }} m-xs" value="bulk-delete">
			<span class="">@icon('solid/trash-alt') @langapp('delete')</span>
			</button>
			@endcan

		</form>
	</section>
</div>
@push('pagestyle')
@include('stacks.css.datatables')
@endpush
@push('pagescript')
@include('stacks.js.datatables')
<script>
	$(function() {
	$('#indexing-table').DataTable({
	processing: true,
	serverSide: true,
	ajax: {
		url: '{{ route('indexing.data') }}',
		type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	},
		data: {
			"filter": '{{ $filter }}',
		}
	},
	order: [[ 0, "desc" ]],
	columns: [
	{ data: 'id', name: 'id' },
	{ data: 'chk', name: 'chk', searchable: false },
	{ data: 'name', name: 'name' },
	{ data: 'company', name: 'company' },
	{ data: 'stage', name: 'status.name' },
	{ data: 'indexing_value', name: 'indexing_value' },
	{ data: 'sales_rep', name: 'agent.name' },
	{ data: 'email', name: 'email' }
	]
	});
	$("#frm-indexing button").click(function(ev){
	ev.preventDefault();
if($(this).attr("value")=="bulk-email"){
	var form = $("#frm-indexing").serialize();
	$("#frm-indexing").submit();
}

if($(this).attr("value")=="bulk-archive"){
    var form = $("#frm-indexing").serialize();
    axios.post('{{ route('archive.process') }}', form)
    .then(function (response) {
    toastr.warning(response.data.message, '@langapp('response_status') ');
    window.location.href = response.data.redirect;
    })
    .catch(function (error) {
    	showErrors(error);
    });
}

if($(this).attr("value")=="bulk-delete"){
    var form = $("#frm-indexing").serialize();
    axios.post('{{ route('indexing.bulk.delete') }}', form)
    .then(function (response) {
    toastr.warning(response.data.message, '@langapp('response_status') ');
    window.location.href = response.data.redirect;
    })
    .catch(function (error) {
    	showErrors(error);
    });
    }
});

	function showErrors(error){
	    var errors = error.response.data.errors;
	    var errorsHtml= '';
	    $.each( errors, function( key, value ) {
	    errorsHtml += '<li>' + value[0] + '</li>';
	    });
	    toastr.error( errorsHtml , '@langapp('response_status') ');
	}
	
});
</script>
@endpush