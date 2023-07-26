<?php $ln=$lang;?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Login')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-scripts'); ?>
<?php if(env('RECAPTCHA_MODULE') == 'yes'): ?>
<?php echo NoCaptcha::renderJs(); ?>

<?php endif; ?>
<?php $__env->stopPush(); ?>


<?php $__env->startSection('lang-selectbox'); ?>
    <select class="btn btn-primary dropdown-toggle ms-2 me-2 language_option_bg" name="language" id="language"
        onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" style=" padding-right: 0px;padding-left: 0px;">
        <?php $__currentLoopData = \App\Models\Utility::languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $url= url('forgot-password/'.$code);?>

            <option <?php if($lang == $code ): ?> selected <?php endif; ?> value="<?php echo e($url); ?>">
                <?php echo e(Str::upper($language)); ?></option>
                <?php  
                ?>
                
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    
<?php $__env->stopSection(); ?>

<?php
    $currantLang = basename(App::getLocale());
?>

<?php $__env->startSection('content'); ?>

<!-- [ auth-signup ] start -->
        <div class="card">
            <div class="row align-items-center text-start">
                <div class="col-xl-6">
                    <div class="card-body">
                        <div class="d-flex">
                            <h2 class="mb-3 f-w-600"><?php echo e(__('Reset Password')); ?></h2>
                        </div>
                        <?php echo e(Form::open(array('route'=>'password.email','method'=>'post','id'=>'loginForm','class'=> 'login-form'))); ?>

                        <input type="hidden" name="lang" value="<?php echo e($ln); ?>">
                        <div class="">
                            <div class="form-group mb-3">
                                <label class="form-label d-flex"><?php echo e(__('E-Mail')); ?></label>
                                <?php echo e(Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter Your Email')))); ?>

                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error invalid-email text-danger" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            </div>
                        


                            
                            <div class="d-grid">
                                <?php echo e(Form::submit(__('Send Password Reset Link'),array('class'=>'btn btn-primary btn-block mt-2','id'=>'saveBtn'))); ?>

                            </div>
                            <?php echo e(Form::close()); ?>


                           
                            <p class="my-4 text-center"><?php echo e(__('Back to')); ?>

                                
                                <a href="<?php echo e(url('login/'."$ln")); ?>" class="my-4 text-primary"><?php echo e(__('Sign In')); ?></a>
                            </p>
                           
                        </div>

                    </div>
                </div>
                <div class="col-xl-6 img-card-side">
                    <div class="auth-img-content">
                        <img src="<?php echo e(asset('assets/images/auth/img-auth-3.svg')); ?>" alt="" class="img-fluid">
                        <h3 class="text-white mb-4 mt-5"> <?php echo e(__('“Attention is the new currency”')); ?></h3>
                        <p class="text-white"> <?php echo e(__('The more effortless the writing looks, the more effort the writer
                            actually put into the process.')); ?></p>
                    </div>
                </div>
            </div>
        </div>  
<!-- [ auth-signup ] end -->

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/vps-m2-srv45.nl/anajob.webmojo.online/resources/views/auth/forgot-password.blade.php ENDPATH**/ ?>