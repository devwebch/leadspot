@extends('layouts.naked')

@section('content')
<div class="text-center">
    <img src="{{asset('assets/img/logo-leadspot.png')}}" alt="logo" data-src="{{asset('assets/img/logo-leadspot.png')}}" data-src-retina="{{asset('assets/img/logo-leadspot@2x.png')}}" width="200">
    <h3>Create a free account in one simple step.</h3>
    <p>During the beta phase, only free accounts are available. Be an early adopter and enjoy a discount when LeadSpot launches.</p>
</div>

<form id="form-register" class="p-t-15" role="form" method="POST" action="{{ url('/register') }}">
    {{ csrf_field() }}

    <div class="row">
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }} form-group-default">
                <label for="first_name" class="control-label">First name</label>
                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
                @if ($errors->has('first_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('first_name') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }} form-group-default">
                <label for="last_name" class="control-label">Last name</label>
                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
                @if ($errors->has('last_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('last_name') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} form-group-default">
        <label for="email" class="control-label">E-Mail Address</label>
        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} form-group-default">
        <label for="password" class="control-label">Password</label>
        <input id="password" type="password" class="form-control" name="password">
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} form-group-default">
        <label for="password-confirm" class="control-label">Confirm Password</label>
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
        @if ($errors->has('password_confirmation'))
            <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-btn fa-user"></i> Register
            </button>
        </div>
    </div>
</form>
@endsection
