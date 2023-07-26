
    <?php echo e(Form::model($role,array('route' => array('roles.update', $role->id), 'method' => 'PUT'))); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('name',__('Name'),['class' => 'col-form-label'])); ?>

                <?php echo e(Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Role Name')))); ?>

                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-name text-danger text-xs" role="alert"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php if(!empty($permissions)): ?>
                    <label for="permissions" class="form-control-label"><?php echo e(__('Assign Permission to Roles')); ?></label>
                    <table class="table">
                        <tr>
                            <th class="text-dark"><?php echo e(__('Module')); ?> </th>
                            <th class="text-dark"><?php echo e(__('Permissions')); ?> </th>
                        </tr>
                        <?php
                         $modules=['user','site','widget','dashboard','share report settings','share report','quick view','analytic','channel analytic','pages analytic','audience analytic','seo analytic','custom analytic']; 
                            if(Auth::user()->type == 'company'){
                                $modules[] = 'language';
                                $modules[] = 'permission';
                                $modules[] = 'system settings';
                            }
                        ?>
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                
                                <td><?php echo e(ucfirst(__($module))); ?></td>
                                <td>
                                    <div class="row">
                                        <?php if(in_array('manage '.$module,(array) $permissions)): ?>
                                            <?php if($key = array_search('manage '.$module,$permissions)): ?>
                                                <div class="col-md-3 custom-control custom-checkbox">
                    <?php echo e(Form::checkbox('permissions[]', $key, $role->permission, ['class'=>'form-check-input isscheck isscheck_'.str_replace(' ', '', $module),'id' => 'permission' . $key])); ?>

                                                    <?php echo e(Form::label('permission'.$key,'Manage',['class'=>'custom-control-label'])); ?><br>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if(in_array('create '.$module,(array) $permissions)): ?>
                                            <?php if($key = array_search('create '.$module,$permissions)): ?>
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    <?php echo e(Form::checkbox('permissions[]', $key, $role->permission, ['class'=>'form-check-input isscheck isscheck_'.str_replace(' ', '', $module),'id' => 'permission' . $key])); ?>

                                                    <?php echo e(Form::label('permission'.$key,'Create',['class'=>'custom-control-label'])); ?><br>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if(in_array('edit '.$module,(array) $permissions)): ?>
                                            <?php if($key = array_search('edit '.$module,$permissions)): ?>
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    <?php echo e(Form::checkbox('permissions[]', $key, $role->permission, ['class'=>'form-check-input isscheck isscheck_'.str_replace(' ', '', $module),'id' => 'permission' . $key])); ?>

                                                    <?php echo e(Form::label('permission'.$key,'Edit',['class'=>'custom-control-label'])); ?><br>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if(in_array('delete '.$module,(array) $permissions)): ?>
                                            <?php if($key = array_search('delete '.$module,$permissions)): ?>
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    <?php echo e(Form::checkbox('permissions[]', $key, $role->permission, ['class'=>'form-check-input isscheck isscheck_'.str_replace(' ', '', $module),'id' => 'permission' . $key])); ?>

                                                    <?php echo e(Form::label('permission'.$key,'Delete',['class'=>'custom-control-label'])); ?><br>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if(in_array('associate '.$module,(array) $permissions)): ?>
                                            <?php if($key = array_search('associate '.$module,$permissions)): ?>
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    <?php echo e(Form::checkbox('permissions[]', $key, $role->permission, ['class'=>'form-check-input isscheck isscheck_'.str_replace(' ', '', $module),'id' => 'permission' . $key])); ?>

                                                    <?php echo e(Form::label('permission'.$key,'Associate',['class'=>'custom-control-label '])); ?><br>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if(in_array('show '.$module,(array) $permissions)): ?>
                                            <?php if($key = array_search('show '.$module,$permissions)): ?>
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    <?php echo e(Form::checkbox('permissions[]', $key, $role->permission, ['class'=>'form-check-input isscheck isscheck_'.str_replace(' ', '', $module),'id' => 'permission' . $key])); ?>

                                                    <?php echo e(Form::label('permission'.$key,'Show',['class'=>'custom-control-label'])); ?><br>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if(in_array('move '.$module,(array) $permissions)): ?>
                                            <?php if($key = array_search('move '.$module,$permissions)): ?>
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    <?php echo e(Form::checkbox('permissions[]', $key, $role->permission, ['class'=>'form-check-input isscheck isscheck_'.str_replace(' ', '', $module),'id' => 'permission' . $key])); ?>

                                                    <?php echo e(Form::label('permission'.$key,'Move',['class'=>'custom-control-label'])); ?><br>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if(in_array('client permission '.$module,(array) $permissions)): ?>
                                            <?php if($key = array_search('client permission '.$module,$permissions)): ?>
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    <?php echo e(Form::checkbox('permissions[]', $key, $role->permission, ['class'=>'form-check-input isscheck isscheck_'.str_replace(' ', '', $module),'id' => 'permission' . $key])); ?>

                                                    <?php echo e(Form::label('permission'.$key,'Client Permission',['class'=>'custom-control-label'])); ?><br>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if(in_array('invite user '.$module,(array) $permissions)): ?>
                                            <?php if($key = array_search('invite user '.$module,$permissions)): ?>
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    <?php echo e(Form::checkbox('permissions[]', $key, $role->permission, ['class'=>'form-check-input isscheck isscheck_'.str_replace(' ', '', $module),'id' => 'permission' . $key])); ?>

                                                    <?php echo e(Form::label('permission'.$key,'Invite User ',['class'=>'custom-control-label'])); ?><br>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if(in_array('change password '.$module,(array) $permissions)): ?>
                                            <?php if($key = array_search('change password '.$module,$permissions)): ?>
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    <?php echo e(Form::checkbox('permissions[]', $key, $role->permission, ['class'=>'form-check-input isscheck isscheck_'.str_replace(' ', '', $module),'id' => 'permission' . $key])); ?>

                                                    <?php echo e(Form::label('permission'.$key,'Change Password ',['class'=>'custom-control-label'])); ?><br>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if(in_array('buy '.$module,(array) $permissions)): ?>
                                            <?php if($key = array_search('buy '.$module,$permissions)): ?>
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    <?php echo e(Form::checkbox('permissions[]', $key, $role->permission, ['class'=>'form-check-input isscheck isscheck_'.str_replace(' ', '', $module),'id' => 'permission' . $key])); ?>

                                                    <?php echo e(Form::label('permission'.$key,'Buy',['class'=>'custom-control-label'])); ?><br>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn  btn-light" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
            <?php echo e(Form::submit(__('Update'),array('class'=>'btn  btn-primary'))); ?>

        </div>
    </div>
    <?php echo e(Form::close()); ?>

    <script>
        $(document).ready(function() {
            $("#checkall").click(function() {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
            $(".ischeck").click(function() {
                var ischeck = $(this).data('id');
                $('.isscheck_' + ischeck).prop('checked', this.checked);
            });
        });
    </script>
<?php /**PATH /var/www/vhosts/vps-m2-srv45.nl/anajob.webmojo.online/resources/views/role/edit.blade.php ENDPATH**/ ?>