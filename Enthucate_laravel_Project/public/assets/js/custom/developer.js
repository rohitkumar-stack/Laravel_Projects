var url = $("#siteurl").val();
var csrftoken = $("#csrftoken").val();

jQuery( ".level_name_org" ).change(function() {
	var id = jQuery(this).val();
    var hierarchy_id = jQuery('#hierarchy_id').val();
    if(hierarchy_id == 1 || hierarchy_id == 2){
    	if(id == 4){
    		var ids = ["3",];
    		SubdivisionLocalSchool(ids);

    	}
    	else if(id == 5){
    		var ids = ["4",];
    		DivisionSchool(ids);
    	}
    	else{
    		jQuery("#Subdivisiontype").html('');
    		jQuery('.Subdivision_main_org').hide();
    	}
    }
    else if (hierarchy_id == 3) {
        if(id == 5){
            var ids = ["4",];
            DivisionSchool(ids);
        }
        else{
            jQuery("#Subdivisiontype").html('');
            jQuery('.Subdivision_main_org').hide();
        }
    }
});

function SubdivisionLocalSchool(id) {
	jQuery.ajax({
        url: url + "/org-subdivision",
        type: 'post',
         data: {id: id, _token: csrftoken},
        success: function(response) {
            var result = '';
                     result += '<option value="">Select Subdivision</option>';
                     result += response;
        	jQuery("#Subdivisiontype").html(result).selectpicker('refresh');
        	jQuery('.Subdivision_main_org').show();
            console.log(response)
        }
    }); 
}
function DivisionSchool(id) {
	jQuery.ajax({
        url: url + "/org-subdivision",
        type: 'post',
         data: {id: id, _token: csrftoken},
        success: function(response) {
            var result = '';
                     result += '<option value="">Select Local Sub-divisionn</option>';
                     result += response;
        	jQuery("#Subdivisiontype").html(result).selectpicker('refresh');
        	jQuery('.Subdivision_main_org').show();
            console.log(response)
        }
    }); 
}

jQuery( ".markorganisationdelete" ).click(function() {
	jQuery('#deleteorganisation').val(jQuery(this).attr("data-id"));
});