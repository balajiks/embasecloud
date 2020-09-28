@foreach ($data['medicaltermdata'] as $termsdata )
@php
$arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
shuffle($arrbgdata); 
@endphp
<li class="list-group-item card" id="medicaldata-{{ $termsdata->id }}">
  <div class="todo-indicator bg-<?php echo $arrbgdata[0];?>"></div>
  <div class="widget-content p-0">
    <div class="widget-content-wrapper">
      <div class="widget-content-left mr-2">
        <div class="custom-checkbox custom-control">
          <input type="checkbox" class="custom-control-input" id="CustomSectionCheckbox{{ $termsdata->id }}" value="{{ $termsdata->id }}">
          <label for="CustomSectionCheckbox{{ $termsdata->id }}" class="custom-control-label">&nbsp;</label>
        </div>
      </div>
      <div class="widget-content-left flex2 text-dark medicalajax" data-id="{{ $termsdata->id }}" id="medical-{{ $termsdata->id }}">
        <div class="widget-heading text-dark">{{ $termsdata->medicalterm }}</div>
      </div>
      <div class="widget-content-right"> @if ($termsdata->termtype =='MED')
        <div class="badge badge-secondary mr-2">{{ $termsdata->termtype }}</div>
        @elseif ($termsdata->termtype =='DIS')
        <div class="badge badge-danger mr-2">{{ $termsdata->termtype }}</div>
        @else
        <div class="badge badge-info mr-2">{{ $termsdata->termtype }}</div>
        @endif </div>
      <div class="widget-content-right widget-content-actions">
        <div class="border-0 btn-transition btn"> <a href="#" class="editMedical" data-medical-id="{{$termsdata->id}}" title="@langapp('edit')"><i class="fa fa-edit text-primary"></i> </a> </div>
        <div class="border-0 btn-transition btn"> @if ($termsdata->user_id === Auth::id()) <a href="#" class="deletemedicalterm" data-medical-id="{{$termsdata->id}}" title="@langapp('delete')"><i class="fa fa-trash-alt text-danger"></i> </a> @endif </div>
      </div>
    </div>
  </div>
</li>
@endforeach 