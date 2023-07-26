<?php $__env->startPush('scripts'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Alert')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <?php echo e(__('Alert')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Alert')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-button'); ?>
<div class="d-flex align-items-center flex-wrap gap-3">
    
    <div class="">
      <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add_alerts_modal" style="padding-top: 7px; padding-bottom: 7px;"
      ><span><i class="ti ti-plus" data-bs-toggle="tooltip" data-bs-original-title=<?php echo e(__('Create Alert')); ?>></i></span></button>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="col-sm-12">
    <div class="card">
        <div class="card-body table-bAletr-style">
           
            <div class="table-responsive overflow_hidden">
                <table id="pc-dt-simple" class="table datatable align-items-center">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name"> <?php echo e(__('Id')); ?></th>
                            <th scope="col"><?php echo e(__('Title')); ?></th>
                            <th scope="col"><?php echo e(__('Site Name')); ?></th>
                            <th scope="col" class="sort" data-sort="completion"> <?php echo e(__('Metric')); ?></th>
                            <th scope="col"><?php echo e(__('Description')); ?></th>
                            <th scope="col" class="sort" data-sort="completion"> <?php echo e(__('Duration')); ?></th>
                            <th scope="col" class="sort" data-sort="completion"> <?php echo e(__('Email Notification')); ?></th>
                            <th scope="col" class="sort" data-sort="completion"> <?php echo e(__('Slack Notification')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($val->id); ?></td>
                                <td><?php echo e($val->title); ?></td>
                                <td><?php echo e($val->site->site_name); ?></td>
                                <td><?php echo e($val->metric); ?></td>
                                <td><?php echo e($val->description); ?></td>
                                <td><?php echo e($val->duration); ?></td>
                                <td>
                                    <?php if($val->email_notification == '1'): ?>
                                       <?php echo e(__('On')); ?>

                                    <?php else: ?>
                                         <?php echo e(__('Off')); ?>

                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($val->slack_notification == '1'): ?>
                                       <?php echo e(__('On')); ?>

                                    <?php else: ?>
                                         <?php echo e(__('Off')); ?>

                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="add_alerts_modal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPopoversLabel"><?php echo e(__('Add Aletr')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="<?php echo e(route('save-aletr')); ?>"  enctype="multipart/form-data"> <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="title" class="col-form-label"><?php echo e(__('Aletr Title')); ?></label>
                            <div class="form-icon-user">
                                <input class="form-control" type="text"  id="title"name="title" placeholder="<?php echo e(__('Aletr Title')); ?>">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="site_id" class="col-form-label"> <?php echo e(__('Site')); ?> </label>
                            <select class="form-select" name="site_id" id="site_id">
                                <option selected="" disabled=""><?php echo e(__('Select Site')); ?></option>
                                <?php $__currentLoopData = $site; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                    <option value="<?php echo e($val->id); ?>"><?php echo e($val->site_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="metric" class="col-form-label"> <?php echo e(__('Metric')); ?> </label>
                            <select class="form-select" name="metric" id="metric">
                                <option selected="" disabled=""><?php echo e(__('Select Metrics')); ?></option>
                               <?php $__currentLoopData = $metric_option; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($key); ?>"><?php echo e($val); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                         <div class="form-group col-md-3">
                            <label for="email_notification" class="col-form-label"> <?php echo e(__('Email Nofication')); ?> </label>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input input-primary"name="email_notification" id="email_notification">
                                <label class="form-check-label" for="email_notification"></label>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="slack_notification" class="col-form-label"> <?php echo e(__('Slack notification')); ?> </label>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input input-primary"
                                    name="slack_notification" id="slack_notification">
                                <label class="form-check-label" for="slack_notification"></label>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name" class="col-form-label"> <?php echo e(__('Frequency of alerts')); ?> </label>
                            <select class="form-select" name="duration" id="duration">
                                <option selected="" disabled=""><?php echo e(__('Select Duration')); ?></option>
                                <option value="daily"><?php echo e(__('Daily')); ?></option>
                                <option value="weekly"><?php echo e(__('Weekly')); ?></option>
                                <option value="monthly"><?php echo e(__('Monthly')); ?></option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 mb-0">
                            <div class="form-group">
                                <label for="description" class="col-form-label"><?php echo e(__('Description')); ?></label>
                                <textarea class="form-control" id="description" name="description"></textarea>
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
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/vps-m2-srv45.nl/anajob.webmojo.online/resources/views/alert/default.blade.php ENDPATH**/ ?>