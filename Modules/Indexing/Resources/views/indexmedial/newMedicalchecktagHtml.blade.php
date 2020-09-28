@if(!empty($data['checktagdata']))
@foreach ($data['checktagdata'] as $checktag )
@php
$arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
shuffle($arrbgdata); 
@endphp
<li class="list-group-item card" id="medicalchecktagdata-{{ $checktag->id }}">
  <div class="todo-indicator bg-<?php echo $arrbgdata[0];?>"></div>
  <div class="widget-content p-0">
    <div class="widget-content-wrapper">
      <div class="widget-content-left mr-2">
        <div class="custom-checkbox custom-control">
          <input type="checkbox" class="custom-control-input" id="CustomSectionCheckbox{{ $checktag->id }}" value="{{ $checktag->id }}">
          <label for="CustomSectionCheckbox{{ $checktag->id }}" class="custom-control-label">&nbsp;</label>
        </div>
      </div>
      <div class="widget-content-left flex2 text-dark" data-id="{{ $checktag->id }}" id="checktag-{{ $checktag->id }}">
        <div class="widget-heading text-dark">{{ $checktag->checktag }} </div>
      </div>
      
      <div class="widget-content-right widget-content-actions">       
        <div class="border-0 btn-transition btn"> @if ($checktag->user_id === Auth::id()) <a href="#" class="deletechecktag" data-checktag-id="{{$checktag->id}}" title="@langapp('delete')"><i class="fa fa-trash-alt text-danger"></i> </a> @endif </div>
      </div>
    </div>
  </div>
</li>

@endforeach   
@endif