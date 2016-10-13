@extends('layouts.app')

@section('title', 'Details: ' . $lead->name)

@section('breadcrumb')
    <li><a href="/leads/list" class="">Leads</a></li>
    <li><a href="/leads/view/{lead}" class="active">Details: {{$lead->name}}</a></li>
@endsection

@section('styles')
@endsection

@section('scripts')
    @if($lead->lat && $lead->lng)
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmuoso1k61TZCOqUdPi3E7VIl2HA2UBmA&libraries=places"></script>
    <script>
        jQuery(document).ready(function ($) {

            var location_lat    = $('#location_lat').val();
            var location_lng    = $('#location_lng').val();

            // init Google Map
            var pyrmont = new google.maps.LatLng(location_lat, location_lng);
            var map = new google.maps.Map(document.getElementById('map'), {
                center: pyrmont,
                zoom: 15,
                scrollwheel: false,
                styles: [{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#b5cbe4"}]},{"featureType":"landscape","stylers":[{"color":"#efefef"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#83a5b0"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#bdcdd3"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#e3eed3"}]},{"featureType":"administrative","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"road"},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{},{"featureType":"road","stylers":[{"lightness":20}]}]
            });
            var marker = new google.maps.Marker({
                map: map,
                position: pyrmont,
                icon: {
                    url: '{{config('constants.maps.icon_blue')}}',
                    scaledSize: new google.maps.Size(22, 30),
                    size: new google.maps.Size(22, 30),
                    origin: new google.maps.Point(0,0),
                    anchor: new google.maps.Point(11, 25),
                    optimized: false
                }
            });

            $('.delete').click(function (e) {
                e.preventDefault();
                var $link   = $(this).attr('href');
                $('#myModal').modal();
                $('#myModal .continue').attr('href', $link);
            });
        });
    </script>
    @endif
@endsection

@section('content')

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">Details</div>
            <div class="btn-group pull-right m-b-10">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="/leads/edit/{{$lead->id}}">Edit</a></li>
                    <li><a href="/leads/delete/{{$lead->id}}" class="delete">Delete</a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-md-8">
                    <input type="hidden" id="location_lat" value="{{$lead->lat}}">
                    <input type="hidden" id="location_lng" value="{{$lead->lng}}">
                    <h1>{{$lead->name}}</h1>
                    <h4>{{$lead->address}}</h4>
                    @if($lead->lat && $lead->lng)
                    <div id="map" style="height: 400px;" class="m-t-20"></div>
                    @endif
                </div>
                <div class="col-md-4">
                    <h4>Details</h4>
                    <p>Status: <span class="label {{$status_classes[$lead->status]}}">{{trans($status[$lead->status])}}</span></p>
                    @if($lead->url)
                        <p>Website: <a href="{{$lead->url}}">{{$lead->url}}</a></p>
                    @endif
                    @if($lead->cms)
                        <p>CMS: {{config('constants.cms.' . $lead->cms)}}</p>
                    @endif
                    @if($lead->phone_number)
                        <p>Phone: {{$lead->phone_number}}</p>
                    @endif
                    <hr>
                    <h4>Notes</h4>
                    @if($lead->notes)
                        {{$lead->notes}}
                    @else
                        <a href="/leads/edit/{{$lead->id}}">Edit and add notes</a>
                    @endif
                    <hr>
                    <h4>Contacts</h4>
                    @if ($stored_contacts)
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="70%">E-mail</th>
                                <th>Type</th>
                                <th>Trust</th>
                            </tr>
                        </thead>
                    @foreach($lead->contacts as $contact)
                        <?php
                        $confidence         = (int) $contact->confidence;
                        $confidence_class   = 'label-info';
                        if ( $confidence >= 85 ) {
                            $confidence_class = 'label-success';
                        }
                        ?>
                        <tr>
                            <td><a href="mailto:{{$contact->email}}" style="word-break: break-all; white-space: normal;">{{$contact->email}}</a></td>
                            <td>{{config('constants.contact.type.' . $contact->type)}}</td>
                            <td><span class="label {{$confidence_class}}">{{$contact->confidence}}%</span></td>
                        </tr>
                    @endforeach
                    </table>
                    @endif

                    @if(!$stored_contacts && ($available_contacts > 0))
                        <p class="hint-text">Contacts may be available ({{$available_contacts}}), only relevant contact informations will be retrieved.</p>
                        <a href="/leads/getcontacts/{{$lead->id}}" class="btn btn-success">Fetch contacts</a>
                    @endif

                    @if(!$stored_contacts && ($available_contacts <=0))
                        <p class="hint-text">No contacts informations were found for this website.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- MODAL STICK UP  -->
    <div class="modal fade stick-up" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                        <h5>Delete this entry</h5>
                    </div>
                    <div class="modal-body">
                        <p class="no-margin">This action will delete this entry for ever.</p>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-danger btn-cons pull-left inline continue">Delete</a>
                        <button type="button" class="btn btn-default btn-cons no-margin pull-left inline" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- END MODAL STICK UP  -->

@endsection