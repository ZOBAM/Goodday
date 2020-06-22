<?php
namespace App\Classes;
use App\{Customer,Balance};

class CustomerClass {
    private $max_loan_amount = 200000;// two hundred thousand naira
    private $min_loan_amount = 1000;// one thousand naira
    private $interest_rate = 20/100;// interest rate of 20%
    private $account_no;
    private $balance;
    //if title image = false, get all images of this ad else get only the first images
    public function get_account_no($customer_id){
        $this->account_no = 'GD'.str_pad($customer_id,5,"0",STR_PAD_LEFT).rand(100,999);
        return $this->account_no;
    }//end get ad images
    public function get_seller_dp($id,$title_image = true){//if title image is false, get all images of this ad

    }
}
?>
