@extends('layouts.app')

@section('title', trans('breadcrumbs.my_account'))

@section('breadcrumb')
    <li><a href="/account" class="active">{{trans('breadcrumbs.my_account')}}</a></li>
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
                    <h3>{{trans('account.greetings', ['firstname' => $user->first_name])}}</h3>

                    <a href="/account/edit" class="btn btn-default pull-right"><i class="fa fa-cog"></i></a>

                    <ul class="nav nav-tabs nav-tabs-top nav-tabs-simple">
                        <li class="active">
                            <a data-toggle="tab" href="#tabInfos">{{trans('account.your_informations')}}</a>
                        </li>
                        @if ( Auth::user()->subscribed('main') )
                        <li class="">
                            <a data-toggle="tab" href="#tabInvoices">{{trans('account.invoices')}}</a>
                        </li>
                        @endif
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabInfos">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="m-t-0">{{trans('account.my_account')}}</h3>

                                    <strong>{{trans('account.first_name')}}</strong>
                                    <p>{{$user->first_name}}</p>

                                    <strong>{{trans('account.last_name')}}</strong>
                                    <p>{{$user->last_name}}</p>

                                    <strong>{{trans('account.email')}}</strong>
                                    <p>{{$user->email}}</p>

                                    @if( $user->company)
                                    <strong>{{trans('account.company')}}</strong>
                                    <p>{{$user->company}}</p>
                                    @endif

                                    <h3>{{trans('account.monthly_usage')}}</h3>
                                    <strong>{{trans('account.search')}} </strong> {{$usage->search->used}} / {{$usage->search->limit}}<br>
                                    <strong>{{trans('account.contacts')}} </strong> {{$usage->contacts->used}} / {{$usage->contacts->limit}}
                                    @if ( Auth::user()->subscribed('main') == false )
                                        <div class="m-t-20 m-b-20">
                                            <a href="/account/pricing" class="btn btn-danger btn-lg">{{trans('home.go_pro_label')}}</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabInvoices">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="m-t-0">{{trans('account.invoices')}}</h3>
                                    <ul>
                                        @forelse($invoices as $invoice)
                                        <li>{{$invoice->date()->toFormattedDateString()}} - {{($invoice->total/100)}}$ | <a href="/account/invoice/{{$invoice->id}}" target="_blank">{{trans('account.download')}}</a></li>
                                        @empty
                                        <li>{{trans('account.no_invoices')}}</li>
                                        @endforelse
                                    </ul>
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