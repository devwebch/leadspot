@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')

@endsection

@section('scripts')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 m-b-10">
            <div class="panel">
                <div class="panel-body">
                    <h3>Hi there {{Auth::user()->first_name}}!</h3>
                    <p>Thank you for participating to the <strong>LeadSpot beta launch</strong>!</p>
                    <p>This is your dashboard, here you can manage your leads and access the latest news regarding LeadSpot.</p>
                    <p>During the beta a lot of features are going to evolve, share your good ideas and concerns with us.</p>
                </div>
            </div>
            <div class="widget-11-2 panel no-border panel-condensed no-margin widget-loader-circle">
                <div class="padding-25">
                    <div class="pull-left">
                        <h3 class="no-margin">Your leads</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="auto-overflow widget-11-2-table">
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
                    <p class="text-center"><a href="/leads/search">You do not have any leads</a>.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <h4>News from LeadSpot</h4>
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
        <div class="col-md-3">
            <h4>Your opinion matters</h4>
            <div class="panel no-border">
                <div class="padding-15">
                    <p>Please let us know what you think of LeadSpot and help us improve during the beta phase.</p>
                    <p><a href="/contact">Contact LeadSpot</a></p>
                </div>
            </div><!-- /.panel -->
        </div>
    </div>
@endsection