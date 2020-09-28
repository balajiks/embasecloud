@php
$arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
shuffle($arrbgdata); 
@endphp

<li class="list-group-item card" data-id="{{ $secdata[0]->id }}" id="section-{{ $secdata[0]->id }}">
<div class="todo-indicator bg-{{$arrbgdata[0]}}"></div>
<div class="widget-content p-0">
  <div class="widget-content-wrapper">
	<div class="widget-content-left mr-2">
	  <div class="custom-checkbox custom-control">
		<div class="placeholdericon"></div>
	  </div>
	</div>
	<div class="widget-content-left flex2 text-dark">
	  <div class="widget-heading text-dark">Section : {{ $secdata[0]->sectionval }}</div>
	</div>
	<div class="widget-content-right">
	  <div class="badge badge-secondary mr-2">@icon('solid/calendar-alt') {{ !empty($secdata[0]->created_at) ?  dateElapsed($secdata[0]->created_at) : '' }}</div>
	</div>
	<div class="widget-content-right widget-content-actions">
	  <div class="border-0 btn-transition btn"> @if ($secdata[0]->user_id === Auth::id()) <a href="#" class="deleteSection" data-section-id="{{$secdata[0]->id}}" title="@langapp('delete')"><i class="fa fa-trash-alt text-danger"></i> </a> @endif </div>
	</div>
  </div>
</div>
</li>