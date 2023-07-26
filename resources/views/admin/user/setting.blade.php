@extends('layouts.admin')


@section('page-title')
    {{ __('Settings') }}
@endsection
<?php
    $cookie = App\Models\Utility::cookies();
    $logo_path = \App\Models\Utility::get_file('logo/');
    $logo=url($logo_path);
    $file_type = config('files_types');
    $setting = App\Models\Utility::settings();
    
    $local_storage_validation = $setting['local_storage_validation'];
    $local_storage_validations = explode(',', $local_storage_validation);
    
    $s3_storage_validation = $setting['s3_storage_validation'];
    $s3_storage_validations = explode(',', $s3_storage_validation);
    
    $wasabi_storage_validation = $setting['wasabi_storage_validation'];
    $wasabi_storage_validations = explode(',', $wasabi_storage_validation);
    $settings = \App\Models\Utility::colorset();
    
    $locations = \App\Models\Utility::CompanySetting();
    
    $color = 'theme-3';
    if (!empty($setting['color'])) {
        $color = $setting['color'];
    }
    $SITE_RTL = $setting['SITE_RTL'];
    if ($setting['SITE_RTL'] = '') {
        $SITE_RTL = 'off';
    }
    
    $dark_logo = \App\Models\Utility::CompanySetting('dark_logo');
     $light_logo = \App\Models\Utility::CompanySetting('light_logo');

    $company_favicon = \App\Models\Utility::CompanySetting('company_favicon');
   
    
?>


@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Settings') }}</li>
@endsection

@section('content')

        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top" style="top:30px">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <a href="#useradd-1"
                                class="list-group-item list-group-item-action border-0">{{ __('Brand Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#useradd-2"
                                class="list-group-item list-group-item-action border-0">{{ __('System Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#useradd-4"
                                class="list-group-item list-group-item-action border-0 ">{{ __('Storage Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#useradd-3"
                                class="list-group-item list-group-item-action border-0">{{ __('Email Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#useradd-5" class="list-group-item list-group-item-action border-0">{{ __('SEO Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#useradd-6" class="list-group-item list-group-item-action border-0">{{ __('Cookie Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#useradd-7"
                                class="list-group-item list-group-item-action border-0">{{ __('Slack Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                             <a href="#useradd-8"
                                class="list-group-item list-group-item-action border-0">{{ __('Report') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#useradd-9"
                                class="list-group-item list-group-item-action border-0">{{ __('Cache Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div id="useradd-1" class="card">
                        {{ Form::open(['route' => ['company.settings.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                        <div class="card-header">
                            <h5>{{ __('Brand Settings') }}</h5>
                            <small class="text-muted">{{ __('Edit your brand details') }}</small>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="card logo_card">
                                        <div class="card-header">
                                            <h5 class="small-title">{{ __('Light Logo') }}</h5>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="setting-card">
                                                <div class="logo-content mt-4 text-center">
                                                    {{-- @dd($light_logo) --}}
                                                    <a href="{{ $logo . '/' . (isset($light_logo['company_light_logo']) && !empty($light_logo['company_light_logo']) ? $light_logo['company_light_logo'] . '?'.time() : 'logo-light.png' . '?'.time()) }}"
                                                        target="_blank"> <img id="light"
                                                            src="{{ $logo . '/' . (isset($light_logo['company_light_logo']) && !empty($light_logo['company_light_logo']) ? $light_logo['company_light_logo'] . '?'.time(): 'logo-light.png' . '?'.time()) }}" class="img_setting big-logo" > </a>

                                                </div>
                                                <div class="choose-files mt-5">
                                                    <label for="logo">
                                                        <div class=" bg-primary logo_update"> <i
                                                                class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                            <input style="margin-top: -40px;" type="file"
                                                                class="form-control file" name="light_logo" id="light_logo"
                                                                data-filename="edit-light_logo" accept=".jpeg,.jpg,.png"
                                                                accept=".jpeg,.jpg,.png"
                                                                onchange="document.getElementById('light').src = window.URL.createObjectURL(this.files[0])">
                                                        </div>
                                                    </label>
                                                </div>
                                                {{-- @error('light_logo')
                                                    <div class="row">
                                                        <span class="invalid-logo" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    </div>
                                                @enderror --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Light Logo --}}
                                <div class="col-sm-4">
                                    <div class="card logo_card">
                                        <div class="card-header">

                                            <h5>{{ __('Dark Logo') }}</h5>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="setting-card">
                                                <div class="logo-content mt-4 text-center">

                                                    <a href="{{ $logo . '/' . (isset($dark_logo['company_dark_logo']) && !empty($dark_logo['company_dark_logo']) ? $dark_logo['company_dark_logo'] . '?'.time(): 'logo-dark.png'. '?'.time()) }}"
                                                        target="_blank"> <img id="logo" class="big-logo" 
                                                            src="{{ $logo . '/' . (isset($dark_logo['company_dark_logo']) && !empty($dark_logo['company_dark_logo']) ? $dark_logo['company_dark_logo'] . '?'.time(): 'logo-dark.png'. '?'.time()) }}"> </a>

                                                </div>
                                                <div class="choose-files mt-5">
                                                    <label for="logo">
                                                        <div class=" bg-primary logo_update" style="width:180px;"> <i
                                                                class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                            <input style="margin-top: -40px;" type="file"
                                                                class="form-control file" name="dark_logo" id="dark_logo"
                                                                data-filename="edit-dark_logo" accept=".jpeg,.jpg,.png"
                                                                accept=".jpeg,.jpg,.png"
                                                                onchange="document.getElementById('logo').src = window.URL.createObjectURL(this.files[0])">
                                                        </div>
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Favicon Logo --}}
                                <div class="col-lg-4 col-sm-6 col-md-6">
                                    <div class="card logo_card">
                                        <div class="card-header">
                                            <h5>{{ __('Favicon') }}</h5>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="setting-card text-center">
                                                <div class="logo-content mt-4">
                                                    <a href="{{ $logo . '/' . (isset($company_favicon['company-favicon']) && !empty($company_favicon['company-favicon']) ? $company_favicon['company-favicon'] . '?'.time(): 'favicon.png'. '?'.time()) }}"
                                                        target="_blank"><img
                                                            src="{{ $logo . '/' . (isset($company_favicon['company-favicon']) && !empty($company_favicon['company-favicon']) ? $company_favicon['company-favicon']. '?'.time() : 'favicon.png'. '?'.time()) }}"
                                                            width="50px" id="favicon" class=""></a>
                                                </div>
                                                <div class="choose-files mt-5">
                                                    <label for="logo">
                                                        <div class=" bg-primary logo_update" style="width:180px;"> <i
                                                                class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                            <input style="margin-top: -40px;" type="file"
                                                                class="form-control file" name="company_favicon"
                                                                id="company_favicon" data-filename="edit-company_favicon"
                                                                accept=".jpeg,.jpg,.png" accept=".jpeg,.jpg,.png"
                                                                onchange="document.getElementById('favicon').src = window.URL.createObjectURL(this.files[0])">
                                                        </div>
                                                    </label>
                                                </div>
                                                {{-- @error('company_favicon')
                                                    <div class="row">
                                                        <span class="invalid-logo" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    </div>
                                                @enderror --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('header_text', __('Title Text'), ['class' => 'col-form-label text-dark']) }}
                                        <input class="form-control" placeholder="Title Text" name="header_text"
                                            type="text"
                                            value="{{ !empty($locations['header_text']) ? $locations['header_text'] : '' }}"
                                            id="header_text">
                                        @error('header_text')
                                            <span class="invalid-header_text" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('header_text', __('Footer Text'), ['class' => 'col-form-label text-dark']) }}
                                        <input class="form-control" placeholder="Title Text" name="footer_text"
                                            type="text"
                                            value="{{ !empty($locations['footer_text']) ? $locations['footer_text'] : '' }}"
                                            id="footer_text">
                                        @error('footer_text')
                                            <span class="invalid-footer_text" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="col-4 switch-width">
                                        <div class="form-group ml-2 mr-3 ">
                                            {{ Form::label('SITE_RTL', __('Enable RTL'), ['class' => 'col-form-label text-dark']) }}
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" data-toggle="switchbutton" data-onstyle="primary"
                                                    class="" name="SITE_RTL" value="on" id="SITE_RTL"
                                                    {{ $SITE_RTL == 'on' ? 'checked="checked"' : '' }}>
                                                <label class="custom-control-label" for="SITE_RTL"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <h4 class="small-title">{{ __('Theme Customizer') }}</h4>
                                    <div class="setting-card setting-logo-box p-3">
                                        <div class="row">
                                            <div class="pct-body">
                                                <div class="row">
                                                    <div class="col-lg-4 col-xl-4 col-md-4">
                                                        <h6 class="mt-2">
                                                            <i data-feather="credit-card"
                                                                class="me-2"></i>{{ __('Primary color Settings') }}
                                                        </h6>
                                                        <hr class="my-2" />
                                                        <div class="theme-color themes-color">
                                                            {{-- <a href="#!"
                                                                class="themes-color-change {{ $color == 'theme-1' ? 'active_color' : '' }}"
                                                                data-value="theme-1" onclick="check_theme('theme-1')"></a>
                                                            <input type="radio" class="theme_color" name="color"
                                                                value="theme-1" style="display: none;"
                                                                {{ $setting['color'] == 'theme-1' ? 'checked' : '' }}>
                                                            <a href="#!"
                                                                class=" themes-color-change {{ $color == 'theme-2' ? 'active_color' : '' }}"
                                                                data-value="theme-2" onclick="check_theme('theme-2')"></a>
                                                            <input type="radio" class="theme_color" name="color"
                                                                value="theme-2" style="display: none;"
                                                                {{ $setting['color'] == 'theme-2' ? 'checked' : '' }}>
                                                            <a href="#!"
                                                                class="themes-color-change {{ $color == 'theme-3' ? 'active_color' : '' }}"
                                                                data-value="theme-3" onclick="check_theme('theme-3')"></a>
                                                            <input type="radio" class="theme_color" name="color"
                                                                value="theme-3" style="display: none;"
                                                                {{ $setting['color'] == 'theme-3' ? 'checked' : '' }}>
                                                            <a href="#!"
                                                                class="themes-color-change {{ $color == 'theme-4' ? 'active_color' : '' }}"
                                                                data-value="theme-4" onclick="check_theme('theme-4')"></a>
                                                            <input type="radio" class="theme_color" name="color"
                                                                value="theme-4" style="display: none;"
                                                                {{ $setting['color'] == 'theme-4' ? 'checked' : '' }}> --}}

                                                                <a href="#!" class="{{(!empty($color) && $color == 'theme-1') ? 'active_color' : ''}}" data-value="theme-1" onclick="check_theme('theme-1')"></a>
                                                                <input type="radio" class="theme_color" name="color" value="theme-1" style="display: none;" {{ !empty($color) && $color == 'theme-1' ? 'checked' : '' }}>
                                                                <a href="#!" class="{{(!empty($color) && $color == 'theme-2') ? 'active_color' : ''}} " data-value="theme-2" onclick="check_theme('theme-2')"></a>
                                                                <input type="radio" class="theme_color" name="color" value="theme-2" style="display: none;" {{ !empty($color) && $color == 'theme-2' ? 'checked' : '' }}>
                                                                <a href="#!" class="{{(!empty($color) && $color == 'theme-3') ? 'active_color' : ''}}" data-value="theme-3" onclick="check_theme('theme-3')"></a>
                                                                <input type="radio" class="theme_color" name="color" value="theme-3" style="display: none;" {{ !empty($color) && $color == 'theme-3' ? 'checked' : '' }}>
                                                                <a href="#!" class="{{(!empty($color) && $color == 'theme-4') ? 'active_color' : ''}}" data-value="theme-4" onclick="check_theme('theme-4')"></a>
                                                                <input type="radio" class="theme_color" name="color" value="theme-4" style="display: none;" {{ !empty($color) && $color == 'theme-4' ? 'checked' : '' }}>
                                                                <a href="#!" class="{{(!empty($color) && $color == 'theme-5') ? 'active_color' : ''}}" data-value="theme-5" onclick="check_theme('theme-5')"></a>
                                                                <input type="radio" class="theme_color" name="color" value="theme-5" style="display: none;" {{ !empty($color) && $color == 'theme-5' ? 'checked' : '' }}>
                                                                <br>
                                                                <a href="#!" class="{{(!empty($color) && $color == 'theme-6') ? 'active_color' : ''}}" data-value="theme-6" onclick="check_theme('theme-6')"></a>
                                                                <input type="radio" class="theme_color" name="color" value="theme-6" style="display: none;" {{ !empty($color) && $color == 'theme-6' ? 'checked' : '' }}>
                                                                <a href="#!" class="{{(!empty($color) && $color == 'theme-7') ? 'active_color' : ''}}" data-value="theme-7" onclick="check_theme('theme-7')"></a>
                                                                <input type="radio" class="theme_color" name="color" value="theme-7" style="display: none;" {{ !empty($color) && $color == 'theme-7' ? 'checked' : '' }}>
                                                                <a href="#!" class="{{(!empty($color) && $color == 'theme-8') ? 'active_color' : ''}}" data-value="theme-8" onclick="check_theme('theme-8')"></a>
                                                                <input type="radio" class="theme_color" name="color" value="theme-8" style="display: none;" {{ !empty($color) && $color == 'theme-8' ? 'checked' : '' }}>
                                                                <a href="#!" class="{{(!empty($color) && $color == 'theme-9') ? 'active_color' : ''}}" data-value="theme-9" onclick="check_theme('theme-9')"></a>
                                                                <input type="radio" class="theme_color" name="color" value="theme-9" style="display: none;" {{ !empty($color) && $color == 'theme-9' ? 'checked' : '' }}>
                                                                <a href="#!" class="{{(!empty($color) && $color == 'theme-10') ? 'active_color' : ''}}" data-value="theme-10" onclick="check_theme('theme-10')"></a>
                                                                <input type="radio" class="theme_color" name="color" value="theme-10" style="display: none;" {{ !empty($color) && $color == 'theme-10' ? 'checked' : '' }}>
                                                        </div>

                                                    </div>

                                                    <div class="col-lg-4 col-xl-4 col-md-4">
                                                        <h6 class="mt-2">
                                                            <i data-feather="layout"
                                                                class="me-2"></i>{{ __('Sidebar Settings') }}
                                                        </h6>

                                                        <hr class="my-2" />
                                                        <div class="form-check form-switch">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="cust-theme-bg" name="cust_theme_bg"
                                                                {{-- {{ Utility::getValByName('cust_theme_bg') == 'on' ? 'checked' : '' }}> --}}
                                                                {{ !empty($locations['cust_theme_bg']) && $locations['cust_theme_bg'] == 'on' ? 'checked' : '' }} />
                                                            <label class="form-check-label f-w-600 pl-1"
                                                                for="cust-theme-bg">{{ __('Transparent layout') }}</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-xl-4 col-md-4">
                                                        <h6 class="mt-2">
                                                            <i data-feather="sun"
                                                                class="me-2"></i>{{ __('Layout Settings') }}
                                                        </h6>
                                                        <hr class="my-2" />
                                                        <div class="form-check form-switch mt-2">
                                                            <input type="hidden" name="cust_darklayout" value="off">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="cust-darklayout" name="cust_darklayout"
                                                                {{ !empty($locations['cust_darklayout']) && $locations['cust_darklayout'] == 'on' ? 'checked' : '' }} />

                                                            <label class="form-check-label f-w-600 pl-1"
                                                                for="cust-darklayout">{{ __('Dark Layout') }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    {{ Form::submit(__('Save Changes'), ['class' => 'btn btn-print-invoice  btn-primary m-r-10']) }}
                                </div>

                            </div>

                        </div>

                        {{ Form::close() }}
                    </div>

                    <div id="useradd-2" class="card">
                        {{ Form::open(['route' => ['company.settings.system.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                        <div class="card-header">
                            <h5>{{ __('System Settings') }}</h5>
                            <small class="text-muted">{{ __('Edit your system details') }}</small>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="title_text" class="form-label">{{ __('Date format') }}</label>
                                        {!! Form::select(
                                            'date_format',
                                            ['d/m/Y' => 'DD/MM/YYYY', 'm-d-Y' => 'MM-DD-YYYY', 'd-m-Y' => 'DD-MM-YYYY'],
                                            !empty($setting['date_format']) ? $setting['date_format'] : '',
                                            ['class' => 'form-control ', 'required' => 'required'],
                                        ) !!}

                                    </div>
                                </div>
                                <div class="col-md-8">
                                <div class="form-group ">
                                    <label for="outh_path" class="form-label">{{__('Set this url as Authorized redirect URIs')}}</label>
                                    <input type="text" class="form-control" name="outh_path" value="<?=url('/').'/oauth2callback'?>" disabled="">
                                 </div>
                                 </div>
                                <div class="modal-footer">
                                    <input type="submit" value="{{ __('Save Changes') }}" class="btn btn-primary">
                                </div>
                            </div>
                        </div>

                        {{ Form::close() }}
                    </div>

                    <div id="useradd-4" class="card mb-3">
                        {{ Form::open(['route' => 'storage.setting.store', 'enctype' => 'multipart/form-data']) }}
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-10 col-md-10 col-sm-10">
                                    <h5 class="">{{ __('Storage Settings') }}</h5>
                                    <small class="text-muted">{{ __('Edit storage Settings') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="pe-2">
                                    <input type="radio" class="btn-check" name="storage_setting" id="local-outlined"
                                        autocomplete="off" {{ $setting['storage_setting'] == 'local' ? 'checked' : '' }}
                                        value="local" checked>
                                    <label class="btn btn-outline-primary"
                                        for="local-outlined">{{ __('Local') }}</label>
                                </div>
                                <div class="pe-2">
                                    <input type="radio" class="btn-check" name="storage_setting" id="s3-outlined"
                                        autocomplete="off" {{ $setting['storage_setting'] == 's3' ? 'checked' : '' }}
                                        value="s3">
                                    <label class="btn btn-outline-primary" for="s3-outlined">
                                        {{ __('AWS S3') }}</label>
                                </div>

                                <div class="pe-2">
                                    <input type="radio" class="btn-check" name="storage_setting" id="wasabi-outlined"
                                        autocomplete="off" {{ $setting['storage_setting'] == 'wasabi' ? 'checked' : '' }}
                                        value="wasabi">
                                    <label class="btn btn-outline-primary"
                                        for="wasabi-outlined">{{ __('Wasabi') }}</label>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div
                                    class="local-setting row {{ $setting['storage_setting'] == 'local' ? ' ' : 'd-none' }}">
                                    {{-- <h4 class="small-title">{{ __('Local Settings') }}</h4> --}}
                                    <div class="form-group col-8 switch-width">
                                        {{ Form::label('local_storage_validation', __('Only Upload Files'), ['class' => 'mb-2']) }}
                                        <select name="local_storage_validation[]" class="multi-select choices__input"
                                            id="local_storage_validation" id='choices-multiple' multiple>
                                             @foreach ($file_type as $f)
                                                <option @if (in_array($f, $local_storage_validations)) selected @endif>
                                                    {{ $f }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label"
                                                for="local_storage_max_upload_size">{{ __('Max upload size ( In KB)') }}</label>
                                            <input type="number" name="local_storage_max_upload_size"
                                                class="form-control"
                                                value="{{ !isset($setting['local_storage_max_upload_size']) || is_null($setting['local_storage_max_upload_size']) ? '' : $setting['local_storage_max_upload_size'] }}"
                                                placeholder="{{ __('Max upload size') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="s3-setting row {{ $setting['storage_setting'] == 's3' ? ' ' : 'd-none' }}">

                                    <div class=" row ">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="s3_key">{{ __('S3 Key') }}</label>
                                                <input type="text" name="s3_key" class="form-control"
                                                    value="{{ !isset($setting['s3_key']) || is_null($setting['s3_key']) ? '' : $setting['s3_key'] }}"
                                                    placeholder="{{ __('S3 Key') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="s3_secret">{{ __('S3 Secret') }}</label>
                                                <input type="text" name="s3_secret" class="form-control"
                                                    value="{{ !isset($setting['s3_secret']) || is_null($setting['s3_secret']) ? '' : $setting['s3_secret'] }}"
                                                    placeholder="{{ __('S3 Secret') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="s3_region">{{ __('S3 Region') }}</label>
                                                <input type="text" name="s3_region" class="form-control"
                                                    value="{{ !isset($setting['s3_region']) || is_null($setting['s3_region']) ? '' : $setting['s3_region'] }}"
                                                    placeholder="{{ __('S3 Region') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="s3_bucket">{{ __('S3 Bucket') }}</label>
                                                <input type="text" name="s3_bucket" class="form-control"
                                                    value="{{ !isset($setting['s3_bucket']) || is_null($setting['s3_bucket']) ? '' : $setting['s3_bucket'] }}"
                                                    placeholder="{{ __('S3 Bucket') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="s3_url">{{ __('S3 URL') }}</label>
                                                <input type="text" name="s3_url" class="form-control"
                                                    value="{{ !isset($setting['s3_url']) || is_null($setting['s3_url']) ? '' : $setting['s3_url'] }}"
                                                    placeholder="{{ __('S3 URL') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_endpoint">{{ __('S3 Endpoint') }}</label>
                                                <input type="text" name="s3_endpoint" class="form-control"
                                                    value="{{ !isset($setting['s3_endpoint']) || is_null($setting['s3_endpoint']) ? '' : $setting['s3_endpoint'] }}"
                                                    placeholder="{{ __('S3 Bucket') }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-8 switch-width">
                                            {{ Form::label('s3_storage_validation', __('Only Upload Files'), ['class' => ' form-label']) }}
                                            <select name="s3_storage_validation[]" class="multi-select"
                                                id="s3_storage_validation" multiple>
                                                @foreach ($file_type as $f)
                                                    <option @if (in_array($f, $s3_storage_validations)) selected @endif>
                                                        {{ $f }}</option>
                                                @endforeach  

                                                  
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_max_upload_size">{{ __('Max upload size ( In KB)') }}</label>
                                                <input type="number" name="s3_max_upload_size" class="form-control"
                                                    value="{{ !isset($setting['s3_max_upload_size']) || is_null($setting['s3_max_upload_size']) ? '' : $setting['s3_max_upload_size'] }}"
                                                    placeholder="{{ __('Max upload size') }}">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div
                                    class="wasabi-setting row {{ $setting['storage_setting'] == 'wasabi' ? ' ' : 'd-none' }}">
                                    <div class=" row ">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_key">{{ __('Wasabi Key') }}</label>
                                                <input type="text" name="wasabi_key" class="form-control"
                                                    value="{{ !isset($setting['wasabi_key']) || is_null($setting['wasabi_key']) ? '' : $setting['wasabi_key'] }}"
                                                    placeholder="{{ __('Wasabi Key') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_secret">{{ __('Wasabi Secret') }}</label>
                                                <input type="text" name="wasabi_secret" class="form-control"
                                                    value="{{ !isset($setting['wasabi_secret']) || is_null($setting['wasabi_secret']) ? '' : $setting['wasabi_secret'] }}"
                                                    placeholder="{{ __('Wasabi Secret') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_region">{{ __('Wasabi Region') }}</label>
                                                <input type="text" name="wasabi_region" class="form-control"
                                                    value="{{ !isset($setting['wasabi_region']) || is_null($setting['wasabi_region']) ? '' : $setting['wasabi_region'] }}"
                                                    placeholder="{{ __('Wasabi Region') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="wasabi_bucket">{{ __('Wasabi Bucket') }}</label>
                                                <input type="text" name="wasabi_bucket" class="form-control"
                                                    value="{{ !isset($setting['wasabi_bucket']) || is_null($setting['wasabi_bucket']) ? '' : $setting['wasabi_bucket'] }}"
                                                    placeholder="{{ __('Wasabi Bucket') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="wasabi_url">{{ __('Wasabi URL') }}</label>
                                                <input type="text" name="wasabi_url" class="form-control"
                                                    value="{{ !isset($setting['wasabi_url']) || is_null($setting['wasabi_url']) ? '' : $setting['wasabi_url'] }}"
                                                    placeholder="{{ __('Wasabi URL') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="wasabi_root">{{ __('Wasabi Root') }}</label>
                                                <input type="text" name="wasabi_root" class="form-control"
                                                    value="{{ !isset($setting['wasabi_root']) || is_null($setting['wasabi_root']) ? '' : $setting['wasabi_root'] }}"
                                                    placeholder="{{ __('Wasabi Bucket') }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-8 switch-width">
                                            {{ Form::label('wasabi_storage_validation', __('Only Upload Files'), ['class' => 'form-label']) }}

                                            <select name="wasabi_storage_validation[]" class="multi-select"
                                                id="wasabi_storage_validation" multiple>
                                                @foreach ($file_type as $f)
                                                    <option @if (in_array($f, $wasabi_storage_validations)) selected @endif>
                                                        {{ $f }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="wasabi_root">{{ __('Max upload size ( In KB)') }}</label>
                                                <input type="number" name="wasabi_max_upload_size"
                                                    class="form-control"
                                                    value="{{ !isset($setting['wasabi_max_upload_size']) || is_null($setting['wasabi_max_upload_size']) ? '' : $setting['wasabi_max_upload_size'] }}"
                                                    placeholder="{{ __('Max upload size') }}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <input class="btn btn-print-invoice  btn-primary m-r-10" type="submit"
                                    value="{{ __('Save Changes') }}">
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>

                    <div id="useradd-3" class="card">
                        {{ Form::open(['route' => 'company.email.settings.store', 'method' => 'post']) }}
                        <div class="card-header">
                            <h5>{{ __('Email Settings') }}</h5>
                            <small class="text-muted">{{ __('Edit Email Settings') }}</small>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 form-group">
                                    {{ Form::label('mail_driver', __('Mail Driver'), ['class' => 'form-label']) }}
                                    {{ Form::text('mail_driver', !empty($location['mail_driver']) ? $location['mail_driver'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Mail Driver')]) }}
                                    @error('mail_driver')
                                        <span class="invalid-mail_driver" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-4 form-group">
                                    {{ Form::label('mail_host', __('Mail Host'), ['class' => 'form-label']) }}
                                    {{ Form::text('mail_host', !empty($location['mail_host']) ? $location['mail_host'] : '', ['class' => 'form-control ', 'placeholder' => __('Enter Mail Driver')]) }}
                                    @error('mail_host')
                                        <span class="invalid-mail_driver" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-4 form-group">
                                    {{ Form::label('mail_port', __('Mail Port'), ['class' => 'form-label']) }}
                                    {{ Form::text('mail_port', !empty($location['mail_port']) ? $location['mail_port'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Mail Port')]) }}
                                    @error('mail_port')
                                        <span class="invalid-mail_port" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-4 form-group">
                                    {{ Form::label('mail_username', __('Mail Username'), ['class' => 'form-label']) }}
                                    {{ Form::text('mail_username', !empty($location['mail_username']) ? $location['mail_username'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Mail Username')]) }}
                                    @error('mail_username')
                                        <span class="invalid-mail_username" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-4 form-group">
                                    {{ Form::label('mail_password', __('Mail Password'), ['class' => 'form-label']) }}
                                    {{ Form::text('mail_password', !empty($location['mail_password']) ? $location['mail_password'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Mail Password')]) }}
                                    @error('mail_password')
                                        <span class="invalid-mail_password" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-4 form-group">
                                    {{ Form::label('mail_encryption', __('Mail Encryption'), ['class' => 'form-label']) }}
                                    {{ Form::text('mail_encryption', !empty($location['mail_encryption']) ? $location['mail_encryption'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Mail Encryption')]) }}
                                    @error('mail_encryption')
                                        <span class="invalid-mail_encryption" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-4 form-group">
                                    {{ Form::label('mail_from_address', __('Mail From Address'), ['class' => 'form-label']) }}
                                    {{ Form::text('mail_from_address', !empty($location['mail_from_address']) ? $location['mail_from_address'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Mail From Address')]) }}
                                    @error('mail_from_address')
                                        <span class="invalid-mail_from_address" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-4 form-group">
                                    {{ Form::label('mail_from_name', __('Mail From Name'), ['class' => 'form-label']) }}
                                    {{ Form::text('mail_from_name', !empty($location['mail_from_name']) ? $location['mail_from_name'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Mail Encryption')]) }}
                                    @error('mail_from_name')
                                        <span class="invalid-mail_from_name" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>
                            <div class="modal-footer ">
                                <div class="row col-12">
                                    <div class="form-group col-md-6">
                                        <a href="#" data-url="{{ route('company.test.mail') }}" id="test_email"
                                            data-title="{{ __('Send Test Mail') }}" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" class="btn  btn-primary send_email">
                                            {{ __('Send Test Mail') }}
                                        </a>
                                    </div>
                                    <div class="form-group col-md-6 text-end">
                                        <input type="submit" value="{{ __('Save Changes') }}" class="btn btn-primary">
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{ Form::close() }}
                    </div>
                     <div id="useradd-5" class="card">
                        {{ Form::open(['url' => route('seo.settings.store'), 'enctype' => 'multipart/form-data']) }}
                          <div class="card-header">
                              <h5>{{ __('SEO Settings') }}</h5>
                              <small class="text-muted">{{ __('Edit your SEO details') }}</small>
                          </div>
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-lg-6">
                                      <div class="form-group">
                                          {{ Form::label('meta_keywords', __('Meta Keywords'), ['class' => 'col-form-label']) }}
                                          {{ Form::text('meta_keywords', !empty($settings['meta_keywords']) ? $settings['meta_keywords'] : '', ['class' => 'form-control ', 'placeholder' => 'Meta Keywords']) }}
                                      </div>
                                      <div class="form-group">
                                          {{ Form::label('meta_description', __('Meta Description'), ['class' => 'form-label']) }}
                                          {{ Form::textarea('meta_description', !empty($settings['meta_description']) ? $settings['meta_description'] : '', ['class' => 'form-control ', 'row' => 2, 'placeholder' => 'Enter Meta Description']) }}
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          {{ Form::label('Meta Image', __('Meta Image'), ['class' => 'col-form-label ']) }}
                                          <div class="card-body pt-0">
                                              <div class="setting-card">
                                                  <div class="logo-content ">
                                                      <a href="{{ $logo . (isset($meta_image) && !empty($meta_image) ? $meta_image : '/meta-image.png') }}"target="_blank">
                                                        <img id="dark"src="{{ $logo . '/meta-image.png' . '?' . time() }}" width="450px" height="250px">
                                                      </a>
                                                  </div>
                                                  <div class="choose-files mt-4">
                                                      <label for="meta_image">
                                                          <div class=" bg-primary logo"> <i
                                                                  class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                          </div>
                                                          <input style="margin-top: -40px;" type="file"
                                                              class="form-control file" name="meta_image"
                                                              id="meta_image" data-filename="meta_image"
                                                              onchange="document.getElementById('meta').src = window.URL.createObjectURL(this.files[0])">
                                                      </label>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="card-footer text-end">
                              <button class="btn-submit btn btn-primary" type="submit">
                                  {{ __('Save Changes') }}
                              </button>
                          </div>
                        {{ Form::close() }}
                    </div>
                    <div id="useradd-6">
                       <div class="card" id="cookie-settings">
                          {{Form::model($settings,array('route'=>'cookie.setting','method'=>'post'))}}
                          <div class="card-header flex-column flex-lg-row  d-flex align-items-lg-center gap-2 justify-content-between">
                              <h5>{{ __('Cookie Settings') }}</h5>
                                  
                              <div class="d-flex align-items-center">
                                  {{ Form::label('enable_cookie', __('Enable cookie'), ['class' => 'col-form-label p-0 fw-bold me-3']) }}
                                  <div class="custom-control custom-switch"  onclick="enablecookie()">
                                      <input type="checkbox" data-toggle="switchbutton" data-onstyle="primary" name="enable_cookie" class="form-check-input input-primary "
                                             id="enable_cookie" {{ $cookie['enable_cookie'] == 'on' ? ' checked ' : '' }} >
                                      <label class="custom-control-label mb-1" for="enable_cookie"></label>
                                  </div>
                              </div>
                          </div>

                          <div class="card-body cookieDiv {{ $cookie['enable_cookie'] == 'off' ? 'disabledCookie ' : '' }}">
                              <div class="row ">
                                  <div class="col-md-6">
                                      <div class="form-check form-switch custom-switch-v1" id="cookie_log">
                                          <input type="checkbox" name="cookie_logging" class="form-check-input input-primary cookie_setting"
                                                 id="cookie_logging"{{ $cookie['cookie_logging'] == 'on' ? ' checked ' : '' }}>
                                          <label class="form-check-label" for="cookie_logging">{{__('Enable logging')}}</label>
                                      </div>
                                      <div class="form-group" >
                                          {{ Form::label('cookie_title', __('Cookie Title'), ['class' => 'col-form-label' ]) }}
                                          {{ Form::text('cookie_title', !empty($cookie['cookie_title']) ? $cookie['cookie_title'] : '', ['class' => 'form-control cookie_setting'] ) }}
                                      </div>
                                      <div class="form-group ">
                                          {{ Form::label('cookie_description', __('Cookie Description'), ['class' => ' form-label']) }}
                                          {!! Form::textarea('cookie_description', !empty($cookie['cookie_description']) ? $cookie['cookie_description'] : '', ['class' => 'form-control cookie_setting', 'rows' => '3']) !!}
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-check form-switch custom-switch-v1 ">
                                          <input type="checkbox" name="necessary_cookies" class="form-check-input input-primary"
                                                 id="necessary_cookies" checked onclick="return false">
                                          <label class="form-check-label" for="necessary_cookies">{{__('Strictly necessary cookies')}}</label>
                                      </div>
                                      <div class="form-group ">
                                          {{ Form::label('strictly_cookie_title', __(' Strictly Cookie Title'), ['class' => 'col-form-label']) }}
                                          {{ Form::text('strictly_cookie_title', !empty($cookie['strictly_cookie_title']) ? $cookie['strictly_cookie_title'] : '', ['class' => 'form-control cookie_setting']) }}
                                      </div>
                                      <div class="form-group ">
                                          {{ Form::label('strictly_cookie_description', __('Strictly Cookie Description'), ['class' => ' form-label']) }}
                                          {!! Form::textarea('strictly_cookie_description', !empty($cookie['strictly_cookie_description']) ? $cookie['strictly_cookie_description'] : '', ['class' => 'form-control cookie_setting ', 'rows' => '3']) !!}
                                      </div>
                                  </div>
                                      <div class="col-12">
                                          <h5>{{__('More Information')}}</h5>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group ">
                                              {{ Form::label('more_information_description', __('Contact Us Description'), ['class' => 'col-form-label']) }}
                                              {{ Form::text('more_information_description', !empty($cookie['more_information_description']) ? $cookie['more_information_description'] : '', ['class' => 'form-control cookie_setting']) }}
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group ">
                                              {{ Form::label('contactus_url', __('Contact Us URL'), ['class' => 'col-form-label']) }}
                                              {{ Form::text('contactus_url', !empty($cookie['contactus_url']) ? $cookie['contactus_url'] : '', ['class' => 'form-control cookie_setting']) }}
                                          </div>
                                      </div>
                              </div>
                          </div>
                          <div class="modal-footer d-flex align-items-center gap-2 flex-sm-column flex-lg-row justify-content-between" >
                              <div>
                                  @if(isset($cookie['cookie_logging']) && $cookie['cookie_logging'] == 'on')
                                  <label for="file" class="form-label">{{__('Download cookie accepted data')}}</label>
                                      <a href="{{ asset(Storage::url('uploads/sample')) . '/data.csv' }}" class="btn btn-primary mr-2 ">
                                          <i class="ti ti-download"></i>
                                      </a>
                                      @endif
                              </div>
                              <input type="submit" value="{{ __('Submit') }}" class="btn btn-primary">
                          </div>
                          {{ Form::close() }}
                      </div>
                    </div>

                   
                    
                    <div id="useradd-7" class="card">
                        {{ Form::open(['route' => ['company.slack.settings'], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                        <div class="card-header">
                            <h5>{{ __('Slack Settings') }}</h5>
                            <small class="text-muted">{{ __('Edit your Slack details') }}</small>
                        </div>

                        <div class="card-body">
                            <div class="row">
                               
                                <div class="col-md-9">
                                    <div class="form-group ">
                                        <label for="title_text" class="form-label">{{__('Slack Webhook URL')}}</label>
                                        <input type="text" class="form-control" name="slack_webhook" value="{{ !empty($locations['slack_webhook']) ? $locations['slack_webhook'] : '' }}" placeholder="{{__('Slack Webhook URL')}}">
                                    
                                    </div>
                                </div>
                                
                                <div class="modal-footer">
                                    <input type="submit" value="{{ __('Save Changes') }}" class="btn btn-primary">
                                </div>
                            </div>
                        </div>

                        {{ Form::close() }}
                    </div>
                  
                    <div id="useradd-8" class="card">
                        {{ Form::open(['route' => ['company.report.settings'], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                        <div class="card-header">
                            <h5>{{ __('Report') }}</h5>
                            <small class="text-muted">{{ __('How often do you want to receive summary reports about your primary metrics?') }}</small>
                        </div>

                        <div class="card-body">
                            <div class="row">
                               
                                <div class="col-lg-6 form-group">
                                    <div class="list-group">
                                        <div class="list-group-item form-switch form-switch-right">
                                            <label class="form-label" style="margin-left:5%;">{{__('Email Notifiation')}}</label>
                                            <input class="form-check-input " onchange="frequency_status()"  id="email_notifiation" type="checkbox" value="0" name="email_notifiation" {{!empty($report_setting->email_notification) && $report_setting->email_notification == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="email_notifiation"></label>

                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12 form-group" id="frequency_block" style="display: none;">
                                   <h4 class="small-title">{{ __('Frequency of new reports') }}</h4>
                                   <hr class="my-2" />
                                    <div class="d-flex flex-wrap gap-3 mb-2 mb-md-0 mt-2">
                                        <div class="form-check form-switch col-lg-2">
                                            <input type="checkbox" class="form-check-input"
                                                id="is_daily" name="is_daily"
                                                {{-- {{ Utility::getValByName('cust_theme_bg') == 1 ? 'checked' : '' }}> --}}
                                                {{ !empty($report_setting->is_daily) && $report_setting->is_daily == 1 ? 'checked' : '' }} />
                                            <label class="form-check-label f-w-600 pl-1"
                                                for="is_daily">{{ __('Daily') }}</label>
                                        </div>
                                        <div class="form-check form-switch col-lg-2">
                                            <input type="checkbox" class="form-check-input"
                                                id="is_weekly" name="is_weekly"
                                                {{-- {{ Utility::getValByName('cust_theme_bg') == 1 ? 'checked' : '' }}> --}}
                                                {{ !empty($report_setting->is_weekly) && $report_setting->is_weekly == 1 ? 'checked' : '' }} />
                                            <label class="form-check-label f-w-600 pl-1"
                                                for="is_weekly">{{ __('Weekly') }}</label>
                                        </div>
                                        <div class="form-check form-switch col-lg-2">
                                            <input type="checkbox" class="form-check-input"
                                                id="is_monthly" name="is_monthly"
                                                {{-- {{ Utility::getValByName('cust_theme_bg') == 1 ? 'checked' : '' }}> --}}
                                                {{ !empty($report_setting->is_monthly) && $report_setting->is_monthly == 1 ? 'checked' : '' }} />
                                            <label class="form-check-label f-w-600 pl-1"
                                                for="is_monthly">{{ __('Monthly') }}</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="modal-footer">
                                    <input type="submit" value="{{ __('Save Changes') }}" class="btn btn-primary">
                                </div>
                            </div>
                        </div>

                        {{ Form::close() }}
                    </div>


                    <div id="useradd-9" class="card">
                        {{ Form::open(['url' => route('cache.settings'), 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                        <div class="col-md-12">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <h5>{{ __('Cache Settings') }}</h5>
                                        <small
                                            class="text-secondary font-weight-bold">{{ __("This is a page meant for more advanced users, simply ignore it if you
                                                                      don't understand what cache is.") }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="col-lg-12">
                                    <div class="input-group search-form">
                                        <input type="text" value="{{ $file_size }}" class="form-control"
                                            disabled>
                                        <span class="input-group-text bg-transparent">MB</span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer m-3">
                                {{ Form::submit(__('Clear Cache'), ['class' => 'btn btn-print-invoice  btn-primary m-r-10']) }}
                            </div>

                            {{ Form::close() }}
                        </div>
                    </div>


                </div>
            </div>
        </div>
                    @endsection
@push('pre-purpose-script-page')
<script type="text/javascript">
    function enablecookie() {
       
        const element = $('#enable_cookie').is(':checked');
        $('.cookieDiv').addClass('disabledCookie');
        if (element==true) {
            $('.cookieDiv').removeClass('disabledCookie');
            $("#cookie_logging").prop('checked', true);
        } else {
            $('.cookieDiv').addClass('disabledCookie');
            $("#cookie_logging").prop('checked', false);
        }
    }
</script>
        <script type="text/javascript">
            $(document).ready(function()
            {
               cookie_inputs();
               frequency_status();
               show_download_link();

            });

            function frequency_status() {
                if ($('#email_notifiation').prop('checked')==true || $('#slack_notifiation').prop('checked')==true){ 
                       $('#frequency_block').css('display','');
                }
                else
                {
                    $('#frequency_block').css('display','none');
                }
                
                
            }
        </script>
        <script>
            var scrollSpy = new bootstrap.ScrollSpy(document.body, {
                target: '#useradd-sidenav',
                offset: 300
            })
        </script>
        <script>
            $(document).on("click", '.send_email', function(e) {

                e.preventDefault();
                var title = $(this).attr('data-title');

                var size = 'md';
                var url = $(this).attr('data-url');
                if (typeof url != 'undefined') {
                    $("#exampleModal .modal-title").html(title);
                    $("#exampleModal .modal-dialog").addClass('modal-' + size);
                    $("#exampleModal").modal('show');

                    $.post(url, {
                        mail_driver: $("#mail_driver").val(),
                        mail_host: $("#mail_host").val(),
                        mail_port: $("#mail_port").val(),
                        mail_username: $("#mail_username").val(),
                        mail_password: $("#mail_password").val(),
                        mail_encryption: $("#mail_encryption").val(),
                        mail_from_address: $("#mail_from_address").val(),
                        mail_from_name: $("#mail_from_name").val(),
                        _token: '{{ csrf_token() }}'
                    }, function(data) {
                        $('#exampleModal .modal-body').html(data);
                    });
                }
            });
            $(document).on('submit', '#test_email', function(e) {
                e.preventDefault();
                $("#email_sending").show();
                var post = $(this).serialize();
                console.log(post);

                var url = $(this).attr('action');
                $.ajax({
                    type: "post",
                    url: url,
                    data: post,
                    cache: false,
                    beforeSend: function() {
                        $('#test_smtp.mailtrap.iosmtp.mailtrap.io.btn-create').attr('disabled', 'disabled');
                    },
                    success: function(data) {
                        if (data.is_success) {
                            toastrs('Success', data.message, 'success');
                        } else {
                            toastrs('Error', data.message, 'error');
                        }
                        $("#email_sending").hide();
                    },
                    complete: function() {
                        $('#test_email .btn-create').removeAttr('disabled');
                    },
                });
            })
        </script>


       

        <script>
            var scrollSpy = new bootstrap.ScrollSpy(document.body, {
                target: '#useradd-sidenav',
                offset: 300,
            })
            $(".list-group-item").click(function() {
                $('.list-group-item').filter(function() {
                    return this.href == id;
                }).parent().removeClass('text-primary');
            });

            // function check_theme(color_val) {
            //     $('#theme_color').prop('checked', false);
            //     $('input[value="' + color_val + '"]').prop('checked', true);
            // }

            $(document).on('change', '[name=storage_setting]', function() {
                if ($(this).val() == 's3') {
                    $('.s3-setting').removeClass('d-none');
                    $('.wasabi-setting').addClass('d-none');
                    $('.local-setting').addClass('d-none');
                } else if ($(this).val() == 'wasabi') {
                    $('.s3-setting').addClass('d-none');
                    $('.wasabi-setting').removeClass('d-none');
                    $('.local-setting').addClass('d-none');
                } else {
                    $('.s3-setting').addClass('d-none');
                    $('.wasabi-setting').addClass('d-none');
                    $('.local-setting').removeClass('d-none');
                }
            });
        </script>

<script>
    function check_theme(color_val) {
        $('body').removeClass($(".theme_color:checked").val());
        $('body').addClass(color_val);

        $('input[value="' + color_val + '"]').prop('checked', true);
        $('input[value="' + color_val + '"]').attr('checked', true);
        $('a[data-value]').removeClass('active_color');
        $('a[data-value="' + color_val + '"]').addClass('active_color');
    }
</script>
        <script src="{{ asset('assets/js/jscolor.js') }} "></script>

        <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
        <script>
            if ($(".multi-select").length > 0) {
                $($(".multi-select")).each(function(index, element) {
                    var id = $(element).attr('id');
                    var multipleCancelButton = new Choices(
                        '#' + id, {
                            removeItemButton: true,
                        }
                    );
                });
            }

            var textRemove = new Choices(
                document.getElementById('choices-text-remove-button'), {
                    delimiter: ',',
                    editItems: true,
                    maxItemCount: 5,
                    removeItemButton: true,
                }
            );
        </script>

<script>

    $(document).ready(function() {
        cust_darklayout();
            $('#cust-darklayout').trigger('cust-darklayout');
        });
        
        function cust_darklayout() {
        
            var custdarklayout = document.querySelector("#cust-darklayout");
            custdarklayout.addEventListener("click", function() {
                if (custdarklayout.checked) {
                    document
                        .querySelector("#main-style-link")
                        .setAttribute("href", "{{ asset('assets/css/style-dark.css') }}");
                } else {
                    document
                        .querySelector("#main-style-link")
                        .setAttribute("href", "{{ asset('assets/css/style.css') }}");
                }
            });
            }
    </script>

<script>

    $(document).ready(function() {
        cust_theme_bg();
            $('#cust-theme-bg').trigger('cust-theme-bg');
        });
        
        function cust_theme_bg() {
        
            var custthemebg = document.querySelector("#cust-theme-bg");
            custthemebg.addEventListener("click", function() {
                if (custthemebg.checked) {
                        document.querySelector(".dash-sidebar").classList.add("transprent-bg");
                        document
                            .querySelector(".dash-header:not(.dash-mob-header)")
                            .classList.add("transprent-bg");
                    } else {
                        document.querySelector(".dash-sidebar").classList.remove("transprent-bg");
                        document
                            .querySelector(".dash-header:not(.dash-mob-header)")
                            .classList.remove("transprent-bg");
                    }
            });
            }
    </script>
    @endpush
