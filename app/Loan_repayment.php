<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan_repayment extends Model
{
    public function loan(){
        return $this->belongsTo('App\Loan');
    }
}
