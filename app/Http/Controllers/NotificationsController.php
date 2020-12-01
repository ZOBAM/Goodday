<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{User,Customer,Balance,Loan_repayment,Sent_sms};
use Carbon\Carbon;

class NotificationsController extends Controller
{
    public function defaulted_loans(){//this method will be called from the sms method below to ensure it runs once per day
        $defaulted_loans = Loan_repayment::where('repaid', false)->whereDate('due_date','<',Carbon::today())->orderBy('due_date','DESC')->get();
        $exceeded_grace_period = [];//hold repayments that exceeded grace period
        $loan_ids = [];//hold loan ids for repayments
        $receivers_ids = '';
        $sms_count = 0;
        foreach($defaulted_loans as $defaulted_loan){
            $first_due_date = Carbon::createFromDate($defaulted_loan->due_date);
            $today = Carbon::now();
            $defaulted_days = $today->diffInDays($first_due_date);
            if($defaulted_days > 7 && !in_array($defaulted_loan->loan->id, $loan_ids )){
                $loan_ids[] = $defaulted_loan->loan->id;
                $exceeded_grace_period[] = $defaulted_loan;
                $penalty_days = $defaulted_days - 7;
                $penalty_amount = $penalty_days * (2/100) * $defaulted_loan->loan->outstanding_amount;//2% of remaining loan repay amount
                $defaulted_loan->defaulted = $defaulted_days;
                $defaulted_loan->default_penalty = $penalty_amount;
                $defaulted_loan->new_due_amount = $defaulted_loan->amount_repaid + $penalty_amount;
                //send sms and update db for only those not in a group
                if($defaulted_loan->loan->customer->group_id !== null && $defaulted_loan->save()){
                    $phone_number = $defaulted_loan->loan->customer->phone_number;
                    $message = $defaulted_loan->loan->customer->first_name . ", your Over-Due Loan Repayment of N".$defaulted_loan->amount_repaid." default penalty is N".$penalty_amount." Visit our branch or Acc No: 1401437462 (GOODDAY COMMISSION AGENCY)  Access Bank. GoodDay Team";
                    $receivers_ids .= $defaulted_loan->loan->customer->id.',';
                    $sms_count += 1;
                    //file_get_contents("https://www.bulksmsnigeria.com/api/v1/sms/create?api_token=xqJj8Y1K7p7cET4AaB1CU7kIPF5O4ANqMiNq5J0ym6e9ZSiXQzlwPex0wpm2&from=GOODDAY&to=$phone_number&body=".urlencode($message)."&dnd=2");
                    $defaulted_loan->loan->total_default_days == null? $defaulted_days : $defaulted_days + 1;
                    $defaulted_loan->loan->save();
                }
            }
        }//end foreach defaulted loan
        $sent_sms = new Sent_sms;
        $sent_sms->receivers_ids = $receivers_ids;
        $sent_sms->sent_count = $sms_count;
        $sent_sms->remind_type = 'Defaulted Loans';
        //return $sent_sms->comment;
        $sent_sms->save();
        return $exceeded_grace_period;
    }
    public function sms(){
        $sent_today = Sent_sms::whereDate('created_at',Carbon::today())->first();
        if(!$sent_today){
            $tomorrow_loans = Loan_repayment::where('repaid', false)->whereDate('due_date',Carbon::tomorrow())->get();
            $today_loans = Loan_repayment::where('repaid', false)->whereDate('due_date',Carbon::today())->get();
            //return count($today_loans);
            if(count($tomorrow_loans)>0){//run the loop only if there are any loans due tomorrow
                $receivers_ids = '';
                $sms_count = 0;
                foreach($tomorrow_loans as $loan_repayment){
                    $phone_number = $loan_repayment->loan->customer->phone_number . ',';
                    $message = $loan_repayment->loan->customer->first_name . ", Reminder of Due Loan Repayment of N".$loan_repayment->amount_repaid." by tomorrow. Visit our branch or Acc No: 1401437462 (GOODDAY COMMISSION AGENCY)  Access Bank. GoodDay Team";
                    if($loan_repayment->loan->customer->group_id == null){//send sms to only customers that are not in a group
                        $receivers_ids .= $loan_repayment->loan->customer->id.',';
                        $sms_count += 1;
                        file_get_contents("https://www.bulksmsnigeria.com/api/v1/sms/create?api_token=xqJj8Y1K7p7cET4AaB1CU7kIPF5O4ANqMiNq5J0ym6e9ZSiXQzlwPex0wpm2&from=GOODDAY&to=$phone_number&body=".urlencode($message)."&dnd=2");
                    }
                }
                $sent_sms = new Sent_sms;
                $sent_sms->receivers_ids = $receivers_ids;
                $sent_sms->sent_count = $sms_count;
                $sent_sms->remind_type = 'Due tomorrow';
                $sent_sms->comment = "Total loans due were ".count($tomorrow_loans).". The total of SMS sent is $sms_count. ".(count($tomorrow_loans) - $sms_count)." are members of groups and therefore no SMS sent to them.";
                //return $sent_sms->comment;
                $sent_sms->save();
            }
            if(count($today_loans)>0){//run the loop only if there are any loans due today
                foreach($today_loans as $loan_repayment){
                    $phone_number = $loan_repayment->loan->customer->phone_number . ',';
                    $message = $loan_repayment->loan->customer->first_name . ", Reminder of Due Loan Repayment of N".$loan_repayment->amount_repaid." today. Visit our branch or Acc No: 1401437462 (GOODDAY COMMISSION AGENCY)  Access Bank. GoodDay Team";
                    if($loan_repayment->loan->customer->group_id == null){//send sms to only customers that are not in a group
                        $receivers_ids .= $loan_repayment->loan->customer->id.',';
                        $sms_count += 1;
                        file_get_contents("https://www.bulksmsnigeria.com/api/v1/sms/create?api_token=xqJj8Y1K7p7cET4AaB1CU7kIPF5O4ANqMiNq5J0ym6e9ZSiXQzlwPex0wpm2&from=GOODDAY&to=$phone_number&body=".urlencode($message)."&dnd=2");
                    }
                }
                $sent_sms = new Sent_sms;
                $sent_sms->receivers_ids = $receivers_ids;
                $sent_sms->sent_count = $sms_count;
                $sent_sms->remind_type = 'Due Today';
                $sent_sms->comment = "Total loans due were ".count($today_loans).". The total of SMS sent is $sms_count. ".(count($today_loans) - $sms_count)." are members of groups and therefore no SMS sent to them.";
                $sent_sms->save();
            }
            $result = $this->defaulted_loans();
            return 1;
        }//end if sent today
        else{
            $result = $this->defaulted_loans();
            return $result;
            return -1;//already sent sms for today
        }
    }
}
