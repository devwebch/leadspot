@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" href="{{asset('assets/plugins/jquery-metrojs/MetroJs.css')}}">
@endsection

@section('scripts')
    <script src="{{asset('assets/plugins/jquery-metrojs/MetroJs.min.js')}}"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 m-b-10">
            <div class="panel">
                <div class="panel-body">
                    <h3>Hi there {{Auth::user()->first_name}}</h3>
                </div>
            </div>
            <div class="widget-11-2 panel no-border panel-condensed no-margin widget-loader-circle">
                <div class="padding-25">
                    <div class="pull-left">
                        <h2 class="no-margin">Your leads</h2>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="auto-overflow widget-11-2-table">
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
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="ar-2-1">
                <div class="widget-2 panel no-border bg-success widget no-margin">
                    <div class="panel-body">
                        <div class="pull-bottom bottom-left bottom-right padding-25">
                            <a href="#">
                                <h3 class="text-white">So much more to see at a glance.</h3>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel no-border">
                <div class="padding-15">
                    <div class="item-header clearfix">
                        <div class="thumbnail-wrapper d32 circular">
                            <img width="40" height="40" src="../assets/img/profiles/3x.jpg"
                                 data-src="../assets/img/profiles/3.jpg"
                                 data-src-retina="../assets/img/profiles/3x.jpg" alt="">
                        </div>
                        <div class="inline m-l-10">
                            <p class="no-margin">
                                <strong>Anne Simons</strong>
                            </p>

                            <p class="no-margin hint-text">Shared a link</p>
                        </div>
                    </div>
                </div>
                <hr class="no-margin">
                <div class="padding-15">
                    <p>Inspired by : good design is obvious, great design is transparent</p>
                    <div class="hint-text">via themeforest</div>
                    <div class="hint-text">22.08.2016</div>
                </div>
            </div><!-- /.panel -->
            <div class="panel no-border">
                <div class="padding-15">
                    <div class="item-header clearfix">
                        <div class="thumbnail-wrapper d32 circular">
                            <img width="40" height="40" src="../assets/img/profiles/3x.jpg"
                                 data-src="../assets/img/profiles/3.jpg"
                                 data-src-retina="../assets/img/profiles/3x.jpg" alt="">
                        </div>
                        <div class="inline m-l-10">
                            <p class="no-margin">
                                <strong>Anne Simons</strong>
                            </p>

                            <p class="no-margin hint-text">Shared a link</p>
                        </div>
                    </div>
                </div>
                <hr class="no-margin">
                <div class="padding-15">
                    <p>Inspired by : good design is obvious, great design is transparent</p>
                    <div class="hint-text">via themeforest</div>
                    <div class="hint-text">22.08.2016</div>
                </div>
            </div><!-- /.panel -->
        </div>
    </div>
@endsection