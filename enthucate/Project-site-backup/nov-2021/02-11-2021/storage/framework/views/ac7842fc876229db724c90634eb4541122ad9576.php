<?php $__env->startSection('title', 'Dashboard - Enthucate'); ?>
<?php $__env->startSection('content'); ?>

<!--**********************************
	Content body start
***********************************-->
<div class="content-body" style="min-height: 1100px;">
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
			<div class="col-xl-3 col-xxl-6 col-sm-6">
				<div class="card bg-primary">
					<div class="card-body ">
						<div class="media align-items-center">
							<span class="p-3 mr-3 border border-white rounded">
								<i class="fa fa-sitemap icon-size"></i>
							</span>
							<div class="media-body text-right">
								<p class="fs-18 text-white mb-2">Organisations</p>
								<span class="fs-48 text-white font-w600"><?php echo e($orgcount); ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-xxl-6 col-sm-6">
				<div class="card bg-secondary">
					<div class="card-body">
						<div class="media align-items-center">
							<span class="p-3 mr-3 border border-white rounded">
								<i class="fa fa-university icon-size"></i>
							</span>
							<div class="media-body text-right">
								<p class="fs-18 text-white mb-2">Schools</p>
								<span class="fs-48 text-white font-w600"><?php echo e($school); ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-xxl-6 col-sm-6">
				<div class="card bg-info">
					<div class="card-body">
						<div class="media align-items-center">
							<span class="p-3 mr-3 border border-white rounded">
								<i class="fa fa-users icon-size"></i>
							</span>
							<div class="media-body text-right">
								<p class="fs-18 text-white mb-2">Groups</p>
								<span class="fs-48 text-white font-w600"><?php echo e($group); ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-xxl-6 col-sm-6">
				<div class="card bg-success">
					<div class="card-body">
						<div class="media align-items-center">
							<span class="p-3 mr-3 border border-white rounded">
								<i class="fa fa-building icon-size"></i>
							</span>
							<div class="media-body text-right">
								<p class="fs-18 text-white mb-2">Departments</p>
								<span class="fs-48 text-white font-w600"><?php echo e($department); ?></span>
							</div>
						</div>
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
<?php echo $__env->make('layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sites/enthucate/resources/views/admin/dashboard/dashboard.blade.php ENDPATH**/ ?>