@php
// Field 3 - Saved Data
		$matchThese 			= ['user_id' => $user_id, 'jobid' => $jobid, 'orderid' => $orderid];
		$checktagdata 			= DB::table('index_medical_checktag')->where($matchThese)->get()->toArray();
		$medicaltermdata 		= DB::table('index_medical_term')->where($matchThese)->get()->toArray();
		$medicaltermtypecount 	= DB::table('index_medical_term')->select('type', DB::raw('count(*) as total'))->where($matchThese)->groupBy('type')->pluck('total','type')->all();
		$diseasescount 			= DB::table('index_medical_term')->select(DB::raw("(CHAR_LENGTH(diseaseslink) - CHAR_LENGTH(REPLACE(diseaseslink, ',', '')) + 1) as TotalValue"))->where($matchThese)->where('diseaseslink', '<>', 'Null')->get()->toArray();
		
		$totaldiseasescnt = 0;
		foreach($diseasescount as $cntval){
		   $totaldiseasescnt = $totaldiseasescnt + $cntval->TotalValue;
		}

		$medicaldata = array();
		foreach($medicaltermdata as $termgroup){
		   $medicaldata[$termgroup->type][] = $termgroup;
		}
		$data['checktagdata']   		= $checktagdata;
		$data['medicaltermtypecount']   = $medicaltermtypecount;
		$data['medicaldata']   			= $medicaldata;
@endphp
@php
$arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
shuffle($arrbgdata); 
@endphp


<div class="col-lg-12">
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">@langapp('medicalinfo') <span class="btn btn-success btn-xs">Total: <span id="medtotalajax">{{@$medicaltermtypecount['minor'] + @$medicaltermtypecount['major'] + count(@$checktagdata)}} </span></span></div>
      <div class="panel-body">
        <div class="slim-scroll1">
          <div class="form-group">
            <div class="col-md-6">
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
                  <div id="collapseOne{{$cnt}}" class="panel-collapse collapse @if($key == 'major') in @endif">
                    <div class="panel-body">
                      <ul class="todo-list-wrapper section-todo-list list-group list-group-flush slim-scroll" id="{{$key}}-mediallistdata" data-height="147" style="height:147px;">
                        
						@foreach ($medicalterms as $termsdata )
						@php
						$rand = rand(0,4);
						@endphp
						
						<li class="list-group-item card" id="medicaldata-{{ $termsdata->id }}">
						<div class="todo-indicator bg-<?php echo $arrbgdata[0];?>"></div>
						<div class="widget-content p-0">
						  <div class="widget-content-wrapper">
							<div class="widget-content-left mr-2">
							  <div class="custom-checkbox custom-control">
								<input type="checkbox" class="custom-control-input" id="CustomSectionCheckbox{{ $termsdata->id }}" value="{{ $termsdata->id }}">
								<label for="CustomSectionCheckbox{{ $termsdata->id }}" class="custom-control-label">&nbsp;</label>
							  </div>
							</div>
							<div class="widget-content-left flex2 text-dark medicalajax" data-id="{{ $termsdata->id }}" id="medical-{{ $termsdata->id }}">
							  <div class="widget-heading text-dark">{{ $termsdata->medicalterm }}</div>
							  
							</div>
							<div class="widget-content-right"> @if ($termsdata->termtype =='MED')
                                <div class="badge badge-secondary mr-2">{{ $termsdata->termtype }}</div>
                                @elseif ($termsdata->termtype =='DIS')
                                <div class="badge badge-danger mr-2">{{ $termsdata->termtype }}</div>
								@else
								<div class="badge badge-info mr-2">{{ $termsdata->termtype }}</div>
                                @endif </div>
								
								
							<div class="widget-content-right widget-content-actions">
							  <div class="border-0 btn-transition btn"> <a href="#" class="editMedical" data-medical-id="{{$termsdata->id}}" title="@langapp('edit')"><i class="fa fa-edit text-primary"></i> </a> </div>
							  <div class="border-0 btn-transition btn"> @if ($termsdata->user_id === Auth::id()) <a href="#" class="deletemedicalterm" data-medical-id="{{$termsdata->id}}" title="@langapp('delete')"><i class="fa fa-trash-alt text-danger"></i> </a> @endif </div>
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
                @else
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne1"> Major&nbsp;&nbsp;<span class="btn btn-info btn-xs m-r"><span id="medmajortotalajax">0</span> </span></a></h3>
                  </div>
                  <div id="collapseOne1" class="panel-collapse collapse in ">
                    <div class="panel-body">
                      <ul class="todo-list-wrapper section-todo-list list-group list-group-flush slim-scroll" id="major-mediallistdata" data-height="147" style="height:147px;">
                        <li id="major-listdata"></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne2"> Minor&nbsp;&nbsp;<span class="btn btn-info btn-xs m-r"><span id="medminortotalajax">0</span> </span></a></h3>
                  </div>
                  <div id="collapseOne2" class="panel-collapse collapse">
                    <div class="panel-body">
                      <ul class="todo-list-wrapper section-todo-list list-group list-group-flush slim-scroll" id="minor-mediallistdata" data-height="147" style="height:147px;">
                        <li id="minor-listdata"></li>
                      </ul>
                    </div>
                  </div>
                </div>
                @endif
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOnechecktags">Minor Term (_ib) CheckTags &nbsp;<span class="btn btn-info btn-xs m-r"><span id="medchecktagtotalajax">{{count(@$checktagdata)}}</span> </span></a></h3>
                  </div>
                  <div id="collapseOnechecktags" class="panel-collapse collapse">
                    <div class="panel-body">
                      <ul class="todo-list-wrapper medical-todo-list list-group list-group-flush slim-scroll" data-height="147" style="height:147px;">
					  
                        @foreach ($checktagdata as $checktag )
						@php
						$rand = rand(0,4);
						@endphp
						
						
						<li class="list-group-item card" id="medicalchecktagdata-{{ $checktag->id }}">
						<div class="todo-indicator bg-<?php echo $arrbgdata[0];?>"></div>
						<div class="widget-content p-0">
						  <div class="widget-content-wrapper">
							<div class="widget-content-left mr-2">
							  <div class="custom-checkbox custom-control">
								<input type="checkbox" class="custom-control-input" id="CustomSectionCheckbox{{ $checktag->id }}" value="{{ $checktag->id }}">
								<label for="CustomSectionCheckbox{{ $checktag->id }}" class="custom-control-label">&nbsp;</label>
							  </div>
							</div>
							<div class="widget-content-left flex2 text-dark medicalchecktagajax" data-id="{{ $checktag->id }}" id="checktag-{{ $checktag->id }}">
							  <div class="widget-heading text-dark">{{ $checktag->checktag }}</div>
							</div>
							<div class="widget-content-right widget-content-actions">
							 
							  <div class="border-0 btn-transition btn"> @if ($checktag->user_id === Auth::id()) <a href="#" class="deletechecktag" data-checktag-id="{{$checktag->id}}" title="@langapp('delete')"><i class="fa fa-trash-alt text-danger"></i> </a> @endif </div>
							</div>
						  </div>
						</div>
					  </li>
						
						
						
                        
                        @endforeach
						<li id="checktags-listdata"></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6" >
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapsediseases">Diseases links</a></h4>
                </div>
                <div id="collapsediseases" class="panel-collapse collapse in">
                  <div class="panel-body">
                    <ul class="todo-list-wrapper section-todo-list list-group list-group-flush slim-scroll" id="diseaseterm" data-height="250" style="height:250px;">
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>