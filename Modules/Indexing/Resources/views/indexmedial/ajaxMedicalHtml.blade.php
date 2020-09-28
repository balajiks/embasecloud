@php
$arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
shuffle($arrbgdata); 
$diseasedata = explode(',',$diseases[0]->diseaseslink);
@endphp
 @foreach ($diseasedata as $dataclass)
<li class="list-group-item" data-id="{{ $diseases[0]->id }}" id="medical-{{ $diseases[0]->id }}">
  <div class="todo-indicator bg-{{$arrbgdata[0]}}"></div>
  <div class="widget-content p-0">
    <div class="widget-content-wrapper">
      <div class="widget-content-left flex2 text-dark">
	  
	  	@if ($dataclass === 'Null' || empty($dataclass))
        <div class="widget-heading text-dark">No Data</div>
		@else
		<div class="widget-heading text-dark">{{ $dataclass }}</div>
		@endif
		
      </div>
	  @if ($dataclass != 'Null')
      <div class="widget-content-right widget-content-actions">
        <div class="border-0 btn-transition btn"> @if ($diseases[0]->user_id === Auth::id()) <a href="#" class="deleteDiseases" data-section-id="{{$dataclass}}" title="@langapp('delete')"  onclick="deleteDiseases('{{@$dataclass}}','{{ @$diseases[0]->id }}')"><i class="fa fa-trash-alt text-danger"></i> </a> @endif </div>
      </div>
	  @endif
    </div>
  </div>
</li>
@endforeach 