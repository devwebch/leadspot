<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function contacts()
    {
        return $this->hasMany('App\Contact');
    }

    public function reports()
    {
        return $this->hasMany('App\Report');
    }
}
