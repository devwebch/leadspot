<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function plan()
    {
        $plan = '';
        if ( $this->stripe_plan ) {
            $plan = config('subscriptions.label.' . $this->stripe_plan);
        }

        return $plan;
    }
}
