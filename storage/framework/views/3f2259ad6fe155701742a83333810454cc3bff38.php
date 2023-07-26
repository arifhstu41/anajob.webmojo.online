<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Settings')); ?>

<?php $__env->stopSection(); ?>
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


<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Settings')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top" style="top:30px">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <a href="#useradd-1"
                                class="list-group-item list-group-item-action border-0"><?php echo e(__('Brand Settings')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#useradd-2"
                                class="list-group-item list-group-item-action border-0"><?php echo e(__('System Settings')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#useradd-4"
                                class="list-group-item list-group-item-action border-0 "><?php echo e(__('Storage Settings')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#useradd-3"
                                class="list-group-item list-group-item-action border-0"><?php echo e(__('Email Settings')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#useradd-5" class="list-group-item list-group-item-action border-0"><?php echo e(__('SEO Settings')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#useradd-6" class="list-group-item list-group-item-action border-0"><?php echo e(__('Cookie Settings')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#useradd-7"
                                class="list-group-item list-group-item-action border-0"><?php echo e(__('Slack Settings')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                             <a href="#useradd-8"
                                class="list-group-item list-group-item-action border-0"><?php echo e(__('Report')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#useradd-9"
                                class="list-group-item list-group-item-action border-0"><?php echo e(__('Cache Settings')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div id="useradd-1" class="card">
                        <?php echo e(Form::open(['route' => ['company.settings.store'], 'method' => 'post', 'enctype' => 'multipart/form-data'])); ?>

                        <div class="card-header">
                            <h5><?php echo e(__('Brand Settings')); ?></h5>
                            <small class="text-muted"><?php echo e(__('Edit your brand details')); ?></small>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="card logo_card">
                                        <div class="card-header">
                                            <h5 class="small-title"><?php echo e(__('Light Logo')); ?></h5>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="setting-card">
                                                <div class="logo-content mt-4 text-center">
                                                    
                                                    <a href="<?php echo e($logo . '/' . (isset($light_logo['company_light_logo']) && !empty($light_logo['company_light_logo']) ? $light_logo['company_light_logo'] . '?'.time() : 'logo-light.png' . '?'.time())); ?>"
                                                        target="_blank"> <img id="light"
                                                            src="<?php echo e($logo . '/' . (isset($light_logo['company_light_logo']) && !empty($light_logo['company_light_logo']) ? $light_logo['company_light_logo'] . '?'.time(): 'logo-light.png' . '?'.time())); ?>" class="img_setting big-logo" > </a>

                                                </div>
                                                <div class="choose-files mt-5">
                                                    <label for="logo">
                                                        <div class=" bg-primary logo_update"> <i
                                                                class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?>

                                                            <input style="margin-top: -40px;" type="file"
                                                                class="form-control file" name="light_logo" id="light_logo"
                                                                data-filename="edit-light_logo" accept=".jpeg,.jpg,.png"
                                                                accept=".jpeg,.jpg,.png"
                                                                onchange="document.getElementById('light').src = window.URL.createObjectURL(this.files[0])">
                                                        </div>
                                                    </label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="col-sm-4">
                                    <div class="card logo_card">
                                        <div class="card-header">

                                            <h5><?php echo e(__('Dark Logo')); ?></h5>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="setting-card">
                                                <div class="logo-content mt-4 text-center">

                                                    <a href="<?php echo e($logo . '/' . (isset($dark_logo['company_dark_logo']) && !empty($dark_logo['company_dark_logo']) ? $dark_logo['company_dark_logo'] . '?'.time(): 'logo-dark.png'. '?'.time())); ?>"
                                                        target="_blank"> <img id="logo" class="big-logo" 
                                                            src="<?php echo e($logo . '/' . (isset($dark_logo['company_dark_logo']) && !empty($dark_logo['company_dark_logo']) ? $dark_logo['company_dark_logo'] . '?'.time(): 'logo-dark.png'. '?'.time())); ?>"> </a>

                                                </div>
                                                <div class="choose-files mt-5">
                                                    <label for="logo">
                                                        <div class=" bg-primary logo_update" style="width:180px;"> <i
                                                                class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?>

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
                                
                                <div class="col-lg-4 col-sm-6 col-md-6">
                                    <div class="card logo_card">
                                        <div class="card-header">
                                            <h5><?php echo e(__('Favicon')); ?></h5>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="setting-card text-center">
                                                <div class="logo-content mt-4">
                                                    <a href="<?php echo e($logo . '/' . (isset($company_favicon['company-favicon']) && !empty($company_favicon['company-favicon']) ? $company_favicon['company-favicon'] . '?'.time(): 'favicon.png'. '?'.time())); ?>"
                                                        target="_blank"><img
                                                            src="<?php echo e($logo . '/' . (isset($company_favicon['company-favicon']) && !empty($company_favicon['company-favicon']) ? $company_favicon['company-favicon']. '?'.time() : 'favicon.png'. '?'.time())); ?>"
                                                            width="50px" id="favicon" class=""></a>
                                                </div>
                                                <div class="choose-files mt-5">
                                                    <label for="logo">
                                                        <div class=" bg-primary logo_update" style="width:180px;"> <i
                                                                class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?>

                                                            <input style="margin-top: -40px;" type="file"
                                                                class="form-control file" name="company_favicon"
                                                                id="company_favicon" data-filename="edit-company_favicon"
                                                                accept=".jpeg,.jpg,.png" accept=".jpeg,.jpg,.png"
                                                                onchange="document.getElementById('favicon').src = window.URL.createObjectURL(this.files[0])">
                                                        </div>
                                                    </label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?php echo e(Form::label('header_text', __('Title Text'), ['class' => 'col-form-label text-dark'])); ?>

                                        <input class="form-control" placeholder="Title Text" name="header_text"
                                            type="text"
                                            value="<?php echo e(!empty($locations['header_text']) ? $locations['header_text'] : ''); ?>"
                                            id="header_text">
                                        <?php $__errorArgs = ['header_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-header_text" role="alert">
                                                <strong class="text-danger"><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?php echo e(Form::label('header_text', __('Footer Text'), ['class' => 'col-form-label text-dark'])); ?>

                                        <input class="form-control" placeholder="Title Text" name="footer_text"
                                            type="text"
                                            value="<?php echo e(!empty($locations['footer_text']) ? $locations['footer_text'] : ''); ?>"
                                            id="footer_text">
                                        <?php $__errorArgs = ['footer_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-footer_text" role="alert">
                                                <strong class="text-danger"><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="col-4 switch-width">
                                        <div class="form-group ml-2 mr-3 ">
                                            <?php echo e(Form::label('SITE_RTL', __('Enable RTL'), ['class' => 'col-form-label text-dark'])); ?>

                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" data-toggle="switchbutton" data-onstyle="primary"
                                                    class="" name="SITE_RTL" value="on" id="SITE_RTL"
                                                    <?php echo e($SITE_RTL == 'on' ? 'checked="checked"' : ''); ?>>
                                                <label class="custom-control-label" for="SITE_RTL"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <h4 class="small-title"><?php echo e(__('Theme Customizer')); ?></h4>
                                    <div class="setting-card setting-logo-box p-3">
                                        <div class="row">
                                            <div class="pct-body">
                                                <div class="row">
                                                    <div class="col-lg-4 col-xl-4 col-md-4">
                                                        <h6 class="mt-2">
                                                            <i data-feather="credit-card"
                                                                class="me-2"></i><?php echo e(__('Primary color Settings')); ?>

                                                        </h6>
                                                        <hr class="my-2" />
                                                        <div class="theme-color themes-color">
                                                            

                                                                <a href="#!" class="<?php echo e((!empty($color) && $color == 'theme-1') ? 'active_color' : ''); ?>" data-value="theme-1" onclick="check_theme('theme-1')"></a>
                                                                <input type="radio" class="theme_color" name="color" value="theme-1" style="display: none;" <?php echo e(!empty($color) && $color == 'theme-1' ? 'checked' : ''); ?>>
                                                                <a href="#!" class="<?php echo e((!empty($color) && $color == 'theme-2') ? 'active_color' : ''); ?> " data-value="theme-2" onclick="check_theme('theme-2')"></a>
                                                                <input type="radio" class="theme_color" name="color" value="theme-2" style="display: none;" <?php echo e(!empty($color) && $color == 'theme-2' ? 'checked' : ''); ?>>
                                                                <a href="#!" class="<?php echo e((!empty($color) && $color == 'theme-3') ? 'active_color' : ''); ?>" data-value="theme-3" onclick="check_theme('theme-3')"></a>
                                                                <input type="radio" class="theme_color" name="color" value="theme-3" style="display: none;" <?php echo e(!empty($color) && $color == 'theme-3' ? 'checked' : ''); ?>>
                                                                <a href="#!" class="<?php echo e((!empty($color) && $color == 'theme-4') ? 'active_color' : ''); ?>" data-value="theme-4" onclick="check_theme('theme-4')"></a>
                                                                <input type="radio" class="theme_color" name="color" value="theme-4" style="display: none;" <?php echo e(!empty($color) && $color == 'theme-4' ? 'checked' : ''); ?>>
                                                                <a href="#!" class="<?php echo e((!empty($color) && $color == 'theme-5') ? 'active_color' : ''); ?>" data-value="theme-5" onclick="check_theme('theme-5')"></a>
                                                                <input type="radio" class="theme_color" name="color" value="theme-5" style="display: none;" <?php echo e(!empty($color) && $color == 'theme-5' ? 'checked' : ''); ?>>
                                                                <br>
                                                                <a href="#!" class="<?php echo e((!empty($color) && $color == 'theme-6') ? 'active_color' : ''); ?>" data-value="theme-6" onclick="check_theme('theme-6')"></a>
                                                                <input type="radio" class="theme_color" name="color" value="theme-6" style="display: none;" <?php echo e(!empty($color) && $color == 'theme-6' ? 'checked' : ''); ?>>
                                                                <a href="#!" class="<?php echo e((!empty($color) && $color == 'theme-7') ? 'active_color' : ''); ?>" data-value="theme-7" onclick="check_theme('theme-7')"></a>
                                                                <input type="radio" class="theme_color" name="color" value="theme-7" style="display: none;" <?php echo e(!empty($color) && $color == 'theme-7' ? 'checked' : ''); ?>>
                                                                <a href="#!" class="<?php echo e((!empty($color) && $color == 'theme-8') ? 'active_color' : ''); ?>" data-value="theme-8" onclick="check_theme('theme-8')"></a>
                                                                <input type="radio" class="theme_color" name="color" value="theme-8" style="display: none;" <?php echo e(!empty($color) && $color == 'theme-8' ? 'checked' : ''); ?>>
                                                                <a href="#!" class="<?php echo e((!empty($color) && $color == 'theme-9') ? 'active_color' : ''); ?>" data-value="theme-9" onclick="check_theme('theme-9')"></a>
                                                                <input type="radio" class="theme_color" name="color" value="theme-9" style="display: none;" <?php echo e(!empty($color) && $color == 'theme-9' ? 'checked' : ''); ?>>
                                                                <a href="#!" class="<?php echo e((!empty($color) && $color == 'theme-10') ? 'active_color' : ''); ?>" data-value="theme-10" onclick="check_theme('theme-10')"></a>
                                                                <input type="radio" class="theme_color" name="color" value="theme-10" style="display: none;" <?php echo e(!empty($color) && $color == 'theme-10' ? 'checked' : ''); ?>>
                                                        </div>

                                                    </div>

                                                    <div class="col-lg-4 col-xl-4 col-md-4">
                                                        <h6 class="mt-2">
                                                            <i data-feather="layout"
                                                                class="me-2"></i><?php echo e(__('Sidebar Settings')); ?>

                                                        </h6>

                                                        <hr class="my-2" />
                                                        <div class="form-check form-switch">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="cust-theme-bg" name="cust_theme_bg"
                                                                
                                                                <?php echo e(!empty($locations['cust_theme_bg']) && $locations['cust_theme_bg'] == 'on' ? 'checked' : ''); ?> />
                                                            <label class="form-check-label f-w-600 pl-1"
                                                                for="cust-theme-bg"><?php echo e(__('Transparent layout')); ?></label>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-xl-4 col-md-4">
                                                        <h6 class="mt-2">
                                                            <i data-feather="sun"
                                                                class="me-2"></i><?php echo e(__('Layout Settings')); ?>

                                                        </h6>
                                                        <hr class="my-2" />
                                                        <div class="form-check form-switch mt-2">
                                                            <input type="hidden" name="cust_darklayout" value="off">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="cust-darklayout" name="cust_darklayout"
                                                                <?php echo e(!empty($locations['cust_darklayout']) && $locations['cust_darklayout'] == 'on' ? 'checked' : ''); ?> />

                                                            <label class="form-check-label f-w-600 pl-1"
                                                                for="cust-darklayout"><?php echo e(__('Dark Layout')); ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <?php echo e(Form::submit(__('Save Changes'), ['class' => 'btn btn-print-invoice  btn-primary m-r-10'])); ?>

                                </div>

                            </div>

                        </div>

                        <?php echo e(Form::close()); ?>

                    </div>

                    <div id="useradd-2" class="card">
                        <?php echo e(Form::open(['route' => ['company.settings.system.store'], 'method' => 'post', 'enctype' => 'multipart/form-data'])); ?>

                        <div class="card-header">
                            <h5><?php echo e(__('System Settings')); ?></h5>
                            <small class="text-muted"><?php echo e(__('Edit your system details')); ?></small>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="title_text" class="form-label"><?php echo e(__('Date format')); ?></label>
                                        <?php echo Form::select(
                                            'date_format',
                                            ['d/m/Y' => 'DD/MM/YYYY', 'm-d-Y' => 'MM-DD-YYYY', 'd-m-Y' => 'DD-MM-YYYY'],
                                            !empty($setting['date_format']) ? $setting['date_format'] : '',
                                            ['class' => 'form-control ', 'required' => 'required'],
                                        ); ?>


                                    </div>
                                </div>
                                <div class="col-md-8">
                                <div class="form-group ">
                                    <label for="outh_path" class="form-label"><?php echo e(__('Set this url as Authorized redirect URIs')); ?></label>
                                    <input type="text" class="form-control" name="outh_path" value="<?=url('/').'/oauth2callback'?>" disabled="">
                                 </div>
                                 </div>
                                <div class="modal-footer">
                                    <input type="submit" value="<?php echo e(__('Save Changes')); ?>" class="btn btn-primary">
                                </div>
                            </div>
                        </div>

                        <?php echo e(Form::close()); ?>

                    </div>

                    <div id="useradd-4" class="card mb-3">
                        <?php echo e(Form::open(['route' => 'storage.setting.store', 'enctype' => 'multipart/form-data'])); ?>

                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-10 col-md-10 col-sm-10">
                                    <h5 class=""><?php echo e(__('Storage Settings')); ?></h5>
                                    <small class="text-muted"><?php echo e(__('Edit storage Settings')); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="pe-2">
                                    <input type="radio" class="btn-check" name="storage_setting" id="local-outlined"
                                        autocomplete="off" <?php echo e($setting['storage_setting'] == 'local' ? 'checked' : ''); ?>

                                        value="local" checked>
                                    <label class="btn btn-outline-primary"
                                        for="local-outlined"><?php echo e(__('Local')); ?></label>
                                </div>
                                <div class="pe-2">
                                    <input type="radio" class="btn-check" name="storage_setting" id="s3-outlined"
                                        autocomplete="off" <?php echo e($setting['storage_setting'] == 's3' ? 'checked' : ''); ?>

                                        value="s3">
                                    <label class="btn btn-outline-primary" for="s3-outlined">
                                        <?php echo e(__('AWS S3')); ?></label>
                                </div>

                                <div class="pe-2">
                                    <input type="radio" class="btn-check" name="storage_setting" id="wasabi-outlined"
                                        autocomplete="off" <?php echo e($setting['storage_setting'] == 'wasabi' ? 'checked' : ''); ?>

                                        value="wasabi">
                                    <label class="btn btn-outline-primary"
                                        for="wasabi-outlined"><?php echo e(__('Wasabi')); ?></label>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div
                                    class="local-setting row <?php echo e($setting['storage_setting'] == 'local' ? ' ' : 'd-none'); ?>">
                                    
                                    <div class="form-group col-8 switch-width">
                                        <?php echo e(Form::label('local_storage_validation', __('Only Upload Files'), ['class' => 'mb-2'])); ?>

                                        <select name="local_storage_validation[]" class="multi-select choices__input"
                                            id="local_storage_validation" id='choices-multiple' multiple>
                                             <?php $__currentLoopData = $file_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option <?php if(in_array($f, $local_storage_validations)): ?> selected <?php endif; ?>>
                                                    <?php echo e($f); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label"
                                                for="local_storage_max_upload_size"><?php echo e(__('Max upload size ( In KB)')); ?></label>
                                            <input type="number" name="local_storage_max_upload_size"
                                                class="form-control"
                                                value="<?php echo e(!isset($setting['local_storage_max_upload_size']) || is_null($setting['local_storage_max_upload_size']) ? '' : $setting['local_storage_max_upload_size']); ?>"
                                                placeholder="<?php echo e(__('Max upload size')); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="s3-setting row <?php echo e($setting['storage_setting'] == 's3' ? ' ' : 'd-none'); ?>">

                                    <div class=" row ">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="s3_key"><?php echo e(__('S3 Key')); ?></label>
                                                <input type="text" name="s3_key" class="form-control"
                                                    value="<?php echo e(!isset($setting['s3_key']) || is_null($setting['s3_key']) ? '' : $setting['s3_key']); ?>"
                                                    placeholder="<?php echo e(__('S3 Key')); ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="s3_secret"><?php echo e(__('S3 Secret')); ?></label>
                                                <input type="text" name="s3_secret" class="form-control"
                                                    value="<?php echo e(!isset($setting['s3_secret']) || is_null($setting['s3_secret']) ? '' : $setting['s3_secret']); ?>"
                                                    placeholder="<?php echo e(__('S3 Secret')); ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="s3_region"><?php echo e(__('S3 Region')); ?></label>
                                                <input type="text" name="s3_region" class="form-control"
                                                    value="<?php echo e(!isset($setting['s3_region']) || is_null($setting['s3_region']) ? '' : $setting['s3_region']); ?>"
                                                    placeholder="<?php echo e(__('S3 Region')); ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="s3_bucket"><?php echo e(__('S3 Bucket')); ?></label>
                                                <input type="text" name="s3_bucket" class="form-control"
                                                    value="<?php echo e(!isset($setting['s3_bucket']) || is_null($setting['s3_bucket']) ? '' : $setting['s3_bucket']); ?>"
                                                    placeholder="<?php echo e(__('S3 Bucket')); ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="s3_url"><?php echo e(__('S3 URL')); ?></label>
                                                <input type="text" name="s3_url" class="form-control"
                                                    value="<?php echo e(!isset($setting['s3_url']) || is_null($setting['s3_url']) ? '' : $setting['s3_url']); ?>"
                                                    placeholder="<?php echo e(__('S3 URL')); ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_endpoint"><?php echo e(__('S3 Endpoint')); ?></label>
                                                <input type="text" name="s3_endpoint" class="form-control"
                                                    value="<?php echo e(!isset($setting['s3_endpoint']) || is_null($setting['s3_endpoint']) ? '' : $setting['s3_endpoint']); ?>"
                                                    placeholder="<?php echo e(__('S3 Bucket')); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-8 switch-width">
                                            <?php echo e(Form::label('s3_storage_validation', __('Only Upload Files'), ['class' => ' form-label'])); ?>

                                            <select name="s3_storage_validation[]" class="multi-select"
                                                id="s3_storage_validation" multiple>
                                                <?php $__currentLoopData = $file_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option <?php if(in_array($f, $s3_storage_validations)): ?> selected <?php endif; ?>>
                                                        <?php echo e($f); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  

                                                  
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_max_upload_size"><?php echo e(__('Max upload size ( In KB)')); ?></label>
                                                <input type="number" name="s3_max_upload_size" class="form-control"
                                                    value="<?php echo e(!isset($setting['s3_max_upload_size']) || is_null($setting['s3_max_upload_size']) ? '' : $setting['s3_max_upload_size']); ?>"
                                                    placeholder="<?php echo e(__('Max upload size')); ?>">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div
                                    class="wasabi-setting row <?php echo e($setting['storage_setting'] == 'wasabi' ? ' ' : 'd-none'); ?>">
                                    <div class=" row ">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_key"><?php echo e(__('Wasabi Key')); ?></label>
                                                <input type="text" name="wasabi_key" class="form-control"
                                                    value="<?php echo e(!isset($setting['wasabi_key']) || is_null($setting['wasabi_key']) ? '' : $setting['wasabi_key']); ?>"
                                                    placeholder="<?php echo e(__('Wasabi Key')); ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_secret"><?php echo e(__('Wasabi Secret')); ?></label>
                                                <input type="text" name="wasabi_secret" class="form-control"
                                                    value="<?php echo e(!isset($setting['wasabi_secret']) || is_null($setting['wasabi_secret']) ? '' : $setting['wasabi_secret']); ?>"
                                                    placeholder="<?php echo e(__('Wasabi Secret')); ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_region"><?php echo e(__('Wasabi Region')); ?></label>
                                                <input type="text" name="wasabi_region" class="form-control"
                                                    value="<?php echo e(!isset($setting['wasabi_region']) || is_null($setting['wasabi_region']) ? '' : $setting['wasabi_region']); ?>"
                                                    placeholder="<?php echo e(__('Wasabi Region')); ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="wasabi_bucket"><?php echo e(__('Wasabi Bucket')); ?></label>
                                                <input type="text" name="wasabi_bucket" class="form-control"
                                                    value="<?php echo e(!isset($setting['wasabi_bucket']) || is_null($setting['wasabi_bucket']) ? '' : $setting['wasabi_bucket']); ?>"
                                                    placeholder="<?php echo e(__('Wasabi Bucket')); ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="wasabi_url"><?php echo e(__('Wasabi URL')); ?></label>
                                                <input type="text" name="wasabi_url" class="form-control"
                                                    value="<?php echo e(!isset($setting['wasabi_url']) || is_null($setting['wasabi_url']) ? '' : $setting['wasabi_url']); ?>"
                                                    placeholder="<?php echo e(__('Wasabi URL')); ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="wasabi_root"><?php echo e(__('Wasabi Root')); ?></label>
                                                <input type="text" name="wasabi_root" class="form-control"
                                                    value="<?php echo e(!isset($setting['wasabi_root']) || is_null($setting['wasabi_root']) ? '' : $setting['wasabi_root']); ?>"
                                                    placeholder="<?php echo e(__('Wasabi Bucket')); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-8 switch-width">
                                            <?php echo e(Form::label('wasabi_storage_validation', __('Only Upload Files'), ['class' => 'form-label'])); ?>


                                            <select name="wasabi_storage_validation[]" class="multi-select"
                                                id="wasabi_storage_validation" multiple>
                                                <?php $__currentLoopData = $file_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option <?php if(in_array($f, $wasabi_storage_validations)): ?> selected <?php endif; ?>>
                                                        <?php echo e($f); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="wasabi_root"><?php echo e(__('Max upload size ( In KB)')); ?></label>
                                                <input type="number" name="wasabi_max_upload_size"
                                                    class="form-control"
                                                    value="<?php echo e(!isset($setting['wasabi_max_upload_size']) || is_null($setting['wasabi_max_upload_size']) ? '' : $setting['wasabi_max_upload_size']); ?>"
                                                    placeholder="<?php echo e(__('Max upload size')); ?>">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <input class="btn btn-print-invoice  btn-primary m-r-10" type="submit"
                                    value="<?php echo e(__('Save Changes')); ?>">
                            </div>
                            <?php echo e(Form::close()); ?>

                        </div>
                    </div>

                    <div id="useradd-3" class="card">
                        <?php echo e(Form::open(['route' => 'company.email.settings.store', 'method' => 'post'])); ?>

                        <div class="card-header">
                            <h5><?php echo e(__('Email Settings')); ?></h5>
                            <small class="text-muted"><?php echo e(__('Edit Email Settings')); ?></small>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 form-group">
                                    <?php echo e(Form::label('mail_driver', __('Mail Driver'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('mail_driver', !empty($location['mail_driver']) ? $location['mail_driver'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Mail Driver')])); ?>

                                    <?php $__errorArgs = ['mail_driver'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-mail_driver" role="alert">
                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-4 form-group">
                                    <?php echo e(Form::label('mail_host', __('Mail Host'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('mail_host', !empty($location['mail_host']) ? $location['mail_host'] : '', ['class' => 'form-control ', 'placeholder' => __('Enter Mail Driver')])); ?>

                                    <?php $__errorArgs = ['mail_host'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-mail_driver" role="alert">
                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-4 form-group">
                                    <?php echo e(Form::label('mail_port', __('Mail Port'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('mail_port', !empty($location['mail_port']) ? $location['mail_port'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Mail Port')])); ?>

                                    <?php $__errorArgs = ['mail_port'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-mail_port" role="alert">
                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-4 form-group">
                                    <?php echo e(Form::label('mail_username', __('Mail Username'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('mail_username', !empty($location['mail_username']) ? $location['mail_username'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Mail Username')])); ?>

                                    <?php $__errorArgs = ['mail_username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-mail_username" role="alert">
                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-4 form-group">
                                    <?php echo e(Form::label('mail_password', __('Mail Password'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('mail_password', !empty($location['mail_password']) ? $location['mail_password'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Mail Password')])); ?>

                                    <?php $__errorArgs = ['mail_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-mail_password" role="alert">
                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-4 form-group">
                                    <?php echo e(Form::label('mail_encryption', __('Mail Encryption'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('mail_encryption', !empty($location['mail_encryption']) ? $location['mail_encryption'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Mail Encryption')])); ?>

                                    <?php $__errorArgs = ['mail_encryption'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-mail_encryption" role="alert">
                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-4 form-group">
                                    <?php echo e(Form::label('mail_from_address', __('Mail From Address'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('mail_from_address', !empty($location['mail_from_address']) ? $location['mail_from_address'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Mail From Address')])); ?>

                                    <?php $__errorArgs = ['mail_from_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-mail_from_address" role="alert">
                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-4 form-group">
                                    <?php echo e(Form::label('mail_from_name', __('Mail From Name'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('mail_from_name', !empty($location['mail_from_name']) ? $location['mail_from_name'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Mail Encryption')])); ?>

                                    <?php $__errorArgs = ['mail_from_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-mail_from_name" role="alert">
                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                            </div>
                            <div class="modal-footer ">
                                <div class="row col-12">
                                    <div class="form-group col-md-6">
                                        <a href="#" data-url="<?php echo e(route('company.test.mail')); ?>" id="test_email"
                                            data-title="<?php echo e(__('Send Test Mail')); ?>" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" class="btn  btn-primary send_email">
                                            <?php echo e(__('Send Test Mail')); ?>

                                        </a>
                                    </div>
                                    <div class="form-group col-md-6 text-end">
                                        <input type="submit" value="<?php echo e(__('Save Changes')); ?>" class="btn btn-primary">
                                    </div>

                                </div>
                            </div>
                        </div>

                        <?php echo e(Form::close()); ?>

                    </div>
                     <div id="useradd-5" class="card">
                        <?php echo e(Form::open(['url' => route('seo.settings.store'), 'enctype' => 'multipart/form-data'])); ?>

                          <div class="card-header">
                              <h5><?php echo e(__('SEO Settings')); ?></h5>
                              <small class="text-muted"><?php echo e(__('Edit your SEO details')); ?></small>
                          </div>
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-lg-6">
                                      <div class="form-group">
                                          <?php echo e(Form::label('meta_keywords', __('Meta Keywords'), ['class' => 'col-form-label'])); ?>

                                          <?php echo e(Form::text('meta_keywords', !empty($settings['meta_keywords']) ? $settings['meta_keywords'] : '', ['class' => 'form-control ', 'placeholder' => 'Meta Keywords'])); ?>

                                      </div>
                                      <div class="form-group">
                                          <?php echo e(Form::label('meta_description', __('Meta Description'), ['class' => 'form-label'])); ?>

                                          <?php echo e(Form::textarea('meta_description', !empty($settings['meta_description']) ? $settings['meta_description'] : '', ['class' => 'form-control ', 'row' => 2, 'placeholder' => 'Enter Meta Description'])); ?>

                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <?php echo e(Form::label('Meta Image', __('Meta Image'), ['class' => 'col-form-label '])); ?>

                                          <div class="card-body pt-0">
                                              <div class="setting-card">
                                                  <div class="logo-content ">
                                                      <a href="<?php echo e($logo . (isset($meta_image) && !empty($meta_image) ? $meta_image : '/meta-image.png')); ?>"target="_blank">
                                                        <img id="dark"src="<?php echo e($logo . '/meta-image.png' . '?' . time()); ?>" width="450px" height="250px">
                                                      </a>
                                                  </div>
                                                  <div class="choose-files mt-4">
                                                      <label for="meta_image">
                                                          <div class=" bg-primary logo"> <i
                                                                  class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?>

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
                                  <?php echo e(__('Save Changes')); ?>

                              </button>
                          </div>
                        <?php echo e(Form::close()); ?>

                    </div>
                    <div id="useradd-6">
                       <div class="card" id="cookie-settings">
                          <?php echo e(Form::model($settings,array('route'=>'cookie.setting','method'=>'post'))); ?>

                          <div class="card-header flex-column flex-lg-row  d-flex align-items-lg-center gap-2 justify-content-between">
                              <h5><?php echo e(__('Cookie Settings')); ?></h5>
                                  
                              <div class="d-flex align-items-center">
                                  <?php echo e(Form::label('enable_cookie', __('Enable cookie'), ['class' => 'col-form-label p-0 fw-bold me-3'])); ?>

                                  <div class="custom-control custom-switch"  onclick="enablecookie()">
                                      <input type="checkbox" data-toggle="switchbutton" data-onstyle="primary" name="enable_cookie" class="form-check-input input-primary "
                                             id="enable_cookie" <?php echo e($cookie['enable_cookie'] == 'on' ? ' checked ' : ''); ?> >
                                      <label class="custom-control-label mb-1" for="enable_cookie"></label>
                                  </div>
                              </div>
                          </div>

                          <div class="card-body cookieDiv <?php echo e($cookie['enable_cookie'] == 'off' ? 'disabledCookie ' : ''); ?>">
                              <div class="row ">
                                  <div class="col-md-6">
                                      <div class="form-check form-switch custom-switch-v1" id="cookie_log">
                                          <input type="checkbox" name="cookie_logging" class="form-check-input input-primary cookie_setting"
                                                 id="cookie_logging"<?php echo e($cookie['cookie_logging'] == 'on' ? ' checked ' : ''); ?>>
                                          <label class="form-check-label" for="cookie_logging"><?php echo e(__('Enable logging')); ?></label>
                                      </div>
                                      <div class="form-group" >
                                          <?php echo e(Form::label('cookie_title', __('Cookie Title'), ['class' => 'col-form-label' ])); ?>

                                          <?php echo e(Form::text('cookie_title', !empty($cookie['cookie_title']) ? $cookie['cookie_title'] : '', ['class' => 'form-control cookie_setting'] )); ?>

                                      </div>
                                      <div class="form-group ">
                                          <?php echo e(Form::label('cookie_description', __('Cookie Description'), ['class' => ' form-label'])); ?>

                                          <?php echo Form::textarea('cookie_description', !empty($cookie['cookie_description']) ? $cookie['cookie_description'] : '', ['class' => 'form-control cookie_setting', 'rows' => '3']); ?>

                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-check form-switch custom-switch-v1 ">
                                          <input type="checkbox" name="necessary_cookies" class="form-check-input input-primary"
                                                 id="necessary_cookies" checked onclick="return false">
                                          <label class="form-check-label" for="necessary_cookies"><?php echo e(__('Strictly necessary cookies')); ?></label>
                                      </div>
                                      <div class="form-group ">
                                          <?php echo e(Form::label('strictly_cookie_title', __(' Strictly Cookie Title'), ['class' => 'col-form-label'])); ?>

                                          <?php echo e(Form::text('strictly_cookie_title', !empty($cookie['strictly_cookie_title']) ? $cookie['strictly_cookie_title'] : '', ['class' => 'form-control cookie_setting'])); ?>

                                      </div>
                                      <div class="form-group ">
                                          <?php echo e(Form::label('strictly_cookie_description', __('Strictly Cookie Description'), ['class' => ' form-label'])); ?>

                                          <?php echo Form::textarea('strictly_cookie_description', !empty($cookie['strictly_cookie_description']) ? $cookie['strictly_cookie_description'] : '', ['class' => 'form-control cookie_setting ', 'rows' => '3']); ?>

                                      </div>
                                  </div>
                                      <div class="col-12">
                                          <h5><?php echo e(__('More Information')); ?></h5>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group ">
                                              <?php echo e(Form::label('more_information_description', __('Contact Us Description'), ['class' => 'col-form-label'])); ?>

                                              <?php echo e(Form::text('more_information_description', !empty($cookie['more_information_description']) ? $cookie['more_information_description'] : '', ['class' => 'form-control cookie_setting'])); ?>

                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group ">
                                              <?php echo e(Form::label('contactus_url', __('Contact Us URL'), ['class' => 'col-form-label'])); ?>

                                              <?php echo e(Form::text('contactus_url', !empty($cookie['contactus_url']) ? $cookie['contactus_url'] : '', ['class' => 'form-control cookie_setting'])); ?>

                                          </div>
                                      </div>
                              </div>
                          </div>
                          <div class="modal-footer d-flex align-items-center gap-2 flex-sm-column flex-lg-row justify-content-between" >
                              <div>
                                  <?php if(isset($cookie['cookie_logging']) && $cookie['cookie_logging'] == 'on'): ?>
                                  <label for="file" class="form-label"><?php echo e(__('Download cookie accepted data')); ?></label>
                                      <a href="<?php echo e(asset(Storage::url('uploads/sample')) . '/data.csv'); ?>" class="btn btn-primary mr-2 ">
                                          <i class="ti ti-download"></i>
                                      </a>
                                      <?php endif; ?>
                              </div>
                              <input type="submit" value="<?php echo e(__('Submit')); ?>" class="btn btn-primary">
                          </div>
                          <?php echo e(Form::close()); ?>

                      </div>
                    </div>

                   
                    
                    <div id="useradd-7" class="card">
                        <?php echo e(Form::open(['route' => ['company.slack.settings'], 'method' => 'post', 'enctype' => 'multipart/form-data'])); ?>

                        <div class="card-header">
                            <h5><?php echo e(__('Slack Settings')); ?></h5>
                            <small class="text-muted"><?php echo e(__('Edit your Slack details')); ?></small>
                        </div>

                        <div class="card-body">
                            <div class="row">
                               
                                <div class="col-md-9">
                                    <div class="form-group ">
                                        <label for="title_text" class="form-label"><?php echo e(__('Slack Webhook URL')); ?></label>
                                        <input type="text" class="form-control" name="slack_webhook" value="<?php echo e(!empty($locations['slack_webhook']) ? $locations['slack_webhook'] : ''); ?>" placeholder="<?php echo e(__('Slack Webhook URL')); ?>">
                                    
                                    </div>
                                </div>
                                
                                <div class="modal-footer">
                                    <input type="submit" value="<?php echo e(__('Save Changes')); ?>" class="btn btn-primary">
                                </div>
                            </div>
                        </div>

                        <?php echo e(Form::close()); ?>

                    </div>
                  
                    <div id="useradd-8" class="card">
                        <?php echo e(Form::open(['route' => ['company.report.settings'], 'method' => 'post', 'enctype' => 'multipart/form-data'])); ?>

                        <div class="card-header">
                            <h5><?php echo e(__('Report')); ?></h5>
                            <small class="text-muted"><?php echo e(__('How often do you want to receive summary reports about your primary metrics?')); ?></small>
                        </div>

                        <div class="card-body">
                            <div class="row">
                               
                                <div class="col-lg-6 form-group">
                                    <div class="list-group">
                                        <div class="list-group-item form-switch form-switch-right">
                                            <label class="form-label" style="margin-left:5%;"><?php echo e(__('Email Notifiation')); ?></label>
                                            <input class="form-check-input " onchange="frequency_status()"  id="email_notifiation" type="checkbox" value="0" name="email_notifiation" <?php echo e(!empty($report_setting->email_notification) && $report_setting->email_notification == 1 ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="email_notifiation"></label>

                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12 form-group" id="frequency_block" style="display: none;">
                                   <h4 class="small-title"><?php echo e(__('Frequency of new reports')); ?></h4>
                                   <hr class="my-2" />
                                    <div class="d-flex flex-wrap gap-3 mb-2 mb-md-0 mt-2">
                                        <div class="form-check form-switch col-lg-2">
                                            <input type="checkbox" class="form-check-input"
                                                id="is_daily" name="is_daily"
                                                
                                                <?php echo e(!empty($report_setting->is_daily) && $report_setting->is_daily == 1 ? 'checked' : ''); ?> />
                                            <label class="form-check-label f-w-600 pl-1"
                                                for="is_daily"><?php echo e(__('Daily')); ?></label>
                                        </div>
                                        <div class="form-check form-switch col-lg-2">
                                            <input type="checkbox" class="form-check-input"
                                                id="is_weekly" name="is_weekly"
                                                
                                                <?php echo e(!empty($report_setting->is_weekly) && $report_setting->is_weekly == 1 ? 'checked' : ''); ?> />
                                            <label class="form-check-label f-w-600 pl-1"
                                                for="is_weekly"><?php echo e(__('Weekly')); ?></label>
                                        </div>
                                        <div class="form-check form-switch col-lg-2">
                                            <input type="checkbox" class="form-check-input"
                                                id="is_monthly" name="is_monthly"
                                                
                                                <?php echo e(!empty($report_setting->is_monthly) && $report_setting->is_monthly == 1 ? 'checked' : ''); ?> />
                                            <label class="form-check-label f-w-600 pl-1"
                                                for="is_monthly"><?php echo e(__('Monthly')); ?></label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="modal-footer">
                                    <input type="submit" value="<?php echo e(__('Save Changes')); ?>" class="btn btn-primary">
                                </div>
                            </div>
                        </div>

                        <?php echo e(Form::close()); ?>

                    </div>


                    <div id="useradd-9" class="card">
                        <?php echo e(Form::open(['url' => route('cache.settings'), 'method' => 'post', 'enctype' => 'multipart/form-data'])); ?>

                        <div class="col-md-12">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <h5><?php echo e(__('Cache Settings')); ?></h5>
                                        <small
                                            class="text-secondary font-weight-bold"><?php echo e(__("This is a page meant for more advanced users, simply ignore it if you
                                                                      don't understand what cache is.")); ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="col-lg-12">
                                    <div class="input-group search-form">
                                        <input type="text" value="<?php echo e($file_size); ?>" class="form-control"
                                            disabled>
                                        <span class="input-group-text bg-transparent">MB</span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer m-3">
                                <?php echo e(Form::submit(__('Clear Cache'), ['class' => 'btn btn-print-invoice  btn-primary m-r-10'])); ?>

                            </div>

                            <?php echo e(Form::close()); ?>

                        </div>
                    </div>


                </div>
            </div>
        </div>
                    <?php $__env->stopSection(); ?>
<?php $__env->startPush('pre-purpose-script-page'); ?>
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
                        _token: '<?php echo e(csrf_token()); ?>'
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
        <script src="<?php echo e(asset('assets/js/jscolor.js')); ?> "></script>

        <script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>
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
                        .setAttribute("href", "<?php echo e(asset('assets/css/style-dark.css')); ?>");
                } else {
                    document
                        .querySelector("#main-style-link")
                        .setAttribute("href", "<?php echo e(asset('assets/css/style.css')); ?>");
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
    <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/vps-m2-srv45.nl/anajob.webmojo.online/resources/views/admin/user/setting.blade.php ENDPATH**/ ?>