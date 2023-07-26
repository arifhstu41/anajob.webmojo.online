<?php


$logos_path=\App\Models\Utility::get_file('logo');
$logos=url('/').$logos_path;
$favicon = \App\Models\Utility::getValByName('favicon');


$company_favicon = \App\Models\Utility::getValByName('company_favicon');


$title_text = \App\Models\Utility::getValByName('title_text');
$settings = App\Models\Utility::colorset();
$SITE_RTL='OFF';
$color = 'theme-3';
if (!empty($setting['color'])) {
    $color = $setting['color'];
}
$mode_setting = \App\Models\Utility::settings();
?>
<head>
    <title> @yield('page-title') -
        {{ \App\Models\Utility::getValByName('header_text') ? \App\Models\Utility::getValByName('header_text') : config('app.name', 'AnalyseGo SaaS') }}
    </title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Dashboard Template Description" />
    <meta name="keywords" content="Dashboard Template" />
    <meta name="author" content="Rajodiya Infotech" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Favicon icon -->
    <link rel="icon" href="{{ $logos . '/' . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png') }}"type="image/x-icon" />  
    <!--calendar-->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/main.css') }}">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" integrity="sha512-gp+RQIipEa1X7Sq1vYXnuOW96C4704yI1n0YB9T/KqdvqaEgL6nAuTSrKufUX3VBONq/TPuKiXGLVgBKicZ0KA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
     <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    @stack('pre-purpose-css-page')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}">
    {{-- @dd(env('SITE_RTL') ) --}}
    @if (env('SITE_RTL') == 'on')
        <link rel="stylesheet" href="{{ asset('css/bootstrap-rtl.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
    @endif
    @if (!empty($settings['cust_darklayout']) && $settings['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/animate.min.css') }}" />
    <!--bootstrap switch-->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/custom/css/custom.css') }}">
</head>
<body class="sidenav-pinned ready {{$color}}">

@if (isset($mode_setting['cust_theme_bg']) && $mode_setting['cust_theme_bg'] == 'on' || $SITE_RTL =='on')
    <header class="dash-header transprent-bg">
@else
    <header class="dash-header">
@endif
        <div class="header-wrapper">
            <div class="me-auto dash-mob-drp">
                <ul class="list-unstyled">
                   
                    <li class="dropdown dash-h-item drp-company">
                        <a class="" href="#" aria-haspopup="false" aria-expanded="false">
                            <img class="hweb" alt="Image placeholder" src="{{asset(Storage::url('logo/')).'/'.(isset($companySettings['company_logo']) && !empty($companySettings['company_logo'])?$companySettings['company_logo']->value:'logo-dark.png')}}" id="navbar-logo" >
                                
                        </a>
                        
                    </li>

                </ul>
            </div>
            <div class="ms-auto">
                <ul class="list-unstyled">
                   
                    <li class="dropdown dash-h-item drp-language">
                        <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ti ti-world nocolor"></i>
                            <span class="drp-text hide-mob">{{ Str::upper($currantLang) }}</span>
                            <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                        </a>
                        <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                             @yield('lang-section')
                                
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>

<div class="dash-container" style="margin-left: auto;">
    <div class="dash-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3 mb-sm-0">
                            <div class="">
                                <h4 class="m-b-10"> @yield('page-title')</h4>
                                <ul class="breadcrumb">
                                     @yield('breadcrumb')
                                             
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <div class="row">
           @yield('content')
        </div>
    </div>
</div>

<footer class="dash-footer">
    <div class="footer-wrapper">
        <div class="py-1">
            <span class="text-muted">  {{(\App\Models\Utility::getValByName('footer_text')) ? \App\Models\Utility::getValByName('footer_text') :  __('Copyright AnalyseGo') }}</span>
        </div>

    </div>
</footer>

<input type="hidden" id="path_admin" value="{{url('/')}}">
<script src="{{asset('js/admin.js?v=dgfdsf')}}"></script>
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="{{asset('assets/vendor/moment/min/moment.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer=""></script>
<script src="{{asset('assets/js/plugins/apexcharts.min.js')}}"></script>
<script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/dash.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<link rel="stylesheet" href="{{asset('assets/vendor/jvectormap-next/jquery-jvectormap.css')}}">
<script src="{{asset('assets/vendor/jvectormap-next/jquery-jvectormap.min.js')}}"></script>
<script src="{{asset('assets/vendor/jvectormap-next/jquery-jvectormap-world-mill.js')}}"></script>
<script src="{{asset('assets/vendor/chart.js/dist/Chart.min.js')}}"></script>
<script src="{{asset('assets/vendor/chart.js/dist/Chart.extension.js')}}"></script>


{{-- <script src="{{ asset('js/letter.avatar.js')}}"></script> --}}
@stack('pre-purpose-script-page')
{{-- FullCalendar --}}
<script src="{{ asset('assets/js/plugins/main.min.js') }}"></script>

<!-- sweet alert Js -->
<script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>


<!--Botstrap switch-->
<script src="{{ asset('assets/js/plugins/bootstrap-switch-button.min.js') }}"></script>

{{-- DataTable --}}
<script src="{{ asset('assets/js/plugins/simple-datatables.js') }}"></script>
<script src="{{ asset('js/jquery.form.js') }}"></script>

<script>
    if ($("#pc-dt-simple").length) {
        const dataTable = new simpleDatatables.DataTable("#pc-dt-simple");
    }
</script>
<script type="text/javascript">

    $(function () {
      
       var siteid = $('#current_site').attr('data-siteid');
     
        if ($('#usersChart').length) {
            get_chart_data("get_user_data","year",siteid);
        }
        if ($('#bounceRateChart').length) {
            get_chart_data("bounceRateChart","year",siteid);
        }
        if ($('#sessionDuration').length) {
            get_chart_data("sessionDuration","year",siteid);
        }
        if ($('#session_by_device').length) {
            get_chart_data("session_by_device","year",siteid);
        }
        if ($('#user-timeline-chart-year').length) {
            get_chart_data("user-timeline-chart","year",siteid);
        }
         if ($('#user-timeline-chart-month').length) {
            get_chart_data("user-timeline-chart","15daysago",siteid);
        }
        if ($('#user-timeline-chart-week').length) {
            get_chart_data("user-timeline-chart","week",siteid);
        }
        if ($('#live_users').length > 0) {
            get_live_user(siteid);
        }
        if ($('#active_pages').length > 0) {
            get_active_pages(siteid);
        }
        if ($('.mapcontainer').length) {
            get_chart_data("mapcontainer","year",siteid);
        }


    });
    
     function map_chart(data) {
           $('.mapcontainer').vectorMap({
                map: 'world_mill_en',
                scaleColors: ['#6fd943', '#000'],
                normalizeFunction: 'polynomial',
                focusOn: {
                    x: 5,
                    y: 1,
                    scale: .85
                },
                zoomOnScroll: false,
                zoomMin: 0.65,
                hoverColor: false,
                regionStyle: {
                    initial: {
                        fill: '#6fd943',
                        "fill-opacity": 1,
                        stroke: '#000',
                        "stroke-width": 0,
                        "stroke-opacity": 0
                    },
                    hover: {
                        "fill-opacity": 0.6
                    }
                },
                markerStyle: {
                    initial: {
                        fill: '#6fd943',
                        stroke: '#9dac97',
                        "fill-opacity": 1,
                        "stroke-width": 6,
                        "stroke-opacity": 0.8,
                        r: 3
                    },
                    hover: {
                        stroke: '#000',
                        "stroke-width": 10
                    },
                    selected: {
                        fill: 'blue'
                    },
                    selectedHover: {}
                },
                backgroundColor: '#ffffff',
                markers:data
            });
            
        }
    
  </script>
  @push('script-page')

       
    </script>
    @endpush
<script>
    if ($(".pc-dt-simple").length > 0) {
        $($(".pc-dt-simple")).each(function(index, element) {
            var id = $(element).attr('id');
            const dataTable = new simpleDatatables.DataTable("#" + id);
        });
    }
</script>




<script>
    var timer = '';
    var timzone = '{{ env('TIMEZONE') }}';



    function minTwoDigits(n) {
        return (n < 10 ? '0' : '') + n;
    }

    function changeTimezone(date, ianatz) {

        var invdate = new Date(date.toLocaleString('en-US', {
            timeZone: ianatz
        }));
        var diff = date.getTime() - invdate.getTime();
        return new Date(date.getTime() - diff);

    }

    function toastrs(title, message, type) {
        var o, i;
        var icon = '';
        var cls = '';
        if (type == 'success') {
            icon = 'fas fa-check-circle';
            // cls = 'success';
            cls = 'primary';
        } else {
            icon = 'fas fa-times-circle';
            cls = 'danger';
        }

        $.notify({
            icon: icon,
            title: " " + title,
            message: message,
            url: ""
        }, {
            element: "body",
            type: cls,
            allow_dismiss: !0,
            placement: {
                from: 'top',
                align: 'right'
            },
            offset: {
                x: 15,
                y: 15
            },
            spacing: 10,
            z_index: 1080,
            delay: 2500,
            timer: 2000,
            url_target: "_blank",
            mouse_over: !1,
            animate: {
                enter: o,
                exit: i
            },
            // danger
            template: '<div class="toast text-white bg-' + cls +
                ' fade show" role="alert" aria-live="assertive" aria-atomic="true">' +
                '<div class="d-flex">' +
                '<div class="toast-body"> ' + message + ' </div>' +
                '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>' +
                '</div>' +
                '</div>'
            
        });
    }
</script>


