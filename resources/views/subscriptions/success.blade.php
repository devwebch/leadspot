@extends('layouts.app')

@section('title', 'Thank you')

@section('breadcrumb')
    <li><a href="/account" class="active">{{trans('breadcrumbs.my_account')}}</a></li>
@endsection

@section('styles')
@endsection

@section('scripts')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h2>Thank you!</h2>
            <p>Your subscription has been successfully added to your account.</p>
            <p><a href="/" class="btn btn-success">Go to my Dashboard</a></p>
        </div>
    </div>
@endsection