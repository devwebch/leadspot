<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use App\SubscriptionsUsage as Usage;

class SubscriptionsUsage
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
        // get authenticated user
        $user                   = $request->user();
        $subscription_usage     = $user->subscriptionUsage()->first();
        $usage_diff             = $subscription_usage->updated_at->diffInHours(Carbon::now());

        // if daily use exceeds the limit
        if ( $subscription_usage->used >= $subscription_usage->limit ) {
            return redirect('/subscription/error/limit');
        }

        // if latest update date from at least 24h, reset
        if ( $usage_diff >= 24 ) {
            return view('Limit mise à jour');
        }


        return $next($request);
    }
}
