@extends('layouts.app')

@section('title', 'Edit')

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
            <div class="panel-title">{{trans('team.edit_user_infos')}}</div>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-md-6">
                    @include('shared.errors')

                    <form action="/account/team/save" class="form" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="_id" value="{{$user->id}}">
                        <div class="form-group">
                            <label for="first_name">{{trans('team.first_name')}}</label>
                            <input type="text" id="first_name" name="first_name" value="{{old('first_name', $user->first_name)}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="last_name">{{trans('team.last_name')}}</label>
                            <input type="text" id="last_name" name="last_name" value="{{old('last_name', $user->last_name)}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">{{trans('team.email')}}</label>
                            <input type="text" id="email" name="email" value="{{old('email', $user->email)}}" class="form-control">
                        </div>
                        <a href="/account/team" class="btn btn-danger">{{trans('team.cancel')}}</a>
                        <button type="submit" class="btn btn-success">{{trans('team.save')}}</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection