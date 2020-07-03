<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Customer, Saving, Savings_collection,Withdrawal,Balance};
use App\Classes\{CustomerClass};
use Auth;

class CustomersController extends Controller
{
    public function StoreCustomer(Request $request, $customer_id = false){
        $this->validate($request, [
            'first_name'        => 'required|string|min:3|max:35',
            'surname'           => 'required|string|min:3|max:35',
            'other_name'        => 'required|string|min:3|max:35',
            'phone_number'      => 'required|string|max:14|min:11|unique:App\Customer,phone_number',
            'next_of_kin'       => 'required|string|min:3|max:35',
            'nok_relationship'  => 'required|string|max:8|min:5',
            'state'             => 'required|string|max:20|min:3',
            'lga'               => 'required|string|max:20|min:3',
            'community'         => 'required|string|max:40|min:3',
            'full_address'      => 'required|string|max:200|min:6',
            'email'             => 'nullable|email|max:100|min:5|unique:App\Customer,phone_number',
            'poverty_index'     => 'nullable|numeric|max:100|min:3',
            'gender'            => 'required|string|max:6|min:4',
            'customer_passport' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if($customer_id){//Means account is being updated
            $customer = Customer::findOrFail($customer_id);
            $redirect_ur = "/customers/view/$customer->id?new=updated";
        }
        else{//It's a new customer
            $customer =new Customer;
            $redirect_ur = "/customers/view/$customer->id?new=1";
            //create customer account no. for new account
            $customer_class = new CustomerClass('customers','create',0,0,Auth::id(),false);
            $customer->account_number   = $customer_class->get_account_no($customer->id);
        }
        $customer->staff_id         = Auth::id();
        $customer->first_name       = $request->first_name;
        $customer->surname          = $request->surname;
        $customer->other_name       = $request->other_name;
        $customer->phone_number     = $request->phone_number;
        $customer->next_of_kin      = $request->next_of_kin;
        $customer->nok_relationship = $request->nok_relationship;
        $customer->state            = $request->state;
        $customer->lga              = $request->lga;
        $customer->community        = $request->community;
        $customer->full_address     = $request->full_address;
        $customer->email            = $request->email;
        $customer->poverty_index    = $request->poverty_index;
        $customer->gender           = $request->gender;
        if($customer->save()){
            if(!$customer_id){
                $customer_class->set_customer($customer->id);
                $customer_class->save_transaction();
                //initialize the account balance to 0
                $balance = new Balance;
                $balance->customer_id = $customer->id;
                $balance->save();
            }
            //check if image was uploaded and process it.
            if ($request->hasFile('customer_passport')){
                $image = $request->file('customer_passport');
                $imageName = time().'_goodday_'.$customer->id.'.'.$image->getClientOriginalExtension();
                $move_path = (is_dir(public_path('../../public/images/')))? public_path('../../public/images/customers/'):'images/customers/' ;
                //check if the customer already has an image in the directory and delete before adding new one
                if($customer_id){
                    if(file_exists($move_path.'/'.$customer->passport_link)){
                        unlink($move_path.'/'.$customer->passport_link);
                    }
                }
                $image->move($move_path, $imageName);
                $customer->passport_link = $imageName;
                $customer->save();
            }
            session()->flash('info','Account details successfully saved.');
            return back();
            //return redirect($redirect_ur);
        }
    }
}
