<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

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

    public function loginAsUserID($userID)
    {
        if ($userID && $userID != 1) {
            Auth::loginUsingId($userID);
        }

        return redirect('/');
    }
}
