<?php
namespace App\Classes;
use App\{User,Customer,Balance,Transaction};
use Carbon\Carbon;
use Auth;

class TransactionClass {
    private $per_page;
    private $total;
    private $staff_id;
    private $search_term;
    private $transactions;

    public function __construct($per_page,$staff_id = false){
        $this->per_page = $per_page;
        $this->staff_id = $staff_id;
        $this->search_term = '-ST'.$this->staff_id.'-';
    }
    public function get_today(){
        $this->total = $this->staff_id? Transaction::whereDate('created_at', Carbon::today())->where('ref_id', 'LIKE', "%$this->search_term%")->where('deleted',false)->sum('amount') : Transaction::whereDate('created_at', Carbon::today())->where('deleted',false)->sum('amount');

        $this->transactions = $this->staff_id? Transaction::whereDate('created_at', Carbon::today())->where('ref_id', 'LIKE', "%$this->search_term%")->where('deleted',false)->orderBy('created_at','DESC')->paginate($this->per_page) : Transaction::whereDate('created_at', Carbon::today())->where('deleted',false)->orderBy('created_at','DESC')->paginate($this->per_page) ;

        return $this->transactions;
    }
    public function get_week(){
        $this->total = $this->staff_id? Transaction::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('ref_id', 'LIKE', "%$this->search_term%")->where('deleted',false)->sum('amount') : Transaction::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('deleted',false)->sum('amount');

        $this->transactions = $this->staff_id? Transaction::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('ref_id', 'LIKE', "%$this->search_term%")->where('deleted',false)->paginate($this->per_page) : Transaction::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('deleted',false)->paginate($this->per_page);

        return $this->transactions;
    }
    public function get_month(){
        $this->transactions = $this->staff_id? Transaction::whereMonth('created_at', '=', date('m'))->where('ref_id', 'LIKE', "%$this->search_term%")->where('deleted',false)->paginate($this->per_page) : Transaction::whereMonth('created_at', '=', date('m'))->where('deleted',false)->paginate($this->per_page);

        $this->total = $this->staff_id? Transaction::whereMonth('created_at', '=', date('m'))->where('ref_id', 'LIKE', "%$this->search_term%")->where('deleted',false)->sum('amount') : Transaction::whereMonth('created_at', '=', date('m'))->where('deleted',false)->sum('amount');

        return $this->transactions;
    }
    public function get_total(){
        return $this->total;
    }
}
?>
