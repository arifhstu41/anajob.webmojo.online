<?php
$logo = $mode_setting = \App\Models\Utility::mode_layout();

$setting = \App\Models\Utility::colorset();
$avatar_path = \App\Models\Utility::get_file('avatars');
$avatar=url($avatar_path).'/';
//$locationsetting = \App\Models\Utility::LocationSetting();
$SITE_RTL= 'off';
$mode_setting = \App\Models\Utility::settings();
?>
<?php if(isset($mode_setting['cust_theme_bg']) && $mode_setting['cust_theme_bg'] == 'on' || $SITE_RTL =='on'): ?>
    <header class="dash-header transprent-bg">
<?php else: ?>
    <header class="dash-header">
<?php endif; ?>
    <div class="header-wrapper">
        <div class="me-auto dash-mob-drp">
            <ul class="list-unstyled">
                <li class="dash-h-item mob-hamburger">
                    <a href="#!" class="dash-head-link" id="mobile-collapse">
                        <div class="hamburger hamburger--arrowturn">
                            <div class="hamburger-box">
                                <div class="hamburger-inner"></div>
                            </div>
                        </div>
                    </a>
                </li>

                <li class="dropdown dash-h-item drp-company">
                    <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">

                        <img class="theme-avtar"
                        src="<?php echo e(!empty(\Auth::user()->avatar) ? $avatar . \Auth::user()->avatar : $avatar.'/avatar.png'); ?>"></span>
                        <span class="hide-mob ms-2"><?php echo e($users->name); ?></span>
                        <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                    </a>
                    <div class="dropdown-menu dash-h-dropdown">
                        <a href="<?php echo e(route('my.account')); ?>" class="dropdown-item">
                            <i class="ti ti-user"></i>
                            <span><?php echo e(__('Profile')); ?></span>
                        </a>
                        <a href="<?php echo e(route('logout')); ?>" class="dropdown-item">
                          <i class="ti ti-power"></i>
                          <span><?php echo e(__('Logout')); ?></span>
                        </a>
                    </div>
                </li>

            </ul>
        </div>
        <div class="ms-auto">
            <ul class="list-unstyled">
               
                <li class="dropdown dash-h-item drp-language">
                    <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ti ti-world nocolor"></i>
                        <?php $__currentLoopData = \App\Models\Utility::languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="drp-text hide-mob" style="margin-left: 2px;"><?php echo e($currantLang == $code ? Str::ucfirst($lang) : ''); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                    </a>
                    <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                       
                        <?php if( \Auth::user()->user_type == 'company' || Auth::user()->user_type != ''): ?>
                            <?php $__currentLoopData = \App\Models\Utility::languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('change_lang_admin', $code)); ?>"
                                    class="dropdown-item <?php echo e($currantLang == $code ? 'text-danger' : ''); ?>">
                                    <span class="small"><?php echo e(Str::ucfirst($lang)); ?></span>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php endif; ?>

                        <?php if(\Auth::user()->user_type == 'company'): ?>
                            <a href="#" class="dropdown-item text-primary" data-size="md" data-url="<?php echo e(route('create.language')); ?>" data-bs-toggle="modal" data-bs-target="#exampleoverModal"
                            data-bs-whatever="<?php echo e(__('Create New Language')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Create Language')); ?>"
                            data-bs-original-title="<?php echo e(__('Create New Language')); ?>">
                                <span> <?php echo e(__('Create Language')); ?></span>
                            </a>
                        <?php endif; ?>

                        <?php if(\Auth::user()->user_type == 'company'): ?>
                            <a href="<?php echo e(route('manage.language', [$currantLang])); ?>"
                                class="dropdown-item text-primary">
                                <span> <?php echo e(__('Manage Language')); ?></span>
                            </a>
                        <?php endif; ?>

                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
<?php /**PATH /var/www/vhosts/vps-m2-srv45.nl/anajob.webmojo.online/resources/views/partials/header.blade.php ENDPATH**/ ?>