<?php
    
    $users = \Auth::user();
    
    $logos_path = \App\Models\Utility::get_file('logo/');
    $logos=url('/').$logos_path;
    $setting = App\Models\Utility::colorset();
    $meta_img = \App\Models\Utility::getValByName('meta_image');

    $SITE_RTL = App\Models\Utility::getValByName('SITE_RTL');
    $settings = App\Models\Utility::settings();
    $color = 'theme-3';
    if (!empty($settings['color'])) {
        $color = $settings['color'];
    }
    $logo = \App\Models\Utility::get_superadmin_logo();
    
    $footer_text = isset(\App\Models\Utility::settings()['footer_text']) ? \App\Models\Utility::settings()['footer_text'] : 'AnalyseGo';
    $meta_setting = App\Models\Utility::settings();


    
    $logo_path = \App\Models\Utility::get_file('logo/');
    $logo=url($logo_path);

     $dark_logo = \App\Models\Utility::CompanySetting('dark_logo');
     $light_logo = \App\Models\Utility::CompanySetting('light_logo');
     $company_favicon = \App\Models\Utility::CompanySetting('company_favicon');

?>

<!DOCTYPE html>

<html lang="en" dir="<?php echo e($SITE_RTL == 'on' ? 'rtl' : ''); ?>">

<head>
    <meta charset="utf-8">
    <!-- Primary Meta Tags -->
    
    <meta name="title" content="<?php echo e($meta_setting['meta_keywords']); ?>">
    <meta name="description" content="<?php echo e($meta_setting['meta_description']); ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://demo.rajodiya.com/analyticsgo/">
    <meta property="og:title" content="<?php echo e($meta_setting['meta_keywords']); ?>">
    <meta property="og:description" content="<?php echo e($meta_setting['meta_description']); ?>">
    <meta property="og:image" content="<?php echo e($logos . (isset($meta_img) && !empty($meta_img) ? $meta_img : 'meta-image.png')); ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://demo.rajodiya.com/analyticsgo/">
    <meta property="twitter:title" content="<?php echo e($meta_setting['meta_keywords']); ?>">
    <meta property="twitter:description" content="<?php echo e($meta_setting['meta_description']); ?>">
    <meta property="twitter:image" content="<?php echo e($logos . (isset($meta_img) && !empty($meta_img) ? $meta_img : 'meta-image.png')); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

    <link rel="icon"
        href="<?php echo e($logos . (isset($company_favicon['company-favicon']) && !empty($company_favicon['company-favicon']) ? $company_favicon['company-favicon'] : 'favicon.png')); ?>"
        type="image/x-icon" />
    <title>
        <?php echo e(\App\Models\Utility::getValByName('header_text') ? \App\Models\Utility::getValByName('header_text') : config('app.name', 'AnalyticsGo')); ?>

        - <?php echo $__env->yieldContent('page-title'); ?></title>

    

    <!-- font css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/tabler-icons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/material.css')); ?>">

    <!-- vendor css -->

    <?php if($SITE_RTL == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-rtl.css')); ?>">
    <?php endif; ?>
    <?php if(isset($settings['cust_darklayout']) && $settings['cust_darklayout'] == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-dark.css')); ?>">
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <?php endif; ?>



    <style type="text/css">
        [dir="rtl"] .ms-auto {
            margin-left: 10px !important;
        }
    </style>

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/customizer.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('custom/css/custom.css')); ?>">
</head>

<body class="<?php echo e($color); ?>">
    <div class="auth-wrapper auth-v3">
        <div class="bg-auth-side bg-primary"></div>
        <div class="auth-content">
            <nav class="navbar navbar-expand-md navbar-light default">
                <div class="container-fluid pe-2">
                    <a class="navbar-brand" href="#">
                        
                        
                        <?php if(isset($settings['cust_darklayout']) && $settings['cust_darklayout'] == 'on'): ?>
                        <img src="<?php echo e($logo . '/' . (isset($light_logo['company_dark_logo']) && !empty($light_logo['company_light_logo']) ? $light_logo['company_light_logo']. '?'.time() : 'logo-light.png'. '?'.time())); ?>" alt="<?php echo e(config('app.name', 'Google Analytics')); ?>">
                        <?php else: ?>
                        <img src="<?php echo e($logo . '/' . (isset($dark_logo['company_dark_logo']) && !empty($dark_logo['company_dark_logo']) ? $dark_logo['company_dark_logo'] . '?'.time(): 'logo-dark.png'. '?'.time())); ?>" alt="<?php echo e(config('app.name', 'Google Analytics')); ?>">
                        <?php endif; ?>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                        <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" href="#"><?php echo e(__('Support')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><?php echo e(__('Terms')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><?php echo e(__('Privacy')); ?></a>
                            </li>
                            <li class="nav-item">
                                <?php echo $__env->yieldContent('lang-selectbox'); ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <?php echo $__env->yieldContent('content'); ?>
            <div class="auth-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6">
                            
                            <p class=""><?php echo e($footer_text); ?> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->yieldPushContent('custom-scripts'); ?>


    <script src="<?php echo e(asset('assets/js/vendor-all.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/feather.min.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>

    <script>
        feather.replace();
    </script>

    <script>
        feather.replace();
        var pctoggle = document.querySelector("#pct-toggler");
        if (pctoggle) {
            pctoggle.addEventListener("click", function() {
                if (
                    !document.querySelector(".pct-customizer").classList.contains("active")
                ) {
                    document.querySelector(".pct-customizer").classList.add("active");
                } else {
                    document.querySelector(".pct-customizer").classList.remove("active");
                }
            });
        }

        var themescolors = document.querySelectorAll(".themes-color > a");
        for (var h = 0; h < themescolors.length; h++) {
            var c = themescolors[h];

            c.addEventListener("click", function(event) {
                var targetElement = event.target;
                if (targetElement.tagName == "SPAN") {
                    targetElement = targetElement.parentNode;
                }
                var temp = targetElement.getAttribute("data-value");
                removeClassByPrefix(document.querySelector("body"), "theme-");
                document.querySelector("body").classList.add(temp);
            });
        }




        function removeClassByPrefix(node, prefix) {
            for (let i = 0; i < node.classList.length; i++) {
                let value = node.classList[i];
                if (value.startsWith(prefix)) {
                    node.classList.remove(value);
                }
            }
        }
    </script>
</body>
<?php echo $__env->make('layouts.cookie_consent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</html>
<?php /**PATH /var/www/vhosts/vps-m2-srv45.nl/anajob.webmojo.online/resources/views/layouts/auth.blade.php ENDPATH**/ ?>