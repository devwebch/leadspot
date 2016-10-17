<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionsUsage extends Model
{
    protected $table = 'subscriptions_usage';

    /**
     * User related to SubscriptionUsage
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Increases the stored used count
     */
    public function increaseUse()
    {
        if ( $this->used < $this->limit ){
            $this->used += 1;
            $this->save();
        }
    }

    public function increaseUseByType($type)
    {
        $quotas = json_decode($this->quotas);

        if ( $quotas ) {
            $quotas->$type->used += 1;

            $quotas = json_encode($quotas);
            $this->quotas = $quotas;
            $this->save();
        }
    }

    /**
     * Decreases the stored used count
     */
    public function decreaseUse()
    {
        if ( $this->used > 0 ){
            $this->used -= 1;
            $this->save();
        }
    }
}
