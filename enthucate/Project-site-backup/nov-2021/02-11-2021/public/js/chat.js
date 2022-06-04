$(function () {

    let pusher = new Pusher($("#pusher_app_key").val(), {
        cluster: $("#pusher_cluster").val(),
        encrypted: true
    });

    let channel = pusher.subscribe('chat');


    // on click on any chat btn render the chat box
   // $(".chat-toggle").on("click", function (e) {
   //     e.preventDefault();

   //     let ele = $(this);

   //     let user_id = ele.attr("data-id");

   //     let username = ele.attr("data-user");

   //     cloneChatBox(user_id, username, function () {

   //         let chatBox = $("#chat_box_" + user_id);

   //         if(!chatBox.hasClass("chat-opened")) {

   //             chatBox.addClass("chat-opened").slideDown("fast");

   //             loadLatestMessages(chatBox, user_id);

   //             chatBox.find(".chat-area").animate({scrollTop: chatBox.find(".chat-area").offset().top + chatBox.find(".chat-area").outerHeight(true)}, 800, 'swing');
   //         }
   //     });
   // });

   $(document).ready(function() {
    setTimeout(function() {
      let ele = $('.ckickid');
       let user_id = ele.attr("data-id");
       //let user_id = ele.attr("data-id");
       let message_id = ele.attr("data-message");
       let username = ele.attr("data-user");
       $('.chat_box').hide();
       $('#chat_box_'+user_id).show();
       $('.chat-user').text(username);
       $('.insert_image_value').html('');
       readmessage(user_id);
       cloneChatBox(user_id, username,message_id, function () {
           let chatBox = $("#chat_box_" + user_id);
           chatBox.find(".insert_image_value").attr("id", "insert_image_" + user_id);
           chatBox.find(".uploadattachment").attr("data-id",  user_id);
           
           if(!chatBox.hasClass("chat-opened")) {
               chatBox.addClass("chat-opened").slideDown("fast");
               
               loadLatestMessages(chatBox, user_id, message_id);
               // chatBox.find(".chat-area").animate({scrollTop: chatBox.find(".chat-area").offset().top + chatBox.find(".chat-area").outerHeight(true)}, 800, 'swing');
               chatBox.find(".scroll_message").animate({scrollTop: chatBox.find(".chat-area").outerHeight(true)},120);
           }
       });     
    },10);
});
 $(document).on('click','.chat-toggle', function(e){


    // $(document).on("click", '.chat-toggle' function (e) {
       e.preventDefault();

       let ele = $(this);

       let user_id = ele.attr("data-id");
       let message_id = ele.attr("data-message");
       $('.insert_image_value').html('');
       let username = ele.attr("data-user");
       $('.chat_box').hide();
       $('#chat_box_'+user_id).show();
       $('.chat-user').text(username);
       readmessage(user_id);
       $('#chat_box_'+user_id).find(".scroll_message").animate({scrollTop: $('#chat_box_'+user_id).find(".chat-area").outerHeight(true)},120);
       cloneChatBox(user_id, username,message_id, function () {

           let chatBox = $("#chat_box_" + user_id);
            chatBox.find(".insert_image_value").attr("id", "insert_image_" + user_id);
            chatBox.find(".uploadattachment").attr("data-id",  user_id);
           if(!chatBox.hasClass("chat-opened")) {

               chatBox.addClass("chat-opened").slideDown("fast");

               loadLatestMessages(chatBox, user_id,message_id);
               chatBox.find(".scroll_message").animate({scrollTop: chatBox.find(".chat-area").outerHeight(true)},120);
           }
       });
   });
   // on close chat close the chat box but don't remove it from the dom
   $(".close-chat").on("click", function (e) {

       $(this).parents("div.chat-opened").removeClass("chat-opened").slideUp("fast");
   });


   // on change chat input text toggle the chat btn disabled state
    // $(".chat_input").on("change keyup", function (e) {
    //    if($(this).val() != "") {
    //        $(this).parents(".form-controls").find(".btn-chat").prop("disabled", false);
    //    } else {
    //        $(this).parents(".form-controls").find(".btn-chat").prop("disabled", true);
    //    }
    // });


    // on click the btn send the message
   $(".btn-chat").on("click", function (e) {
       send($(this).attr('data-to-user'),$(this).attr('data-to-message'), $("#chat_box_" + $(this).attr('data-to-user')).find(".chat_input").val());
   });

   // listen for the send event, this event will be triggered on click the send btn
    channel.bind('send', function(data) {
        displayMessage(data.data);
    });


    // handle the scroll top of any chat box
    // the idea is to load the last messages by date depending of last message
    // that's already loaded on the chat box
    let lastScrollTop = 0;

   $(".scroll_message").on("scroll", function (e) {
       let st = $(this).scrollTop();

       if(st < lastScrollTop) {

           fetchOldMessages($(this).parents(".chat-opened").find("#to_user_id").val(), $(this).find(".msg-box:first-child").attr("data-message-id"));
           //fetchOldMessages($(this).parents(".chat-opened").find("#to_user_id").val(), $(this).find(".msg_container:first-child").attr("data-message-id"));
       }

       lastScrollTop = st;
   });

    // listen for the oldMsgs event, this event will be triggered on scroll top
    channel.bind('oldMsgs', function(data) {
        displayOldMessages(data);
    });
});

/**
 * loaderHtml
 *
 * @returns {string}
 */

function loaderHtml() {
    return '<i class="glyphicon glyphicon-refresh loader"></i>';
}
function loadmessagelast(dataid) {
    let ele = $('.ckickid');
       let user_id = ele.attr("data-id");
       //let user_id = ele.attr("data-id");
       let message_id = ele.attr("data-message");
       let username = ele.attr("data-user");
       $('.chat_box').hide();
       $('#chat_box_'+user_id).show();
       $('.chat-user').text(username);
       $('.insert_image_value').html('');
       cloneChatBox(user_id, username,message_id, function () {
           let chatBox = $("#chat_box_" + user_id);
           chatBox.find(".insert_image_value").attr("id", "insert_image_" + user_id);
           chatBox.find(".uploadattachment").attr("data-id",  user_id);
           
           //if(!chatBox.hasClass("chat-opened")) {
               chatBox.addClass("chat-opened").slideDown("fast");
               // console.log(user_id);
               loadLatestMessages(chatBox, user_id, message_id);
               // chatBox.find(".chat-area").animate({scrollTop: chatBox.find(".chat-area").offset().top + chatBox.find(".chat-area").outerHeight(true)}, 800, 'swing');
               chatBox.find(".scroll_message").animate({scrollTop: chatBox.find(".chat-area").outerHeight(true)},120);
           //}
       });
}
function readmessage(user_id){
   $.ajax({
        url: base_url + "/read-message",
        data: {user_id: user_id, _token: $("meta[name='csrf-token']").attr("content")},
        method: "GET",
        dataType: "json",
        beforeSend: function () {
            // if(chat_area.find(".loader").length  == 0) {
            //     chat_area.html(loaderHtml());
            // }
        },
        success: function (response) {
          var category = jQuery('#message_category').val();
          var message_priority = jQuery('#message_priority').val();
          var messagetype = jQuery('#messagetype').val();
          var count = 1;
         getusers(category,messagetype,message_priority,count,user_id);
        },
    });
}
 $(document).on('change','#messagetype', function(e){
    var category = jQuery('#message_category').val();
    var message_priority = jQuery('#message_priority').val();
    var messagetype = $(this).val();
    var count = 0;
    var user_id = '';
    getusers(category,messagetype,message_priority,count,user_id);
  });
 $(document).on('change','#message_priority', function(e){
    var category = jQuery('#message_category').val();
    var message_priority = $(this).val();
    var messagetype = jQuery('#messagetype').val();
    var count = 0;
    var user_id = '';
    getusers(category,messagetype,message_priority,count,user_id);
  });
 $(document).on('change','#message_category', function(e){
    var category = $(this).val();
    var message_priority = jQuery('#message_priority').val();
    var messagetype = jQuery('#messagetype').val();
    var count = 0;
    var user_id = '';
    getusers(category,messagetype,message_priority,count,user_id);
  });
function getusers(category,messagetype,message_priority,count,user_id){

  var role_id = jQuery('#role_id').val();
  var organisation_url = jQuery('#organisation_url').val();
  if(role_id == 1){
    var urls = base_url + "/superadmin/chatusers";
  }
  else{
    var urls = base_url+'/'+organisation_url+"/admin/chatusers";
  }
  // console.log(search);
      $.ajax({
        url: urls,
        data: {category: category,messagetype:messagetype,message_priority:message_priority, _token: $("meta[name='csrf-token']").attr("content")},
        //data: {user_id: user_id, _token: $("meta[name='csrf-token']").attr("content")},
        method: "GET",
        dataType: "json",
        beforeSend: function () {
            // if(chat_area.find(".loader").length  == 0) {
            //     chat_area.html(loaderHtml());
            // }
        },
        success: function (responses) {
          var text = '';
          // console.log(responses.getallmember);
          var response = responses.getallmember;
          var resultuserid = '';
          for (let i = 0; i < response.length; i++) {
            var datavalue = '';
            if(response[i].profile_pic == '' || response[i].profile_pic === null){
              avatar = base_url+'/images/user_profile/blank.png';
              datavalue = '<img class="rounded-circle user_img" alt="Pic" src='+avatar+' />';
            }
            else{
              var avatar = base_url+'/images/user_profile/' +response[i].profile_pic; 
              datavalue = '<img class="rounded-circle user_img" alt="Pic" src='+avatar+' />';
            }
            var content = '';
            if((response[i].content == '' || response[i].content === null) && (response[i].attachment != ''  && response[i].attachment != null)){
              content =  'send an attachment';
            }
            else{
              content =  response[i].content;
            }
            if(response[i].alias == ''  || response[i].alias === null){
              var name = response[i].first_name;
            }
            else{
              var name = response[i].alias;
            } 
            var subject = response[i].subject;
            // if(response[i].message_priority != 'Normal'){
            //     subject =  response[i].subject+' ('+response[i].message_priority+')';
            // }
            var ckickid = '';
           var dataid = '';
                if(i == 0){
                  dataid = response[i].id;
                  ckickid = 'ckickid';
                  resultuserid = response[i].id;
                }
            text += '<a href="javascript:void(0);" class="chat_user_tag chat-toggle text-dark-75 text-hover-primary font-weight-bold font-size-lg chat_user_'+response[i].id+' '+ckickid+'" data-id="'+response[i].id+'" data-message="'+response[i].userid+'" data-user="'+subject+'">';
              text += '<div class="main d-flex align-items-center">';
                  text += '<div class="inner">';
                  text += datavalue;
                  text += '</div>';
                  text += '<div class="inner1">';
                  text += '<h4>'+subject+'</h4>';
                  text += '<p>'+content+'</p>';
                  text += '</div>';
                  text += '<div class="inner2">';
                  if(response[i].countmessage > 0){
                  text += '<span class="chat_view_count"></span>';
                  }
                  else{
                    jQuery('.messagecount').html('Messages');
                  }
                  text += '<span class="text-muted font-weight-bold font-size-sm"><time datetime="'+response[i].dateTimeStr+'">'+response[i].dateHumanReadable+' </time></span>';
                      
                     
                  text += '</div>';
              text += '</div>';
              text += '</a>';
        
        }
        if(response.length == 0){
          jQuery('.msg-right').hide();
        }
        else{
          jQuery('.msg-right').show();
        }
        if(count == 0){
           setTimeout(function() {
            loadmessagelast(dataid);
            },10);
        }         
        $('.message_left_side').html(text);

        setTimeout(function() {
        if(user_id == ''){
          user_id = resultuserid;
        }        
        $('.chat_user_tag').removeClass('message_active');
        $('.chat_user_'+user_id).addClass('message_active');
        },10);

        if(responses.totalcount > 0){
            jQuery('.messagecount').html('Messages <span class="chat_view_count"></span>');
          }
        // loadmessagelast();
        },
    });
}
/**
 * cloneChatBox
 *
 * this helper function make a copy of the html chat box depending on receiver user
 * then append it to 'chat-overlay' div
 *
 * @param user_id
 * @param username
 * @param callback
 */
function cloneChatBox(user_id, username,message_id, callback)
{
    if($("#chat_box_" + user_id).length == 0) {

        let cloned = $("#chat_box").clone(true);

        // change cloned box id
        cloned.attr("id", "chat_box_" + user_id);

        cloned.find(".chat-user").text(username);

        cloned.find(".btn-chat").attr("data-to-user", user_id);
        cloned.find(".btn-chat").attr("data-to-message", message_id);
        cloned.find("#to_user_id").val(user_id);
        cloned.find("#to_message_id").val(message_id);
        

        $("#chat-overlay").append(cloned);
    }

    callback();
}

/**
 * loadLatestMessages
 *
 * this function called on load to fetch the latest messages
 *
 * @param container
 * @param user_id
 */

function loadLatestMessages(container, user_id,message_id)
{
    let chat_area = container.find(".chat-area");    
    chat_area.html("");
    // console.log('userid==='+user_id);
    $('.usercount_'+user_id).html('');
   
    $.ajax({
        url: base_url + "/load-latest-messages",
        data: {user_id: user_id,message_id:message_id,  _token: $("meta[name='csrf-token']").attr("content")},
        method: "GET",
        dataType: "json",
        beforeSend: function () {
            if(chat_area.find(".loader").length  == 0) {
                chat_area.html(loaderHtml());
            }
        },
        success: function (response) {
          // getusers(search = '');
          if(response.message_status == '0'){
              jQuery('#chat_box_'+user_id+' .panel-footer .form-controls').hide();
              jQuery('#chat_box_'+user_id+' .panel-footer').html('<p class="error_chat_message p-3 ml-3"> You have no permission to reply. </p>');
          }
          else{
            jQuery('#chat_box_'+user_id+' .panel-footer .form-controls').show();
            jQuery('#chat_box_'+user_id+' .panel-footer .error_chat_message').remove();
          }
            if(response.state == 1) {

            
                response.messages.map(function (val, index) {
                    $(val).appendTo(chat_area);
                });
            }
        },
        complete: function () {          
            chat_area.find(".loader").remove();
            container.find(".scroll_message").animate({scrollTop: container.find(".chat-area").outerHeight(true)},120);
        }
    });
}

/**
 * send
 *
 * this function is the main function of chat as it send the message
 *
 * @param to_user
 * @param message
 */
function send(to_user,message_id, message)
{
   // alert('hlo');
  // to_user = 6;
  // message = 'hii';
    let chat_box = $("#chat_box_" + to_user);
    let chat_area = chat_box.find(".chat-area");

    var ReminderImages = [];
    $("input[name='ReminderImages[]']").each(function() {
        ReminderImages.push($(this).val());
    });
    // console.log(ReminderImages.length);
    // console.log('message=='+message);
    if(message == '' && ReminderImages.length == 0){
      return false;
    }
    chat_box.find(".btn-chat").prop("disabled", true);
    chat_box.find(".chat_input").val("");
    chat_box.find(".insert_image_value").html("");

    $.ajax({
        url: base_url + "/send",
        data: {to_user: to_user,message_id:message_id, message: message,ReminderImages:ReminderImages, _token: $("meta[name='csrf-token']").attr("content")},
        method: "POST",
        dataType: "json",
        beforeSend: function () {
            if(chat_area.find(".loader").length  == 0) {
                chat_area.append(loaderHtml());
            }
        },
        success: function (response) {
        },
        complete: function () {
            chat_area.find(".loader").remove();
            chat_box.find(".btn-chat").prop("disabled", false);
            chat_box.find(".chat_input").val("");
            chat_box.find(".insert_image_value").html("");
            chat_area.animate({scrollTop: chat_area.offset().top + chat_area.outerHeight(true)}, 800, 'swing');
        }
    });
}

/**
 * fetchOldMessages
 *
 * this function load the old messages if scroll up triggerd
 *
 * @param to_user
 * @param old_message_id
 */
function fetchOldMessages(to_user, old_message_id)
{
  // console.log(old_message_id);
    let chat_box = $("#chat_box_" + to_user);
    let chat_area = chat_box.find(".chat-area");
    let chat_message = chat_box.find(".msg-box");
    
    var datamessage  = localStorage.getItem("datamessage");
    // console.log(datamessage+'===='+old_message_id);
    // if(datamessage == old_message_id){
    //   return false;
    // }
    localStorage.setItem("datamessage", old_message_id);
    $.ajax({
        url: base_url + "/fetch-old-messages",
        data: {to_user: to_user, old_message_id: old_message_id, _token: $("meta[name='csrf-token']").attr("content")},
        method: "GET",
        async: false,
        dataType: "json",
        beforeSend: function () {
            // if(chat_area.find(".loader").length  == 0) {
                chat_area.prepend(loaderHtml());
            // }
        },
        success: function (response) {
           if(response.state == 1) {
           // var lastid = $('#chat_box_'+to_user).find(".msg-box:first-child").attr("data-message-id");
           // console.log('lastid==='+lastid +'==='+'#chat_box_'+to_user);
                response.data.map(function (val, index) {
                  // console.log(val);
                  chat_area.prepend(val);
                  // console.log(val);
                  var id = chat_message.attr('data-message-id');
                  localStorage.setItem("datamessage", id);
                  // console.log(id);
                    //$(val).prepend(chat_area);
                });
            }
          // getusers(search = '');
        },
        complete: function () {
            chat_area.find(".loader").remove();
        }
    });
}

/**
 * getMessageSenderHtml
 *
 * this is the message template for the sender
 *
 * @param message
 * @returns {string}
 */
function getMessageSenderHtml(message)
{
  if(message.from_user.profile_pic == '' || message.from_user.profile_pic === null){
      var avatar = base_url+'/images/user_profile/blank.png'; 
      datavalue = '<img alt="Pic" src='+avatar+' />';
    }
    else{
      var avatar = base_url+'/images/user_profile/' +message.from_user.profile_pic; 
      datavalue = '<img alt="Pic" src='+avatar+' />';
    }
    if(message.content == '' || message.content === null){
      content =  '';
    }
    else{
      content =  '<p>'+message.content+'</p>';
    }
    return `<div class="msg-box box-rgt d-flex base_sent " data-message-id="${message.id}">
        <div class="inner1">
            <p>`+content+`</p>
            ${message.attachment}
            <span><time datetime="${message.dateTimeStr}"> ${message.fromUserName} • ${message.dateHumanReadable} </time></span>
        </div>
        <div class="inner">
            <img src="` + avatar +  ' ' + `" class="rounded-circle user_img" alt=""/>
        </div>
    </div>
    `;
}

/**
 * getMessageReceiverHtml
 *
 * this is the message template for the receiver
 *
 * @param message
 * @returns {string}
 */
function getMessageReceiverHtml(message)
{
  if(message.from_user.profile_pic == '' || message.from_user.profile_pic === null){
      var avatar = base_url+'/images/user_profile/blank.png'; 
      datavalue = '<img alt="Pic" src='+avatar+' />';
    }
    else{
      var avatar = base_url+'/images/user_profile/' +message.from_user.profile_pic; 
      datavalue = '<img alt="Pic" src='+avatar+' />';
    }
    if(message.content == '' || message.content === null){
      content =  '';
    }
    else{
      content =  '<p>'+message.content+'</p>';
    }
    return `

     <div class="msg-box d-flex base_receive" data-message-id="${message.id}">
        <div class="inner">
            <img src="` + avatar +  ' ' + `" class="rounded-circle user_img" alt=""/>
        </div>
        <div class="inner1">
              <p>`+content+`</p>
            ${message.attachment}
            <span><time datetime="${message.dateTimeStr}"> ${message.fromUserName}  • ${message.dateHumanReadable} </time></span>
        </div>
    </div>
    `;
}

/**
 * This function called by the send event triggered from pusher to display the message
 *
 * @param message
 */
function displayMessage(message)
{
    let alert_sound = document.getElementById("chat-alert-sound");

    if($("#current_user").val() == message.from_user_id) {

        let messageLine = getMessageSenderHtml(message);

        $("#chat_box_" + message.to_user_id).find(".chat-area").append(messageLine);

    } else if($("#current_user").val() == message.to_user_id) {

        //alert_sound.play();

        // for the receiver user check if the chat box is already opened otherwise open it
        cloneChatBox(message.from_user_id, message.fromUserName, function () {

            let chatBox = $("#chat_box_" + message.from_user_id);

            if(!chatBox.hasClass("chat-opened")) {

                chatBox.addClass("chat-opened").slideDown("fast");
                let message_id = '';
                loadLatestMessages(chatBox, message.from_user_id,message_id);

                chatBox.find(".chat-area").animate({scrollTop: chatBox.find(".chat-area").offset().top + chatBox.find(".chat-area").outerHeight(true)}, 800, 'swing');
            } else {

                let messageLine = getMessageReceiverHtml(message);

                // append the message for the receiver user
                $("#chat_box_" + message.from_user_id).find(".chat-area").append(messageLine);
            }
        });
    }
}

function displayOldMessages(data)
{
    if(data.data.length > 0) {

        data.data.map(function (val, index) {
            $("#chat_box_" + data.to_user).find(".chat-area").prepend(val);
        });
    }
}