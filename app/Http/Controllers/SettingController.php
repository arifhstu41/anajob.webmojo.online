<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Plan;
use App\Models\UserCoupon;
use App\Models\Utility;
use App\Models\Settings;
use App\Models\Site;
use App\Models\User;
use App\Models\PlanRequest;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        if (\Auth::user()->user_type == 'company' ) {
            $settings = Utility::settings();

            
            $setting_data = Settings::pluck('value', 'name')->toArray();


           

            return view('setting', compact('settings', 'setting_data' , 'file_size'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $post = $request->all();
        if ($user->user_type == 'company') {
            // if ($request->favicon) {
            //     $request->validate(['favicon' => 'required|image|mimes:png,jpg,jpeg|max:204800']);
            //     $request->favicon->storeAs('logo', 'favicon.png');
            // }
            if ($request->favicon) {
                $request->validate(
                    [
                        'favicon' => 'image',
                    ]
                );
                $validation = [
                    'mimes:' . 'png',
                    'max:' . '20480',
                ];
                $logoName = 'favicon.png';
                $dir = 'logo/';

                $path = Utility::upload_file($request, 'favicon', $logoName, $dir, []);
                if ($path['flag'] == 1) {
                    $favicon = $path['url'];
                } else {
                    return redirect()->back()->with('error', __($path['msg']));
                }
            }

            // if($request->dark_logo)
            // {
            //     $request->validate(['dark_logo' => 'required|image|mimes:jpeg,jpg,png|max:204800']);
            //     $request->dark_logo->storeAs('logo', 'logo-dark.png');
            // }

            if ($request->dark_logo) {
                // dd($request->dark_logo);
                $request->validate(
                    [
                        'dark_logo' => 'image|mimes:png|max:20480',
                    ]
                );
                $logoName = 'logo-dark.png';
                $dir = 'logo/';

                $validation = [
                    'mimes:' . 'png',
                    'max:' . '20480',
                ];

                $path = Utility::upload_file($request, 'dark_logo', $logoName, $dir, $validation);
                if ($path['flag'] == 1) {
                    $dark_logo = $path['url'];
                } else {
                    return redirect()->back()->with('error', __($path['msg']));
                }
            }
            // if($request->light_logo)
            // {

            //     $request->validate(['light_logo' => 'required|image|mimes:jpeg,jpg,png|max:204800']);
            //     $request->light_logo->storeAs('logo', 'logo-light.png');
            // }
            if ($request->light_logo) {
                $request->validate(
                    [
                        'light_logo' => 'image|mimes:png|max:20480',
                    ]
                );

                $validation = [
                    'mimes:' . 'png',
                    'max:' . '20480',
                ];

                $logoName = 'logo-light.png';
                $dir = 'logo/';


                $path = Utility::upload_file($request, 'light_logo', $logoName, $dir, $validation);
                if ($path['flag'] == 1) {
                    
                    $light_logo = $path['url'];
                } else {
                    return redirect()->back()->with('error', __($path['msg']));
                }
            }

            $rules = [
                // 'app_name' => 'required|string|max:50',
                'footer_text' => 'string|max:50',
            ];

            $request->validate($rules);
            $request->is_sidebar_transperent;

            if (
                !empty($request->header_text) || !empty($request->SITE_RTL) || !empty($request->footer_text)  
                ||  isset($request->display_landing) || !isset($request->color) || !empty($request->cust_theme_bg) ||
                !empty($request->cust_darklayout)
            ) {

                $post = $request->all();

                $post['cust_theme_bg'] = (!empty($request->cust_theme_bg) && $request->cust_theme_bg == 'on') ? $request->cust_theme_bg : 'on';
                $post['cust_darklayout'] = (!empty($request->cust_darklayout) && $request->cust_darklayout == 'on') ? $request->cust_darklayout : 'off';
                $post['color'] = (!empty($request->color) &&  $request->has('color')) ? $request->color : 'theme-3';
                $post['SITE_RTL'] = (!empty($request->SITE_RTL)) ? 'on' : 'off';

                if (!isset($request->SIGNUP)) {
                    $post['SIGNUP'] = 'off';
                }
                
                if (!isset($request->display_landing)) {

                    $post['display_landing'] = 'off';
                }
               

                if (!isset($request->color)) {
                    $color = $request->has('color') ? $request->color : 'theme-3';
                    $post['color'] = $color;
                }
                if (!isset($request->cust_theme_bg)) {
                    $cust_theme_bg         = (isset($request->cust_theme_bg)) ? 'on' : 'off';
                    $post['cust_theme_bg'] = $cust_theme_bg;
                }

                if (!isset($request->cust_darklayout)) {
                    $post['cust_darklayout'] = 'off';
                }
                $settings = Utility::settings();
                // dd($settings);
                unset($post['_token'], $post['favicon']);

                foreach ($post as $key => $data) {

                    if (in_array($key, array_keys($settings))) {
                        $setting = Settings::updateOrCreate(
                            ['name' => $key],
                            ['name' => $key, 'value' => $data, 'created_by' => \Auth::user()->id]
                        )->get();
                    }
                    // dd($setting);
                }
            }

            return redirect()->back()->with('success', __('Setting updated successfully'));
        } else {
            return redirect()->back()->with('error', __('Something is wrong'));
        }
    }


    public function emailSettingStore(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'company') {
            $rules = [
                'mail_driver' => 'required',
                'mail_host' => 'required',
                'mail_port' => 'required',
                'mail_username' => 'required',
                'mail_password' => 'required',
                'mail_encryption' => 'required',
                'mail_from_address' => 'required',
                'mail_from_name' => 'required',
            ];

            $arrEnv = [
                'MAIL_DRIVER' => $request->mail_driver,
                'MAIL_HOST' => $request->mail_host,
                'MAIL_PORT' => $request->mail_port,
                'MAIL_USERNAME' => $request->mail_username,
                'MAIL_PASSWORD' => $request->mail_password,
                'MAIL_ENCRYPTION' => $request->mail_encryption,
                'MAIL_FROM_ADDRESS' => $request->mail_from_address,
                'MAIL_FROM_NAME' => $request->mail_from_name,
            ];

            if ($this->setEnvironmentValue($arrEnv)) {
                return redirect()->back()->with('success', __('Setting updated successfully'));
            } else {
                return redirect()->back()->with('error', __('Something is wrong'));
            }
        } else {
            return redirect()->back()->with('error', __('Something is wrong'));
        }
    }


    public function savePaymentSettings(Request $request)
    {
        $user = \Auth::user();

        $validator = \Validator::make(
            $request->all(),
            [
                'currency' => 'required|string|max:255',
                'currency_symbol' => 'required|string|max:255',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        } else {

            if ($user->type == 'company') {
                $arrEnv['CURRENCY_SYMBOL'] = $request->currency_symbol;
                $arrEnv['CURRENCY'] = $request->currency;

                $env = Utility::setEnvironmentValue($arrEnv);
            }

            $post['currency_symbol'] = $request->currency_symbol;
            $post['currency'] = $request->currency;
        }

        if (isset($request->is_stripe_enabled) && $request->is_stripe_enabled == 'on') {
            $validator = \Validator::make(
                $request->all(),
                [
                    'stripe_key' => 'required|string',
                    'stripe_secret' => 'required|string',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $post['is_stripe_enabled']     = $request->is_stripe_enabled;
            $post['stripe_secret']         = $request->stripe_secret;
            $post['stripe_key']            = $request->stripe_key;
        } else {
            $post['is_stripe_enabled'] = 'off';
        }


        if (isset($request->is_paypal_enabled) && $request->is_paypal_enabled == 'on') {
            $validator = \Validator::make(
                $request->all(),
                [
                    'paypal_mode' => 'required|string',
                    'paypal_client_id' => 'required|string',
                    'paypal_secret_key' => 'required|string',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $post['is_paypal_enabled'] = $request->is_paypal_enabled;
            $post['paypal_mode']       = $request->paypal_mode;
            $post['paypal_client_id']  = $request->paypal_client_id;
            $post['paypal_secret_key'] = $request->paypal_secret_key;
        } else {
            $post['is_paypal_enabled'] = 'off';
        }

        if (isset($request->is_paystack_enabled) && $request->is_paystack_enabled == 'on') {

            $validator = \Validator::make(
                $request->all(),
                [
                    'paystack_public_key' => 'required|string',
                    'paystack_secret_key' => 'required|string',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $post['is_paystack_enabled'] = $request->is_paystack_enabled;
            $post['paystack_public_key'] = $request->paystack_public_key;
            $post['paystack_secret_key'] = $request->paystack_secret_key;
        } else {
            $post['is_paystack_enabled'] = 'off';
        }

        if (isset($request->is_flutterwave_enabled) && $request->is_flutterwave_enabled == 'on') {

            $validator = \Validator::make(
                $request->all(),
                [
                    'flutterwave_public_key' => 'required|string',
                    'flutterwave_secret_key' => 'required|string',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $post['is_flutterwave_enabled'] = $request->is_flutterwave_enabled;
            $post['flutterwave_public_key'] = $request->flutterwave_public_key;
            $post['flutterwave_secret_key'] = $request->flutterwave_secret_key;
        } else {
            $post['is_flutterwave_enabled'] = 'off';
        }

        if (isset($request->is_razorpay_enabled) && $request->is_razorpay_enabled == 'on') {

            $validator = \Validator::make(
                $request->all(),
                [
                    'razorpay_public_key' => 'required|string',
                    'razorpay_secret_key' => 'required|string',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $post['is_razorpay_enabled'] = $request->is_razorpay_enabled;
            $post['razorpay_public_key'] = $request->razorpay_public_key;
            $post['razorpay_secret_key'] = $request->razorpay_secret_key;
        } else {
            $post['is_razorpay_enabled'] = 'off';
        }

        if (isset($request->is_mercado_enabled) && $request->is_mercado_enabled == 'on') {
            $validator = \Validator::make(
                $request->all(),
                [
                    'mercado_access_token' => 'required|string',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $post['is_mercado_enabled'] = $request->is_mercado_enabled;
            $post['mercado_access_token']     = $request->mercado_access_token;
            $post['mercado_mode'] = $request->mercado_mode;
        } else {
            $post['is_mercado_enabled'] = 'off';
        }

        if (isset($request->is_paytm_enabled) && $request->is_paytm_enabled == 'on') {

            $validator = \Validator::make(
                $request->all(),
                [
                    'paytm_mode' => 'required',
                    'paytm_merchant_id' => 'required|string',
                    'paytm_merchant_key' => 'required|string',
                    'paytm_industry_type' => 'required|string',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $post['is_paytm_enabled']    = $request->is_paytm_enabled;
            $post['paytm_mode']          = $request->paytm_mode;
            $post['paytm_merchant_id']   = $request->paytm_merchant_id;
            $post['paytm_merchant_key']  = $request->paytm_merchant_key;
            $post['paytm_industry_type'] = $request->paytm_industry_type;
        } else {
            $post['is_paytm_enabled'] = 'off';
        }

        if (isset($request->is_mollie_enabled) && $request->is_mollie_enabled == 'on') {


            $validator = \Validator::make(
                $request->all(),
                [
                    'mollie_api_key' => 'required|string',
                    'mollie_profile_id' => 'required|string',
                    'mollie_partner_id' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $post['is_mollie_enabled'] = $request->is_mollie_enabled;
            $post['mollie_api_key']    = $request->mollie_api_key;
            $post['mollie_profile_id'] = $request->mollie_profile_id;
            $post['mollie_partner_id'] = $request->mollie_partner_id;
        } else {
            $post['is_mollie_enabled'] = 'off';
        }

        if (isset($request->is_skrill_enabled) && $request->is_skrill_enabled == 'on') {



            $validator = \Validator::make(
                $request->all(),
                [
                    'skrill_email' => 'required|email',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $post['is_skrill_enabled'] = $request->is_skrill_enabled;
            $post['skrill_email']      = $request->skrill_email;
        } else {
            $post['is_skrill_enabled'] = 'off';
        }

        if (isset($request->is_coingate_enabled) && $request->is_coingate_enabled == 'on') {


            $validator = \Validator::make(
                $request->all(),
                [
                    'coingate_mode' => 'required|string',
                    'coingate_auth_token' => 'required|string',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $post['is_coingate_enabled'] = $request->is_coingate_enabled;
            $post['coingate_mode']       = $request->coingate_mode;
            $post['coingate_auth_token'] = $request->coingate_auth_token;
        } else {
            $post['is_coingate_enabled'] = 'off';
        }
        foreach ($post as $key => $data) {
            $arr = [
                $data,
                $key,
                \Auth::user()->id,
            ];
            $insert_payment_setting = \DB::insert(
                'insert into admin_payment_settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                $arr
            );
        }

        return redirect()->back()->with('success', __('Settings updated successfully.'));
    }

    public function pusherSettingStore(Request $request)
    {
        $user = Auth::user();
        if ($user->user_type == 'company') {
            $rules = [];

            if ($request->enable_chat == 'yes') {
                $rules['pusher_app_id']      = 'required|string|max:50';
                $rules['pusher_app_key']     = 'required|string|max:50';
                $rules['pusher_app_secret']  = 'required|string|max:50';
                $rules['pusher_app_cluster'] = 'required|string|max:50';
            }

            $request->validate($rules);

            $arrEnv = [
                'CHAT_MODULE' => $request->enable_chat,
                'PUSHER_APP_ID' => $request->pusher_app_id,
                'PUSHER_APP_KEY' => $request->pusher_app_key,
                'PUSHER_APP_SECRET' => $request->pusher_app_secret,
                'PUSHER_APP_CLUSTER' => $request->pusher_app_cluster,
            ];

            if ($this->setEnvironmentValue($arrEnv)) {
                return redirect()->back()->with('success', __('Setting updated successfully'));
            } else {
                return redirect()->back()->with('error', __('Something is wrong'));
            }
        } else {
            return redirect()->back()->with('error', __('Something is wrong'));
        }
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

        return file_put_contents($envFile, $str) ? true : false;
    }

    public function testEmail(Request $request)
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

            return view('test_email', compact('data'));
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function testEmailSend(Request $request)
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

    public function storageSettingStore(Request $request)
    {

        if (isset($request->storage_setting) && $request->storage_setting == 'local') {

            $request->validate(
                [

                    'local_storage_validation' => 'required',
                    'local_storage_max_upload_size' => 'required',
                ]
            );

            $post['storage_setting'] = $request->storage_setting;
            $local_storage_validation = implode(',', $request->local_storage_validation);
            $post['local_storage_validation'] = $local_storage_validation;
            $post['local_storage_max_upload_size'] = $request->local_storage_max_upload_size;
        }

        if (isset($request->storage_setting) && $request->storage_setting == 's3') {
            $request->validate(
                [
                    's3_key'                  => 'required',
                    's3_secret'               => 'required',
                    's3_region'               => 'required',
                    's3_bucket'               => 'required',
                    's3_url'                  => 'required',
                    's3_endpoint'             => 'required',
                    's3_max_upload_size'      => 'required',
                    's3_storage_validation'   => 'required',
                ]
            );
            $post['storage_setting']            = $request->storage_setting;
            $post['s3_key']                     = $request->s3_key;
            $post['s3_secret']                  = $request->s3_secret;
            $post['s3_region']                  = $request->s3_region;
            $post['s3_bucket']                  = $request->s3_bucket;
            $post['s3_url']                     = $request->s3_url;
            $post['s3_endpoint']                = $request->s3_endpoint;
            $post['s3_max_upload_size']         = $request->s3_max_upload_size;
            $s3_storage_validation              = implode(',', $request->s3_storage_validation);
            $post['s3_storage_validation']      = $s3_storage_validation;
        }

        if (isset($request->storage_setting) && $request->storage_setting == 'wasabi') {
            $request->validate(
                [
                    'wasabi_key'                    => 'required',
                    'wasabi_secret'                 => 'required',
                    'wasabi_region'                 => 'required',
                    'wasabi_bucket'                 => 'required',
                    'wasabi_url'                    => 'required',
                    'wasabi_root'                   => 'required',
                    'wasabi_max_upload_size'        => 'required',
                    'wasabi_storage_validation'     => 'required',
                ]
            );
            $post['storage_setting']            = $request->storage_setting;
            $post['wasabi_key']                 = $request->wasabi_key;
            $post['wasabi_secret']              = $request->wasabi_secret;
            $post['wasabi_region']              = $request->wasabi_region;
            $post['wasabi_bucket']              = $request->wasabi_bucket;
            $post['wasabi_url']                 = $request->wasabi_url;
            $post['wasabi_root']                = $request->wasabi_root;
            $post['wasabi_max_upload_size']     = $request->wasabi_max_upload_size;
            $wasabi_storage_validation          = implode(',', $request->wasabi_storage_validation);
            $post['wasabi_storage_validation']  = $wasabi_storage_validation;
        }

        foreach ($post as $key => $data) {
            $arr = [
                $data,
                $key,
                \Auth::user()->id,
            ];

            \DB::insert(
                'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                $arr
            );
        }

        return redirect()->back()->with('success', 'Storage setting successfully updated.');
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
        return redirect()->back()->with('success', 'SEO setting successfully updated.');
    }

    
   public function CookieConsent(Request $request)
    {

        $settings= Utility::settings();
        
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

            $ip = $_SERVER['REMOTE_ADDR'];
            // $ip = '49.36.83.154';
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
    function get_device_type($user_agent) {
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
            if ( $request->cookie_logging && $request->enable_cookie)
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
            return redirect()->back()->with('success', 'Cookie setting successfully saved.');
        }

        public function cacheSettings()
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');

        return redirect()->back()->with('success', 'Cache clear Successfully');

    }

}
