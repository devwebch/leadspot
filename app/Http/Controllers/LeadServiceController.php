<?php
/**
 * Created by PhpStorm.
 * User: srapin
 * Date: 23.08.16
 * Time: 20:21
 */

namespace App\Http\Controllers;

use App\Lead;
use Illuminate\Http\Request;

class LeadServiceController extends Controller
{
    public function __construct()
    {
        // require authentication for the whole Controller
        $this->middleware('auth');
    }

    public function save(Request $request)
    {
        // get the authenticated user
        $user   = $request->user();

        $lead = new Lead();
        $lead->name     = $request->name;
        $lead->url      = $request->website;
        $lead->address  = $request->formatted_address;
        $lead->status   = 0;
        $lead->lat      = $request->lat;
        $lead->lng      = $request->lng;
        $lead->user_id  = $user->id;

        // save the Model
        $lead->save();

        return $request->all();
    }
}