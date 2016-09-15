@extends('layouts.app')

@section('title', 'Subscription')

@section('breadcrumb')
    <li><a href="/account" class="active">My account</a></li>
@endsection

@section('styles')
@endsection

@section('scripts')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">
        Stripe.setPublishableKey('<?php echo env('STRIPE_KEY'); ?>');
    </script>
@endsection

@section('content')
    <form action="/subscription/save" method="POST">
        {{csrf_field()}}
        <script
                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-key="<?php echo env('STRIPE_KEY'); ?>"
                data-amount="10"
                data-name="LeadSpot"
                data-description="LeadSpot subscription Free"
                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                data-locale="auto"
                data-currency="chf">
        </script>
    </form>
@endsection