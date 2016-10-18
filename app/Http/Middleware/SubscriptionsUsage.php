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
    public function handle($request, Closure $next, $type)
    {
        // get authenticated user
        $user                   = $request->user();
        $usage                  = $user->subscriptionParentUsage()->first();
        $quotas                 = json_decode($usage->quotas);
        $usage_diff             = $usage->updated_at->diffInHours(Carbon::now());

        // Usage type is Search
        if ( $type == 'search' ) {
            if ( $quotas->search->used >= $quotas->search->limit ) {
                return redirect('/');
            }
        }

        // Usage type is Contacts
        if ( $type == 'contacts' ) {
            if ( $quotas->contacts->used >= $quotas->contacts->limit ) {
                return redirect('/');
            }
        }

        return $next($request);
    }
}
