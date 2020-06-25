<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\{Customer, Saving, Savings_collection, Withdrawal, Balance, Loan, Loan_repayment, Transaction, User};
use App\Classes\{CustomerClass, TransactionClass};
use Auth;

class MainController extends Controller
{
    //set customer session
    public function SetCurrentCustomer(){
        if(isset($_GET['account_number']) && is_numeric($_GET['account_number'])){
            $account_number = 'GD'.$_GET['account_number'];
            $customer = Customer::where('account_number',$account_number)->first();
            if(!$customer){
                return false;
            }
            else{//set current customer session
                session(['current_customer' => $customer]);
                return true;
                //return url()->current();
                //return redirect('/savings');
            }
        }
        else{
            return false;
        }
    }//SetCurrentCustomer
    //endCurrentCustomer session
    public function endCurrentSession(){
        session()->forget('current_customer');
        return true;
    }

    //the below function will handle the various links based on provided section
    public function index($section = false, $action = false, $id = false){
        //check if the current customer already has a loan that is still running
        if (session()->has('current_customer')) {
            $variable_arr['current_customer_loan'] = Loan::where('customer_id',Session()->get('current_customer')->id)->where('loan_cleared',false)->first();
            $variable_arr['current_customer_loan']? $variable_arr['has_loan'] = true : $variable_arr['has_loan'] = false;
        }
        //end session
        if(isset($_GET['end_session'])){
            if($this->endCurrentSession()){
                return redirect(url()->current());
            }
        }
        $variable_arr['card_header'] = 'Customer\'s Area';
        $variable_arr['require_session'] = false;
        $variable_arr['session_isset'] = session()->has('current_customer')? true : false;
        $sections = ['customers','savings','loans','staffs','transactions'];
        if(in_array($section,$sections)){
            switch($section){
                case 'customers'://HANDLE CUSTOMER SECTION
                    $action = $action? $action : 'view';
                    $section_nav = [
                        'Create Account'          =>  '/customers/create',
                        'Update Account'     =>  '/customers/edit',
                        'View Account'    =>  '/customers/view',
                    ];
                    switch($action){
                        case 'create':
                        break;
                        case 'edit':
                            $variable_arr['require_session'] = true;
                            if(!$variable_arr['session_isset']){
                                if($this->SetCurrentCustomer()){
                                    return redirect(url()->current());
                                }
                            }
                        break;
                        case 'view':
                            if(is_numeric($id)){
                                $variable_arr['new_customer'] = false;
                                if(isset($_GET['new'])){
                                    $variable_arr['new_customer'] = true;
                                }
                                $variable_arr['customer'] = Customer::findOrFail($id);
                                //set current customer session
                                $this->SetCurrentCustomer($variable_arr['customer']);
                            }
                            else{
                                $variable_arr['customers'] = Customer::get();
                            }
                        break;
                        default:
                        return redirect('/customer');
                    }//end switch
                    //return $section_nav;
                break;
                case 'savings'://HANDLE SAVING SECTION
                    $variable_arr['require_session'] = true;
                    if ($variable_arr['session_isset']) {
                        $variable_arr['saving'] = Saving::where('customer_id',Session()->get('current_customer')->id)->first();
                    }
                    //$variable_arr['unit_amount'] = $variable_arr['unit_amount']->unit_amount;
                    //return $variable_arr['unit_amount'];
                    if(!$variable_arr['session_isset']){
                        if($this->SetCurrentCustomer()){
                            return redirect(url()->current());
                        }
                    }
                    $action = $action? $action : 'create';
                    $section_nav = [
                        'Create Saving'          =>  '/savings/create',
                        'Add Collection'     =>  '/savings/collection',
                        'Disburse'    =>  '/savings/disburse',
                        'Close Saving'    =>  '/savings/close_saving'
                    ];
                    switch($action){
                        case 'create':
                        break;
                        case 'collection':
                        break;
                        case 'close_saving':
                        break;
                        case 'disburse':
                        break;
                        default:
                        return redirect('/savings/collection');
                    }
                break;
                case 'loans'://HANDLE LOAN SECTION
                    if(!$variable_arr['session_isset']){
                        if($this->SetCurrentCustomer()){
                            return redirect(url()->current());
                        }
                    }
                    $action = $action? $action : 'repayment';
                    $section_nav = [
                        'New Loan Application'  =>  '/loans/create',
                        'Pending Loans'         =>  '/loans/pending',
                        'Approved Loans'        =>  '/loans/approved',
                        'Loan Repayment'        =>  '/loans/repayment'
                    ];
                    switch($action){
                        case 'create':
                            $variable_arr['repay_loans'] = Loan::where('loan_cleared',false)->where('approval_date','!=',null)->paginate(7);
                        break;
                        case 'pending':
                            $variable_arr['pending_loans'] = Loan::where('approval_date',null)->paginate(7);
                            $variable_arr['heading'] = "List of Loans Awaiting Approval $ Disbursement";
                            if(isset($_GET['approve_loan']) && is_numeric($_GET['approve_loan'])){
                                $customer_class = new CustomerClass('loans','approve',0,$_GET['approve_loan'],Auth::id());
                                if($customer_class->approve_loan()){
                                    $customer_class->save_transaction();
                                    session()->flash('info', 'Task was successful!');
                                    return redirect(url()->current());
                                }
                                else{
                                    return "Approval failed";
                                }
                            }
                        break;
                        case 'approved':
                           $variable_arr['pending_loans'] = Loan::where('approval_date','!=',null)->paginate(7);
                           $variable_arr['heading'] = "List of Approved Loans";
                        break;
                        case 'repayment':
                           $variable_arr['repay_loans'] = Loan::where('loan_cleared',false)->where('approval_date','!=',null)->paginate(7);
                           if (isset($variable_arr['has_loan']) && $variable_arr['has_loan']){
                            $variable_arr['current_due_dates'] = Loan_repayment::where('loan_id',$variable_arr['current_customer_loan']->id)->get();
                           }
                        break;
                    }
                break;
                case 'transactions'://HANDLE TRANSACTION SECTION
                    $transaction_class = new TransactionClass(10);
                    $section_nav = [
                        'Today\'s Transactions'          =>  '/transactions/today',
                        'This Week\'s Transactions'     =>  '/transactions/week',
                        'This Month\'s Transactions'    =>  '/transactions/month',
                    ];
                    switch ($action) {
                        case 'today':
                            //return 1;
                            $variable_arr['transactions'] = $transaction_class->get_today();
                            $variable_arr['heading'] = "List of Transactions for Today";
                            break;

                        case 'week':
                            $variable_arr['transactions'] = $transaction_class->get_week();
                            $variable_arr['heading'] = "List of Transactions for This Week";
                            break;

                        case 'month':
                            $variable_arr['transactions'] = $transaction_class->get_month();
                            $variable_arr['heading'] = "List of Transactions for This Month";
                            break;

                        default:
                            return redirect('/transactions/today');
                            break;
                    }
                break;
                case 'staffs'://HANDLE STAFF SECTION
                    $action = $action? $action : 'create';
                    $section_nav = [
                        'Add Staff'          =>  'staffs/create',
                        'Remove Staff'     =>  'staffs/deactivate',
                    ];
            }//end switch section
        }//end if section in array of sections
        else{//this sectional nav will be displayed when no section is specified
            return redirect('customers/view');
        }
        return view("home",compact('section_nav','section','action','variable_arr'));
    }//end index function
}
