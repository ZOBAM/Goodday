<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\{Customer, Loan, Loan_repayment,Withdrawal,Balance,Transaction};
use App\Classes\{CustomerClass};
use Auth;

class LoansController extends Controller
{
    public function getDueDates(){
        $call;
    }
    public function StoreLoans(Request $request, $customer_id = false,$action = false){
        //LOAN REPAYMENT
        /* $customer_class = new CustomerClass('loans','repay',2000,Session()->get('current_customer')->id,Auth::id(),false);
        $customer_class->set_customer(Session()->get('current_customer')->id);
        return $customer_class->get_max_loan(); */

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
        //REPAY ALL OUTSTANDING REPAYMENT
        elseif($action == 'repay_all'){
            $loan = Loan::findOrFail($customer_id);//get the customer loan using Loan ID from submitted form
            $outstanding_amount = $loan->outstanding_amount;//copy outstanding amount into a new variable
            $loan->loan_cleared = true;
            $loan->outstanding_amount = 0;
            if($loan->save()){
                $loan_repayments = Loan_repayment::where('loan_id',$loan->id)->get();
                foreach($loan_repayments as $loan_repayment){//loop through all the pending due payment and clear them
                    $loan_repayment->repaid = true;
                    $loan_repayment->defaulted = false;
                    $loan_repayment->approved_by = Auth::id();
                    $loan_repayment->save();
                }
            }
            $customer_class = new CustomerClass('loans','repay_all',$outstanding_amount,Session()->get('current_customer')->id,Auth::id(),false);
            $customer_class->save_transaction();
            $customer_class->update_account();
            session()->flash('info','All outstanding loan repayment cleared!.');
            Session()->get('current_customer')->has_loan = false;
            return back();
            //return "All outstanding loan repayment cleared!";
        }
        //PART PAYMENT
        elseif($action == 'part_repayment'){
            $part_repaid = $request->amount_repaid;
            $loan_repay_id = $customer_id;
            $loan_repayment = Loan_repayment::findOrFail($loan_repay_id);
            $loan = Loan::findOrFail($loan_repayment->loan_id);
            $ppp = (10/100) * $loan->outstanding_amount; //ppp = part payment penalty
            if($part_repaid >= $ppp){
                $loan_repayment->amount_repaid -= ($part_repaid - $ppp);
                $loan->outstanding_amount -= ($part_repaid - $ppp);
                //return "PR bigger ppp";
            }
            else{
                $loan_repayment->amount_repaid += ($ppp - $part_repaid);
                $loan->outstanding_amount += ($ppp - $part_repaid);
            }
            $loan_repayment->approved_by = Auth::id();
            $loan_repayment->defaulted = false;
            $loan_repayment->repaid = false;
            $loan_repayment->save();
            $loan->save();
            //get all unpaid repayments and shift their date by repay_interval
            $unpaid_repayments = Loan_repayment::where('loan_id',$loan_repayment->loan_id)->where('repaid',false)->get();
            foreach($unpaid_repayments as $unpaid_repayment){
                $due_date = Carbon::createFromDate($unpaid_repayment->due_date);
                if($loan->repay_interval == 'daily'){
                    $unpaid_repayment->due_date = Carbon::createFromDate($due_date->toDateTimeString())->addDay();
                }
                elseif($loan->repay_interval == 'weekly'){
                    $unpaid_repayment->due_date = Carbon::createFromDate($due_date->toDateTimeString())->addWeek();
                }
                elseif($loan->repay_interval == 'monthly'){
                    $unpaid_repayment->due_date = Carbon::createFromDate($due_date->toDateTimeString())->addMonth();
                }
                $unpaid_repayment->save();
            }
            $customer_class = new CustomerClass('loans','part_repay',$part_repaid,Session()->get('current_customer')->id,Auth::id(),false);
            $customer_class->save_transaction();
            $customer_class->update_account();
            session()->flash('info','Partial Loan Repayment Saved');
            return back();
            //return "Making part payment ...$loan_repayment  ___________ $ppp";
        }
        //DELETE LOAN
        elseif ($action == 'delete'){
            $loan_id = $customer_id;
            $loan = Loan::findOrFail($loan_id);
            $transactions = Transaction::where('ref_id','like','%LNS'.$loan->customer_id.'%')->orderBy('created_at','DESC')->take(2)->get();
            $transaction_amount = $transactions[1]->amount;
            //get company balance and deduct loan fee amount
            $company_balance = Balance::where('customer_id',1)->first();
            $company_balance->amount -= $transaction_amount;
            $company_balance->save();
            //soft delete the transactions record
            if(Loan::destroy($loan_id)){
                foreach($transactions as $transaction){
                    $transaction->deleted = true;
                    $transaction->save();
                }
            }
            session()->flash('info','Loan Application has been successfully deleted.');
            return back();
            //return "Loan Delete Route Reached. $loan_id | $transaction_amount<br> Comp. Balance: $company_balance->amount";
        }
        //NEW LOAN APPLICATION
        else{
            $this->validate($request, [
                'amount'            => 'required|numeric|min:1000|max:1000000',
                'loan_type'         => 'required|string|min:4|max:15',
                'duration'          => 'required|numeric|min:7|max:180',
                'repay_interval'    => 'required|string|min:4|max:10',
                'application_date'  => 'nullable|date',
                'first_repay_date'  => 'required|date',
                'paid_admin'        => 'required|string',
                'paid_insurance'    => 'required|string',
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
            $loan->repay_unit = $request->amount/3;//this is mock data will be replaced down the line;
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
                        $loan->duration = floor($loan->duration/28) * 28;
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
