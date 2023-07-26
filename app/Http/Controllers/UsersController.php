<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\User;
use App\Models\Utility;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Session;
use Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class UsersController extends Controller
{

    public function index()
    {
        if(\Auth::user()->can('manage user'))
        {
            

                $data=Auth::user();
                if($data->user_type=="company")
                {
                    $user=User::where('created_by',$data->id)->get();
               
                    $role=Role::where('created_by',$data->id)->get();
                }
                else
                {
                    $user=User::where('created_by',$data->created_by)->where('id','!=',$data->id)->get();
               
                    $role=Role::where('created_by',$data->created_by)->get();
                }
                
                return view('admin.user.default')->with('user',$user)->with('role',$role);
            
        }
        else
        {
            return redirect()->route('dashboard')->with('error', __('Permission Denied.'));
        }
            
            
    }
    public function edit_user($id)
    {
        $data=User::where("id",$id)->first();
        $role=Role::where('name',$data->user_type)->first();
        if($role)
        {
            $data->role_id=$role->id;
        }
        else
        {
            $data->role_id=0;
        }
        return $data;
    }
    public function save_user(Request $request)
    {

        $data=Auth::user();
        if(\Auth::user()->can('create user'))
        {
            if(\Auth::user()->can('manage user'))
            {
                
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'name' => 'required|max:120',
                        'email' => 'required|email|unique:users',
                        'password' => 'required|min:8',
                        'role' =>'required',
                    ]
                );
            }
            

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->route('users')->with('error', $messages->first());
            }

            $store=new User();
            $store->name=$request->get('name');
            $store->email=$request->get('email');
            $store->email_verified_at=Carbon::now();
            $store->password=Hash::make($request->get('password'));
            if(\Auth::user()->user_type=="company")
            {
                $store->created_by=$data->id;
                
            }
            else
            {
                $store->created_by=$data->created_by;

            }
           
            
            $store->user_type=$request->get('role');
            if(\Auth::user()->is_json_upload==1)
            {
                $store->is_json_upload=1;
            }
               
            
            $store->save();
            
           if($store)
            {
               
                
                    
                    $role_r = Role::findByName($request->get('role'));
                    $store->assignRole($role_r);
                
                
               
                return redirect()->route('users')->with('success', __('User Added Successfully.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Something is wrong.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

    }
    public function delete_user($id)
    {
        if(\Auth::user()->can('delete user'))
        {
            $user=User::where('id',$id)->first();
            if($user)
            {
                $user_site=Site::where('created_by',$user->id)->delete();
                $user->delete();
                return redirect()->route('users')->with('success', __('User successfully deleted .'));
            } else {
                return redirect()->back()->with('error', __('Something is wrong.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
    public function update_user(Request $request)
    {
        $data=Auth::user();
         $id=$request->get('id');
        if(\Auth::user()->can('edit user'))
        {
            $validator = \Validator::make(
                    $request->all(),
                    [
                        'name' => 'required|max:120',
                        'email' => 'required|email|unique:users,email,' . $id,
                    ]
                );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->route('users')->with('error', $messages->first());
            }

            $store=User::where('id',$request->get('id'))->where('created_by',$data->id)->first();
            
            
            if($store)
            { 
                $role= Role::findById($request->role);
                if($role)
                {

                    $store->name=$request->get('name'); 
                    $store->user_type=$role->name;
                    $store->email=$request->get('email'); 
                    
                    $store->save();
                    if(\Auth::user()->user_type=="company")
                    {
                        $roles[] = $request->role;
                        $store->roles()->sync($roles);
                    }
                    return redirect()->route('users')->with('success', __('User Updated Successfully.'));
                }
                else
                {
                    return redirect()->back()->with('error', __('Something is wrong.'));
                }
            }
            else
            {
                return redirect()->back()->with('error', __('Something is wrong.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

    }
    

    public function account(Request $request)
    {
        $user             = Auth::user();
        

        return view('admin.user.account', compact('user'));
    }
    public function accountupdate(Request $request, $id = null)
    {
            $userDetail = \Auth::user();
            $user       = User::findOrFail($userDetail['id']);
            $this->validate(
                $request, [
                            'name' => 'required|max:120',
                            'email' => 'required|email|unique:users,email,' . $userDetail['id'],
                        ]
            );
    
            if($request->hasFile('avatar'))
            {
                $filenameWithExt = $request->file('avatar')->getClientOriginalName();
                $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension       = $request->file('avatar')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $settings = Utility::getStorageSetting();
                $dir        = 'avatar/';
                $url = '';
                $dir        = 'avatars/';
                $path = Utility::upload_file($request,'avatar',$fileNameToStore,$dir,[]);
                
                if($path['flag'] == 1){
                    $url = $path['url'];
                }else{
                    return redirect()->back()->with('error', __($path['msg']));
                }
                
                $user->avatar  = $fileNameToStore;
            }
            
            $user['name']  = $request['name'];
            $user['email'] = $request['email'];
            $user->save();
            
            return redirect()->back()->with('success', __('Profile successfully updated.'));
    }

    
    public function deleteAvatar()
    {
        $objUser         = Auth::user();
        if (asset(\Storage::exists('avatars/' . $objUser->avatar))) {
            asset(\Storage::delete('avatars/' . $objUser->avatar));
        }
        $objUser->avatar = '';
        $objUser->save();

        return redirect()->back()->with('success', 'Avatar deleted successfully');
    }
    public function updatePassword(Request $request)
    {
        if (Auth::Check()) {
            $request->validate(
                [
                    'old_password' => 'required',
                    'password' => 'required|same:password',
                    'confirm_password' => 'required|same:password',
                ]
            );

            $objUser          = Auth::user();
            $request_data     = $request->All();
            $current_password = $objUser->password;

            if (Hash::check($request_data['old_password'], $current_password)) {
                $objUser->password = Hash::make($request_data['password']);;
                $objUser->save();

                return redirect()->back()->with('success', __('Password Updated Successfully!'));
            }
            elseif($request->password != $request->password_confirmation)
            {
                return redirect()->back()->with('error',__('Confrom Password Does not Match with New Password'));
            }
            elseif($objUser->password != $request->old_password)
            {
                return redirect()->back()->with('error',__('Please Enter your right old password'));
            }
            else {
                return redirect()->back()->with('error', __('Please Enter Correct Current Password!'));
            }
        } else {
            return redirect()->back()->with('error', __('Some Thing Is Wrong!'));
        }
    }
      public function resetPassword(Request $request)
    {
        if (Auth::Check()) {

           
            
            $validator = \Validator::make(
                    $request->all(),
                    [
                        'password' => 'required|same:password|min:8',
                    'confirm_password' => 'required|same:password|min:8',

                    ]
                );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->route('users')->with('error', $messages->first());
            }

            $objUser          = User::where('id',$request->resete_id)->first();
            $request_data     = $request->All();
           

            if ($request->password == $request->confirm_password) {
                $objUser->password = Hash::make($request_data['password']);;
                $objUser->save();
 
                return redirect()->back()->with('success', __('Password Updated Successfully!'));
            }
            else
            {
                  
                return redirect()->back()->with('error',__('Confrom Password Does not Match with New Password'));
            }
            
        } else {
            
            return redirect()->back()->with('error', __('Some Thing Is Wrong!'));
        }
    }
}
