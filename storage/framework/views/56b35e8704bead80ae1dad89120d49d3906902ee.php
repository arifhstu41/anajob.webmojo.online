<?php
$avatar_path = \App\Models\Utility::get_file('avatars/');
$avatar = url($avatar_path) . '/';
?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage User')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-button'); ?>
    <div class="col-auto">
        <a href="#" class="btn btn-sm btn-primary btn-icon m-1"  style="padding-top: 7px; padding-bottom: 7px;"
            data-bs-toggle="modal"data-bs-target="#create_user"data-size="lg" data-bs-whatever="Create New User">
            <span class="text-white">
                <i class="ti ti-plus" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Create User')); ?>"></i>
            </span>
        </a>

        <?php if(Auth::user()->user_type == 'company'): ?>
            <a href="<?php echo e(route('userlog.index')); ?>" class="btn btn-sm btn-primary btn-icon m-1" data-url="" data-size="lg" style="padding-top: 7px; padding-bottom: 7px;"
                data-bs-whatever="<?php echo e(__('UserlogDetail')); ?>"> <span class="text-white">
                    <i class="ti ti-user" data-bs-toggle="tooltip"
                        data-bs-original-title="<?php echo e(__('Userlog Detail')); ?>"></i></span>
            </a>
        <?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"><?php echo e(__('User')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php if(count($user) > 0): ?>

            <?php if(\Auth::user()->can('manage user')): ?>
                <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-xl-3 col-lg-4 col-sm-6 d-flex">
                        <div class="card w-100">
                            <div class=" border-0 pb-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <div class="badge bg-danger p-2 px-3 rounded ms-3"><?php echo e($val->user_type); ?></div>
                                    </h6>
                                    <div class="btn-group card-option">
                                        <button type="button" class="btn" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item"
                                                data-bs-toggle="modal"data-bs-target="#edit_user"data-size="lg"
                                                onclick="edit_user(<?= $val->id ?>)" data-bs-whatever="<?php echo e('Edit User'); ?>">
                                                <i class="ti ti-edit"></i>
                                                <span><?php echo e(__('Edit')); ?></span>
                                            </a>
                                            <a href="#" class="dropdown-item"
                                                data-bs-toggle="modal"data-bs-target="#reset_password"data-size="lg"
                                                data-bs-whatever="<?php echo e('Reset Paasword'); ?>"
                                                onclick="reset_password(<?= $val->id ?>)">
                                                <i class="ti ti-adjustments"></i>
                                                <span><?php echo e(__('Reset Paasword')); ?></span>
                                            </a>

                                            <a href="<?php echo e(route('userlog.index', ['month' => '', 'user' => $val->id])); ?>"
                                                class="dropdown-item" data-bs-toggle="tooltip"
                                                data-bs-original-title="<?php echo e(__('Loged Details')); ?>">
                                                <i class="ti ti-history"></i>
                                                <span class="ml-2"><?php echo e(__('Loged Details')); ?></span></a>

                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['delete-user', [$val->id]]]); ?>

                                            <a href="#" class="dropdown-item show_confirm"><i class="ti ti-trash"></i>
                                                <span><?php echo e(__('Delete')); ?></span>
                                            </a>
                                            <?php echo Form::close(); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body text-center pb-3">
                                <a href="#" class="avatar rounded-circle avatar-lg hover-translate-y-n3 user_image">
                                    <img
                                        src="<?php echo e(!empty($val->avatar) ? $avatar . $val->avatar : $avatar . 'avatar.png'); ?>">
                                </a>
                                <h5 class="h6 mt-4 mb-0">
                                    <a href="#" class="text-title"><?php echo e($val->name); ?></a>
                                </h5>
                                <span><?php echo e($val->email); ?></span>
                                <hr class="my-3">
                                <div class="row align-items-center"></div>
                                <p class="mt-2 mb-0"></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

        <?php endif; ?>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="#" class="btn-addnew-project " data-bs-toggle="modal" data-bs-target="#create_user"
                data-bs-whatever="Create New User">
                <div class="bg-primary proj-add-icon">
                    <i class="ti ti-plus" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Create User')); ?>"></i>
                </div>
                <h6 class="mt-4 mb-2"><?php echo e(__('New User')); ?></h6>
                <p class="text-muted text-center"><?php echo e(__('Click here to add new user')); ?></p>
            </a>
        </div>
    </div>

    <div class="modal fade " id="create_user" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog moda">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel"><?php echo e(__('Create New User')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="<?php echo e(route('save-user')); ?>"> <?php echo csrf_field(); ?>
                    <div class="modal-body">

                        <div class="form-group" id="site-name-div">
                            <label class="form-label"><?php echo e(__('Name')); ?>:</label>
                            <input type="text" class="form-control" placeholder="Enter Name" name="name"
                                id="name">

                        </div>

                        <div class="form-group" id="property-name-div">
                            <label class="form-label"><?php echo e(__('Email')); ?>:</label>
                            <input type="text" class="form-control" placeholder="Enter Email" name="email"
                                id="email">
                        </div>

                        <div class="form-group" id="view-name-div">
                            <label class="form-label"><?php echo e(__('Password')); ?>:</label>
                            <input type="password" class="form-control" placeholder="Enter Password" name="password"
                                id="password">
                        </div>

                        <div class="form-group" id="view-name-div">
                            <label class="form-label"><?php echo e(__('Role')); ?>:</label>
                            <select class="form-control" name="role" id=role>
                                <option disabled="" selected=""><?php echo e(__('Select role')); ?></option>
                                <?php $__currentLoopData = $role; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val->name); ?>"><?php echo e($val->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary me-2"><?php echo e(__('Submit')); ?></button>
                        <button class="btn btn-secondary"><?php echo e(__('Clear')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade " id="reset_password" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog moda">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel"><?php echo e(__('Reset password')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="<?php echo e(route('reset.password')); ?>"> <?php echo csrf_field(); ?>
                    <div class="modal-body">

                        <input autocomplete="" type="hidden" name="resete_id" id="resete_id">
                        <div class="form-group" id="view-name-div">
                            <label class="form-label"><?php echo e(__('Password')); ?>:</label>
                            <input autocomplete="" type="password" class="form-control" placeholder="Enter Password"
                                name="password" id="new_password">
                        </div>
                        <div class="form-group" id="view-name-div">
                            <label class="form-label"><?php echo e(__('Confirm Password')); ?>:</label>
                            <input autocomplete="" type="password" class="form-control"
                                placeholder="Enter Confirm Password" name="confirm_password" id="confirm_password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary me-2"><?php echo e(__('Update')); ?></button>
                        <button class="btn btn-secondary"><?php echo e(__('Clear')); ?></button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    </div>
    <div class="modal fade " id="edit_user" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog moda">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel"><?php echo e(__('Edit User')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="<?php echo e(route('update-user')); ?>"> <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="user_id">
                        <div class="form-group" id="site-name-div">
                            <label class="form-label"><?php echo e(__('Name')); ?>:</label>
                            <input type="text" class="form-control" placeholder="Enter Name" name="name"
                                id="edit_name">

                        </div>

                        <div class="form-group" id="property-name-div">
                            <label class="form-label"><?php echo e(__('Email')); ?>:</label>
                            <input type="text" class="form-control" placeholder="Enter Email" name="email"
                                id="edit_email">
                        </div>



                        <div class="form-group" id="view-name-div">
                            <label class="form-label"><?php echo e(__('Role')); ?>:</label>
                            <select class="form-control" name="role" id=edit_role>
                                <option disabled="" selected=""><?php echo e(__('Select role')); ?></option>
                                <?php $__currentLoopData = $role; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val->id); ?>"><?php echo e($val->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary me-2"><?php echo e(__('Submit')); ?></button>
                        <button class="btn btn-secondary"><?php echo e(__('Clear')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    
    <script type="text/javascript">
        function edit_user(id) {
            var token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: $("#path_admin").val() + "/edit-user/" + id,
                method: "POST",
                data: {
                    "_token": token
                },
                success: function(data) {

                    $("#user_id").val(data.id);
                    $("#edit_name").val(data.name);
                    $("#edit_email").val(data.email);
                    $('#edit_role option[value="' + data.role_id + '"]').prop('selected', true);

                }
            });


        }

        function reset_password(id) {
            var token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: $("#path_admin").val() + "/edit-user/" + id,
                method: "POST",
                data: {
                    "_token": token
                },
                success: function(data) {

                    $("#resete_id").val(data.id);


                }
            });


        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/vps-m2-srv45.nl/anajob.webmojo.online/resources/views/admin/user/default.blade.php ENDPATH**/ ?>