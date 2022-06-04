<!doctype html>
<html class="h-100" lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <title><?php echo $__env->yieldContent('title'); ?></title>
     <link href="<?php echo e(asset('public/assets/css/style.css')); ?>" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo e(asset('public/assets/images/favicon.ico')); ?>" />
    <!-- <link href="<?php echo e(asset('public/css/app.css')); ?>" rel="stylesheet"> -->
</head>
<body class="h-100">
    <input type="hidden" name="siteurl" id="siteurl" value="<?php echo e(URL::to('/')); ?>">
    <input type="hidden" name="csrftoken" id="csrftoken" value="<?php echo e(csrf_token()); ?>">
    <?php echo $__env->yieldContent('content'); ?>
    <script src="<?php echo e(asset('public/assets/vendor/global/global.min.js')); ?>"></script>
    <!-- <script src="<?php echo e(asset('public/assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')); ?> "></script> -->
    <!-- <script src="<?php echo e(asset('public/assets/js/custom.min.js')); ?> "></script> -->
    <script src="<?php echo e(asset('public/assets/js/deznav-init.js')); ?>"></script>
    <!-- <script src="<?php echo e(asset('public/assets/js/custom.js')); ?>"></script>   -->
   <!--  <script src="<?php echo e(asset('public/assets/js/custom/common.js')); ?>"></script> -->
   <script src="<?php echo e(asset('public/assets/js/custom/custom.js')); ?>"></script> 

<script type="text/javascript">
    var url = $("#siteurl").val();
    var csrftoken = $("#csrftoken").val();
    jQuery(document).on("click", ".add_teacher", function () {
        var $el = jQuery('.clonschool').html();
        var numItems = $('.selectschool').length;
        var result = '';
        result += '<div class="form-group notshow selectschool" id="divschool" data-id="'+numItems+'">';
            result += '<label>School <span class="requried">*</span></label>';
            result += '<select class="form-control selectschoolvalue notshow selectschoolvalue_'+numItems+'" id="selectschoolvalue" data-value ="'+numItems+'" name="school[]" required>';
            result +=$el;
            result += '</select>';
            result += '</div>';
        result += '<div class="form-group selectgrade notshow" id="divgrade" data-id="'+numItems+'">';
            result += '<label>Grade <span class="requried">*</span></label>';
            result += '<select class="form-control selectgradevalue notshow selectgradevalue_'+numItems+'" id="selectgradevalue" data-value ="'+numItems+'" name="grade[]" required>';
            result += '<option value="">Select Grade</option>';
            result += '</select>';
        result += '</div>';
        result +='<div class="form-group selectclass notshow" id="divclass" data-id="'+numItems+'">';
            result +='<label>Class <span class="requried">*</span></label>';
            result +='<select class="form-control selectclassvalue notshow selectclassvalue_'+numItems+'" id="selectclassvalue" data-value ="'+numItems+'" name="class[]" required>';
            result +='<option value="">Select Class</option>';
            result +='</select>';
        result +='</div>';
        // jQuery('#parent2').append($el);
        jQuery('#parent2').append(result);
    });

    jQuery(document).on("change", ".selectschoolvalue", function () {
        var x = $(this).attr('data-value');
        var id = jQuery(this).val();
        jQuery.ajax({
            url: url + "/grade",
            type: 'post',
             data: {id: id, _token: csrftoken},
            success: function(response) {
                
                jQuery('.selectgradevalue_'+x).html(response);
            }
        });
    });

    jQuery(document).on("change", ".selectgradevalue", function () {
        var x = $(this).attr('data-value');
        var id = jQuery(this).val();
        jQuery.ajax({
            url: url + "/getclass",
            type: 'post',
             data: {id: id, _token: csrftoken},
            success: function(response) {
                jQuery('.selectclassvalue_'+x).html(response);
            }
        });
    });
</script>  
</body>
</html>
<?php /**PATH /var/www/sites/enthucate/resources/views/layouts/app.blade.php ENDPATH**/ ?>