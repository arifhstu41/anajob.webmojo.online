<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use App\Models\Utility;
use App\Models\Settings;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create($lang = '')
    {
         if ($lang == '') {
            $settings = Utility::settings();
            $lang = $settings['default_language'];
        }

        \App::setLocale($lang);
        return view('auth.forgot-password',compact('lang'));
    }
     public function showforget_passwordForm($lang = '')
    {
        if ($lang == '') {
            $settings = Utility::settings();
            $lang = $settings['default_language'];
        }

        if($lang == 'ar' || $lang =='iw'){
            $value = 'on';
        }
        else{
            $value = 'off';
        }
        $setting = Settings::updateOrCreate(
            ['name' => 'SITE_RTL', 'created_by' => 1],
            ['name' => 'SITE_RTL', 'value' => $value, 'created_by' => 1]
        )->get();

        \App::setLocale($lang);

        return view('auth.forgot-password', compact('lang'));
    }
    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }
}
