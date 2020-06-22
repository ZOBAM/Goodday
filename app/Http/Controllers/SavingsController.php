<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Customer, Saving, Savings_collection,Withdrawal,Balance};
use App\Classes\{CustomerClass};
use Auth;

class SavingsController extends Controller
{
    public function StoreSavings(Request $request, $customer_id = false, $action = false){
        //HANDLE COLLECTIONS
        if($action == 'collection'){
            $this->validate($request, [
                'amount_saved'       => 'required|numeric|min:50|max:50000',
            ]);
            $saving = Saving::where('customer_id',Session()->get('current_customer')->id)->first();
            $collection = new Savings_collection;
            $collection->amount_saved = $request->amount_saved;
            $collection->saving_id = $customer_id;
            $collection->collected_by = Auth::id();
            $not_first_collection = Savings_collection::where('saving_id',$saving->id)->first();
            if($collection->save()){
                //update balance table
                $balance = Balance::where('customer_id',Session()->get('current_customer')->id)->first();
                $balance->amount += $collection->amount_saved;
                $balance->save();
                //update the savings table
                $saving->collection_count += 1;
                $saving->saving_cycle_total += $collection->amount_saved;
                if (!$not_first_collection) {
                    $saving->withdrawable_amount = $collection->amount_saved - $saving->unit_amount;
                }
                else{
                    $saving->withdrawable_amount += $collection->amount_saved;
                }
                $saving->save();
            }
            return "Collection submitted";
        }
        //HANDLE DISBURSING
        elseif ($action == 'disburse') {
            $this->validate($request, [
                'amount_withdrawn'       => 'required|numeric|min:50|max:50000',
            ]);
            //get customer balance
            $balance = Balance::where('customer_id',$customer_id)->first();
            if($balance->amount>=$request->amount_withdrawn){
                $withdrawal = new Withdrawal;
                $withdrawal->amount_withdrawn = $request->amount_withdrawn;
                $withdrawal->disbursed_by = Auth::id();
                $withdrawal->customer_id = $customer_id;
                if ($withdrawal->save()) {
                    $balance->amount -= $withdrawal->amount_withdrawn;
                    $balance->save();
                    return "Cash disbursed!";
                }
            }
            else{
                return "Insufficient balance.";
            }
        }
        //HANDLE CLOSING SAVING
        elseif($action == 'close_saving'){
            $saving = Saving::where('customer_id',$customer_id)->first();
            $saving->cycle_complete = true;
            if($saving->save()){
                $balance = Balance::where('customer_id',$customer_id)->first();
                $balance->amount -= $saving->saving_cycle_total;
                $balance->save();
            }
            return "closing saving account";
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
            $saving->saving_cycle       = Saving::where('customer_id',$customer_id)->count() + 1;
            $saving->save();
            return "Store savings route reached and saving succeeded!";
        }
    }
}
