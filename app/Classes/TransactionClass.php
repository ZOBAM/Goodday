<?php
namespace App\Classes;
use App\{User,Customer,Balance,Transaction};
use Carbon\Carbon;
use Auth;

class TransactionClass {
    private $per_page;
    private $total;

    public function __construct($per_page){
        $this->per_page = $per_page;
    }
    public function get_today(){
        $this->total = Transaction::whereDate('created_at', Carbon::today())->sum('amount');
        return Transaction::whereDate('created_at', Carbon::today())->orderBy('created_at','DESC')->paginate($this->per_page);
    }
    public function get_week(){
        $this->total = Transaction::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount');
        return Transaction::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->paginate($this->per_page);
    }
    public function get_month(){
        $this->total = Transaction::whereMonth('created_at', '=', date('m'))->sum('amount');
        return Transaction::whereMonth('created_at', '=', date('m'))->paginate($this->per_page);
    }
    public function get_total(){
        return $this->total;
    }
}
?>
