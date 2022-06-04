setTimeout(function () {
    jQuery("#successMessage").fadeOut("3000");
}, 12000);
setTimeout(function () {
    jQuery("#errorMessage").fadeOut("3000");
}, 16000);

var url = jQuery("#siteurl").val();
var csrftoken = jQuery("#csrftoken").val();

jQuery( ".markorganisationdelete" ).click(function() {
	jQuery('#deleteorganisation').val(jQuery(this).attr("data-id"));
});
jQuery(document).on("click", ".markschooldelete", function () {
    jQuery('#school_id').val(jQuery(this).attr("data-id"));
});
jQuery( ".markgradedelete" ).click(function() {
    jQuery('#grade_id').val(jQuery(this).attr("data-id"));
});
jQuery( ".markclassdelete" ).click(function() {
    jQuery('#class_id').val(jQuery(this).attr("data-id"));
});
jQuery(document).on("click", ".markuserdelete", function () {
    jQuery('#user_id').val(jQuery(this).attr("data-id"));
});
// state

jQuery( ".selectcountry" ).change(function() {
    jQuery("#selectcityvalue").html('');
    var id = jQuery(this).val();
    jQuery.ajax({
        url: url + "/state",
        type: 'post',
         data: {id: id, _token: csrftoken},
        success: function(response) {
            jQuery("#selectstatevalue").html(response).selectpicker('refresh');
        }
    });
});

// city

jQuery(document).on("change", "#selectstatevalue", function () {
    jQuery("#selectcityvalue").html('');
    var id = jQuery(this).val();
    jQuery.ajax({
        url: url + "/city",
        type: 'post',
         data: {id: id, _token: csrftoken},
        success: function(response) {
            jQuery("#selectcityvalue").html(response).selectpicker('refresh');
        }
    });
});

// School

jQuery(document).on("change", "#seleorganisationid", function () {
    jQuery("#selectschoolvalue").html('');
    jQuery("#selectgradevalue").html('');
    var id = jQuery(this).val();
    GetDepartment(id);
    GetMember(id);
    GetGroup(id);
    jQuery.ajax({
        url: url + "/school",
        type: 'post',
         data: {id: id, _token: csrftoken},
        success: function(response) {
            jQuery("#selectschoolvalue").html(response).selectpicker('refresh');
            jQuery("#selectgradevalue").selectpicker('refresh');
        }
    });
});

// Department
function GetDepartment(id){
    jQuery.ajax({
        url: url + "/department",
        type: 'post',
         data: {id: id, _token: csrftoken},
        success: function(response) {
            jQuery("#selectdepartmentvalue").html(response).selectpicker('refresh');
            jQuery("#selectgradevalue").selectpicker('refresh');
        }
    });
}
// Group
function GetGroup(id){
    jQuery.ajax({
        url: url + "/group",
        type: 'post',
         data: {id: id, _token: csrftoken},
        success: function(response) {
            jQuery("#selectgroupvalue").html(response).selectpicker('refresh');
            jQuery("#selectgradevalue").selectpicker('refresh');
        }
    });
}
// Member
function GetMember(id){
    jQuery.ajax({
        url: url + "/member",
        type: 'post',
         data: {id: id, _token: csrftoken},
        success: function(response) {
            jQuery("#selectmembervalue").html(response).selectpicker('refresh');
          
        }
    });
}

jQuery(document).on("change", "#selectschoolvalue", function () {
    jQuery("#selectgradevalue").html('');
    var id = jQuery(this).val();
    jQuery.ajax({
        url: url + "/grade",
        type: 'post',
         data: {id: id, _token: csrftoken},
        success: function(response) {
            jQuery("#selectgradevalue").html(response).selectpicker('refresh');
        }
    });
});

jQuery(document).on("change", "#selectgradevalue", function () {
    jQuery("#selectclassvalue").html('');
    var id = jQuery(this).val();
    jQuery.ajax({
        url: url + "/getclass",
        type: 'post',
         data: {id: id, _token: csrftoken},
        success: function(response) {
            jQuery("#selectclassvalue").html(response).selectpicker('refresh');
        }
    });
});


jQuery(document).on("change", "#selerole", function () {
    var role = jQuery(this).val();
    if(role != 2 && role != 6 && role != 8){
        jQuery('.userschool').show();
    }
    else{
        jQuery('.userschool').hide();
    }
});

// Image upload

jQuery(document).on("change", ".uploadattachment", function () {

//jQuery(".uploadattachment").change(function () {
    var noteid = jQuery(this).attr("data-id");
    readattachment(this, noteid);
});
function readattachment(input, noteid) {
    if (input.files && input.files[0]) {
        var i;
        for (i = 0; i < input.files.length; ++i) {
            var reader = new FileReader();
            var filename = input.files[i]["name"];
            reader.fileName = filename;
            reader.onload = function (e) {
                var getfilename = e.target.fileName;
                jQuery("#insert_image_" + noteid).append(
                    '<input type="hidden" name="ReminderImages[]" class="preview_img_' +
                        noteid +
                        "_" +
                        jQuery(".preview_img").length +
                        '" value="' +
                        getfilename +
                        "!!" +
                        e.target.result +
                        '"><div class="preview_image_container preview_image_container_reply show_all_file" id="preview_img_' +
                        noteid +
                        "_" +
                        jQuery(".preview_img").length +
                        '"><button type="button" class="removebtnfile  delbtn" id="preview_img_' +
                        noteid +
                        "_" +
                        jQuery(".preview_img").length +
                        '">X</button><i for="upload" class="img-responsive pr-1 pt-1 preview_img fa fa-file" id="preview_img_' +
                        noteid +
                        "_" +
                        jQuery(".preview_img").length +
                        '"></i><div class="show_my_file" id="show_file_' +
                        noteid +
                        "_" +
                        jQuery(".preview_img").length +
                        '">' +
                        getfilename +
                        '</div></div>'
                );
            };
            reader.readAsDataURL(input.files[i]);
        }
    }
}
jQuery(document).on("click", ".delbtn", function (e) {
    //jQuery("form").on("click", ".delbtnfile", function (e) {
    var x = confirm("Are you sure you want to delete this file?");
    if (x) {
        console.log(jQuery(this).attr("id"));
        var divid = jQuery(this).attr("id");
        jQuery("#" + divid).remove();
        jQuery("." + divid).remove();
    }
});


jQuery(document).on("click", ".viewdepartement", function () {
    var id = jQuery(this).attr('data-id');
    jQuery.ajax({
        url: url + "/viewdepartementmember",
        type: 'post',
         data: {id: id, _token: csrftoken},
        success: function(response) {
            jQuery(".memberlist").html(response);
        }
    });
});

jQuery(document).on("click", ".deletedapartmentid", function () {
    var id = jQuery(this).attr('data-department');
    var userid = jQuery(this).attr('data-user');
    var x = confirm("Are you sure you want to remove this member?");
    if (x) {
        jQuery.ajax({
            url: url + "/deletedapartmentid",
            type: 'post',
             data: {id: id,userid:userid, _token: csrftoken},
            success: function(response) {
                jQuery('#member_'+userid).remove();
                jQuery('#viewdepartement').modal("hide");
            }
        });
    }
});
setInterval(function(){ 
   appcount();
}, 15000);
function appcount(){
    var role_id = jQuery('#role_id').val();
    var organisation_url = jQuery('#organisation_url').val();
    if(role_id == 1){
    var urls = url + "/superadmin/chatusers";
    }
    else{
    var urls = url+'/'+organisation_url+"/admin/chatusers";
    }
    var category = '';
    var messagetype = 
    $.ajax({
        url: urls,
        data: { _token: $("meta[name='csrf-token']").attr("content")},
        //data: {user_id: user_id, _token: $("meta[name='csrf-token']").attr("content")},
        method: "GET",
        dataType: "json",
        beforeSend: function () {
            // if(chat_area.find(".loader").length  == 0) {
            //     chat_area.html(loaderHtml());
            // }
        },
        success: function (responses) {
          if(responses.totalcount > 0){
            jQuery('.messagecount').html('Messages <span class="chat_view_count"></span>');
          }
          else{
            jQuery('.messagecount').html('Messages');
          }
        },
    });
}
$(document).ready(function() {
    appcount();    
});