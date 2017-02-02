@extends('layouts.app')

@section('title', trans('breadcrumbs.subscribe'))

@section('breadcrumb')
    <li><a href="/account" class="active">{{trans('breadcrumbs.subscribe')}}</a></li>
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
                                $('#btn-validate-cc').addClass('hidden');
                                $('#btn-buy-now').removeClass('hidden');
                            }

                            $('.cc-form .btn .fa').addClass('hidden');
                        });
                    }
                });

                $('#buy-form').submit(function (e) {
                    $('#btn-buy-now .fa').removeClass('hidden');
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
            <div class="padding-20">
                <h2>{{trans('payment.your_subscription')}}</h2>
                <p>{{trans('payment.subscriptions_details')}}</p>
                <table class="table table-condensed">
                    <tbody><tr>
                        <td class="col-md-2">
                            <span>1x</span>
                        </td>
                        <td class="col-md-10">
                            <span class="m-l-10 font-montserrat fs-18 all-caps">{{$planName}}</span>
                            <span class="m-l-10 ">{{trans('payment.monthly_subscription')}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-md-3"><strong>{{trans('payment.total_label')}}</strong></td>
                        <td class="col-md-9 text-right">
                            <h4 class="text-primary no-margin font-montserrat">${{config('subscriptions.' . $plan . '.price')}} / {{trans('payment.month')}}</h4>
                        </td>
                    </tr>
                    </tbody></table>
                <p class="small">{{trans('payment.invoices_msg')}}</p>
                <p class="small">{!! trans('payment.pay_conditions_msg') !!}</p>
            </div>
        </div>
        <div class="col-md-6">
            <form role="form" class="cc-form">
                <div class="bg-master-light padding-30 m-b-20 b-rad-sm">
                    <h2 class="pull-left no-margin">{{trans('payment.credit_card')}}</h2>
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
                        <label>{{trans('payment.card_holder')}}</label>
                        <input type="text" class="form-control" name="inputName" placeholder="{{trans('payment.card_holder_label')}}" required>
                    </div>
                    <div class="form-group form-group-default required">
                        <label>{{trans('payment.card_number')}}</label>
                        <input type="text" class="form-control" name="inputCc" placeholder="8888-8888-8888-8888" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>{{trans('payment.expiration')}}</label>
                            <br>
                            <select class="form-control pull-left m-r-20" name="inputMonth" style="width: 100px;">
                                <option value="1" selected>{{trans('payment.expiration_months.jan')}}</option>
                                <option value="2">{{trans('payment.expiration_months.feb')}}</option>
                                <option value="3">{{trans('payment.expiration_months.mar')}}</option>
                                <option value="4">{{trans('payment.expiration_months.apr')}}</option>
                                <option value="5">{{trans('payment.expiration_months.may')}}</option>
                                <option value="6">{{trans('payment.expiration_months.jun')}}</option>
                                <option value="7">{{trans('payment.expiration_months.jul')}}</option>
                                <option value="8">{{trans('payment.expiration_months.aug')}}</option>
                                <option value="9">{{trans('payment.expiration_months.sep')}}</option>
                                <option value="10">{{trans('payment.expiration_months.oct')}}</option>
                                <option value="11">{{trans('payment.expiration_months.nov')}}</option>
                                <option value="12">{{trans('payment.expiration_months.dec')}}</option>
                            </select>
                            <select class="form-control" name="inputYear" style="width: 100px;">
                                <?php $year = (int) date('Y'); ?>
                                <?php for( $i=$year; $i < ($year + 10); $i++ ): ?>
                                <option value="{{$i}}">{{$i}}</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group required">
                                <label>{{trans('payment.cvc_code')}}</label>
                                <input type="text" class="form-control" name="inputCvc" placeholder="000" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{trans('payment.coupon')}}</label>
                                <input type="text" class="form-control" name="inputCoupon" placeholder="">
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-complete btn-block btn-lg" id="btn-validate-cc" type="submit"><i class="fa fa-refresh fa-spin hidden"></i> {{trans('payment.verify_infos')}}</button>
            </form>
            <form action="/service/subscription/new/{{$plan}}" id="buy-form" method="post">
                {{csrf_field()}}
                <input type="hidden" name="token" value="">
                <button class="btn btn-success btn-lg btn-block hidden" id="btn-buy-now"><i class="fa fa-refresh fa-spin hidden"></i> {{trans('payment.pay_now')}}</button>
            </form>
        </div>
    <div>

@endsection