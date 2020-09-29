@php
// Field 4 - Saved Data
	$matchThese 			= ['user_id' => $user_id, 'jobid' => $jobid, 'pui' => $pui, 'orderid' => $orderid];
	$drugtermdata 			= DB::table('index_drug')->where($matchThese)->get()->toArray();
	$drugtermtypecount 		= DB::table('index_drug')->select('type', DB::raw('count(*) as total'))->where($matchThese)->groupBy('type')->pluck('total','type')->all();
	

	$drugdata = array();
	foreach($drugtermdata as $termgroup){
	   $drugdata[$termgroup->type][] = $termgroup;
	}
	$data['drugtermtypecount']  = $drugtermtypecount;
	$data['drugdata']   		= $drugdata;
	
	
$arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
shuffle($arrbgdata); 
@endphp




<div class="col-lg-12">
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading"> @langapp('drugsublink') <span class="btn btn-success btn-xs">Total: <span id="drugtotalajax">{{@$drugtermtypecount['minor'] + @$drugtermtypecount['major']}} </span></span></div>
      <div class="panel-body">
        <div class="slim-scroll1">
          <div class="form-group">
            <div class="panel-group" id="accordion"> @if(!empty($drugdata))
              @php 
              $cnt =1;
              @endphp
              @foreach ($drugdata as $key =>$drugterms )
			  
			  <div class="panel panel-default">
                  <div class="panel-heading"> @if($key == 'major')
					 <h3 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{$cnt}}"> {{ucwords($key)}}&nbsp;&nbsp;<span class="btn btn-info btn-xs m-r"><span id="drugmajortotalajax">{{@$drugtermtypecount['major']}}</span> </span></a></h3>
                    @else
                    <h3 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{$cnt}}">{{ucwords($key)}}&nbsp;&nbsp;<span class="btn btn-info btn-xs m-r"><span id="drugminortotalajax">{{@$drugtermtypecount['minor']}}</span> </span></a></h3>
                    @endif </div>
					
					
                  <div id="collapseOne{{$cnt}}" class="panel-collapse collapse @if($key == 'major') in @endif">
                    <div class="panel-body">
                      <ul class="todo-list-wrapper section-todo-list list-group list-group-flush slim-scroll" id="{{$key}}-druglistdata" data-height="250" style="height:250px;"> 
						 @foreach ($drugterms as $termsdata )
						@php
						$rand = rand(0,4);
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
                        @endforeach
                        <li id="{{$key}}-druglistdata"></li>
                      </ul>
                    </div>
                  </div>
                </div>
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
              
              @php 
              $cnt++;
              @endphp
              @endforeach
			  @else
			  
			  <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne1"> Major&nbsp;&nbsp;<span class="btn btn-info btn-xs m-r"><span id="drugmajortotalajax">0</span> </span></a></h3>
                  </div>
                  <div id="collapseOne1" class="panel-collapse collapse in ">
                    <div class="panel-body">
                      <ul class="todo-list-wrapper section-todo-list list-group list-group-flush slim-scroll" id="major-mediallistdata" data-height="197" style="height:197px;">
                        <li id="major-druglistdata"></li>
                      </ul>
                    </div>
                  </div>
                </div>
			  
			  <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne2"> Minor&nbsp;&nbsp;<span class="btn btn-info btn-xs m-r"><span id="drugminortotalajax">0</span> </span></a></h3>
                  </div>
                  <div id="collapseOne2" class="panel-collapse collapse">
                    <div class="panel-body">
                      <ul class="todo-list-wrapper section-todo-list list-group list-group-flush slim-scroll" id="minor-mediallistdata" data-height="197" style="height:197px;">
                        <li id="minor-druglistdata"></li>
                      </ul>
                    </div>
                  </div>
                </div>
			  
			  
			  
			  
			  
              @endif 
			  
			  
			  
			  </div>
            <?php /*?><div class="row"> @if(!empty($drugdata))
                @foreach ($drugdata as $key =>$drugterms )
                <ol class="dd-list" id="{{$key}}-druglistdata">
                  <li class="btn-warning" style="padding-left:20px;">
                    <label>{{$key}}</label>
                  </li>
                  @foreach ($drugterms as $termsdata )
                  <li class="dd-item dd3-item active" data-id="{{ $termsdata->id }}" id="drugtermsdata-{{ $termsdata->id }}" onclick="selecteddrugdata('{{$termsdata->id}}','{{$termsdata->drugterm}}','{{$termsdata->type}}')" > <span class="pull-right m-xs"> @if ($termsdata->user_id === Auth::id()) <a href="#" class="deletedrugterm" data-section-id="{{$termsdata->id}}" title="@langapp('delete')"> @icon('solid/times', 'icon-muted fa-fw m-r-xs') </a> @endif </span>
                   
				    <div class="dd3-content" id="drugtermshighlight-{{ $termsdata->id }}">
                      <label><span class="label-text active"> <span class="{!! $termsdata->status ? 'text-info' : 'text-danger' !!}" id="drug-id-{{ $termsdata->id }}"> {{ $termsdata->drugterm }} </span></span></label>
                      <span class="btn btn-info btn-xs pull-right">{{ $termsdata->termtype }}</span> </div>
                  </li>
                  @endforeach
                </ol>
                @endforeach
				
				
                @else
                <ol class="dd-list" id="major-druglistdata">
                  <li class="btn-warning" style="padding-left:20px;">
                    <label>Major</label>
                  </li>
                  <li id="major-listdata"></li>
                </ol>
                <ol class="dd-list" id="minor-druglistdata">
                  <li class="btn-warning" style="padding-left:20px;">
                    <label>Minor</label>
                  </li>
                  <li id="minor-listdata"></li>
                </ol>
                @endif </div><?php */?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
