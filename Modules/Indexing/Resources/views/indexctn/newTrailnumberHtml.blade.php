@php
$arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
shuffle($arrbgdata); 
@endphp
@foreach ($data['ctntermdata'] as $ctn )
<li class="list-group-item card" data-id="{{ $ctn->id }}" id="ctn-{{ $ctn->id }}">
  <div class="todo-indicator bg-{{$arrbgdata[0]}}"></div>
  <div class="widget-content p-0">
    <div class="widget-content-wrapper">
      <div class="widget-content-left mr-2">
        <div class="custom-checkbox custom-control">
          <div class="placeholdericon"></div>
        </div>
      </div>
      <div class="widget-content-left flex2 text-dark">
        <div class="widget-heading text-dark">{{ $ctn->registryname }}</div>
        <div class="widget-heading text-dark">{{ $ctn->trailnumber }}</div>
      </div>
      <div class="widget-content-right">
        <div class="badge badge-warning mr-2">@icon('solid/calendar-alt') {{ !empty($ctn->created_at) ?  dateElapsed($ctn->created_at) : '' }}</div>
      </div>
      <div class="widget-content-right widget-content-actions">
        <div class="border-0 btn-transition btn"> @if ($ctn->user_id === Auth::id()) <a href="#" class="deleteCtn" data-ctn-id="{{$ctn->id}}" title="@langapp('delete')"><i class="fa fa-trash-alt text-danger"></i> </a> @endif </div>
      </div>
    </div>
  </div>
</li>
@endforeach 