<?php $__env->startSection('title', 'Edit Users - Enthucate'); ?>
<?php $__env->startSection('content'); ?>
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-xxl-12 col-lg-12">
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
                         <form method="POST" action="<?php echo e(url(Auth::User()->organisation_url.'/admin/update-user/'.$user->id )); ?>" enctype="multipart/form-data" autocomplete="off">
                            <?php echo csrf_field(); ?>
                            <?php
                            $schoolid = array();
                            if($user->school_id != ''){
                                $schoolid = explode(',', $user->school_id);
                            }
                            $sortname = '';
                            $phonecode = App\Models\Country::where('phonecode',$user->country_code)->first();
                            if(!empty($phonecode)){
                               $sortname = $phonecode->sortname; 
                            }
                            ?>
                            <input type="hidden" name="organisation" value="<?php echo e($user->organisation_id); ?>">
                            <div class="card profile-card">
                                <div class="card-header flex-wrap border-0 pb-0">
                                    <h3 class="fs-24 text-black font-w600 mr-auto mb-2 pr-3">Edit Users</h3>
                                    <div class="d-sm-flex d-block">
                                        <button type="button" class="btn btn-dark light btn-rounded mr-3 mb-2">Cancel</button>
                                        <button type="submit" class="btn btn-primary btn-rounded mb-2">Save/Send</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-5">
                                        <div class="title mb-4"><span class="fs-18 text-black font-w600">Create Users</span></div>
                                        <div class="row">
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Full Name <span class="requried">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Enter name" name="name" value="<?php echo e($user->name); ?>"/>
                                                </div>
                                            </div>

                                            <!-- <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Username <span class="requried">*</span></label>
                                                    <input type="text" class="form-control" placeholder="User name" name="username" value="<?php echo e($user->username); ?>"/>
                                                </div>
                                            </div> -->
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Position Title</label>
                                                    <input type="text" class="form-control" placeholder="Position Title" name="position_title" value="<?php echo e($user->position_title); ?>"/>
                                                </div>
                                            </div>
                                            <!-- <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Position</label>
                                                    <input type="text" class="form-control" placeholder="Enter Position" />
                                                </div>
                                            </div> -->
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Role <span class="requried">*</span></label>
                                                        <select class="form-control selerole_id" id="selerole" name="role">
                                                        <option value="">Select Role</option> 
                                                        <?php if(!empty($roletypes)): ?>
                                                            <?php $__currentLoopData = $roletypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roletype): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                  <?php if($roletype->id != '9' && $roletype->id != '10' && $roletype->id != '11'): ?>
                                                                    <option <?php if($user->role_id == $roletype->id): ?> selected <?php endif; ?> value="<?php echo e($roletype->id); ?>"><?php echo e($roletype->role); ?></option>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                           <!--  <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Organisation <span class="requried">*</span></label>
                                                    <select class="form-control seleorganisation_id" id="seleorganisationid" name="organisation">
                                                        <option value="">Select Organisation</option> 
                                                        <?php if(!empty($organisations)): ?>
                                                            <?php $__currentLoopData = $organisations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organisation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($organisation->id); ?>"><?php echo e($organisation->organisation_name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div> -->
                                             <!-- <div class="col-xl-4 col-sm-6 selectdepartment">
                                                <div class="form-group">
                                                    <label>Department <span class="requried">*</span></label>
                                                    <select class="form-control selectdepartmentvalue" id="selectdepartmentvalue" name="department">
                                                    <option value="">Select Department</option>
                                                    <?php if(!empty($departments)): ?>
                                                            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($department->id); ?>"  <?php if($user->department_id == $department->id): ?> selected <?php endif; ?> ><?php echo e($department->department_name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>  -->
                                            <div class="col-xl-4 col-sm-6 selectschool userschool" <?php if($user->role_id != 2 && $user->role_id != 6 && $user->role_id != 8): ?> style="display:block" <?php else: ?> style="display:none" <?php endif; ?>>
                                                <div class="form-group">
                                                    <label>School <span class="requried">*</span></label>
                                                    <select class="form-control selectschoolvalue" id="selectschoolvalue" name="school[]" multiple="">
                                                    <option value="">Select School</option>
                                                    <?php if(!empty($schools)): ?>
                                                            <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option <?php if($user->role_id == $roletype->id): ?> selected <?php endif; ?> value="<?php echo e($roletype->id); ?>"><?php echo e($roletype->role); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Email Address <span class="requried">*</span></label>
                                                    <div class="input-group input-icon mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="las la-envelope"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="Enter email" name="email" value="<?php echo e($user->email); ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Mobile Number <span class="requried">*</span></label>
                                                    <div class="input-group input-icon mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                                        </div>
                                                      <input type="hidden" name="country_code" class="country_code" id="country_code" value="<?php echo e($user->country_code); ?>">
                                                      
                                                        <input type="text" class="form-control pl-3" placeholder="Phone no." name="mobile_number" id="mobile_number" value=""/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Mobile Number (Whatsapp)</label>
                                                    <div class="input-group input-icon mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
                                                        </div>

                                                        <input type="text" class="form-control" placeholder="Phone no." name="whatsapp" value="<?php echo e($user->whatsapp); ?>" />
                                                    </div>
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
<link rel="stylesheet" href="<?php echo e(asset('public/assets/css/intlTelInput.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page_script'); ?>
  <script src="<?php echo e(asset('public/assets/js/intlTelInput.js')); ?>"></script>
<script>

$(window).on('load', function() {
    var mobile_number = '<?php echo $user->mobile_number; ?>';
    var sortname = '<?php echo $sortname; ?>';
  $(document).on("click", ".iti__country", function () {
    var code = $(this).attr('data-dial-code');
    $('#country_code').val(code);
  })
    var input = document.querySelector("#mobile_number");
    window.intlTelInput(input, {        
      geoIpLookup: function(callback) {
        if(sortname == ''){
              $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
              var countryCode = (resp && resp.country) ? resp.country : "";
              callback(countryCode);
              setTimeout(function () {
              var code = $('li.iti__country.iti__standard.iti__active').attr('data-dial-code');
              $('#country_code').val(code);
              $('#mobile_number').val(mobile_number);
            }, 100);
            });  
        }
        else{
            var countryCode = sortname;
              callback(countryCode);
              setTimeout(function () {
              var code = $('li.iti__country.iti__standard.iti__active').attr('data-dial-code');
              $('#country_code').val(code);
              $('#mobile_number').val(mobile_number);
            }, 100);
        }
        
      },
      initialCountry: "auto",
      utilsScript: "<?php echo e(asset('public/assets/js/utils.js')); ?>",
    });
    });
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sites/enthucate/resources/views/admin/user/edituser.blade.php ENDPATH**/ ?>