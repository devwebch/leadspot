<?php

namespace App\Http\Controllers;

use App\Lead;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home(Request $request)
    {
        // get the authenticated user
        $user   = $request->user();

        // retrieve lead status
        $status = config('constants.lead.status');

        $status_classes = [
            0   => '',
            1   => 'label-warning',
            2   => 'label-success',
            3   => 'label-danger'
        ];

        $leads  = Lead::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('home', [
            'leads'             => $leads,
            'status'            => $status,
            'status_classes'    => $status_classes
        ]);
    }
}
