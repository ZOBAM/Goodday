<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Customer, Saving, Savings_collection,Withdrawal,Balance,Guarantor,Transaction};
use App\Classes\{CustomerClass};
use Auth;

class CustomersController extends Controller
{
    public function index(Request $request, $customer_id = false, $action = false){
        if($action == 'delete'){
            $t_arr = [];
            $customer = Customer::findOrFail($customer_id);
            $customer_balance = Balance::where('customer_id',$customer_id)->first();
            if($customer_balance->amount >= 50){
                session()->flash('info','<span style="color: red;font-weight:bolder">You cannot delete a customer\'s account while he/she still has balance in account</span>.<hr> Withdraw/Clear the balance and then delete the account.');
                return back();
            }
            //check if in group and remove
            $message = '';
            if($customer->group_id != null){
                $customer_class = new CustomerClass('Group','Remove',0,$customer_id,Auth::id());
                $message .= $customer_class->remove_from_group($customer_id);
                //return "This customer is in a group";
            }
            if(Customer::destroy($customer_id)){
                $query_str = $customer_id.'-';
                $transactions = Transaction::where('ref_id','like',"%$query_str%")->get();
                if($transactions){
                    //a way to filter out SVS15- from SVS115- by checking for the transaction code and the customer id
                    foreach($transactions as $transaction){
                        $t_code = substr($transaction->ref_id,0,3);
                        /* return false === 0? 'true':'false';
                        return strpos($transaction->ref_id, $t_code); */
                        if(strpos($transaction->ref_id, $t_code.$customer_id) === 0){
                            $transaction->deleted = true;
                            $transaction->save();
                            //$t_arr[] = $transaction->ref_id;
                        }
                    }
                }
                session()->forget('current_customer');
                session()->flash('info',$message.'<hr>Customer Account successfully deleted.');
                return redirect('/customers');
            }
        }
        $this->validate($request, [
            'first_name'        => 'required|string|min:3|max:35',
            'surname'           => 'required|string|min:3|max:35',
            'other_name'        => 'nullable|string|min:3|max:35',
            'phone_number'      => 'nullable|string|max:14|min:11',
            'next_of_kin'       => 'nullable|string|min:3|max:35',
            'nok_relationship'  => 'nullable|string|max:8|min:5',
            'state'             => 'nullable|string|max:20|min:3',
            'lga'               => 'nullable|string|max:20|min:3',
            'community'         => 'nullable|string|max:40|min:3',
            'full_address'      => 'nullable|string|max:200|min:6',
            'email'             => 'nullable|email|max:100|min:5',
            'poverty_index'     => 'nullable|numeric|max:100|min:3',
            'gender'            => 'nullable|string|max:6|min:4',
            'customer_passport' => 'image|mimes:jpeg,png,jpg|max:5120',
        ]);
        if($customer_id){//Means account is being updated
            $customer = Customer::findOrFail($customer_id);
            $guarantor = Guarantor::where('customer_id',$customer_id);
            $redirect_ur = "/customers/view/$customer->id?new=updated";
        }
        else{//It's a new customer
            $this->validate($request, [
                'phone_number'      => 'unique:App\Customer,phone_number',
                'email'             => 'unique:App\Customer,email',
            ]);
            $customer   = new Customer;
            $guarantor  = new Guarantor;
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
        if($request->has('gresident_address')){
            $this->validate($request, [
                'gfull_name'        => 'required|string|min:6|max:55',
                'gphone_number'     => 'required|string|max:14|min:11|unique:App\Guarantor,gphone_number',
                'grelationship'     => 'required|string|max:8|min:5',
                'gresident_address' => 'required|string|max:200|min:6',
                'gwork_address'     => 'required|string|max:200|min:6',
                'goccupation'       => 'required|string|max:200|min:6',
            ]);
        }
        if($customer->save()){
            if($request->has('gresident_address')){
                $guarantor->gfull_name          = $request->gfull_name;
                $guarantor->gphone_number       = $request->gphone_number;
                $guarantor->grelationship       = $request->grelationship;
                $guarantor->gresident_address   = $request->gresident_address;
                $guarantor->gwork_address       = $request->gwork_address;
                $guarantor->goccupation         = $request->goccupation;
                $guarantor->customer_id         = $customer->id;
                $guarantor->save();
            }
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
