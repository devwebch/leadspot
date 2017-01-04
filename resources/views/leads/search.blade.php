@extends('layouts.app')

@section('title', trans('search.general.search_new_leads'))

@section('breadcrumb')
    <li><a href="/leads/search" class="active">{{trans('breadcrumbs.search_leads')}}</a></li>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('plugins/bootstrap-select2/select2.css')}}">
    <link rel="stylesheet" href="{{asset('css/map-icons.css')}}">
    @if( $tour )
        <link rel="stylesheet" href="{{asset('css/shepherd-theme-arrow.css')}}" />
    @endif
@endsection

@section('scripts')
    <script>
        var constants = {
            maps: {
                icon: '{{config('constants.maps.icon_blue')}}'
            }
        };
        var translations = {
            general: {
                run_analysis: "{!! trans('search.general.run_analysis') !!}"
            },
            swal: {
                saved: "{!! trans('search.swal.saved') !!}",
                error: "{!! trans('search.swal.error') !!}",
                no_results: "{!! trans('search.swal.no_results') !!}",
                sorry: "{!! trans('search.swal.sorry') !!}",
                generic_error: "{!! trans('search.swal.generic_error') !!}",
                default_location_set: "{!! trans('search.swal.default_location_set') !!}",
                lead_added: "{!! trans('search.swal.lead_added') !!}",
                no_results_msg: "{!! trans('search.swal.no_results_msg') !!}",
                monthly_limit: "{!! trans('search.swal.monthly_limit') !!}",
                analysis_error: "{!! trans('search.swal.analysis_error') !!}"
            }
        };
        var user = {
            id: "{{Auth::user()->id}}",
            email: "{{Auth::user()->email}}"
        };
    </script>
    <script src="{{asset('plugins/bootstrap-select2/select2.min.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmuoso1k61TZCOqUdPi3E7VIl2HA2UBmA&signed_in=true&libraries=places"></script>
    <script src="{{asset('js/map-icons.js')}}"></script>
    <script src="https://cdn.ravenjs.com/3.7.0/raven.min.js"></script>
    <script src="{{elixir('js/places.js')}}"></script>
    @if( $tour )
        <script>
            var tourConfig = {tour: 'search'};
            var tourI18n = {
                button_text: "{!! trans('tour.general.button_text') !!}",
                search_1_title: "{!! trans('tour.search.search_1_title') !!}",
                search_1_text: "{!! trans('tour.search.search_1_text') !!}",
                search_2_title: "{!! trans('tour.search.search_2_title') !!}",
                search_2_text: "{!! trans('tour.search.search_2_text') !!}",
                search_3_title: "{!! trans('tour.search.search_3_title') !!}",
                search_3_text: "{!! trans('tour.search.search_3_text') !!}",
                search_4_title: "{!! trans('tour.search.search_4_title') !!}",
                search_4_text: "{!! trans('tour.search.search_4_text') !!}",
                search_5_title: "{!! trans('tour.search.search_5_title') !!}",
                search_5_text: "{!! trans('tour.search.search_5_text') !!}",
                search_5_btn_label: "{!! trans('tour.search.search_5_btn_label') !!}"
            };
        </script>
        <script src="{{asset('js/tour.js')}}"></script>
    @endif
@endsection

@section('content')

    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-search">
                <div class="panel-heading">
                    <div class="panel-title">{{trans('search.general.search_location')}}</div>
                </div>
                <div class="panel-body">
                    <form class="wbf-location-form form-inline">
                        <div class="form-group">
                            <label for="wbfInputAddress" class="sr-only">{{trans('search.general.address')}}</label>
                            <input type="text" name="wbfInputAddress" id="wbfInputAddress" class="form-control" placeholder="{{trans('search.general.address')}}" style="width: 300px"><br>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-default" id="wbfInputGeolocation" type="button"><i class="fa fa-crosshairs"></i></button>
                        </div>
                        <button type="submit" class="btn btn-warning">{{trans('search.general.search_address')}}</button>
                    </form>
                    <div class="m-t-10" v-show="currentLocation">
                        <i class="fa fa-street-view"></i> <a href="#" class="set-default-location hint-text">{!! trans('search.general.set_location_default') !!}</a>
                    </div>
                    <div class="m-t-20" v-show="geolocating">
                        <i class="fa fa-refresh fa-spin m-r-10"></i> {{trans('search.general.searching_for_location')}}
                    </div>
                </div>
            </div>
            <div class="panel panel-search-params">
                <div class="panel-heading">
                    <div class="panel-title">{{trans('search.general.map')}}</div>
                </div>
                <div class="panel-body">
                    <form role="form" class="wbf-search-form">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="wbfInputCategory">{{trans('search.general.category')}}</label>
                                    <select name="wbfInputCategory" id="wbfInputCategory" class="full-width"  data-init-plugin="select2">
                                        <option value="">{{trans('search.general.select_category')}}</option>
                                        @foreach( $categories as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="wbfInputText">{{trans('search.general.search')}}</label>
                                    <input type="text" name="wbfInputText" id="wbfInputText" class="form-control" placeholder="{{trans('search.general.store_name')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="wbfInputRadius">{{trans('search.general.radius')}}</label>
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
                            <div class="col-md-2">
                                <label class="invisible">Submit</label>
                                <button type="submit" class="btn btn-success">{{trans('search.general.search')}} <i class="fa fa-refresh fa-spin hidden"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-map">
                        <div id="map" style="height: 500px"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-leads no-margin">
                        <div class="panel-heading">
                            <div class="panel-title"><i class="pg-map"></i> {{trans('home.your_leads')}}</div>
                        </div>
                        <div class="auto-overflow" style="height: 300px;">
                            @if(count($leads))
                                <table class="table table-condensed table-hover no-margin">
                                    <tbody>
                                    @foreach($leads as $lead)
                                        <tr>
                                            <td class="col-lg-3 fs-18">{{date('d.m.Y', strtotime($lead->created_at))}}</td>
                                            <td class="fs-12 col-lg-6">
                                                <a href="/leads/view/{{$lead->id}}">{{$lead->name}}</a>
                                            </td>
                                            <td class="text-right col-lg-3">
                                                <span class="label {{$status_classes[$lead->status]}}">{{trans($status[$lead->status])}}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-center m-b-10"><a href="/leads/search?tour=1">{{trans('home.no_leads')}}</a>.</p>
                                <p class="text-center p-b-30"><a href="/leads/search?tour=1" class="btn btn-success">{{trans('home.start_searching')}}</a></p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel places-list hidden-xs" style="">
                        <div class="panel-heading">
                            <div class="panel-title"><i class="pg-map"></i> Places (@{{ places.length }})</div>
                        </div>
                        <div class="auto-overflow" style="height: 300px;">
                            <table class="table table-condensed table-hover no-margin">
                                <tbody>
                                <tr v-for="place in places">
                                    <td class="col-xs-12"><a href="#" data-index="@{{$index}}" class="btn-block">@{{ place.name }}</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- /.places-list -->
                </div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="panel panel-place-details">
                <div class="panel-heading">
                    <div class="panel-title"><i class="pg-map"></i> {{trans('search.general.business_details')}}</div>
                </div>
                <div class="panel-body" id="analyze">
                    <div class="wbf-business-details-introduction" v-show="!details.name">
                        <h3>{{trans('search.introduction.title')}}</h3>
                        <p>{!! trans('search.introduction.text_1') !!}</p>
                        <p>{!! trans('search.introduction.text_2') !!}</p>
                        <p>{!! trans('search.introduction.text_3') !!}</p>
                    </div>

                    <div class="upsell-cms alert alert-warning" v-show="details.website && !permissions.cms && 1==2">
                        <h4>Upgrade your account</h4>
                        <p>Find out which CMS is used by this website.</p>
                        <a href="#" class="btn btn-danger m-t-10">Upgrade my account</a>
                    </div>

                    <div class="wbf-business-details">
                        {{csrf_field()}}

                        <div class="wbf-business-details__add-to-list" v-show="status.loaded">
                            <button class="btn btn-success btn-lg btn-block btn-add-to-list">{{trans('search.general.save_lead')}}</button>
                        </div>

                        <div class="wbf-business-details__title" v-show="status.loaded">
                            <h3>@{{ details.name }}</h3>
                            <p v-if="details.formatted_address">@{{ details.formatted_address }}</p>
                            <p v-if="details.formatted_phone_number">@{{ details.formatted_phone_number }}</p>
                            <p v-if="details.website"><a href="@{{ details.website }}" class="website" target="_blank">@{{ details.website }}</a></p>
                            <hr>
                        </div>

                        <div class="wbf-business-details__no-website" v-show="status.loaded && !details.website && details.name">
                            <div class="alert alert-info"><p>{{trans('search.general.no_website')}}</p></div>
                        </div>

                        <div class="wbf-business-details__pagespeed" v-show="status.loaded && details.website">
                            <h4>{{trans('search.general.pagespeed_scores')}}</h4>
                            <table class="table table-condensed">
                                <thead>
                                <tr>
                                    <th>{{trans('search.general.speed')}}</th>
                                    <th>{{trans('search.general.usability')}}</th>
                                </tr>
                                </thead>
                                <tr>
                                    <td><span class="label label-info">@{{ details.stats.score_speed }}</span><span> / 100</span></td>
                                    <td><span class="label label-info">@{{ details.stats.score_usability }}</span><span> / 100</span></td>
                                </tr>
                            </table>
                        </div>

                        <div class="wbf-website-cms" v-show="status.loaded && details.website && details.cms">
                            <h4>{{trans('search.general.cms')}}</h4>
                            <div class="text-center">
                                <div>
                                    <img src="{{asset('img/cms/logo_drupal.png')}}" alt="Drupal" v-show="details.cmsID=='drupal'">
                                    <img src="{{asset('img/cms/logo_expressionengine.png')}}" alt="ExpressionEngine" v-show="details.cmsID=='expressionengine'">
                                    <img src="{{asset('img/cms/logo_joomla.png')}}" alt="Joomla!" v-show="details.cmsID=='joomla'">
                                    <img src="{{asset('img/cms/logo_liferay.png')}}" alt="LifeRay" v-show="details.cmsID=='liferay'">
                                    <img src="{{asset('img/cms/logo_magento.png')}}" alt="Magento" v-show="details.cmsID=='magento'">
                                    <img src="{{asset('img/cms/logo_sitecore.png')}}" alt="SiteCore" v-show="details.cmsID=='sitecore'">
                                    <img src="{{asset('img/cms/logo_typo3.png')}}" alt="Typo3" v-show="details.cmsID=='typo3'">
                                    <img src="{{asset('img/cms/logo_vbulletin.png')}}" alt="vBulletin" v-show="details.cmsID=='vbulletin'">
                                    <img src="{{asset('img/cms/logo_wordpress.png')}}" alt="WordPress" v-show="details.cmsID=='wordpress'">
                                </div>
                                <strong class="m-t-10">@{{ details.cms }}</strong>
                            </div>
                        </div>

                        <div class="wbf-business-details__preview m-b-20" v-if="status.loaded && details.score_screenshot">
                            <h4>{{trans('search.general.mobile_preview')}}</h4>
                            <div style="text-align: center;">
                                <img class="image" v-bind:src="details.score_screenshot" alt="">
                            </div>
                        </div>

                        <div class="wbf-business-details__indicators" v-show="status.loaded && details.website">
                            <h4>{{trans('search.general.obsolescence_indicators')}}</h4>
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th width="70%">{{trans('search.general.variables')}}</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tr class="indicator--responsive">
                                    <td>
                                        <strong>{{trans('search.general.responsive')}}</strong>
                                        <p class="small" style="white-space: normal">{{trans('search.general.responsive_desc')}}</p>
                                    </td>
                                    <td>
                                        <span class="label label-success" v-if="details.indicators.viewport==0">{{trans('search.general.yes')}}</span>
                                        <span class="label label-danger" v-else>{{trans('search.general.no')}}</span>
                                    </td>
                                </tr>
                                <tr class="indicator--gzip">
                                    <td>
                                        <strong>{{trans('search.general.gzip')}}</strong>
                                        <p class="small" style="white-space: normal"></p>
                                    </td>
                                    <td>
                                        <span class="label label-success" v-if="details.indicators.gzip==0">{{trans('search.general.yes')}}</span>
                                        <span class="label label-danger" v-else>{{trans('search.general.no')}}</span>
                                    </td>
                                </tr>
                                <tr class="indicator--minify-css">
                                    <td><strong>{{trans('search.general.minified_css')}}</strong></td>
                                    <td>
                                        <span class="label label-success" v-if="details.indicators.minifyCss==0">{{trans('search.general.yes')}}</span>
                                        <span class="label label-danger" v-else>{{trans('search.general.no')}}</span>
                                    </td>
                                </tr>
                                <tr class="indicator--minify-js">
                                    <td><strong>{{trans('search.general.minified_js')}}</strong></td>
                                    <td>
                                        <span class="label label-success" v-if="details.indicators.minifyJs==0">{{trans('search.general.yes')}}</span>
                                        <span class="label label-danger" v-else>{{trans('search.general.no')}}</span>
                                    </td>
                                </tr>
                                <tr class="indicator--minify-html">
                                    <td><strong>{{trans('search.general.minified_html')}}</strong></td>
                                    <td>
                                        <span class="label label-success" v-if="details.indicators.minifyHTML==0">{{trans('search.general.yes')}}</span>
                                        <span class="label label-danger" v-else>{{trans('search.general.no')}}</span>
                                    </td>
                                </tr>
                                <tr class="indicator--optimized-images">
                                    <td>
                                        <strong>{{trans('search.general.optimized_images')}}</strong>
                                        <p class="small" style="white-space: normal">{{trans('search.general.optimized_images_desc')}}</p>
                                    </td>
                                    <td>
                                        <span class="label label-success" v-if="details.indicators.optimizeImages==0">{{trans('search.general.yes')}}</span>
                                        <span class="label label-danger" v-else>{{trans('search.general.no')}}</span>
                                    </td>
                                </tr>
                                <tr class="indicator--font-size">
                                    <td>
                                        <strong>{{trans('search.general.adapted_font_size')}}</strong>
                                        <p class="small" style="white-space: normal">{{trans('search.general.adapted_font_size_desc')}}</p>
                                    </td>
                                    <td>
                                        <span class="label label-success" v-if="details.indicators.fontSize==0">{{trans('search.general.yes')}}</span>
                                        <span class="label label-danger" v-else>{{trans('search.general.no')}}</span>
                                    </td>
                                </tr>

                            </table>
                        </div>

                        <div class="wbf-business-details__add-to-list" v-show="status.loaded">
                            <button class="btn btn-success btn-lg btn-block btn-add-to-list">{{trans('search.general.save_lead')}}</button>
                        </div>
                    </div>

                    <div class="wbf-business-details-progress" style="text-align: center; padding: 40px 0;" v-show="status.loading">
                        <div class="progress-circle-indeterminate"></div>
                        <p class="small hint-text">{{trans('search.general.loading')}}</p>
                    </div>

                </div>
            </div>
        </div>

    </div>


@endsection