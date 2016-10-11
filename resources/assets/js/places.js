/**
 * Created by srapin on 30.07.16.
 */

var appstate              = {};
appstate.loading          = false;
appstate.loaded           = false;

var place                 = {};
var currentPlace          = {};

var analyzeModuleData   = {
    status: appstate,
    details: currentPlace,
    geolocating: false,
    permissions: {}
};

var analyzeModule = new Vue({
    el: 'body',
    data: analyzeModuleData,
    created: function () {
    }
});

(function () {
    var API_KEY             = 'AIzaSyAmuoso1k61TZCOqUdPi3E7VIl2HA2UBmA';
    var API_PAGESPEED       = 'https://www.googleapis.com/pagespeedonline/v2/runPagespeed';

    var pyrmont             = new google.maps.LatLng(46.522386, 6.628718);
    var service             = null;
    var map                 = null;
    var markers             = [];
    var searchMarkers       = [];
    var overlays            = [];
    var infoWindow          = null;
    var request             = {};
    var permissions         = {};

    /**
     * Application bootstrap
     */
    jQuery(document).ready(function ($)
    {
        // init the Gmap
        init();

        // setup AJAX requests to send the CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            }
        });

        $('.wbf-search-form').submit(function (e) {
            e.preventDefault();

            var searchText          = $('#wbfInputText').val();
            var searchCategory      = $('#wbfInputCategory').val();
            var searchRadius        = $('#wbfInputRadius').val();
            var searchGranted       = false;

            if ( searchText ) { request.name = searchText; } else { request.name = ''; }
            if ( searchCategory ) { request.types = [searchCategory]; } else { request.types = []; }
            if ( searchRadius ) { request.radius = parseInt(searchRadius); } else { request.radius = 100; }

            if (request.name || request.types.length) {
                $('.wbf-search-form .btn .fa').removeClass('hidden'); // show loading icon
                mapSearch();
            }
        });

        $('#wbfInputGeolocation').click(function (e) {
            analyzeModuleData.geolocating = true;
            tryAutoGeoLocation();
        });

        $('#wbfInputRadius').change(function (e) {
            var radius = (parseInt($(this).val()));
            request.radius = radius;
            showRadius(request.location, radius);

            if ( radius < 150 ) {
                map.setZoom(17);
            } else if ( radius < 500 ) {
                map.setZoom(15);
            } else if ( radius <= 900 ) {
                map.setZoom(14);
            } else if ( radius <= 2000 ) {
                map.setZoom(13);
            }
        });

        $('.wbf-location-form').submit(function (e) {
            e.preventDefault();
            var address = $('#wbfInputAddress').val();
            if (address) { geoCodeAddress(address); }
        });

        $('.btn-add-to-list').click(function (e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '/service/leads/save',
                data: currentPlace,
                success: function (data) {
                    // success alert
                    swal({ title: "Saved!", text: "The lead was added to your list.", type: "success", timer: 3000 });
                },
                error: function (jqXHR, textStatus) {
                    swal({ title: "Error", text: "Something went wrong, please try again later.", type: "error", timer: 3000 });
                }
            });
        });

        // retrieve permissions
        $.ajax({
            type: 'POST',
            url: '/service/subscription/permissions',
            success: function (data) {
                permissions = data;
                analyzeModuleData.permissions = permissions;
                console.log('permissions', permissions);
            }
        });

    });

    /**
     * Initialize the Map
     */
    function init()
    {
        // set the default Map request
        request = {
            location: pyrmont,
            radius: 300,
            types: ['store']
        };

        // init Google Map
        map = new google.maps.Map(document.getElementById('map'), {
            center: pyrmont,
            zoom: 15,
            scrollwheel: false,
            styles: [{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#b5cbe4"}]},{"featureType":"landscape","stylers":[{"color":"#efefef"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#83a5b0"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#bdcdd3"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#e3eed3"}]},{"featureType":"administrative","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"road"},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{},{"featureType":"road","stylers":[{"lightness":20}]}]
        });

        // init the InfoWindow
        infoWindow  = new google.maps.InfoWindow({ content: '' });

        // add search point on click
        google.maps.event.addListener(map, 'click', function (event) {
            var position = event.latLng;
            addSearchMarker(position);
        });

        // add the initial search Marker
        addSearchMarker(request.location);

        // auto geolocation
        if (permissions.auto_geolocation) {
            tryAutoGeoLocation();
        }
    }

    /**
     * Request the Places API using the request object
     * Google Places API limit results to 20 establishments
     */
    function mapSearch()
    {
        // reset the markers
        clearPlaces();

        // Create the PlaceService and send the request.
        // Handle the callback with an anonymous function.
        service = new google.maps.places.PlacesService(map);
        service.radarSearch(request, function(results, status) {
            $('.wbf-search-form .btn .fa').addClass('hidden'); // hide loading icon

            // no results
            if (status == google.maps.places.PlacesServiceStatus.ZERO_RESULTS) {
                swal({title: "No results", text: "Sorry but we did not find any results.", type: "warning"});
            }
            // yup there's results
            if (status == google.maps.places.PlacesServiceStatus.OK) {
                for (var i = 0; i < results.length; i++) {
                    var place = results[i];
                    addPlaceMarker(place);
                }
                addSearchMarker(request.location);
                showRadius(request.location, request.radius);
            }
        });
    }

    /**
     * Add a marker on the Map using a place object
     * Handles the display of the InfoWindow for each marker
     * @param place
     */
    function addPlaceMarker(placeData)
    {
        var marker = new Marker({
            map: map,
            position: placeData.geometry.location,
            title: placeData.name,
            id: placeData.id,
            place_id: placeData.place_id,
            vicinity: placeData.vicinity,
            types: placeData.types,
            permanently_closed: placeData.permanently_closed,
            icon: {
                url: '../img/icn_pin_blue.png',
                scaledSize: new google.maps.Size(22, 30),
                size: new google.maps.Size(22, 30),
                origin: new google.maps.Point(0,0),
                anchor: new google.maps.Point(11, 25),
                optimized: false
            }
        });

        // add the marker for future reinitialisation
        markers.push(marker);

        // marker click handler
        marker.addListener('click', function () {

            // close any existing window and open a new one
            infoWindow.close();
            infoWindow  = new google.maps.InfoWindow();

            service.getDetails(placeData, function(result, status){
                if (status !== google.maps.places.PlacesServiceStatus.OK) {
                    return;
                }

                place.place_id                   = result.place_id;
                place.name                       = result.name;
                place.website                    = result.website;
                place.formatted_address          = result.formatted_address;
                place.formatted_phone_number     = result.formatted_phone_number;
                place.formatted_address          = result.formatted_address;
                place.formatted_address          = result.formatted_address;
                place.lat                        = result.geometry.location.lat;
                place.lng                        = result.geometry.location.lng;
                place.cms                        = null;
                place.cmsID                      = null;

                place.stats  = {};

                infoWindow.setContent('<div id="content">'+
                    '<h3 id="firstHeading" class="firstHeading">' + result.name + '</h3>'+
                    '<div id="bodyContent">'+
                    '<p>' + result.formatted_address + '</p>'+
                    '<p><a href="#" class="btn btn-primary btn-analyze" data-id="' + result.place_id + '">Run analysis</a></p>'+
                    '</div>'+
                    '</div>');

                infoWindow.open(map, marker);

                // btn Analyze click handler
                $('.btn-analyze').on('click', function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: '/service/subscription/usageGranted',
                        method: 'POST',
                        data: {update: true}
                    }).done(function (data) {
                        var analyzeGranted = false;
                        if ( data == true ) { analyzeGranted = true; }

                        if (analyzeGranted) {
                            analyze(place);
                        } else {
                            swal("Error", "You have reached the daily limit of your subscription", "error");
                        }
                    });

                });
            });
        });
    }

    /**
     * Add a Search Marker, defining the base location for any research
     * @param position
     */
    function addSearchMarker(position)
    {
        if (searchMarkers.length) {
            searchMarkers.forEach(function (marker) {
                marker.setMap(null);
            });
            searchMarkers = [];
        }

        var marker = new google.maps.Marker({
            map: map,
            position: position,
            draggable: true,
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                scale: 8,
                fillColor: '#b94b68',
                fillOpacity: 1,
                strokeColor: '#fff',
                strokeOpacity: 1,
                strokeWeight: 4
            }
        });

        // if the marker is being moved, clear everything
        marker.addListener('dragstart', function () {
            hideRadius();
            clearPlaces();
        });

        // when the marker is placed on the map, redefine search parameters
        marker.addListener('dragend', function () {
            setSearchLocation(marker.position);
        });

        searchMarkers.push(marker);
        setSearchLocation(marker.position);
    }

    /**
     * Analyze a place using its ID, perfom multiple operations
     * Handles the display of informations
     * @param placeID
     */
    function analyze(placeToAnalyze)
    {
        appstate.loading    = true;
        appstate.loaded     = false;

        currentPlace        = {};
        currentPlace        = jQuery.extend({}, place);

        var place_website_encoded   = encodeURI(currentPlace.website);

        var API_URL = API_PAGESPEED + '?url=' + place_website_encoded + '&screenshot=true&strategy=mobile&key=' + API_KEY;

        if (currentPlace.website) {

            // Run PageSpeed analysis
            $.getJSON(API_URL, function (data) {
                appstate.loaded           = true;
                appstate.loading          = false;

                currentPlace.page_title         = data.title;
                currentPlace.score_screenshot   = data.screenshot.data;

                currentPlace.stats.score_speed          = data.ruleGroups.SPEED.score;
                currentPlace.stats.score_usability      = data.ruleGroups.USABILITY.score;
                currentPlace.stats.total_request_bytes  = data.pageStats.totalRequestBytes;
                currentPlace.stats.num_js_ressources    = data.pageStats.numberJsResources;
                currentPlace.stats.num_css_ressources   = data.pageStats.numberCssResources;

                currentPlace.score_screenshot = currentPlace.score_screenshot.replace(/_/g, '/');
                currentPlace.score_screenshot = currentPlace.score_screenshot.replace(/-/g, '+');
                currentPlace.score_screenshot = 'data:image/jpeg;base64,' + currentPlace.score_screenshot;

                Vue.set(analyzeModuleData, 'details', currentPlace);

                analyzeObsolescenceIndicators(data.formattedResults.ruleResults);
            }).fail(function () {
                // impossible to fetch data: may be a DNS related error
                swal("Sorry", "Something went wrong during the analysis, please try again later.", "error");

                appstate.loading = false;
                appstate.loaded = false;
            });

            if ( permissions.cms ) {
                $.ajax({
                    url: '/service/leads/getcms',
                    method: 'POST',
                    data: { 'url': currentPlace.website },
                    success: function (data) {
                        var cmsInfos    = JSON.parse(data);
                        var cms         = cmsInfos.cms;
                        var cmsID       = cmsInfos.id;

                        if (!cms) {
                            cms         = null;
                            cmsInfos    = null;
                        }

                        currentPlace.cms    = cms;
                        currentPlace.cmsID  = cmsID;
                    }
                });
            }

        } else {
            Vue.set(analyzeModuleData, 'details', currentPlace);

            appstate.loaded     = true;
            appstate.loading    = false;
        }

    }

    /**
     * Analyze the rules returned by PageSpeed
     */
    function analyzeObsolescenceIndicators(results)
    {
        currentPlace.indicators                 = {};
        currentPlace.indicators.viewport        = results.ConfigureViewport.ruleImpact;
        currentPlace.indicators.gzip            = results.EnableGzipCompression.ruleImpact;
        currentPlace.indicators.minifyCss       = results.MinifyCss.ruleImpact;
        currentPlace.indicators.minifyJs        = results.MinifyJavaScript.ruleImpact;
        currentPlace.indicators.minifyHTML      = results.MinifyHTML.ruleImpact;
        currentPlace.indicators.optimizeImages  = results.OptimizeImages.ruleImpact;
        currentPlace.indicators.fontSize        = results.UseLegibleFontSizes.ruleImpact;

        Vue.set(analyzeModuleData.details, 'indicators', currentPlace.indicators);
    }

    /**
     * Pinpoint the user's location using HTML geolocation sensor
     * @requires: SSL certificate
     */
    function tryAutoGeoLocation()
    {
        // Try HTML5 geolocation.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                infoWindow.setPosition(pos);
                infoWindow.setContent('Location found.');
                map.setCenter(pos);
                addSearchMarker(pos);
                analyzeModuleData.geolocating = false;
            }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
            analyzeModuleData.geolocating = false;
        }
    }

    /**
     * Handles location errors
     * @param browserHasGeolocation
     * @param infoWindow
     * @param pos
     */
    function handleLocationError(browserHasGeolocation, infoWindow, pos)
    {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
    }

    /**
     * Set the search location using a location object
     * @param location
     */
    function setSearchLocation(location)
    {
        request.location = location;
        map.setCenter(location);
        showRadius(location, request.radius);
    }

    /**
     * Encode a textual address and return a location object
     * @param address
     */
    function geoCodeAddress(address)
    {
        if (address) {
            var geoCoder    = new google.maps.Geocoder();

            geoCoder.geocode({'address': address}, function (results, status) {
                if ( status === google.maps.GeocoderStatus.OK ) {

                    var location            = results[0].geometry.location;
                    var formatted_address   = results[0].formatted_address;

                    map.setCenter(location);
                    request.location = location;
                    addSearchMarker(location);

                    $('#wbfInputAddress').val(formatted_address);
                } else {
                    console.log('Geocode was unable to geocode: ' + status);
                }
            });
        }
    }

    /**
     * Handles the display of the search radius
     * @param position
     * @param radius
     */
    function showRadius(position, radius)
    {
        if (overlays.length) {
            overlays.forEach(function (overlay) {
                overlay.setMap(null);
            });
            overlays = [];
        }

        var radiusMultiplier    = 1.5;
        var circleOverlay       = new google.maps.Circle({
            strokeColor: '#0784bd',
            strokeOpacity: 0,
            strokeWeight: 1,
            fillColor: '#00afff',
            fillOpacity: 0.15,
            map: map,
            center: position,
            clickable: false,
            radius: radius * radiusMultiplier
        });

        overlays.push(circleOverlay);
    }

    /**
     * Remove radiuses
     */
    function hideRadius()
    {
        if (overlays.length) {
            overlays.forEach(function (overlay) {
                overlay.setMap(null);
            });
            overlays = [];
        }
    }

    /**
     * Remove every places pins
     */
    function clearPlaces()
    {
        // reset the markers
        if (markers.length) {
            markers.forEach(function (marker) { marker.setMap(null); });
            markers = [];
        }
    }

}());

