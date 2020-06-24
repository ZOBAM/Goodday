<?php

namespace App\Http\Controllers\Api;
use Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{Customer, Transaction};
use App\Classes\{CustomerClass};

class CustomersController extends Controller
{
    public function index($customer_id = false){
        $customer = new CustomerClass('loans',2000,1,1);
        //return Auth::id();($type, $amount, $customer_id, $staff_id)
        return $customer->get_transaction_ref();
        //return Customer::find($customer_id);
    }
}
