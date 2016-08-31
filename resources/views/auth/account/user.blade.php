@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li><a href="/account" class="active">My account</a></li>
@endsection

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

                        <ul class="nav nav-tabs nav-tabs-left nav-tabs-simple">
                            <li class="active">
                                <a data-toggle="tab" href="#tab2hellowWorld">Your infos</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab2FollowUs">Subscription</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab2Inspire">Misc.</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab2hellowWorld">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="m-t-0">Your account</h3>

                                        <strong>First name</strong>
                                        <p>{{Auth::user()->first_name}}</p>

                                        <strong>Last name</strong>
                                        <p>{{Auth::user()->last_name}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab2FollowUs">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="m-t-0">Subscription</h3>
                                        <div class="alert alert-info">
                                            <strong>Free beta account</strong>
                                            <p>As an early subscriber you are entitled to a free account.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab2Inspire">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="m-t-0">Delete my account</h3>
                                        <p>Deleting your account is permanent and cannot be canceled.</p>
                                        <p>Any open subscription will be lorem ipsum.</p>
                                        <a href="#" class="btn btn-danger">I wish to delete my account permanently</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
@endsection