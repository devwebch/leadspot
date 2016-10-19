@extends('layouts.app')

@section('title', 'New lead')

@section('styles')
@endsection

@section('scripts')
@endsection

@section('content')

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">Edit my informations</div>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-md-6">
                    @include('shared.errors')

                    <form action="/account/save" class="form" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group">
                            <label for="first_name">First name:</label>
                            <input type="text" id="first_name" name="first_name" value="{{old('first_name', $user->first_name)}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last name:</label>
                            <input type="text" id="last_name" name="last_name" value="{{old('last_name', $user->last_name)}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="company">Company:</label>
                            <input type="text" id="company" name="company" value="{{old('company', $user->company)}}" class="form-control">
                        </div>
                        <a href="/account" class="btn btn-danger">Cancel</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection