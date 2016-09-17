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
        (function () {
            jQuery(document).ready(function ($) {
                var name    = $('input[name="inputName"]');
                var cc      = $('input[name="inputCc"]');
                var month   = $('select[name="inputMonth"]');
                var year    = $('select[name="inputYear"]');
                var cvc     = $('input[name="inputCvc"]');

                $('.cc-form').submit(function (e) {
                    e.preventDefault();

                    if (name && cc && cvc) {
                        $('.cc-form .btn .fa').removeClass('hidden');
                        disableFields();

                        Stripe.card.createToken({
                            number: cc.val(),
                            exp_month: month.val(),
                            exp_year: year.val(),
                            cvc: cvc.val()
                        }, function(status, response) {
                            // response.id is the card token.
                            console.info(response);

                            // test if an error was encountered
                            if (response.error) {
                                enableFields();
                                swal("Error", "We were unable to validate your credit card, please verify your informations.", "error");
                            } else {
                                $('input[name="token"]').val(response.id);
                                $('#buy-form').submit();
                                swal({
                                    type: 'success',
                                    title: 'Success',
                                    text: "Please wait while your payment is being processed...",
                                    timer: 4000,
                                    showConfirmButton: false
                                });
                            }

                            $('.cc-form .btn .fa').addClass('hidden');
                        });
                    }
                });

                function disableFields() {
                    name.attr('disabled', 'disabled');
                    cc.attr('disabled', 'disabled');
                    month.attr('disabled', 'disabled');
                    year.attr('disabled', 'disabled');
                    cvc.attr('disabled', 'disabled');
                }

                function enableFields() {
                    name.removeAttr('disabled');
                    cc.removeAttr('disabled');
                    month.removeAttr('disabled');
                    year.removeAttr('disabled');
                    cvc.removeAttr('disabled');
                }
            });
        })();
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h2>{{$planName}}</h2>
            <h4>Subscribe now for: <strong>${{config('subscriptions.' . $plan . '.price')}} / month</strong></h4>
            <form action="/service/subscription/new/{{$plan}}" id="buy-form" method="post">
                {{csrf_field()}}
                <input type="hidden" name="token" value="">
            </form>
        </div>
        <div class="col-md-6">
            <form role="form" class="cc-form">
                <div class="bg-master-light padding-30 m-b-20 b-rad-sm">
                    <h2 class="pull-left no-margin">Credit Card</h2>
                    <ul class="list-unstyled pull-right list-inline no-margin">
                        <li>
                            <a href="#">
                                <img width="51" height="32" data-src-retina="{{asset('img/credit_cards/visa2x.png')}}" data-src="{{asset('img/credit_cards/visa.png')}}" class="brand" alt="Visa" src="{{asset('img/credit_cards/visa.png')}}">
                            </a>
                        </li>
                        <li>
                            <a href="#" class="hint-text">
                                <img width="51" height="32" data-src-retina="{{asset('img/credit_cards/amex2x.png')}}" data-src="{{asset('img/credit_cards/amex.png')}}" class="brand" alt="Amex" src="{{asset('img/credit_cards/amex.png')}}">
                            </a>
                        </li>
                        <li>
                            <a href="#" class="hint-text">
                                <img width="51" height="32" data-src-retina="{{asset('img/credit_cards/mastercard2x.png')}}" data-src="{{asset('img/credit_cards/mastercard.png')}}" class="brand" alt="Mastercard" src="{{asset('img/credit_cards/mastercard.png')}}">
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                    <div class="form-group form-group-default required m-t-25">
                        <label>Card holder's name</label>
                        <input type="text" class="form-control" name="inputName" placeholder="Name on the card" required>
                    </div>
                    <div class="form-group form-group-default required">
                        <label>Card number</label>
                        <input type="text" class="form-control" name="inputCc" placeholder="8888-8888-8888-8888" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Expiration</label>
                            <br>
                            <select class="form-control pull-left m-r-20" name="inputMonth" style="width: 100px;">
                                <option value="1" selected>Jan (01)</option>
                                <option value="2">Feb (02)</option>
                                <option value="3">Mar (03)</option>
                                <option value="4">Apr (04)</option>
                                <option value="5">May (05)</option>
                                <option value="6">Jun (06)</option>
                                <option value="7">Jul (07)</option>
                                <option value="8">Aug (08)</option>
                                <option value="9">Sep (09)</option>
                                <option value="10">Oct (10)</option>
                                <option value="11">Nov (11)</option>
                                <option value="12">Dec (12)</option>
                            </select>
                            <select class="form-control" name="inputYear" style="width: 100px;">
                                <?php $year = (int) date('Y'); ?>
                                <?php for( $i=$year; $i < ($year + 20); $i++ ): ?>
                                <option value="{{$i}}">{{$i}}</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-2 col-md-offset-4">
                            <div class="form-group required">
                                <label>CVC Code</label>
                                <input type="text" class="form-control" name="inputCvc" placeholder="000" required>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit"><i class="fa fa-refresh fa-spin hidden"></i> Proceed to payment</button>
            </form>
        </div>
    </div>

@endsection