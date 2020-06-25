<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    public function savings_collection(){
        return $this->hasMany('App\Savings_collection');
    }
    public function customer(){
        return $this->belongsTo('App\Customer');
    }
}
