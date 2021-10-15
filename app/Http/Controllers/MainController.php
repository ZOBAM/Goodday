<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\{Customer, Saving, Savings_collection, Withdrawal, Balance, Loan, Loan_repayment, Transaction, User, Group, Guarantor};
use App\Classes\{CustomerClass, TransactionClass};
use Auth;

class MainController extends Controller
{
    public $variable_arr = [];
    public $customer;
    //set customer session
    public function SetCurrentCustomer($customer_id = false){
        if((isset($_GET['account_number']) && is_numeric($_GET['account_number']) || $customer_id)){
            $account_number = $_GET['account_number']?? '';
            $customer = $customer_id? Customer::where('id',$customer_id)->first() : Customer::where('account_number','GD'.$account_number)->first();
            if(!$customer){
                return false;
            }
            else{//set current customer session
                $customer_class = new CustomerClass(false,false,0,$customer->id,Auth::id(),false);
                $this->customer = $customer_class->customer;
                session(['current_customer' => $this->customer]);
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
        $this->variable_arr['is_admin'] = (Auth::user()->rank >= 2)? True : false;
        //get staffs from db
        $this->variable_arr['staffs'] = User::get();
        //end session
        if(isset($_GET['end_session'])){
            if($this->endCurrentSession()){
                return redirect(url()->current());
            }
        }
        $this->variable_arr['card_header'] = 'Customer\'s Area';
        $this->variable_arr['require_session'] = false;
        $this->variable_arr['session_isset'] = session()->has('current_customer')? true : false;
        $sections = ['customers','savings','loans','admin','transactions'];
        if(in_array($section,$sections)){
            $this->variable_arr['nav_link_active'] = false;
            switch($section){
                case 'customers'://HANDLE CUSTOMER SECTION
                    $action = $action? $action : 'view';
                    $this->variable_arr['customers_link_active'] = 'active';
                    $section_nav = [
                        'Create New Account'          =>  ['link' => '/customers/create','icon' => 'user-plus'],
                        'Update Customer Account'     =>  ['link' => '/customers/edit','icon' => 'user-edit'],
                        'View Customers Accounts'    =>  ['link' => '/customers/view','icon' => 'eye'],
                        'Account Statement'    =>  ['link' => '/customers/statement','icon' => 'book'],
                        'Customers Groups'            =>  ['link' => '/customers/groups','icon' => 'layer-group'],
                    ];
                    switch($action){
                        case 'create':
                            $section_nav['Create New Account']['nav_link_active'] = true;
                        break;
                        case 'edit':
                            $section_nav['Update Customer Account']['nav_link_active'] = true;
                            $this->variable_arr['require_session'] = true;
                            if(!$this->variable_arr['session_isset']){
                                if($this->SetCurrentCustomer()){//it gets the id from url variable
                                    return redirect(url()->current());
                                }
                            }
                        break;
                        case 'view':
                            $section_nav['View Customers Accounts']['nav_link_active'] = true;
                            if(is_numeric($id)){
                                //return $id;
                                $this->variable_arr['new_customer'] = false;
                                if(isset($_GET['new'])){
                                    $this->variable_arr['new_customer'] = true;
                                }
                                $this->variable_arr['customer'] = Customer::findOrFail($id);
                                $balance = Balance::where('customer_id',$id)->first();
                                $this->variable_arr['customer']->balance = $balance->amount??0;
                                $this->variable_arr['customer']->group = ($this->variable_arr['customer']->group_id != null)? false : Group::get();
                                $this->variable_arr['customer']->guarantor = Guarantor::where('customer_id',$id)->first();
                                //set current customer session
                                $this->SetCurrentCustomer($id);
                            }
                            else{
                                //$this->variable_arr['customers'] = Customer::where('id','!=',1)->get();//exclude gday account
                                $this->variable_arr['customers'] = Customer::where('id','!=',1)->orderBy('created_at','DESC')->paginate(10);
                                foreach($this->variable_arr['customers'] as $customer){
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
                        case 'statement':
                            $section_nav['Account Statement']['nav_link_active'] = true;
                            $this->variable_arr['require_session'] = true;
                            if($this->variable_arr['session_isset']){
                                $customer_class = new CustomerClass(false,false,0,Session()->get('current_customer')->id,Auth::id(),false);
                                //if date interval was supplied use it if not user past month.
                                if(isset($_GET['start_date']) && $_GET['end_date']){
                                    $start_date = $_GET['start_date'];
                                    $end_date = $_GET['end_date'];
                                    $this->variable_arr['statement'] = $customer_class->account_statement($start_date,$end_date);
                                }else{
                                    $this->variable_arr['statement'] = $customer_class->account_statement();
                                }
                            }else{
                                if($this->SetCurrentCustomer()){//it gets the id from url variable
                                    return redirect(url()->current());
                                }
                            }
                            //return $this->variable_arr['statement'];
                            break;
                        case 'groups':
                            $section_nav['Customers Groups']['nav_link_active'] = true;
                            $this->variable_arr['staffs'] = User::where('rank','>',0)->get();
                            $this->variable_arr['groups'] = Group::get();
                            if(is_numeric($id)){
                                $this->variable_arr['group'] = Group::findOrFail($id);
                                foreach($this->variable_arr['group']->customer as $customer){
                                    if($this->variable_arr['group']->leader_id == $customer->id){
                                        $customer->position = 'Leader';
                                    }
                                    elseif($this->variable_arr['group']->secretary_id == $customer->id){
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
                    $this->variable_arr['require_session'] = true;
                    $this->variable_arr['savings_link_active'] = 'active';
                    //$this->variable_arr['unit_amount'] = $this->variable_arr['unit_amount']->unit_amount;
                    //return $this->variable_arr['unit_amount'];
                    if(!$this->variable_arr['session_isset']){
                        //return $this->SetCurrentCustomer();
                        if($this->SetCurrentCustomer()){
                            return redirect(url()->current());
                        }
                    }
                    if ($this->variable_arr['session_isset']) {
                        $this->variable_arr['saving'] = Saving::where('cycle_complete',false)->where('customer_id',Session()->get('current_customer')->id)->first();
                        $this->variable_arr['saving_cycle'] = Saving::where('customer_id',Session()->get('current_customer')->id)->count() + 1;
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
                            $unit_amount = $this->variable_arr['saving']? $this->variable_arr['saving']->unit_amount : 0;
                            $this->variable_arr['withdrawable_amount'] = Session()->get('current_customer')->balance_amount - $unit_amount;
                            $section_nav['Withdraw From Saving']['nav_link_active'] = true;
                        break;
                        default:
                        return redirect('/savings/collection');
                    }
                break;
                case 'loans'://HANDLE LOAN SECTION
                    if(!$this->variable_arr['session_isset']){
                        if($this->SetCurrentCustomer()){
                            return redirect(url()->current());
                        }
                    }
                    $action = $action? $action : 'repayment';
                    $this->variable_arr['loans_link_active'] = 'active';
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
                            $this->variable_arr['repay_loans'] = Loan::where('loan_cleared',false)->where('approval_date','!=',null)->paginate(7);
                        break;
                        case 'pending':
                            $section_nav['Pending Loans']['nav_link_active'] = true;
                            $this->variable_arr['pending_loans'] = Loan::where('approval_date',null)->paginate(7);
                            $this->variable_arr['heading'] = "List of Loans Awaiting Approval $ Disbursement";
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
                            $this->variable_arr['pending_loans'] = Loan::where('approval_date','!=',null)->paginate(7);
                            $this->variable_arr['heading'] = "List of Approved Loans";
                        break;
                        case 'repayment':
                            $section_nav['Loan Repayment']['nav_link_active'] = true;
                            $this->variable_arr['repay_loans'] = Loan::where('loan_cleared',false)->where('approval_date','!=',null)->paginate(7);
                            //get the repayment count for each of the approved loans.
                            foreach($this->variable_arr['repay_loans'] as $loan){
                                $repay_count = Loan_repayment::where('loan_id',$loan->id)->get();
                                $loan->repay_count = count($repay_count);
                            }
                            if (isset(Session()->get('current_customer')->has_loan)){
                                if(Session()->get('current_customer')->has_loan){
                                    $this->variable_arr['due_dates'] = Loan_repayment::where('loan_id',Session()->get('current_customer')->current_loan->id)->paginate(10);
                                }
                                //get the specific repayment with specified id
                                if($id){
                                    $this->variable_arr['due_dates'] = Loan_repayment::where('id',$id)->paginate(10);
                                    if($this->variable_arr['due_dates'][0]->loan->customer_id != Session()->get('current_customer')->id){
                                        $this->SetCurrentCustomer($this->variable_arr['due_dates'][0]->loan->customer_id);
                                    }
                                    //return $this->variable_arr['due_dates'][0]->loan->customer_id;
                                }
                                $this->variable_arr['unpaid_due_dates'] = Loan_repayment::where('loan_id',Session()->get('current_customer')->current_loan->id)->where('repaid',false)->first();
                                /* if($this->variable_arr['unpaid_due_dates']){
                                    $first_due_date = Carbon::createFromDate($this->variable_arr['unpaid_due_dates']->due_date);
                                    $today = Carbon::now();
                                    $defaulted_days = $today->diffInDays($first_due_date);
                                    if($defaulted_days > 0){
                                        $this->variable_arr['unpaid_due_dates']->defaulted = true;
                                        if($defaulted_days > 7){
                                            $loan = Loan::where('id',$this->variable_arr['unpaid_due_dates']->loan_id)->first();
                                            //return $loan;
                                            if(!is_null($loan->last_default_check)){//has defaulted before
                                                $last_check = Carbon::createFromDate($loan->last_default_check);
                                                if($today->diffInDays($last_check) >= 1){
                                                    $this->variable_arr['unpaid_due_dates']->amount_repaid += (2/100) * $loan->amount * ($today->diffInDays($last_check));
                                                    $loan->outstanding_amount += (2/100) * $loan->amount * ($today->diffInDays($last_check));
                                                    return "Grace period expired";
                                                }
                                                return "This is null ".$today->diffInDays($last_check) ;
                                            }
                                            else{//first time of recording default penalty
                                                //return "Check is null";
                                                $this->variable_arr['unpaid_due_dates']->amount_repaid += ((2/100) * $loan->amount) * ($defaulted_days - 7);
                                                $loan->outstanding_amount += ((2/100) * $loan->amount) * ($defaulted_days - 7);
                                                $loan->last_default_check = Carbon::now();
                                                $loan->save();
                                                $this->variable_arr['unpaid_due_dates']->save();
                                            }
                                            return "Repay amount " . $loan->outstanding_amount." : Repay Unit: ".$this->variable_arr['unpaid_due_dates']->amount_repaid;
                                        }
                                        return "This payment defaulted with $defaulted_days days";
                                    }
                                } */
                            }
                            else{
                                if($id){
                                $repayment = Loan_repayment::findOrFail($id);
                                //set the current user
                                $this->SetCurrentCustomer($repayment->loan->customer_id);

                                $current_url = url()->current();//get current url
                                if(!isset($_GET['rw'])){
                                    return redirect($current_url.'?rw=true');
                                }
                                return $current_url;
                                //get the specific repayment with specified id
                                $this->variable_arr['due_dates'] = Loan_repayment::where('id',$id)->where('loan_id',Session()->get('current_customer')->current_loan->id)->paginate(10);
                                }
                            }
                        break;
                        case 'due_today':
                            $this->variable_arr['due_date'] = Carbon::today();
                            if(isset($_GET['due_date'])){
                                //return "Date set!<br> ".$_GET['due_date'];
                                $this->variable_arr['due_date'] = Carbon::createFromDate($_GET['due_date']);
                            }
                            $this->variable_arr['loans_due_today'] = Loan_repayment::whereDate('due_date', '=', $this->variable_arr['due_date'])->where('repaid',false)->paginate(10);
                            if(isset($_GET['due_day'])){
                                $due_day = $_GET['due_day'];
                                if($due_day == 'yesterday'){
                                    $this->variable_arr['due_date'] = $this->variable_arr['due_date']->subDay();
                                    $this->variable_arr['loans_due_today'] = Loan_repayment::whereDate('due_date', '=', $this->variable_arr['due_date'])->where('repaid',false)->paginate(10);
                                    //return "You are viewing loans due yesterday " .date('D d/M/Y',strtotime($this->variable_arr['due_date']));
                                }
                                if($due_day == 'tomorrow'){
                                    $this->variable_arr['due_date'] = $this->variable_arr['due_date']->addDay();
                                    $this->variable_arr['loans_due_today'] = Loan_repayment::whereDate('due_date', '=', $this->variable_arr['due_date'])->where('repaid',false)->paginate(10);
                                    //return "You are viewing loans due tomorrow";
                                }
                            }
                            //return $this->variable_arr['loans_due_today'][0]->loan;
                        break;
                    }
                    //return $section_nav;
                break;
                case 'transactions'://HANDLE TRANSACTION SECTION
                    $this->variable_arr['transactions_link_active'] = 'active';
                    $staff_set = false;
                    if($id){
                        $staff_set = $id;
                    }
                    if($this->variable_arr['is_admin']){
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
                            $this->variable_arr['transactions'] = $transaction_class->get_today();
                            $this->variable_arr['transactions_total'] = $transaction_class->get_total();
                            $this->variable_arr['heading'] = "Today's Transactions";
                            break;

                        case 'week':
                            $section_nav['This Week\'s Transactions']['nav_link_active'] = true;
                            $this->variable_arr['transactions'] = $transaction_class->get_week();
                            $this->variable_arr['transactions_total'] = $transaction_class->get_total();
                            $this->variable_arr['heading'] = "This Week's Transactions";
                            break;

                        case 'month':
                            $section_nav['This Month\'s Transactions']['nav_link_active'] = true;
                            $this->variable_arr['transactions'] = $transaction_class->get_month();
                            $this->variable_arr['transactions_total'] = $transaction_class->get_total();
                            $this->variable_arr['heading'] = "This Month's Transactions";
                            break;

                        default:
                            return redirect('/transactions/today');
                            break;
                    }
                break;
                case 'admin'://HANDLE STAFF SECTION
                    //keep unauthorized staffs away
                    if(!$this->variable_arr['is_admin']){
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
                            $this->variable_arr['staffs'] = User::where('rank','!=',0)->where('id','!=',Auth::id())->get();
                        break;
                    }
            }//end switch section
        }//end if section in array of sections
        else{//this sectional nav will be displayed when no section is specified
            return redirect('customers/view');
        }
        $variable_arr = $this->variable_arr;
        return view("home",compact('section_nav','section','action','variable_arr'));
    }//end index function
}
