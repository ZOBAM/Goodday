<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function loan(){
        return $this->hasMany('App\Loan');
    }
    /* public function saving(){
        return $this->hasMany('App\Saving');
    } */
    //get full name
    public function getFullNameAttribute(){
        return "{$this->surname} {$this->first_name}";
    }
    //set default passport for staffs
    public function getPassportAttribute(){
        $passport = $this->passport_link == null? "customer_img_placeholder.png" : $this->passport_link;
        return $passport;
    }
}
