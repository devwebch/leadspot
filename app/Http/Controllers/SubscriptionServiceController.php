<?php
/**
 * Created by PhpStorm.
 * User: srapin
 * Date: 16.09.16
 * Time: 20:50
 */

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Cashier;
use Stripe\Stripe;

class SubscriptionServiceController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // require authentication for the whole Controller
        $this->middleware('auth');
    }

    public function addSubscription($plan, Request $request)
    {
        // logged in user
        $user               = $request->user();
        $subscription_type  = null;

        // define Strip plan
        switch ($plan) {
            case 'advanced':
                $subscription_type  = 'leadspot_advanced';
                break;
            case 'pro':
                $subscription_type  = 'leadspot_pro';
                break;
        }

        // retrieve the card token
        $stripeToken = $request->input('token');

        // create new subscription
        $user->newSubscription('main', $subscription_type)->create($stripeToken);

        // retrieve user's subscription usage
        $usage  = $user->subscriptionUsage()->first();

        // define usage limit
        if ( $subscription_type == 'leadspot_advanced' ) {
            $usage->limit = config('subscriptions.advanced.limit');
        } elseif ( $subscription_type == 'leadspot_pro' ) {
            $usage->limit = config('subscriptions.pro.limit');
        }

        // update the subscription usage
        $usage->save();

        // redirect to account
        return redirect('/account');
    }

    public function removeSubscription()
    {
        $user = Auth::user();
        $user->subscription('main')->cancelNow();

        $usage  = $user->subscriptionUsage()->first();
        $usage->limit = config('subscriptions.free.limit');
        $usage->save();

        return redirect('/account');
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