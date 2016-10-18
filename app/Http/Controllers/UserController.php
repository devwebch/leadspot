<?php
/**
 * Created by PhpStorm.
 * User: srapin
 * Date: 16.09.16
 * Time: 22:23
 */

namespace App\Http\Controllers;

use App\User;
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
        $usage          = $user->subscriptionUsage()->first();
        $usage          = json_decode($usage->quotas);
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

    /**
     * Download stripe generated invoice
     * @param Request $request
     * @param $invoiceId
     * @return mixed
     */
    public function downloadInvoice(Request $request, $invoiceId)
    {
        return $request->user()->downloadInvoice($invoiceId, [
            'vendor'  => 'LeadSpot',
            'product' => 'LeadSpot subscription',
        ]);
    }

    /**
     * Edit User
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('auth.account.form', ['user' => $user]);
    }

    /**
     * Save User
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

    /**
     * Retrieve User's preferences
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getPreferences(Request $request)
    {
        // get User
        $user = $request->user();
        // get preferences or instanciate Object
        $preferences    = !empty($user->preferences) ? $user->preferences : json_encode((object) []);

        return response($preferences);
    }

    /**
     * Save user's preferences
     * @param Request $request
     */
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

    /**
     * List team members
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function teamList(Request $request)
    {
        // get User
        $user           = $request->user();
        $team           = $user->children();

        if ( $team ) {
            return view('auth.team.list', [
                'accounts'  => $team
            ]);
        }

        return redirect('/');
    }

    /**
     * Edit team member
     * @param $userID
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View|void
     */
    public function teamEdit($userID, Request $request)
    {
        // get User
        $user           = $request->user();
        $user_edit      = User::find($userID);

        if ( !$user_edit->parent() ) {
            return;
        }

        if ( $user_edit ) {

            if ( $user->id != $user_edit->parent()->id ){
                return;
            }

            return view('auth.team.edit', [
                'user'  => $user_edit
            ]);
        }

        return redirect('/account/team/list');
    }

    /**
     * Save team member
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function teamSave(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'inputFirstName'    => 'required',
            'inputLastName'     => 'required'
        ]);

        $user->first_name       = $request->input('inputFirstName');
        $user->last_name        = $request->input('inputLastName');
        $user->save();

        return redirect('/account');
    }


}