<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\{User, Saving, Savings_collection,Withdrawal,Balance,Guarantor};

class Group extends Model
{
    public function customer(){
        return $this->hasMany('App\Customer');
    }
    //get full name
    public function getStaffNameAttribute(){
        $staff = User::find($this->staff_in_charge);
        return "{$staff->full_name}";
    }
}
