<?php
    $avatar = \App\Models\Utility::get_file('avatars/');
?>


<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage User Logs')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('User Logs')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="col-sm-12 col-lg-12 col-xl-12 col-md-12">
    <div class=" mt-2 " id="multiCollapseExample1" style="">
        <div class="card">
            <div class="card-body">
                <?php echo e(Form::open(['route' => ['userlog.index'], 'method' => 'get', 'id' => 'userlogin_filter'])); ?>

                <div class="d-flex align-items-center justify-content-end">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                        <div class="btn-box">
                            <?php echo e(Form::label('select_month', __('Select Month'), ['class' => 'form-label'])); ?>

                            <input type="month" name="month" class="form-control" value="<?php echo e(isset($_GET['month']) ? $_GET['month'] : ''); ?>" placeholder ="">
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                        <div class="btn-box">
                            <?php echo e(Form::label('user', __('user'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('user', $usersList, isset($_GET['user']) ? $_GET['user'] : '', ['class' => 'form-control select ','id'=>'user_id'])); ?>

                        </div>
                    </div>
                    
                    <div class="col-auto float-end ms-2 mt-4">
                        <a href="#" class="btn btn-sm btn-primary"
                            onclick="document.getElementById('userlogin_filter').submit(); return false;"
                            data-bs-toggle="tooltip" title="" data-bs-original-title="apply">
                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                        </a>

                        <a href="<?php echo e(route('userlog.index')); ?>" class="btn btn-sm btn-danger"
                            data-bs-toggle="tooltip" title="" data-bs-original-title="Reset">
                            <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                        </a>
                    </div>

                </div>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
</div>

<div class="col-xl-12">
    <div class="card">
        <div class="card-header card-body table-border-style">
            <h5></h5>
            <div class="table-responsive">
                <table class="table" id="pc-dt-simple">
                    <thead>
                        <tr>
                            <th><?php echo e(__('Name')); ?></th>
                            <th><?php echo e(__('Role')); ?></th>
                            <th><?php echo e(__('Ip')); ?></th>
                            <th><?php echo e(__('Last Login At')); ?></th>
                            <th><?php echo e(__('Country')); ?></th>
                            <th><?php echo e(__('Device Type')); ?></th>
                            <th><?php echo e(__('Os Name')); ?></th>
                            <th><?php echo e(__('Details')); ?></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                <?php
                                    $json = json_decode($user->details);
                                ?>
                                
                                <td><?php echo e($user->user_name); ?></td>
                                <td><span class="badge rounded p-2 m-1 px-3 bg-primary"><?php echo e($user->type); ?></span></td>
                                <td><?php echo e($user->ip); ?></td>
                                <td><?php echo e($user->date); ?></td>
                                <td><?php echo e($json->country); ?></td>
                                <td><?php echo e($json->device_type); ?></td>
                                <td><?php echo e($json->os_name); ?></td>
                                <td> 
                                    <div class="action-btn bg-info ms-2">
                                        <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                            data-bs-toggle="modal" data-size="lg" data-bs-target="#exampleModal"
                                            data-url="<?php echo e(route('userlog.view', [$user->id])); ?>"
                                            data-bs-whatever="<?php echo e(__('View User Logs')); ?>" data-size="lg"> <span
                                                class="text-white"> <i class="ti ti-eye" data-bs-toggle="tooltip"
                                                    data-bs-original-title="<?php echo e(__('View')); ?>"></i></span></a>
                                    </div>

                                    <div class="action-btn bg-danger ms-2" style="padding-top: 20px;"> 
                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['userlog.destroy', $user->id]]); ?>

                                        <a href="#!" class="mx-3 btn btn-sm align-items-center show_confirm ">
                                            <i class="ti ti-trash text-white" data-bs-toggle="tooltip"
                                                data-bs-original-title="<?php echo e(__('Delete')); ?>"></i>
                                        </a>
                                        <?php echo Form::close(); ?>



                                    </div>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/vps-m2-srv45.nl/anajob.webmojo.online/resources/views/user_log/index.blade.php ENDPATH**/ ?>