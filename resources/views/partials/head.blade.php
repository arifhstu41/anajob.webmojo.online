<?php



 $logo_path = \App\Models\Utility::get_file('logo');
 $logos=url($logo_path).'/';


 $company_favicon = \App\Models\Utility::CompanySetting('company_favicon');
$meta_img = \App\Models\Utility::getValByName('meta_image');
$meta_setting = App\Models\Utility::settings();


$title_text = \App\Models\Utility::getValByName('title_text');
$settings = App\Models\Utility::colorset();

$color = 'theme-3';
if (!empty($setting['color'])) {
    $color = $setting['color'];
}
?>
<head>


    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-13J1NE912P"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-13J1NE912P');
    </script>

    <!-- Primary Meta Tags -->

    <meta name="title" content="{{$meta_setting['meta_keywords']}}">
    <meta name="description" content="{{$meta_setting['meta_description']}}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://demo.rajodiya.com/analyticsgo/">
    <meta property="og:title" content="{{$meta_setting['meta_keywords']}}">
    <meta property="og:description" content="{{$meta_setting['meta_description']}}">
    <meta property="og:image" content="{{ $logos . (isset($meta_img) && !empty($meta_img) ? $meta_img : 'meta-image.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://demo.rajodiya.com/analyticsgo/">
    <meta property="twitter:title" content="{{$meta_setting['meta_keywords']}}">
    <meta property="twitter:description" content="{{$meta_setting['meta_description']}}">
    <meta property="twitter:image" content="{{ $logos . (isset($meta_img) && !empty($meta_img) ? $meta_img : 'meta-image.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Favicon icon -->
    <link rel="icon" href="{{ $logos . (isset($company_favicon['company-favicon']) && !empty($company_favicon['company-favicon']) ? $company_favicon['company-favicon'] : 'favicon.png') }}"type="image/x-icon" />

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/main.css') }}">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" integrity="sha512-gp+RQIipEa1X7Sq1vYXnuOW96C4704yI1n0YB9T/KqdvqaEgL6nAuTSrKufUX3VBONq/TPuKiXGLVgBKicZ0KA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
    <script src="{{asset('js/jquery-1.11.0.min.js')}}"></script>

    @stack('pre-purpose-css-page')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}">
    {{-- @dd(env('SITE_RTL') ) --}}
    @if (env('SITE_RTL') == 'on')
        <link rel="stylesheet" href="{{ asset('css/bootstrap-rtl.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
    @endif
{{--
    @if (!empty($settings['cust_darklayout']) && $settings['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @endif --}}

    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/dropzone.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/animate.min.css') }}" />

    <!--bootstrap switch-->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">

    <link rel="stylesheet" href="{{ asset('public/custom/css/custom.css') }}">
     <style type="text/css">
    .big-logo{
        width:160px;
        height:40px;
    }
    .logo_card {
        min-height: 280px;
    }
</style>

</head>
