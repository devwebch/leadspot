<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the subscription view
     * @param $plan
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function subscribe($plan, Request $request)
    {
        $planID     = null;
        $planName   = null;

        // define plan ID and name
        switch ($plan) {
            case 'advanced':
                $planID     = 'leadspot_advanced';
                $planName   = 'LeadSpot ADVANCED';
                break;
            case 'pro':
                $planID     = 'leadspot_pro';
                $planName   = 'LeadSpot PRO';
                break;
        }

        // if no ID or name, redirect to user account
        if ( !$planID || !$planName ) {
            return redirect('/account');
        }

        // return the subscribe view
        return view('subscriptions.buy', [
            'plan'      => $plan,
            'planID'    => $planID,
            'planName'  => $planName
        ]);
    }
}
