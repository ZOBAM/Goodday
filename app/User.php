<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'surname', 'other_name','phone_number','email','bvn', 'password','designation','passport_link',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //get full name
    public function getFullNameAttribute(){
        return "{$this->surname} {$this->first_name}";
    }

    //set default passport for staffs
    public function getPassportAttribute(){
        $passport = $this->passport_link == null? "staff_img_placeholder.png" : $this->passport_link;
        return $passport;
    }

}
