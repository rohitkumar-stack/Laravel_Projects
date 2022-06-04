setTimeout(function () {
    $("#successMessage").fadeOut("3000");
}, 12000);
setTimeout(function () {
    $("#errorMessage").fadeOut("3000");
}, 16000);

var url = $("#siteurl").val();
var csrftoken = $("#csrftoken").val();

jQuery(".add_child").on("click", function (e) {  
	if(jQuery('.first_name').val() != '' && jQuery('.last_name').val() != '' && jQuery('.last_name').val() != '' && jQuery('.mobile_number').val() != '' && jQuery('.password').val() != '' && jQuery('.password_confirmation').val() != ''){
		if(jQuery('.password').val() == jQuery('.password_confirmation').val()){
			e.preventDefault();
			jQuery('#addchildcall').modal("show");
		}
		else{
			jQuery(".invitemembererror").html('<div class="alert alert-danger" id="errorMessage">Password not match</div>');
		}
		e.preventDefault();
	}
});
jQuery(".add_onther_child").on("click", function (e) {
	jQuery('#addchildcall').modal("show");
});
jQuery(".nochild").on("click", function (e) {
	jQuery('#tab_1_parent').hide();
	jQuery('#tab_3_parent').hide();
	jQuery('#addchildcall').modal("hide");
	jQuery('#tab_2_parent').show();
});
jQuery(".yeschild").on("click", function (e) {
	jQuery('#tab_1_parent').hide();
	jQuery('#tab_3_parent').hide();
	jQuery('#tab_2_parent').hide();
	jQuery('#addchildcall').modal("hide");
	jQuery('#tab_4_parent').show();
});
jQuery(".my_child").on("click", function () {
	var parent_id = jQuery('#parent_id').val();
	var student_id = jQuery('#my_student_id').val();
	jQuery.ajax({
        url: url + "/update-exist-child-form",
        type: 'get',
         data: {parent_id: parent_id, student_id: student_id},
        success: function(response) {            
            if(response.code == 404){
            	console.log(response.code);
            	let data = response.data;
            	var error = '';
        		error +='<div class="alert alert-danger" id="errorMessage">';
                error +='Join ID not Exist. Please check the ID.';
				error +='</div>';
				jQuery(".invitemembererror").html(error);
            }
            if(response.code == 200){
            	console.log(response.data);

            	jQuery("#get_student_info").html(response.data.studentinfo);
            	jQuery("#get_student_id").html(response.data.studentinid); 
            	jQuery('#tab_1_parent').hide();           	
            	jQuery('#tab_2_parent').hide();
            	jQuery('#tab_3_parent').show();
            	jQuery('#tab_4_parent').hide();
            	jQuery('#tab_5_parent').hide();
            }
        }
    });
});
jQuery(".exist_new_child").on("click", function () {
	if(jQuery('.join_id').val() == ''){
		jQuery(".invitemembererror").html('<div class="alert alert-danger" id="errorMessage">Please enter Join ID.</div>');
		return false;
	}
	var formData = $("form.exist_child_form").serialize();
    jQuery.ajax({
        url: url + "/exist-child-form",
        type: 'post',
         data: formData,
        success: function(response) {            
            if(response.code == 404){
            	console.log(response.code);
            	let data = response.data;
            	var error = '';
        		error +='<div class="alert alert-danger" id="errorMessage">';
                error +='Join ID not Exist. Please check the ID.';
				error +='</div>';
				jQuery(".invitemembererror").html(error);
            }
            if(response.code == 200){
            	console.log(response.data);
            	jQuery("#getexist_student_info").html(response.data.studentinfo);
            	jQuery("#get_student_info_input").html(response.data.studentinid);
            	jQuery('#tab_2_parent').hide();
            	jQuery('#tab_3_parent').hide();
            	jQuery('#tab_4_parent').hide();
            	jQuery('#tab_5_parent').show();
            }
        }
    });
});	
jQuery(".add_new_child").on("click", function () {
    var formData = $("form.add_child_form").serialize();
    jQuery.ajax({
        url: url + "/add-new-child",
        type: 'post',
         data: formData,
        success: function(response) {            
            if(response.code == 404){
            	console.log(response.code);
            	let data = response.data;
            	var error = '';
        		error +='<div class="alert alert-danger" id="errorMessage">';
                error +='<ul>'; 
	            	for (let [key, value] of Object.entries(data)) {
					  	console.log(value);
					    error +='<li>'+value+'</li>';
					}
				error +='</ul>';
				error +='</div>';
				jQuery(".invitemembererror").html(error);
            }
            if(response.code == 200){
            	console.log(response.data);
            	jQuery("#get_student_info").html(response.data.studentinfo);
            	jQuery("#get_student_id").html(response.data.studentinid);
            	jQuery('#tab_2_parent').hide();
            	jQuery('#tab_3_parent').show();
            }
        }
    });
});