@foreach ($data['drugtermdata'] as $termsdata )
<li class="list-group-item card" data-id="{{ $termsdata->id }}" id="drugtermsdata-{{ $termsdata->id }}" onclick="selecteddrugdata('{{$termsdata->id}}','{{$termsdata->drugterm}}','{{$termsdata->type}}')" >
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
</li>
@endforeach 