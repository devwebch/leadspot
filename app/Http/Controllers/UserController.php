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
        $this->middleware(['auth']);
    }

    /**
     * Retrieve user informations
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function account()
    {
        $user           = Auth::user();
        $usage          = $user->usageSearch();
        $subscription   = $user->subscriptions()->first();
        $invoices       = [];

        if ( $user->subscribed('main') ){
            $invoices = $user->invoicesIncludingPending();
        }

        return view('auth.account.user', [
            'user'              => $user,
            'usage'             => $usage,
            'subscription'      => $subscription,
            'invoices'          => $invoices,
        ]);
    }

    public function downloadInvoice(Request $request, $invoiceId)
    {
        return $request->user()->downloadInvoice($invoiceId, [
            'vendor'  => 'LeadSpot',
            'product' => 'LeadSpot subscription',
        ]);
    }

    public function edit(Request $request)
    {
        $user = $request->user();

        return view('auth.account.form', ['user' => $user]);
    }

    public function save(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'inputFirstName'    => 'required',
            'inputLastName'     => 'required',
            'inputCompany'      => 'max:255'
        ]);

        $user->first_name       = $request->input('inputFirstName');
        $user->last_name        = $request->input('inputLastName');
        $user->company          = $request->input('inputCompany');
        $user->save();

        return redirect('/account');
    }

    public function getPreferences(Request $request)
    {
        // get User
        $user = $request->user();
        // get preferences or instanciate Object
        $preferences    = !empty($user->preferences) ? $user->preferences : json_encode((object) []);

        return response($preferences);
    }

    public function savePreference(Request $request)
    {
        // get User
        $user           = $request->user();
        // get preferences or instanciate Object
        $preferences    = !empty($user->preferences) ? json_decode($user->preferences) : (object) [];

        // save default location
        if ($request->input('location')) {
            $preferences->defaultLocationLat = $request->input('location.lat');
            $preferences->defaultLocationLng = $request->input('location.lng');
        }

        // encode preferences
        $user->preferences = json_encode($preferences);
        // save
        $user->save();
    }

}