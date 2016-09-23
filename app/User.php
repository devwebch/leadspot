<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'company'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function leads()
    {
        return $this->hasMany('App\Lead');
    }

    public function getSubscription()
    {
        $relation = $this->hasOne('App\Subscription')->get()->first();

        if ( $relation ) {
            $relation = config('subscriptions.label.' . $relation->stripe_plan);
        }

        return $relation;
    }

    public function subscriptionUsage()
    {
        return $this->hasOne('App\SubscriptionsUsage');
    }
}
