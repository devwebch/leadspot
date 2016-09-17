@extends('layouts.app')

@section('title', 'Success')

@section('breadcrumb')
    <li><a href="/account" class="active">My account</a></li>
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