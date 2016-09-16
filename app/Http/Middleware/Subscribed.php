<?php

namespace App\Http\Middleware;

use Closure;

class Subscribed
{
    /**
     * Handle an incoming request.
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
