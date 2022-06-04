<?php $__env->startSection('title', 'grade List - Enthucate'); ?>
<?php $__env->startSection('content'); ?>
<!--**********************************
	Content body start
***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
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
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title col-sm-2">Grades</h4>
                        <div class="col-sm-4">
                          <div class="form-group">
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
                        <div class="col-sm-4">
                           <div class="form-group">
                           <select class="form-control selectschoolvalue" id="selectschoolvalue" name="school">
                                <option value="">Select School</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-sm-4">
                          <button type="button" class="btn btn-primary btn-rounded mb-2 searchgrade">Search</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="example3_wrapper" class="dataTables_wrapper no-footer">
                                <table id="example3" class="display table-responsive-lg dataTable no-footer grade_list" role="grid" aria-describedby="example3_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Name: activate to sort column ascending">#</th>
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Name: activate to sort column ascending">Organisation Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Name: activate to sort column ascending">School Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Group: activate to sort column ascending">Grade</th>
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Action: activate to sort column ascending">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- delete Organisation -->
<div class="modal fade" id="deletegrade" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header border-bottom-0">
            <h4 class="modal-title text-center" id="exampleModalLabel">Delete Grade</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i aria-hidden="true" class="ki ki-close"></i>
            </button>
         </div>
         <div class="modal-body py-0">
            Are you sure want to delete this Grade?                                    
         </div>
         <form class="form" method="POST" id="gradedelete" action="<?php echo e(url('/superadmin/delete-grade/')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="grade_id" id="grade_id" value="">
            <div class="modal-footer border-top-0">
               <button type="button" class="btn btn-dark light btn-rounded mr-3 mb-2" data-dismiss="modal">Cancel</button>
               <button type="submit" class="btn btn-primary btn-rounded mb-2 gradedelete">Delete</button>
            </div>
         </form>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page_script'); ?>
<script type="text/javascript">
    // $(document).ready(function() {
    //     $('.departments_list').DataTable();
    // } );
    var searchorderTable;
    jQuery(document).ready(function() {
      // searchorderTable= $("#sample_2").DataTable(); 
      var organisation = '';
      var school = '';
      load_departmentlist(organisation,school);
    });
    function load_departmentlist(organisation,school){
        siteurl = jQuery('#siteurl').val();
        searchorderTable = jQuery('.grade_list').DataTable({
        info: true,
        cache: false,
        destroy: true,
        pageLength: 10,
        searching: true,
        serverSide: true,
        processing: false,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        ajax: {
          url : siteurl+"/superadmin/gradelist" ,
          type: "get",
          dataType: "json",
          data: function (d) {
                d.organisation = organisation;
                d.schools = school;
                d._token = $("#csrftoken").val();
            },
          dataFilter: function (response) {
            return response;
          },
        },
        columns: [
          { orderable: false, data: "orderno" },
          { orderable: false, data: "organisation_name" },
          { orderable: false, data: "school" },
          { orderable: false, data: "grade_name" },
          { orderable: false, data: "action" },
        ],
      });
    }

$(document).on('click','.searchgrade',function(){  
   var organisation = jQuery('#seleorganisationid').val();
   var school = jQuery('#selectschoolvalue').val();
   // alert(organisation+'==='+school);
  load_departmentlist(organisation,school);
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.superadmin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sites/enthucate/resources/views/superadmin/grade/grade.blade.php ENDPATH**/ ?>