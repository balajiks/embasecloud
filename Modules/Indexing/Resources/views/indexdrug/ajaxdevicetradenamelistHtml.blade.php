<input type="hidden" id="selectedmanuid" value="{{$data["selectedid"]}}"/>
@php
$arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
shuffle($arrbgdata); 
@endphp
@foreach ($data['devicetradename'] as $tradelink )
<li class="list-group-item card" data-id="{{ $tradelink }}" id="ajaxtradelink-{{ str_replace(' ', '', $tradelink) }}">
  <div class="todo-indicator bg-{{$arrbgdata[0]}}"></div>
  <div class="widget-content p-0">
    <div class="widget-content-wrapper">
      <div class="widget-content-left flex2 text-dark">
        <div class="widget-heading text-dark" id="ajaxtradelink-id-{{ str_replace(' ', '', $tradelink) }}">{{ $tradelink }}</div>
      </div>
      <div class="widget-content-right widget-content-actions">
        <div class="border-0 btn-transition btn"> <a href="#" class="deleteajaxtradelink" data-termsdata-id="{{ str_replace(' ', '', $tradelink) }}" title="@langapp('delete')"><i class="fa fa-trash-alt text-danger"></i> </a> </div>
      </div>
    </div>
  </div>
</li>
@endforeach