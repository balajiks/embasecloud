@extends('layouts.app')
@section('content')
<section id="content" class="bg">
    <section class="vbox">
        <header class="header bg-white b-b clearfix">
            <div class="row m-t-sm">
                <div class="col-sm-12 m-b-xs">
                    <p class="h3">{{ $indexing->name }}
                        @can('indexing_delete')
                        <a href="{{ route('indexing.delete', ['id' => $indexing->id]) }}"
                            class="btn btn-danger btn-sm pull-right" data-toggle="ajaxModal" data-rel="tooltip"
                        title="@langapp('delete')  ">@icon('solid/trash-alt')</a>
                        @endcan
                        @can('reminders_create')
                        <a class="btn btn-sm btn-{{ get_option('theme_color') }} pull-right" data-toggle="ajaxModal" data-rel="tooltip"  data-placement="bottom" href="{{  route('calendar.reminder', ['module' => 'indexing', 'id' => $indexing->id])  }}" title="@langapp('set_reminder')  ">
                            @icon('solid/clock')
                        </a>
                        @endcan
                        @can('indexing_update')
                        <a href="{{ route('indexing.edit', ['id' => $indexing->id]) }}"
                            class="btn btn-{{ get_option('theme_color') }} btn-sm pull-right" data-rel="tooltip"
                            data-toggle="ajaxModal" title="@langapp('edit')  " data-placement="left">
                        @icon('solid/pencil-alt') @langapp('edit')  </a>
                        @endcan
                        @can('deals_create')
                        <a href="{{ route('indexing.convert', ['id' => $indexing->id]) }}"
                            class="btn btn-{{ get_option('theme_color') }} btn-sm pull-right" data-rel="tooltip"
                            data-toggle="ajaxModal" title="@langapp('convert')  " data-placement="left">
                            @icon('solid/check-circle') @langapp('convert')
                        </a>
                        @endcan
                        @can('indexing_update')
                        <a href="{{ route('indexing.nextstage', ['id' => $indexing->id]) }}"
                            class="btn btn-{{ get_option('theme_color') }} btn-sm pull-right" data-rel="tooltip"
                            data-toggle="ajaxModal" title="@langapp('move_stage')  " data-placement="left">
                        @icon('solid/arrow-alt-circle-right') @langapp('next_stage')  </a>
                        @endcan
                        
                    </p>
                </div>
            </div>
        </header>
        <section class="scrollable wrapper">
            
            <?php /*?><div class="sub-tab m-b-10">
                <ul class="nav pro-nav-tabs nav-tabs-dashed">
                    <li class="{{  ($tab == 'overview') ? 'active' : '' }}">
                        <a href="{{  route('indexings.view', ['id' => $indexing->id, 'tab' => 'overview'])  }}">@icon('solid/home') @langapp('overview')  </a>
                    </li>

                    <li class="{{  ($tab == 'calls') ? 'active' : ''  }}">
                                <a href="{{  route('indexings.view', ['id' => $indexing->id, 'tab' => 'calls'])  }}">@icon('solid/phone') @langapp('calls')  
                                </a>
                            </li>

                    <li class="{{  ($tab == 'conversations') ? 'active' : ''  }}">
                        <a href="{{  route('indexings.view', ['id' => $indexing->id, 'tab' => 'conversations'])  }}">
                            @icon('solid/envelope-open') @langapp('emails')
                            {!! $indexing->has_email ? '<i class="fas fa-bell text-danger"></i>' : '' !!}
                        </a>
                    </li>
                    <li class="{{  ($tab == 'activity') ? 'active' : ''  }}">
                        <a href="{{  route('indexings.view', ['id' => $indexing->id, 'tab' => 'activity'])  }}">
                            @icon('solid/history') @langapp('activity')
                            {!! $indexing->has_activity ? '<i class="fas fa-bell text-danger"></i>' : '' !!}
                        </a>
                    </li>
                    <li class="{{  ($tab == 'files') ? 'active' : ''  }}">
                        <a href="{{  route('indexings.view', ['id' => $indexing->id, 'tab' => 'files'])  }}">
                        @icon('solid/file-alt') @langapp('files')  </a>
                    </li>
                    <li class="{{  ($tab == 'comments') ? 'active' : ''  }}">
                        <a href="{{  route('indexings.view', ['id' => $indexing->id, 'tab' => 'comments'])  }}">
                            @icon('solid/comments') @langapp('comments')
                        </a>
                    </li>
                    <li class="{{  ($tab == 'calendar') ? 'active' : ''  }}">
                        <a href="{{  route('indexings.view', ['id' => $indexing->id, 'tab' => 'calendar'])  }}">
                            @icon('solid/calendar-alt') @langapp('calendar')
                        </a>
                    </li>
                    <li class="{{  ($tab == 'whatsapp') ? 'active' : ''  }}">
                        <a href="{{  route('indexings.view', ['id' => $indexing->id, 'tab' => 'whatsapp'])  }}">
                            @icon('brands/whatsapp','text-success') Whatsapp
                        </a>
                    </li>
                </ul>
            </div><?php */?>
            
        </section>
    </section>
</section>
@push('pagescript')
@include('stacks.js.markdown')
@endpush
@endsection