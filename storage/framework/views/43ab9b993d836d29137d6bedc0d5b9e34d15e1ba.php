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
<?php if(isset($mode_setting['cust_theme_bg']) && $mode_setting['cust_theme_bg'] == 'on'): ?>
    <nav class="dash-sidebar light-sidebar transprent-bg">
    <?php else: ?>
        <nav class="dash-sidebar light-sidebar">
<?php endif; ?>

<div class="navbar-wrapper">
    <div class="m-header main-logo">
        <a href="#" class="b-brand">
            <!-- ========   change your logo hear   ======= -->
           
            <?php if(\Auth::user()->user_type == 'company'): ?>
                <?php if(!empty($mode_setting['cust_darklayout']) && $mode_setting['cust_darklayout'] == 'on'): ?>
                    <img src="<?php echo e($logo . '/' . (isset($light_logo['company_dark_logo']) && !empty($light_logo['company_light_logo']) ? $light_logo['company_light_logo']. '?'.time() : 'logo-light.png'. '?'.time())); ?>"
                    width="170px" alt="<?php echo e(config('app.name', 'Google Analytics')); ?>" class="logo logo-lg">
                <?php else: ?>
                    <img src="<?php echo e($logo . '/' . (isset($dark_logo['company_dark_logo']) && !empty($dark_logo['company_dark_logo']) ? $dark_logo['company_dark_logo'] . '?'.time(): 'logo-dark.png'. '?'.time())); ?>"
                    width="170px" alt="<?php echo e(config('app.name', 'Google Analytics')); ?>" class="logo logo-lg">
                <?php endif; ?>
            <?php else: ?>
                <img src="<?php echo e($logos . '' . (isset($company_dark_logo) && !empty($company_dark_logo) ? $company_dark_logo . '?'.time(): 'logo-dark.png'. '?'.time())); ?>"
                    alt="<?php echo e(config('app.name', 'Google Analytics')); ?>" class="logo logo-lg">
            <?php endif; ?>
        </a>
    </div>
    <div class="navbar-content">
         <ul class="dash-navbar">
            <li class="dash-item  dash-hasmenu">
              <a href="<?php echo e(route('dashboard')); ?>" class="dash-link <?php echo e((Request::route()->getName() == 'dashboard' 
              ) ? ' active' : ''); ?>">
                <span class="dash-micon">
                  <i class="ti ti-home"></i>
                </span>
                <span class="dash-mtext"><?php echo e(__('Dashboard')); ?></span>
              </a>
            </li>
            
            
            <?php if(\Auth::user()->can('manage user')): ?>
            <li class="dash-item  dash-hasmenu">
              <a href="<?php echo e(route('users')); ?>" class="dash-link <?php echo e((Request::route()->getName() == 'users' 
              ) ? ' active' : ''); ?>">
                <span class="dash-micon">
                  <i class="ti ti-user"></i>
                </span>
                <span class="dash-mtext"><?php echo e(__('Users')); ?></span>
              </a>
            </li>
            <?php endif; ?>
            <?php if(\Auth::user()->can('manage role')): ?>
            <li class="dash-item  dash-hasmenu">
              <a href="<?php echo e(route('roles.index')); ?>" class="dash-link <?php echo e((Request::route()->getName() == 'roles' 
              ) ? ' active' : ''); ?>">
                <span class="dash-micon">
                  <i class="ti ti-share"></i>
                </span>
                <span class="dash-mtext"><?php echo e(__('Role')); ?></span>
              </a>
            </li>
            <?php endif; ?>
            <?php if(\Auth::user()->can('show quick view')): ?>
            <li class="dash-item  dash-hasmenu">
              <a href="<?php echo e(url('quick-view/0')); ?>" class="dash-link <?php echo e((Request::route()->getName() == 'quick-view' 
              ) ? ' active' : ''); ?>">
                <span class="dash-micon">
                  <i class="ti ti-layers-difference"></i>
                </span>
                <span class="dash-mtext"><?php echo e(__('Quick View')); ?></span>
              </a>
            </li>
            <?php endif; ?>
            <?php if(\Auth::user()->can('manage widget')): ?>
            <li class="dash-item  dash-hasmenu">
              <a href="<?php echo e(route('widget')); ?>" class="dash-link <?php echo e((Request::route()->getName() == 'widget' 
              ) ? ' active' : ''); ?>">
                <span class="dash-micon">
                 <i class="ti ti-layout-2"></i>
                </span>
                <span class="dash-mtext"><?php echo e(__('Widget')); ?></span>
              </a>
            </li>
            <?php endif; ?>
            <?php if(\Auth::user()): ?>
            <li class="dash-item  dash-hasmenu">
              <a href="<?php echo e(url('site-standard/0')); ?>" class="dash-link <?php echo e((Request::route()->getName() == 'site-standard' 
              ) ? ' active' : ''); ?>">
                <span class="dash-micon">
                  <i data-feather="layers"></i>
                </span>
                <span class="dash-mtext"><?php echo e(__('Standard')); ?></span>
              </a>
            </li>
            <?php endif; ?>
            <?php if(\Auth::user()->can('show analytic') || \Auth::user()->can('show channel analytic')|| \Auth::user()->can('show audience analytic')|| \Auth::user()->can('show pages analytic')|| \Auth::user()->can('show seo analytic')): ?>
            <li class="dash-item dash-hasmenu">
              <a href="#!" class="dash-link"
                ><span class="dash-micon"><i class="ti ti-box"></i></span
                ><span class="dash-mtext"><?php echo e(__('Analytics')); ?></span
                ><span class="dash-arrow"><i data-feather="chevron-right"></i></span
              ></a>
              <ul class="dash-submenu">
                <?php if(\Auth::user()->can('show channel analytic')): ?>
                <li class="dash-item">
                  <a href="<?php echo e(route('channel')); ?>" class="dash-link <?php echo e((Request::route()->getName() == 'channel' 
              ) ? ' active' : ''); ?>"><?php echo e(__('Channel')); ?></a>
                </li>
                <?php endif; ?>
                <?php if(\Auth::user()->can('show audience analytic')): ?>
                <li class="dash-item">
                  <a href="<?php echo e(route('audience')); ?>" class="dash-link <?php echo e((Request::route()->getName() == 'audience' 
              ) ? ' active' : ''); ?>"><?php echo e(__('Audience')); ?></a>
                </li>
                <?php endif; ?>
                <?php if(\Auth::user()->can('show pages analytic')): ?>
                <li class="dash-item">
                  <a href="<?php echo e(route('page')); ?>" class="dash-link <?php echo e((Request::route()->getName() == 'page' 
              ) ? ' active' : ''); ?>"><?php echo e(__('Pages')); ?></a>
                </li>
                <?php endif; ?>
                <?php if(\Auth::user()->can('show seo analytic')): ?>
                <li class="dash-item">
                  <a href="<?php echo e(route('seo-analysis')); ?>" class="dash-link <?php echo e((Request::route()->getName() == 'seo-analysis' 
              ) ? ' active' : ''); ?>"><?php echo e(__('SEO')); ?></a>
                </li>
                <?php endif; ?>
              </ul>
            </li>
            <?php endif; ?>

            <?php if(\Auth::user()->can('show custom analytic')): ?>
            <li class="dash-item  dash-hasmenu">
              <a href="<?php echo e(url('custom-dashboard')); ?>" class="dash-link <?php echo e((Request::route()->getName() == 'custom-dashboard' 
              ) ? ' active' : ''); ?>">
                <span class="dash-micon">
                  <i data-feather="layers"></i>
                </span>
                <span class="dash-mtext"><?php echo e(__('Custom')); ?></span>
              </a>
            </li>
            <?php endif; ?>

             <?php if(\Auth::user()): ?>

            <li class="dash-item dash-hasmenu">
              <a href="#!" class="dash-link"
                ><span class="dash-micon"><i class="ti ti-box"></i></span
                ><span class="dash-mtext"><?php echo e(__('Alerts')); ?></span
                ><span class="dash-arrow"><i data-feather="chevron-right"></i></span
              ></a>
              <ul class="dash-submenu">
              
                <li class="dash-item">
                  <a href="<?php echo e(route('aletr')); ?>" class="dash-link <?php echo e((Request::route()->getName() == 'aletr' 
              ) ? ' active' : ''); ?>"><?php echo e(__('Alerts')); ?></a>
                </li>
               
                <li class="dash-item">
                  <a href="<?php echo e(route('aletr-history')); ?>" class="dash-link <?php echo e((Request::route()->getName() == 'aletr-history' 
              ) ? ' active' : ''); ?>"><?php echo e(__('History')); ?></a>
                </li>
             
                
              </ul>
            </li>
            <li class="dash-item  dash-hasmenu">
              <a href="<?php echo e(url('report/history')); ?>" class="dash-link <?php echo e((Request::route()->getName() == 'report/history' 
              ) ? ' active' : ''); ?>">
                <span class="dash-micon">
                  <i class="ti ti-file-invoice"></i>
                </span>
                <span class="dash-mtext"><?php echo e(__('Report')); ?></span>
              </a>
            </li>
            <?php endif; ?>
             

            <?php if(\Auth::user()->user_type == 'company'): ?>
            <?php echo $__env->make('landingpage::menu.landingpage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>  

            
            <?php if(\Auth::user()->user_type == 'company'): ?>
            <li class="dash-item  dash-hasmenu">
              <a href="<?php echo e(route('company.settings')); ?>" class="dash-link <?php echo e((Request::route()->getName() == 'company.settings' 
              ) ? ' active' : ''); ?>">
                <span class="dash-micon">
                  <i class="ti ti-settings"></i>
                </span>
                <span class="dash-mtext"><?php echo e(__('Settings')); ?></span>
              </a>
            </li>
             <?php endif; ?>
             

          </ul>
    </div>
</div>
</nav>
<!-- [ navigation menu ] end -->
<?php /**PATH /var/www/vhosts/vps-m2-srv45.nl/anajob.webmojo.online/resources/views/partials/menu.blade.php ENDPATH**/ ?>