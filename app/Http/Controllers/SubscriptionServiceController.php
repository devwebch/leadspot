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
        $parent             = $user->parent();

        // if this user is a child account, abort
        if ( $parent ) {
            return redirect('/');
        }

        // define Strip plan
        switch ($plan) {
            case 'boutique':
                $subscription_type  = 'leadspot_boutique';
                break;
            case 'company':
                $subscription_type  = 'leadspot_company';
                break;
            case 'agency':
                $subscription_type  = 'leadspot_agency';
                break;
        }

        // retrieve the card token
        $stripeToken = $request->input('token');

        // create new subscription
        $user->newSubscription('main', $subscription_type)->create($stripeToken);

        // retrieve user's subscription usage
        $usage  = $user->subscriptionUsage()->first();
        $quotas = json_decode($usage->quotas);

        // define usage limit
        if ( $subscription_type == 'leadspot_boutique' ) {
            $quotas->search->limit      = config('subscriptions.boutique.limit.search');
            $quotas->contacts->limit    = config('subscriptions.boutique.limit.contacts');
        }
        if ( $subscription_type == 'leadspot_company' ) {
            $quotas->search->limit      = config('subscriptions.company.limit.search');
            $quotas->contacts->limit    = config('subscriptions.company.limit.contacts');
        }
        if ( $subscription_type == 'leadspot_agency' ) {
            $quotas->search->limit      = config('subscriptions.agency.limit.search');
            $quotas->contacts->limit    = config('subscriptions.agency.limit.contacts');
        }

        $quotas = json_encode($quotas);
        $usage->quotas = $quotas;

        // update the subscription usage
        $usage->save();

        // notify the user
        // TODO: Notify user

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

        $quotas = json_decode($usage->quotas);

        if ( $quotas ) {
            $quotas->search->limit      = config('subscriptions.free.limit.search');
            $quotas->search->used       = 0;
            $quotas->contacts->limit    = config('subscriptions.free.limit.contacts');
            $quotas->contacts->used     = 0;

            $quotas = json_encode($quotas);
            $usage->quotas = $quotas;
            $usage->save();
        }

        return redirect('/account');
    }


    /**
     * Retrieve subscription usage, may increase if param is passed
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkSubscriptionUsage(Request $request)
    {
        // get the current user
        $user           = $request->user();
        $user_parent    = $user->parent();

        $usage          = $user->subscriptionUsage()->first();
        $usage_parent   = $usage;
        $update         = $request->input('update');
        $type           = $request->input('type');

        // if the user has a parent, store its usage
        if ($user_parent) {
            $usage_parent  = $user_parent->subscriptionUsage()->first();
        }

        // decode the quotas
        $quotas   = json_decode($usage_parent->quotas);

        // check subscription use
        if ( $quotas->$type->used >= $quotas->$type->limit ) {
            $return = false;
        } else {
            $return = true;
        }

        // if increment is asked, proceed
        if ( $update == true && $type && $return == true ) {
            $usage->increaseUseByType($type);

            // if the account is a child account, the target account is the parent
            if ( $user_parent ) {
                $usage_parent->increaseUseByType($type);
            }
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
        $parent = $user->parent();

        // if the account is a child account, the target account is the parent
        if ( $parent ) {
            $user = User::find($parent->id);
        }

        $usage  = $user->subscriptionUsage()->first();
        $usage->increaseUse();
    }

    public function updateSubscriptionUsageByType(Request $request)
    {
        $user           = $request->user();
        $parent         = $user->parent();
        $usage          = $user->subscriptionUsage()->first();

        $type           = $request->input('type');

        if ( $type ) {
            $usage->increaseUseByType($type);

            // if the account is a child account, update the parent
            if ( $parent ) {
                $user   = User::find($parent->id);
                $usage  = $user->subscriptionUsage()->first();
                $usage->increaseUseByType($type);
            }
        }
    }

    /**
     * Retrieve the current user's permissions according to his plan
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubscriptionPermissions(Request $request)
    {
        $user           = $request->user();
        $parent         = $user->parent();

        // if the account is a child account, the target account is the parent
        if ( $parent ) {
            $user = User::find($parent->id);
        }

        $subscription   = $user->subscriptions()->get()->first();
        $permissions    = [
            'cms'               => true,
            'auto_geolocation'  => false,
            'report'            => false,
            'manual_lead'       => false,
        ];

        if ( $user->subscribed('main') ) {
            if ( $subscription->stripe_plan == 'leadspot_boutique' ) {
                $permissions = [
                    'cms'               => true,
                    'auto_geolocation'  => true,
                    'report'            => true,
                    'manual_lead'       => true
                ];
            }
            if ( $subscription->stripe_plan == 'leadspot_company' ) {
                $permissions = [
                    'cms'               => true,
                    'auto_geolocation'  => true,
                    'report'            => true,
                    'manual_lead'       => true
                ];
            }
            if ( $subscription->stripe_plan == 'leadspot_agency' ) {
                $permissions = [
                    'cms'               => true,
                    'auto_geolocation'  => true,
                    'report'            => true,
                    'manual_lead'       => true
                ];
            }
        }

        return response()->json($permissions);
    }
}