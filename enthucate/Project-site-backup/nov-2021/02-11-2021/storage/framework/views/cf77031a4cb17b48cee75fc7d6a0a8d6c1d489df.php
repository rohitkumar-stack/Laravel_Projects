 <?php $__env->startSection('title', 'Message Add - Enthucate'); ?> <?php $__env->startSection('content'); ?>
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
                        <div class="card profile-card">
                            <div class="card-header flex-wrap border-0 pb-0">
                                <h3 class="fs-24 text-black font-w600 mr-auto mb-2 pr-3">Messages</h3>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <!-- Nav tabs -->
                                    <div class="custom-tab-1">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link <?php if(old('message_type') != 'group' && old('message_type') != 'school'): ?> active <?php endif; ?>" data-toggle="tab" href="#home1" id="departments_tab"><i class="fa fa-building mr-2"></i>Departments</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link <?php if(old('message_type') == 'group'): ?> active <?php endif; ?>" data-toggle="tab" href="#profile1" id="groups_tab"><i class="fa fa-users mr-2"></i> Groups</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link <?php if(old('message_type') == 'school'): ?> active <?php endif; ?>" data-toggle="tab" href="#contact1" id="schools_tab"><i class="fa fa-university mr-2"></i> Schools</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade <?php if(old('message_type') != 'group' && old('message_type') != 'school'): ?> show active <?php endif; ?> " id="home1" role="tabpanel">
                                                <div class="pt-4">
                                                     <form method="POST" action="<?php echo e(url('/superadmin/save-message' )); ?>" enctype="multipart/form-data" autocomplete="off">
                                                     <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="message_type" value="department">

                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Organisation <span class="requried">*</span></label>
                                                                    <select class="form-control seleorganisation_id" name="organisation" id="seleorganisationid">
                                                                        <option value="">Select Organisation</option>
                                                                        <?php if(!empty($organisations)): ?> <?php $__currentLoopData = $organisations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organisation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($organisation->id); ?>"><?php echo e($organisation->organisation_name); ?></option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php endif; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Select Department <span class="requried">*</span></label>
                                                                    <!-- <div class="dropdown bootstrap-select show-tick form-control"> -->
                                                                        <select name="department[]" class="form-control selectdepartmentvalue" id="selectdepartmentvalue" tabindex="-98"> </select>
                                                                    <!-- </div> -->
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Subject Title <span class="requried">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Enter Title" id="subject" name="subject" value="<?php echo e(old('subject')); ?>" />
                                                                </div>
                                                            </div>
                                                             <div class="col-sm-6">
                                                                <div class="form-group mb-3">
                                                                    <label style="width: 100%;">Category <span class="requried">*</span></label>
                                                                    <select class="form-control" name="message_category" id="">
                                                                        <option value="">Select Category</option>
                                                                        <?php if(!empty($messagecategory)): ?> <?php $__currentLoopData = $messagecategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->category); ?></option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php endif; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group mb-3">
                                                                    <label style="width: 100%;">Message Priority <span class="requried">*</span></label>
                                                                    <div class="form-control message_priorty">
                                                                    <label class="radio-inline mr-3"><input type="radio" name="message_priority" value="Normal" checked /> Normal</label>
                                                                    <label class="radio-inline mr-3"><input type="radio" name="message_priority" value="Urgent" /> Urgent</label>
                                                                    <label class="radio-inline mr-3"><input type="radio" name="message_priority" value="Critical" /> Critical</label>
                                                                </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Message <span class="requried">*</span></label>
                                                                    <textarea class="form-control" rows="4" id="message" name="message"><?php echo e(old('message')); ?></textarea>
                                                                </div>
                                                            </div>
                                                             <div id="insert_image_001" class="insert_image_value insert_image_value_001 col-sm-12 mb-2"></div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <span class="only-file">
                                                                        <input type="file" class="uploadattachment" id="uploadimage" name="attachment[]" multiple accept=".jpg,.png,.jpeg,.xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf" data-id="001" />
                                                                        <i for="upload" class="fa fa-paperclip"></i>
                                                                        Attachments
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 message_right">
                                                                <button type="button" class="btn btn-dark light btn-rounded mr-3 mb-2">Cancel</button>
                                                                <button type="submit" class="btn btn-primary btn-rounded mb-2">Send</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade <?php if(old('message_type') == 'group'): ?> show active <?php endif; ?>" id="profile1">
                                                <div class="pt-4">
                                                     <form method="POST" action="<?php echo e(url('/superadmin/save-message' )); ?>" enctype="multipart/form-data" autocomplete="off">
                                                     <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="message_type" value="group">                                                    
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Organisation <span class="requried">*</span></label>
                                                                    <select class="form-control seleorganisation_id" name="organisation" id="seleorganisationid">
                                                                        <option value="">Select Organisation</option>
                                                                        <?php if(!empty($organisations)): ?> <?php $__currentLoopData = $organisations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organisation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($organisation->id); ?>"><?php echo e($organisation->organisation_name); ?></option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php endif; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Select Group <span class="requried">*</span></label>
                                                                    <!-- <div class="dropdown bootstrap-select show-tick form-control"> -->
                                                                        <select name="group[]" class="form-control selectgroupvalue" id="selectgroupvalue" tabindex="-98"> </select>
                                                                   <!--  </div> -->
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Subject Title <span class="requried">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Enter Title" id="subject" name="subject" value="<?php echo e(old('subject')); ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group mb-3">
                                                                    <label style="width: 100%;">Category <span class="requried">*</span></label>
                                                                    <select class="form-control" name="message_category" id="">
                                                                        <option value="">Select Category</option>
                                                                        <?php if(!empty($messagecategory)): ?> <?php $__currentLoopData = $messagecategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->category); ?></option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php endif; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group mb-3">
                                                                    <label style="width: 100%;">Message Priority <span class="requried">*</span></label>
                                                                    <div class="form-control message_priorty">
                                                                    <label class="radio-inline mr-3"><input type="radio" name="message_priority" value="Normal" checked /> Normal</label>
                                                                    <label class="radio-inline mr-3"><input type="radio" name="message_priority" value="Urgent" /> Urgent</label>
                                                                    <label class="radio-inline mr-3"><input type="radio" name="message_priority" value="Critical" /> Critical</label>
                                                                </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Message <span class="requried">*</span></label>
                                                                    <textarea class="form-control" rows="4" id="message" name="message"><?php echo e(old('message')); ?></textarea>
                                                                </div>
                                                            </div>
                                                             <div id="insert_image_002" class="insert_image_value insert_image_value_002 col-sm-12 mb-2"></div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <span class="only-file">
                                                                        <input type="file" class="uploadattachment" id="uploadimage" name="attachment[]" multiple accept=".jpg,.png,.jpeg,.xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf" data-id="002" />
                                                                        <i for="upload" class="fa fa-paperclip"></i>
                                                                        Attachments
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 message_right">
                                                                <button type="button" class="btn btn-dark light btn-rounded mr-3 mb-2">Cancel</button>
                                                                <button type="submit" class="btn btn-primary btn-rounded mb-2">Send</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade <?php if(old('message_type') == 'school'): ?> show active <?php endif; ?>" id="contact1">
                                                <div class="pt-4">
                                                     <form method="POST" action="<?php echo e(url('/superadmin/save-message' )); ?>" enctype="multipart/form-data" autocomplete="off">
                                                     <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="message_type" value="school">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Organisation <span class="requried">*</span></label>
                                                                    <select class="form-control seleorganisation_id" name="organisation" id="seleorganisationid">
                                                                        <option value="">Select Organisation</option>
                                                                        <?php if(!empty($organisations)): ?> <?php $__currentLoopData = $organisations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organisation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($organisation->id); ?>"><?php echo e($organisation->organisation_name); ?></option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php endif; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Select School <span class="requried">*</span></label>
                                                                    <!-- <div class="dropdown bootstrap-select show-tick form-control"> -->
                                                                        <select class="form-control selectschoolvalue" name="school[]" id="selectschoolvalue" tabindex="-98"> </select>
                                                                    <!-- </div> -->
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Subject Title <span class="requried">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Enter Title" id="subject" name="subject" value="<?php echo e(old('subject')); ?>" />
                                                                </div>
                                                            </div>
                                                             <!-- <div class="col-sm-6">
                                                                <div class="form-group mb-3">
                                                                    <label style="width: 100%;">Filters <span class="requried">*</span></label>
                                                                    <select class="form-control" name="filters" id="">
                                                                        <option value="">Select Filters</option>
                                                                        <option value="1">All School</option>
                                                                        <option value="2">Grades</option>
                                                                        <option value="3">Classes(Subset of grades)</option>
                                                                    </select>
                                                                </div>
                                                            </div> -->
                                                            <div class="col-sm-12 mb-4">
                                                            <label style="width: 100%;">Recipients <span class="requried">*</span></label>
                                                                <div class="row">            
                                                                <div class="col-sm-3">
                                                                    <div class="custom-control custom-checkbox mb-3">
                                                                    <input type="checkbox" class="custom-control-input role_check school_add_all"  id="customCheckBox41" name="recipientsall" value="" />
                                                                    <label class="custom-control-label" for="customCheckBox41">All</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="custom-control custom-checkbox mb-3">
                                                                    <input type="checkbox" class="custom-control-input role_check school_add"  id="customCheckBox41t" name="recipients[]" value="9"/>
                                                                    <label class="custom-control-label" for="customCheckBox41t">Teachers</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="custom-control custom-checkbox mb-3">
                                                                    <input type="checkbox" class="custom-control-input role_check school_add"  id="customCheckBox41s" name="recipients[]" value="10"/>
                                                                    <label class="custom-control-label" for="customCheckBox41s">Students</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="custom-control custom-checkbox mb-3">
                                                                    <input type="checkbox" class="custom-control-input role_check school_add"  id="customCheckBox41p" name="recipients[]" value="11"/>
                                                                    <label class="custom-control-label" for="customCheckBox41p">Parents</label>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group mb-3">
                                                                    <label style="width: 100%;">Category <span class="requried">*</span></label>
                                                                    <select class="form-control" name="message_category" id="">
                                                                        <option value="">Select Category</option>
                                                                        <?php if(!empty($messagecategory)): ?> <?php $__currentLoopData = $messagecategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->category); ?></option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php endif; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group mb-3">
                                                                    <label style="width: 100%;">Message Priority <span class="requried">*</span></label>
                                                                    <div class="form-control message_priorty">
                                                                    <label class="radio-inline mr-3"><input type="radio" name="message_priority" value="Normal" checked /> Normal</label>
                                                                    <label class="radio-inline mr-3"><input type="radio" name="message_priority" value="Urgent" /> Urgent</label>
                                                                    <label class="radio-inline mr-3"><input type="radio" name="message_priority" value="Critical" /> Critical</label>
                                                                </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Message <span class="requried">*</span></label>
                                                                    <textarea class="form-control" rows="4" id="message" name="message"><?php echo e(old('message')); ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div id="insert_image_003" class="insert_image_value insert_image_value_003 col-sm-12 mb-2"></div> 
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <span class="only-file">
                                                                        <input type="file" class="uploadattachment" id="uploadimage" name="attachment[]" multiple accept=".jpg,.png,.jpeg,.xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf" data-id="003" />
                                                                        <i for="upload" class="fa fa-paperclip"></i>
                                                                        Attachments
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 message_right">
                                                                <button type="button" class="btn btn-dark light btn-rounded mr-3 mb-2">Cancel</button>
                                                                <button type="submit" class="btn btn-primary btn-rounded mb-2">Send</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?> <?php $__env->startSection('page_script'); ?>
<script type="text/javascript">
    jQuery(document).on("click", "#departments_tab", function () {
        jQuery("#selectdepartmentvalue").selectpicker("refresh");
        jQuery("#selectgroupvalue").selectpicker("refresh");
        jQuery("#selectschoolvalue").selectpicker("refresh");
    });
    jQuery(document).on("click", "#groups_tab", function () {
        jQuery("#selectdepartmentvalue").selectpicker("refresh");
        jQuery("#selectgroupvalue").selectpicker("refresh");
        jQuery("#selectschoolvalue").selectpicker("refresh");
    });
    jQuery(document).on("click", "#schools_tab", function () {
        jQuery("#selectdepartmentvalue").selectpicker("refresh");
        jQuery("#selectgroupvalue").selectpicker("refresh");
        jQuery("#selectschoolvalue").selectpicker("refresh");
    });

$('.school_add_all').on('click',function(){
    if($('input[name=recipientsall]').is(':checked')){
      $('.school_add').prop('checked',true);
    }else{
      $('.school_add').prop('checked',false);       
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.superadmin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sites/enthucate/resources/views/superadmin/message/addmessage.blade.php ENDPATH**/ ?>