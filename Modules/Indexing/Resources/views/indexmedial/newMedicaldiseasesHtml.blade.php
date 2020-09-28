 @foreach ($data['medicaltermdata'] as $diseaseslink )
			  @if($diseaseslink->diseaseslink != 'Null')
			  	
			  	@if(strpos($diseaseslink->diseaseslink, ',') !== false)
					 @foreach(explode(',', $diseaseslink->diseaseslink) as $selected)
                     <li class="dd-item dd3-item active" data-id="{{ $diseaseslink->id }}" id="termsdiseasesdata-{{ $diseaseslink->id }}" > <span class="pull-right m-xs">  @if ($diseaseslink->user_id === Auth::id()) <a href="#" class="deletemedicalterm" data-section-id="{{$diseaseslink->id}}" title="@langapp('delete')"> @icon('solid/times', 'icon-muted fa-fw m-r-xs') </a> @endif </span>
  <div class="dd3-content">
                         <label><span class="label-text"> <span class="{!! $diseaseslink->status ? 'text-info' : 'text-danger' !!}" id="section-id-{{ $diseaseslink->id }}"> {{ $selected }} </span></span></label>
                       </div>
</li>
                     @endforeach
				@else
                     <li class="dd-item dd3-item active" data-id="{{ $diseaseslink->id }}" id="termsdiseasesdata-{{ $diseaseslink->id }}" > <span class="pull-right m-xs"> O @if ($diseaseslink->user_id === Auth::id()) <a href="#" class="deletemedicalterm" data-section-id="{{$diseaseslink->id}}" title="@langapp('delete')"> @icon('solid/times', 'icon-muted fa-fw m-r-xs') </a> @endif </span>
  <div class="dd3-content">
                         <label><span class="label-text"> <span class="{!! $diseaseslink->status ? 'text-info' : 'text-danger' !!}" id="section-id-{{ $diseaseslink->id }}"> {{ $diseaseslink->diseaseslink }} </span></span></label>
                       </div>
</li>
                    @endif
			  
		 @endif
 @endforeach 