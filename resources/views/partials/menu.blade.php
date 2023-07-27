<?php
    $logo_path = \App\Models\Utility::get_file('logo/');
    $logo=url($logo_path);

     $dark_logo = \App\Models\Utility::CompanySetting('dark_logo');
     $light_logo = \App\Models\Utility::CompanySetting('light_logo');


    $users = \Auth::user();
    $profile = asset(Storage::url('uploads/avatar/'));
    $currantLang = $users->currentLanguage();

    $mode_setting = \App\Models\Utility::settings();




?>

<!-- [ navigation menu ] start -->
@if (isset($mode_setting['cust_theme_bg']) && $mode_setting['cust_theme_bg'] == 'on')
    <nav class="dash-sidebar light-sidebar transprent-bg">
    @else
        <nav class="dash-sidebar light-sidebar">
@endif
{{-- <nav class="dash-sidebar light-sidebar {{($setting['is_sidebar_transperent'] == 'off' &&  $setting['is_sidebar_transperent'] != 'on') ? '' : 'transprent-bg'}}"> --}}
<div class="navbar-wrapper">
    <div class="m-header main-logo">
        <a href="#" class="b-brand">
            <!-- ========   change your logo hear   ======= -->

            @if (\Auth::user()->user_type == 'company')
                @if (!empty($mode_setting['cust_darklayout']) && $mode_setting['cust_darklayout'] == 'on')
                    <img src="{{ $logo . '/' . (isset($light_logo['company_dark_logo']) && !empty($light_logo['company_light_logo']) ? $light_logo['company_light_logo']. '?'.time() : 'logo-light.png'. '?'.time()) }}"
                    width="170px" alt="{{ config('app.name', 'Google Analytics') }}" class="logo logo-lg">
                @else
                    <img src="{{ $logo . '/' . (isset($dark_logo['company_dark_logo']) && !empty($dark_logo['company_dark_logo']) ? $dark_logo['company_dark_logo'] . '?'.time(): 'logo-dark.png'. '?'.time()) }}"
                    width="170px" alt="{{ config('app.name', 'Google Analytics') }}" class="logo logo-lg">
                @endif
            @else
                <img src="{{ @$logos . '' . (isset($company_dark_logo) && !empty($company_dark_logo) ? $company_dark_logo . '?'.time(): 'logo-dark.png'. '?'.time()) }}"
                    alt="{{ config('app.name', 'Google Analytics') }}" class="logo logo-lg">
            @endif
        </a>
    </div>
    <div class="navbar-content">
         <ul class="dash-navbar">
            <li class="dash-item  dash-hasmenu">
              <a href="{{ route('dashboard') }}" class="dash-link {{ (Request::route()->getName() == 'dashboard'
              ) ? ' active' : '' }}">
                <span class="dash-micon">
                  <i class="ti ti-home"></i>
                </span>
                <span class="dash-mtext">{{__('Dashboard')}}</span>
              </a>
            </li>


            @if(\Auth::user()->can('manage user'))
            <li class="dash-item  dash-hasmenu">
              <a href="{{ route('users') }}" class="dash-link {{ (Request::route()->getName() == 'users'
              ) ? ' active' : '' }}">
                <span class="dash-micon">
                  <i class="ti ti-user"></i>
                </span>
                <span class="dash-mtext">{{__('Users')}}</span>
              </a>
            </li>
            @endif
            @if(\Auth::user()->can('manage role'))
            <li class="dash-item  dash-hasmenu">
              <a href="{{ route('roles.index') }}" class="dash-link {{ (Request::route()->getName() == 'roles'
              ) ? ' active' : '' }}">
                <span class="dash-micon">
                  <i class="ti ti-share"></i>
                </span>
                <span class="dash-mtext">{{__('Role')}}</span>
              </a>
            </li>
            @endif
            @if(\Auth::user()->can('show quick view'))
            <li class="dash-item  dash-hasmenu">
              <a href="{{ url('quick-view/0') }}" class="dash-link {{ (Request::route()->getName() == 'quick-view'
              ) ? ' active' : '' }}">
                <span class="dash-micon">
                  <i class="ti ti-layers-difference"></i>
                </span>
                <span class="dash-mtext">{{__('Quick View')}}</span>
              </a>
            </li>
            @endif
            @if(\Auth::user()->can('manage widget'))
            <li class="dash-item  dash-hasmenu">
              <a href="{{ route('widget') }}" class="dash-link {{ (Request::route()->getName() == 'widget'
              ) ? ' active' : '' }}">
                <span class="dash-micon">
                 <i class="ti ti-layout-2"></i>
                </span>
                <span class="dash-mtext">{{__('Widget')}}</span>
              </a>
            </li>
            @endif
            @if (\Auth::user())
            <li class="dash-item  dash-hasmenu">
              <a href="{{ url('site-standard/0') }}" class="dash-link {{ (Request::route()->getName() == 'site-standard'
              ) ? ' active' : '' }}">
                <span class="dash-micon">
                  <i data-feather="layers"></i>
                </span>
                <span class="dash-mtext">{{__('Standard')}}</span>
              </a>
            </li>
            @endif
            @if(\Auth::user()->can('show analytic') || \Auth::user()->can('show channel analytic')|| \Auth::user()->can('show audience analytic')|| \Auth::user()->can('show pages analytic')|| \Auth::user()->can('show seo analytic'))
            <li class="dash-item dash-hasmenu">
              <a href="#!" class="dash-link"
                ><span class="dash-micon"><i class="ti ti-box"></i></span
                ><span class="dash-mtext">{{__('Analytics')}}</span
                ><span class="dash-arrow"><i data-feather="chevron-right"></i></span
              ></a>
              <ul class="dash-submenu">
                @if(\Auth::user()->can('show channel analytic'))
                <li class="dash-item">
                  <a href="{{ route('channel') }}" class="dash-link {{ (Request::route()->getName() == 'channel'
              ) ? ' active' : '' }}">{{__('Channel')}}</a>
                </li>
                @endif
                @if(\Auth::user()->can('show audience analytic'))
                <li class="dash-item">
                  <a href="{{ route('audience') }}" class="dash-link {{ (Request::route()->getName() == 'audience'
              ) ? ' active' : '' }}">{{__('Audience')}}</a>
                </li>
                @endif
                @if(\Auth::user()->can('show pages analytic'))
                <li class="dash-item">
                  <a href="{{ route('page') }}" class="dash-link {{ (Request::route()->getName() == 'page'
              ) ? ' active' : '' }}">{{__('Pages')}}</a>
                </li>
                @endif
                @if(\Auth::user()->can('show seo analytic'))
                <li class="dash-item">
                  <a href="{{ route('seo-analysis') }}" class="dash-link {{ (Request::route()->getName() == 'seo-analysis'
              ) ? ' active' : '' }}">{{__('SEO')}}</a>
                </li>
                @endif
              </ul>
            </li>
            @endif

            @if(\Auth::user()->can('show custom analytic'))
            <li class="dash-item  dash-hasmenu">
              <a href="{{ url('custom-dashboard') }}" class="dash-link {{ (Request::route()->getName() == 'custom-dashboard'
              ) ? ' active' : '' }}">
                <span class="dash-micon">
                  <i data-feather="layers"></i>
                </span>
                <span class="dash-mtext">{{__('Custom')}}</span>
              </a>
            </li>
            @endif

             @if (\Auth::user())

            <li class="dash-item dash-hasmenu">
              <a href="#!" class="dash-link"
                ><span class="dash-micon"><i class="ti ti-box"></i></span
                ><span class="dash-mtext">{{__('Alerts')}}</span
                ><span class="dash-arrow"><i data-feather="chevron-right"></i></span
              ></a>
              <ul class="dash-submenu">

                <li class="dash-item">
                  <a href="{{ route('aletr') }}" class="dash-link {{ (Request::route()->getName() == 'aletr'
              ) ? ' active' : '' }}">{{__('Alerts')}}</a>
                </li>

                <li class="dash-item">
                  <a href="{{ route('aletr-history') }}" class="dash-link {{ (Request::route()->getName() == 'aletr-history'
              ) ? ' active' : '' }}">{{__('History')}}</a>
                </li>


              </ul>
            </li>
            <li class="dash-item  dash-hasmenu">
              <a href="{{ url('report/history') }}" class="dash-link {{ (Request::route()->getName() == 'report/history'
              ) ? ' active' : '' }}">
                <span class="dash-micon">
                  <i class="ti ti-file-invoice"></i>
                </span>
                <span class="dash-mtext">{{__('Report')}}</span>
              </a>
            </li>
            @endif


            @if(\Auth::user()->user_type == 'company')
            @include('landingpage::menu.landingpage')
            @endif


            @if (\Auth::user()->user_type == 'company')
            <li class="dash-item  dash-hasmenu">
              <a href="{{ route('company.settings') }}" class="dash-link {{ (Request::route()->getName() == 'company.settings'
              ) ? ' active' : '' }}">
                <span class="dash-micon">
                  <i class="ti ti-settings"></i>
                </span>
                <span class="dash-mtext">{{__('Settings')}}</span>
              </a>
            </li>
             @endif


          </ul>
    </div>
</div>
</nav>
<!-- [ navigation menu ] end -->
