<?php
/**
 * Created by PhpStorm.
 * User: srapin
 * Date: 16.09.16
 * Time: 22:23
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\SubscriptionsUsage;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends RegisterController
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
        $usage          = $user->subscriptionParentUsage()->first();
        $usage          = json_decode($usage->quotas);
        $subscription   = $user->subscriptions()->first();
        $invoices       = [];

        if ( $user->subscribed('main') ){
            $invoices = $user->invoicesIncludingPending();
        }

        Log::info('Showing user account for user ID: ' . $user->id);

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
        Log::info('Editing user with ID: ' . $user->id);

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
            'first_name'    => 'required|max:255',
            'last_name'     => 'required|max:255',
            'company'       => 'max:255'
        ]);

        $user->first_name       = $request->input('first_name');
        $user->last_name        = $request->input('last_name');
        $user->company          = $request->input('company');
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
        if ( $user->parent() ) { return back(); }

        $team           = $user->children();
        $slots_open     = $user->teamSlotsAvailable();

        if ( $slots_open ) {
            Log::info(' ID: ' . $user->id);

            return view('auth.team.list', [
                'accounts'      => $team,
                'slots_open'    => $slots_open
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

        // a child account cannot edit
        if ( !$user_edit->parent() ) {
            return redirect('/');
        }

        if ( $user_edit ) {

            // if the child doesn't belong to the account
            if ( $user->id != $user_edit->parent()->id ){
                return redirect('/account/team');
            }

            return view('auth.team.edit', [
                'user'  => $user_edit
            ]);
        }

        return redirect('/account/team');
    }

    /**
     * Save team member after edit
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function teamSave(Request $request)
    {
        $userID = $request->input('_id');
        $user   = User::find($userID);

        $this->validate($request, [
            'first_name'    => 'required|max:255',
            'last_name'     => 'required|max:255',
            'email'         => 'required|email|max:255',
        ]);

        $user->first_name       = $request->input('first_name');
        $user->last_name        = $request->input('last_name');
        $user->email            = $request->input('email');
        $user->save();

        return redirect('/account/team');
    }

    /**
     * Add a new team member
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function teamNew(Request $request)
    {
        // get User
        $user           = $request->user();
        if ( $user->parent() || !$user->teamSlotsAvailable() ) { return redirect('/'); }


        return view('auth.team.new');
    }

    /**
     * Save a new user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function teamNewSave(Request $request)
    {
        $parent_user = $request->user();

        $new_user = $this->create([
            'first_name'    => $request->input('first_name'),
            'last_name'     => $request->input('last_name'),
            'email'         => $request->input('email'),
            'password'      => bcrypt($request->input('password')),
            'company'       => ''
        ]);

        $new_user->parent_id = $parent_user->id;
        $new_user->save();

        return redirect('/account/team');
    }

    /**
     * Delete team member
     * @param $userID
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function teamDelete($userID, Request $request)
    {
        // get User
        $current_user           = $request->user();
        $user                   = User::find($userID);

        // if it has a parent, return
        if ( $current_user->parent() ) { return; }
        // if it is not the parent, return
        if ( $current_user->id != $user->parent_id ) { return; };

        // delete usage
        $user->subscriptionUsage()->delete();
        // delete user
        $user->delete();

        return redirect('/account/team');
    }


}