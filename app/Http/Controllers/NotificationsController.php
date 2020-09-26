<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{User,Customer,Balance,Loan_repayment};
use Carbon\Carbon;

class NotificationsController extends Controller
{
    public function sms(){
        $tomorrow_loans = Loan_repayment::where('repaid', false)->where('due_date',Carbon::tomorrow())->get();
        $today_loans = Loan_repayment::where('repaid', false)->where('due_date',Carbon::today())->get();
        if(count($tomorrow_loans)>0){//run the loop only if there are any loans due tomorrow
            foreach($tomorrow_loans as $loan_repayment){
                $phone_number = $loan_repayment->loan->customer->phone_number . ',';
                $message = $loan_repayment->loan->customer->first_name . ", Reminder of Due Loan Repayment of N".$loan_repayment->amount_repaid." by tomorrow. Visit our branch or Acc No: 1401437462 (GOODDAY COMMISSION AGENCY)  Access Bank. GoodDay Team";
                if($loan_repayment->loan->customer->group_id == null){//send sms to only customers that are not in a group
                    file_get_contents("https://www.bulksmsnigeria.com/api/v1/sms/create?api_token=xqJj8Y1K7p7cET4AaB1CU7kIPF5O4ANqMiNq5J0ym6e9ZSiXQzlwPex0wpm2&from=GOODDAY&to=$phone_number&body=".urlencode($message)."&dnd=2");
                }
            }
        }
        if(count($today_loans)>0){//run the loop only if there are any loans due today
            foreach($today_loans as $loan_repayment){
                $phone_number = $loan_repayment->loan->customer->phone_number . ',';
                $message = $loan_repayment->loan->customer->first_name . ", Reminder of Due Loan Repayment of N".$loan_repayment->amount_repaid." today. Visit our branch or Acc No: 1401437462 (GOODDAY COMMISSION AGENCY)  Access Bank. GoodDay Team";
                if($loan_repayment->loan->customer->group_id == null){//send sms to only customers that are not in a group
                    file_get_contents("https://www.bulksmsnigeria.com/api/v1/sms/create?api_token=xqJj8Y1K7p7cET4AaB1CU7kIPF5O4ANqMiNq5J0ym6e9ZSiXQzlwPex0wpm2&from=GOODDAY&to=$phone_number&body=".urlencode($message)."&dnd=2");
                }
            }
        }
    }
}
