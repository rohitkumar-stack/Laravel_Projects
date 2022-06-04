<?php $__env->startSection('title', 'Organisation Edit - Enthucate'); ?>
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
            <?php
            $sortname = '';
            $phonecode = App\Models\Country::where('phonecode',$organisations->country_code)->first();
            if(!empty($phonecode)){
               $sortname = $phonecode->sortname; 
            }

            ?>
                <div class="row">                
                    <div class="col-xl-12">
                         <form method="POST" action="<?php echo e(url(Auth::User()->organisation_url.'/admin/update-organisation/'.$organisations->id )); ?>">
                           <?php echo csrf_field(); ?>
                            <div class="card profile-card">
                                <div class="card-header flex-wrap border-0 pb-0">
                                    <h3 class="fs-24 text-black font-w600 mr-auto mb-2 pr-3">Edit Organisation</h3>
                                    <div class="d-sm-flex d-block">
                                        <button type="button" class="btn btn-dark light btn-rounded mr-3 mb-2">Cancel</button>
                                        <button type="submit" class="btn btn-primary btn-rounded mb-2">Save Changes</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-5">
                                        <div class="title mb-4"><span class="fs-18 text-black font-w600">Generals</span></div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Name Of Organisation *</label>
                                                    <input type="text" class="form-control" placeholder="Enter name"  name="organisation_name" value="<?php echo e($organisations->organisation_name); ?>" />
                                                </div>
                                            </div>
                                            <!-- <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Level Name *</label>
                                                    <select class="form-control" name="level_name" >
                                                        <option value="">Select Level Name</option>
                                                        <?php if(!empty($hierarchys)): ?>
	                                                        <?php $__currentLoopData = $hierarchys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hierarchy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                                        	<option value="<?php echo e($hierarchy->id); ?>" <?php if($hierarchy->id == $organisations->hierarchy_id): ?> selected <?php endif; ?>><?php echo e($hierarchy->level_name); ?></option>
	                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>License Type *</label>
                                                    <select class="form-control" name="license_type" >
	                                                     <option value="">Select License Type</option>
	                                                    <?php if(!empty($hierarchyLicense)): ?>
		                                                    <?php $__currentLoopData = $hierarchyLicense; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hierarchy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                                                    	<option value="<?php echo e($hierarchy->id); ?>" <?php if($hierarchy->id == $organisations->license_type): ?> selected <?php endif; ?>><?php echo e($hierarchy->license_type); ?></option>
		                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                                                	<?php endif; ?>
                                                    </select>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>

                                    <div class="mb-5">
                                        <div class="title mb-4"><span class="fs-18 text-black font-w600">Primary Contact Details</span></div>
                                        <div class="row">
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Full Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter name" name="name" value="<?php echo e($organisations->name); ?>" />
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input type="text" class="form-control" placeholder="User name" name="username" value="<?php echo e($organisations->username); ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Position Title</label>
                                                    <input type="text" class="form-control" placeholder="Position Title" name="position_title" value="<?php echo e($organisations->position_title); ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-5">
                                        <div class="title mb-4"><span class="fs-18 text-black font-w600">Secondary CONTACT DETAILS</span></div>
                                        <div class="row">
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Mobile Number</label>
                                                    <div class="input-group input-icon mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                                        </div>
                                                         <input type="hidden" name="country_code" class="country_code" id="country_code" value="<?php echo e($organisations->country_code); ?>">
                                                         
                                                        <input type="text" class="form-control pl-3" placeholder="Phone no." name="mobile_number"  id="mobile_number" value=""/>
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
                                                        <input type="text" class="form-control" placeholder="Phone no." name="whatsapp" value="<?php echo e($organisations->whatsapp); ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Email Address</label>
                                                    <div class="input-group input-icon mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="las la-envelope"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="Enter email" name="email" value="<?php echo e($organisations->email); ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Office Address</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="Enter address" name="address" value="<?php echo e($organisations->address); ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Country</label>
                                                    <select class="form-control selectcountry" name="country">
                                                        <option value="">Select country</option> 
                                                        <?php if(!empty($countries)): ?>
                                                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($country->id); ?>" <?php if($organisations->country == $country->id): ?> selected <?php endif; ?> ><?php echo e($country->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6 selectstate">
                                                <div class="form-group">
                                                    <label>State</label>
                                                    <select class="form-control selectstatevalue" id="selectstatevalue" name="state">
                                                        <option value="">Select State</option> 
                                                        <?php if(!empty($states)): ?>
                                                            <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($state->id); ?>" <?php if($organisations->state == $state->id): ?> selected <?php endif; ?> ><?php echo e($state->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6 selectcity">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <select class="form-control selectcityvalue"  id="selectcityvalue" name="city">
                                                        <option value="">Select City</option> 
                                                        <?php if(!empty($cities)): ?>
                                                            <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($city->id); ?>" <?php if($organisations->city == $city->id): ?> selected <?php endif; ?> ><?php echo e($city->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </select>
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
    var mobile_number = '<?php echo $organisations->mobile_number; ?>';
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
<?php echo $__env->make('layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sites/enthucate/resources/views/admin/organisation/editorganisation.blade.php ENDPATH**/ ?>