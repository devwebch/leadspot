<?php
/**
 * Created by PhpStorm.
 * User: srapin
 * Date: 23.08.16
 * Time: 20:21
 */

namespace App\Http\Controllers;

use App\Lead;
use App\Library\DetectCMS\DetectCMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadServiceController extends Controller
{
    private $PAGESPEED_API_KEY      = 'AIzaSyDCelPpT9KgfceVGY8cBRFc4D-n8rbT9-0';
    private $referer                = 'https://go.leadspotapp.com';

    public function __construct()
    {
        // require authentication for the whole Controller
        $this->middleware('auth');
    }

    /**
     * Save a single lead
     * @param Request $request
     * @return array
     */
    public function save(Request $request)
    {
        // get the authenticated user
        $user   = $request->user();

        $lead = new Lead();
        $lead->place_id         = $request->place_id;
        $lead->name             = $request->name;
        $lead->url              = $request->website ? $request->website : '';
        $lead->address          = $request->formatted_address;
        $lead->rating           = 0;
        $lead->status           = 0;
        $lead->phone_number     = $request->formatted_phone_number;
        $lead->notes            = '';
        $lead->lat              = $request->lat;
        $lead->lng              = $request->lng;
        $lead->user_id          = $user->id;
        $lead->cms              = $request->cmsID;

        // save the Model
        $lead->save();

        return $request->all();
    }

    /**
     * Run CMS detector for provided url
     * @param Request $request
     * @return array|string
     */
    public function getCMS(Request $request)
    {
        $url        = $request->input('url');

        if ( $url ) {
            $cms_data   = new DetectCMS($url);
            $return     = $cms_data->getResult();
        } else {
            $return     = ['cms' => null];
            $return     = json_encode($return);
        }

        return $return;
    }

    public function analyze(Request $request)
    {
        $website    = $request->input('url');

        $pagespeed    = 'https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=' . urlencode($website) . '&screenshot=true&strategy=mobile&key=' . $this->PAGESPEED_API_KEY;

        $curl   = curl_init();
        curl_setopt($curl, CURLOPT_URL, $pagespeed);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_REFERER, $this->referer);
        $output = curl_exec($curl);
        curl_close($curl);

        return response()->json($output);
    }

    public function getPlaces(Request $request)
    {
        $location_lat   = '-33.8670';
        $location_lng   = '151.1957';
        $location       = $location_lat . ',' . $location_lng;
        $radius         = '500';
        $types          = 'food';
        $name           = 'cruise';
        $places = 'https://maps.googleapis.com/maps/api/place/radarsearch/json?location=' . $location . '&radius=' . $radius . '&types=' . $types . '&name=' . $name . '&key=' . $this->PAGESPEED_API_KEY;

        $curl   = curl_init();
        curl_setopt($curl, CURLOPT_URL, $places);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_REFERER, $this->referer);
        $output = curl_exec($curl);
        curl_close($curl);

        return response($output);
    }

    public function getPlaceDetails(Request $request)
    {
        $place_ID   = 'ChIJ__8_hziuEmsR27ucFXECfOg';
        $places = 'https://maps.googleapis.com/maps/api/place/details/json?placeid=' . $place_ID . '&key=' . $this->PAGESPEED_API_KEY;

        $curl   = curl_init();
        curl_setopt($curl, CURLOPT_URL, $places);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_REFERER, $this->referer);
        $output = curl_exec($curl);
        curl_close($curl);

        return response($output);
    }
}