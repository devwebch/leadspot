@extends('layouts.app')

@section('title', 'New team member')

@section('styles')
@endsection

@section('scripts')
@endsection

@section('content')

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">Add team member</div>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-md-6">
                    @include('shared.errors')

                    <form action="/account/team/save" class="form" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group">
                            <label for="inputFirstName">First name:</label>
                            <input type="text" id="inputFirstName" name="inputFirstName" value="{{old('inputFirstName')}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputLastName">Last name:</label>
                            <input type="text" id="inputLastName" name="inputLastName" value="{{old('inputLastName')}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputEmail">E-mail:</label>
                            <input type="text" id="inputEmail" name="inputEmail" value="{{old('inputEmail')}}" class="form-control">
                        </div>
                        <a href="/account/team" class="btn btn-danger">Cancel</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection