@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
    @if( $tour )
        <link rel="stylesheet" href="{{asset('css/shepherd-theme-arrow.css')}}" />
    @endif
@endsection

@section('scripts')
    @if( $tour )
        <script>var tourConfig = {tour: 'intro'};</script>
        <script>
            var tourI18n = {
                button_text: "{!! trans('tour.general.button_text') !!}",
                intro_title: "{!! trans('tour.intro.intro_title') !!}",
                intro_text: "{!! trans('tour.intro.intro_text') !!}",
                intro_1_title: "{!! trans('tour.intro.intro_1_title') !!}",
                intro_1_text: "{!! trans('tour.intro.intro_1_text') !!}",
                intro_2_title: "{!! trans('tour.intro.intro_2_title') !!}",
                intro_2_text: "{!! trans('tour.intro.intro_2_text') !!}",
                intro_3_title: "{!! trans('tour.intro.intro_3_title') !!}",
                intro_3_text: "{!! trans('tour.intro.intro_3_text') !!}",
                intro_4_title: "{!! trans('tour.intro.intro_4_title') !!}",
                intro_4_text: "{!! trans('tour.intro.intro_4_text') !!}",
                intro_4_btn_label: "{!! trans('tour.intro.intro_4_btn_label') !!}"
            };
        </script>
        <script src="{{asset('js/tour.js')}}"></script>
    @endif
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 m-b-10">
            <div class="panel panel-welcome">
                <div class="panel-body">
                    <h3>{{trans('home.welcome', ['firstname' => Auth::user()->first_name])}}</h3>
                    <p>{{trans('home.introduction')}}</p>
                </div>
            </div>
            <div class="widget-11-2 panel panel-leads no-border panel-condensed no-margin widget-loader-circle">
                <div class="padding-25">
                    <div class="pull-left">
                        <h3 class="no-margin">{{trans('home.your_leads')}}</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="widget-table">
                    @if(count($leads))
                    <table class="table table-condensed table-hover">
                        <tbody>
                            @foreach($leads as $lead)
                            <tr>
                                <td class="col-lg-2 fs-18">{{date('d.m.Y', strtotime($lead->created_at))}}</td>
                                <td class="fs-12 col-lg-6">
                                    <a href="/leads/view/{{$lead->id}}">{{$lead->name}}</a>
                                </td>
                                <td class="text-right col-lg-3">
                                    <span class="label {{$status_classes[$lead->status]}}">{{trans($status[$lead->status])}}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <p class="text-center m-b-10"><a href="/leads/search?tour=1">{{trans('home.no_leads')}}</a>.</p>
                        <p class="text-center p-b-30"><a href="/leads/search?tour=1" class="btn btn-success">{{trans('home.start_searching')}}</a></p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="widget-11-2 panel no-border panel-condensed no-margin widget-loader-circle">
                <div class="padding-25">
                    <div class="pull-left">
                        <h3 class="no-margin">{{trans('home.news')}}</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- newsItem -->
                <div class="panel no-border p-l-25 p-r-25 p-b-25">
                    <div class="p-b-10">
                        <div class="item-header clearfix">
                            <div class="inline">
                                <p class="no-margin"><strong>LeadSpot team</strong></p>
                            </div>
                        </div>
                    </div>
                    <hr class="no-margin">
                    <div class="p-t-10">
                        <p>LeadSpot V 1.0 is online.</p>
                        <div class="hint-text">24.10.2016</div>
                    </div>
                </div>
                <!-- /newItem -->
                <!-- newsItem -->
                <div class="panel no-border p-l-25 p-r-25 p-b-25">
                    <div class="p-b-10">
                        <div class="item-header clearfix">
                            <div class="inline">
                                <p class="no-margin"><strong>LeadSpot team</strong></p>
                            </div>
                        </div>
                    </div>
                    <hr class="no-margin">
                    <div class="p-t-10">
                        <p>The beta is now open to everyone!</p>
                        <div class="hint-text">12.09.2016</div>
                    </div>
                </div>
                <!-- /newItem -->
            </div>
        </div>
        <div class="col-md-3">
            @if( $leads->count() == 0 )
                <div class="m-b-20">
                    <a href="/?tour=1" class="btn btn-success btn-lg btn-block hidden-xs"><i class="fa fa-rocket"></i> {{trans('home.start_tour')}}</a>
                </div>
            @endif

            @if ( Auth::user()->subscribed('main') )
            <div class="m-b-20">
                <div class="panel widget panel-gopro text-center" style="background-color: #b94a67;">
                    <div class="panel-body">
                        <h2 class="semi-bold"><a href="/account/pricing" class="text-white">{{trans('home.go_pro_title')}}</a></h2>
                        <p class=""><a href="/account/pricing" class="btn btn-info-light">{{trans('home.go_pro_label')}}</a></p>
                    </div>
                </div>
            </div>
            @endif

            <div class="m-b-20">
                <div class="panel bg-master-dark widget panel-account text-center">
                    <div class="panel-body">
                        <h2 class="semi-bold"><a href="/account" class="text-white">{{trans('home.my_account')}}</a></h2>
                        <p class=""><a href="/account" class="btn btn-info">{{trans('home.manage_options')}}</a></p>
                    </div>
                </div>
            </div>

            <div class="m-b-20">
                <div class="panel bg-complete-dark widget panel-limit text-center">
                    <div class="panel-body">
                        <h2 class="semi-bold text-white">{{trans('home.monthly_limit')}}</h2>

                        <div class="row">
                            <div class="col-xs-6 text-white">
                                <strong>{{trans('home.limit_search')}}</strong><br>
                                {{$usage->search->used}} / {{$usage->search->limit}}
                            </div>
                            <div class="col-xs-6 text-white">
                                <strong>{{trans('home.limit_contacts')}}</strong><br>
                                {{$usage->contacts->used}} / {{$usage->contacts->limit}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="m-b-20">
                <div class="panel bg-info-light widget panel-contact text-center">
                    <div class="panel-body">
                        <a href="/account"><h3 class="text-white semi-bold">{{trans('home.opinion_title')}}</h3></a>
                        <p class="text-white">{{trans('home.opinion_desc')}}</p>
                        <p><a href="/contact" class="btn btn-default">{{trans('home.opinion_action')}}</a></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection