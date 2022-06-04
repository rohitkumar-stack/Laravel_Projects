<?php $__env->startSection('title', 'Roles Permission - Enthucate'); ?>
<?php $__env->startSection('content'); ?>

<!--**********************************
	Content body start
***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-xxl-12 col-lg-12">
            <div class="invitemembersuccess"></div>
            <?php if(session()->has('success')): ?>
                  <div class="alert alert-success" id="successMessage" style="white-space: pre-line;"><?php echo e(session()->get('success')); ?></div>
                <?php endif; ?>
                <?php if(session()->has('error')): ?>
                   <div class="alert alert-danger" id="errorMessage">
                        <?php echo e(session()->get('error')); ?>

                    </div>
                <?php endif; ?>
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger" id="errorMessage">
                       <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                       </ul>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-xl-12">
                        <form method="post" id="role_permission">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="role" id="role" value="">
                            <div class="card profile-card">
                                <div class="card-header flex-wrap border-0 pb-0">
                                    <h3 class="fs-24 text-black font-w600 mr-auto mb-2 pr-3">Roles And Permissions</h3>
                                    <div class="d-sm-flex d-block">
                                        <button type="submit" id="submit_role_permission" class="btn btn-primary btn-rounded mb-2">Save</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-5">
                                        <div class="row mb-4">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Select Role</label>
                                                    <select class="form-control rolepermission" id="rolepermission" name="role_id" required>
                                                        <option value="">Select Role</option>
                                                        <?php if(!empty($roletypes)): ?>
                                                            <?php $__currentLoopData = $roletypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roletype): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($roletype->id); ?>"><?php echo e($roletype->role); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="mb-4 col-sm-12"><span class="fs-18 text-black font-w600">Organisation</span></div>
                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check org_add orle" id="customCheckBox1"  name="org_add" />
                                                    <label class="custom-control-label" for="customCheckBox1">Add</label>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check org_edit" id="customCheckBox2"  name="org_edit" />
                                                    <label class="custom-control-label" for="customCheckBox2">Edit</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check org_delete" id="customCheckBox3"  name="org_delete" />
                                                    <label class="custom-control-label" for="customCheckBox3">Delete</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="mb-4 col-sm-12"><span class="fs-18 text-black font-w600">Department</span></div>

                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check department_add"  id="customCheckBox4" name="department_add" />
                                                    <label class="custom-control-label" for="customCheckBox4">Add</label>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check department_edit" id="customCheckBox5"  name="department_edit"/>
                                                    <label class="custom-control-label" for="customCheckBox5">Edit</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check department_delete" id="customCheckBox6"  name="department_delete" />
                                                    <label class="custom-control-label" for="customCheckBox6">Delete</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="mb-4 col-sm-12"><span class="fs-18 text-black font-w600">Groups</span></div>

                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check group_add" id="customCheckBox19"  name="group_add" />
                                                    <label class="custom-control-label" for="customCheckBox19">Add</label>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check group_edit" id="customCheckBox20"  name="group_edit" />
                                                    <label class="custom-control-label" for="customCheckBox20">Edit</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check group_delete" id="customCheckBox18"  name="group_delete" />
                                                    <label class="custom-control-label" for="customCheckBox18">Delete</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="mb-4 col-sm-12"><span class="fs-18 text-black font-w600">School</span></div>

                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check school_add"  id="customCheckBox41" name="school_add" />
                                                    <label class="custom-control-label" for="customCheckBox41">Add</label>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check school_edit" id="customCheckBox51"  name="school_edit"/>
                                                    <label class="custom-control-label" for="customCheckBox51">Edit</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check school_delete" id="customCheckBox61"  name="school_delete" />
                                                    <label class="custom-control-label" for="customCheckBox61">Delete</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="mb-4 col-sm-12"><span class="fs-18 text-black font-w600">Grade</span></div>

                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check grade_add"  id="customCheckBox411" name="grade_add" />
                                                    <label class="custom-control-label" for="customCheckBox411">Add</label>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check grade_edit" id="customCheckBox511"  name="grade_edit"/>
                                                    <label class="custom-control-label" for="customCheckBox511">Edit</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check grade_delete" id="customCheckBox611"  name="grade_delete" />
                                                    <label class="custom-control-label" for="customCheckBox611">Delete</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="mb-4 col-sm-12"><span class="fs-18 text-black font-w600">Class</span></div>

                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check class_add"  id="customCheckBox4111" name="class_add" />
                                                    <label class="custom-control-label" for="customCheckBox4111">Add</label>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check class_edit" id="customCheckBox5111"  name="class_edit"/>
                                                    <label class="custom-control-label" for="customCheckBox5111">Edit</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check class_delete" id="customCheckBox6111"  name="class_delete" />
                                                    <label class="custom-control-label" for="customCheckBox6111">Delete</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="mb-4 col-sm-12"><span class="fs-18 text-black font-w600">Users</span></div>

                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check user_add" id="customCheckBox12"  name="user_add" />
                                                    <label class="custom-control-label" for="customCheckBox12">Add</label>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check user_edit" id="customCheckBox13" name="user_edit"  />
                                                    <label class="custom-control-label" for="customCheckBox13">Edit</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check user_delete" id="customCheckBox14" name="user_delete"  />
                                                    <label class="custom-control-label" for="customCheckBox14">Delete</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="mb-4 col-sm-12"><span class="fs-18 text-black font-w600">Message</span></div>

                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check message_add" id="customCheckBox17"  name="message_add" />
                                                    <label class="custom-control-label" for="customCheckBox17">Add</label>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check message_edit" id="customCheckBox16"  name="message_edit" />
                                                    <label class="custom-control-label" for="customCheckBox16">Edit</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check message_delete" id="customCheckBox15"  name="message_delete" />
                                                    <label class="custom-control-label" for="customCheckBox15">Delete</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check message_receiver" id="customCheckBox7"  name="message_receiver" />
                                                    <label class="custom-control-label" for="customCheckBox7">Receiver</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check message_sender" id="customCheckBox8"  name="message_sender" />
                                                    <label class="custom-control-label" for="customCheckBox8">Sender</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check message_create_group" id="customCheckBox9"  name="message_create_group" />
                                                    <label class="custom-control-label" for="customCheckBox9">Create Group</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check message_admin" id="customCheckBox10"  name="message_admin" />
                                                    <label class="custom-control-label" for="customCheckBox10">Admin</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input role_check message_approve_message" id="customCheckBox11"  name="message_approve_message" />
                                                    <label class="custom-control-label" for="customCheckBox11">Approve Urgent Messages</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page_script'); ?>
<script type="text/javascript">
  
   $('#Membersearch').click(function(){
      $('form#myForm').submit();
});
   $(".invitesaccept").click(function(){
     var id = $(this).attr('id');
     $('#acceptid').val(id);
     });
   $(".invitesreject").click(function(){
     var id = $(this).attr('id');
     $('#rejecttid').val(id);
     });
   
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.superadmin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sites/enthucate/resources/views/superadmin/dashboard/roles-permission.blade.php ENDPATH**/ ?>