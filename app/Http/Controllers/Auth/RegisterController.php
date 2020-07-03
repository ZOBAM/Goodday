<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'other_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'bvn' => ['required', 'numeric', 'min:10000000000'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'passport' => ['image', 'mimes:jpeg,png,jpg', 'max:2024'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'surname' => $data['surname'],
            'other_name' => $data['other_name'],
            'phone_number' => $data['phone_number'],
            'bvn' => $data['bvn'],
            'email' => $data['email'],
            'designation' => 'staff',
            'password' => Hash::make($data['password']),
        ]);
        //check if image was uploaded and process it.
        if (isset($data['passport'])){
            $image = $data['passport'];
            $imageName = time().'_goodday_staff'.$user->id.'.'.$image->getClientOriginalExtension();
            $move_path = (is_dir(public_path('../../public/images/')))? public_path('../../public/images/staffs/'):'images/staffs/' ;
            //check if the customer already has an image in the directory and delete before adding new one
            /* if($customer_id){
                if(file_exists($move_path.'/'.$customer->passport_link)){
                    unlink($move_path.'/'.$customer->passport_link);
                }
            } */
            $image->move($move_path, $imageName);
            $user->passport_link = $imageName;
            $user->save();
        }
        return $user;
    }
}
