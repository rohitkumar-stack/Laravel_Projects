var url = $("#siteurl").val();
var csrftoken = $("#csrftoken").val();

jQuery( ".level_name" ).change(function() {
	var id = jQuery(this).val();
	if(id == 3){
		var ids = ["1", "2"];
		SubdivisionSchool(ids);
	}
	else if(id == 4){
		var ids = ["3",];
		SubdivisionLocalSchool(ids);

	}
	else if(id == 5){
		var ids = ["4",];
		DivisionSchool(ids);
	}
	else{
		jQuery("#Subdivisiontype").html('');
		jQuery('.Subdivision_main').hide();
	}
});

function SubdivisionSchool(id) {
	jQuery.ajax({
        url: url + "/subdivision",
        type: 'post',
         data: {id: id, _token: csrftoken},
        success: function(response) {
	          var result = '';
            result += '<option value="">Select Global/Partner Organisation</option>';
            result += response;
        	jQuery("#Subdivisiontype").html(result).selectpicker('refresh');
        	jQuery('.Subdivision_main').show();
        }
    }); 
}
function SubdivisionLocalSchool(id) {
	jQuery.ajax({
        url: url + "/subdivision",
        type: 'post',
         data: {id: id, _token: csrftoken},
        success: function(response) {
          var result = '';
          result += '<option value="">Select Subdivision</option>';
          result += response;
          jQuery("#Subdivisiontype").html(result).selectpicker('refresh');
          jQuery('.Subdivision_main').show();
        }
    }); 
}
function DivisionSchool(id) {
	jQuery.ajax({
        url: url + "/subdivision",
        type: 'post',
         data: {id: id, _token: csrftoken},
        success: function(response) {
          var result = '';
          result += '<option value="">Select Local Sub-divisionn</option>';
          result += response;
        	jQuery("#Subdivisiontype").html(result).selectpicker('refresh');
          jQuery('.Subdivision_main').show();
        }
    }); 
}

jQuery( ".markorganisationdelete" ).click(function() {
	jQuery('#deleteorganisation').val(jQuery(this).attr("data-id"));
});

jQuery( "#rolepermission" ).change(function() {
    var role = $('option:selected',this).text();
    var id = $('option:selected',this).val();
    jQuery('#role').val(role);
    jQuery('.role_check').prop('checked', false);
    // jQuery('.role_check')
    jQuery.ajax({
        url: url + "/superadmin/get-roles-permission-data",
        type: 'post',
         data: {id: id, _token: csrftoken},
        success: function(response) {
           if((response.length > 0)){
            for (var i = 0; i < response.length; i++) {
              var meta_key = response[i].meta_key;
              jQuery('.'+meta_key).prop('checked', true);
            }
            
           } 
        }
    });
});

jQuery("#submit_role_permission").click(function (event) {
    event.preventDefault();
    if(jQuery('#rolepermission').val() == ''){
      $('.invitemembersuccess').css("display", "block");
      $(".invitemembersuccess").html('<div class="alert alert-danger" id="errorMessage">Please select role for permission!</div>');
      setTimeout(function () {
          $(".invitemembersuccess").fadeOut("3000");
      }, 5000);
      return false;
    }

    var formData = jQuery("#role_permission").serialize();
    jQuery.ajax({
        url: url + "/superadmin/update-roles-permission-data",
        type: 'post',
        data: formData,
        success: function(response) {
            $('.invitemembersuccess').css("display", "block");
            $(".invitemembersuccess").html('<div class="alert alert-success" id="successMessage">Role permission Updated successfully!</div>');
            setTimeout(function () {
                $(".invitemembersuccess").fadeOut("3000");
            }, 5000);
        }
    });
 });