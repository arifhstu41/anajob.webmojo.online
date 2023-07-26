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
        <?php $url= url('login/'.$code);?>

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
              <h2 class="mb-3 f-w-600"><?php echo e(__('Login')); ?></h2>
            </div>
            <?php echo e(Form::open(array('route'=>'login','method'=>'post','id'=>'loginForm','class'=> 'login-form'))); ?>

            <div class="">
              <div class="form-group mb-3">
                <label class="form-label d-flex"><?php echo e(__('Email')); ?></label>
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
              <div class="form-group mb-3">
                <label class="form-label d-flex"><?php echo e(__('Password')); ?></label>
                <?php echo e(Form::password('password',array('class'=>'form-control','placeholder'=>__('Enter Your Password'),'id'=>'input-password'))); ?>


                <?php if(Route::has('password.request')): ?>
                <div class="mb-2 ms-2 mt-3">
                  <a href="<?php echo e(url('forgot-password/'."$ln")); ?>"
                    class="small text-muted text-underline--dashed border-primary">
                    <?php echo e(__('Forgot Your Password?')); ?></a>
                </div>
                <?php endif; ?>

                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="error invalid-password text-danger" role="alert">
                  <strong><?php echo e($message); ?></strong>
                </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

              </div>


              <?php if(env('RECAPTCHA_MODULE') == 'yes'): ?>
              <div class="form-group col-lg-12 col-md-12 mt-3">
                <?php echo NoCaptcha::display(); ?>

                <?php $__errorArgs = ['g-recaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="small text-danger" role="alert">
                  <strong><?php echo e($message); ?></strong>
                </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              </div>
              <?php endif; ?>
              <div class="d-grid">
                <?php echo e(Form::submit(__('Sign in'),array('class'=>'btn btn-primary btn-block mt-2','id'=>'saveBtn'))); ?>

              </div>
              <?php echo e(Form::close()); ?>


             
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


<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/vps-m2-srv45.nl/anajob.webmojo.online/resources/views/auth/login.blade.php ENDPATH**/ ?>