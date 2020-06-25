<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    public function customer(){
        return $this->belongsTo('App\Customer');
    }
    public function loan_repayment(){
        return $this->hasMany('App\Loan_repayment');
    }
}
