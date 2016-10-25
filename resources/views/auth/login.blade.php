@extends('layouts.login')

@section('content')
    <form id="form-login" class="p-t-15" role="form" method="POST" action="{{ url('/login') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="control-label">{{trans('login.email_address')}}</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">
            @if ($errors->has('email'))
                <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="control-label">{{trans('login.password')}}</label>
            <input id="password" type="password" class="form-control" name="password">

            @if ($errors->has('password'))
                <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
        </div>

        <div class="form-group m-t-20">
            <div class="checkbox check-info">
                <input type="checkbox" checked="checked" value="1" id="checkbox1">
                <label for="checkbox1">{{trans('login.signed_in')}}</label>
            </div>
        </div>

        <div class="form-group m-t-20">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-btn fa-sign-in"></i> {{trans('login.login')}}
            </button>

            <a class="btn btn-link" href="{{ url('/password/reset') }}">{{trans('login.forgot_password')}}</a>
        </div>
    </form>
@endsection
