<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Customer, Loan, Loan_repayment, User, Group};
use App\Classes\{CustomerClass, TransactionClass};
use Auth;

class GroupController extends Controller
{
    public function index(Request $request, $customer_id = false, $action = false){
        if($action == 'create_leaders'){
            $group_id = $customer_id;
            $group = Group::findOrFail($group_id);
            if ($request->has('leader_id')) {
                $this->validate($request, [
                    'leader_id'    => 'required|numeric|min:0|max:1000000',
                    'secretary_id'    => 'required|numeric|min:0|max:1000000',
                ]);
                $group->leader_id = $request->leader_id;
                $group->secretary_id = $request->secretary_id;
                $group->save();
                session()->flash('info',"Leaders for  \"$group->name\" Group has been Successfully Assigned");
                return back();
            }
            else{
                $members = Customer::where('group_id',$group_id)->get();
                $group->members = (count($members)>0)? $members : false;
                session()->flash('group',$group);
                return back();
                //return "Creating Group Leaders";
            }
        }//end create group leaders
        //Delete Group
        elseif($action == 'delete'){
            $group_id = $customer_id;
            $group = Group::where('id',$group_id)->first();
            $members = Customer::where('group_id',$group->id)->get();
            //return $members;
            foreach($members as $member){
                $member->group_id = null;
                $member->save();
            }
            $group_name = $group->name;
            if(Group::destroy($group_id)){
                session()->flash('info',"The Group \"$group_name\" has been Successfully Removed");
                return redirect('/customers/groups');
            }
        }
        elseif($action == 'add'){
            $this->validate($request, [
                'group'    => 'required|numeric|min:0|max:10000',
            ]);
            $group_id = $request->group;
            $group = Group::findOrFail($group_id);
            $customer =  Customer::findOrFail($customer_id);
            $group->population += 1;
            $group->members .= ($group->members == null)? ','.$customer_id.',' : $customer_id.',';
            if($group->save()){
                $customer->group_id = $group_id;
                $customer->save();
                session()->flash('info',"$customer->full_name has been added to the Group \"$group->name\" Successfully");
                return back();
            }
        }
        //remove member from group
        elseif($action == 'remove'){
            $customer_class = new CustomerClass('Group','Remove',0,$customer_id,Auth::id());
            $message = $customer_class->remove_from_group($customer_id);
            session()->flash('info',$message);
            return back();
        }
        else{
            $this->validate($request, [
                'name'            => 'required|string|min:3|max:255|unique:App\Group,name',
                'address'         => 'required|string|min:5|max:255',
                'staff_in_charge'  => 'required|numeric|min:1',
                'meeting_day'       => 'required|string|min:4|max:15',
            ]);
            $group = new Group;
            $group->name = $request->name;
            $group->address = $request->address;
            $group->staff_in_charge = $request->staff_in_charge;
            $group->meeting_day = $request->meeting_day;
            $group->created_by = Auth::id();
            $group->save();
            session()->flash('info',"The Group \"$group->name\" has been Successfully Created");
            return back();
        }
    }
}
