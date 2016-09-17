@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li><a href="/account" class="active">My account</a></li>
@endsection

@section('styles')
    <style>
        .pricing-table .fa {
            font-size: 19px;
        }
    </style>
@endsection

@section('scripts')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 m-b-10">
            <div class="panel">
                <div class="panel-body">
                    <h3>Hi there {{Auth::user()->first_name}}</h3>

                    <ul class="nav nav-tabs nav-tabs-top nav-tabs-simple">
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

                                    <h3>Daily usage</h3>
                                    <strong>{{$usage->used}} / {{$usage->limit}}</strong>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabSubscription">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="m-t-0">Subscription</h3>

                                    @if ( $user->subscribed('main') )
                                        <div class="alert alert-info" style="max-width: 400px">
                                            <p>You are currently on {{$subscription->stripe_plan}}</p>
                                        </div>
                                        <p><a href="/service/subscription/cancel" class="btn btn-danger">Cancel subscription</a></p>
                                    @endif

                                    @if ( !$user->subscribed('main') )
                                    <table class="table pricing-table no-border m-t-60">
                                        <thead>
                                        <tr>
                                            <th class="no-border"></th>
                                            <th class="text-center v-align-top no-padding bg-master-lightest" style="width: 22%;">
                                                <div class="bg-menu-dark">
                                                    <p class="block-title text-white padding-10 fs-14 no-margin">
                                                        Beginner
                                                    </p>
                                                </div>
                                                <p class="font-montserrat text-info m-t-30 m-b-30 lh-large">FREE</p>
                                            </th>
                                            <th class="text-center bg-menu v-align-top no-padding" style="width: 22%;">
                                                <p class="block-title text-white padding-10 fs-14 text-warning">
                                                    Professional
                                                </p>
                                                <p class="font-montserrat text-white m-t-30 m-b-30 lh-large">
                                                    ${{config('subscriptions.pro.price')}} / mo
                                                </p>
                                            </th>
                                            <th class="text-center v-align-top no-padding bg-master-lightest" style="width: 22%;">
                                                <div class="bg-menu-dark">
                                                    <p class="block-title text-white padding-10 fs-14 no-margin">
                                                        Advanced
                                                    </p>
                                                </div>
                                                <p class="font-montserrat text-info m-t-30 m-b-30 lh-large">
                                                    ${{config('subscriptions.advanced.price')}} / mo
                                                </p>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="bg-master-lightest">
                                            <td>
                                                <p class="p-l-10 m-t-10 fs-14 semi-bold">
                                                    Website analysis per day
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                <p class="block-title text-info m-t-10 fs-14">
                                                    {{config('subscriptions.free.limit')}}
                                                </p>
                                            </td>
                                            <td class="bg-menu text-center">
                                                <p class="block-title text-white m-t-10 fs-14">
                                                    {{config('subscriptions.pro.limit')}}
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                <p class="block-title text-info m-t-10 fs-14">
                                                    {{config('subscriptions.advanced.limit')}}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="bg-transparent">
                                            <td class="v-align-middle">
                                                <p class="p-l-10 m-t-10 fs-14 semi-bold">
                                                    Leads <em>basic</em> management
                                                </p>
                                            </td>
                                            <td class="text-center" data-title="Regular">
                                                <h4 class="fa fa-check text-info m-t-15"></h4>
                                            </td>
                                            <td class="bg-menu text-center" data-title="Extended">
                                                <h4 class="fa fa-check text-warning m-t-15"></h4>
                                            </td>
                                            <td class="text-center" data-title="Custom">
                                                <h4 class="fa fa-check text-info m-t-15"></h4>
                                            </td>
                                        </tr>
                                        <tr class="bg-master-lightest">
                                            <td class="v-align-middle">
                                                <p class="p-l-10 m-t-10 fs-14 semi-bold">
                                                    Automatic geolocation on map
                                                </p>
                                            </td>
                                            <td class="text-center" data-title="Regular">
                                                <h4 class="fa fa-times text-info m-t-15"></h4>
                                            </td>
                                            <td class="bg-menu text-center" data-title="Extended">
                                                <h4 class="fa fa-check text-warning m-t-15"></h4>
                                            </td>
                                            <td class="text-center" data-title="Custom">
                                                <h4 class="fa fa-check text-info m-t-15"></h4>
                                            </td>
                                        </tr>
                                        <tr class="bg-transparent">
                                            <td class="v-align-middle">
                                                <p class="p-l-10 m-t-10 fs-14 semi-bold">
                                                    CMS detection
                                                </p>
                                            </td>
                                            <td class="text-center" data-title="Regular">
                                                <h4 class="fa fa-times text-info m-t-15"></h4>
                                            </td>
                                            <td class="bg-menu text-center" data-title="Extended">
                                                <h4 class="fa fa-check text-warning m-t-15"></h4>
                                            </td>
                                            <td class="text-center" data-title="Custom">
                                                <h4 class="fa fa-check text-info m-t-15"></h4>
                                            </td>
                                        </tr>
                                        <tr class="bg-master-lightest">
                                            <td class="v-align-middle">
                                                <p class="p-l-10 m-t-10 fs-14 semi-bold">
                                                    PDF reports
                                                </p>
                                            </td>
                                            <td class="text-center" data-title="Regular">
                                                <h4 class="fa fa-times text-info m-t-15"></h4>
                                            </td>
                                            <td class="bg-menu text-center" data-title="Extended">
                                                <h4 class="fa fa-check text-warning m-t-15"></h4>
                                            </td>
                                            <td class="text-center" data-title="Custom">
                                                <h4 class="fa fa-times text-info m-t-15"></h4>
                                            </td>
                                        </tr>
                                        <tr class="bg-transparent">
                                            <td class="v-align-middle">
                                                <p class="p-l-10 m-t-10 fs-14 semi-bold">
                                                    Manual leads insertions
                                                </p>
                                            </td>
                                            <td class="text-center" data-title="Regular">
                                                <h4 class="fa fa-times text-info m-t-15"></h4>
                                            </td>
                                            <td class="bg-menu text-center" data-title="Extended">
                                                <h4 class="fa fa-check text-warning m-t-15"></h4>
                                            </td>
                                            <td class="text-center" data-title="Custom">
                                                <h4 class="fa fa-times text-info m-t-15"></h4>
                                            </td>
                                        </tr>
                                        <tr class="bg-transparent">
                                            <td class=""></td>
                                            <td class="text-center p-b-30 p-t-20" data-title="Regular">
                                                <p class="m-t-0 fs-14 semi-bold">
                                                    Billed monthly
                                                </p>
                                                <a class="m-t-10 btn btn-info btn-block bold" disabled href="#">Go free</a>
                                            </td>
                                            <td class="bg-menu text-center p-b-30 p-t-20" data-title="Extended">
                                                <p class="m-t-0 fs-14 text-white semi-bold">
                                                    Billed monthly
                                                </p>
                                                @if ( !$user->subscribed('main', 'leadspot_pro') )
                                                    <a id="btn-subscribe-pro" class="m-t-10 btn btn-warning btn-block bold" href="/subscribe/pro">Go PRO</a>
                                                @else
                                                    <a id="btn-subscribe-pro" class="m-t-10 btn btn-warning btn-block bold" href="#" disabled>Go PRO</a>
                                                @endif
                                            </td>
                                            <td class="text-center p-b-30 p-t-20" data-title="Custom">
                                                <p class="m-t-0 fs-14 semi-bold">
                                                    Billed monthly
                                                </p>
                                                @if ( !$user->subscribed('main', 'leadspot_advanced') && !$user->subscribed('main', 'leadspot_pro') )
                                                    <a id="btn-subscribe-advanced" class="m-t-10 btn btn-complete btn-block bold" href="/subscribe/advanced">Go ADVANCED</a>
                                                @else
                                                    <a id="btn-subscribe-advanced" class="m-t-10 btn btn-complete btn-block bold" href="#" disabled>Go ADVANCED</a>
                                                @endif
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    @endif
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