<?php $__env->startSection('title', 'Department Add - Enthucate'); ?>
<?php $__env->startSection('content'); ?>
<!--**********************************
	Content body start
***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
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
            <div class="col-xl-12 col-xxl-12 col-lg-12">
                <div class="row">
                    <div class="col-xl-12">
                        <form  method="POST" action="<?php echo e(url('/superadmin/save-department' )); ?>" enctype="multipart/form-data" autocomplete="off">
                        <?php echo csrf_field(); ?>
                            <div class="card profile-card">
                                <div class="card-header flex-wrap border-0 pb-0">
                                    <h3 class="fs-24 text-black font-w600 mr-auto mb-2 pr-3">Add Department</h3>
                                    <div class="d-sm-flex d-block">
                                        <button type="submit" class="btn btn-dark light btn-rounded mr-3 mb-2">Cancel</button>
                                        <button type="submit" class="btn btn-primary btn-rounded mb-2">Save Changes</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-5">
                                        <div class="row">
                                        <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Organisation <span class="requried">*</span></label>
                                                   <select class="form-control seleorganisation_id" name="organisation" id="seleorganisationid">
                                                        <option value="">Select Organisation</option> 
                                                        <?php if(!empty($organisations)): ?>
                                                            <?php $__currentLoopData = $organisations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organisation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($organisation->id); ?>"><?php echo e($organisation->organisation_name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Department *</label>
                                                    <input type="text" class="form-control" placeholder="Enter name"  name="department_name" value="<?php echo e(old('department_name')); ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <input type="text" class="form-control" placeholder="Enter Description" name="description" value="<?php echo e(old('description')); ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 selectmember">
                                                <div class="form-group">
                                                    <label>Members</label>
                                                    <div class="dropdown bootstrap-select show-tick form-control">
                                                        <select name="members[]" multiple="" class="form-control selectmembervalue"  tabindex="-98" id="selectmembervalue">
                                                            <option value="">Select Members</option> 
                                                           <!--  <?php if(!empty($members)): ?>
                                                                <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($member->id); ?>"><?php echo e($member->name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?> -->
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Message Create Members </label>
                                                    <div class="dropdown bootstrap-select show-tick form-control">
                                                        <select name="create_members[]" multiple="" class="form-control" id="sel2" tabindex="-98">
                                                            <option value="">Select Create Members</option> 
                                                            <?php if(!empty($members)): ?>
                                                                <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($member->id); ?>"><?php echo e($member->name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div>                                    	
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.superadmin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sites/enthucate/resources/views/superadmin/department/adddepartment.blade.php ENDPATH**/ ?>