<?php

namespace App\Http\Controllers;

use App\Message;
use App\Subscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Cashier;
use Stripe\Stripe;

class Admin extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function home(Request $request)
    {
        $user       = $request->user();

        return view('admin.home', ['user' => $user]);
    }

    public function accounts(Request $request)
    {
        $user       = $request->user();
        $accounts   = \App\User::where('id', '!=', 1)->get();
        $accounts   = \App\User::all();

        return view('admin.accounts', ['accounts' => $accounts]);
    }

    public function subscriptions(Request $request)
    {
        $user           = $request->user();
        $subscriptions  = \App\Subscription::all();

        return view('admin.subscriptions', ['subscriptions' => $subscriptions]);
    }
    
    public function messages(Request $request)
    {
        $user           = $request->user();
        $messages       = \App\Message::all();

        return view('admin.messages', ['messages' => $messages]);
    }

    public function loginAsUserID($userID)
    {
        if ($userID && $userID != 1) {
            Auth::loginUsingId($userID);
        }

        return redirect('/');
    }

    // actions
    public function deleteAccount($id)
    {
        $user           = User::findOrFail($id);
        $subscription   = $user->subscriptions()->get()->first();

        if ( $user->subscribed('main') ) {
            $user->subscription('main')->cancelNow();
        }
        if ( $subscription ) {
            $subscription->delete();
        }

        $user->delete();

        return back();
    }

    public function deleteMessage($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return back();
    }
}
