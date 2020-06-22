<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Customer, Loan, Loans_repayment,Withdrawal,Balance};
use App\Classes\{CustomerClass};
use Auth;

class LoansController extends Controller
{
    public function StoreLoans(Request $request, $customer_id = false){
        $this->validate($request, [
            'amount'       => 'required|numeric|min:1000|max:200000',
            'loan_type'   => 'required|string|min:4|max:15',
            'duration'   => 'required|string|min:4|max:7',
            'repay_interval'   => 'required|string|min:4|max:10',
            'application_date'        => 'nullable|date',
            'first_repay_date'        => 'required|date',
            'paid_admin'        => 'required|string',
            'paid_insurance'        => 'required|string',
        ]);
        /* if($request->has('paid-admin')){
            return "Paid admin!";
        } */
        $customer = new Customer;
        $loan = new Loan;
        $loan->amount = $request->amount;
        $loan->receiver_id = $customer_id;
        $loan->repay_amount = $request->amount + ($request->amount * $customer->interest_rate);
        $loan->loan_type = $request->loan_type;
        $loan->duration = $request->duration;
        $loan->repay_interval = $request->repay_interval;
        $loan->application_date = $request->application_date;
        $loan->first_repay_date = $request->first_repay_date;
        $loan->save();
        return "Store loan route reached";
    }
}
