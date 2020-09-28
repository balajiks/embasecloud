
<div class="row">
  <div class="col-sm-12 col-lg-6">
    <div class="card-hover-shadow-2x mb-3 card">
      <div class="card-header-tab" style="border-bottom:1px solid rgba(26,54,126,0.125);">
        <div class="card-header" style="float:left;">
          <div class="card-header-title font-size-xlg text-capitalize font-weight-bold"> <i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i>Section </div>&nbsp;&nbsp;&nbsp;<input id="selectAll" type="checkbox">
          <label for='selectAll' class="badge badge-primary mr-2" style="font-size:100% !important; margin-top:7px; cursor:pointer;">Select All</label>
          &nbsp;&nbsp;&nbsp;
          <label class="badge badge-danger mr-2" style="font-size:100%; margin-top:7px;" id="sectiondeletebtn">Delete</label>
        </div>
        <span id="preloader" class="btn btn-sm btn-warning pull-right" style="display:block !important;"><i class="fas fa-spin fa-spinner"></i> Loading...</span> </div>
      <div class="p-2">
        <ul class="todo-list-wrapper section-todo-list list-group list-group-flush slim-scroll" data-height="250">
          @foreach (@$indexingsections as $section)
          @php
          $arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
          shuffle($arrbgdata); 
          @endphp
		  
		  
          <li class="list-group-item card" id="sectiondata-{{ $section->id }}">
            <div class="todo-indicator bg-{{ $arrbgdata[0] }}"></div>
            <div class="widget-content p-0">
              <div class="widget-content-wrapper">
                <div class="widget-content-left mr-2">
                  <div class="custom-checkbox custom-control">
                    <input type="checkbox" class="custom-control-input" id="CustomSectionCheckbox{{ $section->id }}" value="{{ $section->id }}">
                    <label for="CustomSectionCheckbox{{ $section->id }}" class="custom-control-label">&nbsp;</label>
                  </div>
                </div>
                <div class="widget-content-left flex2 text-dark sectionajax" data-id="{{ $section->id }}" id="section-{{ $section->id }}">
                  <div class="widget-heading text-dark">Section : {{ $section->sectionval }}</div>
                  <div class="widget-subheading text-dark">Publication Choice: {{ $section->pubchoice }}</div>
                </div>
                <div class="widget-content-right widget-content-actions">
                  <div class="border-0 btn-transition btn"> <a href="#" class="editSection" data-section-id="{{$section->id}}" title="@langapp('edit')"><i class="fa fa-edit text-primary"></i> </a> </div>
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
  @php
  $arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
  shuffle($arrbgdata); 
  @endphp
  <div class="col-sm-12 col-lg-6">
    <div class="card-hover-shadow-2x mb-3 card">
      <div class="card-header-tab" style="border-bottom:1px solid rgba(26,54,126,0.125);">
        <div class="card-header" style="float:left;">
          <div class="card-header-title font-size-xlg text-capitalize font-weight-bold"> <i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i>Classification </div>
        </div>
        <span id="preloaderloading" class="btn btn-sm btn-warning pull-right"><i class="fas fa-spin fa-spinner"></i> Loading...</span> </div>
      <div class="p-2">
        <ul class="todo-list-wrapper list-group list-group-flush slim-scroll innerhtmlclassification" data-height="250">
          @if (@$indexingsections[0]->classificationval !='')
          @php
          $classdata = explode('|||',@$indexingsections[0]->classificationval);
          @endphp
          
          
          
          @foreach ($classdata as $dataclass)
          <li class="list-group-item card" data-id="{{ @$indexingsections[0]->id }}" id="section-{{ @$indexingsections[0]->id }}" >
            <div class="todo-indicator bg-{{$arrbgdata[0]}}"></div>
            <div class="widget-content p-0">
              <div class="widget-content-wrapper">
                <div class="widget-content-left flex2 text-dark">
                  <div class="widget-heading text-dark">{{ $dataclass }}</div>
                </div>
                <div class="widget-content-right widget-content-actions">
                  <div class="border-0 btn-transition btn"> @if (@$indexingsections[0]->user_id === Auth::id()) <a href="#" class="deleteClassification" data-section-id="{{@$dataclass}}" title="@langapp('delete')" onclick="deleteClassification('{{@$dataclass}}','{{ @$indexingsections[0]->id }}')"><i class="fa fa-trash-alt text-danger"></i> </a> @endif </div>
                </div>
              </div>
            </div>
          </li>
          @endforeach
        </ul>
        @endif </div>
    </div>
  </div>
</div>
