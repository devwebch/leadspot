<?php

namespace App\Http\Controllers;

use App\Lead;
use App\Notifications\InvoicePaid;
use App\Notifications\NewMessage;
use App\Notifications\Welcome;
use App\SubscriptionsUsage;
use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Home view
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home(Request $request)
    {
        // get the authenticated user
        $user   = $request->user();
        $parent = $user->parent();

        $lead_author = $user->id;
        if ( $parent ) {
            $lead_author = $parent->id;
        }

        // retrieve lead status
        $status = config('constants.lead.status');

        $status_classes = [
            0 => '',
            1 => 'label-warning',
            2 => 'label-success',
            3 => 'label-danger'
        ];

        $leads = Lead::where('user_id', $lead_author)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $usage = $user->subscriptionParentUsage()->first();
        $usage = json_decode($usage->quotas);

        // get the tour param
        $tour = $request->input('tour');

        return view('home', [
            'leads'             => $leads,
            'usage'             => $usage,
            'status'            => $status,
            'status_classes'    => $status_classes,
            'tour'              => $tour,
        ]);
    }

    public function sandbox(Request $request)
    {
        // get the authenticated user
        $user = $request->user();

        $children   = $user->children();
        $parent     = $user->parent();
        $categories = trans('search.categories');
        asort($categories);

        return view('sandbox', [
            'user'              => $user,
            'children'          => $children,
            'parent'            => $parent,
            'categories'        => $categories
        ]);
    }

    /**
     * Contact view
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contact(Request $request)
    {
        return view('contact');
    }

    /**
     * Contact form handling
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function contactSend(Request $request)
    {
        $this->validate($request, [
            'inputFirstName'    => 'required|max:255',
            'inputLastName'     => 'required|max:255',
            'inputEmail'        => 'required|email',
            'inputMessage'      => 'required',
        ]);

        // save message
        $message = new \App\Message();
        $message->first_name    = $request->input('inputFirstName');
        $message->last_name     = $request->input('inputLastName');
        $message->email         = $request->input('inputEmail');
        $message->message       = $request->input('inputMessage');
        $message->save();

        $admin  = User::find(1);
        $admin->notify(new NewMessage($message));

        return back();
    }
}
