<?php
namespace App\Classes;
use Carbon\Carbon;
use App\{User,Customer,Balance,Transaction, Loan};
use Auth;

class CustomerClass {
    private $max_loan_amount = 200000;// two hundred thousand naira
    private $min_loan_amount = 1000;// one thousand naira
    private $interest_rate = 20/100;// interest rate of 20%
    private $account_no;
    //private $balance;
    private $transaction_ref;
    private $transaction_count;
    private $transaction;
    private $staff;
    private $customer;
    private $type;
    private $subtype;
    private $amount;
    private $comment;
    private $gday_balance;

    public function __construct($type, $subtype, $amount, $customer_id, $staff_id,$update_account){
        $this->transaction_count = Transaction::count();
        $this->transaction = new Transaction;
        $this->gday_balance = Balance::where('id',1)->first();
        $this->customer = Customer::where('id',$customer_id)->first();
        $this->staff = User::where('id',$staff_id)->first();
        $this->amount = $amount;
        $this->type = $type;
        $this->subtype = $subtype;
        $this->comment = "Transaction of $this->amount was recorded";
        if($update_account){
            $this->update_account();
        }
    }
    public function set_customer($customer_id){
        $this->customer = Customer::where('id',$customer_id)->first();
    }
    public function get_interest_rate(){
        return $this->interest_rate;
    }
    //if title image = false, get all images of this ad else get only the first images
    public function get_account_no($customer_id){
        $this->account_no = 'GD'.str_pad($customer_id,5,"0",STR_PAD_LEFT).rand(100,999);
        return $this->account_no;
    }//end get ad images
    public function get_transaction_ref(){//if title image is false, get all images of this ad
        switch ($this->type) {
            case 'customers':
                $this->transaction_ref = 'CTM';
                if($this->subtype = 'create'){
                    $this->comment = $this->customer->full_name. " account was created by ".$this->staff->full_name;
                }
                break;

            case 'savings':
                $this->transaction_ref = 'SVS';
                if($this->subtype == 'create'){
                    $this->comment = $this->customer->full_name. " Started a new Saving Cycle via ".$this->staff->full_name;
                }
                elseif($this->subtype == 'collection'){
                    $this->comment = $this->customer->full_name. " saved $this->amount via ".$this->staff->full_name;
                }
                elseif($this->subtype == 'disburse'){
                    $this->comment = $this->customer->full_name. " withdrew the sum of ₦".abs($this->amount)." via ".$this->staff->full_name;
                }
                elseif($this->subtype == 'close'){
                    $this->comment = $this->customer->full_name. " closed saving of ₦".abs($this->amount)." via ".$this->staff->full_name;
                }
                elseif($this->subtype == 'just_save'){
                    $this->comment = $this->customer->full_name. " saved the sum of ₦".abs($this->amount)." via ".$this->staff->full_name;
                }
                break;

            case 'loans':
                $this->transaction_ref = 'LNS';
                if($this->subtype == 'create'){
                    $this->comment = $this->customer->full_name. " Loan Application Fees of ₦$this->amount was received via ".$this->staff->full_name;
                }
                elseif($this->subtype == 'approve'){
                    $this->comment = $this->customer->full_name. " Loan Application was approved by ".$this->staff->full_name;
                }
                elseif($this->subtype == 'repay'){
                    $this->comment = $this->customer->full_name. " paid ₦$this->amount Loan Repayment via ".$this->staff->full_name;
                }
                elseif($this->subtype == 'repay_all'){
                    $this->comment = $this->customer->full_name. " paid ₦$this->amount Loan Clearance via ".$this->staff->full_name;
                }
                elseif($this->subtype == 'part_repay'){
                    $this->comment = $this->customer->full_name. " paid ₦$this->amount Partial Loan Repayment via ".$this->staff->full_name;
                }
                break;

            default:
                # code...
                break;
        }//end switch type
        $this->transaction_ref .= $this->customer->id.'-ST'.$this->staff->id.'-'.str_pad(($this->transaction_count + 1),7,"0",STR_PAD_LEFT);
        return $this->transaction_ref;
    }//end get_transaction ref.
    public function approve_loan(){
        $this->customer->loan = Loan::where('customer_id',$this->customer->id)->where('loan_cleared',false)->first();
        if($this->customer->loan){
            $this->customer->loan->approval_date = Carbon::now();
            $this->customer->loan->approved_by = $this->staff->id;
            $this->customer->loan->save();
            return true;
        }
    }
    //save transaction in db
    public function save_transaction(){
        $this->transaction->ref_id = $this->get_transaction_ref();
        $this->transaction->type = $this->type;
        $this->transaction->amount = $this->amount;
        $this->transaction->comment = $this->comment;
        $this->transaction->staff_id = $this->staff->id;
        if($this->transaction->save()){
            return true;
        }
    }
    //add to the company balance
    public function update_account(){
        $this->gday_balance->amount += $this->amount;
        $this->gday_balance->save();
    }
}
?>
