<?php $__env->startPush('scripts'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Aletr History')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <?php echo e(__('Aletr History')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Aletr History')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-button'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php if(count($data)>0): ?>
<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class=" col-xxl-4">
    <div class="card price-card price-1 wow animate__fadeInUp">
        <div class="card-header border-0 pb-0">
            <div class="d-flex  align-items-center">
                <div class="bg-primary theme-avtar me-2 " ><h3 class="mb-0 badge" style="font-family: cursive;font-size: xx-large;"> <?=substr($val->site->site_name,0,1);?></h3></div>
                <div class="gap-4">
                     <h5 class="mb-0 "><a class="text-dark" href="https://demo.rajodiya.com/erpgo-saas/projects/7"><?php echo e($val->site->site_name); ?></a></h5>
                </div>
                   
            </div>

            <div class="card-header-right">
                <div class="btn-group card-option">
                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti ti-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                       
                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['delete-alert-history', [$val->id]]]); ?>

                            <a href="#!" class="dropdown-item bs-pass-para show_confirm">
                                <i class="ti ti-archive"></i><span> Delete</span>
                            </a>
                        <?php echo Form::close(); ?>

                       
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <span class="price-badge bg-primary"><?=ucfirst($val->detail->duration)?> <?php echo e(__('Alert')); ?></span>
            <div class="text-center">
                <div ><span class="badge alert-primary" style="padding: 25px 25px;border-radius: 50%;"> <i data-feather="alert-triangle"></i></span>
                </div>
            </div>
            <h6 class="text-center text-dark mt-3"><?php echo e($val->title); ?></h6>
            <h6 class="text-center text-muted text-sm mt-3"><?php echo e($val->description); ?></h6>
           
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/vps-m2-srv45.nl/anajob.webmojo.online/resources/views/alert/history.blade.php ENDPATH**/ ?>