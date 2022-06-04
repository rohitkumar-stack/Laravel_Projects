@if($message->from_user == \Auth::user()->id)
    <?php
    if($message->fromUser->profile_pic == '' || $message->fromUser->profile_pic === null){ 
          $avatar = url('/images/user_profile/blank.png');
        }
        else{
            $avatar = url('/images/user_profile/'.$message->fromUser->profile_pic.'');
        }

    ?>
    <div class="msg-box box-rgt d-flex base_sent"  data-message-id="{{ $message->id }}">
        <div class="inner1">
              @if(!empty($message->content ))
                  <p>{!! $message->content !!}</p>
                @endif
                  @if(!empty($message->attachment))
                    <?php
                       $getnote_images = explode(',', $message->attachment); foreach ($getnote_images as $key => $getnote_image) { $getexpimage = explode('.', $getnote_image); 
                       //$bytes = filesize(getcwd() ."/public/assets/note_image/" . $getnote_image); 
                       //$byte = app(App\Http\Controllers\Controller::class)->formatSizeUnits($bytes);
                       $byte = '';
                        ?>
                    <div class="preview_image_container preview_image_container_reply  result_preview_img_{{$message->id}}_{{$key}} " id="result_preview_img_{{$message->id}}_{{$key}} ">                                       
                       <div class="new-sec">
                          <div class="inner d-flex align-items-center">
                             <div class="img-sec">
                                <i class="fa fa-file"></i>
                             </div>
                             <div class="text-sec">
                                <p>{{$getnote_image}}</p>
                                <span>{{$byte}}</span>
                             </div>
                             <div class="download-ico">
                                <a href='{{ asset("images/messages/".$getnote_image) }}' download> <i class="fa fa-download"></i></a>
                             </div>
                           
                          </div>
                       </div>
                    </div>
                    <!-- </div> -->
                    <?php
                       }
                       ?>
                  @endif
            <span><time datetime="{{ date("Y-m-dTH:i", strtotime($message->created_at->toDateTimeString())) }}">{{ $message->fromUser->name }} • {{ $message->created_at->diffForHumans() }}</time></span>
        </div>
        <div class="inner">
            <img src="{{ $avatar }}" class="rounded-circle user_img" alt=""/>
        </div>
    </div>
@else

 <?php
    if($message->fromUser->profile_pic == '' || $message->fromUser->profile_pic === null){ 
          $avatar = url('/images/user_profile/blank.png');
        }
        else{
            $avatar = url('/images/user_profile/'.$message->fromUser->profile_pic.'');
        }
    ?>
    <div class="msg-box d-flex base_receive"  data-message-id="{{ $message->id }}">
        <div class="inner">
            <img src="{{ $avatar }}" class="rounded-circle user_img" alt=""/>
        </div>
        <div class="inner1">
             @if(!empty($message->content ))
                  <p>{!! $message->content !!}</p>
                @endif
                  @if(!empty($message->attachment))
                    <?php
                       $getnote_images = explode(',', $message->attachment); foreach ($getnote_images as $key => $getnote_image) { $getexpimage = explode('.', $getnote_image); 
                      // $bytes = filesize(getcwd() ."/public/assets/note_image/" . $getnote_image); 
                      // $byte = app(App\Http\Controllers\Controller::class)->formatSizeUnits($bytes); 
                       $byte = '';
                       ?>
                    <div class="preview_image_container preview_image_container_reply  result_preview_img_{{$message->id}}_{{$key}} " id="result_preview_img_{{$message->id}}_{{$key}} ">                                       
                       <div class="new-sec">
                          <div class="inner d-flex align-items-center">
                             <div class="img-sec">
                                <i class="fa fa-file"></i>
                             </div>
                             <div class="text-sec">
                                <p>{{$getnote_image}}</p>
                                <span>{{$byte}}</span>
                             </div>
                             <div class="download-ico">
                                <a href='{{ asset("images/messages/".$getnote_image) }}' download> <i class="fa fa-download"></i></a>
                             </div>
                           
                          </div>
                       </div>
                    </div>
                    <!-- </div> -->
                    <?php
                       }
                       ?>
                  @endif
            <span><time datetime="{{ date("Y-m-dTH:i", strtotime($message->created_at->toDateTimeString())) }}">{{ $message->fromUser->name }} • {{ $message->created_at->diffForHumans() }}</time></span>
        </div>
    </div>
@endif