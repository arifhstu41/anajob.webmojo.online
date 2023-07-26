<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Roles')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Role')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
<div class="col-auto">
    <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="modal"  style="padding-top: 7px; padding-bottom: 7px;"
    data-bs-target="#exampleModal" data-url="<?php echo e(route('create.roles')); ?>"  data-size="lg"
    data-bs-whatever="<?php echo e(__('Create New Role')); ?>" > <span class="text-white">
        <i class="ti ti-plus text-white" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Create')); ?>"></i></span>
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                <h5></h5>
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Role')); ?> </th>
                                <th><?php echo e(__('Permissions')); ?> </th>
                                <th width="200px"><?php echo e(__('Action')); ?> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="Role"><?php echo e($role->name); ?></td>
                                        <td class="Permission">
                                            <?php for($j=0;$j<count($role->permissions()->pluck('name'));$j++): ?>
                                                 <span class="badge rounded p-2 m-1 px-3 bg-primary"><?php echo e($role->permissions()->pluck('name')[$j]); ?></span>
                                            <?php endfor; ?>
                                        </td>
                                        <td class="Action">
                                            <span>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit role')): ?>
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="modal" data-size="lg"
                                                        data-bs-target="#exampleModal" data-url="<?php echo e(route('roles.edit',$role->id)); ?>"
                                                        data-bs-whatever="<?php echo e(__('Edit Role')); ?>" > <span class="text-white"> <i
                                                                class="ti ti-edit" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Edit')); ?>"></i></span></a>
                                                </div>
                                            <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete role')): ?>
                                                

                                                <div class="action-btn bg-danger ms-2" style="padding-top: 20px;"> 
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id]]); ?>

                                                    <a href="#!" class="mx-3 btn btn-sm align-items-center show_confirm ">
                                                        <i class="ti ti-trash text-white" data-bs-toggle="tooltip"
                                                            data-bs-original-title="<?php echo e(__('Delete')); ?>"></i>
                                                    </a>
                                                    <?php echo Form::close(); ?>

            
            
                                                </div>
                                                <?php endif; ?>
                                            </span>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/vps-m2-srv45.nl/anajob.webmojo.online/resources/views/role/index.blade.php ENDPATH**/ ?>