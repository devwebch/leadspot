<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function lead()
    {
        return $this->belongsTo('App\Lead');
    }
}
