@extends('layouts.app')

@section('title', 'Admin')

@section('breadcrumb')
    <li><a href="/admin" class="active">Admin</a></li>
@endsection

@section('styles')
@endsection

@section('scripts')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 m-b-10">
            <div class="panel">
                <div class="panel-body">
                    <h3>Hello {{$user->first_name}}</h3>
                    <ul>
                        <li><a href="/admin/accounts">Accounts</a></li>
                        <li><a href="/admin/subscriptions">Subscriptions</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection