<!--**********************************
         Sidebar start
      ***********************************-->
      <?php
         $org_adds = App\Models\RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','org_add')->first();
         $department_add = App\Models\RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','department_add')->first();
         $group_add = App\Models\RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','group_add')->first();
         $user_add = App\Models\RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','user_add')->first();
         $message_add = App\Models\RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','message_add')->first();  
         $school_add = App\Models\RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','school_add')->first();
         $grade_add = App\Models\RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','grade_add')->first();
         $class_add = App\Models\RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','class_add')->first();
         $message_add = App\Models\RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','message_add')->first();        
         
      ?>
      <div class="deznav">
      <div class="deznav-scroll">
      <ul class="metismenu" id="menu">
         <li><a class="ai-icon" href="<?php echo e(URL(Auth::User()->organisation_url.'/admin')); ?>" aria-expanded="false">
               <i class="flaticon-381-networking"></i>
               <span class="nav-text">Dashboard</span>
            </a>
            
         </li>
         <?php if(Auth::User()->hierarchy_id != 5 && Auth::User()->hierarchy_id != ''): ?>
         <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
               <i class="fa fa-sitemap"></i>
               <span class="nav-text">Organisation</span>
            </a>
            <ul aria-expanded="false">
               <?php if(isset($org_adds->meta_value) && $org_adds->meta_value == 'on'): ?>
               <li><a href="<?php echo e(URL(Auth::User()->organisation_url.'/admin/add-organisation')); ?>">Add Organisation</a></li>
               <?php endif; ?>
               <li><a href="<?php echo e(URL(Auth::User()->organisation_url.'/admin/organisation-list')); ?>">List</a></li>
               
            </ul>
         </li>
         <?php endif; ?>
         
         <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
               <i class="fa fa-building"></i>
               <span class="nav-text">Departments</span>
            </a>
            <ul aria-expanded="false">
               <?php if(isset($department_add->meta_value) && $department_add->meta_value == 'on'): ?>
               <li><a href="<?php echo e(URL(Auth::User()->organisation_url.'/admin/add-department')); ?>">Add Department</a></li>
               <?php endif; ?>
               <li><a href="<?php echo e(URL(Auth::User()->organisation_url.'/admin/department-list')); ?>">List</a></li>
               
            </ul>
         </li>
         
         <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
               <i class="fa fa-users"></i>
               <span class="nav-text">Groups</span>
            </a>
            <ul aria-expanded="false">
            <?php if(isset($group_add->meta_value) && $group_add->meta_value == 'on'): ?>
               <li><a href="<?php echo e(URL(Auth::User()->organisation_url.'/admin/add-group')); ?>">Create Groups</a></li>
               <?php endif; ?>
               <li><a href="<?php echo e(URL(Auth::User()->organisation_url.'/admin/group-list')); ?>">List Group</a></li>
               
            </ul>
         </li>
         <?php if(Auth::User()->hierarchy_id != 5): ?>
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                  <i class="fa fa-university"></i>
                  <span class="nav-text">Schools</span>
               </a>
               <ul aria-expanded="false">
                  <li>
                     <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <span class="nav-text">School</span>
                     </a>
                     <ul aria-expanded="false" class="sub_sub_menus">
                        <?php if(isset($school_add->meta_value) && $school_add->meta_value == 'on'): ?>
                        <li><a href="<?php echo e(URL(Auth::User()->organisation_url.'/admin/add-school')); ?>">Add Schools</a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo e(URL(Auth::User()->organisation_url.'/admin/school-list')); ?>">List Schools</a></li>
                     </ul>
                  </li>
                   <li>
                     <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <span class="nav-text">Grade</span>
                     </a>
                     <ul aria-expanded="false" class="sub_sub_menus">
                        <?php if(isset($grade_add->meta_value) && $grade_add->meta_value == 'on'): ?>
                        <li><a href="<?php echo e(URL(Auth::User()->organisation_url.'/admin/add-grade')); ?>">Add Grade</a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo e(URL(Auth::User()->organisation_url.'/admin/grade-list')); ?>">List Grade</a></li>
                     </ul>
                  </li>
                  <li>
                     <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <span class="nav-text">Class</span>
                     </a>
                     <ul aria-expanded="false" class="sub_sub_menus">
                        <?php if(isset($class_add->meta_value) && $class_add->meta_value == 'on'): ?>
                        <li><a href="<?php echo e(URL(Auth::User()->organisation_url.'/admin/add-class')); ?>">Add Class</a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo e(URL(Auth::User()->organisation_url.'/admin/class-list')); ?>">List Class</a></li>
                     </ul>
                  </li>
                  
               </ul>
            </li> 
         <?php endif; ?>
         <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
               <i class="flaticon-381-user-7"></i>
               <span class="nav-text">Users</span>
            </a>
            
            <ul aria-expanded="false">
               <?php if(isset($user_add->meta_value) && $user_add->meta_value == 'on'): ?>
               <li><a href="<?php echo e(URL(Auth::User()->organisation_url.'/admin/add-user')); ?>">Add Users</a></li>
               <?php endif; ?>
               <li><a href="<?php echo e(URL(Auth::User()->organisation_url.'/admin/user-list')); ?>">List</a></li>
               
            </ul>
            
         </li>
         <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
               <i class="fa fa-envelope color-danger"></i>
               <span class="nav-text messagecount">Messages</span>
            </a>
            <ul aria-expanded="false">
               <?php if(isset($message_add->meta_value) && $message_add->meta_value == 'on'): ?>
               <li><a href="<?php echo e(URL(Auth::User()->organisation_url.'/admin/add-message')); ?>">Add Message</a></li>
               <?php endif; ?>
               <li><a href="<?php echo e(URL(Auth::User()->organisation_url.'/admin/message-list')); ?>">List</a></li>
               
            </ul>
         </li>
      </ul>


      </div>
      </div>
      <!--**********************************
         Sidebar end
      ***********************************--><?php /**PATH /var/www/sites/enthucate/resources/views/includes/admin_sidebar.blade.php ENDPATH**/ ?>