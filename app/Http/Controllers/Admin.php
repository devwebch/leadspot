<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class Admin extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        if (Auth::id() != 4){
            return redirect('/nope');
        }
    }

    public function home(Request $request)
    {
        return 'admin';
    }
}
