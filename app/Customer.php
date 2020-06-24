<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function loan(){
        return $this->hasMany('App\Loan');
    }
    //get full name
    public function getFullNameAttribute(){
        return "{$this->surname} {$this->first_name}";
    }
}
