<?php
/**
 * Created by PhpStorm.
 * User: srapin
 * Date: 23.08.16
 * Time: 20:21
 */

namespace App\Http\Controllers;

use App\Contact;
use App\Lead;
use App\User;
use App\Library\DetectCMS\DetectCMS;
use App\Report;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadServiceController extends Controller
{
    private $MAPS_API_KEY           = 'AIzaSyAmuoso1k61TZCOqUdPi3E7VIl2HA2UBmA';
    private $PAGESPEED_API_KEY      = 'AIzaSyDCelPpT9KgfceVGY8cBRFc4D-n8rbT9-0';
    private $EMAILHUNTER_API_KEY    = 'b7ed2eb558bb33918da354c3cb6525a33b28ccd3';
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
        $parent = $user->parent();

        // if the account is a child account, the target account is the parent
        if ( $parent ) {
            $user = User::find($parent->id);
        }

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
        $lead->cms              = '';

        // save the Model
        $lead->save();

        // reports data
        $scores = [
            'speed'     => isset($request->stats['score_speed']) ? $request->stats['score_speed'] : '',
            'usability' => isset($request->stats['score_usability']) ? $request->stats['score_usability'] : ''
        ];
        $stats = [
            'total_request_bytes'   => isset($request->stats['total_request_bytes']) ? $request->stats['total_request_bytes'] : '',
            'num_js_ressources'     => isset($request->stats['num_js_ressources']) ? $request->stats['num_js_ressources'] : '',
            'num_css_ressources'    => isset($request->stats['num_css_ressources']) ? $request->stats['num_css_ressources'] : ''
        ];
        $indicators = [
            'viewport'              => isset($request->indicators['viewport']) ? $request->indicators['viewport'] : '',
            'gzip'                  => isset($request->indicators['gzip']) ? $request->indicators['gzip'] : '',
            'minifyCss'             => isset($request->indicators['minifyCss']) ? $request->indicators['minifyCss'] : '',
            'minifyJs'              => isset($request->indicators['minifyJs']) ? $request->indicators['minifyJs'] : '',
            'minifyHTML'            => isset($request->indicators['minifyHTML']) ? $request->indicators['minifyHTML'] : '',
            'optimizeImages'        => isset($request->indicators['optimizeImages']) ? $request->indicators['optimizeImages'] : '',
            'fontSize'              => isset($request->indicators['fontSize']) ? $request->indicators['fontSize'] : '',
        ];
        $website = [];
        $website['cms'] = $request->cmsID;

        $report = new Report();
        $report->lead_id       = $lead->id;
        $report->scores        = json_encode($scores);
        $report->stats         = json_encode($stats);
        $report->indicators    = json_encode($indicators);
        $report->website       = json_encode($website);
        $report->save();

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

        $client = new Client();
        $res    = $client->request('GET', $pagespeed, ['verify' => false]);
        $output = $res->getBody();

        return response($output);
    }

    public function getPlaces(Request $request)
    {
        // TODO: get parameters from input
        $location_lat   = '-33.8670';
        $location_lng   = '151.1957';
        $location       = $location_lat . ',' . $location_lng;
        $radius         = '500';
        $types          = 'establishment';
        $name           = 'cruise';
        $places = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=' . $location . '&radius=' . $radius . '&types=' . $types . '&key=' . $this->PAGESPEED_API_KEY;

        $client = new Client([
            'headers' => ['Referer' => 'leadspotapp.lan']
        ]);
        $res    = $client->request('GET', $places, ['verify' => false]);
        $output = json_decode($res->getBody());
        $places_list = $output->results;


        return response()->json($output);
    }

    public function getPlacesSample(Request $request)
    {
        // request data
        $location_lat   = '46.521491';
        $location_lng   = '6.630802';
        $location       = $location_lat . ',' . $location_lng;
        $radius         = '500';
        $types          = 'establishment';
        $name           = 'cruise';
        $places = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=' . $location . '&radius=' . $radius . '&types=' . $types . '&key=' . $this->PAGESPEED_API_KEY;

        // new Guzzle request
        $client = new Client([
            'headers' => ['Referer' => 'leadspot.lan']
        ]);
        $res    = $client->request('GET', $places, ['verify' => false]);

        // output
        $output = json_decode($res->getBody());
        $places_list = $output->results;
        $places = [];

        // extract places
        $count  = 0;
        $max    = 3;
        foreach ($places_list as $place) {
            if ( $count < $max ) {
                $place_ID = $place->place_id;
                $places[] = $this->getPlaceDetails($place_ID);
            }
            $count++;
        }

        return response()->json($places);
    }

    public function getPlaceDetails($place_ID)
    {
        $places = 'https://maps.googleapis.com/maps/api/place/details/json?placeid=' . $place_ID . '&key=' . $this->MAPS_API_KEY;

        $client = new Client([
            'headers' => ['Referer' => 'leadspot.lan']
        ]);
        $res    = $client->request('GET', $places, ['verify' => false]);
        $output = json_decode($res->getBody());

        $place_website  = isset($output->result->website) ? $output->result->website : false;
        $scores         = ($place_website) ? $this->getPlaceInsights($place_website) : false;
        //$scores         = false;

        $place  = [
            'name'      => $output->result->name,
            'address'   => $output->result->formatted_address,
            'website'   => $place_website,
            'scores'    => $scores
        ];

        return $place;
    }

    public function getPlaceInsights($url)
    {
        $pagespeed = 'https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=' . urlencode($url).'&strategy=mobile';

        $client = new Client([
            'headers' => ['Referer' => 'leadspot.lan']
        ]);
        $res    = $client->request('GET', $pagespeed, ['verify' => false]);
        $output = json_decode($res->getBody());

        $scores = [
            'speed'     => $output->ruleGroups->SPEED->score,
            'usability' => $output->ruleGroups->USABILITY->score
        ];

        return $scores;
    }

    /**
     * Retrieve contacts emails for a given domain
     * @param Lead $lead
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function getLeadEmails(Lead $lead, Request $request)
    {
        $website        = $lead->url;

        // if no website, exit
        if ( !$website ) {
            return;
        }

        $website        = parse_url($website)['host'];
        $domain         = preg_replace('/www\./', '', $website);
        $user           = $request->user();
        $user_parent    = $user->parent();

        $usage          = $user->subscriptionUsage()->first();
        $usage_parent   = $usage;

        if ( $user_parent ) {
            $usage_parent = $user_parent->subscriptionUsage()->first();
        }

        // retrieve the quotas
        $quotas         = json_decode($usage_parent->quotas);

        // if quotas are full, go back
        if ( $quotas->contacts->used >= $quotas->contacts->limit ) {
            return back();
        }

        // check if lead has contacts
        $contacts = Contact::where('lead_id', $lead->id)->count();
        if ( $contacts ) {
            return;
        }

        // query the mailhunter api
        $client = new Client();
        $res    = $client->request('GET', 'https://api.hunter.io/v2/domain-search?domain=' . $domain . '&api_key=' . $this->EMAILHUNTER_API_KEY, ['verify' => false]);

        if ( $res->getStatusCode() == '200' ) {
            // decode json response
            $json_object    = json_decode($res->getBody());
            $emails_raw     = $json_object->data->emails;
            $results        = 0;

            // loop through emails
            foreach ($emails_raw as $email) {

                // check confidence
                if ( $email->confidence >= 30 ) {

                    // create Contact Model
                    $contact = new Contact();
                    $contact->lead_id       = $lead->id;
                    $contact->email         = $email->value;
                    $contact->type          = $email->type;
                    $contact->confidence    = $email->confidence;
                    $contact->save();

                    $results++;
                }
            }

            if ( $results > 0 ) {
                $usage->increaseUseByType('contacts');

                if ( $user_parent ) {
                    $usage_parent->increaseUseByType('contacts');
                }
            }
        }

        return back();
    }

    /**
     * Count how many e-mails are available for a given domain
     * @param Lead $lead
     * @return int|void
     */
    public function checkLeadEmails(Lead $lead)
    {
        // if no website, exit
        if ( !$lead->url ) {
            return;
        }

        $website    = $lead->url;
        $website    = parse_url($website)['host'];
        $domain     = preg_replace('/www\./', '', $website);
        $count      = 0;

        $client = new Client();
        $res    = $client->request('GET', 'https://api.hunter.io/v2/email-count?domain=' . $domain, ['verify' => false]);

        if ( $res->getStatusCode() == '200' ) {
            $data = json_decode($res->getBody());
            $count = (int) $data->data->total;
        }

        return $count;
    }
}