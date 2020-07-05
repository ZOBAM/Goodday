<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\{Customer, Loan, Loan_repayment,Withdrawal,Balance};
use App\Classes\{CustomerClass};
use Auth;

class LoansController extends Controller
{
    public function StoreLoans(Request $request, $customer_id = false,$action = false){
        //LOAN REPAYMENT
        if ($action == 'repay') {
            $loan_repayment = Loan_repayment::where('id', $customer_id)->first();
            $loan_repayment->repaid = true;
            $loan_repayment->defaulted = false;
            $loan_repayment->approved_by = Auth::id();
            if($loan_repayment->save()){
                $loan = Loan::where('id',$loan_repayment->loan_id)->first();
                $loan->outstanding_amount -= $loan_repayment->amount_repaid;
                $loan->disbursed_date = Carbon::now();
                if($loan->outstanding_amount == 0){
                    $loan->loan_cleared = true;
                }
                $loan->save();
                $customer_class = new CustomerClass('loans','repay',$loan_repayment->amount_repaid,Session()->get('current_customer')->id,$loan_repayment->approved_by,false);
                $customer_class->save_transaction();
                $customer_class->update_account();
                //Session()->flash('info','Loan repayment has been successfully saved.');
                session()->flash('info','Loan repayment has been successfully saved.');
                return back();
            }
        }
        //NEW LOAN APPLICATION
        else{
            $this->validate($request, [
                'amount'       => 'required|numeric|min:1000|max:200000',
                'loan_type'   => 'required|string|min:4|max:15',
                'duration'   => 'required|numeric|min:7|max:90',
                'repay_interval'   => 'required|string|min:4|max:10',
                'application_date'        => 'nullable|date',
                'first_repay_date'        => 'required|date',
                'paid_admin'        => 'required|string',
                'paid_insurance'        => 'required|string',
            ]);
            /* if($request->has('paid_admin')){
                return $request->paid_admin;
            } */
            $customer = new Customer;
            $loan = new Loan;
            $customer_class = new CustomerClass('loans','create',$request->paid_admin*2,$customer_id,Auth::id(),false);
            $loan->amount = $request->amount;
            $loan->customer_id = $customer_id;
            $loan->repay_amount = $request->amount + ($request->amount * $customer_class->get_interest_rate());
            $loan->loan_type = $request->loan_type;
            $loan->duration = $request->duration;
            $loan->repay_interval = $request->repay_interval;
            $loan->application_date = $request->application_date;
            $loan->repay_unit = $request->amount/3;
            $loan->outstanding_amount = $loan->repay_amount;
            $loan->first_repay_date = $request->first_repay_date;
            if($loan->save()){
                $customer_class->save_transaction();
                $customer_class->update_account();
                //calculate the due date for repayment(s) and the unit repay amount
                switch ($loan->repay_interval) {
                    case 'daily':
                        $num_of_payments = $loan->duration;
                        $loan->repay_unit = $loan->repay_amount/$num_of_payments;
                        //$loan->last_repay_date = $request->first_repay_date;
                        $loan->save();
                        $first_repay_date = Carbon::createFromDate($request->first_repay_date);
                        //return $request->first_repay_date->toFormattedDateString();
                        $due_dates[] = $first_repay_date;
                        for ($i=1; $i < $num_of_payments; $i++) {
                            $due_dates[] = Carbon::createFromDate($request->first_repay_date)->addDays($i);
                        }
                        break;
                    case 'weekly':
                        $num_of_payments = $loan->duration/7;
                        $loan->repay_unit = $loan->repay_amount/$num_of_payments;
                        //$loan->last_repay_date = $request->first_repay_date;
                        $loan->save();
                        $first_repay_date = Carbon::createFromDate($request->first_repay_date);
                        //return $request->first_repay_date->toFormattedDateString();
                        $due_dates[] = $first_repay_date;
                        for ($i=1; $i < $num_of_payments; $i++) {
                            $due_dates[] = Carbon::createFromDate($request->first_repay_date)->addWeeks($i);
                        }
                        break;

                    case 'monthly':
                        $num_of_payments = $loan->duration/30;
                        $loan->repay_unit = $loan->repay_amount/$num_of_payments;
                        //$loan->last_repay_date = $request->first_repay_date;
                        $loan->save();
                        $first_repay_date = Carbon::createFromDate($request->first_repay_date);
                        $due_dates[] = $first_repay_date;
                        for ($i=1; $i < $num_of_payments; $i++) {
                            $due_dates[] = Carbon::createFromDate($request->first_repay_date)->addMonths($i);
                        }
                        break;
                }//end switch
                foreach ($due_dates as $key => $due_date) {
                    $loan_repayment = new Loan_repayment;
                    $loan_repayment->loan_id = $loan->id;
                    $loan_repayment->amount_repaid = $loan->repay_unit;
                    $loan_repayment->due_date = $due_date;
                    $loan_repayment->install_number = $key + 1;
                    $loan_repayment->repaid = false;
                    $loan_repayment->defaulted = false;
                    $loan_repayment->save();
                }
                session()->flash('info','Loan Application has been successfully saved.');
                return back();
            }
        }
    }//endstoreLoans
    public function repayment_schedule($loan){

    }
}
