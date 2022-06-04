<?php $__env->startSection('title', 'Organisation List - Enthucate'); ?>
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
                        <h4 class="card-title">Organisation</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="example3_wrapper" class="dataTables_wrapper no-footer">                                                              
                                <table id="example3" class="display table-responsive-lg dataTable no-footer organisations_list" role="grid" aria-describedby="example3_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Name: activate to sort column ascending">Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Department: activate to sort column ascending">Level</th>
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Gender: activate to sort column ascending">Email</th>
                                            <th class="sorting" tabindex="0" aria-controls="example3" aria-label="Action: activate to sort column ascending">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        if(!empty($results)){
                                            if(isset($results['organisations']) && $results['organisations'] != ''){
                                                foreach ($results['organisations'] as $key => $result) { 
                                                    $hierarchy = App\Models\Hierarchy::where('id', $result->hierarchy_id)->first();
                                                    ?>
                                                    <tr role="row">
                                                    <td><?php echo e($result->organisation_name); ?></td>
                                                    <td><?php echo e($hierarchy->level_name); ?></td>
                                                    <td>
                                                        <a href="javascript:void(0);"><strong><?php echo e($result->email); ?></strong></a>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="<?php echo e(url('/superadmin/edit-organisation/'.$result->id )); ?>" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                            <!-- <a href="<?php echo e(url('/superadmin/delete-organisation/'.$result->id )); ?>" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a> -->
                                                            <a href="javascript:void(0)" class="btn btn-danger shadow btn-xs sharp markorganisationdelete" data-id="<?php echo e($result->id); ?>" data-toggle="modal" data-target="#markdelete" title="Delete Organisation" data-placement="right" ><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                    ?>
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
<div class="modal fade" id="markdelete" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header border-bottom-0">
            <h4 class="modal-title text-center" id="exampleModalLabel">Delete Organisation</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i aria-hidden="true" class="ki ki-close"></i>
            </button>
         </div>
         <div class="modal-body py-0">
            Are you sure want to delete this Organisation?                                    
         </div>
         <form class="form" method="POST" id="organisationdelete" action="<?php echo e(url('/superadmin/delete-organisation/')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="organisation_id" id="deleteorganisation" value="">
            <div class="modal-footer border-top-0">
               <button type="button" class="btn btn-dark light btn-rounded mr-3 mb-2" data-dismiss="modal">Cancel</button>
               <button type="submit" class="btn btn-primary btn-rounded mb-2 organisationdelete">Delete</button>
            </div>
         </form>
      </div>
   </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page_script'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.organisations_list').DataTable();
    } );
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.superadmin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sites/enthucate/resources/views/superadmin/organisation/organisation.blade.php ENDPATH**/ ?>