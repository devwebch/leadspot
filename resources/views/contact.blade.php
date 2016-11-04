@extends('layouts.app')

@section('title', trans('contact.contact_us'))

@section('styles')
    <link rel="stylesheet" href="{{asset('plugins/jquery-metrojs/MetroJs.css')}}">
@endsection

@section('scripts')
    <script src="{{asset('plugins/jquery-metrojs/MetroJs.min.js')}}"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 m-b-10">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">

                            <h2>{{trans('contact.contact_us')}}</h2>

                            @include('shared.errors')

                            <form action="/contact/send" method="post">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="inputFirstName">{{trans('contact.first_name')}}</label>
                                    <input type="text" name="inputFirstName" id="inputFirstName" class="form-control" value="{{old('inputFirstName')}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputLastName">{{trans('contact.last_name')}}</label>
                                    <input type="text" name="inputLastName" id="inputLastName" class="form-control" value="{{old('inputLastName')}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail">{{trans('contact.email')}}</label>
                                    <input type="email" name="inputEmail" id="inputEmail" class="form-control" value="{{old('inputEmail')}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputMessage">{{trans('contact.message')}}</label>
                                    <textarea name="inputMessage" id="inputMessage" class="form-control" cols="30" rows="10">{{old('inputMessage')}}</textarea>
                                </div>

                                <button class="btn btn-success" type="submit">{{trans('contact.send')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection