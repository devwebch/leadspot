<?php

namespace App\Http\Controllers;

use App\Lead;
use App\Mail\LeadSample;
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
        $user                   = $request->user();
        $parent                 = $user->parent();

        $lead_author = $user->id;
        if ( $parent ) {
            $lead_author = $parent->id;
        }

        // retrieve lead status
        $status = config('constants.lead.status');

        $status_classes = config('constants.lead.classes');

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

        $fake_leads = (object)[
            [
                'name'      => 'Lead 1',
                'address'   => 'Chemin des Primevères 2',
                'website'   => 'http://www.site1.com',
                'scores'    => ['speed' => 98, 'usability' => 55]
            ],
            [
                'name'      => 'Lead 2',
                'address'   => 'Chemin des Primevères 2',
                'website'   => 'http://www.site2.com',
                'scores'    => ['speed' => 45, 'usability' => 75]
            ],
            [
                'name'      => 'Lead 3',
                'address'   => 'Chemin des Primevères 2',
                'website'   => 'http://www.site3.com',
                'scores'    => ['speed' => 37, 'usability' => 84]
            ],
        ];


        Mail::to('simon.rapin@gmail.com')->send(new LeadSample($fake_leads));

        return view('sandbox', [
            'user'              => $user,
            'children'          => $children,
            'parent'            => $parent
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
