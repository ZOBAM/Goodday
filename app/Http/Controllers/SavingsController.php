<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Customer, Saving, Savings_collection,Withdrawal,Balance};
use App\Classes\{CustomerClass};
use Auth;

class SavingsController extends Controller
{
    public function record_transaction($type,$subtype,$amount,$customer_id,$staff_id,$update_account=false){
        $customer_class = new CustomerClass($type,$subtype,$amount,$customer_id,$staff_id,$update_account);
        $customer_class->save_transaction();
        return true;
    }
    public function StoreSavings(Request $request, $customer_id = false, $action = false){
        //HANDLE COLLECTIONS
        if($action == 'collection'){
            $this->validate($request, [
                'amount_saved'       => 'nullable|numeric|min:50|max:50000',
            ]);
            $saving = Saving::where('customer_id',Session()->get('current_customer')->id)->where('cycle_complete',false)->first();
            $collection = new Savings_collection;
            $collection->amount_saved = empty($request->input('amount_saved'))? $request->unit_amount : $request->amount_saved;
            $collection->saving_id = $customer_id;
            $collection->collected_by = Auth::id();
            $not_first_collection = Savings_collection::where('saving_id',$saving->id)->first();
            if($collection->save()){
                //update savings table
                $saving->withdrawable_amount += $collection->amount_saved;
                $saving->saving_cycle_total += $collection->amount_saved;
                $saving->collection_count += 1;
                $saving->save();
                //update balance table
                $balance = Balance::where('customer_id',Session()->get('current_customer')->id)->first();
                $balance->amount += $collection->amount_saved;
                $balance->save();
                //record transaction
                $this->record_transaction('savings','collection',$collection->amount_saved,Session()->get('current_customer')->id,Auth::id());
            }
            return "Collection submitted";
        }
        //HANDLE DISBURSING
        elseif ($action == 'disburse') {
            $this->validate($request, [
                'amount_withdrawn'       => 'nullable|numeric|min:50|max:50000',
            ]);
            //get customer balance
            $balance = Balance::where('customer_id',$customer_id)->first();
            if($balance->amount>=$request->amount_withdrawn){
                $withdrawal = new Withdrawal;
                $withdrawal->amount_withdrawn = empty($request->input('amount_withdrawn'))? $request->withdrawable_amount : $request->amount_withdrawn;
                //$withdrawal->amount_withdrawn = $request->amount_withdrawn;
                $withdrawal->disbursed_by = Auth::id();
                $withdrawal->customer_id = $customer_id;
                if ($withdrawal->save()) {
                    //update customer current savings
                    $saving = Saving::where('customer_id',$customer_id)->where('cycle_complete',false)->first();
                    $saving->withdrawable_amount -= $withdrawal->amount_withdrawn;
                    $saving->saving_cycle_total -= $withdrawal->amount_withdrawn;
                    $saving->save();
                    //update customer balance
                    $balance->amount -= $withdrawal->amount_withdrawn;
                    $balance->save();
                    //record transaction
                    if($this->record_transaction('savings','disburse',0 - $withdrawal->amount_withdrawn,$customer_id,Auth::id())){
                        return "Cash disbursed!";
                    };
                }
            }
            else{
                return "Insufficient balance.";
            }
        }
        //HANDLE CLOSING SAVING
        elseif($action == 'close_saving'){
            $saving = Saving::where('customer_id',$customer_id)->where('cycle_complete',false)->first();
            $withdrawal = new Withdrawal;
            $withdrawal->amount_withdrawn = $saving->withdrawable_amount;
            $withdrawal->customer_id = $customer_id;
            $withdrawal->disbursed_by = Auth::id();
            if($withdrawal->save()){
                $saving->cycle_complete = true;
                $saving->withdrawable_amount -= $withdrawal->amount_withdrawn;
                $saving->saving_cycle_total -= $withdrawal->amount_withdrawn;
                $saving->save();
                $balance = Balance::where('customer_id',$customer_id)->first();
                $balance->amount -= $saving->saving_cycle_total;
                $balance->save();
                if($this->record_transaction('savings','close',0 - $saving->withdrawable_amount,$customer_id,Auth::id())){
                    $this->record_transaction('savings','collection', $saving->unit_amount,1,Auth::id(),true);
                    return "closing saving account";
                }
            }
        }
        //HANDLE CREATING SAVINGS
        else{
            $this->validate($request, [
                'unit_amount'       => 'required|numeric|min:50|max:50000',
                'saving_interval'   => 'required|string|min:4|max:7',
                'start_date'        => 'nullable|date',
            ]);
            $saving = new Saving;
            $saving->unit_amount        = $request->unit_amount;
            $saving->created_by         = Auth::id();
            $saving->customer_id        = $customer_id;
            $saving->saving_interval    = $request->saving_interval;
            if(!empty($request->input('start_date'))){
                $saving->start_date = $request->start_date;
            }
            //get saving cycle
            $saving->saving_cycle           = Saving::where('customer_id',$customer_id)->count() + 1;
            $saving->withdrawable_amount    = 0 - $saving->unit_amount;
            if($saving->save()){
                $this->record_transaction('savings','create',0,$customer_id,$saving->created_by);
                return "Store savings route reached and saving succeeded!";
            }
        }
    }
}
