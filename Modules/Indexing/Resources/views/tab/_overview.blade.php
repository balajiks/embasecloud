<div class="row">
    <div class="col-lg-4 b-r">
        <section class="panel panel-default">
        <header class="panel-heading">@langapp('overview')  </header>
        <section class="panel-body">
            
            <div class="m-xs">
                    <span class="text-muted">@langapp('created_at'):</span>
                    <span class="text-bold">{{  dateFormatted($indexing->created_at)  }}</span>
            </div>

            <div class="m-xs">
                    <span class="text-muted">{{  langapp('stage')  }}:</span>
                    <span class="text-bold text-danger">{{  ucfirst($indexing->status->name)  }}</span>
            </div>

            <div class="m-xs">
                    <span class="text-muted">@langapp('source'):</span>
                    <span class="text-bold">{{  $indexing->AsSource->name  }}</span>
            </div>

            <div class="m-xs">
                    <span class="text-muted">{{ langapp('indexing_age')  }}:</span>
                    <span class="text-bold">{{ dateElapsed($indexing->created_at)  }}</span>
            </div>

            <div class="m-xs">
                    <span class="text-muted">{{ langapp('indexing_value') }}:</span>
                    <span class="text-bold">{{ $indexing->computed_value }}</span>
            </div>

            <div class="m-xs">
                    <span class="text-muted">@langapp('next_followup'):</span>
                    <span class="text-bold">{{  dateFormatted($indexing->next_followup)  }}</span>
            </div>

            <div class="m-xs m-b-sm">
                    <span class="text-muted" data-rel="tooltip" title="GDPR Privacy">{{  langapp('data_processing')  }}:</span>
                    <span class="text-bold text-danger">{{ is_null($indexing->unsubscribed_at) ? '✔︎' : '✘' }}
                        @if(!is_null($indexing->unsubscribed_at))
                        <a href="{{ route('indexing.consent', ['indexing' => $indexing->id]) }}" class="btn btn-xs btn-success" data-rel="tooltip" title="Send Consent">@icon('solid/user-lock')</a>
                        @endif
                    </span>
            </div>

            <div class="progress progress-xs progress-striped active">
                    <div class="progress-bar progress-bar-success" data-toggle="tooltip" data-original-title="{{ $indexing->score }}%" style="width:{{ $indexing->score }}%"></div>
                  </div>

            @if ($indexing->sales_rep > 0)

            <h4 class="font-thin">@langapp('sales_rep')</h4>

            

                <div class="line"></div>
            
            <span class="thumb-sm avatar lobilist-check">
                <img src="{{ $indexing->agent->profile->photo  }}" class="img-circle">
            </span> <strong>{{ $indexing->agent->name }}</strong>
            @endif





                <h4 class="font-thin">indexing Profile</h4>
                <div class="line"></div>

            @if(!empty($indexing->name))
                <small class="text-uc text-xs text-muted">@langapp('name') </small>
                <p>{{ $indexing->name }}</p>
            @endif

            @if(!empty($indexing->email))
                <small class="text-uc text-xs text-muted">@langapp('email') </small>
                <p>{{ $indexing->email }}</p>
            @endif
            @if(!empty($indexing->mobile))
                <small class="text-uc text-xs text-muted">@langapp('mobile') </small>
                <p>{{ $indexing->mobile }} 
                @if(settingEnabled('whatsapp_enabled'))
                <span class="text-bold text-danger">
                        @if(!$indexing->whatsapp_optin)
                        <a href="{{ route('indexing.consent.whatsapp', $indexing->id) }}" class="btn btn-xs btn-success" data-rel="tooltip" title="Request whatsapp consent">@icon('brands/whatsapp') @langapp('subscribe')</a>
                        @endif
                </span>
                @endif
            </p>

            @endif

            @if(!empty($indexing->phone))
                <small class="text-uc text-xs text-muted">@langapp('phone') </small>
                <p>{{ formatPhoneNumber($indexing->phone) }}</p>
            @endif

            @if(!empty($indexing->company))
                <small class="text-uc text-xs text-muted">@langapp('company_name') </small>
                <p>{{ $indexing->company }}</p>
            @endif

           @if(!empty($indexing->timezone))
                <small class="text-uc text-xs text-muted">@langapp('timezone') </small>
                <p>{{ $indexing->timezone }}</p>
            @endif

            @if(!empty($indexing->address1))
                <small class="text-uc text-xs text-muted">@langapp('address') 1 </small>
                <p>{{ $indexing->address1 }}</p>
            @endif

            @if(!empty($indexing->address2))
                <small class="text-uc text-xs text-muted">@langapp('address') 2 </small>
                <p>{{ $indexing->address2 }}</p>
            @endif

            @if(!empty($indexing->city))
                <small class="text-uc text-xs text-muted">@langapp('city') </small>
                <p>{{ $indexing->city }}</p>
            @endif

            @if(!empty($indexing->zip_code))
                <small class="text-uc text-xs text-muted">@langapp('zipcode') </small>
                <p>{{ $indexing->zip_code }}</p>
            @endif

            @if(!empty($indexing->state))
                <small class="text-uc text-xs text-muted">@langapp('state') </small>
                <p>{{ $indexing->state }}</p>
            @endif

            @if(!empty($indexing->country))
                <small class="text-uc text-xs text-muted">@langapp('country') </small>
                <p>{{ $indexing->country }}</p>
            @endif

            

            <div class="m-xs">
                @if(!empty($indexing->skype))

                    <a href="skype:{{ $indexing->skype }}?call" class="btn btn-rounded btn-info btn-icon shadowed">
                        @icon('brands/skype')</a>

                @endif

            @if(!empty($indexing->twitter))
                        <a href="{{ $indexing->twitter }}" target="_blank" class="btn btn-rounded btn-twitter btn-icon shadowed">
                            @icon('brands/twitter')
                        </a>
            @endif

            @if(!empty($indexing->facebook))
                    <a href="{{ $indexing->facebook }}" target="_blank" class="btn btn-rounded btn-info btn-icon shadowed">
                        @icon('brands/facebook')
                    </a>
            @endif

            @if(!empty($indexing->linkedin))
                    <a href="{{ $indexing->linkedin }}" target="_blank" class="btn btn-rounded btn-primary btn-icon shadowed">
                        @icon('brands/linkedin')
                    </a>
            @endif

                    @if(!empty($indexing->website))
                        <a href="{{ $indexing->website }}" target="_blank" class="btn btn-rounded btn-danger btn-icon shadowed">
                            @icon('solid/link')
                        </a>
                    @endif

            </div>

            <div class="map">
                <a href="{{ $indexing->maplink }}" rel="nofollow" target="_blank">
        <img src="//maps.googleapis.com/maps/api/staticmap?center={{ $indexing->map }}&amp;zoom=14&amp;scale=2&amp;size=600x340&amp;maptype=roadmap&amp;format=png&amp;visual_refresh=true&amp;key=AIzaSyAzrmdGlvKbFu9F7vPaY0Jg74q1WQo7B0w" alt="Google Map">
        
        </a>
            </div>

            

            <div class="line"></div>
    <small class="text-uc text-xs text-muted">@langapp('tags')  </small>
                <div class="m-xs">
                    @php
                        $data['tags'] = $indexing->tags;
                    @endphp
                    @include('partial.tags', $data)
                </div>

                <div class="line"></div>
    <small class="text-uc text-xs text-muted">@langapp('message')  </small>
                <div class="m-xs">
                    @parsedown($indexing->message)
                </div>
            
        </section>
    </section>
    <section class="panel panel-default">
    <header class="panel-heading">@langapp('extras')  </header>
        <section class="panel-body">

        @foreach ($indexing->custom as $key => $field)
        @if (App\Entities\CustomField::whereName($field->meta_key)->count() > 0)

        <small class="text-uc text-xs text-muted">{{  ucfirst(humanize($field->meta_key, '-'))  }}</small>
        <p>{{ isJson($field->meta_value) ? implode(', ', json_decode($field->meta_value)) : $field->meta_value }}</p>

        

        
        @endif
        @endforeach
    </section>
</section>
<section class="panel panel-default">
<header class="panel-heading">@langapp('activities')  </header>
<div class="slim-scroll" data-color="#333333" data-disable-fade-out="true" data-distance="0" data-height="500px" data-size="3px">
    @widget('Activities\Feed', ['activities' => $indexing->activities])
</div>
</section>
</div>

<div class="col-lg-8">

    @php
            $data = [
                'notes' => $indexing->notes, 'noteable_type' => get_class($indexing), 
                'title' => $indexing->name.' Note', 'noteable_id' => $indexing->id
            ];
        @endphp

    @widget('Notes\ShowNotes', $data)



</div>


</div>