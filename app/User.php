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
        $staff_dp_path = (is_dir(public_path("../../public/images/")))? public_path("../../public/images/staffs/$this->passport_link"):"images/staffs/$this->passport_link" ;
        $passport = ($this->passport_link == null || !file_exists($staff_dp_path))? "staff_img_placeholder.png" : $this->passport_link;
        return $passport;
    }

}
