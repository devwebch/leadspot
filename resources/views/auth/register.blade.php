@extends('layouts.naked')

@section('content')

    @include('shared.errors');

    <div class="text-center">
        <img src="{{asset('img/logo-leadspot.png')}}" alt="logo" data-src="{{asset('img/logo-leadspot.png')}}" data-src-retina="{{asset('img/logo-leadspot.png')}}" width="200">
        <h3>{{trans('register.title')}}</h3>
    </div>

    <form id="form-register" class="p-t-15" role="form" method="POST" action="{{ url('/register') }}">
        {{ csrf_field() }}

        <div class="row">
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }} form-group-default">
                    <label for="first_name" class="control-label">{{trans('register.first_name')}}</label>
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
                    <label for="last_name" class="control-label">{{trans('register.last_name')}}</label>
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
            <label for="email" class="control-label">{{trans('register.email')}}</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">
            @if ($errors->has('email'))
                <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} form-group-default">
            <label for="password" class="control-label">{{trans('register.password')}}</label>
            <input id="password" type="password" class="form-control" name="password">
            @if ($errors->has('password'))
                <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} form-group-default">
            <label for="password-confirm" class="control-label">{{trans('register.confirm_password')}}</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
            @endif
        </div>

        <div class="form-group">
            <div class="checkbox">
                <input type="checkbox" value="agreed" name="terms_agree" id="terms_agree">
                <label for="terms_agree">{!! trans('register.terms_conditions', ['url' => 'http://leadspotapp.com/terms-and-conditions']) !!}</label>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-btn fa-user"></i> {{trans('register.register')}}
                </button>
            </div>
        </div>
    </form>
@endsection
