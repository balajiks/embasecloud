@foreach ($data['drugtermdata'] as $termsdata )
@php
$arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
shuffle($arrbgdata); 
@endphp
<li class="list-group-item card" id="drugdata-{{ $termsdata->id }}" >
<div class="todo-indicator bg-<?php echo $arrbgdata[0];?>"></div>
<div class="widget-content p-0">
  <div class="widget-content-wrapper">
	<div class="widget-content-left mr-2">
	  <div class="custom-checkbox custom-control">
		<input type="checkbox" class="custom-control-input" id="CustomSectionCheckbox{{ $termsdata->id }}" value="{{ $termsdata->id }}">
		<label for="CustomSectionCheckbox{{ $termsdata->id }}" class="custom-control-label">&nbsp;</label>
	  </div>
	</div>
	<div class="widget-content-left flex2 text-dark drugajax" data-id="{{ $termsdata->id }}" id="drug-{{ $termsdata->id }}" onclick="selecteddrugdata('{{$termsdata->id}}','{{$termsdata->drugterm}}','{{$termsdata->type}}')">
	  <div class="widget-heading text-dark">{{ $termsdata->drugterm }}</div>
	  
	</div>
	
		
		
	<div class="widget-content-right widget-content-actions">
	  <div class="border-0 btn-transition btn"> <a href="#" class="editDrug" data-drug-id="{{$termsdata->id}}" title="@langapp('edit')"><i class="fa fa-edit text-primary"></i> </a> </div>
	  <div class="border-0 btn-transition btn"> @if ($termsdata->user_id === Auth::id()) <a href="#" class="deletedrugterm" data-drug-id="{{$termsdata->id}}" title="@langapp('delete')"><i class="fa fa-trash-alt text-danger"></i> </a> @endif </div>
	</div>
  </div>
</div>
</li>

<?php /*?><li class="list-group-item card" data-id="{{ $termsdata->id }}" id="drugtermsdata-{{ $termsdata->id }}" onclick="selecteddrugdata('{{$termsdata->id}}','{{$termsdata->drugterm}}','{{$termsdata->type}}')" >
  <div class="todo-indicator bg-success"></div>
  <div class="widget-content p-0">
    <div class="widget-content-wrapper">
      <div class="widget-content-left mr-2">
        <div class="custom-checkbox custom-control">
          <div class="placeholdericon"></div>
        </div>
      </div>
      <div class="widget-content-left flex2 text-dark">
        <div class="widget-heading text-dark">{{ $termsdata->drugterm }}</div>
      </div>
      <div class="widget-content-right">
        <div class="badge badge-info mr-2">{{ $termsdata->termtype }}</div>
      </div>
      <div class="widget-content-right widget-content-actions">
        <div class="border-0 btn-transition btn"> @if ($termsdata->user_id === Auth::id()) <a href="#" class="deletedrugterm" data-section-id="{{$termsdata->id}}" title="@langapp('delete')"><i class="fa fa-trash-alt text-danger"></i> </a> @endif </div>
      </div>
    </div>
  </div>
</li><?php */?>
@endforeach 