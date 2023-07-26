<?php if(\Auth::user()->is_json_upload ==1 && count($site)>0): ?>
<?php $__env->startSection('action-button'); ?>
<div class="d-flex align-items-center flex-wrap gap-3">
    <div class="select-box">
        <select class="form-select" name="site_name" id="site-list" onchange="dash_site_detail()"> 
          	<?php $__currentLoopData = $site; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
          		<option value="<?php echo e($val->id); ?>" data-site="<?php echo e($val->site_name); ?>"><?php echo e($val->site_name); ?></option> 
          	
          	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
        </select>
    </div>
    <?php if(\Auth::user()->can('create site')): ?>
    <div class="btn p-0">
      <a class="btn  btn-primary" href="<?php echo e(route('add-site')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Create Coupon')); ?>"><span><i class="ti ti-plus">
        </i></span><?php echo e(__('Add Site')); ?></a>
    </div>
    <?php endif; ?>
     <?php if(count($site)>0): ?>
        <?php if(\Auth::user()->can('manage share report settings')): ?>
            <div class="btn p-0">
              <a class="btn btn-primary" onclick="share_setting('dashboard')" data-bs-toggle="modal"  data-bs-target="#share_dash_report">
                <span><i class="ti ti-settings" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Share Report Setting')); ?>"></i></span></a>
            </div>
        <?php endif; ?>
        <?php if(\Auth::user()->can('manage share report')): ?>
        <div class="link" ddata-bs-toggle="tooltip" data-bs-original-title="Create"></div>
         <?php endif; ?>
    <?php endif; ?>
  </div>
<?php $__env->stopSection(); ?>
<?php endif; ?>
<?php $__env->startSection('page-title'); ?> 
    <?php echo e(__('Dashboard')); ?>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
   
    <li class="breadcrumb-item" id="current_site" data-siteid=""></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
	<?php if(\Auth::user()->user_type == 'company' || \Auth::user()->user_type != 'super admin'): ?>
    <?php if(\Auth::user()->can('manage dashboard')): ?>
	<?php if(count($site)==0 ): ?>
    	<?php if(\Auth::user()->can('create site')): ?>
    		<div class="col-sm-12">
    		    <div class="row">
    		    	<div class="col-xxl-12">
    		            <div class="row">
    		                <div class="col-lg-4 col-6">
    		                	<?php if(\Auth::user()->is_json_upload ==1): ?>
    		                    <a href="<?php echo e(route('add-site')); ?>">
    		                    <?php else: ?>
    		                    <a data-bs-toggle="modal" data-bs-target="#json_upload">
    		                    <?php endif; ?>
    		                	<div class="card">
    		                        <div class="card-body">
    		                          <div class="row">
    		                            <div class="col-auto">
    			                            <div class="theme-avtar bg-primary">
    			                                <i class="ti ti-plus"></i>
    			                            </div>
    		                          	</div>
    		                            <div class="col">
    		                              <h5 class="mb-3"><?php echo e(__('Add New Site')); ?></h5>
    		                            </div>
    		                          </div>
    		                        </div>
    		                    </div>
    		                  	</a>
    		                </div>
    		            </div>
    		        </div> 
    		    </div>
    		</div>
    	<?php else: ?>
            <div class="col-md-12" style="height: 200px; ">
                <div class="alert alert-primary alert-dismissible fade show text-center" role="alert">
                      <?php echo e(__('No Data Found !')); ?>

                     
                </div>
            </div>
        <?php endif; ?>
	<?php else: ?>
   
        <div class="col-sm-12 ">
            <div class="card">
                <div class="card-header row">
                    <div class="col">
                        <h5><?php echo e(__('Visitor')); ?></h5>
                    </div>
                    <div class="col">
                        <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="week-chart" data-bs-toggle="pill" data-bs-target="#timeline-chart-week" type="button"><?php echo e(__('Week')); ?></button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="15daysago-chart" data-bs-toggle="pill" data-bs-target="#timeline-chart-month" type="button"><?php echo e(__('Month')); ?></button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="year-chart" data-bs-toggle="pill" data-bs-target="#timeline-chart-year" type="button"><?php echo e(__('Year')); ?></button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card-body">
                    <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="timeline-chart-week" role="tabpanel" aria-labelledby="pills-user-tab-1">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="mb-3"><?php echo e(__('Total New Visitors')); ?></h6>
                                                <h5 id="total_visitor_week">0</h5>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="mb-3"><?php echo e(__('Total Returning Visitor')); ?></h6>
                                                <h5 id="total_returning_visitor_week">0</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                       <div   id="user-timeline-chart-week">
                                            <div class="loader " id="progress">
                                          <div class="spinner text-center" style="align-items: center;">
                                            <img height="320px"  src="<?php echo e(asset('assets/images/loader.gif')); ?>" />
                                          </div>
                                        </div>
                                       </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="tab-pane fade" id="timeline-chart-month" role="tabpanel" aria-labelledby="pills-user-tab-2">
                                 <div class="row">
                                    <div class="col-md-2">
                                        <div class="card">
                                        <div class="card-body">
                                            <h6 class="mb-3"><?php echo e(__('Total New Visitors')); ?></h6>
                                            <h5 id="total_visitor_15daysago">0</h5>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="mb-3"><?php echo e(__('Total Returning Visitor')); ?></h6>
                                            <h5 id="total_returning_visitor_15daysago">0</h5>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-10">
                                       <div   id="user-timeline-chart-month">
                                        <div class="loader " id="progress">
                                          <div class="spinner text-center" style="align-items: center;">
                                            <img height="264px"  src="<?php echo e(asset('assets/images/loader.gif')); ?>" />
                                          </div>
                                        </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="tab-pane fade" id="timeline-chart-year" role="tabpanel" aria-labelledby="pills-user-tab-3">
                                 <div class="row">
                                    <div class="col-md-2">
                                        <div class="card">
                                        <div class="card-body">
                                            <h6 class="mb-3"><?php echo e(__('Total New Visitors')); ?></h6>
                                            <h5 id="total_visitor_year">0</h5>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="mb-3"><?php echo e(__('Total Returning Visitor')); ?></h6>
                                            <h5 id="total_returning_visitor_year">0</h5>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-10">
                                       <div   id="user-timeline-chart-year">
                                            <div class="loader " id="progress">
                                          <div class="spinner text-center" style="align-items: center;">
                                            <img height="264px"  src="<?php echo e(asset('assets/images/loader.gif')); ?>" />
                                          </div>
                                        </div>
                                       </div>
                                    </div>
                                    
                                </div>
                            </div>
                    </div>
                </div>
            </div>

                    <div class="row">
                        <div class="col-xxl-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5><?php echo e(__('Users')); ?></h5>
                                </div>
                                <div class="card-body" style="padding: 0px!important">
                                    <div id="usersChart">
                                        <div class="loader " id="progress">
                                          <div class="spinner text-center" style="align-items: center;">
                                            <img height="264px"  src="<?php echo e(asset('assets/images/loader.gif')); ?>" />
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5><?php echo e(__('Bounce Rate')); ?></h5>
                                </div>
                                <div class="card-body" style="padding: 0px!important">
                                    <div id="bounceRateChart">
                                        <div class="loader " id="progress">
                                          <div class="spinner text-center" style="align-items: center;">
                                            <img height="264px"  src="<?php echo e(asset('assets/images/loader.gif')); ?>" />
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5><?php echo e(__('Session Duration')); ?></h5>
                                </div>
                                <div class="card-body" style="padding: 0px!important">
                                    <div id="sessionDuration">
                                        <div class="loader " id="progress">
                                          <div class="spinner text-center" style="align-items: center;">
                                            <img height="264px"  src="<?php echo e(asset('assets/images/loader.gif')); ?>" />
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                      <div class="col-xxl-9">
                        <div class="card">
                                <div class="card-header">
                                    <h5><?php echo e(__('New Users by Location')); ?></h5>
                                </div>
                                <div class="card-body" >
                                        <div class="mapcontainer" style="height: 350px">
                                           
                                        </div>
                                    
                                </div>
                            </div>
                      </div> 
                      <div class="col-xxl-3">
                        <div class="card bg-primary">
                                <div class="card-header">
                                    <h5 class="text-light"><?php echo e(__('Live Active Users')); ?></h5>
                                </div>
                                <div class="card-body text-light" style="text-align:  center!important;">
                                  <div class="display-2">
                                    <i class="ti ti-antenna-bars-5"> </i>
                                  </div>
                                  <div class="display-6" id="live_users">0</div>
                                    <h5 class="text-light"><?php echo e(__('Active Users')); ?></h5>
                                </div>
                            </div>
                      </div> 
                      
                    </div>
                    <div class="row ">
                      <div class="col-xxl-7 d-flex">
                        <div class="card w-100 active-page-table">
                                <div class="card-header">
                                    <h5><?php echo e(__('Top Active Pages')); ?></h5>
                                </div>
                                <div class="card-body" >
                                   <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="thead-light">
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col"><?php echo e(__('Active Page')); ?></th>
                                                <th scope="col"><?php echo e(__('Active Users')); ?></th>
                                                <th scope="col"><?php echo e(__('% New Sessions')); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody id="active_pages"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                      </div> 
                      <div class="col-xxl-5 d-flex">
                        <div class="card w-100">
                                <div class="card-header">
                                    <h5><?php echo e(__('Sessions by device')); ?></h5>
                                </div>
                                <div class="card-body" style="text-align: center!important;padding: 23px 0px!important" >
                                  <div id="session_by_device">
                                       <div class="loader " id="progress">
                                          <div class="spinner text-center" style="align-items: center;">
                                            <img height="500px"  src="<?php echo e(asset('assets/images/loader.gif')); ?>" />
                                          </div>
                                        </div>
                                  </div>
                                </div>
                            </div>
                      </div> 
                      
                    </div>
                </div>
        </div>
   
	<?php endif; ?> 
    
    <div class="col-xl-4 col-md-6">
        <div id="json_upload" class="modal fade" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalPopoversLabel"><?php echo e(__('JSON Update')); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="<?php echo e(route('save-json')); ?>"  enctype="multipart/form-data"> <?php echo csrf_field(); ?>
                        <div class="modal-body">
                            <div class="form-group col-md-12">
                                <label for="json_file" class="col-form-label"><?php echo e(__('Name')); ?></label>
                                <input type="file" class="form-control" id="json_file" name="json_file" required />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn  btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn  btn-primary"><?php echo e(__('Save changes')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="share_dash_report" class="modal fade" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalPopoversLabel"><?php echo e(__('Share Report')); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="<?php echo e(route('save-share-setting','dashboard')); ?>"  enctype="multipart/form-data"> <?php echo csrf_field(); ?>
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="share_site"id="share_site">
                                 <div class="form-group col-md-4">
                                    <label for="name" class="col-form-label"> <?php echo e(__('New User & Returning User report')); ?> </label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input input-primary"
                                            name="new_user_report" id="new_user_report">
                                        <label class="form-check-label" for="new_user_report"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="name" class="col-form-label"> <?php echo e(__('User report')); ?> </label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input input-primary"
                                            name="user_report" id="user_report">
                                        <label class="form-check-label" for="user_report"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="name" class="col-form-label"> <?php echo e(__('Bounce Rate report')); ?> </label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input input-primary"
                                            name="bounce_rate_report" id="bounce_rate_report">
                                        <label class="form-check-label" for="bounce_rate_report"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="name" class="col-form-label"> <?php echo e(__('Session Duration report')); ?> </label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input input-primary"
                                            name="session_duration_report" id="session_duration_report">
                                        <label class="form-check-label" for="session_duration_report"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="name" class="col-form-label"> <?php echo e(__('New Users by Location report')); ?> </label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input input-primary"
                                            name="user_location_report" id="user_location_report">
                                        <label class="form-check-label" for="user_location_report"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="name" class="col-form-label"> <?php echo e(__('Live Active Users report')); ?> </label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input input-primary"
                                            name="live_user_report" id="live_user_report">
                                        <label class="form-check-label" for="live_user_report"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="name" class="col-form-label"> <?php echo e(__('Top Active Pages report')); ?> </label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input input-primary"
                                            name="page_report" id="page_report">
                                        <label class="form-check-label" for="page_report"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="name" class="col-form-label"> <?php echo e(__('Sessions by device report')); ?> </label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input input-primary"
                                            name="device_report" id="device_report">
                                        <label class="form-check-label" for="device_report"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
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
    
    <?php endif; ?>
	<?php endif; ?>
	
<?php if(count($site)>=0 && \Auth::user()->can('manage dashboard')): ?>

  <script type="text/javascript">
    $(function () {
        dash_site_detail() ;
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
 <?php $__env->startPush('script-page'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/vendor/jvectormap-next/jquery-jvectormap.css')); ?>">
<script src="<?php echo e(asset('assets/vendor/jvectormap-next/jquery-jvectormap.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/jvectormap-next/jquery-jvectormap-world-mill.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/chart.js/dist/Chart.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/chart.js/dist/Chart.extension.js')); ?>"></script>
<script type="text/javascript">
    
        function map_chart(data) {

            $('.mapcontainer').empty();
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
    <?php $__env->stopPush(); ?>

    <?php endif; ?>
  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/vps-m2-srv45.nl/anajob.webmojo.online/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>