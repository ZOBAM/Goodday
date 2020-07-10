<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\{User,Admin};
use Illuminate\Support\Facades\Hash;
use Auth;

class AdminController extends Controller
{
    protected function index(Request $request, $staff_id = false, $action = false){
        //keep unauthorized staffs away
        if(!(Auth::user()->rank > 1)){
            return redirect('/customers');
        }
        if($action && is_numeric($staff_id)){
            $staff = User::findOrFail($staff_id);
            if($action == 'make-admin'){
                $admin = new Admin;
                $admin->rank = 2;
                $admin->designation = 'Admin';
                $admin->staff_id = $staff_id;
                $admin->added_by = Auth::id();
                if($admin->save()){
                    $staff->rank = 2;
                    $staff->save();
                }
                session()->flash('info','Admin Addeded Successfully.');
                return back();
            }
            elseif($action == 'remove-admin'){
                $admin = Admin::where('staff_id',$staff_id)->first();
                if(Admin::destroy($admin->id)){
                    $staff->rank = 1;
                    $staff->save();
                    session()->flash('info','Admin removed Successfully.');
                    return back();
                }
            }
            elseif($action == 'remove-staff'){
                $admin = Admin::where('staff_id',$staff_id)->first();
                if($admin){
                    Admin::destroy($admin->id);
                }
                $staff->rank = 0;
                $staff->save();
                session()->flash('info','Staff Account removed Successfully.');
                return back();
            }
            else{
                return redirect("/");
            }
        }
        else{
            $this->validate($request, [
                'first_name'       => 'required|string|min:2|max:25',
                'surname'   => 'required|string|min:2|max:25',
                'other_name'   => 'required|string|min:2|max:25',
                'phone_number'   => 'required|string|min:11|max:14',
                'bvn'        => 'required|numeric|min:10000000000',
                'email'        => 'required|string|email|max:55|unique:users',
                'passport'        => 'image|mimes:jpeg,png,jpg|max:10240',
                'password'        => 'nullable|required|string|min:8|confirmed',
            ]);
            $user = new User;
                $user->first_name   = $request->first_name;
                $user->surname      = $request->surname;
                $user->other_name   = $request->other_name;
                $user->phone_number = $request->phone_number;
                $user->bvn          = $request->bvn;
                $user->email        = $request->email;
                $user->password     = Hash::make($request->password);
                $user->save();
            //check if image was uploaded and process it.
            if ($request->hasFile('passport')){
                $image = $request->file('passport');
                $imageName = time().'_goodday_staff'.$user->id.'.'.$image->getClientOriginalExtension();
                $move_path = (is_dir(public_path('../../public/images/')))? public_path('../../public/images/staffs/'):'images/staffs/' ;
                //check if the customer already has an image in the directory and delete before adding new one
                /* if($customer_id){
                    if(file_exists($move_path.'/'.$customer->passport_link)){
                        unlink($move_path.'/'.$customer->passport_link);
                    }
                } */
                $image->move($move_path, $imageName);
                $user->passport_link = $imageName;
                $user->save();
            }
            session()->flash('info','Staff Account created Successfully.');
            return back();
        }
    }//end index
}
