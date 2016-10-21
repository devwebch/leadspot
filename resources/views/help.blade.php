@extends('layouts.app')

@section('title', 'Help')

@section('breadcrumb')
    <li><a href="/help" class="active">{{trans('breadcrumbs.help')}}</a></li>
@endsection

@section('styles')
@endsection

@section('scripts')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 m-b-10">
            <div class="panel">
                <div class="panel-heading">
                    <h2>Help</h2>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="m-b-20">
                                <h4>What is LeadSpot?</h4>
                                <p>LeadSpot is an online tool created to help young agencies and freelancers to find new clients. When starting up, it can be quite difficult to find clients, LeadSpot is here to analyze the online presence of local business in a defined area.</p>
                            </div>
                            <div class="m-b-20">
                                <h4>Is this a paid service?</h4>
                                <p>LeadSpot is open to everyone through our free plan, no credit cards are required to open a free account.</p>
                                <p>Paid subscriptions are available, unlocking advanced features and increasing your monthly limits.</p>
                            </div>
                            <div class="m-b-20">
                                <h4>I would like to cancel my subscriptions</h4>
                                <p>We would be sad to see you go, but our goal is your full satisfaction regarding our services. Simply <a href="mailto:support@leadspotapp.com">get in touch with our support</a> and we will cancel your subscription. However we do not offer refunds.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="m-b-20">
                                <h4>I need help using LeadSpot</h4>
                                <p>Do not hesitate to <a href="mailto:support@leadspotapp.com">contact our support</a> by e-mail, we will gladly help you find what you need.</p>
                            </div>
                            <div class="m-b-20">
                                <h4>What happens if I cancel my subscription?</h4>
                                <p>Your subscription will still be active until the end of the purchased time period. If you subscribed on the 5th of november, cancel on the 15th, your subscription will still be active until the 5th of december.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection