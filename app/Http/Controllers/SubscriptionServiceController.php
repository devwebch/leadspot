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

    /**
     * Add subscription to logged in user
     * @param $plan
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

        // notify the user


        // redirect to success page
        return redirect('/subscribe/transaction/success');
    }

    /**
     * Remove subscription from logged in user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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
     * Retrieve subscription usage, may increase if param is passed
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

    /**
     * Increase the subscription usage
     * @param Request $request
     */
    public function updateSubscriptionUsage(Request $request)
    {
        $user   = $request->user();
        $usage  = $user->subscriptionUsage()->first();
        $usage->increaseUse();
    }

    /**
     * Retrieve the current user's permissions according to his plan
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubscriptionPermissions(Request $request)
    {
        $user           = $request->user();
        $subscription   = $user->subscriptions()->get()->first();
        $permissions    = [
            'cms'               => false,
            'auto_geolocation'  => false,
            'report'            => false,
            'manual_lead'       => false,
        ];

        if ( $user->subscribed('main') ) {
            if ( $subscription->stripe_plan == 'leadspot_pro' ) {
                $permissions = [
                    'cms'               => true,
                    'auto_geolocation'  => true,
                    'report'            => true,
                    'manual_lead'       => true
                ];
            }
            if ( $subscription->stripe_plan == 'leadspot_advanced' ) {
                $permissions = [
                    'cms'               => true,
                    'auto_geolocation'  => true,
                    'report'            => false,
                    'manual_lead'       => false
                ];
            }
        }

        return response()->json($permissions);
    }
}