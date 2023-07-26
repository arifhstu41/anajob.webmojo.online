<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;
use Artisan;
use Jenssegers\Date\Date;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommonEmailTemplate;
use Spatie\GoogleCalendar\Event;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;

class Utility extends Model
{
    use HasFactory;

    public static function addNewData()
    {

        Artisan::call('cache:forget spatie.permission.cache');
        Artisan::call('cache:clear');
        $usr            = Auth::user();
        $arrPermissions = [
            'manage company dashboard',
            'manage user',
            'create user',
            'edit user',
            'delete user',
            'manage site',
            'create site',
            'edit site',
            'manage widget',
            'create widget',
            'edit widget',
            'manage role',
            'create role',
            'edit role',
            'delete role',
            'manage permission',
            'create permission',
            'edit permission',
            'delete permission',
            'manage company settings',
            'show quick view',
            'show analytic',
            'show channel analytic',
            'show audience analytic',
            'show pages analytic',
            'show seo analytic',
            'show custom analytic',
            'manage dashboard',
            'manage share report',
            'manage share report settings'
        ];

        $companyRole        = Role::where('name', 'LIKE', 'company')->first();
        $companyPermissions = $companyRole->getPermissionNames()->toArray();

        foreach ($arrPermissions as $ap) {
            // check if permission is not created then create it.
            $permission = Permission::where('name', 'LIKE', $ap)->first();
            if (empty($permission)) {
                Permission::create(['name' => $ap]);
            }

            // check if permission is not assign to company then assign.
            if (!in_array($ap, $companyPermissions)) {
                $permission = Permission::findByName($ap);
                $companyRole->givePermissionTo($permission);
            }
        }
    }

    public static function get_device_type($user_agent) {
        $mobile_regex = '/(?:phone|windows\s+phone|ipod|blackberry|(?:android|bb\d+|meego|silk|googlebot) .+? mobile|palm|windows\s+ce|opera mini|avantgo|mobilesafari|docomo)/i';
        $tablet_regex = '/(?:ipad|playbook|(?:android|bb\d+|meego|silk)(?! .+? mobile))/i';

        if(preg_match_all($mobile_regex, $user_agent)) {
            return 'mobile';
        } else {

            if(preg_match_all($tablet_regex, $user_agent)) {
                return 'tablet';
            } else {
                return 'desktop';
            }

        }
    }
    public function createSlug($table, $title, $id = 0)
    {
        // Normalize the title
        $slug = Str::slug($title, '-');
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($table, $slug, $id);
        // If we haven't used it before then we are all good.
        if (!$allSlugs->contains('slug', $slug)) {
            return $slug;
        }
        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 100; $i++) {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }
        throw new \Exception(__('Can not create a unique slug'));
    }

    protected function getRelatedSlugs($table, $slug, $id = 0)
    {
        return DB::table($table)->select()->where('slug', 'like', $slug . '%')->where('id', '<>', $id)->get();
    }

    public static function getLocationBySlug($slug)
    {
        $objUser = Auth::user();

        if ($objUser && $objUser->current_location) {

            $rs = location::where(['id' => $objUser->current_location])->first();
        } elseif ($objUser && !empty($slug)) {
            $loaction_id = [];
            if ($objUser->location_id != "" && $objUser->location_id != null) {
                $loaction_id = explode($objUser->location_id);
            }
            $rs = location::where('slug', '=', $slug)->whereIn('id', $loaction_id)->first();
        } elseif ($objUser) {
            $loaction_id = [];
            if ($objUser->location_id != "" && $objUser->location_id != null) {
                $loaction_id = explode($objUser->location_id);
            }

            $rs = location::whereIn('id', $loaction_id)->limit(1)->first();
        } else {
            $rs = location::where('slug', '=', $slug)->limit(1)->first();
        }
        if ($rs) {
            Utility::setLang($rs);

            return $rs;
        }
    }

    public static function setLang($location)
    {
        $dir = base_path() . '/resources/lang/' . $location->id . "/";
        if (is_dir($dir)) {
            $lang = $location->id . "/" . $location->lang;
        } else {
            $lang = $location->lang;
        }

        Date::setLocale(basename($lang));
        \App::setLocale($lang);
    }

  
    public static function cookies()
    {
        $data = DB::table('settings');

        if (\Auth::check()) {
            $userId = \Auth::user();
            if($userId->user_type !="super admin")
            {
                $data = $data->where('created_by', '=', $userId->id)->where('name',"!=",'comapny_access_token')->where('name',"!=",'comapny_refresh_token');
            }
            else
            {
                $data = $data->where('created_by', '=', 1);
            }
            
        }
        else
        {
            $data = DB::table('settings')->where('created_by', '=', 1);
        }
        $data = $data->get();
        if(count($data)<=0)
        {
            $data = DB::table('settings')->where('created_by', '=', 1)->get();
        }
        $cookies = [
            
            'enable_cookie'=>'on',
            'necessary_cookies'=>'on',
            'cookie_logging'=>'on',
            'cookie_title'=>'We use cookies!',
            'cookie_description'=>'Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it',
            'strictly_cookie_title'=>'Strictly necessary cookies',
            'strictly_cookie_description'=>'These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly',
            'more_information_description'=>'For any queries in relation to our policy on cookies and your choices, please contact us',
            
            'contactus_url'=>'#',
        ];
        foreach ($data as $key => $row) {
            if (array_key_exists($row->name,$cookies))
            {
                $cookies[$row->name] = $row->value;
            }
        }
       
        return $cookies;
    }
    public static function settings()
    {
        $data = DB::table('settings');

        if (\Auth::check()) {
            $userId = \Auth::user();
            if($userId->user_type !="super admin")
            {
                $data = $data->where('created_by', '=', $userId->id);
            }
            else
            {
                $data = $data->where('created_by', '=', 1);
            }
        }
        
        $data = $data->get();
        if(count($data)<=0)
        {
            $data = DB::table('settings')->where('created_by', '=', 1)->get();
        }
        $settings = [
            "footer_text" => "Copyright © AnalyticsGo  2023",
            "display_landing" => "on",
            "default_language" => "en",
            "SIGNUP" => 'on',
            "color" => '',
            "cust_theme_bg" => "",
            "cust_darklayout" => 'off',
            "header_text" => 'AnalyticsGo ',
            "favicon" => 'favicon.png',
            "comapny_favicon"=>'favicon.png',
            "logo_light" => 'logo-light.png',
            "SITE_RTL" => "off",
            "storage_setting" => "local",
            "local_storage_validation" => "jpg,png,jpeg",
            "local_storage_max_upload_size" => "2048000",
            "s3_key" => "",
            "s3_secret" => "",
            "s3_region" => "",
            "s3_bucket" => "",
            "s3_url"    => "",
            "s3_endpoint" => "",
            "s3_max_upload_size" => "",
            "s3_storage_validation" => "",
            "wasabi_key" => "",
            "wasabi_secret" => "",
            "wasabi_region" => "",
            "wasabi_bucket" => "",
            "wasabi_url" => "",
            "wasabi_root" => "",
            "wasabi_max_upload_size" => "",
            "wasabi_storage_validation" => "",
            "barcode_type" => "code128",
            "barcode_format" =>"css",
            "google_calender_json_file"=>"",
            "google_calender_id"=>"",
            "google_calender_folder"=>"",
            "site_currency"=>"USD",
            "is_enabled"=>"",
            "meta_keywords"=>"AnalyticsGo",
            "meta_description"=>"AnalyticsGo is a tool for Google analytics for managing multiple websites on a single platform. To identify trends and patterns in how visitors interact with the websites, data from various matrices are collected and used to create the reports. Charts are used to present the overview and visual presentation.",
            "meta_image"=>'meta-image.png',
            'disable_lang'=>''

            
        ];

        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }
       
        return $settings;
    }



    public static function getValByName($key)
    {

        $setting = self::settings();
        if (!array_key_exists($key,$setting) || empty($setting[$key])) {
            $setting[$key] = '';
        }
        
        return $setting[$key];
    }


    public static function getSettingValByName($key)
    {
        $setting = self::settings();

        if (!isset($setting[$key]) || empty($setting[$key])) {
            $setting[$key] = 'yes';
        }

        return $setting[$key];
    }



    public static function languages()
    {

        $languages = Utility::langList();

        if(\Schema::hasTable('languages')){
            $settings = Utility::langSetting();
            if(!empty($settings['disable_lang'])){
                $disabledlang =explode(',', $settings['disable_lang']);
                $languages = Language::whereNotIn('code',$disabledlang)->pluck('fullName','code');
            }
            else{
                $languages = Language::pluck('fullName','code');
            }
        }

        return $languages;
    }

    public function changeLangWorkspace($workspaceID, $lang)
    {

        $workspace       = Workspace::find($workspaceID);
        $workspace->lang = $lang;
        $workspace->save();

        return redirect()->back()->with('success', __('Workspace Language Change Successfully!'));
    }

    public static function getFirstSeventhWeekDay($week = null)
    {
        $first_day = $seventh_day = null;

        if (isset($week)) {
            $first_day   = Carbon::now()->addWeeks($week)->startOfWeek();
            $seventh_day = Carbon::now()->addWeeks($week)->endOfWeek();
        }

        $dateCollection['first_day']   = $first_day;
        $dateCollection['seventh_day'] = $seventh_day;

        $period = CarbonPeriod::create($first_day, $seventh_day);

        foreach ($period as $key => $dateobj) {
            $dateCollection['datePeriod'][$key] = $dateobj;
        }

        return $dateCollection;
    }

   


    public static function dateFormat($date)
    {
        $lang = \App::getLocale();
        \App::setLocale(basename($lang));
        $date = Date::parse($date)->format('d M Y');

        return $date;
    }
    public static function getDateFormated($date, $time = false)
    {
        if (!empty($date) && $date != '0000-00-00') {
            if ($time == true) {
                return date("d M Y H:i A", strtotime($date));
            } else {
                return date("d M Y", strtotime($date));
            }
        } else {
            return '';
        }
    }


    // public static function SettingDateFormat()
    // {
    //     $date=LocationSetting::
    //     return 0;
    // }

    public static function delete_directory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (!self::delete_directory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($dir);
    }



    public static function colorset()
    {

        if (\Auth::user()) {
            if (\Auth::user()->user_type == 'super admin') {
                $user = \Auth::user();
                $setting = DB::table('settings')->where('created_by', \Auth::user()->id)->pluck('value', 'name')->toArray();
            } else {
                $setting = DB::table('settings')->where('created_by', \Auth::user()->id)->pluck('value', 'name')->toArray();
            }
        } else {
            $setting = Utility::settings();
        }
        if (!isset($setting['color'])) {
            $setting = Utility::settings();
        }

        return $setting;

        $is_dark_mode = $setting['cust_darklayout'];

        if ($is_dark_mode == 'on') {
            return 'logo-light.png';
        } else {
            return 'logo-dark.png';
        }
    }


    public static function get_superadmin_logo()
    {
        $setting = DB::table('settings')->where('created_by', 1)->pluck('value', 'name')->toArray();


        if (!empty($setting['cust_darklayout'])) {
            $is_dark_mode = $setting['cust_darklayout'];
            if ($is_dark_mode == 'on') {
                return 'logo-light.png';
            } else {
                return 'logo-dark.png';
            }
        } else {
            return 'logo-dark.png';
        }
    }


    public static function get_company_logo()
    {
        // $currentlocation = User::userCurrentLocation();
        $setting = DB::table('settings')->pluck('value', 'name')->toArray();

        if (!empty($setting['cust_darklayout'])) {
            $is_dark_mode = $setting['cust_darklayout'];
            if ($is_dark_mode == 'on') {
                return 'logo-light.png';
            } else {
                return 'logo-dark.png';
            }
        } else {
            return 'logo-dark.png';
        }
    }

    public static function mode_layout()
    {
        if (\Auth::check()) {

            // if(\Auth::user()->user_type == 'company')
            // {
            $setting = DB::table('settings')->where('created_by', Auth::user()->id)->pluck('value', 'name')->toArray();
            // }
            // else{
            
            //  }
        } else {
            $setting = DB::table('settings')->where('created_by', Auth::user()->id)->pluck('value', 'name')->toArray();
        }
        return $setting;

        $settings = [
            "cust_darklayout" => "off",
            "cust_theme_bg" => "off",
            "SITE_RTL" => "off",
        ];
        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }

    public static function setEnvironmentValue(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str     = file_get_contents($envFile);
        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                $keyPosition       = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine           = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}='{$envValue}'\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}='{$envValue}'", $str);
                }
            }
        }
        $str = substr($str, 0, -1);
        $str .= "\n";
        if (!file_put_contents($envFile, $str)) {
            return false;
        }

        return true;
    }

    public static function GetLogo()
    {
        $setting = Utility::colorset();
        if (\Auth::user() && \Auth::user()->type != 'super admin') {
            if (self::get_cookie_var('dark_mode') == 'on') {

                return Utility::getValByName('logo_light');
            } else {
                return Utility::getValByName('logo_dark');
            }
        } else {
            if (self::get_cookie_var('dark_mode') == 'on') {
                return Utility::getValByName('logo_light');
            } else {
                return Utility::getValByName('logo');
            }
        }
    }

    // Email Template Modules Function START
    // Common Function That used to send mail with check all cases
    public static function sendEmailTemplate($emailTemplate, $mailTo, $obj)
    {
        $usr = \Auth::user();

        //Remove Current Login user Email don't send mail to them
        unset($mailTo[$usr->id]);

        $mailTo = array_values($mailTo);

        if ($usr->user_type != 'super admin') {
            // find template is exist or not in our record
            $template = EmailTemplate::where('slug', $emailTemplate)->first();
            if (isset($template) && !empty($template)) {
                // check template is active or not by company
                $is_active = UserEmailTemplate::where('template_id', '=', $template->id)->where('user_id', '=', $usr->creatorId())->first();

                if ($is_active->is_active == 1) {
                    if ($usr->user_type == 'super admin') {

                        $settings = self::settings();
                    } else {
                        $settings = self::LocationSetting();
                    }

                    // dd($settings);
                    // get email content language base
                    $content = EmailTemplateLang::where('parent_id', '=', $template->id)->where('lang', 'LIKE', $usr->lang)->first();
                    //    dd($content);
                    $content->from = $template->from;

                    if (!empty($content->content)) {
                        $content->content = self::replaceVariable($content->content, $obj);
                        // send email
                        try {
                            Mail::to($mailTo)->send(new CommonEmailTemplate($content, $settings));
                        } catch (\Exception $e) {

                            $error = __('E-Mail has been not sent due to SMTP configuration');
                        }

                        if (isset($error)) {
                            $arReturn = [
                                'is_success' => false,
                                'error' => $error,
                            ];
                        } else {
                            $arReturn = [
                                'is_success' => true,
                                'error' => false,
                            ];
                        }
                    } else {
                        $arReturn = [
                            'is_success' => false,
                            'error' => __('Mail not send, email is empty'),
                        ];
                    }

                    return $arReturn;
                } else {
                    return [
                        'is_success' => true,
                        'error' => false,
                    ];
                }
            } else {
                return [
                    'is_success' => false,
                    'error' => __('Mail not send, email not found'),
                ];
            }
        }
    }


    // used for replace email variable (parameter 'template_name','id(get particular record by id for data)')
    public static function replaceVariable($content, $obj)
    {
        $arrVariable = [
            '{app_name}',
            '{company_email_from_name}',
            '{app_url}',
            '{email}',
            '{password}',
            '{work_request_name}',
            '{problem}',
            '{work_order_id}',
            '{Assets}',
            '{priority}',
            '{work_order_due_date}',
            '{name}',
            '{contact}',
            '{vendor}',
            '{items}',
            '{description}',
            '{quantity}',
            '{price}',
            '{purchase_order_date}',
            '{expected_delivery_date}',

        ];
        $arrValue    = [
            'app_name' => '-',
            'company_email_from_name' => '-',
            'app_url' => '-',
            'email' => '-',
            'password' => '-',
            'work_request_name' => '-',
            'problem' => '-',
            'work_order_id' => '-',
            'Assets' => '-',
            'priority' => '-',
            'work_order_due_date' => '-',
            'name' => '-',
            'contact' => '-',
            'vendor' => '-',
            'items' => '-',
            'description' => '-',
            'quantity' => '-',
            'price' => '-',
            'purchase_order_date' => '-',
            'expected_delivery_date' => '-',
        ];

        foreach ($obj as $key => $val) {
            $arrValue[$key] = $val;
        }

        $settings = Utility::settings();

        $company_name = !empty($settings['company_email_from_name']) ? $settings['company_email_from_name'] : '';

        $arrValue['app_name']     =  $company_name;
        $arrValue['company_email_from_name'] = self::settings()['company_email_from_name'];
        $arrValue['app_url']      = '<a href="' . env('APP_URL') . '" target="_blank">' . env('APP_URL') . '</a>';

        return str_replace($arrVariable, array_values($arrValue), $content);
    }

    // Make Entry in email_tempalte_lang table when create new language
    public static function makeEmailLang($lang)
    {
        $template = EmailTemplate::all();
        foreach ($template as $t) {
            $default_lang                 = EmailTemplateLang::where('parent_id', '=', $t->id)->where('lang', 'LIKE', 'en')->first();
            $emailTemplateLang            = new EmailTemplateLang();
            $emailTemplateLang->parent_id = $t->id;
            $emailTemplateLang->lang      = $lang;
            $emailTemplateLang->subject   = $default_lang->subject;
            $emailTemplateLang->content   = $default_lang->content;
            $emailTemplateLang->save();
        }
    }

    //    Storage-Setting

    public static function upload_file($request, $key_name, $name, $path, $custom_validation = [])
    {

        try {
            
            $settings = Utility::getStorageSetting();

            if (!empty($settings['storage_setting'])) {

       

                if ($settings['storage_setting'] == 'wasabi') {

                    config(
                        [
                            'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                            'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                            'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                            'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                            'filesystems.disks.wasabi.endpoint' => 'https://s3.' . $settings['wasabi_region'] . '.wasabisys.com'
                        ]
                    );

                    $max_size = !empty($settings['wasabi_max_upload_size']) ? $settings['wasabi_max_upload_size'] : '2048';
                    $mimes =  !empty($settings['wasabi_storage_validation']) ? $settings['wasabi_storage_validation'] : '';
                } 
                else if ($settings['storage_setting'] == 's3') {
                    config(
                        [
                            'filesystems.disks.s3.key' => $settings['s3_key'],
                            'filesystems.disks.s3.secret' => $settings['s3_secret'],
                            'filesystems.disks.s3.region' => $settings['s3_region'],
                            'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                            'filesystems.disks.s3.use_path_style_endpoint' => false,
                        ]
                    );
                    $max_size = !empty($settings['s3_max_upload_size']) ? $settings['s3_max_upload_size'] : '2048';
                    $mimes =  !empty($settings['s3_storage_validation']) ? $settings['s3_storage_validation'] : '';
                } 

                else {
            

                    $max_size = !empty($settings['local_storage_max_upload_size']) ? $settings['local_storage_max_upload_size'] : '2048';

                    $mimes =  !empty($settings['local_storage_validation']) ? $settings['local_storage_validation'] : '';
                }

                $file = $key_name;
                // dd( $file);

                if (count($custom_validation) > 0) {
                    $validation = $custom_validation;
                } else {

                    $validation = [
                        'mimes:' . $mimes,
                        'max:' . $max_size,
                    ];
                }


                $validator = \Validator::make($request->all(), [
                    $key_name => $validation
                ]);


                if ($validator->fails()) {
                    $res = [
                        'flag' => 0,
                        'msg' => $validator->messages()->first(),
                    ];
                    return $res;
                } else {

                    $name = $name;

                    if ($settings['storage_setting'] == 'local') {

                        // \Storage::disk()->putFileAs(
                        //     $path,
                        //     $request->file($key_name),
                        //     $name
                        // );
                        $request->$key_name->move(storage_path($path), $name);
                        $directory = storage_path($path);
                        $file = $directory . $name;
                       // chmod($file, 0777);
                        $path = $path . $name;

                    } else if ($settings['storage_setting'] == 'wasabi') {

                        $path = \Storage::disk('wasabi')->putFileAs(
                            $path,
                            $file,
                            $name
                        );

                        // $path = $path.$name;

                    } else if ($settings['storage_setting'] == 's3') {

                        $path = \Storage::disk('s3')->putFileAs(
                            $path,
                            $file,
                            $name
                        );
                        // $path = $path.$name;
                        // dd($path);
                    }


                    $res = [
                        'flag' => 1,
                        'msg'  => 'success',
                        'url'  => $path
                    ];

                    return $res;
                }
            } else {
                $res = [
                    'flag' => 0,
                    'msg' => __('Please set proper configuration for storage.'),
                ];
                return $res;
            }
        } catch (\Exception $e) {
            $res = [
                'flag' => 0,
                'msg' => $e->getMessage(),
            ];
            return $res;
        }
    }


    public static function get_file($path)
    {

        $settings = Utility::getStorageSetting();

        try {
            if ($settings['storage_setting'] == 'wasabi') {
                config(
                    [
                        'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                        'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                        'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                        'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                        'filesystems.disks.wasabi.endpoint' => 'https://s3.' . $settings['wasabi_region'] . '.wasabisys.com'
                    ]
                );
            } elseif ($settings['storage_setting'] == 's3') {
                config(
                    [
                        'filesystems.disks.s3.key' => $settings['s3_key'],
                        'filesystems.disks.s3.secret' => $settings['s3_secret'],
                        'filesystems.disks.s3.region' => $settings['s3_region'],
                        'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                        'filesystems.disks.s3.use_path_style_endpoint' => false,
                    ]
                );
            }
           
            return Storage::disk($settings['storage_setting'])->url($path);
        } catch (\Throwable $th) {
          
            return '';
        }
    }

    public static function getStorageSetting()
    {

        $data = DB::table('settings');
        $data = $data->where('created_by', '=', 1);
        $data     = $data->get();
        $settings = [
            "storage_setting" => "",
            "local_storage_validation" => "",
            "local_storage_max_upload_size" => "",
            "s3_key" => "",
            "s3_secret" => "",
            "s3_region" => "",
            "s3_bucket" => "",
            "s3_url"    => "",
            "s3_endpoint" => "",
            "s3_max_upload_size" => "",
            "s3_storage_validation" => "",
            "wasabi_key" => "",
            "wasabi_secret" => "",
            "wasabi_region" => "",
            "wasabi_bucket" => "",
            "wasabi_url" => "",
            "wasabi_root" => "",
            "wasabi_max_upload_size" => "",
            "wasabi_storage_validation" => "",
        ];

        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }

    public static function getPaymentIsOn()
    {
        $payments = self::getAdminPaymentSetting();
        if (isset($payments['is_stripe_enabled']) && $payments['is_stripe_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_paypal_enabled']) && $payments['is_paypal_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_flutterwave_enabled']) && $payments['is_flutterwave_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_razorpay_enabled']) && $payments['is_razorpay_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_mercado_enabled']) && $payments['is_mercado_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_paytm_enabled']) && $payments['is_paytm_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_mollie_enabled']) && $payments['is_mollie_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_skrill_enabled']) && $payments['is_skrill_enabled'] == 'on') {
            return true;
        } elseif (isset($payments['is_coingate_enabled']) && $payments['is_coingate_enabled'] == 'on') {
            return true;
        } else {
            return false;
        }
    }

    public static function keyWiseUpload_file($request, $key_name, $name, $path, $data_key, $custom_validation = [])
    {

        $multifile = [
            $key_name => $request->file($key_name)[$data_key],
        ];

        try {
            $settings = Utility::getStorageSetting();


            if (!empty($settings['storage_setting'])) {

                if ($settings['storage_setting'] == 'wasabi') {

                    config(
                        [
                            'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                            'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                            'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                            'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                            'filesystems.disks.wasabi.endpoint' => 'https://s3.' . $settings['wasabi_region'] . '.wasabisys.com'
                        ]
                    );

                    $max_size = !empty($settings['wasabi_max_upload_size']) ? $settings['wasabi_max_upload_size'] : '2048';
                    $mimes =  !empty($settings['wasabi_storage_validation']) ? $settings['wasabi_storage_validation'] : '';
                } else if ($settings['storage_setting'] == 's3') {
                    config(
                        [
                            'filesystems.disks.s3.key' => $settings['s3_key'],
                            'filesystems.disks.s3.secret' => $settings['s3_secret'],
                            'filesystems.disks.s3.region' => $settings['s3_region'],
                            'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                            'filesystems.disks.s3.use_path_style_endpoint' => false,
                        ]
                    );
                    $max_size = !empty($settings['s3_max_upload_size']) ? $settings['s3_max_upload_size'] : '2048';
                    $mimes =  !empty($settings['s3_storage_validation']) ? $settings['s3_storage_validation'] : '';
                } else {
                    $max_size = !empty($settings['local_storage_max_upload_size']) ? $settings['local_storage_max_upload_size'] : '2048';

                    $mimes =  !empty($settings['local_storage_validation']) ? $settings['local_storage_validation'] : '';
                }


                $file = $request->$key_name;


                if (count($custom_validation) > 0) {
                    $validation = $custom_validation;
                } else {

                    $validation = [
                        'mimes:' . $mimes,
                        'max:' . $max_size,
                    ];
                }

                $validator = \Validator::make($multifile, [
                    $key_name => $validation
                ]);


                if ($validator->fails()) {
                    $res = [
                        'flag' => 0,
                        'msg' => $validator->messages()->first(),
                    ];
                    return $res;
                } else {

                    $name = $name;

                    if ($settings['storage_setting'] == 'local') {

                        \Storage::disk()->putFileAs(
                            $path,
                            $request->file($key_name)[$data_key],
                            $name
                        );


                        $path = $name;
                    } else if ($settings['storage_setting'] == 'wasabi') {

                        $path = \Storage::disk('wasabi')->putFileAs(
                            $path,
                            $file,
                            $name
                        );

                        // $path = $path.$name;

                    } else if ($settings['storage_setting'] == 's3') {

                        $path = \Storage::disk('s3')->putFileAs(
                            $path,
                            $file,
                            $name
                        );
                    }


                    $res = [
                        'flag' => 1,
                        'msg'  => 'success',
                        'url'  => $path
                    ];
                    return $res;
                }
            } else {
                $res = [
                    'flag' => 0,
                    'msg' => __('Please set proper configuration for storage.'),
                ];
                return $res;
            }
        } catch (\Exception $e) {
            $res = [
                'flag' => 0,
                'msg' => $e->getMessage(),
            ];
            return $res;
        }
    }


    public static function formBuilderFileUpload($request, $key_name, $name, $path, $custom_validation = [])
    {

        try {

            $settings = Utility::getStorageSetting();

            if (!empty($settings['storage_setting'])) {

                if ($settings['storage_setting'] == 'wasabi') {

                    config(
                        [
                            'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                            'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                            'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                            'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                            'filesystems.disks.wasabi.endpoint' => 'https://s3.' . $settings['wasabi_region'] . '.wasabisys.com'
                        ]
                    );

                    $max_size = !empty($settings['wasabi_max_upload_size']) ? $settings['wasabi_max_upload_size'] : '2048';
                    $mimes =  !empty($settings['wasabi_storage_validation']) ? $settings['wasabi_storage_validation'] : '';
                } else if ($settings['storage_setting'] == 's3') {
                    config(
                        [
                            'filesystems.disks.s3.key' => $settings['s3_key'],
                            'filesystems.disks.s3.secret' => $settings['s3_secret'],
                            'filesystems.disks.s3.region' => $settings['s3_region'],
                            'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                            'filesystems.disks.s3.use_path_style_endpoint' => false,
                        ]
                    );
                    $max_size = !empty($settings['s3_max_upload_size']) ? $settings['s3_max_upload_size'] : '2048';
                    $mimes =  !empty($settings['s3_storage_validation']) ? $settings['s3_storage_validation'] : '';
                } else {
                    $max_size = !empty($settings['local_storage_max_upload_size']) ? $settings['local_storage_max_upload_size'] : '2048';

                    $mimes =  !empty($settings['local_storage_validation']) ? $settings['local_storage_validation'] : '';
                }


                $file = $request->$key_name;
                // dd( $file);

                if (count($custom_validation) > 0) {
                    $validation = $custom_validation;
                } else {

                    $validation = [
                        'mimes:' . $mimes,
                        'max:' . $max_size,
                    ];
                }


                $validator = \Validator::make($request->all(), [
                    $key_name => $validation
                ]);


                if ($validator->fails()) {
                    $res = [
                        'flag' => 0,
                        'msg' => $validator->messages()->first(),
                    ];
                    return $res;
                } else {

                    $name = $name;

                    if ($settings['storage_setting'] == 'local') {

                        // \Storage::disk()->putFileAs(
                        //     $path,
                        //     $request->file($key_name),
                        //     $name
                        // );
                        $request->$key_name->move(storage_path($path), $name);
                        $path = $path . $name;
                    } else if ($settings['storage_setting'] == 'wasabi') {

                        $path = \Storage::disk('wasabi')->putFileAs(
                            $path,
                            $file,
                            $name
                        );

                        // $path = $path.$name;

                    } else if ($settings['storage_setting'] == 's3') {

                        $path = \Storage::disk('s3')->putFileAs(
                            $path,
                            $file,
                            $name
                        );
                        // $path = $path.$name;
                        // dd($path);
                    }


                    $res = [
                        'flag' => 1,
                        'msg'  => 'success',
                        'url'  => $path
                    ];
                    return $res;
                }
            } else {
                $res = [
                    'flag' => 0,
                    'msg' => __('Please set proper configuration for storage.'),
                ];
                return $res;
            }
        } catch (\Exception $e) {
            $res = [
                'flag' => 0,
                'msg' => $e->getMessage(),
            ];
            return $res;
        }
    }

    public static function colorCodeData($type)
    {
        if($type == 'event')
        {
            return 1;
        }
        elseif ($type == 'zoom_meeting')
        {
            return 2;
        }
        elseif ($type == 'task')
        {
            return 3;
        }
        elseif ($type == 'appointment')
        {
            return 11;
        }
        elseif ($type == 'rotas')
        {
            return 3;
        }
        elseif ($type == 'holiday')
        {
            return 4;
        }
        elseif ($type == 'call')
        {
            return 10;
        }
        elseif ($type == 'meeting')
        {
            return 5;
        }
        elseif ($type == 'leave')
        {
            return 6;
        }
        elseif ($type == 'work_order')
        {
            return 7;
        }
        elseif ($type == 'lead')
        {
            return 7;
        }
        elseif ($type == 'deal')
        {
            return 8;
        }
        elseif ($type == 'interview_schedule')
        {
            return 9;
        }
        else{
            return 11;
        }

    }
        public static $colorCode =[
        1=>'event-warning',
        2=>'event-secondary',
        3=>'event-success',
        4=>'event-warning',
        5=>'event-danger',
        6=>'event-dark',
        7=>'event-black',
        8=>'event-info',
        9=>'event-secondary',
        10=>'event-success',
        11=>'event-warning',

    ];

    public static function googleCalendarConfig()
    {
        $setting = Utility::settings();
        $path = storage_path($setting['google_calender_json_file']);

        // dd($setting['google_calender_id']);

        config([
            'google-calendar.default_auth_profile' => 'service_account',
            'google-calendar.auth_profiles.service_account.credentials_json' => $path,
            'google-calendar.auth_profiles.oauth.credentials_json' => $path,
            'google-calendar.auth_profiles.oauth.token_json' => $path,
            'google-calendar.calendar_id' => isset($setting['google_calender_id'])?$setting['google_calender_id'] : '',
            'google-calendar.user_to_impersonate' => '',
        ]);

  
}

public static function CompanySetting()
    {

        if(Auth::user())
        {
            $company= Auth::User();
       
            return Settings::where('created_by', $company->id)->pluck('value', 'name')->toArray();
        }
        else
        {
            $company = User::where('user_type','company')->first();
            return Settings::where('created_by', $company->id)->pluck('value', 'name')->toArray();
        }
        
    }


    public static function addCalendarData($request , $type)
    {
        

        Self::googleCalendarConfig();

        $event = new Event();
        $event->name = $request->get('wo_name');
        $event->startDateTime = Carbon::parse($request->date);
        $event->endDateTime = Carbon::parse($request->date);
        $event->colorId = Self::colorCodeData($type);
        $event->save();
    }

    public static function getCalendarData($type)
    {
        Self::googleCalendarConfig();

        $data= Event::get();
        $type=Self::colorCodeData($type);
        $arrEvents = [];
        foreach($data as $val)
        {
            $end_date=date_create($val->endDateTime);
            date_add($end_date,date_interval_create_from_date_string("1 days"));

            if($val->colorId=="$type"){

                $arrEvents[] = [
                    "id"=> $val->id,
                    "title" => $val->summary,
                    "start" => $val->startDateTime,
                    "end" => date_format($end_date,"Y-m-d H:i:s"),
                    "className" => Self::$colorCode[$type],
                    "textColor"=>'#FFF',
                    "allDay" => true,
                ];
            }
        }
        return $arrEvents;
    }

    public static function languagecreate()
    {
        $languages=Utility::langList();

       foreach($languages as $key => $lang){
         $languageExist = Language::where('code',$key)->first();
         if(empty($languageExist)){
             $language = new Language();
             $language->code = $key;
             $language->fullName = $lang;
             $language->save();
         }
     
        }
    }

    public static function langSetting(){
        $data = DB::table('settings');
        $data = $data->where('created_by', '=', 1)->get();
        if (count($data) == 0) {
            $data = DB::table('settings')->where('created_by', '=', 1)->get();
        }
        $settings= [];
        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }
        return $settings;
    }
 
    public static function langList(){
        $languages = [
            "ar" => "Arabic",
            "zh" => "Chinese",
            "da" => "Danish",
            "de" => "German",
            "en" => "English",
            "es" => "Spanish",
            "fr" => "French",
            "he" => "Hebrew",
            "it" => "Italian",
            "ja" => "Japanese",
            "nl" => "Dutch",
            "pl" => "Polish",
            "pt" => "Portuguese",
            "pt-br"=>"Portuguese (Brazil)",
            "ru" => "Russian",
            "tr" => "Turkish",
            "vi" => "Vietnamese",
        ];
        return $languages;
    }

}
