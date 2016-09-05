@extends('layouts.naked')

@section('title', 'Page not found')

@section('styles')
@endsection

@section('scripts')
@endsection

@section('content')
<div class="row">
    <div class="col-middle">
        <div class="text-center">
            <h1 class="error-number">404</h1>
            <h2 class="semi-bold">You have ventured too far..</h2>
            <p>Need more informations? <a href="/contact">Contact us</a>
            </p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-middle">
        <div class="text-center">
            <a href="/" class="btn btn-success" title="Go back to my Dashboard">Go back to my Dashboard</a>
        </div>
    </div>
</div>
@endsection