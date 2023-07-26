<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Utility;
use App\Models\Settings;
use App\Models\Site;
use App\Models\User;
use App\Models\ReportSetting;
use Validator;
use Illuminate\Support\Facades\Artisan;
use App\Mail\EmailTest;
use Illuminate\Support\Facades\Mail;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class CompanySettingController extends Controller
{
    public function settings()
    {
        
        $objUser          = Auth::user();
        $report_setting =  ReportSetting::where('created_by', $objUser->id)->first();
        $com_setting=Site::where('created_by', $objUser->id)->first();
        $location =  Settings::where('created_by', $objUser->id)->pluck('value', 'name')->toArray();

        $path = storage_path() . '/' . 'framework/';
        $size = \File::size(storage_path('/framework'));
        $file_size = 0;
        foreach (\File::allFiles(storage_path('/framework')) as $file) {
            $file_size += $file->getSize();
        }
        $file_size = number_format($file_size / 1000000, 4);


        if(\Auth::user()->can('manage company settings'))
        {
            return view('admin.user.setting', compact('location','report_setting' , 'file_size'));
        } else {
            return redirect()->route('dashboard')->with('error', __("You can not access site Settings!"));
        }
    }

    public function settingsStore(Request $request)
    {
        $objUser          = Auth::user();
        $Settings = Settings::where('created_by',$objUser->id)->first();

        if(\Auth::user()->can('manage company settings')) {
            $validate      = [];
            $validator = Validator::make(
                $request->all(),
                $validate
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $post = $request->all();
            unset($post['_token']);

            if ($request->header_text) {
                $header_text = $request->header_text;
                $setting = Settings::updateOrCreate(
                    ['name' => 'header_text', 'created_by' => Auth::user()->id],
                    ['name' => 'header_text', 'value' => $header_text, 'created_by' => Auth::user()->id]
                )->get();
            }
            if ($request->footer_text) {
                $footer_text = $request->footer_text;
                $setting = Settings::updateOrCreate(
                    ['name' => 'footer_text', 'created_by' => Auth::user()->id],
                    ['name' => 'footer_text', 'value' => $footer_text, 'created_by' => Auth::user()->id]
                )->get();
            }

            if ($request->company_email) {
                $company_email = $request->company_email;
                $setting = Settings::updateOrCreate(
                    ['name' => 'company_email', 'created_by' => Auth::user()->id],
                    ['name' => 'company_email', 'value' => $company_email, 'created_by' => Auth::user()->id]
                )->get();
            }

            if ($request->company_email_from_name) {
                $company_email_from_name = $request->company_email_from_name;
                $setting = Settings::updateOrCreate(
                    ['name' => 'company_email_from_name', 'created_by' => Auth::user()->id],
                    ['name' => 'company_email_from_name', 'value' => $company_email_from_name, 'created_by' => Auth::user()->id]
                )->get();
            }


            foreach ($post as $key => $name) {
                $favicon = Settings::updateOrCreate(
                    ['created_by' => $objUser->id, 'name' => $key],
                    ['created_by' => $objUser->id, 'name' => $key, 'value' => $name]
                );

                if ($request->light_logo) {

                    Artisan::call('cache:clear');
                    $request->validate(['light_logo' => 'required']);
                    $logoName = 'light_logo_' . Auth::user()->id . '.png';

                    $request->validate(
                        [
                            'light_logo' => 'image|mimes:png|max:20480',
                        ]
                    );

                    $validation = [
                        'mimes:' . 'png',
                        'max:' . '20480',
                    ];

                    // $logoName = 'logo-light.png';
                    $dir = 'logo/';


                    $path = Utility::upload_file($request, 'light_logo', $logoName, $dir, $validation);

                    if ($path['flag'] == 1) {

                        $light_logo = $path['url'];

                    } else {
                        return redirect()->back()->with('error', __($path['msg']));
                    }

                    // $request->file('light_logo')->storeAs('logo' , $logoName);
                    $logo = Settings::updateOrCreate(
                        ['created_by' => Auth::user()->id, 'name' => 'company_light_logo'],
                        ['created_by' => Auth::user()->id, 'name' => 'company_light_logo', 'value' => $logoName]
                    );

                }

                if ($request->dark_logo) {
                    Artisan::call('cache:clear');

                    $logoName = 'dark_logo_' . Auth::user()->id . '.png';
                    // dd($logoName);
                    $request->validate(
                        [
                            'dark_logo' => 'image',
                        ]
                    );

                    $validation = [
                        'mimes:' . 'png',
                        'max:' . '20480',
                    ];

                    // $logoName = 'logo-dark.png';
                    $dir = 'logo/';


                    $path = Utility::upload_file($request, 'dark_logo', $logoName, $dir, $validation);

                    if ($path['flag'] == 1) {
                        $dark_logo = $path['url'];
                    } else {
                        return redirect()->back()->with('error', __($path['msg']));
                    }
                    // $request->dark_logo->storeAs('logo', $logoName);

                    $logo = Settings::updateOrCreate(
                        ['created_by' => Auth::user()->id, 'name' => 'company_dark_logo'],
                        ['created_by' => Auth::user()->id, 'name' => 'company_dark_logo', 'value' => $logoName]
                    );

                }

                if ($request->company_favicon) {
                    // dd($request->company_favicon);
                    Artisan::call('cache:clear');
                    $request->validate(['company_favicon' => 'required']);
                    $logoName = 'company_favicon_' . Auth::user()->id . '.png';

                    $request->validate(
                        [
                            'company_favicon' => 'image',
                        ]
                    );

                    $validation = [
                        'mimes:' . 'png',
                        'max:' . '20480',
                    ];


                    $dir = 'logo/';
                    // dd($request,$logoName,$dir,$validation);
                    $path = Utility::upload_file($request, 'company_favicon', $logoName, $dir, $validation);

                    if ($path['flag'] == 1) {
                        $company_favicon = $path['url'];
                    } else {
                        return redirect()->back()->with('error', __($path['msg']));
                    }
                    // $request->company_favicon->storeAs('logo', $logoName);
                    $company_favicon = Settings::updateOrCreate(
                        ['created_by' => Auth::user()->id, 'name' => 'company-favicon'],
                        ['created_by' => Auth::user()->id, 'name' => 'company-favicon', 'value' => $logoName]
                    );
                    // dd($company_favicon);

                }



                if (!isset($request->color) || !empty($request->cust_theme_bg) || !empty($request->cust_darklayout)) {
                    $post = $request->all();

                    $post['cust_theme_bg'] = (!empty($request->cust_theme_bg) && $request->cust_theme_bg == 'on') ? $request->cust_theme_bg : 'off';
                    $post['cust_darklayout'] = (!empty($request->cust_darklayout) && $request->cust_darklayout == 'on') ? $request->cust_darklayout : 'off';
                    $post['color'] = (!empty($request->color) &&  $request->has('color')) ? $request->color : 'theme-3';



                    if (!isset($request->color)) {
                        $color = $request->has('color') ? $request->color : 'theme-3';
                        $post['color'] = $color;
                    }

                    if (!isset($request->cust_theme_bg)) {
                        $cust_theme_bg         = (isset($request->cust_theme_bg)) ? 'on' : 'off';
                        $post['cust_theme_bg'] = $cust_theme_bg;
                    }

                    if (!isset($request->cust_darklayout)) {
                        $cust_darklayout         = (isset($request->cust_darklayout)) ? 'on' : 'off';
                        $post['cust_darklayout'] = $cust_darklayout;
                    }
                    $settings = Utility::settings();
                    unset($post['_token'], $post['color'], $post['light_logo'], $post['dark_logo'], $post['company_favicon'], $post['header_text'], $post['footer_text']);

                    foreach ($post as $key => $data) {
                        if (in_array($key, array_keys($settings))) {

                            $setting = Settings::updateOrCreate(
                                ['name' => $key, 'created_by' => $objUser->id],
                                ['name' => $key, 'value' => $data, 'created_by' => $objUser->id]
                            )->get();

                        }
                    }
                }

                $post = $request->all();
                $post['SITE_RTL'] = (!empty($request->SITE_RTL) && $request->SITE_RTL == 'on') ? $request->SITE_RTL : 'off';

                unset($post['header_text'], $post['footer_text']);

                if ($request->SITE_RTL != NULL) {
                    $SITE_RTL = $request->has('SITE_RTL') ? $request->SITE_RTL : 'off';
                    $post['SITE_RTL'] = $SITE_RTL;
                }
                foreach ($post as $key => $data) {
                    if (in_array($key, array_keys($settings))) {

                        $setting = Settings::updateOrCreate(
                            ['name' => $key, 'created_by' => Auth::user()->id],
                            ['name' => $key, 'value' => $data, 'created_by' => Auth::user()->id]
                        )->get();

                    }
                }
            }
            return redirect()->back()->with('success', __('Settings Save Successfully.!'));
        } else {
            return redirect()->route('dashboard')->with('error', __("You can't access Location settings!"));
        }
    }

    public function SystemsettingsStore(Request $request){
        $post = $request->all();
        $settings = Utility::settings();
        unset($post['_token']);

        foreach ($post as $key => $data) {

                $setting = Settings::updateOrCreate(
                    ['name' => $key, 'created_by' => Auth::user()->id],
                    ['name' => $key, 'value' => $data, 'created_by' => Auth::user()->id]
                );
            
        }

        return redirect()->back()->with('success', __('Settings Save Successfully.!'));
    }



    public function emailSettingStore(Request $request)
    {
        $user = Auth::user();
       
        $locations =  Settings::where('created_by', $user->id)->pluck('value', 'name')->toArray();
        if ($user->user_type == 'company') {
            $post = $request->all();
            
            unset($post['_token']);
            
            foreach ($post as $key => $data) {

                    $company_email_setting = Settings::updateOrCreate(
                        ['name' => $key , 'created_by' => Auth::user()->id],
                        ['name' => $key, 'value' => $data, 'created_by' => Auth::user()->id]
                    );
                }
            return redirect()->back()->with('success', __('Email Settings Save Successfully'));
        } else {
            return redirect()->back()->with('error', __('Something is wrong'));
        }
    }
    public function testmail(Request $request)
    {

        $user = Auth::user();

        if ($user->user_type == 'company') {
            $data                      = [];
            $data['mail_driver']       = $request->mail_driver;
            $data['mail_host']         = $request->mail_host;
            $data['mail_port']         = $request->mail_port;
            $data['mail_username']     = $request->mail_username;
            $data['mail_password']     = $request->mail_password;
            $data['mail_encryption']   = $request->mail_encryption;
            $data['mail_from_address'] = $request->mail_from_address;
            $data['mail_from_name']    = $request->mail_from_name;

            return view('admin.user.test_email', compact('data'));
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }
    public function testmailstore(Request $request)
    {


        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
            'mail_driver' => 'required',
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required',
            'mail_password' => 'required',
            'mail_from_address' => 'required',
            'mail_from_name' => 'required',
        ]);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        try {
            config([
                'mail.driver' => $request->mail_driver,
                'mail.host' => $request->mail_host,
                'mail.port' => $request->mail_port,
                'mail.encryption' => $request->mail_encryption,
                'mail.username' => $request->mail_username,
                'mail.password' => $request->mail_password,
                'mail.from.address' => $request->mail_from_address,
                'mail.from.name' => $request->mail_from_name,
            ]);
            Mail::to($request->email)->send(new EmailTest());
        } catch (\Exception $e) {
            return response()->json([
                'is_success' => false,
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'is_success' => true,
            'message' => __('Email send Successfully'),
        ]);
    }
    public function saveSlackSettings(Request $request)
    {
        $post = $request->all();
        $settings = Utility::settings();
        unset($post['_token']);

        foreach ($post as $key => $data) {

                $setting = Settings::updateOrCreate(
                    ['name' => $key, 'created_by' => Auth::user()->id],
                    ['name' => $key, 'value' => $data, 'created_by' => Auth::user()->id]
                );
            
        }

        return redirect()->back()->with('success', __('Settings Save Successfully.!'));
    }

    public function savereportSettings(Request $request)
    {
        if($request->has('email_notifiation') || $request->has('slack_notifiation'))
        {
            $user= Auth::user();
            $check=ReportSetting::where('created_by',$user->id)->first();
            if($check)
            {
                $store=ReportSetting::where('created_by',$user->id)->first();
            }
            else
            {
                 $store=new ReportSetting();
            }
           
            $store->email_notification =$request->has('email_notifiation') ? 1 : 0;
            $store->slack_notification =$request->has('slack_notifiation') ? 1 : 0;
            $store->is_daily =$request->has('is_daily') ? 1 : 0;
            $store->is_weekly =$request->has('is_weekly') ? 1 : 0;
            $store->is_monthly =$request->has('is_monthly') ? 1 : 0;
            $store->created_by =$user->id;
            $store->save();
            return redirect()->back()->with('success', __('Settings Save Successfully.!'));
        }
        else
        {
            return redirect()->back()->with('error', "Something went wrong");
        }
        
    }

    public function saveSEOSettings(Request $request)
    {
            $validator = \Validator::make(
                $request->all(),
                [
                    'meta_keywords' => 'required',
                    'meta_description' => 'required',
                    // 'meta_image' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
        if (!empty($request->meta_image))
        {
            if($request->meta_image)
            {
                $path = storage_path('uploads/metaevent/' . Utility::settings()['meta_image']);
                if (!empty($path)) {
                    if(file_exists($path))
                    {
                        \File::delete($path);
                    }
                }
            }
            $img_name = time() . '_' . 'meta_image.png';
            $dir = 'uploads/metaevent';
            $validation = [
                'max:' . '20480',
            ];
            $path = Utility::upload_file($request, 'meta_image', $img_name, $dir, $validation);
            // dd($path);
            if ($path['flag'] == 1) {
                $logo_dark = $path['url'];
            } else {
                return redirect()->back()->with('error', __($path['msg']));
            }
            $post['meta_image']  = $img_name;
        }
        $post['meta_keywords']            = $request->meta_keywords;
        $post['meta_description']            = $request->meta_description;
        foreach ($post as $key => $data) {
           $arr = [
                $data,
                $key,
                \Auth::user()->id,
            ];
            \DB::insert(
                'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', $arr
            );
        }
        return redirect()->back()->with('success', __('SEO setting successfully updated.'));
    }

    
   public function CookieConsent(Request $request)
    {

        $settings= Utility::cookies();
        
        if($settings['enable_cookie'] == "on" && $settings['cookie_logging'] == "on"){
            $allowed_levels = ['necessary', 'analytics', 'targeting'];
            $levels = array_filter($request['cookie'], function($level) use ($allowed_levels) {
                return in_array($level, $allowed_levels);
            });
            $whichbrowser = new \WhichBrowser\Parser($_SERVER['HTTP_USER_AGENT']);
            // Generate new CSV line
            $browser_name = $whichbrowser->browser->name ?? null;
            $os_name = $whichbrowser->os->name ?? null;
            $browser_language = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? mb_substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : null;
            $device_type = Utility::get_device_type($_SERVER['HTTP_USER_AGENT']);

            //$ip = $_SERVER['REMOTE_ADDR'];
            $ip = '49.36.83.154';
            $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));


            $date = (new \DateTime())->format('Y-m-d');
            $time = (new \DateTime())->format('H:i:s') . ' UTC';


            $new_line = implode(',', [$ip, $date, $time,json_encode($request['cookie']), $device_type, $browser_language, $browser_name, $os_name,
                isset($query)?$query['country']:'',isset($query)?$query['region']:'',isset($query)?$query['regionName']:'',isset($query)?$query['city']:'',isset($query)?$query['zip']:'',isset($query)?$query['lat']:'',isset($query)?$query['lon']:'']);

            if(!file_exists(storage_path(). '/uploads/sample/data.csv')) {

                $first_line = 'IP,Date,Time,Accepted cookies,Device type,Browser language,Browser name,OS Name,Country,Region,RegionName,City,Zipcode,Lat,Lon';
                file_put_contents(storage_path() . '/uploads/sample/data.csv', $first_line . PHP_EOL , FILE_APPEND | LOCK_EX);
            }
            file_put_contents(storage_path() . '/uploads/sample/data.csv', $new_line . PHP_EOL , FILE_APPEND | LOCK_EX);

            return response()->json('success');
        }
        return response()->json('error');
    }
    

    public function saveCookieSettings(Request $request)
    {
        

            $validator = \Validator::make(
                $request->all(), [
                    'cookie_title' => 'required',
                    'cookie_description' => 'required',
                    'strictly_cookie_title' => 'required',
                    'strictly_cookie_description' => 'required',
                    'more_information_description' => 'required',
                    'contactus_url' => 'required',
                ]
            );

            $post = $request->all();

            unset($post['_token']);

            if ($request->enable_cookie)
            {
                $post['enable_cookie'] = 'on';
            }
            else{
                $post['enable_cookie'] = 'off';
            }
            if ( $request->cookie_logging )
            {
                $post['cookie_logging'] = 'on';
            }
            else{
                $post['cookie_logging'] = 'off';
            }
            
            if($post['enable_cookie']=="on")
            {
                $post['cookie_title']            = $request->cookie_title;
                $post['cookie_description']            = $request->cookie_description;
                $post['strictly_cookie_title']            = $request->strictly_cookie_title;
                $post['strictly_cookie_description']            = $request->strictly_cookie_description;
                $post['more_information_description']            = $request->more_information_description;
                $post['contactus_url']            = $request->contactus_url;

            }
           
            $settings = Utility::cookies();
            foreach ($post as $key => $data) {

                if (in_array($key, array_keys($settings))) {
                    $setting = Settings::updateOrCreate(
                            ['name' => $key],
                            ['name' => $key, 'value' => $data, 'created_by' => \Auth::user()->id]
                        )->get();
                }
            }
            return redirect()->back()->with('success', __('Cookie setting successfully saved.'));
    }
}
