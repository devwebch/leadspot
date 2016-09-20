<?php

namespace App\Http\Middleware;

use Closure;

class Subscribed
{
    /**
     * Check if a user has an active paid subscription
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // not a paying customer
        if ( $request->user() && !$request->user()->subscribed('main') ) {
            return redirect('/');
        }

        return $next($request);
    }
}
