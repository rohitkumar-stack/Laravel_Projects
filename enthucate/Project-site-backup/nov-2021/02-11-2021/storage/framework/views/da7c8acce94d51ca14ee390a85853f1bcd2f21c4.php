<?php if($message->from_user == \Auth::user()->id): ?>
    <?php
    if($message->fromUser->profile_pic == '' || $message->fromUser->profile_pic === null){ 
          $avatar = url('/images/user_profile/blank.png');
        }
        else{
            $avatar = url('/images/user_profile/'.$message->fromUser->profile_pic.'');
        }

    ?>
    <div class="msg-box box-rgt d-flex base_sent"  data-message-id="<?php echo e($message->id); ?>">
        <div class="inner1">
              <?php if(!empty($message->content )): ?>
                  <p><?php echo $message->content; ?></p>
                <?php endif; ?>
                  <?php if(!empty($message->attachment)): ?>
                    <?php
                       $getnote_images = explode(',', $message->attachment); foreach ($getnote_images as $key => $getnote_image) { $getexpimage = explode('.', $getnote_image); 
                       //$bytes = filesize(getcwd() ."/public/assets/note_image/" . $getnote_image); 
                       //$byte = app(App\Http\Controllers\Controller::class)->formatSizeUnits($bytes);
                       $byte = '';
                        ?>
                    <div class="preview_image_container preview_image_container_reply  result_preview_img_<?php echo e($message->id); ?>_<?php echo e($key); ?> " id="result_preview_img_<?php echo e($message->id); ?>_<?php echo e($key); ?> ">                                       
                       <div class="new-sec">
                          <div class="inner d-flex align-items-center">
                             <div class="img-sec">
                                <i class="fa fa-file"></i>
                             </div>
                             <div class="text-sec">
                                <p><?php echo e($getnote_image); ?></p>
                                <span><?php echo e($byte); ?></span>
                             </div>
                             <div class="download-ico">
                                <a href='<?php echo e(asset("images/messages/".$getnote_image)); ?>' download> <i class="fa fa-download"></i></a>
                             </div>
                           
                          </div>
                       </div>
                    </div>
                    <!-- </div> -->
                    <?php
                       }
                       ?>
                  <?php endif; ?>
            <span><time datetime="<?php echo e(date("Y-m-dTH:i", strtotime($message->created_at->toDateTimeString()))); ?>"><?php echo e($message->fromUser->name); ?> • <?php echo e($message->created_at->diffForHumans()); ?></time></span>
        </div>
        <div class="inner">
            <img src="<?php echo e($avatar); ?>" class="rounded-circle user_img" alt=""/>
        </div>
    </div>
<?php else: ?>

 <?php
    if($message->fromUser->profile_pic == '' || $message->fromUser->profile_pic === null){ 
          $avatar = url('/images/user_profile/blank.png');
        }
        else{
            $avatar = url('/images/user_profile/'.$message->fromUser->profile_pic.'');
        }
    ?>
    <div class="msg-box d-flex base_receive"  data-message-id="<?php echo e($message->id); ?>">
        <div class="inner">
            <img src="<?php echo e($avatar); ?>" class="rounded-circle user_img" alt=""/>
        </div>
        <div class="inner1">
             <?php if(!empty($message->content )): ?>
                  <p><?php echo $message->content; ?></p>
                <?php endif; ?>
                  <?php if(!empty($message->attachment)): ?>
                    <?php
                       $getnote_images = explode(',', $message->attachment); foreach ($getnote_images as $key => $getnote_image) { $getexpimage = explode('.', $getnote_image); 
                      // $bytes = filesize(getcwd() ."/public/assets/note_image/" . $getnote_image); 
                      // $byte = app(App\Http\Controllers\Controller::class)->formatSizeUnits($bytes); 
                       $byte = '';
                       ?>
                    <div class="preview_image_container preview_image_container_reply  result_preview_img_<?php echo e($message->id); ?>_<?php echo e($key); ?> " id="result_preview_img_<?php echo e($message->id); ?>_<?php echo e($key); ?> ">                                       
                       <div class="new-sec">
                          <div class="inner d-flex align-items-center">
                             <div class="img-sec">
                                <i class="fa fa-file"></i>
                             </div>
                             <div class="text-sec">
                                <p><?php echo e($getnote_image); ?></p>
                                <span><?php echo e($byte); ?></span>
                             </div>
                             <div class="download-ico">
                                <a href='<?php echo e(asset("images/messages/".$getnote_image)); ?>' download> <i class="fa fa-download"></i></a>
                             </div>
                           
                          </div>
                       </div>
                    </div>
                    <!-- </div> -->
                    <?php
                       }
                       ?>
                  <?php endif; ?>
            <span><time datetime="<?php echo e(date("Y-m-dTH:i", strtotime($message->created_at->toDateTimeString()))); ?>"><?php echo e($message->fromUser->name); ?> • <?php echo e($message->created_at->diffForHumans()); ?></time></span>
        </div>
    </div>
<?php endif; ?><?php /**PATH /var/www/sites/enthucate/resources/views/superadmin/message-line.blade.php ENDPATH**/ ?>