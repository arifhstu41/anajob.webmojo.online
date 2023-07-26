<?php $ln=$lang;?>
@extends('layouts.auth')
@section('page-title')
    {{ __('Login') }}
@endsection
@push('custom-scripts')
@if(env('RECAPTCHA_MODULE') == 'yes')
{!! NoCaptcha::renderJs() !!}
@endif
@endpush


@section('lang-selectbox')
    <select class="btn btn-primary dropdown-toggle ms-2 me-2 language_option_bg" name="language" id="language"
        onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" style=" padding-right: 0px;padding-left: 0px;">
        @foreach (\App\Models\Utility::languages() as $code => $language)
        <?php $url= url('forgot-password/'.$code);?>

            <option @if ($lang == $code ) selected @endif value="{{$url}}">
                {{ Str::upper($language) }}</option>
                <?php  
                ?>
                
        @endforeach
    </select>

    
@endsection

@php
    $currantLang = basename(App::getLocale());
@endphp

@section('content')

<!-- [ auth-signup ] start -->
        <div class="card">
            <div class="row align-items-center text-start">
                <div class="col-xl-6">
                    <div class="card-body">
                        <div class="d-flex">
                            <h2 class="mb-3 f-w-600">{{ __('Reset Password') }}</h2>
                        </div>
                        {{Form::open(array('route'=>'password.email','method'=>'post','id'=>'loginForm','class'=> 'login-form'))}}
                        <input type="hidden" name="lang" value="{{$ln}}">
                        <div class="">
                            <div class="form-group mb-3">
                                <label class="form-label d-flex">{{ __('E-Mail') }}</label>
                                {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter Your Email')))}}
                                @error('email')
                                <span class="error invalid-email text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>
                        


                            
                            <div class="d-grid">
                                {{Form::submit(__('Send Password Reset Link'),array('class'=>'btn btn-primary btn-block mt-2','id'=>'saveBtn'))}}
                            </div>
                            {{ Form::close() }}

                           
                            <p class="my-4 text-center">{{ __('Back to') }}
                                
                                <a href="{{ url('login/'."$ln") }}" class="my-4 text-primary">{{ __('Sign In') }}</a>
                            </p>
                           
                        </div>

                    </div>
                </div>
                <div class="col-xl-6 img-card-side">
                    <div class="auth-img-content">
                        <img src="{{ asset('assets/images/auth/img-auth-3.svg') }}" alt="" class="img-fluid">
                        <h3 class="text-white mb-4 mt-5"> {{ __('“Attention is the new currency”') }}</h3>
                        <p class="text-white"> {{__('The more effortless the writing looks, the more effort the writer
                            actually put into the process.')}}</p>
                    </div>
                </div>
            </div>
        </div>  
<!-- [ auth-signup ] end -->

@endsection

