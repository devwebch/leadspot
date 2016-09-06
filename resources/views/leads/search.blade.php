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
    <script>
        var constants = {
            maps: {
                icon: '{{config('constants.maps.icon_blue')}}'
            }
        };
    </script>
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
                            <button class="btn btn-default" id="wbfInputGeolocation" type="button"><i class="fa fa-crosshairs"></i></button>
                        </div>
                        <button type="submit" class="btn btn-warning">Search address</button>
                    </form>
                    <div class="m-t-20" v-show="geolocating">
                        <i class="fa fa-refresh fa-spin m-r-10"></i> Searching for your location...
                    </div>
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
                                        <option value="">{{trans('search.general.select_category')}}</option>
                                        <option value="accounting">{{trans('search.categories.accounting')}}</option>
                                        <option value="airport">{{trans('search.categories.airport')}}</option>
                                        <option value="art_gallery">{{trans('search.categories.art_gallery')}}</option>
                                        <option value="bakery">{{trans('search.categories.bakery')}}</option>
                                        <option value="bar">{{trans('search.categories.bar')}}</option>
                                        <option value="beauty_salon">{{trans('search.categories.beauty_salon')}}</option>
                                        <option value="bicycle_store">{{trans('search.categories.bicycle_store')}}</option>
                                        <option value="book_store">{{trans('search.categories.book_store')}}</option>
                                        <option value="bowling_alley">{{trans('search.categories.bowling_alley')}}</option>
                                        <option value="cafe">{{trans('search.categories.cafe')}}</option>
                                        <option value="car_dealer">{{trans('search.categories.car_dealer')}}</option>
                                        <option value="car_rental">{{trans('search.categories.car_rental')}}</option>
                                        <option value="car_repair">{{trans('search.categories.car_repair')}}</option>
                                        <option value="casino">{{trans('search.categories.casino')}}</option>
                                        <option value="church">{{trans('search.categories.church')}}</option>
                                        <option value="clothing_store">{{trans('search.categories.clothing_store')}}</option>
                                        <option value="convenience_store">{{trans('search.categories.convenience_store')}}</option>
                                        <option value="dentist">{{trans('search.categories.dentist')}}</option>
                                        <option value="electrician">{{trans('search.categories.electrician')}}</option>
                                        <option value="electronics_store">{{trans('search.categories.electronics_store')}}</option>
                                        <option value="establishment">{{trans('search.categories.establishment')}}</option>
                                        <option value="finance">{{trans('search.categories.finance')}}</option>
                                        <option value="florist">{{trans('search.categories.florist')}}</option>
                                        <option value="food">{{trans('search.categories.food')}}</option>
                                        <option value="funeral_home">{{trans('search.categories.funeral_home')}}</option>
                                        <option value="furniture_store">{{trans('search.categories.furniture_store')}}</option>
                                        <option value="general_contractor">{{trans('search.categories.general_contractor')}}</option>
                                        <option value="grocery_or_supermarket">{{trans('search.categories.grocery_or_supermarket')}}</option>
                                        <option value="gym">{{trans('search.categories.gym')}}</option>
                                        <option value="hair_care">{{trans('search.categories.hair_care')}}</option>
                                        <option value="hardware_store">{{trans('search.categories.hardware_store')}}</option>
                                        <option value="health">{{trans('search.categories.health')}}</option>
                                        <option value="home_goods_store">{{trans('search.categories.home_goods_store')}}</option>
                                        <option value="insurance_agency">{{trans('search.categories.insurance_agency')}}</option>
                                        <option value="jewelry_store">{{trans('search.categories.jewelry_store')}}</option>
                                        <option value="laundry">{{trans('search.categories.laundry')}}</option>
                                        <option value="lawyer">{{trans('search.categories.lawyer')}}</option>
                                        <option value="library">{{trans('search.categories.library')}}</option>
                                        <option value="liquor_store">{{trans('search.categories.liquor_store')}}</option>
                                        <option value="locksmith">{{trans('search.categories.locksmith')}}</option>
                                        <option value="lodging">{{trans('search.categories.lodging')}}</option>
                                        <option value="meal_delivery">{{trans('search.categories.meal_delivery')}}</option>
                                        <option value="meal_takeaway">{{trans('search.categories.meal_takeaway')}}</option>
                                        <option value="movie_theater">{{trans('search.categories.movie_theater')}}</option>
                                        <option value="moving_company">{{trans('search.categories.moving_company')}}</option>
                                        <option value="museum">{{trans('search.categories.museum')}}</option>
                                        <option value="night_club">{{trans('search.categories.night_club')}}</option>
                                        <option value="painter">{{trans('search.categories.painter')}}</option>
                                        <option value="pet_store">{{trans('search.categories.pet_store')}}</option>
                                        <option value="pharmacy">{{trans('search.categories.pharmacy')}}</option>
                                        <option value="physiotherapist">{{trans('search.categories.physiotherapist')}}</option>
                                        <option value="plumber">{{trans('search.categories.plumber')}}</option>
                                        <option value="real_estate_agency">{{trans('search.categories.real_estate_agency')}}</option>
                                        <option value="restaurant">{{trans('search.categories.restaurant')}}</option>
                                        <option value="roofing_contractor">{{trans('search.categories.roofing_contractor')}}</option>
                                        <option value="school">{{trans('search.categories.school')}}</option>
                                        <option value="shoe_store">{{trans('search.categories.shoe_store')}}</option>
                                        <option value="spa">{{trans('search.categories.spa')}}</option>
                                        <option value="storage">{{trans('search.categories.storage')}}</option>
                                        <option value="store">{{trans('search.categories.store')}}</option>
                                        <option value="travel_agency">{{trans('search.categories.travel_agency')}}</option>
                                        <option value="university">{{trans('search.categories.university')}}</option>
                                        <option value="veterinary_care">{{trans('search.categories.veterinary_care')}}</option>
                                        <option value="zoo">{{trans('search.categories.zoo')}}</option>
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
                                        <option value="600">600m</option>
                                        <option value="700">700m</option>
                                        <option value="800">800m</option>
                                        <option value="900">900m</option>
                                        <option value="1000">1000m</option>
                                        <option value="2000">2000m</option>
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
                <div class="panel-body" id="analyze">
                    <div class="wbf-business-details-introduction" v-show="!details.name">
                        <h3>How do I start?</h3>
                        <p><strong>Locate the area</strong> in which you would like to start search, either by typing a <strong>city name</strong> or <strong>clicking on the map</strong>.</p>
                        <p>Then you may search by <strong>business name</strong> directly or select a <strong>category</strong> of business and a <strong>search radius</strong>.</p>
                        <p>By clicking on icons you will have basic informations about the business, you will then be able to <strong>perform an analysis</strong> of their web presence.</p>
                    </div>

                    <div class="wbf-business-details">
                        {{csrf_field()}}

                        <div class="wbf-business-details__title" v-show="status.loaded">
                            <h3>@{{ details.name }}</h3>
                            <p v-if="details.formatted_address">@{{ details.formatted_address }}</p>
                            <p v-if="details.formatted_phone_number">@{{ details.formatted_phone_number }}</p>
                            <p v-if="details.website"><a href="@{{ details.website }}" class="website" target="_blank">@{{ details.website }}</a></p>
                            <hr>
                        </div>

                        <div class="wbf-business-details__no-website" v-show="status.loaded && !details.website && details.name">
                            <div class="alert alert-info"><p>It looks like this business have no website.</p></div>
                        </div>

                        <div class="wbf-business-details__pagespeed" v-show="status.loaded && details.website">
                            <h4>Pagespeed scores</h4>
                            <table class="table table-condensed">
                                <thead>
                                <tr>
                                    <th>Speed</th>
                                    <th>Usability</th>
                                </tr>
                                </thead>
                                <tr>
                                    <td><span class="label label-info">@{{ details.stats.score_speed }}</span><span> / 100</span></td>
                                    <td><span class="label label-info">@{{ details.stats.score_usability }}</span><span> / 100</span></td>
                                </tr>
                            </table>
                        </div>

                        <div class="wbf-website-cms" v-show="status.loaded && details.website && details.cms">
                            <h4>CMS</h4>
                            <div class="text-center">
                                <div>
                                    <img src="{{asset('assets/img/logo_drupal.png')}}" alt="Drupal" v-show="details.cmsID=='drupal'">
                                    <img src="{{asset('assets/img/logo_expressionengine.png')}}" alt="ExpressionEngine" v-show="details.cmsID=='expressionengine'">
                                    <img src="{{asset('assets/img/logo_joomla.png')}}" alt="Joomla!" v-show="details.cmsID=='joomla'">
                                    <img src="{{asset('assets/img/logo_liferay.png')}}" alt="LifeRay" v-show="details.cmsID=='liferay'">
                                    <img src="{{asset('assets/img/logo_magento.png')}}" alt="Magento" v-show="details.cmsID=='magento'">
                                    <img src="{{asset('assets/img/logo_sitecore.png')}}" alt="SiteCore" v-show="details.cmsID=='sitecore'">
                                    <img src="{{asset('assets/img/logo_typo3.png')}}" alt="Typo3" v-show="details.cmsID=='typo3'">
                                    <img src="{{asset('assets/img/logo_vbulletin.png')}}" alt="vBulletin" v-show="details.cmsID=='vbulletin'">
                                    <img src="{{asset('assets/img/logo_wordpress.png')}}" alt="WordPress" v-show="details.cmsID=='wordpress'">
                                </div>
                                <strong class="m-t-10">@{{ details.cms }}</strong>
                            </div>
                        </div>

                        <div class="wbf-business-details__preview m-b-20" v-if="status.loaded && details.score_screenshot">
                            <h4>Mobile preview</h4>
                            <div style="text-align: center;">
                                <img class="image" v-bind:src="details.score_screenshot" alt="">
                            </div>
                        </div>

                        <div class="wbf-business-details__indicators" v-show="status.loaded && details.website">
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
                                    <td>
                                        <span class="label label-success" v-if="details.indicators.viewport==0">Yes</span>
                                        <span class="label label-danger" v-else>No</span>
                                    </td>
                                </tr>
                                <tr class="indicator--gzip">
                                    <td>
                                        <strong>GZIP</strong>
                                        <p class="small" style="white-space: normal"></p>
                                    </td>
                                    <td>
                                        <span class="label label-success" v-if="details.indicators.gzip==0">Yes</span>
                                        <span class="label label-danger" v-else>No</span>
                                    </td>
                                </tr>
                                <tr class="indicator--minify-css">
                                    <td><strong>Minified CSS</strong></td>
                                    <td>
                                        <span class="label label-success" v-if="details.indicators.minifyCss==0">Yes</span>
                                        <span class="label label-danger" v-else>No</span>
                                    </td>
                                </tr>
                                <tr class="indicator--minify-js">
                                    <td><strong>Minified JS</strong></td>
                                    <td>
                                        <span class="label label-success" v-if="details.indicators.minifyJs==0">Yes</span>
                                        <span class="label label-danger" v-else>No</span>
                                    </td>
                                </tr>
                                <tr class="indicator--minify-html">
                                    <td><strong>Minified HTML</strong></td>
                                    <td>
                                        <span class="label label-success" v-if="details.indicators.minifyHTML==0">Yes</span>
                                        <span class="label label-danger" v-else>No</span>
                                    </td>
                                </tr>
                                <tr class="indicator--optimized-images">
                                    <td>
                                        <strong>Optimized images</strong>
                                        <p class="small" style="white-space: normal">Images sizes are optimized</p>
                                    </td>
                                    <td>
                                        <span class="label label-success" v-if="details.indicators.optimizeImages==0">Yes</span>
                                        <span class="label label-danger" v-else>No</span>
                                    </td>
                                </tr>
                                <tr class="indicator--font-size">
                                    <td>
                                        <strong>Adapted font size</strong>
                                        <p class="small" style="white-space: normal">Font size is optimized for readability</p>
                                    </td>
                                    <td>
                                        <span class="label label-success" v-if="details.indicators.fontSize==0">Yes</span>
                                        <span class="label label-danger" v-else>No</span>
                                    </td>
                                </tr>

                            </table>
                        </div>

                        <div class="wbf-business-details__add-to-list" v-show="status.loaded">
                            <button class="btn btn-complete btn-lg btn-block btn-add-to-list">Save this lead</button>
                        </div>
                    </div>

                    <div class="wbf-business-details-progress" style="text-align: center; padding: 40px 0;" v-show="status.loading">
                        <div class="progress-circle-indeterminate"></div>
                        <p class="small hint-text">Loading</p>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection