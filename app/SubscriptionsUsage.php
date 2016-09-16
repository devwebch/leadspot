<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionsUsage extends Model
{
    protected $table = 'subscriptions_usage';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function increaseUse()
    {
        if ( $this->used < $this->limit ){
            $this->used += 1;
            $this->save();
        }
    }
}
