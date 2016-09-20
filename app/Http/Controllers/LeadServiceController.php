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

class LeadServiceController extends Controller
{
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
}