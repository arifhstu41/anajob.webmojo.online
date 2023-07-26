<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Widget')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-button'); ?>
<div class="d-flex flex-wrap gap-3 mb-2 mb-md-0">
   <div class="">
    <?php if(count($site_data)>0): ?>
      <select class="form-select" name="site_name" id="site-list" onchange=" widget_data(0,0)"> <?php $__currentLoopData = $site_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($val->id); ?>"><?php echo e($val->site_name); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </select>
      <?php endif; ?>
    </div>
    <div class="">
      <div class="input-group mr-sm-2">
        <input type="text" name="date_duration" onchange="widget_data(0,0)" class="form-control date_duration w-100" id="date_duration" />
      </div>
    </div>
    <div class="">
      <button type="button" class="btn  btn-primary" data-bs-toggle="modal" data-bs-target="#add_widget_modal" style="width: max-content;" onclick="get_site_id()">
        <span data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Add Widget')); ?>"><?php echo e(__('Add Widget')); ?></span></button>
    </div>
  </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"><?php echo e(__('Widget')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
 

    <div class=" widget-card-data"></div>

<div class="col-xl-4 col-md-6">
  <div id="add_widget_modal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalPopoversLabel">Add Widget</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST"> <?php echo csrf_field(); ?> <div class="form-group" id="site-name-div">
              <input type="hidden" class="form-control" name="add_id" id="add_id" value="0">
              <label class="form-label">Title:</label>
              <input type="text" class="form-control" placeholder="Enter Title" name="title" id="title">
              <input type="hidden" class="form-control" name="site_id" id="site_id">
            </div>
            <div class="form-group" id="site-name-div">
              <label class="form-label">Metrics:</label>
              <select class="form-select" name="metric_1" id="metric_1"> <?php $__currentLoopData = $metric_option; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($key); ?>"><?php echo e($val); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </select>
            </div>
            <div class="form-group" id="site-name-div">
              <select class="form-select" name="metric_2" id="metric_2"> <?php $__currentLoopData = $metric_option; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($key); ?>"><?php echo e($val); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn  btn-light" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn  btn-primary" onclick="save_widget(1)">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="col-xl-4 col-md-6">
  <div id="edit_widget_modal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalPopoversLabel">Edit Widget</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST"> <?php echo csrf_field(); ?> <div class="form-group" id="site-name-div">
              <input type="hidden" class="form-control" name="edit_id" id="edit_id">
              <label class="form-label">Title:</label>
              <input type="text" class="form-control" placeholder="Enter Title" name="edit_title" id="edit_title">
              <input type="hidden" class="form-control" name="s_id" id="s_id">
            </div>
            <div class="form-group" id="site-name-div">
              <label class="form-label">Metrics:</label>
              <select class="form-select" name="edit_metric_1" id="edit_metric_1"> <?php $__currentLoopData = $metric_option; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($key); ?>"><?php echo e($val); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </select>
            </div>
            <div class="form-group" id="site-name-div">
              <select class="form-select" name="edit_metric_2" id="edit_metric_2"> <?php $__currentLoopData = $metric_option; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($key); ?>"><?php echo e($val); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn  btn-light" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn  btn-primary" data-bs-dismiss="modal" onclick="save_widget(0)">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

$(document).ready(function()
{
    
   widget_data(0,0);

});


</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/vps-m2-srv45.nl/anajob.webmojo.online/resources/views/admin/widget/default.blade.php ENDPATH**/ ?>