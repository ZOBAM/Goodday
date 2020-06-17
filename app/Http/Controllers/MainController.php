<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Customer, Saving, Savings_collection};
use App\Classes\{CustomerClass};
use Auth;

class MainController extends Controller
{

    public function StoreSavings(Request $request, $customer_id = false){
        $this->validate($request, [
            'unit_amount'        => 'required|numeric|min:50|max:50000',
            'saving_interval'   => 'required|string|min:4|max:7',
            'start_date'        => 'nullable|date',
        ]);
            $saving = new Saving;
            $saving->unit_amount = $request->unit_amount;
            $saving->saving_interval = $request->saving_interval;
            if(!empty($request->input('start_date'))){
                $saving->start_date = $request->start_date;
            }
        return "Store savings route reached";
    }

    public function StoreCustomer(Request $request, $customer_id = false){
        $this->validate($request, [
            'first_name'        => 'required|string|min:3|max:35',
            'surname'           => 'required|string|min:3|max:35',
            'other_name'        => 'required|string|min:3|max:35',
            'phone_number'      => 'required|string|max:14|min:11',
            'next_of_kin'       => 'required|string|min:3|max:35',
            'nok_relationship'  => 'required|string|max:8|min:5',
            'state'             => 'required|string|max:20|min:3',
            'lga'               => 'required|string|max:20|min:3',
            'community'         => 'required|string|max:40|min:3',
            'full_address'      => 'required|string|max:200|min:6',
            'email'             => 'nullable|email|max:100|min:5',
            'poverty_index'     => 'nullable|numeric|max:100|min:3',
            'gender'            => 'required|string|max:6|min:4',
            'customer_passport' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if($customer_id){
            $customer = Customer::findOrFail($customer_id);
            $redirect_ur = "/customers/view/$customer->id?new=updated";
        }
        else{
            $customer =new Customer;
            $redirect_ur = "/customers/view/$customer->id?new=1";
            //create customer account no. for new account
            $customer_class = new CustomerClass;
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
            return redirect($redirect_ur);
        }
    }

    public function StoreLoans(Request $request){
        return "Store loan route reached";
    }
    //set customer session
    public function SetCurrentCustomer($customer){
        $names = ['John','Jane'];
        session(['current_customer' => $customer]);

        /* if(session()->has('key')){
            return "Session found";
        } */
    }
    //the below function will handle the various links based on provided section
    public function index($section = false, $action = false, $id = false){
        $variable_arr['card_header'] = 'Customer\'s Area';
        $sections = ['customers','savings','loans','staffs','transactions'];
        if(in_array($section,$sections)){
            switch($section){
                case 'customers':
                    $action = $action? $action : 'view';
                    $section_nav = [
                        'Create Account'          =>  '/customers/create',
                        'Update Account'     =>  '/customers/edit',
                        'View Account'    =>  '/customers/view',
                    ];
                    switch($action){
                        case 'create':
                        break;
                        case 'edit':
                            if(isset($_GET['account_number']) && is_numeric($_GET['account_number'])){
                                $account_number = 'GD'.$_GET['account_number'];
                                $variable_arr['customer'] = Customer::where('account_number',$account_number)->first();
                                if(!$variable_arr['customer']){
                                    $variable_arr['customer'] = false;
                                }
                                else{//set current customer session
                                    $this->SetCurrentCustomer($variable_arr['customer']);
                                }
                            }
                            else{
                                $variable_arr['customer'] = false;
                            }
                        break;
                        case 'view':
                            if(is_numeric($id)){
                                $variable_arr['new_customer'] = false;
                                if(isset($_GET['new'])){
                                    $variable_arr['new_customer'] = true;
                                }
                                $variable_arr['customer'] = Customer::findOrFail($id);
                                //set current customer session
                                $this->SetCurrentCustomer($variable_arr['customer']);
                            }
                            else{
                                $variable_arr['customers'] = Customer::get();
                            }
                        break;
                        default:
                        return redirect('/customer');
                    }//end switch
                    //return $section_nav;
                break;
                case 'savings':
                    $action = $action? $action : 'collection';
                    $section_nav = [
                        'Create Saving'          =>  '/savings/create',
                        'Add Collection'     =>  '/savings/collection',
                        'Disburse'    =>  '/savings/disburse',
                        'Close Saving'    =>  '/savings/close_saving'
                    ];
                break;
                case 'loans':
                    $action = $action? $action : 'repayment';
                    $section_nav = [
                        'New Loan'          =>  '/loans/create',
                        'Pending Loans'     =>  '/loans/pending',
                        'Approved Loans'    =>  '/loans/approved',
                        'Loan Repayment'    =>  '/loans/repayment'
                    ];
                break;
                case 'transactions':
                    $action = 'view';
                    $section_nav = [
                        'Today'          =>  '/transactions/today',
                        'This Week'     =>  '/transactions/week',
                        'This Month'    =>  '/transactions/month',
                    ];
                break;
                case 'staffs':
                    $action = $action? $action : 'create';
                    $section_nav = [
                        'Add Staff'          =>  'staffs/create',
                        'Remove Staff'     =>  'staffs/deactivate',
                    ];
            }//end switch section
        }//end if section in array of sections
        else{//this sectional nav will be displayed when no section is specified
            return redirect('customers/view');
        }
        return view("home",compact('section_nav','section','action','variable_arr'));
    }//end index function
}
