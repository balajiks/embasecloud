@php
$arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
shuffle($arrbgdata); 
@endphp
<li class="list-group-item card" id="sectiondata-{{ $secdata[0]->id }}">
  <div class="todo-indicator bg-{{ $arrbgdata[0] }}"></div>
  <div class="widget-content p-0">
    <div class="widget-content-wrapper">
      <div class="widget-content-left mr-2">
        <div class="custom-checkbox custom-control">
          <input type="checkbox" class="custom-control-input" id="CustomSectionCheckbox{{ $secdata[0]->id }}" value="{{ $secdata[0]->id }}">
          <label for="CustomSectionCheckbox{{ $secdata[0]->id }}" class="custom-control-label">&nbsp;</label>
        </div>
      </div>
      <div class="widget-content-left flex2 text-dark sectionajax" data-id="{{ $secdata[0]->id }}" id="section-{{ $secdata[0]->id }}">
        <div class="widget-heading text-dark">Section : {{ $secdata[0]->sectionval }}</div>
        <div class="widget-subheading text-dark">Publication Choice: {{ $secdata[0]->pubchoice }}</div>
      </div>
      <div class="widget-content-right widget-content-actions">
        <div class="border-0 btn-transition btn"> <a href="#" class="editSection" data-section-id="{{$secdata[0]->id}}" title="@langapp('edit')"><i class="fa fa-edit text-primary"></i> </a> </div>
        <div class="border-0 btn-transition btn"> @if ($secdata[0]->user_id === Auth::id()) <a href="#" class="deleteSection" data-section-id="{{$secdata[0]->id}}" title="@langapp('delete')"><i class="fa fa-trash-alt text-danger"></i> </a> @endif </div>
      </div>
    </div>
  </div>
</li>
