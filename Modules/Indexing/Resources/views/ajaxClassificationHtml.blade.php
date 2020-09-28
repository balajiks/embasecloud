@php
$arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
shuffle($arrbgdata); 
$classdata = explode('|||',$classification[0]->classificationval);
@endphp
@foreach ($classdata as $dataclass)
<li class="list-group-item card" data-id="{{ $classification[0]->id }}" id="section-{{ $classification[0]->id }}">
  <div class="todo-indicator bg-{{$arrbgdata[0]}}"></div>
  <div class="widget-content p-0">
    <div class="widget-content-wrapper">
      <div class="widget-content-left flex2 text-dark">
        <div class="widget-heading text-dark">{{ $dataclass }}</div>
      </div>
      <div class="widget-content-right widget-content-actions">
        <div class="border-0 btn-transition btn">
        @if ($classification[0]->user_id === Auth::id()) <a href="#" class="deleteClassification" data-section-id="{{$dataclass}}" title="@langapp('delete')"  onclick="deleteClassification('{{@$dataclass}}','{{ @$classification[0]->id }}')"><i class="fa fa-trash-alt text-danger"></i> </a> @endif
        </div>
      </div>
    </div>
  </div>
</li>
@endforeach