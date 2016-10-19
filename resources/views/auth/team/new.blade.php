@extends('layouts.app')

@section('title', 'New team member')

@section('breadcrumb')
    <li><a href="/account/team" class="active">{{trans('breadcrumbs.team')}}</a></li>
@endsection

@section('styles')
@endsection

@section('scripts')
@endsection

@section('content')

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">{{trans('team.new_team_member')}}</div>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-md-6">
                    @include('shared.errors')

                    <form id="form-register" class="p-t-15" role="form" method="POST" action="/account/team/new/save">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }} form-group-default">
                                    <label for="first_name"
                                           class="control-label">{{trans('register.first_name')}}</label>
                                    <input id="first_name" type="text" class="form-control" name="first_name"
                                           value="{{ old('first_name') }}">
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
                                    <input id="last_name" type="text" class="form-control" name="last_name"
                                           value="{{ old('last_name') }}">
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
                            <label for="password-confirm"
                                   class="control-label">{{trans('register.confirm_password')}}</label>
                            <input id="password-confirm" type="password" class="form-control"
                                   name="password_confirmation">
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-complete btn-lg btn-block">
                                    <i class="fa fa-btn fa-user"></i> {{trans('register.register')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection