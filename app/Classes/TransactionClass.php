<?php
namespace App\Classes;
use App\{User,Customer,Balance,Transaction};
use Carbon\Carbon;
use Auth;

class TransactionClass {
    private $per_page;

    public function __construct($per_page){
        $this->per_page = $per_page;
    }
    public function get_today(){
        return Transaction::whereDate('created_at', Carbon::today())->paginate($this->per_page);
    }
    public function get_week(){
        return Transaction::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->paginate($this->per_page);
    }
    public function get_month(){
        return Transaction::whereMonth('created_at', '=', date('m'))->paginate($this->per_page);
    }
}
?>
