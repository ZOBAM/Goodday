<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\{Customer, Saving, Savings_collection, Withdrawal, Balance, Loan, Loan_repayment, Transaction, User, Group};
use App\Classes\{CustomerClass, TransactionClass};
use Auth;

class MainController extends Controller
{
    //set customer session
    public function SetCurrentCustomer($customer_id = false){
        if((isset($_GET['account_number']) && is_numeric($_GET['account_number']) || $customer_id)){
            $account_number = $_GET['account_number']?? '';
            $customer = $customer_id? Customer::where('id',$customer_id)->first() : Customer::where('account_number','GD'.$account_number)->first();
            if(!$customer){
                return false;
            }
            else{//set current customer session
                $savings = Saving::where('customer_id',$customer->id)->get();
                $balance = Balance::where('customer_id',$customer->id)->first();
                //return $savings;
                $customer->savings = $savings;
                $customer->balance_amount = $balance->amount;
                $customer->max_loan_amount = $balance->amount * 10;
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
        //keep deactivated staffs away
        if(!(Auth::user()->rank > 0)){
            return redirect('/');
        }
        //set if staff is admin
        $variable_arr['is_admin'] = (Auth::user()->rank >= 2)? True : false;
        //get staffs from db
        $variable_arr['staffs'] = User::get();
        if (session()->has('current_customer')) {
            //check if the current customer already has a loan that is still running
            $variable_arr['current_customer_loan'] = Loan::where('customer_id',Session()->get('current_customer')->id)->where('loan_cleared',false)->where('approval_date','!=',null)->first();
            $variable_arr['current_customer_loan']? $variable_arr['has_loan'] = true : $variable_arr['has_loan'] = false;
            //check if customer is in group
            $variable_arr['in_group'] = Customer::where('id',Session()->get('current_customer')->id)->where('group_id','!=',null)->first();
            $variable_arr['customer_group'] = $variable_arr['in_group']? Group::where('id',$variable_arr['in_group']->group_id)->first():false;
            //max loan for customer
            $variable_arr['max_loan_amount'] = Session()->get('current_customer')->balance_amount * 10;
            //return $variable_arr['in_group'];
            if($variable_arr['customer_group']){
                if(Session()->get('current_customer')->balance_amount >= 3000 && Session()->get('current_customer')->balance_amount < 5000){
                    $variable_arr['max_loan_amount'] =  50000;
                }
            }
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
        $sections = ['customers','savings','loans','admin','transactions'];
        if(in_array($section,$sections)){
            $variable_arr['nav_link_active'] = false;
            switch($section){
                case 'customers'://HANDLE CUSTOMER SECTION
                    $action = $action? $action : 'view';
                    $variable_arr['customers_link_active'] = 'active';
                    $section_nav = [
                        'Create New Account'          =>  ['link' => '/customers/create','icon' => 'user-plus'],
                        'Update Customer Account'     =>  ['link' => '/customers/edit','icon' => 'user-edit'],
                        'View Customers Accounts'    =>  ['link' => '/customers/view','icon' => 'eye'],
                        'Customers Groups'            =>  ['link' => '/customers/groups','icon' => 'layer-group'],
                    ];
                    switch($action){
                        case 'create':
                            $section_nav['Create New Account']['nav_link_active'] = true;
                        break;
                        case 'edit':
                            $section_nav['Update Customer Account']['nav_link_active'] = true;
                            $variable_arr['require_session'] = true;
                            if(!$variable_arr['session_isset']){
                                if($this->SetCurrentCustomer()){
                                    return redirect(url()->current());
                                }
                            }
                        break;
                        case 'view':
                            $section_nav['View Customers Accounts']['nav_link_active'] = true;
                            if(is_numeric($id)){
                                //return $id;
                                $variable_arr['new_customer'] = false;
                                if(isset($_GET['new'])){
                                    $variable_arr['new_customer'] = true;
                                }
                                $variable_arr['customer'] = Customer::findOrFail($id);
                                $balance = Balance::where('customer_id',$id)->first();
                                $variable_arr['customer']->balance = $balance->amount??0;
                                $variable_arr['customer']->group = ($variable_arr['customer']->group_id != null)? false : Group::get();
                                //set current customer session
                                $this->SetCurrentCustomer($id);
                            }
                            else{
                                $variable_arr['customers'] = Customer::where('id','!=',1)->orderBy('created_at','DESC')->paginate(10);
                                foreach($variable_arr['customers'] as $customer){
                                    $balance = Balance::where('customer_id',$customer->id)->first();
                                    if($balance){
                                        $customer->balance = $balance->amount;
                                    }
                                    else{
                                        $customer->balance = 0;
                                    }
                                }
                            }
                        break;
                        case 'groups':
                            $section_nav['Customers Groups']['nav_link_active'] = true;
                            $variable_arr['staffs'] = User::where('rank','>',0)->get();
                            $variable_arr['groups'] = Group::get();
                            if(is_numeric($id)){
                                $variable_arr['group'] = Group::findOrFail($id);
                                foreach($variable_arr['group']->customer as $customer){
                                    if($variable_arr['group']->leader_id == $customer->id){
                                        $customer->position = 'Leader';
                                    }
                                    elseif($variable_arr['group']->secretary_id == $customer->id){
                                        $customer->position = 'Secretary';
                                    }
                                    else{
                                        $customer->position = 'Member';
                                    }
                                }
                            }
                        break;
                        default:
                        return redirect('/customer');
                    }//end switch
                    //return $section_nav;
                break;
                case 'savings'://HANDLE SAVING SECTION
                    $variable_arr['require_session'] = true;
                    $variable_arr['savings_link_active'] = 'active';
                    //$variable_arr['unit_amount'] = $variable_arr['unit_amount']->unit_amount;
                    //return $variable_arr['unit_amount'];
                    if(!$variable_arr['session_isset']){
                        //return $this->SetCurrentCustomer();
                        if($this->SetCurrentCustomer()){
                            return redirect(url()->current());
                        }
                    }
                    if ($variable_arr['session_isset']) {
                        $variable_arr['saving'] = Saving::where('cycle_complete',false)->where('customer_id',Session()->get('current_customer')->id)->first();
                        $variable_arr['saving_cycle'] = Saving::where('customer_id',Session()->get('current_customer')->id)->count() + 1;
                    }
                    $section_nav = [
                        'Start New Saving'          =>  ['link' => '/savings/create','icon' => 'plus'],
                        'Record Saving Collection'     =>  ['link' => '/savings/collection','icon' => 'money-bill-alt'],
                        'Withdraw From Saving'    =>  ['link' => '/savings/disburse','icon' => 'money-bill'],
                        'Close Saving'    =>  ['link' => '/savings/close_saving','icon' => 'circle-notch']
                    ];
                    switch($action){
                        case 'create':
                            $section_nav['Start New Saving']['nav_link_active'] = true;
                            //return $section_nav;
                        break;
                        case 'collection':
                            $section_nav['Record Saving Collection']['nav_link_active'] = true;
                        break;
                        case 'close_saving':
                            $section_nav['Close Saving']['nav_link_active'] = true;
                        break;
                        case 'disburse':
                            $unit_amount = $variable_arr['saving']? $variable_arr['saving']->unit_amount : 0;
                            $variable_arr['withdrawable_amount'] = Session()->get('current_customer')->balance_amount - $unit_amount;
                            $section_nav['Withdraw From Saving']['nav_link_active'] = true;
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
                    $variable_arr['loans_link_active'] = 'active';
                    $section_nav = [
                        'New Loan Application'  =>  ['link' => '/loans/create','icon' => 'plus'],
                        'Pending Loans'         =>  ['link' => '/loans/pending','icon' => 'circle'],
                        'Approved Loans'        =>  ['link' => '/loans/approved','icon' => 'check'],
                        'Loan Repayment'        =>  ['link' => '/loans/repayment','icon' => 'pen'],
                        'Loans Due Today'       =>  ['link' => '/loans/due_today','icon' => 'bullseye']
                    ];
                    switch($action){
                        case 'create':
                            $section_nav['New Loan Application']['nav_link_active'] = true;
                            $variable_arr['repay_loans'] = Loan::where('loan_cleared',false)->where('approval_date','!=',null)->paginate(7);
                        break;
                        case 'pending':
                            $section_nav['Pending Loans']['nav_link_active'] = true;
                            $variable_arr['pending_loans'] = Loan::where('approval_date',null)->paginate(7);
                            $variable_arr['heading'] = "List of Loans Awaiting Approval $ Disbursement";
                            if(isset($_GET['approve_loan']) && is_numeric($_GET['approve_loan'])){
                                $customer_class = new CustomerClass('loans','approve',0,$_GET['approve_loan'],Auth::id(),false);
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
                            $section_nav['Approved Loans']['nav_link_active'] = true;
                            $variable_arr['pending_loans'] = Loan::where('approval_date','!=',null)->paginate(7);
                            $variable_arr['heading'] = "List of Approved Loans";
                        break;
                        case 'repayment':
                            $section_nav['Loan Repayment']['nav_link_active'] = true;
                            $variable_arr['repay_loans'] = Loan::where('loan_cleared',false)->where('approval_date','!=',null)->paginate(7);
                            //get the repayment count for each of the approved loans.
                            foreach($variable_arr['repay_loans'] as $loan){
                                $repay_count = Loan_repayment::where('loan_id',$loan->id)->get();
                                $loan->repay_count = count($repay_count);
                            }
                            if (isset($variable_arr['has_loan']) && $variable_arr['has_loan']){
                                $variable_arr['current_due_dates'] = Loan_repayment::where('loan_id',$variable_arr['current_customer_loan']->id)->paginate(10);
                                //get the specific repayment with specified id
                                if($id){
                                    $variable_arr['current_due_dates'] = Loan_repayment::where('id',$id)->where('loan_id',$variable_arr['current_customer_loan']->id)->paginate(10);
                                }
                                $variable_arr['unpaid_due_dates'] = Loan_repayment::where('loan_id',$variable_arr['current_customer_loan']->id)->where('repaid',false)->first();
                                /* if($variable_arr['unpaid_due_dates']){
                                    $first_due_date = Carbon::createFromDate($variable_arr['unpaid_due_dates']->due_date);
                                    $today = Carbon::now();
                                    $defaulted_days = $today->diffInDays($first_due_date);
                                    if($defaulted_days > 0){
                                        $variable_arr['unpaid_due_dates']->defaulted = true;
                                        if($defaulted_days > 7){
                                            $loan = Loan::where('id',$variable_arr['unpaid_due_dates']->loan_id)->first();
                                            //return $loan;
                                            if(!is_null($loan->last_default_check)){//has defaulted before
                                                $last_check = Carbon::createFromDate($loan->last_default_check);
                                                if($today->diffInDays($last_check) >= 1){
                                                    $variable_arr['unpaid_due_dates']->amount_repaid += (2/100) * $loan->amount * ($today->diffInDays($last_check));
                                                    $loan->outstanding_amount += (2/100) * $loan->amount * ($today->diffInDays($last_check));
                                                    return "Grace period expired";
                                                }
                                                return "This is null ".$today->diffInDays($last_check) ;
                                            }
                                            else{//first time of recording default penalty
                                                //return "Check is null";
                                                $variable_arr['unpaid_due_dates']->amount_repaid += ((2/100) * $loan->amount) * ($defaulted_days - 7);
                                                $loan->outstanding_amount += ((2/100) * $loan->amount) * ($defaulted_days - 7);
                                                $loan->last_default_check = Carbon::now();
                                                $loan->save();
                                                $variable_arr['unpaid_due_dates']->save();
                                            }
                                            return "Repay amount " . $loan->outstanding_amount." : Repay Unit: ".$variable_arr['unpaid_due_dates']->amount_repaid;
                                        }
                                        return "This payment defaulted with $defaulted_days days";
                                    }
                                } */
                            }
                            else{
                                if($id){
                                $repayment = Loan_repayment::findOrFail($id);
                                $this->SetCurrentCustomer($repayment->loan->customer_id);
                                //get the specific repayment with specified id
                                    $variable_arr['current_due_dates'] = Loan_repayment::where('id',$id)->where('loan_id',$variable_arr['current_customer_loan']->id)->paginate(10);
                                }
                            }
                        break;
                        case 'due_today':
                            $variable_arr['loans_due_today'] = Loan_repayment::whereDate('due_date', '=', Carbon::today())->where('repaid',false)->paginate(10);
                            //return $variable_arr['loans_due_today'][0]->loan;
                        break;
                    }
                    //return $section_nav;
                break;
                case 'transactions'://HANDLE TRANSACTION SECTION
                    $variable_arr['transactions_link_active'] = 'active';
                    $staff_set = false;
                    if($id){
                        $staff_set = $id;
                    }
                    if($variable_arr['is_admin']){
                        $transaction_class = $staff_set? new TransactionClass(10,$staff_set) : new TransactionClass(10);
                    }
                    else{
                        $transaction_class = $staff_set? new TransactionClass(10,$staff_set) : new TransactionClass(10,Auth::id());
                    }
                    $section_nav = [
                        'Today\'s Transactions'          =>  ['link' => '/transactions/today','icon' => 'file'],
                        'This Week\'s Transactions'     =>  ['link' => '/transactions/week','icon' => 'file-alt'],
                        'This Month\'s Transactions'    =>  ['link' => '/transactions/month','icon' => 'file-archive'],
                    ];
                    switch ($action) {
                        case 'today':
                            $section_nav['Today\'s Transactions']['nav_link_active'] = true;
                            //return 1;
                            $variable_arr['transactions'] = $transaction_class->get_today();
                            $variable_arr['transactions_total'] = $transaction_class->get_total();
                            $variable_arr['heading'] = "Today's Transactions";
                            break;

                        case 'week':
                            $section_nav['This Week\'s Transactions']['nav_link_active'] = true;
                            $variable_arr['transactions'] = $transaction_class->get_week();
                            $variable_arr['transactions_total'] = $transaction_class->get_total();
                            $variable_arr['heading'] = "This Week's Transactions";
                            break;

                        case 'month':
                            $section_nav['This Month\'s Transactions']['nav_link_active'] = true;
                            $variable_arr['transactions'] = $transaction_class->get_month();
                            $variable_arr['transactions_total'] = $transaction_class->get_total();
                            $variable_arr['heading'] = "This Month's Transactions";
                            break;

                        default:
                            return redirect('/transactions/today');
                            break;
                    }
                break;
                case 'admin'://HANDLE STAFF SECTION
                    //keep unauthorized staffs away
                    if(!$variable_arr['is_admin']){
                        return redirect('/customers');
                    }
                    $action = $action? $action : 'add_staff';
                    //return "Admin reached!";
                    $section_nav = [
                        'Add Staff'          =>  ['link' => '/admin/add_staff','icon' => 'file'],
                        'Manage Staff'     =>  ['link' => '/admin/manage_staffs','icon' => 'file'],
                    ];
                    switch($action){
                        case 'add_staff':
                            $section_nav['Add Staff']['nav_link_active'] = true;
                        break;
                        case 'manage_staffs':
                            $section_nav['Manage Staff']['nav_link_active'] = true;
                            $variable_arr['staffs'] = User::where('rank','!=',0)->where('id','!=',Auth::id())->get();
                        break;
                    }
            }//end switch section
        }//end if section in array of sections
        else{//this sectional nav will be displayed when no section is specified
            return redirect('customers/view');
        }
        return view("home",compact('section_nav','section','action','variable_arr'));
    }//end index function
}
