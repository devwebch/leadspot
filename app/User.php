<?php

namespace App;

use App\Http\Controllers\SubscriptionServiceController;
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
        'first_name', 'last_name', 'email', 'password', 'company', 'parent_id'
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
        $relation = $this->hasOne('App\Subscription')->first();

        if ( $relation ) {
            $relation = config('subscriptions.label.' . $relation->stripe_plan);
        }

        return $relation;
    }

    public function subscriptionUsage()
    {
        return $this->hasOne('App\SubscriptionsUsage');
    }

    public function subscriptionParentUsage()
    {
        if ( $this->parent_id ) {
            return SubscriptionsUsage::where('user_id', $this->parent_id);
        } else {
            return $this->hasOne('App\SubscriptionsUsage');
        }
    }

    public function permissions()
    {
        $subscription_service   = new SubscriptionServiceController();
        $permissions            = $subscription_service->getSubscriptionPermissions();
        $permissions            = json_decode($permissions->content());

        return $permissions;
    }

    public function usageSearch()
    {
        if ( $this->parent_id ) {
            $usage = SubscriptionsUsage::where('user_id', $this->parent_id)->first();
        } else {
            $usage = $this->hasOne('App\SubscriptionsUsage')->first();
        }

        $usage = json_decode($usage->quotas);
        $usage = $usage->search;

        return $usage;
    }

    public function usageContacts()
    {
        if ( $this->parent_id ) {
            $usage = SubscriptionsUsage::where('user_id', $this->parent_id)->first();
        } else {
            $usage = $this->hasOne('App\SubscriptionsUsage')->first();
        }

        $usage = json_decode($usage->quotas);
        $usage = $usage->contacts;

        return $usage;
    }

    public function teamSlotsAvailable()
    {
        if ( $this->parent_id ) { return 0; }

        $subscription   = $this->hasOne('App\Subscription')->first();
        if ( !$subscription ) { return 0; }

        $plan           = $subscription->stripe_plan;
        $team           = User::where('parent_id', 1)->count();
        $team_size      = 0;
        $free_spots     = 0;

        switch ($plan) {
            case 'leadspot_boutique':
                $team_size = config('subscriptions.boutique.limit.teamsize');
                break;
            case 'leadspot_company':
                $team_size = config('subscriptions.company.limit.teamsize');
                break;
            case 'leadspot_agency':
                $team_size = config('subscriptions.agency.limit.teamsize');
                break;
        }

        $free_spots      = $team_size - $team;
        if ( $free_spots < 0 ) { $free_spots = 0; }
        if ( $free_spots > $team_size ) { $free_spots = $team_size; }

        return $free_spots;
    }

    public function parent()
    {
        return $this->where('id', $this->parent_id)->first();
    }

    public function children()
    {
        return $this->where('parent_id', $this->id)->get();
    }
}
