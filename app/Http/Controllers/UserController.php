<?php
/**
 * Created by PhpStorm.
 * User: srapin
 * Date: 16.09.16
 * Time: 22:23
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Retrieve user informations
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function account()
    {
        $user           = Auth::user();
        $usage          = $user->subscriptionUsage()->first();
        $subscription   = $user->subscriptions()->get()->first();
        $invoices       = [];

        if ( $user->subscribed('main') ){
            $invoices = $user->invoicesIncludingPending();
        }

        return view('auth.account.user', [
            'user' => $user,
            'usage' => $usage,
            'subscription' => $subscription,
            'invoices'  => $invoices,
        ]);
    }

    public function downloadInvoice(Request $request, $invoiceId)
    {
        return $request->user()->downloadInvoice($invoiceId, [
            'vendor'  => 'LeadSpot',
            'product' => 'LeadSpot subscription',
        ]);
    }

}