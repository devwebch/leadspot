<?php
/**
 * Created by PhpStorm.
 * User: srapin
 * Date: 16.09.16
 * Time: 20:50
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionServiceController extends Controller
{
    public function __construct()
    {
        // require authentication for the whole Controller
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkSubscriptionUsage(Request $request)
    {
        $user   = $request->user();
        $usage  = $user->subscriptionUsage()->first();

        // check subscription use
        if ( $usage->used >= $usage->limit ) {
            $return = false;
        } else {
            $return = true;
        }

        // if increment is asked, proceed
        if ( $request->input('update') == true ) {
            $usage->increaseUse();
        }

        return response()->json($return);
    }

    public function updateSubscriptionUsage(Request $request)
    {
        $user   = $request->user();
        $usage  = $user->subscriptionUsage()->first();
        $usage->increaseUse();
    }
}