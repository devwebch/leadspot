@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li><a href="/account" class="active">My account</a></li>
@endsection

@section('styles')
@endsection

@section('scripts')
    <script>
        jQuery(document).ready(function ($) {
            $.ajax({
                url: '/service/checkUsage',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            }).done(function (data) {
                console.info(data);
            });
        });
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 m-b-10">
            <div class="panel">
                <div class="panel-body">
                    <h3>Hi there {{Auth::user()->first_name}}</h3>

                    <ul class="nav nav-tabs nav-tabs-left nav-tabs-simple">
                        <li class="active">
                            <a data-toggle="tab" href="#tabInfos">Your infos</a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#tabSubscription">Subscription</a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#tabMisc">Misc.</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabInfos">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="m-t-0">Your account</h3>

                                    <strong>First name</strong>
                                    <p>{{Auth::user()->first_name}}</p>

                                    <strong>Last name</strong>
                                    <p>{{Auth::user()->last_name}}</p>

                                    <h3>Usage</h3>
                                    <p>Limit: {{$usage->limit}}</p>
                                    <p>Used: {{$usage->used}}</p>
                                    <p>Updated at: {{$usage->updated_at}}</p>

                                    @if( $user->subscribed('main') )
                                        <p>Yes Subscribed: {{$user->subscribed('main')}}</p>
                                    @else
                                        <p>No Subscribed: {{$user->subscribed('main')}}</p>
                                    @endif

                                    @foreach($subscriptions as $item)
                                        <p>sub : {{$item->stripe_plan}}</p>
                                    @endforeach

                                    @if ( $user->subscribed('main', 'leadspot_free') )
                                        <p>Subscribed to FREE</p>
                                    @elseif( $user->subscribed('main', 'leadspot_advanced') )
                                        <p>Subscribed to ADVANCED</p>
                                    @elseif( $user->subscribed('main', 'leadspot_pro') )
                                        <p>Subscribed to PRO</p>
                                    @endif


                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabSubscription">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="m-t-0">Subscription</h3>
                                    <div class="alert alert-info">
                                        <strong>Free beta account</strong>
                                        <p>As an early subscriber you are entitled to a free account.</p>

                                        @if($user->subscribedToPlan('leadspot_free' ,'main'))
                                            Yep subscribed
                                        @else
                                            Nope fuck this shit
                                        @endif

                                        @if ( !$user->subscribed('main') )
                                            <p>
                                                <a href="/subscription/new" class="btn btn-primary">Add Subscription</a>
                                            </p>
                                        @else
                                            <p>
                                                <a href="/subscription/cancel" class="btn btn-danger">Cancel Subscription</a>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabMisc">
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
    {{ csrf_field() }}
@endsection