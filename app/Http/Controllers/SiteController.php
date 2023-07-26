<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\Plan;
use App\Models\Widget;
use App\Models\Utility;
use App\Models\Settings;
use Google_Client;
use Google_Service_Analytics;
use Session;
use Google_Service_AnalyticsReporting;
use Google_Service_AnalyticsReporting_DateRange;
use Google_Service_AnalyticsReporting_Metric;
use Google_Service_AnalyticsReporting_ReportRequest;
use Google_Service_AnalyticsReporting_GetReportsRequest;
use DataTables;
use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class SiteController extends Controller
{



    function getProperty(Request $request)
    {   
		$token=Session::get("access_token");
    	$id=$request->get('account_id');
    	$client=$this->authmain();
        $client->setAccessToken($token['access_token']);
        $analytics    = new Google_Service_Analytics($client);
        $propertyResp = [];
        try
        {
            $properties = $analytics->management_webproperties->listManagementWebproperties($id);
        }
        catch(apiServiceException $e)
        {
            $propertyResp['is_success'] = false;
            $propertyResp['data']       = 'There was an Analytics API service error ' . $e->getCode() . ':' . $e->getMessage();
        }
        catch(apiException $e)
        {
            $propertyResp['is_success'] = false;
            $propertyResp['data']       = 'There was a general API error ' . $e->getCode() . ':' . $e->getMessage();
        }

        if(count($properties->getItems()) > 0)
        {
            foreach($properties->getItems() as $property)
            {
                $dataProperty           = [];
                $dataProperty['acc_id'] = $property->getAccountId();
                $dataProperty['id']     = $property->getId();
                $dataProperty['name']   = $property->getName();

                $propertyResp[] = $dataProperty;
            }
        }
        else
        {
            $propertyResp['is_success'] = false;
            $propertyResp['data']       = 'No Data Found.!';
        }
		$output="<option selected disabled>Select Account Id</option>";
        foreach ($propertyResp as $value) {
                    	
        	$output.='<option value="'.$value['id'].'" data-id="'.$value['name'].'">'.$value['id'].' - '.$value['name'].'</option>';
        
        }
        
        return $output;
       
    }

    function getView(Request $request)
    {
    	$acc_id=$request->get('account_id');
    	$p_id=$request->get('property_id');
		$token=Session::get("access_token");
    	$client=$this->authmain();
        $client->setAccessToken($token['access_token']);
        $analytics = new Google_Service_Analytics($client);
        $viewResp  = [];
        try
        {
            $views = $analytics->management_profiles->listManagementProfiles($acc_id, $p_id);
        }
        catch(apiServiceException $e)
        {
            $viewResp['is_success'] = false;
            $viewResp['data']       = 'There was an Analytics API service error ' . $e->getCode() . ':' . $e->getMessage();

        }
        catch(apiException $e)
        {
            $viewResp['is_success'] = false;
            $viewResp['data']       = 'There was a general API error ' . $e->getCode() . ':' . $e->getMessage();
        }

        if(count($views->getItems()) > 0)
        {
            foreach($views->getItems() as $view)
            {
                $dataView         = [];
                $dataView['id']   = $view->getId();
                $dataView['name'] = $view->getName();

                $viewResp[] = $dataView;
            }
        }
        else
        {
            $viewResp['is_success'] = false;
            $viewResp['data']       = 'No Record Found';
        }
        $output="<option selected disabled>Select Account Id</option>";
        foreach ($viewResp as $value) {
                    	
        	$output.='<option value="'.$value['id'].'" data-id="'.$value['name'].'">'.$value['id'].' - '.$value['name'].'</option>';
        
        }
        
        return $output;
    }


    public function save_site(Request $request){
        $user= Auth::user();
        
        if(\Auth::user()->can('create site'))
        {
            $validation         = [];
            $validation['account_id'] = 'required';
            $validation['view_id'] = 'required';
            $validation['property_id']  = 'required';


            $validator = \Validator::make(
                $request->all(), $validation
            );

            if($validator->fails())
            {
                return redirect()->back()->with('error', $validator->errors()->first());
            }
            else
            {
                if (Session::get("access_token")!='' && !empty(Session::get("access_token")))
                {
                    if(\Auth::user()->user_type == 'company')
                    {
                        $check=Site::where('view_id',$request->get('view_id'))->where('created_by',$user->id)->first();
                    }
                    else
                    {
                        $check=Site::where('view_id',$request->get('view_id'))->where('created_by',$user->created_by)->first();
                    }
                    if($check)
                    {
                        return redirect()->back()->with('error', __('Site is already exist'));
                    }
                    else
                    {
                        $access_token=Settings::where('created_by',$user->id)->where('name','comapny_access_token')->first();
                        $refresh_token=Settings::where('created_by',$user->id)->where('name','comapny_refresh_token')->first();

                        $store=new Site();
                        $store->account_id=$request->get('account_id');
                        $store->site_name=$request->get('site_name');
                        $store->property_id=$request->get('property_id');
                        $store->property_name=$request->get('property_name');
                        $store->view_id=$request->get('view_id');
                        $store->view_name=$request->get('view_name');
                        $store->accessToken=$access_token->value;
                        $store->refreshToken=$refresh_token->value;
                        if(\Auth::user()->user_type == 'company')
                        {

                            $store->created_by=$user->id;
                        }
                        else
                        {
                            $store->created_by=$user->created_by;
                        }

                        $store->save();
                        if($store)
                        {
                            $store->share_setting='{"dashboard":{"new_user_report":1,"user_report":1,"bounce_rate_report":1,"session_duration_report":1,"user_location_report":1,"live_user_report":1,"page_report":1,"device_report":1,"is_password":0,"password":null},"channel":{"all":1,"organic_search":1,"paid_search":1,"bounce":1,"referrals":1,"converters":1,"other":0,"is_password":0,"password":null},"audience":{"region":1,"organic_search":1,"paid_search":1,"bounce":1,"is_password":0,"password":null},"page":{"page_title":1,"landing_page":1,"exit_page":1,"is_password":0,"password":null},"custom":{"share_metric":"ga:avgSessionDuration","share_metric_name":"Session Time","share_dimension":"ga:source","share_dimension_name":"Source","is_password":0,"password":null},"seo":{"keyword":1,"social_network":1,"source":1,"browser":1,"operating_system":1,"device":1,"is_password":0,"password":null}}';
                                    $store->save();
                            return redirect()->route('dashboard')->with('success', __('Site Added Successfully.'));
                        }
                        else
                        {
                            
                            return redirect()->back()->with('error', __('Something is wrong.'));
                        }
                    }
                    
                }
                else
                {
                    return redirect()->back()->with('error', __('Session is expired.'));
                }
            } 
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
               
	}

	public function site_standard($id)
	{
        $user=Auth::user();

        if($user->user_type=="company")
        {
            $all_site=Site::where('created_by',$user->id)->get();
           
    		if($id==0)
            {
                $data=Site::where('created_by',$user->id)->first();
            }
            else
            {
                $data=Site::where('id',$id)->where('created_by',$user->id)->first();
            }
        }
        else{
            $all_site=Site::where('created_by',$user->created_by)->get();
           
            if($id==0)
            {
                $data=Site::where('created_by',$user->created_by)->first();
            }
            else
            {
                $data=Site::where('id',$id)->where('created_by',$user->created_by)->first();
            }
        }
       

		return view('admin.site.site-standard')->with('data',$data)->with("all_site",$all_site);
        
	}
    public function manage_site()
    {
        
        return view('admin.site.manage-site');
    }

    public function site_list()
    {
        $data =Site::get();
         return DataTables::of($data)          
            ->editColumn('site_name', function ($data) {
                return $data->site_name;
            }) 
            
            ->editColumn('account_id', function ($data) {
                return $data->account_id;
            }) 
            ->editColumn('property_id', function ($data) {
                return $data->property_id;
            }) 
            ->editColumn('view_id', function ($data) {
                return $data->view_id;
            }) 
            ->editColumn('action', function ($data) {
                 $edit = route('edit-site', ['id'=>$data->id]);
                 $delete = route('delete-site',['id'=>$data->id]);
                return '

                <a class="btn btn-info"  data-bs-toggle="modal"  onclick="edit_site('.$data->id.')" data-bs-target="#edit_site_modal">Update</a>


                <a onclick="delete_record(' . "'" . $delete. "'" . ')" rel="tooltip"  class="btn btn-danger" data-original-title="Remove" style="margin-right: 10px;color:white !important">Delete</a>';   


            })  
            ->addIndexColumn()         
            ->make(true);
    }

    public function edit_site($id)
    {
        $data=Site::where('id',$id)->first();
        return $data;
    }
    public function delete_site($id)
    {
        $data=Site::where('id',$id)->first();
        if($data)
        {
            $widget=Widget::where('site_id',$data->id)->delete();
            $data->delete();

            return redirect()->route('manage-site')->with('success', __('Site Deleted Successfully.'));
        }
        else
        {
           
            return redirect()->back()->with('error', __('Something is wrong.'));
        }
       
    }

    public function site_dashboard_link($id, $lang,Request $request)
    {
        $id = \Illuminate\Support\Facades\Crypt::decrypt($id);
       
        
        
        $data=Site::where('id',$id)->first();
        


        $json=json_decode($data->share_setting);
         
         \Session::put('lang', $lang);

        \App::setLocale($lang);

        $companySettings['title_text']      = \DB::table('settings')->where('created_by', $data->created_by)->where('name', 'title_text')->first();
        $companySettings['footer_text']     = \DB::table('settings')->where('created_by', $data->created_by)->where('name', 'footer_text')->first();
        $companySettings['company_favicon'] = \DB::table('settings')->where('created_by', $data->created_by)->where('name', 'company_favicon')->first();
        $companySettings['company_logo']    = \DB::table('settings')->where('created_by', $data->created_by)->where('name', 'company_logo')->first();
        $languages                          = Utility::languages();

        $currantLang = \Session::get('lang');
        if(empty($currantLang))
        {
            $currantLang = !empty($data->createdBy) ? $data->createdBy->lang : 'en';
        }



        if(\Session::get('copy_pass_true'. $id) == $json->dashboard->password . '-' . $id)
        {
           
            return view('share-link.site-standard')->with('data',$data)->with('json',$json->dashboard)->with('companySettings',$companySettings)->with('currantLang',$currantLang)->with('languages',$languages);
        }else
        {

            if(!isset($json->dashboard->is_password) || $json->dashboard->is_password != '1')
            {
                
                return view('share-link.site-standard')->with('data',$data)->with('json',$json->dashboard)->with('companySettings',$companySettings)->with('currantLang',$currantLang)->with('languages',$languages);

            }elseif(isset($json->dashboard->is_password) && $json->dashboard->is_password == '1' && $request->password == base64_decode($json->dashboard->password)){

                \Session::put('copy_pass_true'.$id, $json->dashboard->password . '-' . $id);

                return view('share-link.site-standard')->with('data',$data)->with('json',$json->dashboard)->with('companySettings',$companySettings)->with('currantLang',$currantLang)->with('languages',$languages);

            }else{

                $route='site.dashboard.link';
                $param=[\Illuminate\Support\Facades\Crypt::encrypt($id),'en'];
                return view('share-link.share_link_password', compact('id','route','param'));
            }
        }

      

       

     
    }

    public function site_analyse_link($id,$type, $lang,Request $request)
    {

            $id = \Illuminate\Support\Facades\Crypt::decrypt($id);
            $type = \Illuminate\Support\Facades\Crypt::decrypt($type);
           
          
            $data=Site::where('id',$id)->first();
            
            $json=json_decode($data->share_setting);
            $status=0;
            foreach ($json as $key => $value) {
                
                if($key==$type)
                {
                    $status=1;
                }
                
            }
        
            

            if($status!=1)
            {
                return view('share-link.error');
            }

             \Session::put('lang', $lang);

            \App::setLocale($lang);
             $metric_option=$this->arrUsableMetrics();
            $companySettings['title_text']      = \DB::table('settings')->where('created_by', $data->created_by)->where('name', 'title_text')->first();
            $companySettings['footer_text']     = \DB::table('settings')->where('created_by', $data->created_by)->where('name', 'footer_text')->first();
            $companySettings['company_favicon'] = \DB::table('settings')->where('created_by', $data->created_by)->where('name', 'company_favicon')->first();
            $companySettings['company_logo']    = \DB::table('settings')->where('created_by', $data->created_by)->where('name', 'company_logo')->first();
            $languages                          = Utility::languages();

            $currantLang = \Session::get('lang');
            if(empty($currantLang))
            {
                $currantLang = !empty($data->createdBy) ? $data->createdBy->lang : 'en';
            }

            

       
        if(\Session::get('copy_pass_true'. $id) == $json->$type->password . '-' . $id)
        {
           
            return view('share-link.'.$type.'')->with('type',$type)->with('data',$data)->with("metric_option",$metric_option)->with('json',$json->$type)->with('companySettings',$companySettings)->with('currantLang',$currantLang)->with('languages',$languages);
        }else
        {

            if(!isset($json->$type->is_password) || $json->$type->is_password != '1')
            {
                
                return view('share-link.'.$type.'')->with('type',$type)->with('data',$data)->with("metric_option",$metric_option)->with('json',$json->$type)->with('companySettings',$companySettings)->with('currantLang',$currantLang)->with('languages',$languages);

            }elseif(isset($json->$type->is_password) && $json->$type->is_password == '1' && $request->password == base64_decode($json->$type->password)){

                \Session::put('copy_pass_true'.$id, $json->$type->password . '-' . $id);

                return view('share-link.'.$type.'')->with('type',$type)->with('data',$data)->with("metric_option",$metric_option)->with('json',$json->$type)->with('companySettings',$companySettings)->with('currantLang',$currantLang)->with('languages',$languages);

            }else{

               $route='site.analyse.link';
                $param=[\Illuminate\Support\Facades\Crypt::encrypt($id),\Illuminate\Support\Facades\Crypt::encrypt($type),'en'];

                return view('share-link.share_link_password', compact('id','type','route','param'));
            }
        }


       

     
    }
    public function show_site_share_setting($id,$type)
    {
        
       
        $site=Site::where('id',$id)->first();
        $lng=!empty($site)?$site->createdBy->lang:'en';
        if($type=="dashboard")
        {
            $html=' <a href="#"id="'.route("site.dashboard.link",[\Illuminate\Support\Facades\Crypt::encrypt($site->id),$lng]).'" class="btn  btn-primary"  onclick="copyToClipboard(this)" data-bs-toggle="tooltip" title="{{__("Copy")}}" data-original-title="{{__("Click to copy")}}">Share Report</a>';
        }
        else
        {
            $html=' <a href="#"id="'.route("site.analyse.link",[\Illuminate\Support\Facades\Crypt::encrypt($site->id),\Illuminate\Support\Facades\Crypt::encrypt($type),$lng]).'" class="btn  btn-primary"  onclick="copyToClipboard(this)" data-bs-toggle="tooltip" title="{{__("Copy")}}" data-original-title="{{__("Click to copy")}}">Share Report</a>';
        }
        
        
       
        $main_array=json_decode($site->share_setting);
        $json_arr=array();
        $data=array();
        foreach ($main_array as $key => $value) {
           if($key==$type)
           {
                if($value->is_password==1)
                {
                    $value->password=base64_decode($value->password);
                   
                    
                }
                else
                {
                    $value->password=$value->password;
                }
                $json_arr=$value;
           }
           
        }
        $data['type']=$type;
        $data['json']=$json_arr;
        $data['link']=$html;
        
        return $data;
    }
     public function site_share_setting(Request $request,$type)
    {
       

        $site=Site::where('id',$request->share_site)->first();
        $lng=!empty($site)?$site->createdBy->lang:'en';
        
        $main_json=$site->share_setting;
        $main_array=json_decode($main_json);
        
       if(!empty($main_array))
        {
            foreach ($main_array as $key => $value) {
               if($key==$type)
               {
                    unset($main_array->$key);
               }
               
            }
        }
        if($type=="standard"  )
        {
            $data=array(
                "new_user_report" => $request->has('new_user_report') ? 1 : 0,
                "user_report" => $request->has('user_report') ? 1 : 0,
                "bounce_rate_report" => $request->has('bounce_rate_report') ? 1 : 0,
                "session_duration_report" => $request->has('session_duration_report') ? 1 : 0,
                "user_location_report" => $request->has('user_location_report') ? 1 : 0,
                "live_user_report" => $request->has('live_user_report') ? 1 : 0,
                "page_report" => $request->has('page_report') ? 1 : 0,
                "device_report" => $request->has('device_report') ? 1 : 0,
                "is_password" => $request->has('is_password') ? 1 : 0,
                "password" => $request->has('is_password') ? base64_encode($request->password) :null,
            );
        }
        
        if($type=="dashboard"  )
        {
            $data=array(
                "new_user_report" => $request->has('new_user_report') ? 1 : 0,
                "user_report" => $request->has('user_report') ? 1 : 0,
                "bounce_rate_report" => $request->has('bounce_rate_report') ? 1 : 0,
                "session_duration_report" => $request->has('session_duration_report') ? 1 : 0,
                "user_location_report" => $request->has('user_location_report') ? 1 : 0,
                "live_user_report" => $request->has('live_user_report') ? 1 : 0,
                "page_report" => $request->has('page_report') ? 1 : 0,
                "device_report" => $request->has('device_report') ? 1 : 0,
                "is_password" => $request->has('is_password') ? 1 : 0,
                "password" => $request->has('is_password') ? base64_encode($request->password) :null,
            );
        }
        if($type=="channel")
        {
            $data=array(
                "all" => $request->has('all') ? 1 : 0,
                "organic_search" => $request->has('organic_search') ? 1 : 0,
                "paid_search" => $request->has('paid_search') ? 1 : 0,
                "bounce" => $request->has('bounce') ? 1 : 0,
                "referrals" => $request->has('referrals') ? 1 : 0,
                "converters" => $request->has('converters') ? 1 : 0,
                "other" => $request->has('other') ? 1 : 0,
                "is_password" => $request->has('is_password') ? 1 : 0,
                "password" => $request->has('is_password') ? base64_encode($request->password) :null,
            );
        }
        if($type=="audience")
        {
            $data=array(
                "region" => $request->has('region') ? 1 : 0,
                "organic_search" => $request->has('organic_search') ? 1 : 0,
                "paid_search" => $request->has('paid_search') ? 1 : 0,
                "bounce" => $request->has('bounce') ? 1 : 0,
                "is_password" => $request->has('is_password') ? 1 : 0,
                "password" => $request->has('is_password') ? base64_encode($request->password) :null,
            );
        }
        if($type=="page")
        {
            $data=array(
                "page_title" => $request->has('page_title') ? 1 : 0,
                "landing_page" => $request->has('landing_page') ? 1 : 0,
                "exit_page" => $request->has('exit_page') ? 1 : 0,
                "is_password" => $request->has('is_password') ? 1 : 0,
                "password" => $request->has('is_password') ? base64_encode($request->password) :null,
            );
        }
        if($type=="seo")
        {
            $data=array(
                "keyword" => $request->has('keyword') ? 1 : 0,
                "social_network" => $request->has('social_network') ? 1 : 0,
                "source" => $request->has('source') ? 1 : 0,
                "browser" => $request->has('browser') ? 1 : 0,
                "operating_system" => $request->has('operating_system') ? 1 : 0,
                "device" => $request->has('device') ? 1 : 0,
                "is_password" => $request->has('is_password') ? 1 : 0,
                "password" => $request->has('is_password') ? base64_encode($request->password) :null,
            );

           
        }
        if($type=="custom")
        {

            $data=array(
                "share_metric" => $request->share_met,
                "share_metric_name" => $request->share_metric,
                "share_dimension" => $request->share_dim,
                "share_dimension_name" => $request->share_dimension,
                "is_password" => $request->has('is_password') ? 1 : 0,
                "password" => $request->has('is_password') ? base64_encode($request->password) :null,
            );
        }

        if(!empty($main_array))
        {

            $main_array->$type=$data;
        }
        else
        {
           $main_array[$type]=$data;
            
        }
        $json=json_encode($main_array);
        $site->share_setting=$json;
        $site->save();
        if($type=="seo")
        {
             $type='seo-analysis';
        }
        if($type=="standard")
        {
             return redirect()->back()->with('success', __('Setting Save Successfully'));
            
        }
        elseif($type=="custom")
        {
            $html='<a href="#"id="'.route("site.analyse.link",[\Illuminate\Support\Facades\Crypt::encrypt($site->id),\Illuminate\Support\Facades\Crypt::encrypt($type),$lng]).'" class="btn  btn-primary"  onclick="copyToClipboard(this)" data-bs-toggle="tooltip" title="{{__("Copy")}}" data-original-title="{{__("Click to copy")}}">Share Report</a>';
             return $html;
        }
        else
        {
            return redirect()->route($type)->with('success', __('Setting Save Successfully'));
        }
        
    }

    public function share_link_error($lang)
    {
        $languages= Utility::languages();
        $currantLang = \Session::get('lang');
         if(empty($currantLang))
        {
            $currantLang = !empty($user) ? $user->lang : 'en';
        }

         return view('share-link.error')->with('currantLang',$currantLang)->with('languages',$languages);
    }
}
