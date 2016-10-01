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
                            <label for="inputFirstName">First name:</label>
                            <input type="text" id="inputFirstName" name="inputFirstName" value="{{old('inputFirstName', $user->first_name)}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputLastName">Last name:</label>
                            <input type="text" id="inputLastName" name="inputLastName" value="{{old('inputLastName', $user->last_name)}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputCompany">Company:</label>
                            <input type="text" id="inputCompany" name="inputCompany" value="{{old('inputCompany', $user->company)}}" class="form-control">
                        </div>
                        <a href="/account" class="btn btn-danger">Cancel</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection