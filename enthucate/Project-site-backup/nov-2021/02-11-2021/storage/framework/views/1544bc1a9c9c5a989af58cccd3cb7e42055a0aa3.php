 <?php $__env->startSection('title', 'Message List - Enthucate'); ?> <?php $__env->startSection('content'); ?>
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
                $message_sender = App\Models\RolesPermissionMeta::where('role_id', Auth::User()->role_id)->where('meta_key','message_sender')->first(); 
                ?>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card profile-card">
                            <div class="card-header flex-wrap border-0 pb-0">
                                <h3 class="card-title col-sm-2">Messages</h3>
                                 <div class="col-sm-3">
                                   <div class="form-group">
                                        <select class="form-control message_category" name="message_category" id="message_category">
                                            <option value="">Select Category</option>
                                            <?php if(!empty($messagecategory)): ?> 
                                            <?php $__currentLoopData = $messagecategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->category); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                            <?php endif; ?>
                                        </select>
                                   </div>
                                </div>
                                 <div class="col-sm-3">
                                   <div class="form-group">
                                        <select name="message_priority" id="message_priority" class="message_priority form-control">
                                            <option value="">Select Priority</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Urgent">Urgent</option>
                                            <option value="Critical">Critical</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                   <div class="form-group">
                                        <select name="messagetype" id="messagetype" class="messagetype form-control">
                                            <option value="">All Messages (<?php echo e(count($users)); ?>)</option>
                                            <option value="Inbox">Inbox</option>
                                            <option value="Outbox">Outbox</option>
                                        </select>
                                    </div>
                                </div>                                
                            </div>
                                <div class="card-body">
                                <?php if(count($users)>0): ?>
                                    <div class="row">
                                        <div class="col-sm-6">                                       
                                            <div class="form-group message_left_side">
                                             <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                               <?php
                                               // echo 'date=='.$user->created_at;

                                                $ckickid = '';
                                                if(isset($_REQUEST['userid'])) {
                                                    if(base64_decode($_REQUEST['userid']) == $user->id){
                                                        $ckickid = 'ckickid'; 
                                                    }
                                                }
                                                else {
                                                    if($key == 0){$ckickid = 'ckickid';
                                                    }
                                                }
                                                if($user->profile_pic == '' || $user->profile_pic === null){ 
                                                  $avatar = url('/images/user_profile/blank.png');
                                                }
                                                else{
                                                    $avatar = url('/images/user_profile/'.$user->profile_pic.'');
                                                }
                                                // $avatar = '';

                                                $content = '';
                                                if($user->content == '' && $user->chat_attachment != ''){
                                                    $content =  'send an attachment';
                                                }
                                                else{
                                                    $content =  $user->content;
                                                }
                                                $subject = $user->subject;
                                                // if($user->message_priority != 'Normal'){
                                                //     $subject =  $user->subject.' ('.$user->message_priority.')';
                                                // }
                                                ?>
                                                <a href="javascript:void(0);" class="chat_user_tag chat-toggle text-dark-75 text-hover-primary font-weight-bold font-size-lg chat_user_<?php echo e($user->id); ?> <?php echo e($ckickid); ?>" data-id="<?php echo e($user->id); ?>" data-message="<?php echo e($user->userid); ?>" data-user="<?php echo e($subject); ?>">
                                                    <div class="main d-flex align-items-center">
                                                        <div class="inner">
                                                        <img src="<?php echo e($avatar); ?>" class="rounded-circle user_img" alt=""/>
                                                        </div>
                                                        <div class="inner1">
                                                             
                                                                <h4><?php echo e($subject); ?></h4>
                                                        
                                                            <p><?php echo $content; ?></p>
                                                        </div>
                                                        <div class="inner2">
                                                        <?php if($user->countmessage > 0): ?>
                                                        <span class="chat_view_count"></span>
                                                        <?php endif; ?>
                                                        <?php if($user->created_at == '' || $user->created_at === null): ?>
                                                        <span></span>
                                                        <?php else: ?>
                                                        <span><time datetime="<?php echo e(date("Y-m-dTH:i", strtotime($user->created_at->toDateTimeString()))); ?>"><?php echo e($user->created_at->diffForHumans()); ?></time></span>
                                                        <?php endif; ?>
                                                            
                                                           
                                                        </div>
                                                    </div>
                                                        </a>
                                                <!-- </a> -->
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                          
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                              <div class="msg-right">
                                                <h2 class="chat-user"></h2>
                                                <div id="chat-overlay" ></div>
                                                <div id="chat_box" class="chat_box pull-right" style="display: none;">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-md-12">
                                                            <div class="panel panel-default">
                                                                <div class="panel-body chat-area scroll_message"></div>
                                                                <div class="panel-footer">
                                                                    <?php if(isset($message_sender->meta_value) && $message_sender->meta_value == 'on'): ?>
                                                                    <div class="input-group form-controls">
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group">
                                                                            <textarea class="form-control input-sm chat_input mt-3" placeholder="Write your message here..."></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div id="insert_image" class="insert_image_value insert_image_value_003 col-sm-12 mb-2"></div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <span class="only-file">
                                                                                    <input type="file" class="uploadattachment" id="uploadimage" name="attachment[]" multiple accept=".jpg,.png,.jpeg,.xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf" data-id="001" />
                                                                                    <i for="upload" class="fa fa-paperclip"></i> Attachments
                                                                                    
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6 message_right">
                                                                            <button class="btn btn-primary btn-sm btn-chat btn-rounded mb-3" type="button" data-to-user="" data-to-message=""><i class="glyphicon glyphicon-send"></i> Send</button>
                                                                        </div>
                                                                    </div>

                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="to_user_id" value="" />
                                                    <input type="hidden" id="to_message_id" value="" />
                                                </div>
                                                
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                  <?php endif; ?> 
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<input type="hidden" id="current_user" value="<?php echo e(auth()->user()->id); ?>" />
<input type="hidden" id="pusher_app_key" value="<?php echo e(Config::get('app.PUSHER_APP_KEY')); ?>" />
<input type="hidden" id="pusher_cluster" value="<?php echo e(Config::get('app.PUSHER_APP_CLUSTER')); ?>" />

<link href="<?php echo e(asset('public/css/chat.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?> <?php $__env->startSection('page_script'); ?>
<!-- <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script> -->
<!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script> -->
<script src="<?php echo e(asset('public/js/chat.js')); ?>" defer></script>
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<script>
    var base_url = '<?php echo e(url("/")); ?>';
    var organisation_url = '<?php echo Auth::User()->organisation_url ; ?>';
    $(document).on('click','.searchgrade',function(){  
       var category = jQuery('#message_category').val();
       var messagetype = jQuery('#messagetype').val();
       window.location.href='<?php echo e(url("/")); ?>/'+organisation_url+'/admin/message-list?category='+category+'&messagetype='+messagetype;
       // alert(organisation+'==='+school);
      // load_departmentlist(organisation,school);
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sites/enthucate/resources/views/admin/chat.blade.php ENDPATH**/ ?>