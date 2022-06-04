<?php $__env->startSection('content'); ?>
<div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
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
                      <?php if($error == 'The password format is invalid.'): ?>
                      <li>Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.</li>
                      <?php else: ?>
                      <li><?php echo e($error); ?></li>
                      <?php endif; ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   </ul>
                </div>
                <br />
                <?php endif; ?>
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                    
                                        <a href="javascript:void(0)"><img src="<?php echo e(asset('public/assets/images/logo.png')); ?>" alt=""></a>
                                    </div>
                                    <h4 class="text-center mb-4 text-white">Sign in your account</h4>
                                   <form method="POST" action="<?php echo e(route('login')); ?>">
                                     <?php echo csrf_field(); ?>
                                     <input type="hidden" name="status" value="1">
                                     <input type="hidden" name="is_del" value="0">
                                        <div class="form-group">
                                            <label class="mb-1 text-white"><strong>Email/Mobile Number</strong></label>
                                            <input type="text" class="form-control email" id="email" name="email" <?php if(Cookie:: has('adminuser')): ?> value="<?php echo e(Cookie::get('adminuser')); ?>" <?php else: ?> value="<?php echo e(old('email')); ?>" <?php endif; ?> placeholder="Enter Email/Mobile Number">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1 text-white"><strong>Password</strong></label>
                                            <input type="password" id="password" name="password" class="form-control password" <?php if(Cookie:: has('adminpassword')): ?> value="<?php echo e(Cookie::get('adminpassword')); ?>"  <?php endif; ?> placeholder="Enter Password">
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                               <div class="custom-control custom-checkbox ml-1 text-white">
                                                    <input type="checkbox" class="custom-control-input remember_me" id="remember_me" name="remember_me" value="1" <?php if(Cookie:: has('adminuser')): ?>  checked  <?php endif; ?> >
                                                    <label class="custom-control-label" for="remember_me">Remember my preference</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <a class="text-white" href="<?php echo e(url('password-forgot')); ?>">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-white text-primary btn-block">Sign Me In</button>
                                        </div>
                                    </form>
                                   <!--  <div class="new-account mt-3">
                                        <p class="text-white">Don't have an account? <a class="text-white" href="<?php echo e(route('register')); ?>">Sign up</a></p>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sites/enthucate/resources/views/auth/login.blade.php ENDPATH**/ ?>