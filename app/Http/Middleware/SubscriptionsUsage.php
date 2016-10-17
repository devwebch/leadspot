<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use App\SubscriptionsUsage as Usage;

class SubscriptionsUsage
{
    /**
     * Check if a user's subscription usage is within the limits
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // get authenticated user
        $user                   = $request->user();
        $usage                  = $user->subscriptionUsage()->first();
        $quotas                 = json_decode($usage->quotas);
        $usage_diff             = $usage->updated_at->diffInHours(Carbon::now());

        // if daily use exceeds the limit
        if ( $usage->used >= $usage->limit ) {
            return redirect('/subscription/error/limit');
        }

        if ( $quotas->search->used >= $quotas->search->limit ) {
            return redirect('/subscription/error/limit');
        }

        return $next($request);
    }
}
