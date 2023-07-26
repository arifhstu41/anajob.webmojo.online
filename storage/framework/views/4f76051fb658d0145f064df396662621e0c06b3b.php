<?php $__env->startSection('content'); ?>
 <style type="text/css">
  code {
  padding: 5px 8px;
  border-radius: 10px;
  background-color: #f8f9f9;
  color: #CC0066;
}

[type='color'] {
  -moz-appearance: none;
  -webkit-appearance: none;
  appearance: none;
  padding: 0;
  width: 350px;
  height: 15px;
  border: none;
}

[type='color']::-webkit-color-swatch-wrapper {
  padding: 0;
}

[type='color']::-webkit-color-swatch {
  border: none;
}

.color-picker {
  padding: 10px 15px;
  border-radius: 10px;
  border: 1px solid #ccc;
  background-color: #f8f9f9;
}
</style>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Quick view')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"><?php echo e(__('Quick view')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-button'); ?>
<div class="d-flex align-items-center flex-wrap gap-3">
    
    <?php if(count($site_data)>0): ?>
     <?php if(\Auth::user()->can('manage share report settings')): ?>
    <div class="btn p-0">
      <a class="btn btn-sm btn-primary" onclick="quickview_share_setting();" data-bs-toggle="modal"  data-bs-target="#quickview_share_report">
        <span><i class="ti ti-settings" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Share Report Setting')); ?>"></i></span></a>
    </div>
    <?php endif; ?>
    <?php if(\Auth::user()->can('manage share report settings') && \Auth::user()->can('manage share report')): ?>
    <div class="link" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Share Report')); ?>"></div>
    <?php endif; ?>
    <?php endif; ?>
  </div>
<?php $__env->stopSection(); ?>
  <div class="row ">
    <?php if(count($site_data)>0): ?>
    <?php $__currentLoopData = $site_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-12 col-lg-6 col-xl-4 ">
      <div class="card">
          <div class="card-header">
              <div class="row">
                <div class="col-6">
                   <h5 class="site_name" data-site="<?php echo e($val->site_name); ?>" data-siteid="<?php echo e($val->id); ?>"><?php echo e($val->site_name); ?></h5>
                </div>
                <div class="col-6 text-end">
                  <a class="btn btn-sm btn-outline-primary" onclick='edit_quick_view_data(<?=$val->id?>)' data-bs-toggle='modal' data-bs-target='#edit_widget_modal'><i class='ti ti-layout-2' ></i></a>
                </div>
              </div>
             
          </div>
          <div class="card-body" style="padding: 0px!important">
              <div id="quick_chart_<?php echo e($val->id); ?>">
                <div class="loader " id="progress_<?php echo e($val->id); ?>">
                <div class="spinner text-center" style="align-items: center;">
                  <img height="452px"  src="<?php echo e(asset('assets/images/loader.gif')); ?>" />
                </div>
              </div>
              </div>
          </div>
          <div class="card-footer">
            <div class="row ">
                <div class="col-6">
                    <h6 class="surtitle" id="top_left_id_<?php echo e($val->id); ?>">-</h6>
                    <h6  id="top_left_value_<?php echo e($val->id); ?>">-</h6>
                </div>
                <div class="col-6 text-right">
                    <h6 class="surtitles text-end" id="top_right_id_<?php echo e($val->id); ?>">-</h6>
                    <h6 class="text-end" id="top_right_value_<?php echo e($val->id); ?>">-</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <h6 class="surtitle" id="bottom_left_id_<?php echo e($val->id); ?>">-</h6>
                    <h6  id="bottom_left_value_<?php echo e($val->id); ?>">-</h6>
                </div>
                <div class="col-6 text-right">
                    <h6 class="surtitle text-end" id="bottom_right_id_<?php echo e($val->id); ?>">-</h6>
                    <h6 class="text-end" id="bottom_right_value_<?php echo e($val->id); ?>">-</h6>
                </div>
            </div>
          </div>
      </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
    <div class="col-md-12" style="height: 200px; ">
      <div class="alert alert-primary alert-dismissible fade show text-center" role="alert">
              <?php echo e(__('No Data Found !')); ?>

             
            </div>
    </div>
    <?php endif; ?>
    </div>
 
<div class="col-xl-4 col-md-6">
  <div id="edit_widget_modal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="quick_view_model_header"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" id="quick_view_form"> <?php echo csrf_field(); ?> 
        <div class="modal-body">
            <div class="form-group" id="site-name-div">
              <input type="hidden" class="form-control" name="edit_id" id="edit_id">
              <label class="form-label"><?php echo e(__('Time frame')); ?>:</label>
              <select class="form-select"  name="time_frame" id="time_frame"> 
                <option selected="" disabled=""><?php echo e(__('Select Time frame ')); ?> </option>
                <?php $__currentLoopData = $arrTimeframe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($key); ?>"><?php echo e($val); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
            <div class="row mb-3">
                <div class="form-gorup col-6">
                  <label class="form-label"><?php echo e(__('Graph')); ?>:</label>
                  <select class="form-select"  name="graph" id="graph">
                    <option selected="" disabled=""><?php echo e(__('Select Time frame ')); ?> </option>
                    <?php $__currentLoopData = $metrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($key); ?>"><?php echo e($val); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                
                </div>
                <div class="form-gorup col-6">
                  <label class="form-label"><?php echo e(__('Graph Type')); ?>:</label>
                 <select class="form-select"  name="graph_type" id="graph_type">
                    <option selected="" disabled=""><?php echo e(__('Select Time frame ')); ?> </option>
                    <option value="line"><?php echo e(__('Line')); ?></option>
                    <option value="bar"><?php echo e(__('Bar')); ?></option>
                  </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="form-gorup col-6">
                  <label class="form-label"><?php echo e(__('Top Left')); ?>:</label>
                  <select class="form-select"  name="top_left" id="top_left">
                    <option selected="" disabled=""><?php echo e(__('Select Top Left')); ?> </option>
                    <?php $__currentLoopData = $metrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($key); ?>"><?php echo e($val); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                
                </div>
                <div class="form-gorup col-6">
                  <label class="form-label"><?php echo e(__('Top Right')); ?>:</label>
                  <select class="form-select"  name="top_right" id="top_right">
                    <option selected="" disabled=""><?php echo e(__('Select Top Right')); ?> </option>
                    <?php $__currentLoopData = $metrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($key); ?>"><?php echo e($val); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </div>
            </div>
             <div class="row mb-3">
                <div class="form-gorup col-6">
                  <label class="form-label"><?php echo e(__('Bottom Left')); ?>:</label>
                  <select class="form-select"  name="bottom_left" id="bottom_left">
                    <option selected="" disabled=""><?php echo e(__('Select Bottom Left')); ?> </option>
                    <?php $__currentLoopData = $metrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($key); ?>"><?php echo e($val); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                
                </div>
                <div class="form-gorup col-6">
                  <label class="form-label"><?php echo e(__('Bottom Right')); ?>:</label>
                  <select class="form-select"  name="bottom_right" id="bottom_right">
                    <option selected="" disabled=""><?php echo e(__('Select Bottom Right')); ?> </option>
                    <?php $__currentLoopData = $metrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($key); ?>"><?php echo e($val); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </div>
            </div>
            <div class="form-gorup  d-flex flex-column" >
              <label class="form-label"><?php echo e(__('Select Chart color')); ?>:</label>
              <span class="color-picker">
                <label  for="colorPicker">
                  <input type="color"  value="#1DB8CE" name="graph_color" id="colorPicker">
                </label>
              </span>
            
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn  btn-light" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn  btn-primary" data-bs-dismiss="modal" onclick="save_quick_view_data()">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="quickview_share_report" class="modal fade" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalPopoversLabel"><?php echo e(__('Share Report')); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="<?php echo e(route('save-quickview-setting')); ?>"  enctype="multipart/form-data"> <?php echo csrf_field(); ?>
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="user_id"id="user_id" value="<?php echo e(Auth::user()->id); ?>">
                                <?php $__currentLoopData = $site_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <div class="form-group col-md-4">
                                    <label for="name" class="col-form-label"> <?php echo e($val->site_name); ?> </label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input input-primary"
                                            name="site_id-<?php echo e($val->id); ?>" id="site_id-<?php echo e($val->id); ?>" value="<?php echo e($val->id); ?>">
                                        <label class="form-check-label" for="site_id-<?php echo e($val->id); ?>"></label>
                                    </div>
                                </div>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 <div class="form-group col-md-4">
                                    <label for="name" class="col-form-label"> <?php echo e(__('Password Protected')); ?> </label>
                                    <div class="form-check form-switch">
                                        <input onclick="quick_link_password_status()" type="checkbox" class="form-check-input input-primary"name="is_password" id="is_password">
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
<script type="text/javascript">
 
  $(document).ready(function()
  {
      if($('.site_name').length) {
              $('.site_name').each(function (data) {
                  var siteName = $(this).attr('data-site');
                  var siteid = $(this).attr('data-siteid');
                  qick_view_data(siteName, siteid);
              });
          } 
  });



</script>

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


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/vps-m2-srv45.nl/anajob.webmojo.online/resources/views/admin/quick_view/default.blade.php ENDPATH**/ ?>