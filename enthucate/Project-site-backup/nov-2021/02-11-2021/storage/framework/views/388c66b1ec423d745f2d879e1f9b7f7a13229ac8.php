<!--**********************************
         Sidebar start
      ***********************************-->
      <div class="deznav">
      <div class="deznav-scroll">
      <ul class="metismenu" id="menu">
         <li><a class="ai-icon" href="<?php echo e(url('superadmin/dashboard')); ?>" aria-expanded="false">
               <i class="flaticon-381-networking"></i>
               <span class="nav-text">Dashboard</span>
            </a>
            
         </li>
         <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
               <i class="fa fa-sitemap"></i>
               <span class="nav-text">Organisation</span>
            </a>
            <ul aria-expanded="false">
               <li><a href="<?php echo e(url('superadmin/add-organisation')); ?>">Add Organisation</a></li>
               <li><a href="<?php echo e(url('superadmin/organisation-list')); ?>">List</a></li>
               
            </ul>
         </li>
         
         <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
               <i class="fa fa-building"></i>
               <span class="nav-text">Departments</span>
            </a>
            <ul aria-expanded="false">
               <li><a href="<?php echo e(url('superadmin/add-department')); ?>">Add Department</a></li>
               <li><a href="<?php echo e(url('superadmin/department-list')); ?>">List</a></li>
               
            </ul>
         </li>
         
         <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
               <i class="fa fa-users"></i>
               <span class="nav-text">Groups</span>
            </a>
            <ul aria-expanded="false">
               <li><a href="<?php echo e(url('superadmin/add-group')); ?>">Create Groups</a></li>
               <li><a href="<?php echo e(url('superadmin/group-list')); ?>">List Group</a></li>
               
            </ul>
         </li>
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
                        <li><a href="<?php echo e(url('superadmin/add-school')); ?>">Add Schools</a></li>
                        <li><a href="<?php echo e(url('superadmin/school-list')); ?>">List Schools</a></li>
                     </ul>
                  </li>
                   <li>
                     <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <span class="nav-text">Grade</span>
                     </a>
                     <ul aria-expanded="false" class="sub_sub_menus">
                        <li><a href="<?php echo e(url('superadmin/add-grade')); ?>">Add Grade</a></li>
                        <li><a href="<?php echo e(url('superadmin/grade-list')); ?>">List Grade</a></li>
                     </ul>
                  </li>
                  <li>
                     <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <span class="nav-text">Class</span>
                     </a>
                     <ul aria-expanded="false" class="sub_sub_menus">
                        <li><a href="<?php echo e(url('superadmin/add-class')); ?>">Add Class</a></li>
                        <li><a href="<?php echo e(url('superadmin/class-list')); ?>">List Class</a></li>
                     </ul>
                  </li>
                  
               </ul>
            </li>
         <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
               <i class="flaticon-381-user-7"></i>
               <span class="nav-text">Users</span>
            </a>
            
            <ul aria-expanded="false">
               <li><a href="<?php echo e(url('superadmin/add-user')); ?>">Add Users</a></li>
               <li><a href="<?php echo e(url('superadmin/user-list')); ?>">List</a></li>
               
            </ul>
            
         </li>
         <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
               <i class="fa fa-envelope color-danger"></i>
               <span class="nav-text messagecount">Messages</span>
            </a>
            <ul aria-expanded="false">
               <li><a href="<?php echo e(url('superadmin/add-message')); ?>">Add Messages</a></li>
               <li><a href="<?php echo e(url('superadmin/message-list')); ?>">List</a></li>
               
            </ul>
         </li>
         <li><a class="ai-icon" href="<?php echo e(url('superadmin/roles-permission')); ?>" aria-expanded="false">
               <i class="fa fa-cogs color-danger"></i>
               <span class="nav-text">Roles and Permissions</span>
            </a>
            
         </li>
         
         
         
      </ul>


      </div>
      </div>
      <!--**********************************
         Sidebar end
      ***********************************<?php /**PATH /var/www/sites/enthucate/resources/views/includes/superadmin_sidebar.blade.php ENDPATH**/ ?>