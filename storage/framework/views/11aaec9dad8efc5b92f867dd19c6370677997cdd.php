<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Custom')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-button'); ?>
<?php if(count($site_data)>0): ?>
<div class="d-flex flex-wrap gap-3 mb-2 mb-md-0">
    <div class="">
         <select class="form-select" name="site_name" id="site-list" ><?php $__currentLoopData = $site_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($val->id); ?>"><?php echo e($val->site_name); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  </select>
    </div>
    <?php if(\Auth::user()->can('manage share report settings')): ?>
    <div class="custom-setting" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Share Report Setting')); ?>"></div>
    <?php endif; ?>
    <?php if(\Auth::user()->can('manage share report')): ?>
    <div class="link" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Share Report ')); ?>"></div>
    <?php endif; ?>
</div>

<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"><?php echo e(__('Custom')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5><?php echo e(__('Custom Chart')); ?></h5>
                </div>
                <div class="col-md-6">
                    <div class="row">
                    <div class="col-sm-3 mb-2">
                        <div class="input-group mr-sm-2">
                          <select class="form-select" name="metrics" id="metrics-list"  onchange="get_dimension()">
                            <option selected="" value="0" disabled=""><?php echo e(__('Metric')); ?></option>

                          <?php $__currentLoopData = $metrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($key); ?>" data-name="<?php echo e($val); ?>"><?php echo e($val); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                          </select>
                        </div>
                    </div>
                    <div class="col-sm-3 mb-2">
                        <div class="input-group mr-sm-2">
                          <select class="form-select" name="dimension" id="dimension-list" > 
                            <option selected="" value="0" disabled="" ><?php echo e(__('Dimension')); ?></option>
                           </select>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-2">
                        <div class="input-group mr-sm-2">
                          <input type="text" name="date_duration"  class="form-control date_duration w-100" id="date_duration" />
                        </div>
                    </div>
                    <div class="col-sm-2 mb-2">
                        <button type="button" class="btn  btn-primary" onclick="get_custom_cart()"
                        data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Create Custom Chart')); ?>"><?php echo e(__('Refresh')); ?></button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="custom_chart">
                <div class="col-12 pt-5 text-center">
                    <h5>Please Select Metrics & Dimension For Custom Chart</h5>
                </div>
            </div>
        </div>
    </div>
</div>  


 <div id="share_custom_report" class="modal fade" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalPopoversLabel"><?php echo e(__('Share Report')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="share_site"id="share_site">
                             <div class="form-group col-md-12">
                                <label for="share_met" class="col-form-label"> <?php echo e(__('Metric')); ?> </label>
                                <input type="hidden" class="form-control"  name="share_met" id="share_met">
                                <input type="text" readonly="" class="form-control"  name="share_metric" id="share_metric">
                                <label class="form-check-label" for="share_met"></label>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="share_dim" class="col-form-label"> <?php echo e(__('Dimension')); ?> </label>
                                <input type="hidden"  class="form-control" name="share_dim" id="share_dim">
                                <input type="text" readonly="" class="form-control" name="share_dimension" id="share_dimension">
                                <label class="form-check-label" for="share_dim"></label>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="name" class="col-form-label"> <?php echo e(__('Password Protected')); ?> </label>
                                <div class="form-check form-switch">
                                    <input onclick="password_status()" type="checkbox" class="form-check-input input-primary"name="is_password" id="is_password">
                                    <label class="form-check-label" for="is_password"></label>
                                </div>
                            </div>
                            <div class="form-group col-md-9" style="display: none" id="password-box">
                                <label for="password" class="col-form-label"><?php echo e(__('Password')); ?></label>
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
                     
                    <div class="modal-footer">
                        <button type="button" class="btn  btn-light" data-bs-dismiss="modal">Close</button>
                        <a href="#" title="<?php echo e(__('Save')); ?>" class="btn  btn-primary" onclick="save_custom_setting('custom')"><?php echo e(__('Save changes')); ?></a>
                        
                    </div>
               
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/vps-m2-srv45.nl/anajob.webmojo.online/resources/views/admin/custom/default.blade.php ENDPATH**/ ?>