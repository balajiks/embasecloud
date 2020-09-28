@foreach ($data['drugtradename'] as $termsdata )
@php
$arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
shuffle($arrbgdata); 
@endphp
<li class="list-group-item card" data-id="{{ $termsdata->id }}" id="termsdata-{{ $termsdata->id }}">
  <div class="todo-indicator bg-{{$arrbgdata[0]}}"></div>
  <div class="widget-content p-0">
    <div class="widget-content-wrapper">
      <div class="widget-content-left">
        <div class="custom-checkbox custom-control">
          <div class="placeholdericon"></div>
        </div>
      </div>
      <div class="widget-content-left flex2 text-dark" onclick="ajaxtradename({{ $termsdata->id }})" >
        <div class="widget-heading text-dark">_{{ $termsdata->type }} {{ $termsdata->manufacturename }}</div>
      </div>
      @if ($termsdata->countrycode != '')
      <div class="widget-content-right">
        <div class="badge badge-secondary mr-2"> @icon('solid/globe-asia') {{ $termsdata->countrycode }}</div>
      </div>
      @endif
      <div class="widget-content-right widget-content-actions">
        <div class="border-0 btn-transition btn"> @if ($termsdata->user_id === Auth::id()) <a href="#" class="deletetradeterm" data-termsdata-id="{{$termsdata->id}}" title="@langapp('delete')"><i class="fa fa-trash-alt text-danger"></i> </a> @endif </div>
      </div>
    </div>
  </div>
</li>
@endforeach 