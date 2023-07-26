<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\User;
use App\Models\Utility;
use App\Models\Site;
use App\Models\Credintials;
use App\Models\Coupon;
use App\Models\Order;
use Artisan;
use DB;
use Carbon\Carbon;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{

    public function dashboard()
    {
       
        $user=Auth::user();
        
        if((\Auth::user()->user_type == 'company'))
        {   
            $site=Site::where('created_by',$user->id)->get();
            return view('admin.dashboard')->with('site',$site);
        }
        else
        {
            $site=Site::where('created_by',$user->created_by)->get();
             return view('admin.dashboard')->with('site',$site);
        }
        
    }
    public function landingPage()
    {
        if (!file_exists(storage_path() . "/installed")) {
            header('location:install');
            die;
         }

        $setting = Utility::settings();
        if ($setting['display_landing'] == 'on' && \Schema::hasTable('landing_page_settings')) {
            
        	
            return view('landingpage::layouts.landingpage');
        } else {
            return redirect('login');
        }
    }
     public function getOrderChart($arrParam)
    {
        $arrDuration = [];
        if ($arrParam['duration']) {
            if ($arrParam['duration'] == 'week') {
                $previous_week = strtotime("-1 week +1 day");
                for ($i = 0; $i < 7; $i++) {
                    $arrDuration[date('Y-m-d', $previous_week)] = date('d-m', $previous_week);
                    $previous_week = strtotime(date('Y-m-d', $previous_week) . " +1 day");
                }
            }
        }
        $arrTask = [];
        $arrTask['label'] = [];
        $arrTask['data'] = [];
        foreach ($arrDuration as $date => $label) {
            $data = Order::select(\DB::raw('count(*) as total'))->whereDate('created_at', '=', $date)->first();
            $arrTask['label'][] = $label;
            $arrTask['data'][] = $data->total;
        }

  
        return $arrTask;
    }
    public function save_json(Request $request)
    {
         
         $user= Auth::user();
         if($user->user_type=="company")
         {
            if($request->has('json_file'))
            {
                $store=Credintials::where('user_id',$user->id)->first();
                if($store)
                {
                    $store=Credintials::where('id',$store->id)->first();
                }
                else
                {
                    $store=new Credintials();

                }
                $store->user_id=$user->id;
                $store->json=$request->file('json_file')->getContent();
                $store->save();
                if($store)
                {
                    $user->is_json_upload=1;
                    $user->save();
                    $sub_user=User::where('created_by',$user->id)->update(['is_json_upload' =>1]);
                    return redirect()->route('dashboard')->with('success', __('Your Credintials has been saved'));
                }
                else
                {
                    return redirect()->back()->with('error', __('Something want worng.'));
                }
            }
            else
            {
                 return redirect()->back()->with('error', __('Something want worng.'));
            }
            

         }
         else
        {
             return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

}
