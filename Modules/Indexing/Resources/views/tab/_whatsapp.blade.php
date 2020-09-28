<div class="row">
    <div class="col-lg-4 b-r">
        <section class="panel panel-default">
        <header class="panel-heading">@langapp('profile')</header>
        <section class="panel-body">

            @if ($indexing->sales_rep > 0)
            <small class="text-uc text-xs text-muted">@langapp('sales_rep') </small>
                <p>{{ $indexing->agent->name }}</p>
            
            @endif

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

</div>

<div class="col-lg-8">

    
<section class="" id="taskapp">
    <aside>
        <section class="">
            
            <section class="panel panel-default">
                    <header class="panel-heading">WhatsApp Conversation</header>
                    <section class="bg chat-list panel-body">

                        
                      <section class="panel panel-default">

                        @widget('Chats\CreateWidget', ['chatable_type' => 'indexing' , 'chatable_id' => $indexing->id, 'cannedResponse' => true])

                          
                        </section>



                        @asyncWidget('Chats\WhatsApp', ['chatable_id' => $indexing->id, 'chatable_type' => 'indexing'])

                      
            

                    </section>
                    
                  </section>
            
            

        </section>
    </aside>
    
</section>


</div>


</div>




@include('extras::_ajax.ajaxify_chat')