@php
$arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
shuffle($arrbgdata); 
@endphp
<div class="row">
  <div class="col-sm-12 col-lg-12">
    <div class="card-hover-shadow-2x mb-3 card">
      <div class="p-2">
            <ul class="todo-list-wrapper section-todo-list list-group list-group-flush slim-scroll" data-height="250">
			 @foreach ($indexingsections as $section)
			  <li class="list-group-item card" data-id="{{ $section->id }}" id="section-{{ $section->id }}">
                <div class="todo-indicator bg-{{$arrbgdata[0]}}"></div>
                <div class="widget-content p-0">
                  <div class="widget-content-wrapper">
                    <div class="widget-content-left mr-2">
                      <div class="custom-checkbox custom-control">
                        <div class="placeholdericon"></div>
                      </div>
                    </div>
                    <div class="widget-content-left flex2 text-dark">
                      <div class="widget-heading text-dark">Section : {{ $section->sectionval }}</div>
                    </div>
                    <div class="widget-content-right">
                      <div class="badge badge-secondary mr-2">@icon('solid/calendar-alt') {{ !empty($section->created_at) ?  dateElapsed($section->created_at) : '' }}</div>
                    </div>
                    <div class="widget-content-right widget-content-actions">
                      <div class="border-0 btn-transition btn"> @if ($section->user_id === Auth::id()) <a href="#" class="deleteSection" data-section-id="{{$section->id}}" title="@langapp('delete')"><i class="fa fa-trash-alt text-danger"></i> </a> @endif </div>
                    </div>
                  </div>
                </div>
              </li>
			  @endforeach
            </ul>
          </div>
    </div>
  </div>
</div>