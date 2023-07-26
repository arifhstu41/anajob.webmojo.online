<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Audience Analytics')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-button'); ?>
<?php if(count($site_data)>0): ?>
<div class=" d-flex align-items-center flex-wrap gap-3">
   <div class="select-box">
     <select class="form-select" name="site_name" id="site-list" ><?php $__currentLoopData = $site_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($val->id); ?>"><?php echo e($val->site_name); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  </select>
    </div>
    <?php if(\Auth::user()->can('manage share report settings')): ?>
      <div class="btn p-0">
        <a class="btn btn-primary" onclick="share_setting('audience');" data-bs-toggle="modal"  data-bs-target="#share_audience_report"><span>
          <i class="ti ti-settings" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Share Report Setting')); ?>"></i></span></a>
      </div>
    <?php endif; ?>
    <?php if(\Auth::user()->can('manage share report')): ?>
      <div class="link" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Share Report')); ?>"></div>
    <?php endif; ?>

</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
      <li class="breadcrumb-item" aria-current="page"><?php echo e(__('Audience Analytics')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php if(count($site_data)>0): ?>

    
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                       
                        <div class="col-md-10 ">
                          <div class=" ">
                              <ul class="nav nav-pills nav-fill row" id="pills-tab" role="tablist">
                                  <li class="nav-item col-sm-1" role="presentation">
                                      <button class="nav-link audience-analytics active " id="pills-tab-1" onclick="get_audience_data()" data-bs-toggle="pill" data-value="ga:country"
                                          data-bs-target="#" type="button"><?php echo e(('Region')); ?></button>
                                    
                                  </li>
                                  <li class="nav-item col-sm-1" role="presentation">
                                      <button class="nav-link audience-analytics" id="pills-tab-2" data-value="ga:userAgeBracket"  onclick="get_audience_data()" data-bs-toggle="pill" data-bs-toggle="pill"
                                          data-bs-target="#" type="button"><?php echo e(('Organic Search')); ?></button>
                                  </li>

                                  <li class="nav-item col-sm-1" role="presentation">
                                      <button class="nav-link audience-analytics" id="pills-tab-3" data-value="ga:userGender"  onclick="get_audience_data()" data-bs-toggle="pill" data-bs-toggle="pill"
                                          data-bs-target="#" type="button"><?php echo e(('Paid Search')); ?></button>
                                  </li>
                                  <li class="nav-item col-sm-1" role="presentation">
                                      <button class="nav-link audience-analytics" id="pills-tab-4" data-value="ga:language"  onclick="get_audience_data()" data-bs-toggle="pill" data-bs-toggle="pill"
                                          data-bs-target="#" type="button"><?php echo e(('Bounce')); ?></button>
                                  </li>
                                  <li class="col-sm-6"></li>
                              </ul>
                          </div>
                       
                      </div>
                        <div class="col-md-2">
                            <div class="input-group mr-sm-2">
                              <input type="text" name="date_duration"  onchange="get_audience_data()" class="form-control date_duration w-100" id="date_duration" />
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>  
    
      <div class="col-sm-12 col-md-12 col-xxl-12">
         <div class="card">
            <div class="card-body">
                <div class="tab-content" id="pills-tabContent">
                     <?php $j=1; ?>
                    <?php $__currentLoopData = $metric_option; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($j==1): ?>
                    <div class="tab-pane fade show active" id="channel-chart-<?php echo e($j); ?>" role="tabpanel"
                        aria-labelledby="pills-user-tab-1">
                        <?php else: ?>
                        <div class="tab-pane fade =" id="channel-chart-<?php echo e($j); ?>" role="tabpanel"
                        aria-labelledby="pills-user-tab-1">
                        <?php endif; ?>
                        <div class="row">
                          <div class="col-md-6">

                             <div class="card">
                                <div class="card-body">
                                  <div id="audience-line-chart-<?php echo e($val); ?>">
                                    <div class="loader " id="progress">
                                      <div class="spinner text-center" style="align-items: center;">
                                        <img height="452px"  src="<?php echo e(asset('assets/images/loader.gif')); ?>" />
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                          <div class="col-md-6">
                            <div class="card">
                              <div class="card-body">
                                  <div id="audience-bar-chart-<?php echo e($val); ?>">
                                    <div class="loader " id="progress">
                                      <div class="spinner text-center" style="align-items: center;">
                                        <img height="452px"  src="<?php echo e(asset('assets/images/loader.gif')); ?>" />
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                        </div>
                    </div>
                    <?php $j++; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <div class="p-3 card">
          <ul class="nav nav-pills nav-fill row" id="pills-tab" role="tablist">
            <?php if(count($metric_option)>0): ?>
            <?php $i=1;?>
            <?php $__currentLoopData = $metric_option; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li class="nav-item col-md-3" role="presentation">
                <?php if($i==1): ?>
                <div class="card nav-link audience-card-metrics active" id="<?php echo e($val); ?>" data-bs-toggle="pill"
                      data-bs-target="#channel-chart-<?php echo e($i); ?>"  type="button">
                <?php else: ?>
                <div class="card nav-link audience-card-metrics" id="<?php echo e($val); ?>" data-bs-toggle="pill"
                      data-bs-target="#channel-chart-<?php echo e($i); ?>" data-id="<?php echo e($val); ?>" type="button">
                <?php endif; ?>
                  <div class="card-body px-lg-5">
                    <h4 id="audinece_metric_data_<?php echo e($val); ?>">0</h4>
                    <h5><?php echo e($val); ?></h5>
                  </div>
                </div>
                  
              </li>
            <?php $i++;?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
          </ul>
        </div>
       
      </div>
    </div>
    <div id="share_audience_report" class="modal fade" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalPopoversLabel"><?php echo e(__('Share Report')); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="<?php echo e(route('save-share-setting','audience')); ?>"  enctype="multipart/form-data"> <?php echo csrf_field(); ?>
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="share_site"id="share_site">
                                 <div class="form-group col-md-2">
                                    <label for="name" class="col-form-label"> <?php echo e(__('Region')); ?> </label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input input-primary"
                                            name="region" id="region">
                                        <label class="form-check-label" for="region"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="name" class="col-form-label"> <?php echo e(__('Organic Search')); ?> </label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input input-primary"
                                            name="organic_search" id="organic_search">
                                        <label class="form-check-label" for="organic_search"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="name" class="col-form-label"> <?php echo e(__('Paid Search')); ?> </label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input input-primary"
                                            name="paid_search" id="paid_search">
                                        <label class="form-check-label" for="paid_search"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="name" class="col-form-label"> <?php echo e(__('Bounce')); ?> </label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input input-primary"
                                            name="bounce" id="bounce">
                                        <label class="form-check-label" for="bounce"></label>
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-2">
                                    <label for="name" class="col-form-label"> <?php echo e(__('Password Protected')); ?> </label>
                                    <div class="form-check form-switch">
                                        <input onclick="password_status()" type="checkbox" class="form-check-input input-primary"name="is_password" id="is_password">
                                        <label class="form-check-label" for="is_password"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    
                                    <div style="display: none" id="password-box">
                                        <div class="action input-group input-group-merge  text-left ">
                                          <input type="password" value="12345678" class=" form-control " name="password" autocomplete="new-password" id="password" placeholder="Enter Your Password">
                                          <div class="input-group-append">
                                              <span class="input-group-text py-3">
                                                  <a href="#" data-toggle="password-text" data-target="#password">
                                                      <i class="fas fa-eye-slash" id="togglePassword"></i>
                                                  </a>
                                              </span>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         
                        <div class="modal-footer">
                            <button type="button" class="btn  btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" title="<?php echo e(__('Copy')); ?>" class="btn  btn-primary" ><?php echo e(__('Save changes')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

  <script>
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function () {
        // toggle the type attribute
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);

        // toggle the icon
        this.classList.toggle("fa-eye");
        this.classList.toggle("fa-eye-slash");
    });

    // prevent form submit
    // const form = document.querySelector("form");
    // form.addEventListener('submit', function (e) {
    //     e.preventDefault();
    // });
</script>
<script type="text/javascript">
  $(function (){      
        get_audience_data();
        if ($('.audience-card-metrics').length > 0) {
            $('.audience-card-metrics').on('click', function (e) {
                e.preventDefault();
               
                analytics_chart($(this).attr('id'),"audience");
            });
        }
    });
  
</script>
<?php else: ?>
<div class="col-md-12" style="height: 200px; ">
      <div class="alert alert-primary alert-dismissible fade show text-center" role="alert">
              <?php echo e(__('No Data Found !')); ?>

             
            </div>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/vps-m2-srv45.nl/anajob.webmojo.online/resources/views/admin/analytics/audience.blade.php ENDPATH**/ ?>