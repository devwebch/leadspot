/**
 * Created by srapin on 30.07.16.
 */

var appstate                        = {};
appstate.loading                    = false;
appstate.loaded                     = false;

var place                           = {};
place.stats                         = {};
place.indicators                    = {};

var analyzeModuleData   = {
    status: appstate,
    details: place,
    geolocating: false
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

            if ( searchText ) { request.name = searchText; } else { request.name = ''; }
            if ( searchCategory ) { request.types = [searchCategory]; } else { request.types = []; }
            if ( searchRadius ) { request.radius = parseInt(searchRadius); } else { request.radius = 100; }

            if (request.name || request.types.length) {
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
            console.info(radius);
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
            var address          = $('#wbfInputAddress').val();
            if (address) { geoCodeAddress(address); }
        });

        $('.btn-add-to-list').click(function (e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '/service/leads/save',
                data: place,
                success: function (data) {
                    // success alert
                    swal({ title: "Saved!", text: "The lead was added to your list.", type: "success", timer: 3000 });
                }
            });
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

        //tryAutoGeoLocation();
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
    function addPlaceMarker(place)
    {
        var marker = new Marker({
            map: map,
            position: place.geometry.location,
            title: place.name,
            id: place.id,
            place_id: place.place_id,
            vicinity: place.vicinity,
            types: place.types,
            permanently_closed: place.permanently_closed,
            icon: {
                url: constants.maps.icon,
                size: new google.maps.Size(24, 30),
                origin: new google.maps.Point(0,0),
                anchor: new google.maps.Point(10, 25)
            }
        });

        // add the marker for future reinitialisation
        markers.push(marker);

        // marker click handler
        marker.addListener('click', function () {

            // close any existing window and open a new one
            infoWindow.close();
            infoWindow  = new google.maps.InfoWindow();

            service.getDetails(place, function(result, status){
                if (status !== google.maps.places.PlacesServiceStatus.OK) {
                    return;
                }

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
                    var placeID = $(this).attr('data-id');
                    analyze(placeID);
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
                url: '/assets/img/icn_up_circle_arrow.png',
                size: new google.maps.Size(20, 20),
                origin: new google.maps.Point(0,0),
                anchor: new google.maps.Point(10, 10)
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
    function analyze(placeID)
    {
        appstate.loading    = true;
        appstate.loaded     = false;

        // Get Places details
        service.getDetails({placeId: placeID}, function (placeResult, placesServiceStatus) {
            if (placesServiceStatus == google.maps.places.PlacesServiceStatus.OK) {

                Vue.set(analyzeModuleData.details, 'id', placeResult.place_id);
                Vue.set(analyzeModuleData.details, 'name', placeResult.name);
                Vue.set(analyzeModuleData.details, 'rating', placeResult.rating);
                Vue.set(analyzeModuleData.details, 'website', placeResult.website);
                Vue.set(analyzeModuleData.details, 'google_page', placeResult.url);
                Vue.set(analyzeModuleData.details, 'opening_hours', placeResult.opening_hours);
                Vue.set(analyzeModuleData.details, 'formatted_address', placeResult.formatted_address);
                Vue.set(analyzeModuleData.details, 'formatted_phone_number', placeResult.formatted_phone_number);
                Vue.set(analyzeModuleData.details, 'lat', placeResult.geometry.location.lat);
                Vue.set(analyzeModuleData.details, 'lng', placeResult.geometry.location.lng);

                var place_website_encoded   = encodeURI(place.website);

                var API_URL = API_PAGESPEED + '?url=' + place_website_encoded + '&screenshot=true&strategy=mobile&key=' + API_KEY;

                if (place.website) {

                    // Run PageSpeed analysis
                    $.getJSON(API_URL, function (data) {
                        appstate.loaded           = true;
                        appstate.loading          = false;

                        Vue.set(analyzeModuleData.details, 'page_title', data.title);
                        Vue.set(analyzeModuleData.details, 'score_screenshot', data.screenshot.data);

                        Vue.set(analyzeModuleData.details.stats, 'score_speed', data.ruleGroups.SPEED.score);
                        Vue.set(analyzeModuleData.details.stats, 'score_usability', data.ruleGroups.USABILITY.score);
                        Vue.set(analyzeModuleData.details.stats, 'total_request_bytes', data.pageStats.totalRequestBytes);
                        Vue.set(analyzeModuleData.details.stats, 'num_js_ressources', data.pageStats.numberJsResources);
                        Vue.set(analyzeModuleData.details.stats, 'num_css_ressources', data.pageStats.numberCssResources);

                        analyzeModuleData.details.score_screenshot = analyzeModuleData.details.score_screenshot.replace(/_/g, '/');
                        analyzeModuleData.details.score_screenshot = analyzeModuleData.details.score_screenshot.replace(/-/g, '+');
                        analyzeModuleData.details.score_screenshot = 'data:image/jpeg;base64,' + analyzeModuleData.details.score_screenshot;

                        analyzeObsolescenceIndicators(data.formattedResults.ruleResults);

                    });
                } else {
                    analyzeModuleData.details.indicators        = {};
                    analyzeModuleData.details.stats             = {};
                    analyzeModuleData.details.page_title        = '';
                    analyzeModuleData.details.score_screenshot  = '';

                    appstate.loaded     = true;
                    appstate.loading    = false;
                }

            } else {
                appstate.loading = false;
                console.log('No Places informations available.');
            }
        });
    }

    /**
     * Analyze the rules returned by PageSpeed
     */
    function analyzeObsolescenceIndicators(results)
    {
        Vue.set(analyzeModuleData.details, 'indicators', {});
        Vue.set(analyzeModuleData.details.indicators, 'viewport', results.ConfigureViewport.ruleImpact);
        Vue.set(analyzeModuleData.details.indicators, 'gzip', results.EnableGzipCompression.ruleImpact);
        Vue.set(analyzeModuleData.details.indicators, 'minifyCss', results.MinifyCss.ruleImpact);
        Vue.set(analyzeModuleData.details.indicators, 'minifyJs', results.MinifyJavaScript.ruleImpact);
        Vue.set(analyzeModuleData.details.indicators, 'minifyHTML', results.MinifyHTML.ruleImpact);
        Vue.set(analyzeModuleData.details.indicators, 'optimizeImages', results.OptimizeImages.ruleImpact);
        Vue.set(analyzeModuleData.details.indicators, 'fontSize', results.UseLegibleFontSizes.ruleImpact);
    }

    /**
     * Pinpoint the user's location using HTML geolocation sensor
     * @requires: SSL certificate
     */
    function tryAutoGeoLocation()
    {
        console.info('try geolocation');
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

