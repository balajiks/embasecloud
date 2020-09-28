@php
// Field 3 - Saved Data
		$matchThese 			= ['user_id' => $user_id, 'jobid' => $jobid, 'orderid' => $orderid];
		$drugtradename 			= DB::table('drugtradename')->where($matchThese)->get()->toArray();
		$drugtradenametypecount = DB::table('drugtradename')->select('type', DB::raw('count(*) as total'))->where($matchThese)->groupBy('type')->pluck('total','type')->all();
		$data['drugtradename']   		= $drugtradename;
		$data['drugtradenametypecount'] = $drugtradenametypecount;
		$arrbgdata = array( "a"=>"success", "b"=>"warning", "c"=>"info", "d"=>"danger" );
		shuffle($arrbgdata); 
@endphp

<div class="col-lg-12">
<div class="panel-group">
  <div class="panel panel-default">
    <div class="panel-heading">@langapp('indexeddrugtradename')</div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-12 col-lg-6">
          <div class="card-hover-shadow-2x mb-3 card">
            <div class="p-2">
              <ul class="todo-list-wrapper drugtradename-list section-todo-list list-group list-group-flush slim-scroll" data-height="265">
                @foreach ($drugtradename as $termsdata )
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
              </ul>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-lg-6">
          <div class="card-hover-shadow-2x mb-3 card">
            <div class="card-header-tab card-header">
              <div class="card-header-title font-size-xlg text-capitalize font-weight-bold"> <i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i>Drug Trade Name </div>
            </div>
            <div class="p-2">
              <ul class="todo-list-wrapper section-todo-list list-group list-group-flush slim-scroll" data-height="230" id="ajaxdrugtradename">
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
