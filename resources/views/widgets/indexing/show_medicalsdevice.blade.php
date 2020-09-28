@php
// Field 3 - Saved Data
		$matchThese 			= ['user_id' => $user_id, 'jobid' => $jobid, 'orderid' => $orderid, 'pui' => $pui];
		$medicaltermdata 		= DB::table('medicaldevice')->where($matchThese)->get()->toArray();
		$medicaltermtypecount 	= DB::table('medicaldevice')->select('type', DB::raw('count(*) as total'))->where($matchThese)->groupBy('type')->pluck('total','type')->all();
		$sublinkcount 			= DB::table('medicaldevice')->select(DB::raw("(CHAR_LENGTH(sublink) - CHAR_LENGTH(REPLACE(sublink, ',', '')) + 1) as TotalValue"))->where($matchThese)->where('sublink', '<>', 'Null')->get()->toArray();
		
		$totalsublinkcnt = 0;
		foreach($sublinkcount as $cntval){
		   $totalsublinkcnt = $totalsublinkcnt + $cntval->TotalValue;
		}

		$medicaldata = array();
		foreach($medicaltermdata as $termgroup){
		   $medicaldata[$termgroup->type][] = $termgroup;
		}
		$data['medicaltermtypecount']   = $medicaltermtypecount;
		$data['medicaldata']   			= $medicaldata;
@endphp
<div class="col-lg-12">
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading"> @langapp('medicalinfo') <span class="btn btn-success btn-xs">Total: <span id="medtotalajax">{{@$medicaltermtypecount['minor'] + @$medicaltermtypecount['major']}} </span></span></div>
      <div class="panel-body">
        <div class="slim-scroll1">
          <div class="form-group">
            <div class="panel-group" id="accordion"> @if(!empty($medicaldata))
              @php 
              $cnt =1;
              @endphp
              @foreach ($medicaldata as $key =>$medicalterms )
              <div class="panel panel-default">
                <div class="panel-heading"> @if($key == 'major')
                  <h3 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{$cnt}}"> {{ucwords($key)}}&nbsp;&nbsp;<span class="btn btn-info btn-xs m-r"><span id="medmajortotalajax">{{@$medicaltermtypecount['major']}}</span> </span></a></h3>
                  @else
                  <h3 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{$cnt}}">{{ucwords($key)}}&nbsp;&nbsp;<span class="btn btn-info btn-xs m-r"><span id="medminortotalajax">{{@$medicaltermtypecount['minor']}}</span> </span></a></h3>
                  @endif </div>
                <div id="collapseOne{{$cnt}}" class="panel-collapse collapse">
                  <div class="panel-body">
                    <ul class="todo-list-wrapper section-todo-list list-group list-group-flush slim-scroll" id="{{$key}}-mediallistdata" data-height="250" style="height:250px;">
                     @foreach ($medicalterms as $termsdata )
                      <li class="list-group-item card" data-id="{{ $termsdata->id }}" id="termsdata-{{ $termsdata->id }}" onClick="selectedmedicalindexingdata('{{$termsdata->id}}','{{$termsdata->deviceterm}}','{{$termsdata->type}}')" >
                        <div class="todo-indicator bg-success"></div>
                        <div class="widget-content p-0">
                          <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-2">
                              <div class="custom-checkbox custom-control">
                                <div class="placeholdericon"></div>
                              </div>
                            </div>
                            <div class="widget-content-left flex2 text-dark">
                              <div class="widget-heading text-dark">{{ $termsdata->deviceterm }}</div>
                            </div>
                            <div class="widget-content-right">
                              <div class="badge badge-info mr-2">{{ $termsdata->termtype }}</div>
                            </div>
                            <div class="widget-content-right widget-content-actions">
                              <div class="border-0 btn-transition btn"> @if ($termsdata->user_id === Auth::id()) <a href="#" class="deletemedicaldeviceterm" data-section-id="{{$termsdata->id}}" title="@langapp('delete')"><i class="fa fa-trash-alt text-danger"></i> </a> @endif </div>
                            </div>
                          </div>
                        </div>
                      </li>
                      @endforeach
					  <li id="{{$key}}-listdata"></li>
                    </ul>
                  </div>
                </div>
              </div>
              @php 
              $cnt++;
              @endphp
              @endforeach
              @endif </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php /*?><div class="col-lg-121">
  <div class="panel-group">
     <div class="panel panel-primary">
	 <div class="panel-heading">@langapp('medicalinfo')</div>
       <div class="panel-body">
	   <div class="slim-scroll">
         <div class="form-group">
          <div class="col-md-6">
		  
        <header class="btn btn-primary btn-sm" > @icon('solid/exclamation-circle') Medical Device  Term (Major & Minor)</header>
      
		   <span class="btn btn-success btn-xs pull-right">Total: <span id="medtotalajax">{{@$medicaltermtypecount['minor'] + @$medicaltermtypecount['major'] }} </span></span><span class="btn btn-info btn-xs pull-right">Minor: <span id="medminortotalajax">{{@$medicaltermtypecount['minor']}}</span> </span><span class="btn btn-warning btn-xs pull-right">Major: <span id="medmajortotalajax">{{@$medicaltermtypecount['major']}}</span> </span>
             
			 @if(!empty($medicaldata))
              @foreach ($medicaldata as $key =>$medicalterms )
			  <ol class="dd-list" id="{{$key}}-mediallistdata">
              <li class="btn-warning" style="padding-left:20px;"><label>{{$key}}</label></li>
			  <li id="{{$key}}-listdata"></li>
              @foreach ($medicalterms as $termsdata )
              <li class="dd-item dd3-item active" data-id="{{ $termsdata->id }}" id="termsdata-{{ $termsdata->id }}" > <span class="pull-right m-xs"> <a href="#" class=""> @icon('solid/pencil-alt', 'icon-muted fa-fw m-r-xs') </a> @if ($termsdata->user_id === Auth::id()) <a href="#" class="deletemedicaldeviceterm" data-section-id="{{$termsdata->id}}" title="@langapp('delete')"> @icon('solid/times', 'icon-muted fa-fw m-r-xs') </a> @endif </span>
                 <div class="dd3-content">
                  <label><span class="label-text"> <span class="{!! $termsdata->status ? 'text-info' : 'text-danger' !!}" id="section-id-{{ $termsdata->id }}"> {{ $termsdata->deviceterm }} </span></span></label><span class="btn btn-info btn-xs pull-right">{{ $termsdata->termtype }}</span>
                </div></li>
              @endforeach  
			  </ol>
              @endforeach
			 @else
			 <ol class="dd-list" id="major-mediallistdata"><li class="btn-warning" style="padding-left:20px;"><label>Major</label></li><li id="major-listdata"></li></ol>
			 <ol class="dd-list" id="minor-mediallistdata"><li class="btn-warning" style="padding-left:20px;"><label>Minor</label></li><li id="minor-listdata"></li></ol>
			 @endif
             
		   
		   
             
			
			
         </div>
          <div class="col-md-5">
		   <header class="btn btn-primary btn-sm" > @icon('solid/exclamation-circle') Sublinks </header>
      
		    <span class="btn btn-primary btn-xs pull-right">Count: <span id="medsublinktotalajax">{{$totalsublinkcnt}}</span></span>
             <ol class="dd-list" id="sublink-listdata">
              @foreach ($medicaltermdata as $diseaseslink )
			  @if($diseaseslink->sublink != 'Null')
			  	
			  	@if(strpos($diseaseslink->sublink, ',') !== false)
					 @foreach(explode(',', $diseaseslink->sublink) as $selected)
					 	<li class="dd-item dd3-item active" data-id="{{ $diseaseslink->id }}" id="termsdiseasesdata-{{ $diseaseslink->id }}" > <span class="pull-right m-xs"> <a href="#" class=""> @icon('solid/pencil-alt', 'icon-muted fa-fw m-r-xs') </a> @if ($diseaseslink->user_id === Auth::id()) <a href="#" class="deletemedicalterm" data-section-id="{{$diseaseslink->id}}" title="@langapp('delete')"> @icon('solid/times', 'icon-muted fa-fw m-r-xs') </a> @endif </span>
					  <div class="dd3-content">
					  <label><span class="label-text"> <span class="{!! $diseaseslink->status ? 'text-info' : 'text-danger' !!}" id="section-id-{{ $diseaseslink->id }}"> {{ $selected }} </span></span></label>
					</div>
				  </li>
					 @endforeach
				@else
					<li class="dd-item dd3-item active" data-id="{{ $diseaseslink->id }}" id="termsdiseasesdata-{{ $diseaseslink->id }}" > <span class="pull-right m-xs"> <a href="#" class=""> @icon('solid/pencil-alt', 'icon-muted fa-fw m-r-xs') </a> @if ($diseaseslink->user_id === Auth::id()) <a href="#" class="delete{{$key}}" data-section-id="{{$diseaseslink->id}}" title="@langapp('delete')"> @icon('solid/times', 'icon-muted fa-fw m-r-xs') </a> @endif </span>
					  <div class="dd3-content">
					  <label><span class="label-text"> <span class="{!! $diseaseslink->status ? 'text-info' : 'text-danger' !!}" id="section-id-{{ $diseaseslink->id }}"> {{ $diseaseslink->sublink }} </span></span></label>
					</div>
				  </li>
				@endif
			  
			  @endif
              @endforeach
            </ol>
                     </div>
        </div>
		
		</div>
                 </div>
    </div>
             </div>
</div><?php */?>
