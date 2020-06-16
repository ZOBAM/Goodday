<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{Customer};

class CustomersController extends Controller
{
    public function index($customer_id = false){
        return Customer::find($customer_id);
    }
}
