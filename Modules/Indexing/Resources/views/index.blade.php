@extends('layouts.indexerapp')
@section('content')
<input type="hidden" class="form-control" placeholder="jobid" id="project_jobid" name="jobid" value="{{$jobdata->id}}" />
<input type="hidden" class="form-control" placeholder="pui" id="project_pui" name="pui" value="{{$jobdata->pui}}" />
<input type="hidden" class="form-control" placeholder="orderid" id="project_orderid" name="orderid" value="{{$jobdata->orderid}}" />
<aside class="b-l bg" id="">
  <div class="panel-group m-b" id="accordion2">
    <ul class="list no-style" id="responses-list">
      <li class="panel panel-default" id="tokenize">
        <div class="panel-heading">@icon('solid/cogs') @langapp('sectiondetails')  <span class="badge badge-secondary mr-2">JobID: {{ $jobdata->id }}</span> &nbsp;&nbsp; <span class="badge badge-secondary mr-2">PUI: {{ str_replace('_pui ','',$jobdata->pui) }}</span>
          <div style="float:right; margin-top:-5px;"> <a href="{{  route('indexing.ajaxapivalidation', ['id' => $jobdata->id])  }}" class="btn btn-sm btn-{{ get_option('theme_color')  }} pull-right" data-toggle="ajaxModal"> @icon('solid/vote-yea') @langapp('ajaxapivalidationapi') </a> <a href="{{  route('indexing.showmeta', ['id' => $jobdata->id])  }}" class="btn btn-sm btn-default pull-right" data-toggle="ajaxModal"> @icon('solid/newspaper') @langapp('openindexmanual') </a> <a href="{{  route('indexing.showemtree', ['id' => $jobdata->id])  }}" target="_blank" class="btn btn-sm btn-default pull-right"> @icon('solid/vials') @langapp('openemtree') </a> <a href="{{  route('indexing.showsource', ['id' => $jobdata->id])  }}" target="_blank" class="btn btn-sm btn-default pull-right"> @icon('solid/plus-square') @langapp('opensource') </a> <a href="{{  route('indexing.showmeta', ['id' => $jobdata->id])  }}" class="btn btn-sm btn-default pull-right" data-toggle="ajaxModal"> @icon('solid/file-signature') @langapp('metadata') </a> </div>
        </div>
      </li>
    </ul>
  </div>
  <ul class="dashmenu text-uc text-muted no-border no-radius nav pro-nav-tabs nav-tabs-dashed">
    <li class="{{  ($tab == 'section') ? 'active' : '' }}"> <a href="{{  route('indexing.addindexing', ['id' => $jobdata->id, 'tabmenu' => 'section', 'tab' => 'section'])  }}"> <img src="{{getAsset('images/section.svg')}}" > @langapp('section') </a> </li>
    <li class="{{  ($tab == 'medical') ? 'active' : '' }}"> <a href="{{  route('indexing.addindexing', ['id' => $jobdata->id, 'tab' => 'medical'])  }}"><img src="{{getAsset('images/medical.svg')}}" > @langapp('medical') </a> </li>
    <li class="{{  ($tab == 'drug') ? 'active' : '' }}"> <a href="{{  route('indexing.addindexing', ['id' => $jobdata->id, 'tab' => 'drug'])  }}"><img src="{{getAsset('images/drug.svg')}}" > @langapp('drug') </a> </li>
    <li class="{{  ($tab == 'drugtradename') ? 'active' : '' }}"> <a href="{{  route('indexing.addindexing', ['id' => $jobdata->id, 'tab' => 'drugtradename'])  }}"><img src="{{getAsset('images/drugtrade.svg')}}" > @langapp('drugtradename') </a> </li>
    <li class="{{  ($tab == 'mdt') ? 'active' : '' }}"> <a href="{{  route('indexing.addindexing', ['id' => $jobdata->id, 'tab' => 'mdt'])  }}"><img src="{{getAsset('images/mdt.svg')}}" > @langapp('mdt') </a> </li>
    <li class="{{  ($tab == 'ctn') ? 'active' : '' }}"> <a href="{{  route('indexing.addindexing', ['id' => $jobdata->id, 'tab' => 'ctn'])  }}"><img src="{{getAsset('images/ctn.svg')}}" > @langapp('ctn') </a> </li>
    <li class="{{  ($tab == 'msn') ? 'active' : '' }}"> <a href="{{  route('indexing.addindexing', ['id' => $jobdata->id, 'tab' => 'msn'])  }}"><img src="{{getAsset('images/msn.svg')}}" > @langapp('msn') </a> </li>
    <li class="{{  ($tab == 'mdi') ? 'active' : '' }}"> <a href="{{  route('indexing.addindexing', ['id' => $jobdata->id, 'tab' => 'mdi'])  }}"><img src="{{getAsset('images/mdi.svg')}}" > @langapp('mdi') </a> </li>
  </ul>
  <section class="padder"> @include('indexing::tab._'.$tab) </section>
</aside>
<aside class="aside-lg b-l">
  <section class="vbox">
    <section class="scrollable" id="feeds">
      <div class="slim-scroll" data-color="#333333" data-disable-fade-out="true" data-distance="0" data-height="auto" data-size="3px"> @include('indexing::_sidebar.'.$tabmenu) </div>
    </section>
  </section>
</aside>
@push('pagescript')
@include('indexing::_ajax.sectionjs')
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
	children.prepend(element);
	$('#processing-modal').modal('toggle');
	}, 1000);
	}
	event.preventDefault();
	});
}
</script>
@endpush
@endsection