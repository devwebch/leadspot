@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/shepherd-theme-arrow.css')}}" />
@endsection

@section('scripts')
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
            <div class="widget-11-2 panel no-border panel-condensed no-margin widget-loader-circle">
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
                    <p class="text-center"><a href="/leads/search">{{trans('home.no_leads')}}</a>.</p>
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
                <div class="panel no-border">
                    <div class="padding-15">
                        <div class="item-header clearfix">
                            <div class="inline">
                                <p class="no-margin"><strong>LeadSpot team</strong></p>
                            </div>
                        </div>
                    </div>
                    <hr class="no-margin">
                    <div class="padding-15">
                        <p>The beta is now open to everyone!</p>
                        <div class="hint-text">12.09.2016</div>
                    </div>
                </div><!-- /.panel -->
            </div>
        </div>
        <div class="col-md-3">
            <div class="m-b-20">
                <div class="panel bg-master-dark widget panel-account">
                    <div class="panel-body">
                        <h2 class="semi-bold"><a href="/account" class="text-white">{{trans('home.my_account')}}</a></h2>
                        <p class=""><a href="/account" class="btn btn-info">{{trans('home.manage_options')}}</a></p>
                    </div>
                </div>
            </div>

            <div class="m-b-20">
                <div class="panel bg-complete-dark widget panel-limit">
                    <div class="panel-body">
                        <h2 class="semi-bold text-white">{{trans('home.daily_limit')}}</h2>
                        <h3 class="text-white">
                            {{$usage->get()->first()->used}} / {{$usage->get()->first()->limit}}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="m-b-20">
                <div class="panel bg-info-light widget panel-contact">
                    <div class="panel-body">
                        <a href="/account"><h3 class="text-white semi-bold">{{trans('home.opinion_title')}}</h3></a>
                        <p class="text-white">{{trans('home.opinion_desc')}}</p>
                        <p><a href="/contact" class="btn btn-default">{{trans('home.opinion_action')}}</a></p>
                    </div>
                </div>
            </div>

            @if( $leads->count() == 0 )
            <div class="m-b-20">
                <a href="/?tour=1" class="btn btn-success">Start tour</a>
            </div>
            @endif

        </div>
    </div>
@endsection