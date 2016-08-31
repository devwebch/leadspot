@extends('layouts.app')

@section('title', 'Search new leads')

@section('breadcrumb')
    <li><a href="/leads/search" class="active">Search leads</a></li>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select2/select2.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/map-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/alerts/sweet-alert.css')}}">
@endsection

@section('scripts')
    <script src="{{asset('assets/plugins/bootstrap-select2/select2.min.js')}}"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmuoso1k61TZCOqUdPi3E7VIl2HA2UBmA&libraries=places"></script>
    <script src="{{asset('assets/js/map-icons.js')}}"></script>
    <script src="{{asset('assets/plugins/alerts/sweet-alert.min.js')}}"></script>
    <script src="{{asset('assets/js/places.js')}}"></script>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-9">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">Search location</div>
                </div>
                <div class="panel-body">
                    <form class="wbf-location-form form-inline">
                        <div class="form-group">
                            <label for="wbfInputAddress" class="sr-only">Address</label>
                            <input type="text" name="wbfInputAddress" id="wbfInputAddress" class="form-control" placeholder="Address..." style="width: 300px">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-default" id="wbfInputGeolocation"><i class="fa fa-crosshairs"></i></button>
                        </div>
                        <button type="submit" class="btn btn-warning">Search address</button>
                    </form>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">Google Map</div>
                </div>
                <div class="panel-body">
                    <form role="form" class="wbf-search-form m-b-20">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="wbfInputText">Search</label>
                                    <input type="text" name="wbfInputText" id="wbfInputText" class="form-control" placeholder="Store name...">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="wbfInputCategory">Category</label>
                                    <select name="wbfInputCategory" id="wbfInputCategory" class="full-width"  data-init-plugin="select2">
                                        <option value="">Select a category...</option>
                                        <option value="accounting">Accounting</option>
                                        <option value="airport">Airport</option>
                                        <option value="art_gallery">Art gallery</option>
                                        <option value="bakery">Bakery</option>
                                        <option value="bar">Bar</option>
                                        <option value="beauty_salon">Beauty Salon</option>
                                        <option value="bicycle_store">Bicycle Store</option>
                                        <option value="book_store">Book Store</option>
                                        <option value="bowling_alley">Bowling Alley</option>
                                        <option value="cafe">Cafe</option>
                                        <option value="car_dealer">Car Dealer</option>
                                        <option value="car_rental">Car Rental</option>
                                        <option value="car_repair">Car Repair</option>
                                        <option value="casino">Casino</option>
                                        <option value="church">Church</option>
                                        <option value="clothing_store">Clothing Store</option>
                                        <option value="convenience_store">Convenience Store</option>
                                        <option value="dentist">Dentist</option>
                                        <option value="electrician">Electrician</option>
                                        <option value="electronics_store">Electronics Store</option>
                                        <option value="establishment">Establishment</option>
                                        <option value="finance">Finance</option>
                                        <option value="florist">Florist</option>
                                        <option value="food">Food</option>
                                        <option value="funeral_home">Funeral Home</option>
                                        <option value="furniture_store">Furniture Store</option>
                                        <option value="general_contractor">General Contractor</option>
                                        <option value="grocery_or_supermarket">Grocery or Supermarket</option>
                                        <option value="gym">Gym</option>
                                        <option value="hair_care">Hair Care</option>
                                        <option value="hardware_store">Hardware Store</option>
                                        <option value="health">Health</option>
                                        <option value="home_goods_store">Home Goods Store</option>
                                        <option value="insurance_agency">Insurence Agency</option>
                                        <option value="jewelry_store">Jewelry Store</option>
                                        <option value="laundry">Laundry</option>
                                        <option value="lawyer">Lawyer</option>
                                        <option value="library">Library</option>
                                        <option value="liquor_store">Liquor Store</option>
                                        <option value="locksmith">Locksmith</option>
                                        <option value="lodging">Lodging</option>
                                        <option value="meal_delivery">Meal Delivery</option>
                                        <option value="meal_takeaway">Meal Takeaway</option>
                                        <option value="movie_theater">Movie Theater</option>
                                        <option value="moving_company">Moving Company</option>
                                        <option value="museum">Museum</option>
                                        <option value="night_club">Night Club</option>
                                        <option value="painter">Painter</option>
                                        <option value="pet_store">Pet store</option>
                                        <option value="pharmacy">Pharmacy</option>
                                        <option value="physiotherapist">Physiotherapist</option>
                                        <option value="plumber">Plumber</option>
                                        <option value="real_estate_agency">Real Estate Agency</option>
                                        <option value="restaurant">Restaurant</option>
                                        <option value="roofing_contractor">Roofing Contractor</option>
                                        <option value="school">School</option>
                                        <option value="shoe_store">Shoe Store</option>
                                        <option value="spa">Spa</option>
                                        <option value="storage">Storage</option>
                                        <option value="store">Store</option>
                                        <option value="travel_agency">Travel Agency</option>
                                        <option value="university">University</option>
                                        <option value="veterinary_care">Veterinary Care</option>
                                        <option value="zoo">Zoo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="wbfInputRadius">Radius</label>
                                    <select name="wbfInputRadius" id="wbfInputRadius" class="form-control">
                                        <option value="50">50m</option>
                                        <option value="100">100m</option>
                                        <option value="150">150m</option>
                                        <option value="200">200m</option>
                                        <option value="300" selected>300m</option>
                                        <option value="400">400m</option>
                                        <option value="500">500m</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Search</button>
                    </form>
                    <div class="map-container">
                        <div id="map" style="height: 500px"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title"><i class="pg-map"></i> Business details</div>
                </div>
                <div class="panel-body">
                    <div class="wbf-business-details-introduction">
                        <h3>Hi there!</h3>
                        <p>Please search for a business and click analyze to get informations, lorem ipsum.</p>
                    </div>
                    <div class="wbf-business-details">
                        {{csrf_field()}}
                        <div class="wbf-business-details__title hidden">
                            <h3 class="title"></h3>
                            <p class="address"></p>
                            <p class="phone-number"></p>
                            <p><a href="#" class="website hidden" target="_blank">http://www.example.com</a></p>
                            <hr>
                        </div>
                        <div class="wbf-business-details__no-website hidden">
                            <div class="alert alert-info"><p>It looks like this business have no website.</p></div>
                        </div>
                        <div class="wbf-business-details__pagespeed hidden">
                            <h4>Pagespeed scores</h4>
                            <table class="table table-condensed">
                                <thead>
                                <tr>
                                    <th>Speed</th>
                                    <th>Usability</th>
                                </tr>
                                </thead>
                                <tr>
                                    <td><span class="score-speed label label-info">0</span><span> / 100</span></td>
                                    <td><span class="score-usability label label-info">0</span><span> / 100</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="wbf-business-details__preview hidden m-b-20">
                            <h4>Mobile preview</h4>
                            <div style="text-align: center;">
                                <img class="image" src="" alt="">
                            </div>
                        </div>
                        <div class="wbf-business-details__indicators hidden">
                            <h4>Obsolescence indicators</h4>
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th width="70%">Variable</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tr class="indicator--responsive">
                                    <td>
                                        <strong>Responsive</strong>
                                        <p class="small" style="white-space: normal">Website is adapted for mobile devices</p>
                                    </td>
                                    <td class="indicator"></td>
                                </tr>
                                <tr class="indicator--gzip">
                                    <td>
                                        <strong>GZIP</strong>
                                        <p class="small" style="white-space: normal"></p>
                                    </td>
                                    <td class="indicator"></td>
                                </tr>
                                <tr class="indicator--minify-css">
                                    <td><strong>Minified CSS</strong></td>
                                    <td class="indicator"></td>
                                </tr>
                                <tr class="indicator--minify-js">
                                    <td><strong>Minified JS</strong></td>
                                    <td class="indicator"></td>
                                </tr>
                                <tr class="indicator--minify-html">
                                    <td><strong>Minified HTML</strong></td>
                                    <td class="indicator"></td>
                                </tr>
                                <tr class="indicator--optimized-images">
                                    <td>
                                        <strong>Optimized images</strong>
                                        <p class="small" style="white-space: normal">Images sizes are optimized</p>
                                    </td>
                                    <td class="indicator"></td>
                                </tr>
                                <tr class="indicator--font-size">
                                    <td>
                                        <strong>Adapted font size</strong>
                                        <p class="small" style="white-space: normal">Font size is optimized for readability</p>
                                    </td>
                                    <td class="indicator"></td>
                                </tr>

                            </table>
                        </div>
                        <div class="wbf-business-details__add-to-list hidden">
                            <button class="btn btn-complete btn-lg btn-block btn-add-to-list">Save this lead</button>
                        </div>
                    </div>

                    <div class="wbf-business-details-progress hidden" style="text-align: center; padding: 40px 0;">
                        <div class="progress-circle-indeterminate"></div>
                        <p class="small hint-text">Loading</p>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection