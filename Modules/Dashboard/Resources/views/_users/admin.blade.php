<aside class="b-l bg" id="">
            <ul class="dashmenu text-uc text-muted no-border no-radius">
                @modactive('projects')
                <li class="{{ $dashboard == 'projects' ? 'active' : '' }}"><a href="{{ route('dashboard.index', ['dashboard' => 'projects']) }}">@icon('solid/clock') @langapp('projects')</a></li>
                @endmod
                @modactive('tickets')
                <li class="{{ $dashboard == 'tickets' ? 'active' : '' }}"><a href="{{ route('dashboard.index', ['dashboard' => 'tickets']) }}">@icon('solid/life-ring') @langapp('ticketing')</a></li>
                @endmod
            </ul>
            
                <section class="scrollable">
                    <div class="slim-scroll" data-color="#333333" data-disable-fade-out="true" data-distance="0" data-height="auto" data-size="3px">
                        <section class="padder">
                            
                            @include('dashboard::_includes.'.$dashboard)
                            
                            
                        </section>
                    </div>
                </section>
                
            </aside>

            <aside class="aside-lg b-l">
                <section class="vbox">
                    
                    <section class="scrollable" id="feeds">

                    <div class="slim-scroll padder" data-color="#333333" data-disable-fade-out="true" data-distance="0" data-height="auto" data-size="3px">
                    
                        @include('dashboard::_sidebar.'.$dashboard)
                    
                    </div>

                </section>
                    
                </section>
            </aside>