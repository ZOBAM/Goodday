<?php
namespace App\Classes;
use App\{User,Customer,Balance,Transaction};
use Auth;

class CustomerClass {
    private $max_loan_amount = 200000;// two hundred thousand naira
    private $min_loan_amount = 1000;// one thousand naira
    private $interest_rate = 20/100;// interest rate of 20%
    private $account_no;
    private $balance;
    private $transaction_ref;
    private $transaction_count;
    private $transaction;
    private $staff;
    private $customer;
    private $type;
    private $amount;
    private $comment;

    public function __construct($type, $amount, $customer_id, $staff_id){
        $this->transaction_count = Transaction::count();
        $this->transaction = new Transaction;
        $this->balance = new Balance;
        $this->customer = Customer::where('id',$customer_id)->first();
        $this->staff = User::where('id',$staff_id)->first();
        $this->amount = $amount;
        $this->type = $type;
        $this->comment = "Transaction of $this->amount was recorded";
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
            case 'customer':
                $this->transaction_ref = 'CTM';
                break;

            case 'savings':
                $this->transaction_ref = 'SVS';
                break;

            case 'loans':
                $this->transaction_ref = 'LNS';
                $this->comment = $this->customer->full_name. " Loan Application of N$this->amount was received via ".$this->staff->full_name;
                break;

            default:
                # code...
                break;
        }//end switch type
        $this->transaction_ref .= $this->customer->id.'-ST'.$this->staff->id.'-'.str_pad(($this->transaction_count + 1),7,"0",STR_PAD_LEFT);
        return $this->transaction_ref;
    }//end get_transaction ref.
    public function save_transaction(){
        $this->transaction->ref_id = $this->get_transaction_ref();
        $this->transaction->type = $this->type;
        $this->transaction->amount = $this->amount;
        $this->transaction->comment = $this->comment;
        if($this->transaction->save()){
            return true;
        }
    }
}
?>
