@extends('layouts.app')

@section('title', 'New lead')

@section('styles')
    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/css/summernote.css')}}">
@endsection

@section('scripts')
    <script src="{{asset('assets/plugins/summernote/js/summernote.min.js')}}"></script>
    <script src="{{asset('assets/js/widgets.js')}}"></script>
@endsection

@section('content')

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">Table</div>
        </div>
        <div class="panel-body">

            @include('shared.errors')

            <form action="/leads/store" class="form" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="_id" value="{{$lead->id}}">
                <div class="form-group">
                    <label for="leadName">Name:</label>
                    <input type="text" class="form-control" name="leadName" id="leadName" placeholder="Name" value="{{old('leadName', $lead->name)}}">
                </div>
                <div class="form-group">
                    <label for="leadAddress">Address:</label>
                    <input type="text" class="form-control" name="leadAddress" id="leadAddress" placeholder="Address" value="{{old('leadAddress', $lead->address)}}">
                </div>
                <div class="form-group">
                    <label for="leadUrl">URL:</label>
                    <input type="text" class="form-control" name="leadUrl" id="leadUrl" placeholder="URL" value="{{old('leadUrl', $lead->url)}}">
                </div>
                <div class="row hidden">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="leadLat">Latitude:</label>
                            <input type="text" class="form-control" name="leadLat" id="leadLat" value="{{old('leadLat', $lead->lat)}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="leadLng">Longitude:</label>
                            <input type="text" class="form-control" name="leadLng" id="leadLng" value="{{old('leadLng', $lead->lng)}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="leadNotes">Notes:</label>
                            <textarea name="leadNotes" id="leadNotes" class="form-control" cols="30" rows="10">{{old('leadNotes', $lead->notes)}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="leadStatus">Status:</label>
                            <select name="leadStatus" id="leadStatus" class="form-control">
                                @foreach($status as $key => $item)
                                <option value="{{$key}}" class="{{$status_classes[$key]}}" {{(old('leadStatus', $lead->status) == $key) ? 'selected' : ''}}>
                                    {{trans($item)}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-complete">{{$submit_label or 'Add new lead'}}</button>
            </form>
        </div>
    </div>

@endsection