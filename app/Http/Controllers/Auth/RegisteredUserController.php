<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use App\Models\Utility;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Carbon\Carbon;
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        


        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'company',
            'created_by' => 1,
            'plan' => 1,
            'plan_expire_date' => Carbon::now()->addDays(5),
        ]);

        event(new Registered($user));
                $role_r = Role::findByName('company');
                    $user->assignRole($role_r);

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

     public function showregisterForm($lang = '')
    {  
        return redirect()->back();
        if ($lang == '') {
            $settings = Utility::settings();
            $lang = $settings['default_language'];
        }

        \App::setLocale($lang);

        return view('auth.register', compact('lang'));
    }
}
